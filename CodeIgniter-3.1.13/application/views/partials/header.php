<nav>
    <h1>Village88 Merchandise</h1>
<?php
    $dashboard_class = "";   
    $profile_class = "";
    if(current_url() === base_url() . 'dashboard' || current_url() === base_url() . 'dashboard/admin')
    {
        $dashboard_class = "link-highlight";   
        $profile_class = "";
    }
    else if(current_url() === base_url() . 'users/edit')
    {
        $dashboard_class = "";   
        $profile_class = "link-highlight";
    }

    if(current_url() === base_url() . 'signin' || current_url() === base_url())
    {
?>
    <a href="register">Register</a>
<?php
    }
    else if(current_url() === base_url() . 'register')
    {
?>
    <a href="signin">Login</a>
<?php
    }
    else
    {
?>
    <a href="/dashboards" id="dashboard" class="<?= $dashboard_class; ?>">Dashboard</a>
    <a href="/users/edit" id="profile" class="<?= $profile_class; ?>">Profile</a>
    <a href="/signout">Logout</a>
<?php   
    }
?>    
</nav>