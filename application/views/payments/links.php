<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<style type="text/css">
    .link_container{
        width:80%;
        margin: auto;
    }
    .link_container .LINK{
        width:50%;
        display:inline-block;
        height: 200px;
        vertical-align: middle;
    }
    .link_container .LINK{
        border-width:1px 1px 1px 0px;
        border:solid #000;
    }
    .link_container .LINK a{
        vertical-align: middle;
        display: block;
    }
    
</style>
<div class="link_container">
    <div class="LINK">
        <a href="<?php echo base_url(); ?>payments/collect">Collect</a>
    </div><div class="LINK">
        <a href="<?php echo base_url(); ?>payments/pay">Pay</a>
    </div><div class="LINK">
        <a href="<?php echo base_url(); ?>payments/givesalary">Give Salary</a>
    </div><div class="LINK">
        <a href="">Bank Transfer</a>
    </div><div class="LINK">
        <a href="">Give Salary</a>
    </div><div class="LINK">
        <a href="">Best Account</a>
    </div>
</div>