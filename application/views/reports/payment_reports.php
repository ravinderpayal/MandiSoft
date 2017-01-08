<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h3 align="center"><?php echo $this->lang->line('payment_report'); ?> <i class="no-print"><?php if(!isset($view_next)){ ?>(<a href="<?php echo base_url(); ?>view/payments">View All</a>)<?php } else{ ?>(<a href="<?php echo $view_next; ?>">View Next</a>)<?php } ?></i></h3>
<table border="2px" align="center">
            <tr>
                <th colspan="6"style="text-align: center;">
                    <?php $this->load->view("slip/heading"); ?>
                </th>
            </tr>
            <tr>
                <th><?php echo ($this->lang->line('account_name')); ?></th>
                <th><?php echo ($this->lang->line('date')); ?></th> 
                <th><?php echo ($this->lang->line('amount')); ?></th>
                <th><?php echo ($this->lang->line('rebate')); ?></th>
                <th><?php echo ($this->lang->line('balance_cleared')); ?></th>
                <th><?php echo ($this->lang->line('closing_balance')); ?></th>
              <!--  <th>Amount Received</th> -->
              <!--  <th>Amount Pending</th> -->
                <th class="no-print"></th>
            </tr>
            <?php foreach ($payments as $value) { ?>
                <tr align="center">
                    <td style="text-align: center"><a href="<?php echo base_url(); ?>ledger/view/<?php echo $value->ledger_number; ?>"><?php
                            echo $value->acc_name;
                            ?></a><span class="only_Printable"><?php
                            echo $value->acc_name;
                            ?></span></td>
                    <td style="text-align: center"><?php
                    $datetime = strtotime($value->datetime);
                    $date     = strtotime($value->make_date);
                            echo date("d/m/Y",$date?$date:$datetime);
                        ?></td>
                    <td>
                        <?php
                            echo $value->amount;
                        ?>
                    </td>
                    <td>
                        ₹<?php echo $value->rebate; ?>
                    </td>
                    <td style="text-align:center;"><?php
                            echo "₹".($value->amount+$value->rebate);
                        ?></td>
                    <td>
                    <b>₹<?php echo $value ->account_balance<0?(-1*$value ->account_balance)."Dr":$value ->account_balance."Cr"; ?></b>
                    </td>
                    <td class="no-print"><!--<a href="<?php echo base_url(); ?>sells/view/<?php echo $value->payment_id; ?>">View Detail</a> |--> <a href="<?php echo base_url(); ?>payments/edit/<?php echo $value->payment_id; ?>">Edit</a> | <a href="<?php echo base_url(); ?>payments/askDelete/<?php echo $value->payment_id; ?>">Delete</a></td>
                </tr>
            <?php } ?> 
            </table>