<!-- =========================
            NAVIGATION 
============================== -->
<header id="home">
<nav class="navbar navbar-fixed-top" id="main-navbar">
<div class="container">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a href="/" class="navbar-brand smooth-scroll"><img src="/assets/img/logo.png" alt="<?php echo $this->config->item('product_name');?>"></a>
</div>
<div class="collapse navbar-collapse" id="navbar-collapse">
<ul class="nav navbar-nav navbar-right">
<li><a href="#home" class="smooth-scroll"><?php echo $this->lang->line('home'); ?></a></li>
<li><a href="#features" class="smooth-scroll"><?php echo $this->lang->line('Features');?></a></li>
<li><a href="#reviews" class="smooth-scroll"><?php echo $this->lang->line("Reviews"); ?></a></li>
<li><a href="#pricing" class="smooth-scroll"><?php echo $this->lang->line('Pricing'); ?></a></li>
<li <?php if($this->config->item('display_video_block') == '0') echo "class='hidden'"; ?>><a href="#tutorial"><?php echo $this->lang->line('Tutorial');?></a></li>
	<?php if ($this->session->userdata('license_type') == 'double')  {?>
<li><a href="<?php echo base_url('blog');?>"><?php echo $this->lang->line('Blog'); ?></a></li>
	<?php } ?>
<li><a href="#faq" class="smooth-scroll">FAQ</a></li>
<li class="<?php if($this->config->item('display_video_block') == '0' && $this->config->item('display_review_block') == '0' ) echo 'background-color: #fff'; elseif($this->config->item('display_video_block') == '0') echo 'background-color: #f5f4f4'; else echo 'background-color: #fff'; ?>"><a href="#contact" data-toggle="modal"><?php echo $this->lang->line('Contact'); ?></a></li>
<li><a href="<?php echo base_url('home/sign_up'); ?>" class="btn-nav btn-red btn-login text-uppercase"><?php echo $this->lang->line('sign up'); ?></a></li>
<li><a href="<?php echo base_url('home/login'); ?>" class="btn-nav btn-green btn-signup text-uppercase"><?php echo $this->lang->line('Login'); ?></a></li>
</ul>
</div>
<?php 
	if($this->session->userdata('mail_sent') == 1) {
	echo "<div class='alert alert-success text-center' id='success-alert'>".$this->lang->line("we have received your email. we will contact you through email as soon as possible")."</div>";
	$this->session->unset_userdata('mail_sent');
	}
?>
</div>
</nav>
</header>
