<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];

    $CompanyroleDetail = $userObj->getsroleDetail($mysqli, $userid);
        $logrole             = $CompanyroleDetail['role'];
        $user_company_id     = $CompanyroleDetail['company_id'];
        $user_branch_id     = $CompanyroleDetail['branch_id'];
        $user_dept_id        = $CompanyroleDetail['department'];
        $user_staff_id       = $CompanyroleDetail['staff_id'];
} 
?>

<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Daily Performance Review</li>
    </ol>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "daily_performace_form" name="daily_performace_form" action="" method="post" enctype="multipart/form-data"> 

<!-- Login User Data Start -->
<input type="hidden" class="form-control" value="<?php if (isset($user_company_id)) echo $user_company_id; ?>" id="user_company" name="user_company">
<input type="hidden" class="form-control" value="<?php if (isset($user_branch_id)) echo $user_branch_id; ?>" id="user_branch" name="user_branch">
<input type="hidden" class="form-control" value="<?php if (isset($user_dept_id)) echo $user_dept_id; ?>" id="user_department" name="user_department">
<input type="hidden" class="form-control" value="<?php if (isset($logrole)) echo $logrole; ?>" id="user_role" name="user_role">
<input type="hidden" class="form-control" value="<?php if (isset($user_staff_id)) echo $user_staff_id; ?>" id="user_staff_id" name="user_staff_id">
<!-- Login User Data END -->
        
    <!-- Row gutters start -->
        <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <!-- card start -->
                <div class="card">
					<div class="card-header">
						<!-- <div class="card-title">General Info</div> -->
					</div>
                    <!-- card body start -->
                    <div class="card-body">

                            <div class="row ">
                            <!--Fields -->
                            <div class="col-md-12 "> 
                                <div class="row input-container">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="company_name">Company Name</label>
                                                <select type="text" tabindex="1" name="company_name" id="company_name" class="form-control">
                                                    <option value=''>Select Company Name</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="branch_name">Branch Name</label>
                                                <select type="text" tabindex="2" name="branch_name" id="branch_name" class="form-control">
                                                    <option value=''>Select Branch Name</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="dept">Department</label>
                                                <select type="text" tabindex="3" name="dept" id="dept" class="form-control">
                                                    <option value=''>Select Department Name</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="review_date">Review Date</label>
                                                <input type="date" tabindex="4" name="review_date" id="review_date" class="form-control">
                                            </div>
                                        </div>
                                </div> 
                            </br></br>
                                        
                            <div class="col-md-12" id="tableContent">
                                <table id="moduleTable" class="table custom-table" >
                                    <thead>
                                        <tr>
                                            <th>Staff Name</th>
                                            <th>Assertion</th>
                                            <th>Target</th>
                                            <th>Actual Achieve</th>
                                            <th>Balance To Do</th>
                                            <th>Average per day</th>
                                            <th>System Date</th>
                                            <th>Work Status</th>                                            
                                            <th>Manager Comment</th>                                            
                                            <th colspan='2'>Action</th>                                            
                                        </tr>
                                    </thead>
                                        <tbody id="reviewTable"></tbody>
                                    </table>
                                </div>
                            <!-- tableContent END -->
                                </div>
                                <!-- col-md-12 END -->
                            </div>
                            <!-- row END -->
                        </div>
                        <!-- card body END -->
                    </div>
                    <!-- card END -->

                        <div class="col-md-12">
                            <br><br>
                            <div class="text-right">
                                <!-- <button type="submit" name="submit_daily_performance" id="submit_daily_performance" class="btn btn-primary print-hide" value="Submit" tabindex="15">Submit</button> -->
                            </div>
                        </div>
            </div>
        </div>
        <!-- Row gutters END -->
    </form>
    <!-- Form END -->
</div>
<!-- Main-Container END -->



