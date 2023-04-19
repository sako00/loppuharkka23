<?php
//5. Lisäys ja parametrit: add_artist_info.php
//a. Tiedosto lisää uuden artistin, sekä lisäksi artistille albumin ja albumin kappaleet.
//Kaikki tarvittavat tiedot saadaan joko POST- tai JSON-muodossa parametreina. Voit
//aloittaa luomalla vain artistin ja albumin.

require "dbconnection.php";
$dbcon = createDbConnection();

// Receive and decode the JSON data from the request body
$body = file_get_contents("php://input");
$data = json_decode($body);

// Retrieve the artist name, album title, and track names from the decoded JSON data
$artistName = strip_tags($data->artist);
$albumTitle = strip_tags($data->album);
$trackNames = $data->tracks;

// Insert the new artist into the artists table
$sql = "INSERT INTO artists (Name) VALUES (?)";
$statement = $dbcon->prepare($sql);
$statement->execute(array($artistName));

// Retrieve the artist ID from the database
$artistId = $dbcon->lastInsertId();

// Insert the new album into the albums table
$sql = "INSERT INTO albums (Title, ArtistId) VALUES (?,?)";
$statement = $dbcon->prepare($sql);
$statement->execute(array($albumTitle,$artistId));

// Retrieve the album ID from the database
$albumId = $dbcon->lastInsertId();

// Loop through the track names and insert each track into the tracks table
foreach ($trackNames as $trackName) {
    $sql = "INSERT INTO tracks (Name, AlbumId, MediaTypeId, Milliseconds, UnitPrice) VALUES (?,?,?,?,?)";
$statement = $dbcon->prepare($sql);
$statement->execute(array($trackName, $albumId, 1, $milliseconds, $unitPrice));

}

echo "New artist and album created successfully!";
?>

