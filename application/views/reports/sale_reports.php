<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h3 align="center"><?php echo $this->lang->line('sales_report'); ?> <i class="no-print"><?php if(!isset($view_next)){ ?>(<a href="<?php echo base_url(); ?>view/sales">View All</a>)<?php } else{ ?>(<a href="<?php echo $view_next; ?>">View Next</a>)<?php } ?></i></h3>
<table border="2px" align="center">
            <tr>
                <th colspan="7"style="text-align: center;">
                    <?php $this->load->view("slip/heading"); ?>
                </th>
            </tr>
            <tr>
                <th><?php echo ($this->lang->line('account_name')); ?></th>
                <th><?php echo ($this->lang->line('sold_on')); ?></th> 
                <th><?php echo ($this->lang->line('quantity')); ?></th>
                <th><?php echo ($this->lang->line('rate')); ?></th>
                <th><?php echo ($this->lang->line('total_amount')); ?></th>
                <th><?php echo $this->lang->line('closing_balance'); ?></th>
              <!--  <th>Amount Received</th> -->
              <!--  <th>Amount Pending</th> -->
                <th class="no-print"></th>
            </tr>
            <?php foreach ($sales as $value) { ?>
                <tr align="center">
                    <td style="text-align: center"><a href="<?php echo base_url(); ?>ledger/view/<?php echo $value->ledger_number; ?>"><?php
                            echo $value->acc_name;
                            ?></a><span class="only_Printable"><?php
                            echo $value->acc_name;
                            ?></span></td>
                    <td style="text-align: center"><?php
                    $datetime = strtotime($value->datetime);
                    $date     = strtotime($value->sale_date);
                            echo date("d/m/Y",$date?$date:$datetime);
                        ?></td>
                    <td>
                        <?php
                            echo $value->quantity;
                            echo $value->qnt_sign;
                            echo "($value->item_lot की भर्ती)";
                        ?>
                    </td>
                    <td>
                        ₹<?php echo $value->rate; ?>
                    </td>
                    <td style="text-align:center;background:#00f0ff;color:#777;font-weight:bolder;font-size:20px;"><?php
                            $total_amount = ( $value->quantity * $value->rate) - $value->rebate;
                            echo "₹".$total_amount;
                        ?></td>
                    <td>
                    <b>₹<?php echo $value ->account_balance<0?(-1*$value ->account_balance)."Dr":$value ->account_balance."Cr"; ?></b>
                    </td>
                    <?php /*
                    <td  style="text-align:center;background:#0f0;color:#777;font-weight:bolder;font-size:20px;"><?php
                            echo $value->amount_received;
                        ?></td> */ ?>
                    <?php
                    /*
                     * 
                    <td style="text-align: center;background:#f00;color:#eee; font-weight:bolder;"><?php
                            echo $total_amount - $value->amount_received;
                        ?></td> 
                     * 
                     */ ?>
                    <td class="no-print"><!--<a href="<?php echo base_url(); ?>sells/view/<?php echo $value->sale_id; ?>">View Detail</a> |--> <a href="<?php echo base_url(); ?>reports/edit/<?php echo $value->sale_id; ?>">Edit</a> | <a href="<?php echo base_url(); ?>sale/askDelete/<?php echo $value->sale_id; ?>">Delete</a></td>
                </tr>
            <?php } ?> 
            </table>