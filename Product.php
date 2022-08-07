<?php

require_once('db.php');
require_once('helpers.php');
$message = "";

$statement = $connection->prepare('select * from branchDesignProducts where id =?');
$statement->bind_param('i', $_REQUEST['id']);
$statement->execute();
$result = $statement->get_result();

$product = $result->fetch_assoc();

if (!$result) {
  printf("Errormessage: %s\n", $connection->error);
  die();
}

if (isset($_POST['skicka'])) {
  if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
  } else {
    $cart = [];
  }


  $cart[$_GET['id']] = isset($cart[$_GET['id']]) ? $cart[$_GET['id']] + $_POST['amount'] : $_POST['amount'];


  $_SESSION['cart'] = $cart;
  $message = 'Produkten lades till i varukorgen!';
}

$pageTitle = $product['productName'] . " - BRANCH DESIGN UF";

require_once("header.php");


?>

<div class="container mb-3 mt-3">

  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb" style="font-family: 'Inter', sans-serif;">
      <li class="breadcrumb-item"><a href="index.php" class="link-dark text-decoration-none">Hem</a></li>
      <li class="breadcrumb-item" aria-current="page"><?php echo $product['productName'] ?></li>
    </ol>
  </nav>

  <div class="row">

    <div class="col-lg-8 mb-3">
      <img src="Media/ProductImages/<?php echo  $product['productImageName']; ?>" class="img-fluid rounded-0 bg-light">
    </div>

    <div class="col-lg-4">

      <p class="fw-bold lead text-center" style="font-family: 'Inter', sans-serif;"><?php echo $product['productName'] ?></p>
      <p class="lead text-center" style="font-family: 'Inter', sans-serif;"><?php echo $product['productPrice'] ?> Kr</p>


      <form action="" method="POST">

        <select class="form-select form-select-lg mb-3 mt-5 rounded-3 border-dark" name="amount">
          <option selected value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
        </select>

        <button class="btn btn-outline-dark btn-lg w-100 rounded-3 mb-3" type="submit" name="skicka">Lägg till i varukorgen</button>

        <p class="text-center mb-5 fw-bold" style="font-family: 'Inter', sans-serif;"><a href="Cart.php" class="link-dark"><?php echo $message ?></a></p>

      </form>


      <!--Product Description-->

      <p class="mb-5" style="font-family: 'Inter', sans-serif;"><?php echo $product['productDescription'] ?></p>

      <p class="lead" style="font-family: 'Inter', sans-serif;">Information</p>

      <hr>

      <!--Product Information-->

      <p style="font-family: 'Inter', sans-serif;"><?php echo $product['productInformation'] ?></p>

      <p style="font-family: 'Inter', sans-serif;">Produktnummer: <?php echo $product['id'] ?></p>

      <div>

      </div>

    </div>

  </div>

  <div class="row">
    <div class="col-lg-8">
    <img src="Media/ProductImages/<?php echo  $product['productImage2Name']; ?>" class="img-fluid rounded-0 bg-light">
    </div>
  </div>

</div>


<?php require_once("footer.php"); ?>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 2: Separate Popper and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>

</html>