<?php require 'data.php'; ?>

<!-- http://localhost/cst8257/part-1/php_Lab2/index.php -->
<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab2-Part 1</title>
</head>

<body>
  <div class="container">
    <h1>Invoice Manager</h1>
    <p>There are <?php echo count($selectedInvoices); ?> invoices.</p>

    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" href="index.php">All</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="draft.php">Draft</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pending.php">Pending</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="paid.php">Paid</a>
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