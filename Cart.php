<?php

require_once('db.php');
require_once('helpers.php');


if (!empty($_SESSION['cart'])) {

  $sql = 'select * from branchDesignProducts where id in (' . implode(',', array_keys($_SESSION['cart'])) . ')';

  $products = $connection->query($sql);
  $isCartEmpty = false;
}

if (isset($_POST['cleanCart'])) {
  $_SESSION['cart'] = [];
}

$pageTitle = "Din varukorg - Branch Design UF";

$price = itemsInCartTotal();

require_once("header.php");
?>

<div class="container mb-3 mt-3" style="font-family: 'Inter', sans-serif;">

  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php" class="link-dark text-decoration-none">Hem</a></li>
      <li class="breadcrumb-item" aria-current="page">Varukorg</li>
    </ol>
  </nav>

  <div class="text-center">
    <p class="display-6">Varukorg</p>
  </div>

<!---

  <div class="container p-3 rounded mb-3 text-center border-0 bg-danger text-white" role="alert">
    <b>Beställningar går inte att göra just nu p.g.a. stopp i produktionen</b><br>Vi kommer släppa information om när det går att beställa igen på <a class="link-light" href="https://www.instagram.com/branchdesignuf/">Instagram</a>
  </div>

    -->

  <?php if (empty($_SESSION['cart'])) : ?>

    <div class="text-center">
      <p>Din varukorg är tom, men så behöver det inte vara!</p>
      <a class="btn btn-outline-dark rounded-3" href="index.php#products">Shoppa</a>
    </div>

  <?php endif ?>


  <?php if (!empty($_SESSION['cart'])) : ?>


    <div class="row mb-3">
      <div class="col-6">
        Produkt
      </div>


      <div class="col-6 text-end">
        Antal
      </div>

    </div>


    <div class="p-0">


      <?php foreach ($products as $key => $value) : ?>

        <div class="row mb-3">
          <div class="col-10">

            <div class="card border-0">
              <div class="row g-0">

                <div class="col-2">
                  <img src="Media/ProductImages/<?php echo $value['productImageName']; ?>" class="img-fluid bg-light">
                </div>
                <div class="col-10">
                  <div class="card-body pt-0">
                    <p class="card-text mb-0"><?php echo $value['productName']; ?></p>
                    <p class="card-text">Produktnummer: <?php echo $value['id']; ?></p>
                    <p class="card-text"><?php echo $_SESSION['cart'][$value['id']] * $value['productPrice']; ?> Kr</p>
                  </div>
                </div>
              </div>
            </div>

          </div>


          <div class="col-2 text-end">
            <p><?php echo $_SESSION['cart'][$value['id']]; ?></p>
          </div>

        </div>

      <?php endforeach; ?>

    </div>



    <div class="row">
      <div class="col-6">

        <form method="POST">
          <button type="submit" class="btn btn-outline-dark rounded-3 mb-5" name="cleanCart">Rensa varukorgen</button>
        </form>

      </div>

      <div class="col-6 text-end">
        <p>Summa: <?php echo $price ?> Kr</p>

      </div>
    </div>



    <p class="display-6 text-center">Kassa</p>

    <p class="text-center"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-down-circle" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z" />
      </svg>
    </p>

    <form action="payment.php" method="POST">

      <p>Dina uppgifter</p>

      <div class="form-group">
        <div class="row">
          <div class="col-lg-6 mb-3">
            <label for="förnamn">Förnamn <span class="text-danger">(OBS! Måste vara samma som på Swish-betalningen)</span></label>
            <input type="text" class="form-control rounded-3 form-control-lg" id="förnamn" name="Förnamn" required>
          </div>
          <div class="col-lg-6 mb-3">
            <label for="efternamn">Efternamn <span class="text-danger">(OBS! Måste vara samma som på Swish-betalningen)</span></label>
            <input type="text" class="form-control rounded-3 form-control-lg" id="efternamn" name="Efternamn" required>
          </div>
        </div>
      </div>

      <div class="form-group mb-3">
        <label for="epost">E-postadress</label>
        <input type="email" class="form-control rounded-3 form-control-lg" id="epost" name="Epost" required>
      </div>

      <div class="form-group mb-3">
        <label for="telefonummer">Telefonnummer <span class="text-danger">(OBS! Måste vara samma som på Swish-betalningen)</span></label>
        <input type="tel" class="form-control rounded-3 form-control-lg" id="telefonummer" name="Telefonnummer" required>
      </div>



      <p>Leverans</p>

      <div class="form-group mb-3">
        <label for="adress">Adress</label>
        <input type="text" class="form-control rounded-3 form-control-lg" id="adress" name="Adress" required>
      </div>

      <div class="form-group mb-3">
        <label for="ort">Ort</label>
        <input type="text" class="form-control rounded-3 form-control-lg" id="ort" name="Ort" required>
      </div>

      <div class="form-group mb-3">
        <label for="postnummer">Postnummer</label>
        <input type="text" class="form-control rounded-3 form-control-lg" id="postnummer" name="Postnummer" required>
      </div>

      <div class="form-group mb-3 p-3 border rounded-3">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioShipping" id="flexRadioShipping1" value="99" onchange="handleChange(this);">
          <label class="form-check-label" for="flexRadioShipping1">
            Hemkörning inom 20km från Lugnetgymnasiet (+ 99.00 SEK)
          </label>

          <p>Vi kör hem din beställning till din dörr. Vi hör av oss via e-post om dag och tid för utlämningen. <span class="text-danger">OBS! Adressen får inte vara längre bort än 20km från Lugnetgymnasiet!</span></p>
          <p class="mb-0">Leveranstid: 1-3 veckor, produkterna produceras på beställning!</p>
        </div>

      </div>

      <div class="form-group mb-3 p-3 border rounded-3">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioShipping" id="flexRadioShipping2" checked value="0" onchange="handleChange(this);">
          <label class="form-check-label" for="flexRadioShipping2">
            Hämtning på Lugnetgymnasiet, Falun (+ 0.00 SEK)
          </label>

          <p class="mb-0">Vi kontaktar dig via e-post för att bestämma datum och tid för upphämtning.</p>
          <span class="badge bg-dark rounded-3">Rekommenderad</span>
          <span class="badge bg-dark rounded-3 mb-3">Populärast</span>

          <p class="mb-0">Leveranstid: 1-3 veckor, produkterna produceras på beställning!</p>
        </div>

      </div>

      <div class="form-group mb-3 p-3 border rounded-3">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioShipping" id="flexRadioShipping2" value="69" onchange="handleChange(this);">
          <label class="form-check-label" for="flexRadioShipping2">
            Skickas mot fraktavgift (+ 69.00 SEK)
          </label>

          <p>Vi skickar beställningen till angiven adress ovanför. Skickas som spårbart paket till postombud.</p>
          <p class="mb-0">Leveranstid: 1-3 veckor, produkterna produceras på beställning!</p>
        </div>
      </div>



      <p>Betalningssätt</p>

      <div class="form-group mb-3 p-3 border rounded-3">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioPayment" id="flexRadioPayment1" checked>
          <label class="form-check-label" for="flexRadioPayment">
            Swish
          </label>

          <p class="mb-0">I nästa steg genereras en QR-kod som du skannar med Swish-appen. Du måste manuellt skanna koden och starta betalningen. Instruktioner för betalning på mobil enhet finns i nästa steg.</p>
        </div>
      </div>

      <!-- Hidden fields -->
      <input type="text" name="Summa" value="<?php echo $price ?>" hidden>

      <!-- Alla produkter i beställningen -->
      <?php foreach ($products as $key => $value) : ?>

        <?php echo '<input type="text" name="products[' . $value['productName'] . ']" value=" ' . $_SESSION['cart'][$value['id']] . '" hidden>' ?>

      <?php endforeach; ?>

      <!-- Hidden fields -->

      <h6>Summa: <?php echo $price ?> KR</h6>

      <h6 id="shippingText">Leverans: 0 KR</h6>

      <h6 id="totalText">Totalsumma: <?php echo $price ?> Kr</h6>

      <!---
      <div class="container p-3 rounded mb-3 text-center border-0 bg-danger text-white" role="alert">
        <b>Beställningar går inte att göra just nu p.g.a. stopp i produktionen</b><br>Vi kommer släppa information om när det går att beställa igen på <a class="link-light" href="https://www.instagram.com/branchdesignuf/">Instagram</a>
      </div>

      !-->

      <button type="submit" class="btn btn-outline-dark btn-lg rounded-3 w-100 mb-3" disabled>Fortsätt till betalning</button>


      <p>14 dagars ångerrätt från att produkten levereras, gäller bara om produkten har samma skick som vid leverans.</p>


    </form>

  <?php endif; ?>

</div>

<?php if (!empty($_SESSION['cart'])) : ?>

  <?php require_once("footer.php"); ?>

<?php endif ?>

<script>
  var shippingFee = 0;
  var cost = <?php echo $price ?>;

  var totalCost = parseInt(shippingFee) + parseInt(cost);

  document.getElementById('shippingText').innerHTML = "Leverans: " + shippingFee + " Kr";
  document.getElementById('totalText').innerHTML = "Totalsumma: " + totalCost + " Kr";

  function handleChange(src) {
    shippingFee = src.value;
    totalCost = parseInt(shippingFee) + parseInt(cost);
    document.getElementById('shippingText').innerHTML = "Leverans: " + shippingFee + " Kr";
    document.getElementById('totalText').innerHTML = "Totalsumma: " + totalCost + " Kr";
  }
</script>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 2: Separate Popper and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</body>

</html>