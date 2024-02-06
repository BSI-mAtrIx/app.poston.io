<div class="container vh-100">
<div class="col-md-6 img-block bg-img" style="background-image:url('<?php echo xit_load_images('images/login-or-signup.jpg'); ?>');min-height: 100%;"></div>
<div class="col-md-5 p-y-md m-x">
<div class="">
        <?php 
          if($this->session->flashdata('login_msg')!='') 
          {
              echo "<div class='alert alert-danger text-center'>"; 
                  echo $this->session->flashdata('login_msg');
              echo "</div>"; 
          }   
          if($this->session->flashdata('reset_success')!='') 
          {
              echo "<div class='alert alert-success text-center'>"; 
                  echo $this->session->flashdata('reset_success');
              echo "</div>"; 
          } 
          if($this->session->userdata('reg_success') != ''){
            echo '<div class="alert alert-success text-center">'.$this->session->userdata("reg_success").'</div>';
            $this->session->unset_userdata('reg_success');
          }    
          if(form_error('username') != '' || form_error('password')!="" ) 
          {
            $form_error="";
            if(form_error('username') != '') $form_error.=form_error('username');
            if(form_error('password') != '') $form_error.=form_error('password');
            echo "<div class='alert alert-danger text-center'>".$form_error."</div>";
           
          } 

          $default_user = $default_pass ="";
          if($this->is_demo=='1'){
            $default_user = "admin@xerochat.com";
            $default_pass="123456";
          }
        ?>
          <form method="POST" action="<?php echo base_url('home/login'); ?>" class="form-white needs-validation" novalidate="">
		  <p class="text-center"><a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/img/logo.png" alt="<?php echo $this->config->item('product_name');?>" width="200"></a></p>
		  <h5 class="text-center"><?php echo $this->lang->line("Login"); ?></h5>
            <div class="form-group">
              <label for="email"><?php echo $this->lang->line("Email"); ?></label>
              <input id="email" type="email" value="<?php echo $default_user ?>" class="form-control" name="username" tabindex="1" required autofocus>
              <!-- <div class="invalid-feedback">
                Please fill in your email
              </div> -->
            </div>

            <div class="form-group">
              <label for="password" class="control-label"><?php echo $this->lang->line("Password"); ?></label>
              <input id="password" type="password"value="<?php echo $default_pass ?>"  class="form-control" name="password" tabindex="2" required>
              <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
             	<div style="float:right" class="m-y">
                  <a href="<?php echo site_url();?>home/forgot_password" class="text-small">
                    <?php echo $this->lang->line("Forgot your password?"); ?>
                  </a>
              </div>
              </div>

              <!-- <div class="invalid-feedback">
                please fill in your password
              </div> -->
            </div>

            <!-- <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                <label class="custom-control-label" for="remember-me">Remember Me</label>
              </div>
            </div> -->

            <div class="form-group">
              <button type="submit" class="btn btn-blue text-uppercase" tabindex="4">
                <?php echo $this->lang->line("login"); ?>
              </button>
            </div>
          </form>
          
          <?php if($this->config->item('enable_signup_form')!='0') : ?>
          <div class="row sm-gutters">
            <div class="col-12 col-sm-12 col-md-12 col-lg-6" style="padding-top: 15px;">
            	<?php echo $google_login_button2=str_replace("ThisIsTheLoginButtonForGoogle",$this->lang->line("Login with Google"), $google_login_button); ?>
             </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6" style="padding-top: 15px;">
            	<?php echo $fb_login_button2=str_replace("ThisIsTheLoginButtonForFacebook",$this->lang->line("Login with Facebook"), $fb_login_button); ?>
            </div>

            <div class="col-md-12">
	             <div class="text-muted text-center">
	            	<br><?php echo $this->lang->line("Do not have an account?"); ?> <a href="<?php echo base_url('home/sign_up'); ?>"><?php echo $this->lang->line("Create one"); ?></a>
	        	</div>
	      	 </div>
          </div>
	      	<?php endif; ?>
</div>
</div>
</div>