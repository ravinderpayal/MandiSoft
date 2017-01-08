<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<style type="text/css">
    .link_container{
        width:80%;
        margin: auto;
    }
    .link_container .LINK{
        width:50%;
        display:inline-block;
        height: 200px;
        vertical-align: middle;
    }
    .link_container .LINK{
        border-width:1px 1px 1px 0px;
        border:solid #000;
    }
    .link_container .LINK a{
        vertical-align: middle;
        display: block;
    }
    table td{
        height:100px;
        width:50%;
        text-align:center;
        vertical-align:middle;
    }
    table{
        width:100%;
    }
</style>
<div class="link_container">
    <table border="1px">
        <tr>
            <td><input type="date" placeholder="Date" onchange="setParchiViewLink(this.value)" onkeydown="setLedgerViewLink(this.value)" />
                <script>function setParchiViewLink(v){document.getElementById("ParchiViewLink").setAttribute("href","<?php echo base_url(); ?>parchi/datewise/"+v);}</script>
                <a id="ParchiViewLink">View By Date</a>
            </td>
            <td>
                <a href="<?php echo base_url(); ?>parchi/big">Big Deals</a>
            </td>
        </tr>
            <td>
                <a href="<?php echo base_url(); ?>parchi/viewall/">View All</a>
            </td>
        </tr>
    </table>
</div>