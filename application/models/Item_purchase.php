<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
Class item_purchase extends CI_Model {
    function purchase($a){
        
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
        $this->db->insert("item_purchase",$a);
        $purchase_id = $this->db->insert_id();
        array_push($a,"purchase_id");
        $a["purchase_id"]=$purchase_id;
        /*
         * The net amount of purchase is registered either as lending or cash payment in accordance with PAYMENT MODE
         */
        $this->payment->new_purchase($a);
        
        $this->db->trans_complete();
        /*
         * Transaction is completed either all data is saved or nothing is saved
         */
        if($this->db->trans_status() == true){
            return $purchase_id;
        }
        else{
            return false;
        }        
    }
    
    function makePayment($a,$b){
            $this->db->reset_query();
            $this->db->set('amount_received', 'amount_received + '.$b,false);
            $this->db->where('purchase_id',$a);
            $this->db->update('item_purchase');
            $this->db->reset_query();
    }
}
