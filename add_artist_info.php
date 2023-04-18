<?php
//5. Lisäys ja parametrit: add_artist_info.php
//a. Tiedosto lisää uuden artistin, sekä lisäksi artistille albumin ja albumin kappaleet.
//Kaikki tarvittavat tiedot saadaan joko POST- tai JSON-muodossa parametreina. Voit
//aloittaa luomalla vain artistin ja albumin.
require "dbconnection.php";
$dbcon = createDbConnection();

$Name = strip_tags($_POST["artistname"]);
$Title = strip_tags($_POST["albumstitle"]);


// Insert the artist
$sql = "INSERT INTO artists (Name) VALUES (?)";
$statement = $dbcon->prepare($sql);
$statement->execute(array($Name));

// Get the artist ID
$ArtistId = $dbcon->lastInsertId();

// Insert the album with the artist ID as a foreign key
$sql = "INSERT INTO albums (ArtistId,Title) VALUES (?, ?)";
$statement = $dbcon->prepare($sql);
$statement->execute(array($ArtistId,$Title));





  