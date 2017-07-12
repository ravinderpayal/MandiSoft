<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $this->load->view("header_common.php");
?>
<body>
<?php $this->load->view("admin_menu.php"); ?>
<div class="container" style="margin-top: 51px;">
    <h3><?php echo $this->lang->line('ays_ywtd'); ?></h3>
    <a href="<?php echo base_url(); ?>sale/delete/<?php echo $sale_id; ?>"><button class="btn btn-lg btn-primary"><?php echo $this->lang->line('yes'); ?></button></a> <?php echo $this->lang->line('or'); ?> <a href="javascript:history.back()"><button class="btn btn-lg btn-primary"><?php echo $this->lang->line('no'); ?></button></a>
</div>
</body>
</html>