<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $this->load->view("header_common.php");
?>
<body>
<style>
    #collect_payment{width:100%;}
    #collect_payment td{width:25%;padding:5px;}
</style>
<?php $this->load->view("admin_menu.php"); ?>
<div class="container" style="margin-top:51px;">
            <?php 
            if(isset($message))echo "<div class=\"message\">$message</div>";
            echo validation_errors("<div class=\"error\">","</div>");
            ?>
    <h3>Make Payment</h3>

    <form action="<?php echo base_url(); ?>payments/make" method="POST">
    <table id="collect_payment" border="1px">
        <tr>
            <td>
                <label>Account Name<br/><input id="acc_name_visible" /></label>
                <label>Ledger Number<br /><input type="number" id="acc_ledger_number" name="ledger_number" /></label>
                <label>Account Number<br /><input type="number" id="acc_number" name="acc_num" /></label>
                <div id="acc_error" align="left"></div>
            </td>
            <td>
                <label>Amount<br /><input type="number" name="amount" /></label>
                <label>Any Rebate<br /><input type="number" value="0" name="rebate" /></label>
                <label>Related Sell(Sr. No.)<br /><input type="number" name="related_sell" /></label>
            </td>
            <td>
                <label>
                    Payment Date<br/>
                    <input type="date" name="date" value="<?php echo set_value("date",date("Y-m-d",time())); ?>" />
                </label>
                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Collect" />
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>Note:-</b>Payment through CHEQUE will be added soon
            </td>      
        </tr>
    </table>
</form>
</div>
<script>
            var account_array={},ledger_array={};
    $.ajax({url: base_url + 'api/customers', success: function (result) {
            var names = JSON.parse(result);
            $.each(names,function(){
                        window.account_array[this.value] ={
                            name:this.label,
                            ledger_num:this.ledger_num
                        };
                        window.ledger_array[this.ledger_num] ={
                            name:this.label,
                            acc_num:this.value
                        };
                    }
            );
            $("#acc_name_visible").autocomplete({
                  minLength: 0,
                  source: names,
                  focus: function( event, ui ) {
                    $( "#new_sale_account_id" ).val( ui.item.value );
                    return false;
                  },
                  select: function( event, ui ) {
                    $( "#new_sale_account_id_visible" ).val( ui.item.label );
                    $( "#acc_number" ).val( ui.item.value );
                    $("#acc_ledger_number").val(ui.item.ledger_num );
                    /*$( "#project-description" ).html( ui.item.desc );*/
                    return false;
                  }});
            
            }});
    $("#acc_number").change(function(){
        updateByAccountNum(this.value);
    });
    $("#acc_number").keyup(function(){
        updateByAccountNum(this.value);
    });
    $("#acc_ledger_number").change(function(){
        updateByLedgerNum(this.value);
    });
    $("#acc_ledger_number").keyup(function(){
        updateByLedgerNum(this.value);
    });
    $("#new_sale_rate").change(function(){
        updateNetAmount();
    });
    $("#new_sale_rate").keyup(function(){
        updateNetAmount();
    });
    $("#new_sale_rebate").change(function(){
        updateNetAmount();
    });
    $("#new_sale_rebate").keyup(function(){
        updateNetAmount();
    });
    function updateByAccountNum(a){
        if(account_array[a]){
            setAccount(a,account_array[a].ledger_num,account_array[a].name)
        }
        else{
            acc404(1);
        }
    }
    function updateByLedgerNum(a){
        if(ledger_array[a]){
            setAccount(ledger_array[a].acc_num,a,ledger_array[a].name)
        }
        else{
            acc404(2);
        }
    }
    function setAccount(a,b,c){
            $("#acc_error").html("");
            $("#acc_number").val( a );
            $("#acc_ledger_number").val( b );
            $("#acc_name_visible").val( c );        
    }
    function acc404(a){
            $("#acc_error").html("<div class='error'>Account Doesn't Exist</div>");
            $("#acc_name_visible").val('');
            if(a==1)$("#acc_ledger_number").val('');
            else $("#acc_number").val('');
    }
    function updateNetAmount(){
        var qnt = parseInt($("#new_sale_qnt").val());
        var rate = parseInt($("#new_sale_rate").val());
        var rebate = parseInt($("#new_sale_rebate").val()); 
        qnt = qnt?qnt:0;
        rate = rate?rate:0;
        rebate = rebate?rebate:0;
        var total = qnt * rate;
        if(rebate>=total)rebate=total;
        $("#new_sale_rebate").val(rebate);
       $("#new_sale_total").val(total);
       $("#new_sale_net_total").val(total - rebate);
    }
</script>
</body>
</html>