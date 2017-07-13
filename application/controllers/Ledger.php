<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Ledger extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        $this->load->model('account', '', TRUE);
        $this->load->model('operators', '', TRUE);
        $this->load->model('general', '', TRUE);
    }

    function index(){
            $this->_check_auth(4);
            $this->load->view("ledger/home");
    }
    function view($a="",$b=""){
        /*  Financial Year वित्तीय वर्ष */
            $this->_check_auth(3);
            if($this->_is_ledger($a)){
                /**
                //--deprecated
                */

                $s_b=100;
                $s_c=100;

                $l_from = date($this->input->get('from'))?$this->input->get('from'):date("Y-m-d",(time()-(3600*24*15)));
                $l_to = date($this->input->get('to'))?$this->input->get('to'):date("Y-m-d",time());

                if(!empty($b)){
                    if(is_int($b)){
                        $s_b=$b;
                        $s_c=$b;
                    }
                    else{
                        $limit=explode("-",$b);
                        $limit_c = count($limit);
                        if($limit_c){
                            $s_b=$limit[0];
                            if($limit_c>=2)
                            $s_c=$limit[1];
                        }
                    }
                }
                $data["ledger_info"] = $this->account->get_ledger_info($a);
                $data["start_balance"] = $this->account->get_opening_balance($data["ledger_info"]->acc_id);
                $data["sales"] = $this->account->get_ledger_sales($a,$s_b,$s_c,$l_from,$l_to);
                $data["payments"] = $this->account->get_ledger_payment($a,$s_b,$s_c,$l_from,$l_to);
                $data["payments_total"] = $this->account->get_ledger_paymentTotal($data["ledger_info"]->acc_id);
                $data["sales_total"] = $this->account->get_ledger_salesTotal($data["ledger_info"]->acc_id);
                $data["l_from"]=$l_from;
                $data["l_to"]=$l_to;
                $this->load->view("reports/ledger_view",$data);
        }
            else{
                echo "Not Found";
            }
    }
    function  viewall($l=""){
            $this->_check_auth(3);
        if(!empty($l)){
            $l=explode("-",$l);
            if(isset($l[0]) and isset($l[1])){
                $accounts = $this->account->get_all(array($l[0],$l[1]));
            }
        }
        else{
            $accounts = $this->account->get_all();
        }
       $this->load->view("top");
       $i=0;
       foreach($accounts as $account){
            $a = $account->acc_id;
            $data["ledger_info"] = $account;//$this->account->get_ledger_info($a);
            $data["start_balance"] = $this->account->get_opening_balance($a);
            $data["sales"] = $this->account->get_acc_sales($a);
            $data["payments"] = $this->account->get_acc_payment($a);
            if($i!=0)$data["multiple"] = true;
            $this->load->view("reports/ledger",$data);
            $i++;
       }
            $this->load->view("bottom");
    }
    function byarea($a=""){
        $this->_check_auth(3);
        if(empty($a))show_404 ();
        
    }
    function _is_ledger($a){
        if(empty($a))return false;
        if($this->account->is_ledger($a))return true;
        else{
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