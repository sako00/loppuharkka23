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
    
$sql = "INSERT INTO albums (Title, ArtistId) VALUES (?, ?)";
$statement = $dbcon->prepare($sql);
$statement->execute([$albumTitle, $artistId]);

$albumId = $dbcon->lastInsertId();

