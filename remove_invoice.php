


<?php

//Lisää koodiin muuttuja nimeltä invoice_id. Poista tietokannasta invoice_item tällä
//id:llä.
require "dbconnection.php";
$dbcon = createDbConnection();

// invoice_id muuttuja
$invoice_id = 1; // Korvaa tämä tiedon oikealla ID:llä

// SQL DELETE-lauseke
$sql = "DELETE FROM invoice_items WHERE InvoiceId = $invoice_id";

$statement = $dbcon->prepare($sql);
$statement->execute();



  

