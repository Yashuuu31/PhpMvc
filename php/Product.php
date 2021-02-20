
<?php 
header('content-type: application/json; charset=utf-8');
$connect = new mysqli("localhost", "root", "", "yash_c");
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
   }
$productId = $_POST['id'];
$product = $connect->query("SELECT * FROM product WHERE id='$productId'")->fetch_assoc();

echo json_encode($product);

$connect->close();
?>
