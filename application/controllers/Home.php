<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('report', '', TRUE);
    }

    function index() {
        $this->_check_auth(4);
        $data['sales'] = $this->report->latest_sale();
        $data['payments'] = $this->report->latest_payments();
        $data['defaulters'] = $this->report->defaulters();

        $daywiseSaleAmount = $this->report->daywiseSaleAmount(3);
        $daywisePaymentAmount = $this->report->daywisePaymentAmount(3);
        $daywiseAccountBalance = $this->report->daywiseAccountBalance(3);

        $data['daywiseSaleAmount'] =  "";
        $data['daywiseSaledates'] =  "";
        foreach($daywiseSaleAmount as $ds){
            $data['daywiseSaleAmount'].="$ds->amount ,";
            $data['daywiseSaledates'].="\"$ds->sale_date\" ,";
        }
        $data['daywiseSaleAmount'] = rtrim($data['daywiseSaleAmount']);
        $data['daywiseSaledates'] = rtrim($data['daywiseSaledates']);

        $data['daywisePaymentAmount'] =  "";
        foreach($daywisePaymentAmount as $dp){
            $data['daywisePaymentAmount'].="$dp->Camount ,";
        }
        $data['daywisePaymentAmount'] = rtrim($data['daywisePaymentAmount']);

        $this->load->view('home_view', $data);
        }

    function logout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('home', 'refresh');
    }
    function _check_auth($r) {//$r->rights required to access the page
        if(!$this->session->userdata('logged_in'))exit("{\"out\":\"You are not allowed to access this page\}");
        if(!($this->session->userdata('logged_in')["access_right"]<=$r))exit("{\"out\":\"You are not allowed to access this page\}");
        $this->lang->load('labels', $this->session->userdata('logged_in')["language"]);
    }
}