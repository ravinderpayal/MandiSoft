<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
    td,th{
        padding:10px 25px 10px 25px;
    }
    th{
        font-size:30px;
        text-align:center;
    }
    tr.total{
        text-align: center;
        font-weight: 700;
        font-size: 20px;
    }
    /*
    table{
        border:1px dashed;
    }
    td,th{
        border-top:1px dashed !important;
    }
    th:nth-child(odd),td:nth-child(odd){
        border-right:1px dashed;
        border-left:1px dashed;
    }
    th:nth-child(even),td:nth-child(even){
        border-right:1px dashed;
    }
    td:nth-last-of-type{
        border-bottom:2px dashed;
    }*/
    table , th , td {
        border-style: dashed;
    }
</style>
<script>
    function _print (){
        window.print();
    };
</script>
<a href="javascript:_print();" class="no-print">Print Parchi</a>
<table border="2px">
            <tr>
                <th>अकाउंट नंबर</th>
                <th>तारीख़</th> 
                <th>कलम</th>
                <th>जमा</th>
                <th>बकाया</th>
                <th></th>
            </tr>
            <?php foreach ($sales as $value) { ?>
                <tr>
                    <td style="text-align: center"><a href="<?php echo base_url(); ?>account/view/<?php echo $value->sold_to; ?>"><?php
                            echo $value->sold_to;
                        ?></a></td>
                    <td style="text-align: center"><?php
                    $datetime = strtotime($value->datetime);
                    $date     = strtotime($value->sale_date);
                            echo date("d/m/Y",$date?$date:$datetime);
                        ?></td> 
                    <td style="text-align:center;background:#00f0ff;color:#777;font-weight:bolder;font-size:20px;"><?php
                            $total_amount = ( $value->quantity * $value->rate) - $value->rebate;
                            echo $total_amount;
                        ?></td>
                    <td  style="text-align:center;background:#0f0;color:#777;font-weight:bolder;font-size:20px;"><?php
                            echo $value->amount_received;
                        ?></td> 
                    <td style="text-align: center;background:#f00;color:#eee; font-weight:bolder;"><?php
                            echo $total_amount - $value->amount_received;
                        ?></td> 
                    <td style="text-align: center"><a href="<?php echo base_url(); ?>sells/view/<?php echo $value->sale_id; ?>">View Detail</a> | <a href="<?php echo base_url(); ?>reports/edit/<?php echo $value->sale_id; ?>">Edit</a> | <a href="<?php echo base_url(); ?>sale/askDelete/<?php echo $value->sale_id; ?>">Delete</a></td>
                </tr>
            <?php } ?> 
            </table>