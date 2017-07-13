<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class accounts extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('account', '', TRUE);
        $this->load->model('payment', '', TRUE);
    }

    function index(){
        $this->_check_auth(4);
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        //$data['reports'] = $this->report->sell_reports();
        $this->load->view('account/account_home', $data);
        }
    function create(){
        $this->_check_auth(3);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('ledger_num', 'Ledger Number', 'trim|required|is_natural_no_zero|callback__is_ledger_available');
        $this->form_validation->set_rules('date', 'Sell Date', 'trim|required|callback__is_date');
        $this->form_validation->set_rules('acc_name', 'Account Name', 'trim|required');
        $this->form_validation->set_rules('acc_name_ll', 'Account Name Hindi', 'trim');
        $this->form_validation->set_rules('acc_group', 'Account Group', 'trim|required|is_natural_no_zero|callback__is_account_group');
        $this->form_validation->set_rules('acc_opening_balance', 'Account Opening Balance', 'required|trim|greater_than_equal_to[0]|numeric');
        $this->form_validation->set_rules('ob_dr', 'Account Opening Balance Direction', 'required|trim|in_list[debt,dpst]');
        $this->form_validation->set_rules('crates', 'Crate Balance', 'required|trim|greater_than_equal_to[0]|numeric');
        $this->form_validation->set_rules('crt_dr', 'Crate Balance Direction', 'required|trim|in_list[debt,dpst]');
        $this->form_validation->set_rules('acc_mob_num1', 'Account Mobile Number(1st)', 'trim|is_natural_no_zero|regex_match[/^[789][0-9]{9}$/]');
        $this->form_validation->set_rules('acc_mob_num2', 'Account Mobile Number(2nd)', 'trim|exact_length[10]|is_natural_no_zero|regex_match[/^[789][0-9]{9}$/]');
        $this->form_validation->set_rules('acc_area', 'Account Area', 'trim');
        $this->form_validation->set_rules('acc_city', 'Account City', 'trim|required');
        $this->form_validation->set_rules('acc_adrs1', 'Account Address(1st)', 'trim');
        $this->form_validation->set_rules('acc_adrs2', 'Account Address(2nd)', 'trim');
        $this->form_validation->set_rules('related_acc_1', 'Related Account(1st)', 'trim|is_natural_no_zero|callback__is_account');
        $this->form_validation->set_rules('related_acc_2', 'Related Account(2nd)', 'trim|is_natural_no_zero|callback__is_account');
        $this->form_validation->set_rules('related_acc_3', 'Related Account(3rd)', 'trim|is_natural_no_zero|callback__is_account');
        if ($this->form_validation->run() == TRUE){
            $data['account_groups'] = $this->account->account_groups();
            $account_balance = $this->input->post('acc_opening_balance');
            $ob_dr = $this->input->post('ob_dr');
            if($ob_dr=="debt")$account_balance = -1 * $account_balance;
            $crate_balance = $this->input->post('crates');
            $crt_dr = $this->input->post('crt_dr');
            if($crt_dr=="debt")$crate_balance = -1 * $crate_balance;
            $out = $this->account->create(array(
                "acc_name"=>$this->input->post('acc_name'),
                "group_id"=>$this->input->post('acc_group'),
                "acc_name_ll"=>$this->input->post('acc_name_ll'),
                "ledger_number"=>$this->input->post('ledger_num'),
                "account_balance"=>$account_balance,
                "crate_balance"=>$crate_balance,
                "acc_address1"=>$this->input->post('acc_adrs1'),
                "acc_address2"=>$this->input->post('acc_adrs2'),
                "acc_area"=>$this->input->post('acc_area'),
                "acc_city"=>$this->input->post('acc_city'),
                "mobile_number1"=>$this->input->post('acc_mob_num1'),
                "mobile_number2"=>$this->input->post('acc_mob_num2'),
                "last_activity"=>$this->input->post('date'),
                "inserting_operator"=>$this->session->userdata('logged_in')["id"],
                "firm_id"=>$this->session->userdata('logged_in')["firm_id"]
                    ));
            if($out){
                $rel_array=array();
                if(!empty($this->input->post('related_acc_1')))$rel_array[]=    array(
                        "acc1_id"=>$out,
                        "acc2_id"=>$this->input->post('related_acc_1')
                    );
                if(!empty($this->input->post('related_acc_2')))$rel_array[]=    array(
                        "acc1_id"=>$out,
                        "acc2_id"=>$this->input->post('related_acc_2')
                    );
                if(!empty($this->input->post('related_acc_3')))$rel_array[]=    array(
                        "acc1_id"=>$out,
                        "acc2_id"=>$this->input->post('related_acc_3')
                    );
                if(count($rel_array))$this->account->create_relation($rel_array);
            }
            redirect(base_url().'accounts/add/Added Succesfully', 'refresh');
            //$this->_reusable_add("Added Succesfully");
        }
        else{
            $data['account_groups'] = $this->account->account_groups();
            //if($this->account->check_unique($a,$b)){
            $this->_reusable_add();
            //redirect(base_url() . 'home', 'refresh');
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
    function _is_account($a){
        if(empty($a))return true;
        if($this->account->is_account($a,$this->session->userdata('logged_in')['firm_id']))return true;
        else{
            $this->form_validation->set_message('_is_account', 'The related account you have Entered doesn\'t exist!');            
            return false; 
        }
    }
    function _is_ledger_available($a){
        if($this->account->is_ledger($a)){
            $this->form_validation->set_message('_is_ledger_available', 'The ledger number is already given to some other account');
            return false;
        }
        else return true;
    }
    function add($a="") {
        $this->_check_auth(3);
        $this->_reusable_add($a?urldecode($a):NULL);
   }
   function view($a="",$b="",$c=""){
       switch ($a){
           case "":
               $this->_show_all_accounts();
               break;
           case "limit":
               $this->_show_all_accounts($b);
               break;
           case "defaulters":
               $this->_show_defaulter_accounts();
               break;
           case "active":
               $this->_show_active_accounts();
               break;
           case "search":
               $this->_show_accounts_by_search($b);
               break;
           default :
               $this->_show_account($a);
               break;
       }
   }
   function _show_account($a){
       $data["account"] = $this->account->get($a,$this->session->userdata('logged_in')["firm_id"]);
       $data["view"]     = "account/show_account";
       $this->load->view("blank",$data);
   }
   /**
    * 
    * atd (Add to Defaulter)
    * Name of function is self explaining
    * 
    */
   function atd($a=""){
       if(!is_numeric($a) || $a<1){
            show_404();
       }
       if($this->_is_account($a)){
           if($this->account->atd($a)){
               $data["message"] = "Successfully Added to Defaulter List";
               $this->load->view('sale/blank_message', $data);             
           }
           else{
               $data["message"] = "Failed! Internal Server Error. Please retry.";
               $this->load->view('sale/blank_message', $data);             
           }
       }
   }
   
   /*
    *         if(!empty($l)){
            $l=explode("-",$l);
            if(isset($l[0]) and isset($l[1])){
                $accounts = $this->account->get_all(array($l[0],$l[1]));
            }
        }
        else{
            $accounts = $this->account->get_all();
        }

    */
   function _show_all_accounts($l=false){
         if($l){
            $l=explode("-",$l);
            if(isset($l[0]) and isset($l[1])){
                $accounts = $this->account->get_all(array($l[0],$l[1]));
            }
        }
        else{
            $accounts = $this->account->get_all();
        }
        $data["accounts"] = $accounts;//$this->account->get_all();
       $data["view"]     = "account/show_accounts";
       $this->load->view("blank",$data);
   }
   function _show_defaulter_accounts(){
       $data["accounts"] = $this->account->get_defaulters();
       $data["view"]     = "account/show_accounts";
       $this->load->view("blank",$data);
   }
   function _show_active_accounts(){
       $data["accounts"] = $this->account->get_active(date("Y-m-d",time()));
       $data["view"]     = "account/show_accounts";
       $this->load->view("blank",$data);
   }
   function  _show_accounts_by_search($b){
       $data["accounts"] = $this->account->search($b,$this->session->userdata('logged_in')["firm_id"]);
       $data["didyoumean"]=array();
       if(!count($data["accounts"])){
       $data["didyoumean"] = $this->account->searchDidYouMean($b);           
       }
       $data["view"]     = "account/show_search";
       $this->load->view("blank",$data);
   }
   function _reusable_add($m=''){
        $data['account_groups'] = $this->account->account_groups();
        $numbers = $this->account->get_last_id();
        $data['account_number'] = $numbers?($numbers->acc_id + 1):1;
        $data['ledger_number'] = $numbers?($numbers->ledger_number + 1):1;
        $data['message']=$m;
        $this->load->helper('form');
        
        $this->load->view('account/add', $data);
    }
    function _check_auth($r) {//$r->rights required to access the page
        if(!$this->session->userdata('logged_in'))exit("{\"out\":\"You are not allowed to access this page\}");
        if(!($this->session->userdata('logged_in')["access_right"]<=$r))exit("{\"out\":\"You are not allowed to access this page\}");
        $this->lang->load('labels', $this->session->userdata('logged_in')["language"]);
    }
}

?>