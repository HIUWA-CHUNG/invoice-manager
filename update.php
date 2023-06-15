<?php
require "data.php";

function sanitize($data)       // remove unwanted and malicious characters from  
{ 
    return array_map(function ($value) {
        return htmlspecialchars(stripslashes(trim($value)));        // remove the space from ends and backslashes, converts special characters to HTML
    }, $data);
}

session_start();

$submissions = $_SESSION['invoices'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $data = sanitize($_POST);

    extract($data);

    $errors = [];
// validation for updating
    if (empty($client)) {
        $errors["client"] = "Name is required";
    } else if (!preg_match('/^[A-Za-z\s]{0,255}$/', $client)) {
        $errors["client"] = "Name is not valid";
    }

    if (empty($email)) {
        $errors["email"] = "Email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Email is not valid";
    }

    if (empty($amount)) {
        $errors["amount"] = "Amount is required";
    } else if (!filter_var($amount, FILTER_VALIDATE_INT)) {
        $errors["amount"] = "Amount is not valid";
    }

    if ($status == "") {
        $errors["status"] = "Status is required";
    } else if (!in_array($status, $statuses)) {
        $errors["status"] = "Status is not valid";
    }
// if the validation is good
    if (!$errors) {
        $updated_invoice = [
            'number' => $_GET["client"],
            'amount' => $_POST["amount"],
            'client' => $_POST["client"],
            'status' => $_POST["status"],
            'email' => $_POST["email"],
        ];

        $submissions = array_map(function ($invoice) use ($updated_invoice) {
            if ($invoice["number"] == $updated_invoice["number"]) {
                return $updated_invoice;
            }
            return $invoice;
        }, $submissions);

        $_SESSION['invoices'] = $submissions;

        header('Location: index.php');
    }
}

if (isset($_GET["client"])) {
    $invoice_to_edit = current(array_filter($submissions, function ($submission) {
        return $submission["number"] == $_GET["client"];
    }));

    if (!$invoice_to_edit) {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Lab 4 - Edit Invoice</title>
</head>

<body>
    <div class="container">
        <h1 class="pt-5">Invoice Manager</h1>
        <div class="d-flex justify-content-between">
            <p>Edit invoice</p>
            <a href="index.php">Back</a>
        </div>
        <div class="card bg-light py-4">
            <form method="post" class="px-5">
                <div class="pb-3">
                    <label class="form-label" for="client-number">Client Number</label>
                    <input class="form-control " type="text" id="client-number" name="client-number" placeholder="Client Number" value="<?php echo $invoice_to_edit["number"] ?>" disabled>

                </div>
                <div class="pb-3">
                    <label class="form-label" for="client-name">Client Name</label>
                    <input class="form-control <?php if (isset($errors['client'])) :  ?> is-invalid <?php endif; ?>" type="text" id="client-name" name="client" placeholder="Client Name" value="<?php echo $invoice_to_edit["client"] ?>">
                    <div class="invalid-feedback">
                        <?php if (isset($errors['client'])) : ?>
                            <?php echo $errors["client"]; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="pb-3">
                    <label class="form-label" for="client-email">Client Email</label>
                    <input class="form-control <?php if (isset($errors['email'])) :  ?> is-invalid <?php endif; ?>" type="text" id="client-email" name="email" placeholder="Client Email" value="<?php echo $invoice_to_edit["email"] ?>">
                    <div class="invalid-feedback">
                        <?php if (isset($errors['email'])) : ?>
                            <?php echo $errors["email"]; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="pb-3">
                    <label class="form-label" for="invoice-amount">Invoice Amount</label>
                    <input class="form-control <?php if (isset($errors['amount'])) :  ?> is-invalid <?php endif; ?>" type="text" id="invoice-amount" name="amount" placeholder="Invoice Amount" value="<?php echo $invoice_to_edit["amount"] ?>">
                    <div class="invalid-feedback">
                        <?php if (isset($errors['amount'])) : ?>
                            <?php echo $errors["amount"]; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="pb-3">
                    <label class="form-label" for="invoice-status">Invoice Status</label>
                    <select class="form-select  <?php if (isset($errors['status'])) :  ?> is-invalid <?php endif; ?>" id="invoice-status" name="status">
                        <option value="paid" <?php if ($invoice_to_edit["status"] == "paid") echo "selected" ?>>Paid</option>
                        <option value="draft" <?php if ($invoice_to_edit["status"] == "draft")  echo "selected" ?>>Draft</option>
                        <option value="pending" <?php if ($invoice_to_edit["status"] == "pending") echo "selected" ?>>Pending</option>
                    </select>
                    <div class="invalid-feedback">
                        <?php if (isset($errors['status'])) : ?>
                            <?php echo $errors['status']; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="pb-3">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>