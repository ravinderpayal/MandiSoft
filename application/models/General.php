<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
Class general extends CI_Model {
    function get_payment_mode(){
        $query = $this->db->get('payment_mode');
        return $query->result();
    }
    function get_item_types(){
        $query = $this->db->get('item');
        return $query->result();
    }
    function get_quantity_types(){
        $query = $this->db->get('quantity_types');
        return $query->result();
    }
    function get_item_lotes(){
        $query = $this->db->get('item_lot');
        return $query->result();
    }
    function is_sell_srno($a){
        $query=$this->db->get_where("item_sale",array("sale_id"=> $a));
        return ($query->num_rows()==1);
    }
    function is_item($a){
        $query=$this->db->get_where("item",array("item_id"=> $a));
        return ($query->num_rows()==1);
    }
    function is_item_lot($a){
        $query=$this->db->get_where("item_lot",array("lot_id"=> $a));
        return ($query->num_rows()==1);
    }
    function is_quantity_type($a){
        $query=$this->db->get_where("quantity_types",array("qnt_id"=> $a));
        return ($query->num_rows()==1);
    }
    function is_payment_mode($a){
        $query=$this->db->get_where("item_lot",array("lot_id"=> $a));
        return ($query->num_rows()==1);
    }
}

?>