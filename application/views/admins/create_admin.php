<?php $this->load->view("header_common.php"); ?>
<style>
    body {
        padding-top: 40px;
        padding-bottom: 40px;
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
    <?php $this->load->view("admin_menu.php"); ?>
    <div class="container" style="margin-top: 40px;">
        
        <form action="<?php echo base_url() ?>admins/create" method="post" class="form-signin">
            <h1>Add Admin</h1>
            <label for="username" class="sr-only" >Name:</label>
            <input type="text" id="username" class="form-control" autocomplete="off" value="" name="admin[username]" required placeholder="username"/>
            <br/>
            <label for="password" class="sr-only">Password:</label>
            <input type="password" id="password" class="form-control" name="admin[password]" value="" required placeholder="password" autocomplete="off" />
            <br/>
            <label for="email" class="sr-only">Email:</label>
            <input type="email"  id="passowrd" class="form-control" name="admin[email]" value="" placeholder="email" autocomplete="off"/>
            <br/>
            <label for="phone" class="sr-only">Phone:</label>
            <input type="tel" id="phone" class="form-control" name="admin[phone]" value="" placeholder="phone" autocomplete="off"/>
            <br/>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Add</button>
            <?php if(isset($error)){ ?>
            <label><?php echo $error; ?></label>   
             <?php } ?>
        </form>
    </div>
</body>
</html>