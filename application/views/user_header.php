
<?php 
$this->load->library('session');
$n = $this->session->userdata('name');
$i = $this->session->userdata('i');
$id = $this->session->userdata('person_id');
$row = $this->login_model->getdata_by_id($id);

$d=$this->login_model->user_pages();
$g=$this->login_model->color();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<style>


</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-<?php echo $g[0]->color;?> sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon ">
                    <?php 
                        echo '<img class="img-profile rounded-circle" src="' . base_url('uploads/') . $g[0]->logo . '" alt="My image alt" style="width: 50px; height: 60px;">';
                    ?>     
                </div>
                <div class="sidebar-brand-text mx-3" style="max-width: 120px; word-wrap: break-word;">
                    <?php echo $g[0]->title;?>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url('welcome/dashboard');?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span><?php echo $d[0]->side_menu;?></span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('Welcome/upload');?>">
                    <i class="fas fa-fw fa-upload"></i>
                    <span><?php echo $d[1]->side_menu;?></span></a>
            </li>

            <?php
if ($row && property_exists($row, 'access')) {
    $arr = explode(',', $row->access);

    $accessPages = [
        'HR' => [
            'page' => 'access_page_HR',
            'icon_class' => 'fas fa-fw fa-user'
        ],
        'manager' => [
            'page' => 'access_page_Manager',
            'icon_class' => 'fas fa-fw fa-cogs'  // Change this to the desired icon class
        ],
        'senior developer' => [
            'page' => 'access_page_Developer',
            'icon_class' => 'fas fa-fw fa-code'  // Change this to the desired icon class
        ],
    ];

    foreach ($accessPages as $role => $data) {
        $isAdmin = ($row->role == 'admin');
        $hasAccess = in_array($role, $arr);

        if ($isAdmin || $hasAccess) {
            ?>
            <li class="nav-item">
                <a href="<?= base_url('welcome/' . $data['page']); ?>" class="nav-link">
                    <i class="<?= $data['icon_class'] ?>"></i>
                    <span><?= $role ?></span>
                </a>
            </li>
            <?php
        }
    }
}
?>



            <!-- Nav Item - Tables -->
            <!--<li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>-->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

           

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $row->name; ?> </span>
                            <?php
                            if (isset($row->pic) && !empty($row->pic)) {
                                // If the image URL starts with "https", use it as is
                                if (strpos($row->pic, "https") === 0) {
                                    $imageSrc = $row->pic;
                                } else {
                                    // If not, prepend the base_url for local images
                                    $imageSrc = base_url('uploads/') . $row->pic;
                                }
                                echo '<img class="img-profile rounded-circle" src="' . $imageSrc . '" alt="' . '" style="max-width: 200px; max-height: 200px;">';
                            } else {
                                // If there's no image, display a default circular image
                                echo '<img class="img-profile rounded-circle" src="' . base_url('uploads/default.jpg') . '" alt="Default Profile Image" style="max-width: 200px; max-height: 200px;">';
                            }
                            ?>
                        </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('welcome/profile'); ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url('Welcome/change_password');?>">
                                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo base_url('Welcome/logout');?>" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

