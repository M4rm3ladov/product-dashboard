<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet/less" href="/assets/stylesheet/normalize.less">
    <link rel="stylesheet/less" href="/assets/stylesheet/users.less">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/less.js/4.1.3/less.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="/assets/javascript/register_validation.js"></script>
    <title>Register Page</title>
</head>
<body>
    <?php $this->load->view('partials/header'); ?>
    <form action="register/validate" method="post">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
        <h1>Register</h1>

        <input type="email" name="email" value="<?= isset($this->session->flashdata('values')['email']) ? $this->session->flashdata('values')['email'] : '';?>" placeholder="Email" id="email">
        <p class="error"><?= isset($this->session->flashdata('errors')['email']) ? $this->session->flashdata('errors')['email'] : ''; ?></p>
        
        <input type="text" name="first_name" value="<?= isset($this->session->flashdata('values')['first_name']) ? $this->session->flashdata('values')['first_name'] : '';?>" placeholder="First Name" id="first-name">
        <p class="error"><?= isset($this->session->flashdata('errors')['first_name']) ? $this->session->flashdata('errors')['first_name'] : ''; ?></p>
        
        <input type="text" name="last_name" value="<?= isset($this->session->flashdata('values')['last_name']) ? $this->session->flashdata('values')['last_name'] : '';?>" placeholder="Last Name" id="last-name">
        <p class="error"><?= isset($this->session->flashdata('errors')['last_name']) ? $this->session->flashdata('errors')['last_name'] : ''; ?></p>
        
        <input type="password" name="password" value="<?= isset($this->session->flashdata('values')['password']) ? $this->session->flashdata('values')['password'] : '';?>" placeholder="Password" id="password">
        <p class="error"><?= isset($this->session->flashdata('errors')['password']) ? $this->session->flashdata('errors')['password'] : ''; ?></p>

        <input type="password" name="confirm_password" value="<?= isset($this->session->flashdata('values')['confirm_password']) ? $this->session->flashdata('values')['confirm_password'] : '';?>" placeholder="Confirm Password" id="confirm-password"> 
        <p class="error"><?= isset($this->session->flashdata('errors')['confirm_password']) ? $this->session->flashdata('errors')['confirm_password'] : ''; ?></p>
        
        <input type="submit" value="Register">
        <p>Already have an account? <a href="signin">Login</a></p>
    </form>
</body>
</html>