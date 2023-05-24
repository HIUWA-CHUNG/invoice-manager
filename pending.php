<?php include 'data.php'; ?>

<?php
// Filter function = pending status
function arrayDraft($invoices) {
  return array_filter($invoices, function($invoice) {
    return $invoice['status'] === 'pending';
  });
}

$selectedInvoices = arrayDraft($invoices);

include 'template.php';
?>