<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require('./layout/style.php') ?>
</head>

<body>
    <?php $connect = new mysqli("localhost", "root", "", "yash_c"); ?>
    <?php require('./layout/navbar.php') ?>

    <div class="container mt-5 ">
        <div class="card shadow-1-strong">
            <h3 class="text-center card-header">All Products</h3>
            <div class="card-body">
                <?php
                    $orders = $connect->query("select * from total");
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>Sr.</th>
                            <th>Order</th>
                            <th>Discount</th>
                            <th>Vat Tex</th>
                            <th>Total</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php foreach($orders as $ky => $item){ ?>
                            <tr>
                                <td><?= $ky+1 ?></td>
                                <td><?= $item['order_id'] ?></td>
                                <td><?= isset($item['discount']) ? $item['discount'] : '---' ?></td>
                                <td><?= isset($item['vat_tex']) ? $item['vat_tex'].'%' : '---' ?></td>
                                <td><?= $item['total'] ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $item['order_id'] ?>" class="btn btn-warning">EDIT</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
<?php require('./layout/script.php') ?>

</html>