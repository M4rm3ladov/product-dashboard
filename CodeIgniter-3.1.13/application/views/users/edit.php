<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet/less" href="/assets/stylesheet/normalize.less">
    <link rel="stylesheet/less" href="/assets/stylesheet/products.less">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/4.1.3/less.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="/assets/javascript/register_validation.js"></script>
    <title>Edit Profile</title>
</head>
<body>
    <?php $this->load->view('partials/header'); ?>
    <div>
        <h1>Edit Profile</h1>
        
        <fieldset class="user-info">
<?php
    if(!empty($this->session->flashdata('success')['profile']))
    {
?>
            <p class="success"><?= $this->session->flashdata('success')['profile']; ?></p>
<?php
    }
?>
            <legend>Edit Information</legend>
            <form action="/edit/profile/validate" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                
                <p>
                    <label for="email">Email Address:</label>
                    <input type="email" name="email" value="<?= isset($this->session->flashdata('values')['email']) ? $this->session->flashdata('values')['email'] : $this->session->userdata('user')['email']; ?>" id="email">
                    <p class="error"><?= !empty($this->session->flashdata('errors')['email']) ? $this->session->flashdata('errors')['email'] : ''; ?></p>
                </p>
                <p>
                    <label for="first-name">First Name:</label>
                    <input type="text" name="first_name" value="<?= isset($this->session->flashdata('values')['first_name']) ? $this->session->flashdata('values')['first_name'] : $this->session->userdata('user')['first_name']; ?>" id="first-name"> 
                    <p class="error"><?= !empty($this->session->flashdata('errors')['first_name']) ? $this->session->flashdata('errors')['first_name'] : ''; ?></p>
                </p>
                <p>
                    <label for="last-name">Last Name:</label>
                    <input type="text" name="last_name" value="<?= isset($this->session->flashdata('values')['last_name']) ? $this->session->flashdata('values')['last_name'] : $this->session->userdata('user')['last_name']; ?>" id="last-name">
                    <p class="error"><?= !empty($this->session->flashdata('errors')['last_name']) ? $this->session->flashdata('errors')['last_name'] : ''; ?></p>
                </p>

                <input type="submit" value="Save">
            </form>
        </fieldset><!--
     --><fieldset class="user-password">
<?php
    if(!empty($this->session->flashdata('success')['password']))
    {
?>
            <p class="success"><?= $this->session->flashdata('success')['password']; ?></p>
<?php
    }
?>
            <legend>Change Password</legend>
            <form action="/edit/password/validate" method="post">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                
                <p>
                    <label for="old-password">Old Password:</label>
                    <input type="password" name="old_password" value="<?= !empty($this->session->flashdata('values')['old_password']) ? $this->session->flashdata('values')['old_password'] : ''; ?>" id="old-password">
                    <p class="error"><?= !empty($this->session->flashdata('errors')['old_password']) ? $this->session->flashdata('errors')['old_password'] : ''; ?></p>
                </p>
                <p>
                    <label for="new-password">New Password:</label>
                    <input type="password" name="new_password" value="<?= !empty($this->session->flashdata('values')['new_password']) ? $this->session->flashdata('values')['new_password'] : ''; ?>" id="new-password"> 
                    <p class="error"><?= !empty($this->session->flashdata('errors')['new_password']) ? $this->session->flashdata('errors')['new_password'] : ''; ?></p>
                </p>
                <p>
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" name="confirm_password" value="<?= !empty($this->session->flashdata('values')['confirm_password']) ? $this->session->flashdata('values')['confirm_password'] : ''; ?>" id="confirm-password">
                    <p class="error"><?= !empty($this->session->flashdata('errors')['confirm_password']) ? $this->session->flashdata('errors')['confirm_password'] : ''; ?></p>
                </p>

                <input type="submit" value="Save">
            </form>
        </fieldset>
    </div>
</body>
</html>