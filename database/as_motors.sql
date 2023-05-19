-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2023 at 03:04 PM
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

--
-- Dumping data for table `accountsgroup`
--

INSERT INTO `accountsgroup` (`Id`, `AccountsName`, `ParentId`, `status`, `order_id`) VALUES
(1, 'Capital Account', 0, 0, 1),
(2, 'Current Liabilities', 0, 0, 2),
(3, 'Current Assets', 0, 0, 4),
(4, 'Purchase Accounts', 0, 0, 5),
(5, 'Direct Income', 0, 0, 6),
(6, 'Direct Expenses', 0, 0, 7),
(7, 'Indirect Income', 0, 0, 8),
(8, 'Indirect Expenses', 0, 0, 9),
(9, 'Profit & Loss A/c', 0, 0, 10),
(10, 'Diff. in Opening Balances', 0, 0, 11),
(11, 'Reserve & Surplus', 1, 0, 12),
(12, 'Sundry Creditors', 2, 0, 13),
(13, 'Loans(Liability)', 2, 0, 14),
(14, 'Bank OD', 2, 0, 15),
(15, 'Opening Stock', 3, 0, 16),
(16, 'Cash-in-hand', 3, 0, 17),
(17, 'Bank Accounts', 3, 0, 18),
(18, 'Investments', 3, 0, 19),
(19, 'Loans and Advances', 3, 0, 20),
(40, 'Sundry Debtors', 3, 0, 35),
(42, 'Fixed Assets', 0, 0, 3);

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

--
-- Dumping data for table `approval_line`
--

INSERT INTO `approval_line` (`approval_line_id`, `company_id`, `staff_id`, `approval_staff_id`, `agree_par_staff_id`, `after_notified_staff_id`, `receiving_dept_id`, `checker_approval`, `reviewer_approval`, `final_approval`, `checker_approval_date`, `reviewer_approval_date`, `final_approval_date`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', '2,3,4', '2,3,4', '2,3,4', '1', '1', '1', '1', '2023-05-12', '2023-05-12', '2023-05-12', 0, 20, NULL, NULL, '2023-05-12 18:38:43', '2023-05-12 18:38:43'),
(2, '1', '1', '2,3,4', '2,3,4', '2,3,4', '2', '0', '0', '0', NULL, NULL, NULL, 0, 20, NULL, NULL, '2023-05-15 10:04:36', '2023-05-15 10:04:36');

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

--
-- Dumping data for table `approval_requisition`
--

INSERT INTO `approval_requisition` (`approval_requisition_id`, `approval_line_id`, `staff_id`, `doc_no`, `auto_generation_date`, `title`, `comments`, `file`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', 'DOCNUM1', '12-05-2023', 'test', 'testst', '', 0, 20, NULL, NULL, '2023-05-12 18:39:01', '2023-05-12 18:39:01'),
(2, '2', '1', 'ARDOCNUM2', '15-05-2023', 'test', 'et', '', 0, 20, NULL, NULL, '2023-05-15 10:23:47', '2023-05-15 10:23:47');

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

--
-- Dumping data for table `approval_requisition_parallel_agree_disagree`
--

INSERT INTO `approval_requisition_parallel_agree_disagree` (`approval_requisition_agree_disagree_id`, `approval_line_id`, `agree_disagree_staff_id`, `agree_disagree`, `agree_disagree_date`, `status`, `created_date`) VALUES
(11, '1', '2', 1, '2023-05-12', 0, '2023-05-12 18:38:43'),
(12, '1', '3', 1, '2023-05-12', 0, '2023-05-12 18:38:43'),
(13, '1', '4', 0, NULL, 0, '2023-05-12 18:38:43'),
(14, '2', '2', 1, '2023-05-15', 0, '2023-05-15 10:04:36'),
(15, '2', '3', 0, NULL, 0, '2023-05-15 10:04:36'),
(16, '2', '4', 0, NULL, 0, '2023-05-15 10:04:36');

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
(1, '1', '1', '3', '1', '60000', '2023-05-05', '2023-05-05', '50000', '1', 0, NULL, NULL, '2023-05-05 12:17:51', '2023-05-05 12:17:51');

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
(2, 1, 111111, '2023-05-05');

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
(1, '1', '3', 'Dell System', '2023-05-05', 2, 60000, '1', 'inward', 0, 1, NULL, NULL, '2023-05-05 12:15:39', '2023-05-05 12:15:39');

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
(1, '1', 0, '2023-05-05 13:27:35', '2023-05-05 13:27:35', NULL, NULL);

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
(1, '1', '1', '1', '2', 'Webapp Creation', NULL, '2023-05-05 00:00:00', '2023-05-16 00:00:00', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `audit_area_creation`
--

CREATE TABLE `audit_area_creation` (
  `audit_area_id` int(11) NOT NULL,
  `audit_area` varchar(250) DEFAULT NULL,
  `department_id` varchar(250) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
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

INSERT INTO `audit_area_creation` (`audit_area_id`, `audit_area`, `department_id`, `frequency`, `calendar`, `from_date`, `to_date`, `role1`, `role2`, `check_list`, `work_status`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Area1', '1,2', 'Fortnightly', 'Yes', '2023-05-09 12:31:01', '2023-05-13 12:31:01', '1', '2', 'Yes', 3, 0, 1, NULL, NULL, '2023-05-09 12:31:01', '2023-05-09 12:31:01');

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
(1, '2023-05-12', '1,2', '1', '2', '1', 1, 0, 1, NULL, NULL, '2023-05-12 17:12:19', '2023-05-12 17:12:19'),
(2, '2023-05-12', '1,2', '1', '2', '1', 1, 0, 21, NULL, NULL, '2023-05-12 17:19:26', '2023-05-12 17:19:26'),
(3, '2023-05-12', '1,2', '1', '2', '1', 1, 0, 21, NULL, NULL, '2023-05-12 17:21:14', '2023-05-12 17:21:14'),
(4, '2023-05-12', '1,2', '1', '2', '1', 0, 0, 21, NULL, NULL, '2023-05-12 17:41:39', '2023-05-12 17:41:39');

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
  `auditee_followup_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_assign_ref`
--

INSERT INTO `audit_assign_ref` (`audit_assign_ref_id`, `audit_assign_id`, `major_area`, `assertion`, `audit_status`, `recommendation`, `attachment`, `audit_remarks`, `auditee_response`, `action_plan`, `target_date`, `auditee_response_status`, `auditee_followup_status`) VALUES
(1, '1', 'chennai', 'test', '0', 'asdf', '', 'sdf', NULL, NULL, NULL, 0, 0),
(2, '1', 'pondy', 'test1', '0', 'asdf', '', 'sadf', NULL, NULL, NULL, 0, 0),
(3, '2', 'chennai', 'test', '0', 'asdf', '', 'sdf', NULL, NULL, NULL, 0, 0),
(4, '2', 'pondy', 'test1', '0', 'sadf', '', 'asdf', NULL, NULL, NULL, 0, 0),
(5, '3', 'chennai', 'test', '0', 'asdf', '', 'asdf', 'asdf', 'asdf1212', '2023-05-12', 1, 0),
(6, '3', 'pondy', 'test1', '0', 'sadfsfsdf', '', 'asdf', '1212', '121221', '2023-05-22', 1, 0),
(7, '4', 'chennai', 'test', '0', 'asdf', '', 'sadf', NULL, NULL, NULL, 0, 0),
(8, '4', 'pondy', 'test1', '0', 'sadf', '', 'asdf', NULL, NULL, NULL, 0, 0);

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
(1, 1, '1,2', '1', '2', 0);

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
(1, 1, 'chennai', NULL, 'test', ''),
(2, 1, 'pondy', NULL, 'test1', '');

-- --------------------------------------------------------

--
-- Table structure for table `audit_followup`
--

CREATE TABLE `audit_followup` (
  `audit_followup_id` int(11) NOT NULL,
  `audit_assign_id` int(11) NOT NULL,
  `audit_assign_ref_id` int(11) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `completed_date` date NOT NULL,
  `files` varchar(200) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp()
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
(1, NULL, '1', 'Dev-1/Pondicherry', 'DESIG-1/Pondicherry', '1', '1', '', 0, 1, NULL, NULL, '2023-05-04 18:24:28', '2023-05-04 18:24:28'),
(2, NULL, '1', 'Dev-2/Pondicherry', 'DESIG-2/Pondicherry', '1', '2', '1', 0, 1, NULL, NULL, '2023-05-04 18:24:40', '2023-05-04 18:24:40'),
(3, NULL, '1', 'Dev-3/Pondicherry', 'DESIG-3/Pondicherry', '1', '3', '2', 0, 1, NULL, NULL, '2023-05-04 18:24:51', '2023-05-04 18:24:51'),
(4, NULL, '1', 'Mar-4/Pondicherry', 'DESIG-4/Pondicherry', '2', '4', '', 0, 1, NULL, NULL, '2023-05-04 18:25:39', '2023-05-04 18:25:39'),
(5, NULL, '1', 'Mar-5/Pondicherry', 'DESIG-5/Pondicherry', '2', '5', '4', 0, 1, NULL, NULL, '2023-05-04 18:25:49', '2023-05-04 18:25:49'),
(6, NULL, '2', 'HR-6/Vandavasi', 'DESIG-6/Vandavasi', '3', '6', '', 0, 1, NULL, NULL, '2023-05-04 18:27:18', '2023-05-04 18:27:18'),
(7, NULL, '2', 'HR-7/Vandavasi', 'DESIG-7/Vandavasi', '3', '7', '6', 0, 1, NULL, NULL, '2023-05-04 18:27:27', '2023-05-04 18:27:27');

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
(1, '1', '1', 'test', 'High', 0, 0, 1, NULL, NULL, '2023-05-05 13:34:01', '2023-05-05 13:34:01');

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
(1, 'Pondicherry', 1, 'Bussy Street', 'Chinnakadai', 'Shanmuga Priyan', 'Chennai', 'TamilNadu', 'support@feathertechnology.in', 'www.feathertechnology.com', 'ABCTY1234D', 'MH/BAN/0000064/000/0000123', '', '', '31/00/123456/000/0001', 'PDES03028F', NULL, 0, 1, NULL, NULL, '2023-05-04 18:21:40', '2023-05-04 18:21:40'),
(2, 'Vandavasi', 2, 'Gandhi Street', 'Vandavasi', 'Prabakaran', 'Tiruvannamalai', 'TamilNadu', 'marudham@gmail.com', 'www.marudham.com', 'ABCTY1234D', '', '', '', '31/00/123456/000/0001', 'PDES03028E', NULL, 0, 1, NULL, NULL, '2023-05-04 18:22:14', '2023-05-04 18:22:14');

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

--
-- Dumping data for table `business_com_line`
--

INSERT INTO `business_com_line` (`business_com_line_id`, `company_id`, `staff_id`, `approval_staff_id`, `agree_par_staff_id`, `after_notified_staff_id`, `recipient_id`, `receiving_branch_id`, `checker_approval`, `reviewer_approval`, `final_approval`, `checker_approval_date`, `reviewer_approval_date`, `final_approval_date`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', '2,3,4', '2,3,4', '2,3,4', '3', '2', '1', '1', '1', '2023-05-13', '2023-05-13', '2023-05-13', 0, 20, NULL, NULL, '2023-05-13 14:34:53', '2023-05-13 14:34:53');

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

--
-- Dumping data for table `business_com_out`
--

INSERT INTO `business_com_out` (`business_com_out_id`, `business_com_line_id`, `staff_id`, `doc_no`, `auto_generation_date`, `title`, `comments`, `file`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', 'DOCNUM1', '13-05-2023', 'test', 'test', '', 0, 20, NULL, NULL, '2023-05-13 14:35:11', '2023-05-13 14:35:11');

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

--
-- Dumping data for table `business_com_parallel_agree_disagree`
--

INSERT INTO `business_com_parallel_agree_disagree` (`business_com_parallel_agree_disagree_id`, `business_com_line_id`, `agree_disagree_staff_id`, `agree_disagree`, `agree_disagree_date`, `status`, `created_date`) VALUES
(1, '1', '2', 1, '2023-05-13', 0, '2023-05-13 14:34:53'),
(2, '1', '3', 1, '2023-05-13', 0, '2023-05-13 14:34:53'),
(3, '1', '4', 1, '2023-05-13', 0, '2023-05-13 14:34:53');

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
(1, '1', '2023-05-11', 1, 1, NULL, 1, '2023-05-11 18:38:22', '2023-05-11 18:38:22'),
(2, '1', '2023-05-11', 0, 1, 1, NULL, '2023-05-11 18:44:19', '2023-05-11 18:44:19'),
(3, '1', '2023-05-11', 0, 1, NULL, NULL, '2023-05-11 18:50:00', '2023-05-11 18:50:00');

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
(1, '1', '1', 'act 1', '10', '3', '2023-05-11 18:38:22', '2023-05-12 18:38:22', '1', 3),
(2, '1', '2', 'act 2', '5', '2', '2023-05-11 18:38:22', '2023-05-14 18:38:22', '2', 3),
(5, '2', '1', 'act 1', '10', '3', ' 18:44:31', ' 18:44:31', '1', 0),
(6, '2', '2', 'act 2', '5', '2', ' 18:44:31', ' 18:44:31', '2', 0),
(7, '3', '1', 'act 1', '10', '3', '2023-05-11 18:50:00', '2023-05-13 18:50:00', '1', 3),
(8, '3', '2', 'act 2', '5', '2', '2023-05-11 18:50:00', '2023-05-17 18:50:00', '2', 0);

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
(1, 'Category1', 0, NULL, NULL, NULL, '2023-05-05 01:03:16', '2023-05-05 01:03:16'),
(2, 'Category2', 0, NULL, NULL, NULL, '2023-05-05 01:03:55', '2023-05-05 01:03:55');

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
(1, 'Feather Technology', 'Partnership', '', 'Car Street', 'Chinnakadai', 'Ram', 'Chennai', 'TamilNadu', 'support@feathertechnology.in', 'www.feathertechnology.com', 'ABCTY1234D', 'MH/BAN/0000064/000/0000123', '', '', '31/00/123456/000/0001', 'PDES03028F', '', 0, 1, 1, NULL, '2023-05-04 18:19:24', '2023-05-04 18:19:24'),
(2, 'Marutham', 'Partnership', '', 'Gandhi Street', 'Vandavasi', '', 'Tiruvannamalai', 'TamilNadu', 'marudham@gmail.com', 'www.marudham.com', '', 'MH/BAN/0000064/000/0000123', '', '', '31/00/123456/000/0001', 'PDES03028F', '', 0, 1, NULL, NULL, '2023-05-04 18:20:55', '2023-05-04 18:20:55');

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

--
-- Dumping data for table `daily_km`
--

INSERT INTO `daily_km` (`daily_km_id`, `company_id`, `date`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '2023-05-05', 0, NULL, NULL, NULL, '2023-05-05 02:05:23', '2023-05-05 02:05:23'),
(2, '1', '2023-05-05', 0, NULL, NULL, NULL, '2023-05-05 14:43:13', '2023-05-05 14:43:13');

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

--
-- Dumping data for table `daily_km_ref`
--

INSERT INTO `daily_km_ref` (`daily_km_ref_id`, `vehicle_details_id`, `vehicle_number`, `start_km`, `end_km`, `daily_km_id`) VALUES
(2, '1', '111', '50', '500', '1'),
(3, '1', '111', '50', '100', '2');

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
(1, 'Development', 1, 0, '2023-05-04 05:53:47', '2023-05-04 05:53:47'),
(2, 'Marketing', 1, 0, '2023-05-04 05:53:56', '2023-05-04 05:53:56'),
(3, 'HR', 2, 0, '2023-05-04 05:56:01', '2023-05-04 05:56:01'),
(4, 'Accounts', 2, 0, '2023-05-04 05:56:08', '2023-05-04 05:56:08');

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
(1, 'TL', 1, 0, '2023-05-04 05:54:06', '2023-05-04 05:54:06'),
(2, 'Senior Developer', 1, 0, '2023-05-04 05:54:12', '2023-05-04 05:54:12'),
(3, 'Junior Developer', 1, 0, '2023-05-04 05:54:18', '2023-05-04 05:54:18'),
(4, 'Marketing Manager', 1, 0, '2023-05-04 05:55:19', '2023-05-04 05:55:19'),
(5, 'Marketing Executive', 1, 0, '2023-05-04 05:55:32', '2023-05-04 05:55:32'),
(6, 'Senior HR', 2, 0, '2023-05-04 05:56:46', '2023-05-04 05:56:46'),
(7, 'Junior HR', 2, 0, '2023-05-04 05:56:55', '2023-05-04 05:56:55');

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

--
-- Dumping data for table `diesel_slip`
--

INSERT INTO `diesel_slip` (`diesel_slip_id`, `company_id`, `vehicle_number`, `previous_km`, `previous_km_date`, `present_km`, `present_km_date`, `total_km_run`, `diesel_amount`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', 100, '2023-05-05', 500, '2023-05-10', 400, 50, 0, 1, NULL, NULL, '2023-05-10 12:44:51', '2023-05-10 12:44:51');

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

--
-- Dumping data for table `goal_setting`
--

INSERT INTO `goal_setting` (`goal_setting_id`, `company_name`, `department`, `role`, `year`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '2', '3', '7', '5', 0, 1, NULL, NULL, '2023-05-16 10:45:58', '2023-05-16 10:45:58'),
(2, '2', '3', '7', '5', 0, 1, NULL, NULL, '2023-05-16 10:46:35', '2023-05-16 10:46:35');

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

--
-- Dumping data for table `goal_setting_ref`
--

INSERT INTO `goal_setting_ref` (`goal_setting_ref_id`, `goal_setting_id`, `assertion`, `target`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 1, 'test1', '300', 0, 1, NULL, NULL, '2023-05-16 10:54:37', '2023-05-16 10:54:37'),
(2, 1, 'test2', '500', 0, 0, NULL, NULL, '2023-05-16 10:54:37', '2023-05-16 10:54:37'),
(3, 1, 'test3', '600', 0, 1, NULL, NULL, '2023-05-16 10:54:38', '2023-05-16 10:54:38'),
(4, 2, 'test4', '800', 0, 0, NULL, NULL, '2023-05-16 10:54:38', '2023-05-16 10:54:38'),
(5, 2, 'test5', '200', 0, 1, NULL, NULL, '2023-05-16 10:54:38', '2023-05-16 10:54:38');

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
(1, '2023-2024', '1,2', 0, 1, NULL, NULL, '2023-05-04 18:23:04', '2023-05-04 18:23:04');

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
(3, 1, '2023-05-10', 'Holiday 1', 0, 1, NULL, NULL, '2023-05-04 18:23:09', '2023-05-04 18:23:09'),
(4, 1, '2023-05-25', 'Holiday 2', 0, 1, NULL, NULL, '2023-05-04 18:23:09', '2023-05-04 18:23:09');

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
(1, 'Health Insurance', 1, 0, '2023-05-04 23:46:10', '2023-05-04 23:46:10');

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
  `from_date` varchar(255) DEFAULT NULL,
  `to_date` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurance_register`
--

INSERT INTO `insurance_register` (`ins_reg_id`, `company_id`, `insurance_id`, `dept_id`, `freq_id`, `department_id`, `designation_id`, `staff_id`, `from_date`, `to_date`, `status`, `created_date`, `updated_date`) VALUES
(1, 1, 1, 1, 1, '1', '1', '1', '2023-05-05', '2023-05-15', 0, '2023-05-05 12:16:25', '2023-05-05 12:16:25');

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
(1, '1', '1', '1', 0, 1, NULL, NULL, '2023-05-05 15:23:53', '2023-05-05 15:23:53'),
(2, '1', '1', '1', 0, 1, NULL, NULL, '2023-05-18 16:23:19', '2023-05-18 16:23:19');

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

INSERT INTO `krakpi_creation_ref` (`krakpi_ref_id`, `krakpi_reff_id`, `kra_category`, `rr`, `kpi`, `frequency`, `calendar`, `from_date`, `to_date`, `criteria`, `project_id`, `work_status`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 1, '1', '4', '', 'Fortnightly', 'Yes', '2023-05-05 15:23:53', '2023-05-12 15:23:53', 'Project', '1', 3, 0, 1, NULL, NULL, '2023-05-05 15:23:53', '2023-05-05 15:23:53');

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
(1, '1', '1', '1', 0, 1, NULL, NULL, '2023-05-04 18:35:26', '2023-05-04 18:35:26'),
(2, '1', '1', '2', 0, 1, NULL, NULL, '2023-05-04 18:35:40', '2023-05-04 18:35:40'),
(3, '1', '1', '3', 0, 1, NULL, NULL, '2023-05-04 18:35:53', '2023-05-04 18:35:53'),
(4, '1', '2', '4', 0, 1, NULL, NULL, '2023-05-04 18:36:07', '2023-05-04 18:36:07'),
(5, '1', '2', '5', 0, 1, NULL, NULL, '2023-05-04 18:36:20', '2023-05-04 18:36:20'),
(6, '2', '3', '6', 0, 1, NULL, NULL, '2023-05-04 18:36:31', '2023-05-04 18:36:31'),
(7, '2', '3', '7', 0, 1, NULL, NULL, '2023-05-04 18:36:42', '2023-05-04 18:36:42');

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
(1, 'kra1', '50', '1'),
(2, 'kra2', '50', '1'),
(3, 'kra3', '100', '2'),
(4, 'kra4', '100', '3'),
(5, 'kra5', '100', '4'),
(6, 'kra6', '100', '5'),
(7, 'kra7', '100', '6'),
(8, 'kra8', '100', '7');

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
(1, '1', '2023-05-11', '1', 'pm_checklist', 'Yes', '2023-05-11 18:32:04', '2023-05-12 18:32:04', '1', '2', 0, 3, 0, NULL, NULL, NULL, '2023-05-11 18:32:04', '2023-05-11 18:32:04');

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
(1, '1', '2', NULL, 'test', '', NULL, 0);

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
(1, 1, 'Media 1', 'ZR_106418_CAND.pdf', '2023-05-05', '2023-05-15', 'Facebook', 0);

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

--
-- Dumping data for table `meeting_minutes`
--

INSERT INTO `meeting_minutes` (`meeting_minutes_id`, `meeting_minutes_approval_line_id`, `staff_id`, `doc_no`, `auto_generation_date`, `title`, `comments`, `file`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', 'MMDOCNUM1', '15-05-2023', 'test', 'test', 'ZR_106418_CAND (1).pdf', 0, 20, NULL, NULL, '2023-05-15 10:40:13', '2023-05-15 10:40:13');

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

--
-- Dumping data for table `meeting_minutes_approval_line`
--

INSERT INTO `meeting_minutes_approval_line` (`meeting_minutes_approval_line_id`, `company_id`, `staff_id`, `approval_staff_id`, `agree_par_staff_id`, `after_notified_staff_id`, `receiving_dept_id`, `checker_approval`, `reviewer_approval`, `final_approval`, `checker_approval_date`, `reviewer_approval_date`, `final_approval_date`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', '2,3,4', '2,3,4', '2,3,4', '2', '1', '1', '1', '2023-05-15', '2023-05-15', '2023-05-15', 0, 20, NULL, NULL, '2023-05-15 10:37:19', '2023-05-15 10:37:19');

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

--
-- Dumping data for table `meeting_minutes_parallel_agree_disagree`
--

INSERT INTO `meeting_minutes_parallel_agree_disagree` (`meeting_minutes_agree_disagree_id`, `meeting_minutes_approval_line_id`, `agree_disagree_staff_id`, `agree_disagree`, `agree_disagree_date`, `status`, `created_date`) VALUES
(1, '1', '2', 1, '2023-05-15', 0, '2023-05-15 10:37:19'),
(2, '1', '3', 1, '2023-05-15', 0, '2023-05-15 10:37:19'),
(3, '1', '4', 1, '2023-05-15', 0, '2023-05-15 10:37:19');

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
(1, '1', NULL, '1', '1', '1', 'test', 'test', 'ZR_106418_CAND.pdf', '2023-05-11', '', '', '2023-05-14', '', 'test', 0, 1, 1, NULL, '2023-05-05 13:32:03', '2023-05-05 13:32:03');

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
(1, '1', '1', '1', '111', '', 'Permission', '03:34', '04:35', '2023-05-05', '', '', '', 0, 1, NULL, NULL, '2023-05-05 14:33:37', '2023-05-05 14:33:37');

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

INSERT INTO `pm_checklist` (`pm_checklist_id`, `company_id`, `category_id`, `checklist`, `type_of_checklist`, `yes_no_na`, `no_of_option`, `option1`, `option2`, `option3`, `option4`, `frequency`, `rating`, `maintenance_checklist`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', '1', 'test', 'Option', 'Yes', '2', 'option1', 'option2', '', '', 'Fortnightly', 'High', 1, 0, 1, NULL, NULL, '2023-05-05 13:33:36', '2023-05-05 13:33:36'),
(2, '1', '1', 'test', 'Yes/No/NA', '', '', '', '', '', '', 'Fortnightly', 'High', 1, 0, 1, NULL, NULL, '2023-05-11 18:31:59', '2023-05-11 18:31:59'),
(3, '1', '1', 'stset', 'Yes/No/NA', '', '', '', '', '', '', 'Fortnightly', 'High', 0, 0, 1, NULL, NULL, '2023-05-13 13:20:14', '2023-05-13 13:20:14');

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
(1, 'project1', 0, NULL, NULL, NULL, '2023-05-04 06:08:10', '2023-05-04 06:08:10'),
(2, 'project2', 0, NULL, NULL, NULL, '2023-05-04 06:12:14', '2023-05-04 06:12:14'),
(3, 'project3', 0, NULL, NULL, NULL, '2023-05-05 01:01:09', '2023-05-05 01:01:09');

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
(1, 'project1', 0, 0, 1, NULL, NULL, '2023-05-10 15:58:48', '2023-05-10 15:58:48'),
(2, 'project2', 0, 0, 1, NULL, NULL, '2023-05-10 16:04:59', '2023-05-10 16:04:59');

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
(1, 1, 'act 1', 10, 3, '2023-05-11', '2023-05-13', '1'),
(2, 1, 'act 2', 5, 2, '2023-05-11', '2023-05-17', '2'),
(4, 3, 'act 3', 20, 5, NULL, NULL, NULL),
(5, 3, 'act 4', 15, 2, NULL, NULL, NULL);

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
(1, 1, 'Template 1', 'Prasanth (2) (1) (1).pdf', 0);

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
(1, '2023-05-05', '2023-05-07', '3', '1', '1', '2', 'Bussy Street', 'Chinnakadai', 'Gandhi Street', 'Vandavasi', '1', '60000', 'test', '2023-05-13', 'test', NULL, 'inward', 1, NULL, NULL, '2023-05-05 12:18:32', '2023-05-05 12:18:32');

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
(1, '1', 0, 1, NULL, NULL, '2023-05-04 18:29:57', '2023-05-04 18:29:57'),
(2, '2', 0, 1, NULL, NULL, '2023-05-04 18:30:53', '2023-05-04 18:30:53'),
(3, '1', 0, 1, NULL, NULL, '2023-05-05 14:55:13', '2023-05-05 14:55:13');

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
(1, '1', '1', '1', 'Website Creation', 'Fortnightly', '111', 'Common', 0, 1, NULL, NULL, '2023-05-04 18:29:57', '2023-05-04 18:29:57'),
(2, '1', '1', '2', 'Webapp Creation', 'Monthly', '112', 'Common', 0, 1, NULL, NULL, '2023-05-04 18:29:57', '2023-05-04 18:29:57'),
(3, '1', '2', '4', 'Market sw', 'Quaterly', '113', 'Common', 0, 1, NULL, NULL, '2023-05-04 18:29:57', '2023-05-04 18:29:57'),
(4, '1', '2', '5', 'Market smm', 'Half Yearly', '114', 'Common', 0, 1, NULL, NULL, '2023-05-04 18:29:57', '2023-05-04 18:29:57'),
(5, '2', '3', '6', 'Hiring', 'Fortnightly', '222', 'Common', 0, 1, NULL, NULL, '2023-05-04 18:30:53', '2023-05-04 18:30:53'),
(6, '2', '3', '7', 'Attendance Work', 'Monthly', '223', 'Common', 0, 1, NULL, NULL, '2023-05-04 18:30:53', '2023-05-04 18:30:53'),
(8, '3', '1', '3', 'test1', 'Fortnightly', NULL, NULL, 0, 1, NULL, NULL, '2023-05-05 14:55:49', '2023-05-05 14:55:49');

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
(1, '1', '2023-05-05', '3', '1', '60000', 'test1', 'test2', 'tes3', 'Bussy Street, Chinnakadai', 'Chennai', 'TamilNadu', 'test', '2023-05-05', 2, 0, 1, 1, NULL, '2023-05-05 12:17:08', '2023-05-05 12:17:08');

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
(1, 'Keyboard', 1, 1, 0, '2023-05-04 23:47:47', '2023-05-04 23:47:47');

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
(1, 'Suresh', 1, 1, '111', 1, '2023-05-04', '1', '2023-05-04', 'coding', '2121212121', 'test@gmail.com', '', 0, 1, NULL, NULL, '2023-05-04 18:55:47', '2023-05-04 18:55:47'),
(2, 'Barath', 1, 2, '112', 1, '2023-05-04', '1', '2023-05-04', 'coding', '1111111111', 'test@gmail.com1', '1', 0, 1, NULL, NULL, '2023-05-04 18:56:13', '2023-05-04 18:56:13'),
(3, 'Ram', 1, 3, '113', 1, '2023-05-04', '1', '2023-05-04', 'coding', '3333333333', 'test1@gmail.com', '2', 0, 1, NULL, NULL, '2023-05-04 18:56:43', '2023-05-04 18:56:43'),
(4, 'Kumar', 1, 3, '114', 1, '2023-05-12', '1', '2023-05-12', 'coding', '1222211111', 'test@gmail.com', '3', 0, 1, NULL, NULL, '2023-05-12 18:02:35', '2023-05-12 18:02:35');

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
(1, '1', '1', 'Development Tag', 0, 1, NULL, NULL, '2023-05-04 18:27:43', '2023-05-04 18:27:43'),
(2, '2', '1', 'Marketing Tag', 0, 1, NULL, NULL, '2023-05-04 18:27:54', '2023-05-04 18:27:54'),
(3, '3', '2', 'HR Tag', 0, 1, NULL, NULL, '2023-05-04 18:28:03', '2023-05-04 18:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `target_fixing`
--

CREATE TABLE `target_fixing` (
  `target_fixing_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
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
  `assertion` varchar(200) DEFAULT NULL,
  `target` varchar(100) DEFAULT NULL,
  `new_assertion` varchar(200) DEFAULT NULL,
  `new_target` varchar(100) DEFAULT NULL,
  `applicability` varchar(250) DEFAULT NULL,
  `delete_date` datetime NOT NULL DEFAULT current_timestamp(),
  `delete_remarks` text DEFAULT NULL
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
(1, '1', 'test', '1', '1', '2', '2023-05-05 13:28:40', '2023-05-08 13:28:40', 3, 'Event', '1', 0, '2023-05-05 13:28:40', '2023-05-05 13:28:40', 1, NULL),
(2, '1', 'test', '1', '1', '3,1,2', '2023-05-05 13:30:47', '2023-05-10 13:30:47', 3, 'Project', '1', 0, '2023-05-05 13:30:47', '2023-05-05 13:30:47', 1, NULL),
(3, '1', 'test', '1', '1', '2,3,1', '2023-05-11 18:23:45', '2023-05-15 18:23:45', 3, 'Event', '', 0, '2023-05-11 18:23:45', '2023-05-11 18:23:45', 1, NULL);

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
(1, '1', '1', '1', 'Suresh', '2023-05-05', '2', '2023-05-05', 'ZR_106418_CAND.pdf', 0, 1, 1, NULL, '2023-05-05 14:34:17', '2023-05-05 14:34:17');

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
  `status` varchar(255) DEFAULT '0',
  `Createddate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `fullname`, `title`, `emailid`, `user_name`, `user_password`, `role`, `staff_id`, `branch_id`, `status`, `Createddate`) VALUES
(1, 'Super', 'Admin', 'Super Admin', 'Super Admin', 'support@feathertechnology.in', 'support@feathertechnology.in', 'admin@123', '1', 'Overall', 'Overall', '0', '2021-04-17 17:08:00'),
(19, 'Manager', 'Manager', 'Manager', 'Manager', 'manager@feathertechnology.in', 'manager@feathertechnology.in', 'admin@123', '3', NULL, '1', '0', '2023-01-31 16:52:54'),
(20, 'Employee', 'Employee', 'Employee', 'Employee', 'employee@feathertechnology.in', 'employee@feathertechnology.in', 'admin@123', '4', '1', '1', '0', '2023-03-10 16:33:04'),
(21, 'Employee1', 'Employee1', 'Employee1', 'Employee1', 'employee1@feathertechnology.in', 'employee1@feathertechnology.in', 'admin@123', NULL, '2', '1', '0', '2023-03-14 13:09:26'),
(22, 'Employee2', 'Employee2', 'Employee2', 'Employee2', 'employee2@feathertechnology.in', 'employee2@feathertechnology.in', 'admin@123', NULL, '3', '1', '0', '2023-03-15 10:48:41'),
(23, 'Employee3', 'Employee3', 'Employee3', 'Employee3', 'employee3@feathertechnology.in', 'employee3@feathertechnology.in', 'admin@123', NULL, '4', '1', '0', '2023-03-16 16:34:10'),
(24, 'Employee4', 'Employee4', 'Employee4', 'Employee4', 'employee4@feathertechnology.in', 'employee4@feathertechnology.in', 'admin@123', NULL, '5', '2', '0', '2023-03-22 09:40:51');

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

--
-- Dumping data for table `vehicle_details`
--

INSERT INTO `vehicle_details` (`vehicle_details_id`, `company_id`, `vehicle_code`, `vehicle_name`, `vehicle_number`, `date_of_purchase`, `fitment_upto`, `insurance_upto`, `asset_value`, `book_value_as_on`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '1', 'VC1', 'Car', '111', '2023-05-05', '2023-05-07', '2023-05-12', '60000', '30000', 0, 1, NULL, NULL, '2023-05-05 14:35:08', '2023-05-05 14:35:08');

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

--
-- Dumping data for table `work_status`
--

INSERT INTO `work_status` (`status_id`, `work_id`, `work_des`, `work_status`, `remarks`, `completed_file`, `outdated_completed_date`, `status`, `created_date`, `updated_date`, `created_id`, `updated_id`) VALUES
(1, 'krakpi_ref 1', 'Webapp Creation', '1', 'test', NULL, NULL, 0, '2023-05-04 06:28:08', '2023-05-04 06:28:08', NULL, NULL),
(2, 'krakpi_ref 1', 'Webapp Creation', '2', 'tset1', NULL, NULL, 0, '2023-05-04 06:28:17', '2023-05-04 06:28:17', NULL, NULL),
(3, 'krakpi_ref 1', 'Webapp Creation', '3', NULL, '', NULL, 0, '2023-05-04 06:28:23', '2023-05-04 06:28:23', NULL, NULL),
(4, 'audit 1', 'Area1', '1', 'test', NULL, NULL, 0, '2023-05-05 15:10:34', '2023-05-05 15:10:34', NULL, NULL),
(5, 'audit 1', 'Area1', '3', NULL, '', NULL, 0, '2023-05-05 15:12:28', '2023-05-05 15:12:28', NULL, NULL),
(6, 'audit 1', 'Area1', '1', 'sadf', NULL, NULL, 0, '2023-05-05 15:17:12', '2023-05-05 15:17:12', NULL, NULL),
(7, 'audit 1', 'Area1', '1', 'sadf', NULL, NULL, 0, '2023-05-05 15:18:11', '2023-05-05 15:18:11', NULL, NULL),
(8, 'audit 1', 'Area1', '1', 'sadf', NULL, NULL, 0, '2023-05-05 15:18:59', '2023-05-05 15:18:59', NULL, NULL),
(9, 'audit 1', 'Area1', '1', 'asdf', NULL, NULL, 0, '2023-05-05 15:20:45', '2023-05-05 15:20:45', NULL, NULL),
(10, '1', 'Webapp Creation', '1', 'sadf', NULL, NULL, 0, '2023-05-05 15:22:24', '2023-05-05 15:22:24', NULL, NULL),
(11, '1', 'Webapp Creation', '1', 'test', NULL, NULL, 0, '2023-05-05 15:22:52', '2023-05-05 15:22:52', NULL, NULL),
(12, 'todo 2', 'test', '2', '', NULL, NULL, 0, '2023-05-05 15:23:02', '2023-05-05 15:23:02', NULL, NULL),
(13, '1', 'Webapp Creation', '3', NULL, '', NULL, 0, '2023-05-05 15:23:09', '2023-05-05 15:23:09', NULL, NULL),
(14, 'todo 2', 'test', '3', NULL, '', NULL, 0, '2023-05-05 15:23:15', '2023-05-05 15:23:15', NULL, NULL),
(15, 'krakpi_ref 1', 'Market smm', '1', 'test', NULL, NULL, 0, '2023-05-05 15:24:00', '2023-05-05 15:24:00', NULL, NULL),
(16, 'krakpi_ref 1', 'Market smm', '2', '', NULL, NULL, 0, '2023-05-05 15:24:05', '2023-05-05 15:24:05', NULL, NULL),
(17, 'krakpi_ref 1', 'Market smm', '3', NULL, '', NULL, 0, '2023-05-05 15:24:10', '2023-05-05 15:24:10', NULL, NULL),
(18, 'audit 1', 'area 1', '1', 'tsdfdf', NULL, NULL, 0, '2023-05-05 15:26:23', '2023-05-05 15:26:23', NULL, NULL),
(19, 'audit 1', 'area 1', '1', 'test', NULL, NULL, 0, '2023-05-05 15:32:54', '2023-05-05 15:32:54', NULL, NULL),
(20, 'audit 1', 'area 1', '2', '', NULL, NULL, 0, '2023-05-05 15:33:45', '2023-05-05 15:33:45', NULL, NULL),
(21, 'audit 1', 'area 1', '1', NULL, '', NULL, 0, '2023-05-05 15:33:49', '2023-05-05 15:33:49', NULL, NULL),
(22, 'audit 1', '1', '1', 'sadf', NULL, NULL, 0, '2023-05-05 15:34:11', '2023-05-05 15:34:11', NULL, NULL),
(23, 'audit 1', 'area 1', '1', 'sadf', NULL, NULL, 0, '2023-05-05 15:40:04', '2023-05-05 15:40:04', NULL, NULL),
(24, 'audit 1', 'area 1', '1', 'sadf', NULL, NULL, 0, '2023-05-05 15:40:19', '2023-05-05 15:40:19', NULL, NULL),
(25, 'audit 1', 'area 1', '2', 'sadfsdf', NULL, NULL, 0, '2023-05-05 15:40:27', '2023-05-05 15:40:27', NULL, NULL),
(26, 'audit 1', 'area 1', '1', 'sdf', NULL, NULL, 0, '2023-05-05 15:40:48', '2023-05-05 15:40:48', NULL, NULL),
(27, 'audit_area 1', 'area 1', '1', 'sdf', NULL, NULL, 0, '2023-05-05 15:45:00', '2023-05-05 15:45:00', NULL, NULL),
(28, '', '', '1', NULL, NULL, '', 0, '2023-05-10 14:43:22', '2023-05-10 14:43:22', NULL, NULL),
(29, '', '', '1', NULL, NULL, '', 0, '2023-05-10 14:43:40', '2023-05-10 14:43:40', NULL, NULL),
(30, '', '', '1', NULL, NULL, '2023-05-10', 0, '2023-05-10 14:43:57', '2023-05-10 14:43:57', NULL, NULL),
(31, 'todo 1', 'test', '0', NULL, NULL, '2023-05-11', 0, '2023-05-10 14:49:09', '2023-05-10 14:49:09', NULL, NULL),
(32, 'audit_area 1', 'Area1', '0', NULL, '', NULL, 0, '2023-05-10 14:51:36', '2023-05-10 14:51:36', NULL, NULL),
(33, 'todo 1', 'test', '0', NULL, NULL, '2023-05-10', 0, '2023-05-10 15:00:36', '2023-05-10 15:00:36', NULL, NULL),
(34, 'todo 1', 'test', '0', NULL, NULL, '2023-05-10', 0, '2023-05-10 15:11:23', '2023-05-10 15:11:23', NULL, NULL),
(35, 'todo 1', 'test', '3', NULL, NULL, '2023-05-11', 0, '2023-05-11 17:15:44', '2023-05-11 17:15:44', NULL, NULL),
(36, 'todo 2', 'test', '3', NULL, NULL, '2023-05-11', 0, '2023-05-11 17:15:49', '2023-05-11 17:15:49', NULL, NULL),
(37, 'audit_area 1', 'Area1', '3', NULL, '', NULL, 0, '2023-05-11 17:15:53', '2023-05-11 17:15:53', NULL, NULL),
(38, 'campaign 2', 'act 2', '1', '', NULL, NULL, 0, '2023-05-11 18:39:21', '2023-05-11 18:39:21', NULL, NULL),
(39, 'campaign 2', 'act 2', '2', '', NULL, NULL, 0, '2023-05-11 18:39:26', '2023-05-11 18:39:26', NULL, NULL),
(40, 'campaign 2', 'act 2', '3', NULL, '', NULL, 0, '2023-05-11 18:39:33', '2023-05-11 18:39:33', NULL, NULL),
(41, 'maintenance 1', 'Dell System', '3', NULL, '', NULL, 0, '2023-05-11 18:39:40', '2023-05-11 18:39:40', NULL, NULL),
(42, 'todo 3', 'test', '3', NULL, '', NULL, 0, '2023-05-11 18:39:47', '2023-05-11 18:39:47', NULL, NULL),
(43, 'campaign 1', 'act 1', '1', '', NULL, NULL, 0, '2023-05-11 18:40:15', '2023-05-11 18:40:15', NULL, NULL),
(44, 'campaign 1', 'act 1', '2', '', NULL, NULL, 0, '2023-05-11 18:40:26', '2023-05-11 18:40:26', NULL, NULL),
(45, 'campaign 1', 'act 1', '3', NULL, '', NULL, 0, '2023-05-11 18:40:31', '2023-05-11 18:40:31', NULL, NULL),
(46, 'campaign 7', 'act 1', '1', '', NULL, NULL, 0, '2023-05-11 18:50:53', '2023-05-11 18:50:53', NULL, NULL),
(47, 'campaign 7', 'act 1', '1', '', NULL, NULL, 0, '2023-05-11 18:51:02', '2023-05-11 18:51:02', NULL, NULL),
(48, 'campaign 7', 'act 1', '2', '', NULL, NULL, 0, '2023-05-11 18:51:16', '2023-05-11 18:51:16', NULL, NULL),
(49, 'campaign 7', 'act 1', '3', NULL, '', NULL, 0, '2023-05-11 18:51:27', '2023-05-11 18:51:27', NULL, NULL);

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
(1, '1959', 0, 0, '2023-05-15 17:45:38', '2023-05-15 17:45:38'),
(2, '1956', 0, 0, '2023-05-15 18:05:58', '2023-05-15 18:05:58'),
(3, '1958', 1, 0, '2023-05-15 18:21:03', '2023-05-15 18:21:03'),
(4, '1955', 1, 0, '2023-05-15 18:22:55', '2023-05-15 18:22:55'),
(5, '1959', 2, 0, '2023-05-15 18:29:49', '2023-05-15 18:29:49'),
(6, '2022', 2, 0, '2023-05-15 18:31:34', '2023-05-15 18:31:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountsgroup`
--
ALTER TABLE `accountsgroup`
  ADD PRIMARY KEY (`Id`);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `approval_line`
--
ALTER TABLE `approval_line`
  MODIFY `approval_line_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `approval_requisition`
--
ALTER TABLE `approval_requisition`
  MODIFY `approval_requisition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `approval_requisition_parallel_agree_disagree`
--
ALTER TABLE `approval_requisition_parallel_agree_disagree`
  MODIFY `approval_requisition_agree_disagree_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `asset_details`
--
ALTER TABLE `asset_details`
  MODIFY `asset_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_details_ref`
--
ALTER TABLE `asset_details_ref`
  MODIFY `ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `asset_register`
--
ALTER TABLE `asset_register`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `audit_assign`
--
ALTER TABLE `audit_assign`
  MODIFY `audit_assign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `audit_assign_ref`
--
ALTER TABLE `audit_assign_ref`
  MODIFY `audit_assign_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `basic_creation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bm_checklist`
--
ALTER TABLE `bm_checklist`
  MODIFY `bm_checklist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branch_creation`
--
ALTER TABLE `branch_creation`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `business_com_line`
--
ALTER TABLE `business_com_line`
  MODIFY `business_com_line_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `business_com_out`
--
ALTER TABLE `business_com_out`
  MODIFY `business_com_out_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `business_com_parallel_agree_disagree`
--
ALTER TABLE `business_com_parallel_agree_disagree`
  MODIFY `business_com_parallel_agree_disagree_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `campaign`
--
ALTER TABLE `campaign`
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `campaign_ref`
--
ALTER TABLE `campaign_ref`
  MODIFY `campaign_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category_creation`
--
ALTER TABLE `category_creation`
  MODIFY `category_creation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `daily_km_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `daily_km_ref`
--
ALTER TABLE `daily_km_ref`
  MODIFY `daily_km_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `department_creation`
--
ALTER TABLE `department_creation`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `designation_creation`
--
ALTER TABLE `designation_creation`
  MODIFY `designation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `diesel_slip`
--
ALTER TABLE `diesel_slip`
  MODIFY `diesel_slip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `goal_setting`
--
ALTER TABLE `goal_setting`
  MODIFY `goal_setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `goal_setting_ref`
--
ALTER TABLE `goal_setting_ref`
  MODIFY `goal_setting_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `holiday_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `insurance_creation`
--
ALTER TABLE `insurance_creation`
  MODIFY `insurance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `insurance_register`
--
ALTER TABLE `insurance_register`
  MODIFY `ins_reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `krakpi_creation`
--
ALTER TABLE `krakpi_creation`
  MODIFY `krakpi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `krakpi_creation_ref`
--
ALTER TABLE `krakpi_creation_ref`
  MODIFY `krakpi_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kra_creation`
--
ALTER TABLE `kra_creation`
  MODIFY `kra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kra_creation_ref`
--
ALTER TABLE `kra_creation_ref`
  MODIFY `kra_creation_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `meeting_minutes`
--
ALTER TABLE `meeting_minutes`
  MODIFY `meeting_minutes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `meeting_minutes_approval_line`
--
ALTER TABLE `meeting_minutes_approval_line`
  MODIFY `meeting_minutes_approval_line_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `meeting_minutes_parallel_agree_disagree`
--
ALTER TABLE `meeting_minutes_parallel_agree_disagree`
  MODIFY `meeting_minutes_agree_disagree_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `memo`
--
ALTER TABLE `memo`
  MODIFY `memo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `pm_checklist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project_creation`
--
ALTER TABLE `project_creation`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `promotional_activities`
--
ALTER TABLE `promotional_activities`
  MODIFY `promotional_activities_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `promotional_activities_ref`
--
ALTER TABLE `promotional_activities_ref`
  MODIFY `promotional_activities_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `report_creation`
--
ALTER TABLE `report_creation`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rgp_creation`
--
ALTER TABLE `rgp_creation`
  MODIFY `rgp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rr_creation`
--
ALTER TABLE `rr_creation`
  MODIFY `rr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rr_creation_ref`
--
ALTER TABLE `rr_creation_ref`
  MODIFY `rr_ref_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `service_indent`
--
ALTER TABLE `service_indent`
  MODIFY `service_indent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `spare_creation`
--
ALTER TABLE `spare_creation`
  MODIFY `spare_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_creation`
--
ALTER TABLE `staff_creation`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tag_creation`
--
ALTER TABLE `tag_creation`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transfer_location`
--
ALTER TABLE `transfer_location`
  MODIFY `transfer_location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  MODIFY `vehicle_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `work_status`
--
ALTER TABLE `work_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `year_creation`
--
ALTER TABLE `year_creation`
  MODIFY `year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
