/*
SQLyog Community Edition- MySQL GUI v8.12 
MySQL - 5.1.32-community-log : Database - mdi_ooe
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`mdi_ooe` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `mdi_ooe`;

/*Table structure for table `announcement` */

DROP TABLE IF EXISTS `announcement`;

CREATE TABLE `announcement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content` text,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `announcement` */

/*Table structure for table `order_notes` */

DROP TABLE IF EXISTS `order_notes`;

CREATE TABLE `order_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL,
  `notes` varchar(1000) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `order_notes` */

/*Table structure for table `tblfacility` */

DROP TABLE IF EXISTS `tblfacility`;

CREATE TABLE `tblfacility` (
  `fldID` int(20) NOT NULL AUTO_INCREMENT,
  `fldFacilityName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldAdminName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldDivisionName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldAddressLine1` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldAddressLine2` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldAddressCity` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldAddressState` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldAddressZip` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldPhoneNumber` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldFaxNumber` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldEmail` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldEmailOrder` tinyint(1) NOT NULL,
  `fldAutoDispatch` tinyint(1) NOT NULL DEFAULT '0',
  `fldTechnologist` varchar(255) DEFAULT NULL,
  `fldReqDis` tinyint(1) DEFAULT '0',
  `fldMainState` varchar(3) NOT NULL,
  `fldFacilityType` varchar(64) NOT NULL,
  `fldFacilityDisabled` tinyint(1) DEFAULT '0',
  `fldBillingContact` varchar(100) DEFAULT NULL,
  `fldBillingPhone` varchar(100) DEFAULT NULL,
  `fldBillingFax` varchar(100) DEFAULT NULL,
  `fldBillingRep` varchar(100) DEFAULT NULL,
  `fldBillingAccNum` varchar(100) DEFAULT NULL,
  `fldStartDate` date DEFAULT NULL,
  PRIMARY KEY (`fldID`),
  UNIQUE KEY `fldFacilityName` (`fldFacilityName`)
) ENGINE=MyISAM AUTO_INCREMENT=1388 DEFAULT CHARSET=latin1;

/*Data for the table `tblfacility` */

insert  into `tblfacility`(`fldID`,`fldFacilityName`,`fldAdminName`,`fldDivisionName`,`fldAddressLine1`,`fldAddressLine2`,`fldAddressCity`,`fldAddressState`,`fldAddressZip`,`fldPhoneNumber`,`fldFaxNumber`,`fldEmail`,`fldEmailOrder`,`fldAutoDispatch`,`fldTechnologist`,`fldReqDis`,`fldMainState`,`fldFacilityType`,`fldFacilityDisabled`,`fldBillingContact`,`fldBillingPhone`,`fldBillingFax`,`fldBillingRep`,`fldBillingAccNum`,`fldStartDate`) values (1383,'Abbott Road Nursing Facility','Mary','South','4601 Abbott Rd','','Orchard Park','NEW YORK','14127','(716)555-2136','','',0,0,'',0,'NY','NURSING HOME',0,'','','','','','0000-00-00');
insert  into `tblfacility`(`fldID`,`fldFacilityName`,`fldAdminName`,`fldDivisionName`,`fldAddressLine1`,`fldAddressLine2`,`fldAddressCity`,`fldAddressState`,`fldAddressZip`,`fldPhoneNumber`,`fldFaxNumber`,`fldEmail`,`fldEmailOrder`,`fldAutoDispatch`,`fldTechnologist`,`fldReqDis`,`fldMainState`,`fldFacilityType`,`fldFacilityDisabled`,`fldBillingContact`,`fldBillingPhone`,`fldBillingFax`,`fldBillingRep`,`fldBillingAccNum`,`fldStartDate`) values (1384,'Erie County Holding Center','Robin','North','40 Delaware Ave','','Buffalo','NEW YORK','14202','(716)555-9986','','',0,0,'',0,'NY','CORRECTIONAL FACILITY',0,'','','','','','0000-00-00');
insert  into `tblfacility`(`fldID`,`fldFacilityName`,`fldAdminName`,`fldDivisionName`,`fldAddressLine1`,`fldAddressLine2`,`fldAddressCity`,`fldAddressState`,`fldAddressZip`,`fldPhoneNumber`,`fldFaxNumber`,`fldEmail`,`fldEmailOrder`,`fldAutoDispatch`,`fldTechnologist`,`fldReqDis`,`fldMainState`,`fldFacilityType`,`fldFacilityDisabled`,`fldBillingContact`,`fldBillingPhone`,`fldBillingFax`,`fldBillingRep`,`fldBillingAccNum`,`fldStartDate`) values (1385,'Hospice Care','Peter ','North','225 Como Park Blvd','','Buffalo','NEW YORK','14227','(716)555-1489','','',0,0,'',0,'NY','HOME BOUND',0,'','','','','','0000-00-00');
insert  into `tblfacility`(`fldID`,`fldFacilityName`,`fldAdminName`,`fldDivisionName`,`fldAddressLine1`,`fldAddressLine2`,`fldAddressCity`,`fldAddressState`,`fldAddressZip`,`fldPhoneNumber`,`fldFaxNumber`,`fldEmail`,`fldEmailOrder`,`fldAutoDispatch`,`fldTechnologist`,`fldReqDis`,`fldMainState`,`fldFacilityType`,`fldFacilityDisabled`,`fldBillingContact`,`fldBillingPhone`,`fldBillingFax`,`fldBillingRep`,`fldBillingAccNum`,`fldStartDate`) values (1386,'Quest Diagnostics','','North','191 North St','','Buffalo','NEW YORK','14201','(716)555-8942','','',0,0,'',0,'NY','PHYSICIANS LAB',0,'','','','','','0000-00-00');
insert  into `tblfacility`(`fldID`,`fldFacilityName`,`fldAdminName`,`fldDivisionName`,`fldAddressLine1`,`fldAddressLine2`,`fldAddressCity`,`fldAddressState`,`fldAddressZip`,`fldPhoneNumber`,`fldFaxNumber`,`fldEmail`,`fldEmailOrder`,`fldAutoDispatch`,`fldTechnologist`,`fldReqDis`,`fldMainState`,`fldFacilityType`,`fldFacilityDisabled`,`fldBillingContact`,`fldBillingPhone`,`fldBillingFax`,`fldBillingRep`,`fldBillingAccNum`,`fldStartDate`) values (1387,'Crestwood Assisted Living','Frank','South','79 Rovner Place','','Hamburg','NEW YORK','14075','(716)555-6980','','',0,0,'',0,'NY','NURSING HOME',0,'','','','','','0000-00-00');

/*Table structure for table `tblfacilitydetails` */

DROP TABLE IF EXISTS `tblfacilitydetails`;

CREATE TABLE `tblfacilitydetails` (
  `fldID` int(20) NOT NULL AUTO_INCREMENT,
  `fldOrderID` int(20) NOT NULL,
  `fldFacility` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`fldID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `tblfacilitydetails` */

/*Table structure for table `tblhistory` */

DROP TABLE IF EXISTS `tblhistory`;

CREATE TABLE `tblhistory` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fldID` bigint(25) unsigned DEFAULT NULL,
  `fldEventType` enum('Add','Edit','Delete') DEFAULT NULL,
  `flduser` varchar(255) DEFAULT NULL,
  `fldEventDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`fldID`),
  KEY `type` (`fldEventType`,`fldID`),
  KEY `user` (`flduser`,`fldID`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

/*Data for the table `tblhistory` */

insert  into `tblhistory`(`id`,`fldID`,`fldEventType`,`flduser`,`fldEventDateTime`) values (114,41619,'Edit','admin','2014-01-24 12:33:27');
insert  into `tblhistory`(`id`,`fldID`,`fldEventType`,`flduser`,`fldEventDateTime`) values (115,41622,'Add','admin','2014-01-24 12:36:16');
insert  into `tblhistory`(`id`,`fldID`,`fldEventType`,`flduser`,`fldEventDateTime`) values (116,41623,'Add','admin','2014-02-17 13:33:33');
insert  into `tblhistory`(`id`,`fldID`,`fldEventType`,`flduser`,`fldEventDateTime`) values (117,41624,'Add','msmith','2014-02-20 06:23:54');
insert  into `tblhistory`(`id`,`fldID`,`fldEventType`,`flduser`,`fldEventDateTime`) values (118,41625,'Add','admin','2014-02-20 06:29:14');
insert  into `tblhistory`(`id`,`fldID`,`fldEventType`,`flduser`,`fldEventDateTime`) values (119,41626,'Add','admin','2014-02-20 06:31:43');
insert  into `tblhistory`(`id`,`fldID`,`fldEventType`,`flduser`,`fldEventDateTime`) values (120,41625,'Edit','admin','2014-02-20 06:37:12');
insert  into `tblhistory`(`id`,`fldID`,`fldEventType`,`flduser`,`fldEventDateTime`) values (121,41625,'Edit','admin','2014-02-20 06:37:19');

/*Table structure for table `tblicdcodes` */

DROP TABLE IF EXISTS `tblicdcodes`;

CREATE TABLE `tblicdcodes` (
  `fldOrderid` int(10) NOT NULL,
  `fldProc1icd1` varchar(255) NOT NULL,
  `fldProc1icd2` varchar(255) NOT NULL,
  `fldProc1icd3` varchar(255) NOT NULL,
  `fldProc1icd4` varchar(255) NOT NULL,
  `fldProc1dig` varchar(255) NOT NULL,
  `fldProc2icd1` varchar(255) NOT NULL,
  `fldProc2icd2` varchar(255) NOT NULL,
  `fldProc2icd3` varchar(255) NOT NULL,
  `fldProc2icd4` varchar(255) NOT NULL,
  `fldProc2dig` varchar(255) NOT NULL,
  `fldProc3icd1` varchar(255) NOT NULL,
  `fldProc3icd2` varchar(255) NOT NULL,
  `fldProc3icd3` varchar(255) NOT NULL,
  `fldProc3icd4` varchar(255) NOT NULL,
  `fldProc3dig` varchar(255) NOT NULL,
  `fldProc4icd1` varchar(255) NOT NULL,
  `fldProc4icd2` varchar(255) NOT NULL,
  `fldProc4icd3` varchar(255) NOT NULL,
  `fldProc4icd4` varchar(255) NOT NULL,
  `fldProc4dig` varchar(255) NOT NULL,
  `fldProc5icd1` varchar(255) NOT NULL,
  `fldProc5icd2` varchar(255) NOT NULL,
  `fldProc5icd3` varchar(255) NOT NULL,
  `fldProc5icd4` varchar(255) NOT NULL,
  `fldProc5dig` varchar(255) NOT NULL,
  `fldProc6icd1` varchar(255) NOT NULL,
  `fldProc6icd2` varchar(255) NOT NULL,
  `fldProc6icd3` varchar(255) NOT NULL,
  `fldProc6icd4` varchar(255) NOT NULL,
  `fldProc6dig` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tblicdcodes` */

insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41619,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41620,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41621,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41619,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41619,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41619,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41619,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41619,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41619,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41622,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41623,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41624,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41625,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41626,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41625,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
insert  into `tblicdcodes`(`fldOrderid`,`fldProc1icd1`,`fldProc1icd2`,`fldProc1icd3`,`fldProc1icd4`,`fldProc1dig`,`fldProc2icd1`,`fldProc2icd2`,`fldProc2icd3`,`fldProc2icd4`,`fldProc2dig`,`fldProc3icd1`,`fldProc3icd2`,`fldProc3icd3`,`fldProc3icd4`,`fldProc3dig`,`fldProc4icd1`,`fldProc4icd2`,`fldProc4icd3`,`fldProc4icd4`,`fldProc4dig`,`fldProc5icd1`,`fldProc5icd2`,`fldProc5icd3`,`fldProc5icd4`,`fldProc5dig`,`fldProc6icd1`,`fldProc6icd2`,`fldProc6icd3`,`fldProc6icd4`,`fldProc6dig`) values (41625,'','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');

/*Table structure for table `tbllists` */

DROP TABLE IF EXISTS `tbllists`;

CREATE TABLE `tbllists` (
  `fldID` int(20) NOT NULL AUTO_INCREMENT,
  `fldListName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldValue` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `code` varchar(10) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'used mostly for icd',
  `fldActiveValue` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fldID`)
) ENGINE=MyISAM AUTO_INCREMENT=460 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbllists` */

insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (33,'modality','CR',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (34,'modality','US',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (365,'icd','Seizure',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (37,'modality','EKG',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (364,'icd','Med Monitoring',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (363,'icd','Lethargy',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (362,'icd','Hypothyroid',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (361,'icd','Hypertension',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (360,'icd','Hyperlipidemia',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (359,'icd','Gerd',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (358,'icd','Fatigue & Weakness',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (357,'icd','DM',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (356,'icd','Depression',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (355,'icd','Dementia',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (354,'icd','CRI',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (353,'icd','CRF',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (352,'icd','Coumadin',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (351,'icd','COPD',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (350,'icd','Confusion',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (349,'icd','CHF',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (348,'icd','Change In Behavior',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (347,'icd','Anemia',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (346,'icd','A-Fib',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (345,'icd','Face Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (344,'icd','Vomiting',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (343,'icd','Nausea',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (342,'icd','Naus.+Vomit',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (341,'icd','Flu',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (340,'icd','Edema',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (339,'icd','Ventricular Fibrillation',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (402,'icd','Bradycardia',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (338,'icd','Tachycardia',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (337,'icd','Irreg. Heartbeat',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (336,'icd','Cardiomegaly',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (335,'icd','Cardiac Dysrhythmia',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (382,'icd','Positive PPD',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (381,'icd','Palpitations',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (334,'icd','Atrial Fibrillation',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (333,'icd','Arrhythmia',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (79,'relationship','Mother',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (80,'relationship','Father',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (81,'relationship','Sister',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (82,'relationship','Brother',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (83,'relationship','Son',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (85,'relationship','Daughter',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (86,'relationship','Other',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (87,'relationship','Niece',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (88,'relationship','Nephew',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (89,'relationship','Cousin',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (380,'icd','Oxygen Saturation',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (379,'icd','Dysphagia',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (378,'icd','Dyspnea',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (331,'icd','Abdominal Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (332,'icd','Fecal Impaction',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (377,'icd','Diarrhea',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (376,'icd','Cardiac Murmur',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (375,'icd','Constipation',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (374,'icd','Airway Obst/COPD',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (373,'icd','Abn. Weight Loss',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (372,'icd','Abn. Weight Gain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (371,'icd','Abnormal Sputum',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (370,'icd','Abn. Bowel Sounds',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (369,'icd','Weight Loss',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (367,'icd','Throat Cx',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (368,'icd','UTI',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (366,'icd','Stroke',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (309,'icd','Rib Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (310,'icd','Shoulder Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (312,'icd','Tib-Fib Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (313,'icd','Toe Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (314,'icd','Wrist Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (315,'icd','Chest Injury',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (316,'icd','Chest Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (317,'icd','Cong Heart Failure',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (318,'icd','Congestion',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (319,'icd','Cough',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (320,'icd','Coughing Blood',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (321,'icd','Fever',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (322,'icd','Infiltrates',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (323,'icd','Painful Respiration',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (324,'icd','Pos. PPD (TB Reaction)',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (325,'icd','Rales/Ronchi',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (326,'icd','Respiratory Abnormal',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (327,'icd','Shortness Of Breath',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (328,'icd','Unspec. Pleural Effusion',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (329,'icd','Wheezing',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (330,'icd','Abdominal Distention',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (308,'icd','Neck Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (307,'icd','Low Back Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (306,'icd','Knee Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (311,'icd','Thoracic Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (304,'icd','Humerus Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (303,'icd','Hip/Pelvis Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (302,'icd','Hand Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (301,'icd','Forearm Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (300,'icd','Foot Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (299,'icd','Finger Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (295,'icd','Ankle Pain','111',1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (296,'icd','Dorsal Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (297,'icd','Elbow Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (278,'pcategory','Test Value',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (298,'icd','Femur/Leg Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (276,'modality','Lab',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (383,'icd','Resp. Distress, SOB, Wheezing',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (384,'icd','Cervical Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (385,'icd','Coccyx Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (386,'icd','Head Pain',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (456,'division','North',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (457,'division','South',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (431,'facilitytype','Home Bound',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (394,'facilitytype','Nursing Home',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (422,'icd','Elavated WBC',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (423,'icd','LEUKOCYTOSIS',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (424,'icd','S/P FALL',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (425,'icd','HYPOTENSION',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (399,'facilitytype','Correctional Facility',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (400,'Select','Home Health Agency',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (401,'facilitytype','Physicians Lab',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (403,'icd','Verify NG',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (404,'icd','Annual',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (405,'icd','Admission',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (406,'icd','Pre Employment',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (407,'icd','Pre Operative',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (408,'icd','Tube Placement',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (436,'icd','Pneum. Unspec.',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (410,'icd','Aspiration',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (411,'icd','Redness',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (412,'icd','Mass',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (413,'icd','Nodule',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (414,'icd','Bruising',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (415,'icd','Altered Mental State',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (416,'exception','Syncope',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (418,'icd','Atelectisis',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (417,'icd','PICC Placement',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (419,'icd','Distention',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (420,'icd','Ascites',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (421,'icd','PEG placement',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (426,'icd','Stones/calculi',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (427,'icd','Coronary artery disease',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (428,'modality','ECHO',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (458,'insurance','Blue Cross Blue Shield',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (434,'icd','Pain and Swelling',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (437,'icd','Pain in Abdomen',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (438,'icd','Pain in Ankle/Foot',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (439,'icd','Pain in Arm/Leg',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (440,'icd','Pain in Elbow',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (441,'icd','Pain in Hand',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (442,'icd','Pain in Knee',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (443,'icd','Pain in L-spine',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (444,'icd','Backache Unspecified',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (445,'icd','Pain in Neck',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (446,'icd','Pain in Pelvis/Hip',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (447,'icd','Pain in Coccyx',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (448,'icd','Pain in Ribs',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (449,'icd','Pain in Shoulder',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (450,'icd','Pain in T-spine',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (451,'icd','Pain in Wrist',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (452,'icd','NOS Reaction to TB Test',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (453,'icd','Pulmonary TB Screening',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (454,'icd','Sinusitis Acute',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (455,'icd','F/U Fracture',NULL,1);
insert  into `tbllists`(`fldID`,`fldListName`,`fldValue`,`code`,`fldActiveValue`) values (459,'insurance','Independent Health',NULL,1);

/*Table structure for table `tblorderdetails` */

DROP TABLE IF EXISTS `tblorderdetails`;

CREATE TABLE `tblorderdetails` (
  `fldID` int(25) NOT NULL AUTO_INCREMENT,
  `fldPatientID` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fldUserName` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `fldPatientSSN` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldFirstName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldLastName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldMiddleName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldSurName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldDOB` date NOT NULL,
  `fldGender` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldInsurance` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldMedicareNumber` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldMedicaidNumber` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldState` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldInsuranceCompanyName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldHmoContract` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldPolicy` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldGroup` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldResponsiblePerson` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldPhone` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldRelationship` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldFacilityName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldPrivateAddressLine1` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldPrivateAddressLine2` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldPrivateAddressCity` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldPrivateAddressState` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldPrivateAddressZip` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldPrivatePhoneNumber` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldHomeAddressLine1` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `fldHomeAddressLine2` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `fldHomeAddressCity` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `fldHomeAddressState` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `fldHomeAddressZip` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `fldHomePhoneNumber` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldStat` tinyint(1) NOT NULL,
  `fldOrderingPhysicians` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldRequestedBy` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure1` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure2` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure3` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure4` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure5` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure6` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure7` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure8` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure9` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure10` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldplr1` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr2` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr3` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr4` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr5` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr6` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr7` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr8` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr9` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr10` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom1` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom2` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom3` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom4` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom5` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom6` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom7` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom8` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom9` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom10` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldacsno1` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno2` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno3` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno4` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno5` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno6` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno7` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno8` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno9` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno10` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldSymptoms` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `fldHistory` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldPatientroom` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `fldAfterhours` tinyint(1) NOT NULL,
  `fldAuthorized` tinyint(1) NOT NULL,
  `fldTechnologist` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldDispatched` tinyint(1) NOT NULL,
  `fldDispatchedDate` datetime DEFAULT NULL,
  `fldVerbal` tinyint(1) NOT NULL,
  `fldCoded` tinyint(1) NOT NULL,
  `fldReportDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fldReportCalledTo` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `fldReportCalledToDateTime` datetime DEFAULT NULL,
  `fldReportDetails` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `fldCDRequested` tinyint(1) NOT NULL,
  `fldCDAddr` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `fldCreDate` date NOT NULL,
  `fldAuthDate` datetime NOT NULL,
  `fldVerbalnoofpat` int(10) NOT NULL,
  `fldRadiologist` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `fldSchDate` date NOT NULL DEFAULT '0000-00-00',
  `fldSchTime` time DEFAULT NULL,
  `fldFacPhone` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `fldCDDate` date NOT NULL,
  `fldCDTimeRequested` time DEFAULT NULL,
  `fldnoofviews` int(10) NOT NULL,
  `fldExamDate` time NOT NULL,
  `fldStairs` tinyint(1) DEFAULT NULL,
  `fldNstairs` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `fldpps` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign` varchar(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldException1` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldException2` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldException3` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldExp1Date` date DEFAULT NULL,
  `fdlExp2Date` date DEFAULT NULL,
  `fldExp3Date` date DEFAULT NULL,
  `fldExp1Resh` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `fldExp2Resh` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `fldExp3Resh` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign1` varchar(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign2` varchar(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign3` varchar(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign4` varchar(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign5` varchar(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign6` varchar(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign7` tinyint(4) DEFAULT NULL,
  `fldSign8` tinyint(4) DEFAULT NULL,
  `fldSign9` tinyint(4) DEFAULT NULL,
  `fldSign10` tinyint(4) DEFAULT NULL,
  `fldCDShipDate` date DEFAULT NULL,
  `tr_modified_by` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `tr_modified_date` datetime DEFAULT NULL,
  `created_by` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `fldPatNotes` text COLLATE latin1_general_ci NOT NULL,
  `fldOrderingPhysiciansPhone` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldPrivateHousingNo` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldReportFax` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldBackupFax` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldBackupPhone` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldOrderType` int(2) DEFAULT NULL,
  `fldbilled` enum('insurance','facility') COLLATE latin1_general_ci DEFAULT NULL,
  `fldStation` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldFacFax` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldNotes` text COLLATE latin1_general_ci,
  `fldOrderingPhysiciansFax` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldDiagnosisReuired1` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldDiagnosisReuired2` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldDiagnosisReuired3` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldRepeat` int(2) DEFAULT NULL,
  `fldRepeatDays` int(4) DEFAULT NULL,
  `fldRepeatTimes` int(4) DEFAULT NULL,
  `fldTestPriority` int(2) DEFAULT NULL,
  `fldLocFacName` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldlabtype` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `labSentTo` varchar(50) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'name of radiologist or lab for diagnostic reading',
  `fldLabDeliveredDate` date DEFAULT NULL,
  `fldLabDeliveredTime` time DEFAULT NULL,
  `fldtechComplete` tinyint(2) DEFAULT '0',
  `fldRepeatParent` int(25) DEFAULT NULL,
  `fldMarkCompletedBy` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `fldMarkCompletedDate` datetime DEFAULT NULL,
  `fldPrivateResidenceNumber` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `fldOPNotinDB` tinyint(1) DEFAULT '0',
  `fldStatus` tinyint(1) DEFAULT '0' COMMENT 'cancel:1, normal:0',
  `fldCancelNotes` varchar(500) COLLATE latin1_general_ci DEFAULT '0',
  `fldCanceledBy` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `fldCanceledDate` datetime DEFAULT NULL,
  PRIMARY KEY (`fldID`)
) ENGINE=MyISAM AUTO_INCREMENT=41627 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tblorderdetails` */

insert  into `tblorderdetails`(`fldID`,`fldPatientID`,`fldDate`,`fldUserName`,`fldPatientSSN`,`fldFirstName`,`fldLastName`,`fldMiddleName`,`fldSurName`,`fldDOB`,`fldGender`,`fldInsurance`,`fldMedicareNumber`,`fldMedicaidNumber`,`fldState`,`fldInsuranceCompanyName`,`fldHmoContract`,`fldPolicy`,`fldGroup`,`fldResponsiblePerson`,`fldPhone`,`fldRelationship`,`fldFacilityName`,`fldPrivateAddressLine1`,`fldPrivateAddressLine2`,`fldPrivateAddressCity`,`fldPrivateAddressState`,`fldPrivateAddressZip`,`fldPrivatePhoneNumber`,`fldHomeAddressLine1`,`fldHomeAddressLine2`,`fldHomeAddressCity`,`fldHomeAddressState`,`fldHomeAddressZip`,`fldHomePhoneNumber`,`fldStat`,`fldOrderingPhysicians`,`fldRequestedBy`,`fldProcedure1`,`fldProcedure2`,`fldProcedure3`,`fldProcedure4`,`fldProcedure5`,`fldProcedure6`,`fldProcedure7`,`fldProcedure8`,`fldProcedure9`,`fldProcedure10`,`fldplr1`,`fldplr2`,`fldplr3`,`fldplr4`,`fldplr5`,`fldplr6`,`fldplr7`,`fldplr8`,`fldplr9`,`fldplr10`,`fldSymptom1`,`fldSymptom2`,`fldSymptom3`,`fldSymptom4`,`fldSymptom5`,`fldSymptom6`,`fldSymptom7`,`fldSymptom8`,`fldSymptom9`,`fldSymptom10`,`fldacsno1`,`fldacsno2`,`fldacsno3`,`fldacsno4`,`fldacsno5`,`fldacsno6`,`fldacsno7`,`fldacsno8`,`fldacsno9`,`fldacsno10`,`fldSymptoms`,`fldHistory`,`fldPatientroom`,`fldAfterhours`,`fldAuthorized`,`fldTechnologist`,`fldDispatched`,`fldDispatchedDate`,`fldVerbal`,`fldCoded`,`fldReportDate`,`fldReportCalledTo`,`fldReportCalledToDateTime`,`fldReportDetails`,`fldCDRequested`,`fldCDAddr`,`fldCreDate`,`fldAuthDate`,`fldVerbalnoofpat`,`fldRadiologist`,`fldSchDate`,`fldSchTime`,`fldFacPhone`,`fldCDDate`,`fldCDTimeRequested`,`fldnoofviews`,`fldExamDate`,`fldStairs`,`fldNstairs`,`fldpps`,`fldSign`,`fldException1`,`fldException2`,`fldException3`,`fldExp1Date`,`fdlExp2Date`,`fldExp3Date`,`fldExp1Resh`,`fldExp2Resh`,`fldExp3Resh`,`fldSign1`,`fldSign2`,`fldSign3`,`fldSign4`,`fldSign5`,`fldSign6`,`fldSign7`,`fldSign8`,`fldSign9`,`fldSign10`,`fldCDShipDate`,`tr_modified_by`,`tr_modified_date`,`created_by`,`created_date`,`modified_by`,`modified_date`,`fldPatNotes`,`fldOrderingPhysiciansPhone`,`fldPrivateHousingNo`,`fldReportFax`,`fldBackupFax`,`fldBackupPhone`,`fldOrderType`,`fldbilled`,`fldStation`,`fldFacFax`,`fldNotes`,`fldOrderingPhysiciansFax`,`fldDiagnosisReuired1`,`fldDiagnosisReuired2`,`fldDiagnosisReuired3`,`fldRepeat`,`fldRepeatDays`,`fldRepeatTimes`,`fldTestPriority`,`fldLocFacName`,`fldlabtype`,`labSentTo`,`fldLabDeliveredDate`,`fldLabDeliveredTime`,`fldtechComplete`,`fldRepeatParent`,`fldMarkCompletedBy`,`fldMarkCompletedDate`,`fldPrivateResidenceNumber`,`fldOPNotinDB`,`fldStatus`,`fldCancelNotes`,`fldCanceledBy`,`fldCanceledDate`) values (41619,'1','2014-01-24 12:47:36','ADMIN','555-11-2222','RALPH','SCOTT','','','1933-01-10','male','','','','','','','','','','','','Abbott Road Nursing Facility','','','','','','','','','','','','',0,'Mary Smith, M.D','MARY','FINGER(S) 3V','','','','','','','','','','LEFT','','','','','','','','','','F/U Fracture','','','','','','','','','','20140124-1233261','20140124-1233262','20140124-1233263','20140124-1233264','20140124-1233265','20140124-1233266','20140124-1233267','20140124-1233268','20140124-1233269','20140124-12332610','','','',0,0,'PBERRY',1,'2014-01-24 12:47:00',0,0,'0000-00-00 00:00:00','',NULL,'',0,'','2014-01-24','0000-00-00 00:00:00',0,'','2014-01-24','12:11:00','(716)555-2136','0000-00-00',NULL,0,'00:00:00',NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin','2014-01-24 12:12:27','admin','2014-01-24 12:33:26','','','','','','',1,'insurance','','','','','','','',0,0,0,0,'','',NULL,NULL,NULL,0,NULL,NULL,NULL,'',0,0,'0',NULL,NULL);
insert  into `tblorderdetails`(`fldID`,`fldPatientID`,`fldDate`,`fldUserName`,`fldPatientSSN`,`fldFirstName`,`fldLastName`,`fldMiddleName`,`fldSurName`,`fldDOB`,`fldGender`,`fldInsurance`,`fldMedicareNumber`,`fldMedicaidNumber`,`fldState`,`fldInsuranceCompanyName`,`fldHmoContract`,`fldPolicy`,`fldGroup`,`fldResponsiblePerson`,`fldPhone`,`fldRelationship`,`fldFacilityName`,`fldPrivateAddressLine1`,`fldPrivateAddressLine2`,`fldPrivateAddressCity`,`fldPrivateAddressState`,`fldPrivateAddressZip`,`fldPrivatePhoneNumber`,`fldHomeAddressLine1`,`fldHomeAddressLine2`,`fldHomeAddressCity`,`fldHomeAddressState`,`fldHomeAddressZip`,`fldHomePhoneNumber`,`fldStat`,`fldOrderingPhysicians`,`fldRequestedBy`,`fldProcedure1`,`fldProcedure2`,`fldProcedure3`,`fldProcedure4`,`fldProcedure5`,`fldProcedure6`,`fldProcedure7`,`fldProcedure8`,`fldProcedure9`,`fldProcedure10`,`fldplr1`,`fldplr2`,`fldplr3`,`fldplr4`,`fldplr5`,`fldplr6`,`fldplr7`,`fldplr8`,`fldplr9`,`fldplr10`,`fldSymptom1`,`fldSymptom2`,`fldSymptom3`,`fldSymptom4`,`fldSymptom5`,`fldSymptom6`,`fldSymptom7`,`fldSymptom8`,`fldSymptom9`,`fldSymptom10`,`fldacsno1`,`fldacsno2`,`fldacsno3`,`fldacsno4`,`fldacsno5`,`fldacsno6`,`fldacsno7`,`fldacsno8`,`fldacsno9`,`fldacsno10`,`fldSymptoms`,`fldHistory`,`fldPatientroom`,`fldAfterhours`,`fldAuthorized`,`fldTechnologist`,`fldDispatched`,`fldDispatchedDate`,`fldVerbal`,`fldCoded`,`fldReportDate`,`fldReportCalledTo`,`fldReportCalledToDateTime`,`fldReportDetails`,`fldCDRequested`,`fldCDAddr`,`fldCreDate`,`fldAuthDate`,`fldVerbalnoofpat`,`fldRadiologist`,`fldSchDate`,`fldSchTime`,`fldFacPhone`,`fldCDDate`,`fldCDTimeRequested`,`fldnoofviews`,`fldExamDate`,`fldStairs`,`fldNstairs`,`fldpps`,`fldSign`,`fldException1`,`fldException2`,`fldException3`,`fldExp1Date`,`fdlExp2Date`,`fldExp3Date`,`fldExp1Resh`,`fldExp2Resh`,`fldExp3Resh`,`fldSign1`,`fldSign2`,`fldSign3`,`fldSign4`,`fldSign5`,`fldSign6`,`fldSign7`,`fldSign8`,`fldSign9`,`fldSign10`,`fldCDShipDate`,`tr_modified_by`,`tr_modified_date`,`created_by`,`created_date`,`modified_by`,`modified_date`,`fldPatNotes`,`fldOrderingPhysiciansPhone`,`fldPrivateHousingNo`,`fldReportFax`,`fldBackupFax`,`fldBackupPhone`,`fldOrderType`,`fldbilled`,`fldStation`,`fldFacFax`,`fldNotes`,`fldOrderingPhysiciansFax`,`fldDiagnosisReuired1`,`fldDiagnosisReuired2`,`fldDiagnosisReuired3`,`fldRepeat`,`fldRepeatDays`,`fldRepeatTimes`,`fldTestPriority`,`fldLocFacName`,`fldlabtype`,`labSentTo`,`fldLabDeliveredDate`,`fldLabDeliveredTime`,`fldtechComplete`,`fldRepeatParent`,`fldMarkCompletedBy`,`fldMarkCompletedDate`,`fldPrivateResidenceNumber`,`fldOPNotinDB`,`fldStatus`,`fldCancelNotes`,`fldCanceledBy`,`fldCanceledDate`) values (41620,'54236','2014-01-24 12:47:22','ADMIN','421-53-6791','JOSE','RODRIQUEZ','','','1980-07-15','male','','','','','','','','','','','','Erie County Holding Center','','','','','','','','','','','','',0,'Steven Turk, M.D.','','FACIAL BONES 3V','','','','','','','','','','NA','','','','','','','','','','Face Pain','','','','','','','','','','20140124-1215241','20140124-1215242','20140124-1215243','20140124-1215244','20140124-1215245','20140124-1215246','20140124-1215247','20140124-1215248','20140124-1215249','20140124-12152410','','','',0,0,'MWRIGHT',1,'2014-01-24 12:47:00',0,0,'0000-00-00 00:00:00','',NULL,'',0,'','2014-01-24','0000-00-00 00:00:00',0,'','2014-01-24','12:14:00','(716)555-9986','0000-00-00',NULL,0,'00:00:00',NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin','2014-01-24 12:15:24',NULL,NULL,'','','','','','',2,'insurance','','','','','','','',0,0,0,0,'','',NULL,NULL,NULL,0,NULL,NULL,NULL,'',0,0,'0',NULL,NULL);
insert  into `tblorderdetails`(`fldID`,`fldPatientID`,`fldDate`,`fldUserName`,`fldPatientSSN`,`fldFirstName`,`fldLastName`,`fldMiddleName`,`fldSurName`,`fldDOB`,`fldGender`,`fldInsurance`,`fldMedicareNumber`,`fldMedicaidNumber`,`fldState`,`fldInsuranceCompanyName`,`fldHmoContract`,`fldPolicy`,`fldGroup`,`fldResponsiblePerson`,`fldPhone`,`fldRelationship`,`fldFacilityName`,`fldPrivateAddressLine1`,`fldPrivateAddressLine2`,`fldPrivateAddressCity`,`fldPrivateAddressState`,`fldPrivateAddressZip`,`fldPrivatePhoneNumber`,`fldHomeAddressLine1`,`fldHomeAddressLine2`,`fldHomeAddressCity`,`fldHomeAddressState`,`fldHomeAddressZip`,`fldHomePhoneNumber`,`fldStat`,`fldOrderingPhysicians`,`fldRequestedBy`,`fldProcedure1`,`fldProcedure2`,`fldProcedure3`,`fldProcedure4`,`fldProcedure5`,`fldProcedure6`,`fldProcedure7`,`fldProcedure8`,`fldProcedure9`,`fldProcedure10`,`fldplr1`,`fldplr2`,`fldplr3`,`fldplr4`,`fldplr5`,`fldplr6`,`fldplr7`,`fldplr8`,`fldplr9`,`fldplr10`,`fldSymptom1`,`fldSymptom2`,`fldSymptom3`,`fldSymptom4`,`fldSymptom5`,`fldSymptom6`,`fldSymptom7`,`fldSymptom8`,`fldSymptom9`,`fldSymptom10`,`fldacsno1`,`fldacsno2`,`fldacsno3`,`fldacsno4`,`fldacsno5`,`fldacsno6`,`fldacsno7`,`fldacsno8`,`fldacsno9`,`fldacsno10`,`fldSymptoms`,`fldHistory`,`fldPatientroom`,`fldAfterhours`,`fldAuthorized`,`fldTechnologist`,`fldDispatched`,`fldDispatchedDate`,`fldVerbal`,`fldCoded`,`fldReportDate`,`fldReportCalledTo`,`fldReportCalledToDateTime`,`fldReportDetails`,`fldCDRequested`,`fldCDAddr`,`fldCreDate`,`fldAuthDate`,`fldVerbalnoofpat`,`fldRadiologist`,`fldSchDate`,`fldSchTime`,`fldFacPhone`,`fldCDDate`,`fldCDTimeRequested`,`fldnoofviews`,`fldExamDate`,`fldStairs`,`fldNstairs`,`fldpps`,`fldSign`,`fldException1`,`fldException2`,`fldException3`,`fldExp1Date`,`fdlExp2Date`,`fldExp3Date`,`fldExp1Resh`,`fldExp2Resh`,`fldExp3Resh`,`fldSign1`,`fldSign2`,`fldSign3`,`fldSign4`,`fldSign5`,`fldSign6`,`fldSign7`,`fldSign8`,`fldSign9`,`fldSign10`,`fldCDShipDate`,`tr_modified_by`,`tr_modified_date`,`created_by`,`created_date`,`modified_by`,`modified_date`,`fldPatNotes`,`fldOrderingPhysiciansPhone`,`fldPrivateHousingNo`,`fldReportFax`,`fldBackupFax`,`fldBackupPhone`,`fldOrderType`,`fldbilled`,`fldStation`,`fldFacFax`,`fldNotes`,`fldOrderingPhysiciansFax`,`fldDiagnosisReuired1`,`fldDiagnosisReuired2`,`fldDiagnosisReuired3`,`fldRepeat`,`fldRepeatDays`,`fldRepeatTimes`,`fldTestPriority`,`fldLocFacName`,`fldlabtype`,`labSentTo`,`fldLabDeliveredDate`,`fldLabDeliveredTime`,`fldtechComplete`,`fldRepeatParent`,`fldMarkCompletedBy`,`fldMarkCompletedDate`,`fldPrivateResidenceNumber`,`fldOPNotinDB`,`fldStatus`,`fldCancelNotes`,`fldCanceledBy`,`fldCanceledDate`) values (41621,'54237','2014-01-24 12:22:00','ADMIN','154-21-4752','VERONICA','BARKER','','','1925-04-20','female','','','','','','','','','','','','Abbott Road Nursing Facility','','','','','','','','','','','','',1,'Mary Smith, M.D','BO','FEMUR 2V','','','','','','','','','','RIGHT','','','','','','','','','','Pain in Arm/Leg','','','','','','','','','','20140124-1224111','20140124-1224112','20140124-1224113','20140124-1224114','20140124-1224115','20140124-1224116','20140124-1224117','20140124-1224118','20140124-1224119','20140124-12241110','','','',0,0,'',0,NULL,0,0,'0000-00-00 00:00:00','',NULL,'',0,'','2014-01-24','0000-00-00 00:00:00',0,'','2014-01-24','12:22:00','(716)555-2136','0000-00-00',NULL,0,'00:00:00',NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin','2014-01-24 12:24:11',NULL,NULL,'','','','','','',1,'insurance','','','','','','','',0,0,0,0,'','',NULL,NULL,NULL,0,NULL,NULL,NULL,'',0,0,'0',NULL,NULL);
insert  into `tblorderdetails`(`fldID`,`fldPatientID`,`fldDate`,`fldUserName`,`fldPatientSSN`,`fldFirstName`,`fldLastName`,`fldMiddleName`,`fldSurName`,`fldDOB`,`fldGender`,`fldInsurance`,`fldMedicareNumber`,`fldMedicaidNumber`,`fldState`,`fldInsuranceCompanyName`,`fldHmoContract`,`fldPolicy`,`fldGroup`,`fldResponsiblePerson`,`fldPhone`,`fldRelationship`,`fldFacilityName`,`fldPrivateAddressLine1`,`fldPrivateAddressLine2`,`fldPrivateAddressCity`,`fldPrivateAddressState`,`fldPrivateAddressZip`,`fldPrivatePhoneNumber`,`fldHomeAddressLine1`,`fldHomeAddressLine2`,`fldHomeAddressCity`,`fldHomeAddressState`,`fldHomeAddressZip`,`fldHomePhoneNumber`,`fldStat`,`fldOrderingPhysicians`,`fldRequestedBy`,`fldProcedure1`,`fldProcedure2`,`fldProcedure3`,`fldProcedure4`,`fldProcedure5`,`fldProcedure6`,`fldProcedure7`,`fldProcedure8`,`fldProcedure9`,`fldProcedure10`,`fldplr1`,`fldplr2`,`fldplr3`,`fldplr4`,`fldplr5`,`fldplr6`,`fldplr7`,`fldplr8`,`fldplr9`,`fldplr10`,`fldSymptom1`,`fldSymptom2`,`fldSymptom3`,`fldSymptom4`,`fldSymptom5`,`fldSymptom6`,`fldSymptom7`,`fldSymptom8`,`fldSymptom9`,`fldSymptom10`,`fldacsno1`,`fldacsno2`,`fldacsno3`,`fldacsno4`,`fldacsno5`,`fldacsno6`,`fldacsno7`,`fldacsno8`,`fldacsno9`,`fldacsno10`,`fldSymptoms`,`fldHistory`,`fldPatientroom`,`fldAfterhours`,`fldAuthorized`,`fldTechnologist`,`fldDispatched`,`fldDispatchedDate`,`fldVerbal`,`fldCoded`,`fldReportDate`,`fldReportCalledTo`,`fldReportCalledToDateTime`,`fldReportDetails`,`fldCDRequested`,`fldCDAddr`,`fldCreDate`,`fldAuthDate`,`fldVerbalnoofpat`,`fldRadiologist`,`fldSchDate`,`fldSchTime`,`fldFacPhone`,`fldCDDate`,`fldCDTimeRequested`,`fldnoofviews`,`fldExamDate`,`fldStairs`,`fldNstairs`,`fldpps`,`fldSign`,`fldException1`,`fldException2`,`fldException3`,`fldExp1Date`,`fdlExp2Date`,`fldExp3Date`,`fldExp1Resh`,`fldExp2Resh`,`fldExp3Resh`,`fldSign1`,`fldSign2`,`fldSign3`,`fldSign4`,`fldSign5`,`fldSign6`,`fldSign7`,`fldSign8`,`fldSign9`,`fldSign10`,`fldCDShipDate`,`tr_modified_by`,`tr_modified_date`,`created_by`,`created_date`,`modified_by`,`modified_date`,`fldPatNotes`,`fldOrderingPhysiciansPhone`,`fldPrivateHousingNo`,`fldReportFax`,`fldBackupFax`,`fldBackupPhone`,`fldOrderType`,`fldbilled`,`fldStation`,`fldFacFax`,`fldNotes`,`fldOrderingPhysiciansFax`,`fldDiagnosisReuired1`,`fldDiagnosisReuired2`,`fldDiagnosisReuired3`,`fldRepeat`,`fldRepeatDays`,`fldRepeatTimes`,`fldTestPriority`,`fldLocFacName`,`fldlabtype`,`labSentTo`,`fldLabDeliveredDate`,`fldLabDeliveredTime`,`fldtechComplete`,`fldRepeatParent`,`fldMarkCompletedBy`,`fldMarkCompletedDate`,`fldPrivateResidenceNumber`,`fldOPNotinDB`,`fldStatus`,`fldCancelNotes`,`fldCanceledBy`,`fldCanceledDate`) values (41622,'54238','2014-01-24 12:35:00','ADMIN','014-57-8962','NICOLE','POSTAL','','','1940-02-16','female','','','','','','','','','','','','Crestwood Assisted Living','','','','','','','','','','','','',0,'Mary Smith, M.D','PAULA','CHEST 1V','','','','','','','','','','NA','','','','','','','','','','COPD','','','','','','','','','','20140124-1236161','20140124-1236162','20140124-1236163','20140124-1236164','20140124-1236165','20140124-1236166','20140124-1236167','20140124-1236168','20140124-1236169','20140124-12361610','','','',0,0,'',0,NULL,0,0,'0000-00-00 00:00:00','',NULL,'',0,'','2014-01-24','0000-00-00 00:00:00',0,'','2014-01-24','12:35:00','(716)555-6980','0000-00-00',NULL,0,'00:00:00',NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin','2014-01-24 12:36:16',NULL,NULL,'','','','','','',1,'insurance','','','','','','','',0,0,0,0,'','',NULL,NULL,NULL,0,NULL,NULL,NULL,'',0,0,'0',NULL,NULL);
insert  into `tblorderdetails`(`fldID`,`fldPatientID`,`fldDate`,`fldUserName`,`fldPatientSSN`,`fldFirstName`,`fldLastName`,`fldMiddleName`,`fldSurName`,`fldDOB`,`fldGender`,`fldInsurance`,`fldMedicareNumber`,`fldMedicaidNumber`,`fldState`,`fldInsuranceCompanyName`,`fldHmoContract`,`fldPolicy`,`fldGroup`,`fldResponsiblePerson`,`fldPhone`,`fldRelationship`,`fldFacilityName`,`fldPrivateAddressLine1`,`fldPrivateAddressLine2`,`fldPrivateAddressCity`,`fldPrivateAddressState`,`fldPrivateAddressZip`,`fldPrivatePhoneNumber`,`fldHomeAddressLine1`,`fldHomeAddressLine2`,`fldHomeAddressCity`,`fldHomeAddressState`,`fldHomeAddressZip`,`fldHomePhoneNumber`,`fldStat`,`fldOrderingPhysicians`,`fldRequestedBy`,`fldProcedure1`,`fldProcedure2`,`fldProcedure3`,`fldProcedure4`,`fldProcedure5`,`fldProcedure6`,`fldProcedure7`,`fldProcedure8`,`fldProcedure9`,`fldProcedure10`,`fldplr1`,`fldplr2`,`fldplr3`,`fldplr4`,`fldplr5`,`fldplr6`,`fldplr7`,`fldplr8`,`fldplr9`,`fldplr10`,`fldSymptom1`,`fldSymptom2`,`fldSymptom3`,`fldSymptom4`,`fldSymptom5`,`fldSymptom6`,`fldSymptom7`,`fldSymptom8`,`fldSymptom9`,`fldSymptom10`,`fldacsno1`,`fldacsno2`,`fldacsno3`,`fldacsno4`,`fldacsno5`,`fldacsno6`,`fldacsno7`,`fldacsno8`,`fldacsno9`,`fldacsno10`,`fldSymptoms`,`fldHistory`,`fldPatientroom`,`fldAfterhours`,`fldAuthorized`,`fldTechnologist`,`fldDispatched`,`fldDispatchedDate`,`fldVerbal`,`fldCoded`,`fldReportDate`,`fldReportCalledTo`,`fldReportCalledToDateTime`,`fldReportDetails`,`fldCDRequested`,`fldCDAddr`,`fldCreDate`,`fldAuthDate`,`fldVerbalnoofpat`,`fldRadiologist`,`fldSchDate`,`fldSchTime`,`fldFacPhone`,`fldCDDate`,`fldCDTimeRequested`,`fldnoofviews`,`fldExamDate`,`fldStairs`,`fldNstairs`,`fldpps`,`fldSign`,`fldException1`,`fldException2`,`fldException3`,`fldExp1Date`,`fdlExp2Date`,`fldExp3Date`,`fldExp1Resh`,`fldExp2Resh`,`fldExp3Resh`,`fldSign1`,`fldSign2`,`fldSign3`,`fldSign4`,`fldSign5`,`fldSign6`,`fldSign7`,`fldSign8`,`fldSign9`,`fldSign10`,`fldCDShipDate`,`tr_modified_by`,`tr_modified_date`,`created_by`,`created_date`,`modified_by`,`modified_date`,`fldPatNotes`,`fldOrderingPhysiciansPhone`,`fldPrivateHousingNo`,`fldReportFax`,`fldBackupFax`,`fldBackupPhone`,`fldOrderType`,`fldbilled`,`fldStation`,`fldFacFax`,`fldNotes`,`fldOrderingPhysiciansFax`,`fldDiagnosisReuired1`,`fldDiagnosisReuired2`,`fldDiagnosisReuired3`,`fldRepeat`,`fldRepeatDays`,`fldRepeatTimes`,`fldTestPriority`,`fldLocFacName`,`fldlabtype`,`labSentTo`,`fldLabDeliveredDate`,`fldLabDeliveredTime`,`fldtechComplete`,`fldRepeatParent`,`fldMarkCompletedBy`,`fldMarkCompletedDate`,`fldPrivateResidenceNumber`,`fldOPNotinDB`,`fldStatus`,`fldCancelNotes`,`fldCanceledBy`,`fldCanceledDate`) values (41623,'54239','2014-02-17 13:34:26','ADMIN','046-21-5796','KRISTEN','DIXON','','','1983-07-29','female','','','','','','','','','','','','Abbott Road Nursing Facility','','','','','','','','','','','','',0,'Mary Smith, M.D','MARY','ANKLE 3V','','','','','','','','','','LEFT','','','','','','','','','','Ankle Pain','','','','','','','','','','20140217-1333331','20140217-1333332','20140217-1333333','20140217-1333334','20140217-1333335','20140217-1333336','20140217-1333337','20140217-1333338','20140217-1333339','20140217-13333310','','','',0,0,'MWRIGHT',1,'2014-02-17 00:00:00',0,0,'0000-00-00 00:00:00','',NULL,'',0,'','2014-02-17','0000-00-00 00:00:00',0,'','2014-02-17','13:32:00','(716)555-2136','0000-00-00',NULL,0,'00:00:00',NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin','2014-02-17 13:33:33',NULL,NULL,'','','','','','',1,'insurance','','','','','','','',0,0,0,0,'','',NULL,NULL,NULL,0,NULL,NULL,NULL,'',0,0,'0',NULL,NULL);
insert  into `tblorderdetails`(`fldID`,`fldPatientID`,`fldDate`,`fldUserName`,`fldPatientSSN`,`fldFirstName`,`fldLastName`,`fldMiddleName`,`fldSurName`,`fldDOB`,`fldGender`,`fldInsurance`,`fldMedicareNumber`,`fldMedicaidNumber`,`fldState`,`fldInsuranceCompanyName`,`fldHmoContract`,`fldPolicy`,`fldGroup`,`fldResponsiblePerson`,`fldPhone`,`fldRelationship`,`fldFacilityName`,`fldPrivateAddressLine1`,`fldPrivateAddressLine2`,`fldPrivateAddressCity`,`fldPrivateAddressState`,`fldPrivateAddressZip`,`fldPrivatePhoneNumber`,`fldHomeAddressLine1`,`fldHomeAddressLine2`,`fldHomeAddressCity`,`fldHomeAddressState`,`fldHomeAddressZip`,`fldHomePhoneNumber`,`fldStat`,`fldOrderingPhysicians`,`fldRequestedBy`,`fldProcedure1`,`fldProcedure2`,`fldProcedure3`,`fldProcedure4`,`fldProcedure5`,`fldProcedure6`,`fldProcedure7`,`fldProcedure8`,`fldProcedure9`,`fldProcedure10`,`fldplr1`,`fldplr2`,`fldplr3`,`fldplr4`,`fldplr5`,`fldplr6`,`fldplr7`,`fldplr8`,`fldplr9`,`fldplr10`,`fldSymptom1`,`fldSymptom2`,`fldSymptom3`,`fldSymptom4`,`fldSymptom5`,`fldSymptom6`,`fldSymptom7`,`fldSymptom8`,`fldSymptom9`,`fldSymptom10`,`fldacsno1`,`fldacsno2`,`fldacsno3`,`fldacsno4`,`fldacsno5`,`fldacsno6`,`fldacsno7`,`fldacsno8`,`fldacsno9`,`fldacsno10`,`fldSymptoms`,`fldHistory`,`fldPatientroom`,`fldAfterhours`,`fldAuthorized`,`fldTechnologist`,`fldDispatched`,`fldDispatchedDate`,`fldVerbal`,`fldCoded`,`fldReportDate`,`fldReportCalledTo`,`fldReportCalledToDateTime`,`fldReportDetails`,`fldCDRequested`,`fldCDAddr`,`fldCreDate`,`fldAuthDate`,`fldVerbalnoofpat`,`fldRadiologist`,`fldSchDate`,`fldSchTime`,`fldFacPhone`,`fldCDDate`,`fldCDTimeRequested`,`fldnoofviews`,`fldExamDate`,`fldStairs`,`fldNstairs`,`fldpps`,`fldSign`,`fldException1`,`fldException2`,`fldException3`,`fldExp1Date`,`fdlExp2Date`,`fldExp3Date`,`fldExp1Resh`,`fldExp2Resh`,`fldExp3Resh`,`fldSign1`,`fldSign2`,`fldSign3`,`fldSign4`,`fldSign5`,`fldSign6`,`fldSign7`,`fldSign8`,`fldSign9`,`fldSign10`,`fldCDShipDate`,`tr_modified_by`,`tr_modified_date`,`created_by`,`created_date`,`modified_by`,`modified_date`,`fldPatNotes`,`fldOrderingPhysiciansPhone`,`fldPrivateHousingNo`,`fldReportFax`,`fldBackupFax`,`fldBackupPhone`,`fldOrderType`,`fldbilled`,`fldStation`,`fldFacFax`,`fldNotes`,`fldOrderingPhysiciansFax`,`fldDiagnosisReuired1`,`fldDiagnosisReuired2`,`fldDiagnosisReuired3`,`fldRepeat`,`fldRepeatDays`,`fldRepeatTimes`,`fldTestPriority`,`fldLocFacName`,`fldlabtype`,`labSentTo`,`fldLabDeliveredDate`,`fldLabDeliveredTime`,`fldtechComplete`,`fldRepeatParent`,`fldMarkCompletedBy`,`fldMarkCompletedDate`,`fldPrivateResidenceNumber`,`fldOPNotinDB`,`fldStatus`,`fldCancelNotes`,`fldCanceledBy`,`fldCanceledDate`) values (41624,'54240','2014-02-20 06:32:01','MSMITH','468-79-1319','KRISTEN','DIXON','','','1942-07-30','female','','','','','','','','','','','','Abbott Road Nursing Facility','','','','','','','','','','','','',0,'Mary Smith, M.D','STEVE','CHEST 1V','','','','','','','','','','','','','','','','','','','','Airway Obst/COPD','','','','','','','','','','20140220-0623541','20140220-0623542','20140220-0623543','20140220-0623544','20140220-0623545','20140220-0623546','20140220-0623547','20140220-0623548','20140220-0623549','20140220-06235410','','','',0,0,'PBERRY',1,'2014-02-20 06:32:00',0,0,'0000-00-00 00:00:00','',NULL,'',0,'','2014-02-20','0000-00-00 00:00:00',0,'','2014-02-20','06:23:00','(716)555-2136','0000-00-00',NULL,0,'00:00:00',NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'msmith','2014-02-20 06:23:54',NULL,NULL,'','','','','','',1,'insurance','','','','','','','',0,0,0,0,'','',NULL,NULL,NULL,0,NULL,NULL,NULL,'',0,0,'0',NULL,NULL);
insert  into `tblorderdetails`(`fldID`,`fldPatientID`,`fldDate`,`fldUserName`,`fldPatientSSN`,`fldFirstName`,`fldLastName`,`fldMiddleName`,`fldSurName`,`fldDOB`,`fldGender`,`fldInsurance`,`fldMedicareNumber`,`fldMedicaidNumber`,`fldState`,`fldInsuranceCompanyName`,`fldHmoContract`,`fldPolicy`,`fldGroup`,`fldResponsiblePerson`,`fldPhone`,`fldRelationship`,`fldFacilityName`,`fldPrivateAddressLine1`,`fldPrivateAddressLine2`,`fldPrivateAddressCity`,`fldPrivateAddressState`,`fldPrivateAddressZip`,`fldPrivatePhoneNumber`,`fldHomeAddressLine1`,`fldHomeAddressLine2`,`fldHomeAddressCity`,`fldHomeAddressState`,`fldHomeAddressZip`,`fldHomePhoneNumber`,`fldStat`,`fldOrderingPhysicians`,`fldRequestedBy`,`fldProcedure1`,`fldProcedure2`,`fldProcedure3`,`fldProcedure4`,`fldProcedure5`,`fldProcedure6`,`fldProcedure7`,`fldProcedure8`,`fldProcedure9`,`fldProcedure10`,`fldplr1`,`fldplr2`,`fldplr3`,`fldplr4`,`fldplr5`,`fldplr6`,`fldplr7`,`fldplr8`,`fldplr9`,`fldplr10`,`fldSymptom1`,`fldSymptom2`,`fldSymptom3`,`fldSymptom4`,`fldSymptom5`,`fldSymptom6`,`fldSymptom7`,`fldSymptom8`,`fldSymptom9`,`fldSymptom10`,`fldacsno1`,`fldacsno2`,`fldacsno3`,`fldacsno4`,`fldacsno5`,`fldacsno6`,`fldacsno7`,`fldacsno8`,`fldacsno9`,`fldacsno10`,`fldSymptoms`,`fldHistory`,`fldPatientroom`,`fldAfterhours`,`fldAuthorized`,`fldTechnologist`,`fldDispatched`,`fldDispatchedDate`,`fldVerbal`,`fldCoded`,`fldReportDate`,`fldReportCalledTo`,`fldReportCalledToDateTime`,`fldReportDetails`,`fldCDRequested`,`fldCDAddr`,`fldCreDate`,`fldAuthDate`,`fldVerbalnoofpat`,`fldRadiologist`,`fldSchDate`,`fldSchTime`,`fldFacPhone`,`fldCDDate`,`fldCDTimeRequested`,`fldnoofviews`,`fldExamDate`,`fldStairs`,`fldNstairs`,`fldpps`,`fldSign`,`fldException1`,`fldException2`,`fldException3`,`fldExp1Date`,`fdlExp2Date`,`fldExp3Date`,`fldExp1Resh`,`fldExp2Resh`,`fldExp3Resh`,`fldSign1`,`fldSign2`,`fldSign3`,`fldSign4`,`fldSign5`,`fldSign6`,`fldSign7`,`fldSign8`,`fldSign9`,`fldSign10`,`fldCDShipDate`,`tr_modified_by`,`tr_modified_date`,`created_by`,`created_date`,`modified_by`,`modified_date`,`fldPatNotes`,`fldOrderingPhysiciansPhone`,`fldPrivateHousingNo`,`fldReportFax`,`fldBackupFax`,`fldBackupPhone`,`fldOrderType`,`fldbilled`,`fldStation`,`fldFacFax`,`fldNotes`,`fldOrderingPhysiciansFax`,`fldDiagnosisReuired1`,`fldDiagnosisReuired2`,`fldDiagnosisReuired3`,`fldRepeat`,`fldRepeatDays`,`fldRepeatTimes`,`fldTestPriority`,`fldLocFacName`,`fldlabtype`,`labSentTo`,`fldLabDeliveredDate`,`fldLabDeliveredTime`,`fldtechComplete`,`fldRepeatParent`,`fldMarkCompletedBy`,`fldMarkCompletedDate`,`fldPrivateResidenceNumber`,`fldOPNotinDB`,`fldStatus`,`fldCancelNotes`,`fldCanceledBy`,`fldCanceledDate`) values (41625,'54241','2014-02-20 06:28:00','ADMIN','546-87-6193','MYLES','DAVIS','','','1920-04-16','male','Blue Cross Blue Shield','156830','','','BLUE CROSS','','156461','1','','','Mother','Crestwood Assisted Living','','','','','','','','','','','','',0,'','','Abdominal Limited','','','','','','','','','','','','','','','','','','','','Abn. Bowel Sounds','','','','','','','','','','20140220-0637191','20140220-0637192','20140220-0637193','20140220-0637194','20140220-0637195','20140220-0637196','20140220-0637197','20140220-0637198','20140220-0637199','20140220-06371910','','','',0,0,'',0,NULL,0,0,'0000-00-00 00:00:00','',NULL,'',0,'','2014-02-20','0000-00-00 00:00:00',0,'','2014-02-20','06:28:00','(716)555-6980','0000-00-00',NULL,0,'00:00:00',NULL,NULL,'YES',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin','2014-02-20 06:29:14','admin','2014-02-20 06:37:19','','','','','','',1,'insurance','','','','','','','',0,0,0,0,'','',NULL,NULL,NULL,0,NULL,NULL,NULL,'',0,0,'0',NULL,NULL);
insert  into `tblorderdetails`(`fldID`,`fldPatientID`,`fldDate`,`fldUserName`,`fldPatientSSN`,`fldFirstName`,`fldLastName`,`fldMiddleName`,`fldSurName`,`fldDOB`,`fldGender`,`fldInsurance`,`fldMedicareNumber`,`fldMedicaidNumber`,`fldState`,`fldInsuranceCompanyName`,`fldHmoContract`,`fldPolicy`,`fldGroup`,`fldResponsiblePerson`,`fldPhone`,`fldRelationship`,`fldFacilityName`,`fldPrivateAddressLine1`,`fldPrivateAddressLine2`,`fldPrivateAddressCity`,`fldPrivateAddressState`,`fldPrivateAddressZip`,`fldPrivatePhoneNumber`,`fldHomeAddressLine1`,`fldHomeAddressLine2`,`fldHomeAddressCity`,`fldHomeAddressState`,`fldHomeAddressZip`,`fldHomePhoneNumber`,`fldStat`,`fldOrderingPhysicians`,`fldRequestedBy`,`fldProcedure1`,`fldProcedure2`,`fldProcedure3`,`fldProcedure4`,`fldProcedure5`,`fldProcedure6`,`fldProcedure7`,`fldProcedure8`,`fldProcedure9`,`fldProcedure10`,`fldplr1`,`fldplr2`,`fldplr3`,`fldplr4`,`fldplr5`,`fldplr6`,`fldplr7`,`fldplr8`,`fldplr9`,`fldplr10`,`fldSymptom1`,`fldSymptom2`,`fldSymptom3`,`fldSymptom4`,`fldSymptom5`,`fldSymptom6`,`fldSymptom7`,`fldSymptom8`,`fldSymptom9`,`fldSymptom10`,`fldacsno1`,`fldacsno2`,`fldacsno3`,`fldacsno4`,`fldacsno5`,`fldacsno6`,`fldacsno7`,`fldacsno8`,`fldacsno9`,`fldacsno10`,`fldSymptoms`,`fldHistory`,`fldPatientroom`,`fldAfterhours`,`fldAuthorized`,`fldTechnologist`,`fldDispatched`,`fldDispatchedDate`,`fldVerbal`,`fldCoded`,`fldReportDate`,`fldReportCalledTo`,`fldReportCalledToDateTime`,`fldReportDetails`,`fldCDRequested`,`fldCDAddr`,`fldCreDate`,`fldAuthDate`,`fldVerbalnoofpat`,`fldRadiologist`,`fldSchDate`,`fldSchTime`,`fldFacPhone`,`fldCDDate`,`fldCDTimeRequested`,`fldnoofviews`,`fldExamDate`,`fldStairs`,`fldNstairs`,`fldpps`,`fldSign`,`fldException1`,`fldException2`,`fldException3`,`fldExp1Date`,`fdlExp2Date`,`fldExp3Date`,`fldExp1Resh`,`fldExp2Resh`,`fldExp3Resh`,`fldSign1`,`fldSign2`,`fldSign3`,`fldSign4`,`fldSign5`,`fldSign6`,`fldSign7`,`fldSign8`,`fldSign9`,`fldSign10`,`fldCDShipDate`,`tr_modified_by`,`tr_modified_date`,`created_by`,`created_date`,`modified_by`,`modified_date`,`fldPatNotes`,`fldOrderingPhysiciansPhone`,`fldPrivateHousingNo`,`fldReportFax`,`fldBackupFax`,`fldBackupPhone`,`fldOrderType`,`fldbilled`,`fldStation`,`fldFacFax`,`fldNotes`,`fldOrderingPhysiciansFax`,`fldDiagnosisReuired1`,`fldDiagnosisReuired2`,`fldDiagnosisReuired3`,`fldRepeat`,`fldRepeatDays`,`fldRepeatTimes`,`fldTestPriority`,`fldLocFacName`,`fldlabtype`,`labSentTo`,`fldLabDeliveredDate`,`fldLabDeliveredTime`,`fldtechComplete`,`fldRepeatParent`,`fldMarkCompletedBy`,`fldMarkCompletedDate`,`fldPrivateResidenceNumber`,`fldOPNotinDB`,`fldStatus`,`fldCancelNotes`,`fldCanceledBy`,`fldCanceledDate`) values (41626,'54242','2014-02-20 06:33:12','ADMIN','046-51-8976','DIANE','ELLINGTON','','','1925-02-10','female','','','','','','','','','','','','Hospice Care','225 COMO PARK BLVD','','BUFFALO','NEW YORK','14227','','','','','','','',1,'','SUZY','FACIAL BONES 3V','','','','','','','','','','','','','','','','','','','','Face Pain','','','','','','','','','','20140220-0631431','20140220-0631432','20140220-0631433','20140220-0631434','20140220-0631435','20140220-0631436','20140220-0631437','20140220-0631438','20140220-0631439','20140220-06314310','','','',0,0,'MWRIGHT',1,'2014-02-20 06:33:00',0,0,'0000-00-00 00:00:00','','0000-00-00 00:00:00','',0,'','2014-02-20','0000-00-00 00:00:00',0,'','2014-02-20','06:31:00','(716)555-1489','0000-00-00','00:00:00',0,'00:00:00',NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','','',0,0,0,0,'0000-00-00','admin','0000-00-00 00:00:00','admin','2014-02-20 06:31:43',NULL,NULL,'','','','','','',3,'insurance','','','','','','','',0,0,0,0,'HOSPICE CARE','','','0000-00-00','00:00:00',0,NULL,NULL,'0000-00-00 00:00:00','',0,0,'0',NULL,NULL);

/*Table structure for table `tblproceduremanagment` */

DROP TABLE IF EXISTS `tblproceduremanagment`;

CREATE TABLE `tblproceduremanagment` (
  `fldID` int(25) NOT NULL AUTO_INCREMENT,
  `fldCBTCode` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `fldDescription` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldModality` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldCategory` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`fldID`)
) ENGINE=MyISAM AUTO_INCREMENT=269 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tblproceduremanagment` */

insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (129,'74000','ABDOMEN 1V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (130,'74020','ABDOMEN 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (131,'74022','ABDOMEN 3 V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (132,'76705','Abdominal Limited','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (133,'76700','Abdominal Ultrasound','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (134,'93922','ABI','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (135,'73050','AC JOINTS BILAT','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (136,'82040','Albumin','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (137,'84075','Alk Phos','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (138,'84460','ALT','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (139,'82150','Amylase','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (140,'73600','ANKLE 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (141,'73610','ANKLE 3V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (142,'87730','APTT','LAB','Coagulation');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (143,'93923','Arterial Doppler Lower','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (144,'93923','Arterial Doppler Upper','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (145,'93924','Arterial Doppler w Exercise','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (146,'84450','AST','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (147,'80048','Basic Metabolic Panel','LAB','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (148,'76857','Bladder Pelvis Limited','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (149,'77081','Bone Density Appenducular Skeleton','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (150,'77080','Bone Density Ultrasound','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (151,'82310','Calcium','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (152,'93880','Carotid Doppler','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (153,'85007','CBC Manual Diff (billed with 80027)','LAB','Hematology');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (154,'85025','CBC w/Auto Diff','LAB','Hematology');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (155,'85027','CBC w/o Diff','LAB','Hematology');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (156,'71010','CHEST 1V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (157,'71020','CHEST 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (158,'71022','CHEST 3V W/OBLIQUE','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (159,'71030','CHEST MIN 4V W/OBLIQUES','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (160,'76604','Chest Sono','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (161,'82435','Chloride','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (162,'73000','CLAVICLE 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (163,'82374','CO2','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (164,'80053','Comp Metabolic Panel','LAB','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (165,'86140','CRP','LAB','Other');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (166,'72040','C-SPINE 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (167,'72050','C-SPINE 4V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (168,'93325','Doppler Color Flow','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (169,'93303','Echocardiogram complete - Pediatric','ECHO','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (170,'93306','Echocardiogram Complete','ECHO','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (171,'93005','EKG','EKG','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (172,'73070','ELBOW 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (173,'73080','ELBOW 3V W/OBLIQUE','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (174,'80051','Electrolute Panel','LAB','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (175,'70150','FACIAL BONES 3V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (176,'73550','FEMUR 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (177,'82728','Ferritin','LAB','Special Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (178,'73140','FINGER(S) 3V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (179,'82746','Folate','LAB','Special Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (180,'73630','FOOT 3V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (181,'73090','FOREARM 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (182,'84439','Free T4','LAB','Special Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (183,'82977','GGTP','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (184,'82947','Glucose (FBS)','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (185,'83036','Gly Hgb (A1C)','LAB','Special Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (186,'73120','HAND 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (187,'73130','HAND 3V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (188,'73650','HEEL 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (189,'85014','Hematocrit','LAB','Hematology');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (190,'85018','Hemoglobin','LAB','Hematology');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (191,'73500','HIP 1V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (192,'73510','HIP 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (193,'73520','HIP 3 V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (194,'73060','HUMERUS 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (195,'83550','Iron Binding (IBC)','LAB','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (196,'73560','KNEE 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (197,'73562','KNEE 3V w sunrise','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (198,'80061','Lipid Panel','LAB','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (199,'80076','Liver Panel','LAB','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (200,'72100','L-SPINE 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (201,'72110','L-SPINE COMPLETE','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (202,'70100','MANDIBLE 1-3V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (203,'70110','Mandible 4 views','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (204,'82044','Micro Albumin (random)','LAB','Other');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (205,'70160','NASAL BONES 3V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (206,'70200','ORBITS 4V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (207,'76857','Ovarian Follicle','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (208,'72170','PELVIS 1V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (209,'76856','Pelvis Complete','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (210,'84100','Phosphorus','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (211,'85610','Protime/INR','LAB','Coagulation');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (212,'84153','PSA','LAB','Special Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (213,'87880','Rapid Strep','LAB','Microbiology');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (214,'93930','Real Time Art Dop Bil Up','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (215,'93925','Real Time Arterial Doppler Bilat Lower','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (216,'93926','Real Time Arterial Doppler Unilat Lower','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (217,'93931','Real Time Arterial Doppler Unilat Upper','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (218,'76770','Retroperitoneum Renal Complete','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (219,'86431','Rheum Factor','LAB','Other');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (220,'71100','RIB 2VW','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (221,'71101','RIB 3VW','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (222,'71110','Rib Bilat 3vw','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (223,'71111','Ribs Min 4vw','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (224,'71101','RIBS, UNI W/CHEST 3V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (225,'72202','SACRO-ILIAC 3 OR MORE','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (226,'72220','SACRUM/COCCYX 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (227,'73010','SCAPULA 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (228,'85652','Sed Rate','LAB','Hematology');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (229,'83540','Serum Iron','LAB','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (230,'73020','SHOULDER 1V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (231,'73030','SHOULDER 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (232,'70220','SINUSES 3V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (233,'70250','SKULL 1-3V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (234,'84295','Sodium','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (235,'70360','SOFT TISSUE NECK 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (236,'76880','Soft Tissue/Extremity','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (238,'72020','SPINE 1V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (239,'72010','SPINE ENTIRE SURVEY','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (266,'73660','Toes','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (241,'71130','STERNOVACULAR FTS','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (242,'71120','STERNUM 2VW','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (243,'93350','Stress Echo','ECHO','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (244,'76870','Testicular Scrotal','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (245,'72080','THORACOLUMBAR JUNC','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (246,'87081','Throat Culture','LAB','Microbiology');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (247,'76536','Thyroid Parotid Neck','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (248,'73590','TIBIA/FIBULA 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (249,'84155','Total Protein','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (250,'76872','TRANS RECTAL US','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (251,'84478','Triglycerides','LAB','Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (252,'84443','TSH','LAB','Special Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (253,'72070','T-SPINE 2V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (254,'81001','Urinalysis','LAB','Urines');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (255,'87086','Urine Culture','LAB','Urines');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (256,'36415','Venipuncture','LAB','Draw');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (257,'93970','Venous Doppler Bilateral','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (258,'93971','Venous Doppler Unilateral Upper','US','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (259,'82607','Vitamin B-12','LAB','Special Chemistry');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (260,'73110','WRIST 3V','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (261,'0000000','EMPLOYEE','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (262,'93971','Venous Doppler Lower','US',NULL);
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (268,'73520','Pelvis w/bilat hips - 5 vws','CR','');
insert  into `tblproceduremanagment`(`fldID`,`fldCBTCode`,`fldDescription`,`fldModality`,`fldCategory`) values (267,'72070','THORACIC SPINE','CR','');

/*Table structure for table `tblsettings` */

DROP TABLE IF EXISTS `tblsettings`;

CREATE TABLE `tblsettings` (
  `fldEmailSignedOrders1` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldEmailSendOrders1` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldPDFUnsignedOrders` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldPDFSignedOrders` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `flddmwl` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldEmailSignedOrders2` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldEmailSendOrders2` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `mapAddress` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `mapLatLong` varchar(25) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tblsettings` */

insert  into `tblsettings`(`fldEmailSignedOrders1`,`fldEmailSendOrders1`,`fldPDFUnsignedOrders`,`fldPDFSignedOrders`,`flddmwl`,`fldEmailSignedOrders2`,`fldEmailSendOrders2`,`mapAddress`,`mapLatLong`) values ('','','unsigned/','signed/','txt/','','','2795 Genesee St, Buffalo, NY 14225','42.9226219,-78.781166');

/*Table structure for table `tblstates` */

DROP TABLE IF EXISTS `tblstates`;

CREATE TABLE `tblstates` (
  `fldState` varchar(64) NOT NULL,
  `fldSt` varchar(4) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fldState`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tblstates` */

insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('ALABAMA','AL',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('ALASKA','AK',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('ARIZONA','AZ',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('ARKANSAS','AR',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('CALIFORNIA','CA',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('COLORADO','CO',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('CONNECTICUT','CT',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('DELAWARE','DE',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('FLORIDA','FL',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('GEORGIA','GA',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('HAWAII','HI',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('IDAHO','ID',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('ILLINOIS','IL',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('INDIANA','IN',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('IOWA','IA',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('KANSAS','KS',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('KENTUCKY','KY',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('LOUISIANA','LA',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('MAINE','ME',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('MARYLAND','MD',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('MASSACHUSETTS','MA',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('MICHIGAN','MI',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('MINNESOTA','MN',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('MISSISSIPPI','MS',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('MISSOURI','MO',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('MONTANA','MT',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('NEBRASKA','NE',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('NEVADA','NV',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('NEW HAMPSHIRE','NH',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('NEW JERSEY','NJ',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('NEW MEXICO','NM',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('NEW YORK','NY',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('NORTH CAROLINA','NC',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('NORTH DAKOTA','ND',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('OHIO','OH',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('OKLAHOMA','OK',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('OREGON','OR',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('PENNSYLVANIA','PA',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('PUERTO RICO','PR',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('RHODE ISLAND','RI',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('SOUTH CAROLINA','SC',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('SOUTH DAKOTA','SD',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('TENNESSEE','TN',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('TEXAS','TX',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('UTAH','UT',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('VERMONT','VT',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('VIRGINIA','VA',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('WASHINGTON','WA',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('WASHINGTON DC','DC',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('WEST VIRGINIA','WV',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('WISCONSIN','WI',1);
insert  into `tblstates`(`fldState`,`fldSt`,`active`) values ('WYOMING','WY',1);

/*Table structure for table `tblstations` */

DROP TABLE IF EXISTS `tblstations`;

CREATE TABLE `tblstations` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `facId` int(11) NOT NULL,
  `StationName` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `StationPhone` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `StationFax` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1254 DEFAULT CHARSET=latin1;

/*Data for the table `tblstations` */

/*Table structure for table `tblsysvar` */

DROP TABLE IF EXISTS `tblsysvar`;

CREATE TABLE `tblsysvar` (
  `varName` varchar(255) NOT NULL,
  `VarValue` varchar(255) NOT NULL,
  PRIMARY KEY (`varName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tblsysvar` */

insert  into `tblsysvar`(`varName`,`VarValue`) values ('autodispatch','0');

/*Table structure for table `tblsysvars` */

DROP TABLE IF EXISTS `tblsysvars`;

CREATE TABLE `tblsysvars` (
  `varName` varchar(255) NOT NULL,
  `VarValue` varchar(255) NOT NULL,
  PRIMARY KEY (`varName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tblsysvars` */

insert  into `tblsysvars`(`varName`,`VarValue`) values ('autodispatch','0');

/*Table structure for table `tbltechlog` */

DROP TABLE IF EXISTS `tbltechlog`;

CREATE TABLE `tbltechlog` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `techId` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  `eventDateTime` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `tbltechlog` */

/*Table structure for table `tbluser` */

DROP TABLE IF EXISTS `tbluser`;

CREATE TABLE `tbluser` (
  `fldID` int(25) NOT NULL AUTO_INCREMENT,
  `fldUserID` int(25) NOT NULL,
  `fldRealName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldUserName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldPassword` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `fldEmail` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldRole` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldFacility` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `fldPhone` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `fldEmailPref` tinyint(1) DEFAULT NULL,
  `fldSMSPref` tinyint(1) DEFAULT NULL,
  `fldOnline` tinyint(1) NOT NULL DEFAULT '0',
  `fldMainState` varchar(3) COLLATE latin1_general_ci NOT NULL,
  `fldPWChange` tinyint(1) NOT NULL DEFAULT '0',
  `fldStatus` enum('Enabled','Disabled') COLLATE latin1_general_ci DEFAULT 'Enabled',
  `fldFax` varchar(50) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`fldID`),
  UNIQUE KEY `fldUserName` (`fldUserName`)
) ENGINE=MyISAM AUTO_INCREMENT=3926 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbluser` */

insert  into `tbluser`(`fldID`,`fldUserID`,`fldRealName`,`fldUserName`,`fldPassword`,`fldEmail`,`fldRole`,`fldFacility`,`fldPhone`,`fldEmailPref`,`fldSMSPref`,`fldOnline`,`fldMainState`,`fldPWChange`,`fldStatus`,`fldFax`) values (1,1111111,'Mobile Digital Imaging','admin','21232f297a57a5a743894a0e4a801fc3','issues@mobiledigitalimaging.com','admin','','',0,0,0,'',0,'Enabled','');
insert  into `tbluser`(`fldID`,`fldUserID`,`fldRealName`,`fldUserName`,`fldPassword`,`fldEmail`,`fldRole`,`fldFacility`,`fldPhone`,`fldEmailPref`,`fldSMSPref`,`fldOnline`,`fldMainState`,`fldPWChange`,`fldStatus`,`fldFax`) values (3920,23724974,'Mary Smith, M.D','msmith','5f4dcc3b5aa765d61d8327deb882cf99','','orderingphysician','','',0,0,0,'NEW',0,'Enabled','');
insert  into `tbluser`(`fldID`,`fldUserID`,`fldRealName`,`fldUserName`,`fldPassword`,`fldEmail`,`fldRole`,`fldFacility`,`fldPhone`,`fldEmailPref`,`fldSMSPref`,`fldOnline`,`fldMainState`,`fldPWChange`,`fldStatus`,`fldFax`) values (3921,38176153,'Steven Turk, M.D.','sturk','5f4dcc3b5aa765d61d8327deb882cf99','','orderingphysician','','',0,0,0,'NEW',0,'Enabled','');
insert  into `tbluser`(`fldID`,`fldUserID`,`fldRealName`,`fldUserName`,`fldPassword`,`fldEmail`,`fldRole`,`fldFacility`,`fldPhone`,`fldEmailPref`,`fldSMSPref`,`fldOnline`,`fldMainState`,`fldPWChange`,`fldStatus`,`fldFax`) values (3922,4245394,'Paul Berry','pberry','5f4dcc3b5aa765d61d8327deb882cf99','','technologist','','',0,0,0,'NEW',0,'Enabled','');
insert  into `tbluser`(`fldID`,`fldUserID`,`fldRealName`,`fldUserName`,`fldPassword`,`fldEmail`,`fldRole`,`fldFacility`,`fldPhone`,`fldEmailPref`,`fldSMSPref`,`fldOnline`,`fldMainState`,`fldPWChange`,`fldStatus`,`fldFax`) values (3923,17461729,'Michele Wright','mwright','5f4dcc3b5aa765d61d8327deb882cf99','','technologist','','',0,0,0,'NEW',0,'Enabled','');
insert  into `tbluser`(`fldID`,`fldUserID`,`fldRealName`,`fldUserName`,`fldPassword`,`fldEmail`,`fldRole`,`fldFacility`,`fldPhone`,`fldEmailPref`,`fldSMSPref`,`fldOnline`,`fldMainState`,`fldPWChange`,`fldStatus`,`fldFax`) values (3924,57937649,'Dorthy Jones','djones','5f4dcc3b5aa765d61d8327deb882cf99','','dispatcher','','',0,0,0,'NEW',0,'Enabled','');
insert  into `tbluser`(`fldID`,`fldUserID`,`fldRealName`,`fldUserName`,`fldPassword`,`fldEmail`,`fldRole`,`fldFacility`,`fldPhone`,`fldEmailPref`,`fldSMSPref`,`fldOnline`,`fldMainState`,`fldPWChange`,`fldStatus`,`fldFax`) values (3925,83634191,'Patricia Barns','pbarns','5f4dcc3b5aa765d61d8327deb882cf99','','facilityuser','','',0,0,0,'NEW',0,'Enabled','');

/*Table structure for table `tbluserfacdetails` */

DROP TABLE IF EXISTS `tbluserfacdetails`;

CREATE TABLE `tbluserfacdetails` (
  `fldFacility` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldUserID` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tbluserfacdetails` */

insert  into `tbluserfacdetails`(`fldFacility`,`fldUserID`) values ('Abbott Road Nursing Facility',3920);
insert  into `tbluserfacdetails`(`fldFacility`,`fldUserID`) values ('Hospice Care',3920);
insert  into `tbluserfacdetails`(`fldFacility`,`fldUserID`) values ('Crestwood Assisted Living',3920);
insert  into `tbluserfacdetails`(`fldFacility`,`fldUserID`) values ('Erie County Holding Center',3921);
insert  into `tbluserfacdetails`(`fldFacility`,`fldUserID`) values ('',3922);
insert  into `tbluserfacdetails`(`fldFacility`,`fldUserID`) values ('',3923);
insert  into `tbluserfacdetails`(`fldFacility`,`fldUserID`) values ('',3924);
insert  into `tbluserfacdetails`(`fldFacility`,`fldUserID`) values ('Abbott Road Nursing Facility',3925);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;