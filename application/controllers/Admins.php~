<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Admins extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url() . 'login', 'refresh');
        }
        $this->load->model('operators', '', TRUE);
        $this->load->model('report', '', TRUE);
    }

    function index() {
        $this->_check_auth(1);
        $data['admins'] = $this->operators->all_admins();
        $this->load->view('admins/view_all', $data);
    }

    function add() {
        $this->_check_auth(1);
        $this->load->library('form_validation');
        $this->_show_add();
    }
    function _show_add($m = FALSE){
        if($m)$this->data['message']  = $m;
        $this->data["view"]='admins/add';
        $this->load->view('blank', $this->data);
    }

    function create() {
        $this->_check_auth(1);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('username', 'User Name', 'trim|required|callback__is_username_available');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[256]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[12]');
        $this->form_validation->set_rules('rights', 'Rights', 'required|greater_than_equal_to[1]|less_than_equal_to[5]');
        $this->form_validation->set_rules('phone', 'Mobile/Phone Number', 'trim|regex_match[/^[789][0-9]{9}$/]');
        
        if ($this->form_validation->run() == TRUE){
        $admin["o_name"] = $this->input->post('name');
        $admin["o_username"] = $this->input->post('username');
        $admin["o_password"] = $this->input->post('password');
        $admin["o_email"] = $this->input->post('email');
        $admin["o_phone"] = $this->input->post('phone');
        $admin["o_rights"] = $this->input->post('rights');
        $admin["operator_of"] = $this->session->userdata('logged_in')["firm_id"];
            
        if ($this->operators->create($admin)) {
            redirect(base_url() . 'admins', 'refresh');
        }else {
            $this->_show_add( 'User already exist,try with different username and passowrd');
        }
        }
        else{
            $this->_show_add();
        }
    }
    
    function _is_username_available($a){
        if($this->operators->is_username_available($a)){
            return true;
        }
        else{
            $this->form_validation->set_message('_is_username_available', 'The  Username you entered is not available!');            
            return false;
        }
    }

    function _check_auth($r) {//$r->rights required to access the page
        if(!$this->session->userdata('logged_in'))exit("{\"out\":\"You are not allowed to access this page\}");
        if(!($this->session->userdata('logged_in')["access_right"]<=$r))exit("{\"out\":\"You are not allowed to access this page\}");
    }

}

?>