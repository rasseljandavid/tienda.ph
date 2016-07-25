<!DOCTYPE HTML>
<html>
    <head>
        <?php
      
        $enhanced = "";
    
        expTheme::head(array(
            "xhtml"=>false,
            "framework"=>"bootstrap3",
            "lesscss"=>$enhanced,
            // these viewport settings are the defaults so they are not really needed except to customize
            "viewport"=>array(
                "width"=>"device-width",
                "height"=>"device-height",
                "initial_scale"=>1,
                "minimum_scale"=>0.25,
                "maximum_scale"=>5.0,
                "user_scalable"=>true,
            ),
            "css_core"=>array(
                "common"
            ),
            "css_links"=>true,
            "css_theme"=>true
        ));
        ?>
    </head>
    <body>
        <!-- navigation bar/menu -->
        <div class="main-menu">
            <?php expTheme::module(array("controller"=>"navigation","action"=>"showall","view"=>"showall_Flydown")); ?>
        </div>
        <!-- main page body -->
        <div class="container <?php echo (MENU_LOCATION == 'fixed-top') ? 'fixedmenu' : '' ?>">
            <!-- optional flyout sidebar container -->
        
            <section id="main" class="row">
                <!-- main column wanted on top if collapsed -->
                <section id="content" class="col-sm-10 col-sm-push-2">
                    <?php expTheme::main(); ?>
                </section>
                <!-- left column -->
                <aside id="sidebar" class="col-sm-2 col-sm-pull-10">
                    <?php expTheme::module(array("controller"=>"container","action"=>"showall","view"=>"showall","source"=>"@left")); ?>

					<?php expTheme::module(array("controller"=>"store","action"=>"showFullTree","source"=>"@leftnav")); ?>
                </aside>
            </section>
            <!-- footer -->
            <footer class="row">
                <div class="content col-sm-12">
                    <?php expTheme::module(array("controller"=>"text","action"=>"showall","view"=>"showall_single","source"=>"@footer","chrome"=>1)) ?>
                </div>
            </footer>
        </div>
        <?php expTheme::foot(); ?>
		<script type="text/javascript" src="<?php echo THEME_RELATIVE; ?>js/jquery.jscroll.min.js"></script>
    </body>
</html>
