<?php require_once("../../resources/config.php"); ?>
<?php include(TEMPLATE_BACK . "/header_normaluser.php"); ?>

<?php

    if(!isset($_SESSION['username'])) {
        redirect("../../public");
    }

?>

        <div id="page-wrapper">

            <div class="container-fluid">


            <?php
                if (
                    $_SERVER['REQUEST_URI'] == "/eshop/public/normaluser/" ||
                    $_SERVER['REQUEST_URI'] == "/eshop/public/normaluser/index.php"
                ) {

                    include(TEMPLATE_BACK . "/normaluser_content.php");
                }     
                if(isset($_GET['reports'])) {
                    include(TEMPLATE_BACK . "/reports_normaluser.php");
                }
                  
            ?>

            </div>
            <!-- /.container-fluid -->

<?php include(TEMPLATE_BACK . "/footer.php"); ?>
        