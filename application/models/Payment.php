<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
Class payment extends CI_Model {
    /*function pay(){
        $query = $this->db->get('payment_mode');
        return $query->result();
    }*/

    function collect($a){/**Receiving Money**//**$a -> info array**/
        $this->db->trans_start();
        $this->db->insert("payment",$a);
        $payment_id = $this->db->insert_id();
        $old_data = $this->db->query("SELECT account_balance,crate_balance FROM accounts WHERE `acc_id` = '".$a["acc_id"]."' FOR UPDATE");
        $old_data = $old_data ->row(0);
        $old_balance = $old_data->account_balance;
        $old_crate = $old_data->crate_balance;
        /*
         * Calculating new values
         */
        
        $new_balance = $old_balance +( $a["amount"] + $a["rebate"]);
        $new_crate   = $old_crate;
        
        /*
         * The net amount of item sold is adjusted in main/account balance of ACCOUNT
         * and Total crates given to ACCOUNT is adjusted in crate balance of ACCOUNT
         */
        
        $this->account->updateBalance($a["acc_id"],$a["amount"]+$a["rebate"],0);
        /*
         * Clearing Debts Table and add receivings to item_sale table
         */
        if($a["related_sell"])$this->item_sale->receivePayment($a["related_sell"],$a["amount"]);
        /*
         * The BALANCE activity is stored in `datewise_account_balance` table along with previous and current balance
         */
        $this->payment->addBalanceChangeActivity(array(
                "acc_id"=>$a["acc_id"],
                "new_balance"=>$new_balance,
                "old_balance"=>$old_balance,
                "new_crate" =>$new_crate,
                "old_crate" =>$old_crate,
                "payment_id"=>$payment_id,
                "remarks"=>"Added Automatically By COMPUTER on behalf of receiving an payment from CUSTOMER"
            ));
        $this->db->trans_complete();
        if($this->db->trans_status() == true){
            return $payment_id;
        }
        else{
            return false;
        }
        }
    function pay($a){/*******Paying Money to some else account for some else purpose**********//**$a -> info array**/
        
        $p = $a;
        $p["amount"] = -1 * $p["amount"];
        $p["rebate"] = -1 * $p["rebate"];
        $this->db->trans_start();
        $this->db->insert("payment",$p);
        $payment_id = $this->db->insert_id();
        $old_data = $this->db->query("SELECT account_balance,crate_balance FROM accounts WHERE `acc_id` = '".$a["acc_id"]."' FOR UPDATE");
        $old_data = $old_data ->row(0);
        $old_balance = $old_data->account_balance;
        $old_crate = $old_data->crate_balance;
        /*
         * Calculating new values
         */
        
        $new_balance = $old_balance -( $a["amount"] + $a["rebate"]);
        $new_crate   = $old_crate;
        
        /*
         * The net amount of item sold is adjusted in main/account balance of ACCOUNT
         * and Total crates given to ACCOUNT is adjusted in crate balance of ACCOUNT
         */
        
        $this->account->updateBalance($a["acc_id"],$p["amount"]+$p["rebate"],0);
        /*
         * Clearing Debts Table and add receivings to item_sale table
         */
        if($a["related_stock"])$this->item_sale->makePayment($a["related_stock"],$a["amount"]);
        /*
         * The BALANCE activity is stored in `datewise_account_balance` table along with previous and current balance
         */
        $this->payment->addBalanceChangeActivity(array(
                "acc_id"=>$a["acc_id"],
                "new_balance"=>$new_balance,
                "old_balance"=>$old_balance,
                "new_crate" =>$new_crate,
                "old_crate" =>$old_crate,
                "payment_id"=>$payment_id,
                "remarks"=>"Added Automatically By COMPUTER on behalf of receiving an payment from CUSTOMER"
            ));
        $this->db->trans_complete();
        if($this->db->trans_status() == true){
            return $payment_id;
        }
        else{
            return false;
        }
        }
    function lend($a){/**Firm Sold something on debt**//**$a->array**/
        /*
         * 
         * $a = array(
         *      "acc_id"=>ACCOUNT_ID,
         *      "amount"    =>AMOUNT,
         *      "crates"    =>CRATE,
         * );
         * 
         */
        
        /*
         * 
         * Get account_balance and crate_balance before updating
         * and locks the account row for isolating this instance of db connection
         * 
         */
        $a["crates"] = -1 * $a["crates"];
        $a["amount"] = -1 * $a["amount"];
        $this->db->reset_query();
        $old_data = $this->db->query("SELECT account_balance,crate_balance FROM accounts WHERE `acc_id` = '".$a["acc_id"]."' FOR UPDATE");
        $old_data = $old_data ->row(0);
        $this->db->reset_query();
        $old_balance = $old_data->account_balance;
        $old_crate = $old_data->crate_balance;
        
        /*
         * Calculating new values
         */
        $new_balance = $old_balance + $a["amount"];
        $new_crate   = $old_crate + $a["crates"];
        /*
         * The net amount of item sold is adjusted in main/account balance of ACCOUNT
         * and Total crates given to ACCOUNT is adjusted in crate balance of ACCOUNT
         */
        $this->account->updateBalance($a["acc_id"],$a["amount"],$a["crates"]);
        /*
         * The BALANCE activity is stored in `datewise_account_balance` table along with previous and current balance
         */
        $this->payment->addBalanceChangeActivity(array(
                                            "acc_id"=>$a["acc_id"],
                                            "new_balance"=>$new_balance,
                                            "old_balance"=>$old_balance,
                                            "new_crate" =>$new_crate,
                                            "old_crate" =>$old_crate,
                                            "sale_id"   =>$a["sale_id"],
                                            "remarks"=>"Added Automatically By COMPUTER on behalf of selling a item"
                                             ));
        $this->db->reset_query();
        $this->db->insert("debts",array("acc_id"=> $a["acc_id"],"amount"=>(-1 * $a["amount"]),"related_sell"=>$a["sale_id"]));
        $this->db->reset_query();
        /* changed by computer on behalf of selling a item on debt */
    }
    function addBalanceChangeActivity($a){/***$a is array****/
                $this->db->insert("datewise_account_balance",$a);
    }
    function _new($a){/***********$a -> array ****************/
        /*
         * 
         * $a = array(
         *      "acc_id"        =>  ACCOUNT_ID,
         *      "amount"        =>  AMOUNT,
         *      "crates"        =>  CRATES,
         *      "sale_id"       =>  SALE_ID,
         *      "payment_mode"  =>  MODE_OF_PAYMENT
         *      );
         * 
         */
        if($a["payment_mode"] == 1){
            $this->payment->lend($a);
        }
        else if($a["payment_mode"] == 2 ){
            /******Need to Modify A function*********/
                $this->payment->cashSell($a);
        }
    }

    /**
     *
     * Function for recording purchase transactions
     *
     */
    function new_purchase($a){/**Receiving Money**//**$a -> info array**/
            $this->db->trans_start();
            $old_data = $this->db->query("SELECT account_balance,crate_balance FROM accounts WHERE `acc_id` = '".$a["purchased_from"]."' FOR UPDATE");
            $old_data = $old_data ->row(0);
            $old_balance = $old_data->account_balance;
            $old_crate = $old_data->crate_balance;

            /*
             * Calculating new values
             */
            $new_balance = $old_balance +( $a["net_rate"] - $a["rebate"]);
            $new_crate   = $old_crate;

            /*
             * The net amount of item sold is adjusted in main/account balance of ACCOUNT
             * and Total crates given to ACCOUNT is adjusted in crate balance of ACCOUNT
             */
            $this->account->updateBalance($a["purchased_from"],$a["amount"]-$a["rebate"],0);

             /*
             * The BALANCE activity is stored in `datewise_account_balance` table along with previous and current balance
             */
             var_dump($old_crate);
            $this->payment->addBalanceChangeActivity(array(
                "acc_id"=>$a["purchased_from"],
                "new_balance"=>$new_balance,
                "old_balance"=>$old_balance,
                "new_crate" =>$new_crate,
                "old_crate" =>$old_crate,
                "purchase_id"=>$a["purchase_id"],
                "remarks"=>"Added Automatically By COMPUTER on behalf of making an purchase"
            ));
            $this->db->trans_complete();
            if($this->db->trans_status() == true){
                return $purchase_id;
            }
            else{

                return false;
            }
        }


     function delete($a){
        $this->db->trans_start();
        $this->db->query("INSERT INTO `deleted_payments`( select * from payment where payment_id = $a)");
        $query = $this->db->query("select * from payment where payment_id = $a");
        if(!isset($query->result()[0])){
            return false;
        }
        $info = $query->result()[0];
        $amount =-1*( $info -> amount + $info -> rebate);
        $this->account->updateBalance($info->acc_id,$amount,0);
        $this->db->query("DELETE FROM payment WHERE payment_id =  $a");
        $this->db->query("UPDATE `datewise_account_balance` SET new_balance = (new_balance + $amount) , old_balance = (old_balance + $amount) WHERE datetime > \"$info->datetime\" and acc_id = $info->acc_id");
        $this->db->trans_complete();

        /*
         * 
         * Transaction is completed either all data is saved or nothing is saved
         * 
         */
        if($this->db->trans_status() == true){
            return true;
        }
        else{
            return false;
        }
    }
}