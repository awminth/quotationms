<?php 
if(isset($_SESSION['naiip_userid'])){
    $aid=$_SESSION['naiip_userid'];
    $sql="select * from tbluser where AID='$aid'";
    $result=mysqli_query($con,$sql);
    $rowpermission=mysqli_fetch_array($result);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font: Source Sans Pro -->

    <link rel="stylesheet" href="<?php echo roothtml.'lib/plugins/fontawesome-free/css/all.min.css' ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo roothtml.'lib/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css' ?>">
    <link rel="stylesheet"
        href="<?php echo roothtml.'lib/plugins/datatables-responsive/css/responsive.bootstrap4.min.css' ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo roothtml.'lib/plugins/overlayScrollbars/css/OverlayScrollbars.min.css' ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo roothtml.'lib/dist/css/adminlte.min.css' ?>">
    <link rel="stylesheet" href="<?php echo roothtml.'lib/dist/font-awesome.min.css' ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo roothtml.'lib/plugins/select2/css/select2.min.css' ?>">
    <link rel="stylesheet"
        href="<?php echo roothtml.'lib/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css' ?>">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="<?php echo roothtml.'lib/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' ?>">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet"
        href="<?php echo roothtml.'lib/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css' ?>">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="<?php echo roothtml.'lib/plugins/bs-stepper/css/bs-stepper.min.css' ?>">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="<?php echo roothtml.'lib/plugins/dropzone/min/dropzone.min.css' ?>">

    <link rel="stylesheet" href="<?php echo roothtml.'lib/animate.min.css' ?>">
    <title>Quotation MS</title>
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo roothtml.'lib/plugins/summernote/summernote-bs4.min.css' ?>">

    <!-- jQuery UI -->
    <link rel="stylesheet" href="<?php echo roothtml.'lib/plugins/jquery-ui/jquery-ui.css'?>" />
    <script src="<?php echo roothtml.'lib/plugins/jquery-ui/jquery-ui.min.js'?>"></script>

    <!-- Sweet Alarm -->
    <link href="<?php echo roothtml.'lib/sweet/sweetalert.css' ?>" rel="stylesheet" />
    <script src="<?php echo roothtml.'lib/sweet/sweetalert.min.js' ?>"></script>
    <script src="<?php echo roothtml.'lib/sweet/sweetalert.js' ?>"></script>

    <link rel="shortcut icon" href="<?php echo roothtml.'lib/images/naiip.jpg' ?>" />
    <link href="<?php echo roothtml.'lib/print.min.css' ?>" rel="stylesheet" />

    <style>
    body {
        /* font-family: Arial, Helvetica, sans-serif; */
        font-family: "Times New Roman", Times, serif;
    }

    #logo {
        background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo roothtml.'images/naiip.jpg' ?>');
        /* Used if the image is unavailable */
        height: 550px;
        /* You must set a specified height */
        background-position: center;
        /* Center the image */
        background-repeat: no-repeat;
        /* Do not repeat the image */
        background-size: cover;
        /* Resize the background image to cover the entire container */

    }

    .loader {
        position: fixed;
        z-index: 999;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        background-color: Black;
        filter: alpha(opacity=60);
        opacity: 0.7;
        -moz-opacity: 0.8;
    }

    .center-load {
        z-index: 1000;
        margin: 300px auto;
        padding: 10px;
        width: 130px;
        background-color: black;
        border-radius: 10px;
        filter: 1;
        -moz-opacity: 1;
    }

    .center-load img {
        height: 128px;
        width: 128px;
    }

    .bgactive {
        background-color: RGB(73, 78, 83);
    }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed ">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand fixed-top navbar-<?=$color?> navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars text-white"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a data-toggle="tooltip" data-placement="bottom" title="Home"
                        href="<?php echo roothtml.'home/home.php' ?>" class="nav-link text-white">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <img class="img-circle img-sm" src="<?php echo roothtml.'lib/images/img.jpg' ?>"
                            alt="Profile">&nbsp;&nbsp;

                        <span
                            class="text-white"><?php echo isset($_SESSION['naiip_username'])?$_SESSION['naiip_username'] : ''; ?>
                            ( <?php echo $_SESSION['naiip_usertype'] ?> )</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="bg-<?=$color?> text-center p-1 m-1">
                            <img class="img-circle" src="<?php echo roothtml.'lib/images/img.jpg' ?>" alt="Profile">
                            <p class="text-white">
                                <?php echo isset($_SESSION['naiip_username'])?$_SESSION['naiip_username'] : ''; ?>
                                ( <?php echo $_SESSION['naiip_usertype'] ?> )</p>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="float-left m-2">
                            <a href="<?php echo roothtml.'profile/profile.php' ?>" class="btn btn-<?=$color?> ">
                                <i class="fas fa-user text-white"></i>&nbsp;Profile</a>
                        </div>
                        <div class="float-right m-2">
                            <a href="#" id="btnlogout" class="btn btn-<?=$color?> ">
                                <i class="fas fa-sign-out-alt text-white"></i>&nbsp;Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-success elevation-4">
            <!-- Brand Logo -->
            <a href="<?php echo roothtml.'home/home.php' ?>" class="brand-link bg-<?=$color?>">
                <img src="<?php echo roothtml.'lib/images/naiip.jpg' ?>" alt="AdminLTE Logo"
                    class="brand-image elevation-3" style="opacity: .8;width: 50px;">
                <span class="brand-text font-weight-light" style="font-size: 1.0rem;">Quotation MS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="<?php echo roothtml.'home/home.php' ?>"
                                class="nav-link <?php echo (curlink == 'home.php' || curlink == 'quotation.php' || curlink == 'newquotation.php')?'bgactive' : '' ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo roothtml.'createquotation/createquotation.php' ?>"
                                class="nav-link <?php echo (curlink == 'createquotation.php')?'bgactive' : '' ?>">
                                <i class="nav-icon fas fa-file-medical"></i>
                                <p>
                                    Create Quotation
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo roothtml.'viewquotation/viewquotation.php' ?>"
                                class="nav-link <?php echo (curlink == 'viewquotation.php')?'bgactive' : '' ?>">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    View Quotation
                                </p>
                            </a>
                        </li>
                        <li class="nav-item <?php echo (curlink=='printsetting.php'  || curlink == 'category.php' ||
                        curlink == 'log.php' || curlink == 'project.php')?'menu-open' : '' ?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Setting
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo roothtml.'setting/project.php' ?>"
                                        class="nav-link <?php echo (curlink == 'project.php')?'bgactive' : '' ?>">
                                        <i class="far fa-circle nav-icon" style="font-size:10px;"></i>
                                        <p>Project Name</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo roothtml.'setting/category.php' ?>"
                                        class="nav-link <?php echo (curlink == 'category.php')?'bgactive' : '' ?>">
                                        <i class="far fa-circle nav-icon" style="font-size:10px;"></i>
                                        <p>Category</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo roothtml.'setting/log.php' ?>"
                                        class="nav-link <?php echo (curlink == 'log.php')?'bgactive' : '' ?>">
                                        <i class="far fa-circle nav-icon" style="font-size:10px;"></i>
                                        <p>Log History</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="display: none;">
                                    <a href="<?php echo roothtml.'setting/printsetting.php' ?>"
                                        class="nav-link <?php echo (curlink == 'printsetting.php')?'bgactive' : '' ?>">
                                        <i class="far fa-circle nav-icon" style="font-size:10px;"></i>
                                        <p>Print Setting</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo roothtml.'setting/usercontrol.php' ?>"
                                class="nav-link <?php echo (curlink == 'usercontrol.php' || curlink == 'permission.php')?'bgactive' : '' ?>">
                                <i class="fas fa-users nav-icon"></i>
                                <p>User Control</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <br><br>

        <div class="loader" style="display:none;">
            <div class="center-load">
                <img src="<?php echo roothtml.'lib/images/ajax-loader1.gif'; ?>" />
            </div>
        </div>


        <div class="modal fade" id="modaltoday">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-<?=$color?>">
                        <h4 class="modal-title">ယနေ့အရောင်းကိုကြည့်ရန်</h4>
                        <div class="float-right m-2">
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                            <a id="btnprintvoucher" class="text-white" style="float:right;"><i class="fas fa-print"
                                    style="font-size:20px;"></i></a>

                        </div>
                    </div>

                    <div id="frmtoday" class="container  modal-body">

                    </div>
                </div>
            </div>
        </div>


        <?php }else{  

header("location:". roothtml."errorpage.php");   
      
}
?>