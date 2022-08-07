<?php
require('db.php');


session_start();


function d($message)
{
    echo '<pre>';
    var_dump($message);
}

function dd($message)
{
    d($message);
    die();
}


function itemsInCart()
{
    $sum = 0;
    if (!isset($_SESSION['cart'])) {
        return $sum;
    }
    foreach ($_SESSION['cart'] as $items) {
        $sum += $items;
    }

    return $sum;
}


function itemsInCartTotal()
{
    require('db.php');
    $sum = 0;
    if (!isset($_SESSION['cart'])) {
        return $sum;
    }
    foreach ($_SESSION['cart'] as $id => $items) {
        $sql = "select productPrice as price from branchDesignProducts where id = ?";

        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $id);

        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $sum += $result['price'] * $items;
    }

    return $sum;
}
