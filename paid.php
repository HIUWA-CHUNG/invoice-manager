<?php include 'data.php'; ?>

<?php
// Filter function = paid status
function arrayDraft($invoices) {
  return array_filter($invoices, function($invoice) {
    return $invoice['status'] === 'paid';
  });
}

$selectedInvoices = arrayDraft($invoices);

include 'template.php';
?>