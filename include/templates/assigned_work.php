<?php
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
if(isset($_SESSION["staffid"])){
    $staff_id = $_SESSION["staffid"];
}else{
    $staff_id = 0;
}

$outdateList = $userObj->getOverDueTask($mysqli);
$outdateList1 = $userObj->getOverDueTask1($mysqli);
?>

<style>

/* hide the calendar time */
.fc-event-time {
  display: none;
}

body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
 }

#calendar {
    max-width: 1200px;
    margin: 0 auto;
}
.fc-day-grid-event {
    height: 10em !important; /* or any other desired height */
    width: 100% !important; /* or any other desired width */
}

.overduebox {
  width: 100%;
  height: auto;
  border: 1px solid #333;
  border-radius: 5px;
}

.overduehead {
  background-color: #1b6aaa;
  color: white;
  font-weight: bold;
  font-size: large;
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  padding: 10px;
  text-align: center;
}

.overduebody {
  padding: 10px;
  color: black;
}

.fc-h-event {
    border: none;
}
</style>


<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Assigned Work </li>
    </ol>

    <!-- <a href="edit_staff_creation">
        <button type="button" class="btn btn-primary"><span class="icon-arrow-left"></span>&nbsp; Back</button>
     <button type="button" class="btn btn-primary"><span class="icon-border_color"></span>&nbsp Edit Employee Master</button>
    </a> -->
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "" name="" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($staff_id)) echo $staff_id; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">
 		<!-- Row start -->
         <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
					<div class="card-header">
						<!-- <div class="card-title">General Info</div> -->
					</div>
                    <div class="card-body">

                    	 <div class="row">
                            <!--Fields -->
                           <div class="col-md-12 "> 
                              <div class="row">
                                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
                                        <div class="form-group">
                                            <div id='calendar' ></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                        <div class="form-group" >
                                            <div class="overduebox">
                                                <div class="overduehead">Out Dated Tasks</div>
                                                <ul>
                                                    <?php
                                                    $j=0;
                                                    if (sizeof($outdateList) > 0) {
                                                        for ($i = 0; $i < count($outdateList); $i++) {$j=$i+1; ?>
                                                        <li>
                                                            <div class="overduebody">
                                                                <span style="display: none;"> <?php echo $outdateList[$i]['work_id'] ?></span>
                                                                <span> <?php echo  $j.'. '. $outdateList[$i]['work_des_text'] ?></span>
                                                            </div>
                                                        </li>
                                                        <?php }
                                                    } ?>
                                                    <?php if (sizeof($outdateList1) > 0)
                                                    {
                                                        for ($i = 0; $i < count($outdateList1); $i++) { $j=$j+1; ?>
                                                        <li>
                                                            <div class="overduebody">
                                                                <span style="display: none;"> <?php echo $outdateList1[$i]['todo_id'] ?></span>
                                                                <span> <?php echo $j .'. '. $outdateList1[$i]['work_des'] ?></span>
                                                            </div>
                                                        </li>
                                                        <?php }
                                                    } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>

             <!-- Add Work status Modal -->
             <div class="modal fade workStatusModal" id="workStatusModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="background-color: white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeStatusModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- alert messages -->
                            <div id="insertsuccess" class="successalert">Status Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                            </div>
                            <br>
                            
                            <div class="row">
                                <div class="col-xl-1 col-lg-1 col-md-6 col-sm-6 col-12"></div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group ">
                                        <label class="label" id="work_des_label">Work description</label>
                                        <input type="hidden" name="work_id" id="work_id">
                                        <textarea readonly name="work_name" id="work_name" class="form-control" style="height:100px ; width: 350px"></textarea>
                                        
                                        <label class="label" id="progress_label" style="display: none;">Progress Status</label>
                                        <input type="text" class="form-control" style="display: none;width: 350px;" id="in_progress" name="in_progress" placeholder="Enter Progress Status"><br>
                                        <button  name="submit_progress" id="submit_progress" style="display: none;" class="btn btn-primary">Submit </button>
                                        <button  name="cancel_progress" id="cancel_progress" style="display: none;" class="btn btn-outline-secondary">Cancel</button>

                                        <label class="label" id="pending_label" style="display: none;">Pending Remark</label>
                                        <input type="text" class="form-control" style="display: none;width: 350px;" id="pending" name="pending" placeholder="Enter Remarks for Pending"><br>
                                        <button  name="submit_pending" id="submit_pending" style="display: none;" class="btn btn-primary">Submit</button>
                                        <button  name="cancel_pending" id="cancel_pending" style="display: none;" class="btn btn-outline-secondary">Cancel
                                        </button>

                                        <label class="label" id="completed_label" style="display: none;">Completed File</label>
                                        <input type="file" class="form-control" style="display: none;width: 350px;" id="completed_file" name="completed_file" ><br>
                                        <button  name="submit_completed" id="submit_completed" style="display: none;" class="btn btn-primary">Submit</button>
                                        <button  name="cancel_completed" id="cancel_completed" style="display: none;" class="btn btn-outline-secondary">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12"></div>
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                    <button type="button" tabindex="2" name="inprogressgbtn" id="inprogressgbtn" class="btn btn-primary">In Progress</button>
                                    <button type="button" tabindex="2" name="pendingbtn" id="pendingbtn" class="btn btn-danger">Pending</button>
                                    <button type="button" tabindex="2" name="completedbtn" id="completedbtn" class="btn btn-success">Completed</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeStatusModal()">Close</button>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Add Work status Modal -->
             <div class="modal fade workStatusModal1" id="workStatusModal1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="background-color: white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeStatusModal1()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- alert messages -->
                            <div id="insertsuccess" class="successalert">Status Updated Succesfully!<span class="custclosebtn" onclick="this.parentElement.style.display='none';"><span class="icon-squared-cross"></span></span>
                            </div>
                            <br>
                            
                            <div class="row">
                                <div class="col-xl-1 col-lg-1 col-md-6 col-sm-6 col-12"></div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group ">
                                        <!-- <label class="label" id="work_des_label">Work description</label> -->
                                        <input type="hidden" name="work_id1" id="work_id1">
                                        <textarea readonly name="work_name1" id="work_name1" class="form-control" style="display: none; height:100px ; width: 350px"></textarea>
                                        
                                        <label class="label" id="over_due_label" >Completed Date</label>
                                        <input type="date" class="form-control" style="width: 350px;" id="outdated" name="outdated" ><br>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-12"></div>
                                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                    <button name="submit_outdated" id="submit_outdated" class="btn btn-primary">Submit </button>
                                    <button name="cancel_outdated" id="cancel_outdated" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeStatusModal1()">Close</button>
                        </div>
                    </div>
                </div>
            </div>

    </form>
</div>
