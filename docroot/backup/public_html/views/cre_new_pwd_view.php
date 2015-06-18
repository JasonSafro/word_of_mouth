<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

            <title>:: Word Of Mouth ::</title>
            <?php
            echo css_asset("reset.css");
            echo css_asset("stylesheet.css");
            echo css_asset("word-of-mouth.css");
            echo css_asset("flexslider.css");
            echo css_asset("screen.css");
            ?>
            <link rel="shortcut icon" href="<?php echo USER_SIDE_IMAGES; ?>wom-20130603-favicon.ico.png"/>
            <!--[if IE]>
            <script src="js/html5.js"></script>
            <![endif]-->
            <?php echo js_asset("jquery-1.8.3.min.js"); ?>
            <script type="text/javascript" language="javascript">
                $(document).ready(function () {
                    $("div.videos li:last") .css("margin-bottom","0px");
                    $("div.videos li:last") .css("background","none");
                    $("div.line-one li:last") .css("margin-right","0px");
                    $("div.line-two li:last") .css("margin-right","0px");
                    $("div.line-three li:last") .css("margin-right","0px");
                    $("div.line-four li:last") .css("margin-right","0px");
                    $("div.line-five li:last") .css("margin-right","0px");
                    $("div.swControls a:last") .css("margin-right","0px");
                    $("div.links li:last") .css("background","none");
                });
            </script>
            <!--for us of back to top function-->
            <script src="<?php echo base_url() ?>assets/scripts/jquery.easing.1.2.js" type="text/javascript" charset="utf-8"></script>
            <script src="<?php echo base_url() ?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
            <script type="text/javascript" charset="utf-8">
                $(document).ready(function(){
                    /*====================== Exemple basique ======================*/
                    $("#parent1").wslide({
                        width: 450,
                        height: 200,
                        duration: 2000,
                        effect: 'easeOutBounce'
                    });
                    /*====================== Exemple 2 ======================*/
                    $("#parent2").wslide({
                        width: '100%',
                        height: 284,
                        //pos: 1,
                        //horiz: true,
                        autoplay: true ,
                        fade: true,
                        //delay: 2000,
                        duration: 2000, 
                        //type: 'sequence',
                        //duration: 1000,
                        //effect: 'easeOutElastic'
					
                    });
				
				
				
                    /*====================== Exemple 3 ======================*/
                    $("#parent3").wslide({
                        width: 250,
                        height: 300,
                        col: 4,
                        autolink: 'menu3',
                        duration: 4000,
                        effect: 'easeOutExpo'
                    });
                });
            </script>
            <?php
            echo js_asset("jquery.reveal.js");
            echo js_asset("script.js");
            ?>
        </head>
        <body id="top">
            <div id="wrapper" >
                <div class="clearfix">
                    <header>
                        <div id="main" >
                            <div class="fr1">         
                                <div class="clear"></div>
                            </div>
                            <div class="logo"><?php echo anchor('#', img(array('src' => USER_SIDE_IMAGES . 'logo.png', 'border' => "0", 'alt' => 'logo'))); ?></div>
                            <div class="fr">
                                <div class="clear"></div>
                                <div class="call-us">
                                    <div class="space"><img src="<?php echo USER_SIDE_IMAGES; ?>spacer.gif" alt="spacer" width="5"></div>
                                    <span>Call Us Today: 1-888-324-2301</span></div>
                            </div>
                            <div class="call-us1">
                                <div class="space"><img src="i<?php echo USER_SIDE_IMAGES; ?>spacer.gif" alt="spacer" width="5"></div>
                                Call Us Today: 1-888-324-2301</div>
                            <div class="clear"></div>
                        </div>   
                    </header>
                    <!--header end here-->
                    <div id="page-wrap">
                        <div id="main1">
                            <section class="inside-title">
                                <div class="inside-title-in"><div  id="main">
                                        <h1>Create New Password</h1></div>
                                </div>
                            </section> 
                            <div class="clear"></div>

                        </div>
                        <div class="clear"></div>

                        <div id="section">
                            <section id="main"><div class="contact-main">
                                    <article class="section-left-inside-contact top-mar"><h3>Enter Your New Password! </h3>
                                        <h4>Don't Close This Window. If You Close This Window, Your Password Will Not Change.. </h4>
                                        <div class="clear"></div>
                                        <?php
                                        $atr = array("name" => "ch_pwd_frm", "id" => "ch_pwd_frm", "method" => "post");
                                        echo form_open("forgot_pwd/change_pwd", $atr);
                                        ?>
                                        <label>Enter New Password *</label><input type="password" id="n_pass" name="n_pass" value="<?php echo set_value('n_pass');?>">
                                        <?php echo form_error('n_pass');?> 
                                        <label>Confirm Password *</label><input type="password" id="c_pass" name="c_pass" value="<?php echo set_value('c_pass');?>">         
                                        <?php echo form_error('c_pass');?> 
                                        <div class="conntact-buttons">
                                            <div class="tabs-contact">
                                                <div class="tab">
                                                    <a class="button1 white wid" onclick="javascript: $('#resetbtn12').click();">RESET</a>
                                                     <input  style="display:none;" name="resetbtn12" id="resetbtn12" value="RESET" type="reset"/>
                                                </div>
                                            </div>
                                            <div class="tabs-contact">
                                                <div class="tab">
                                                    <a class="button1 orange wid" onclick="javascript: $('#submitbtn12').click();">SUBMIT</a>
                                                    <input  style="display:none;" name="submitbtn12" id="submitbtn12" value="SUBMIT"  type="submit"/>
                                                </div>
                                            </div>
                                        </div>
                                    </article>        

                                </div></section>

                        </div>
                    </div>

                </div>
                <div class="clear"></div>
            </div>
        </div>
        <p id="back-top"><a href="#top"><span></span></a> </p>
        <!-- FlexSlider --> 
        <script>
            $(document).ready(function(){

                // hide #back-top first
                $("#back-top").hide();
	
                // fade in #back-top
                $(function () {
                    $(window).scroll(function () {
                        if ($(this).scrollTop() > 100) {
                            $('#back-top').fadeIn();
                        } else {
                            $('#back-top').fadeOut();
                        }
                    });

                    // scroll body to 0px on click
                    $('#back-top a').click(function () {
                        $('body,html').animate({
                            scrollTop: 0
                        }, 800);
                        return false;
                    });
                });

            });
        </script>
        <script defer src="<?php echo base_url() ?>assets/scripts/jquery.flexslider.js"></script> 
        <script type="text/javascript">
            $(function(){
                //SyntaxHighlighter.all();
            });
            $(window).load(function(){
                $('.flexslider').flexslider({
                    animation: "slide",
                    start: function(slider){
                        $('body').removeClass('loading');
                    }
                });
            });
        </script>
    </body>
</html>