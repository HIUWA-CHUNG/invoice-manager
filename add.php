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
            <p>Create a new invoices.</p>
            <a href="index.php">
                < Back</a>
        </div>

        <form class="form bg-light text-dark" method="post" action="index.php">
            <div class="mb-3">
                <label>Client Name</label>
                <input type="text" class="form-control" name="client" placeholder="Client Name" required>
            </div>
            <div class="mb-3">
                <label>Client Email</label>
                <input type="text" class="form-control" name="email" placeholder="Client Email" required>
            </div>
            <div class="mb-3">
                <label>Invoice Amount</label>
                <input type="number" class="form-control" name="amount" placeholder="Invoice Amount" required>
            </div>
            <div class="mb-3">
                <label>Invoice Status</label>
                <select class="form-select" name="status">
                    <option value="" >Select a Status</option>
                    <option value="draft">draft</option>
                    <option value="pending">pending</option>
                    <option value="paid">paid</option>
                </select>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>
</body>