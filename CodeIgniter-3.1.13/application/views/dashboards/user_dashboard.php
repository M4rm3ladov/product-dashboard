<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet/less" href="/assets/stylesheet/normalize.less">
    <link rel="stylesheet/less" href="/assets/stylesheet/dashboards.less">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/4.1.3/less.js"></script>
    <title>Product Dashboard | User</title>
</head>
<body>
    <?php $this->load->view('partials/header'); ?>
    <div>
        <h1>All Products</h1>
        <table>
            <thead>
                <td>ID</td>
                <td>Name</td>
                <td>Inventory Count</td>
                <td>Quantity Sold</td>
            </thead>
            <tbody>
<?php
    if(!empty($products))
    {
        $index = 0;
        foreach($products as $product)
        {
?>
                <tr class=<?= ($index % 2 == 0) ? "row-color" : ""; ?>>
                    <td><?= $product['id']; ?></td>
                    <td><a href="/products/show/<?= $product['id']; ?>"><?= $product['name']; ?></a></td>
                    <td><?= $product['product_count']; ?></td>  
                    <td><?= $product['quantity_sold']; ?></td>
                </tr>
<?php
            $index++;
        }
    }
?>
            </tbody>
        </table>
    </div>
</body>
</html>