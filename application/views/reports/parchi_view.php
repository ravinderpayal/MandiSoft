<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view("header_common.php"); ?>
    <body>
        <style>
            th,td{padding:10px;}
        </style>
     <?php $this->load->view("admin_menu.php"); ?>
        <div class="container">
            <?php
            $this->load->view("reports/parchi");
            ?>           
       </div>
    </body>
</html>