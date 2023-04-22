<?php
//5. Lisäys ja parametrit: add_artist_info.php
//a. Tiedosto lisää uuden artistin, sekä lisäksi artistille albumin ja albumin kappaleet.
//Kaikki tarvittavat tiedot saadaan joko POST- tai JSON-muodossa parametreina. Voit
//aloittaa luomalla vain artistin ja albumin.

//Retrieve the artist name, album title, and track names from the decoded JSON data
require "dbconnection.php";
$dbcon = createDbConnection();

$body = file_get_contents("php://input");
$data = json_decode($body);


//$sql = "INSERT INTO artists (Name) VALUES (?)";
//$statement = $dbcon->prepare($sql);
//foreach($data as $a){
//$statement->execute(array($a->name));
    


$sql = "SELECT ArtistId FROM artists WHERE Name = ?";
$statement = $dbcon->prepare($sql);
$statement->execute(array("Popeda"));
$result = $statement->fetch();
$artistId = $result["ArtistId"];

// Insert a new album for "Popeda"
$sql = "INSERT INTO albums (Title, ArtistId) VALUES (?, ?)";
$statement = $dbcon->prepare($sql);
$statement->execute(array($data->albumTitle, $artistId));
$albumId = $dbcon->lastInsertId();


$mediaTypeId = 1;
$genreId = 2;
$composer = "John Doe";
$milliseconds = 1000;
$bytes = 500000;
$unitPrice = 0.99;

$sql = "INSERT INTO tracks (Name, AlbumId, MediaTypeId, GenreId, Composer, Milliseconds, Bytes, UnitPrice) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$statement = $dbcon->prepare($sql);
$statement->execute(array("Track name", $albumId, $mediaTypeId, $genreId, $composer, $milliseconds, $bytes, $unitPrice));






