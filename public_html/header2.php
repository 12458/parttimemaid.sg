<?php $companyname = $obj_settings->get_option("rzvy_company_name"); ?>
<?php $companylogo = $obj_settings->get_option("rzvy_company_logo"); ?>
<!-- Rzvy Header -->

<style>
    .rz-logo img {
        max-width: 150px;
        max-height: 150PX;

        padding: 4px;
    }
    .pset{
        padding-left:0;
    }
    .smenu{
        padding-left:0;
    }
    .rzvy-brand .rzvy-companytitle {
        margin-left: -22px;
    }
    @media screen and (max-width: 991px){

        .rz-logo img {
            max-width: 120px;
            max-height: 120px;
            float: none;
            margin-left: 33%;
        }

        .pset{
            padding-left:22px;
            padding-right:22px;

        }
        .rzvy-header .container {
            padding-top: 0px!important;	
        }
        .rzvy-brand .rzvy-companytitle {
            margin-left: 2px;
        }
    }
</style>
<div style="background:#fff;">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-12" style="padding: 15px;">

                <a href="<?php echo SITE_URL; ?>" class="rz-logo"><?php if (!isset($_GET['if'])) { ?><?php if ($companylogo != "" && file_exists(ROOT_PATH . "/uploads/images/" . $companylogo)) { ?><img src="<?php echo SITE_URL; ?>uploads/images/<?php echo $companylogo; ?>" /> <?php } else { ?><b class="rzvy-companytitle"><?php echo $companyname; ?></b><?php } ?><?php } ?></a>

            </div>
            <div class="col-md-10 col-12" style="padding: 0;">
                <div class="row" style="padding: 0;">
                    <div class="col-md-12" style="padding: 0;">
                        <header class="rzvy-header"> 
                          
                            <div class="container">





                                <a href="<?php echo SITE_URL; ?>" class="rzvy-brand"><b class="rzvy-companytitle"><?php echo $companyname; ?></b> </a>

                                <a href="javascript:void(0);" class="hamburger" onclick="$('.rzvy-header > .container > ul').slideToggle();"><span></span></a>
                                <ul>
                                    <?php if ($lang_j > 1) { ?>
                                        <li>
                                            <div class="country-selectd">
                                                <a href="javascript:void(0);"><?php echo $isSelectedlanguage; ?></a>
                                                <ul class="selectpickerd" data-style="btn-primary">
                                                    <?php echo $langOptions; ?>
                                                </ul>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <?php 
                                        if(isset($rzvy_location_selector_status)){
                                            
                                        
                                        if ($rzvy_location_selector_status == "Y") {
                                            ?>
                                        <a data-toggle="modal" data-target="#rzvy-location-selector-modal" href="javascript:void(0)">
                                            <i class="fa fa-fw fa-map-marker"></i><?php
                                                if (isset($rzvy_translangArr['book_at_another_location'])) {
                                                    echo $rzvy_translangArr['book_at_another_location'];
                                                } else {
                                                    echo $rzvy_defaultlang['book_at_another_location'];
                                                }
                                                ?></a><?php }} ?></li>

                                    <li><a href="<?php echo SITE_URL; ?>part-time-maid.php">Part-time Maid</a></li>

                                    <li><a href="<?php echo SITE_URL; ?>near-by-me.php">Part-time Maid Near Me</a></li>

                                    <li><a href="<?php echo SITE_URL; ?>about.php">About Us</a></li>

                                    <?php if (!isset($_SESSION['login_type'])) { ?>

                                        <li><a href="<?php echo SITE_URL; ?>backend/register.php">Sign Up</a></li>
                                    <?php } ?>
                                    <li>
                                        <a href="<?php echo SITE_URL; ?>backend/my-appointments.php">
                                            <i class="fa  fa-fw fa-user-circle-o" aria-hidden="true"></i>
                                            <?php
                                            if (isset($_SESSION['login_type'])) {

                                                if (isset($rzvy_translangArr['my_account'])) {
                                                    echo $rzvy_translangArr['my_account'];
                                                } else {
                                                    echo $rzvy_defaultlang['my_account'];
                                                }
                                            }else{
                                                echo "Login";
                                            }
                                            ?>
                                        </a>
                                    </li>

                                    <?php
                                    if (isset($_SESSION['login_type'])) {
                                        $rzvy_namestring = '';
                                        if (isset($_SESSION['customer_id'])) {
                                            $get_customer_name = $obj_settings->get_customer_name($_SESSION["customer_id"]);
                                            if (mysqli_num_rows($get_customer_name) > 0) {
                                                $__customername = mysqli_fetch_array($get_customer_name);
                                                $rzvy_namestring = mb_substr($__customername["firstname"], 0, 1) . mb_substr($__customername["lastname"], 0, 1);
                                            }
                                        }
                                        if (isset($_SESSION['staff_id'])) {
                                            $get_staff_name = $obj_settings->get_staff_name($_SESSION["staff_id"]);
                                            if (mysqli_num_rows($get_staff_name) > 0) {
                                                $__staff_name = mysqli_fetch_array($get_staff_name);
                                                $rzvy_namestring = mb_substr($__staff_name["firstname"], 0, 1) . mb_substr($__staff_name["lastname"], 0, 1);
                                            }
                                        }
                                        if (isset($_SESSION['admin_id'])) {
                                            $get_admin_name = $obj_settings->get_admin_name($_SESSION["admin_id"]);
                                            if (mysqli_num_rows($get_admin_name) > 0) {
                                                $__admin_name = mysqli_fetch_array($get_admin_name);
                                                $rzvy_namestring = mb_substr($__admin_name["firstname"], 0, 1) . mb_substr($__admin_name["lastname"], 0, 1);
                                            }
                                        }
                                        if ($rzvy_namestring != '') {
                                            ?>
                                            <li><span class="user-avatar"><?php echo $rzvy_namestring; ?></span></li>
                                        <?php } ?>
                                        <li class="logout"><a href="logout.php" id="rzvy_logout_header_btn"><i class="fa fa-fw fa-sign-out" aria-hidden="true"></i> <?php
                                                if (isset($rzvy_translangArr['logout'])) {
                                                    echo $rzvy_translangArr['logout'];
                                                } else {
                                                    echo $rzvy_defaultlang['logout'];
                                                }
                                                ?></a></li>
                                    <?php } ?>

                                </ul>

                            </div>

                        </header>
                    </div>
                    <div class="col-md-12 smenu"  style="padding: 0;">
                        <ul class="pset">
                            <?php
                            include('db.php');
                            ?>

                            <li style="display: inline-block;">

                                <?php echo base64_decode($obj_settings->get_option("rzvy_welcome_message_container")); ?>
                            </li>

                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>