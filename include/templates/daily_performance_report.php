<?php 
include "ajaxconfig.php";

if(isset($_SESSION['staffid'])){
    $userstaffid = $_SESSION['staffid'];
    $staffQry = $con->query("select department from staff_creation where staff_id = '$userstaffid' ");
    $staffDetails = $staffQry->fetch_assoc();
    $userdeptid = $staffDetails['department'];
}
?>

<style>
.orLabel{
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Daily Performance Report </li>
    </ol>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!--------form start-->
    <form id="assign_work" name="assign_work" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="user_role" id="user_role" value="<?php if(isset($_SESSION['role'])) echo $_SESSION['role'];?>" >
        <input type="hidden" name="user_staff_id" id="user_staff_id" value="<?php if(isset($_SESSION['staffid'])) echo $_SESSION['staffid'];?>" >
        <input type="hidden" name="user_dept_id" id="user_dept_id" value="<?php if(isset($userdeptid)) echo $userdeptid;?>" >
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
                                            <label for="report_type">Report Type</label>
                                                <select tabindex="1" type="text" class="form-control emptyTable" id="report_type" name="report_type">
                                                    <option value=''>Select Report Type</option>
                                                    <option value='1'>Staff</option>
                                                    <option value='2'>Department</option>
                                                    <option value='3'>Overall</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Type End-->

                            <!--Staff Start-->
                            <div class="col-md-12" id="staff_report" style="display: none;">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="staff_name">Staff Name</label>
                                                <select tabindex="2" type="text" class="form-control clearvalue" id="staff_name" name="staff_name">
                                                    <option value=''>Select Staff Name</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="staff_monthwise">MonthWise</label>
                                                <input tabindex="3" type="month" class="form-control clearvalue clearMonth" id="staff_monthwise" name="staff_monthwise">
                                        </div>
                                    </div>

                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 orLabel" >
                                    <label for="or">OR</label>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="staff_from_date">From Date</label>
                                                <input tabindex="4" type="date" class="form-control validateToDate clearvalue clearFrom" id="staff_from_date" name="staff_from_date">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="staff_to_date">To Date</label>
                                                <input tabindex="5" type="date" class="form-control setvaltodate clearvalue clearTo" id="staff_to_date" name="staff_to_date">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--Staff End-->

                            <!--Department Start-->
                            <div class="col-md-12" id="dept_report" style="display: none;">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_type">Type</label>
                                                <select tabindex="5" type="text" class="form-control clearvalue" id="dept_type" name="dept_type">
                                                    <option value=''>Select Type</option>
                                                    <option value='1'>Department</option>
                                                    <option value='2'>Staff</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>

                                <!--Department Start-->
                                <div class="row" id="dept_name_report" style="display: none;">
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
                                            <label for="dept_monthwise">MonthWise</label>
                                                <input tabindex="7" type="month" class="form-control clearvalue clearMonth" id="dept_monthwise" name="dept_monthwise">
                                        </div>
                                    </div>

                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 orLabel" >
                                        <label for="or">OR</label>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_from_date">From Date</label>
                                            <input tabindex="8" type="date" class="form-control validateToDate clearvalue clearFrom" id="dept_from_date" name="dept_from_date">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_to_date">To Date</label>
                                            <input tabindex="9" type="date" class="form-control setvaltodate clearvalue clearTo" id="dept_to_date" name="dept_to_date">
                                        </div>
                                    </div>
                                </div>
                                <!--Department End-->

                                <!--Department staff Start-->
                                <div class="row" id="dept_staff_report" style="display: none;">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dep_name">Department Name</label>
                                                <select tabindex="9" type="text" class="form-control clearvalue" id="dep_name" name="dep_name">
                                                    <option value=''>Select Department</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_staff_name">Staff Name</label>
                                                <select tabindex="10" type="text" class="form-control clearvalue" id="dept_staff_name" name="dept_staff_name">
                                                    <option value=''>Select Staff Name</option>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12"></div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dept_staff_monthwise">MonthWise</label>
                                                <input tabindex="7" type="month" class="form-control clearvalue clearMonth" id="dept_staff_monthwise" name="dept_staff_monthwise">
                                        </div>
                                    </div>

                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 orLabel" >
                                        <label for="or">OR</label>
                                    </div>
                                    
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="dept_staff_from_date">From Date</label>
                                            <input tabindex="11" type="date" class="form-control validateToDate clearvalue clearFrom" id="dept_staff_from_date" name="dept_staff_from_date">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="dept_staff_to_date">To Date</label>
                                            <input tabindex="12" type="date" class="form-control setvaltodate clearvalue clearTo" id="dept_staff_to_date" name="dept_staff_to_date">
                                        </div>
                                    </div>
                                </div>
                                <!--Department staff End-->

                            </div>
                            <!--Department End-->

                            <!--Overall Start-->
                            <div class="col-md-12" id="overall_report" style="display: none;">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="monthwise">Month</label>
                                            <input tabindex="2" type="month" class="form-control clearvalue clearMonth" id="monthwise" name="monthwise">
                                        </div>
                                    </div>

                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-12 orLabel" >
                                        <label for="or">OR</label>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="overall_from_date">From Date</label>
                                            <input tabindex="9" type="date" class="form-control validateToDate clearvalue clearFrom" id="overall_from_date" name="overall_from_date">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                                        <div class="form-group">
                                            <label for="overall_to_date">To Date</label>
                                            <input tabindex="10" type="date" class="form-control setvaltodate clearvalue clearTo" id="overall_to_date" name="overall_to_date">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--Overall End-->

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
                        <div class="card-body table-responsive" id="report_view_table">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>