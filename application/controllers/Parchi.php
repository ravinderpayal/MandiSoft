<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Parchi extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        $this->load->model('account', '', TRUE);
        $this->load->model('operators', '', TRUE);
        $this->load->model('general', '', TRUE);
        $this->load->model('item_sale', '', TRUE);
        $this->load->model('report', '', TRUE);
    }

    function index() {        
            $this->_check_auth(4);
            $this->load->view("parchi/home");
    }
    function datewise($d){
        $d = date("Y-m-d",strtotime($d));
        $parchis = $this->report->get_all_parchi_by_date($d);
        $this->load->view("top");
        $i=0;
       foreach($parchis as $parchi){
            $data["sale"] = $parchi;
            if($i!=0)$data["not_first"] = true;
            $data["multiple"] = true;
            $data["no_head"] = true;
            $data["no_top_head"] = false;
            if($i!=0){
                $data["no_top_head"] = true;
            }
            $data["no_stamp"] = true;
            $this->load->view("reports/parchi",$data);
            $i++;
            unset($data);
       }
            $this->load->view("bottom");

        }
    function sale($a){
            $this->_check_auth(3);
            $data["sale"] = $this->report->get_sale_parchi($a);
            if($data["sale"]){
            //$data["ledger_info"] = $this->account->get($data["sale"]->sold_to);
            $this->load->view("reports/parchi_view",$data);
            }
            else{
               show_404();
            }
    }
    function payment($a){
            $this->_check_auth(3);
            $data["payment"] = $this->report->get_payment_parchi($a);
            if($data["payment"]){
               $data["view"]     = "payments/parchi";
               $this->load->view("blank",$data);
            }
            else{
               show_404();
            }
        }
    function view_sales($a=""){
            $this->_check_auth(3);
            if($this->_is_account($a)){
            $data["ledger_info"] = $this->account->get_ledger_info($a);
            $data["no_top_head"] = true;
            $data["sales"] = $this->report->get_acc_sales($data["ledger_info"]->acc_id);
            $this->load->view("reports/view_sales",$data);
        }
        else{
            show_404();
        }
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