<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Common extends CI_Model
{
    function __construct()
    {
        //if(!$this->session->userdata('firm_id') and $this->session->userdata('operator_id'))exit("{\"out\":\"You are not allowed to access this page. Company/Firm Not Selected\}");
        $this->db->limit(1);
        $query = $this->db->get('firms');

        if ($query->num_rows() == 1){
            $result = $query->result()[0];
            $this->firm = array('id' => $result->firm_id,'name' => $result->firm_name,'add' => $result->firm_add,'contact'=>$result->firm_contact);
        }else{
            redirect(base_url() . 'install', 'refresh');
        }

    }
}