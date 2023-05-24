<?php include 'data.php'; ?>

<?php
$arrayStatus = 'all';        // Default filter = all

// isset: check if a variable is set and is not null.
if (isset($_GET['status'])) {
  $arrayStatus = $_GET['status'];           
}

//filters invoices based on the status provided in $arrayStatus
if ($arrayStatus === 'all') {
  $selectedInvoices = $invoices;
} 
else {
  $selectedInvoices = $applyFilterFunction($invoices);
}

include 'template.php';
?>