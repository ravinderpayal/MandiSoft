<?php
class Report extends CI_Model {
    /*
     * return all reports
     */

    function all($account_id) {
        $query = $this->db->get_where('item_sale', array('acc_id' => $report_id));
        return $query->result();
    }

    function latest_sale($l = 10) {
        $query = $query = $this->db->query('SELECT * FROM `item_sale`,`accounts`,`quantity_types` where acc_id = sold_to and qnt_id = quantity_type ORDER BY sale_id DESC LIMIT '.$l);
        return $query->result();
    }
    function latest_payments($l = 10) {
        $query = $query = $this->db->query('SELECT * FROM `payment` as p,`accounts` as a where a.acc_id = p.acc_id ORDER BY payment_id DESC LIMIT '.$l);
        return $query->result();
    }
    function daywiseAmount($l = 10) {
        /*CONCAT(DAY(sale_date)," ",MONTHNAME(sale_date)) as*/
        $query = $query = $this->db->query('SELECT * FROM (SELECT  sale_date,sum(rate * quantity) as Samount,sum(amount) as Camount FROM `item_sale` as i , `payment` as p  GROUP BY WEEK(i.sale_date)  ORDER BY DATE(sale_date) DESC LIMIT '.$l.') as f ORDER BY DATE(f.sale_date) ASC');
        return $query->result();
    }
    function daywiseSaleAmount($l = 10) {
        $query = $query = $this->db->query('SELECT * FROM (SELECT sale_date,sum(rate * quantity) as amount FROM `item_sale` GROUP BY WEEK(sale_date)  ORDER BY sale_date DESC LIMIT '.$l.') as f ORDER BY f.sale_date ASC');
        return $query->result();
    }
    function daywisePaymentAmount($l = 10) {
        $query = $query = $this->db->query('SELECT * FROM (SELECT make_date,sum(amount) as Camount FROM `payment` GROUP BY WEEK(make_date)  ORDER BY make_date DESC LIMIT '.$l.') as f ORDER BY f.make_date ASC');
        return $query->result();
    }
    function daywiseAccountBalance($l = 10) {
        $l=5;
        $query = $query = $this->db->query('SELECT * FROM (SELECT make_date,sum(amount) as Camount FROM `payment` GROUP BY WEEK(make_date)  ORDER BY make_date DESC LIMIT '.$l.') as f ORDER BY f.make_date ASC');
        return $query->result();
    }
    function get_acc_sales($a){
        $query = $query = $this->db->query('SELECT * FROM `item_sale` WHERE sold_to ='.$a.' ORDER BY sale_id DESC LIMIT 10');
        return $query->result();
    }
    function get_all_payment_parchi_by_date($d){
        $query = $this->db->query('SELECT * FROM `payments` as p,`accounts` as a WHERE a.acc_id = p.acc_id and make_date ="'.$d.'"');
        if($query)return $query->result();
        else return false;
    }
    function get_all_parchi_by_date($d){
        $query = $this->db->query('SELECT * FROM `item_sale` as s,`accounts` as a,`quantity_types` WHERE a.acc_id = s.sold_to and qnt_id = quantity_type and sale_date ="'.$d.'"');
        if($query)return $query->result();
        else return false;
    }
    function get_all_sales_parchi_by_date($d){
        $query = $this->db->query('SELECT * FROM `item_sale` as s,`accounts` as a,`quantity_types` WHERE a.acc_id = s.sold_to and qnt_id = quantity_type and sale_date ="'.$d.'"');
        if($query)return $query->result();
        else return false;
    }
    function get_sale_parchi($a){
        $query = $query = $this->db->query('SELECT * FROM `item_sale` s , accounts as a WHERE s.sale_id ='.$a.' and a.acc_id=s.sold_to');
        $result = $query->result();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
    function get_payment_parchi($a){
        $query = $query = $this->db->query('SELECT * FROM `payment` p , accounts as a WHERE p.payment_id ='.$a.' and a.acc_id=p.acc_id');
        $result = $query->result();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }

    function defaulters($l=20){
        $query = $this->db->query(
                'SELECT  acc.`acc_id`,acc.`ledger_number`,`acc_name`,acc.`account_balance`,acc.`datetime`,(select sum(sale.`rate` * sale.`quantity` - sale.`rebate`) from `item_sale` as sale where `sold_to` = acc.`acc_id`) as total_sale FROM `accounts` as acc WHERE acc.`group_id`=1 ORDER BY (total_sale - acc.`account_balance`) ASC  LIMIT '.$l
                );
        if($query)return $query->result();
    }
    /*
     * return report details
     */

    function report_details($report_id) {
        $query = $this->db->get_where('report_details', array('report_id' => $report_id));
        return $query->result();
    }

    function get_report($report_id) {
        $query = $this->db->get_where('reports', array('id' => $report_id));
        return $query->result();
    }

    /*
     * create report and return created object 
     */

    function create($patient_id, $created_at) {
        $data = array(
            'patient_id' => $patient_id,
            'created_at' => $created_at
        );
        try {
            $this->db->insert('reports', $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        $query = $this->db->get_where('reports', array('patient_id' => $patient_id, 'created_at' => $created_at));
        //var_dump($query->result());
        foreach ($query->result() as $row) {
            $report_result = array(
                'id' => $row->id,
                'createad_at' => $row->created_at
            );
        }
        return $report_result;
    }

    function update($id, $test) {
        $this->db->where('id', $id);
        $this->db->update('report_details', array('test_name' => $test['name'], 'test_value' => $test['measurement']));
    }

    function delete($report_id) {
        $this->db->delete('report_details', array('report_id' => $report_id));
        $this->db->delete('reports', array('id' => $report_id));
    }

    function insert_details($details_object) {
        try {
            $query = $this->db->insert_batch('report_details', $details_object);
            return $query;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}