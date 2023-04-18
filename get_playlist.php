<?php

//Lisää koodiin muuttaja nimeltä playlist_id. Tiedosto hakee kyseisen soittolistan
//kappaleiden nimet ja kappaleiden säveltäjät ja tulostaa ne echolla. Kuvassa 1
//esimerkki. Voit helpottaa tehtävää tulostamalla aluksi yhden kappaleen tiedot.

// Haetaan kappaleiden nimet ja säveltäjät halutulle soittolistalle
require "dbconnection.php";
$dbcon = createDbConnection();

// Lisää koodiin muokkaaja nimeltä playlist_id
$playlist_id = 1; // korvaa halutulla soittolistan tunnuksella

// SQL-kysely hakeaksesi kappaleiden nimet ja säveltäjät määritetylle soittolistalle
$sql = "SELECT TrackId FROM playlist_track WHERE PlaylistId = $playlist_id";

$statement = $dbcon->prepare($sql);
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_COLUMN);

// Print the details of each song in the playlist
foreach($rows as $row){
    $track_id = $row;

    $sql = "SELECT * FROM tracks WHERE TrackId = $track_id";

$statement = $dbcon->prepare($sql);
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($rows as $row){
    echo '<h2>'.$row["Name"].'<br>'.'</h2>'.'('.$row["Composer"].')'.'<br>';
}
    
}




