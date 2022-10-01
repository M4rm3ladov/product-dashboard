<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet/less" href="/assets/stylesheet/normalize.less">
    <link rel="stylesheet/less" href="/assets/stylesheet/show_product.less">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/4.1.3/less.js"></script>
    <title>Product Information</title>
</head>
<body>
    <?php $this->load->view('partials/header'); ?>
    <div class="container">
        <h1><?= $product['name']; ?> ($<?= number_format($product['price'], 2); ?>)</h1>
        <p>Added since: <?= date("F dS, Y", strtotime($product['created_at'])); ?></p>
        <p>Product ID: #<?= $product['id']; ?></p>
        <p>Description: <?= $product['description']; ?></p>
        <p>Total sold: <?= $product['quantity_sold']; ?></p>
        <p>Number of available stocks: <?= $product['product_count']; ?></p>
        
        <h2>Leave a Review</h2>
        <form action="/review/products/validate/<?= $product['id']; ?>" method="post">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
            <textarea name="review" placeholder="write a message"></textarea>
            <?= !empty($this->session->flashdata('review_error')) ? $this->session->flashdata('review_error') : ''; ?>
            <input type="submit" value="Post">
        </form>
<?php
    date_default_timezone_set('Asia/Manila');
    $date_today = new DateTime(date("Y-m-d H:i:s", time()));
    if(isset($reviews))
    {
        foreach($reviews as $review)
        {
            $date_created = new DateTime($review['created_at']);
            $interval = $date_today->diff($date_created);
            if($interval->format('%a') > 7)
            {
                $elapsed = date("F jS, Y", strtotime($review['created_at']));
            }
            else if($interval->format('%a') != 0)
            {
                $interval->format('%a') > 1 ? $noun = 'days' : $noun = 'day' ;
                $elapsed = $interval->format("%a {$noun} ago");
            }
            else if($interval->format('%h') != 0) 
            {
                $interval->format('%h') > 1 ? $noun = 'hours' : $noun = 'hour' ;
                $elapsed = $interval->format("%h {$noun} ago");
            }
            else if($interval->format('%i') != 0) 
            {
                $interval->format('%i') > 1 ? $noun = 'minutes' : $noun = 'minute' ;
                $elapsed = $interval->format("%i {$noun} ago");
            }
            else if($interval->format('%s') != 0) 
            {
                $interval->format('%s') > 1 ? $noun = 'seconds' : $noun = 'second' ;
                $elapsed = $interval->format("%s {$noun} ago");
            }
?>
        <h3><?= $review['name']; ?><span> wrote:</span></h3>
        <p class="date-time"><?= $elapsed; ?></p>
        <p><?= $review['comments']; ?></p>

        <div>
<?php
        date_default_timezone_set('Asia/Manila');
        $date_today = new DateTime(date("Y-m-d H:i:s", time()));
        foreach($review['replies'] as $reply)
        {
            $date_created = new DateTime($reply['created_at']);
            $interval = $date_today->diff($date_created);
            if($interval->format('%a') > 7)
            {
                $elapsed = date("F jS, Y", strtotime($reply['created_at']));
            }
            else if($interval->format('%a') != 0)
            {
                $interval->format('%a') > 1 ? $noun = 'days' : $noun = 'day' ;
                $elapsed = $interval->format("%a {$noun} ago");
            }
            else if($interval->format('%h') != 0) 
            {
                $interval->format('%h') > 1 ? $noun = 'hours' : $noun = 'hour' ;
                $elapsed = $interval->format("%h {$noun} ago");
            }
            else if($interval->format('%i') != 0) 
            {
                $interval->format('%i') > 1 ? $noun = 'minutes' : $noun = 'minute' ;
                $elapsed = $interval->format("%i {$noun} ago");
            }
            else if($interval->format('%s') != 0) 
            {
                $interval->format('%s') > 1 ? $noun = 'seconds' : $noun = 'second' ;
                $elapsed = $interval->format("%s {$noun} ago");
            }
?>
            <h3><?= $reply['name'] ?> <span>wrote:</span></h3>
            <p class="date-time"><?= $elapsed ?></p>
            <p><?= $reply['comments'] ?></p>
<?php
            }
?>
            <form action="/reply/products/validate/<?= $product['id']; ?>/<?= $review['id']; ?>" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <textarea name="reply" placeholder="write a message"></textarea> 
                <?= !empty($this->session->flashdata('reply_error')) ? $this->session->flashdata('reply_error') : ''; ?>
                <input type="submit" value="Post">
            </form>
        </div>
<?php
        }
    }
?>      
    </div>
</body>
</html>