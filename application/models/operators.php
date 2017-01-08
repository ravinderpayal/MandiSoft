<?php

Class Operators extends CI_Model {

    function login($username, $password,$firm) {
        $this->db->select('o_id,o_name,o_username,o_rights');
        $this->db->from('operators');
        $this->db->where('o_username', $username);
        $this->db->where('o_password', hash('sha256',$password));
        $this->db->where('operator_of', $firm);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function create($o){
        $this->db->select('o_id,o_name,o_username,o_rights');
        $this->db->from('operators');
        $this->db->where('o_username', $o["o_username"]);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return false;
        } else {
            $o["o_password"] = hash('sha256',$o["o_password"]);
            $this->db->insert('operators', $o);
            return true;
        }
        
    }
    
    function is_username_available($u){
        $this->db->select('o_id,o_name,o_username,o_rights');
        $this->db->from('operators');
        $this->db->where('o_username', $u);
        $this->db->limit(1);
        $query = $this->db->get();
        return !( $query->num_rows() == 1 );
    }

    /*
     # return all patients
     */

    
    function all_admins() {
        $query = $this->db->from('operators')->get(); //type 2 is for patients
        return $query->result();
        }
    }
