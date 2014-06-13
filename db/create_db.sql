SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE `mdi_ooe` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mdi_ooe`;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE IF NOT EXISTS `announcement` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` TEXT,
  `date_created` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_notes`
--

CREATE TABLE IF NOT EXISTS `order_notes` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` BIGINT(20) NOT NULL,
  `notes` VARCHAR(1000) DEFAULT NULL,
  `created_by` VARCHAR(50) DEFAULT NULL,
  `created_date` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB  DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblfacility`
--

CREATE TABLE IF NOT EXISTS `tblfacility` (
  `fldID` INT(20) NOT NULL AUTO_INCREMENT,
  `fldFacilityName` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldAdminName` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldDivisionName` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldAddressLine1` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldAddressLine2` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldAddressCity` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldAddressState` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldAddressZip` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldPhoneNumber` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldFaxNumber` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldEmail` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldEmailOrder` TINYINT(1) NOT NULL,
  `fldAutoDispatch` TINYINT(1) NOT NULL DEFAULT '0',
  `fldTechnologist` VARCHAR(255) DEFAULT NULL,
  `fldReqDis` TINYINT(1) DEFAULT '0',
  `fldMainState` VARCHAR(3) NOT NULL,
  `fldFacilityType` VARCHAR(64) NOT NULL,
  `fldFacilityDisabled` TINYINT(1) DEFAULT '0',
  `fldBillingContact` VARCHAR(100) DEFAULT NULL,
  `fldBillingPhone` VARCHAR(100) DEFAULT NULL,
  `fldBillingFax` VARCHAR(100) DEFAULT NULL,
  `fldBillingRep` VARCHAR(100) DEFAULT NULL,
  `fldBillingAccNum` VARCHAR(100) DEFAULT NULL,
  `fldStartDate` DATE DEFAULT NULL,
  PRIMARY KEY (`fldID`),
  UNIQUE KEY `fldFacilityName` (`fldFacilityName`)
) ENGINE=MYISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1383 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblfacilitydetails`
--

CREATE TABLE IF NOT EXISTS `tblfacilitydetails` (
  `fldID` INT(20) NOT NULL AUTO_INCREMENT,
  `fldOrderID` INT(20) NOT NULL,
  `fldFacility` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`fldID`)
) ENGINE=MYISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblhistory`
--

CREATE TABLE IF NOT EXISTS `tblhistory` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `fldID` BIGINT(25) UNSIGNED DEFAULT NULL,
  `fldEventType` ENUM('Add','Edit','Delete') DEFAULT NULL,
  `flduser` VARCHAR(255) DEFAULT NULL,
  `fldEventDateTime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`fldID`),
  KEY `type` (`fldEventType`,`fldID`),
  KEY `user` (`flduser`,`fldID`)
) ENGINE=MYISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblicdcodes`
--

CREATE TABLE IF NOT EXISTS `tblicdcodes` (
  `fldOrderid` INT(10) NOT NULL,
  `fldProc1icd1` VARCHAR(255) NOT NULL,
  `fldProc1icd2` VARCHAR(255) NOT NULL,
  `fldProc1icd3` VARCHAR(255) NOT NULL,
  `fldProc1icd4` VARCHAR(255) NOT NULL,
  `fldProc1dig` VARCHAR(255) NOT NULL,
  `fldProc2icd1` VARCHAR(255) NOT NULL,
  `fldProc2icd2` VARCHAR(255) NOT NULL,
  `fldProc2icd3` VARCHAR(255) NOT NULL,
  `fldProc2icd4` VARCHAR(255) NOT NULL,
  `fldProc2dig` VARCHAR(255) NOT NULL,
  `fldProc3icd1` VARCHAR(255) NOT NULL,
  `fldProc3icd2` VARCHAR(255) NOT NULL,
  `fldProc3icd3` VARCHAR(255) NOT NULL,
  `fldProc3icd4` VARCHAR(255) NOT NULL,
  `fldProc3dig` VARCHAR(255) NOT NULL,
  `fldProc4icd1` VARCHAR(255) NOT NULL,
  `fldProc4icd2` VARCHAR(255) NOT NULL,
  `fldProc4icd3` VARCHAR(255) NOT NULL,
  `fldProc4icd4` VARCHAR(255) NOT NULL,
  `fldProc4dig` VARCHAR(255) NOT NULL,
  `fldProc5icd1` VARCHAR(255) NOT NULL,
  `fldProc5icd2` VARCHAR(255) NOT NULL,
  `fldProc5icd3` VARCHAR(255) NOT NULL,
  `fldProc5icd4` VARCHAR(255) NOT NULL,
  `fldProc5dig` VARCHAR(255) NOT NULL,
  `fldProc6icd1` VARCHAR(255) NOT NULL,
  `fldProc6icd2` VARCHAR(255) NOT NULL,
  `fldProc6icd3` VARCHAR(255) NOT NULL,
  `fldProc6icd4` VARCHAR(255) NOT NULL,
  `fldProc6dig` VARCHAR(255) NOT NULL
) ENGINE=MYISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbllists`
--

CREATE TABLE IF NOT EXISTS `tbllists` (
  `fldID` INT(20) NOT NULL AUTO_INCREMENT,
  `fldListName` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldValue` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `code` VARCHAR(10) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'used mostly for icd',
  `fldActiveValue` TINYINT(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fldID`)
) ENGINE=MYISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=456 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblorderdetails`
--

CREATE TABLE IF NOT EXISTS `tblorderdetails` (
  `fldID` INT(25) NOT NULL AUTO_INCREMENT,
  `fldPatientID` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldDate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fldUserName` VARCHAR(255) COLLATE latin1_general_ci NOT NULL,
  `fldPatientSSN` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldFirstName` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldLastName` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldMiddleName` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldSurName` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldDOB` DATE NOT NULL,
  `fldGender` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldInsurance` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldMedicareNumber` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldMedicaidNumber` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldState` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldInsuranceCompanyName` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldHmoContract` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldPolicy` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldGroup` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldResponsiblePerson` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldPhone` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldRelationship` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldFacilityName` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldPrivateAddressLine1` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldPrivateAddressLine2` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldPrivateAddressCity` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldPrivateAddressState` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldPrivateAddressZip` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldPrivatePhoneNumber` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldHomeAddressLine1` VARCHAR(250) COLLATE latin1_general_ci NOT NULL,
  `fldHomeAddressLine2` VARCHAR(250) COLLATE latin1_general_ci NOT NULL,
  `fldHomeAddressCity` VARCHAR(250) COLLATE latin1_general_ci NOT NULL,
  `fldHomeAddressState` VARCHAR(250) COLLATE latin1_general_ci NOT NULL,
  `fldHomeAddressZip` VARCHAR(250) COLLATE latin1_general_ci NOT NULL,
  `fldHomePhoneNumber` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldStat` TINYINT(1) NOT NULL,
  `fldOrderingPhysicians` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldRequestedBy` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure1` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure2` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure3` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure4` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure5` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure6` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure7` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure8` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure9` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldProcedure10` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldplr1` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr2` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr3` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr4` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr5` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr6` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr7` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr8` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr9` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldplr10` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom1` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom2` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom3` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom4` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom5` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom6` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom7` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom8` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom9` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldSymptom10` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldacsno1` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno2` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno3` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno4` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno5` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno6` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno7` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno8` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno9` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldacsno10` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldSymptoms` VARCHAR(255) COLLATE latin1_general_ci NOT NULL,
  `fldHistory` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldPatientroom` VARCHAR(10) COLLATE latin1_general_ci NOT NULL,
  `fldAfterhours` TINYINT(1) NOT NULL,
  `fldAuthorized` TINYINT(1) NOT NULL,
  `fldTechnologist` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldDispatched` TINYINT(1) NOT NULL,
  `fldDispatchedDate` DATETIME DEFAULT NULL,
  `fldVerbal` TINYINT(1) NOT NULL,
  `fldCoded` TINYINT(1) NOT NULL,
  `fldReportDate` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fldReportCalledTo` VARCHAR(255) COLLATE latin1_general_ci NOT NULL,
  `fldReportCalledToDateTime` DATETIME DEFAULT NULL,
  `fldReportDetails` VARCHAR(255) COLLATE latin1_general_ci NOT NULL,
  `fldCDRequested` TINYINT(1) NOT NULL,
  `fldCDAddr` VARCHAR(255) COLLATE latin1_general_ci NOT NULL,
  `fldCreDate` DATE NOT NULL,
  `fldAuthDate` DATETIME NOT NULL,
  `fldVerbalnoofpat` INT(10) NOT NULL,
  `fldRadiologist` VARCHAR(255) COLLATE latin1_general_ci NOT NULL,
  `fldSchDate` DATE NOT NULL DEFAULT '0000-00-00',
  `fldSchTime` TIME DEFAULT NULL,
  `fldFacPhone` VARCHAR(25) COLLATE latin1_general_ci NOT NULL,
  `fldCDDate` DATE NOT NULL,
  `fldCDTimeRequested` TIME DEFAULT NULL,
  `fldnoofviews` INT(10) NOT NULL,
  `fldExamDate` TIME NOT NULL,
  `fldStairs` TINYINT(1) DEFAULT NULL,
  `fldNstairs` VARCHAR(10) COLLATE latin1_general_ci DEFAULT NULL,
  `fldpps` VARCHAR(5) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign` VARCHAR(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldException1` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldException2` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldException3` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldExp1Date` DATE DEFAULT NULL,
  `fdlExp2Date` DATE DEFAULT NULL,
  `fldExp3Date` DATE DEFAULT NULL,
  `fldExp1Resh` VARCHAR(5) COLLATE latin1_general_ci DEFAULT NULL,
  `fldExp2Resh` VARCHAR(5) COLLATE latin1_general_ci DEFAULT NULL,
  `fldExp3Resh` VARCHAR(5) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign1` VARCHAR(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign2` VARCHAR(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign3` VARCHAR(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign4` VARCHAR(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign5` VARCHAR(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign6` VARCHAR(1) COLLATE latin1_general_ci DEFAULT NULL,
  `fldSign7` TINYINT(4) DEFAULT NULL,
  `fldSign8` TINYINT(4) DEFAULT NULL,
  `fldSign9` TINYINT(4) DEFAULT NULL,
  `fldSign10` TINYINT(4) DEFAULT NULL,
  `fldCDShipDate` DATE DEFAULT NULL,
  `tr_modified_by` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `tr_modified_date` DATETIME DEFAULT NULL,
  `created_by` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `created_date` DATETIME DEFAULT NULL,
  `modified_by` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `modified_date` DATETIME DEFAULT NULL,
  `fldPatNotes` TEXT COLLATE latin1_general_ci NOT NULL,
  `fldOrderingPhysiciansPhone` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldPrivateHousingNo` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldReportFax` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldBackupFax` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldBackupPhone` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldOrderType` INT(2) DEFAULT NULL,
  `fldbilled` ENUM('insurance','facility') COLLATE latin1_general_ci DEFAULT NULL,
  `fldStation` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldFacFax` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldNotes` TEXT COLLATE latin1_general_ci,
  `fldOrderingPhysiciansFax` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldDiagnosisReuired1` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldDiagnosisReuired2` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldDiagnosisReuired3` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldRepeat` INT(2) DEFAULT NULL,
  `fldRepeatDays` INT(4) DEFAULT NULL,
  `fldRepeatTimes` INT(4) DEFAULT NULL,
  `fldTestPriority` INT(2) DEFAULT NULL,
  `fldLocFacName` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `fldlabtype` VARCHAR(255) COLLATE latin1_general_ci DEFAULT NULL,
  `labSentTo` VARCHAR(50) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'name of radiologist or lab for diagnostic reading',
  `fldLabDeliveredDate` DATE DEFAULT NULL,
  `fldLabDeliveredTime` TIME DEFAULT NULL,
  `fldtechComplete` TINYINT(2) DEFAULT '0',
  `fldRepeatParent` INT(25) DEFAULT NULL,
  `fldMarkCompletedBy` VARCHAR(25) COLLATE latin1_general_ci DEFAULT NULL,
  `fldMarkCompletedDate` DATETIME DEFAULT NULL,
  `fldPrivateResidenceNumber` VARCHAR(25) COLLATE latin1_general_ci DEFAULT NULL,
  `fldOPNotinDB` TINYINT(1) DEFAULT '0',
  `fldStatus` TINYINT(1) DEFAULT '0' COMMENT 'cancel:1, normal:0',
  `fldCancelNotes` VARCHAR(500) COLLATE latin1_general_ci DEFAULT '0',
  `fldCanceledBy` VARCHAR(25) COLLATE latin1_general_ci DEFAULT NULL,
  `fldCanceledDate` DATETIME DEFAULT NULL,
  PRIMARY KEY (`fldID`)
) ENGINE=MYISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=41619 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblproceduremanagment`
--

CREATE TABLE IF NOT EXISTS `tblproceduremanagment` (
  `fldID` INT(25) NOT NULL AUTO_INCREMENT,
  `fldCBTCode` VARCHAR(20) COLLATE latin1_general_ci NOT NULL,
  `fldDescription` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldModality` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldCategory` VARCHAR(100) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`fldID`)
) ENGINE=MYISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=269 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblsettings`
--

CREATE TABLE IF NOT EXISTS `tblsettings` (
  `fldEmailSignedOrders1` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldEmailSendOrders1` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldPDFUnsignedOrders` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldPDFSignedOrders` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `flddmwl` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldEmailSignedOrders2` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldEmailSendOrders2` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `mapAddress` VARCHAR(500) COLLATE latin1_general_ci DEFAULT NULL,
  `mapLatLong` VARCHAR(25) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MYISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblstates`
--

CREATE TABLE IF NOT EXISTS `tblstates` (
  `fldState` VARCHAR(64) NOT NULL,
  `fldSt` VARCHAR(4) NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fldState`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblstations`
--

CREATE TABLE IF NOT EXISTS `tblstations` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `facId` INT(11) NOT NULL,
  `StationName` VARCHAR(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `StationPhone` VARCHAR(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `StationFax` VARCHAR(64) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=INNODB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1254 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblsysvar`
--

CREATE TABLE IF NOT EXISTS `tblsysvar` (
  `varName` VARCHAR(255) NOT NULL,
  `VarValue` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`varName`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblsysvars`
--

CREATE TABLE IF NOT EXISTS `tblsysvars` (
  `varName` VARCHAR(255) NOT NULL,
  `VarValue` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`varName`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbltechlog`
--

CREATE TABLE IF NOT EXISTS `tbltechlog` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `techId` INT(11) NOT NULL,
  `event` INT(11) NOT NULL,
  `eventDateTime` DATETIME NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=INNODB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE IF NOT EXISTS `tbluser` (
  `fldID` INT(25) NOT NULL AUTO_INCREMENT,
  `fldUserID` INT(25) NOT NULL,
  `fldRealName` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldUserName` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldPassword` VARCHAR(32) COLLATE latin1_general_ci NOT NULL,
  `fldEmail` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldRole` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldFacility` VARCHAR(100) COLLATE latin1_general_ci NOT NULL,
  `fldPhone` VARCHAR(50) COLLATE latin1_general_ci NOT NULL,
  `fldEmailPref` TINYINT(1) DEFAULT NULL,
  `fldSMSPref` TINYINT(1) DEFAULT NULL,
  `fldOnline` TINYINT(1) NOT NULL DEFAULT '0',
  `fldMainState` VARCHAR(3) COLLATE latin1_general_ci NOT NULL,
  `fldPWChange` TINYINT(1) NOT NULL DEFAULT '0',
  `fldStatus` ENUM('Enabled','Disabled') COLLATE latin1_general_ci DEFAULT 'Enabled',
  `fldFax` VARCHAR(50) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`fldID`),
  UNIQUE KEY `fldUserName` (`fldUserName`)
) ENGINE=MYISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3920 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbluserfacdetails`
--

CREATE TABLE IF NOT EXISTS `tbluserfacdetails` (
  `fldFacility` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `fldUserID` INT(10) NOT NULL
) ENGINE=MYISAM DEFAULT CHARSET=latin1;


INSERT INTO `tbllists` (`fldID`, `fldListName`, `fldValue`, `code`, `fldActiveValue`) VALUES
(33, 'modality', 'CR', NULL, 1),
(34, 'modality', 'US', NULL, 1),
(365, 'icd', 'Seizure', NULL, 1),
(37, 'modality', 'EKG', NULL, 1),
(364, 'icd', 'Med Monitoring', NULL, 1),
(363, 'icd', 'Lethargy', NULL, 1),
(362, 'icd', 'Hypothyroid', NULL, 1),
(361, 'icd', 'Hypertension', NULL, 1),
(360, 'icd', 'Hyperlipidemia', NULL, 1),
(359, 'icd', 'Gerd', NULL, 1),
(358, 'icd', 'Fatigue & Weakness', NULL, 1),
(357, 'icd', 'DM', NULL, 1),
(356, 'icd', 'Depression', NULL, 1),
(355, 'icd', 'Dementia', NULL, 1),
(354, 'icd', 'CRI', NULL, 1),
(353, 'icd', 'CRF', NULL, 1),
(352, 'icd', 'Coumadin', NULL, 1),
(351, 'icd', 'COPD', NULL, 1),
(350, 'icd', 'Confusion', NULL, 1),
(349, 'icd', 'CHF', NULL, 1),
(348, 'icd', 'Change In Behavior', NULL, 1),
(347, 'icd', 'Anemia', NULL, 1),
(346, 'icd', 'A-Fib', NULL, 1),
(345, 'icd', 'Face Pain', NULL, 1),
(344, 'icd', 'Vomiting', NULL, 1),
(343, 'icd', 'Nausea', NULL, 1),
(342, 'icd', 'Naus.+Vomit', NULL, 1),
(341, 'icd', 'Flu', NULL, 1),
(340, 'icd', 'Edema', NULL, 1),
(339, 'icd', 'Ventricular Fibrillation', NULL, 1),
(402, 'icd', 'Bradycardia', NULL, 1),
(338, 'icd', 'Tachycardia', NULL, 1),
(337, 'icd', 'Irreg. Heartbeat', NULL, 1),
(336, 'icd', 'Cardiomegaly', NULL, 1),
(335, 'icd', 'Cardiac Dysrhythmia', NULL, 1),
(382, 'icd', 'Positive PPD', NULL, 1),
(381, 'icd', 'Palpitations', NULL, 1),
(334, 'icd', 'Atrial Fibrillation', NULL, 1),
(333, 'icd', 'Arrhythmia', NULL, 1),
(79, 'relationship', 'Mother', NULL, 1),
(80, 'relationship', 'Father', NULL, 1),
(81, 'relationship', 'Sister', NULL, 1),
(82, 'relationship', 'Brother', NULL, 1),
(83, 'relationship', 'Son', NULL, 1),
(85, 'relationship', 'Daughter', NULL, 1),
(86, 'relationship', 'Other', NULL, 1),
(87, 'relationship', 'Niece', NULL, 1),
(88, 'relationship', 'Nephew', NULL, 1),
(89, 'relationship', 'Cousin', NULL, 1),
(380, 'icd', 'Oxygen Saturation', NULL, 1),
(379, 'icd', 'Dysphagia', NULL, 1),
(378, 'icd', 'Dyspnea', NULL, 1),
(331, 'icd', 'Abdominal Pain', NULL, 1),
(332, 'icd', 'Fecal Impaction', NULL, 1),
(377, 'icd', 'Diarrhea', NULL, 1),
(376, 'icd', 'Cardiac Murmur', NULL, 1),
(375, 'icd', 'Constipation', NULL, 1),
(374, 'icd', 'Airway Obst/COPD', NULL, 1),
(373, 'icd', 'Abn. Weight Loss', NULL, 1),
(372, 'icd', 'Abn. Weight Gain', NULL, 1),
(371, 'icd', 'Abnormal Sputum', NULL, 1),
(370, 'icd', 'Abn. Bowel Sounds', NULL, 1),
(369, 'icd', 'Weight Loss', NULL, 1),
(367, 'icd', 'Throat Cx', NULL, 1),
(368, 'icd', 'UTI', NULL, 1),
(366, 'icd', 'Stroke', NULL, 1),
(309, 'icd', 'Rib Pain', NULL, 1),
(310, 'icd', 'Shoulder Pain', NULL, 1),
(312, 'icd', 'Tib-Fib Pain', NULL, 1),
(313, 'icd', 'Toe Pain', NULL, 1),
(314, 'icd', 'Wrist Pain', NULL, 1),
(315, 'icd', 'Chest Injury', NULL, 1),
(316, 'icd', 'Chest Pain', NULL, 1),
(317, 'icd', 'Cong Heart Failure', NULL, 1),
(318, 'icd', 'Congestion', NULL, 1),
(319, 'icd', 'Cough', NULL, 1),
(320, 'icd', 'Coughing Blood', NULL, 1),
(321, 'icd', 'Fever', NULL, 1),
(322, 'icd', 'Infiltrates', NULL, 1),
(323, 'icd', 'Painful Respiration', NULL, 1),
(324, 'icd', 'Pos. PPD (TB Reaction)', NULL, 1),
(325, 'icd', 'Rales/Ronchi', NULL, 1),
(326, 'icd', 'Respiratory Abnormal', NULL, 1),
(327, 'icd', 'Shortness Of Breath', NULL, 1),
(328, 'icd', 'Unspec. Pleural Effusion', NULL, 1),
(329, 'icd', 'Wheezing', NULL, 1),
(330, 'icd', 'Abdominal Distention', NULL, 1),
(308, 'icd', 'Neck Pain', NULL, 1),
(307, 'icd', 'Low Back Pain', NULL, 1),
(306, 'icd', 'Knee Pain', NULL, 1),
(311, 'icd', 'Thoracic Pain', NULL, 1),
(304, 'icd', 'Humerus Pain', NULL, 1),
(303, 'icd', 'Hip/Pelvis Pain', NULL, 1),
(302, 'icd', 'Hand Pain', NULL, 1),
(301, 'icd', 'Forearm Pain', NULL, 1),
(300, 'icd', 'Foot Pain', NULL, 1),
(299, 'icd', 'Finger Pain', NULL, 1),
(295, 'icd', 'Ankle Pain', '111', 1),
(296, 'icd', 'Dorsal Pain', NULL, 1),
(297, 'icd', 'Elbow Pain', NULL, 1),
(278, 'pcategory', 'Test Value', NULL, 1),
(298, 'icd', 'Femur/Leg Pain', NULL, 1),
(276, 'modality', 'Lab', NULL, 1),
(383, 'icd', 'Resp. Distress, SOB, Wheezing', NULL, 1),
(384, 'icd', 'Cervical Pain', NULL, 1),
(385, 'icd', 'Coccyx Pain', NULL, 1),
(386, 'icd', 'Head Pain', NULL, 1),
(431, 'facilitytype', 'Home Bound', NULL, 1),
(394, 'facilitytype', 'Nursing Home', NULL, 1),
(422, 'icd', 'Elavated WBC', NULL, 1),
(423, 'icd', 'LEUKOCYTOSIS', NULL, 1),
(424, 'icd', 'S/P FALL', NULL, 1),
(425, 'icd', 'HYPOTENSION', NULL, 1),
(399, 'facilitytype', 'Correctional Facility', NULL, 1),
(400, 'Select', 'Home Health Agency', NULL, 1),
(401, 'facilitytype', 'Physicians Lab', NULL, 1),
(403, 'icd', 'Verify NG', NULL, 1),
(404, 'icd', 'Annual', NULL, 1),
(405, 'icd', 'Admission', NULL, 1),
(406, 'icd', 'Pre Employment', NULL, 1),
(407, 'icd', 'Pre Operative', NULL, 1),
(408, 'icd', 'Tube Placement', NULL, 1),
(436, 'icd', 'Pneum. Unspec.', NULL, 1),
(410, 'icd', 'Aspiration', NULL, 1),
(411, 'icd', 'Redness', NULL, 1),
(412, 'icd', 'Mass', NULL, 1),
(413, 'icd', 'Nodule', NULL, 1),
(414, 'icd', 'Bruising', NULL, 1),
(415, 'icd', 'Altered Mental State', NULL, 1),
(416, 'exception', 'Syncope', NULL, 1),
(418, 'icd', 'Atelectisis', NULL, 1),
(417, 'icd', 'PICC Placement', NULL, 1),
(419, 'icd', 'Distention', NULL, 1),
(420, 'icd', 'Ascites', NULL, 1),
(421, 'icd', 'PEG placement', NULL, 1),
(426, 'icd', 'Stones/calculi', NULL, 1),
(427, 'icd', 'Coronary artery disease', NULL, 1),
(428, 'modality', 'ECHO', NULL, 1),
(435, 'facilitytype', 'Assisted Living', NULL, 1),
(434, 'icd', 'Pain and Swelling', NULL, 1),
(437, 'icd', 'Pain in Abdomen', NULL, 1),
(438, 'icd', 'Pain in Ankle/Foot', NULL, 1),
(439, 'icd', 'Pain in Arm/Leg', NULL, 1),
(440, 'icd', 'Pain in Elbow', NULL, 1),
(441, 'icd', 'Pain in Hand', NULL, 1),
(442, 'icd', 'Pain in Knee', NULL, 1),
(443, 'icd', 'Pain in L-spine', NULL, 1),
(444, 'icd', 'Backache Unspecified', NULL, 1),
(445, 'icd', 'Pain in Neck', NULL, 1),
(446, 'icd', 'Pain in Pelvis/Hip', NULL, 1),
(447, 'icd', 'Pain in Coccyx', NULL, 1),
(448, 'icd', 'Pain in Ribs', NULL, 1),
(449, 'icd', 'Pain in Shoulder', NULL, 1),
(450, 'icd', 'Pain in T-spine', NULL, 1),
(451, 'icd', 'Pain in Wrist', NULL, 1),
(452, 'icd', 'NOS Reaction to TB Test', NULL, 1),
(453, 'icd', 'Pulmonary TB Screening', NULL, 1),
(454, 'icd', 'Sinusitis Acute', NULL, 1),
(455, 'icd', 'F/U Fracture', NULL, 1);

--
-- Dumping data for table `tblproceduremanagment`
--

INSERT INTO `tblproceduremanagment` (`fldID`, `fldCBTCode`, `fldDescription`, `fldModality`, `fldCategory`) VALUES
(129, '74000', 'ABDOMEN 1V', 'CR', ''),
(130, '74020', 'ABDOMEN 2V', 'CR', ''),
(131, '74022', 'ABDOMEN 3 V', 'CR', ''),
(132, '76705', 'Abdominal Limited', 'US', ''),
(133, '76700', 'Abdominal Ultrasound', 'US', ''),
(134, '93922', 'ABI', 'US', ''),
(135, '73050', 'AC JOINTS BILAT', 'CR', ''),
(136, '82040', 'Albumin', 'LAB', 'Chemistry'),
(137, '84075', 'Alk Phos', 'LAB', 'Chemistry'),
(138, '84460', 'ALT', 'LAB', 'Chemistry'),
(139, '82150', 'Amylase', 'LAB', 'Chemistry'),
(140, '73600', 'ANKLE 2V', 'CR', ''),
(141, '73610', 'ANKLE 3V', 'CR', ''),
(142, '87730', 'APTT', 'LAB', 'Coagulation'),
(143, '93923', 'Arterial Doppler Lower', 'US', ''),
(144, '93923', 'Arterial Doppler Upper', 'US', ''),
(145, '93924', 'Arterial Doppler w Exercise', 'US', ''),
(146, '84450', 'AST', 'LAB', 'Chemistry'),
(147, '80048', 'Basic Metabolic Panel', 'LAB', ''),
(148, '76857', 'Bladder Pelvis Limited', 'US', ''),
(149, '77081', 'Bone Density Appenducular Skeleton', 'US', ''),
(150, '77080', 'Bone Density Ultrasound', 'US', ''),
(151, '82310', 'Calcium', 'LAB', 'Chemistry'),
(152, '93880', 'Carotid Doppler', 'US', ''),
(153, '85007', 'CBC Manual Diff (billed with 80027)', 'LAB', 'Hematology'),
(154, '85025', 'CBC w/Auto Diff', 'LAB', 'Hematology'),
(155, '85027', 'CBC w/o Diff', 'LAB', 'Hematology'),
(156, '71010', 'CHEST 1V', 'CR', ''),
(157, '71020', 'CHEST 2V', 'CR', ''),
(158, '71022', 'CHEST 3V W/OBLIQUE', 'CR', ''),
(159, '71030', 'CHEST MIN 4V W/OBLIQUES', 'CR', ''),
(160, '76604', 'Chest Sono', 'US', ''),
(161, '82435', 'Chloride', 'LAB', 'Chemistry'),
(162, '73000', 'CLAVICLE 2V', 'CR', ''),
(163, '82374', 'CO2', 'LAB', 'Chemistry'),
(164, '80053', 'Comp Metabolic Panel', 'LAB', ''),
(165, '86140', 'CRP', 'LAB', 'Other'),
(166, '72040', 'C-SPINE 2V', 'CR', ''),
(167, '72050', 'C-SPINE 4V', 'CR', ''),
(168, '93325', 'Doppler Color Flow', 'US', ''),
(169, '93303', 'Echocardiogram complete - Pediatric', 'ECHO', ''),
(170, '93306', 'Echocardiogram Complete', 'ECHO', ''),
(171, '93005', 'EKG', 'EKG', ''),
(172, '73070', 'ELBOW 2V', 'CR', ''),
(173, '73080', 'ELBOW 3V W/OBLIQUE', 'CR', ''),
(174, '80051', 'Electrolute Panel', 'LAB', ''),
(175, '70150', 'FACIAL BONES 3V', 'CR', ''),
(176, '73550', 'FEMUR 2V', 'CR', ''),
(177, '82728', 'Ferritin', 'LAB', 'Special Chemistry'),
(178, '73140', 'FINGER(S) 3V', 'CR', ''),
(179, '82746', 'Folate', 'LAB', 'Special Chemistry'),
(180, '73630', 'FOOT 3V', 'CR', ''),
(181, '73090', 'FOREARM 2V', 'CR', ''),
(182, '84439', 'Free T4', 'LAB', 'Special Chemistry'),
(183, '82977', 'GGTP', 'LAB', 'Chemistry'),
(184, '82947', 'Glucose (FBS)', 'LAB', 'Chemistry'),
(185, '83036', 'Gly Hgb (A1C)', 'LAB', 'Special Chemistry'),
(186, '73120', 'HAND 2V', 'CR', ''),
(187, '73130', 'HAND 3V', 'CR', ''),
(188, '73650', 'HEEL 2V', 'CR', ''),
(189, '85014', 'Hematocrit', 'LAB', 'Hematology'),
(190, '85018', 'Hemoglobin', 'LAB', 'Hematology'),
(191, '73500', 'HIP 1V', 'CR', ''),
(192, '73510', 'HIP 2V', 'CR', ''),
(193, '73520', 'HIP 3 V', 'CR', ''),
(194, '73060', 'HUMERUS 2V', 'CR', ''),
(195, '83550', 'Iron Binding (IBC)', 'LAB', ''),
(196, '73560', 'KNEE 2V', 'CR', ''),
(197, '73562', 'KNEE 3V w sunrise', 'CR', ''),
(198, '80061', 'Lipid Panel', 'LAB', ''),
(199, '80076', 'Liver Panel', 'LAB', ''),
(200, '72100', 'L-SPINE 2V', 'CR', ''),
(201, '72110', 'L-SPINE COMPLETE', 'CR', ''),
(202, '70100', 'MANDIBLE 1-3V', 'CR', ''),
(203, '70110', 'Mandible 4 views', 'CR', ''),
(204, '82044', 'Micro Albumin (random)', 'LAB', 'Other'),
(205, '70160', 'NASAL BONES 3V', 'CR', ''),
(206, '70200', 'ORBITS 4V', 'CR', ''),
(207, '76857', 'Ovarian Follicle', 'US', ''),
(208, '72170', 'PELVIS 1V', 'CR', ''),
(209, '76856', 'Pelvis Complete', 'US', ''),
(210, '84100', 'Phosphorus', 'LAB', 'Chemistry'),
(211, '85610', 'Protime/INR', 'LAB', 'Coagulation'),
(212, '84153', 'PSA', 'LAB', 'Special Chemistry'),
(213, '87880', 'Rapid Strep', 'LAB', 'Microbiology'),
(214, '93930', 'Real Time Art Dop Bil Up', 'US', ''),
(215, '93925', 'Real Time Arterial Doppler Bilat Lower', 'US', ''),
(216, '93926', 'Real Time Arterial Doppler Unilat Lower', 'US', ''),
(217, '93931', 'Real Time Arterial Doppler Unilat Upper', 'US', ''),
(218, '76770', 'Retroperitoneum Renal Complete', 'US', ''),
(219, '86431', 'Rheum Factor', 'LAB', 'Other'),
(220, '71100', 'RIB 2VW', 'CR', ''),
(221, '71101', 'RIB 3VW', 'CR', ''),
(222, '71110', 'Rib Bilat 3vw', 'CR', ''),
(223, '71111', 'Ribs Min 4vw', 'CR', ''),
(224, '71101', 'RIBS, UNI W/CHEST 3V', 'CR', ''),
(225, '72202', 'SACRO-ILIAC 3 OR MORE', 'CR', ''),
(226, '72220', 'SACRUM/COCCYX 2V', 'CR', ''),
(227, '73010', 'SCAPULA 2V', 'CR', ''),
(228, '85652', 'Sed Rate', 'LAB', 'Hematology'),
(229, '83540', 'Serum Iron', 'LAB', ''),
(230, '73020', 'SHOULDER 1V', 'CR', ''),
(231, '73030', 'SHOULDER 2V', 'CR', ''),
(232, '70220', 'SINUSES 3V', 'CR', ''),
(233, '70250', 'SKULL 1-3V', 'CR', ''),
(234, '84295', 'Sodium', 'LAB', 'Chemistry'),
(235, '70360', 'SOFT TISSUE NECK 2V', 'CR', ''),
(236, '76880', 'Soft Tissue/Extremity', 'US', ''),
(238, '72020', 'SPINE 1V', 'CR', ''),
(239, '72010', 'SPINE ENTIRE SURVEY', 'CR', ''),
(266, '73660', 'Toes', 'CR', ''),
(241, '71130', 'STERNOVACULAR FTS', 'CR', ''),
(242, '71120', 'STERNUM 2VW', 'CR', ''),
(243, '93350', 'Stress Echo', 'ECHO', ''),
(244, '76870', 'Testicular Scrotal', 'US', ''),
(245, '72080', 'THORACOLUMBAR JUNC', 'CR', ''),
(246, '87081', 'Throat Culture', 'LAB', 'Microbiology'),
(247, '76536', 'Thyroid Parotid Neck', 'US', ''),
(248, '73590', 'TIBIA/FIBULA 2V', 'CR', ''),
(249, '84155', 'Total Protein', 'LAB', 'Chemistry'),
(250, '76872', 'TRANS RECTAL US', 'US', ''),
(251, '84478', 'Triglycerides', 'LAB', 'Chemistry'),
(252, '84443', 'TSH', 'LAB', 'Special Chemistry'),
(253, '72070', 'T-SPINE 2V', 'CR', ''),
(254, '81001', 'Urinalysis', 'LAB', 'Urines'),
(255, '87086', 'Urine Culture', 'LAB', 'Urines'),
(256, '36415', 'Venipuncture', 'LAB', 'Draw'),
(257, '93970', 'Venous Doppler Bilateral', 'US', ''),
(258, '93971', 'Venous Doppler Unilateral Upper', 'US', ''),
(259, '82607', 'Vitamin B-12', 'LAB', 'Special Chemistry'),
(260, '73110', 'WRIST 3V', 'CR', ''),
(261, '0000000', 'EMPLOYEE', 'CR', ''),
(262, '93971', 'Venous Doppler Lower', 'US', NULL),
(268, '73520', 'Pelvis w/bilat hips - 5 vws', 'CR', ''),
(267, '72070', 'THORACIC SPINE', 'CR', '');

--
-- Dumping data for table `tblsettings`
--

INSERT INTO `tblsettings` (`fldEmailSignedOrders1`, `fldEmailSendOrders1`, `fldPDFUnsignedOrders`, `fldPDFSignedOrders`, `flddmwl`, `fldEmailSignedOrders2`, `fldEmailSendOrders2`, `mapAddress`, `mapLatLong`) VALUES
('', '', 'unsigned/', 'signed/', 'txt/', '', '', '247 S Coltrane Rd Edmond, OK 73034', '35.652292,-97.44279');

--
-- Dumping data for table `tblstates`
--

INSERT INTO `tblstates` (`fldState`, `fldSt`, `active`) VALUES
('ALABAMA', 'AL', 1),
('ALASKA', 'AK', 1),
('ARIZONA', 'AZ', 1),
('ARKANSAS', 'AR', 1),
('CALIFORNIA', 'CA', 1),
('COLORADO', 'CO', 1),
('CONNECTICUT', 'CT', 1),
('DELAWARE', 'DE', 1),
('FLORIDA', 'FL', 1),
('GEORGIA', 'GA', 1),
('HAWAII', 'HI', 1),
('IDAHO', 'ID', 1),
('ILLINOIS', 'IL', 1),
('INDIANA', 'IN', 1),
('IOWA', 'IA', 1),
('KANSAS', 'KS', 1),
('KENTUCKY', 'KY', 1),
('LOUISIANA', 'LA', 1),
('MAINE', 'ME', 1),
('MARYLAND', 'MD', 1),
('MASSACHUSETTS', 'MA', 1),
('MICHIGAN', 'MI', 1),
('MINNESOTA', 'MN', 1),
('MISSISSIPPI', 'MS', 1),
('MISSOURI', 'MO', 1),
('MONTANA', 'MT', 1),
('NEBRASKA', 'NE', 1),
('NEVADA', 'NV', 1),
('NEW HAMPSHIRE', 'NH', 1),
('NEW JERSEY', 'NJ', 1),
('NEW MEXICO', 'NM', 1),
('NEW YORK', 'NY', 1),
('NORTH CAROLINA', 'NC', 1),
('NORTH DAKOTA', 'ND', 1),
('OHIO', 'OH', 1),
('OKLAHOMA', 'OK', 1),
('OREGON', 'OR', 1),
('PENNSYLVANIA', 'PA', 1),
('PUERTO RICO', 'PR', 1),
('RHODE ISLAND', 'RI', 1),
('SOUTH CAROLINA', 'SC', 1),
('SOUTH DAKOTA', 'SD', 1),
('TENNESSEE', 'TN', 1),
('TEXAS', 'TX', 1),
('UTAH', 'UT', 1),
('VERMONT', 'VT', 1),
('VIRGINIA', 'VA', 1),
('WASHINGTON', 'WA', 1),
('WASHINGTON DC', 'DC', 1),
('WEST VIRGINIA', 'WV', 1),
('WISCONSIN', 'WI', 1),
('WYOMING', 'WY', 1);

--
-- Dumping data for table `tblsysvar`
--

INSERT INTO `tblsysvar` (`varName`, `VarValue`) VALUES
('autodispatch', '0');

--
-- Dumping data for table `tblsysvars`
--

INSERT INTO `tblsysvars` (`varName`, `VarValue`) VALUES
('autodispatch', '0');

INSERT INTO `tbluser` (`fldID`, `fldUserID`, `fldRealName`, `fldUserName`, `fldPassword`, `fldEmail`, `fldRole`, `fldFacility`, `fldPhone`, `fldEmailPref`, `fldSMSPref`, `fldOnline`, `fldMainState`, `fldPWChange`, `fldStatus`, `fldFax`) VALUES
(1, 1111111, 'Mobile Digital Imaging', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'issues@mobiledigitalimaging.com', 'admin', '', '', 0, 0, 0, '', 0, 'Enabled', '');