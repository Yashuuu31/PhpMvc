<?php

$connect = new mysqli("localhost", "root", "", "yash_c");
$productSql = "select * from product";
$products = $connect->query($productSql);

?>

<!-- Html Code -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
    <?php require('./layout/style.php') ?>

    <style>
        .error {
            color: red !important;
            position: sticky !important;
        }
    </style>
</head>


<body>

    <?php require('./layout/navbar.php') ?>

    <div class="container mt-5 pt-3">
        <div class="card shadow-1-strong">
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <h3 class="col">Add Fields</h3>
                        <a class="btn btn-outline-primary col-1" data-mdb-toggle="modal" data-mdb-target="#exampleModal">Add</a>
                    </div>
                    <hr>

                    <!-- Modal Form Start-->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>Add Field Form</h3>
                                        <hr>
                                        <form action="" id="addForm" class="mx-2">
                                            <div class="row">
                                                <div class="form-outline mb-4 col-md-4 mx-2">
                                                    <input type="text" name="name[]" class="form-control">
                                                    <label class="form-label">Name</label>
                                                </div>

                                                <div class="form-outline mb-4 col-md-4 mx-2">
                                                    <input type="text" name="placeholder" class="form-control">
                                                    <label class="form-label">Placeholder</label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-4 col-md-4">
                                                    <select name="data_type" class="form-select">
                                                        <option value="">--Choose--</option>
                                                        <option value="text">Text</option>
                                                        <option value="number">Number</option>
                                                        <option value="radio">Radio</option>
                                                        <option value="checkbox">Checkbox</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-primary" id="addBtn" data-mdb-dismiss="modal">Submit</a>
                                    <a class="btn btn-danger" data-mdb-dismiss="modal" data-mdb-dismiss="modal">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Form End -->


                    <div class="table-responsive">
                        <form id="FormAdd" method="POST" action="../php/submit.php">
                            <table class="table table-bordered" id="FormTable">
                                <tr class="FormColumn">
                                    <td class="SrNo">
                                        1
                                    </td>
                                    <td>
                                        <div>
                                            <select name="name[0]" class="form-select form_name">
                                                <option value="" data-price="">--select--</option>
                                                <?php foreach ($products as $i) { ?>
                                                    <option data-price="<?= $i['price'] ?>" value="<?= $i['id'] ?>"><?= $i['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group ">
                                            <input type="text" disabled name="rate" class="form-control form_rate   " placeholder="Rate">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group ">
                                            <input type="number" name="qty[0]" value=""  class="form-control form_qty" placeholder="Qty">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group ">
                                            <input type="text" disabled name="total" class="form-control form_total" placeholder="Total">
                                        </div>
                                    </td>

                                    <td>
                                        <a class="btn btn-success btn-sm BtnAdd"><i class="fas fa-plus"></i></a>
                                    </td>

                                    <td>
                                        <a class="btn btn-danger btn-sm BtnSub"><i class="fas fa-minus"></i></a>
                                    </td>
                                </tr>
                            </table>

                            <table class="table table-bordered" id="TotalForm">
                                <tr>
                                    <td style="width: 35%;" class="h5 text-center">Sub Total</td>
                                    <td id="SubTotal" class="h5 text-center">0</td>
                                </tr>

                                <tr>
                                    <td style="width: 35%;" class="h5 text-center">Discount</td>
                                    <td>
                                        <div class="form-group col-md-3 offset-md-4">
                                            <input type="number" name="discount" class="form-control" placeholder="Discount">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 35%;" class="h5">
                                        <div class="row">
                                            <h5 class="col text-center">Vat-Tex</h5>
                                            <div class="form-group col">
                                                <input type="number" name="vat_tex" class="form-control" placeholder="Vat-Tex">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center h5">
                                            <span id="vat_per">0</span><span></span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 35%;" class="h5 text-center">Garnd Total</td>
                                    <td id="GrandTotal" class="h5 text-center">0</td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <div class="form-group col-md-6 offset-md-3">
                                            <button type="submit" class="btn btn-primary form-control">Submit</button>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<?php require('./layout/script.php') ?>
<script src="../js/custom.js"></script>

</html>