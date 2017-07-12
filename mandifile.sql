-- MySQL dump 10.13  Distrib 5.7.11, for Win64 (x86_64)
--
-- Host: localhost    Database: mandisoft
-- ------------------------------------------------------
-- Server version	5.7.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account_group`
--

DROP TABLE IF EXISTS `account_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_group` (
  `group_id` int(5) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(56) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `acc_id` int(6) NOT NULL AUTO_INCREMENT,
  `group_id` int(5) NOT NULL,
  `acc_name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `acc_name_ll` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'account name in local language',
  `ledger_number` int(5) NOT NULL,
  `account_balance` double NOT NULL DEFAULT '0' COMMENT 'here positive values means credit(payable - à¤œà¤®à¤¾ à¤°à¤¾à¤¶à¥€) and -ve value means money receivable (à¤‰à¤§à¤¾à¤°)',
  `crate_balance` int(4) NOT NULL DEFAULT '0',
  `acc_address1` mediumtext COLLATE utf8mb4_unicode_ci,
  `acc_address2` mediumtext COLLATE utf8mb4_unicode_ci,
  `acc_area` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `acc_city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number1` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number2` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_activity` date NOT NULL,
  `inserting_operator` int(5) NOT NULL,
  `firm_id` int(5) NOT NULL COMMENT 'Used for storing ID of Entity which have created this account.',
  PRIMARY KEY (`acc_id`),
  UNIQUE KEY `ledger_number` (`ledger_number`),
  KEY `acc_oprtr_ibfk_1` (`inserting_operator`),
  KEY `accounts_group_id_fk` (`group_id`),
  KEY `sccount_of` (`firm_id`),
  KEY `firm_id` (`firm_id`),
  CONSTRAINT `acc_group_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `account_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `acc_oprtr_ibfk_1` FOREIGN KEY (`inserting_operator`) REFERENCES `operators` (`o_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `accounts_group_id_fk` FOREIGN KEY (`group_id`) REFERENCES `account_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_firmId_to_acc_firm` FOREIGN KEY (`firm_id`) REFERENCES `firms` (`firm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `datewise_account_balance`
--

DROP TABLE IF EXISTS `datewise_account_balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datewise_account_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(6) NOT NULL,
  `new_balance` double NOT NULL,
  `old_balance` double NOT NULL,
  `new_crate` int(4) NOT NULL,
  `old_crate` int(4) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` text CHARACTER SET latin1 NOT NULL,
  `sale_id` int(6) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acc_id` (`acc_id`),
  KEY `sale_id` (`sale_id`),
  KEY `payment_id` (`payment_id`),
  CONSTRAINT `activity_account_id_ibfk1` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `dab_payment_id_ibfk1` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `dab_sale_id_ibfk1` FOREIGN KEY (`sale_id`) REFERENCES `item_sale` (`sale_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2412 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `debts`
--

DROP TABLE IF EXISTS `debts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `debts` (
  `debt_id` int(8) NOT NULL AUTO_INCREMENT,
  `acc_id` int(6) NOT NULL,
  `amount` double NOT NULL,
  `related_sell` int(6) NOT NULL,
  `is_cleared` tinyint(1) NOT NULL DEFAULT '0',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`debt_id`),
  KEY `acc_id` (`acc_id`),
  KEY `related_sale` (`related_sell`),
  CONSTRAINT `debt_acc_id_ibfk1` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `debt_related_sell_ibfk1` FOREIGN KEY (`related_sell`) REFERENCES `item_sale` (`sale_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1540 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `deleted_payments`
--

DROP TABLE IF EXISTS `deleted_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deleted_payments` (
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
) ENGINE=InnoDB AUTO_INCREMENT=717 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `deleted_sales`
--

DROP TABLE IF EXISTS `deleted_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deleted_sales` (
  `sale_id` int(6) NOT NULL,
  `sold_to` int(6) NOT NULL,
  `item_id` int(5) NOT NULL,
  `item_lot` int(5) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` double NOT NULL,
  `rate` double NOT NULL,
  `net_rate` tinyint(1) NOT NULL DEFAULT '0',
  `quantity_type` int(3) NOT NULL,
  `payment_mode` int(2) NOT NULL,
  `rebate` double NOT NULL DEFAULT '0',
  `amount_received` double NOT NULL DEFAULT '0',
  `crates` int(5) NOT NULL,
  `crate_security` double NOT NULL DEFAULT '0',
  `sale_date` date NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `deleting_operator` int(5) NOT NULL,
  UNIQUE KEY `sale_id_2` (`sale_id`),
  KEY `sale_id` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entities`
--

DROP TABLE IF EXISTS `entities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities` (
  `ent_id` int(5) NOT NULL AUTO_INCREMENT,
  `ent_name` text CHARACTER SET latin1 NOT NULL,
  `ent_address` text CHARACTER SET latin1 NOT NULL,
  `ent_tin` bigint(20) DEFAULT NULL,
  `ent_pan` bigint(20) DEFAULT NULL,
  `ent_owner` int(5) DEFAULT NULL,
  `ent_type` set('firm','person','group','') CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ent_id`),
  KEY `ent_owner` (`ent_owner`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `firms`
--

DROP TABLE IF EXISTS `firms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `firms` (
  `firm_id` int(5) NOT NULL AUTO_INCREMENT,
  `firm_name` varchar(512) NOT NULL,
  `firm_contact` varchar(12) DEFAULT NULL,
  `firm_add` text,
  `firm_owner` int(5) DEFAULT NULL,
  PRIMARY KEY (`firm_id`),
  KEY `firm_owner` (`firm_owner`),
  CONSTRAINT `fk_firmOwner_to_firm_id` FOREIGN KEY (`firm_owner`) REFERENCES `firms` (`firm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `item_id` int(3) NOT NULL AUTO_INCREMENT,
  `i_name` varchar(56) CHARACTER SET latin1 NOT NULL,
  `parent_item` int(3) DEFAULT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `i_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_id`),
  KEY `parent_item` (`parent_item`),
  CONSTRAINT `item_ibfk_1` FOREIGN KEY (`parent_item`) REFERENCES `item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `item_lot`
--

DROP TABLE IF EXISTS `item_lot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_lot` (
  `lot_id` int(5) NOT NULL AUTO_INCREMENT,
  `lot_desc` text CHARACTER SET latin1 NOT NULL,
  `available` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`lot_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `item_purchase`
--

DROP TABLE IF EXISTS `item_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_purchase` (
  `purchase_id` int(6) NOT NULL AUTO_INCREMENT,
  `purchased_from` int(6) NOT NULL,
  `quantity` int(5) NOT NULL,
  `qnt_type` int(3) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL,
  `inserting_operator` int(5) NOT NULL,
  PRIMARY KEY (`purchase_id`),
  KEY `purchased_from` (`purchased_from`),
  CONSTRAINT `item_purchased_from_fkib1` FOREIGN KEY (`purchased_from`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `item_sale`
--

DROP TABLE IF EXISTS `item_sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_sale` (
  `sale_id` int(6) NOT NULL AUTO_INCREMENT,
  `sold_to` int(6) NOT NULL,
  `item_id` int(5) NOT NULL,
  `item_lot` int(5) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` double NOT NULL,
  `rate` double NOT NULL,
  `net_rate` tinyint(1) NOT NULL DEFAULT '0',
  `quantity_type` int(3) NOT NULL,
  `payment_mode` int(2) NOT NULL,
  `rebate` double NOT NULL DEFAULT '0',
  `amount_received` double NOT NULL DEFAULT '0',
  `crates` int(5) NOT NULL,
  `crate_security` double NOT NULL DEFAULT '0',
  `sale_date` date NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `inserting_operator` int(5) NOT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `item_id_ibfk_1` (`item_id`),
  KEY `sold_to_ibfk_1` (`sold_to`),
  KEY `item_lot_ibfk_1` (`item_lot`),
  KEY `payment_mode_ibfk_1` (`payment_mode`),
  KEY `inserting_operator` (`inserting_operator`),
  CONSTRAINT `item_id_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_lot_ibfk_1` FOREIGN KEY (`item_lot`) REFERENCES `item_lot` (`lot_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_sale_inserting_operator_ibfk1` FOREIGN KEY (`inserting_operator`) REFERENCES `operators` (`o_id`),
  CONSTRAINT `payment_mode_ibfk_1` FOREIGN KEY (`payment_mode`) REFERENCES `payment_mode` (`mode_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sold_to_ibfk_1` FOREIGN KEY (`sold_to`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1542 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `operators`
--

DROP TABLE IF EXISTS `operators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operators` (
  `o_id` int(5) NOT NULL AUTO_INCREMENT,
  `o_name` varchar(56) COLLATE utf8mb4_unicode_ci NOT NULL,
  `o_email` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `o_phone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `o_username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `o_password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `o_rights` int(1) NOT NULL COMMENT '1->master  2-> read/write/update  3->read/write 4->read only',
  `operator_of` int(5) NOT NULL COMMENT 'Used for storing ID of Entity which have created this operator.',
  PRIMARY KEY (`o_id`),
  KEY `operator_of` (`operator_of`),
  CONSTRAINT `fk_firmId_to_operator_firm` FOREIGN KEY (`operator_of`) REFERENCES `firms` (`firm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
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
  KEY `payment_related_sell_ibfk_1` (`related_sell`),
  CONSTRAINT `payment_inserting_operator_fk` FOREIGN KEY (`inserting_operator`) REFERENCES `operators` (`o_id`),
  CONSTRAINT `payment_paying_account_ibfk_1` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `payment_paying_mode__ib_fk2` FOREIGN KEY (`payment_mode`) REFERENCES `payment_mode` (`mode_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `payment_related_sell_ibfk_1` FOREIGN KEY (`related_sell`) REFERENCES `item_sale` (`sale_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=716 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment_mode`
--

DROP TABLE IF EXISTS `payment_mode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_mode` (
  `mode_id` int(2) NOT NULL AUTO_INCREMENT,
  `mode_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode_available` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`mode_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quantity_types`
--

DROP TABLE IF EXISTS `quantity_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quantity_types` (
  `qnt_id` int(3) NOT NULL AUTO_INCREMENT,
  `qnt_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qnt_sign` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`qnt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `related_accounts`
--

DROP TABLE IF EXISTS `related_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `related_accounts` (
  `acc1_id` int(6) NOT NULL,
  `acc2_id` int(6) NOT NULL,
  UNIQUE KEY `unique_index` (`acc1_id`,`acc2_id`),
  KEY `RELATE_acc2_ID_ibfk_1` (`acc2_id`),
  CONSTRAINT `RELATE_acc1_ID_ibfk_1` FOREIGN KEY (`acc1_id`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `RELATE_acc2_ID_ibfk_1` FOREIGN KEY (`acc2_id`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-01 19:53:13
