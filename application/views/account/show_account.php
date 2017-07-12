<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<h3><?php echo ($account ->acc_name_ll?$account ->acc_name_ll:$account ->acc_name); ?></h3>
<table border="1px">
    <tr>
        <td>
            <?php if($account ->mobile_number1 or $account ->mobile_number2){ ?><span>मोबाइल नo :- <?php echo $account ->mobile_number1?$account ->mobile_number1:$account ->mobile_number2; ?></span><?php } ?>
            <hr/>
            <span>पता :- <?php echo $account->acc_area.", ".($account ->acc_address1?$account ->acc_address1:$account ->acc_city); ?></span>
        </td>
        
    </tr>
</table>