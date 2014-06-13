USE `order1`;

/*Table structure for table `tbltechlog` */

DROP TABLE IF EXISTS `tbltechlog`;

CREATE TABLE `tbltechlog` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `techId` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  `eventDateTime` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `order1`.`tbluser` ADD COLUMN `fldOnline` TINYINT(1) DEFAULT '0' NOT NULL AFTER `fldSMSPref`;

ALTER TABLE `order1`.`tblfacility` CHANGE `fldAutoDispatch` `fldAutoDispatch` TINYINT(1) DEFAULT '0' NOT NULL;

CREATE TABLE `order1`.`tblsysvars`( `varName` VARCHAR(255) NOT NULL , `VarValue` VARCHAR(255) NOT NULL , PRIMARY KEY (`varName`) ); 