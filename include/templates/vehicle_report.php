<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Vehicle Report </li>
    </ol>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!--form start-->
    <form id="vehicle_report" name="vehicle_report" action="" method="post" enctype="multipart/form-data">
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
                                                    <option value='1'>OverAll</option>
                                                    <option value='2'>Branch</option>
                                                    <!-- <option value='3'>Date of Purchase</option> -->
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Type End-->

                            <!--Department Start-->
                            <div class="col-md-12" id="branch_report" style="display: none;">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="branch_name">Branch Name</label>
                                                <select tabindex="6" type="text" class="form-control clearvalue" id="branch_name" name="branch_name">
                                                    <option value=''>Select Branch</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Department End-->

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