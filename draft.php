<?php include 'data.php'; ?>

<?php
// Filter function = draft status
function arrayDraft($invoices) {
  return array_filter($invoices, function($invoice) {
    return $invoice['status'] === 'draft';
  });
}

$selectedInvoices = arrayDraft($invoices);

include 'template.php';
?>