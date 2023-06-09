<?php

session_start();

$submissions = $_SESSION['invoices'];

if (isset($_POST["number"])) {
    $index = array_key_first(array_filter($submissions, function ($invoice) {
        return $invoice["number"] == $_POST["number"];
    }));

    unset($submissions[$index]);

    $_SESSION['invoices'] = $submissions;
}

header("Location: index.php");
