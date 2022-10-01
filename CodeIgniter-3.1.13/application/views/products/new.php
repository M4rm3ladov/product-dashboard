<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet/less" href="/assets/stylesheet/normalize.less">
    <link rel="stylesheet/less" href="/assets/stylesheet/products.less">

    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/4.1.3/less.js"></script>
    <script type="text/javascript" src="/assets/javascript/products.js"></script>
    <title>New Product | Admin</title>
</head>
<body>
    <?php $this->load->view('partials/header'); ?>
    <div>
        <h1>Add a new Product</h1>
        <a href="/dashboard/admin" class="button-link">Return to Dashboard</a>
        <form action="/new/products/validate" method="post">
<?php
    if(!empty($this->session->flashdata('success')))
    {
?>
            <p class="success"><?= $this->session->flashdata('success'); ?></p>
<?php
    }
?>
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
            
            <p>
                <label for="name">Name:</label>
                <input type="text" name="name" value="<?= isset($this->session->flashdata('values')['name']) ? $this->session->flashdata('values')['name'] : '';?>" id="name">
                <p class="error"><?= isset($this->session->flashdata('errors')['name']) ? $this->session->flashdata('errors')['name'] : ''; ?></p>
            </p>
            <p>
                <label for="description">Description:</label>
                <textarea name="description" id="description"><?= isset($this->session->flashdata('values')['description']) ? $this->session->flashdata('values')['description'] : '';?></textarea> 
                <p class="error"><?= isset($this->session->flashdata('errors')['description']) ? $this->session->flashdata('errors')['description'] : ''; ?></p>
            </p>
            <p>
                <label for="price">Price:</label>
                <input type="number" name="price" value="<?= isset($this->session->flashdata('values')['price']) ? $this->session->flashdata('values')['price'] : '';?>" placeholder="0.00" min="1" step="any" id="price">
                <p class="error"><?= isset($this->session->flashdata('errors')['price']) ? $this->session->flashdata('errors')['price'] : ''; ?></p>
            </p>
            <p>
                <label for="count">Inventory Count:</label>
                <input type="number" name="count" value="<?= isset($this->session->flashdata('values')['count']) ? $this->session->flashdata('values')['count'] : '';?>" placeholder="0" min="1" max="" id="count">
                <p class="error"><?= isset($this->session->flashdata('errors')['count']) ? $this->session->flashdata('errors')['count'] : ''; ?></p>
            </p>

            <input type="submit" value="Create">
        </form>
    </div>
</body>
</html>