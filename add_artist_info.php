<?php
//5. Lisäys ja parametrit: add_artist_info.php
//a. Tiedosto lisää uuden artistin, sekä lisäksi artistille albumin ja albumin kappaleet.
//Kaikki tarvittavat tiedot saadaan joko POST- tai JSON-muodossa parametreina. Voit
//aloittaa luomalla vain artistin ja albumin.
require "dbconnection.php";
$dbcon = createDbConnection();

// Get the JSON data
$body = file_get_contents("php://input");
$data = json_decode($body);

// Get the artist information
$artistName = $data->artist_name;
$artistSql = "INSERT INTO artists (Name) VALUES (?)";
$artistStmt = $dbcon->prepare($artistSql);
$artistStmt->execute([$artistName]);

// Get the album information
$albumTitle = $data->album_title;
$albumArtistId = $dbcon->lastInsertId(); // The ID of the artist we just inserted
$albumSql = "INSERT INTO albums (Title, ArtistId) VALUES (?, ?)";
$albumStmt = $dbcon->prepare($albumSql);
$albumStmt->execute([$albumTitle, $albumArtistId]);
$albumId = $dbcon->lastInsertId(); // The ID of the album we just inserted

// Get the tracks information
$tracks = $data->tracks;
$trackSql = "INSERT INTO tracks (Name, AlbumId, MediaTypeId, GenreId, Composer,Milliseconds,Bytes,UnitPrice) VALUES (?, ?, ?, ?, ?, ? , ? , ?)";
$trackStmt = $dbcon->prepare($trackSql);
foreach ($tracks as $track) {
    $trackStmt->execute([$track->name, $albumId, 
    $track->media_type_id, $track->genre_id, $track->composer, $track->Milliseconds, $track->Bytes, $track->Unitprice]);
}
