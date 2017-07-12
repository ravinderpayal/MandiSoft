<?php
defined('BASEPATH')
    or exit('No direct script access allowed');
Class InvoiceCustomer extends CI_Model {
    function save($invoice){
            $this->couchdb->addDocument($invoice);
    }
}

abstract class Array2Object{
    function check($arg,$key){
       return isset($arg[$key])?$arg[$key]: $this->throw("Provide ".$key."!");
    }
    function throw($msg){
        throw new Exception($msg);
        return false;
    }
}
class Invoice extends Array2Object{
    function __construct($arg){
            $this->account_id = $this->check($arg,'account_id');
            $this->invoice_total = $this->check($arg,'total');
            $this->tax_total = $this->check($arg,'tax_total');
            $this->tax_detail = $this->check($arg,'tax_detail');
            $ths->item_total = $this->check($arg,'item_total');
            $this->item_detail = $this->check($arg,'item_detail');
    }
}

class InvoiceItemDetail extends Array2Object{
    function __construct($arg){
            $this->stock_id = $this->check($arg,'stock_id');
            $this->stock_item = $this->check($arg,'stock_item_id');
            $this->stock_item_rate = $this->check($arg,'stock_item_rate');
            $this->stock_item_expenses = $this->check($arg,'stock_item_expenses');
            $ths->item_quantity = $this->check($arg,'item_quantity');
    }    
}

class Quanity extends Array2Object{
    function __construct($arg){
        $this->unit_id = $this->check($arg,'unit_id');
        $this->quantity = $this->check($arg,'quantity');
    }
}