<style type="text/css">

</style>
<footer class="rzvy-header">
    <div class="container">
        <ul>
            <li><a href="<?php echo SITE_URL ?>part-time-maid.php">Part-time Maid</a></li>
            <li><a href="<?php echo SITE_URL ?>near-by-me.php">Part-time Near Me</a></li>
            <li><a href="<?php echo SITE_URL ?>about.php">About Us</a></li>
            <?php if (!isset($_SESSION['login_type'])) { ?>

                <li><a href="<?php echo SITE_URL ?>backend/register.php">Sign Up</a></li>
            <?php } ?>
        </ul>
        <div class="text-right">
            &copy; All rights reserved, 2021
            <div>
            </div>
            </footer>
