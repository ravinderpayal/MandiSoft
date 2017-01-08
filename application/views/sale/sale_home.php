<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $this->load->view("header_common.php");
?>
<body>
<?php $this->load->view("admin_menu.php"); ?>
<div class="container" style="margin-top: 51px;">
<?php
    $this->load->view('sale/sale_nav');
    $this->load->view('sale/new_sell');
?>
</div>
</body>
</html>