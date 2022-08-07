<?php

require_once('db.php');
require_once('helpers.php');

$price = itemsInCartTotal();
$price += (int)$_POST['flexRadioShipping'];


//var_dump($_POST["products"]);

if (!empty($_SESSION['cart'])) {

    $isCartEmpty = false;

    $sql = 'insert into branchDesignOrders values (null, ?,?,?,?,?,?,?,?,?,?,?,?,?)';
    $statement = $connection->prepare($sql);

    if ($_POST['flexRadioShipping'] == 0) {
        $shippingType = "Hämtning på Lugnetgymnasiet, Falun";
    } else if ($_POST['flexRadioShipping'] == 69) {
        $shippingType = "Skickas mot fraktavgift";
    } else {
        $shippingType = "Hemkörning inom Falu Kommun";
    }

    $status = "Pågående";

    $products = "";
    foreach ($_POST['products'] as $key => $value) {
        $products .= $key . " :" . $value . "<br>";
    }

    $orderDate = date("j, n, Y");

    $statement->bind_param("sssssssssssss", $_POST['Förnamn'], $_POST['Efternamn'], $_POST['Epost'], $_POST['Telefonnummer'], $_POST['Adress'], $_POST['Ort'], $_POST['Postnummer'], $status, $shippingType, $price, $products, $orderDate, $_SERVER['REMOTE_ADDR']);
    $statement->execute();
    $lastOrderId = $connection->insert_id;


} else {
    header("Location: index.php");
    exit;
}

//Swish QR-Kod anrop

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://mpc.getswish.net/qrg-swish/api/v1/prefilled',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 50,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
    "payee": {
        "value": "1230765750",
        "editable": "False"
    },
    "amount": {
        "value": "' . $price . '",
        "editable": "False"
    },
    "message": {
        "value": "OrderID: '.$lastOrderId .'",
        "editable": "False"
    },
    "format": "png",
    "size": "512"
}',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
));

$response = curl_exec($curl);

curl_close($curl);

//Avslutar Swish QR-Kod anrop

$imgSrc = base64_encode($response);







//Skickar mail

require_once('vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$shippingValue = $_POST["flexRadioShipping"];

if ($shippingValue == 69) {
    $shipping = "Skickas mot fraktavgift";
} else if ($shippingValue == 99) {
    $shipping = "Hemkörning inom Falu kommun";
} else {
    $shipping = "Hämtning på lugnetgymnasiet";
}


$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Debugoutput = 'error_log';
//$mail->Mailer = "smtp";

$mail->SMTPDebug  = SMTP::DEBUG_SERVER;
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "ssl";
$mail->Port       = 465;
$mail->CharSet = 'UTF-8';
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "branchdesignuf@gmail.com";
$mail->Password   = "kryptoframtid123.";

$mail->IsHTML(true);
//$mail->AddAddress($_POST['epost'], "recipient-name");
$mail->AddAddress("branchdesignuf@gmail.com", $_POST['Förnamn']);
$mail->addCC($_POST['Epost']);
$mail->SetFrom("branchdesignuf@gmail.com", "Branch Design UF");

$mail->Subject = "Orderbekräftelse";

$content = "<h1>Tack för din beställning, " . $_POST['Förnamn'] . "</h1><br><h2>Dina uppgifter</h2>";

$content .= "<strong>Epost:</strong> " . $_POST['Epost'] . "<br><strong>Telefonnummer:</strong> " . $_POST['Telefonnummer'] . "<br><strong>Förnamn:</strong> " . $_POST['Förnamn'] . "<br><strong>Efternamn:</strong> " . $_POST['Efternamn'] . "<br>";
$content .= "<h2>Leverans</h2><strong>Adress:</strong> " . $_POST['Adress'] . "<br><strong>Ort:</strong> " . $_POST['Ort'] . "<br><strong>Postnummer:</strong> " . $_POST['Postnummer'] . "<br><strong>Leverans: </strong>" . $shipping;
$content .= "<h2>Produkter</h2>";

foreach ($_POST['products'] as $key => $value) {
    $content .= $key . " : " . $value . "<br>";
}


$content .= "<h2>Betalning</h2><strong>Summa:</strong> " . $price . "<br><br>OrderID: ". $lastOrderId . "<br><br>Vid problem med beställningen eller frågor, <a href='https://branchdesignuf.se/Contact.php'>kontakta oss</a>.";


$mail->MsgHTML($content); 

if (!$mail->Send()) {
    //echo "Error while sending Email.";
    //var_dump($mail);
} else {
    //echo "Email sent successfully";
}

//Rensar varukorgen
$_SESSION['cart'] = [];

?>

<!doctype html>
<html lang="sv">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <title>Betalning - Branch Design UF</title>
</head>

<body>

    <div class="container text-center">

        <p class="display-6 mb-0 mt-3">Tack för din beställning, <?php echo $_POST['Förnamn'] ?></p>
        <p class="text-black-50">Vi har skickat en orderbekräftelse till, <span class="fw-bold"><?php echo $_POST['Epost'] ?></span></p>

        <p class="lead mb-0">Öppna Swish appen på din telefon och skanna QR-Koden</p>

        <p class="fw-bold">När du genomfört betalningen kan du stänga sidan!</p>

        <?php echo '<img src="data:image/png;base64,' . $imgSrc . '" class="img-fluid" />'; ?>

        <p class="mb-0">Om du betalar från en mobil enhet, Swisha <span class="fw-bold"><?php echo $price ?></span> Kr till <span class="fw-bold">1230765750</span></p>
        <p>Skriv OrderID: <strong><?php echo $lastOrderId ?></strong> som meddelande!</p>

        <p class="fw-bold">När du genomfört betalningen kan du stänga sidan!</p>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</body>

</html>