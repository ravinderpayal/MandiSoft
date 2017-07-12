<?php
defined('BASEPATH') or exit('No direct script access allowed');
Class Create extends CI_Controller {

    function __construct() {
        parent::__construct();
       // $this->output->enable_profiler(TRUE);
        //$this->_check_auth(3);
        
        $this->load->model('report', '', TRUE);
        $this->load->model('general', '', TRUE);
        $this->load->model('account', '', TRUE);
        $this->load->model('payment', '', TRUE);
        $this->load->model('invoicecustomer', '', TRUE);
    }
    function index(){

    }

    function invoice(){
                    $invoice = $this->input->post("invoice")?json_decode($this->input->post("invoice")):array();
                    try{
                        $invoice = new Invoice($invoice);
                    }
                    catch(Exception $e){
                        echo $e->getMessage();
                        exit;
                    }

                    $result = $this->invoicecustomer->save($invoice);
    }/*
    function _is_boolean($a){
        if($!=)
    }*/
    function _is_date($a){
        $strtime = strtotime($a);
        if($strtime){
            return date("Y-m-d",$strtime);
        }
        else return false;
    }
    function _is_customer($a){
        if($this->account->is_customer($a))return true;
        else{
            $this->form_validation->set_message('_is_customer', 'The  ACCOUNT you have Entered is not a customer!');            
            return false;
        }
    }
    function _is_ledger_available($a){
        if($this->account->is_ledger($a))return true;
        else{
            $this->form_validation->set_message('_is_ledger_available', 'The ledger number is invalid');
            return false;
        }
    }
    function _is_item($a){
        if($this->general->is_item($a))return true;
        else{
            $this->form_validation->set_message('_is_item', 'The Item type doesn\'t exist');
            return false;
        }
    }
    function _is_quantity_type($a){
        if($this->general->is_quantity_type($a))return true;
        else{
            $this->form_validation->set_message('_is_quantity_type', 'The Quantity type doesn\'t exist');
            return false;
        }
    }
    function _is_item_lot($a){
        if($this->general->is_item_lot($a))return true;
        else{
            $this->form_validation->set_message('_is_item_lot', 'Item Lot doesn\'t exist');
            return false;
        }
    }
    function _is_payment_mode($a){
        if($this->general->is_payment_mode($a))return true;
        else{
            $this->form_validation->set_message('_is_payment_mode', 'Invalid Payment Mode');
            return false;
        }
    }

    function _check_auth($r) {//$r->rights required to access the page
        if(!$this->session->userdata('logged_in'))exit("{\"out\":\"You are not allowed to access this page\}");
        if(!($this->session->userdata('logged_in')["access_right"]<=$r))exit("{\"out\":\"You are not allowed to access this page\}");
        $this->lang->load('labels', $this->session->userdata('logged_in')["language"]);
    }

}

?>