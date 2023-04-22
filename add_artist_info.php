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
    

//Create a new album for the artist in the albums table
$stmt = $dbcon->prepare("INSERT INTO albums (Title, ArtistId) VALUES (?, ?)");
$stmt->execute(array($data->title, $data->artist_id));
$album_id = $dbcon->lastInsertId();

//Create a new track for the album in the tracks table
$stmt = $dbcon->prepare("INSERT INTO tracks (Name, AlbumId, MediaTypeId, GenreId, Composer, Milliseconds, Bytes, UnitPrice) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute(array($data->track_name, $album_id, $data->media_type_id, $data->genre_id, $data->composer, $data->milliseconds, $data->bytes, $data->unit_price));
$track_id = $dbcon->lastInsertId();

//Return a JSON response with information about the new album and track
$response = array('album_id' => $album_id, 'track_id' => $track_id, 'album_title' => $data->title, 'track_name' => $data->track_name);
echo json_encode($response);