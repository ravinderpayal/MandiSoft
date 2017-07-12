<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('operators', '', TRUE);
    }

    function index() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('firm', 'Firm Name', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback__login');

        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.  User redirected to login page
           // 0redirect(base_url() . 'login', 'refresh');
            $this->load->model('firm');
            $this->firm->is_exists() or  (redirect(base_url() . 'home', 'refresh') && exit);
            $data["firms"]=$this->firm->listFirm();
            $this->load->view('login_view',$data);
        }
        else {
            redirect(base_url() . 'home', 'refresh');
        }
    }
    function _login(){
        $u = $this->input->post('username');
        $p = $this->input->post('password');
        $f = $this->input->post('firm');
        $result = $this->operators->login($u, $p,$f);
        if ($result){
            $result = $result[0];
            $sess_array = array();
            $sess_array = array('id' => $result->o_id,'username' => $result->o_username,'access_right' => $result->o_rights,"language"=>$this->input->post('lang'),"firm_id"=>$f);
            $this->session->set_userdata('logged_in', $sess_array);
            return true;
        }
        else{
            $this->form_validation->set_message('_login', 'Wrong Username / Password');
            return false;
        }
    }
}