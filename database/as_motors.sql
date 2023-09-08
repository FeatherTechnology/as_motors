-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2023 at 03:00 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `as_motors`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountsgroup`
--

CREATE TABLE `accountsgroup` (
  `Id` int(11) NOT NULL,
  `AccountsName` longtext DEFAULT NULL,
  `ParentId` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `appreciation_depreciation`
--

CREATE TABLE `appreciation_depreciation` (
  `appreciation_depreciation_id` int(11) NOT NULL,
  `review` varchar(50) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `overall_performance` varchar(255) DEFAULT NULL,
  `not_done` varchar(255) DEFAULT NULL,
  `carry_forward` varchar(255) DEFAULT NULL,
  `strength` varchar(255) NOT NULL,
  `weakness` varchar(255) NOT NULL,
  `need_for_improvement` varchar(255) NOT NULL,
  `overall_rating` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `appreciation_depreciation_ref`
--

CREATE TABLE `appreciation_depreciation_ref` (
  `appreciation_depreciation_ref_id` int(11) NOT NULL,
  `review` varchar(50) DEFAULT NULL,
  `appreciation_depreciation_id` int(11) DEFAULT NULL,
  `daily_performance_ref_id` int(11) DEFAULT NULL,
  `assertion` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `achievement` varchar(255) DEFAULT NULL,
  `employee_rating` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `approval_line`
--

CREATE TABLE `approval_line` (
  `approval_line_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `approval_staff_id` varchar(255) DEFAULT NULL,
  `agree_par_staff_id` varchar(255) DEFAULT NULL,
  `after_notified_staff_id` varchar(255) DEFAULT NULL,
  `receiving_dept_id` varchar(255) DEFAULT NULL,
  `checker_approval` varchar(255) NOT NULL DEFAULT '0',
  `reviewer_approval` varchar(255) NOT NULL DEFAULT '0',
  `final_approval` varchar(255) NOT NULL DEFAULT '0',
  `checker_approval_date` varchar(255) DEFAULT NULL,
  `reviewer_approval_date` varchar(255) DEFAULT NULL,
  `final_approval_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `approval_requisition`
--

CREATE TABLE `approval_requisition` (
  `approval_requisition_id` int(11) NOT NULL,
  `approval_line_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `doc_no` varchar(255) DEFAULT NULL,
  `auto_generation_date` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `approval_requisition_parallel_agree_disagree`
--

CREATE TABLE `approval_requisition_parallel_agree_disagree` (
  `approval_requisition_agree_disagree_id` int(11) NOT NULL,
  `approval_line_id` varchar(255) DEFAULT NULL,
  `agree_disagree_staff_id` varchar(255) DEFAULT NULL,
  `agree_disagree` int(11) NOT NULL DEFAULT 0,
  `agree_disagree_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `asset_details`
--

CREATE TABLE `asset_details` (
  `asset_details_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `classification` varchar(255) DEFAULT NULL,
  `asset_name` varchar(255) DEFAULT NULL,
  `asset_value` varchar(255) DEFAULT NULL,
  `dou` date DEFAULT NULL,
  `depreciation` varchar(255) DEFAULT NULL,
  `as_on` varchar(255) DEFAULT NULL,
  `spare_names` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_details`
--

INSERT INTO `asset_details` (`asset_details_id`, `company_id`, `branch_id`, `classification`, `asset_name`, `asset_value`, `dou`, `depreciation`, `as_on`, `spare_names`, `status`, `created_id`, `updated_id`, `created_date`, `updated_date`) VALUES
(1, '1', '3', '3', '1', '50000', '2020-07-01', '2023-07-01', '20000', '4,2,1,3', 0, NULL, NULL, '2023-06-06 13:29:20', '2023-06-06 13:29:20');

-- --------------------------------------------------------

--
-- Table structure for table `asset_details_ref`
--

CREATE TABLE `asset_details_ref` (
  `ref_id` int(11) NOT NULL,
  `asset_details_reff_id` int(11) DEFAULT NULL,
  `modal_no` int(11) DEFAULT NULL,
  `warranty_upto` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_details_ref`
--

INSERT INTO `asset_details_ref` (`ref_id`, `asset_details_reff_id`, `modal_no`, `warranty_upto`) VALUES
(1, 1, 548945665, '2023-09-30');

-- --------------------------------------------------------

--
-- Table structure for table `asset_register`
--

CREATE TABLE `asset_register` (
  `asset_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `asset_classification` varchar(250) DEFAULT NULL,
  `asset_name` varchar(255) DEFAULT NULL,
  `dop` date DEFAULT NULL,
  `asset_nature` int(11) DEFAULT NULL,
  `asset_value` int(11) DEFAULT NULL,
  `maintenance` varchar(255) DEFAULT NULL,
  `rgp_status` varchar(255) NOT NULL DEFAULT 'inword',
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset_register`
--

INSERT INTO `asset_register` (`asset_id`, `company_id`, `asset_classification`, `asset_name`, `dop`, `asset_nature`, `asset_value`, `maintenance`, `rgp_status`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '3', '3', 'Acer', '2020-07-01', 2, 50000, '1', 'inward', 0, 1, 1, NULL, '2023-06-06 13:21:08', '2023-06-06 13:21:16'),
(2, '4', '4', 'Canon', '2020-07-01', 2, 200000, '1', 'inword', 0, 1, NULL, NULL, '2023-06-06 13:21:57', '2023-06-06 13:21:57'),
(3, '1', '6', 'Router, Bandwidth', '2020-07-01', 1, 70000, '1', 'inword', 0, 1, NULL, NULL, '2023-06-06 13:22:44', '2023-06-06 13:22:44');

-- --------------------------------------------------------

--
-- Table structure for table `assign_work`
--

CREATE TABLE `assign_work` (
  `work_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assign_work`
--

INSERT INTO `assign_work` (`work_id`, `company_id`, `status`, `created_date`, `updated_date`, `created_id`, `updated_id`) VALUES
(1, '2', 0, '2023-06-06 16:18:10', '2023-06-06 16:18:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assign_work_ref`
--

CREATE TABLE `assign_work_ref` (
  `ref_id` int(11) NOT NULL,
  `assign_work_reff_id` varchar(255) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `designation_id` varchar(255) DEFAULT NULL,
  `work_des` varchar(255) DEFAULT NULL,
  `work_des_text` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assign_work_ref`
--

INSERT INTO `assign_work_ref` (`ref_id`, `assign_work_reff_id`, `department_id`, `designation_id`, `work_des`, `work_des_text`, `priority`, `from_date`, `to_date`, `work_status`, `status`) VALUES
(1, '1', '7', '8', '4', 'Accounting', NULL, '2023-07-29 00:00:00', '2023-07-31 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `audit_area_creation`
--

CREATE TABLE `audit_area_creation` (
  `audit_area_id` int(11) NOT NULL,
  `audit_area` varchar(250) DEFAULT NULL,
  `department_id` varchar(250) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `frequency_applicable` varchar(100) DEFAULT NULL,
  `calendar` varchar(255) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `role1` varchar(250) DEFAULT NULL,
  `role2` varchar(250) DEFAULT NULL,
  `check_list` varchar(250) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_area_creation`
--

INSERT INTO `audit_area_creation` (`audit_area_id`, `audit_area`, `department_id`, `frequency`, `frequency_applicable`, `calendar`, `from_date`, `to_date`, `role1`, `role2`, `check_list`, `work_status`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Development', '7,1', 'Quaterly', 'frequency_applicable', 'Yes', '2023-06-20 14:40:50', '2023-06-25 14:40:50', '1', '6', 'Yes', 0, 0, 1, NULL, NULL, '2023-06-06 14:40:50', '2023-06-06 14:40:50');

-- --------------------------------------------------------

--
-- Table structure for table `audit_area_creation_ref`
--

CREATE TABLE `audit_area_creation_ref` (
  `audit_area_creation_ref_id` int(11) NOT NULL,
  `audit_area_id` varchar(50) DEFAULT NULL,
  `from_date` varchar(100) DEFAULT NULL,
  `to_date` varchar(100) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_area_creation_ref`
--

INSERT INTO `audit_area_creation_ref` (`audit_area_creation_ref_id`, `audit_area_id`, `from_date`, `to_date`, `work_status`) VALUES
(1, '1', '2023-06-20 14:40:50', '2023-06-26 14:40:50', 0),
(2, '1', '2023-09-20 14:40:50', '2023-09-26 14:40:50', 0),
(3, '1', '2023-12-20 14:40:50', '2023-12-26 14:40:50', 0);

-- --------------------------------------------------------

--
-- Table structure for table `audit_assign`
--

CREATE TABLE `audit_assign` (
  `audit_assign_id` int(11) NOT NULL,
  `date_of_audit` date DEFAULT NULL,
  `department_id` varchar(100) DEFAULT NULL,
  `role1` varchar(100) DEFAULT NULL,
  `role2` varchar(100) DEFAULT NULL,
  `audit_area_id` varchar(100) DEFAULT NULL,
  `auditee_response_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_assign`
--

INSERT INTO `audit_assign` (`audit_assign_id`, `date_of_audit`, `department_id`, `role1`, `role2`, `audit_area_id`, `auditee_response_status`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '2023-06-21', '7,1', '1', '6', '1', 0, 0, 1, NULL, NULL, '2023-06-06 15:57:23', '2023-06-06 15:57:23');

-- --------------------------------------------------------

--
-- Table structure for table `audit_assign_ref`
--

CREATE TABLE `audit_assign_ref` (
  `audit_assign_ref_id` int(11) NOT NULL,
  `audit_assign_id` varchar(100) DEFAULT NULL,
  `major_area` varchar(200) DEFAULT NULL,
  `assertion` varchar(200) DEFAULT NULL,
  `audit_status` varchar(50) DEFAULT NULL,
  `recommendation` varchar(250) DEFAULT NULL,
  `attachment` varchar(200) DEFAULT NULL,
  `audit_remarks` text DEFAULT NULL,
  `auditee_response` varchar(100) DEFAULT NULL,
  `action_plan` varchar(100) DEFAULT NULL,
  `target_date` varchar(100) DEFAULT NULL,
  `auditee_response_status` int(11) NOT NULL DEFAULT 0,
  `auditee_followup_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_assign_ref`
--

INSERT INTO `audit_assign_ref` (`audit_assign_ref_id`, `audit_assign_id`, `major_area`, `assertion`, `audit_status`, `recommendation`, `attachment`, `audit_remarks`, `auditee_response`, `action_plan`, `target_date`, `auditee_response_status`, `auditee_followup_status`) VALUES
(1, '1', 'Checklist1', 'test1', '', '', '', '', NULL, NULL, NULL, 0, 0),
(2, '1', 'fgh', 'fghfg', '', '', '', '', NULL, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `audit_checklist`
--

CREATE TABLE `audit_checklist` (
  `audit_checklist_id` int(11) NOT NULL,
  `audit_area_id` int(11) DEFAULT NULL,
  `department` varchar(200) DEFAULT NULL,
  `auditor` varchar(200) DEFAULT NULL,
  `auditee` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_checklist`
--

INSERT INTO `audit_checklist` (`audit_checklist_id`, `audit_area_id`, `department`, `auditor`, `auditee`, `status`) VALUES
(1, 1, '7,1', '1', '6', 0);

-- --------------------------------------------------------

--
-- Table structure for table `audit_checklist_ref`
--

CREATE TABLE `audit_checklist_ref` (
  `audit_checklist_ref_id` int(11) NOT NULL,
  `audit_area_id` int(11) DEFAULT NULL,
  `major_area` varchar(200) DEFAULT NULL,
  `sub_area` varchar(200) DEFAULT NULL,
  `assertion` varchar(200) DEFAULT NULL,
  `weightage` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_checklist_ref`
--

INSERT INTO `audit_checklist_ref` (`audit_checklist_ref_id`, `audit_area_id`, `major_area`, `sub_area`, `assertion`, `weightage`) VALUES
(1, 1, 'Checklist1', NULL, 'test1', NULL),
(2, 1, 'fgh', NULL, 'fghfg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audit_followup`
--

CREATE TABLE `audit_followup` (
  `audit_followup_id` int(11) NOT NULL,
  `audit_assign_id` int(11) DEFAULT NULL,
  `audit_assign_ref_id` int(11) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `completed_date` varchar(255) DEFAULT NULL,
  `files` varchar(200) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bankmaster`
--

CREATE TABLE `bankmaster` (
  `bankid` int(11) NOT NULL,
  `bankcode` varchar(255) DEFAULT NULL,
  `bankname` varchar(255) DEFAULT NULL,
  `accountno` varchar(255) DEFAULT NULL,
  `branchname` varchar(255) DEFAULT NULL,
  `shortform` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `mailid` varchar(255) DEFAULT NULL,
  `ifsccode` varchar(255) DEFAULT NULL,
  `contactperson` varchar(255) DEFAULT NULL,
  `contactno` varchar(255) DEFAULT NULL,
  `micrcode` varchar(255) DEFAULT NULL,
  `typeofaccount` varchar(255) DEFAULT NULL,
  `undersubgroup` varchar(255) DEFAULT NULL,
  `fgroup` varchar(255) DEFAULT NULL,
  `bankgrouprefid` varchar(20) DEFAULT NULL,
  `ledgername` varchar(255) DEFAULT NULL,
  `costcenter` varchar(255) DEFAULT NULL,
  `fromperiod` varchar(50) DEFAULT NULL,
  `toperiod` varchar(50) DEFAULT NULL,
  `duedate` varchar(50) DEFAULT NULL,
  `loanamount` int(11) DEFAULT NULL,
  `emi` int(11) DEFAULT NULL,
  `restofinterest` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `createddate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `basic_creation`
--

CREATE TABLE `basic_creation` (
  `basic_creation_id` int(11) NOT NULL,
  `type` varchar(11) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `department_code` varchar(250) DEFAULT NULL,
  `designation_code` varchar(255) DEFAULT NULL,
  `department` varchar(250) DEFAULT NULL,
  `designation` varchar(250) DEFAULT NULL,
  `report_to` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `basic_creation`
--

INSERT INTO `basic_creation` (`basic_creation_id`, `type`, `company_id`, `department_code`, `designation_code`, `department`, `designation`, `report_to`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, NULL, '3', 'Hib-1/HibiConde', 'DESIG-1/HibiConde', '1', '2,1', '', 0, 1, NULL, NULL, '2023-06-06 11:55:42', '2023-06-06 11:55:42'),
(2, NULL, '4', 'con-2/CondeNast', 'DESIG-2/CondeNast', '3', '4,3,5', '', 0, 1, NULL, NULL, '2023-06-06 11:57:35', '2023-06-06 11:57:35'),
(3, NULL, '1', 'Fin-3/LittleProdapt', 'DESIG-3/LittleProdapt', '6', '6,7', '', 0, 1, NULL, NULL, '2023-06-06 12:01:01', '2023-06-06 12:01:01'),
(4, NULL, '2', 'Acc-4/olympia', 'DESIG-4/olympia', '7', '9,8', '', 0, 1, NULL, NULL, '2023-06-06 12:27:20', '2023-06-06 12:27:20'),
(5, NULL, '3', 'Hib-5/HibiConde', 'DESIG-5/HibiConde', '2', '10', '', 0, 1, NULL, NULL, '2023-06-06 12:32:11', '2023-06-06 12:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `bm_checklist`
--

CREATE TABLE `bm_checklist` (
  `bm_checklist_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `checklist` text DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `maintenance_checklist` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bm_checklist`
--

INSERT INTO `bm_checklist` (`bm_checklist_id`, `company_id`, `category_id`, `checklist`, `rating`, `maintenance_checklist`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '3', '1', 'dsgasdfgasd', 'Medium', 0, 0, 1, NULL, NULL, '2023-06-06 17:07:24', '2023-06-06 17:07:24');

-- --------------------------------------------------------

--
-- Table structure for table `branch_creation`
--

CREATE TABLE `branch_creation` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `address1` text DEFAULT NULL,
  `address2` text DEFAULT NULL,
  `key_personal` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `pf_number` varchar(250) DEFAULT NULL,
  `fax_number` varchar(250) DEFAULT NULL,
  `office_number` varchar(250) DEFAULT NULL,
  `esi_number` varchar(250) DEFAULT NULL,
  `tan_number` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch_creation`
--

INSERT INTO `branch_creation` (`branch_id`, `branch_name`, `company_id`, `address1`, `address2`, `key_personal`, `city`, `state`, `email_id`, `website`, `pan_number`, `pf_number`, `fax_number`, `office_number`, `esi_number`, `tan_number`, `company_logo`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Little Prodapt', 2, 'OMR Road,', 'Thoraipakkam', 'IT', 'Chennai', 'TamilNadu', 'lttleprodapt@mail.com', 'www.prodapt.com', 'GTRFS2309G', 'PP/FRD/7823878/789/8777878', '4626446464463', '6575346436', '67/43/894434/898/9000', 'RFAS23322F', NULL, 0, 1, NULL, NULL, '2023-06-06 11:25:02', '2023-06-06 11:25:02'),
(2, 'olympia', 2, 'Ashok nagar road,', 'ekkatuthangal', 'IT', 'Chennai', 'TamilNadu', 'sample@gmail.com', 'www.prodapt.com', 'ASFFD9239F', 'KN/KRP/7654321/783/2343233', '5684658564486', '6535423354', '87/75/983493/455/2324', 'DFSS39023G', NULL, 0, 1, NULL, NULL, '2023-06-06 11:46:51', '2023-06-06 11:46:51'),
(3, 'Hibi Conde', 1, 'No.55, TSKV Street, ', 'Mylapore, Chennai.', 'IT', 'Chennai', 'TamilNadu', 'hibis@yahoo.in', 'www.hibis.com', 'DSSFD9239F', 'PP/FRD/7823878/789/8777878', '8345734346634', '3446363463', '67/43/894434/898/9000', 'DFSS39023G', NULL, 0, 1, NULL, NULL, '2023-06-06 11:48:01', '2023-06-06 11:48:01'),
(4, 'CondeNast', 1, 'No.3/7, 14th Trust Road,', 'Lawspet', 'IT', 'Cuddalore', 'TamilNadu', 'abc@abc.com', 'www.hibis.com', 'ASFFD9239F', 'PP/FRD/7823878/789/8777878', '6758646232232', '2325342344', '67/43/894434/898/9000', 'DADS39023G', NULL, 0, 1, NULL, NULL, '2023-06-06 11:50:01', '2023-06-06 11:50:01');

-- --------------------------------------------------------

--
-- Table structure for table `business_com_line`
--

CREATE TABLE `business_com_line` (
  `business_com_line_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(250) DEFAULT NULL,
  `approval_staff_id` varchar(255) DEFAULT NULL,
  `agree_par_staff_id` varchar(255) DEFAULT NULL,
  `after_notified_staff_id` varchar(255) DEFAULT NULL,
  `recipient_id` varchar(255) DEFAULT NULL,
  `receiving_branch_id` varchar(255) DEFAULT NULL,
  `checker_approval` varchar(255) NOT NULL DEFAULT '0',
  `reviewer_approval` varchar(250) NOT NULL DEFAULT '0',
  `final_approval` varchar(250) NOT NULL DEFAULT '0',
  `checker_approval_date` varchar(250) DEFAULT NULL,
  `reviewer_approval_date` varchar(255) DEFAULT NULL,
  `final_approval_date` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `business_com_out`
--

CREATE TABLE `business_com_out` (
  `business_com_out_id` int(11) NOT NULL,
  `business_com_line_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `doc_no` varchar(255) DEFAULT NULL,
  `auto_generation_date` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `business_com_parallel_agree_disagree`
--

CREATE TABLE `business_com_parallel_agree_disagree` (
  `business_com_parallel_agree_disagree_id` int(11) NOT NULL,
  `business_com_line_id` varchar(255) DEFAULT NULL,
  `agree_disagree_staff_id` varchar(255) DEFAULT NULL,
  `agree_disagree` int(11) NOT NULL DEFAULT 0,
  `agree_disagree_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `campaign_id` int(11) NOT NULL,
  `promotional_activities_id` varchar(50) DEFAULT NULL,
  `actual_start_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `campaign`
--

INSERT INTO `campaign` (`campaign_id`, `promotional_activities_id`, `actual_start_date`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '2023-07-15', 0, 1, NULL, NULL, '2023-06-06 15:59:04', '2023-06-06 15:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_ref`
--

CREATE TABLE `campaign_ref` (
  `campaign_ref_id` int(11) NOT NULL,
  `campaign_id` varchar(50) DEFAULT NULL,
  `promotional_activities_ref_id` varchar(50) DEFAULT NULL,
  `activity_involved` varchar(255) DEFAULT NULL,
  `time_frame_start` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `campaign_ref`
--

INSERT INTO `campaign_ref` (`campaign_ref_id`, `campaign_id`, `promotional_activities_ref_id`, `activity_involved`, `time_frame_start`, `duration`, `start_date`, `end_date`, `employee_name`, `work_status`) VALUES
(1, '1', '1', 'devlopment Post ', '10', '30', '2023-07-05 15:59:04', '2023-08-04 15:59:04', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `category_creation`
--

CREATE TABLE `category_creation` (
  `category_creation_id` int(11) NOT NULL,
  `category_creation_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_creation`
--

INSERT INTO `category_creation` (`category_creation_id`, `category_creation_name`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'maintance', 0, NULL, NULL, NULL, '2023-06-06 17:05:09', '2023-06-06 17:05:09');

-- --------------------------------------------------------

--
-- Table structure for table `company_creation`
--

CREATE TABLE `company_creation` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_status` varchar(255) DEFAULT NULL,
  `cin` varchar(255) DEFAULT NULL,
  `address1` text DEFAULT NULL,
  `address2` text DEFAULT NULL,
  `key_personal` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `pf_number` varchar(250) DEFAULT NULL,
  `fax_number` varchar(250) DEFAULT NULL,
  `office_number` varchar(250) DEFAULT NULL,
  `esi_number` varchar(250) DEFAULT NULL,
  `tan_number` varchar(255) DEFAULT NULL,
  `company_logo` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_creation`
--

INSERT INTO `company_creation` (`company_id`, `company_name`, `company_status`, `cin`, `address1`, `address2`, `key_personal`, `city`, `state`, `email_id`, `website`, `pan_number`, `pf_number`, `fax_number`, `office_number`, `esi_number`, `tan_number`, `company_logo`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Hibis', 'Private Limited', '5454775375', 'No.3/7, 14th Trust cross Street,', ' Mandhaveli, Chennai.', 'IT', 'Chennai', 'TamilNadu', 'abc@abc.com', 'www.hibis.com', 'PEFFD9239F', 'KN/KRP/7654321/783/2343233', '5473737775445', '5634345345', '31/00/123456/030/2333', 'HASF78237H', 'tree-736885__480 (1).jpg', 0, 1, NULL, NULL, '2023-06-06 11:21:19', '2023-06-06 11:21:19'),
(2, 'Prodapt', 'Private Limited', '5454654655', 'No.55, 4th cross Street, ', 'Light House, Chennai.', 'IT', 'Chennai', 'TamilNadu', 'abc@little.in', 'www.prodapt.com', 'FSSFD9239F', 'PP/FSD/8923234/834/8348934', '5123554435343', '2454545151', '78/78/983493/893/9439', 'HASF78237H', '', 0, 1, NULL, NULL, '2023-06-06 11:22:16', '2023-06-06 11:22:16');

-- --------------------------------------------------------

--
-- Table structure for table `costcentre`
--

CREATE TABLE `costcentre` (
  `costcentreid` int(11) NOT NULL,
  `costcentrename` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `daily_km`
--

CREATE TABLE `daily_km` (
  `daily_km_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `daily_km_ref`
--

CREATE TABLE `daily_km_ref` (
  `daily_km_ref_id` int(11) NOT NULL,
  `vehicle_details_id` varchar(255) DEFAULT NULL,
  `vehicle_number` varchar(255) DEFAULT NULL,
  `start_km` varchar(255) DEFAULT NULL,
  `end_km` varchar(255) DEFAULT NULL,
  `daily_km_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `daily_performance`
--

CREATE TABLE `daily_performance` (
  `daily_performance_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `daily_performance_ref`
--

CREATE TABLE `daily_performance_ref` (
  `daily_performance_ref_id` int(11) NOT NULL,
  `daily_performance_id` int(11) DEFAULT NULL,
  `assertion` varchar(200) DEFAULT NULL,
  `target` varchar(100) DEFAULT NULL,
  `system_date` date DEFAULT NULL,
  `old_target` varchar(200) DEFAULT NULL,
  `target_fixing_id` int(11) DEFAULT NULL,
  `target_fixing_ref_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `department_creation`
--

CREATE TABLE `department_creation` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department_creation`
--

INSERT INTO `department_creation` (`department_id`, `department_name`, `company_id`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Hib Development', 3, 0, '2023-06-06 11:54:38', '2023-06-06 11:54:38'),
(2, 'Hib Finance', 3, 0, '2023-06-06 11:54:56', '2023-06-06 11:54:56'),
(3, 'con Digital Marketing', 4, 0, '2023-06-06 11:56:21', '2023-06-06 11:56:21'),
(4, 'Con Marketing', 4, 0, '2023-06-06 11:56:59', '2023-06-06 11:56:59'),
(5, 'Devlopment', 1, 0, '2023-06-06 11:59:05', '2023-06-06 11:59:05'),
(6, 'Finance', 1, 0, '2023-06-06 11:59:13', '2023-06-06 11:59:13'),
(7, 'Accounts', 2, 0, '2023-06-06 12:26:35', '2023-06-06 12:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `designation_creation`
--

CREATE TABLE `designation_creation` (
  `designation_id` int(11) NOT NULL,
  `designation_name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `designation_creation`
--

INSERT INTO `designation_creation` (`designation_id`, `designation_name`, `company_id`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Software Developer', 3, 0, '2023-06-06 11:55:14', '2023-06-06 11:55:14'),
(2, 'Junior Software Developer', 3, 0, '2023-06-06 11:55:28', '2023-06-06 11:55:28'),
(3, 'Designer', 4, 0, '2023-06-06 11:57:12', '2023-06-06 11:57:12'),
(4, 'Content Writer', 4, 0, '2023-06-06 11:57:20', '2023-06-06 11:57:20'),
(5, 'SEO', 4, 0, '2023-06-06 11:57:27', '2023-06-06 11:57:27'),
(6, 'Chief Finance ', 1, 0, '2023-06-06 11:59:36', '2023-06-06 11:59:36'),
(7, 'Finance Associate', 1, 0, '2023-06-06 11:59:50', '2023-06-06 11:59:50'),
(8, 'Junior Accountant', 2, 0, '2023-06-06 12:27:03', '2023-06-06 12:27:03'),
(9, 'Accountant', 2, 0, '2023-06-06 12:27:12', '2023-06-06 12:27:12'),
(10, 'Hib Finance', 3, 0, '2023-06-06 12:32:02', '2023-06-06 12:32:02');

-- --------------------------------------------------------

--
-- Table structure for table `diesel_slip`
--

CREATE TABLE `diesel_slip` (
  `diesel_slip_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `vehicle_number` varchar(255) DEFAULT NULL,
  `previous_km` int(11) DEFAULT NULL,
  `previous_km_date` varchar(255) DEFAULT NULL,
  `present_km` int(11) DEFAULT NULL,
  `present_km_date` varchar(255) DEFAULT NULL,
  `total_km_run` int(11) DEFAULT NULL,
  `diesel_amount` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `goal_setting`
--

CREATE TABLE `goal_setting` (
  `goal_setting_id` int(11) NOT NULL,
  `company_name` varchar(11) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `role` varchar(250) DEFAULT NULL,
  `year` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `goal_setting_ref`
--

CREATE TABLE `goal_setting_ref` (
  `goal_setting_ref_id` int(11) NOT NULL,
  `goal_setting_id` int(11) DEFAULT NULL,
  `assertion` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hierarchy_creation`
--

CREATE TABLE `hierarchy_creation` (
  `hierarchy_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `top_hierarchy` varchar(255) DEFAULT NULL,
  `sub_ordinate` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_creation`
--

CREATE TABLE `holiday_creation` (
  `holiday_id` int(11) NOT NULL,
  `calendar_year` varchar(255) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holiday_creation`
--

INSERT INTO `holiday_creation` (`holiday_id`, `calendar_year`, `company_id`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '2023-2024', '1,2', 0, 1, NULL, NULL, '2023-06-06 11:53:53', '2023-06-06 11:53:53');

-- --------------------------------------------------------

--
-- Table structure for table `holiday_creation_ref`
--

CREATE TABLE `holiday_creation_ref` (
  `holiday_ref_id` int(11) NOT NULL,
  `holiday_reff_id` int(11) DEFAULT NULL,
  `holiday_date` date DEFAULT NULL,
  `holiday_description` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holiday_creation_ref`
--

INSERT INTO `holiday_creation_ref` (`holiday_ref_id`, `holiday_reff_id`, `holiday_date`, `holiday_description`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 1, '2023-06-29', 'EID- EL-Aldha', 0, 1, NULL, NULL, '2023-06-06 11:53:53', '2023-06-06 11:53:53'),
(2, 1, '2023-08-15', 'Independence Day', 0, 1, NULL, NULL, '2023-06-06 11:53:53', '2023-06-06 11:53:53'),
(3, 1, '2023-09-18', 'Vinayagar Chagurthi', 0, 1, NULL, NULL, '2023-06-06 11:53:53', '2023-06-06 11:53:53');

-- --------------------------------------------------------

--
-- Table structure for table `insurance_creation`
--

CREATE TABLE `insurance_creation` (
  `insurance_id` int(11) NOT NULL,
  `insurance_name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurance_creation`
--

INSERT INTO `insurance_creation` (`insurance_id`, `insurance_name`, `company_id`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Life Insurance', 3, 0, '2023-06-06 13:23:34', '2023-06-06 13:23:34'),
(2, 'LIfe Long Insurance', 1, 0, '2023-06-06 13:24:32', '2023-06-06 13:24:32');

-- --------------------------------------------------------

--
-- Table structure for table `insurance_register`
--

CREATE TABLE `insurance_register` (
  `ins_reg_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `insurance_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `freq_id` int(11) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `designation_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `calendar` varchar(50) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `frequency_applicable` varchar(100) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurance_register`
--

INSERT INTO `insurance_register` (`ins_reg_id`, `company_id`, `insurance_id`, `dept_id`, `freq_id`, `department_id`, `designation_id`, `staff_id`, `calendar`, `from_date`, `to_date`, `frequency_applicable`, `work_status`, `status`, `created_date`, `updated_date`) VALUES
(1, 3, 1, 1, 1, '1', '1', '1', 'Yes', '2023-07-01 13:23:54', '2023-07-05 13:23:54', 'frequency_applicable', 0, 0, '2023-06-06 13:23:54', '2023-06-06 13:23:54'),
(2, 1, 2, 6, 2, '6', '6', '3', 'Yes', '2023-07-15 13:24:58', '2023-07-20 13:24:58', '', 0, 0, '2023-06-06 13:24:58', '2023-06-06 13:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `insurance_register_ref`
--

CREATE TABLE `insurance_register_ref` (
  `ins_reg_ref_id` int(11) NOT NULL,
  `ins_reg_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `insurance_id` int(11) DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `freq_id` int(11) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `designation_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `calendar` varchar(50) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurance_register_ref`
--

INSERT INTO `insurance_register_ref` (`ins_reg_ref_id`, `ins_reg_id`, `company_id`, `insurance_id`, `dept_id`, `freq_id`, `department_id`, `designation_id`, `staff_id`, `calendar`, `from_date`, `to_date`, `work_status`, `status`, `created_date`, `updated_date`) VALUES
(1, 1, 3, 1, 1, 1, '1', '1', '1', 'Yes', '2023-07-01 13:23:54', '2023-07-05 13:23:54', 0, 0, '2023-06-06 13:23:54', '2023-06-06 13:23:54'),
(2, 2, 1, 2, 6, 2, '6', '6', '3', 'Yes', '2023-07-15 13:24:58', '2023-07-20 13:24:58', 0, 0, '2023-06-06 13:24:58', '2023-06-06 13:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `krakpi_calendar_map`
--

CREATE TABLE `krakpi_calendar_map` (
  `krakpi_calendar_map_id` int(11) NOT NULL,
  `krakpi_id` varchar(50) DEFAULT NULL,
  `krakpi_ref_id` varchar(50) DEFAULT NULL,
  `kra_category` varchar(255) DEFAULT NULL,
  `calendar` varchar(50) DEFAULT NULL,
  `from_date` varchar(50) DEFAULT NULL,
  `to_date` varchar(50) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `krakpi_calendar_map`
--

INSERT INTO `krakpi_calendar_map` (`krakpi_calendar_map_id`, `krakpi_id`, `krakpi_ref_id`, `kra_category`, `calendar`, `from_date`, `to_date`, `work_status`) VALUES
(1, '1', '1', '1', 'No', '1970-01-01 16:04:26', '1970-01-01 16:04:26', 0),
(2, '1', '1', '1', 'No', '1970-04-01 16:04:26', '1970-04-01 16:04:26', 0),
(3, '1', '1', '1', 'No', '1970-07-01 16:04:26', '1970-07-01 16:04:26', 0),
(4, '1', '1', '1', 'No', '1970-10-01 16:04:26', '1970-10-01 16:04:26', 0),
(5, '1', '1', '1', 'No', '1971-01-01 16:04:26', '1971-01-01 16:04:26', 0),
(6, '1', '1', '1', 'No', '1971-04-01 16:04:26', '1971-04-01 16:04:26', 0),
(7, '1', '1', '1', 'No', '1971-07-01 16:04:26', '1971-07-01 16:04:26', 0),
(8, '1', '1', '1', 'No', '1971-10-01 16:04:26', '1971-10-01 16:04:26', 0),
(9, '1', '1', '1', 'No', '1972-01-01 16:04:26', '1972-01-01 16:04:26', 0),
(10, '1', '1', '1', 'No', '1972-04-01 16:04:26', '1972-04-01 16:04:26', 0),
(11, '1', '1', '1', 'No', '1972-07-01 16:04:26', '1972-07-01 16:04:26', 0),
(12, '1', '1', '1', 'No', '1972-10-02 16:04:26', '1972-10-02 16:04:26', 0),
(13, '1', '1', '1', 'No', '1973-01-02 16:04:26', '1973-01-02 16:04:26', 0),
(14, '1', '1', '1', 'No', '1973-04-02 16:04:26', '1973-04-02 16:04:26', 0),
(15, '1', '1', '1', 'No', '1973-07-02 16:04:26', '1973-07-02 16:04:26', 0),
(16, '1', '1', '1', 'No', '1973-10-02 16:04:26', '1973-10-02 16:04:26', 0),
(17, '1', '1', '1', 'No', '1974-01-02 16:04:26', '1974-01-02 16:04:26', 0),
(18, '1', '1', '1', 'No', '1974-04-02 16:04:26', '1974-04-02 16:04:26', 0),
(19, '1', '1', '1', 'No', '1974-07-02 16:04:26', '1974-07-02 16:04:26', 0),
(20, '1', '1', '1', 'No', '1974-10-02 16:04:26', '1974-10-02 16:04:26', 0),
(21, '1', '1', '1', 'No', '1975-01-02 16:04:26', '1975-01-02 16:04:26', 0),
(22, '1', '1', '1', 'No', '1975-04-02 16:04:26', '1975-04-02 16:04:26', 0),
(23, '1', '1', '1', 'No', '1975-07-02 16:04:26', '1975-07-02 16:04:26', 0),
(24, '1', '1', '1', 'No', '1975-10-02 16:04:26', '1975-10-02 16:04:26', 0),
(25, '1', '1', '1', 'No', '1976-01-02 16:04:26', '1976-01-02 16:04:26', 0),
(26, '1', '1', '1', 'No', '1976-04-02 16:04:26', '1976-04-02 16:04:26', 0),
(27, '1', '1', '1', 'No', '1976-07-02 16:04:26', '1976-07-02 16:04:26', 0),
(28, '1', '1', '1', 'No', '1976-10-02 16:04:26', '1976-10-02 16:04:26', 0),
(29, '1', '1', '1', 'No', '1977-01-03 16:04:26', '1977-01-03 16:04:26', 0),
(30, '1', '1', '1', 'No', '1977-04-04 16:04:26', '1977-04-04 16:04:26', 0),
(31, '1', '1', '1', 'No', '1977-07-04 16:04:26', '1977-07-04 16:04:26', 0),
(32, '1', '1', '1', 'No', '1977-10-04 16:04:26', '1977-10-04 16:04:26', 0),
(33, '1', '1', '1', 'No', '1978-01-04 16:04:26', '1978-01-04 16:04:26', 0),
(34, '1', '1', '1', 'No', '1978-04-04 16:04:26', '1978-04-04 16:04:26', 0),
(35, '1', '1', '1', 'No', '1978-07-04 16:04:26', '1978-07-04 16:04:26', 0),
(36, '1', '1', '1', 'No', '1978-10-04 16:04:26', '1978-10-04 16:04:26', 0),
(37, '1', '1', '1', 'No', '1979-01-04 16:04:26', '1979-01-04 16:04:26', 0),
(38, '1', '1', '1', 'No', '1979-04-04 16:04:26', '1979-04-04 16:04:26', 0),
(39, '1', '1', '1', 'No', '1979-07-04 16:04:26', '1979-07-04 16:04:26', 0),
(40, '1', '1', '1', 'No', '1979-10-04 16:04:26', '1979-10-04 16:04:26', 0),
(41, '1', '1', '1', 'No', '1980-01-04 16:04:26', '1980-01-04 16:04:26', 0),
(42, '1', '1', '1', 'No', '1980-04-04 16:04:26', '1980-04-04 16:04:26', 0),
(43, '1', '1', '1', 'No', '1980-07-04 16:04:26', '1980-07-04 16:04:26', 0),
(44, '1', '1', '1', 'No', '1980-10-04 16:04:26', '1980-10-04 16:04:26', 0),
(45, '1', '1', '1', 'No', '1981-01-05 16:04:26', '1981-01-05 16:04:26', 0),
(46, '1', '1', '1', 'No', '1981-04-06 16:04:26', '1981-04-06 16:04:26', 0),
(47, '1', '1', '1', 'No', '1981-07-06 16:04:26', '1981-07-06 16:04:26', 0),
(48, '1', '1', '1', 'No', '1981-10-06 16:04:26', '1981-10-06 16:04:26', 0),
(49, '1', '1', '1', 'No', '1982-01-06 16:04:26', '1982-01-06 16:04:26', 0),
(50, '1', '1', '1', 'No', '1982-04-06 16:04:26', '1982-04-06 16:04:26', 0),
(51, '1', '1', '1', 'No', '1982-07-06 16:04:26', '1982-07-06 16:04:26', 0),
(52, '1', '1', '1', 'No', '1982-10-06 16:04:26', '1982-10-06 16:04:26', 0),
(53, '1', '1', '1', 'No', '1983-01-06 16:04:26', '1983-01-06 16:04:26', 0),
(54, '1', '1', '1', 'No', '1983-04-06 16:04:26', '1983-04-06 16:04:26', 0),
(55, '1', '1', '1', 'No', '1983-07-06 16:04:26', '1983-07-06 16:04:26', 0),
(56, '1', '1', '1', 'No', '1983-10-06 16:04:26', '1983-10-06 16:04:26', 0),
(57, '1', '1', '1', 'No', '1984-01-06 16:04:26', '1984-01-06 16:04:26', 0),
(58, '1', '1', '1', 'No', '1984-04-06 16:04:26', '1984-04-06 16:04:26', 0),
(59, '1', '1', '1', 'No', '1984-07-06 16:04:26', '1984-07-06 16:04:26', 0),
(60, '1', '1', '1', 'No', '1984-10-06 16:04:26', '1984-10-06 16:04:26', 0),
(61, '1', '1', '1', 'No', '1985-01-07 16:04:26', '1985-01-07 16:04:26', 0),
(62, '1', '1', '1', 'No', '1985-04-08 16:04:26', '1985-04-08 16:04:26', 0),
(63, '1', '1', '1', 'No', '1985-07-08 16:04:26', '1985-07-08 16:04:26', 0),
(64, '1', '1', '1', 'No', '1985-10-08 16:04:26', '1985-10-08 16:04:26', 0),
(65, '1', '1', '1', 'No', '1986-01-08 16:04:26', '1986-01-08 16:04:26', 0),
(66, '1', '1', '1', 'No', '1986-04-08 16:04:26', '1986-04-08 16:04:26', 0),
(67, '1', '1', '1', 'No', '1986-07-08 16:04:26', '1986-07-08 16:04:26', 0),
(68, '1', '1', '1', 'No', '1986-10-08 16:04:26', '1986-10-08 16:04:26', 0),
(69, '1', '1', '1', 'No', '1987-01-08 16:04:26', '1987-01-08 16:04:26', 0),
(70, '1', '1', '1', 'No', '1987-04-08 16:04:26', '1987-04-08 16:04:26', 0),
(71, '1', '1', '1', 'No', '1987-07-08 16:04:26', '1987-07-08 16:04:26', 0),
(72, '1', '1', '1', 'No', '1987-10-08 16:04:26', '1987-10-08 16:04:26', 0),
(73, '1', '1', '1', 'No', '1988-01-08 16:04:26', '1988-01-08 16:04:26', 0),
(74, '1', '1', '1', 'No', '1988-04-08 16:04:26', '1988-04-08 16:04:26', 0),
(75, '1', '1', '1', 'No', '1988-07-08 16:04:26', '1988-07-08 16:04:26', 0),
(76, '1', '1', '1', 'No', '1988-10-08 16:04:26', '1988-10-08 16:04:26', 0),
(77, '1', '1', '1', 'No', '1989-01-09 16:04:26', '1989-01-09 16:04:26', 0),
(78, '1', '1', '1', 'No', '1989-04-10 16:04:26', '1989-04-10 16:04:26', 0),
(79, '1', '1', '1', 'No', '1989-07-10 16:04:26', '1989-07-10 16:04:26', 0),
(80, '1', '1', '1', 'No', '1989-10-10 16:04:26', '1989-10-10 16:04:26', 0),
(81, '1', '1', '1', 'No', '1990-01-10 16:04:26', '1990-01-10 16:04:26', 0),
(82, '1', '1', '1', 'No', '1990-04-10 16:04:26', '1990-04-10 16:04:26', 0),
(83, '1', '1', '1', 'No', '1990-07-10 16:04:26', '1990-07-10 16:04:26', 0),
(84, '1', '1', '1', 'No', '1990-10-10 16:04:26', '1990-10-10 16:04:26', 0),
(85, '1', '1', '1', 'No', '1991-01-10 16:04:26', '1991-01-10 16:04:26', 0),
(86, '1', '1', '1', 'No', '1991-04-10 16:04:26', '1991-04-10 16:04:26', 0),
(87, '1', '1', '1', 'No', '1991-07-10 16:04:26', '1991-07-10 16:04:26', 0),
(88, '1', '1', '1', 'No', '1991-10-10 16:04:26', '1991-10-10 16:04:26', 0),
(89, '1', '1', '1', 'No', '1992-01-10 16:04:26', '1992-01-10 16:04:26', 0),
(90, '1', '1', '1', 'No', '1992-04-10 16:04:26', '1992-04-10 16:04:26', 0),
(91, '1', '1', '1', 'No', '1992-07-10 16:04:26', '1992-07-10 16:04:26', 0),
(92, '1', '1', '1', 'No', '1992-10-10 16:04:26', '1992-10-10 16:04:26', 0),
(93, '1', '1', '1', 'No', '1993-01-11 16:04:26', '1993-01-11 16:04:26', 0),
(94, '1', '1', '1', 'No', '1993-04-12 16:04:26', '1993-04-12 16:04:26', 0),
(95, '1', '1', '1', 'No', '1993-07-12 16:04:26', '1993-07-12 16:04:26', 0),
(96, '1', '1', '1', 'No', '1993-10-12 16:04:26', '1993-10-12 16:04:26', 0),
(97, '1', '1', '1', 'No', '1994-01-12 16:04:26', '1994-01-12 16:04:26', 0),
(98, '1', '1', '1', 'No', '1994-04-12 16:04:26', '1994-04-12 16:04:26', 0),
(99, '1', '1', '1', 'No', '1994-07-12 16:04:26', '1994-07-12 16:04:26', 0),
(100, '1', '1', '1', 'No', '1994-10-12 16:04:26', '1994-10-12 16:04:26', 0),
(101, '1', '1', '1', 'No', '1995-01-12 16:04:26', '1995-01-12 16:04:26', 0),
(102, '1', '1', '1', 'No', '1995-04-12 16:04:26', '1995-04-12 16:04:26', 0),
(103, '1', '1', '1', 'No', '1995-07-12 16:04:26', '1995-07-12 16:04:26', 0),
(104, '1', '1', '1', 'No', '1995-10-12 16:04:26', '1995-10-12 16:04:26', 0),
(105, '1', '1', '1', 'No', '1996-01-12 16:04:26', '1996-01-12 16:04:26', 0),
(106, '1', '1', '1', 'No', '1996-04-12 16:04:26', '1996-04-12 16:04:26', 0),
(107, '1', '1', '1', 'No', '1996-07-12 16:04:26', '1996-07-12 16:04:26', 0),
(108, '1', '1', '1', 'No', '1996-10-12 16:04:26', '1996-10-12 16:04:26', 0),
(109, '1', '1', '1', 'No', '1997-01-13 16:04:26', '1997-01-13 16:04:26', 0),
(110, '1', '1', '1', 'No', '1997-04-14 16:04:26', '1997-04-14 16:04:26', 0),
(111, '1', '1', '1', 'No', '1997-07-14 16:04:26', '1997-07-14 16:04:26', 0),
(112, '1', '1', '1', 'No', '1997-10-14 16:04:26', '1997-10-14 16:04:26', 0),
(113, '1', '1', '1', 'No', '1998-01-14 16:04:26', '1998-01-14 16:04:26', 0),
(114, '1', '1', '1', 'No', '1998-04-14 16:04:26', '1998-04-14 16:04:26', 0),
(115, '1', '1', '1', 'No', '1998-07-14 16:04:26', '1998-07-14 16:04:26', 0),
(116, '1', '1', '1', 'No', '1998-10-14 16:04:26', '1998-10-14 16:04:26', 0),
(117, '1', '1', '1', 'No', '1999-01-14 16:04:26', '1999-01-14 16:04:26', 0),
(118, '1', '1', '1', 'No', '1999-04-14 16:04:26', '1999-04-14 16:04:26', 0),
(119, '1', '1', '1', 'No', '1999-07-14 16:04:26', '1999-07-14 16:04:26', 0),
(120, '1', '1', '1', 'No', '1999-10-14 16:04:26', '1999-10-14 16:04:26', 0),
(121, '1', '1', '1', 'No', '2000-01-14 16:04:26', '2000-01-14 16:04:26', 0),
(122, '1', '1', '1', 'No', '2000-04-14 16:04:26', '2000-04-14 16:04:26', 0),
(123, '1', '1', '1', 'No', '2000-07-14 16:04:26', '2000-07-14 16:04:26', 0),
(124, '1', '1', '1', 'No', '2000-10-14 16:04:26', '2000-10-14 16:04:26', 0),
(125, '1', '1', '1', 'No', '2001-01-15 16:04:26', '2001-01-15 16:04:26', 0),
(126, '1', '1', '1', 'No', '2001-04-16 16:04:26', '2001-04-16 16:04:26', 0),
(127, '1', '1', '1', 'No', '2001-07-16 16:04:26', '2001-07-16 16:04:26', 0),
(128, '1', '1', '1', 'No', '2001-10-16 16:04:26', '2001-10-16 16:04:26', 0),
(129, '1', '1', '1', 'No', '2002-01-16 16:04:26', '2002-01-16 16:04:26', 0),
(130, '1', '1', '1', 'No', '2002-04-16 16:04:26', '2002-04-16 16:04:26', 0),
(131, '1', '1', '1', 'No', '2002-07-16 16:04:26', '2002-07-16 16:04:26', 0),
(132, '1', '1', '1', 'No', '2002-10-16 16:04:26', '2002-10-16 16:04:26', 0),
(133, '1', '1', '1', 'No', '2003-01-16 16:04:26', '2003-01-16 16:04:26', 0),
(134, '1', '1', '1', 'No', '2003-04-16 16:04:26', '2003-04-16 16:04:26', 0),
(135, '1', '1', '1', 'No', '2003-07-16 16:04:26', '2003-07-16 16:04:26', 0),
(136, '1', '1', '1', 'No', '2003-10-16 16:04:26', '2003-10-16 16:04:26', 0),
(137, '1', '1', '1', 'No', '2004-01-16 16:04:26', '2004-01-16 16:04:26', 0),
(138, '1', '1', '1', 'No', '2004-04-16 16:04:26', '2004-04-16 16:04:26', 0),
(139, '1', '1', '1', 'No', '2004-07-16 16:04:26', '2004-07-16 16:04:26', 0),
(140, '1', '1', '1', 'No', '2004-10-16 16:04:26', '2004-10-16 16:04:26', 0),
(141, '1', '1', '1', 'No', '2005-01-17 16:04:26', '2005-01-17 16:04:26', 0),
(142, '1', '1', '1', 'No', '2005-04-18 16:04:26', '2005-04-18 16:04:26', 0),
(143, '1', '1', '1', 'No', '2005-07-18 16:04:26', '2005-07-18 16:04:26', 0),
(144, '1', '1', '1', 'No', '2005-10-18 16:04:26', '2005-10-18 16:04:26', 0),
(145, '1', '1', '1', 'No', '2006-01-18 16:04:26', '2006-01-18 16:04:26', 0),
(146, '1', '1', '1', 'No', '2006-04-18 16:04:26', '2006-04-18 16:04:26', 0),
(147, '1', '1', '1', 'No', '2006-07-18 16:04:26', '2006-07-18 16:04:26', 0),
(148, '1', '1', '1', 'No', '2006-10-18 16:04:26', '2006-10-18 16:04:26', 0),
(149, '1', '1', '1', 'No', '2007-01-18 16:04:26', '2007-01-18 16:04:26', 0),
(150, '1', '1', '1', 'No', '2007-04-18 16:04:26', '2007-04-18 16:04:26', 0),
(151, '1', '1', '1', 'No', '2007-07-18 16:04:26', '2007-07-18 16:04:26', 0),
(152, '1', '1', '1', 'No', '2007-10-18 16:04:26', '2007-10-18 16:04:26', 0),
(153, '1', '1', '1', 'No', '2008-01-18 16:04:26', '2008-01-18 16:04:26', 0),
(154, '1', '1', '1', 'No', '2008-04-18 16:04:26', '2008-04-18 16:04:26', 0),
(155, '1', '1', '1', 'No', '2008-07-18 16:04:26', '2008-07-18 16:04:26', 0),
(156, '1', '1', '1', 'No', '2008-10-18 16:04:26', '2008-10-18 16:04:26', 0),
(157, '1', '1', '1', 'No', '2009-01-19 16:04:26', '2009-01-19 16:04:26', 0),
(158, '1', '1', '1', 'No', '2009-04-20 16:04:26', '2009-04-20 16:04:26', 0),
(159, '1', '1', '1', 'No', '2009-07-20 16:04:26', '2009-07-20 16:04:26', 0),
(160, '1', '1', '1', 'No', '2009-10-20 16:04:26', '2009-10-20 16:04:26', 0),
(161, '1', '1', '1', 'No', '2010-01-20 16:04:26', '2010-01-20 16:04:26', 0),
(162, '1', '1', '1', 'No', '2010-04-20 16:04:26', '2010-04-20 16:04:26', 0),
(163, '1', '1', '1', 'No', '2010-07-20 16:04:26', '2010-07-20 16:04:26', 0),
(164, '1', '1', '1', 'No', '2010-10-20 16:04:26', '2010-10-20 16:04:26', 0),
(165, '1', '1', '1', 'No', '2011-01-20 16:04:26', '2011-01-20 16:04:26', 0),
(166, '1', '1', '1', 'No', '2011-04-20 16:04:26', '2011-04-20 16:04:26', 0),
(167, '1', '1', '1', 'No', '2011-07-20 16:04:26', '2011-07-20 16:04:26', 0),
(168, '1', '1', '1', 'No', '2011-10-20 16:04:26', '2011-10-20 16:04:26', 0),
(169, '1', '1', '1', 'No', '2012-01-20 16:04:26', '2012-01-20 16:04:26', 0),
(170, '1', '1', '1', 'No', '2012-04-20 16:04:26', '2012-04-20 16:04:26', 0),
(171, '1', '1', '1', 'No', '2012-07-20 16:04:26', '2012-07-20 16:04:26', 0),
(172, '1', '1', '1', 'No', '2012-10-20 16:04:26', '2012-10-20 16:04:26', 0),
(173, '1', '1', '1', 'No', '2013-01-21 16:04:26', '2013-01-21 16:04:26', 0),
(174, '1', '1', '1', 'No', '2013-04-22 16:04:26', '2013-04-22 16:04:26', 0),
(175, '1', '1', '1', 'No', '2013-07-22 16:04:26', '2013-07-22 16:04:26', 0),
(176, '1', '1', '1', 'No', '2013-10-22 16:04:26', '2013-10-22 16:04:26', 0),
(177, '1', '1', '1', 'No', '2014-01-22 16:04:26', '2014-01-22 16:04:26', 0),
(178, '1', '1', '1', 'No', '2014-04-22 16:04:26', '2014-04-22 16:04:26', 0),
(179, '1', '1', '1', 'No', '2014-07-22 16:04:26', '2014-07-22 16:04:26', 0),
(180, '1', '1', '1', 'No', '2014-10-22 16:04:26', '2014-10-22 16:04:26', 0),
(181, '1', '1', '1', 'No', '2015-01-22 16:04:26', '2015-01-22 16:04:26', 0),
(182, '1', '1', '1', 'No', '2015-04-22 16:04:26', '2015-04-22 16:04:26', 0),
(183, '1', '1', '1', 'No', '2015-07-22 16:04:26', '2015-07-22 16:04:26', 0),
(184, '1', '1', '1', 'No', '2015-10-22 16:04:26', '2015-10-22 16:04:26', 0),
(185, '1', '1', '1', 'No', '2016-01-22 16:04:26', '2016-01-22 16:04:26', 0),
(186, '1', '1', '1', 'No', '2016-04-22 16:04:26', '2016-04-22 16:04:26', 0),
(187, '1', '1', '1', 'No', '2016-07-22 16:04:26', '2016-07-22 16:04:26', 0),
(188, '1', '1', '1', 'No', '2016-10-22 16:04:26', '2016-10-22 16:04:26', 0),
(189, '1', '1', '1', 'No', '2017-01-23 16:04:26', '2017-01-23 16:04:26', 0),
(190, '1', '1', '1', 'No', '2017-04-24 16:04:26', '2017-04-24 16:04:26', 0),
(191, '1', '1', '1', 'No', '2017-07-24 16:04:26', '2017-07-24 16:04:26', 0),
(192, '1', '1', '1', 'No', '2017-10-24 16:04:26', '2017-10-24 16:04:26', 0),
(193, '1', '1', '1', 'No', '2018-01-24 16:04:26', '2018-01-24 16:04:26', 0),
(194, '1', '1', '1', 'No', '2018-04-24 16:04:26', '2018-04-24 16:04:26', 0),
(195, '1', '1', '1', 'No', '2018-07-24 16:04:26', '2018-07-24 16:04:26', 0),
(196, '1', '1', '1', 'No', '2018-10-24 16:04:26', '2018-10-24 16:04:26', 0),
(197, '1', '1', '1', 'No', '2019-01-24 16:04:26', '2019-01-24 16:04:26', 0),
(198, '1', '1', '1', 'No', '2019-04-24 16:04:26', '2019-04-24 16:04:26', 0),
(199, '1', '1', '1', 'No', '2019-07-24 16:04:26', '2019-07-24 16:04:26', 0),
(200, '1', '1', '1', 'No', '2019-10-24 16:04:26', '2019-10-24 16:04:26', 0),
(201, '1', '1', '1', 'No', '2020-01-24 16:04:26', '2020-01-24 16:04:26', 0),
(202, '1', '1', '1', 'No', '2020-04-24 16:04:26', '2020-04-24 16:04:26', 0),
(203, '1', '1', '1', 'No', '2020-07-24 16:04:26', '2020-07-24 16:04:26', 0),
(204, '1', '1', '1', 'No', '2020-10-24 16:04:26', '2020-10-24 16:04:26', 0),
(205, '1', '1', '1', 'No', '2021-01-25 16:04:26', '2021-01-25 16:04:26', 0),
(206, '1', '1', '1', 'No', '2021-04-26 16:04:26', '2021-04-26 16:04:26', 0),
(207, '1', '1', '1', 'No', '2021-07-26 16:04:26', '2021-07-26 16:04:26', 0),
(208, '1', '1', '1', 'No', '2021-10-26 16:04:26', '2021-10-26 16:04:26', 0),
(209, '1', '1', '1', 'No', '2022-01-26 16:04:26', '2022-01-26 16:04:26', 0),
(210, '1', '1', '1', 'No', '2022-04-26 16:04:26', '2022-04-26 16:04:26', 0),
(211, '1', '1', '1', 'No', '2022-07-26 16:04:26', '2022-07-26 16:04:26', 0),
(212, '1', '1', '1', 'No', '2022-10-26 16:04:26', '2022-10-26 16:04:26', 0),
(213, '1', '1', '1', 'No', '2023-01-26 16:04:26', '2023-01-26 16:04:26', 0),
(214, '1', '1', '1', 'No', '2023-04-26 16:04:26', '2023-04-26 16:04:26', 0),
(215, '1', '1', '1', 'No', '2023-07-26 16:04:26', '2023-07-26 16:04:26', 0),
(216, '1', '1', '1', 'No', '2023-10-26 16:04:26', '2023-10-26 16:04:26', 0),
(217, '2', '2', '2', 'No', '1970-01-01 16:04:48', '1970-01-01 16:04:48', 0),
(218, '2', '2', '2', 'No', '1970-01-16 16:04:48', '1970-01-16 16:04:48', 0),
(219, '2', '2', '2', 'No', '1970-01-31 16:04:48', '1970-01-31 16:04:48', 0),
(220, '2', '2', '2', 'No', '1970-02-16 16:04:48', '1970-02-16 16:04:48', 0),
(221, '2', '2', '2', 'No', '1970-03-03 16:04:48', '1970-03-03 16:04:48', 0),
(222, '2', '2', '2', 'No', '1970-03-18 16:04:48', '1970-03-18 16:04:48', 0),
(223, '2', '2', '2', 'No', '1970-04-02 16:04:48', '1970-04-02 16:04:48', 0),
(224, '2', '2', '2', 'No', '1970-04-17 16:04:48', '1970-04-17 16:04:48', 0),
(225, '2', '2', '2', 'No', '1970-05-02 16:04:48', '1970-05-02 16:04:48', 0),
(226, '2', '2', '2', 'No', '1970-05-18 16:04:48', '1970-05-18 16:04:48', 0),
(227, '2', '2', '2', 'No', '1970-06-02 16:04:48', '1970-06-02 16:04:48', 0),
(228, '2', '2', '2', 'No', '1970-06-17 16:04:48', '1970-06-17 16:04:48', 0),
(229, '2', '2', '2', 'No', '1970-07-02 16:04:48', '1970-07-02 16:04:48', 0),
(230, '2', '2', '2', 'No', '1970-07-17 16:04:48', '1970-07-17 16:04:48', 0),
(231, '2', '2', '2', 'No', '1970-08-01 16:04:48', '1970-08-01 16:04:48', 0),
(232, '2', '2', '2', 'No', '1970-08-17 16:04:48', '1970-08-17 16:04:48', 0),
(233, '2', '2', '2', 'No', '1970-09-01 16:04:48', '1970-09-01 16:04:48', 0),
(234, '2', '2', '2', 'No', '1970-09-16 16:04:48', '1970-09-16 16:04:48', 0),
(235, '2', '2', '2', 'No', '1970-10-01 16:04:48', '1970-10-01 16:04:48', 0),
(236, '2', '2', '2', 'No', '1970-10-16 16:04:48', '1970-10-16 16:04:48', 0),
(237, '2', '2', '2', 'No', '1970-10-31 16:04:48', '1970-10-31 16:04:48', 0),
(238, '2', '2', '2', 'No', '1970-11-16 16:04:48', '1970-11-16 16:04:48', 0),
(239, '2', '2', '2', 'No', '1970-12-01 16:04:48', '1970-12-01 16:04:48', 0),
(240, '2', '2', '2', 'No', '1970-12-16 16:04:48', '1970-12-16 16:04:48', 0),
(241, '2', '2', '2', 'No', '1970-12-31 16:04:48', '1970-12-31 16:04:48', 0),
(242, '2', '2', '2', 'No', '1971-01-15 16:04:48', '1971-01-15 16:04:48', 0),
(243, '2', '2', '2', 'No', '1971-01-30 16:04:48', '1971-01-30 16:04:48', 0),
(244, '2', '2', '2', 'No', '1971-02-15 16:04:48', '1971-02-15 16:04:48', 0),
(245, '2', '2', '2', 'No', '1971-03-02 16:04:48', '1971-03-02 16:04:48', 0),
(246, '2', '2', '2', 'No', '1971-03-17 16:04:48', '1971-03-17 16:04:48', 0),
(247, '2', '2', '2', 'No', '1971-04-01 16:04:48', '1971-04-01 16:04:48', 0),
(248, '2', '2', '2', 'No', '1971-04-16 16:04:48', '1971-04-16 16:04:48', 0),
(249, '2', '2', '2', 'No', '1971-05-01 16:04:48', '1971-05-01 16:04:48', 0),
(250, '2', '2', '2', 'No', '1971-05-17 16:04:48', '1971-05-17 16:04:48', 0),
(251, '2', '2', '2', 'No', '1971-06-01 16:04:48', '1971-06-01 16:04:48', 0),
(252, '2', '2', '2', 'No', '1971-06-16 16:04:48', '1971-06-16 16:04:48', 0),
(253, '2', '2', '2', 'No', '1971-07-01 16:04:48', '1971-07-01 16:04:48', 0),
(254, '2', '2', '2', 'No', '1971-07-16 16:04:48', '1971-07-16 16:04:48', 0),
(255, '2', '2', '2', 'No', '1971-07-31 16:04:48', '1971-07-31 16:04:48', 0),
(256, '2', '2', '2', 'No', '1971-08-16 16:04:48', '1971-08-16 16:04:48', 0),
(257, '2', '2', '2', 'No', '1971-08-31 16:04:48', '1971-08-31 16:04:48', 0),
(258, '2', '2', '2', 'No', '1971-09-15 16:04:48', '1971-09-15 16:04:48', 0),
(259, '2', '2', '2', 'No', '1971-09-30 16:04:48', '1971-09-30 16:04:48', 0),
(260, '2', '2', '2', 'No', '1971-10-15 16:04:48', '1971-10-15 16:04:48', 0),
(261, '2', '2', '2', 'No', '1971-10-30 16:04:48', '1971-10-30 16:04:48', 0),
(262, '2', '2', '2', 'No', '1971-11-15 16:04:48', '1971-11-15 16:04:48', 0),
(263, '2', '2', '2', 'No', '1971-11-30 16:04:48', '1971-11-30 16:04:48', 0),
(264, '2', '2', '2', 'No', '1971-12-15 16:04:48', '1971-12-15 16:04:48', 0),
(265, '2', '2', '2', 'No', '1971-12-30 16:04:48', '1971-12-30 16:04:48', 0),
(266, '2', '2', '2', 'No', '1972-01-14 16:04:48', '1972-01-14 16:04:48', 0),
(267, '2', '2', '2', 'No', '1972-01-29 16:04:48', '1972-01-29 16:04:48', 0),
(268, '2', '2', '2', 'No', '1972-02-14 16:04:48', '1972-02-14 16:04:48', 0),
(269, '2', '2', '2', 'No', '1972-02-29 16:04:48', '1972-02-29 16:04:48', 0),
(270, '2', '2', '2', 'No', '1972-03-15 16:04:48', '1972-03-15 16:04:48', 0),
(271, '2', '2', '2', 'No', '1972-03-30 16:04:48', '1972-03-30 16:04:48', 0),
(272, '2', '2', '2', 'No', '1972-04-14 16:04:48', '1972-04-14 16:04:48', 0),
(273, '2', '2', '2', 'No', '1972-04-29 16:04:48', '1972-04-29 16:04:48', 0),
(274, '2', '2', '2', 'No', '1972-05-15 16:04:48', '1972-05-15 16:04:48', 0),
(275, '2', '2', '2', 'No', '1972-05-30 16:04:48', '1972-05-30 16:04:48', 0),
(276, '2', '2', '2', 'No', '1972-06-14 16:04:48', '1972-06-14 16:04:48', 0),
(277, '2', '2', '2', 'No', '1972-06-29 16:04:48', '1972-06-29 16:04:48', 0),
(278, '2', '2', '2', 'No', '1972-07-14 16:04:48', '1972-07-14 16:04:48', 0),
(279, '2', '2', '2', 'No', '1972-07-29 16:04:48', '1972-07-29 16:04:48', 0),
(280, '2', '2', '2', 'No', '1972-08-14 16:04:48', '1972-08-14 16:04:48', 0),
(281, '2', '2', '2', 'No', '1972-08-29 16:04:48', '1972-08-29 16:04:48', 0),
(282, '2', '2', '2', 'No', '1972-09-13 16:04:48', '1972-09-13 16:04:48', 0),
(283, '2', '2', '2', 'No', '1972-09-28 16:04:48', '1972-09-28 16:04:48', 0),
(284, '2', '2', '2', 'No', '1972-10-13 16:04:48', '1972-10-13 16:04:48', 0),
(285, '2', '2', '2', 'No', '1972-10-28 16:04:48', '1972-10-28 16:04:48', 0),
(286, '2', '2', '2', 'No', '1972-11-13 16:04:48', '1972-11-13 16:04:48', 0),
(287, '2', '2', '2', 'No', '1972-11-28 16:04:48', '1972-11-28 16:04:48', 0),
(288, '2', '2', '2', 'No', '1972-12-13 16:04:48', '1972-12-13 16:04:48', 0),
(289, '2', '2', '2', 'No', '1972-12-28 16:04:48', '1972-12-28 16:04:48', 0),
(290, '2', '2', '2', 'No', '1973-01-12 16:04:48', '1973-01-12 16:04:48', 0),
(291, '2', '2', '2', 'No', '1973-01-27 16:04:48', '1973-01-27 16:04:48', 0),
(292, '2', '2', '2', 'No', '1973-02-12 16:04:48', '1973-02-12 16:04:48', 0),
(293, '2', '2', '2', 'No', '1973-02-27 16:04:48', '1973-02-27 16:04:48', 0),
(294, '2', '2', '2', 'No', '1973-03-14 16:04:48', '1973-03-14 16:04:48', 0),
(295, '2', '2', '2', 'No', '1973-03-29 16:04:48', '1973-03-29 16:04:48', 0),
(296, '2', '2', '2', 'No', '1973-04-13 16:04:48', '1973-04-13 16:04:48', 0),
(297, '2', '2', '2', 'No', '1973-04-28 16:04:48', '1973-04-28 16:04:48', 0),
(298, '2', '2', '2', 'No', '1973-05-14 16:04:48', '1973-05-14 16:04:48', 0),
(299, '2', '2', '2', 'No', '1973-05-29 16:04:48', '1973-05-29 16:04:48', 0),
(300, '2', '2', '2', 'No', '1973-06-13 16:04:48', '1973-06-13 16:04:48', 0),
(301, '2', '2', '2', 'No', '1973-06-28 16:04:48', '1973-06-28 16:04:48', 0),
(302, '2', '2', '2', 'No', '1973-07-13 16:04:48', '1973-07-13 16:04:48', 0),
(303, '2', '2', '2', 'No', '1973-07-28 16:04:48', '1973-07-28 16:04:48', 0),
(304, '2', '2', '2', 'No', '1973-08-13 16:04:48', '1973-08-13 16:04:48', 0),
(305, '2', '2', '2', 'No', '1973-08-28 16:04:48', '1973-08-28 16:04:48', 0),
(306, '2', '2', '2', 'No', '1973-09-12 16:04:48', '1973-09-12 16:04:48', 0),
(307, '2', '2', '2', 'No', '1973-09-27 16:04:48', '1973-09-27 16:04:48', 0),
(308, '2', '2', '2', 'No', '1973-10-12 16:04:48', '1973-10-12 16:04:48', 0),
(309, '2', '2', '2', 'No', '1973-10-27 16:04:48', '1973-10-27 16:04:48', 0),
(310, '2', '2', '2', 'No', '1973-11-12 16:04:48', '1973-11-12 16:04:48', 0),
(311, '2', '2', '2', 'No', '1973-11-27 16:04:48', '1973-11-27 16:04:48', 0),
(312, '2', '2', '2', 'No', '1973-12-12 16:04:48', '1973-12-12 16:04:48', 0),
(313, '2', '2', '2', 'No', '1973-12-27 16:04:48', '1973-12-27 16:04:48', 0),
(314, '2', '2', '2', 'No', '1974-01-11 16:04:48', '1974-01-11 16:04:48', 0),
(315, '2', '2', '2', 'No', '1974-01-26 16:04:48', '1974-01-26 16:04:48', 0),
(316, '2', '2', '2', 'No', '1974-02-11 16:04:48', '1974-02-11 16:04:48', 0),
(317, '2', '2', '2', 'No', '1974-02-26 16:04:48', '1974-02-26 16:04:48', 0),
(318, '2', '2', '2', 'No', '1974-03-13 16:04:48', '1974-03-13 16:04:48', 0),
(319, '2', '2', '2', 'No', '1974-03-28 16:04:48', '1974-03-28 16:04:48', 0),
(320, '2', '2', '2', 'No', '1974-04-12 16:04:48', '1974-04-12 16:04:48', 0),
(321, '2', '2', '2', 'No', '1974-04-27 16:04:48', '1974-04-27 16:04:48', 0),
(322, '2', '2', '2', 'No', '1974-05-13 16:04:48', '1974-05-13 16:04:48', 0),
(323, '2', '2', '2', 'No', '1974-05-28 16:04:48', '1974-05-28 16:04:48', 0),
(324, '2', '2', '2', 'No', '1974-06-12 16:04:48', '1974-06-12 16:04:48', 0),
(325, '2', '2', '2', 'No', '1974-06-27 16:04:48', '1974-06-27 16:04:48', 0),
(326, '2', '2', '2', 'No', '1974-07-12 16:04:48', '1974-07-12 16:04:48', 0),
(327, '2', '2', '2', 'No', '1974-07-27 16:04:48', '1974-07-27 16:04:48', 0),
(328, '2', '2', '2', 'No', '1974-08-12 16:04:48', '1974-08-12 16:04:48', 0),
(329, '2', '2', '2', 'No', '1974-08-27 16:04:48', '1974-08-27 16:04:48', 0),
(330, '2', '2', '2', 'No', '1974-09-11 16:04:48', '1974-09-11 16:04:48', 0),
(331, '2', '2', '2', 'No', '1974-09-26 16:04:48', '1974-09-26 16:04:48', 0),
(332, '2', '2', '2', 'No', '1974-10-11 16:04:48', '1974-10-11 16:04:48', 0),
(333, '2', '2', '2', 'No', '1974-10-26 16:04:48', '1974-10-26 16:04:48', 0),
(334, '2', '2', '2', 'No', '1974-11-11 16:04:48', '1974-11-11 16:04:48', 0),
(335, '2', '2', '2', 'No', '1974-11-26 16:04:48', '1974-11-26 16:04:48', 0),
(336, '2', '2', '2', 'No', '1974-12-11 16:04:48', '1974-12-11 16:04:48', 0),
(337, '2', '2', '2', 'No', '1974-12-26 16:04:48', '1974-12-26 16:04:48', 0),
(338, '2', '2', '2', 'No', '1975-01-10 16:04:48', '1975-01-10 16:04:48', 0),
(339, '2', '2', '2', 'No', '1975-01-25 16:04:48', '1975-01-25 16:04:48', 0),
(340, '2', '2', '2', 'No', '1975-02-10 16:04:48', '1975-02-10 16:04:48', 0),
(341, '2', '2', '2', 'No', '1975-02-25 16:04:48', '1975-02-25 16:04:48', 0),
(342, '2', '2', '2', 'No', '1975-03-12 16:04:48', '1975-03-12 16:04:48', 0),
(343, '2', '2', '2', 'No', '1975-03-27 16:04:48', '1975-03-27 16:04:48', 0),
(344, '2', '2', '2', 'No', '1975-04-11 16:04:48', '1975-04-11 16:04:48', 0),
(345, '2', '2', '2', 'No', '1975-04-26 16:04:48', '1975-04-26 16:04:48', 0),
(346, '2', '2', '2', 'No', '1975-05-12 16:04:48', '1975-05-12 16:04:48', 0),
(347, '2', '2', '2', 'No', '1975-05-27 16:04:48', '1975-05-27 16:04:48', 0),
(348, '2', '2', '2', 'No', '1975-06-11 16:04:48', '1975-06-11 16:04:48', 0),
(349, '2', '2', '2', 'No', '1975-06-26 16:04:48', '1975-06-26 16:04:48', 0),
(350, '2', '2', '2', 'No', '1975-07-11 16:04:48', '1975-07-11 16:04:48', 0),
(351, '2', '2', '2', 'No', '1975-07-26 16:04:48', '1975-07-26 16:04:48', 0),
(352, '2', '2', '2', 'No', '1975-08-11 16:04:48', '1975-08-11 16:04:48', 0),
(353, '2', '2', '2', 'No', '1975-08-26 16:04:48', '1975-08-26 16:04:48', 0),
(354, '2', '2', '2', 'No', '1975-09-10 16:04:48', '1975-09-10 16:04:48', 0),
(355, '2', '2', '2', 'No', '1975-09-25 16:04:48', '1975-09-25 16:04:48', 0),
(356, '2', '2', '2', 'No', '1975-10-10 16:04:48', '1975-10-10 16:04:48', 0),
(357, '2', '2', '2', 'No', '1975-10-25 16:04:48', '1975-10-25 16:04:48', 0),
(358, '2', '2', '2', 'No', '1975-11-10 16:04:48', '1975-11-10 16:04:48', 0),
(359, '2', '2', '2', 'No', '1975-11-25 16:04:48', '1975-11-25 16:04:48', 0),
(360, '2', '2', '2', 'No', '1975-12-10 16:04:48', '1975-12-10 16:04:48', 0),
(361, '2', '2', '2', 'No', '1975-12-25 16:04:48', '1975-12-25 16:04:48', 0),
(362, '2', '2', '2', 'No', '1976-01-09 16:04:48', '1976-01-09 16:04:48', 0),
(363, '2', '2', '2', 'No', '1976-01-24 16:04:48', '1976-01-24 16:04:48', 0),
(364, '2', '2', '2', 'No', '1976-02-09 16:04:48', '1976-02-09 16:04:48', 0),
(365, '2', '2', '2', 'No', '1976-02-24 16:04:48', '1976-02-24 16:04:48', 0),
(366, '2', '2', '2', 'No', '1976-03-10 16:04:48', '1976-03-10 16:04:48', 0),
(367, '2', '2', '2', 'No', '1976-03-25 16:04:48', '1976-03-25 16:04:48', 0),
(368, '2', '2', '2', 'No', '1976-04-09 16:04:48', '1976-04-09 16:04:48', 0),
(369, '2', '2', '2', 'No', '1976-04-24 16:04:48', '1976-04-24 16:04:48', 0),
(370, '2', '2', '2', 'No', '1976-05-10 16:04:48', '1976-05-10 16:04:48', 0),
(371, '2', '2', '2', 'No', '1976-05-25 16:04:48', '1976-05-25 16:04:48', 0),
(372, '2', '2', '2', 'No', '1976-06-09 16:04:48', '1976-06-09 16:04:48', 0),
(373, '2', '2', '2', 'No', '1976-06-24 16:04:48', '1976-06-24 16:04:48', 0),
(374, '2', '2', '2', 'No', '1976-07-09 16:04:48', '1976-07-09 16:04:48', 0),
(375, '2', '2', '2', 'No', '1976-07-24 16:04:48', '1976-07-24 16:04:48', 0),
(376, '2', '2', '2', 'No', '1976-08-09 16:04:48', '1976-08-09 16:04:48', 0),
(377, '2', '2', '2', 'No', '1976-08-24 16:04:48', '1976-08-24 16:04:48', 0),
(378, '2', '2', '2', 'No', '1976-09-08 16:04:48', '1976-09-08 16:04:48', 0),
(379, '2', '2', '2', 'No', '1976-09-23 16:04:48', '1976-09-23 16:04:48', 0),
(380, '2', '2', '2', 'No', '1976-10-08 16:04:48', '1976-10-08 16:04:48', 0),
(381, '2', '2', '2', 'No', '1976-10-23 16:04:48', '1976-10-23 16:04:48', 0),
(382, '2', '2', '2', 'No', '1976-11-08 16:04:48', '1976-11-08 16:04:48', 0),
(383, '2', '2', '2', 'No', '1976-11-23 16:04:48', '1976-11-23 16:04:48', 0),
(384, '2', '2', '2', 'No', '1976-12-08 16:04:48', '1976-12-08 16:04:48', 0),
(385, '2', '2', '2', 'No', '1976-12-23 16:04:48', '1976-12-23 16:04:48', 0),
(386, '2', '2', '2', 'No', '1977-01-07 16:04:48', '1977-01-07 16:04:48', 0),
(387, '2', '2', '2', 'No', '1977-01-22 16:04:48', '1977-01-22 16:04:48', 0),
(388, '2', '2', '2', 'No', '1977-02-07 16:04:48', '1977-02-07 16:04:48', 0),
(389, '2', '2', '2', 'No', '1977-02-22 16:04:48', '1977-02-22 16:04:48', 0),
(390, '2', '2', '2', 'No', '1977-03-09 16:04:48', '1977-03-09 16:04:48', 0),
(391, '2', '2', '2', 'No', '1977-03-24 16:04:48', '1977-03-24 16:04:48', 0),
(392, '2', '2', '2', 'No', '1977-04-08 16:04:48', '1977-04-08 16:04:48', 0),
(393, '2', '2', '2', 'No', '1977-04-23 16:04:48', '1977-04-23 16:04:48', 0),
(394, '2', '2', '2', 'No', '1977-05-09 16:04:48', '1977-05-09 16:04:48', 0),
(395, '2', '2', '2', 'No', '1977-05-24 16:04:48', '1977-05-24 16:04:48', 0),
(396, '2', '2', '2', 'No', '1977-06-08 16:04:48', '1977-06-08 16:04:48', 0),
(397, '2', '2', '2', 'No', '1977-06-23 16:04:48', '1977-06-23 16:04:48', 0),
(398, '2', '2', '2', 'No', '1977-07-08 16:04:48', '1977-07-08 16:04:48', 0),
(399, '2', '2', '2', 'No', '1977-07-23 16:04:48', '1977-07-23 16:04:48', 0),
(400, '2', '2', '2', 'No', '1977-08-08 16:04:48', '1977-08-08 16:04:48', 0),
(401, '2', '2', '2', 'No', '1977-08-23 16:04:48', '1977-08-23 16:04:48', 0),
(402, '2', '2', '2', 'No', '1977-09-07 16:04:48', '1977-09-07 16:04:48', 0),
(403, '2', '2', '2', 'No', '1977-09-22 16:04:48', '1977-09-22 16:04:48', 0),
(404, '2', '2', '2', 'No', '1977-10-07 16:04:48', '1977-10-07 16:04:48', 0),
(405, '2', '2', '2', 'No', '1977-10-22 16:04:48', '1977-10-22 16:04:48', 0),
(406, '2', '2', '2', 'No', '1977-11-07 16:04:48', '1977-11-07 16:04:48', 0),
(407, '2', '2', '2', 'No', '1977-11-22 16:04:48', '1977-11-22 16:04:48', 0),
(408, '2', '2', '2', 'No', '1977-12-07 16:04:48', '1977-12-07 16:04:48', 0),
(409, '2', '2', '2', 'No', '1977-12-22 16:04:48', '1977-12-22 16:04:48', 0),
(410, '2', '2', '2', 'No', '1978-01-06 16:04:48', '1978-01-06 16:04:48', 0),
(411, '2', '2', '2', 'No', '1978-01-21 16:04:48', '1978-01-21 16:04:48', 0),
(412, '2', '2', '2', 'No', '1978-02-06 16:04:48', '1978-02-06 16:04:48', 0),
(413, '2', '2', '2', 'No', '1978-02-21 16:04:48', '1978-02-21 16:04:48', 0),
(414, '2', '2', '2', 'No', '1978-03-08 16:04:48', '1978-03-08 16:04:48', 0),
(415, '2', '2', '2', 'No', '1978-03-23 16:04:48', '1978-03-23 16:04:48', 0),
(416, '2', '2', '2', 'No', '1978-04-07 16:04:48', '1978-04-07 16:04:48', 0),
(417, '2', '2', '2', 'No', '1978-04-22 16:04:48', '1978-04-22 16:04:48', 0),
(418, '2', '2', '2', 'No', '1978-05-08 16:04:48', '1978-05-08 16:04:48', 0),
(419, '2', '2', '2', 'No', '1978-05-23 16:04:48', '1978-05-23 16:04:48', 0),
(420, '2', '2', '2', 'No', '1978-06-07 16:04:48', '1978-06-07 16:04:48', 0),
(421, '2', '2', '2', 'No', '1978-06-22 16:04:48', '1978-06-22 16:04:48', 0),
(422, '2', '2', '2', 'No', '1978-07-07 16:04:48', '1978-07-07 16:04:48', 0),
(423, '2', '2', '2', 'No', '1978-07-22 16:04:48', '1978-07-22 16:04:48', 0),
(424, '2', '2', '2', 'No', '1978-08-07 16:04:48', '1978-08-07 16:04:48', 0),
(425, '2', '2', '2', 'No', '1978-08-22 16:04:48', '1978-08-22 16:04:48', 0),
(426, '2', '2', '2', 'No', '1978-09-06 16:04:48', '1978-09-06 16:04:48', 0),
(427, '2', '2', '2', 'No', '1978-09-21 16:04:48', '1978-09-21 16:04:48', 0),
(428, '2', '2', '2', 'No', '1978-10-06 16:04:48', '1978-10-06 16:04:48', 0),
(429, '2', '2', '2', 'No', '1978-10-21 16:04:48', '1978-10-21 16:04:48', 0),
(430, '2', '2', '2', 'No', '1978-11-06 16:04:48', '1978-11-06 16:04:48', 0),
(431, '2', '2', '2', 'No', '1978-11-21 16:04:48', '1978-11-21 16:04:48', 0),
(432, '2', '2', '2', 'No', '1978-12-06 16:04:48', '1978-12-06 16:04:48', 0),
(433, '2', '2', '2', 'No', '1978-12-21 16:04:48', '1978-12-21 16:04:48', 0),
(434, '2', '2', '2', 'No', '1979-01-05 16:04:48', '1979-01-05 16:04:48', 0),
(435, '2', '2', '2', 'No', '1979-01-20 16:04:48', '1979-01-20 16:04:48', 0),
(436, '2', '2', '2', 'No', '1979-02-05 16:04:48', '1979-02-05 16:04:48', 0),
(437, '2', '2', '2', 'No', '1979-02-20 16:04:48', '1979-02-20 16:04:48', 0),
(438, '2', '2', '2', 'No', '1979-03-07 16:04:48', '1979-03-07 16:04:48', 0),
(439, '2', '2', '2', 'No', '1979-03-22 16:04:48', '1979-03-22 16:04:48', 0),
(440, '2', '2', '2', 'No', '1979-04-06 16:04:48', '1979-04-06 16:04:48', 0),
(441, '2', '2', '2', 'No', '1979-04-21 16:04:48', '1979-04-21 16:04:48', 0),
(442, '2', '2', '2', 'No', '1979-05-07 16:04:48', '1979-05-07 16:04:48', 0),
(443, '2', '2', '2', 'No', '1979-05-22 16:04:48', '1979-05-22 16:04:48', 0),
(444, '2', '2', '2', 'No', '1979-06-06 16:04:48', '1979-06-06 16:04:48', 0),
(445, '2', '2', '2', 'No', '1979-06-21 16:04:48', '1979-06-21 16:04:48', 0),
(446, '2', '2', '2', 'No', '1979-07-06 16:04:48', '1979-07-06 16:04:48', 0),
(447, '2', '2', '2', 'No', '1979-07-21 16:04:48', '1979-07-21 16:04:48', 0),
(448, '2', '2', '2', 'No', '1979-08-06 16:04:48', '1979-08-06 16:04:48', 0),
(449, '2', '2', '2', 'No', '1979-08-21 16:04:48', '1979-08-21 16:04:48', 0),
(450, '2', '2', '2', 'No', '1979-09-05 16:04:48', '1979-09-05 16:04:48', 0),
(451, '2', '2', '2', 'No', '1979-09-20 16:04:48', '1979-09-20 16:04:48', 0),
(452, '2', '2', '2', 'No', '1979-10-05 16:04:48', '1979-10-05 16:04:48', 0),
(453, '2', '2', '2', 'No', '1979-10-20 16:04:48', '1979-10-20 16:04:48', 0),
(454, '2', '2', '2', 'No', '1979-11-05 16:04:48', '1979-11-05 16:04:48', 0),
(455, '2', '2', '2', 'No', '1979-11-20 16:04:48', '1979-11-20 16:04:48', 0),
(456, '2', '2', '2', 'No', '1979-12-05 16:04:48', '1979-12-05 16:04:48', 0),
(457, '2', '2', '2', 'No', '1979-12-20 16:04:48', '1979-12-20 16:04:48', 0),
(458, '2', '2', '2', 'No', '1980-01-04 16:04:48', '1980-01-04 16:04:48', 0),
(459, '2', '2', '2', 'No', '1980-01-19 16:04:48', '1980-01-19 16:04:48', 0),
(460, '2', '2', '2', 'No', '1980-02-04 16:04:48', '1980-02-04 16:04:48', 0),
(461, '2', '2', '2', 'No', '1980-02-19 16:04:48', '1980-02-19 16:04:48', 0),
(462, '2', '2', '2', 'No', '1980-03-05 16:04:48', '1980-03-05 16:04:48', 0),
(463, '2', '2', '2', 'No', '1980-03-20 16:04:48', '1980-03-20 16:04:48', 0),
(464, '2', '2', '2', 'No', '1980-04-04 16:04:48', '1980-04-04 16:04:48', 0),
(465, '2', '2', '2', 'No', '1980-04-19 16:04:48', '1980-04-19 16:04:48', 0),
(466, '2', '2', '2', 'No', '1980-05-05 16:04:48', '1980-05-05 16:04:48', 0),
(467, '2', '2', '2', 'No', '1980-05-20 16:04:48', '1980-05-20 16:04:48', 0),
(468, '2', '2', '2', 'No', '1980-06-04 16:04:48', '1980-06-04 16:04:48', 0),
(469, '2', '2', '2', 'No', '1980-06-19 16:04:48', '1980-06-19 16:04:48', 0),
(470, '2', '2', '2', 'No', '1980-07-04 16:04:48', '1980-07-04 16:04:48', 0),
(471, '2', '2', '2', 'No', '1980-07-19 16:04:48', '1980-07-19 16:04:48', 0),
(472, '2', '2', '2', 'No', '1980-08-04 16:04:48', '1980-08-04 16:04:48', 0),
(473, '2', '2', '2', 'No', '1980-08-19 16:04:48', '1980-08-19 16:04:48', 0),
(474, '2', '2', '2', 'No', '1980-09-03 16:04:48', '1980-09-03 16:04:48', 0),
(475, '2', '2', '2', 'No', '1980-09-18 16:04:48', '1980-09-18 16:04:48', 0),
(476, '2', '2', '2', 'No', '1980-10-03 16:04:48', '1980-10-03 16:04:48', 0),
(477, '2', '2', '2', 'No', '1980-10-18 16:04:48', '1980-10-18 16:04:48', 0),
(478, '2', '2', '2', 'No', '1980-11-03 16:04:48', '1980-11-03 16:04:48', 0),
(479, '2', '2', '2', 'No', '1980-11-18 16:04:48', '1980-11-18 16:04:48', 0),
(480, '2', '2', '2', 'No', '1980-12-03 16:04:48', '1980-12-03 16:04:48', 0),
(481, '2', '2', '2', 'No', '1980-12-18 16:04:48', '1980-12-18 16:04:48', 0),
(482, '2', '2', '2', 'No', '1981-01-02 16:04:48', '1981-01-02 16:04:48', 0),
(483, '2', '2', '2', 'No', '1981-01-17 16:04:48', '1981-01-17 16:04:48', 0),
(484, '2', '2', '2', 'No', '1981-02-02 16:04:48', '1981-02-02 16:04:48', 0),
(485, '2', '2', '2', 'No', '1981-02-17 16:04:48', '1981-02-17 16:04:48', 0),
(486, '2', '2', '2', 'No', '1981-03-04 16:04:48', '1981-03-04 16:04:48', 0),
(487, '2', '2', '2', 'No', '1981-03-19 16:04:48', '1981-03-19 16:04:48', 0),
(488, '2', '2', '2', 'No', '1981-04-03 16:04:48', '1981-04-03 16:04:48', 0),
(489, '2', '2', '2', 'No', '1981-04-18 16:04:48', '1981-04-18 16:04:48', 0),
(490, '2', '2', '2', 'No', '1981-05-04 16:04:48', '1981-05-04 16:04:48', 0),
(491, '2', '2', '2', 'No', '1981-05-19 16:04:48', '1981-05-19 16:04:48', 0),
(492, '2', '2', '2', 'No', '1981-06-03 16:04:48', '1981-06-03 16:04:48', 0),
(493, '2', '2', '2', 'No', '1981-06-18 16:04:48', '1981-06-18 16:04:48', 0),
(494, '2', '2', '2', 'No', '1981-07-03 16:04:48', '1981-07-03 16:04:48', 0),
(495, '2', '2', '2', 'No', '1981-07-18 16:04:48', '1981-07-18 16:04:48', 0),
(496, '2', '2', '2', 'No', '1981-08-03 16:04:48', '1981-08-03 16:04:48', 0),
(497, '2', '2', '2', 'No', '1981-08-18 16:04:48', '1981-08-18 16:04:48', 0),
(498, '2', '2', '2', 'No', '1981-09-02 16:04:48', '1981-09-02 16:04:48', 0),
(499, '2', '2', '2', 'No', '1981-09-17 16:04:48', '1981-09-17 16:04:48', 0),
(500, '2', '2', '2', 'No', '1981-10-02 16:04:48', '1981-10-02 16:04:48', 0),
(501, '2', '2', '2', 'No', '1981-10-17 16:04:48', '1981-10-17 16:04:48', 0),
(502, '2', '2', '2', 'No', '1981-11-02 16:04:48', '1981-11-02 16:04:48', 0),
(503, '2', '2', '2', 'No', '1981-11-17 16:04:48', '1981-11-17 16:04:48', 0),
(504, '2', '2', '2', 'No', '1981-12-02 16:04:48', '1981-12-02 16:04:48', 0),
(505, '2', '2', '2', 'No', '1981-12-17 16:04:48', '1981-12-17 16:04:48', 0),
(506, '2', '2', '2', 'No', '1982-01-01 16:04:48', '1982-01-01 16:04:48', 0),
(507, '2', '2', '2', 'No', '1982-01-16 16:04:48', '1982-01-16 16:04:48', 0),
(508, '2', '2', '2', 'No', '1982-02-01 16:04:48', '1982-02-01 16:04:48', 0),
(509, '2', '2', '2', 'No', '1982-02-16 16:04:48', '1982-02-16 16:04:48', 0),
(510, '2', '2', '2', 'No', '1982-03-03 16:04:48', '1982-03-03 16:04:48', 0),
(511, '2', '2', '2', 'No', '1982-03-18 16:04:48', '1982-03-18 16:04:48', 0),
(512, '2', '2', '2', 'No', '1982-04-02 16:04:48', '1982-04-02 16:04:48', 0),
(513, '2', '2', '2', 'No', '1982-04-17 16:04:48', '1982-04-17 16:04:48', 0),
(514, '2', '2', '2', 'No', '1982-05-03 16:04:48', '1982-05-03 16:04:48', 0),
(515, '2', '2', '2', 'No', '1982-05-18 16:04:48', '1982-05-18 16:04:48', 0),
(516, '2', '2', '2', 'No', '1982-06-02 16:04:48', '1982-06-02 16:04:48', 0),
(517, '2', '2', '2', 'No', '1982-06-17 16:04:48', '1982-06-17 16:04:48', 0),
(518, '2', '2', '2', 'No', '1982-07-02 16:04:48', '1982-07-02 16:04:48', 0),
(519, '2', '2', '2', 'No', '1982-07-17 16:04:48', '1982-07-17 16:04:48', 0),
(520, '2', '2', '2', 'No', '1982-08-02 16:04:48', '1982-08-02 16:04:48', 0),
(521, '2', '2', '2', 'No', '1982-08-17 16:04:48', '1982-08-17 16:04:48', 0),
(522, '2', '2', '2', 'No', '1982-09-01 16:04:48', '1982-09-01 16:04:48', 0),
(523, '2', '2', '2', 'No', '1982-09-16 16:04:48', '1982-09-16 16:04:48', 0),
(524, '2', '2', '2', 'No', '1982-10-01 16:04:48', '1982-10-01 16:04:48', 0),
(525, '2', '2', '2', 'No', '1982-10-16 16:04:48', '1982-10-16 16:04:48', 0),
(526, '2', '2', '2', 'No', '1982-11-01 16:04:48', '1982-11-01 16:04:48', 0),
(527, '2', '2', '2', 'No', '1982-11-16 16:04:48', '1982-11-16 16:04:48', 0),
(528, '2', '2', '2', 'No', '1982-12-01 16:04:48', '1982-12-01 16:04:48', 0),
(529, '2', '2', '2', 'No', '1982-12-16 16:04:48', '1982-12-16 16:04:48', 0),
(530, '2', '2', '2', 'No', '1982-12-31 16:04:48', '1982-12-31 16:04:48', 0),
(531, '2', '2', '2', 'No', '1983-01-15 16:04:48', '1983-01-15 16:04:48', 0),
(532, '2', '2', '2', 'No', '1983-01-31 16:04:48', '1983-01-31 16:04:48', 0),
(533, '2', '2', '2', 'No', '1983-02-15 16:04:48', '1983-02-15 16:04:48', 0),
(534, '2', '2', '2', 'No', '1983-03-02 16:04:48', '1983-03-02 16:04:48', 0),
(535, '2', '2', '2', 'No', '1983-03-17 16:04:48', '1983-03-17 16:04:48', 0),
(536, '2', '2', '2', 'No', '1983-04-01 16:04:48', '1983-04-01 16:04:48', 0),
(537, '2', '2', '2', 'No', '1983-04-16 16:04:48', '1983-04-16 16:04:48', 0),
(538, '2', '2', '2', 'No', '1983-05-02 16:04:48', '1983-05-02 16:04:48', 0),
(539, '2', '2', '2', 'No', '1983-05-17 16:04:48', '1983-05-17 16:04:48', 0),
(540, '2', '2', '2', 'No', '1983-06-01 16:04:48', '1983-06-01 16:04:48', 0),
(541, '2', '2', '2', 'No', '1983-06-16 16:04:48', '1983-06-16 16:04:48', 0),
(542, '2', '2', '2', 'No', '1983-07-01 16:04:48', '1983-07-01 16:04:48', 0),
(543, '2', '2', '2', 'No', '1983-07-16 16:04:48', '1983-07-16 16:04:48', 0),
(544, '2', '2', '2', 'No', '1983-08-01 16:04:48', '1983-08-01 16:04:48', 0),
(545, '2', '2', '2', 'No', '1983-08-16 16:04:48', '1983-08-16 16:04:48', 0),
(546, '2', '2', '2', 'No', '1983-08-31 16:04:48', '1983-08-31 16:04:48', 0),
(547, '2', '2', '2', 'No', '1983-09-15 16:04:48', '1983-09-15 16:04:48', 0),
(548, '2', '2', '2', 'No', '1983-09-30 16:04:48', '1983-09-30 16:04:48', 0),
(549, '2', '2', '2', 'No', '1983-10-15 16:04:48', '1983-10-15 16:04:48', 0),
(550, '2', '2', '2', 'No', '1983-10-31 16:04:48', '1983-10-31 16:04:48', 0),
(551, '2', '2', '2', 'No', '1983-11-15 16:04:48', '1983-11-15 16:04:48', 0),
(552, '2', '2', '2', 'No', '1983-11-30 16:04:48', '1983-11-30 16:04:48', 0),
(553, '2', '2', '2', 'No', '1983-12-15 16:04:48', '1983-12-15 16:04:48', 0),
(554, '2', '2', '2', 'No', '1983-12-30 16:04:48', '1983-12-30 16:04:48', 0),
(555, '2', '2', '2', 'No', '1984-01-14 16:04:48', '1984-01-14 16:04:48', 0),
(556, '2', '2', '2', 'No', '1984-01-30 16:04:48', '1984-01-30 16:04:48', 0),
(557, '2', '2', '2', 'No', '1984-02-14 16:04:48', '1984-02-14 16:04:48', 0),
(558, '2', '2', '2', 'No', '1984-02-29 16:04:48', '1984-02-29 16:04:48', 0),
(559, '2', '2', '2', 'No', '1984-03-15 16:04:48', '1984-03-15 16:04:48', 0),
(560, '2', '2', '2', 'No', '1984-03-30 16:04:48', '1984-03-30 16:04:48', 0),
(561, '2', '2', '2', 'No', '1984-04-14 16:04:48', '1984-04-14 16:04:48', 0),
(562, '2', '2', '2', 'No', '1984-04-30 16:04:48', '1984-04-30 16:04:48', 0),
(563, '2', '2', '2', 'No', '1984-05-15 16:04:48', '1984-05-15 16:04:48', 0),
(564, '2', '2', '2', 'No', '1984-05-30 16:04:48', '1984-05-30 16:04:48', 0),
(565, '2', '2', '2', 'No', '1984-06-14 16:04:48', '1984-06-14 16:04:48', 0),
(566, '2', '2', '2', 'No', '1984-06-29 16:04:48', '1984-06-29 16:04:48', 0),
(567, '2', '2', '2', 'No', '1984-07-14 16:04:48', '1984-07-14 16:04:48', 0),
(568, '2', '2', '2', 'No', '1984-07-30 16:04:48', '1984-07-30 16:04:48', 0),
(569, '2', '2', '2', 'No', '1984-08-14 16:04:48', '1984-08-14 16:04:48', 0),
(570, '2', '2', '2', 'No', '1984-08-29 16:04:48', '1984-08-29 16:04:48', 0),
(571, '2', '2', '2', 'No', '1984-09-13 16:04:48', '1984-09-13 16:04:48', 0),
(572, '2', '2', '2', 'No', '1984-09-28 16:04:48', '1984-09-28 16:04:48', 0),
(573, '2', '2', '2', 'No', '1984-10-13 16:04:48', '1984-10-13 16:04:48', 0),
(574, '2', '2', '2', 'No', '1984-10-29 16:04:48', '1984-10-29 16:04:48', 0),
(575, '2', '2', '2', 'No', '1984-11-13 16:04:48', '1984-11-13 16:04:48', 0),
(576, '2', '2', '2', 'No', '1984-11-28 16:04:48', '1984-11-28 16:04:48', 0),
(577, '2', '2', '2', 'No', '1984-12-13 16:04:48', '1984-12-13 16:04:48', 0),
(578, '2', '2', '2', 'No', '1984-12-28 16:04:48', '1984-12-28 16:04:48', 0),
(579, '2', '2', '2', 'No', '1985-01-12 16:04:48', '1985-01-12 16:04:48', 0),
(580, '2', '2', '2', 'No', '1985-01-28 16:04:48', '1985-01-28 16:04:48', 0),
(581, '2', '2', '2', 'No', '1985-02-12 16:04:48', '1985-02-12 16:04:48', 0),
(582, '2', '2', '2', 'No', '1985-02-27 16:04:48', '1985-02-27 16:04:48', 0),
(583, '2', '2', '2', 'No', '1985-03-14 16:04:48', '1985-03-14 16:04:48', 0),
(584, '2', '2', '2', 'No', '1985-03-29 16:04:48', '1985-03-29 16:04:48', 0),
(585, '2', '2', '2', 'No', '1985-04-13 16:04:48', '1985-04-13 16:04:48', 0),
(586, '2', '2', '2', 'No', '1985-04-29 16:04:48', '1985-04-29 16:04:48', 0),
(587, '2', '2', '2', 'No', '1985-05-14 16:04:48', '1985-05-14 16:04:48', 0),
(588, '2', '2', '2', 'No', '1985-05-29 16:04:48', '1985-05-29 16:04:48', 0),
(589, '2', '2', '2', 'No', '1985-06-13 16:04:48', '1985-06-13 16:04:48', 0),
(590, '2', '2', '2', 'No', '1985-06-28 16:04:48', '1985-06-28 16:04:48', 0),
(591, '2', '2', '2', 'No', '1985-07-13 16:04:48', '1985-07-13 16:04:48', 0),
(592, '2', '2', '2', 'No', '1985-07-29 16:04:48', '1985-07-29 16:04:48', 0),
(593, '2', '2', '2', 'No', '1985-08-13 16:04:48', '1985-08-13 16:04:48', 0),
(594, '2', '2', '2', 'No', '1985-08-28 16:04:48', '1985-08-28 16:04:48', 0),
(595, '2', '2', '2', 'No', '1985-09-12 16:04:48', '1985-09-12 16:04:48', 0),
(596, '2', '2', '2', 'No', '1985-09-27 16:04:48', '1985-09-27 16:04:48', 0),
(597, '2', '2', '2', 'No', '1985-10-12 16:04:48', '1985-10-12 16:04:48', 0),
(598, '2', '2', '2', 'No', '1985-10-28 16:04:48', '1985-10-28 16:04:48', 0),
(599, '2', '2', '2', 'No', '1985-11-12 16:04:48', '1985-11-12 16:04:48', 0),
(600, '2', '2', '2', 'No', '1985-11-27 16:04:48', '1985-11-27 16:04:48', 0),
(601, '2', '2', '2', 'No', '1985-12-12 16:04:48', '1985-12-12 16:04:48', 0),
(602, '2', '2', '2', 'No', '1985-12-27 16:04:48', '1985-12-27 16:04:48', 0),
(603, '2', '2', '2', 'No', '1986-01-11 16:04:48', '1986-01-11 16:04:48', 0),
(604, '2', '2', '2', 'No', '1986-01-27 16:04:48', '1986-01-27 16:04:48', 0),
(605, '2', '2', '2', 'No', '1986-02-11 16:04:48', '1986-02-11 16:04:48', 0),
(606, '2', '2', '2', 'No', '1986-02-26 16:04:48', '1986-02-26 16:04:48', 0),
(607, '2', '2', '2', 'No', '1986-03-13 16:04:48', '1986-03-13 16:04:48', 0),
(608, '2', '2', '2', 'No', '1986-03-28 16:04:48', '1986-03-28 16:04:48', 0),
(609, '2', '2', '2', 'No', '1986-04-12 16:04:48', '1986-04-12 16:04:48', 0),
(610, '2', '2', '2', 'No', '1986-04-28 16:04:48', '1986-04-28 16:04:48', 0),
(611, '2', '2', '2', 'No', '1986-05-13 16:04:48', '1986-05-13 16:04:48', 0),
(612, '2', '2', '2', 'No', '1986-05-28 16:04:48', '1986-05-28 16:04:48', 0),
(613, '2', '2', '2', 'No', '1986-06-12 16:04:48', '1986-06-12 16:04:48', 0),
(614, '2', '2', '2', 'No', '1986-06-27 16:04:48', '1986-06-27 16:04:48', 0),
(615, '2', '2', '2', 'No', '1986-07-12 16:04:48', '1986-07-12 16:04:48', 0),
(616, '2', '2', '2', 'No', '1986-07-28 16:04:48', '1986-07-28 16:04:48', 0),
(617, '2', '2', '2', 'No', '1986-08-12 16:04:48', '1986-08-12 16:04:48', 0),
(618, '2', '2', '2', 'No', '1986-08-27 16:04:48', '1986-08-27 16:04:48', 0),
(619, '2', '2', '2', 'No', '1986-09-11 16:04:48', '1986-09-11 16:04:48', 0),
(620, '2', '2', '2', 'No', '1986-09-26 16:04:48', '1986-09-26 16:04:48', 0),
(621, '2', '2', '2', 'No', '1986-10-11 16:04:48', '1986-10-11 16:04:48', 0),
(622, '2', '2', '2', 'No', '1986-10-27 16:04:48', '1986-10-27 16:04:48', 0),
(623, '2', '2', '2', 'No', '1986-11-11 16:04:48', '1986-11-11 16:04:48', 0),
(624, '2', '2', '2', 'No', '1986-11-26 16:04:48', '1986-11-26 16:04:48', 0),
(625, '2', '2', '2', 'No', '1986-12-11 16:04:48', '1986-12-11 16:04:48', 0),
(626, '2', '2', '2', 'No', '1986-12-26 16:04:48', '1986-12-26 16:04:48', 0),
(627, '2', '2', '2', 'No', '1987-01-10 16:04:48', '1987-01-10 16:04:48', 0),
(628, '2', '2', '2', 'No', '1987-01-26 16:04:48', '1987-01-26 16:04:48', 0),
(629, '2', '2', '2', 'No', '1987-02-10 16:04:48', '1987-02-10 16:04:48', 0),
(630, '2', '2', '2', 'No', '1987-02-25 16:04:48', '1987-02-25 16:04:48', 0),
(631, '2', '2', '2', 'No', '1987-03-12 16:04:48', '1987-03-12 16:04:48', 0),
(632, '2', '2', '2', 'No', '1987-03-27 16:04:48', '1987-03-27 16:04:48', 0),
(633, '2', '2', '2', 'No', '1987-04-11 16:04:48', '1987-04-11 16:04:48', 0),
(634, '2', '2', '2', 'No', '1987-04-27 16:04:48', '1987-04-27 16:04:48', 0),
(635, '2', '2', '2', 'No', '1987-05-12 16:04:48', '1987-05-12 16:04:48', 0),
(636, '2', '2', '2', 'No', '1987-05-27 16:04:48', '1987-05-27 16:04:48', 0),
(637, '2', '2', '2', 'No', '1987-06-11 16:04:48', '1987-06-11 16:04:48', 0),
(638, '2', '2', '2', 'No', '1987-06-26 16:04:48', '1987-06-26 16:04:48', 0),
(639, '2', '2', '2', 'No', '1987-07-11 16:04:48', '1987-07-11 16:04:48', 0),
(640, '2', '2', '2', 'No', '1987-07-27 16:04:48', '1987-07-27 16:04:48', 0),
(641, '2', '2', '2', 'No', '1987-08-11 16:04:48', '1987-08-11 16:04:48', 0),
(642, '2', '2', '2', 'No', '1987-08-26 16:04:48', '1987-08-26 16:04:48', 0),
(643, '2', '2', '2', 'No', '1987-09-10 16:04:48', '1987-09-10 16:04:48', 0),
(644, '2', '2', '2', 'No', '1987-09-25 16:04:48', '1987-09-25 16:04:48', 0),
(645, '2', '2', '2', 'No', '1987-10-10 16:04:48', '1987-10-10 16:04:48', 0),
(646, '2', '2', '2', 'No', '1987-10-26 16:04:48', '1987-10-26 16:04:48', 0),
(647, '2', '2', '2', 'No', '1987-11-10 16:04:48', '1987-11-10 16:04:48', 0),
(648, '2', '2', '2', 'No', '1987-11-25 16:04:48', '1987-11-25 16:04:48', 0),
(649, '2', '2', '2', 'No', '1987-12-10 16:04:48', '1987-12-10 16:04:48', 0),
(650, '2', '2', '2', 'No', '1987-12-25 16:04:48', '1987-12-25 16:04:48', 0),
(651, '2', '2', '2', 'No', '1988-01-09 16:04:48', '1988-01-09 16:04:48', 0),
(652, '2', '2', '2', 'No', '1988-01-25 16:04:48', '1988-01-25 16:04:48', 0),
(653, '2', '2', '2', 'No', '1988-02-09 16:04:48', '1988-02-09 16:04:48', 0),
(654, '2', '2', '2', 'No', '1988-02-24 16:04:48', '1988-02-24 16:04:48', 0),
(655, '2', '2', '2', 'No', '1988-03-10 16:04:48', '1988-03-10 16:04:48', 0),
(656, '2', '2', '2', 'No', '1988-03-25 16:04:48', '1988-03-25 16:04:48', 0),
(657, '2', '2', '2', 'No', '1988-04-09 16:04:48', '1988-04-09 16:04:48', 0),
(658, '2', '2', '2', 'No', '1988-04-25 16:04:48', '1988-04-25 16:04:48', 0),
(659, '2', '2', '2', 'No', '1988-05-10 16:04:48', '1988-05-10 16:04:48', 0),
(660, '2', '2', '2', 'No', '1988-05-25 16:04:48', '1988-05-25 16:04:48', 0),
(661, '2', '2', '2', 'No', '1988-06-09 16:04:48', '1988-06-09 16:04:48', 0),
(662, '2', '2', '2', 'No', '1988-06-24 16:04:48', '1988-06-24 16:04:48', 0),
(663, '2', '2', '2', 'No', '1988-07-09 16:04:48', '1988-07-09 16:04:48', 0),
(664, '2', '2', '2', 'No', '1988-07-25 16:04:48', '1988-07-25 16:04:48', 0),
(665, '2', '2', '2', 'No', '1988-08-09 16:04:48', '1988-08-09 16:04:48', 0);
INSERT INTO `krakpi_calendar_map` (`krakpi_calendar_map_id`, `krakpi_id`, `krakpi_ref_id`, `kra_category`, `calendar`, `from_date`, `to_date`, `work_status`) VALUES
(666, '2', '2', '2', 'No', '1988-08-24 16:04:48', '1988-08-24 16:04:48', 0),
(667, '2', '2', '2', 'No', '1988-09-08 16:04:48', '1988-09-08 16:04:48', 0),
(668, '2', '2', '2', 'No', '1988-09-23 16:04:48', '1988-09-23 16:04:48', 0),
(669, '2', '2', '2', 'No', '1988-10-08 16:04:48', '1988-10-08 16:04:48', 0),
(670, '2', '2', '2', 'No', '1988-10-24 16:04:48', '1988-10-24 16:04:48', 0),
(671, '2', '2', '2', 'No', '1988-11-08 16:04:48', '1988-11-08 16:04:48', 0),
(672, '2', '2', '2', 'No', '1988-11-23 16:04:48', '1988-11-23 16:04:48', 0),
(673, '2', '2', '2', 'No', '1988-12-08 16:04:48', '1988-12-08 16:04:48', 0),
(674, '2', '2', '2', 'No', '1988-12-23 16:04:48', '1988-12-23 16:04:48', 0),
(675, '2', '2', '2', 'No', '1989-01-07 16:04:48', '1989-01-07 16:04:48', 0),
(676, '2', '2', '2', 'No', '1989-01-23 16:04:48', '1989-01-23 16:04:48', 0),
(677, '2', '2', '2', 'No', '1989-02-07 16:04:48', '1989-02-07 16:04:48', 0),
(678, '2', '2', '2', 'No', '1989-02-22 16:04:48', '1989-02-22 16:04:48', 0),
(679, '2', '2', '2', 'No', '1989-03-09 16:04:48', '1989-03-09 16:04:48', 0),
(680, '2', '2', '2', 'No', '1989-03-24 16:04:48', '1989-03-24 16:04:48', 0),
(681, '2', '2', '2', 'No', '1989-04-08 16:04:48', '1989-04-08 16:04:48', 0),
(682, '2', '2', '2', 'No', '1989-04-24 16:04:48', '1989-04-24 16:04:48', 0),
(683, '2', '2', '2', 'No', '1989-05-09 16:04:48', '1989-05-09 16:04:48', 0),
(684, '2', '2', '2', 'No', '1989-05-24 16:04:48', '1989-05-24 16:04:48', 0),
(685, '2', '2', '2', 'No', '1989-06-08 16:04:48', '1989-06-08 16:04:48', 0),
(686, '2', '2', '2', 'No', '1989-06-23 16:04:48', '1989-06-23 16:04:48', 0),
(687, '2', '2', '2', 'No', '1989-07-08 16:04:48', '1989-07-08 16:04:48', 0),
(688, '2', '2', '2', 'No', '1989-07-24 16:04:48', '1989-07-24 16:04:48', 0),
(689, '2', '2', '2', 'No', '1989-08-08 16:04:48', '1989-08-08 16:04:48', 0),
(690, '2', '2', '2', 'No', '1989-08-23 16:04:48', '1989-08-23 16:04:48', 0),
(691, '2', '2', '2', 'No', '1989-09-07 16:04:48', '1989-09-07 16:04:48', 0),
(692, '2', '2', '2', 'No', '1989-09-22 16:04:48', '1989-09-22 16:04:48', 0),
(693, '2', '2', '2', 'No', '1989-10-07 16:04:48', '1989-10-07 16:04:48', 0),
(694, '2', '2', '2', 'No', '1989-10-23 16:04:48', '1989-10-23 16:04:48', 0),
(695, '2', '2', '2', 'No', '1989-11-07 16:04:48', '1989-11-07 16:04:48', 0),
(696, '2', '2', '2', 'No', '1989-11-22 16:04:48', '1989-11-22 16:04:48', 0),
(697, '2', '2', '2', 'No', '1989-12-07 16:04:48', '1989-12-07 16:04:48', 0),
(698, '2', '2', '2', 'No', '1989-12-22 16:04:48', '1989-12-22 16:04:48', 0),
(699, '2', '2', '2', 'No', '1990-01-06 16:04:48', '1990-01-06 16:04:48', 0),
(700, '2', '2', '2', 'No', '1990-01-22 16:04:48', '1990-01-22 16:04:48', 0),
(701, '2', '2', '2', 'No', '1990-02-06 16:04:48', '1990-02-06 16:04:48', 0),
(702, '2', '2', '2', 'No', '1990-02-21 16:04:48', '1990-02-21 16:04:48', 0),
(703, '2', '2', '2', 'No', '1990-03-08 16:04:48', '1990-03-08 16:04:48', 0),
(704, '2', '2', '2', 'No', '1990-03-23 16:04:48', '1990-03-23 16:04:48', 0),
(705, '2', '2', '2', 'No', '1990-04-07 16:04:48', '1990-04-07 16:04:48', 0),
(706, '2', '2', '2', 'No', '1990-04-23 16:04:48', '1990-04-23 16:04:48', 0),
(707, '2', '2', '2', 'No', '1990-05-08 16:04:48', '1990-05-08 16:04:48', 0),
(708, '2', '2', '2', 'No', '1990-05-23 16:04:48', '1990-05-23 16:04:48', 0),
(709, '2', '2', '2', 'No', '1990-06-07 16:04:48', '1990-06-07 16:04:48', 0),
(710, '2', '2', '2', 'No', '1990-06-22 16:04:48', '1990-06-22 16:04:48', 0),
(711, '2', '2', '2', 'No', '1990-07-07 16:04:48', '1990-07-07 16:04:48', 0),
(712, '2', '2', '2', 'No', '1990-07-23 16:04:48', '1990-07-23 16:04:48', 0),
(713, '2', '2', '2', 'No', '1990-08-07 16:04:48', '1990-08-07 16:04:48', 0),
(714, '2', '2', '2', 'No', '1990-08-22 16:04:48', '1990-08-22 16:04:48', 0),
(715, '2', '2', '2', 'No', '1990-09-06 16:04:48', '1990-09-06 16:04:48', 0),
(716, '2', '2', '2', 'No', '1990-09-21 16:04:48', '1990-09-21 16:04:48', 0),
(717, '2', '2', '2', 'No', '1990-10-06 16:04:48', '1990-10-06 16:04:48', 0),
(718, '2', '2', '2', 'No', '1990-10-22 16:04:48', '1990-10-22 16:04:48', 0),
(719, '2', '2', '2', 'No', '1990-11-06 16:04:48', '1990-11-06 16:04:48', 0),
(720, '2', '2', '2', 'No', '1990-11-21 16:04:48', '1990-11-21 16:04:48', 0),
(721, '2', '2', '2', 'No', '1990-12-06 16:04:48', '1990-12-06 16:04:48', 0),
(722, '2', '2', '2', 'No', '1990-12-21 16:04:48', '1990-12-21 16:04:48', 0),
(723, '2', '2', '2', 'No', '1991-01-05 16:04:48', '1991-01-05 16:04:48', 0),
(724, '2', '2', '2', 'No', '1991-01-21 16:04:48', '1991-01-21 16:04:48', 0),
(725, '2', '2', '2', 'No', '1991-02-05 16:04:48', '1991-02-05 16:04:48', 0),
(726, '2', '2', '2', 'No', '1991-02-20 16:04:48', '1991-02-20 16:04:48', 0),
(727, '2', '2', '2', 'No', '1991-03-07 16:04:48', '1991-03-07 16:04:48', 0),
(728, '2', '2', '2', 'No', '1991-03-22 16:04:48', '1991-03-22 16:04:48', 0),
(729, '2', '2', '2', 'No', '1991-04-06 16:04:48', '1991-04-06 16:04:48', 0),
(730, '2', '2', '2', 'No', '1991-04-22 16:04:48', '1991-04-22 16:04:48', 0),
(731, '2', '2', '2', 'No', '1991-05-07 16:04:48', '1991-05-07 16:04:48', 0),
(732, '2', '2', '2', 'No', '1991-05-22 16:04:48', '1991-05-22 16:04:48', 0),
(733, '2', '2', '2', 'No', '1991-06-06 16:04:48', '1991-06-06 16:04:48', 0),
(734, '2', '2', '2', 'No', '1991-06-21 16:04:48', '1991-06-21 16:04:48', 0),
(735, '2', '2', '2', 'No', '1991-07-06 16:04:48', '1991-07-06 16:04:48', 0),
(736, '2', '2', '2', 'No', '1991-07-22 16:04:48', '1991-07-22 16:04:48', 0),
(737, '2', '2', '2', 'No', '1991-08-06 16:04:48', '1991-08-06 16:04:48', 0),
(738, '2', '2', '2', 'No', '1991-08-21 16:04:48', '1991-08-21 16:04:48', 0),
(739, '2', '2', '2', 'No', '1991-09-05 16:04:48', '1991-09-05 16:04:48', 0),
(740, '2', '2', '2', 'No', '1991-09-20 16:04:48', '1991-09-20 16:04:48', 0),
(741, '2', '2', '2', 'No', '1991-10-05 16:04:48', '1991-10-05 16:04:48', 0),
(742, '2', '2', '2', 'No', '1991-10-21 16:04:48', '1991-10-21 16:04:48', 0),
(743, '2', '2', '2', 'No', '1991-11-05 16:04:48', '1991-11-05 16:04:48', 0),
(744, '2', '2', '2', 'No', '1991-11-20 16:04:48', '1991-11-20 16:04:48', 0),
(745, '2', '2', '2', 'No', '1991-12-05 16:04:48', '1991-12-05 16:04:48', 0),
(746, '2', '2', '2', 'No', '1991-12-20 16:04:48', '1991-12-20 16:04:48', 0),
(747, '2', '2', '2', 'No', '1992-01-04 16:04:48', '1992-01-04 16:04:48', 0),
(748, '2', '2', '2', 'No', '1992-01-20 16:04:48', '1992-01-20 16:04:48', 0),
(749, '2', '2', '2', 'No', '1992-02-04 16:04:48', '1992-02-04 16:04:48', 0),
(750, '2', '2', '2', 'No', '1992-02-19 16:04:48', '1992-02-19 16:04:48', 0),
(751, '2', '2', '2', 'No', '1992-03-05 16:04:48', '1992-03-05 16:04:48', 0),
(752, '2', '2', '2', 'No', '1992-03-20 16:04:48', '1992-03-20 16:04:48', 0),
(753, '2', '2', '2', 'No', '1992-04-04 16:04:48', '1992-04-04 16:04:48', 0),
(754, '2', '2', '2', 'No', '1992-04-20 16:04:48', '1992-04-20 16:04:48', 0),
(755, '2', '2', '2', 'No', '1992-05-05 16:04:48', '1992-05-05 16:04:48', 0),
(756, '2', '2', '2', 'No', '1992-05-20 16:04:48', '1992-05-20 16:04:48', 0),
(757, '2', '2', '2', 'No', '1992-06-04 16:04:48', '1992-06-04 16:04:48', 0),
(758, '2', '2', '2', 'No', '1992-06-19 16:04:48', '1992-06-19 16:04:48', 0),
(759, '2', '2', '2', 'No', '1992-07-04 16:04:48', '1992-07-04 16:04:48', 0),
(760, '2', '2', '2', 'No', '1992-07-20 16:04:48', '1992-07-20 16:04:48', 0),
(761, '2', '2', '2', 'No', '1992-08-04 16:04:48', '1992-08-04 16:04:48', 0),
(762, '2', '2', '2', 'No', '1992-08-19 16:04:48', '1992-08-19 16:04:48', 0),
(763, '2', '2', '2', 'No', '1992-09-03 16:04:48', '1992-09-03 16:04:48', 0),
(764, '2', '2', '2', 'No', '1992-09-18 16:04:48', '1992-09-18 16:04:48', 0),
(765, '2', '2', '2', 'No', '1992-10-03 16:04:48', '1992-10-03 16:04:48', 0),
(766, '2', '2', '2', 'No', '1992-10-19 16:04:48', '1992-10-19 16:04:48', 0),
(767, '2', '2', '2', 'No', '1992-11-03 16:04:48', '1992-11-03 16:04:48', 0),
(768, '2', '2', '2', 'No', '1992-11-18 16:04:48', '1992-11-18 16:04:48', 0),
(769, '2', '2', '2', 'No', '1992-12-03 16:04:48', '1992-12-03 16:04:48', 0),
(770, '2', '2', '2', 'No', '1992-12-18 16:04:48', '1992-12-18 16:04:48', 0),
(771, '2', '2', '2', 'No', '1993-01-02 16:04:48', '1993-01-02 16:04:48', 0),
(772, '2', '2', '2', 'No', '1993-01-18 16:04:48', '1993-01-18 16:04:48', 0),
(773, '2', '2', '2', 'No', '1993-02-02 16:04:48', '1993-02-02 16:04:48', 0),
(774, '2', '2', '2', 'No', '1993-02-17 16:04:48', '1993-02-17 16:04:48', 0),
(775, '2', '2', '2', 'No', '1993-03-04 16:04:48', '1993-03-04 16:04:48', 0),
(776, '2', '2', '2', 'No', '1993-03-19 16:04:48', '1993-03-19 16:04:48', 0),
(777, '2', '2', '2', 'No', '1993-04-03 16:04:48', '1993-04-03 16:04:48', 0),
(778, '2', '2', '2', 'No', '1993-04-19 16:04:48', '1993-04-19 16:04:48', 0),
(779, '2', '2', '2', 'No', '1993-05-04 16:04:48', '1993-05-04 16:04:48', 0),
(780, '2', '2', '2', 'No', '1993-05-19 16:04:48', '1993-05-19 16:04:48', 0),
(781, '2', '2', '2', 'No', '1993-06-03 16:04:48', '1993-06-03 16:04:48', 0),
(782, '2', '2', '2', 'No', '1993-06-18 16:04:48', '1993-06-18 16:04:48', 0),
(783, '2', '2', '2', 'No', '1993-07-03 16:04:48', '1993-07-03 16:04:48', 0),
(784, '2', '2', '2', 'No', '1993-07-19 16:04:48', '1993-07-19 16:04:48', 0),
(785, '2', '2', '2', 'No', '1993-08-03 16:04:48', '1993-08-03 16:04:48', 0),
(786, '2', '2', '2', 'No', '1993-08-18 16:04:48', '1993-08-18 16:04:48', 0),
(787, '2', '2', '2', 'No', '1993-09-02 16:04:48', '1993-09-02 16:04:48', 0),
(788, '2', '2', '2', 'No', '1993-09-17 16:04:48', '1993-09-17 16:04:48', 0),
(789, '2', '2', '2', 'No', '1993-10-02 16:04:48', '1993-10-02 16:04:48', 0),
(790, '2', '2', '2', 'No', '1993-10-18 16:04:48', '1993-10-18 16:04:48', 0),
(791, '2', '2', '2', 'No', '1993-11-02 16:04:48', '1993-11-02 16:04:48', 0),
(792, '2', '2', '2', 'No', '1993-11-17 16:04:48', '1993-11-17 16:04:48', 0),
(793, '2', '2', '2', 'No', '1993-12-02 16:04:48', '1993-12-02 16:04:48', 0),
(794, '2', '2', '2', 'No', '1993-12-17 16:04:48', '1993-12-17 16:04:48', 0),
(795, '2', '2', '2', 'No', '1994-01-01 16:04:48', '1994-01-01 16:04:48', 0),
(796, '2', '2', '2', 'No', '1994-01-17 16:04:48', '1994-01-17 16:04:48', 0),
(797, '2', '2', '2', 'No', '1994-02-01 16:04:48', '1994-02-01 16:04:48', 0),
(798, '2', '2', '2', 'No', '1994-02-16 16:04:48', '1994-02-16 16:04:48', 0),
(799, '2', '2', '2', 'No', '1994-03-03 16:04:48', '1994-03-03 16:04:48', 0),
(800, '2', '2', '2', 'No', '1994-03-18 16:04:48', '1994-03-18 16:04:48', 0),
(801, '2', '2', '2', 'No', '1994-04-02 16:04:48', '1994-04-02 16:04:48', 0),
(802, '2', '2', '2', 'No', '1994-04-18 16:04:48', '1994-04-18 16:04:48', 0),
(803, '2', '2', '2', 'No', '1994-05-03 16:04:48', '1994-05-03 16:04:48', 0),
(804, '2', '2', '2', 'No', '1994-05-18 16:04:48', '1994-05-18 16:04:48', 0),
(805, '2', '2', '2', 'No', '1994-06-02 16:04:48', '1994-06-02 16:04:48', 0),
(806, '2', '2', '2', 'No', '1994-06-17 16:04:48', '1994-06-17 16:04:48', 0),
(807, '2', '2', '2', 'No', '1994-07-02 16:04:48', '1994-07-02 16:04:48', 0),
(808, '2', '2', '2', 'No', '1994-07-18 16:04:48', '1994-07-18 16:04:48', 0),
(809, '2', '2', '2', 'No', '1994-08-02 16:04:48', '1994-08-02 16:04:48', 0),
(810, '2', '2', '2', 'No', '1994-08-17 16:04:48', '1994-08-17 16:04:48', 0),
(811, '2', '2', '2', 'No', '1994-09-01 16:04:48', '1994-09-01 16:04:48', 0),
(812, '2', '2', '2', 'No', '1994-09-16 16:04:48', '1994-09-16 16:04:48', 0),
(813, '2', '2', '2', 'No', '1994-10-01 16:04:48', '1994-10-01 16:04:48', 0),
(814, '2', '2', '2', 'No', '1994-10-17 16:04:48', '1994-10-17 16:04:48', 0),
(815, '2', '2', '2', 'No', '1994-11-01 16:04:48', '1994-11-01 16:04:48', 0),
(816, '2', '2', '2', 'No', '1994-11-16 16:04:48', '1994-11-16 16:04:48', 0),
(817, '2', '2', '2', 'No', '1994-12-01 16:04:48', '1994-12-01 16:04:48', 0),
(818, '2', '2', '2', 'No', '1994-12-16 16:04:48', '1994-12-16 16:04:48', 0),
(819, '2', '2', '2', 'No', '1994-12-31 16:04:48', '1994-12-31 16:04:48', 0),
(820, '2', '2', '2', 'No', '1995-01-16 16:04:48', '1995-01-16 16:04:48', 0),
(821, '2', '2', '2', 'No', '1995-01-31 16:04:48', '1995-01-31 16:04:48', 0),
(822, '2', '2', '2', 'No', '1995-02-15 16:04:48', '1995-02-15 16:04:48', 0),
(823, '2', '2', '2', 'No', '1995-03-02 16:04:48', '1995-03-02 16:04:48', 0),
(824, '2', '2', '2', 'No', '1995-03-17 16:04:48', '1995-03-17 16:04:48', 0),
(825, '2', '2', '2', 'No', '1995-04-01 16:04:48', '1995-04-01 16:04:48', 0),
(826, '2', '2', '2', 'No', '1995-04-17 16:04:48', '1995-04-17 16:04:48', 0),
(827, '2', '2', '2', 'No', '1995-05-02 16:04:48', '1995-05-02 16:04:48', 0),
(828, '2', '2', '2', 'No', '1995-05-17 16:04:48', '1995-05-17 16:04:48', 0),
(829, '2', '2', '2', 'No', '1995-06-01 16:04:48', '1995-06-01 16:04:48', 0),
(830, '2', '2', '2', 'No', '1995-06-16 16:04:48', '1995-06-16 16:04:48', 0),
(831, '2', '2', '2', 'No', '1995-07-01 16:04:48', '1995-07-01 16:04:48', 0),
(832, '2', '2', '2', 'No', '1995-07-17 16:04:48', '1995-07-17 16:04:48', 0),
(833, '2', '2', '2', 'No', '1995-08-01 16:04:48', '1995-08-01 16:04:48', 0),
(834, '2', '2', '2', 'No', '1995-08-16 16:04:48', '1995-08-16 16:04:48', 0),
(835, '2', '2', '2', 'No', '1995-08-31 16:04:48', '1995-08-31 16:04:48', 0),
(836, '2', '2', '2', 'No', '1995-09-15 16:04:48', '1995-09-15 16:04:48', 0),
(837, '2', '2', '2', 'No', '1995-09-30 16:04:48', '1995-09-30 16:04:48', 0),
(838, '2', '2', '2', 'No', '1995-10-16 16:04:48', '1995-10-16 16:04:48', 0),
(839, '2', '2', '2', 'No', '1995-10-31 16:04:48', '1995-10-31 16:04:48', 0),
(840, '2', '2', '2', 'No', '1995-11-15 16:04:48', '1995-11-15 16:04:48', 0),
(841, '2', '2', '2', 'No', '1995-11-30 16:04:48', '1995-11-30 16:04:48', 0),
(842, '2', '2', '2', 'No', '1995-12-15 16:04:48', '1995-12-15 16:04:48', 0),
(843, '2', '2', '2', 'No', '1995-12-30 16:04:48', '1995-12-30 16:04:48', 0),
(844, '2', '2', '2', 'No', '1996-01-15 16:04:48', '1996-01-15 16:04:48', 0),
(845, '2', '2', '2', 'No', '1996-01-30 16:04:48', '1996-01-30 16:04:48', 0),
(846, '2', '2', '2', 'No', '1996-02-14 16:04:48', '1996-02-14 16:04:48', 0),
(847, '2', '2', '2', 'No', '1996-02-29 16:04:48', '1996-02-29 16:04:48', 0),
(848, '2', '2', '2', 'No', '1996-03-15 16:04:48', '1996-03-15 16:04:48', 0),
(849, '2', '2', '2', 'No', '1996-03-30 16:04:48', '1996-03-30 16:04:48', 0),
(850, '2', '2', '2', 'No', '1996-04-15 16:04:48', '1996-04-15 16:04:48', 0),
(851, '2', '2', '2', 'No', '1996-04-30 16:04:48', '1996-04-30 16:04:48', 0),
(852, '2', '2', '2', 'No', '1996-05-15 16:04:48', '1996-05-15 16:04:48', 0),
(853, '2', '2', '2', 'No', '1996-05-30 16:04:48', '1996-05-30 16:04:48', 0),
(854, '2', '2', '2', 'No', '1996-06-14 16:04:48', '1996-06-14 16:04:48', 0),
(855, '2', '2', '2', 'No', '1996-06-29 16:04:48', '1996-06-29 16:04:48', 0),
(856, '2', '2', '2', 'No', '1996-07-15 16:04:48', '1996-07-15 16:04:48', 0),
(857, '2', '2', '2', 'No', '1996-07-30 16:04:48', '1996-07-30 16:04:48', 0),
(858, '2', '2', '2', 'No', '1996-08-14 16:04:48', '1996-08-14 16:04:48', 0),
(859, '2', '2', '2', 'No', '1996-08-29 16:04:48', '1996-08-29 16:04:48', 0),
(860, '2', '2', '2', 'No', '1996-09-13 16:04:48', '1996-09-13 16:04:48', 0),
(861, '2', '2', '2', 'No', '1996-09-28 16:04:48', '1996-09-28 16:04:48', 0),
(862, '2', '2', '2', 'No', '1996-10-14 16:04:48', '1996-10-14 16:04:48', 0),
(863, '2', '2', '2', 'No', '1996-10-29 16:04:48', '1996-10-29 16:04:48', 0),
(864, '2', '2', '2', 'No', '1996-11-13 16:04:48', '1996-11-13 16:04:48', 0),
(865, '2', '2', '2', 'No', '1996-11-28 16:04:48', '1996-11-28 16:04:48', 0),
(866, '2', '2', '2', 'No', '1996-12-13 16:04:48', '1996-12-13 16:04:48', 0),
(867, '2', '2', '2', 'No', '1996-12-28 16:04:48', '1996-12-28 16:04:48', 0),
(868, '2', '2', '2', 'No', '1997-01-13 16:04:48', '1997-01-13 16:04:48', 0),
(869, '2', '2', '2', 'No', '1997-01-28 16:04:48', '1997-01-28 16:04:48', 0),
(870, '2', '2', '2', 'No', '1997-02-12 16:04:48', '1997-02-12 16:04:48', 0),
(871, '2', '2', '2', 'No', '1997-02-27 16:04:48', '1997-02-27 16:04:48', 0),
(872, '2', '2', '2', 'No', '1997-03-14 16:04:48', '1997-03-14 16:04:48', 0),
(873, '2', '2', '2', 'No', '1997-03-29 16:04:48', '1997-03-29 16:04:48', 0),
(874, '2', '2', '2', 'No', '1997-04-14 16:04:48', '1997-04-14 16:04:48', 0),
(875, '2', '2', '2', 'No', '1997-04-29 16:04:48', '1997-04-29 16:04:48', 0),
(876, '2', '2', '2', 'No', '1997-05-14 16:04:48', '1997-05-14 16:04:48', 0),
(877, '2', '2', '2', 'No', '1997-05-29 16:04:48', '1997-05-29 16:04:48', 0),
(878, '2', '2', '2', 'No', '1997-06-13 16:04:48', '1997-06-13 16:04:48', 0),
(879, '2', '2', '2', 'No', '1997-06-28 16:04:48', '1997-06-28 16:04:48', 0),
(880, '2', '2', '2', 'No', '1997-07-14 16:04:48', '1997-07-14 16:04:48', 0),
(881, '2', '2', '2', 'No', '1997-07-29 16:04:48', '1997-07-29 16:04:48', 0),
(882, '2', '2', '2', 'No', '1997-08-13 16:04:48', '1997-08-13 16:04:48', 0),
(883, '2', '2', '2', 'No', '1997-08-28 16:04:48', '1997-08-28 16:04:48', 0),
(884, '2', '2', '2', 'No', '1997-09-12 16:04:48', '1997-09-12 16:04:48', 0),
(885, '2', '2', '2', 'No', '1997-09-27 16:04:48', '1997-09-27 16:04:48', 0),
(886, '2', '2', '2', 'No', '1997-10-13 16:04:48', '1997-10-13 16:04:48', 0),
(887, '2', '2', '2', 'No', '1997-10-28 16:04:48', '1997-10-28 16:04:48', 0),
(888, '2', '2', '2', 'No', '1997-11-12 16:04:48', '1997-11-12 16:04:48', 0),
(889, '2', '2', '2', 'No', '1997-11-27 16:04:48', '1997-11-27 16:04:48', 0),
(890, '2', '2', '2', 'No', '1997-12-12 16:04:48', '1997-12-12 16:04:48', 0),
(891, '2', '2', '2', 'No', '1997-12-27 16:04:48', '1997-12-27 16:04:48', 0),
(892, '2', '2', '2', 'No', '1998-01-12 16:04:48', '1998-01-12 16:04:48', 0),
(893, '2', '2', '2', 'No', '1998-01-27 16:04:48', '1998-01-27 16:04:48', 0),
(894, '2', '2', '2', 'No', '1998-02-11 16:04:48', '1998-02-11 16:04:48', 0),
(895, '2', '2', '2', 'No', '1998-02-26 16:04:48', '1998-02-26 16:04:48', 0),
(896, '2', '2', '2', 'No', '1998-03-13 16:04:48', '1998-03-13 16:04:48', 0),
(897, '2', '2', '2', 'No', '1998-03-28 16:04:48', '1998-03-28 16:04:48', 0),
(898, '2', '2', '2', 'No', '1998-04-13 16:04:48', '1998-04-13 16:04:48', 0),
(899, '2', '2', '2', 'No', '1998-04-28 16:04:48', '1998-04-28 16:04:48', 0),
(900, '2', '2', '2', 'No', '1998-05-13 16:04:48', '1998-05-13 16:04:48', 0),
(901, '2', '2', '2', 'No', '1998-05-28 16:04:48', '1998-05-28 16:04:48', 0),
(902, '2', '2', '2', 'No', '1998-06-12 16:04:48', '1998-06-12 16:04:48', 0),
(903, '2', '2', '2', 'No', '1998-06-27 16:04:48', '1998-06-27 16:04:48', 0),
(904, '2', '2', '2', 'No', '1998-07-13 16:04:48', '1998-07-13 16:04:48', 0),
(905, '2', '2', '2', 'No', '1998-07-28 16:04:48', '1998-07-28 16:04:48', 0),
(906, '2', '2', '2', 'No', '1998-08-12 16:04:48', '1998-08-12 16:04:48', 0),
(907, '2', '2', '2', 'No', '1998-08-27 16:04:48', '1998-08-27 16:04:48', 0),
(908, '2', '2', '2', 'No', '1998-09-11 16:04:48', '1998-09-11 16:04:48', 0),
(909, '2', '2', '2', 'No', '1998-09-26 16:04:48', '1998-09-26 16:04:48', 0),
(910, '2', '2', '2', 'No', '1998-10-12 16:04:48', '1998-10-12 16:04:48', 0),
(911, '2', '2', '2', 'No', '1998-10-27 16:04:48', '1998-10-27 16:04:48', 0),
(912, '2', '2', '2', 'No', '1998-11-11 16:04:48', '1998-11-11 16:04:48', 0),
(913, '2', '2', '2', 'No', '1998-11-26 16:04:48', '1998-11-26 16:04:48', 0),
(914, '2', '2', '2', 'No', '1998-12-11 16:04:48', '1998-12-11 16:04:48', 0),
(915, '2', '2', '2', 'No', '1998-12-26 16:04:48', '1998-12-26 16:04:48', 0),
(916, '2', '2', '2', 'No', '1999-01-11 16:04:48', '1999-01-11 16:04:48', 0),
(917, '2', '2', '2', 'No', '1999-01-26 16:04:48', '1999-01-26 16:04:48', 0),
(918, '2', '2', '2', 'No', '1999-02-10 16:04:48', '1999-02-10 16:04:48', 0),
(919, '2', '2', '2', 'No', '1999-02-25 16:04:48', '1999-02-25 16:04:48', 0),
(920, '2', '2', '2', 'No', '1999-03-12 16:04:48', '1999-03-12 16:04:48', 0),
(921, '2', '2', '2', 'No', '1999-03-27 16:04:48', '1999-03-27 16:04:48', 0),
(922, '2', '2', '2', 'No', '1999-04-12 16:04:48', '1999-04-12 16:04:48', 0),
(923, '2', '2', '2', 'No', '1999-04-27 16:04:48', '1999-04-27 16:04:48', 0),
(924, '2', '2', '2', 'No', '1999-05-12 16:04:48', '1999-05-12 16:04:48', 0),
(925, '2', '2', '2', 'No', '1999-05-27 16:04:48', '1999-05-27 16:04:48', 0),
(926, '2', '2', '2', 'No', '1999-06-11 16:04:48', '1999-06-11 16:04:48', 0),
(927, '2', '2', '2', 'No', '1999-06-26 16:04:48', '1999-06-26 16:04:48', 0),
(928, '2', '2', '2', 'No', '1999-07-12 16:04:48', '1999-07-12 16:04:48', 0),
(929, '2', '2', '2', 'No', '1999-07-27 16:04:48', '1999-07-27 16:04:48', 0),
(930, '2', '2', '2', 'No', '1999-08-11 16:04:48', '1999-08-11 16:04:48', 0),
(931, '2', '2', '2', 'No', '1999-08-26 16:04:48', '1999-08-26 16:04:48', 0),
(932, '2', '2', '2', 'No', '1999-09-10 16:04:48', '1999-09-10 16:04:48', 0),
(933, '2', '2', '2', 'No', '1999-09-25 16:04:48', '1999-09-25 16:04:48', 0),
(934, '2', '2', '2', 'No', '1999-10-11 16:04:48', '1999-10-11 16:04:48', 0),
(935, '2', '2', '2', 'No', '1999-10-26 16:04:48', '1999-10-26 16:04:48', 0),
(936, '2', '2', '2', 'No', '1999-11-10 16:04:48', '1999-11-10 16:04:48', 0),
(937, '2', '2', '2', 'No', '1999-11-25 16:04:48', '1999-11-25 16:04:48', 0),
(938, '2', '2', '2', 'No', '1999-12-10 16:04:48', '1999-12-10 16:04:48', 0),
(939, '2', '2', '2', 'No', '1999-12-25 16:04:48', '1999-12-25 16:04:48', 0),
(940, '2', '2', '2', 'No', '2000-01-10 16:04:48', '2000-01-10 16:04:48', 0),
(941, '2', '2', '2', 'No', '2000-01-25 16:04:48', '2000-01-25 16:04:48', 0),
(942, '2', '2', '2', 'No', '2000-02-09 16:04:48', '2000-02-09 16:04:48', 0),
(943, '2', '2', '2', 'No', '2000-02-24 16:04:48', '2000-02-24 16:04:48', 0),
(944, '2', '2', '2', 'No', '2000-03-10 16:04:48', '2000-03-10 16:04:48', 0),
(945, '2', '2', '2', 'No', '2000-03-25 16:04:48', '2000-03-25 16:04:48', 0),
(946, '2', '2', '2', 'No', '2000-04-10 16:04:48', '2000-04-10 16:04:48', 0),
(947, '2', '2', '2', 'No', '2000-04-25 16:04:48', '2000-04-25 16:04:48', 0),
(948, '2', '2', '2', 'No', '2000-05-10 16:04:48', '2000-05-10 16:04:48', 0),
(949, '2', '2', '2', 'No', '2000-05-25 16:04:48', '2000-05-25 16:04:48', 0),
(950, '2', '2', '2', 'No', '2000-06-09 16:04:48', '2000-06-09 16:04:48', 0),
(951, '2', '2', '2', 'No', '2000-06-24 16:04:48', '2000-06-24 16:04:48', 0),
(952, '2', '2', '2', 'No', '2000-07-10 16:04:48', '2000-07-10 16:04:48', 0),
(953, '2', '2', '2', 'No', '2000-07-25 16:04:48', '2000-07-25 16:04:48', 0),
(954, '2', '2', '2', 'No', '2000-08-09 16:04:48', '2000-08-09 16:04:48', 0),
(955, '2', '2', '2', 'No', '2000-08-24 16:04:48', '2000-08-24 16:04:48', 0),
(956, '2', '2', '2', 'No', '2000-09-08 16:04:48', '2000-09-08 16:04:48', 0),
(957, '2', '2', '2', 'No', '2000-09-23 16:04:48', '2000-09-23 16:04:48', 0),
(958, '2', '2', '2', 'No', '2000-10-09 16:04:48', '2000-10-09 16:04:48', 0),
(959, '2', '2', '2', 'No', '2000-10-24 16:04:48', '2000-10-24 16:04:48', 0),
(960, '2', '2', '2', 'No', '2000-11-08 16:04:48', '2000-11-08 16:04:48', 0),
(961, '2', '2', '2', 'No', '2000-11-23 16:04:48', '2000-11-23 16:04:48', 0),
(962, '2', '2', '2', 'No', '2000-12-08 16:04:48', '2000-12-08 16:04:48', 0),
(963, '2', '2', '2', 'No', '2000-12-23 16:04:48', '2000-12-23 16:04:48', 0),
(964, '2', '2', '2', 'No', '2001-01-08 16:04:48', '2001-01-08 16:04:48', 0),
(965, '2', '2', '2', 'No', '2001-01-23 16:04:48', '2001-01-23 16:04:48', 0),
(966, '2', '2', '2', 'No', '2001-02-07 16:04:48', '2001-02-07 16:04:48', 0),
(967, '2', '2', '2', 'No', '2001-02-22 16:04:48', '2001-02-22 16:04:48', 0),
(968, '2', '2', '2', 'No', '2001-03-09 16:04:48', '2001-03-09 16:04:48', 0),
(969, '2', '2', '2', 'No', '2001-03-24 16:04:48', '2001-03-24 16:04:48', 0),
(970, '2', '2', '2', 'No', '2001-04-09 16:04:48', '2001-04-09 16:04:48', 0),
(971, '2', '2', '2', 'No', '2001-04-24 16:04:48', '2001-04-24 16:04:48', 0),
(972, '2', '2', '2', 'No', '2001-05-09 16:04:48', '2001-05-09 16:04:48', 0),
(973, '2', '2', '2', 'No', '2001-05-24 16:04:48', '2001-05-24 16:04:48', 0),
(974, '2', '2', '2', 'No', '2001-06-08 16:04:48', '2001-06-08 16:04:48', 0),
(975, '2', '2', '2', 'No', '2001-06-23 16:04:48', '2001-06-23 16:04:48', 0),
(976, '2', '2', '2', 'No', '2001-07-09 16:04:48', '2001-07-09 16:04:48', 0),
(977, '2', '2', '2', 'No', '2001-07-24 16:04:48', '2001-07-24 16:04:48', 0),
(978, '2', '2', '2', 'No', '2001-08-08 16:04:48', '2001-08-08 16:04:48', 0),
(979, '2', '2', '2', 'No', '2001-08-23 16:04:48', '2001-08-23 16:04:48', 0),
(980, '2', '2', '2', 'No', '2001-09-07 16:04:48', '2001-09-07 16:04:48', 0),
(981, '2', '2', '2', 'No', '2001-09-22 16:04:48', '2001-09-22 16:04:48', 0),
(982, '2', '2', '2', 'No', '2001-10-08 16:04:48', '2001-10-08 16:04:48', 0),
(983, '2', '2', '2', 'No', '2001-10-23 16:04:48', '2001-10-23 16:04:48', 0),
(984, '2', '2', '2', 'No', '2001-11-07 16:04:48', '2001-11-07 16:04:48', 0),
(985, '2', '2', '2', 'No', '2001-11-22 16:04:48', '2001-11-22 16:04:48', 0),
(986, '2', '2', '2', 'No', '2001-12-07 16:04:48', '2001-12-07 16:04:48', 0),
(987, '2', '2', '2', 'No', '2001-12-22 16:04:48', '2001-12-22 16:04:48', 0),
(988, '2', '2', '2', 'No', '2002-01-07 16:04:48', '2002-01-07 16:04:48', 0),
(989, '2', '2', '2', 'No', '2002-01-22 16:04:48', '2002-01-22 16:04:48', 0),
(990, '2', '2', '2', 'No', '2002-02-06 16:04:48', '2002-02-06 16:04:48', 0),
(991, '2', '2', '2', 'No', '2002-02-21 16:04:48', '2002-02-21 16:04:48', 0),
(992, '2', '2', '2', 'No', '2002-03-08 16:04:48', '2002-03-08 16:04:48', 0),
(993, '2', '2', '2', 'No', '2002-03-23 16:04:48', '2002-03-23 16:04:48', 0),
(994, '2', '2', '2', 'No', '2002-04-08 16:04:48', '2002-04-08 16:04:48', 0),
(995, '2', '2', '2', 'No', '2002-04-23 16:04:48', '2002-04-23 16:04:48', 0),
(996, '2', '2', '2', 'No', '2002-05-08 16:04:48', '2002-05-08 16:04:48', 0),
(997, '2', '2', '2', 'No', '2002-05-23 16:04:48', '2002-05-23 16:04:48', 0),
(998, '2', '2', '2', 'No', '2002-06-07 16:04:48', '2002-06-07 16:04:48', 0),
(999, '2', '2', '2', 'No', '2002-06-22 16:04:48', '2002-06-22 16:04:48', 0),
(1000, '2', '2', '2', 'No', '2002-07-08 16:04:48', '2002-07-08 16:04:48', 0),
(1001, '2', '2', '2', 'No', '2002-07-23 16:04:48', '2002-07-23 16:04:48', 0),
(1002, '2', '2', '2', 'No', '2002-08-07 16:04:48', '2002-08-07 16:04:48', 0),
(1003, '2', '2', '2', 'No', '2002-08-22 16:04:48', '2002-08-22 16:04:48', 0),
(1004, '2', '2', '2', 'No', '2002-09-06 16:04:48', '2002-09-06 16:04:48', 0),
(1005, '2', '2', '2', 'No', '2002-09-21 16:04:48', '2002-09-21 16:04:48', 0),
(1006, '2', '2', '2', 'No', '2002-10-07 16:04:48', '2002-10-07 16:04:48', 0),
(1007, '2', '2', '2', 'No', '2002-10-22 16:04:48', '2002-10-22 16:04:48', 0),
(1008, '2', '2', '2', 'No', '2002-11-06 16:04:48', '2002-11-06 16:04:48', 0),
(1009, '2', '2', '2', 'No', '2002-11-21 16:04:48', '2002-11-21 16:04:48', 0),
(1010, '2', '2', '2', 'No', '2002-12-06 16:04:48', '2002-12-06 16:04:48', 0),
(1011, '2', '2', '2', 'No', '2002-12-21 16:04:48', '2002-12-21 16:04:48', 0),
(1012, '2', '2', '2', 'No', '2003-01-06 16:04:48', '2003-01-06 16:04:48', 0),
(1013, '2', '2', '2', 'No', '2003-01-21 16:04:48', '2003-01-21 16:04:48', 0),
(1014, '2', '2', '2', 'No', '2003-02-05 16:04:48', '2003-02-05 16:04:48', 0),
(1015, '2', '2', '2', 'No', '2003-02-20 16:04:48', '2003-02-20 16:04:48', 0),
(1016, '2', '2', '2', 'No', '2003-03-07 16:04:48', '2003-03-07 16:04:48', 0),
(1017, '2', '2', '2', 'No', '2003-03-22 16:04:48', '2003-03-22 16:04:48', 0),
(1018, '2', '2', '2', 'No', '2003-04-07 16:04:48', '2003-04-07 16:04:48', 0),
(1019, '2', '2', '2', 'No', '2003-04-22 16:04:48', '2003-04-22 16:04:48', 0),
(1020, '2', '2', '2', 'No', '2003-05-07 16:04:48', '2003-05-07 16:04:48', 0),
(1021, '2', '2', '2', 'No', '2003-05-22 16:04:48', '2003-05-22 16:04:48', 0),
(1022, '2', '2', '2', 'No', '2003-06-06 16:04:48', '2003-06-06 16:04:48', 0),
(1023, '2', '2', '2', 'No', '2003-06-21 16:04:48', '2003-06-21 16:04:48', 0),
(1024, '2', '2', '2', 'No', '2003-07-07 16:04:48', '2003-07-07 16:04:48', 0),
(1025, '2', '2', '2', 'No', '2003-07-22 16:04:48', '2003-07-22 16:04:48', 0),
(1026, '2', '2', '2', 'No', '2003-08-06 16:04:48', '2003-08-06 16:04:48', 0),
(1027, '2', '2', '2', 'No', '2003-08-21 16:04:48', '2003-08-21 16:04:48', 0),
(1028, '2', '2', '2', 'No', '2003-09-05 16:04:48', '2003-09-05 16:04:48', 0),
(1029, '2', '2', '2', 'No', '2003-09-20 16:04:48', '2003-09-20 16:04:48', 0),
(1030, '2', '2', '2', 'No', '2003-10-06 16:04:48', '2003-10-06 16:04:48', 0),
(1031, '2', '2', '2', 'No', '2003-10-21 16:04:48', '2003-10-21 16:04:48', 0),
(1032, '2', '2', '2', 'No', '2003-11-05 16:04:48', '2003-11-05 16:04:48', 0),
(1033, '2', '2', '2', 'No', '2003-11-20 16:04:48', '2003-11-20 16:04:48', 0),
(1034, '2', '2', '2', 'No', '2003-12-05 16:04:48', '2003-12-05 16:04:48', 0),
(1035, '2', '2', '2', 'No', '2003-12-20 16:04:48', '2003-12-20 16:04:48', 0),
(1036, '2', '2', '2', 'No', '2004-01-05 16:04:48', '2004-01-05 16:04:48', 0),
(1037, '2', '2', '2', 'No', '2004-01-20 16:04:48', '2004-01-20 16:04:48', 0),
(1038, '2', '2', '2', 'No', '2004-02-04 16:04:48', '2004-02-04 16:04:48', 0),
(1039, '2', '2', '2', 'No', '2004-02-19 16:04:48', '2004-02-19 16:04:48', 0),
(1040, '2', '2', '2', 'No', '2004-03-05 16:04:48', '2004-03-05 16:04:48', 0),
(1041, '2', '2', '2', 'No', '2004-03-20 16:04:48', '2004-03-20 16:04:48', 0),
(1042, '2', '2', '2', 'No', '2004-04-05 16:04:48', '2004-04-05 16:04:48', 0),
(1043, '2', '2', '2', 'No', '2004-04-20 16:04:48', '2004-04-20 16:04:48', 0),
(1044, '2', '2', '2', 'No', '2004-05-05 16:04:48', '2004-05-05 16:04:48', 0),
(1045, '2', '2', '2', 'No', '2004-05-20 16:04:48', '2004-05-20 16:04:48', 0),
(1046, '2', '2', '2', 'No', '2004-06-04 16:04:48', '2004-06-04 16:04:48', 0),
(1047, '2', '2', '2', 'No', '2004-06-19 16:04:48', '2004-06-19 16:04:48', 0),
(1048, '2', '2', '2', 'No', '2004-07-05 16:04:48', '2004-07-05 16:04:48', 0),
(1049, '2', '2', '2', 'No', '2004-07-20 16:04:48', '2004-07-20 16:04:48', 0),
(1050, '2', '2', '2', 'No', '2004-08-04 16:04:48', '2004-08-04 16:04:48', 0),
(1051, '2', '2', '2', 'No', '2004-08-19 16:04:48', '2004-08-19 16:04:48', 0),
(1052, '2', '2', '2', 'No', '2004-09-03 16:04:48', '2004-09-03 16:04:48', 0),
(1053, '2', '2', '2', 'No', '2004-09-18 16:04:48', '2004-09-18 16:04:48', 0),
(1054, '2', '2', '2', 'No', '2004-10-04 16:04:48', '2004-10-04 16:04:48', 0),
(1055, '2', '2', '2', 'No', '2004-10-19 16:04:48', '2004-10-19 16:04:48', 0),
(1056, '2', '2', '2', 'No', '2004-11-03 16:04:48', '2004-11-03 16:04:48', 0),
(1057, '2', '2', '2', 'No', '2004-11-18 16:04:48', '2004-11-18 16:04:48', 0),
(1058, '2', '2', '2', 'No', '2004-12-03 16:04:48', '2004-12-03 16:04:48', 0),
(1059, '2', '2', '2', 'No', '2004-12-18 16:04:48', '2004-12-18 16:04:48', 0),
(1060, '2', '2', '2', 'No', '2005-01-03 16:04:48', '2005-01-03 16:04:48', 0),
(1061, '2', '2', '2', 'No', '2005-01-18 16:04:48', '2005-01-18 16:04:48', 0),
(1062, '2', '2', '2', 'No', '2005-02-02 16:04:48', '2005-02-02 16:04:48', 0),
(1063, '2', '2', '2', 'No', '2005-02-17 16:04:48', '2005-02-17 16:04:48', 0),
(1064, '2', '2', '2', 'No', '2005-03-04 16:04:48', '2005-03-04 16:04:48', 0),
(1065, '2', '2', '2', 'No', '2005-03-19 16:04:48', '2005-03-19 16:04:48', 0),
(1066, '2', '2', '2', 'No', '2005-04-04 16:04:48', '2005-04-04 16:04:48', 0),
(1067, '2', '2', '2', 'No', '2005-04-19 16:04:48', '2005-04-19 16:04:48', 0),
(1068, '2', '2', '2', 'No', '2005-05-04 16:04:48', '2005-05-04 16:04:48', 0),
(1069, '2', '2', '2', 'No', '2005-05-19 16:04:48', '2005-05-19 16:04:48', 0),
(1070, '2', '2', '2', 'No', '2005-06-03 16:04:48', '2005-06-03 16:04:48', 0),
(1071, '2', '2', '2', 'No', '2005-06-18 16:04:48', '2005-06-18 16:04:48', 0),
(1072, '2', '2', '2', 'No', '2005-07-04 16:04:48', '2005-07-04 16:04:48', 0),
(1073, '2', '2', '2', 'No', '2005-07-19 16:04:48', '2005-07-19 16:04:48', 0),
(1074, '2', '2', '2', 'No', '2005-08-03 16:04:48', '2005-08-03 16:04:48', 0),
(1075, '2', '2', '2', 'No', '2005-08-18 16:04:48', '2005-08-18 16:04:48', 0),
(1076, '2', '2', '2', 'No', '2005-09-02 16:04:48', '2005-09-02 16:04:48', 0),
(1077, '2', '2', '2', 'No', '2005-09-17 16:04:48', '2005-09-17 16:04:48', 0),
(1078, '2', '2', '2', 'No', '2005-10-03 16:04:48', '2005-10-03 16:04:48', 0),
(1079, '2', '2', '2', 'No', '2005-10-18 16:04:48', '2005-10-18 16:04:48', 0),
(1080, '2', '2', '2', 'No', '2005-11-02 16:04:48', '2005-11-02 16:04:48', 0),
(1081, '2', '2', '2', 'No', '2005-11-17 16:04:48', '2005-11-17 16:04:48', 0),
(1082, '2', '2', '2', 'No', '2005-12-02 16:04:48', '2005-12-02 16:04:48', 0),
(1083, '2', '2', '2', 'No', '2005-12-17 16:04:48', '2005-12-17 16:04:48', 0),
(1084, '2', '2', '2', 'No', '2006-01-02 16:04:48', '2006-01-02 16:04:48', 0),
(1085, '2', '2', '2', 'No', '2006-01-17 16:04:48', '2006-01-17 16:04:48', 0),
(1086, '2', '2', '2', 'No', '2006-02-01 16:04:48', '2006-02-01 16:04:48', 0),
(1087, '2', '2', '2', 'No', '2006-02-16 16:04:48', '2006-02-16 16:04:48', 0),
(1088, '2', '2', '2', 'No', '2006-03-03 16:04:48', '2006-03-03 16:04:48', 0),
(1089, '2', '2', '2', 'No', '2006-03-18 16:04:48', '2006-03-18 16:04:48', 0),
(1090, '2', '2', '2', 'No', '2006-04-03 16:04:48', '2006-04-03 16:04:48', 0),
(1091, '2', '2', '2', 'No', '2006-04-18 16:04:48', '2006-04-18 16:04:48', 0),
(1092, '2', '2', '2', 'No', '2006-05-03 16:04:48', '2006-05-03 16:04:48', 0),
(1093, '2', '2', '2', 'No', '2006-05-18 16:04:48', '2006-05-18 16:04:48', 0),
(1094, '2', '2', '2', 'No', '2006-06-02 16:04:48', '2006-06-02 16:04:48', 0),
(1095, '2', '2', '2', 'No', '2006-06-17 16:04:48', '2006-06-17 16:04:48', 0),
(1096, '2', '2', '2', 'No', '2006-07-03 16:04:48', '2006-07-03 16:04:48', 0),
(1097, '2', '2', '2', 'No', '2006-07-18 16:04:48', '2006-07-18 16:04:48', 0),
(1098, '2', '2', '2', 'No', '2006-08-02 16:04:48', '2006-08-02 16:04:48', 0),
(1099, '2', '2', '2', 'No', '2006-08-17 16:04:48', '2006-08-17 16:04:48', 0),
(1100, '2', '2', '2', 'No', '2006-09-01 16:04:48', '2006-09-01 16:04:48', 0),
(1101, '2', '2', '2', 'No', '2006-09-16 16:04:48', '2006-09-16 16:04:48', 0),
(1102, '2', '2', '2', 'No', '2006-10-02 16:04:48', '2006-10-02 16:04:48', 0),
(1103, '2', '2', '2', 'No', '2006-10-17 16:04:48', '2006-10-17 16:04:48', 0),
(1104, '2', '2', '2', 'No', '2006-11-01 16:04:48', '2006-11-01 16:04:48', 0),
(1105, '2', '2', '2', 'No', '2006-11-16 16:04:48', '2006-11-16 16:04:48', 0),
(1106, '2', '2', '2', 'No', '2006-12-01 16:04:48', '2006-12-01 16:04:48', 0),
(1107, '2', '2', '2', 'No', '2006-12-16 16:04:48', '2006-12-16 16:04:48', 0),
(1108, '2', '2', '2', 'No', '2007-01-01 16:04:48', '2007-01-01 16:04:48', 0),
(1109, '2', '2', '2', 'No', '2007-01-16 16:04:48', '2007-01-16 16:04:48', 0),
(1110, '2', '2', '2', 'No', '2007-01-31 16:04:48', '2007-01-31 16:04:48', 0),
(1111, '2', '2', '2', 'No', '2007-02-15 16:04:48', '2007-02-15 16:04:48', 0),
(1112, '2', '2', '2', 'No', '2007-03-02 16:04:48', '2007-03-02 16:04:48', 0),
(1113, '2', '2', '2', 'No', '2007-03-17 16:04:48', '2007-03-17 16:04:48', 0),
(1114, '2', '2', '2', 'No', '2007-04-02 16:04:48', '2007-04-02 16:04:48', 0),
(1115, '2', '2', '2', 'No', '2007-04-17 16:04:48', '2007-04-17 16:04:48', 0),
(1116, '2', '2', '2', 'No', '2007-05-02 16:04:48', '2007-05-02 16:04:48', 0),
(1117, '2', '2', '2', 'No', '2007-05-17 16:04:48', '2007-05-17 16:04:48', 0),
(1118, '2', '2', '2', 'No', '2007-06-01 16:04:48', '2007-06-01 16:04:48', 0),
(1119, '2', '2', '2', 'No', '2007-06-16 16:04:48', '2007-06-16 16:04:48', 0),
(1120, '2', '2', '2', 'No', '2007-07-02 16:04:48', '2007-07-02 16:04:48', 0),
(1121, '2', '2', '2', 'No', '2007-07-17 16:04:48', '2007-07-17 16:04:48', 0),
(1122, '2', '2', '2', 'No', '2007-08-01 16:04:48', '2007-08-01 16:04:48', 0),
(1123, '2', '2', '2', 'No', '2007-08-16 16:04:48', '2007-08-16 16:04:48', 0),
(1124, '2', '2', '2', 'No', '2007-08-31 16:04:48', '2007-08-31 16:04:48', 0),
(1125, '2', '2', '2', 'No', '2007-09-15 16:04:48', '2007-09-15 16:04:48', 0),
(1126, '2', '2', '2', 'No', '2007-10-01 16:04:48', '2007-10-01 16:04:48', 0),
(1127, '2', '2', '2', 'No', '2007-10-16 16:04:48', '2007-10-16 16:04:48', 0),
(1128, '2', '2', '2', 'No', '2007-10-31 16:04:48', '2007-10-31 16:04:48', 0),
(1129, '2', '2', '2', 'No', '2007-11-15 16:04:48', '2007-11-15 16:04:48', 0),
(1130, '2', '2', '2', 'No', '2007-11-30 16:04:48', '2007-11-30 16:04:48', 0),
(1131, '2', '2', '2', 'No', '2007-12-15 16:04:48', '2007-12-15 16:04:48', 0),
(1132, '2', '2', '2', 'No', '2007-12-31 16:04:48', '2007-12-31 16:04:48', 0),
(1133, '2', '2', '2', 'No', '2008-01-15 16:04:48', '2008-01-15 16:04:48', 0),
(1134, '2', '2', '2', 'No', '2008-01-30 16:04:48', '2008-01-30 16:04:48', 0),
(1135, '2', '2', '2', 'No', '2008-02-14 16:04:48', '2008-02-14 16:04:48', 0),
(1136, '2', '2', '2', 'No', '2008-02-29 16:04:48', '2008-02-29 16:04:48', 0),
(1137, '2', '2', '2', 'No', '2008-03-15 16:04:48', '2008-03-15 16:04:48', 0),
(1138, '2', '2', '2', 'No', '2008-03-31 16:04:48', '2008-03-31 16:04:48', 0),
(1139, '2', '2', '2', 'No', '2008-04-15 16:04:48', '2008-04-15 16:04:48', 0),
(1140, '2', '2', '2', 'No', '2008-04-30 16:04:48', '2008-04-30 16:04:48', 0),
(1141, '2', '2', '2', 'No', '2008-05-15 16:04:48', '2008-05-15 16:04:48', 0),
(1142, '2', '2', '2', 'No', '2008-05-30 16:04:48', '2008-05-30 16:04:48', 0),
(1143, '2', '2', '2', 'No', '2008-06-14 16:04:48', '2008-06-14 16:04:48', 0),
(1144, '2', '2', '2', 'No', '2008-06-30 16:04:48', '2008-06-30 16:04:48', 0),
(1145, '2', '2', '2', 'No', '2008-07-15 16:04:48', '2008-07-15 16:04:48', 0),
(1146, '2', '2', '2', 'No', '2008-07-30 16:04:48', '2008-07-30 16:04:48', 0),
(1147, '2', '2', '2', 'No', '2008-08-14 16:04:48', '2008-08-14 16:04:48', 0),
(1148, '2', '2', '2', 'No', '2008-08-29 16:04:48', '2008-08-29 16:04:48', 0),
(1149, '2', '2', '2', 'No', '2008-09-13 16:04:48', '2008-09-13 16:04:48', 0),
(1150, '2', '2', '2', 'No', '2008-09-29 16:04:48', '2008-09-29 16:04:48', 0),
(1151, '2', '2', '2', 'No', '2008-10-14 16:04:48', '2008-10-14 16:04:48', 0),
(1152, '2', '2', '2', 'No', '2008-10-29 16:04:48', '2008-10-29 16:04:48', 0),
(1153, '2', '2', '2', 'No', '2008-11-13 16:04:48', '2008-11-13 16:04:48', 0),
(1154, '2', '2', '2', 'No', '2008-11-28 16:04:48', '2008-11-28 16:04:48', 0),
(1155, '2', '2', '2', 'No', '2008-12-13 16:04:48', '2008-12-13 16:04:48', 0),
(1156, '2', '2', '2', 'No', '2008-12-29 16:04:48', '2008-12-29 16:04:48', 0),
(1157, '2', '2', '2', 'No', '2009-01-13 16:04:48', '2009-01-13 16:04:48', 0),
(1158, '2', '2', '2', 'No', '2009-01-28 16:04:48', '2009-01-28 16:04:48', 0),
(1159, '2', '2', '2', 'No', '2009-02-12 16:04:48', '2009-02-12 16:04:48', 0),
(1160, '2', '2', '2', 'No', '2009-02-27 16:04:48', '2009-02-27 16:04:48', 0),
(1161, '2', '2', '2', 'No', '2009-03-14 16:04:48', '2009-03-14 16:04:48', 0),
(1162, '2', '2', '2', 'No', '2009-03-30 16:04:48', '2009-03-30 16:04:48', 0),
(1163, '2', '2', '2', 'No', '2009-04-14 16:04:48', '2009-04-14 16:04:48', 0),
(1164, '2', '2', '2', 'No', '2009-04-29 16:04:48', '2009-04-29 16:04:48', 0),
(1165, '2', '2', '2', 'No', '2009-05-14 16:04:48', '2009-05-14 16:04:48', 0),
(1166, '2', '2', '2', 'No', '2009-05-29 16:04:48', '2009-05-29 16:04:48', 0),
(1167, '2', '2', '2', 'No', '2009-06-13 16:04:48', '2009-06-13 16:04:48', 0),
(1168, '2', '2', '2', 'No', '2009-06-29 16:04:48', '2009-06-29 16:04:48', 0),
(1169, '2', '2', '2', 'No', '2009-07-14 16:04:48', '2009-07-14 16:04:48', 0),
(1170, '2', '2', '2', 'No', '2009-07-29 16:04:48', '2009-07-29 16:04:48', 0),
(1171, '2', '2', '2', 'No', '2009-08-13 16:04:48', '2009-08-13 16:04:48', 0),
(1172, '2', '2', '2', 'No', '2009-08-28 16:04:48', '2009-08-28 16:04:48', 0),
(1173, '2', '2', '2', 'No', '2009-09-12 16:04:48', '2009-09-12 16:04:48', 0),
(1174, '2', '2', '2', 'No', '2009-09-28 16:04:48', '2009-09-28 16:04:48', 0),
(1175, '2', '2', '2', 'No', '2009-10-13 16:04:48', '2009-10-13 16:04:48', 0),
(1176, '2', '2', '2', 'No', '2009-10-28 16:04:48', '2009-10-28 16:04:48', 0),
(1177, '2', '2', '2', 'No', '2009-11-12 16:04:48', '2009-11-12 16:04:48', 0),
(1178, '2', '2', '2', 'No', '2009-11-27 16:04:48', '2009-11-27 16:04:48', 0),
(1179, '2', '2', '2', 'No', '2009-12-12 16:04:48', '2009-12-12 16:04:48', 0),
(1180, '2', '2', '2', 'No', '2009-12-28 16:04:48', '2009-12-28 16:04:48', 0),
(1181, '2', '2', '2', 'No', '2010-01-12 16:04:48', '2010-01-12 16:04:48', 0),
(1182, '2', '2', '2', 'No', '2010-01-27 16:04:48', '2010-01-27 16:04:48', 0),
(1183, '2', '2', '2', 'No', '2010-02-11 16:04:48', '2010-02-11 16:04:48', 0),
(1184, '2', '2', '2', 'No', '2010-02-26 16:04:48', '2010-02-26 16:04:48', 0),
(1185, '2', '2', '2', 'No', '2010-03-13 16:04:48', '2010-03-13 16:04:48', 0),
(1186, '2', '2', '2', 'No', '2010-03-29 16:04:48', '2010-03-29 16:04:48', 0),
(1187, '2', '2', '2', 'No', '2010-04-13 16:04:48', '2010-04-13 16:04:48', 0),
(1188, '2', '2', '2', 'No', '2010-04-28 16:04:48', '2010-04-28 16:04:48', 0),
(1189, '2', '2', '2', 'No', '2010-05-13 16:04:48', '2010-05-13 16:04:48', 0),
(1190, '2', '2', '2', 'No', '2010-05-28 16:04:48', '2010-05-28 16:04:48', 0),
(1191, '2', '2', '2', 'No', '2010-06-12 16:04:48', '2010-06-12 16:04:48', 0),
(1192, '2', '2', '2', 'No', '2010-06-28 16:04:48', '2010-06-28 16:04:48', 0),
(1193, '2', '2', '2', 'No', '2010-07-13 16:04:48', '2010-07-13 16:04:48', 0),
(1194, '2', '2', '2', 'No', '2010-07-28 16:04:48', '2010-07-28 16:04:48', 0),
(1195, '2', '2', '2', 'No', '2010-08-12 16:04:48', '2010-08-12 16:04:48', 0),
(1196, '2', '2', '2', 'No', '2010-08-27 16:04:48', '2010-08-27 16:04:48', 0),
(1197, '2', '2', '2', 'No', '2010-09-11 16:04:48', '2010-09-11 16:04:48', 0),
(1198, '2', '2', '2', 'No', '2010-09-27 16:04:48', '2010-09-27 16:04:48', 0),
(1199, '2', '2', '2', 'No', '2010-10-12 16:04:48', '2010-10-12 16:04:48', 0),
(1200, '2', '2', '2', 'No', '2010-10-27 16:04:48', '2010-10-27 16:04:48', 0),
(1201, '2', '2', '2', 'No', '2010-11-11 16:04:48', '2010-11-11 16:04:48', 0),
(1202, '2', '2', '2', 'No', '2010-11-26 16:04:48', '2010-11-26 16:04:48', 0),
(1203, '2', '2', '2', 'No', '2010-12-11 16:04:48', '2010-12-11 16:04:48', 0),
(1204, '2', '2', '2', 'No', '2010-12-27 16:04:48', '2010-12-27 16:04:48', 0),
(1205, '2', '2', '2', 'No', '2011-01-11 16:04:48', '2011-01-11 16:04:48', 0),
(1206, '2', '2', '2', 'No', '2011-01-26 16:04:48', '2011-01-26 16:04:48', 0),
(1207, '2', '2', '2', 'No', '2011-02-10 16:04:48', '2011-02-10 16:04:48', 0),
(1208, '2', '2', '2', 'No', '2011-02-25 16:04:48', '2011-02-25 16:04:48', 0),
(1209, '2', '2', '2', 'No', '2011-03-12 16:04:48', '2011-03-12 16:04:48', 0),
(1210, '2', '2', '2', 'No', '2011-03-28 16:04:48', '2011-03-28 16:04:48', 0),
(1211, '2', '2', '2', 'No', '2011-04-12 16:04:48', '2011-04-12 16:04:48', 0),
(1212, '2', '2', '2', 'No', '2011-04-27 16:04:48', '2011-04-27 16:04:48', 0),
(1213, '2', '2', '2', 'No', '2011-05-12 16:04:48', '2011-05-12 16:04:48', 0),
(1214, '2', '2', '2', 'No', '2011-05-27 16:04:48', '2011-05-27 16:04:48', 0),
(1215, '2', '2', '2', 'No', '2011-06-11 16:04:48', '2011-06-11 16:04:48', 0),
(1216, '2', '2', '2', 'No', '2011-06-27 16:04:48', '2011-06-27 16:04:48', 0),
(1217, '2', '2', '2', 'No', '2011-07-12 16:04:48', '2011-07-12 16:04:48', 0),
(1218, '2', '2', '2', 'No', '2011-07-27 16:04:48', '2011-07-27 16:04:48', 0),
(1219, '2', '2', '2', 'No', '2011-08-11 16:04:48', '2011-08-11 16:04:48', 0),
(1220, '2', '2', '2', 'No', '2011-08-26 16:04:48', '2011-08-26 16:04:48', 0),
(1221, '2', '2', '2', 'No', '2011-09-10 16:04:48', '2011-09-10 16:04:48', 0),
(1222, '2', '2', '2', 'No', '2011-09-26 16:04:48', '2011-09-26 16:04:48', 0),
(1223, '2', '2', '2', 'No', '2011-10-11 16:04:48', '2011-10-11 16:04:48', 0),
(1224, '2', '2', '2', 'No', '2011-10-26 16:04:48', '2011-10-26 16:04:48', 0),
(1225, '2', '2', '2', 'No', '2011-11-10 16:04:48', '2011-11-10 16:04:48', 0),
(1226, '2', '2', '2', 'No', '2011-11-25 16:04:48', '2011-11-25 16:04:48', 0),
(1227, '2', '2', '2', 'No', '2011-12-10 16:04:48', '2011-12-10 16:04:48', 0),
(1228, '2', '2', '2', 'No', '2011-12-26 16:04:48', '2011-12-26 16:04:48', 0),
(1229, '2', '2', '2', 'No', '2012-01-10 16:04:48', '2012-01-10 16:04:48', 0),
(1230, '2', '2', '2', 'No', '2012-01-25 16:04:48', '2012-01-25 16:04:48', 0),
(1231, '2', '2', '2', 'No', '2012-02-09 16:04:48', '2012-02-09 16:04:48', 0),
(1232, '2', '2', '2', 'No', '2012-02-24 16:04:48', '2012-02-24 16:04:48', 0),
(1233, '2', '2', '2', 'No', '2012-03-10 16:04:48', '2012-03-10 16:04:48', 0),
(1234, '2', '2', '2', 'No', '2012-03-26 16:04:48', '2012-03-26 16:04:48', 0),
(1235, '2', '2', '2', 'No', '2012-04-10 16:04:48', '2012-04-10 16:04:48', 0),
(1236, '2', '2', '2', 'No', '2012-04-25 16:04:48', '2012-04-25 16:04:48', 0),
(1237, '2', '2', '2', 'No', '2012-05-10 16:04:48', '2012-05-10 16:04:48', 0),
(1238, '2', '2', '2', 'No', '2012-05-25 16:04:48', '2012-05-25 16:04:48', 0),
(1239, '2', '2', '2', 'No', '2012-06-09 16:04:48', '2012-06-09 16:04:48', 0),
(1240, '2', '2', '2', 'No', '2012-06-25 16:04:48', '2012-06-25 16:04:48', 0),
(1241, '2', '2', '2', 'No', '2012-07-10 16:04:48', '2012-07-10 16:04:48', 0),
(1242, '2', '2', '2', 'No', '2012-07-25 16:04:48', '2012-07-25 16:04:48', 0),
(1243, '2', '2', '2', 'No', '2012-08-09 16:04:48', '2012-08-09 16:04:48', 0),
(1244, '2', '2', '2', 'No', '2012-08-24 16:04:48', '2012-08-24 16:04:48', 0),
(1245, '2', '2', '2', 'No', '2012-09-08 16:04:48', '2012-09-08 16:04:48', 0),
(1246, '2', '2', '2', 'No', '2012-09-24 16:04:48', '2012-09-24 16:04:48', 0),
(1247, '2', '2', '2', 'No', '2012-10-09 16:04:48', '2012-10-09 16:04:48', 0),
(1248, '2', '2', '2', 'No', '2012-10-24 16:04:48', '2012-10-24 16:04:48', 0),
(1249, '2', '2', '2', 'No', '2012-11-08 16:04:48', '2012-11-08 16:04:48', 0),
(1250, '2', '2', '2', 'No', '2012-11-23 16:04:48', '2012-11-23 16:04:48', 0),
(1251, '2', '2', '2', 'No', '2012-12-08 16:04:48', '2012-12-08 16:04:48', 0),
(1252, '2', '2', '2', 'No', '2012-12-24 16:04:48', '2012-12-24 16:04:48', 0),
(1253, '2', '2', '2', 'No', '2013-01-08 16:04:48', '2013-01-08 16:04:48', 0),
(1254, '2', '2', '2', 'No', '2013-01-23 16:04:48', '2013-01-23 16:04:48', 0),
(1255, '2', '2', '2', 'No', '2013-02-07 16:04:48', '2013-02-07 16:04:48', 0),
(1256, '2', '2', '2', 'No', '2013-02-22 16:04:48', '2013-02-22 16:04:48', 0),
(1257, '2', '2', '2', 'No', '2013-03-09 16:04:48', '2013-03-09 16:04:48', 0),
(1258, '2', '2', '2', 'No', '2013-03-25 16:04:48', '2013-03-25 16:04:48', 0),
(1259, '2', '2', '2', 'No', '2013-04-09 16:04:48', '2013-04-09 16:04:48', 0),
(1260, '2', '2', '2', 'No', '2013-04-24 16:04:48', '2013-04-24 16:04:48', 0),
(1261, '2', '2', '2', 'No', '2013-05-09 16:04:48', '2013-05-09 16:04:48', 0),
(1262, '2', '2', '2', 'No', '2013-05-24 16:04:48', '2013-05-24 16:04:48', 0),
(1263, '2', '2', '2', 'No', '2013-06-08 16:04:48', '2013-06-08 16:04:48', 0),
(1264, '2', '2', '2', 'No', '2013-06-24 16:04:48', '2013-06-24 16:04:48', 0),
(1265, '2', '2', '2', 'No', '2013-07-09 16:04:48', '2013-07-09 16:04:48', 0),
(1266, '2', '2', '2', 'No', '2013-07-24 16:04:48', '2013-07-24 16:04:48', 0),
(1267, '2', '2', '2', 'No', '2013-08-08 16:04:48', '2013-08-08 16:04:48', 0),
(1268, '2', '2', '2', 'No', '2013-08-23 16:04:48', '2013-08-23 16:04:48', 0),
(1269, '2', '2', '2', 'No', '2013-09-07 16:04:48', '2013-09-07 16:04:48', 0),
(1270, '2', '2', '2', 'No', '2013-09-23 16:04:48', '2013-09-23 16:04:48', 0),
(1271, '2', '2', '2', 'No', '2013-10-08 16:04:48', '2013-10-08 16:04:48', 0),
(1272, '2', '2', '2', 'No', '2013-10-23 16:04:48', '2013-10-23 16:04:48', 0),
(1273, '2', '2', '2', 'No', '2013-11-07 16:04:48', '2013-11-07 16:04:48', 0),
(1274, '2', '2', '2', 'No', '2013-11-22 16:04:48', '2013-11-22 16:04:48', 0),
(1275, '2', '2', '2', 'No', '2013-12-07 16:04:48', '2013-12-07 16:04:48', 0),
(1276, '2', '2', '2', 'No', '2013-12-23 16:04:48', '2013-12-23 16:04:48', 0),
(1277, '2', '2', '2', 'No', '2014-01-07 16:04:48', '2014-01-07 16:04:48', 0),
(1278, '2', '2', '2', 'No', '2014-01-22 16:04:48', '2014-01-22 16:04:48', 0),
(1279, '2', '2', '2', 'No', '2014-02-06 16:04:48', '2014-02-06 16:04:48', 0),
(1280, '2', '2', '2', 'No', '2014-02-21 16:04:48', '2014-02-21 16:04:48', 0),
(1281, '2', '2', '2', 'No', '2014-03-08 16:04:48', '2014-03-08 16:04:48', 0),
(1282, '2', '2', '2', 'No', '2014-03-24 16:04:48', '2014-03-24 16:04:48', 0),
(1283, '2', '2', '2', 'No', '2014-04-08 16:04:48', '2014-04-08 16:04:48', 0),
(1284, '2', '2', '2', 'No', '2014-04-23 16:04:48', '2014-04-23 16:04:48', 0),
(1285, '2', '2', '2', 'No', '2014-05-08 16:04:48', '2014-05-08 16:04:48', 0),
(1286, '2', '2', '2', 'No', '2014-05-23 16:04:48', '2014-05-23 16:04:48', 0),
(1287, '2', '2', '2', 'No', '2014-06-07 16:04:48', '2014-06-07 16:04:48', 0),
(1288, '2', '2', '2', 'No', '2014-06-23 16:04:48', '2014-06-23 16:04:48', 0),
(1289, '2', '2', '2', 'No', '2014-07-08 16:04:48', '2014-07-08 16:04:48', 0),
(1290, '2', '2', '2', 'No', '2014-07-23 16:04:48', '2014-07-23 16:04:48', 0),
(1291, '2', '2', '2', 'No', '2014-08-07 16:04:48', '2014-08-07 16:04:48', 0),
(1292, '2', '2', '2', 'No', '2014-08-22 16:04:48', '2014-08-22 16:04:48', 0),
(1293, '2', '2', '2', 'No', '2014-09-06 16:04:48', '2014-09-06 16:04:48', 0),
(1294, '2', '2', '2', 'No', '2014-09-22 16:04:48', '2014-09-22 16:04:48', 0),
(1295, '2', '2', '2', 'No', '2014-10-07 16:04:48', '2014-10-07 16:04:48', 0),
(1296, '2', '2', '2', 'No', '2014-10-22 16:04:48', '2014-10-22 16:04:48', 0),
(1297, '2', '2', '2', 'No', '2014-11-06 16:04:48', '2014-11-06 16:04:48', 0),
(1298, '2', '2', '2', 'No', '2014-11-21 16:04:48', '2014-11-21 16:04:48', 0),
(1299, '2', '2', '2', 'No', '2014-12-06 16:04:48', '2014-12-06 16:04:48', 0),
(1300, '2', '2', '2', 'No', '2014-12-22 16:04:48', '2014-12-22 16:04:48', 0),
(1301, '2', '2', '2', 'No', '2015-01-06 16:04:48', '2015-01-06 16:04:48', 0),
(1302, '2', '2', '2', 'No', '2015-01-21 16:04:48', '2015-01-21 16:04:48', 0),
(1303, '2', '2', '2', 'No', '2015-02-05 16:04:48', '2015-02-05 16:04:48', 0),
(1304, '2', '2', '2', 'No', '2015-02-20 16:04:48', '2015-02-20 16:04:48', 0),
(1305, '2', '2', '2', 'No', '2015-03-07 16:04:48', '2015-03-07 16:04:48', 0),
(1306, '2', '2', '2', 'No', '2015-03-23 16:04:48', '2015-03-23 16:04:48', 0),
(1307, '2', '2', '2', 'No', '2015-04-07 16:04:48', '2015-04-07 16:04:48', 0),
(1308, '2', '2', '2', 'No', '2015-04-22 16:04:48', '2015-04-22 16:04:48', 0),
(1309, '2', '2', '2', 'No', '2015-05-07 16:04:48', '2015-05-07 16:04:48', 0),
(1310, '2', '2', '2', 'No', '2015-05-22 16:04:48', '2015-05-22 16:04:48', 0),
(1311, '2', '2', '2', 'No', '2015-06-06 16:04:48', '2015-06-06 16:04:48', 0),
(1312, '2', '2', '2', 'No', '2015-06-22 16:04:48', '2015-06-22 16:04:48', 0),
(1313, '2', '2', '2', 'No', '2015-07-07 16:04:48', '2015-07-07 16:04:48', 0),
(1314, '2', '2', '2', 'No', '2015-07-22 16:04:48', '2015-07-22 16:04:48', 0),
(1315, '2', '2', '2', 'No', '2015-08-06 16:04:48', '2015-08-06 16:04:48', 0),
(1316, '2', '2', '2', 'No', '2015-08-21 16:04:48', '2015-08-21 16:04:48', 0),
(1317, '2', '2', '2', 'No', '2015-09-05 16:04:48', '2015-09-05 16:04:48', 0),
(1318, '2', '2', '2', 'No', '2015-09-21 16:04:48', '2015-09-21 16:04:48', 0),
(1319, '2', '2', '2', 'No', '2015-10-06 16:04:48', '2015-10-06 16:04:48', 0),
(1320, '2', '2', '2', 'No', '2015-10-21 16:04:48', '2015-10-21 16:04:48', 0),
(1321, '2', '2', '2', 'No', '2015-11-05 16:04:48', '2015-11-05 16:04:48', 0),
(1322, '2', '2', '2', 'No', '2015-11-20 16:04:48', '2015-11-20 16:04:48', 0),
(1323, '2', '2', '2', 'No', '2015-12-05 16:04:48', '2015-12-05 16:04:48', 0),
(1324, '2', '2', '2', 'No', '2015-12-21 16:04:48', '2015-12-21 16:04:48', 0),
(1325, '2', '2', '2', 'No', '2016-01-05 16:04:48', '2016-01-05 16:04:48', 0);
INSERT INTO `krakpi_calendar_map` (`krakpi_calendar_map_id`, `krakpi_id`, `krakpi_ref_id`, `kra_category`, `calendar`, `from_date`, `to_date`, `work_status`) VALUES
(1326, '2', '2', '2', 'No', '2016-01-20 16:04:48', '2016-01-20 16:04:48', 0),
(1327, '2', '2', '2', 'No', '2016-02-04 16:04:48', '2016-02-04 16:04:48', 0),
(1328, '2', '2', '2', 'No', '2016-02-19 16:04:48', '2016-02-19 16:04:48', 0),
(1329, '2', '2', '2', 'No', '2016-03-05 16:04:48', '2016-03-05 16:04:48', 0),
(1330, '2', '2', '2', 'No', '2016-03-21 16:04:48', '2016-03-21 16:04:48', 0),
(1331, '2', '2', '2', 'No', '2016-04-05 16:04:48', '2016-04-05 16:04:48', 0),
(1332, '2', '2', '2', 'No', '2016-04-20 16:04:48', '2016-04-20 16:04:48', 0),
(1333, '2', '2', '2', 'No', '2016-05-05 16:04:48', '2016-05-05 16:04:48', 0),
(1334, '2', '2', '2', 'No', '2016-05-20 16:04:48', '2016-05-20 16:04:48', 0),
(1335, '2', '2', '2', 'No', '2016-06-04 16:04:48', '2016-06-04 16:04:48', 0),
(1336, '2', '2', '2', 'No', '2016-06-20 16:04:48', '2016-06-20 16:04:48', 0),
(1337, '2', '2', '2', 'No', '2016-07-05 16:04:48', '2016-07-05 16:04:48', 0),
(1338, '2', '2', '2', 'No', '2016-07-20 16:04:48', '2016-07-20 16:04:48', 0),
(1339, '2', '2', '2', 'No', '2016-08-04 16:04:48', '2016-08-04 16:04:48', 0),
(1340, '2', '2', '2', 'No', '2016-08-19 16:04:48', '2016-08-19 16:04:48', 0),
(1341, '2', '2', '2', 'No', '2016-09-03 16:04:48', '2016-09-03 16:04:48', 0),
(1342, '2', '2', '2', 'No', '2016-09-19 16:04:48', '2016-09-19 16:04:48', 0),
(1343, '2', '2', '2', 'No', '2016-10-04 16:04:48', '2016-10-04 16:04:48', 0),
(1344, '2', '2', '2', 'No', '2016-10-19 16:04:48', '2016-10-19 16:04:48', 0),
(1345, '2', '2', '2', 'No', '2016-11-03 16:04:48', '2016-11-03 16:04:48', 0),
(1346, '2', '2', '2', 'No', '2016-11-18 16:04:48', '2016-11-18 16:04:48', 0),
(1347, '2', '2', '2', 'No', '2016-12-03 16:04:48', '2016-12-03 16:04:48', 0),
(1348, '2', '2', '2', 'No', '2016-12-19 16:04:48', '2016-12-19 16:04:48', 0),
(1349, '2', '2', '2', 'No', '2017-01-03 16:04:48', '2017-01-03 16:04:48', 0),
(1350, '2', '2', '2', 'No', '2017-01-18 16:04:48', '2017-01-18 16:04:48', 0),
(1351, '2', '2', '2', 'No', '2017-02-02 16:04:48', '2017-02-02 16:04:48', 0),
(1352, '2', '2', '2', 'No', '2017-02-17 16:04:48', '2017-02-17 16:04:48', 0),
(1353, '2', '2', '2', 'No', '2017-03-04 16:04:48', '2017-03-04 16:04:48', 0),
(1354, '2', '2', '2', 'No', '2017-03-20 16:04:48', '2017-03-20 16:04:48', 0),
(1355, '2', '2', '2', 'No', '2017-04-04 16:04:48', '2017-04-04 16:04:48', 0),
(1356, '2', '2', '2', 'No', '2017-04-19 16:04:48', '2017-04-19 16:04:48', 0),
(1357, '2', '2', '2', 'No', '2017-05-04 16:04:48', '2017-05-04 16:04:48', 0),
(1358, '2', '2', '2', 'No', '2017-05-19 16:04:48', '2017-05-19 16:04:48', 0),
(1359, '2', '2', '2', 'No', '2017-06-03 16:04:48', '2017-06-03 16:04:48', 0),
(1360, '2', '2', '2', 'No', '2017-06-19 16:04:48', '2017-06-19 16:04:48', 0),
(1361, '2', '2', '2', 'No', '2017-07-04 16:04:48', '2017-07-04 16:04:48', 0),
(1362, '2', '2', '2', 'No', '2017-07-19 16:04:48', '2017-07-19 16:04:48', 0),
(1363, '2', '2', '2', 'No', '2017-08-03 16:04:48', '2017-08-03 16:04:48', 0),
(1364, '2', '2', '2', 'No', '2017-08-18 16:04:48', '2017-08-18 16:04:48', 0),
(1365, '2', '2', '2', 'No', '2017-09-02 16:04:48', '2017-09-02 16:04:48', 0),
(1366, '2', '2', '2', 'No', '2017-09-18 16:04:48', '2017-09-18 16:04:48', 0),
(1367, '2', '2', '2', 'No', '2017-10-03 16:04:48', '2017-10-03 16:04:48', 0),
(1368, '2', '2', '2', 'No', '2017-10-18 16:04:48', '2017-10-18 16:04:48', 0),
(1369, '2', '2', '2', 'No', '2017-11-02 16:04:48', '2017-11-02 16:04:48', 0),
(1370, '2', '2', '2', 'No', '2017-11-17 16:04:48', '2017-11-17 16:04:48', 0),
(1371, '2', '2', '2', 'No', '2017-12-02 16:04:48', '2017-12-02 16:04:48', 0),
(1372, '2', '2', '2', 'No', '2017-12-18 16:04:48', '2017-12-18 16:04:48', 0),
(1373, '2', '2', '2', 'No', '2018-01-02 16:04:48', '2018-01-02 16:04:48', 0),
(1374, '2', '2', '2', 'No', '2018-01-17 16:04:48', '2018-01-17 16:04:48', 0),
(1375, '2', '2', '2', 'No', '2018-02-01 16:04:48', '2018-02-01 16:04:48', 0),
(1376, '2', '2', '2', 'No', '2018-02-16 16:04:48', '2018-02-16 16:04:48', 0),
(1377, '2', '2', '2', 'No', '2018-03-03 16:04:48', '2018-03-03 16:04:48', 0),
(1378, '2', '2', '2', 'No', '2018-03-19 16:04:48', '2018-03-19 16:04:48', 0),
(1379, '2', '2', '2', 'No', '2018-04-03 16:04:48', '2018-04-03 16:04:48', 0),
(1380, '2', '2', '2', 'No', '2018-04-18 16:04:48', '2018-04-18 16:04:48', 0),
(1381, '2', '2', '2', 'No', '2018-05-03 16:04:48', '2018-05-03 16:04:48', 0),
(1382, '2', '2', '2', 'No', '2018-05-18 16:04:48', '2018-05-18 16:04:48', 0),
(1383, '2', '2', '2', 'No', '2018-06-02 16:04:48', '2018-06-02 16:04:48', 0),
(1384, '2', '2', '2', 'No', '2018-06-18 16:04:48', '2018-06-18 16:04:48', 0),
(1385, '2', '2', '2', 'No', '2018-07-03 16:04:48', '2018-07-03 16:04:48', 0),
(1386, '2', '2', '2', 'No', '2018-07-18 16:04:48', '2018-07-18 16:04:48', 0),
(1387, '2', '2', '2', 'No', '2018-08-02 16:04:48', '2018-08-02 16:04:48', 0),
(1388, '2', '2', '2', 'No', '2018-08-17 16:04:48', '2018-08-17 16:04:48', 0),
(1389, '2', '2', '2', 'No', '2018-09-01 16:04:48', '2018-09-01 16:04:48', 0),
(1390, '2', '2', '2', 'No', '2018-09-17 16:04:48', '2018-09-17 16:04:48', 0),
(1391, '2', '2', '2', 'No', '2018-10-02 16:04:48', '2018-10-02 16:04:48', 0),
(1392, '2', '2', '2', 'No', '2018-10-17 16:04:48', '2018-10-17 16:04:48', 0),
(1393, '2', '2', '2', 'No', '2018-11-01 16:04:48', '2018-11-01 16:04:48', 0),
(1394, '2', '2', '2', 'No', '2018-11-16 16:04:48', '2018-11-16 16:04:48', 0),
(1395, '2', '2', '2', 'No', '2018-12-01 16:04:48', '2018-12-01 16:04:48', 0),
(1396, '2', '2', '2', 'No', '2018-12-17 16:04:48', '2018-12-17 16:04:48', 0),
(1397, '2', '2', '2', 'No', '2019-01-01 16:04:48', '2019-01-01 16:04:48', 0),
(1398, '2', '2', '2', 'No', '2019-01-16 16:04:48', '2019-01-16 16:04:48', 0),
(1399, '2', '2', '2', 'No', '2019-01-31 16:04:48', '2019-01-31 16:04:48', 0),
(1400, '2', '2', '2', 'No', '2019-02-15 16:04:48', '2019-02-15 16:04:48', 0),
(1401, '2', '2', '2', 'No', '2019-03-02 16:04:48', '2019-03-02 16:04:48', 0),
(1402, '2', '2', '2', 'No', '2019-03-18 16:04:48', '2019-03-18 16:04:48', 0),
(1403, '2', '2', '2', 'No', '2019-04-02 16:04:48', '2019-04-02 16:04:48', 0),
(1404, '2', '2', '2', 'No', '2019-04-17 16:04:48', '2019-04-17 16:04:48', 0),
(1405, '2', '2', '2', 'No', '2019-05-02 16:04:48', '2019-05-02 16:04:48', 0),
(1406, '2', '2', '2', 'No', '2019-05-17 16:04:48', '2019-05-17 16:04:48', 0),
(1407, '2', '2', '2', 'No', '2019-06-01 16:04:48', '2019-06-01 16:04:48', 0),
(1408, '2', '2', '2', 'No', '2019-06-17 16:04:48', '2019-06-17 16:04:48', 0),
(1409, '2', '2', '2', 'No', '2019-07-02 16:04:48', '2019-07-02 16:04:48', 0),
(1410, '2', '2', '2', 'No', '2019-07-17 16:04:48', '2019-07-17 16:04:48', 0),
(1411, '2', '2', '2', 'No', '2019-08-01 16:04:48', '2019-08-01 16:04:48', 0),
(1412, '2', '2', '2', 'No', '2019-08-16 16:04:48', '2019-08-16 16:04:48', 0),
(1413, '2', '2', '2', 'No', '2019-08-31 16:04:48', '2019-08-31 16:04:48', 0),
(1414, '2', '2', '2', 'No', '2019-09-16 16:04:48', '2019-09-16 16:04:48', 0),
(1415, '2', '2', '2', 'No', '2019-10-01 16:04:48', '2019-10-01 16:04:48', 0),
(1416, '2', '2', '2', 'No', '2019-10-16 16:04:48', '2019-10-16 16:04:48', 0),
(1417, '2', '2', '2', 'No', '2019-10-31 16:04:48', '2019-10-31 16:04:48', 0),
(1418, '2', '2', '2', 'No', '2019-11-15 16:04:48', '2019-11-15 16:04:48', 0),
(1419, '2', '2', '2', 'No', '2019-11-30 16:04:48', '2019-11-30 16:04:48', 0),
(1420, '2', '2', '2', 'No', '2019-12-16 16:04:48', '2019-12-16 16:04:48', 0),
(1421, '2', '2', '2', 'No', '2019-12-31 16:04:48', '2019-12-31 16:04:48', 0),
(1422, '2', '2', '2', 'No', '2020-01-15 16:04:48', '2020-01-15 16:04:48', 0),
(1423, '2', '2', '2', 'No', '2020-01-30 16:04:48', '2020-01-30 16:04:48', 0),
(1424, '2', '2', '2', 'No', '2020-02-14 16:04:48', '2020-02-14 16:04:48', 0),
(1425, '2', '2', '2', 'No', '2020-02-29 16:04:48', '2020-02-29 16:04:48', 0),
(1426, '2', '2', '2', 'No', '2020-03-16 16:04:48', '2020-03-16 16:04:48', 0),
(1427, '2', '2', '2', 'No', '2020-03-31 16:04:48', '2020-03-31 16:04:48', 0),
(1428, '2', '2', '2', 'No', '2020-04-15 16:04:48', '2020-04-15 16:04:48', 0),
(1429, '2', '2', '2', 'No', '2020-04-30 16:04:48', '2020-04-30 16:04:48', 0),
(1430, '2', '2', '2', 'No', '2020-05-15 16:04:48', '2020-05-15 16:04:48', 0),
(1431, '2', '2', '2', 'No', '2020-05-30 16:04:48', '2020-05-30 16:04:48', 0),
(1432, '2', '2', '2', 'No', '2020-06-15 16:04:48', '2020-06-15 16:04:48', 0),
(1433, '2', '2', '2', 'No', '2020-06-30 16:04:48', '2020-06-30 16:04:48', 0),
(1434, '2', '2', '2', 'No', '2020-07-15 16:04:48', '2020-07-15 16:04:48', 0),
(1435, '2', '2', '2', 'No', '2020-07-30 16:04:48', '2020-07-30 16:04:48', 0),
(1436, '2', '2', '2', 'No', '2020-08-14 16:04:48', '2020-08-14 16:04:48', 0),
(1437, '2', '2', '2', 'No', '2020-08-29 16:04:48', '2020-08-29 16:04:48', 0),
(1438, '2', '2', '2', 'No', '2020-09-14 16:04:48', '2020-09-14 16:04:48', 0),
(1439, '2', '2', '2', 'No', '2020-09-29 16:04:48', '2020-09-29 16:04:48', 0),
(1440, '2', '2', '2', 'No', '2020-10-14 16:04:48', '2020-10-14 16:04:48', 0),
(1441, '2', '2', '2', 'No', '2020-10-29 16:04:48', '2020-10-29 16:04:48', 0),
(1442, '2', '2', '2', 'No', '2020-11-13 16:04:48', '2020-11-13 16:04:48', 0),
(1443, '2', '2', '2', 'No', '2020-11-28 16:04:48', '2020-11-28 16:04:48', 0),
(1444, '2', '2', '2', 'No', '2020-12-14 16:04:48', '2020-12-14 16:04:48', 0),
(1445, '2', '2', '2', 'No', '2020-12-29 16:04:48', '2020-12-29 16:04:48', 0),
(1446, '2', '2', '2', 'No', '2021-01-13 16:04:48', '2021-01-13 16:04:48', 0),
(1447, '2', '2', '2', 'No', '2021-01-28 16:04:48', '2021-01-28 16:04:48', 0),
(1448, '2', '2', '2', 'No', '2021-02-12 16:04:48', '2021-02-12 16:04:48', 0),
(1449, '2', '2', '2', 'No', '2021-02-27 16:04:48', '2021-02-27 16:04:48', 0),
(1450, '2', '2', '2', 'No', '2021-03-15 16:04:48', '2021-03-15 16:04:48', 0),
(1451, '2', '2', '2', 'No', '2021-03-30 16:04:48', '2021-03-30 16:04:48', 0),
(1452, '2', '2', '2', 'No', '2021-04-14 16:04:48', '2021-04-14 16:04:48', 0),
(1453, '2', '2', '2', 'No', '2021-04-29 16:04:48', '2021-04-29 16:04:48', 0),
(1454, '2', '2', '2', 'No', '2021-05-14 16:04:48', '2021-05-14 16:04:48', 0),
(1455, '2', '2', '2', 'No', '2021-05-29 16:04:48', '2021-05-29 16:04:48', 0),
(1456, '2', '2', '2', 'No', '2021-06-14 16:04:48', '2021-06-14 16:04:48', 0),
(1457, '2', '2', '2', 'No', '2021-06-29 16:04:48', '2021-06-29 16:04:48', 0),
(1458, '2', '2', '2', 'No', '2021-07-14 16:04:48', '2021-07-14 16:04:48', 0),
(1459, '2', '2', '2', 'No', '2021-07-29 16:04:48', '2021-07-29 16:04:48', 0),
(1460, '2', '2', '2', 'No', '2021-08-13 16:04:48', '2021-08-13 16:04:48', 0),
(1461, '2', '2', '2', 'No', '2021-08-28 16:04:48', '2021-08-28 16:04:48', 0),
(1462, '2', '2', '2', 'No', '2021-09-13 16:04:48', '2021-09-13 16:04:48', 0),
(1463, '2', '2', '2', 'No', '2021-09-28 16:04:48', '2021-09-28 16:04:48', 0),
(1464, '2', '2', '2', 'No', '2021-10-13 16:04:48', '2021-10-13 16:04:48', 0),
(1465, '2', '2', '2', 'No', '2021-10-28 16:04:48', '2021-10-28 16:04:48', 0),
(1466, '2', '2', '2', 'No', '2021-11-12 16:04:48', '2021-11-12 16:04:48', 0),
(1467, '2', '2', '2', 'No', '2021-11-27 16:04:48', '2021-11-27 16:04:48', 0),
(1468, '2', '2', '2', 'No', '2021-12-13 16:04:48', '2021-12-13 16:04:48', 0),
(1469, '2', '2', '2', 'No', '2021-12-28 16:04:48', '2021-12-28 16:04:48', 0),
(1470, '2', '2', '2', 'No', '2022-01-12 16:04:48', '2022-01-12 16:04:48', 0),
(1471, '2', '2', '2', 'No', '2022-01-27 16:04:48', '2022-01-27 16:04:48', 0),
(1472, '2', '2', '2', 'No', '2022-02-11 16:04:48', '2022-02-11 16:04:48', 0),
(1473, '2', '2', '2', 'No', '2022-02-26 16:04:48', '2022-02-26 16:04:48', 0),
(1474, '2', '2', '2', 'No', '2022-03-14 16:04:48', '2022-03-14 16:04:48', 0),
(1475, '2', '2', '2', 'No', '2022-03-29 16:04:48', '2022-03-29 16:04:48', 0),
(1476, '2', '2', '2', 'No', '2022-04-13 16:04:48', '2022-04-13 16:04:48', 0),
(1477, '2', '2', '2', 'No', '2022-04-28 16:04:48', '2022-04-28 16:04:48', 0),
(1478, '2', '2', '2', 'No', '2022-05-13 16:04:48', '2022-05-13 16:04:48', 0),
(1479, '2', '2', '2', 'No', '2022-05-28 16:04:48', '2022-05-28 16:04:48', 0),
(1480, '2', '2', '2', 'No', '2022-06-13 16:04:48', '2022-06-13 16:04:48', 0),
(1481, '2', '2', '2', 'No', '2022-06-28 16:04:48', '2022-06-28 16:04:48', 0),
(1482, '2', '2', '2', 'No', '2022-07-13 16:04:48', '2022-07-13 16:04:48', 0),
(1483, '2', '2', '2', 'No', '2022-07-28 16:04:48', '2022-07-28 16:04:48', 0),
(1484, '2', '2', '2', 'No', '2022-08-12 16:04:48', '2022-08-12 16:04:48', 0),
(1485, '2', '2', '2', 'No', '2022-08-27 16:04:48', '2022-08-27 16:04:48', 0),
(1486, '2', '2', '2', 'No', '2022-09-12 16:04:48', '2022-09-12 16:04:48', 0),
(1487, '2', '2', '2', 'No', '2022-09-27 16:04:48', '2022-09-27 16:04:48', 0),
(1488, '2', '2', '2', 'No', '2022-10-12 16:04:48', '2022-10-12 16:04:48', 0),
(1489, '2', '2', '2', 'No', '2022-10-27 16:04:48', '2022-10-27 16:04:48', 0),
(1490, '2', '2', '2', 'No', '2022-11-11 16:04:48', '2022-11-11 16:04:48', 0),
(1491, '2', '2', '2', 'No', '2022-11-26 16:04:48', '2022-11-26 16:04:48', 0),
(1492, '2', '2', '2', 'No', '2022-12-12 16:04:48', '2022-12-12 16:04:48', 0),
(1493, '2', '2', '2', 'No', '2022-12-27 16:04:48', '2022-12-27 16:04:48', 0),
(1494, '2', '2', '2', 'No', '2023-01-11 16:04:48', '2023-01-11 16:04:48', 0),
(1495, '2', '2', '2', 'No', '2023-01-26 16:04:48', '2023-01-26 16:04:48', 0),
(1496, '2', '2', '2', 'No', '2023-02-10 16:04:48', '2023-02-10 16:04:48', 0),
(1497, '2', '2', '2', 'No', '2023-02-25 16:04:48', '2023-02-25 16:04:48', 0),
(1498, '2', '2', '2', 'No', '2023-03-13 16:04:48', '2023-03-13 16:04:48', 0),
(1499, '2', '2', '2', 'No', '2023-03-28 16:04:48', '2023-03-28 16:04:48', 0),
(1500, '2', '2', '2', 'No', '2023-04-12 16:04:48', '2023-04-12 16:04:48', 0),
(1501, '2', '2', '2', 'No', '2023-04-27 16:04:48', '2023-04-27 16:04:48', 0),
(1502, '2', '2', '2', 'No', '2023-05-12 16:04:48', '2023-05-12 16:04:48', 0),
(1503, '2', '2', '2', 'No', '2023-05-27 16:04:48', '2023-05-27 16:04:48', 0),
(1504, '2', '2', '2', 'No', '2023-06-12 16:04:48', '2023-06-12 16:04:48', 0),
(1505, '2', '2', '2', 'No', '2023-06-27 16:04:48', '2023-06-27 16:04:48', 0),
(1506, '2', '2', '2', 'No', '2023-07-12 16:04:48', '2023-07-12 16:04:48', 0),
(1507, '2', '2', '2', 'No', '2023-07-27 16:04:48', '2023-07-27 16:04:48', 0),
(1508, '2', '2', '2', 'No', '2023-08-11 16:04:48', '2023-08-11 16:04:48', 0),
(1509, '2', '2', '2', 'No', '2023-08-26 16:04:48', '2023-08-26 16:04:48', 0),
(1510, '2', '2', '2', 'No', '2023-09-11 16:04:48', '2023-09-11 16:04:48', 0),
(1511, '2', '2', '2', 'No', '2023-09-26 16:04:48', '2023-09-26 16:04:48', 0),
(1512, '2', '2', '2', 'No', '2023-10-11 16:04:48', '2023-10-11 16:04:48', 0),
(1513, '2', '2', '2', 'No', '2023-10-26 16:04:48', '2023-10-26 16:04:48', 0),
(1514, '2', '2', '2', 'No', '2023-11-10 16:04:48', '2023-11-10 16:04:48', 0),
(1515, '2', '2', '2', 'No', '2023-11-25 16:04:48', '2023-11-25 16:04:48', 0),
(1516, '2', '2', '2', 'No', '2023-12-11 16:04:48', '2023-12-11 16:04:48', 0),
(1517, '2', '2', '2', 'No', '2023-12-26 16:04:48', '2023-12-26 16:04:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table `krakpi_creation`
--

CREATE TABLE `krakpi_creation` (
  `krakpi_id` int(11) NOT NULL,
  `company_name` varchar(11) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `designation` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `krakpi_creation`
--

INSERT INTO `krakpi_creation` (`krakpi_id`, `company_name`, `department`, `designation`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', '1', 0, 1, NULL, NULL, '2023-06-06 16:04:26', '2023-06-06 16:04:26'),
(2, '2', '7', '8', 0, 1, NULL, NULL, '2023-06-06 16:04:48', '2023-06-06 16:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `krakpi_creation_ref`
--

CREATE TABLE `krakpi_creation_ref` (
  `krakpi_ref_id` int(11) NOT NULL,
  `krakpi_reff_id` int(11) DEFAULT NULL,
  `kra_category` varchar(255) DEFAULT NULL,
  `rr` varchar(255) DEFAULT NULL,
  `kpi` varchar(255) DEFAULT NULL,
  `frequency` varchar(250) DEFAULT NULL,
  `frequency_applicable` varchar(50) DEFAULT NULL,
  `calendar` varchar(255) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `criteria` varchar(250) DEFAULT NULL,
  `project_id` varchar(250) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `krakpi_creation_ref`
--

INSERT INTO `krakpi_creation_ref` (`krakpi_ref_id`, `krakpi_reff_id`, `kra_category`, `rr`, `kpi`, `frequency`, `frequency_applicable`, `calendar`, `from_date`, `to_date`, `criteria`, `project_id`, `work_status`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 1, '1', '1', '', 'Quaterly', 'frequency_applicable', 'No', '', '', 'Project', '1', 0, 0, 1, NULL, NULL, '2023-06-06 16:04:26', '2023-06-06 16:04:26'),
(2, 2, '2', '4', '', 'Fortnightly', 'frequency_applicable', 'No', '', '', 'Event', '', 0, 0, 1, NULL, NULL, '2023-06-06 16:04:48', '2023-06-06 16:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `kra_creation`
--

CREATE TABLE `kra_creation` (
  `kra_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `designation_id` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kra_creation`
--

INSERT INTO `kra_creation` (`kra_id`, `company_id`, `department_id`, `designation_id`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', '1', 0, 1, NULL, NULL, '2023-06-06 16:02:52', '2023-06-06 16:02:52'),
(2, '2', '7', '8', 0, 1, NULL, NULL, '2023-06-06 16:03:27', '2023-06-06 16:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `kra_creation_ref`
--

CREATE TABLE `kra_creation_ref` (
  `kra_creation_ref_id` int(11) NOT NULL,
  `kra_category` varchar(255) DEFAULT NULL,
  `weightage` varchar(255) DEFAULT NULL,
  `kra_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kra_creation_ref`
--

INSERT INTO `kra_creation_ref` (`kra_creation_ref_id`, `kra_category`, `weightage`, `kra_id`) VALUES
(1, 'Hib Software Team', '100', '1'),
(2, 'Accounts Team Prodapt', '100', '2');

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE `ledger` (
  `ledgerid` int(11) NOT NULL,
  `ledgername` varchar(255) DEFAULT NULL,
  `groupname` varchar(255) DEFAULT NULL,
  `subgroupname` varchar(255) DEFAULT NULL,
  `inventory` varchar(255) DEFAULT NULL,
  `costcentre` varchar(255) DEFAULT NULL,
  `openingbalancedr` varchar(200) DEFAULT NULL,
  `opening_credit` varchar(255) DEFAULT NULL,
  `opening_debit` varchar(255) DEFAULT NULL,
  `openingbalance` int(11) DEFAULT 0,
  `status` varchar(255) DEFAULT '0',
  `exciseduty` varchar(255) DEFAULT NULL,
  `pan` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `servicetax` varchar(255) DEFAULT NULL,
  `contactperson` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `address3` varchar(255) DEFAULT NULL,
  `address4` varchar(255) DEFAULT NULL,
  `contactnumber` varchar(255) DEFAULT NULL,
  `AccountRefId` int(11) DEFAULT NULL,
  `ServiceTaxNumber` varchar(255) DEFAULT NULL,
  `ExciseDutyReg` varchar(255) DEFAULT NULL,
  `DebitCredit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_checklist`
--

CREATE TABLE `maintenance_checklist` (
  `maintenance_checklist_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `date_of_inspection` varchar(255) DEFAULT NULL,
  `asset_details` varchar(255) DEFAULT NULL,
  `checklist` varchar(255) DEFAULT NULL,
  `calendar` varchar(255) DEFAULT NULL,
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `role1` varchar(255) DEFAULT NULL,
  `role2` varchar(255) DEFAULT NULL,
  `responder_status` int(11) NOT NULL DEFAULT 0,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `maintenance_checklist`
--

INSERT INTO `maintenance_checklist` (`maintenance_checklist_id`, `company_id`, `date_of_inspection`, `asset_details`, `checklist`, `calendar`, `from_date`, `to_date`, `role1`, `role2`, `responder_status`, `work_status`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '3', '2023-06-08', '1', 'pm_checklist', 'No', '', '', '1', '2', 0, 0, 0, NULL, NULL, NULL, '2023-06-06 17:09:23', '2023-06-06 17:09:23');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_checklist_ref`
--

CREATE TABLE `maintenance_checklist_ref` (
  `maintenance_checklist_ref_id` int(11) NOT NULL,
  `maintenance_checklist_id` varchar(255) DEFAULT NULL,
  `pm_checklist_id` varchar(255) DEFAULT NULL,
  `bm_checklist_id` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `responder_reason` text DEFAULT NULL,
  `responder_status_ref` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `maintenance_checklist_ref`
--

INSERT INTO `maintenance_checklist_ref` (`maintenance_checklist_ref_id`, `maintenance_checklist_id`, `pm_checklist_id`, `bm_checklist_id`, `remarks`, `file`, `responder_reason`, `responder_status_ref`) VALUES
(1, '1', '1', NULL, 'hhhhhfdhahadsa', 'WhatsApp Image 2023-04-15 at 3.10.20 PM.jpeg', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `media_creation`
--

CREATE TABLE `media_creation` (
  `media_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `media_name` varchar(200) DEFAULT NULL,
  `media_file` varchar(200) DEFAULT NULL,
  `from_period` varchar(255) DEFAULT NULL,
  `to_period` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `media_creation`
--

INSERT INTO `media_creation` (`media_id`, `company_id`, `media_name`, `media_file`, `from_period`, `to_period`, `platform`, `status`) VALUES
(1, 3, 'DrumStick', 'WhatsApp Image 2023-04-15 at 3.10.20 PM.jpeg', '2023-06-06', '2023-06-10', 'YouTube', 0),
(2, 1, 'Micset', 'hoc2022-banner.png', '2023-06-25', '2023-06-30', 'TV Ads', 0);

-- --------------------------------------------------------

--
-- Table structure for table `meeting_minutes`
--

CREATE TABLE `meeting_minutes` (
  `meeting_minutes_id` int(11) NOT NULL,
  `meeting_minutes_approval_line_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `doc_no` varchar(255) DEFAULT NULL,
  `auto_generation_date` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_minutes_approval_line`
--

CREATE TABLE `meeting_minutes_approval_line` (
  `meeting_minutes_approval_line_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `approval_staff_id` varchar(255) DEFAULT NULL,
  `agree_par_staff_id` varchar(255) DEFAULT NULL,
  `after_notified_staff_id` varchar(255) DEFAULT NULL,
  `receiving_dept_id` varchar(255) DEFAULT NULL,
  `checker_approval` varchar(255) NOT NULL DEFAULT '0',
  `reviewer_approval` varchar(255) NOT NULL DEFAULT '0',
  `final_approval` varchar(255) NOT NULL DEFAULT '0',
  `checker_approval_date` varchar(255) DEFAULT NULL,
  `reviewer_approval_date` varchar(255) DEFAULT NULL,
  `final_approval_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_minutes_parallel_agree_disagree`
--

CREATE TABLE `meeting_minutes_parallel_agree_disagree` (
  `meeting_minutes_agree_disagree_id` int(11) NOT NULL,
  `meeting_minutes_approval_line_id` varchar(255) DEFAULT NULL,
  `agree_disagree_staff_id` varchar(255) DEFAULT NULL,
  `agree_disagree` int(11) NOT NULL DEFAULT 0,
  `agree_disagree_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `memo`
--

CREATE TABLE `memo` (
  `memo_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `from_department` varchar(255) DEFAULT NULL,
  `to_department` varchar(255) DEFAULT NULL,
  `assign_employee` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `inquiry` text DEFAULT NULL,
  `suggestion` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `completion_target_date` varchar(255) DEFAULT NULL,
  `initial_phase` varchar(255) DEFAULT NULL,
  `final_phase` varchar(255) DEFAULT NULL,
  `date_of_completion` varchar(255) DEFAULT NULL,
  `update_attachment` varchar(255) DEFAULT NULL,
  `narration` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `memo`
--

INSERT INTO `memo` (`memo_id`, `company_id`, `from_department`, `to_department`, `assign_employee`, `priority`, `inquiry`, `suggestion`, `attachment`, `completion_target_date`, `initial_phase`, `final_phase`, `date_of_completion`, `update_attachment`, `narration`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '3', NULL, '1', '1', '2', 'hsfdsfd', 'fdssfdfddf', 'pexels-pixabay-268533.jpg', '2023-06-10', '', '', '2023-06-11', 'pexels-pixabay-268533.jpg', 'dgddfgfgdf', 0, 1, 1, NULL, '2023-06-06 16:29:43', '2023-06-06 16:29:43'),
(2, '2', NULL, '7', NULL, NULL, 'trrerrtttt', 'eeeeeeeeeeeeee', 'tree-736885__480.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-06-06 16:35:50', '2023-06-06 16:35:50');

-- --------------------------------------------------------

--
-- Table structure for table `memo_status`
--

CREATE TABLE `memo_status` (
  `memo_status_id` int(11) NOT NULL,
  `date_of_completion` date DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `highlighted` varchar(250) DEFAULT NULL,
  `work_update` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `periodic_level`
--

CREATE TABLE `periodic_level` (
  `periodic_level_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `periodic_date` varchar(255) DEFAULT NULL,
  `asset_details` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permission_or_on_duty`
--

CREATE TABLE `permission_or_on_duty` (
  `permission_on_duty_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `staff_code` varchar(255) DEFAULT NULL,
  `reporting` varchar(255) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `permission_from_time` varchar(255) DEFAULT NULL,
  `permission_to_time` varchar(255) DEFAULT NULL,
  `permission_date` varchar(255) DEFAULT NULL,
  `on_duty_place` varchar(255) DEFAULT NULL,
  `leave_date` varchar(255) DEFAULT NULL,
  `leave_reason` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission_or_on_duty`
--

INSERT INTO `permission_or_on_duty` (`permission_on_duty_id`, `company_id`, `department_id`, `staff_id`, `staff_code`, `reporting`, `reason`, `permission_from_time`, `permission_to_time`, `permission_date`, `on_duty_place`, `leave_date`, `leave_reason`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '3', '1', '1', '101', '', 'On Duty', '', '', '', 'Client Officee', '', '', 0, 1, 1, NULL, '2023-06-06 17:22:17', '2023-06-06 17:22:17');

-- --------------------------------------------------------

--
-- Table structure for table `pm_checklist`
--

CREATE TABLE `pm_checklist` (
  `pm_checklist_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `checklist` text DEFAULT NULL,
  `type_of_checklist` varchar(255) DEFAULT NULL,
  `yes_no_na` varchar(255) DEFAULT NULL,
  `no_of_option` varchar(255) DEFAULT NULL,
  `option1` varchar(255) DEFAULT NULL,
  `option2` varchar(255) DEFAULT NULL,
  `option3` varchar(255) DEFAULT NULL,
  `option4` varchar(255) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `frequency_applicable` varchar(50) DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `maintenance_checklist` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pm_checklist`
--

INSERT INTO `pm_checklist` (`pm_checklist_id`, `company_id`, `category_id`, `checklist`, `type_of_checklist`, `yes_no_na`, `no_of_option`, `option1`, `option2`, `option3`, `option4`, `frequency`, `frequency_applicable`, `rating`, `maintenance_checklist`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '3', '1', 'asgagaga', 'Option', '', '2', 'date', 'type', '', '', 'Monthly', '', 'Medium', 1, 0, 1, NULL, NULL, '2023-06-06 17:05:47', '2023-06-06 17:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `pm_checklist_ref`
--

CREATE TABLE `pm_checklist_ref` (
  `pm_checklist_ref_id` int(11) NOT NULL,
  `pm_checklist_id` varchar(50) DEFAULT NULL,
  `maintenance_checklist_id` varchar(50) DEFAULT NULL,
  `maintenance_checklist_ref_id` varchar(200) DEFAULT NULL,
  `checklist` text DEFAULT NULL,
  `from_date` varchar(50) DEFAULT NULL,
  `to_date` varchar(50) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `role1` varchar(200) DEFAULT NULL,
  `role2` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pm_checklist_ref`
--

INSERT INTO `pm_checklist_ref` (`pm_checklist_ref_id`, `pm_checklist_id`, `maintenance_checklist_id`, `maintenance_checklist_ref_id`, `checklist`, `from_date`, `to_date`, `work_status`, `role1`, `role2`) VALUES
(1, '1', '1', '1', 'asgagaga', '', '', 0, '1', '2');

-- --------------------------------------------------------

--
-- Table structure for table `project_creation`
--

CREATE TABLE `project_creation` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_creation`
--

INSERT INTO `project_creation` (`project_id`, `project_name`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Project  1', 0, NULL, NULL, NULL, '2023-06-06 16:04:05', '2023-06-06 16:04:05'),
(2, 'Project  2', 0, NULL, NULL, NULL, '2023-06-06 16:04:13', '2023-06-06 16:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `promotional_activities`
--

CREATE TABLE `promotional_activities` (
  `promotional_activities_id` int(11) NOT NULL,
  `project` varchar(100) DEFAULT NULL,
  `campaign_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promotional_activities`
--

INSERT INTO `promotional_activities` (`promotional_activities_id`, `project`, `campaign_status`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Digital Reach', 1, 0, 1, NULL, NULL, '2023-06-06 13:30:58', '2023-06-06 13:30:58'),
(2, 'Promotion Project ', 0, 0, 1, NULL, NULL, '2023-06-06 14:31:41', '2023-06-06 14:31:41');

-- --------------------------------------------------------

--
-- Table structure for table `promotional_activities_ref`
--

CREATE TABLE `promotional_activities_ref` (
  `promotional_activities_ref_id` int(11) NOT NULL,
  `promotional_activities_id` int(11) DEFAULT NULL,
  `activity_involved` varchar(200) DEFAULT NULL,
  `time_frame_start` int(50) DEFAULT NULL,
  `duration` int(50) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `employee_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promotional_activities_ref`
--

INSERT INTO `promotional_activities_ref` (`promotional_activities_ref_id`, `promotional_activities_id`, `activity_involved`, `time_frame_start`, `duration`, `start_date`, `end_date`, `employee_name`) VALUES
(1, 1, 'devlopment Post ', 10, 30, '2023-07-05', '2023-08-04', '1'),
(2, 2, 'Poster', 12, 23, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `report_creation`
--

CREATE TABLE `report_creation` (
  `report_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `report_name` varchar(200) DEFAULT NULL,
  `report_file` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_creation`
--

INSERT INTO `report_creation` (`report_id`, `company_id`, `report_name`, `report_file`, `status`) VALUES
(1, 3, 'Regular Report', 'pexels-pixabay-268533.jpg', 0),
(2, 1, 'Report Temp', 'WhatsApp Image 2023-04-15 at 3.10.20 PM.jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rgp_creation`
--

CREATE TABLE `rgp_creation` (
  `rgp_id` int(11) NOT NULL,
  `rgp_date` varchar(255) DEFAULT NULL,
  `return_date` varchar(255) DEFAULT NULL,
  `asset_class` varchar(255) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `branch_from` varchar(255) DEFAULT NULL,
  `branch_to` varchar(255) DEFAULT NULL,
  `from_comm_line1` varchar(255) DEFAULT NULL,
  `from_comm_line2` varchar(255) DEFAULT NULL,
  `to_comm_line1` varchar(255) DEFAULT NULL,
  `to_comm_line2` varchar(255) DEFAULT NULL,
  `asset_name_id` varchar(255) DEFAULT NULL,
  `asset_value` varchar(255) DEFAULT NULL,
  `reason_rgp` varchar(255) DEFAULT NULL,
  `extended_date` varchar(255) DEFAULT NULL,
  `extend_reason` varchar(255) DEFAULT NULL,
  `extend_status` varchar(255) DEFAULT NULL,
  `rgp_status` varchar(255) NOT NULL DEFAULT 'outward',
  `status` int(11) NOT NULL DEFAULT 0,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rgp_creation`
--

INSERT INTO `rgp_creation` (`rgp_id`, `rgp_date`, `return_date`, `asset_class`, `company_id`, `branch_from`, `branch_to`, `from_comm_line1`, `from_comm_line2`, `to_comm_line1`, `to_comm_line2`, `asset_name_id`, `asset_value`, `reason_rgp`, `extended_date`, `extend_reason`, `extend_status`, `rgp_status`, `status`, `created_id`, `updated_id`, `created_date`, `updated_date`) VALUES
(1, '2023-07-01', '2023-07-15', '3', '1', '3', '4', 'No.55, TSKV Street, ', 'Mylapore, Chennai.', 'No.3/7, 14th Trust Road,', 'Lawspet', '1', '50000', 'dsgdfdfhdffd', NULL, NULL, NULL, 'outward', 0, NULL, NULL, '2023-06-06 13:30:18', '2023-06-06 13:30:18');

-- --------------------------------------------------------

--
-- Table structure for table `rr_creation`
--

CREATE TABLE `rr_creation` (
  `rr_id` int(11) NOT NULL,
  `company_name` varchar(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rr_creation`
--

INSERT INTO `rr_creation` (`rr_id`, `company_name`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', 0, 1, NULL, NULL, '2023-06-06 12:28:19', '2023-06-06 12:28:19'),
(2, '1', 0, 1, NULL, NULL, '2023-06-06 12:28:37', '2023-06-06 12:28:37'),
(3, '2', 0, 1, NULL, NULL, '2023-06-06 12:29:02', '2023-06-06 12:29:02'),
(4, '2', 0, 1, NULL, NULL, '2023-06-06 12:29:24', '2023-06-06 12:29:24');

-- --------------------------------------------------------

--
-- Table structure for table `rr_creation_ref`
--

CREATE TABLE `rr_creation_ref` (
  `rr_ref_id` int(11) NOT NULL,
  `rr_reff_id` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `designation` varchar(250) DEFAULT NULL,
  `rr` varchar(255) DEFAULT NULL,
  `frequency` varchar(250) DEFAULT NULL,
  `code_ref` varchar(250) DEFAULT NULL,
  `applicability` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rr_creation_ref`
--

INSERT INTO `rr_creation_ref` (`rr_ref_id`, `rr_reff_id`, `department`, `designation`, `rr`, `frequency`, `code_ref`, `applicability`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '6', '6', 'Update Finance  Status Daily', NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-06-06 12:28:19', '2023-06-06 12:28:19'),
(2, '2', '6', '7', 'Clear Monthly Finance Files', NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-06-06 12:28:37', '2023-06-06 12:28:37'),
(3, '3', '7', '8', 'Clear Monthly Accounts Files', NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-06-06 12:29:02', '2023-06-06 12:29:02'),
(4, '4', '7', '9', 'Accounting', NULL, NULL, NULL, 0, 1, NULL, NULL, '2023-06-06 12:29:24', '2023-06-06 12:29:24');

-- --------------------------------------------------------

--
-- Table structure for table `service_indent`
--

CREATE TABLE `service_indent` (
  `service_indent_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `date_of_indent` date DEFAULT NULL,
  `asset_class` varchar(255) DEFAULT NULL,
  `asset_name1` varchar(250) DEFAULT NULL,
  `asset_value` varchar(250) DEFAULT NULL,
  `vendor_address` varchar(250) DEFAULT NULL,
  `vendor_address1` varchar(250) DEFAULT NULL,
  `vendor_address2` varchar(250) DEFAULT NULL,
  `company_address` varchar(250) DEFAULT NULL,
  `company_address1` varchar(250) DEFAULT NULL,
  `company_address2` varchar(250) DEFAULT NULL,
  `reason_for_indent` varchar(250) DEFAULT NULL,
  `expected_to_arrive` varchar(250) DEFAULT NULL,
  `stock_in_out` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_indent`
--

INSERT INTO `service_indent` (`service_indent_id`, `company_id`, `date_of_indent`, `asset_class`, `asset_name1`, `asset_value`, `vendor_address`, `vendor_address1`, `vendor_address2`, `company_address`, `company_address1`, `company_address2`, `reason_for_indent`, `expected_to_arrive`, `stock_in_out`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '3', '2023-06-06', '3', '1', '50000', 'No.69, Anna Salai,', 'Little Mount', 'Chennai.', 'No.55, TSKV Street, , Mylapore, Chennai.', 'Chennai', 'TamilNadu', 'ragareararagr', '2023-06-09', 1, 0, 1, NULL, NULL, '2023-06-06 13:25:34', '2023-06-06 13:25:34'),
(2, '1', '2023-06-07', '6', '3', '70000', 'No.69, Anna Salai,', 'Little Mount', 'Chennai.', 'OMR Road,, Thoraipakkam', 'Chennai', 'TamilNadu', 'agagadfga', '2023-06-10', 1, 0, 1, NULL, NULL, '2023-06-06 13:26:00', '2023-06-06 13:26:00');

-- --------------------------------------------------------

--
-- Table structure for table `spare_creation`
--

CREATE TABLE `spare_creation` (
  `spare_id` int(11) NOT NULL,
  `spare_name` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spare_creation`
--

INSERT INTO `spare_creation` (`spare_id`, `spare_name`, `branch_id`, `company_id`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Display', 3, 1, 0, '2023-06-06 13:27:42', '2023-06-06 13:27:42'),
(2, 'Buttons', 3, 1, 0, '2023-06-06 13:27:48', '2023-06-06 13:27:48'),
(3, 'Bazel', 3, 1, 0, '2023-06-06 13:27:53', '2023-06-06 13:27:53'),
(4, 'IC', 3, 1, 0, '2023-06-06 13:28:09', '2023-06-06 13:28:09');

-- --------------------------------------------------------

--
-- Table structure for table `staff_creation`
--

CREATE TABLE `staff_creation` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `designation` int(11) DEFAULT NULL,
  `emp_code` text DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `doj` varchar(255) DEFAULT NULL,
  `krikpi` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `key_skills` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email_id` varchar(250) NOT NULL,
  `reporting` varchar(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff_creation`
--

INSERT INTO `staff_creation` (`staff_id`, `staff_name`, `company_id`, `designation`, `emp_code`, `department`, `doj`, `krikpi`, `dob`, `key_skills`, `contact_number`, `email_id`, `reporting`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Ram', 3, 1, '101', 1, '2020-06-01', '', '1998-06-29', 'Js', '7417741717', 'abc@abc.com', '', 0, 1, NULL, NULL, '2023-06-06 12:57:56', '2023-06-06 12:57:56'),
(2, 'Sankari', 3, 10, '102', 2, '2020-07-15', '', '1996-05-10', 'Js', '9689897454', 'abc@little.in', '', 0, 1, NULL, NULL, '2023-06-06 13:00:59', '2023-06-06 13:00:59'),
(3, 'Nuaim', 1, 6, '103', 6, '2020-06-18', '', '1990-05-05', 'Js', '7418255999', 'abc@little.in', '', 0, 1, NULL, NULL, '2023-06-06 13:02:17', '2023-06-06 13:02:17'),
(4, 'Kamalesh', 2, 9, '104', 7, '2020-06-16', '', '1998-02-14', 'Js', '9638527410', 'abc@abc.com', '', 0, 1, 1, NULL, '2023-06-06 13:04:55', '2023-06-06 13:04:55'),
(5, 'Revan', 2, 9, '105', 7, '2020-07-01', '2', '1997-12-06', 'Js', '7417848484', 'abc@little.in', '', 0, 1, NULL, NULL, '2023-06-06 16:34:33', '2023-06-06 16:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `tag_creation`
--

CREATE TABLE `tag_creation` (
  `tag_id` int(11) NOT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `tag_classification` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tag_creation`
--

INSERT INTO `tag_creation` (`tag_id`, `department_id`, `company_id`, `tag_classification`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '3', '4', 'Digi Tag', 0, 1, NULL, NULL, '2023-06-06 12:25:11', '2023-06-06 12:25:11'),
(2, '1', '3', 'Devlop Tag', 0, 1, NULL, NULL, '2023-06-06 12:25:42', '2023-06-06 12:25:42'),
(3, '6', '1', 'Lit Tag', 0, 1, NULL, NULL, '2023-06-06 12:26:03', '2023-06-06 12:26:03'),
(4, '7', '2', 'Acc Tag', 0, 1, NULL, NULL, '2023-06-06 12:27:40', '2023-06-06 12:27:40');

-- --------------------------------------------------------

--
-- Table structure for table `target_fixing`
--

CREATE TABLE `target_fixing` (
  `target_fixing_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `no_of_months` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `target_fixing_ref`
--

CREATE TABLE `target_fixing_ref` (
  `target_fixing_ref_id` int(11) NOT NULL,
  `target_fixing_id` int(11) NOT NULL,
  `goal_setting_and_kra_id` varchar(50) DEFAULT NULL,
  `assertion` varchar(200) DEFAULT NULL,
  `target` varchar(100) DEFAULT NULL,
  `new_assertion` varchar(200) DEFAULT NULL,
  `new_target` varchar(100) DEFAULT NULL,
  `applicability` varchar(250) DEFAULT NULL,
  `deleted_date` varchar(100) DEFAULT NULL,
  `deleted_remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `todo_creation`
--

CREATE TABLE `todo_creation` (
  `todo_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `work_des` varchar(255) DEFAULT NULL,
  `tag_id` varchar(255) DEFAULT NULL,
  `priority` varchar(200) DEFAULT NULL,
  `assign_to` varchar(255) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `criteria` varchar(255) DEFAULT NULL,
  `project_id` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `todo_creation`
--

INSERT INTO `todo_creation` (`todo_id`, `company_id`, `work_des`, `tag_id`, `priority`, `assign_to`, `from_date`, `to_date`, `work_status`, `criteria`, `project_id`, `status`, `created_date`, `updated_date`, `created_id`, `updated_id`) VALUES
(1, '3', 'test todo ', '2', '2', '1', '2023-08-06 16:27:22', '2023-08-10 16:27:22', 0, 'Event', '', 0, '2023-06-06 16:27:22', '2023-06-06 16:27:22', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfer_location`
--

CREATE TABLE `transfer_location` (
  `transfer_location_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `staff_code` varchar(255) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `dot` varchar(255) DEFAULT NULL,
  `transfer_location` varchar(255) DEFAULT NULL,
  `transfer_effective_from` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transfer_location`
--

INSERT INTO `transfer_location` (`transfer_location_id`, `company_id`, `department_id`, `staff_code`, `staff_id`, `dot`, `transfer_location`, `transfer_effective_from`, `file`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '3', '1', '1', 'Ram', '2023-06-10', '4', '2023-06-10', 'tree-736885__480.jpg', 0, 1, NULL, NULL, '2023-06-06 17:24:48', '2023-06-06 17:24:48');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `emailid` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `designation_id` varchar(50) DEFAULT NULL,
  `mobile_number` varchar(50) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0',
  `Createddate` datetime NOT NULL DEFAULT current_timestamp(),
  `administration_module` varchar(11) DEFAULT NULL,
  `dashboard` varchar(11) DEFAULT NULL,
  `company_creation` varchar(11) DEFAULT NULL,
  `branch_creation` varchar(11) DEFAULT NULL,
  `holiday_creation` varchar(11) DEFAULT NULL,
  `manage_users` varchar(11) DEFAULT NULL,
  `master_module` varchar(11) DEFAULT NULL,
  `basic_sub_module` varchar(11) DEFAULT NULL,
  `responsibility_sub_module` varchar(11) DEFAULT NULL,
  `audit_sub_module` varchar(11) DEFAULT NULL,
  `others_sub_module` varchar(11) DEFAULT NULL,
  `basic_creation` varchar(11) DEFAULT NULL,
  `tag_creation` varchar(11) DEFAULT NULL,
  `rr_creation` varchar(11) DEFAULT NULL,
  `kra_category` varchar(11) DEFAULT NULL,
  `krakpi_creation` varchar(11) DEFAULT NULL,
  `staff_creation` varchar(11) DEFAULT NULL,
  `audit_area_creation` varchar(11) DEFAULT NULL,
  `audit_area_checklist` varchar(11) DEFAULT NULL,
  `audit_assign` varchar(11) DEFAULT NULL,
  `audit_follow_up` varchar(11) DEFAULT NULL,
  `report_template` varchar(11) DEFAULT NULL,
  `media_master` varchar(11) DEFAULT NULL,
  `asset_creation` varchar(11) DEFAULT NULL,
  `insurance_register` varchar(11) DEFAULT NULL,
  `service_indent` varchar(11) DEFAULT NULL,
  `asset_details` varchar(11) DEFAULT NULL,
  `rgp_creation` varchar(11) DEFAULT NULL,
  `promotional_activities` varchar(11) DEFAULT NULL,
  `work_force_module` varchar(11) DEFAULT NULL,
  `schedule_task_sub_module` varchar(11) DEFAULT NULL,
  `memo_sub_module` varchar(11) DEFAULT NULL,
  `campaign` varchar(11) DEFAULT NULL,
  `assign_work` varchar(11) DEFAULT NULL,
  `todo` varchar(11) DEFAULT NULL,
  `assigned_work` varchar(11) DEFAULT NULL,
  `memo_initiate` varchar(11) DEFAULT NULL,
  `memo_assigned` varchar(11) DEFAULT NULL,
  `memo_update` varchar(11) DEFAULT NULL,
  `maintenance_module` varchar(11) DEFAULT NULL,
  `pm_checklist` varchar(11) DEFAULT NULL,
  `bm_checklist` varchar(11) DEFAULT NULL,
  `maintenance_checklist` varchar(11) DEFAULT NULL,
  `manpower_in_out_module` varchar(11) DEFAULT NULL,
  `permission_or_onduty` varchar(11) DEFAULT NULL,
  `transfer_location` varchar(11) DEFAULT NULL,
  `target_fixing_module` varchar(11) DEFAULT NULL,
  `goal_setting` varchar(11) DEFAULT NULL,
  `target_fixing` varchar(11) DEFAULT NULL,
  `daily_performance` varchar(11) DEFAULT NULL,
  `appreciation_depreciation` varchar(11) DEFAULT NULL,
  `vehicle_management_module` varchar(11) DEFAULT NULL,
  `vehicle_details` varchar(11) DEFAULT NULL,
  `daily_km` varchar(11) DEFAULT NULL,
  `diesel_slip` varchar(11) DEFAULT NULL,
  `approval_mechanism_module` varchar(11) DEFAULT NULL,
  `approval_requisition` varchar(11) DEFAULT NULL,
  `business_communication_outgoing` varchar(11) DEFAULT NULL,
  `minutes_of_meeting` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `fullname`, `title`, `emailid`, `user_name`, `user_password`, `role`, `staff_id`, `branch_id`, `designation_id`, `mobile_number`, `status`, `Createddate`, `administration_module`, `dashboard`, `company_creation`, `branch_creation`, `holiday_creation`, `manage_users`, `master_module`, `basic_sub_module`, `responsibility_sub_module`, `audit_sub_module`, `others_sub_module`, `basic_creation`, `tag_creation`, `rr_creation`, `kra_category`, `krakpi_creation`, `staff_creation`, `audit_area_creation`, `audit_area_checklist`, `audit_assign`, `audit_follow_up`, `report_template`, `media_master`, `asset_creation`, `insurance_register`, `service_indent`, `asset_details`, `rgp_creation`, `promotional_activities`, `work_force_module`, `schedule_task_sub_module`, `memo_sub_module`, `campaign`, `assign_work`, `todo`, `assigned_work`, `memo_initiate`, `memo_assigned`, `memo_update`, `maintenance_module`, `pm_checklist`, `bm_checklist`, `maintenance_checklist`, `manpower_in_out_module`, `permission_or_onduty`, `transfer_location`, `target_fixing_module`, `goal_setting`, `target_fixing`, `daily_performance`, `appreciation_depreciation`, `vehicle_management_module`, `vehicle_details`, `daily_km`, `diesel_slip`, `approval_mechanism_module`, `approval_requisition`, `business_communication_outgoing`, `minutes_of_meeting`) VALUES
(1, 'Super', 'Admin', 'Super Admin', 'Super Admin', 'support@feathertechnology.in', 'support@feathertechnology.in', 'admin@123', '1', 'Overall', 'Overall', NULL, NULL, '0', '2021-04-17 17:08:00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(19, 'Manager', 'Manager', 'Manager', 'Manager', 'manager@feathertechnology.in', 'manager@feathertechnology.in', 'admin@123', '3', NULL, '1', NULL, NULL, '0', '2023-01-31 16:52:54', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(20, 'Employee', 'Employee', 'Employee', 'Employee', 'employee@feathertechnology.in', 'employee@feathertechnology.in', 'admin@123', '4', '1', '1', NULL, NULL, '0', '2023-03-10 16:33:04', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(21, 'Employee1', 'Employee1', 'Employee1', 'Employee1', 'employee1@feathertechnology.in', 'employee1@feathertechnology.in', 'admin@123', '4', '2', '1', NULL, NULL, '0', '2023-03-14 13:09:26', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(22, 'Employee2', 'Employee2', 'Employee2', 'Employee2', 'employee2@feathertechnology.in', 'employee2@feathertechnology.in', 'admin@123', '4', '3', '1', NULL, NULL, '0', '2023-03-15 10:48:41', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(23, 'Employee3', 'Employee3', 'Employee3', 'Employee3', 'employee3@feathertechnology.in', 'employee3@feathertechnology.in', 'admin@123', '4', '4', '1', NULL, NULL, '0', '2023-03-16 16:34:10', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(24, 'Employee4', 'Employee4', 'Employee4', 'Employee4', 'employee4@feathertechnology.in', 'employee4@feathertechnology.in', 'admin@123', '4', '5', '2', NULL, NULL, '0', '2023-03-22 09:40:51', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
(26, 'Test firstname', 'Test Lastname', 'Test firstname Test Lastname', 'Test', 'test@testmail.com', 'test@testmail.com', '123', '3', NULL, NULL, NULL, NULL, '0', '2023-06-05 11:00:32', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1'),
(27, 'Revan', 'S', 'Revan S', 'Testing', 'revan@test.com', 'revan@test.com', '123', '3', NULL, NULL, NULL, NULL, '0', '2023-06-05 11:06:57', '0', '0', '0', '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_details`
--

CREATE TABLE `vehicle_details` (
  `vehicle_details_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `vehicle_code` varchar(255) DEFAULT NULL,
  `vehicle_name` varchar(255) DEFAULT NULL,
  `vehicle_number` varchar(255) DEFAULT NULL,
  `date_of_purchase` varchar(255) DEFAULT NULL,
  `fitment_upto` varchar(255) DEFAULT NULL,
  `insurance_upto` varchar(255) DEFAULT NULL,
  `asset_value` varchar(255) DEFAULT NULL,
  `book_value_as_on` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `work_status`
--

CREATE TABLE `work_status` (
  `status_id` int(11) NOT NULL,
  `work_id` varchar(255) DEFAULT NULL,
  `work_des` varchar(255) DEFAULT NULL,
  `work_status` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `completed_file` varchar(255) DEFAULT NULL,
  `outdated_completed_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `year_creation`
--

CREATE TABLE `year_creation` (
  `year_id` int(11) NOT NULL,
  `year` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `year_creation`
--

INSERT INTO `year_creation` (`year_id`, `year`, `company_id`, `status`, `created_date`, `updated_date`) VALUES
(1, '2023', 2, 0, '2023-06-06 17:28:55', '2023-06-06 17:28:55'),
(2, '2023', 2, 0, '2023-06-06 17:29:07', '2023-06-06 17:29:07'),
(3, '2023', 2, 0, '2023-06-06 17:29:25', '2023-06-06 17:29:25'),
(4, '1950', 2, 0, '2023-06-06 17:32:05', '2023-06-06 17:32:05'),
(5, '1951', 2, 0, '2023-06-06 17:35:09', '2023-06-06 17:35:09'),
(6, '1953', 2, 0, '2023-06-06 17:35:38', '2023-06-06 17:35:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountsgroup`
--
ALTER TABLE `accountsgroup`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `appreciation_depreciation`
--
ALTER TABLE `appreciation_depreciation`
  ADD PRIMARY KEY (`appreciation_depreciation_id`);

--
-- Indexes for table `appreciation_depreciation_ref`
--
ALTER TABLE `appreciation_depreciation_ref`
  ADD PRIMARY KEY (`appreciation_depreciation_ref_id`);

--
-- Indexes for table `approval_line`
--
ALTER TABLE `approval_line`
  ADD PRIMARY KEY (`approval_line_id`);

--
-- Indexes for table `approval_requisition`
--
ALTER TABLE `approval_requisition`
  ADD PRIMARY KEY (`approval_requisition_id`);

--
-- Indexes for table `approval_requisition_parallel_agree_disagree`
--
ALTER TABLE `approval_requisition_parallel_agree_disagree`
  ADD PRIMARY KEY (`approval_requisition_agree_disagree_id`);

--
-- Indexes for table `asset_details`
--
ALTER TABLE `asset_details`
  ADD PRIMARY KEY (`asset_details_id`);

--
-- Indexes for table `asset_details_ref`
--
ALTER TABLE `asset_details_ref`
  ADD PRIMARY KEY (`ref_id`);

--
-- Indexes for table `asset_register`
--
ALTER TABLE `asset_register`
  ADD PRIMARY KEY (`asset_id`);

--
-- Indexes for table `assign_work`
--
ALTER TABLE `assign_work`
  ADD PRIMARY KEY (`work_id`);

--
-- Indexes for table `assign_work_ref`
--
ALTER TABLE `assign_work_ref`
  ADD PRIMARY KEY (`ref_id`);

--
-- Indexes for table `audit_area_creation`
--
ALTER TABLE `audit_area_creation`
  ADD PRIMARY KEY (`audit_area_id`);

--
-- Indexes for table `audit_area_creation_ref`
--
ALTER TABLE `audit_area_creation_ref`
  ADD PRIMARY KEY (`audit_area_creation_ref_id`);

--
-- Indexes for table `audit_assign`
--
ALTER TABLE `audit_assign`
  ADD PRIMARY KEY (`audit_assign_id`);

--
-- Indexes for table `audit_assign_ref`
--
ALTER TABLE `audit_assign_ref`
  ADD PRIMARY KEY (`audit_assign_ref_id`);

--
-- Indexes for table `audit_checklist`
--
ALTER TABLE `audit_checklist`
  ADD PRIMARY KEY (`audit_checklist_id`);

--
-- Indexes for table `audit_checklist_ref`
--
ALTER TABLE `audit_checklist_ref`
  ADD PRIMARY KEY (`audit_checklist_ref_id`);

--
-- Indexes for table `audit_followup`
--
ALTER TABLE `audit_followup`
  ADD PRIMARY KEY (`audit_followup_id`);

--
-- Indexes for table `bankmaster`
--
ALTER TABLE `bankmaster`
  ADD PRIMARY KEY (`bankid`);

--
-- Indexes for table `basic_creation`
--
ALTER TABLE `basic_creation`
  ADD PRIMARY KEY (`basic_creation_id`);

--
-- Indexes for table `bm_checklist`
--
ALTER TABLE `bm_checklist`
  ADD PRIMARY KEY (`bm_checklist_id`);

--
-- Indexes for table `branch_creation`
--
ALTER TABLE `branch_creation`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `business_com_line`
--
ALTER TABLE `business_com_line`
  ADD PRIMARY KEY (`business_com_line_id`);

--
-- Indexes for table `business_com_out`
--
ALTER TABLE `business_com_out`
  ADD PRIMARY KEY (`business_com_out_id`);

--
-- Indexes for table `business_com_parallel_agree_disagree`
--
ALTER TABLE `business_com_parallel_agree_disagree`
  ADD PRIMARY KEY (`business_com_parallel_agree_disagree_id`);

--
-- Indexes for table `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`campaign_id`);

--
-- Indexes for table `campaign_ref`
--
ALTER TABLE `campaign_ref`
  ADD PRIMARY KEY (`campaign_ref_id`);

--
-- Indexes for table `category_creation`
--
ALTER TABLE `category_creation`
  ADD PRIMARY KEY (`category_creation_id`);

--
-- Indexes for table `company_creation`
--
ALTER TABLE `company_creation`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `costcentre`
--
ALTER TABLE `costcentre`
  ADD PRIMARY KEY (`costcentreid`);

--
-- Indexes for table `daily_km`
--
ALTER TABLE `daily_km`
  ADD PRIMARY KEY (`daily_km_id`);

--
-- Indexes for table `daily_km_ref`
--
ALTER TABLE `daily_km_ref`
  ADD PRIMARY KEY (`daily_km_ref_id`);

--
-- Indexes for table `daily_performance`
--
ALTER TABLE `daily_performance`
  ADD PRIMARY KEY (`daily_performance_id`);

--
-- Indexes for table `daily_performance_ref`
--
ALTER TABLE `daily_performance_ref`
  ADD PRIMARY KEY (`daily_performance_ref_id`);

--
-- Indexes for table `department_creation`
--
ALTER TABLE `department_creation`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `designation_creation`
--
ALTER TABLE `designation_creation`
  ADD PRIMARY KEY (`designation_id`);

--
-- Indexes for table `diesel_slip`
--
ALTER TABLE `diesel_slip`
  ADD PRIMARY KEY (`diesel_slip_id`);

--
-- Indexes for table `goal_setting`
--
ALTER TABLE `goal_setting`
  ADD PRIMARY KEY (`goal_setting_id`);

--
-- Indexes for table `goal_setting_ref`
--
ALTER TABLE `goal_setting_ref`
  ADD PRIMARY KEY (`goal_setting_ref_id`);

--
-- Indexes for table `hierarchy_creation`
--
ALTER TABLE `hierarchy_creation`
  ADD PRIMARY KEY (`hierarchy_id`);

--
-- Indexes for table `holiday_creation`
--
ALTER TABLE `holiday_creation`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `holiday_creation_ref`
--
ALTER TABLE `holiday_creation_ref`
  ADD PRIMARY KEY (`holiday_ref_id`);

--
-- Indexes for table `insurance_creation`
--
ALTER TABLE `insurance_creation`
  ADD PRIMARY KEY (`insurance_id`);

--
-- Indexes for table `insurance_register`
--
ALTER TABLE `insurance_register`
  ADD PRIMARY KEY (`ins_reg_id`);

--
-- Indexes for table `insurance_register_ref`
--
ALTER TABLE `insurance_register_ref`
  ADD PRIMARY KEY (`ins_reg_ref_id`);

--
-- Indexes for table `krakpi_calendar_map`
--
ALTER TABLE `krakpi_calendar_map`
  ADD PRIMARY KEY (`krakpi_calendar_map_id`);

--
-- Indexes for table `krakpi_creation`
--
ALTER TABLE `krakpi_creation`
  ADD PRIMARY KEY (`krakpi_id`);

--
-- Indexes for table `krakpi_creation_ref`
--
ALTER TABLE `krakpi_creation_ref`
  ADD PRIMARY KEY (`krakpi_ref_id`);

--
-- Indexes for table `kra_creation`
--
ALTER TABLE `kra_creation`
  ADD PRIMARY KEY (`kra_id`);

--
-- Indexes for table `kra_creation_ref`
--
ALTER TABLE `kra_creation_ref`
  ADD PRIMARY KEY (`kra_creation_ref_id`);

--
-- Indexes for table `ledger`
--
ALTER TABLE `ledger`
  ADD PRIMARY KEY (`ledgerid`);

--
-- Indexes for table `maintenance_checklist`
--
ALTER TABLE `maintenance_checklist`
  ADD PRIMARY KEY (`maintenance_checklist_id`);

--
-- Indexes for table `maintenance_checklist_ref`
--
ALTER TABLE `maintenance_checklist_ref`
  ADD PRIMARY KEY (`maintenance_checklist_ref_id`);

--
-- Indexes for table `media_creation`
--
ALTER TABLE `media_creation`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `meeting_minutes`
--
ALTER TABLE `meeting_minutes`
  ADD PRIMARY KEY (`meeting_minutes_id`);

--
-- Indexes for table `meeting_minutes_approval_line`
--
ALTER TABLE `meeting_minutes_approval_line`
  ADD PRIMARY KEY (`meeting_minutes_approval_line_id`);

--
-- Indexes for table `meeting_minutes_parallel_agree_disagree`
--
ALTER TABLE `meeting_minutes_parallel_agree_disagree`
  ADD PRIMARY KEY (`meeting_minutes_agree_disagree_id`);

--
-- Indexes for table `memo`
--
ALTER TABLE `memo`
  ADD PRIMARY KEY (`memo_id`);

--
-- Indexes for table `memo_status`
--
ALTER TABLE `memo_status`
  ADD PRIMARY KEY (`memo_status_id`);

--
-- Indexes for table `periodic_level`
--
ALTER TABLE `periodic_level`
  ADD PRIMARY KEY (`periodic_level_id`);

--
-- Indexes for table `permission_or_on_duty`
--
ALTER TABLE `permission_or_on_duty`
  ADD PRIMARY KEY (`permission_on_duty_id`);

--
-- Indexes for table `pm_checklist`
--
ALTER TABLE `pm_checklist`
  ADD PRIMARY KEY (`pm_checklist_id`);

--
-- Indexes for table `pm_checklist_ref`
--
ALTER TABLE `pm_checklist_ref`
  ADD PRIMARY KEY (`pm_checklist_ref_id`);

--
-- Indexes for table `project_creation`
--
ALTER TABLE `project_creation`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `promotional_activities`
--
ALTER TABLE `promotional_activities`
  ADD PRIMARY KEY (`promotional_activities_id`);

--
-- Indexes for table `promotional_activities_ref`
--
ALTER TABLE `promotional_activities_ref`
  ADD PRIMARY KEY (`promotional_activities_ref_id`);

--
-- Indexes for table `report_creation`
--
ALTER TABLE `report_creation`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `rgp_creation`
--
ALTER TABLE `rgp_creation`
  ADD PRIMARY KEY (`rgp_id`);

--
-- Indexes for table `rr_creation`
--
ALTER TABLE `rr_creation`
  ADD PRIMARY KEY (`rr_id`);

--
-- Indexes for table `rr_creation_ref`
--
ALTER TABLE `rr_creation_ref`
  ADD PRIMARY KEY (`rr_ref_id`);

--
-- Indexes for table `service_indent`
--
ALTER TABLE `service_indent`
  ADD PRIMARY KEY (`service_indent_id`);

--
-- Indexes for table `spare_creation`
--
ALTER TABLE `spare_creation`
  ADD PRIMARY KEY (`spare_id`);

--
-- Indexes for table `staff_creation`
--
ALTER TABLE `staff_creation`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `tag_creation`
--
ALTER TABLE `tag_creation`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `target_fixing`
--
ALTER TABLE `target_fixing`
  ADD PRIMARY KEY (`target_fixing_id`);

--
-- Indexes for table `target_fixing_ref`
--
ALTER TABLE `target_fixing_ref`
  ADD PRIMARY KEY (`target_fixing_ref_id`);

--
-- Indexes for table `todo_creation`
--
ALTER TABLE `todo_creation`
  ADD PRIMARY KEY (`todo_id`);

--
-- Indexes for table `transfer_location`
--
ALTER TABLE `transfer_location`
  ADD PRIMARY KEY (`transfer_location_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  ADD PRIMARY KEY (`vehicle_details_id`);

--
-- Indexes for table `work_status`
--
ALTER TABLE `work_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `year_creation`
--
ALTER TABLE `year_creation`
  ADD PRIMARY KEY (`year_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountsgroup`
--
ALTER TABLE `accountsgroup`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appreciation_depreciation`
--
ALTER TABLE `appreciation_depreciation`
  MODIFY `appreciation_depreciation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appreciation_depreciation_ref`
--
ALTER TABLE `appreciation_depreciation_ref`
  MODIFY `appreciation_depreciation_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval_line`
--
ALTER TABLE `approval_line`
  MODIFY `approval_line_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval_requisition`
--
ALTER TABLE `approval_requisition`
  MODIFY `approval_requisition_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval_requisition_parallel_agree_disagree`
--
ALTER TABLE `approval_requisition_parallel_agree_disagree`
  MODIFY `approval_requisition_agree_disagree_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_details`
--
ALTER TABLE `asset_details`
  MODIFY `asset_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_details_ref`
--
ALTER TABLE `asset_details_ref`
  MODIFY `ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_register`
--
ALTER TABLE `asset_register`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `assign_work`
--
ALTER TABLE `assign_work`
  MODIFY `work_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assign_work_ref`
--
ALTER TABLE `assign_work_ref`
  MODIFY `ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_area_creation`
--
ALTER TABLE `audit_area_creation`
  MODIFY `audit_area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_area_creation_ref`
--
ALTER TABLE `audit_area_creation_ref`
  MODIFY `audit_area_creation_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `audit_assign`
--
ALTER TABLE `audit_assign`
  MODIFY `audit_assign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_assign_ref`
--
ALTER TABLE `audit_assign_ref`
  MODIFY `audit_assign_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audit_checklist`
--
ALTER TABLE `audit_checklist`
  MODIFY `audit_checklist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_checklist_ref`
--
ALTER TABLE `audit_checklist_ref`
  MODIFY `audit_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audit_followup`
--
ALTER TABLE `audit_followup`
  MODIFY `audit_followup_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bankmaster`
--
ALTER TABLE `bankmaster`
  MODIFY `bankid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `basic_creation`
--
ALTER TABLE `basic_creation`
  MODIFY `basic_creation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bm_checklist`
--
ALTER TABLE `bm_checklist`
  MODIFY `bm_checklist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branch_creation`
--
ALTER TABLE `branch_creation`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `business_com_line`
--
ALTER TABLE `business_com_line`
  MODIFY `business_com_line_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_com_out`
--
ALTER TABLE `business_com_out`
  MODIFY `business_com_out_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_com_parallel_agree_disagree`
--
ALTER TABLE `business_com_parallel_agree_disagree`
  MODIFY `business_com_parallel_agree_disagree_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign`
--
ALTER TABLE `campaign`
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `campaign_ref`
--
ALTER TABLE `campaign_ref`
  MODIFY `campaign_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category_creation`
--
ALTER TABLE `category_creation`
  MODIFY `category_creation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_creation`
--
ALTER TABLE `company_creation`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `costcentre`
--
ALTER TABLE `costcentre`
  MODIFY `costcentreid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_km`
--
ALTER TABLE `daily_km`
  MODIFY `daily_km_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_km_ref`
--
ALTER TABLE `daily_km_ref`
  MODIFY `daily_km_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_performance`
--
ALTER TABLE `daily_performance`
  MODIFY `daily_performance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_performance_ref`
--
ALTER TABLE `daily_performance_ref`
  MODIFY `daily_performance_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department_creation`
--
ALTER TABLE `department_creation`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `designation_creation`
--
ALTER TABLE `designation_creation`
  MODIFY `designation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `diesel_slip`
--
ALTER TABLE `diesel_slip`
  MODIFY `diesel_slip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goal_setting`
--
ALTER TABLE `goal_setting`
  MODIFY `goal_setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `goal_setting_ref`
--
ALTER TABLE `goal_setting_ref`
  MODIFY `goal_setting_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hierarchy_creation`
--
ALTER TABLE `hierarchy_creation`
  MODIFY `hierarchy_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday_creation`
--
ALTER TABLE `holiday_creation`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `holiday_creation_ref`
--
ALTER TABLE `holiday_creation_ref`
  MODIFY `holiday_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `insurance_creation`
--
ALTER TABLE `insurance_creation`
  MODIFY `insurance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `insurance_register`
--
ALTER TABLE `insurance_register`
  MODIFY `ins_reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `insurance_register_ref`
--
ALTER TABLE `insurance_register_ref`
  MODIFY `ins_reg_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `krakpi_calendar_map`
--
ALTER TABLE `krakpi_calendar_map`
  MODIFY `krakpi_calendar_map_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1518;

--
-- AUTO_INCREMENT for table `krakpi_creation`
--
ALTER TABLE `krakpi_creation`
  MODIFY `krakpi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `krakpi_creation_ref`
--
ALTER TABLE `krakpi_creation_ref`
  MODIFY `krakpi_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kra_creation`
--
ALTER TABLE `kra_creation`
  MODIFY `kra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kra_creation_ref`
--
ALTER TABLE `kra_creation_ref`
  MODIFY `kra_creation_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
  MODIFY `ledgerid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_checklist`
--
ALTER TABLE `maintenance_checklist`
  MODIFY `maintenance_checklist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maintenance_checklist_ref`
--
ALTER TABLE `maintenance_checklist_ref`
  MODIFY `maintenance_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `media_creation`
--
ALTER TABLE `media_creation`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meeting_minutes`
--
ALTER TABLE `meeting_minutes`
  MODIFY `meeting_minutes_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_minutes_approval_line`
--
ALTER TABLE `meeting_minutes_approval_line`
  MODIFY `meeting_minutes_approval_line_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_minutes_parallel_agree_disagree`
--
ALTER TABLE `meeting_minutes_parallel_agree_disagree`
  MODIFY `meeting_minutes_agree_disagree_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `memo`
--
ALTER TABLE `memo`
  MODIFY `memo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `memo_status`
--
ALTER TABLE `memo_status`
  MODIFY `memo_status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `periodic_level`
--
ALTER TABLE `periodic_level`
  MODIFY `periodic_level_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission_or_on_duty`
--
ALTER TABLE `permission_or_on_duty`
  MODIFY `permission_on_duty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pm_checklist`
--
ALTER TABLE `pm_checklist`
  MODIFY `pm_checklist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pm_checklist_ref`
--
ALTER TABLE `pm_checklist_ref`
  MODIFY `pm_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_creation`
--
ALTER TABLE `project_creation`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promotional_activities`
--
ALTER TABLE `promotional_activities`
  MODIFY `promotional_activities_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promotional_activities_ref`
--
ALTER TABLE `promotional_activities_ref`
  MODIFY `promotional_activities_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `report_creation`
--
ALTER TABLE `report_creation`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rgp_creation`
--
ALTER TABLE `rgp_creation`
  MODIFY `rgp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rr_creation`
--
ALTER TABLE `rr_creation`
  MODIFY `rr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rr_creation_ref`
--
ALTER TABLE `rr_creation_ref`
  MODIFY `rr_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_indent`
--
ALTER TABLE `service_indent`
  MODIFY `service_indent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `spare_creation`
--
ALTER TABLE `spare_creation`
  MODIFY `spare_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff_creation`
--
ALTER TABLE `staff_creation`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tag_creation`
--
ALTER TABLE `tag_creation`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `target_fixing`
--
ALTER TABLE `target_fixing`
  MODIFY `target_fixing_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `target_fixing_ref`
--
ALTER TABLE `target_fixing_ref`
  MODIFY `target_fixing_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `todo_creation`
--
ALTER TABLE `todo_creation`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transfer_location`
--
ALTER TABLE `transfer_location`
  MODIFY `transfer_location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  MODIFY `vehicle_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_status`
--
ALTER TABLE `work_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `year_creation`
--
ALTER TABLE `year_creation`
  MODIFY `year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
