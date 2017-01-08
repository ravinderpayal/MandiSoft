<?php
/**
 * 
 * Migration classs for adding `deleted_payments` table, so that payment deleting feature can 
 * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Payments_Delete extends CI_Migration {

        public function up()
        {
               /* $this->dbforge->add_field(array(
                        'payment_id' => array(
                                'type' => 'INT',
                                'constraint' => 11,
                                'auto_increment' => TRUE
                        ),
                        'amount' => array(
                                'type' => 'double',
                        ),
                        'rebate' => array(
                                'type' => 'double',
                        ),
                        'acc_id' => array(
                                'type' => 'int',
                                'null' => TRUE,
                                'constraint' => 6,
                        ),
                        'payment_mode' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
                        ),
                ));
                $this->dbforge->add_key('blog_id', TRUE);
                $this->dbforge->create_table('deleted_payments');*/
            $this->db->query("CREATE TABLE `deleted_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` double NOT NULL COMMENT 'here positive values means money received and -ve value means money given',
  `rebate` double NOT NULL,
  `acc_id` int(6) NOT NULL,
  `payment_mode` int(2) NOT NULL DEFAULT '2',
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `make_date` date NOT NULL,
  `related_sell` int(6) DEFAULT NULL,
  `inserting_operator` int(5) NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `account_id` (`acc_id`),
  KEY `payment_mode` (`payment_mode`),
  KEY `inserting_operator` (`inserting_operator`),
  KEY `payment_related_sell_ibfk_1` (`related_sell`)
) ENGINE=InnoDB AUTO_INCREMENT=714 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
        }

        public function down()
        {
                $this->dbforge->drop_table('deleted_payments');
        }
}