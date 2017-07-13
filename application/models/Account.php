<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
Class account extends CI_Model {
    /*
     * return all reports
     */
    function updateBalance($a,$b,$c){/***$a -> account id , $b -> amount***/
        $this->db->reset_query();
        $this->db->set('account_balance', 'account_balance + ('.$b.')',false);
        $this->db->set('crate_balance', 'crate_balance + ('.$c.')',false);
        $this->db->where('acc_id',$a);
        $this->db->update('accounts');
        $this->db->reset_query();
    }
    
    /**
     * 
     * Function for saving changes in database done by `atd` function in Controller (Accounts).
     * @param int $a
     * @return boolean
     * 
     */
    function atd($a){
        $this->db->reset_query();
        $this->db->set('group_id', 6,false);
        $this->db->where('acc_id',$a);
        if($this->db->update('accounts')){
        $this->db->reset_query();
        return true;
        }
        return false;
    }
    function get_all($a=array()){
        if(isset($a[0]) and isset($a[1])){
            $this->db->limit(1+$a[1]-($a[0]<$a[1]?($a[0]):(-1*$a[0])),$a[0]-1);
        }
        elseif(isset($a[0])){
            $this->db->limit($a[0]);
        }
        $query = $this->db->order_by("acc_area")->order_by("account_balance")->get('accounts');
        return $query->result();
    }
    function search($s,$b){
        $query = $this->db->where(array("firm_id"=>$b))->and_like("acc_name",$s,"both",true)->or_like("acc_name_ll",$s,"both",false)->or_like("acc_area",$s,"both",true)->or_like("acc_city",$s,"both",true)->or_like("mobile_number1",$s,"both",true)->or_like("mobile_number2",$s,"both",true)->get('accounts');
        return $query->result();
    }
    function searchDidYouMean($a){
        $query = $this->db->order_by("levenshtein(`acc_name`, '".$a."')")->limit(3)->get("accounts");
        return $query->result();
    }
    function get_defaulters(){
        $query = $this->db->where("(account_balance<0 or crate_balance<0) and MONTH(datetime)<(MONTH(now())-1)")->get('accounts');
        return $query->result();
    }
    function get_active($a){/***$a->Date****/
        $query = $this->db->where("DATE(datetime)>=\"$a\"")->get('accounts');
        return $query->result();
    }
    function get_all_customers(){
        $query = $this->db->get_where('accounts',array("group_id"=>1));
        return $query->result();
    }
    function get_all_supliers(){
        $query = $this->db->get_where('accounts',array("group_id"=>3));
        return $query->result();
    }

    function account_reports() {
        $query=$this->db->get_where("account_group",array("group_id"=> $a));
        return $query->result();
    }
    
    function account_groups(){
        $query = $this->db->get('account_group');
        return $query->result();
    }
    function is_account_group($a){
                $query=$this->db->get_where("account_group",array("group_id"=> $a));
                return ($query->num_rows()==1);
    }
    function is_account($a,$b){
        $query=$this->db->get_where("accounts",array("acc_id"=> $a,"firm_id"=>$b));
                return ($query->num_rows()==1);
    }
    function is_customer($a){
        $query=$this->db->get_where("accounts",array("acc_id"=> $a , "group_id" =>1));
        return ($query->num_rows()==1);
    }
    function is_supplier($a){
        $query=$this->db->get_where("accounts",array("acc_id"=> $a , "group_id" =>3));
        return ($query->num_rows()==1);
    }
    function is_employee($a){
        $query=$this->db->get_where("accounts",array("acc_id"=> $a , "group_id" =>2));
        return ($query->num_rows()==1);
    }
    function is_ledger($a){
            $query=$this->db->get_where("accounts",array("ledger_number"=> $a));
            return ($query->num_rows()==1);
    }

    function get($a,$b) {
        $query = $this->db->get_where("accounts",array("acc_id"=>$a,"firm_id"=>$b));
        $result = $query->result();
            if($result)return $result[0];
            else return false;
    }
    function get_ledger_info($a){
            $query = $this->db->select('acc_id,acc_name,acc_name_ll,ledger_number,acc_address1,acc_area,acc_city,mobile_number1,mobile_number2,account_balance')->where('ledger_number', $a)->get('accounts');
            $result =  $query->result();
            if($result)return $result[0];
            else return false;
    }
    function get_last_id(){
            $query = $this->db->select('acc_id,ledger_number')->order_by('acc_id', 'DESC')->limit(1)->get('accounts');
            $result =  $query->result();
            if($result)return $result[0];
            else return false;
    }
    function get_account($a){
        $query = $this->db->get_where('account', array('acc_id' => $a));
            $result =  $query->result();
            if($result)return $result[0];
            else return false;
    }
    
    function get_acc_sales($a){
                $query = $query = $this->db->query(
                        "SELECT * FROM (SELECT a.`acc_id`,a.`acc_name`, s.sale_id, s.quantity,s.rebate,qt.qnt_sign, s.rate, s.rebate AS sale_rebate,s.item_lot,DATE(s.datetime) AS sale_datetime, s.sale_date AS sale_date, dab.old_balance, dab.new_balance FROM `item_sale` as s LEFT JOIN `accounts` a ON ( a.`acc_id` = $a ) LEFT JOIN `datewise_account_balance` dab ON (dab.sale_id = s.sale_id) JOIN `quantity_types` as qt ON(qt.qnt_id = s.quantity_type) WHERE s.`sold_to` = $a ORDER BY s.`datetime DESC LIMIT 10) ORDER BY s.datetime ASC`"
                );
                return $query->result();
    }
    /**
    *
    * @param $a Ledger Number/ID
    * @param $b Limit 1 for Number of Entries to be fetched
    * @param $c Limit 2 for Number of Entries to be fetched
    * @param $d Date after which Entries to be fetched
    * @param $e Date before which Entries to be fetched
    *
    */
    function get_ledger_sales($a,$b=100,$c=100,$d,$e){
                $query = $query = $this->db->query(
                        "SELECT * FROM (SELECT s.`sold_to`,a.`acc_name`, s.sale_id, s.quantity,s.rebate,qt.qnt_sign,s.rate,"
                        . " s.rebate AS sale_rebate,s.item_lot,s.datetime,s.sale_date AS sale_date, dab.old_balance, dab.new_balance"
                        . " FROM `item_sale` as s"
                        . " JOIN `accounts` a ON ( s.`sold_to` = a.`acc_id` )"
                        . " LEFT JOIN `datewise_account_balance` dab ON (dab.sale_id = s.sale_id) JOIN `quantity_types` as qt"
                        . " ON(qt.qnt_id = s.quantity_type) WHERE a.ledger_number=$a and s.sale_date>='$d' and s.sale_date<='$e'"
                        . " ORDER BY s.`datetime` DESC LIMIT $b ) as f ORDER BY f.datetime ASC LIMIT $c"
                );
                return $query->result();
    }
    function get_acc_payment($a){
                $query = $this->db->query(
                        'SELECT'
                        . ' p.amount as amount_received,'
                        . 'p.rebate,'
                        . 'date(p.`datetime`) as payment_date,'
                        . 'p.`make_date`,'
                        . ' dab.old_balance, dab.new_balance'
                        . ' FROM '
                        . '`payment` as p '
                        . 'LEFT JOIN `datewise_account_balance` dab ON (dab.payment_id = p.payment_id)'
                        . ' JOIN accounts as a'
                        . ' ON(p.acc_id = a.acc_id) '
                        . 'WHERE a.acc_id='.$a
                        . ' ORDER BY p.`datetime` LIMIT 30'
                );
                return $query->result();
    }

    /**
    *
    * @param $a Ledger Number/ID
    * @param $b Limit 1 for Number of Entries to be fetched
    * @param $c Limit 2 for Number of Entries to be fetched
    * @param $d Date after which Entries to be fetched
    * @param $e Date before which Entries to be fetched
    *
    */
    function get_ledger_payment($a,$b=20,$c=20,$d,$e){
                $query = $query = $this->db->query(
                         "SELECT * FROM (SELECT  p.payment_id as payment_id, p.amount as amount_received,"
                        ." p.rebate,date(p.`datetime`) as payment_date,p.`make_date`, dab.old_balance,"
                        ." dab.new_balance FROM `payment` as p LEFT JOIN `datewise_account_balance` dab"
                        ." ON (dab.payment_id = p.payment_id)  JOIN accounts as a ON(p.acc_id = a.acc_id)"
                        ." WHERE a.ledger_number=$a and p.make_date>='$d' and p.make_date<='$e' ORDER BY p.`make_date` DESC LIMIT $b ) as f ORDER BY f.make_date ASC LIMIT $c"
                );
                return $query->result();
    }
    function get_ledger_paymentTotal($a){
                $query = $this->db->query("SELECT sum(amount) as total FROM  `payment`  WHERE acc_id=$a");
                return $query->result()[0]->total;
    }
    function get_ledger_salesTotal($a){
                $query = $query = $this->db->query("SELECT sum(rate*quantity) as total FROM `item_sale` WHERE sold_to=$a");
                return $query->result()[0]->total;
    }
    
    function create_relation($a){
        try {
            $query = $this->db->insert_batch('related_accounts', $a);
            return $query;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        
    }

    function create($a) {
        try {
            if( $this->db->insert('accounts', $a)){
                $acc_id = $this->db->insert_id();
                $this->payment->addBalanceChangeActivity(array(
                                                                "acc_id"=>$acc_id,
                                                                "new_balance"=>$a["account_balance"],
                                                                "old_balance"=>0,
                                                                "new_crate" =>$a["crate_balance"],
                                                                "old_crate" =>0,
                                                                "remarks"=>"Added Automatically By COMPUTER on behalf of creating an account"
                                                        ));

                return $acc_id;
            }
            else{ return false;}
        } catch (Exception $exc){
            echo $exc->getTraceAsString();
        }
    }
    
    function check_unique($a,$b){
                $this->db->where($a,$b);
                return $this->db->get_result();
    }

    function update_extra_details($id, $test) {
        $this->db->where('id', $id);
        $this->db->update('report_details', array('test_name' => $test['name'], 'test_value' => $test['measurement']));
    }
    function get_opening_balance($a){
                $query = $query = $this->db->query("SELECT * FROM `datewise_account_balance` where acc_id=$a LIMIT 1");
                return $query->result()[0];
    }
    function delete($account_id) {
//        $this->db->delete('account_details', array('report_id' => $account_id));
       // $this->db->delete('reports', array('id' => $account_id));
    }
    function insert_extra_details($details_object){
/*        try {
            $query = $this->db->insert_batch('report_details', $details_object);
            return $query;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }*/
    }
}