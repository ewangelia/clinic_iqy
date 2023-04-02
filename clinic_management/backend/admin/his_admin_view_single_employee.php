<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $uid=$_SESSION['uid'];
?>

<!DOCTYPE html>
    <html lang="en">

    <?php include('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
             <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <!--Get Details Of A Single User And Display Them Here-->
            <?php
                $id_user=$_GET['id_user'];
                $ret="SELECT  * FROM users WHERE id_user=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('i',$id_user);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                $no_user=$_GET['no_user'];
                //$cnt=1;
                while($row=$res->fetch_object())
            {
            ?>
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Employees</a></li>
                                            <li class="breadcrumb-item active">View Employees</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"><?php echo $row->nama_user;?>'s Profile</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="card-box text-center">
                                    <img src="../doc/assets/images/users/<?php echo $row->doc_dpic;?>" class="rounded-circle avatar-lg img-thumbnail"
                                        alt="profile-image">

                                    
                                    <div class="text-centre mt-3">
                                        
                                        <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2"><?php echo $row->nama_user;?></span></p>
                                       <p class="text-muted mb-2 font-13"><strong>Department :</strong> <span class="ml-2"><?php echo $row->spesialis;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Employee Number :</strong> <span class="ml-2"><?php echo $row->no_user;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Telephone Number :</strong> <span class="ml-2"><?php echo $row->no_telp_user;?></span></p>


                                    </div>

                                </div> <!-- end card-box -->

                            </div> <!-- end col-->
                            <!--Vitals-->
                            <div class="col-lg-6 col-xl-6">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Body Temperature</th>
                                                <th>Heart Rate/Pulse</th>
                                                <th>Respiratory Rate</th>
                                                <th>Blood Pressure</th>
                                                <th>Date Recorded</th>
                                            </tr>
                                        </thead>
                                        <?php
                                            $vit_pat_number =$_GET['doc_number'];
                                            $ret="SELECT * FROM his_vitals WHERE vit_pat_number = '$vit_pat_number'";
                                            $stmt= $mysqli->prepare($ret) ;
                                            // $stmt->bind_param('i',$vit_pat_number );
                                            $stmt->execute() ;//ok
                                            $res=$stmt->get_result();
                                            //$cnt=1;
                                            
                                            while($row=$res->fetch_object())
                                                {
                                            $mysqlDateTime = $row->vit_daterec; //trim timestamp to date

                                        ?>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $row->vit_bodytemp;?>°C</td>
                                                    <td><?php echo $row->vit_heartpulse;?>BPM</td>
                                                    <td><?php echo $row->vit_resprate;?>bpm</td>
                                                    <td><?php echo $row->vit_bloodpress;?>mmHg</td>
                                                    <td><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></td>
                                                </tr>
                                            </tbody>
                                        <?php }?>
                                    </table>
                                    </div>
                                </div> <!-- end col-->
                        </div>
                        <!-- end row-->

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->

            </div>
            <?php }?>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

    </body>


</html>