<?php
$connect = new mysqli("localhost", "root", "", "yash_c");


$discount = isset($_POST['discount']) ? $_POST['discount'] : 0;
$vat_tex = isset($_POST['vat_tex']) ? $_POST['vat_tex'] : 0;
$order_id = $_POST['order_id'];

// print_r($productId);

$prod['id'] = $_POST['product_id'];
$prod['qty'] = $_POST['qty'];
$prod['name'] = $_POST['name'];

$prevProduct = array_column($connect->query("SELECT * FROM orders WHERE order_id='$order_id'")->fetch_all(),0);
$delProducts = array_diff($prevProduct, $prod['id']);
if(count($delProducts) != 0){
    foreach($delProducts as $i){
        $connect->query("DELETE FROM orders WHERE id='$i'");

    }
}


$product = [];
// foreach($prod['id'] as $ky => $i){
//     echo $i;
// }

// foreach($prod['qty'] as $ky => $i){
//     echo  $i;
// }

// foreach($prod['name'] as $ky => $i){
//     echo $i;
// }


foreach($prod as $ky => $i){
    foreach($i as $j => $k){        
        $product[$j][$ky] = $k;
        
    }
}

// echo "<pre>";
// print_r($product);
// echo "</pre>";

$total = 0;
foreach($product as $ky => $i){
    if($i['id'] != null){
        $tempProd = $connect->query("SELECT * FROM product WHERE id='{$i['name']}'")->fetch_assoc();
        $subTotal = $tempProd['price'] * $i['qty'];
        $connect->query("UPDATE orders SET product_id='{$i['name']}',price='{$tempProd['price']}',qty='{$i['qty']}',total='$subTotal' WHERE id='{$i['id']}'");
        $total += $subTotal;
    } else if(! $i['id']){
        $tempProd = $connect->query("SELECT * FROM product WHERE id='{$i['name']}'")->fetch_assoc();
        $subTotal = $tempProd['price'] * $i['qty'];
        $connect->query("INSERT INTO orders (order_id, product_id,price,total,qty) 
                VALUES ('$order_id','{$i['name']}', {$tempProd['price']}, '$subTotal','{$i['qty']}')");
        $total += $subTotal;
    }
}

if($total != 0){
    if($discount != 0){
        $total -= $discount;
    }
    if($vat_tex != 0){
        $tempTex = ($total / 100) * $vat_tex;
        $total += $tempTex;
    }
    $connect->query("UPDATE total SET order_id='$order_id', discount='$discount', vat_tex='$vat_tex', total='$total' WHERE order_id='$order_id'");
}

echo "<script>location.replace('../views/index.php')</script>";

exit();
