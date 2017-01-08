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
                    <input type="search" placeholder="Search" onchange="setAccountSearchLink(this.value)" onkeydown="setLedgerViewLink(this.value)" autofocus="" />
                    <script>function setAccountSearchLink(v){document.getElementById("LedgerViewLink").setAttribute("action","<?php echo base_url(); ?>accounts/view/search/"+v);}</script>
                    <button>Search</button>
                </form>
            </td>
            <td>
                <a href="<?php echo base_url(); ?>accounts/add">Add New Account</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php echo base_url(); ?>accounts/view/active">Active Accounts</a>
            </td>
            <td>
                <a href="">Bank Transfer</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="">Give Salary</a>
            </td>
            <td>
                <a href="<?php echo base_url(); ?>accounts/view/">View All</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="<?php echo base_url(); ?>accounts/dafaulters">Defaulters</a>
            </td>
        </tr>
    </table>
</div>