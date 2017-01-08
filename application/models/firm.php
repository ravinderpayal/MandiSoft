<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
Class Firm extends CI_Model
{
    function __construct()
    {
    }
    function is_exists()
    {
        $query = $this->db->get('firms');

        if ($query->num_rows() >= 1)
        {
            return true;
        }
        return false;
    }
    function add(array $firm){
        $this->db->trans_start();
        $this->db->insert("firms",$firm);
        $payment_id = $this->db->insert_id();
        return $payment_id;
    }
    function addMaster(array $master){
        $this->db->insert("operators",$master);
        $payment_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $payment_id;
    }
    function listFirm()
    {
        $query = $this->db->get('firms');

        if ($query->num_rows() >= 1)
        {
            return $query->result();
        }
        return false;
    }
}