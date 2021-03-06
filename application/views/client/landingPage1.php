<!DOCTYPE html>
<!--[if IEMobile 7]> <html dir="ltr" lang="en-US"class="no-js iem7"> <![endif]-->
<!--[if lt IE 7]> <html dir="ltr" lang="en-US" class="no-js ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html dir="ltr" lang="en-US" class="no-js ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html dir="ltr" lang="en-US" class="no-js ie8 oldie"> <![endif]-->
<!--[if IE 9]>    <html dir="ltr" lang="en-US" class="no-js ie8 oldie"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!-->
<html dir="ltr" lang="en-US" class="no-js">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<title>vAlert - Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="author" content="admin" >

<!-- CSS Style -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>source/assets2/_/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>source/assets2/_/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>source/assets2/_/css/slider.css">

<!-- Font icons -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>source/assets2/_/fonts/css/font-awesome.min.css">

<!-- Google Fonts -->
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

<!-- Javascripts -->
<script type="text/javascript" src="<?php echo base_url();?>source/assets2/_/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>source/assets2/_/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>source/assets2/_/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>source/assets2/_/js/modernizr-2.8.3.min.js"></script>

<!-- jQuery custom -->
<script type="text/javascript">
    $(function(){

      $('.valert-scroll').slimscroll({
        disableFadeOut: true
      });
	   $('.valert-scroll-news').slimscroll({
        disableFadeOut: true
      });

    });
</script>
<script type="text/javascript" src="<?php echo base_url();?>source/assets2/_/js/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>source/assets2/_/js/rs-plugin/js/jquery.themepunch.revolution.js"></script>
<script type="text/javascript">
			jQuery(document).ready(function() {
			
				jQuery('.tp-banner').show().revolution(
				{
					dottedOverlay:"none",
					delay:10000,
					startwidth:1170,
					startheight:700,
					hideThumbs:200,
					
					thumbWidth:100,
					thumbHeight:50,
					thumbAmount:5,
					
					navigationType:"bullet",
					navigationArrows:"solo",
					navigationStyle:"preview1",
					
					touchenabled:"on",
					onHoverStop:"off",
					
					swipe_velocity: 0.7,
					swipe_min_touches: 1,
					swipe_max_touches: 1,
					drag_block_vertical: false,
											
					parallax:"mouse",
					parallaxBgFreeze:"on",
					parallaxLevels:[7,4,3,2,5,4,3,2,1,0],
											
					keyboardNavigation:"off",
					
					navigationHAlign:"center",
					navigationVAlign:"bottom",
					navigationHOffset:0,
					navigationVOffset:20,
			
					soloArrowLeftHalign:"left",
					soloArrowLeftValign:"center",
					soloArrowLeftHOffset:20,
					soloArrowLeftVOffset:0,
			
					soloArrowRightHalign:"right",
					soloArrowRightValign:"center",
					soloArrowRightHOffset:20,
					soloArrowRightVOffset:0,
							
					shadow:0,
					fullWidth:"on",
					fullScreen:"on",
			
					spinner:"spinner4",
					
					stopLoop:"on",
					stopAfterLoops:-1,
					stopAtSlide:-1,
			
					shuffle:"on",
					
					autoHeight:"on",						
					forceFullWidth:"off",						
					
					hideThumbsOnMobile:"off",
					hideNavDelayOnMobile:1500,						
					hideBulletsOnMobile:"off",
					hideArrowsOnMobile:"off",
					hideThumbsUnderResolution:0,
					
					hideSliderAtLimit:0,
					hideCaptionAtLimit:480,
					hideAllCaptionAtLilmit:0,
					startWithSlide:0,
					fullScreenOffsetContainer: ""	
				});
				
			});	//ready
			
		</script>
</head>

<body>

<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

<header>
  <nav class="navbar navbar-default valert-menu">
    <div class="container"> 
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#primary-menu"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        <a class="navbar-brand" href="<?php echo base_url('home');?>"><img src="<?php echo base_url();?>source/assets2/_/img/logo.png"></a> </div>
      <div class="collapse navbar-collapse" id="primary-menu">
        <ul class="nav navbar-nav navbar-right primary-nav">
          <li><a href="<?php echo base_url('home');?>">Home</a></li>
          <li><a href="#">Products</a></li>
          <li><a href="#">Reviews</a></li>
          <li><a href="#">Support</a></li>
          <li><a href="#">Store</a></li>
          <li><a href="<?php echo base_url('login');?>">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<section>
  <div id="slider">
    <div class="tp-banner-container">
      <div class="tp-banner" >
        <ul>
          <!-- SLIDE  -->
          <li data-transition="fade" data-slotamount="5" data-masterspeed="700" > 
            <!-- MAIN IMAGE --> 
            <img src="<?php echo base_url();?>source/assets2/_/img/slider.png" class="img-responsive" alt="slidebg1"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat"> 
            <!-- LAYER NR. 1 -->
            <div class="tp-caption tp-fade fadeout fullscreenvideo"
								data-x="0"
								data-y="0"
								data-speed="1000"
								data-start="1100"
								data-easing="Power4.easeOut"
								data-endspeed="1500"
								data-endeasing="Power4.easeIn"
								data-autoplay="true"                            
								data-autoplayonlyfirsttime="false"
								data-nextslideatend="true"
								data-forceCover="1"
								data-dottedoverlay="twoxtwo"
								data-aspectratio="16:9"
								data-forcerewind="on"
								style="z-index: 1"> </div>
            <!-- LAYER NR. 2 -->
            <div class="tp-caption small_text-2 sfb customout"
								data-x="center"
								data-y="200"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="800"
								data-start="1000"
								data-easing="Power4.easeOut"
								data-endspeed="300"
								data-endeasing="Power1.easeIn"
								data-captionhidden="off"
								style="z-index: 6">YOUR ALLERGIC GOOD DETECTOR</div>
            <!-- LAYER NR. 3 -->
            <div class="tp-caption very_large_text customin customout tp-resizeme"
								data-x="center"
								data-y="235"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="800"
								data-start="1500"                               
								data-easing="Power3.easeInOut"
								data-splitin="chars"
								data-splitout="chars"
								data-elementdelay="0.08"
								data-endelementdelay="0.08"   
								data-endspeed="300"
								data-endeasing="Power1.easeIn"
								data-captionhidden="off"
								style="z-index: 6">VALERT </div>
            <!-- LAYER NR. 4 -->
            <div class="tp-caption small_text sfb customout"
								data-x="center"
								data-y="340"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="800"
								data-start="3500"
								data-easing="Power4.easeOut"
								data-endspeed="300"
								data-endeasing="Power1.easeIn"
								data-captionhidden="off"
								style="z-index: 6">Watch Promo Video </div>
            <!-- LAYER NR. 5 -->
            <div class="tp-caption medium_text sfb customout"
								data-x="center"
								data-y="400"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="800"
								data-start="4000"
								data-easing="Power4.easeOut"
								data-endspeed="300"
								data-endeasing="Power1.easeIn"
								data-captionhidden="on"
								style="z-index: 6"><a href="<?php echo base_url('login/registration');?>" class="s-btn s-btn-1 s-btn-1b">Create New Account</a> <a href="<?php echo base_url('login');?>" class="s-btn s-btn-1 s-btn-1b">Find Out More</a> </div>
          </li>
          <li data-transition="fade" data-slotamount="5" data-masterspeed="700" > 
            <!-- MAIN IMAGE --> 
            <img src="<?php echo base_url();?>source/assets2/_/videos/explore-poster.jpg"  alt="slidebg1"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat"> 
            <!-- LAYER NR. 1 -->
            <div class="tp-caption tp-fade fadeout fullscreenvideo"
								data-x="0"
								data-y="0"
								data-speed="1000"
								data-start="1100"
								data-easing="Power4.easeOut"
								data-endspeed="1500"
								data-endeasing="Power4.easeIn"
								data-autoplay="true"                            
								data-autoplayonlyfirsttime="false"
								data-nextslideatend="true"
								data-forceCover="1"
								data-dottedoverlay="twoxtwo"
								data-aspectratio="16:9"
								data-forcerewind="on"
								style="z-index: 1">
              <video class="video-js vjs-default-skin" muted loop preload="none" autoplay width="100%" height="100%"
									poster='<?php echo base_url();?>source/assets2/_/videos/explore-poster.jpg' data-setup="{}">
                <<?php echo base_url();?>source src='<?php echo base_url();?>source/assets2/_/videos/explore.mp4' type='video/mp4' />
                <<?php echo base_url();?>source src='<?php echo base_url();?>source/assets2/_/videos/explore.webm' type='video/webm' />
              </video>
            </div>
            <!-- LAYER NR. 2 -->
            <div class="tp-caption small_text-2 sfb customout"
								data-x="center"
								data-y="200"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="800"
								data-start="1000"
								data-easing="Power4.easeOut"
								data-endspeed="300"
								data-endeasing="Power1.easeIn"
								data-captionhidden="off"
								style="z-index: 6">YOUR ALLERGIC GOOD DETECTOR</div>
            <!-- LAYER NR. 3 -->
            <div class="tp-caption very_large_text customin customout tp-resizeme"
								data-x="center"
								data-y="235"
								data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="800"
								data-start="1500"                               
								data-easing="Power3.easeInOut"
								data-splitin="chars"
								data-splitout="chars"
								data-elementdelay="0.08"
								data-endelementdelay="0.08"   
								data-endspeed="300"
								data-endeasing="Power1.easeIn"
								data-captionhidden="off"
								style="z-index: 6">VALERT </div>
            <!-- LAYER NR. 4 -->
            <div class="tp-caption small_text sfb customout"
								data-x="center"
								data-y="340"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="800"
								data-start="3500"
								data-easing="Power4.easeOut"
								data-endspeed="300"
								data-endeasing="Power1.easeIn"
								data-captionhidden="off"
								style="z-index: 6">Watch Promo Video </div>
            <!-- LAYER NR. 5 -->
            <div class="tp-caption medium_text sfb customout"
								data-x="center"
								data-y="400"
								data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
								data-speed="800"
								data-start="4000"
								data-easing="Power4.easeOut"
								data-endspeed="300"
								data-endeasing="Power1.easeIn"
								data-captionhidden="on"
								style="z-index: 6"><a href="<?php echo base_url('login/registration');?>" class="s-btn s-btn-1 s-btn-1b">CREATE NEW ACCOUNT</a> <a href="#" class="s-btn s-btn-1 s-btn-1b">FIND OUT MORE</a> </div>
          </li>
        </ul>
        <div class="tp-bannertimer tp-bottom"></div>
      </div>
    </div>
  </div>
</section>
<section class="three-areas">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 products">
        <h2>Products <a href="#" class="text-right">All Products</a></h2>
        <div class="clearfix"></div>
        <ul class="valert-scroll">
          <li>
            <div class="product-container">
              <figure class="pull-left"> <img class="img-responsive" alt="img-holder" src="<?php echo base_url();?>source/assets2/_/img/watch.png"> </figure>
              <div class="pull-right">
                <h3>VTAG - Watch</h3>
                <p>Maecenas semper massa tellus, ac rutrum sem pulvinar quis. Morbi ac facilisis massa. </p>
                <a href="#">Read More</a> </div>
              <div class="clearfix"></div>
            </div>
          </li>
          <li>
            <div class="product-container">
              <figure class="pull-left"> <img class="img-responsive" alt="img-holder" src="<?php echo base_url();?>source/assets2/_/img/vtag.jpg"> </figure>
              <div class="pull-right">
                <h3>VTAG - Tag</h3>
                <p>Maecenas semper massa tellus, ac rutrum sem pulvinar quis. Morbi ac facilisis massa. </p>
                <a href="#">Read More</a> </div>
              <div class="clearfix"></div>
            </div>
          </li>
          <li>
            <div class="product-container">
              <figure class="pull-left"> <img class="img-responsive" alt="img-holder" src="<?php echo base_url();?>source/assets2/_/img/pendant.png"> </figure>
              <div class="pull-right">
                <h3>VTAG - Pendant</h3>
                <p>Maecenas semper massa tellus, ac rutrum sem pulvinar quis. Morbi ac facilisis massa. </p>
                <a href="#">Read More</a> </div>
              <div class="clearfix"></div>
            </div>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 box-videos">
        <ul>
          <li>
            <div class="box-video">
             <iframe width="360" height="270" src="https://www.youtube.com/embed/PXxZlcrGFP0" frameborder="0" allowfullscreen></iframe>
             </div>
          </li>
          <li>
            <div class="box-video">
            <iframe width="360" height="203" src="https://www.youtube.com/embed/AKVjKC3u9hk" frameborder="0" allowfullscreen></iframe>
            </div>
          </li>
        </ul>
      </div>
      <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 news">
        <h2>News <a href="#" class="text-right">News Archive</a></h2>
        <div class="clearfix"></div>
        <ul class="valert-scroll-news">
          <li>
            <div class="news-container"> <small>2015-04-02</small>
              <h3>Food Allergies: What You Need to Know</h3>
              <p>Each year, millions of Americans have allergic reactions to food. Although most food allergies cause relatively mild and minor symptoms,some food allergies can cause severe reactions, and may even be life-threatening...</p>
              <a target="_blank" href="http://www.fda.gov/Food/IngredientsPackagingLabeling/FoodAllergens/ucm079311.htm">Read More</a> </div>
          </li>
          <li>
            <div class="news-container"> <small>2015-04-02</small>
              <h3>Food allergy or intolerance? A blood test can tell</h3>
              <p>AUSTIN (KXAN) — Some 15 million Americans suffer from food allergies. They can cause severe swelling, anaphylaxis that can close your windpipe and even death. But many folks who think they have food allergies don’t; It may be a more manageable food intolerance. One in four of us have food intolerance but never realize it. A simple blood test can find out...</p>
              <a target="_blank" href="http://kxan.com/2015/04/05/food-allergy-or-intolerance-a-blood-test-can-tell/">Read More</a> </div>
          </li>
          <li>
            <div class="news-container"> <small>2015-04-02</small>
              <h3>A New Blood Test Can Estimate How Serious Your Food Allergy Is</h3>
              <p>A blood test may make diagnosing allergy severity a little less invasive.A blood test can reveal just how severe a person’s food allergy is and could possibly replace more invasive testing, a new study published Wednesday morning suggests...</p>
              <a target="_blank" href="http://time.com/3765551/food-allergy-blood-test/">Read More</a> </div>
          </li>
          <li>
            <div class="news-container"> <small>2015-04-02</small>
              <h3>Allergy desensitization program in KC to add 5 more foods after success of peanut desensitization</h3>
              <p>OVERLAND PARK, Kan. - People with food allergies will soon have new food treatment options in the Kansas City area after six patients became desensitized to their peanut allergy...</p>
              <a target="_blank" href="http://www.kshb.com/news/local-news/allergy-desensitization-program-in-kc-adding-five-more-foods-after-success-of-peanut-desensitization">Read More</a> </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="features">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center feature-title">
        <h2>Valert provides secure, customized retirement investing</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="ftitle-holder text-center"> <img src="<?php echo base_url();?>source/assets2/_/img/school-icon.png">
          <h3>School</h3>
        </div>
        <div class="fdesc">
          <p>Maecenas semper massa tellus, ac rutrum sem pulvinar quis. Morbi ac facilisis massa. Donec finibus diam ipsum, ut maximus lectus .</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="ftitle-holder text-center"> <img src="<?php echo base_url();?>source/assets2/_/img/restaurant-icon.png">
          <h3>Restaurant</h3>
        </div>
        <div class="fdesc">
          <p>Maecenas semper massa tellus, ac rutrum sem pulvinar quis. Morbi ac facilisis massa. Donec finibus diam ipsum, ut maximus lectus .</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="ftitle-holder text-center"> <img src="<?php echo base_url();?>source/assets2/_/img/camp-icon.png">
          <h3>Camp</h3>
        </div>
        <div class="fdesc">
          <p>Maecenas semper massa tellus, ac rutrum sem pulvinar quis. Morbi ac facilisis massa. Donec finibus diam ipsum, ut maximus lectus .</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="ftitle-holder text-center"> <img src="<?php echo base_url();?>source/assets2/_/img/workplace-icon.png">
          <h3>Workplace</h3>
        </div>
        <div class="fdesc">
          <p>Maecenas semper massa tellus, ac rutrum sem pulvinar quis. Morbi ac facilisis massa. Donec finibus diam ipsum, ut maximus lectus .</p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="footer">
  <div class="container">
    <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 text-center hidden-lg hidden-md hidden-xs visible-sm">
      <button class="valert-btn valert-btn-1 valert-btn-1b">Create New Account</button>
      <p class="app"> <a href="#"><img src="<?php echo base_url();?>source/assets2/_/img/google-play.png"></a> <a href="#"><img src="<?php echo base_url();?>source/assets2/_/img/app-store.png"></a> </p>
      <p class="social"> <a href="#"><i class="fa fa-facebook-f"></i></a> <a href="#"><i class="fa fa-google-plus"></i></a> <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-rss"></i></a> </p>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
      <h4>Infographics</h4>
      <ul>
        <li><a href="#">How we're different</a></li>
        <li><a href="#">Our Portfolio</a></li>
        <li><a href="#">Tax-Efficient Investing</a></li>
        <li><a href="#">Security</a></li>
        <li><a href="#">Team of Experts</a></li>
        <li><a href="#">Story</a></li>
      </ul>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
      <h4>About</h4>
      <ul>
        <li><a href="#">How we're different</a></li>
        <li><a href="#">Our Portfolio</a></li>
        <li><a href="#">Tax-Efficient Investing</a></li>
        <li><a href="#">Security</a></li>
        <li><a href="#">Team of Experts</a></li>
        <li><a href="#">Story</a></li>
      </ul>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
      <h4>News</h4>
      <ul>
        <li><a href="#">How we're different</a></li>
        <li><a href="#">Our Portfolio</a></li>
        <li><a href="#">Tax-Efficient Investing</a></li>
        <li><a href="#">Security</a></li>
        <li><a href="#">Team of Experts</a></li>
        <li><a href="#">Story</a></li>
      </ul>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
      <h4>Jobs &amp; Contact</h4>
      <ul>
        <li><a href="#">How we're different</a></li>
        <li><a href="#">Our Portfolio</a></li>
        <li><a href="#">Tax-Efficient Investing</a></li>
        <li><a href="#">Security</a></li>
        <li><a href="#">Team of Experts</a></li>
        <li><a href="#">Story</a></li>
      </ul>
    </div>
    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 text-center hidden-sm hidden-xs ">
      <a href="<?php echo base_url('login/registration');?>" class="valert-btn valert-btn-1 valert-btn-1b">Create New Account</a>
      <p class="app"> <a href="#"><img src="<?php echo base_url();?>source/assets2/_/img/google-play.png"></a> <a href="#"><img src="<?php echo base_url();?>source/assets2/_/img/app-store.png"></a> </p>
      <p class="social"> <a href="#"><i class="fa fa-facebook-f"></i></a> <a href="#"><i class="fa fa-google-plus"></i></a> <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-rss"></i></a> </p>
    </div>
  </div>
</section>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
        <p>Select:</p>
      </div>
      <div class="col-lg-10 col-md-8 col-sm-6 col-xs-12 text-center">
        <p><a href="#">FAQ</a> | <a href="#">Privacy Policy</a> | <a href="#">Terms and Conditions</a></p>
      </div>
    </div>
  </div>
</footer>
</body>
</html>
