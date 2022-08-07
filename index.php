<?php

require_once('db.php');
require_once('helpers.php');

$products = $connection->query('select * from branchDesignProducts');

if (!$products) {
  printf("Errormessage: %s\n", $connection->error);
  die();
}

$allProducts = $products;

$pageTitle = "Hem - Branch Design UF";


require_once("header.php");
?>

<div class="container-fluid p-0 mb-5">
  <div class="card border-0 rounded-0">
    <div class="ratio ratio-16x9 card-img rounded-0">

      <video playsinline autoplay loop muted id="heroVideo">
        <source src="Media/candleMovie.mp4" type="video/mp4">
      </video>

    </div>

    <div class="card-img-overlay text-center d-flex text-white">
      <div class="align-self-center mx-auto">
        <h1 class="card-title fw-bold display-4" style="font-family: 'Inter', sans-serif; text-shadow: 0px 0px 10px rgba(150, 150, 150, 0);">BRANCH DESIGN UF</h1>
        <p class="card-text fw-bold" style="font-family: 'Inter', sans-serif; text-shadow: 0px 0px 10px rgba(150, 150, 150, 0);">- Produkterna varierar, men inte vår kvalité -</p>
      </div>
    </div>
  </div>
</div>



<div class="container">

  <!--


  <div class="text-center mb-5">
    <h4>Intresserad av vad vi gör?</h4>
    <p>Håll dig uppdaterad på @branchdesignuf</p>
    <a href="https://www.instagram.com/branchdesignuf/" target="_blank" class="btn btn-dark btn-lg fw-bold rounded-3">Gå till Instagram</a>
  </div>

-->


  <div class="text-center mx-auto mb-5">

    <p class="lead fw-bold" style="font-family: 'Inter', sans-serif;" id="products">
      Produkter
    </p>

    <p style="font-family: 'Inter', sans-serif;">
      Med design inspirerad av Dalarna och natur, presenterar vi på Branch Design UF stolt vår kollektion av inredningsdetaljer tillverkade av miljövänligt material.
    </p>
  </div>

  <div class="row row-cols-1 row-cols-md-3 g-3 mb-5 justify-content-center">

    <?php foreach ($allProducts as $key => $value) : ?>
      <div class="col">
        <div class="card border-0 rounded-3">
          <img src="Media/ProductImages/<?php echo  $value['productImageName']; ?>" class="card-img img-fluid rounded-0">
          <div class="card-body p-0">
            <p class="card-title fw-bold mt-3" style="font-family: 'Inter', sans-serif;"><a href="Product.php?id=<?php echo  $value['id']; ?>" class="stretched-link text-decoration-none link-dark"><?php echo  $value['productName']; ?></a></p>
            <p class="card-text" style="font-family: 'Inter', sans-serif;"><?php echo  $value['productPrice']; ?> Kr</p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>


  </div>

  <p class="lead text-center fw-bold" style="font-family: 'Inter', sans-serif;">Inblick i verkstaden</p>

  <div class="ratio ratio-16x9 card-img shadow-lg">

    <video autoplay loop muted playsinline>
      <source src="Media/productionMovie.mp4" type="video/mp4">
    </video>

  </div>

  <div class="mb-5 mt-5">
    <p class="lead text-center fw-bold mb-0" style="font-family: 'Inter', sans-serif;">Försäljningstillfällen</p>
    <p class="text-center" style="font-family: 'Inter', sans-serif;">Nedanför finns alla våra planerade försäljningstillfällen</p>
    <p class="text-center" style="font-family: 'Inter', sans-serif;">Just nu har vi inga planerade försäljningstillfällen</p>


    <!--

    <div class="card mx-auto rounded-0 border-0 mb-3 text-center" style="max-width: 512px;">
      <img src="Media/lugnet.jpg" class="img-fluid rounded-0">
      <div class="card-body p-0">
        <p class="card-title mt-3" style="font-family: 'Inter', sans-serif;">Lugnetgymnasiet, öppet hus</p>
        <p class="card-text" style="font-family: 'Inter', sans-serif;">17 November 2021 mellan Kl 18-20</p>
        <a href="https://www.google.se/maps/place/Lugnetgymnasiet/@60.6160694,15.6553533,575m/data=!3m2!1e3!4b1!4m5!3m4!1s0x466770146eb55e6d:0x24522fc29b22f321!8m2!3d60.6160668!4d15.657542" target="_blank" class="link-dark stretched-link">Visa på karta</a>
      </div>
    </div>

    -->
  </div>

</div>

<hr>

<div class="text-center mb-5 mt-5">
  <p style="font-family: 'Inter', sans-serif;" class="fw-bold lead">Vill ditt företag beställa specialdesignade produkter?</p>
  <p style="font-family: 'Inter', sans-serif;">Kontakta oss så återkommer vi!</p>
  <a href="Contact.php" class="btn btn-outline-dark btn-lg rounded-3" style="font-family: 'Inter', sans-serif;">Kontakta oss</a>
</div>

</div>


<?php require_once("footer.php"); ?>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 2: Separate Popper and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


<!-- Masonry -->
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
</script>



</body>

</html>