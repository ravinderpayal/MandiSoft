<h4>
    Did you Mean
</h4>
<?php
foreach($didyoumean as $dym){
//    echo "<a href='".base_url()."ledger/view/$dym->acc_id'>$dym->acc_name</a><br />";
    echo "<a href='".base_url()."accounts/view/search/$dym->acc_name'>$dym->acc_name</a><br />";
    
}
?>
<?php
$this->load->view("account/show_accounts");
?>