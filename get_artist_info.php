<?php
//4. Monipuolinen haku: get_artist_info.php
//a. Lisää koodiin muuttaja nimeltä artist_id. Tiedosto hakee ja palauttaa JSONmuodossa artistin nimen ja sekä 
//artistin albumit ja albumien kappaleet. Esimerkki
//vastauksessa kuvassa 2


require "dbconnection.php";
$dbcon = createDbConnection();

$artist_id = 2;

// SQL-kysely artistin tiedoille
$sql = "SELECT Name FROM artists WHERE ArtistId = $artist_id";
$statement = $dbcon->prepare($sql);
$statement->execute();
$artist_name = $statement->fetchColumn();

// SQL-kysely albumit ja kappaleet
$sql = "SELECT albums.Title as AlbumTitle, tracks.Name as TrackName
        FROM albums
        JOIN tracks ON albums.AlbumId = tracks.AlbumId
        WHERE albums.ArtistId = $artist_id";
$statement = $dbcon->prepare($sql);
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

// Muodosta tulos array
$result = array("artist" => $artist_name, "albums" => array());

foreach($rows as $row){
    $album = $row["AlbumTitle"];
    $track = $row["TrackName"];

    if(!isset($result["albums"][$album])){
        $result["albums"][$album] = array();
    }

    array_push($result["albums"][$album], $track);
}

// Tulosta tulos JSON-muodossa
header("Content-Type: application/json");
echo json_encode($result);
