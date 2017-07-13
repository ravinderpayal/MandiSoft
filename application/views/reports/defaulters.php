<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h3 align="center"><?php echo $this->lang->line('defaulter'); ?> <i class="no-print"><?php if(!isset($view_next)){ ?>(<a href="<?php echo base_url(); ?>view/defaulters">View All</a>)<?php } else{ ?>(<a href="<?php echo $view_next; ?>">View Next</a>)<?php } ?></i></h3>
<table border="2px" align="center">
            <tr>
                <th>Ledger Number</th>
                <th>Account Name</th> 
                <th>Balance</th>
                <th>Total Sale</th>
                <th>Last Activity</th>
                <th></th>
            </tr>
            <?php foreach ($defaulters as $value) { ?>
                <tr>
                    <td style="text-align: center"><a href="<?php echo base_url(); ?>ledger/view/<?php echo $value->ledger_number; ?>"><?php
                            echo $value->ledger_number;
                        ?></a></td>
                    <td style="text-align: center"><?php
                            echo $value->acc_name;
                        ?></td> 
                    <td style="text-align:center;background:#00f0ff;color:#777;font-weight:bolder;font-size:20px;"><?php
                            echo $value->account_balance;
                        ?></td>
                    <td  style="text-align:center;background:#0f0;color:#777;font-weight:bolder;font-size:20px;"><?php
                            echo $value->total_sale;
                        ?></td>
                    <td style="text-align: center;background:#f00;color:#eee; font-weight:bolder;"><?php
                            echo date("d/m/Y",strtotime($value->datetime));
                        ?></td> 
                    <td style="text-align: center"><a href="<?php echo base_url(); ?>accounts/atd/<?php echo $value->acc_id; ?>">Add to Defaulter</a> | <a href="<?php echo base_url(); ?>ledger/view/<?php echo $value->ledger_number; ?>">View Detail</a></td>
                </tr>
            <?php } ?> 
</table>