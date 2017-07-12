<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $this->load->view("header_common.php");
?>
<body>
<?php $this->load->view("admin_menu.php"); ?>
<div class="container" style="margin-top: 51px;">
    <h3><?php echo $message; ?></h3>
</div>
</body>
</html>