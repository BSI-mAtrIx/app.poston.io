<?php // Query User Infomation
    $bck_join = array('package'=>"users.package_id=package.id,left");
    $bck_profile_info = $this->basic->get_data("users",array("where"=>array("users.id"=>$this->session->userdata("user_id"))),"users.*,package_name",$bck_join);
    $bck_add_date= isset($bck_profile_info[0]["add_date"]) ? $bck_profile_info[0]["add_date"] : ""; 
?>

<?php // Subscribers Subscribers Subscribers Subscribers Subscribers Subscribers Subscribers ///////////////////////////////////////////?>

    <?php if ( // Chèn Button cho bot_subscribers VÀ sms_email_manager
                $this->uri->segment(2) == 'bot_subscribers' 
                OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(1) == 'contact_group_list'
                OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(1) == 'contact_list'
                
            ) { ?>
            
    <script>
    $("h1").first().after("<a href='<?php echo base_url('subscriber_manager');?>'><button class='btn btn-primary ml-3' type='button'><i class='fas fa-layer-group'></i> <span><?=$this->lang->line('bca_1041')?></span></button></a>");
    </script>
    
    <?php } ?>
    
    
    
    <?php if ( // Chèn Button cho các trang khác ngoài subscriber_manager VÀ ngoài bot_subscribers
                $this->uri->segment(1) == 'subscriber_manager' && $this->uri->segment(2) !== NULL && $this->uri->segment(2) !== 'bot_subscribers' 
                OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'contact_group_list'
                OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'contact_list'
                OR $this->uri->segment(1) == 'email_optin_form_builder' && $this->uri->segment(2) == NULL
            ) {  ?>
            
    <script>
    $("h1").first().after("<a href='<?php echo base_url('subscriber_manager');?>'><button class='btn btn-primary ml-3' type='button'><i class='fas fa-layer-group'></i> <span><?=$this->lang->line('bca_1041')?></span></button></a>");
    </script>
    
    <?php } ?>
    
    
    
    <?php if ( $this->uri->segment(1) == 'subscriber_manager' && $this->uri->segment(2) == NULL ) {  // Chèn Button cho trang subscriber_manager ?>
    
        <script>
        $("h1").first().after("<a href='<?php echo base_url('subscriber_manager/bot_subscribers');?>'><button class='btn btn-primary ml-3' type='button'><i class='fas fa-user-friends'></i> <span>Subscribers</span></button></a>");
        </script>
    
    <?php } ?>
    
    
    <?php if ( // Inc. Mega Menu -> Subscriber Manager
        $this->uri->segment(2) == 'bot_subscribers' 
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(1) == 'contact_group_list'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(1) == 'contact_list'
        OR $this->uri->segment(1) == 'subscriber_manager' && $this->uri->segment(2) !== NULL && $this->uri->segment(2) !== 'bot_subscribers' 
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'contact_group_list'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'contact_list'
        OR $this->uri->segment(1) == 'email_optin_form_builder' && $this->uri->segment(2) == NULL
        OR $this->uri->segment(1) == 'subscriber_manager' && $this->uri->segment(2) == NULL
        ) { ?>
    
        
            
            <div id="rb_mySidenav" class="rb_sidenav">
              <div class="sidebar-brand" style=" position: absolute; top: 10px; "> <p class="ml-4 mt-2"><img src="<?php echo base_url('assets/img/logo.png');?>" alt="" style="max-width: 70%;max-height: 70px;"></p> </div>
              <hr>
              <center href="#" style=" font-size: 18px; color: #6f6f6f; font-weight: bold; "><i class="menu-icons-size menu-icons-JHudhaSettings" style=" "></i> <span><?php echo $this->lang->line("Subscriber Manager"); ?></span></center>
              <span href="javascript:void(0)" class="rb_closebtn" onclick="rb_closeNav()" style="cursor: pointer;">&times;</span>
              
              <label class="rb_sidenav_label mt-3"><?php echo $this->lang->line("Messenger Subscriber"); ?></label>
              
              <a href="<?php echo base_url("subscriber_manager/bot_subscribers"); ?>" class="rb_ahref"><i class="fas fa-user-circle"></i> <?php echo $this->lang->line("Bot Subscribers"); ?></a>
              
              <a href="<?php echo base_url("subscriber_manager/sync_subscribers"); ?>" class="rb_ahref"><i class="fas fa-sync-alt"></i> <?php echo $this->lang->line("Sync Subscribers"); ?></a>
              
              <a href="<?php echo base_url("subscriber_manager/contact_group"); ?>" class="rb_ahref"><i class="fas fa-tags"></i> <?php echo $this->lang->line("Labels/Tags"); ?></a>
              
              <?php if($this->basic->is_exist("modules",array("id"=>263)) || $this->basic->is_exist("modules",array("id"=>264))) { if($this->session->userdata('user_type') == 'Admin' || count(array_intersect($this->module_access, array('263','264'))) !=0) {  ?>
               
                <label class="rb_sidenav_label mt-3"><?php echo $this->lang->line("SMS/Email Subscriber (External)"); ?></label>
              
                <a href="<?php echo base_url("sms_email_manager/contact_group_list"); ?>" class="rb_ahref"><i class="fas fa-users"></i> <?php echo $this->lang->line("Contact Group"); ?></a>
                
                <a href="<?php echo base_url("sms_email_manager/contact_list"); ?>" class="rb_ahref"><i class="fas fa-book"></i> <?php echo $this->lang->line("Contact Book"); ?></a>
                
                <?php if($this->basic->is_exist("modules",array("id"=>290))) { ?> 
                    <?php if($this->session->userdata('user_type') == 'Admin' || in_array(290,$this->module_access)) {  ?>
                        <a href="<?php echo base_url("email_optin_form_builder"); ?>" class="rb_ahref"><i class="fab fa-get-pocket"></i> <?php echo $this->lang->line("Email Phone Opt-in Form Builder"); ?></a>
                    <?php } ?> 
                <?php } ?>
            
              <?php } } ?>
              
              
              
              
              
              
            </div>
            
            <span class="btn-apps" style="" onclick="rb_openNav()">
                <svg class="btn_apps_svg" style="width: 65px; height: 65px; border-radius: 50% 0px 0% 0%; background: #e2e2e2; padding: 6px 12px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_2_1_" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve"> 
                    <path d="M59.3,42.8l-5.9-3.5l5.6-3.2c1.3-0.5,1.9-1.9,2.1-3.2c0-1.3-0.8-2.7-1.9-3.2l-6.7-4l6.7-3.7c1.3-0.5,1.9-1.9,2.1-3.2  c0-1.3-0.8-2.7-1.9-3.2L34.5,0.7c-1.1-0.8-2.7-0.8-3.7,0L4.4,15.4c-1.1,0.8-1.9,1.9-1.9,3.2c0,1.3,0.8,2.7,1.9,3.2l6.9,3.7l-6.9,4  c-1.1,0.5-1.9,1.9-1.9,3.2c0,1.3,0.8,2.7,1.9,3.2l6.1,3.5l-6.1,3.5c-1.1,0.5-1.9,1.9-1.9,3.2c0,1.3,0.8,2.7,1.9,3.2l26.1,14.1  c0.5,0.3,1.3,0.5,1.9,0.5c0.5,0,1.3-0.3,1.9-0.5l24.8-14.1c1.3-0.5,1.9-1.9,2.1-3.2C61.2,44.7,60.4,43.4,59.3,42.8z M9.7,18.6  L32.7,5.5l21.6,13.1L32.4,30.8L9.7,18.6z M9.7,32.7l7.2-4l13.6,7.5c0.5,0.5,1.3,0.5,1.9,0.5c0,0,0,0,0.3,0c0.8,0,1.3-0.3,1.9-0.8  l12.8-7.2l6.9,4L32.7,45L9.7,32.7z M32.4,58.3L9.7,46l6.4-3.7l14.4,8c0.5,0.3,1.3,0.5,1.9,0.5c0.5,0,1.3-0.3,1.9-0.5l13.9-8l6.1,3.7  L32.4,58.3z" style="&#10;    fill: #607D8B;&#10;"/> 
                </svg>
            </span>
            
            <script>
            function rb_openNav() {
              document.getElementById("rb_mySidenav").style.width = "380px";
            }
            
            function rb_closeNav() {
              document.getElementById("rb_mySidenav").style.width = "0";
            }
            </script>
            
            
            
    <?php } ?>
    

    
    
    
<?php // Messenger_bot Messenger_bot Messenger_bot Messenger_bot Messenger_bot ///////////////////////////////////////////////////////////// ?>


    <?php if ( // Chèn Button cho nhiều trang, ngoại trừ trang chính /Messenger_bot 
        $this->uri->segment(1) == 'messenger_bot' 
            && $this->uri->segment(2) !== NULL 
        
        OR $this->uri->segment(1) == 'messenger_bot_enhancers' 
            && $this->uri->segment(2) !== 'subscriber_broadcast_campaign' 
            && $this->uri->segment(2) !== 'otn_subscriber_broadcast_campaign' 
            && $this->uri->segment(2) !== 'create_subscriber_broadcast_campaign' 
        
        OR $this->uri->segment(1) == 'email_auto_responder_integration' 
        //OR $this->uri->segment(1) == 'ecommerce' 
        OR $this->uri->segment(1) == 'messenger_bot_connectivity'
        OR $this->uri->segment(1) == 'email_auto_responder_integration'
        
        ) { ?>
            <script>
            $("h1").first().after("<a href='<?php echo base_url('messenger_bot');?>''><button class='btn btn-primary ml-3' type='button'><i class='fas fa-layer-group'></i> <span><?=$this->lang->line('bca_1041')?></span></button></a>");
            </script>
    <?php } ?>
    




    <?php if ( $this->uri->segment(1) == 'messenger_bot' && $this->uri->segment(2) == NULL ) {  // Chèn Button cho trang Messenger_bot ?>
        <script>
        $("h1").first().after("<a href='<?php echo base_url('messenger_bot/bot_list');?>'><button class='btn btn-primary ml-3' type='button'><i class='fas fa-cogs'></i> <span><?=$this->lang->line('bca_1042')?></span></button></a>");
        </script>
    <?php } ?>
    
    
    
    <?php if ( // Inc. Mega Menu -> Messenger_bot
        
        $this->uri->segment(1) == 'messenger_bot' && $this->uri->segment(2) == NULL
        
        OR $this->uri->segment(1) == 'messenger_bot' 
            && $this->uri->segment(2) !== NULL 
        
        OR $this->uri->segment(1) == 'messenger_bot_enhancers' 
            && $this->uri->segment(2) !== 'subscriber_broadcast_campaign' 
            && $this->uri->segment(2) !== 'otn_subscriber_broadcast_campaign' 
            && $this->uri->segment(2) !== 'create_subscriber_broadcast_campaign' 
        
        OR $this->uri->segment(1) == 'email_auto_responder_integration' 
        //OR $this->uri->segment(1) == 'ecommerce' 
        OR $this->uri->segment(1) == 'messenger_bot_connectivity'
        OR $this->uri->segment(1) == 'email_auto_responder_integration'
        OR $this->uri->segment(1) == 'custom_field_manager'
        
        
        ) { ?>
            
            <div id="rb_mySidenav" class="rb_sidenav">
              <div class="sidebar-brand" style=" position: absolute; top: 10px; "> <p class="ml-4 mt-2"><img src="<?php echo base_url('assets/img/logo.png');?>" alt="BCheckin" style="max-width: 70%;max-height: 70px; "></p> </div>
              <hr>
              <center href="#" style=" font-size: 18px; color: #6f6f6f; font-weight: bold; "><i class="menu-icons-size menu-icons-JHudhaSettings" style=" "></i> <span><?php echo $this->lang->line("Messenger Bot"); ?></span></center>
              <span href="javascript:void(0)" class="rb_closebtn" onclick="rb_closeNav()" style="cursor: pointer;">&times;</span>
              
              <a href="<?php echo base_url("messenger_bot/bot_list"); ?>" class="rb_ahref"><i class="fas fa-cogs"></i> <?php echo $this->lang->line("Bot Settings"); ?></a>
              
              <a href="<?php echo base_url("messenger_bot/template_manager"); ?>" class="rb_ahref"><i class="fas fa-th-large"></i> <?php echo $this->lang->line("Post-back Manager"); ?></a>
              
              <?php if($this->session->userdata('user_type') == 'Admin' || in_array(275,$this->module_access)) : ?>
                <div class="dropdown">
                    <a data-toggle="dropdown" class="no_hover" href="#" class="rb_ahref"><i class="fas fa-th-large"></i> <?php echo $this->lang->line("OTN Post-back Manager"); ?> <i class="fas fa-chevron-down"></i></a>
                    <div class="rb_dropdown_menu dropdown-menu">
                        <div class="dropdown-title"><?php echo $this->lang->line("Tools"); ?></div>                        
                        <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url("messenger_bot/otn_template_manager"); ?>"><i class="fas fa-check-square"></i> <?php echo $this->lang->line("Manage Templates"); ?></a>
                        <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url("messenger_bot/otn_subscribers"); ?>"><i class="fas fa-eye"></i> <?php echo $this->lang->line("Report"); ?></a>
                    </div>
                </div>    
              <?php endif; ?>
              
              
              
                <div class="dropdown">
                    <a data-toggle="dropdown" class="no_hover" href="#" class="rb_ahref"><i class="fas fa-ring"></i> <?php echo $this->lang->line("Messenger Engagement"); ?> <i class="fas fa-chevron-down"></i></a>
                    <div class="rb_dropdown_menu dropdown-menu">
                        <div class="dropdown-title"><?php echo $this->lang->line("Tools"); ?></div>                        
                        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(213,$this->module_access)) : ?><a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('messenger_bot_enhancers/checkbox_plugin_list'); ?>"><i class="fas fa-check-square"></i> <?php echo $this->lang->line("Checkbox Plugin"); ?></a><?php endif; ?>
                        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(214,$this->module_access)) : ?><a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('messenger_bot_enhancers/send_to_messenger_list'); ?>"><i class="fas fa-paper-plane"></i> <?php echo $this->lang->line("Send to Messenger"); ?></a><?php endif; ?>
                        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(215,$this->module_access)) : ?><a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('messenger_bot_enhancers/mme_link_list'); ?>"><i class="fas fa-link"></i> <?php echo $this->lang->line("m.me Link"); ?></a><?php endif; ?>
                        <?php if($this->session->userdata('user_type') == 'Admin' || in_array(217,$this->module_access)) : ?><a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('messenger_bot_enhancers/customer_chat_plugin_list'); ?>"><i class="fas fa-comments"></i> <?php echo $this->lang->line("Customer Chat Plugin"); ?></a><?php endif; ?>
                      </div>
                </div>
                
              
              
              <?php if($this->session->userdata('user_type') == 'Admin' || in_array(265,$this->module_access)) : ?>
                <div class="dropdown">
                    <a data-toggle="dropdown" class="no_hover" href="#" class="rb_ahref"><i class="fas fa-paper-plane"></i> <?php echo $this->lang->line("Email Auto Responder"); ?> <i class="fas fa-chevron-down"></i></a>
                    <div class="rb_dropdown_menu dropdown-menu" style="width:220px;">
                        <div class="dropdown-title"><?php echo $this->lang->line("Tools"); ?></div>                        
                        <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('email_auto_responder_integration/mailchimp_list'); ?>"><i class="fas fa-check-square"></i> <?php echo $this->lang->line("MailChimp Integration"); ?></a>
                        <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('email_auto_responder_integration/sendinblue_list'); ?>"><i class="fas fa-check-square"></i> <?php echo $this->lang->line("Sendinblue Integration"); ?></a>
                        <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('email_auto_responder_integration/activecampaign_list'); ?>"><i class="fas fa-check-square"></i> <?php echo $this->lang->line("Activecampaign Integration"); ?></a>
                        <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('email_auto_responder_integration/mautic_list'); ?>"><i class="fas fa-check-square"></i> <?php echo $this->lang->line("Mautic Integration"); ?></a>
                        <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('email_auto_responder_integration/acelle_list'); ?>"><i class="fas fa-check-square"></i> <?php echo $this->lang->line("Acelle Integration"); ?></a>
                    </div>
                </div>  
              <?php endif; ?>
              
              
              <a href="<?php echo base_url("messenger_bot/domain_whitelist"); ?>" class="rb_ahref"><i class="fas fa-check-circle"></i> <?php echo $this->lang->line("Whitelisted Domains"); ?></a>
              
              
              <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(257,$this->module_access)) : ?>
                <a href="<?php echo base_url("messenger_bot/saved_templates"); ?>" class="rb_ahref"><i class="fas fa-save"></i> <?php echo $this->lang->line("Saved Templates"); ?></a>
              <?php endif; ?>
              
              
              <?php if($this->basic->is_exist("add_ons",array("project_id"=>31))) if($this->session->userdata('user_type') == 'Admin' || in_array(258,$this->module_access)) : ?>
                <a href="<?php echo base_url("messenger_bot_connectivity/json_api_connector"); ?>" class="rb_ahref"><i class="fas fa-plug"></i> <?php echo $this->lang->line("Json API Connector"); ?></a>
              <?php endif; ?>
              
              
              <?php if($this->basic->is_exist("add_ons",array("project_id"=>31))) if($this->session->userdata('user_type') == 'Admin' || in_array(261,$this->module_access)) : ?>
                <a href="<?php echo base_url("messenger_bot_connectivity/webview_builder_manager"); ?>" class="rb_ahref"><i class="fab fa-wpforms"></i> <?php echo $this->lang->line("Webform Builder"); ?></a>
              <?php endif; ?>
              
              
              <?php if($this->basic->is_exist("add_ons",array("project_id"=>49))) if($this->session->userdata('user_type') == 'Admin' || in_array(292,$this->module_access)) : ?>
                <div class="dropdown">
                    <a data-toggle="dropdown" class="no_hover" href="#" class="rb_ahref"><i class="fab fa-stack-overflow"></i> <?php echo $this->lang->line("User Input Flow & Custom Fields"); ?> <i class="fas fa-chevron-down"></i></a>
                    <div class="rb_dropdown_menu dropdown-menu" style="width: 250px;">
                        <div class="dropdown-title"><?php echo $this->lang->line("Tools"); ?></div>                        
                        <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url("custom_field_manager/campaign_list"); ?>"><i class="fas fa-check-square"></i> <?php echo $this->lang->line("User Input Flow Campaign"); ?></a>
                        <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url("custom_field_manager/custom_field_list"); ?>"><i class="fas fa-check-square"></i> <?php echo $this->lang->line("Custom Fields"); ?></a>
                    </div>
                </div> 
              <?php endif; ?>
              
              
            </div>
            
            
            <span class="btn-apps" style="" onclick="rb_openNav()">
                <svg class="btn_apps_svg" style="width: 65px; height: 65px; border-radius: 50% 0px 0% 0%; background: #e2e2e2; padding: 6px 12px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_2_1_" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve"> 
                    <path d="M59.3,42.8l-5.9-3.5l5.6-3.2c1.3-0.5,1.9-1.9,2.1-3.2c0-1.3-0.8-2.7-1.9-3.2l-6.7-4l6.7-3.7c1.3-0.5,1.9-1.9,2.1-3.2  c0-1.3-0.8-2.7-1.9-3.2L34.5,0.7c-1.1-0.8-2.7-0.8-3.7,0L4.4,15.4c-1.1,0.8-1.9,1.9-1.9,3.2c0,1.3,0.8,2.7,1.9,3.2l6.9,3.7l-6.9,4  c-1.1,0.5-1.9,1.9-1.9,3.2c0,1.3,0.8,2.7,1.9,3.2l6.1,3.5l-6.1,3.5c-1.1,0.5-1.9,1.9-1.9,3.2c0,1.3,0.8,2.7,1.9,3.2l26.1,14.1  c0.5,0.3,1.3,0.5,1.9,0.5c0.5,0,1.3-0.3,1.9-0.5l24.8-14.1c1.3-0.5,1.9-1.9,2.1-3.2C61.2,44.7,60.4,43.4,59.3,42.8z M9.7,18.6  L32.7,5.5l21.6,13.1L32.4,30.8L9.7,18.6z M9.7,32.7l7.2-4l13.6,7.5c0.5,0.5,1.3,0.5,1.9,0.5c0,0,0,0,0.3,0c0.8,0,1.3-0.3,1.9-0.8  l12.8-7.2l6.9,4L32.7,45L9.7,32.7z M32.4,58.3L9.7,46l6.4-3.7l14.4,8c0.5,0.3,1.3,0.5,1.9,0.5c0.5,0,1.3-0.3,1.9-0.5l13.9-8l6.1,3.7  L32.4,58.3z" style="&#10;    fill: #607D8B;&#10;"/> 
                </svg>
            </span>
            
            <script>
            function rb_openNav() {
              document.getElementById("rb_mySidenav").style.width = "380px";
            }
            
            function rb_closeNav() {
              document.getElementById("rb_mySidenav").style.width = "0";
            }
            </script>

    <?php } ?>
    







<?php // Broadcast Broadcast Broadcast Broadcast Broadcast  ///////////////////////////////////////////////////////////// ?>


    <?php if ( // Chèn Button cho nhiều trang, ngoại trừ trang chính /Messenger_bot 
        $this->uri->segment(1) == 'messenger_bot_enhancers' && $this->uri->segment(2) == 'subscriber_broadcast_campaign'
        OR $this->uri->segment(1) == 'messenger_bot_broadcast' && $this->uri->segment(2) == 'otn_subscriber_broadcast_campaign'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'sms_api_lists'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'sms_campaign_lists'
        
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'smtp_config'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'mandrill_api_config'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'sendgrid_api_config'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'mailgun_api_config'
        
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'email_campaign_lists'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'template_lists'
        OR $this->uri->segment(1) == 'sms_email_sequence' && $this->uri->segment(2) == 'template_lists'
        OR $this->uri->segment(1) == 'sms_email_sequence' && $this->uri->segment(2) == 'external_sequence_lists'
        
        
        
        ) { ?>
        
        <script>
        $("h1").first().after("<a href='<?php echo base_url('messenger_bot_broadcast');?>'><button class='btn btn-primary ml-3' type='button'><i class='fas fa-layer-group'></i> <span><?=$this->lang->line('bca_1041')?></span></button></a>");
        </script>
    
    <?php } ?>
    




    <?php if ( $this->uri->segment(1) == 'messenger_bot_broadcast' && $this->uri->segment(2) == NULL ) {  // Chèn Button cho trang Messenger_bot ?>
    <script>
    $("h1").first().after("<a href='<?php echo base_url('messenger_bot_enhancers/subscriber_broadcast_campaign');?>'><button class='btn btn-primary ml-3' type='button'><svg aria-hidden='true' focusable='false' data-prefix='fab' data-icon='facebook-messenger' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class='svg-inline--fa fa-facebook-messenger fa-w-16 fa-2x' style=' width: 15px; '><path fill='currentColor' d='M256.55 8C116.52 8 8 110.34 8 248.57c0 72.3 29.71 134.78 78.07 177.94 8.35 7.51 6.63 11.86 8.05 58.23A19.92 19.92 0 0 0 122 502.31c52.91-23.3 53.59-25.14 62.56-22.7C337.85 521.8 504 423.7 504 248.57 504 110.34 396.59 8 256.55 8zm149.24 185.13l-73 115.57a37.37 37.37 0 0 1-53.91 9.93l-58.08-43.47a15 15 0 0 0-18 0l-78.37 59.44c-10.46 7.93-24.16-4.6-17.11-15.67l73-115.57a37.36 37.36 0 0 1 53.91-9.93l58.06 43.46a15 15 0 0 0 18 0l78.41-59.38c10.44-7.98 24.14 4.54 17.09 15.62z' class=''></path></svg> <span><?=$this->lang->line('bca_1043')?></span></button></a>");
    </script>
    <?php } ?>
    
    
    <?php if ( // Inc. Mega Menu -> BroadCasting messenger_bot_broadcast
        $this->uri->segment(1) == 'messenger_bot_broadcast' && $this->uri->segment(2) == NULL
        OR $this->uri->segment(1) == 'messenger_bot_enhancers' && $this->uri->segment(2) == 'subscriber_broadcast_campaign'
        OR $this->uri->segment(1) == 'messenger_bot_broadcast' && $this->uri->segment(2) == 'otn_subscriber_broadcast_campaign'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'sms_api_lists'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'sms_campaign_lists'
        
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'smtp_config'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'mandrill_api_config'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'sendgrid_api_config'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'mailgun_api_config'
        
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'email_campaign_lists'
        OR $this->uri->segment(1) == 'sms_email_manager' && $this->uri->segment(2) == 'template_lists'
        OR $this->uri->segment(1) == 'sms_email_sequence' && $this->uri->segment(2) == 'template_lists'
        OR $this->uri->segment(1) == 'sms_email_sequence' && $this->uri->segment(2) == 'external_sequence_lists'
    
        ){ ?>
        
            
            <div id="rb_mySidenav" class="rb_sidenav">
              <div class="sidebar-brand" style=" position: absolute; top: 10px; "> <p class="ml-4 mt-2"><img src="<?php echo base_url('assets/img/logo.png');?>" alt="BCheckin" style=" max-width: 70%;max-height: 70px;"></p> </div>
              <hr>
              <center href="#" style=" font-size: 18px; color: #6f6f6f; font-weight: bold; "><i class="menu-icons-size menu-icons-JHudhaSettings" style=" "></i> <span><?php echo $this->lang->line("Broadcasting"); ?></span></center>
              <span href="javascript:void(0)" class="rb_closebtn" onclick="rb_closeNav()" style="cursor: pointer;">&times;</span>
              
              <label class="rb_sidenav_label mt-3"><?php echo $this->lang->line("Messenger Broadcasting"); ?></label>
              
              <?php if(($this->session->userdata("user_type")=="Admin" || in_array(79,$this->module_access)) && strtotime(date("Y-m-d")) <= strtotime("2020-3-15") or 1 == 2 ) { ?>
                <a href="<?php echo base_url("messenger_bot_broadcast/conversation_broadcast_campaign"); ?>" class="rb_ahref"><i class="fas fa-comments"></i> <?php echo $this->lang->line("Conversation Broadcast"); ?></a>
              <?php } ?>
              
              <a href="<?php echo base_url("messenger_bot_enhancers/subscriber_broadcast_campaign"); ?>" class="rb_ahref"><i class="fas fa-users"></i> <?php echo $this->lang->line("Subscriber Broadcast"); ?></a>
              
              <?php if($this->session->userdata("user_type")=="Admin"  || in_array(275,$this->module_access)) : ?>
                <a href="<?php echo base_url("messenger_bot_broadcast/otn_subscriber_broadcast_campaign"); ?>" class="rb_ahref"><i class="fas fa-users"></i> <?php echo $this->lang->line("OTN Subscriber Broadcast"); ?></a>
              <?php endif; ?>
              
              
              <label class="rb_sidenav_label mt-3"><?php echo $this->lang->line("SMS Broadcasting"); ?></label>
              
              <a href="<?php echo base_url("sms_email_manager/sms_api_lists"); ?>" class="rb_ahref"><i class="fas fa-plug"></i> <?php echo $this->lang->line("SMS API Settings"); ?></a>
              
              <a href="<?php echo base_url("sms_email_manager/sms_campaign_lists"); ?>" class="rb_ahref"><i class="fas fa-sms"></i> <?php echo $this->lang->line("SMS Campaign"); ?></a>
              
              <a href="<?php echo base_url("sms_email_sequence/template_lists/sms"); ?>" class="rb_ahref"><i class="fas fa-th-list"></i> <?php echo $this->lang->line("SMS Template"); ?></a>
              
              
              <label class="rb_sidenav_label mt-3"><?php echo $this->lang->line("Email Broadcasting"); ?></label>
              
              <div class="dropdown">
                <a href="#" data-toggle="dropdown" class="no_hover"  class="rb_ahref"><i class="fas fa-plug"></i> <?php echo $this->lang->line("Email API Settings"); ?> <i class="fas fa-chevron-down"></i></a>
                <div class="rb_dropdown_menu dropdown-menu">
                    <div class="dropdown-title"><?php echo $this->lang->line("Tools"); ?></div>                        
                    <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('sms_email_manager/smtp_config'); ?>"><i class="fas fa-plug"></i> <?php echo $this->lang->line("SMTP API"); ?></a>
                    <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('sms_email_manager/mandrill_api_config'); ?>"><i class="fas fa-plug"></i> <?php echo $this->lang->line("Mandrill API"); ?></a>
                    <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('sms_email_manager/sendgrid_api_config'); ?>"><i class="fas fa-plug"></i> <?php echo $this->lang->line("Sendgrid API"); ?></a>
                    <a class="dropdown-item has-icon rb_ahref" href="<?php echo base_url('sms_email_manager/mailgun_api_config'); ?>"><i class="fas fa-plug"></i> <?php echo $this->lang->line("Mailgun API"); ?></a>
                </div>
              </div>
              
              <a href="<?php echo base_url("sms_email_manager/email_campaign_lists"); ?>" class="rb_ahref"><i class="fas fa-envelope"></i> <?php echo $this->lang->line("Email Campaign"); ?></a>
              
              <a href="<?php echo base_url("sms_email_manager/template_lists/email"); ?>" class="rb_ahref"><i class="fas fa-th-list"></i> <?php echo $this->lang->line("Email Templates"); ?></a>
              
              
              <label class="rb_sidenav_label mt-3"><?php echo $this->lang->line("SMS/Email Sequence Campaigner (External Contacts)"); ?></label>
              
              <a href="<?php echo base_url("sms_email_sequence/external_sequence_lists"); ?>" class="rb_ahref"><i class="fas fa-envelope"></i> <?php echo $this->lang->line("Sequence Campaign"); ?></a>
              
              
              
            </div>
            
            <span class="btn-apps" style="" onclick="rb_openNav()">
                <svg class="btn_apps_svg" style="width: 65px; height: 65px; border-radius: 50% 0px 0% 0%; background: #e2e2e2; padding: 6px 12px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_2_1_" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve"> 
                    <path d="M59.3,42.8l-5.9-3.5l5.6-3.2c1.3-0.5,1.9-1.9,2.1-3.2c0-1.3-0.8-2.7-1.9-3.2l-6.7-4l6.7-3.7c1.3-0.5,1.9-1.9,2.1-3.2  c0-1.3-0.8-2.7-1.9-3.2L34.5,0.7c-1.1-0.8-2.7-0.8-3.7,0L4.4,15.4c-1.1,0.8-1.9,1.9-1.9,3.2c0,1.3,0.8,2.7,1.9,3.2l6.9,3.7l-6.9,4  c-1.1,0.5-1.9,1.9-1.9,3.2c0,1.3,0.8,2.7,1.9,3.2l6.1,3.5l-6.1,3.5c-1.1,0.5-1.9,1.9-1.9,3.2c0,1.3,0.8,2.7,1.9,3.2l26.1,14.1  c0.5,0.3,1.3,0.5,1.9,0.5c0.5,0,1.3-0.3,1.9-0.5l24.8-14.1c1.3-0.5,1.9-1.9,2.1-3.2C61.2,44.7,60.4,43.4,59.3,42.8z M9.7,18.6  L32.7,5.5l21.6,13.1L32.4,30.8L9.7,18.6z M9.7,32.7l7.2-4l13.6,7.5c0.5,0.5,1.3,0.5,1.9,0.5c0,0,0,0,0.3,0c0.8,0,1.3-0.3,1.9-0.8  l12.8-7.2l6.9,4L32.7,45L9.7,32.7z M32.4,58.3L9.7,46l6.4-3.7l14.4,8c0.5,0.3,1.3,0.5,1.9,0.5c0.5,0,1.3-0.3,1.9-0.5l13.9-8l6.1,3.7  L32.4,58.3z" style="&#10;    fill: #607D8B;&#10;"/> 
                </svg>
            </span>
            
            <script>
            function rb_openNav() {
              document.getElementById("rb_mySidenav").style.width = "380px";
            }
            
            function rb_closeNav() {
              document.getElementById("rb_mySidenav").style.width = "0";
            }
            </script>    
    
    <?php } ?>
    
  



<?php //  GLOBAL /////////////////////////////////////////////////////////////////////////// ?>

   <style>


   
   .dropdown-item.has-icon i {
    color: #1875bf;
    }
    
    .main-sidebar .sidebar-menu li ul.dropdown-menu li a i {
        color: #1875bf;
    }

    .menu-icons-36b3ee2d91ed { border-radius: 50%; }
   


   /* Global CSS */
    .card.card-large-icons {
        display: flex;
        flex-direction: row;
        border-left: 5px solid #2196F3;
    }
    
    .card.card-large-icons .card-icon { width: 120px !important; }
    
    .text-primary, .text-primary-all *, .text-primary-all *:before, .text-primary-all *:after {
        color: #2196f3 !important;
    }
    
        

    
    .card { box-shadow: 0 4px 8px rgb(0 0 0 / 17%) !important; }
    
    .tab-item { background: #eaeaea !important; border-radius: 5px !important; }
    
    .tab-item.selected { background: white !important;  box-shadow: -2px 0px 8px rgb(0 0 0 / 21%) !important;  border-radius: 5px !important; }
    
    .main-sidebar { box-shadow: 0 4px 8px rgb(0 0 0 / 17%) !important; }
        
    .main-sidebar .sidebar-menu li.active a { color: #575757; font-weight: 600; background-color: rgb(217 217 217 / 23%) !important; box-shadow: inset 0 0 10px rgb(173 173 173 / 46%); -moz-box-shadow: inset 0 0 10px rgb(173 173 173 / 46%); -webkit-box-shadow: inset 0px 0px 10px rgb(173 173 173 / 46%); }
    .main-sidebar .sidebar-menu li.active a:hover { background-color: rgb(217 217 217 / 23%) !important; box-shadow: inset 0 0 10px rgb(173 173 173 / 46%); -moz-box-shadow: inset 0 0 10px rgb(173 173 173 / 46%); -webkit-box-shadow: inset 0px 0px 10px rgb(173 173 173 / 46%); }
    
    
    .main-sidebar .sidebar-menu li a:hover { background-color: #cecece !important; }
    
    .main-sidebar .sidebar-menu li ul.dropdown-menu li a { padding-left: 18px; background: white ; box-shadow: none !important; }
    .main-sidebar .sidebar-menu li ul.dropdown-menu li a:hover { background-color: #cecece !important; color: #343a40 !important ;  padding-left:30px;}
    
    .main-sidebar .sidebar-menu li ul.dropdown-menu li a i { margin-right: 15px !important; }
    
    body.sidebar-mini .main-sidebar .sidebar-menu > li ul.dropdown-menu {  width: 250px; } 
    
    body.sidebar-mini .main-sidebar .sidebar-menu > li > a > i { margin-right: 5px; }
    
    

	  
	  @media only screen and (max-width: 425px) {
        .main-content { padding-left: 5px; padding-right: 5px; }
        .main-footer .footer-right { margin-right: 30px; }
	  }
	  
	  
	  @media (min-width: 768px)
      {
        .main-footer .footer-right { margin-right: 70px; }
      }
      
      .navbar-expand-lg .navbar-nav .dropdown-menu { -webkit-animation: noti 0.5s; animation: noti 0.5s; }
      
      .main-sidebar .sidebar-menu li ul.dropdown-menu li a { color: #545454; }
	  
	  @-webkit-keyframes noti {
          0% {
            opacity: 0;
            margin-top: 100px; }
          80% {
            opacity: 0;
            margin-top: 100px; }
          100% {
            opacity: 1;
            margin-top: 0px; } 
	  }
	  
	  @keyframes noti {
          0% {
            opacity: 0;
            margin-top: 100px; }
          80% {
            opacity: 0;
            margin-top: 100px; }
          100% {
            opacity: 1;
            margin-top: 0px; } 
        }    
    

    /* Left Sidebar | CSS */
            .rb_sidenav_label {
                padding: 3px 15px;
                color: #a1a8ae;
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 1.3px;
                font-weight: 600;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                
            }
            
            .rb_sidenav {
              height: 100%;
              width: 0;
              position: fixed;
              z-index: 999;
              top: 0;
              right: -20px;
              background-color: #fff;
              overflow-x: hidden;
              transition: 0.5s;
              padding-top: 60px;
              box-shadow: rgba(0, 0, 0, 0.18) -10px 0px 8px 1px;
              border-left: 5px solid rgb(205, 205, 205);
            }
            
            .rb_sidenav a {
                padding: 12px 8px 12px 25px;
                text-decoration: none;
                font-size: 15px;
                color: #818181;
                display: block;
                transition: 0.3s;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            .rb_sidenav a:hover {
              color: #2196f3;
              background: #eeeeee;
              padding-left: 30px;
            }
            
            .rb_ahref.rb_sidenav_active {
              background: #eeeeee;
            }
            
            .rb_closebtn {
              position: absolute;
              top: 0;
              right: 45px;
              font-size: 36px;
              margin-left: 50px;
            }
            
            @media screen and (max-height: 450px) {
              .rb_sidenav {padding-top: 15px;}
              .rb_sidenav a {font-size: 18px;}
            }
            
            .btn-apps {
                font-size: 30px; 
                cursor: pointer; 
                position: fixed; 
                bottom: 30px; 
                right: 30px; 
                z-index: 9;
            }
            
            
            .btn-apps::after {
              content: '';
              width: 30px; height: 30px;
              border-radius: 50% 0px 0% 0%;
              border: 6px solid #7f7f7f;
              position: absolute;
              z-index: -1;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
              animation: ring 1.5s infinite;
            }
            
            btn:hover::after, btn:focus::after { animation: none; display: none; }
                
                
            @keyframes ring {
              0% {
                width: 30px;
                height: 30px;
                opacity: 1;
              }
              100% {
                width: 100px;
                height: 100px;
                opacity: 0;
              }
            }
            
            @media (max-width: 450px) {
                .btn_apps_svg { width: 45px !important; height: 45px !important; }
                .btn-apps { bottom: 20px !important; right: 20px !important; }
                @keyframes ring { 0% { width: 30px; height: 30px; opacity: 1; } 100% { width: 70px; height: 70px; opacity: 0; } }
                
            }
            
            #rb_mySidenav > a >i , #rb_mySidenav > div > a >i {
                color: #2196f3;
                margin-right: 10px;
                font-size: 15px;
            }
            #rb_mySidenav > center > span {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            .rb_dropdown_menu.dropdown-menu.show {
                animation: growDown 300ms ease-in-out forwards;
                transform-origin: top right;
                top: 35px !important;
            }
            
            .rb_dropdown_menu { margin-bottom: 3rem; } 
            
            @keyframes growDown {
                0% {
                    transform: scaleY(0)
                }
                80% {
                    transform: scaleY(1.1)
                }
                100% {
                    transform: scaleY(1)
                }
            }

    </style>
    
    <script>
    // Highlight the active link | Right Sidebar
    for (var i = 0; i < document.links.length; i++) {
        if (document.links[i].href == document.URL) {
            document.links[i].className += ' rb_sidenav_active';
            
        }
    }
    </script>