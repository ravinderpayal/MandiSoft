<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
if(!isset($multiple)){
?>
<style>
        td,th{
        padding:10px 15px 10px 15px;
    }
    th{
        font-size:16px;
        text-align:center;
    }
    td{vertical-align: top;}
    tr.total{
        text-align: center;
        font-weight: 700;
        font-size: 20px;
    }
      table ,tr, th , td {
        border-style: dashed;
    }
    b{
       font-size: 125%;
    }
    span{
        font-size: 120%;
    }
    small{
        font-size: 100%;
    }
    .footer td{
        padding:25px;
        border: none;
    }
</style>
<script>
    function _print (){
        window.print();
    };
</script>
<a href="javascript:_print();" class="no-print">Print Parchi</a>
<?php
}
?>
<table id="LEDGER_TABLE" align="center" border="1px" cellspacing="0">
<?php
if(!isset($multiple)){
?>
    <tr>
        <td colspan="4" align="center">
            <?php $this->load->view("slip/heading"); ?>
        </td>
    </tr>
    <?php
    }
    ?>
    <tr>
        <td colspan="2">
            <span>दिनांक :- <?php echo date("d/m/Y",strtotime($payment->make_date)?strtotime($payment->make_date):strtotime($payment->datetime)); ?></span><hr/>
            <span>क्रo :-<?php echo $payment->payment_id; ?></span>            
        </td>
        <td colspan="2">
            <span>लेजर सँo :- <?php echo $payment ->ledger_number; ?></span><i>(Closing Balance:₹<?php echo $payment ->account_balance<0?(-1*$payment ->account_balance)."Dr":$payment ->account_balance."Cr"; ?>)</i>
            <hr />
            <span>नाम :- <?php echo $payment ->acc_name_ll?$payment ->acc_name_ll:$payment ->acc_name; ?></span>
        </td>
    </tr>
    <tr class="heading" align="center">
        <th<?php if(!$payment->rebate){ ?> colspan="2"<?php } ?>>Amount Received</th><?php if($payment->rebate){ ?><th>Rebate</th><?php } ?><th colspan="2">Total Amount<br />(Total Balance Cleared)</th>
            </tr>
            <tr align="center">
                <td<?php if(!$payment->rebate){ ?> colspan="2"<?php } ?>>
                    <?php echo $payment->amount; ?>
                </td>
                <?php if($payment->rebate){ ?>
                <td><?php
                        echo $payment->rebate;
                    ?>
                </td>
                <?php } ?>
                <td colspan="2">
                    <b>₹<?php
                        echo ($payment->rebate?"$payment->amount + $payment->rebate = ":"").($payment->amount + $payment->rebate);
                        ?></b>                  
                </td>
            </tr>
            <tr class="footer">
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <?php $this->load->view("slip/footer"); ?>
                </td>
            </tr>
</table>
<br />
<br />
<div align="center">पर्ची MANDISOFT द्वारा बनाई गई|<?php echo date("d/m/Y",time()); ?></div>