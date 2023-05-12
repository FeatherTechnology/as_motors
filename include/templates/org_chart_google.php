<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
$getuserdetails  = $userObj->getuser($mysqli, $userid); 
$getcompanyDetails = $userObj->getCompanyName($mysqli); 
?>

<style>
    .card{
        margin: 0px 0px;
    }
    #chart_div{
        font-size: large;
        /* margin-left: 350px; */
    }

    .google-visualization-orgchart-lineleft {
        border-left: 2px solid #333!important;
    }
    .google-visualization-orgchart-linebottom {
        border-bottom: 2px solid #333!important;
    }
    .google-visualization-orgchart-lineright {
        border-right: 2px solid #333!important;
    }
    

    /* .node-style {

        border: 2px solid black;
        border-radius: 10px;
        
        padding: 10px;
    } */


</style>
<!-- Page header end -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Organization Chart </li>
    </ol>
    
</div>
<!-- Main container start -->
<div class="main-container">
<!--------form start-->
<form id = "report_creation" name="report_creation" action="" method="post" enctype="multipart/form-data"> 
<input type="hidden" class="form-control" value="<?php if(isset($userid)) echo $userid; ?>"  id="id" name="id" aria-describedby="id" placeholder="Enter id">

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
                    <div class="col-md-12"> 
                        <div class="row">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12">
                                <!-- <h4 style="align-items: left;" id="company_name"></h4><br>
                                <h4 style="align-items: left;" id="branch_name"></h4> -->
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div id="chart_div"></div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12" >
                                <!-- <h4 style="text-align: center;" id="branch_address"></h4> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</form>
</div>


