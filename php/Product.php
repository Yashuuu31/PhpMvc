<!-- Php Code ------------------------------------------------------------------ -->
<?php 
$connect = new mysqli("localhost", "root", "", "yash_c");
$productSql = "SELECT * FROM product";
$products = $connect->query($productSql);
// $res['products'] = ;
// foreach($products as $i){
//     // print_r($i);
// }
header("Content-type: application/json;charset=utf-8");
echo json_encode($products);

// exit();
?>
