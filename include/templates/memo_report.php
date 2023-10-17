<!-- Page header start -->
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">AS - Memo Report </li>
    </ol>
</div>
<!-- Page header end -->

<!-- Main container start -->
<div class="main-container">
    <!--form start-->
    <form id="memo_report" name="memo_report" action="" method="post" enctype="multipart/form-data">
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
                                            <label for="memo_report_type">Report Type</label>
                                                <select tabindex="1" type="text" class="form-control emptyTable" id="memo_report_type" name="memo_report_type">
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

                                    <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dailyKM_from_date">From Date</label>
                                            <input tabindex="11" type="date" class="form-control validateToDate clearvalue" id="dailyKM_from_date" name="dailyKM_from_date">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                        <div class="form-group">
                                            <label for="dailyKM_to_date">To Date</label>
                                            <input tabindex="12" type="date" class="form-control setvaltodate clearvalue" id="dailyKM_to_date" name="dailyKM_to_date">
                                        </div>
                                    </div> -->

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
                        <div class="card-body" id="memo_report_view_table">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>