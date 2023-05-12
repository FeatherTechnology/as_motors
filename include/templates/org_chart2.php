<?php 
@session_start();
if(isset($_SESSION["userid"])){
    $userid = $_SESSION["userid"];
} 
$getuserdetails  = $userObj->getuser($mysqli, $userid); 
$getcompanyDetails = $userObj->getCompanyName($mysqli); 
?>    

<style>
/*CSS*/
html, body {
    margin: 0px;
    padding: 0px;
    width: 100%;
    height: 100%;
    overflow: hidden;
}
#tree {
    width: 100%;
    height: 100%;
    background-color: #EEEEF1;
}
[data-ctrl-ec-id]{
    -webkit-user-select: none; /* Safari */        
    -moz-user-select: none; /* Firefox */
    -ms-user-select: none; /* IE10+/Edge */
    user-select: none; /* Standard */
}


.boc-edit-form-header, .boc-img-button{
    background-color: #1E1E1E !important;
}


.sales line{    
    stroke: #F57C00 !important;
}

.department.sales rect{    
    fill: #ffe7ce !important;
}
.sales .boc-edit-form-header, .sales .boc-img-button{
    background-color: #F57C00 !important;
}


.technology line{    
    stroke: #039BE5 !important;    
}

.department.technology rect{    
    fill: #d5f1fe  !important;    
}

.technology .boc-edit-form-header, .technology .boc-img-button{
    background-color: #039BE5 !important;
}




.marketing line{
    stroke: #FFCA28 !important;
}

.department.marketing rect{
    fill: #fff9e8  !important;
}

.marketing .boc-edit-form-header, .marketing .boc-img-button{
    background-color: #FFCA28 !important;
}

.dotted-connector path{
    stroke-dasharray: 7;
    stroke: #fff;
}

</style>
<!--HTML-->
<script src="https://balkan.app/js/OrgChart.js"></script>
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
                                <div class="col-md-12 "> 
                                    <div class="row">
                                    
                                    <div id="tree"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>
                                
        </form>
    </div>
</div>
