<?php

require "data.php";

function getInvoiceNumber($length = 5)
{
    $letters = range('A', 'Z');
    $number = [];

    for ($i = 0; $i < $length; $i++) {
        array_push($number, $letters[rand(0, count($letters) - 1)]);
    }
    return implode($number);
}

function sanitize($data)
{
    return array_map(function ($value) {
        return htmlspecialchars(stripslashes(trim($value)));
    }, $data);
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data = sanitize($_POST);

    extract($data);

    $errors = [];

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

    if (!$errors) {
        session_start();

        $submission = array(
            'number' => getInvoiceNumber(),
            'amount' => $_POST['amount'],
            'status' => $_POST['status'],
            'client' => $_POST['client'],
            'email' => $_POST['email'],
        );

        $submissions = $_SESSION['invoices'];

        array_push($submissions, $submission);

        $_SESSION['invoices'] = $submissions;
        header("Location: index.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Lab 4 - Add Invoice</title>
</head>

<body>
    <div class="container">
        <h1 class="pt-5">Invoice Manager</h1>
        <div class="d-flex justify-content-between">
            <p>Create a new invoice</p>
            <a href="index.php">Back</a>
        </div>
        <div class="card bg-light py-4">
            <form method="post" action="add.php" class="px-5">
                <div class="pb-3">
                    <label class="form-label" for="name">Client Name</label>
                    <input class="form-control <?php if (isset($errors['client'])) :  ?> is-invalid <?php endif; ?>" type="text" id="name" name="client" placeholder="Client Name" value="<?php echo $client ?? "" ?>">
                    <div class="invalid-feedback">
                        <?php if (isset($errors['client'])) : ?>
                            <?php echo $errors["client"]; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="pb-3">
                    <label class="form-label" for="email">Client Email</label>
                    <input class="form-control <?php if (isset($errors['email'])) :  ?> is-invalid <?php endif; ?>" type=" text" id="email" name="email" placeholder="Client Email" value="<?php echo $email ?? "" ?>">
                    <div class="invalid-feedback">
                        <?php if (isset($errors['email'])) : ?>
                            <?php echo $errors["email"]; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="pb-3">
                    <label class="form-label" for="amount">Invoice Amount</label>
                    <input class="form-control <?php if (isset($errors['amount'])) :  ?> is-invalid <?php endif; ?>" type=" text" id="amount" name="amount" placeholder="Invoice Amount" value="<?php echo $amount ?? "" ?>">
                    <div class="invalid-feedback">
                        <?php if (isset($errors['amount'])) : ?>
                            <?php echo $errors["amount"]; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="pb-3">
                    <label class="form-label" for="status">Invoice Status</label>
                    <select class="form-select <?php if (isset($errors['status'])) :  ?> is-invalid <?php endif; ?>" id="status" name="status">
                        <option value="" <?php (isset($status) && $status == "") ? "selected" : "" ?>>Select a Status</option>
                        <option value=" paid" <?php (isset($status) && $status == "paid") ? "selected" : "" ?>>Paid</option>
                        <option value="draft" <?php (isset($status) && $status == "draft") ? "selected" : "" ?>>Draft</option>
                        <option value="pending" <?php (isset($status) && $status == "pending") ? "selected" : "" ?>>Pending</option>
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