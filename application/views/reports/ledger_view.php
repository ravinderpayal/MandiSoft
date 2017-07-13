<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view("header_common.php"); ?>
    <body>
        <style>
            th{padding:5px;}
        </style>
     <?php $this->load->view("admin_menu.php"); ?>
        <div class="container">
            <?php
            $this->load->view("reports/ledger");
            ?>           
       </div>
    </body>
</html>