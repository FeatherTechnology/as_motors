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
        margin-top: 80px;
        height: 100%;
    }
    #tree {
        width: 100%;
        height: 100%;
    }
    [lcn='hr-team']>rect {
    fill: #FFCA28;
    }

    [lcn='sales-team']>rect {
        fill: #F57C00;
    }

    [lcn='top-management']>rect {
        fill: #f2f2f2;
    }

    [lcn='top-management']>text,
    .assistant>text {
        fill: #aeaeae;
    }

    [lcn='top-management'] circle,
    [lcn='assistant'] {
        fill: #aeaeae;
    }

    .assistant>rect {
        fill: #ffffff;
    }

    .assistant [data-ctrl-n-menu-id]>circle {
        fill: #aeaeae;
    }

    .it-team>rect {
        fill: #b4ffff;
    }

    .it-team>text {
        fill: #039BE5;
    }

    .it-team>[data-ctrl-n-menu-id] line {
        stroke: #039BE5;
    }

    .it-team>g>.ripple {
        fill: #00efef;
    }

    .hr-team>rect {
        fill: #fff5d8;
    }

    .hr-team>text {
        fill: #ecaf00;
    }

    .hr-team>[data-ctrl-n-menu-id] line {
        stroke: #ecaf00;
    }

    .hr-team>g>.ripple {
        fill: #ecaf00;
    }

    .sales-team>rect {
        fill: #ffeedd;
    }

    .sales-team>text {
        fill: #F57C00;
    }

    .sales-team>[data-ctrl-n-menu-id] line {
        stroke: #F57C00;
    }

    .sales-team>g>.ripple {
        fill: #F57C00;
    }
    
</style>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!--------form start-->
    <form id = "report_creation" name="report_creation" action="" method="post" enctype="multipart/form-data"> 
        <input type="hidden" class="form-control" value="<?php if(isset($userid)) echo $userid; ?>" id="id" name="id" aria-describedby="id" placeholder="Enter id">
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
                                
                                <div id="tree"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


