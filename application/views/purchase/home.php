<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $this->load->view("header_common.php");
?>
<body>
<?php $this->load->view("admin_menu.php"); ?>
<div class="container" style="margin-top: 51px;">
<?php
    $this->load->view('purchase/new_purchase');
?>
</div>
</body>
</html>