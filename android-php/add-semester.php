<?php
$page = "add-semester";
/*
TITLE variable will be added to the title tag of the page
*/
$TITLE = "Study Link | Add a new semester";
?>
    <!DOCTYPE html>
    <!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
    <!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
    <!--[if !IE]><!-->
    <html lang="en">
    <!--<![endif]-->

    <?php
    include_once('../../includes/head.php');
    ?>

        <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
            <?php
        include_once('../../includes/header.php');
        ?>
                <!-- BEGIN CONTAINER -->
                <div class="page-container">
                    <?php
            include_once('../../includes/sidebar.php');
            ?>
                        <!-- BEGIN CONTENT -->
                        <div class="page-content-wrapper">
                            <!-- BEGIN CONTENT BODY -->
                            <div class="page-content">
                                <!-- BEGIN PAGE HEADER-->
                                <!-- BEGIN PAGE BAR -->
                                <div class="page-bar">
                                    <ul class="page-breadcrumb">
                                        <li>
                                            <a href="<?php echo BASE_PATH." ui/dashboard.php ";?>">Dashboard</a>
                                            <i class="fa fa-circle"></i>
                                        </li>
                                        <li>
                                            <span>Test Stuff</span>
                                            <i class="fa fa-circle"></i>
                                        </li>
                                        <li>
                                            <a href="#">Add New Semester</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- END PAGE BAR -->
                                <!-- BEGIN PAGE TITLE-->
                                <h3 class="page-title"> Add New Semester
                                    <small>creates a new semester to existing branch</small>
                                </h3>
                                <!-- END PAGE TITLE-->
                                <!-- END PAGE HEADER-->

                                <!--BEGIN FORM-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- BEGIN VALIDATION STATES-->
                                        <div class="portlet light portlet-fit portlet-form bordered">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class=" icon-layers font-green"></i>
                                                    <span class="caption-subject font-green sbold uppercase">Semester Creation</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <!-- BEGIN FORM-->
                                                <form action="#" id="form_add_new_semester">
                                                   
                                                   
                                                   <!--BRANCH COMBO BOX-->
                                                   <div class="form-body">
                                                    <div class="form-group form-md-line-input form-md-floating-label">
                                                        <select class="form-control" name="branch" id="branch">
                                                            <option value=""></option>
                                                            <option value="1">Option 1</option>
                                                            <option value="2">Option 2</option>
                                                            <option value="3">Option 3</option>
                                                        </select>
                                                        <label for="branch">Branch</label>
                                                        <span class="help-block">Select a branch...</span>
                                                    </div>
                                                    </div>
                                                    <!--END OF BRANCH COMBO BOX-->
                                                    
                                                    
                                                    
                                                    <div class="form-body">
                                                        <div class="form-group form-md-line-input form-md-floating-label">
                                                            <input type="text" class="form-control" name="semester" id="semester">
                                                            <label for="semester">Enter Semester</label>
                                                            <span class="help-block">Insert new semester number to be inserted...</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <button type="submit" class="btn green">Add</button>
                                                                <button type="reset" class="btn default">Reset</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- END FORM-->
                                            </div>
                                        </div>
                                        <!-- END VALIDATION STATES-->
                                    </div>
                                </div>
                            </div>
                            <!-- END CONTENT BODY -->
                        </div>
                        <!-- END CONTENT -->
                </div>
                <!-- END CONTAINER -->
                <!--BEGIN FOOTER-->
                <?php
            include_once('../../includes/footer.php');
        ?>
                    <!--END OF FOOTER-->
                    <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
                    <!-- BEGIN CORE PLUGINS -->
                    <script src="<?php echo BASE_PATH." /assets/global/plugins/jquery.min.js ";?>" type="text/javascript"></script>
                    <script src="<?php echo BASE_PATH." /assets/global/plugins/bootstrap/js/bootstrap.min.js ";?>" type="text/javascript"></script>
                    <script src="<?php echo BASE_PATH." /assets/global/plugins/js.cookie.min.js ";?>" type="text/javascript"></script>
                    <script src="<?php echo BASE_PATH." /assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js ";?>" type="text/javascript"></script>
                    <script src="<?php echo BASE_PATH." /assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js ";?>" type="text/javascript"></script>
                    <script src="<?php echo BASE_PATH." /assets/global/plugins/jquery.blockui.min.js ";?>" type="text/javascript"></script>
                    <script src="<?php echo BASE_PATH." /assets/global/plugins/uniform/jquery.uniform.min.js ";?>" type="text/javascript"></script>
                    <script src="<?php echo BASE_PATH." /assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js ";?>" type="text/javascript"></script>
                    <!-- END CORE PLUGINS -->
                    <!-- BEGIN PAGE LEVEL PLUGINS -->
                    <script src="<?php echo BASE_PATH." /assets/global/plugins/jquery-validation/js/jquery.validate.min.js ";?>" type="text/javascript"></script>
                    <script src="<?php echo BASE_PATH." /assets/global/plugins/jquery-validation/js/additional-methods.min.js ";?>" type="text/javascript"></script>
                    <!-- END PAGE LEVEL PLUGINS -->
                    <!-- BEGIN THEME GLOBAL SCRIPTS -->
                    <script src="<?php echo BASE_PATH." /assets/global/scripts/app.min.js ";?>" type="text/javascript"></script>
                    <!-- END THEME GLOBAL SCRIPTS -->
                    <!-- BEGIN PAGE LEVEL SCRIPTS -->
                    <script src="<?php echo BASE_PATH." /assets/pages/scripts/form-validation-md.min.js ";?>" type="text/javascript"></script>
                    <!-- END PAGE LEVEL SCRIPTS -->
                    <!-- BEGIN THEME LAYOUT SCRIPTS -->
                    <script src="<?php echo BASE_PATH." /assets/layouts/layout/scripts/layout.min.js ";?>" type="text/javascript"></script>
                    <script src="<?php echo BASE_PATH." /assets/layouts/layout/scripts/demo.min.js ";?>" type="text/javascript"></script>
                    <script src="<?php echo BASE_PATH." /assets/layouts/global/scripts/quick-sidebar.min.js ";?>" type="text/javascript"></script>
                    <!-- END THEME LAYOUT SCRIPTS -->
        </body>

    </html>
