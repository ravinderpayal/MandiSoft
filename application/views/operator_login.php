<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view("header_common.php"); ?>
<style>
    body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #eee;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }
    .form-signin .checkbox {
        font-weight: normal;
    }
    .form-signin .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
<body>
    <div class="container">
                <a href="<?php echo base_url(); ?>"> <button class="btn btn-primary" type="submit">Patient Sign in</button></a>
        </div>
        <form action="<?php echo base_url(); ?>verifylogin/check_database" method="post" class="form-signin">
            <h2 class="form-signin-heading">Operator sign in</h2>
            <label for="username" class="sr-only">Username</label>
            <input type="text" class="form-control" autocomplete="new-password" id="username" name="user[username]" required placeholder="Username"/>
            <br/>
            <label for="password" class="sr-only">Password</label>
            <input type="password" class="form-control" autocomplete="new-password"  id="passowrd" name="user[password]" required placeholder="Password"/>
            <br/>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <?php if (isset($adminloginerror)) { ?>
                <label>Invalid username or password</label>
            <?php } ?>
        </form>
    </div>
</body>
<script src="<?php echo $this->config->item('base_directory'); ?>media/jquery-ui/jquery-ui.js"></script>
</html>
