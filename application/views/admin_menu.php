<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<nav class="navbar navbar-default no-print">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo $this->lang->line('mandisoft'); ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a  href="<?php echo base_url() ?>ledger/"><?php echo ($this->lang->line('ledger')); ?></a></li>
                <li><a href="<?php echo base_url() ?>sale/"><?php echo $this->lang->line('new_sell'); ?></a></li>
                <li><a href="<?php echo base_url() ?>payments/collect"><?php echo $this->lang->line('payin'); ?></a></li>
                <li><a href="<?php echo base_url() ?>accounts/"><?php echo $this->lang->line('accounts'); ?></a></li>
                <li><a href="<?php echo base_url() ?>accounts/add"><?php echo $this->lang->line('add_account'); ?></a></li>
                <li><a href="<?php echo base_url() ?>payments"><?php echo $this->lang->line('transactions'); ?></a></li>
                <li><a href="<?php echo base_url() ?>parchi/"><?php echo $this->lang->line('datewise_sales'); ?></a></li>
                <li><a href="<?php echo base_url() ?>purchase/"><?php echo $this->lang->line('new_purchase'); ?></a></li>
                <li><a href="<?php echo base_url() ?>admins/add"><?php echo $this->lang->line('add_operator'); ?></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url(); ?>logout"><?php echo $this->lang->line('logout'); ?></a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>