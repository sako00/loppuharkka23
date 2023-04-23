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
    

// Check if all required data is present
if (!isset($data->title) || !isset($data->artist_id) || !isset($data->trackNames) || !isset($data->mediatypeId) || !isset($data->milliseconds) || !isset($data->unitprice)) {
        // Return an error message if any required data is missing
        http_response_code(400);
        echo json_encode(array("error" => "Missing required data"));
        exit();
    }
    
    // Insert the album into the database
    $stmt = $dbcon->prepare("INSERT INTO albums (Title, ArtistId) VALUES (?, ?)");
    $stmt->execute(array($data->title, $data->artist_id));
    $album_id = $dbcon->lastInsertId();
    
    // Insert each track into the database
    foreach ($data->trackNames as $trackName) {
        $statement = $dbcon->prepare("INSERT INTO tracks (Name, AlbumId, MediaTypeId, Milliseconds, UnitPrice) VALUES (?, ?, ?, ?, ?)");
        $statement->execute(array($trackName, $album_id, $data->mediatypeId, $data->milliseconds, $data->unitprice));
        $track_id = $dbcon->lastInsertId();
    }
    
    //{
      //  "artistName": "Popeda",
        //"artist_id":1,
        //"title": "Kaasua, komisario Palmu!",
        //"trackNames": [
          //  "Hullun paperit",
            //"Hän",
            //"Odotusaika",
            //"Kersantti Karoliina",
            //"Vielä virtaa",
            //"Vauhtiajot",
            //"Sukset",
            //"Korkeajännitystä",
            //"Oi Mari",
            //"Matkalla Alabamaan"
        //],
        //"mediatypeId":1,
        //"milliseconds":123456,
        //"unitprice":0.99
    //}
    