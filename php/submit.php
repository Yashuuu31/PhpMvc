<?php 
$connect = new mysqli("localhost", "root", "", "yash_c");

// -----
$products = array_combine($_POST['name'], $_POST['qty']);
$discount = isset($_POST['discount']) ? $_POST['discount'] : 0;
$vat_tex = isset($_POST['vat_tex']) ? $_POST['vat_tex'] : 0;
$order_id = uniqid();

$total = 0;
foreach($products as $ky => $qty){
    $prod = $connect->query("select * from product where id=$ky")->fetch_assoc();
    $total += $prod['price'] * $qty;
}

if($total != 0){
    if($discount != 0){
        $total -= $discount;
    }
    if($vat_tex != 0){
        $tempTex = ($total / 100) * $vat_tex;
        $total += $tempTex;
    }
    
    foreach($products as $ky => $qty){
        $tempProd = $connect->query("select * from product where id=$ky")->fetch_assoc();
        $subtotal = $tempProd['price'] * $qty;
        $connect->query("insert into orders (order_id, product_id,price,total,qty) 
            values('$order_id', '$ky', {$tempProd['price']}, '$subtotal', '$qty')");
    }
    $connect->query("insert into total (order_id,discount, vat_tex, total) 
        values('$order_id', '$discount','$vat_tex','$total')");

        echo "<script>location.replace('../views/index.php')</script>";
}

exit();
?>
