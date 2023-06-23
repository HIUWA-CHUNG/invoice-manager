<?php
require "data.php";
require "db_functions.php";


function filter($arr)
{
    global $status;
    if ($status == "all") {
        return true;
    } elseif ($arr["status"] == $status) {
        return true;
    }
}

$status = $_GET['status'] ?? "all";

$allItems = getAllInvoices();

$items = array_filter($allItems, "filter");

$invoice_count = count($items);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 2 - <?php echo ucfirst($status) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
    <div class="container">
        <h1 class="pt-5">Invoices</h1>
        <div class="d-flex justify-content-between">
            <p>There are <?php echo $invoice_count ?> invoices</p>
            <a href="add.php">Add</a>
        </div>
        <div class="pb-2">
            <ul class="nav nav-tabs">
                <?php
                foreach ($statuses as $value) {
                    $url = "index.php?status=";
                    if ($value == "all") {
                        $url = $url . "all";
                    } else {
                        $url = $url . "$value";
                    }

                    $isActive = "";
                    if ($status == $value) {
                        $isActive = "active";
                    }
                    echo "<li class=\"nav-item\">
                            <a class=\"nav-link  $isActive\" href=\"$url\" \">";
                    echo ucfirst($value);
                    echo "</a></li>";
                }

                ?>
            </ul>
        </div>
        <div>
            <div class="card flex-row d-flex justify-content-center align-items-center">
                <label class="col-2 text-center fw-bold py-2">Number</label>
                <label class="col-2 text-center fw-bold py-2">Client</label>
                <label class="col-2 text-center fw-bold py-2">Amount</label>
                <label class="col-2 text-center fw-bold py-2">Status</label>
                <label class="col-2 text-center fw-bold py-2">Actions</label>
            </div>
            <?php foreach ($items as $item) : ?>
                <div class="card flex-row justify-content-center my-2">
                    <div class="col-2 flex-row justify-content-center text-center py-2">
                        <label class="fw-bold">#<?php echo $item["number"] ?></label>
                    </div>
                    <div class="col-2 text-center font-weight-bold py-2">
                        <a href="mailto:<?php echo $item["email"] ?>" class="text-decoration-none">
                            <?php echo $item["client"] ?>
                        </a>
                    </div>
                    <div div class="col-2 text-center py-2">
                        $ <?php
                            echo $item["amount"];
                            ?>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <?php
                        if ($item["status"] == "paid") {
                            echo "<div class=\"col-6 btn btn-success\">";
                            echo $item['status'];
                            echo "</div>";
                        } elseif ($item["status"] == "pending") {
                            echo "<div class=\"col-6 btn btn-warning\">";
                            echo $item['status'];
                            echo "</div>";
                        } elseif ($item["status"] == "draft") {
                            echo "<div class=\"col-6 btn btn-secondary\">";
                            echo $item['status'];
                            echo "</div>";
                        }
                        ?>
                    </div>
                    <div class="col-2 d-flex justify-content-end align-items-center">
                        <?PHP if (file_exists("documents/" . $item["number"] . ".pdf")) : ?>
                            <div class="px-1">
                                <a class="btn btn-outline-primary btn-sm" target="_blank" href="<?php echo "documents/" . $item["number"] . ".pdf" ?>">
                                    View
                                </a>
                            </div>
                        <? else : ?>
                            <div class="
                            </div>
                        <?php endif ?>
                        <div class=" px-1">
                                <a class="btn btn-outline-primary btn-sm" href="update.php?number=<?php echo $item["number"] ?>">
                                    Edit
                                </a>
                            </div>
                            <div class="px-1">
                                <form class="mb-0" action="delete.php" method="post">
                                    <input type="hidden" name="number" placeholder="Client Number" value="<?php echo $item["number"] ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        Clear
                                    </button>
                                </form>
                            </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>