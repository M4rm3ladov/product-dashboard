<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet/less" href="/assets/stylesheet/normalize.less">
    <link rel="stylesheet/less" href="/assets/stylesheet/dashboards.less">

    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/4.1.3/less.js"></script>
    <script type="text/javascript" src="/assets/javascript/modal.js"></script>
    <title>Product Dashboard | Admin</title>
</head>
<body>
    <?php $this->load->view('partials/header'); ?>
    <div>
        <h1>Manage Products</h1>
        <a href="/products/new" class="button-link">Add new</a>
        <table>
            <thead>
                <td>ID</td>
                <td>Name</td>
                <td>Inventory Count</td>
                <td>Quantity Sold</td>
                <td>Action</td>
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
                    <td><a href="/products/show/<?= $product['id']; ?>"><?= $product['name'] ?></a></td>
                    <td><?= $product['product_count']; ?></td>  
                    <td><?= $product['quantity_sold']; ?></td>
                    <td class="actions">
                        <a href="/products/edit/<?= $product['id']; ?>">edit</a> 
                        <input type="submit" value="remove" data-id="<?= $product['id']; ?>" data-name="<?= $product['name'] ?>" class="remove">
                    </td>
                </tr>
<?php
            $index++;
        }
    }
?>
            </tbody>
        </table>
    </div>
    <div id="modal-remove">
        <div class="modal-content">
            <h1>Remove Product</h1>
            <span class="close">&times;</span>
            <p>Are you sure you want to delete <span id="product-name"></span></p>
            <input type="submit" value="Cancel" class="cancel">
            <form action="" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <input type="submit" value="Yes">
            </form>
        </div>
    </div>
</body>
</html>