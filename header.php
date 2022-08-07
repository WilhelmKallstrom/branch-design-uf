<!doctype html>
<html lang="sv">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Zen+Antique+Soft&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title><?php echo isset($pageTitle) ? $pageTitle : "Branch Design UF" ?></title>

  <link rel="icon" href="Media/logo_small.png">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-48JH4Q52HZ"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-48JH4Q52HZ');
  </script>

</head>

<body style="padding-top: 80px;">

  <div class="fixed-top">

    <!-- As a link -->
    <nav class="navbar navbar-dark navbar-expand-lg p-3" style="background-color: #000000;">


      <div class="container">

        <a class="navbar-brand pb-3" href="index.php#">
          <img src="Media/logo2.png" class="img-fluid" style="height: 25px;">
        </a>

        <a href="Cart.php" class="btn position-relative p-1 d-block d-sm-none">

          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" class="bi bi-bag" viewBox="0 0 16 16">
            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
          </svg>

          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">
            <?php echo itemsInCart(); ?>
          </span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="index.php#">Hem</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="index.php#products">Produkter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="Cart.php">Varukorg (<?php echo itemsInCart(); ?>)</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="About.php">Om Branch Design UF</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="Contact.php">Kontakt</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>



  <button type="button" class="btn btn-dark btn-floating btn-lg p-0 rounded-circle shadow-sm d-block d-sm-none" id="btn-back-to-top" style="position: fixed; bottom: 10px; right: 10px; display: none; z-index: 99 !important;">
    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-arrow-up-square-fill rounded-circle" viewBox="0 0 16 16">
      <path d="M2 16a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2zm6.5-4.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 1 0z" />
    </svg>
  </button>

  <script>
    //Get the button
    let mybutton = document.getElementById("btn-back-to-top");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
      scrollFunction();
    };

    function scrollFunction() {
      if (
        document.body.scrollTop > 50 ||
        document.documentElement.scrollTop > 50
      ) {
        mybutton.style.display = "block";
      } else {
        mybutton.style.display = "none";
      }
    }
    // When the user clicks on the button, scroll to the top of the document
    mybutton.addEventListener("click", backToTop);

    function backToTop() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
    }
  </script>

  <style>
    .navbar .navbar-nav .nav-link {
      position: relative;

    }

    .navbar .navbar-nav .nav-link::after {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      margin: auto;
      background-color: #000000;
      color: transparent;
      width: 0%;
      content: '.';
      height: 4px;
      transition: all 0.25s;
    }

    .navbar .navbar-nav .nav-link:hover::after {
      width: 100%;
    }
  </style>