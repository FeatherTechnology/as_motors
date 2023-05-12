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
                    <div style="margin-left: 400px;" class="col-md-12"> 
                        <div class="row">
                            <div id="chart_div"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</form>
</div>


