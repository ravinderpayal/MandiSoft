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
            <td>
                <form action="" method="POST" id="LedgerViewLink">
                    <input style="height:40px"  type="number" placeholder="Enter Ledger Number" onchange="setLedgerViewLink(this.value)" onkeydown="setLedgerViewLink(this.value)" autofocus="" />
                    <script>function setLedgerViewLink(v){document.getElementById("LedgerViewLink").setAttribute("action","<?php echo base_url(); ?>ledger/view/"+v);}</script>
                    <button style="height:40px" >View</button>
                </form>
            </td>
            <td>
                <a href="<?php echo base_url(); ?>accounts/dafaulters">Defaulter's</a>
            </td>
        </tr>
            <td>
                <a href="<?php echo base_url(); ?>ledger/viewall/">View All</a>
            </td>
        </tr>
    </table>
</div>