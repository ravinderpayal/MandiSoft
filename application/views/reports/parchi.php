<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!isset($not_first)){
?>
<style>
    table.parchiINLINE{
        width:calc(50% - 8px); display: inline-block;
        min-width:300px;
        border: 0;
        margin:5px;
    }
    table.parchiINLINE:nth-of-type(odd){
        margin-left:0;
    }
    table.parchiINLINE:nth-of-type(right){
        margin-right:0;
    }
    table.parchiBLOCK{
        width:100%; display: inline-block;
        min-width:550px;
        border: 0;
    }
    
    table.parchiINLINE .col25{
        width:25%;
    }
    table.parchiINLINE .col30{
        width:30%;
    }
    table.parchiINLINE .col20{
        width:20%;
    }
    table.parchiINLINE .col50{
        width:50%;
    }
    
    td,th{
        padding:5px;
        width:20%;
    }
    th{
        font-size:15px;
        text-align:center;
    }
    th h1{
        font-size:25px !important;
    }
    td{vertical-align: top;}
    tr.total{
        text-align: center;
        font-weight: 700;
        font-size: 20px;
    }
      table ,tr, th , td {
        border-style:dashed;
        box-sizing:border-box;
    }
    b{
       font-size: 115%;
    }
    span{
    }
    small{
        font-size: 85%;
    }
    .footer td{
        padding:10px;
        border: none;
    }
</style>
<script>
    function _print (){
        window.print();
    };
</script>
<a href="javascript:_print();" class="no-print">Print Parchi</a><br />
<?php
}
/*if(!isset($no_top_head)){
?>
<table class="parchiBLOCK">
    <tr>
        <td colspan="4" align="center">
            <?php
                $this->load->view("slip/heading");
            ?>
        </td>
    </tr>
</table>
<?php
}
?>*/ ?><table align="center" border="1px" cellspacing="0" class="<?php echo isset($multiple)?"parchiINLINE":"parchiBLOCK"; ?>">
<?php
if(!isset($multiple) or !isset($no_head)){
?>
    <tr>
        <td colspan="4" align="center">
            <?php
                $this->load->view("slip/heading");
            ?>
        </td>
    </tr>
    <?php
    }
    ?>
    <tr>
        <td class="col50" colspan="2">
            <span><?php PrintLangLabel('date',$this); ?> :- <?php echo date("d/m/Y",strtotime($sale->sale_date)?strtotime($sale->sale_date):strtotime($sale->datetime)); ?></span><hr/>
            <span><?php PrintLangLabel('number',$this); ?> :-<?php echo $sale->sale_id; ?></span>            
        </td>
        <td class="col50" colspan="2">
            <span><?php PrintLangLabel('ledger_number',$this); ?> :- <?php echo $sale ->ledger_number; ?></span>
            <hr />
            <span><?php PrintLangLabel('name',$this); ?> :- <?php echo $sale ->acc_name_ll?$sale ->acc_name_ll:$sale ->acc_name; ?></span>
        </td>
    </tr>
    <tr class="heading" align="center">
        <th><?php PrintLangLabel('quantity',$this); ?> </th><th><?php PrintLangLabel('rate',$this); ?> </th><?php if($sale->rebate){ ?><th><?php PrintLangLabel('rebate',$this); ?> </th><?php } ?><th <?php echo $sale->rebate?"":"colspan=\"2\""; ?>><?php PrintLangLabel('total_amount',$this); ?> </th>
            </tr>
            <tr align="center">
                <td>
                    <?php
                    $quantity_types=array("","Crt","Kg","Dzn");
                    echo $sale->quantity.$quantity_types[$sale->quantity_type]."<br />".($sale->quantity_type==1?"($sale->item_lot की भर्ती)":""); ?>
                </td>
                <td>
                    <?php echo $sale->rate; ?>
                </td>
                <?php if($sale->rebate){ ?>
                <td>
                    <b><?php
                        echo "₹".$sale->rebate;
                    ?></b>
                </td>
                <?php } ?>
                <td<?php if(!$sale->rebate){ ?> colspan="2"<?php } ?>>
                    <?php
                    $total = $sale->quantity * $sale->rate;
                        /*echo "$total - $sale->rebate = ".($total - $sale->rebate);*/
                        echo ($sale->rebate?"$total + $sale->rebate = ":"").($total + $sale->rebate);
                    ?>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2"><b>Closing Balance:</b></td>
                <td align="right" colspan="2">
                    <b>₹<?php echo $sale ->account_balance<0?(-1*$sale ->account_balance)."Dr":$sale ->account_balance."Cr"; ?></b>
                </td>
            </tr>
            <?php
                if(!isset($no_stamp)){
            ?>
            <tr class="footer">
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <?php $this->load->view("slip/footer"); ?>
                </td>
            </tr>
            <?php
                }
            ?>
</table><?php
if(!isset($multiple)){
?>
<br />
<br />
<div align="center">पर्ची MANDISOFT द्वारा बनाई गई|<?php echo date("d/m/Y",time()); ?></div>
<?php
}