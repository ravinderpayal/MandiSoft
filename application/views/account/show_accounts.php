<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
    td{
        padding:6px;
        font-size:22px;
    }
</style>
<table border="1px">
                <?php
                    if (count($accounts)){
                ?>
                <th>Ledger Number</th>
                <th>Account Name</th> 
                <th>Closing Balance</th>
                <th>Crate Balance</th>
                <th>Area</th>
               <!-- <th>City</th>-->
                <th class="no-print">Last Activity</th>
                <th class="no-print"></th>
            </tr>
            <?php
                }
            ?>
            <?php foreach ($accounts as $value) { ?>
                <tr>
                    <td style="text-align: center"><?php
                            echo $value->ledger_number;
                        ?></td>
                    <td style="text-align: center"><?php
                            echo $value->acc_name;
                        ?></td> 
                    <td style="text-align:center;background:#00f0ff;color:#777;">
                        ₹<?php
                    echo ($value -> account_balance<0)?(-1*$value -> account_balance)." Dr":$value -> account_balance." Cr";
                    ?>
                    </td>
                    <td  style="text-align:center;background:#0f0;color:#777;"><?php
                            echo $value->crate_balance;
                        ?></td>
                    <td  style="text-align:center;background:#0f0;color:#777;"><?php
                            echo $value->acc_area.", ".$value->acc_city;
                        ?></td>
                    <!--<td  style="text-align:center;background:#0f0;color:#777;"><?php
                           // echo $value->acc_city;
                        ?></td>-->
                    <td class="no-print" style="text-align: center;background:#f00;color:#eee;"><?php
                            echo date("d/m/Y",strtotime($value->datetime));
                        ?></td> 
                    <td style="text-align: center" class="no-print"><a href="<?php echo base_url(); ?>ledger/view/<?php echo $value->ledger_number; ?>">View Detail</a></td>
                </tr>
            <?php } ?> 
</table>