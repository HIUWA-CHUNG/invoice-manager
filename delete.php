<?php

require "db.php";

if (isset($_POST["number"])) {
    deleteInvoice($_POST["number"]);
}

header("Location: index.php");
