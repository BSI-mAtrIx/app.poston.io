<!-- =========================
           FOOTER
============================== -->
<footer id="footer2-2" class="p-y footer f2 bg-edit bg-dark">
<div class="container">
<div class="row text-white">
<div class="col-sm-4 col-xs-12">
<p>Copyright &#169; <?php echo date("Y"); ?> <?php echo $this->config->item("product_short_name"); ?>. All rights reserved</p>
</div>
<div class="col-sm-4 col-xs-12 text-center">
<ul class="footer-social">
<?php if($this->config->item('facebook') != ''): ?>
<li><a href="<?php echo $this->config->item('facebook'); ?>" target="_blank" class="inverse"><i class="fa fa-facebook"></i></a></li>
<?php endif; ?>
<?php if($this->config->item('twitter') != ''): ?>
<li><a href="<?php echo $this->config->item('twitter'); ?>" target="_blank" class="inverse"><i class="fa fa-twitter"></i></a></li>
<?php endif; ?>
<?php if($this->config->item('youtube') != ''): ?>
<li><a href="<?php echo $this->config->item('youtube'); ?>" target="_blank" class="inverse"><i class="fa fa-youtube"></i></a></li>
<?php endif; ?>
<?php if($this->config->item('linkedin') != ''): ?>
<li><a href="<?php echo $this->config->item('linkedin'); ?>" target="_blank" class="inverse"><i class="fa fa-linkedin"></i></a></li>
<?php endif; ?>
</ul>
</div>
<div class="col-sm-4 col-xs-12">
<ul class="footer-links">
<li><a href="<?php echo base_url('home/privacy_policy'); ?>" title="" class="edit inverse">Privacy Policy</a></li>
<li><a href="<?php echo base_url('home/terms_use'); ?>" title="" class="edit inverse">Terms of use</a></li>
<li><a href="<?php echo base_url('home/gdpr'); ?>" title="" class="edit inverse">GDPR</a></li>
</ul>
</div>
</div>
</div>
</footer>

</div>
