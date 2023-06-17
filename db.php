<?php


require "data.php";

$dsn = "mysql:host=localhost;dbname=invoice_manager";
$username = "root";
$password = "Zx562397";

try {
    $db = new pDO($dsn, $username, $password);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo $error_message;
    exit();
}

function getAllInvoices()
{
    global $db;
    $query = "SELECT * from invoices inner join statuses on invoices.status_id = statuses.id";
    $result = $db->query($query);
    return $result->fetchAll();
}

function getInvoice($number)
{
    global $db;
    $query = "SELECT * from invoices WHERE number=:number";
    $result = $db->prepare($query);
    $result->execute([
        ":number" => $number,
    ]);
    return $result->fetch();
}

function addInvoice($invoice)
{
    global $db;
    global $statuses;
    $status_id = array_search($invoice["status"], $statuses);

    $query = "INSERT INTO invoices (number,client,email,amount,status_id)
            VALUES(:number,:client,:email,:amount,:status_id)";
    $result = $db->prepare($query);
    $result->execute([
        ":number" => $invoice["number"],
        ":client" => $invoice["client"],
        ":email" => $invoice["email"],
        ":amount" => $invoice["amount"],
        ":status_id" => $status_id
    ]);
}

function updateInvoice($invoice)
{
    global $statuses;
    global $db;

    $status_id = array_search($invoice["status"], $statuses);
    $id = getInvoice($invoice["number"])["id"];
    $query = "UPDATE invoices SET client = :client, email = :email, amount = :amount, status_id = :status_id WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->execute([
        ":id" => $id,
        ":client" => $invoice["client"],
        ":email" => $invoice["email"],
        ":amount" => $invoice["amount"],
        ":status_id" => $status_id
    ]);
}

function deleteInvoice($invoiceNumber)
{
    global $db;

    $query = "DELETE FROM invoices WHERE number= :number";
    $statement = $db->prepare($query);
    $statement->execute([":number" => $invoiceNumber]);
}

?>;