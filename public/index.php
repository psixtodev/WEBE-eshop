<?php require_once("../resources/config.php"); ?>
<!-- it leads you to 'resources/templates/front/header.php' -->
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>
    <?php //session_destroy();//phpinfo();?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!--Catagories here!-->
            <?php include(TEMPLATE_FRONT . DS . "side_nav.php") ?>



            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <!--Carousel!-->
                        
                    </div>

                </div>

                <div class="row">

                    <?php get_products(); ?>
                    
                </div> <!--row ends here!-->

            </div>

        </div>

    </div>
    <!-- /.container -->
<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>


   