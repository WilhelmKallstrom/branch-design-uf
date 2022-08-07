<?php

require_once('db.php');
require_once('helpers.php');


if (isset($_POST['login'])) {

    if ($_POST['pass'] == "kryptoframtid123.") {
        //User is authenticated
        $_SESSION['authenticated'] = [0];
    }
}

if (isset($_POST['logout'])) {

    $_SESSION['authenticated'] = null;
}

if (isset($_SESSION['authenticated'])) {
    $isUserAuthenticated = true;
} else {
    $isUserAuthenticated = false;
}
//dd($_POST);
if ($isUserAuthenticated) {

    if (isset($_POST['uppdatera'])) {

        //Uppdatera order som är vald

        $orderID = $_POST['id'];

        $sql = "UPDATE branchDesignOrders SET firstName = ?, sureName = ?, email = ?, phoneNumber = ?, `address` = ?, district = ?, zipCode = ?, `status` = ?, shippingType = ? WHERE id = ?";
        $statement = $connection->prepare($sql);
        echo $connection->error;

        $typeTest = "test";

        $statement->bind_param("sssssssssi", $_POST['förnamn'], $_POST['efternamn'], $_POST['epost'], $_POST['tel'], $_POST['adress'], $_POST['ort'], $_POST['postnummer'], $_POST['status'], $_POST['shippingType'], $orderID);
        // var_dump($_POST);
        $statement->execute();
        //  dd($statement->error);
    }

    $orders = $connection->query('select * from branchDesignOrders ORDER BY id DESC');
    $amountOfOrders = mysqli_num_rows($orders);

    if (!$orders) {
        printf("Errormessage: %s\n", $connection->error);
        die();
    }

    $revenue = 0;
    $paidOrders = 0;
    $delivered = 0;

    foreach ($orders as $key => $order) {

        if ($order['status'] == "Betald" || $order['status'] == "Skickad") {
            $revenue += $order['total'];
            $paidOrders++;
        }

        if($order['status'] == "Skickad"){
            $delivered++;
        }
    }
}

?>

<!doctype html>
<html lang="sv">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Adminpanel - Branch Design UF</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>

    <?php if ($isUserAuthenticated) : ?>
        <!-- IF USER IS LOGGED IN -->

        <!-- NAVBAR -->
        <nav class="navbar navbar-light border-bottom mb-3">
            <div class="container">
                <a class="navbar-brand fw-bold">Adminpanel</a>
                <form method="POST" class="d-flex">
                    <button type="submit" class="btn btn-outline-danger fw-bold" name="logout">Logga ut</button>
                </form>
            </div>
        </nav>

        <div class="container">

        <p class="display-6">Översikt</p>

            <div class="row mb-5">
                <div class="col-lg-4 mb-3">
                    <div class="container border rounded-3 p-3">
                        <p class="mb-0"><span class="fw-bold">Inkomster:</span> <?php echo $revenue; ?> Kr</p>
                        <p class="mb-0 text-black-50">Alla inkomster från betalade och skickade produkter.</p>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="container border rounded-3 p-3">
                        <p class="mb-0"><span class="fw-bold">Betalda beställningar:</span> <?php echo $paidOrders ?>/<?php echo $amountOfOrders ?></p>
                        <p class="mb-0 text-black-50">Betalda beställningar förhållande till alla beställningar.</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="container border rounded-3 p-3">
                        <p class="mb-0"><span class="fw-bold">Skickade beställningar:</span> <?php echo $delivered ?>/<?php echo $paidOrders ?></p>
                        <p class="mb-0 text-black-50">Skickade beställningar förhållande till betalda beställningar.</p>
                    </div>
                </div>

            </div>

            <p class="display-6">Beställningar</p>

                <p class="text-black-50 fw-bold"><?php echo $amountOfOrders ?> beställningar hittades</p>

                <div class="row align-items-start text-black-50 fw-bold mb-3">
                    <div class="col">Beställnings-ID</div>
                    <div class="col">Kund</div>
                    <div class="col">Detaljer</div>
                    <div class="col">Status</div>
                    <div class="col">Summa</div>
                </div>

                <?php if ($amountOfOrders == 0) : ?>
                    <div class="text-center mt-5">
                        <h1>Inga beställningar hittades</h1>
                    </div>
                <?php endif; ?>

                <?php foreach ($orders as $key => $order) : ?>

                    <div class="row align-items-start border-bottom pt-3 pb-3" style="background-color: #fff;">
                        <div class="col"><?php echo  $order['id']; ?></div>
                        <div class="col"><?php echo  $order['firstName']; ?></div>
                        <div class="col">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#orderModal-<?php echo  $order['id']; ?>">
                                Öppna
                            </button>
                        </div>
                        <div class="col">

                            <?php if ($order['status'] == "Pågående") : ?> <span class="badge rounded-pill bg-danger">Pågående</span> <?php endif; ?>

                            <?php if ($order['status'] == "Betald") : ?> <span class="badge rounded-pill bg-warning">Betald</span> <?php endif; ?>

                            <?php if ($order['status'] == "Skickad") : ?> <span class="badge rounded-pill bg-success">Skickad</span> <?php endif; ?>

                        </div>
                        <div class="col"><?php echo  $order['total']; ?> KR</div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="orderModal-<?php echo  $order['id']; ?>">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Beställnings-ID: <?php echo  $order['id']; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="admin.php" method="POST">

                                        <p class="display-6">Orderinformation</p>

                                        <div class="mb-3">

                                            <label for="status" class="form-label">Orderstatus</label>
                                            <select class="form-select" name="status">
                                                <option <?php if ($order['status'] == "Pågående") : ?> selected <?php endif; ?> value="Pågående">Pågående
                                                </option>

                                                <option <?php if ($order['status'] == "Betald") : ?> selected <?php endif; ?> value="Betald">Betald
                                                </option>

                                                <option <?php if ($order['status'] == "Skickad") : ?> selected <?php endif; ?> value="Skickad">Skickad
                                                </option>

                                            </select>

                                        </div>

                                        <div class="mb-3">

                                            <label for="SummaField" class="form-label">Orderdatum</label>
                                            <input type="text" class="form-control" name="SummaField" value="<?php echo  $order['date']; ?>" disabled>

                                        </div>

                                        <div class="mb-3">

                                            <label for="SummaField" class="form-label">Produkter</label>
                                            <input type="text" class="form-control" name="SummaField" value="<?php echo  $order['products']; ?>" disabled>

                                        </div>


                                        <div class="mb-3">

                                            <label for="SummaField" class="form-label">Ordersumma</label>
                                            <input type="text" class="form-control" name="SummaField" value="<?php echo  $order['total']; ?>" disabled>

                                        </div>

                                        <div class="mb-3">

                                            <label for="ip" class="form-label">IP-adress</label>
                                            <input type="text" class="form-control" name="ip" value="<?php echo  $order['ip']; ?>" disabled>

                                        </div>

                                        <input type="hidden" name="id" value="<?php echo  $order['id']; ?>" id="<?php echo  $order['id']; ?>">

                                        <p class="display-6">Kundinformation</p>

                                        <div class="mb-3">
                                            <label for="förnamn" class="form-label">Förnamn</label>
                                            <input type="text" class="form-control" name="förnamn" value="<?php echo  $order['firstName']; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="efternamn" class="form-label">Efternamn</label>
                                            <input type="text" class="form-control" name="efternamn" value="<?php echo  $order['sureName']; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="epost" class="form-label">E-postadress</label>
                                            <input type="email" class="form-control" name="epost" value="<?php echo  $order['email']; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="tel" class="form-label">Telefonnummer</label>
                                            <input type="tel" class="form-control" name="tel" value="<?php echo  $order['phoneNumber']; ?>">
                                        </div>

                                        <p class="display-6">Leveransinformation</p>

                                        <div class="mb-3">
                                            <label for="adress" class="form-label">Adress</label>
                                            <input type="text" class="form-control" name="adress" value="<?php echo  $order['address']; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="ort" class="form-label">Ort</label>
                                            <input type="text" class="form-control" name="ort" value="<?php echo  $order['district']; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="postnummer" class="form-label">Postnummer</label>
                                            <input type="text" class="form-control" name="postnummer" value="<?php echo  $order['zipCode']; ?>">
                                        </div>

                                        <div class="mb-3">

                                            <label for="shippingType" class="form-label">Fraktsätt</label>
                                            <input type="text" class="form-control" name="shippingType" value="<?php echo  $order['shippingType']; ?>" readonly>

                                        </div>

                                        <button type="submit" class="btn btn-primary rounded-3" name="uppdatera">Uppdatera</button>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>


        <?php else : ?>

            <!-- IF USER IS NOT LOGGED IN -->

            <div class="container" style="max-width: 400px;">

                <form method="POST" class="mt-3">

                    <div class="mb-3">
                        <label for="pass" class="form-label">Lösenord</label>
                        <input type="password" class="form-control" id="pass" name="pass">
                    </div>

                    <button type="submit" class="btn btn-primary w-100" name="login">Logga in</button>

                </form>
            </div>

        <?php endif; ?>


        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>