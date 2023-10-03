<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];

    $CompanyroleDetail = $userObj->getsroleDetail($mysqli, $userid);
    for ($j = 0; $j < count($CompanyroleDetail); $j++) {
        $logrole             = $CompanyroleDetail['role'];
        $user_company_id     = $CompanyroleDetail['company_id'];
        $user_desgn_id       = $CompanyroleDetail['designation_id'];
        $user_dept_id        = $CompanyroleDetail['department'];
        $user_staff_id       = $CompanyroleDetail['staff_id'];
    }
} 

if(isset($_SESSION["branch_id"])){
    $sbranch_id = $_SESSION["branch_id"];
}


// $idupd=0;
// if(isset($_GET['upd']))
// {
// $idupd = $_GET['upd'];
// }

// if($idupd>0)
// {
// 	$daily_performance_details = $userObj->getdailyperformance($mysqli,$idupd); 
// 	if (sizeof($daily_performance_details)>0) {
//         for($i=0;$i<sizeof($daily_performance_details);$i++)  { //both daily_performance & daily_perfomance_ref table calling in one function and return as one array, here we spliting. 
//             $header_table              = $daily_performance_details['daily_performance_list'];
//             $ref_table                 = $daily_performance_details['daily_performance_ref_list'];
// 		}
// 	}

//     for($i=0;$i<sizeof($header_table);$i++)  {
    
//         $daily_performance_id        = $header_table[$i]['daily_performance_id'];  
//         $company_id                  = $header_table[$i]['company_id']; 
//         $company_name_upd            = $header_table[$i]['company_name']; 
//         $branch_id                   = $header_table[$i]['branch_id']; 
//         $branch_name                 = $header_table[$i]['branch_name']; 
//         $department_id               = $header_table[$i]['department_id']; 
//         $department_name             = $header_table[$i]['department_name']; 
//         $role_id                     = $header_table[$i]['role_id']; 
//         $designation_name            = $header_table[$i]['designation_name']; 
//         $emp_id                      = $header_table[$i]['emp_id']; 
//         $staff_name                  = $header_table[$i]['staff_name']; 
//         $month                       = $header_table[$i]['month']; 
//     }
// }
?>

<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Daily Performance Review</li>
    </ol>

    <!-- <a href="edit_daily_performance_review">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
   </a> -->
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "daily_performace_form" name="daily_performace_form" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($idupd)) echo $idupd; ?>"  id="idupd" name="idupd">
<input type="hidden" class="form-control" value="<?php if(isset($company_id)) echo $company_id; ?>"  id="company_id_upd" name="company_id_upd">
<input type="hidden" class="form-control" value="<?php if(isset($branch_id)) echo $branch_id; ?>"  id="branch_id_upd" name="branch_id_upd">
<input type="hidden" class="form-control" value="<?php if(isset($department_id)) echo $department_id; ?>"  id="dept_id_upd" name="dept_id_upd">

<!-- Login User Data Start -->
<input type="hidden" class="form-control" value="<?php if (isset($user_company_id)) echo $user_company_id; ?>" id="user_company" name="user_company">
<input type="hidden" class="form-control" value="<?php if (isset($sbranch_id)) echo $sbranch_id; ?>" id="user_branch" name="user_branch">
<input type="hidden" class="form-control" value="<?php if (isset($user_desgn_id)) echo $user_desgn_id; ?>" id="user_designation" name="user_designation">
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
                                                <label for="inputReadOnly">Company Name</label>
                                                <select type="text" tabindex="1" name="company_name" id="company_name" class="form-control" disabled>
                                                    <option value=''>Select Company Name</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly">Branch Name</label>
                                                <select type="text" tabindex="2" name="branch_name" id="branch_name" class="form-control" disabled>
                                                    <option value=''>Select Branch Name</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="inputReadOnly">Department</label>
                                                <select type="text" tabindex="3" name="dept" id="dept" class="form-control" disabled>
                                                    <option value=''>Select Department Name</option>
                                                </select>
                                            </div>
                                        </div>
                                </div> 
                            </br></br>
                                        

                        <!-- <div class="row" > -->
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
                                            <th>Action</th>                                            
                                        </tr>
                                    </thead>
                                        <tbody id="reviewTable">
                                            <!-- <tr>

                                                <td>
                                                    <label>Staff</label>
                                                </td>
                                                <td>
                                                    <textarea tabindex="9" type="text" class="form-control" id="assertion" name="assertion[]"  readonly>
                                                    </textarea> 
                                                </td>
                                                <td>
                                                    <input tabindex="10" type="text" class="form-control target" id="target" name="target[]" readonly>
                                                    </input> 
                                                </td>
                                                <td>
                                                    <input tabindex="11" type="number" class="form-control actual_achieve" id="actual_achieve" name="actual_achieve[]" readonly>
                                                    </input> 
                                                </td>
                                                <td>
                                                    <input tabindex="11" type="number" class="form-control actual_achieve" id="actual_achieve" name="actual_achieve[]" readonly>
                                                    </input> 
                                                </td>
                                                <td>
                                                    <input tabindex="12" type="date" class="form-control" id="sdate" name="sdate[]" value=""  readonly></input> 
                                                </td>
                                                <td>
                                                    <select  class="form-control wstatus" id="wstatus" name="wstatus[]" tabindex="13">
                                                        <option value=" ">Select Work Status</option>
                                                        <option value="1">Statisfied</option>
                                                        <option value="2">Not Done</option>
                                                        <option value="3">Carry Forward</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <textarea tabindex="9" type="text" class="form-control" id="manager_comment" name="manager_comment[]">
                                                    </textarea> 
                                                </td>
                                                <td>
                                                <button type="submit" name="submit_daily_performance" id="submit_daily_performance" class="btn btn-primary print-hide" value="Submit" tabindex="15">Submit</button> 
                                                </td>                                               
                                            </tr> -->
                                        </tbody>
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



