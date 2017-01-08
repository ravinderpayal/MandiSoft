<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class View extends CI_Controller {

    function __construct() {
        parent::__construct();
       // $this->output->enable_profiler(TRUE);
        $this->load->model('account', '', TRUE);
        $this->load->model('operators', '', TRUE);
        $this->load->model('general', '', TRUE);
        $this->load->model('report', '', TRUE);
    }

    function index() {        
    }
    function debts($a){
            $this->_check_auth(3);
            if($this->_is_account($a)){
            $data["ledger_info"] = $this->account->get_basic_info($a);
            $data["start_balance"] = $this->account->get_opening_balance($a);
            $data["sales"] = $this->account->get_acc_sales($a);
            $data["payments"] = $this->account->get_ledger_payment($a);
            $this->load->view("reports/debts_view",$data);
        }
        else{
            echo "Not Found";
        }
    }
    function sales($a="",$b="",$c=""){
        switch($a){
            case "account":
                $this->_view_acc_sales($b);
                break;
            case "date":
                $this->_sales_datewise($b);
                break;
            default :
                $this->_view_all_sales($a);
                break;
        }
    }
    function defaulters($l=""){
            $this->_check_auth(3);
            if(!empty($l)){
                $l=explode("-",$l);
                if(isset($l[0]) and isset($l[1])){
                    $data["view_next"] =base_url()."view/defaulters/".($l[0]+$l[1])."-20";
                    $data["defaulters"] = $this->report->defaulters("$l[0],$l[1]");
                }
                else{
                    show_404();
                }
            }
            else{
                $data["view_next"] = base_url()."view/defaulters/20-20";
                $data['defaulters'] = $this->report->defaulters();
            }
            $this->load->view("top");
            $this->load->view("reports/defaulters",$data);
            $this->load->view("bottom");
        
    }
    function payments($a="",$b="",$c=""){
        switch($a){
            case "account":
                $this->_view_acc_payments($b);
                break;
            case "date":
                $this->_payments_datewise($b);
                break;
            default :
                $this->_view_all_payments($a);
                break;
        }
    }
   function _view_all_payments($l=""){
            $this->_check_auth(3);
            if(!empty($l)){
                $l=explode("-",$l);
                if(isset($l[0]) and isset($l[1])){
                    $data["view_next"] =base_url()."view/payments/".($l[0]+$l[1])."-20";
                    $data["payments"] = $this->report->latest_payments("$l[0],$l[1]");
                }
                else{
                    show_404();
                }
            }
            else{
                $data["view_next"] = base_url()."view/payments/20-20";
                $data["payments"] = $this->report->latest_payments(20);
            }
            $this->load->view("top");
            $this->load->view("reports/payment_reports",$data);
            $this->load->view("bottom");
    }

    function _view_all_sales($l=""){
            $this->_check_auth(3);
        if(!empty($l)){
            $l=explode("-",$l);
            if(isset($l[0]) and isset($l[1])){
            $data["view_next"] =base_url()."view/sales/".($l[0]+$l[1])."-20";
            $data["sales"] = $this->report->latest_sale("$l[0],$l[1]");
            }
            else{
                show_404();
            }
        }
        else{
            $data["view_next"] = base_url()."view/sales/20-20";
            $data["sales"] = $this->report->latest_sale(20);
            }
        $this->load->view("top");
        $this->load->view("reports/sale_reports",$data);
        $this->load->view("bottom");
    }
    function _view_acc_payments($a){
            $this->_check_auth(3);
            if($this->_is_account($a)){
            /*$data["ledger_info"] = $this->account->get_ledger_info($a);*/
            $data["sales"] = $this->account->get_ledger_payment($a);
            /*$this->load->view("reports/view_sales",$data);*/
            $this->load->view("top");
            $this->load->view("reports/payment_reports",$data);
            $this->load->view("bottom");
        }
        else{
            show_404();
        }
    }
    function _view_acc_sales($a){
            $this->_check_auth(3);
            if($this->_is_account($a)){
            /*$data["ledger_info"] = $this->account->get_ledger_info($a);*/
            $data["sales"] = $this->account->get_ledger_sales($a);
            /*$this->load->view("reports/view_sales",$data);*/
            $this->load->view("top");
            $this->load->view("reports/sale_reports",$data);
            $this->load->view("bottom");
        }
        else{
            show_404();
        }
    }
    function _sales_datewise($d){
            $d = date("Y-m-d",strtotime($d));
            $data["sales"] = $this->report->get_all_sales_parchi_by_date($d);
            $this->load->view("top");
            $this->load->view("reports/sale_reports",$data);
            $this->load->view("bottom");
        }
    function _payments_datewise($d){
            $d = date("Y-m-d",strtotime($d));
            $data["payments"] = $this->report->get_all_payment_parchi_by_date($d);
            $this->load->view("top");
            $this->load->view("reports/payment_reports",$data);
            $this->load->view("bottom");
        }
    function _is_account($a){
        if(empty($a))return false;
        if($this->account->is_account($a))return true;
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