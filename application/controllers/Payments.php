<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class payments extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('account', '', TRUE);
        $this->load->model('general', '', TRUE);
        $this->load->model('item_sale', '', TRUE);
        $this->load->model('payment', '', TRUE);
    }

    function index(){
        $this->_check_auth(4);
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        //$data['reports'] = $this->report->sell_reports();
        $this->load->view('payments/home', $data);
    }
    function save_collection(){
        $this->_check_auth(3);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ledger_number', 'Ledger Number', 'trim|required|is_natural_no_zero|callback__is_ledger_available');
        $this->form_validation->set_rules('acc_num', 'Account Number', 'trim|required|is_natural_no_zero|callback__is_customer');
        $this->form_validation->set_rules('related_sell', 'Related Sell', 'trim|is_natural_no_zero|callback__is_sell_srno');
        $this->form_validation->set_rules('amount', 'Amount', 'required|trim|greater_than_equal_to[0]|numeric');
        $this->form_validation->set_rules('rebate', 'Account Balance Rebate', 'trim|required|greater_than_equal_to[0]|numeric');
        $this->form_validation->set_rules('date', 'Collection Date', 'trim|required|callback__is_date');
         if ($this->form_validation->run() == TRUE){
            $data['account_groups'] = $this->account->account_groups();
            $account_balance = $this->input->post('acc_opening_balance');
            $ob_dr = $this->input->post('ob_dr');
            if($ob_dr=="debt")$account_balance = -1 * $account_balance;
            $crate_balance = $this->input->post('crates');
            $crt_dr = $this->input->post('crt_dr');
            if($crt_dr=="debt")$crate_balance = -1 * $crate_balance;
            $result = $this->payment->collect(array(
                "acc_id"=>$this->input->post('acc_num'),
                "amount"=>$this->input->post('amount'),
                "rebate"=>$this->input->post('rebate'),
                "related_sell"=>$this->input->post('related_sell')?$this->input->post('related_sell'):NULL,
                "make_date"=>$this->input->post("date"),
                "inserting_operator"=>$this->session->userdata('logged_in')["id"]
                ));
            if($result){
            //$this->_reusable_collect("Added Succesfully");
            //redirect(base_url().'payments/collect/Payment Received Successfully', 'refresh');
                    redirect(base_url()."parchi/payment/$result", 'refresh');
            }
        }
        else{
            $data['account_groups'] = $this->account->account_groups();
            //if($this->account->check_unique($a,$b)){
            $this->_reusable_collect();
            //redirect(base_url() . 'home', 'refresh');
        }
    }
    
    function make(){
        $this->_check_auth(3);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ledger_number', 'Ledger Number', 'trim|required|is_natural_no_zero|callback__is_ledger_available');
        $this->form_validation->set_rules('acc_num', 'Account Number', 'trim|required|is_natural_no_zero|callback__is_customer');
        $this->form_validation->set_rules('related_sell', 'Related Sell', 'trim|is_natural_no_zero|callback__is_sell_srno');
        $this->form_validation->set_rules('amount', 'Amount', 'required|trim|greater_than_equal_to[0]|numeric');
        $this->form_validation->set_rules('rebate', 'Account Balance Rebate', 'trim|required|greater_than_equal_to[0]|numeric');
        $this->form_validation->set_rules('date', 'Make Date', 'trim|required|callback__is_date');
         if ($this->form_validation->run() == TRUE){
            $data['account_groups'] = $this->account->account_groups();
            $account_balance = $this->input->post('acc_opening_balance');
            $ob_dr = $this->input->post('ob_dr');
            if($ob_dr=="debt")$account_balance = -1 * $account_balance;
            $crate_balance = $this->input->post('crates');
            $crt_dr = $this->input->post('crt_dr');
            if($crt_dr=="debt")$crate_balance = -1 * $crate_balance;
            $result = $this->payment->pay(array(
                "acc_id"=>$this->input->post('acc_num'),
                "amount"=>$this->input->post('amount'),
                "rebate"=>$this->input->post('rebate'),
                "related_sell"=>$this->input->post('related_sell')?$this->input->post('related_sell'):NULL,
                "make_date"=>$this->input->post("date"),
                "inserting_operator"=>$this->session->userdata('logged_in')["id"]
                ));
            if($result){
            //$this->_reusable_collect("Added Succesfully");
            //redirect(base_url().'payments/collect/Payment Received Successfully', 'refresh');
                    redirect(base_url()."parchi/payment/$result", 'refresh');
            }
        }
        else{
            $data['account_groups'] = $this->account->account_groups();
            //if($this->account->check_unique($a,$b)){
            $this->_reusable_collect();
            //redirect(base_url() . 'home', 'refresh');
        }
    }
    function  askDelete($a=""){
        $this->_check_auth(1);
        if(empty($a) || !is_numeric($a)){
            show_404();
        }
        else{
            $data["sale_id"] = $a;
            $this->load->view('payments/ask_delete', $data);
        }
    }
    function delete($a){
        $this->_check_auth(1);
        if(empty($a) || !is_numeric($a)){
            show_404();
        }
        else{
            if($this->payment->delete($a)){
                $data["message"] = "Successfully Deleted";
                $this->load->view('sale/blank_message', $data);
            }
            else{
               $data["message"] = "Deleting Process failed . Please Retry.";
               $this->load->view('sale/blank_message', $data);             
            }
        }
    }
    
    function _is_date($a){
        $strtime = strtotime($a);
        if($strtime){
            return date("Y-m-d",$strtime);
        }
        else return false;
    }

    function _is_account_group($a){
        if($this->account->is_account_group(intval($a)))return true;
        else{
            $this->form_validation->set_message('_is_account_group', 'The account group you have Entered doesn\'t exist!');            
            return false; 
        }
    }
    function _is_customer($a){
        if($this->account->is_customer($a))return true;
        else{
            $this->form_validation->set_message('_is_customer', 'The  ACCOUNT you have Entered is not a customer!');            
            return false;
        }
    }
    function _is_account($a){
        if($this->account->is_account($a))return true;
        else{
            $this->form_validation->set_message('_is_account', 'The related account you have Entered doesn\'t exist!');            
            return false; 
        }
    }
    function _is_ledger_available($a){
        if($this->account->is_ledger($a)){
               return true;
        }
        else{
            $this->form_validation->set_message('_is_ledger_available', "The ledger number($a) is invalid");
            return false;
        }
    }
    function _is_sell_srno($a){
        if($this->account->is_ledger($a)){
            $this->form_validation->set_message('_is_sell_srno', 'The Selling doesn\'t exist in Sale history');
            return false;
        }
        else return true;
    }
    function collect($a=""){
        $this->_check_auth(3);
        $this->_reusable_collect($a?urldecode($a):NULL);
   }
    function pay($a=""){
        $this->_check_auth(3);
        $this->_reusable_pay($a?urldecode($a):NULL);
   }
    function _reusable_collect($m=''){
        $data['message']=$m;
        $this->load->helper('form');
        $this->load->view('payments/collect', $data);
    }
    function _reusable_pay($m=''){
        $data['message']=$m;
        $this->load->helper('form');
        $this->load->view('payments/pay', $data);
    }
    function _check_auth($r) {//$r->rights required to access the page
        if(!$this->session->userdata('logged_in'))redirect(base_url() . 'login', 'refresh');
        if(!($this->session->userdata('logged_in')["access_right"]<=$r)){
            $this->load->view('no_proper_rights');
            exit("You have no rights to access this page");
        }
    }
}

?>