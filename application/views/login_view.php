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
        <div align="center"><h1>Sabzi Mandi</h1>
        <h3>Management System</h3>
        <h4>by <strong>KWIK aka Fun n Enjoy soft Private Ltd.</strong></h4>
        <?php /*<a href="<?php echo base_url(); ?>operator/"> <button class="btn btn-primary" type="submit">Customer Sign in</button></a>*/ ?>
        </div>
        
        <?php echo validation_errors("<div class=\"error\">","</div>"); ?>
        <form action="<?php echo base_url(); ?>verifylogin" method="post" class="form-signin">
            <h2 class="form-signin-heading">Operator Log in</h2>
            <select class="form-control" name="firm" >
                <option>
                    Choose Firm / Entity
                </option>
                <?php foreach($firms as $firm){ ?>
                <option value="<?php echo $firm->firm_id; ?>">
                    <?php echo $firm->firm_name; ?>
                </option>
                <?php } ?>
            </select>
            <label for="patientusername" class="sr-only">Name</label>
            <input type="text" class="form-control" id="username" name="username" required placeholder="Username / ID"/>
            <label for="password" class="sr-only">Pass Code</label>
            <input type="password" class="form-control" id="passowrd" name="password" required placeholder="Password"/>
            <select name="lang" class="input-sm input-lg input-group-lg" style="vertical-align:bottom;padding-left:17px;padding-right:17px;"><option value="english">English</option><option value="hindi">Hindi(हिंदी)</option></select>
            <button class="btn btn-lg btn-primary" style="padding-left:45px;padding-right:45px;" type="submit">Sign in</button>
            <?php if (isset($patientloginerror)) { ?>
                <label>Invalid username or password</label>
            <?php } ?>
        </form>
    </div>
<script>
    /*
    $.ajax({url: base_url + 'api/operators', success: function (result) {
            var names = JSON.parse(result);
            console.log(names.patients);
            $("#patientusername").autocomplete({
                source: names.patients
            });
        }});*/
</script>
</body>
</html>
