<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class sale extends CI_Controller {

    function __construct() {
        parent::__construct();
       // $this->output->enable_profiler(TRUE);
        
        $this->load->model('report', '', TRUE);
        $this->load->model('general', '', TRUE);
        $this->load->model('account', '', TRUE);
        $this->load->model('payment', '', TRUE);
        $this->load->model('item_sale', '', TRUE);
    }

    function index() {
        $this->_check_auth(3);
        $this->_show_home();
    }
    function new_sell($a=""){
        $this->_check_auth(3);
        $this->_show_home($a?urldecode($a):NULL);        
    }
    function  askDelete($a=""){
        $this->_check_auth(1);
        if(empty($a) || !is_numeric($a)){
            show_404();
        }
        else{
            $data["sale_id"] = $a;
            $this->load->view('sale/ask_delete', $data);
        }
    }
    function delete($a){
        $this->_check_auth(1);
        if(empty($a) || !is_numeric($a)){
            show_404();
        }
        else{
        if($this->item_sale->delete($a)){
            $data["message"] = "Successfully Deleted";
                $this->load->view('sale/blank_message', $data);
            }
         else{
            $data["message"] = "Deleting Process failed . Please Retry.";
                $this->load->view('sale/blank_message', $data);             
         }
        }
    }
    function _show_home($m =""){
            $data['payments_modes'] = $this->general->get_payment_mode();
            $data['item_types'] = $this->general->get_item_types();
            $data['item_lotes'] = $this->general->get_item_lotes();
            $data['quantity_types'] = $this->general->get_quantity_types();
            $data['message']    = $m;
            $this->load->helper('form');
            $this->load->view('sale/sale_home', $data);
    }
    function sell(){
        $this->_check_auth(3);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('item_id', 'Item Type', 'trim|required|is_natural_no_zero|callback__is_item');
        $this->form_validation->set_rules('item_lot', 'Item Lot', 'trim|required|is_natural_no_zero|callback__is_item_lot');
        $this->form_validation->set_rules('date', 'Sell Date', 'trim|required|callback__is_date');

        $this->form_validation->set_rules('ledger_num', 'Ledger Number', 'trim|required|is_natural_no_zero|callback__is_ledger_available');
        $this->form_validation->set_rules('acc_num', 'Account Number', 'trim|required|is_natural_no_zero|callback__is_customer');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|trim|greater_than_equal_to[0]|numeric');
        $this->form_validation->set_rules('qnt_type', 'Quantity Type', 'required|trim|greater_than_equal_to[0]|numeric|callback__is_quantity_type');
        $this->form_validation->set_rules('rate', 'Rate', 'required|trim|greater_than_equal_to[0]|numeric');
        $this->form_validation->set_rules('crates', 'Crates Given', 'required|trim|greater_than_equal_to[0]|numeric');
        $this->form_validation->set_rules('rebate', 'Rebate( छुट ) ₹', 'required|trim|greater_than_equal_to[0]|numeric');
        /*$this->form_validation->set_rules('net_rate', 'Sell By Net Rate', 'required|trim');*/
        $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'required|trim|greater_than_equal_to[0]|numeric|callback__is_payment_mode');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim');
                if ($this->form_validation->run() == TRUE){
                    $sell_info = array(
                        "sold_to"=>$this->input->post("acc_num"),
                        "item_id"=>$this->input->post("item_id"),
                        "item_lot"=>$this->input->post("item_lot"),
                        "quantity"=>$this->input->post("quantity"),
                        "quantity_type"=>$this->input->post("qnt_type"),
                        "payment_mode"=>$this->input->post("payment_mode"),
                        "rebate"=>$this->input->post("rebate"),
                        "rate"=>$this->input->post("rate"),
                        "crates"=>$this->input->post("crates"),
                        "crate_security"=>$this->input->post("crate_security"),
                        "remarks"=>$this->input->post("remarks"),
                        "sale_date"=>$this->input->post("date"),
                        "net_rate"=>$this->input->post("net_rate")?true:false,
                        "inserting_operator"=>$this->session->userdata('logged_in')["id"]
                    );
                    $result =$this->item_sale->sell($sell_info);
                    if($result){
                    
                    if($this->input->post("quick")){
                        $message = "Saved Successfully";
                        redirect(base_url()."sale/new_sell/$message", 'refresh');
                    }
                    else{
                        redirect(base_url()."parchi/sale/$result", 'refresh');
                    }
                    }
                }
                else{
                    $this->_show_home("");
                }
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