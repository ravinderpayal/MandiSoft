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
    <h3>Collect Payment</h3>

    <form action="<?php echo base_url(); ?>payments/save_collection" method="POST">
    <table id="collect_payment" border="1px">
        <tr>
            <td>
                <label>Account Name<input type="text" id="new_sale_account_id_visible" name="acc_name"  value='<?php echo set_value('acc_name',''); ?>' style="width:300px" required="" /></label>
                <label>Ledger Number<input type="number" name="ledger_number" id="new_sale_account_ldgr" style="width:300px"  value="<?php echo set_value("ledger_num"); ?>" autofocus="true" /></label>
                <label>Account Balance.<input disabled="" id="new_sale_account_balance" style="width:300px"  /></label><input type="hidden"id="new_sale_account_id"  name="acc_num" value="<?php echo set_value("acc_num"); ?>" />
                <div id="acc_error" align="left"></div>
            </td>
            <td>
                <label>Amount<br /><input type="number" name="amount" /></label>
                <label>Any Rebate<br /><input type="number" value="0" name="rebate" /></label>
                <label>Related Sell(Sr. No.)<br /><input type="number" name="related_sell" /></label>
            </td>
            <td>
                <label>
                    Collection Date<br/>
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
                $("#new-sell-form").submit(function(){
                    $("#new-sell-submit-btn").attr("disabled");
                })
    $.ajax({url: base_url + 'api/customers', success: function (result) {
            var names = JSON.parse(result);
            $.each(names,function(){
                      /* window.account_array[this.value] ={
                            name:this.label,
                            ledger_num:this.ledger_num
                        };*/
                        window.ledger_array[this.ledger_num] ={
                            name:this.label,
                            acc_num:this.value,
                            balance:this.ledger_balance
                        };
                    }
            );
            $("#new_sale_account_id_visible").autocomplete({
                  minLength:0,
                  source: names,
                  focus: function( event, ui ) {
                    setAccount( ui.item.value,ui.item.ledger_num ,ui.item.label,ui.item.ledger_balance);
                    return false;
                  },
                  select: function( event, ui ) {
                            setAccount( ui.item.value,ui.item.ledger_num ,ui.item.label,ui.item.ledger_balance);
                    /*$( "#project-description" ).html( ui.item.desc );*/
                    return false;
                  }});
            
            }});
/*    $.ajax({url: base_url + 'api/item_types', success: function (result) {
            var names = JSON.parse(result);
            $("#new_sale_account_id_visible").autocomplete({
                  minLength: 0,
                  source: name_var,
                  focus: function( event, ui ) {
                    return false;
                  },
                  select: function( event, ui ) {
                    return false;
                  }});
            
            }});*/
    $("#new_sell_qnt_type").change(function(){
        setCrates(this.value);
    });

    $("#new_sale_account_ldgr").change(function(){
        updateByLedgerNum(this.value);
    });
    $("#new_sale_account_ldgr").keyup(function(){
        updateByLedgerNum(this.value);
    });

    $("#net_rate").change(function(){
        window.net=this;
        if(this.checked){
            $("#new_sale_total").removeAttr("readonly");
            $("#new_sale_rate").attr("readonly",true);
            console.log("........net rate.........");
        }
        else{
            $("#new_sale_total").attr("readonly",true);
            $("#new_sale_rate").removeAttr("readonly");
        }

    });

    $("#new_sale_total").change(function(){
            if($("#net_rate")[0].checked)
                        updateNetAmount(false);
        /*$("#new_sale_rate").val(parseFloat(this.value)/parseFloat($("#new_sale_qnt").val()));*/
       // setCrates($("#new_sell_qnt_type")[0].value);
    });
    $("#new_sale_total").keyup(function(){
            if($("#net_rate")[0].checked)
                        updateNetAmount(false);
        /*$("#new_sale_rate").val(parseFloat(this.value)/parseFloat($("#new_sale_qnt").val()));*/
    });
    $("#new_sale_qnt").change(function(){
                if($("#net_rate")[0].checked)updateNetAmount(false);
                else updateNetAmount(true);
       // setCrates($("#new_sell_qnt_type")[0].value);
    });
    $("#new_sale_qnt").keyup(function(){
                if($("#net_rate")[0].checked)updateNetAmount(false);
                else updateNetAmount(true);
        //setCrates(this.value);
    })
    $("#new_sale_rate").change(function(){
        updateNetAmount(true);
    })
    $("#new_sale_rate").keyup(function(){
        updateNetAmount(true);
    })
    $("#new_sale_rebate").change(function(){
            if($("#net_rate")[0].checked)
                updateNetAmount(false);
            else
                updateNetAmount(false);
    });
    $("#new_sale_rebate").keyup(function(){
            if($("#net_rate")[0].checked)
                updateNetAmount(false);
            else
                updateNetAmount(false);
    });
    function setCrates(a){
        var qnt = parseInt($("#new_sale_qnt").val());
        switch(a){
            case "1":
                setCrateValue(qnt);
                break;
            case "2":
                setCrateValue(Math.round(  qnt/12));
                break;
            case "3":
                setCrateValue(Math.round(  qnt/9));
        }
    }
    function setCrateValue(a){
        $("#new_sale_crate").val(a);
        $("#new_sale_crate_security").val(a*110);
    }
    function updateByLedgerNum(a){
        if(ledger_array[a]){
            setAccount(ledger_array[a].acc_num,a,ledger_array[a].name,ledger_array[a].balance)
        }
        else{
            acc404(2);
        }
    }
    function setAccount(a,b,c,d){
            $("#acc_error").html("");
            $("#new_sale_account_id").val( a );
            $("#new_sale_account_ldgr").val( b );
            $("#new_sale_account_id_visible").val( c );
            $("#new_sale_account_balance").val((d<0)?(-1*d+"Dr"):d+"Cr");
    }
    function acc404(a){
            $("#acc_error").html("<div class='error'>Account Doesn't Exist</div>");
            $("#new_sale_account_id_visible").val('');
            if(a==1)$("#new_sale_account_ldgr").val('');
            else $("#new_sale_account_id").val('');
    }
    function updateNetAmount(a){
        if(!a)$("#new_sale_rate").val(parseFloat($("#new_sale_total").val())/parseFloat($("#new_sale_qnt").val()));
        var qnt = parseFloat($("#new_sale_qnt").val());
        var rate = parseFloat($("#new_sale_rate").val());
        var rebate = parseFloat($("#new_sale_rebate").val()); 
        qnt = qnt?qnt:0;
        rate = rate?rate:0;
        rebate = rebate?rebate:0;
        var total = qnt * rate;
        if(rebate>=total)rebate=total;
        $("#new_sale_rebate").val(rebate);
        if(a)$("#new_sale_total").val(total);
        $("#new_sale_net_total").val(total - rebate);
    }
</script>
</body>
</html>