<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Reports extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url() . 'login', 'refresh');
        }
        $this->load->model('report', '', TRUE);
        $this->load->model('user', '', TRUE);
    }

    function index() {
        $this->check_auth();
        //$data['reports'] = $this->report->all();
        $this->load->view('UNDER_CONSTRUCTION');
    }


}

?>