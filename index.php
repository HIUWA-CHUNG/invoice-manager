<!-- http://localhost/cst8257/Lab3/index.php -->

<?php

require 'data.php';

//gen random number
function getInvoiceNumber($length = 5)
{
  $letters = range('A', 'Z');
  $number = [];

  for ($i = 0; $i < $length; $i++) {
    array_push($number, $letters[rand(0, count($letters) - 1)]);
  }
  return implode($number);
}

function filterArray($array)
{
  global $arrayStatus;
  if ($arrayStatus == 'all') {
    return true;
  } elseif ($array['status'] == $arrayStatus) {       // comparing if status matched
    return true;
  }
}

$arrayStatus = $_GET['status'] ?? 'all';        // if doesn't exist, will returns to all

// session start and store new data
session_start();

if (isset($_POST['client'])) {
  // add new invoice to the invoices array:
  $newdata = array(
    'number' => getInvoiceNumber(),
    'amount' => $_POST['amount'],
    'status' => $_POST['status'],
    'client' => $_POST['client'],
    'email' => $_POST['email']
  );

  $session_invoices = $_SESSION['invoices'];

  array_push($session_invoices, $newdata);
  // call session, will update session when updated invoices
  $_SESSION['invoices'] = $session_invoices;
}

if (isset($_SESSION['invoices'])) {
  $sessionDataArr = $_SESSION['invoices'];
} else {
  $sessionDataArr = $invoices;
}

//filters invoices based on the status provided in $arrayStatus
$selectedInvoices = array_filter($sessionDataArr, 'filterArray');

$_SESSION['invoices'] = $sessionDataArr;

?>

<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab3-Part 2</title>
</head>

<body>
  <div class="container">
    <h1>Invoice Manager</h1>

    <div class="d-flex justify-content-between">
      <p>There are <?php echo count($selectedInvoices); ?> invoices.</p>
      <a href="add.php">Add ></a>
    </div>

    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" href="index.php?status=all">All</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?status=draft">Draft</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?status=pending">Pending</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?status=paid">Paid</a>
      </li>
    </ul>
    <!-- foreach 用黎將array入面唔同既DATA LOOP落去 -->
    <?php foreach ($selectedInvoices as $invoice) : ?>
      <div class="card flex-row d-flex justify-content-center align-items-center">
        <label class="col-3 text-center fw-bold py-2 ">
          <?php echo $invoice['number']; ?>
        </label>

        <a href="mailto:<?php echo $invoice['email'] ?>" class="col-3 text-center py-2">
          <?php echo $invoice['client'] ?>
        </a>

        <label class="col-3 text-center py-2">
          <?php echo $invoice['amount']; ?>
        </label>

        <?php
        if ($invoice["status"] == "paid") {               //for style the status independently
          echo "<div class=\"col-3 btn btn-success\">";
        } elseif ($invoice["status"] == "pending") {
          echo "<div class=\"col-3 btn btn-warning\">";
        } elseif ($invoice["status"] == "draft") {
          echo "<div class=\"col-3 btn btn-secondary\">";
        }
        ?>
        <?php echo $invoice["status"] ?>
      </div>

  </div>
<?php endforeach; ?>


</body>

</html>