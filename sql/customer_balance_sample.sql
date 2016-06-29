/*
SQLyog Community
MySQL - 5.6.22-log : Database - test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `enterprise_customerbalance` */

CREATE TABLE `enterprise_customerbalance` (
  `balance_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Balance Id',
  `customer_id` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Customer Id',
  `website_id` SMALLINT(5) UNSIGNED DEFAULT NULL COMMENT 'Website Id',
  `amount` DECIMAL(12,4) NOT NULL DEFAULT '0.0000' COMMENT 'Balance Amount',
  `base_currency_code` VARCHAR(3) DEFAULT NULL COMMENT 'Base Currency Code',
  PRIMARY KEY (`balance_id`),
  UNIQUE KEY `UNQ_ENTERPRISE_CUSTOMERBALANCE_CUSTOMER_ID_WEBSITE_ID` (`customer_id`,`website_id`),
  KEY `IDX_ENTERPRISE_CUSTOMERBALANCE_WEBSITE_ID` (`website_id`),
  CONSTRAINT `FK_ENTERPRISE_CUSTOMERBALANCE_WEBSITE_ID_CORE_WEBSITE_WEBSITE_ID` FOREIGN KEY (`website_id`) REFERENCES `core_website` (`website_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK_ENT_CSTRBALANCE_CSTR_ID_CSTR_ENTT_ENTT_ID` FOREIGN KEY (`customer_id`) REFERENCES `customer_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Enterprise Customerbalance';

/*Data for the table `enterprise_customerbalance` */

INSERT  INTO `enterprise_customerbalance`(`balance_id`,`customer_id`,`website_id`,`amount`,`base_currency_code`) VALUES 
(1,26,1,'0.0000',NULL),
(2,56,1,'0.0000',NULL),
(3,21,1,'100.0000',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
