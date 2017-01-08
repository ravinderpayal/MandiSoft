<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class migratexJJx34ty extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->_check_auth();
        $this->load->library('migration');

                if ($this->migration->current() === FALSE)
                {
                        show_error($this->migration->error_string());
                }
                else{
                    echo "<body bgcolor=\"black\" style=\"color:#fff\">Migration Done</body>";
                    unlink(__FILE__);
                }
         }

    function _check_auth($r=1) {//$r->rights required to access the page
        if(!$this->session->userdata('logged_in'))exit("{\"out\":\"You are not allowed to access this page\}");
        if(!($this->session->userdata('logged_in')["access_right"]<=$r))exit("{\"out\":\"You are not allowed to access this page\}");
        $this->lang->load('labels', $this->session->userdata('logged_in')["language"]);
    }
}