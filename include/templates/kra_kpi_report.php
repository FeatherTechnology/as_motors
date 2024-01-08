<?php 
include "ajaxconfig.php";

if(isset($_SESSION['staffid'])){
    $userstaffid = $_SESSION['staffid'];
    $staffQry = $con->query("select department from staff_creation where staff_id = '$userstaffid' ");
    $staffDetails = $staffQry->fetch_assoc();
    $userdeptid = $staffDetails['department'];
}
?>
<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - KRA&KPI Report </li>
    </ol>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!--form start-->
    <form id="krakpi_report" name="krakpi_report" action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="user_role" id="user_role" value="<?php if(isset($_SESSION['role'])) echo $_SESSION['role'];?>" >
        <input type="hidden" name="user_dept_id" id="user_dept_id" value="<?php if(isset($userdeptid)) echo $userdeptid;?>" >
        <input type="hidden" name="user_designation_id" id="user_designation_id" value="<?php if(isset($_SESSION['designation_id'])) echo $_SESSION['designation_id'];?>" >
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <!--Type Start  -->
                            <div class="col-md-12 ">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="krakpi_report_type">Report Type</label>
                                                <select tabindex="1" type="text" class="form-control emptyTable" id="krakpi_report_type" name="krakpi_report_type">
                                                    <option value=''>Select Report Type</option>
                                                    <option value='1'>Department</option>
                                                    <option value='2'>Designation</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Type End-->

                            <!--Department Start-->
                            <div class="col-md-12" id="department_report" style="display: none;">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_name">Department Name</label>
                                                <select tabindex="6" type="text" class="form-control clearvalue" id="department_name" name="department_name">
                                                    <option value=''>Select Department</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Department End-->

                            <!-- Designation Start -->
                            <div class="col-md-12" id="designation_report" style="display: none;">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_name">Department Name</label>
                                                <select tabindex="6" type="text" class="form-control clearvalue" id="dept_name" name="dept_name">
                                                    <option value=''>Select Department</option>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="designation_name">Designation Name</label>
                                                <select tabindex="6" type="text" class="form-control clearvalue" id="designation_name" name="designation_name">
                                                    <option value=''>Select Designation</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Designation End -->

                            <!--Report View Button Start -->
                            <div class="col-12">
                                <div class="form-group text-right">
                                    <span class="required validate" style="display: none;">*Please Fill All the Field</span>
                                    <button type="button" tabindex="10" class="btn btn-primary" id="view_report" name="view_report" >View Report</button>
                                </div>
                            </div>
                            <!--Report View Button End -->

                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card-body table-responsive" id="krakpi_report_view_table">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>