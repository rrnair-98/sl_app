<?php
include_once('constants.php');
?>
<!--SIDEBAR.PHP-->
<!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-light " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper hide">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler"> </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>
                        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                        <li class="sidebar-search-wrapper">
                            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                            
                            <!--SEARCH BOX-->
                            <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                                <a href="javascript:;" class="remove">
                                    <i class="icon-close"></i>
                                </a>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <a href="javascript:;" class="btn submit">
                                            <i class="icon-magnifier"></i>
                                        </a>
                                    </span>
                                </div>
                            </form>
                            <!-- END RESPONSIVE QUICK SEARCH FORM -->
                            
                            
                        </li>
                        <li class="<?php if($page=="dashboard"){echo "nav-item active";}else {echo"nav-item";}?>">
                            <a href="<?php echo BASE_PATH."ui/dashboard.php";?>" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="heading">
                            <h3 class="uppercase">Admin Panel</h3>
                        </li>
                        <li class="nav-item active">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-diamond"></i>
                                <span class="title">Test Stuff</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="<?php if($page=="add-branch"){echo "nav-item active";}else {echo"nav-item";}?>">
                                    <a href="<?php echo BASE_PATH."ui/test-stuff/add-branch.php";?>" class="nav-link">
                                        <span class="title">Add New Branch</span>
                                    </a>
                                </li>
                                <li class="<?php if($page=="add-semester"){echo "nav-item active";}else {echo"nav-item";}?>">
                                    <a href="<?php echo BASE_PATH."ui/test-stuff/add-semester.php";?>" class="nav-link">
                                        <span class="title">Add New Semester</span>
                                    </a>
                                </li>
                                <li class="<?php if($page=="add-subject"){echo "nav-item active";}else {echo"nav-item";}?>">
                                    <a href="<?php echo BASE_PATH."ui/test-stuff/add-subject.php";?>" class="nav-link">
                                        <span class="title">Add New Subject</span>
                                    </a>
                                </li>
                                <li class="<?php if($page=="add-chapter"){echo "nav-item active";}else {echo"nav-item";}?>">
                                    <a href="<?php echo BASE_PATH."ui/test-stuff/add-chapter.php";?>" class="nav-link">
                                        <span class="title">Add New Chapter</span>
                                    </a>
                                </li>
                                <li class="<?php if($page=="add-question"){echo "nav-item active";}else {echo"nav-item";}?>">
                                    <a href="<?php echo BASE_PATH."ui/test-stuff/add-question.php";?>" class="nav-link">
                                        <span class="title">Add New Question</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                        
                        
                    </ul>
                    <!-- END SIDEBAR MENU -->
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->