<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class item_sale extends CI_Model {

    function sell($a){
        
        $amount = ($a["quantity"] * $a["rate"]) - $a["rebate"];
        
        /*
         * 
         * *********Transaction Started If any Query Fails ....
         * * Others will also be rollbacked (Any changes made after *this* point will be discarded)***
         * 
         */
        $this->db->trans_start();
        
        /*
         * Sell is registered in `item_sale` Table
         */
        $this->db->insert("item_sale",$a);
        $sale_id = $this->db->insert_id();
        /*
         * The net amount of sale is registered either as lending or cash payment in accordance with PAYMENT MODE
         */
        $this->payment->_new(array("acc_id"=>$a["sold_to"],"amount"=>$amount,"crates"=>$a["crates"],"sale_id"=>$sale_id,"payment_mode"=>$a["payment_mode"]));
        
        $this->db->trans_complete();
        /*
         * Transaction is completed either all data is saved or nothing is saved
         */
        if($this->db->trans_status() == true){
            return $sale_id;
        }
        else{
            return false;
        }        
    }
    function receivePayment($a,$b){
        $this->db->reset_query();
        $this->db->set('amount_received', 'amount_received + '.$b,false);
        $this->db->where('sale_id',$a);
        $this->db->update('item_sale');
        $this->db->reset_query();
        $this->db->set('amount', 'amount - ('.$b.')',false);
        $this->db->where('related_sell',$a);
        $this->db->update('debts');
        $this->db->reset_query();
    }
    
    function delete($a){
        $this->db->trans_start();
        /*
         * Sell is registered in `item_sale` Table
         */
        $this->db->query("INSERT INTO `deleted_sales`( select * from item_sale where sale_id = $a)");
        $query = $this->db->query("select * from item_sale where sale_id = $a");
        $info = $query->result()[0];

        $amount = ($info -> quantity * $info -> rate) - $info -> rebate;
        $crates = $info -> crates;
        $this->account->updateBalance($info->sold_to,$amount,$crates);
        $this->db->query("DELETE FROM item_sale WHERE sale_id =  $a");
        $this->db->query("UPDATE `datewise_account_balance` SET new_balance = (new_balance + $amount) , old_balance = (old_balance + $amount) WHERE datetime > \"$info->datetime\" and acc_id = $info->sold_to");
        $this->db->trans_complete();

        /*
         * 
         * Transaction is completed either all data is saved or nothing is saved
         * 
         */
        if($this->db->trans_status() == true){
            return true;
        }
        else{
            return false;
        }        
    }
}

?>