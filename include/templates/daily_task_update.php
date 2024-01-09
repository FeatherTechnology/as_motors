<?php
@session_start();
if (isset($_SESSION["staffid"])) {
    $staffid = $_SESSION["staffid"];
}
if (isset($_SESSION["curdateFromIndexPage"])) {
    $curdate = $_SESSION["curdateFromIndexPage"];
}
if (isset($_SESSION["branch_id"])) {
    $sbranch_id = $_SESSION["branch_id"];
    $sCompanyBranchDetail = $userObj->getsCompanyBranchDetail($mysqli, $sbranch_id);
}
$companyName = $userObj->getCompanyName($mysqli);

if(isset($_POST['submit_daily_task_update']) && $_POST['submit_daily_task_update'] !=''){
    $insertDailyTask = $userObj->addDailyTask($mysqli, $curdate);
}
?>

<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Daily Task Update </li>
    </ol>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!--------form start-->
    <form id="daily_task_update" name="daily_task_update" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" value="<?php if (isset($staffid)) echo $staffid; ?>" id="staffid" name="staffid">

        <!-- Row start -->
        <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <div class="card-title">General Info</div> -->
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <!--Fields -->
                            <div class="col-md-12 ">
                                <div class="row">

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="company_id">Company Name</label>
                                            <?php if ($sbranch_id == 'Overall') { ?>
                                                <select tabindex="1" type="text" class="form-control" id="company_id" name="company_id">
                                                    <option value="">Select Company Name</option>
                                                    <?php if (sizeof($companyName) > 0) {
                                                        for ($j = 0; $j < count($companyName); $j++) { ?>
                                                            <option <?php if (isset($sCompanyBranchDetailEdit['company_id'])) {
                                                                        if ($companyName[$j]['company_id'] == $sCompanyBranchDetailEdit['company_id']) echo 'selected';
                                                                    } ?> value="<?php echo $companyName[$j]['company_id']; ?>">
                                                                <?php echo $companyName[$j]['company_name']; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            <?php } else if ($sbranch_id != 'Overall') { ?>
                                                <select disabled tabindex="1" type="text" class="form-control" id="company_id" name="company_id">
                                                    <option value="<?php echo $sCompanyBranchDetail['company_id']; ?>"><?php echo $sCompanyBranchDetail['company_name']; ?></option>
                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="branch_id">Branch Name</label>
                                            <?php if ($sbranch_id == 'Overall') { ?>
                                                <select tabindex="2" type="text" class="form-control" id="branch_id" name="branch_id">
                                                    <option value="" disabled selected>Select Branch Name</option>
                                                </select>
                                            <?php } else if ($sbranch_id != 'Overall') { ?>
                                                <input type="hidden" name="branch_id" id="branch_id" class="form-control" value="<?php echo $sbranch_id; ?>">
                                                <select disabled tabindex="2" type="text" class="form-control" id="branch_id1" name="branch_id1">
                                                    <option value="<?php echo $sbranch_id; ?>"><?php echo $sCompanyBranchDetail['branch_name']; ?></option>
                                                </select>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="employee">Employee</label>
                                            <select tabindex="3" type="text" class="form-control" name="employee" id="employee">
                                                <option value="">Select employee</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="current_date">Date</label>
                                            <input type="date" tabindex="9" name="current_date" id="current_date" class="form-control" value="<?php if(isset($curdate)) echo $curdate; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group text-right">
                                            <label class="label" style="visibility: hidden;">View</label>
                                            <button type="button" tabindex="10" class="btn btn-primary" id="dailytask_update" name="dailytask_update" style="padding: 7px 35px;">View</button>
                                        </div>
                                    </div>


                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <!-- alert messages -->
                                        <?php
                                        if (isset($_GET['dailyTaskAlertid'])) {
                                            if ($_GET['dailyTaskAlertid'] == '1') { ?>
                                                <div class="alert alert-success" role="alert">
                                                    <div class="alert-text">Status Updated Succesfully!</div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="alert alert-success" role="alert">
                                                    <div class="alert-text">Status Update Failed!</div>
                                                </div>
                                        <?php }
                                        } ?>

                                        <div class="card-body row">
                                            <table class="table custom-table" id="taskTable">
                                                <thead>
                                                    <tr>
                                                        <th>Task</th>
                                                        <th>Status</th>
                                                        <th>Remark</th>
                                                        <th>File Upload</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="dailyTaskTable"> </tbody>
                                            </table>
                                        </div>
                                        <br><br>
                                        <div class="text-right">
                                            <button type="submit" name="submit_daily_task_update" id="submit_daily_task_update" class="btn btn-primary" value="Submit" tabindex="11">Submit</button>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>