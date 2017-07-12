<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Install extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('firm', '', TRUE);
    }

    function index() {
        !$this->firm->is_exists()         or    (redirect(base_url() . 'login', 'refresh') && exit);
        $this->load->view('install/install');
    }
    function install(){
        !$this->firm->is_exists()         or    (redirect(base_url() . 'login', 'refresh') && exit);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('firmname', 'Firm Name', 'trim|required|min_length[3]|max_length[512]');
        $this->form_validation->set_rules('firmcontact', 'Account Mobile Number(2nd)', 'trim|is_natural_no_zero');
        $this->form_validation->set_rules('firmadd', 'Firm Address', 'trim');
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|min_length[3]|max_length[64]');
        $this->form_validation->set_rules('user_pass', 'User Password', 'trim|required|min_length[4]|max_length[20]');
        if ($this->form_validation->run() == TRUE) {
            $firm["firm_name"] = $this->input->post('firmname');
            $firm["firm_contact"] = $this->input->post('firmcontact');
            $firm["firm_add"] = $this->input->post('firmadd');
            $master["o_name"] = $this->input->post('user_name');
            $master["o_password"] = hash('sha256',$this->input->post('user_pass'));
            $master["o_username"] = $this->input->post('user_name');
            $firm_id=$this->firm->add($firm);
            $master["operator_of"] = $firm_id;
            $master["o_rights"]="1";
            $master["o_email"]="NA";
            $master["o_phone"]="NA";
            $this->firm->addMaster($master);
        }
        else{
            $this->load->view('install/install');
        }
        }
    function _check_auth($r) {//$r->rights required to access the page
        if(!$this->session->userdata('logged_in'))exit("{\"out\":\"You are not allowed to access this page\}");
        if(!($this->session->userdata('logged_in')["access_right"]<=$r))exit("{\"out\":\"You are not allowed to access this page\}");
    }

}

?>