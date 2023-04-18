<?php
//3. Transaktio: remove_artist.php
//a. Tiedostossa on parametreina artist_id. Poista kyseinen artisti ja kaikki siihen liittyvät
//tiedot kannasta transaktiona. Huom! Tutki kannan rakennetta ja poista
//riippuvuudet oikeassa järjestyksessä.(artists/albums/tracks/invoice_items). 

require "dbconnection.php";
$dbcon = createDbConnection();

$artist_id = 1;
    try {
        $dbcon->beginTransaction();

        // Delete related invoice items
    $statement = $dbcon->prepare("DELETE FROM invoice_items WHERE TrackId IN 
    (SELECT TrackId FROM tracks WHERE AlbumId IN (SELECT AlbumId FROM albums WHERE ArtistId = $artist_id))");
    $statement->execute();

    // Delete related invoices
    $statement = $dbcon->prepare("DELETE FROM invoices WHERE InvoiceId IN 
    (SELECT InvoiceId FROM invoice_items WHERE TrackId IN (SELECT TrackId FROM tracks WHERE AlbumId IN 
    (SELECT AlbumId FROM albums WHERE ArtistId = $artist_id)))");
    $statement->execute();

    // Delete related playlist tracks
    $statement = $dbcon->prepare("DELETE FROM playlist_track WHERE TrackId IN 
    (SELECT TrackId FROM tracks WHERE AlbumId IN (SELECT AlbumId FROM albums WHERE ArtistId = $artist_id))");
    $statement->execute();

    // Delete related tracks
    $statement = $dbcon->prepare("DELETE FROM tracks WHERE AlbumId IN 
    (SELECT AlbumId FROM albums WHERE ArtistId = $artist_id)");
    $statement->execute();

    // Delete related albums
    $statement = $dbcon->prepare("DELETE FROM albums WHERE ArtistId = $artist_id");
    $statement->execute();

    // Delete the artist
    $statement = $dbcon->prepare("DELETE FROM artists WHERE ArtistId = $artist_id");
    $statement->execute();

        

        $dbcon->commit();
        
        echo "Artist and related data deleted successfully!";
    } catch(Exception $e) {
        $dbcon->rollBack();
        echo $e->getMessage();
    }