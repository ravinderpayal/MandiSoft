<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        if ($this->session->userdata('logged_in')) {
            redirect(base_url() . 'home', 'refresh');
        } else {
            $this->load->model('firm');
            $this->firm->is_exists() or  (redirect(base_url() . 'home', 'refresh') && exit);
            $data["firms"]=$this->firm->listFirm();
            $this->load->helper('form');
            $this->load->view('login_view',$data);
        }
    }

}

?>