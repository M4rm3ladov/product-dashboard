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
    <script src="/assets/javascript/signin_validation.js"></script>
    <title>Login Page</title>
</head>
<body>
    <?php $this->load->view('partials/header'); ?>
    <form action="signin/validate" method="post">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
        <h1>Login</h1>

        <input type="email" name="email" value="<?= !empty($this->session->flashdata('values')['email']) ? $this->session->flashdata('values')['email'] : '';?>" placeholder="Email" id="email">
        <p class="error"><?= !empty($this->session->flashdata('errors')['email']) ? $this->session->flashdata('errors')['email'] : ''; ?></p>
        
        <input type="password" name="password" value="" placeholder="Password" id="password">
        <p class="error"><?= !empty($this->session->flashdata('errors')['password']) ? $this->session->flashdata('errors')['password'] : ''; ?></p> 
        
        <input type="submit" value="Login">
        <p>Don't have an account? <a href="register"> Register</a></p>
    </form>
</body>
</html>