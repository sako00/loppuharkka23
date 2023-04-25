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

//Laitoin ensin artistin nimen

//$sql = "INSERT INTO artists (Name) VALUES (?)";
//$statement = $dbcon->prepare($sql);
//foreach($data as $a){
//$statement->execute(array($a->name));

// Lisätään albumi

$stmt = $dbcon->prepare("INSERT INTO albums (Title, ArtistId) VALUES (?, ?)");
$stmt->execute(array($data->title, $data->artist_id));
$album_id = $dbcon->lastInsertId();

// Lisätään kappaleet
foreach ($data->trackNames as $trackName) {
  $statement = $dbcon->prepare("INSERT INTO tracks (Name, AlbumId, MediaTypeId, Milliseconds, UnitPrice) VALUES (?, ?, ?, ?, ?)");
  $statement->execute(array($trackName, $album_id, $data->mediatypeId, $data->milliseconds, $data->unitprice));
  $track_id = $dbcon->lastInsertId();
}
//Postmanilla lähetetty tieto
//{
    
  //"title": "Harasoo",
  //"artist_id":1,
  //"trackNames": [
    //  "Pullaristo ihmemaassa",
      //"Whiskey",
      //"Olen valmis",
      //"Matkalla alabamaan"
  //],
  //"mediatypeId":1,
  //"milliseconds":123456,
  //"unitprice":0.99
//}
