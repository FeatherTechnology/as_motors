-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2023 at 08:46 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asmotors_empty`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_details`
--

CREATE TABLE `asset_details` (
  `asset_details_id` int(11) NOT NULL,
  `asset_register_id` int(11) DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `classification` varchar(255) DEFAULT NULL,
  `asset_name` varchar(255) DEFAULT NULL,
  `asset_value` varchar(255) DEFAULT NULL,
  `dou` date DEFAULT NULL,
  `depreciation` varchar(255) DEFAULT NULL,
  `as_on` varchar(255) DEFAULT NULL,
  `asset_location` varchar(100) DEFAULT NULL,
  `asset_count` varchar(50) DEFAULT NULL,
  `spare_names` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_id` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_details_ref`
--

CREATE TABLE `asset_details_ref` (
  `ref_id` int(11) NOT NULL,
  `asset_details_reff_id` int(11) DEFAULT NULL,
  `modal_no` varchar(100) DEFAULT NULL,
  `warranty_upto` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_name_creation`
--

CREATE TABLE `asset_name_creation` (
  `asset_name_id` int(11) NOT NULL,
  `asset_name` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_register`
--

CREATE TABLE `asset_register` (
  `asset_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `asset_classification` varchar(250) DEFAULT NULL,
  `asset_autoGen_id` varchar(50) DEFAULT NULL,
  `asset_name` varchar(255) DEFAULT NULL,
  `vendor_id` varchar(50) DEFAULT NULL,
  `dop` date DEFAULT NULL,
  `asset_nature` int(11) DEFAULT NULL,
  `depreciation_rate` varchar(50) DEFAULT NULL,
  `asset_value` int(11) DEFAULT NULL,
  `maintenance` varchar(255) DEFAULT NULL,
  `rgp_status` varchar(255) NOT NULL DEFAULT 'inword',
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `responsibility` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `frequency` varchar(255) DEFAULT NULL,
  `frequency_applicable` varchar(50) DEFAULT NULL,
  `maintenance_checklist` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bm_checklist_multiple`
--

CREATE TABLE `bm_checklist_multiple` (
  `id` int(11) NOT NULL,
  `bm_checklist_id` int(11) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `checklist` text DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `maintenance_checklist` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bm_checklist_ref`
--

CREATE TABLE `bm_checklist_ref` (
  `bm_checklist_ref_id` int(11) NOT NULL,
  `bm_checklist_id` varchar(50) DEFAULT NULL,
  `maintenance_checklist_id` varchar(50) DEFAULT NULL,
  `maintenance_checklist_ref_id` varchar(200) DEFAULT NULL,
  `checklist` text DEFAULT NULL,
  `from_date` varchar(50) DEFAULT NULL,
  `to_date` varchar(50) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0,
  `role1` varchar(200) DEFAULT NULL,
  `role2` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `in_active_remark` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaign`
--

CREATE TABLE `campaign` (
  `campaign_id` int(11) NOT NULL,
  `promotional_activities_id` varchar(50) DEFAULT NULL,
  `actual_start_date` varchar(255) DEFAULT NULL,
  `branch_id` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `department_id` varchar(50) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `work_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `in_active_remark` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `costcentre`
--

CREATE TABLE `costcentre` (
  `costcentreid` int(11) NOT NULL,
  `costcentrename` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `daily_km_id` varchar(255) DEFAULT NULL,
  `employee_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_performance`
--

CREATE TABLE `daily_performance` (
  `daily_performance_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` varchar(50) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `month` date DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_performance_ref`
--

CREATE TABLE `daily_performance_ref` (
  `daily_performance_ref_id` int(11) NOT NULL,
  `daily_performance_id` int(11) DEFAULT NULL,
  `assertion` varchar(200) DEFAULT NULL,
  `target` varchar(100) DEFAULT NULL,
  `actual_achieve` varchar(50) DEFAULT NULL,
  `system_date` date DEFAULT NULL,
  `staff_id` varchar(200) DEFAULT NULL,
  `goal_setting_id` int(11) DEFAULT NULL,
  `goal_setting_ref_id` int(11) DEFAULT NULL,
  `assertion_table_sno` varchar(50) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `manager_comment` varchar(250) DEFAULT NULL,
  `manager_updated_status` int(11) DEFAULT 0,
  `manager_id` varchar(50) DEFAULT NULL,
  `manager_updated_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `staff_id` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fc_insurance_renew`
--

CREATE TABLE `fc_insurance_renew` (
  `fc_insurance_renew_id` int(11) NOT NULL,
  `branch_id` varchar(50) DEFAULT NULL,
  `vehicle_details_id` varchar(50) DEFAULT NULL,
  `assign_staff_name` varchar(50) DEFAULT NULL,
  `assign_remark` varchar(250) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `work_status` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` varchar(50) DEFAULT NULL,
  `insert_login_id` varchar(50) DEFAULT NULL,
  `update_login_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goal_setting`
--

CREATE TABLE `goal_setting` (
  `goal_setting_id` int(11) NOT NULL,
  `company_name` varchar(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `role` varchar(250) DEFAULT NULL,
  `dept_strength` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goal_setting_ref`
--

CREATE TABLE `goal_setting_ref` (
  `goal_setting_ref_id` int(11) NOT NULL,
  `goal_setting_id` int(11) DEFAULT NULL,
  `assertion_table_sno` varchar(50) DEFAULT NULL,
  `assertion` varchar(255) DEFAULT NULL,
  `target` varchar(255) DEFAULT NULL,
  `per_day_target` varchar(150) DEFAULT NULL,
  `goal_month` varchar(50) DEFAULT NULL,
  `monthly_conversion_required` int(11) DEFAULT NULL,
  `staffname` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_register`
--

CREATE TABLE `insurance_register` (
  `ins_reg_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `insurance_id` int(11) DEFAULT NULL,
  `policy_company` varchar(250) DEFAULT NULL,
  `policy_number` varchar(250) DEFAULT NULL,
  `policy_upload` varchar(250) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insurance_register_ref`
--

CREATE TABLE `insurance_register_ref` (
  `ins_reg_ref_id` int(11) NOT NULL,
  `ins_reg_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `insurance_id` int(11) DEFAULT NULL,
  `policy_company` varchar(250) DEFAULT NULL,
  `policy_number` varchar(250) DEFAULT NULL,
  `policy_upload` varchar(250) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kra_creation_ref`
--

CREATE TABLE `kra_creation_ref` (
  `kra_creation_ref_id` int(11) NOT NULL,
  `kra_category` varchar(255) DEFAULT NULL,
  `weightage` varchar(255) DEFAULT NULL,
  `kra_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_or_on_duty`
--

CREATE TABLE `permission_or_on_duty` (
  `permission_on_duty_id` int(11) NOT NULL,
  `regularisation_id` varchar(250) DEFAULT NULL,
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
  `leave_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=request 1=accepted 2=rejected',
  `reject_reason` varchar(255) DEFAULT NULL,
  `responsible_staff` int(11) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pm_checklist_multiple`
--

CREATE TABLE `pm_checklist_multiple` (
  `id` int(11) NOT NULL,
  `pm_checklist_id` int(11) NOT NULL,
  `checklist` text DEFAULT NULL,
  `type_of_checklist` varchar(255) DEFAULT NULL,
  `yes_no_na` varchar(255) DEFAULT NULL,
  `no_of_option` varchar(255) DEFAULT NULL,
  `option1` varchar(255) DEFAULT NULL,
  `option2` varchar(255) DEFAULT NULL,
  `option3` varchar(255) DEFAULT NULL,
  `option4` varchar(255) DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `maintenance_checklist` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `policy_company_creation`
--

CREATE TABLE `policy_company_creation` (
  `policy_company_id` int(11) NOT NULL,
  `policy_company` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotional_activities_ref`
--

CREATE TABLE `promotional_activities_ref` (
  `promotional_activities_ref_id` int(11) NOT NULL,
  `promotional_activities_id` int(11) DEFAULT NULL,
  `activity_involved` varchar(200) DEFAULT NULL,
  `time_frame_start` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `employee_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `responsibility_creation`
--

CREATE TABLE `responsibility_creation` (
  `responsibility_id` int(11) NOT NULL,
  `responsibility_name` varchar(150) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `created_date` date DEFAULT NULL,
  `updated_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `company_to` int(11) DEFAULT NULL,
  `branch_to` varchar(255) DEFAULT NULL,
  `from_comm_line1` varchar(255) DEFAULT NULL,
  `from_comm_line2` varchar(255) DEFAULT NULL,
  `to_comm_line1` varchar(255) DEFAULT NULL,
  `to_comm_line2` varchar(255) DEFAULT NULL,
  `rgp_staff_id` varchar(50) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_creation_history`
--

CREATE TABLE `staff_creation_history` (
  `staff_history_id` int(11) NOT NULL,
  `transfer_location_id` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `monthly_conversion_required` int(11) DEFAULT NULL,
  `new_assertion` varchar(200) DEFAULT NULL,
  `new_target` varchar(100) DEFAULT NULL,
  `applicability` varchar(250) DEFAULT NULL,
  `deleted_date` varchar(100) DEFAULT NULL,
  `deleted_remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `to_company` varchar(100) DEFAULT NULL,
  `transfer_location` varchar(255) DEFAULT NULL,
  `to_department` varchar(100) DEFAULT NULL,
  `to_designation` varchar(100) DEFAULT NULL,
  `transfer_effective_from` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `daily_task_update` int(11) DEFAULT 1,
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
  `regularisation_approval` int(11) DEFAULT NULL,
  `transfer_location` varchar(11) DEFAULT NULL,
  `target_fixing_module` varchar(11) DEFAULT NULL,
  `goal_setting` varchar(11) DEFAULT NULL,
  `target_fixing` varchar(11) DEFAULT NULL,
  `daily_performance` varchar(11) DEFAULT NULL,
  `daily_performance_review` int(11) NOT NULL DEFAULT 1,
  `appreciation_depreciation` varchar(11) DEFAULT NULL,
  `vehicle_management_module` varchar(11) DEFAULT NULL,
  `vehicle_details` varchar(11) DEFAULT NULL,
  `daily_km` varchar(11) DEFAULT NULL,
  `diesel_slip` varchar(11) DEFAULT NULL,
  `approval_mechanism_module` varchar(11) DEFAULT NULL,
  `approval_requisition` varchar(11) DEFAULT NULL,
  `business_communication_outgoing` varchar(11) DEFAULT NULL,
  `minutes_of_meeting` varchar(11) DEFAULT NULL,
  `report_module` int(11) DEFAULT 1,
  `reports` int(11) DEFAULT 1,
  `daily_performance_report` int(11) NOT NULL DEFAULT 1,
  `vehicle_management_report_module` int(11) NOT NULL DEFAULT 1,
  `vehicle_report` int(11) NOT NULL DEFAULT 1,
  `daily_km_report` int(11) NOT NULL DEFAULT 1,
  `diesel_slip_report` int(11) NOT NULL DEFAULT 1,
  `memo_report` int(11) NOT NULL DEFAULT 1,
  `krakpi_report` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_details`
--

CREATE TABLE `vehicle_details` (
  `vehicle_details_id` int(11) NOT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `vehicle_code` varchar(255) DEFAULT NULL,
  `vehicle_type` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_name_creation`
--

CREATE TABLE `vendor_name_creation` (
  `vendor_name_id` int(11) NOT NULL,
  `vendor_name` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `asset_name_creation`
--
ALTER TABLE `asset_name_creation`
  ADD PRIMARY KEY (`asset_name_id`);

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
-- Indexes for table `bm_checklist_multiple`
--
ALTER TABLE `bm_checklist_multiple`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bm_checklist_ref`
--
ALTER TABLE `bm_checklist_ref`
  ADD PRIMARY KEY (`bm_checklist_ref_id`);

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
-- Indexes for table `fc_insurance_renew`
--
ALTER TABLE `fc_insurance_renew`
  ADD PRIMARY KEY (`fc_insurance_renew_id`);

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
-- Indexes for table `pm_checklist_multiple`
--
ALTER TABLE `pm_checklist_multiple`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pm_checklist_ref`
--
ALTER TABLE `pm_checklist_ref`
  ADD PRIMARY KEY (`pm_checklist_ref_id`);

--
-- Indexes for table `policy_company_creation`
--
ALTER TABLE `policy_company_creation`
  ADD PRIMARY KEY (`policy_company_id`);

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
-- Indexes for table `responsibility_creation`
--
ALTER TABLE `responsibility_creation`
  ADD PRIMARY KEY (`responsibility_id`);

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
-- Indexes for table `staff_creation_history`
--
ALTER TABLE `staff_creation_history`
  ADD PRIMARY KEY (`staff_history_id`);

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
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  ADD PRIMARY KEY (`vehicle_details_id`);

--
-- Indexes for table `vendor_name_creation`
--
ALTER TABLE `vendor_name_creation`
  ADD PRIMARY KEY (`vendor_name_id`);

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
  MODIFY `asset_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_details_ref`
--
ALTER TABLE `asset_details_ref`
  MODIFY `ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_name_creation`
--
ALTER TABLE `asset_name_creation`
  MODIFY `asset_name_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_register`
--
ALTER TABLE `asset_register`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_work`
--
ALTER TABLE `assign_work`
  MODIFY `work_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_work_ref`
--
ALTER TABLE `assign_work_ref`
  MODIFY `ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_area_creation`
--
ALTER TABLE `audit_area_creation`
  MODIFY `audit_area_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_area_creation_ref`
--
ALTER TABLE `audit_area_creation_ref`
  MODIFY `audit_area_creation_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_assign`
--
ALTER TABLE `audit_assign`
  MODIFY `audit_assign_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_assign_ref`
--
ALTER TABLE `audit_assign_ref`
  MODIFY `audit_assign_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_checklist`
--
ALTER TABLE `audit_checklist`
  MODIFY `audit_checklist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_checklist_ref`
--
ALTER TABLE `audit_checklist_ref`
  MODIFY `audit_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `basic_creation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bm_checklist`
--
ALTER TABLE `bm_checklist`
  MODIFY `bm_checklist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bm_checklist_multiple`
--
ALTER TABLE `bm_checklist_multiple`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bm_checklist_ref`
--
ALTER TABLE `bm_checklist_ref`
  MODIFY `bm_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch_creation`
--
ALTER TABLE `branch_creation`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign_ref`
--
ALTER TABLE `campaign_ref`
  MODIFY `campaign_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_creation`
--
ALTER TABLE `category_creation`
  MODIFY `category_creation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_creation`
--
ALTER TABLE `company_creation`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designation_creation`
--
ALTER TABLE `designation_creation`
  MODIFY `designation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diesel_slip`
--
ALTER TABLE `diesel_slip`
  MODIFY `diesel_slip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc_insurance_renew`
--
ALTER TABLE `fc_insurance_renew`
  MODIFY `fc_insurance_renew_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday_creation_ref`
--
ALTER TABLE `holiday_creation_ref`
  MODIFY `holiday_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_creation`
--
ALTER TABLE `insurance_creation`
  MODIFY `insurance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_register`
--
ALTER TABLE `insurance_register`
  MODIFY `ins_reg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insurance_register_ref`
--
ALTER TABLE `insurance_register_ref`
  MODIFY `ins_reg_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `krakpi_calendar_map`
--
ALTER TABLE `krakpi_calendar_map`
  MODIFY `krakpi_calendar_map_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `krakpi_creation`
--
ALTER TABLE `krakpi_creation`
  MODIFY `krakpi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `krakpi_creation_ref`
--
ALTER TABLE `krakpi_creation_ref`
  MODIFY `krakpi_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kra_creation`
--
ALTER TABLE `kra_creation`
  MODIFY `kra_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kra_creation_ref`
--
ALTER TABLE `kra_creation_ref`
  MODIFY `kra_creation_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
  MODIFY `ledgerid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_checklist`
--
ALTER TABLE `maintenance_checklist`
  MODIFY `maintenance_checklist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_checklist_ref`
--
ALTER TABLE `maintenance_checklist_ref`
  MODIFY `maintenance_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_creation`
--
ALTER TABLE `media_creation`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `memo_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `permission_on_duty_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pm_checklist`
--
ALTER TABLE `pm_checklist`
  MODIFY `pm_checklist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pm_checklist_multiple`
--
ALTER TABLE `pm_checklist_multiple`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pm_checklist_ref`
--
ALTER TABLE `pm_checklist_ref`
  MODIFY `pm_checklist_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `policy_company_creation`
--
ALTER TABLE `policy_company_creation`
  MODIFY `policy_company_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_creation`
--
ALTER TABLE `project_creation`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotional_activities`
--
ALTER TABLE `promotional_activities`
  MODIFY `promotional_activities_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotional_activities_ref`
--
ALTER TABLE `promotional_activities_ref`
  MODIFY `promotional_activities_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_creation`
--
ALTER TABLE `report_creation`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `responsibility_creation`
--
ALTER TABLE `responsibility_creation`
  MODIFY `responsibility_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rgp_creation`
--
ALTER TABLE `rgp_creation`
  MODIFY `rgp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rr_creation`
--
ALTER TABLE `rr_creation`
  MODIFY `rr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rr_creation_ref`
--
ALTER TABLE `rr_creation_ref`
  MODIFY `rr_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_indent`
--
ALTER TABLE `service_indent`
  MODIFY `service_indent_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spare_creation`
--
ALTER TABLE `spare_creation`
  MODIFY `spare_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_creation`
--
ALTER TABLE `staff_creation`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_creation_history`
--
ALTER TABLE `staff_creation_history`
  MODIFY `staff_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag_creation`
--
ALTER TABLE `tag_creation`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer_location`
--
ALTER TABLE `transfer_location`
  MODIFY `transfer_location_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  MODIFY `vehicle_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_name_creation`
--
ALTER TABLE `vendor_name_creation`
  MODIFY `vendor_name_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_status`
--
ALTER TABLE `work_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `year_creation`
--
ALTER TABLE `year_creation`
  MODIFY `year_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
