<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logout extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->session->unset_userdata('logged_in');
        //session_destroy();
        $this->load->helper('form');
        redirect(base_url() . 'login', 'refresh');
    }

}

?>