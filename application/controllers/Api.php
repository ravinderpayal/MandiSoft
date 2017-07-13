<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Api extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('account', '', TRUE);
        $this->load->model('operators', '', TRUE);
        $this->load->model('general', '', TRUE);
    }

    function index() {        
    }
    
    function customers(){
        $this->_check_auth(4);
        $accnts = $this->account->get_all_customers();
        $names = array();
        foreach ($accnts as $value) {
            $names[]=array("label" => $value->acc_name."(".$value->acc_area.")",
                "value" => $value->acc_id,
                "ledger_num" => $value->ledger_number,
                "ledger_balance" => $value->account_balance
                    );
        }
        echo json_encode($names);
    }
    function supliers(){
        $this->_check_auth(4);
        $accnts = $this->account->get_all_supliers();
        $names = array();
        foreach ($accnts as $value) {
            $names[]=array("label" => $value->acc_name."(".$value->acc_area.")",
                "value" => $value->acc_id,
                "ledger_num" => $value->ledger_number,
                "ledger_balance" => $value->account_balance
                    );
        }
        echo json_encode($names);
    }
    function item_types(){
        $this->_check_auth(4);
        $types = $this->general->get_item_types();
        $names = array();
        foreach ($types as $value) {
            $names[]=array("label" => $value->i_name,
                           "type_id" => $value->item_id
                    );
        }
        echo json_encode($names);
    }
    function _check_auth($r) {//$r->rights required to access the page
        if(!$this->session->userdata('logged_in'))exit("{\"out\":\"You are not allowed to access this page\}");
        if(!($this->session->userdata('logged_in')["access_right"]<=$r))exit("{\"out\":\"You are not allowed to access this page\}");
    }

}

?>