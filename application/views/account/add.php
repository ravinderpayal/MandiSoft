<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $this->load->view("header_common.php");
?>
<body>
<style>
    #new_account{width:100%;}
    #new_account td{width:25%;padding:5px;}
</style>
<?php $this->load->view("admin_menu.php"); ?>
<div class="container" style="margin-top:51px;">
            <?php 
            if(isset($message))echo "<div class=\"message\">$message</div>";
            echo validation_errors("<div class=\"error\">","</div>");
            ?>
    <h3>Add a new account</h3>
    <form action="<?php echo base_url(); ?>accounts/create" method="POST">
    <table id="new_account" border="1px">
        <tr>
            <td>
                <label>Account Number<br /><input type="number" disabled="" value="<?php echo $account_number; ?>" /></label>
            </td>
            <td>
                <label>Ledger Number<br /><input type="number" name="ledger_num" value='<?php echo set_value('ledger_num',$ledger_number); ?>' /></label>
                <label>
                    Last Activity Date<br/>
                    <input type="date" name="date" value="<?php echo set_value("date",date("Y-m-d",time())); ?>" />
                </label>
            </td>
            <td>
                <label>Account Name<br /><input type="text" name="acc_name" value="<?php echo set_value('acc_name'); ?>" /></label>
            </td>
            <td>
                <label>Account Name(Hindi)<br /><input type="text" name="acc_name_ll" value="<?php echo set_value('acc_name_ll'); ?>" /></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Account Group<br /><select name="acc_group" id="new_acc_group_selector"><?php
                        foreach ($account_groups as $group)
                        echo "<option value=\"".$group->group_id."\">".$group->group_name."</option>";
                    ?>
                    </select><script>document.getElementById("new_acc_group_selector").value="<?php echo set_value('acc_group',1); ?>";</script></label>
            </td>
            <td>
                <label>Opening Balance<br /><input type="number" name="acc_opening_balance" value="<?php echo set_value('acc_opening_balance'); ?>" /></label><select name="ob_dr" id="opng_bal_dir"><option value="debt">Debt(उधार)</option><option value="dpst">Deposit(जमा)</option></select>
                    <script>
                        document.getElementById("opng_bal_dir").value ="<?php echo set_value("ob_dr","debt"); ?>";
                    </script>

            </td>
            <td>
                <label>Mobile Number(1st)<br /><input type="tel" name="acc_mob_num1" value="<?php echo set_value('acc_mob_num1'); ?>" /></label>
            </td>
            <td>
                <label>Mobile Number(2nd)<br /><input type="tel" name="acc_mob_num2" value="<?php echo set_value('acc_mob_num2'); ?>" /></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Area<br /><input type="text" name="acc_area"  value="<?php echo set_value('acc_area'); ?>" /></label>
            </td>
            <td>
                <label>City<br /><input type="text" name="acc_city" value="<?php echo set_value('acc_city'); ?>" /></label>        
            </td>
            <td>
                <label>Address(1st)<br /><input type="text" name="acc_addrs1" value="<?php echo set_value('acc_addrs1'); ?>" /></label>
            </td>
            <td>
                <label>Address(2nd)<br /><input type="text" name="acc_addrs2" value="<?php echo set_value('acc_addrs2'); ?>" /></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>Related Account(1st)<br /><input type="text" name="related_acc_1" value="<?php echo set_value('related_acc_1'); ?>" /></label>
            </td>
            <td>
                <label>Related Account(2nd)<br /><input type="text" name="related_acc_2" value="<?php echo set_value('related_acc_2'); ?>" /></label>
            </td>
            <td>
                <label>Related Account(3rd)<br /><input type="text" name="related_acc_3" value="<?php echo set_value('related_acc_3'); ?>" /></label>
            </td>
            <td>
                <label>Crates<br /><input type="number" value="0" name="crates" value="<?php echo set_value('crates'); ?>" /></label>
                <select id="crate_dir" name="crt_dr">
                    <option value="debt"> 
                        Remaining( बकाया )
                    </option>
                    <option value="dpst"> 
                        Deposited( जमा )
                    </option>
                </select>
                <script>
                document.getElementById("crate_dir").value ="<?php echo set_value("crt_dr","debt"); ?>";
                </script>
            </td>
        </tr>
        <tr>
            <td>
                <input type="reset" class="btn btn-primary btn-block" value="Reset" />
            </td>
            <td></td>
            <td></td>
            <td>
                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Create" />
            </td>
        </tr>
    </table>
    </form>
</div>
</body>
</html>