<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
   #new_sale td{width:30%;padding:5px;}
</style>
<h2>New Purchase</h2>
            <?php 
            if(isset($message))echo "<div class=\"message\">$message</div>";
            echo validation_errors("<div class=\"error\">","</div>");
            ?>
<form action="<?php echo base_url(); ?>purchase/purchase" method="POST">
    <table id="new_sale" border="1px">
        <tr  align="left">
            <td align="left">
                <label>Item Type<br />
                <select name="item_id" style="color:#000"><?php foreach ($item_types as $type)echo "<option value=\"".$type->item_id."\"".($type->available?"":"disabled=\"\"").">".$type->i_name."</option>"; ?></select>
                </label>
            </td>
            <td align="left">
                <label>Account Name<input type="text" id="new_sale_account_id_visible" name="acc_name"  value='<?php echo set_value('acc_name',''); ?>' style="width:300px" required="" /></label>
                <label>Ledger Number<input type="number" name="ledger_num" id="new_sale_account_ldgr" style="width:300px"  value="<?php echo set_value("ledger_num"); ?>" autofocus="true" /></label>
                <label>Account Balance.<input disabled="" id="new_sale_account_balance" style="width:300px"  /></label><input type="hidden"id="new_sale_account_id"  name="acc_num" value="<?php echo set_value("acc_num"); ?>" />
                <div id="acc_error" align="left"></div>
            </td>
            <td>
                <label>Quantity<br /><input type="text" id="new_sale_qnt" name="quantity"  value='<?php echo set_value('quantity',''); ?>' required="" /></label><select name="qnt_type" id="new_sell_qnt_type"><?php foreach ($quantity_types as $type)echo "<option value=\"".$type->qnt_id."\"".($type->available?"":"disabled=\"\"").">".$type->qnt_name."[$type->qnt_sign]"."</option>"; ?></select>
                <br />
                <label>Rate<br /><input type="text" id="new_sale_rate" name="rate"  value='<?php echo set_value('rate',''); ?>' required="" /></label>
                <br/>
                <label>
                    Purchase Date<br/>
                    <input type="date" name="date" value="<?php echo set_value("date",date("Y-m-d",time())); ?>" />
                </label>
            </td>
        </tr>
        <tr align="right">
            <td><textarea placeholder="Remarks / Notes" name="notes" name="remarks"></textarea></td>
            <td align="right">
                <label>Net Rate<input type="checkbox" id="net_rate" /></label><br />
                <label>Total ₹<input type="number" id="new_sale_total" name="total" value='<?php echo set_value('total','0'); ?>' required="" readonly="" /></label>
                <label>Rebate( छुट ) ₹<input type="number" id="new_sale_rebate" name="rebate" value='<?php echo set_value('rebate','0'); ?>' required="" /></label>
            </td>
            <td style="background:#00f">
                
                <label style="color:#fff;">Net Total( Receivable ) ₹<input type="number"  style="color:#000;" id="new_sale_net_total" name="net_total" value='<?php echo set_value('net_total','0'); ?>' required="" readonly="" /></label>
                <label style="color:#fff;">Payment Mode<select name="payment_mode" id="new_sell_payment_mode" style="color:#000"><?php foreach ($payments_modes as $mode)echo "<option value=\"".$mode->mode_id."\"".($mode->mode_available?"":"disabled=\"\"").">".$mode->mode_name."</option>"; ?></select>
                    <script>
                        document.getElementById("new_sell_payment_mode").value ="<?php echo set_value("payment_mode",1); ?>";
                    </script>
                </label>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <label>Quik Entry<input type="checkbox" checked="" name="quick" /></label><br />
                <input type="submit" class="btn btn-lg btn-primary btn-block no-print" value="Sell" />
            </td>
        </tr>
    </table>
</form>
<script>
                var account_array={},ledger_array={};
    $.ajax({url: base_url + 'api/supliers', success: function (result) {
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