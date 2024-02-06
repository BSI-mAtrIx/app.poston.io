<?php
/*
Theme Name: Yarseo 
Unique Name: Yarseo Theme
Theme URI: https://echatbots.com/theme/yarseo
Author: Yarseo
Author URI: https://yarseo.com
Version: 1.2.0
Description: This is our first release of a XeroChat theme. Looking forward to creating more and improving on this one.
*/
?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<meta http-equiv=X-UA-Compatible content="IE=edge">
<meta name=viewport content="width=device-width, initial-scale=1">
<title><?php echo $this->config->item('product_name'); if($this->config->item('slogan')!='') echo " | ".$this->config->item('slogan')?></title>
<meta name="description" content="<?php echo $this->config->item('slogan'); ?>">
<meta name="author" content="<?php echo $this->config->item('institute_address1');?>">

<?php
	include 'includes/css.php';
?>

</head>
<body data-spy="scroll" data-target="#main-navbar">
<div class="loader bg-white">
<div class="loader-inner ball-scale-ripple-multiple vh-center">
<div></div>
<div></div>
<div></div>
</div>
</div>
<div class="main-container" id="page">

<?php
	include 'includes/nav.php';
?>

<!-- =========================
           HERO SECTION
============================== -->
<section id="hero4" class="p-y-md bg-edit" style="background-image:url('<?php echo xit_load_images('images/polygonal.jpg'); ?>');background-size: cover;background-position: top center;">
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1 text-center p-t-lg">
<h1 class="m-b-md p-t-md">Meet Chat Marketing</h1>
<p class="lead m-b-md f-w-600">Automate & Combine Facebook Messenger and SMS to Grow Your Business</p>
	<?php if(isset($default_package[0])) : ?>
<a href="<?php echo base_url('home/sign_up'); ?>" class="btn btn-md btn-blue text-uppercase"><?php echo $this->lang->line("Free Trial"); ?> <?php echo $default_package[0]["validity"] ?> <?php echo $this->lang->line("Days"); ?></a>
	<?php endif; ?>
<a href="#pricing" class="btn btn-md btn-green text-uppercase smooth-scroll"><?php echo $this->lang->line('Pricing'); ?></a>
</div>
</div>
</div>
<div class="container p-t-lg">
<div class="row">
<div class="col-md-6 col-md-offset-3">
<div id="carousel-dashboard" class="carousel slide carousel-fade carousel-dashboard" data-ride="carousel">
<ol class="carousel-indicators inverse">
<li data-target="#carousel-dashboard" data-slide-to="0" class="active"></li>
<li data-target="#carousel-dashboard" data-slide-to="1"></li>
<li data-target="#carousel-dashboard" data-slide-to="2"></li>
</ol>
<div class="carousel-inner text-center" role="listbox">
<div class="item active">
<h3><i class="fa fa-bar-chart" style="color:#1CA345;"></i> Drive Sales</h3>
<p class="lead">Convert customers with simple, personalized experiences.</p>
</div>
<div class="item">
<h3><i class="fa fa-check-circle" style="color:#0081FF;"></i> Get More Leads</h3>
<p class="lead">With 80% open rates and 25% CTR, Messenger beats every other channel.</p>
</div>
<div class="item">
<h3><i class="fa fa-heart" style="color:#DE3F44;"></i> Engage Prospects</h3>
<p class="lead">Build relationships with customers through interactive and tailored content.</p>
</div>
</div>
<img src="<?php echo xit_load_images('images/Chat-Marketing.png'); ?>" class="img-responsive m-x-auto" alt="Chat Marketing">
</div>
</div>
</div>
</div>
</section>

<!-- =========================
           VIDEO
============================== -->
<?php if($this->config->item('display_video_block') == '1' || $this->config->item('promo_video') != '') : ?>
<section id="hero8" class="hero p-y-lg hero-countdown bg-img" style="background-image:url('<?php echo xit_load_images('images/bg-1.jpg'); ?>')">
<div class="container">
<h2 class="text-center">1.3 Billion People Use Messenger Every Day</h2>
<p class="lead m-b-0 f-w-700 text-center">Learn How To Reach Them</p>
<div class="row m-y-lg">
<div class="col-sm-12 col-md-6 col-md-offset-3 text-center">
<div class="big-popup p-y-lg">
<?php 
	$promo_video_link = $this->config->item('promo_video');
?>
<a class="mp-iframe" href="<?php echo $promo_video_link; ?>"><i class="fa fa-play-circle"></i></a>
</div>
</div>
</div>
</div>
</section>
<?php endif; ?>

<!-- =========================
        FEATURES SECTION 
============================== -->
<section id="features" class="p-y-md content-align-md bg-edit">
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="section-header text-center wow fadeIn" style="visibility:visible;animation-name:fadeIn">
<h2>Powerful business tools in one place</h2>
<p class="lead">Reach existing and potential customer right into their phones.</p>
</div>
</div>
</div>
<div class="row y-middle">
<div class="col-md-4 col-sm-6">
<ul class="features-list features-list-left list-unstyled">
<li class="m-b-lg wow zoomIn" style="visibility:visible;animation-name:zoomIn">
<h5>Messenger Marketing</h5>
<p>2.4B people will use Facebook Messenger next year and it's one of the most popular mobile apps in the world. Make your presence known with <?php echo $this->config->item("product_short_name"); ?>.</p>
</li>
<li class="m-b-lg wow zoomIn" data-wow-delay="0.2s" style="visibility:visible;animation-delay:.2s;animation-name:zoomIn">
<h5>SMS Marketing</h5>
<p>85% of customers prefer to receive a text message over a call or email, and SMS messages have a whopping 98% open rate!</p>
</li>
<li class="m-b-lg wow zoomIn" data-wow-delay="0.4s" style="visibility:visible;animation-delay:.4s;animation-name:zoomIn">
<h5>Email Marketing</h5>
<p>There are 3.9 billion daily email users. This number is expected to climb to 4.3 billion by 2023. Mobile opens account for 46 percent of all email opens!</p>
</li>
</ul>
</div>
<div class="col-md-4 col-md-push-4 col-sm-6">
<ul class="features-list list-unstyled">
<li class="m-b-lg wow zoomIn" style="visibility:visible;animation-name:zoomIn">
<h5>Social Media Marketing</h5>
<p>A combination of paid and organic advertising maybe the difference between failure and success, and our tools we can help you boost organic reach.</p>
</li>
<li class="m-b-lg wow zoomIn" data-wow-delay="0.2s" style="visibility:visible;animation-delay:.2s;animation-name:zoomIn">
<h5>E-Commerce</h5>
<p>You can setup an online store and sell your products. We even integrate with WooCommerce, one of the most popular ecommerce platforms in the world!</p>
</li>
<li class="m-b-lg wow zoomIn" data-wow-delay="0.4s" style="visibility:visible;animation-delay:.4s;animation-name:zoomIn">
<h5>Google Integrations</h5>
<p>You can reach a much broader audiencee with our Google integration. You can share content and get statistics through our powerful dashboard.</p>
</li>
</ul>
</div>
<div class="col-md-4 col-md-pull-4 text-center features-list-img wow slideInUp" style="visibility:visible;animation-name:slideInUp">
<img src="<?php echo xit_load_images('images/All-the-tools.png'); ?>" class="img-responsive m-x-auto" alt="">
</div>
</div>
</div>
</section>

<!-- =========================
          HIGHLIGHTS
============================== -->
<section id="integrations" class="p-y-lg content-block center-md  content-align-md bg-edit bg-light">
<div class="container">
<div class="row y-middle">
<div class="col-md-6 col-md-push-6 p-b-md">
<p class="lead m-b-md">Grow Your Business</p>
<h2 class="m-b-md wow zoomIn" style="visibility:visible;animation-name:zoomIn"><?php echo $this->config->item("product_short_name"); ?> is Built for Sales and Marketing</h2>
<p class="m-b-md">Sell products, book appointments, nurture leads, capture contact info, and build relationships all through Messenger.</p>
<a href="<?php echo base_url('home/sign_up'); ?>" class="btn btn-sm btn-blue text-uppercase">GET STARTED FOR FREE</a>
</div>
<div class="col-md-6 col-md-pull-6 wow slideInUp" style="visibility:visible;animation-name:slideInUp">
<img src="<?php echo xit_load_images('images/integration.png'); ?>" class="img-responsive m-x-auto" alt="">
</div>
</div>
</div>
</section>

<section id="cta5-1" class="p-y-lg content-block content-align-md center-md bg-edit">
<div class="container">
<div class="row y-middle">
<div class="col-md-6 m-b wow zoomIn p-b-md" style="visibility:visible;animation-name:zoomIn">
<p class="lead m-b-md">Works For Your Business</p>
<h2 class="m-b-md wow zoomIn" style="visibility:visible;animation-name:zoomIn">Get More Out of the Tools You Already Use</h2>
<p class="m-b-md">Whether it's Facebook, Google My Business or Twitter, <?php echo $this->config->item("product_short_name"); ?> connects to the marketing tools you already use, and the best part is that it can automatize them for you!</p>
<a href="<?php echo base_url('home/sign_up'); ?>" class="btn btn-sm btn-blue text-uppercase">GET STARTED FOR FREE</a>
</div>
<div class="col-md-6">
<img src="<?php echo xit_load_images('images/social-media-marketing.png'); ?>" class="img-responsive m-x-auto" alt="">
</div>
</div>
</div>
</section>

<!-- =========================
           ABOUT US
============================== -->
<section id="team3-1" class="p-y-md bg-edit">
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="section-header text-center wow fadeIn" style="visibility:visible;animation-name:fadeIn">
<h2>Expand Your <?php echo $this->config->item("product_short_name"); ?> Knowledge</h2>
<p class="lead">Join a community of small business owners who help each other grow.</p>
</div>
</div>
</div>
</div>
<div class="container portfolio-card">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="col-md-6 m-b-md clearfix">
<div class="h caption-5">
<figure><img src="<?php echo xit_load_images('images/join-our-facebook-group.jpg'); ?>" alt="join our facebook group">
<figcaption>
<div class="caption-box vertical-center-abs text-center text-white">
<h5>Join Us</h5>
<p class="lead m-b-md">Join our Facebook group and share ideas and get support from our community.</p>
<a href="https://www.facebook.com/groups/echatbots/" target="_blank" class="btn btn-ghost smooth-scroll text-uppercase">Join Facebook Group</a>
</div>
</figcaption>
</figure>
</div>
</div>
<div class="col-md-6 m-b-md clearfix">
<div class="h caption-5">
<figure><img src="<?php echo xit_load_images('images/visit-our-blog.jpg'); ?>" alt="visit our blog">
<figcaption>
<div class="caption-box vertical-center-abs text-center text-white">
<h5>Learn More</h5>
<p class="lead m-b-md">Find how-tos and learn more about <?php echo $this->config->item("product_short_name"); ?>.</p>
<a href="<?php echo base_url('blog'); ?>" class="btn btn-ghost smooth-scroll text-uppercase">Visit Blog</a>
</div>
</figcaption>
</figure>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- =========================
         TESTIMONIALS
============================== -->
<section id="reviews" class="<?php if($this->config->item('display_review_block') == '0') echo 'hidden';?> p-y-lg bg-edit">
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="m-b-md text-center wow fadeIn" style="visibility:visible;animation-name:fadeIn">
<h2>What Business Owners Say</h2>
<p class="lead">Meet our happy clients and find why <?php echo $this->config->item('product_name');?> is your best option for direct marketing</p>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12 testimonials">
	<?php 
		$customerReview = $this->config->item('customer_review');
		$ct=0;
		foreach($customerReview as $singleReview) : 
		$ct++;
		$original = $singleReview[2];
		$base     = base_url();
		if (substr($original, 0, 4) != 'http') {
		$img = $base.$original;
		} else {
		$img = $original;
		}
	?>
<div class="col-md-4 text-center p-t-md clearfix">
<blockquote class="quote-border">
<figure><img src="<?php echo $img; ?>" alt="" class="img-circle img-thumbnail" width="90" height="90"> </figure>
<p><?php echo $str = $singleReview[3]; ?></p>
<div class="cite text-edit">
<?php echo $singleReview[0]; ?>
<span class="cite-info p-opacity"><?php echo $singleReview[1]; ?></span>
</div>
</blockquote>
</div>
	<?php endforeach;
	?>
</div>
</div>
</div>
</section>

<!-- =========================
         VIDEO REVIEW
============================== -->
<section id="hero8" class="<?php if($this->config->item('display_review_block') == '0') echo 'hidden';?> hero p-y-lg hero-countdown bg-img" style="background-image:url('<?php echo xit_load_images('images/customer-video-review.jpg'); ?>')">
<div class="container">
<h2 class="text-center text-white"><?php echo $this->lang->line('Customer review Video'); ?></h2>
<div class="row m-y-lg">
<div class="<?php if($this->config->item('customer_review_video') == '') echo 'hidden';?> col-sm-12 col-md-6 col-md-offset-3 text-center">
<div class="big-popup p-y-lg">

<?php 
	$customer_review_video = $this->config->item('customer_review_video');
?>

<a class="mp-iframe" href="<?php echo $customer_review_video; ?>"><i class="fa fa-play-circle text-white"></i></a>
</div>
</div>
</div>
</div>
</section>

<!-- =========================
             PRICING
============================== -->
<?php if(!empty($pricing_table_data)) : ?>
<section id="pricing" class="p-y-md">
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="section-header text-center wow fadeIn" style="visibility:visible;animation-name:fadeIn">
<h2>Choose a <?php echo $this->config->item('product_name');?> Plan That's Right for You</h2>
<p class="lead">Get serious about focusing your time</p>
</div>
</div>
</div>
<div class="row pricing-3po">
<?php 
	$i=0;
	foreach($pricing_table_data as $pack) :
	$i++;
?>
<div class="col-md-4">
<div class="info text-center">
<h2 class="m-b-md"><?php echo $pack["package_name"]; ?></h2>
<div class="price text-edit"> <span class="currency"><?php echo $curency_icon; ?></span><?php echo $pack["price"]?><small>/<?php echo $pack["validity"]?> <?php echo $this->lang->line("days"); ?></small></div>
<ul class="details m-b-md m-x text-left">
<?php 
	$module_ids=$pack["module_ids"];
	$monthly_limit=json_decode($pack["monthly_limit"],true);
	$module_names_array=$this->basic->execute_query('SELECT module_name,id FROM modules WHERE FIND_IN_SET(id,"'.$module_ids.'") > 0  ORDER BY module_name ASC');
	foreach ($module_names_array as $row) : 
?>
<li>
<i class="fa fa-check-circle green"></i>
<?php 
	$limit=0;
	$limit=$monthly_limit[$row["id"]];
	if($limit=="0") 
	$limit2="<b>".$this->lang->line("unlimited")."</b>";
	else 
	$limit2=$limit;
	if($row["id"]!="1" && $limit!="0") 
	$limit2="<p>".$limit2."/".$this->lang->line("month")."";
	echo $this->lang->line($row["module_name"]);
	if($row["id"]!="13" && $row["id"]!="14" && $row["id"]!="16") 
	echo " : <b>". $limit2."</b>"."</p>";
	else 
	echo "";
?>
</li>
<?php endforeach; ?>
</ul>
<?php if($this->config->item('enable_signup_form') != '0') : ?>
<a class="btn btn-sm btn-blue text-uppercase" href="<?php echo site_url('home/sign_up'); ?>">Sign Up</a>
<?php endif; ?>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</section>
<?php endif; ?>

<!-- =========================
             FAQ
============================== -->
<section class="p-y-lg faqs schedule bg-light">
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="section-header text-center wow fadeIn" style="visibility:visible;animation-name:fadeIn">
<h2 class="m-b-md">Looking for an Expert?</h2>
<p class="lead m-b-md">Our experts can help you craft your marketing strategy and create killer funnels to grow your business.</p>
<a href="https://track.fiverr.com/visit/?bta=48881&nci=7416" target="_blank" class="btn btn-blue text-edit">FIND AN EXPERT</a>
</div>
</div>
</div>
<div class="row p-t-md c2" id="faq">
<div class="col-md-10 col-md-offset-1">
<h2 class="p-y-md text-center">Frequently Asked Questions</h2>
<div class="panel-group" id="accordion">
<div class="panel panel-default">
<div class="panel-heading">
<p class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">What is a Facebook Messenger bot?</a>
</p>
</div>
<div id="collapse1" class="panel-collapse collapse">
<div class="panel-body">
<p>A bot is a a series of automated conversations that can answer common questions from your customers over Facebook Messenger. This could be to explain what your product or service does, gather information about the customer, deliver helpful content, or nurture them towards a sale.</p>
</div>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading">
<p class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">What can a bot do for my business?</a>
</p>
</div>
<div id="collapse2" class="panel-collapse collapse">
<div class="panel-body">
<p>Our bots allow you to automatically welcome new users, send them content, schedule messages, respond to specific keywords, and much more.</p>
</div>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading">
<p class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Why do I need a Messenger bot?</a>
</p>
</div>
<div id="collapse3" class="panel-collapse collapse">
<div class="panel-body">
<p>Every day it's becoming harder to reach your audience. People open less email and social media is so noisy your organic reach is often less than 10% of your audience. Facebook Messenger bots solve this problem by providing personalized and automated conversations with your customers. It is real-time, interactive, and has 80% open rates.</p>
</div>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading">
<p class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapse4">How do I create a Messenger bot?</a>
</p>
</div>
<div id="collapse4" class="panel-collapse collapse">
<div class="panel-body">
<p>You'll need an existing Facebook Page and administrator rights to manage it. After that click on the "Get Started for Free" button at the top of the page.</p>
<p>While you need a Facebook Page to get started, Your <?php echo $this->config->item("product_short_name"); ?> bot is not restricted to just customers on your Facebook page. Anywhere your customers can click a link - your Website, in an email, on a QR code, etc., you can launch your <?php echo $this->config->item("product_short_name"); ?> bot and start a conversation.</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

<section id="cta1-1" class="p-y-md bg-edit bg-dark text-white">
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2 wow fadeIn animated" style="visibility:visible;animation-name:fadeIn">
<div class="text-center">
<h2 class="m-t f-w-900">Sign up for <?php echo $this->config->item("product_short_name"); ?> today!</h2>
<p class="p-opacity m-b-md">Start building your bot. It's easy, fun and it delivers real results</p>
<a href="<?php echo base_url('home/sign_up'); ?>" class="btn btn-blue text-uppercase">Get started for free!</a>
</div>
</div>
</div>
</div>
</section>

<?php
	include 'includes/footer.php';
	include 'includes/form.php';
	include 'includes/js.php';
?>

<?php $this->load->view("include/fb_px"); ?> 
<?php $this->load->view("include/google_code"); ?> 

</body>
</html>