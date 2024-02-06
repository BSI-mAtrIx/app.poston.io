<link rel="stylesheet" href="<?php echo base_url("plugins/email_optin_form/css/embeded_code_direct_css.css"); ?>">

<div class="row">
  <div class="col-12 d-flex justify-content-center mt-5">
    <div class="col-12 col-sm-12 col-md-8 col-lg-6">
            <!-- renders form -->
            <?= $form_data ?>
    </div>


  </div>  
</div>

<?php if($is_direct == 1) : ?>
	<script>
		var base_url='<?php echo base_url(); ?>';
		var oppssomethingwrong = '<?php echo $this->lang->line('Oops! Something went wrong.'); ?>';
		var cannotbeempty = '<?php echo $this->lang->line('can not be empty'); ?>';
		var thisfieldcannotbeempty = '<?php echo $this->lang->line('This field can not be empty'); ?>';
		var providevalidemail = '<?php echo $this->lang->line('Please provide an valid email address'); ?>';
		var phonemustbenumeric = '<?php echo $this->lang->line('Phone number must be numeric.'); ?>';
		var checkthecheckbox = '<?php echo $this->lang->line('Please check the checkbox'); ?>';
	</script>
  	<script src="<?php echo base_url("plugins/email_optin_form/js/submit_form.js"); ?>"></script>
<?php endif; ?>