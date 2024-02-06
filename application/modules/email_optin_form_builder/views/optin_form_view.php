<?php $this->load->view("include/upload_js"); ?>
<style>
	.form-wrap.form-builder .frmb .checkbox-group-field .field-label,.form-wrap.form-builder .frmb .checkbox-group-field .field-actions .copy-button,.form-wrap.form-builder .frmb .field-options .option-actions a.add,.text-field .form-group.name-wrap,.checkbox-group-field .form-group.name-wrap,.text-field .form-group.subtype-wrap,.paragraph-field .form-group.subtype-wrap,.maxlength-wrap {display: none !important;}
	.clear-all,.save-template {padding: .55rem 1.5rem;font-size: 12px;width:50%;}
	.form-wrap.form-builder .cb-wrap.pull-left .form-actions { width:100%; }
	.form-wrap.form-builder .stage-wrap{padding:0 15px;border: 1px dashed #ccc;background-color: rgba(255,255,255,0.25);}
	.ajax-upload-dragdrop {border: dashed 1px #c1c1c1;}
</style>

<section class="section section_custom">
	<div class="section-header">
		<h1><i class="fas fa-plus-circle"></i> <?php echo $this->lang->line("Create Email Phone Opt-in Form"); ?></h1>
		
		<div class="section-header-breadcrumb">
		  <div class="breadcrumb-item active"><a href="<?php echo base_url('subscriber_manager'); ?>"><?php echo $this->lang->line("Subscriber Manager"); ?></a></div>
		  <div class="breadcrumb-item active"><a href="<?php echo base_url('email_optin_form_builder'); ?>"><?php echo $this->lang->line("Email Phone Opt-in Form Builder"); ?></a></div>
		  <div class="breadcrumb-item"><?php echo $page_title; ?></div>
		</div>
	</div>
	<div class="section-body">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo $this->lang->line("Form Name"); ?> <span class="red">*</span></label>&nbsp;<a href="#" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('This is actually form name for identify in our system') ?>"><i class="fa fa-info-circle"></i></a>
							<input id="form-name" type="text" name="form-name" class="form-control">
						</div>
					</div>
					<!-- Contact group custom  -->
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo $this->lang->line("Contact Group"); ?> <span class="red">*</span>
								<a href="#" data-placement="top"  data-toggle="tooltip" data-original-title="<?php echo $this->lang->line("Select Contact groups so that new subscribers through this form will be assigned at these groups."); ?>"><i class='fa fa-info-circle'></i> </a>
							</label>
							<small class="blue float-right pointer" id="create_contact_group"><i class="fas fa-plus-circle"></i> <?php echo $this->lang->line('Create Group'); ?></small>
							<select name="contact_group[]" id="contact_group" class="form-control select2" multiple=""  >
								<?php foreach ($contact_group_lists as $key => $value) {
									echo '<option value="'.$key.'">'.$value.'</option>';
								} ?>
							</select>
						</div>
					</div>

					<!-- Emai sequence needs to code with php. pending -->
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo $this->lang->line("Email Sequence"); ?>
								<a href="#" data-placement="top"  data-toggle="tooltip" data-original-title="<?php echo $this->lang->line("If you select email sequence, then your new subscribers will be assigned to this sequence campaign and system will send emails to those subscribers email address according this email sequence campaign settings."); ?>"><i class='fa fa-info-circle'></i> </a>
							</label>
							<select name="sequence_email_campaign_id" id="sequence_email_campaign_id" class="form-control select2">
								<option value=""><?php echo $this->lang->line('Select Email Sequence'); ?></option>
								<?php foreach ($sequence_email_campaign_lists as $value2) {
									echo '<option value="'.$value2['id'].'">'.$value2['campaign_name'].' ['.$value2['campaign_type']. ']</option>';
								} ?>
							</select>
						</div>
					</div>
					<!-- Sms sequence needs to code with php. pending -->
					
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo $this->lang->line("SMS Sequence"); ?>
								<a href="#" data-placement="top"  data-toggle="tooltip" data-original-title="<?php echo $this->lang->line("If you select SMS sequence, then your new subscribers will be assigned to this sequence campaign and system will send SMS to those subscribers phone number according this SMS sequence campaign settings."); ?>"><i class='fa fa-info-circle'></i> </a>
							</label>
							<select name="sequence_sms_campaign_id" id="sequence_sms_campaign_id" class="form-control">
								<option value=""><?php echo $this->lang->line('Select SMS Sequence'); ?></option>
								<?php foreach ($sequence_sms_campaign_lists as $value3) {
									echo '<option value="'.$value3['id'].'">'.$value3['campaign_name'].' ['.$value3['campaign_type']. ']</option>';
								} ?>
							</select>
						</div>
					</div>
					<!-- Position of EMail Optin Form  needs to code with php. pending -->
					<div class="col-md-6">
						<div class="form-group">
							<label><?php echo $this->lang->line("Form Display Type"); ?> <span class="red">*</span>
								<a href="#" data-placement="top"  data-toggle="tooltip" data-original-title="<?php echo $this->lang->line("Form Display Type refers where do you want to make form visible in your website."); ?>"><i class='fa fa-info-circle'></i> </a>
							</label>
							<select name="form_position" id="form_position" class="form-control select2">
								<option value=""><?php echo $this->lang->line('Select Display Type'); ?></option>
								<option value="popup"><?php echo $this->lang->line('Pop-up'); ?></option>
								<option value="fixed"><?php echo $this->lang->line('Fixed'); ?></option>
								<option value="direct"><?php echo $this->lang->line('Direct URL'); ?></option>
							</select>
						</div>
					</div>

					<div class="col-12 col-md-6" id="popupType">
						<div class="form-group">
							<label><?php echo $this->lang->line('Pop-up Position'); ?> <span class="red">*</span>
								<a href="#" data-placement="top"  data-toggle="tooltip" data-original-title="<?php echo $this->lang->line("Pop-up Position refers where do you want to make form Poped up in your website."); ?>"><i class='fa fa-info-circle'></i> </a>
							</label>
							<select name="popup_type" id="popup_type" class="form-control select2">
								<option value=""><?php echo $this->lang->line('Select Pop-up Type'); ?></option>
								<option value="right"><?php echo $this->lang->line('Bottom-right'); ?></option>
								<option value="center"><?php echo $this->lang->line('Center'); ?></option>
							</select>
						</div>
					</div>

					<!-- interval time custom -->
					<div class="col-12 col-md-6" id="interval_time">
						<div class="form-group">
							<label><?php echo $this->lang->line('Pop-up Delay (second)'); ?>
								<a href="#" data-placement="top"  data-toggle="tooltip" data-original-title="<?php echo $this->lang->line("Pop-up delay refers to after how much time your form will be visible and it will work as second, for example, if you put 1 in the field then the form will be visible after 1 second. At initial stage of the form, this field won't be shown. Time interval is required for Bottom-right and Center position."); ?>"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input id="interval_time_input" type="text" name="interval_time" class="form-control">
						</div>
					</div>

					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="mb-3"><?php echo $this->lang->line('Response After Submission'); ?> <span class="red">*</span>
								<a href="#" data-placement="top"  data-toggle="tooltip" data-original-title="<?php echo $this->lang->line("Choose an option to make an event after successfull form submission."); ?>"><i class='fa fa-info-circle'></i> </a>
							</label><br>
							  <div class="custom-control custom-radio custom-control-inline">
								<input type="radio" name="response_type" value="success_message_type" id="success_message_type" class="custom-control-input radio_button">
								<label class="custom-control-label" for="success_message_type"><?php echo $this->lang->line("Set Success Message") ?></label>
							  </div>
							  <div class="custom-control custom-radio custom-control-inline">
								<input type="radio" name="response_type" value="redirect_url_type" id="redirect_url_type" class="custom-control-input radio_button">
								<label class="custom-control-label" for="redirect_url_type"><?php echo $this->lang->line("Set Redirect URL") ?></label>
							  </div>
						</div>
					</div>

					<!-- upload image code for background image -->
					<div class="col-12 col-md-6">
					    <div class="form-group mb-0">
					        <label><?php echo $this->lang->line('Background Image'); ?> <?php echo $this->lang->line('(Max 1MB)');?>
					            <a href="#" data-placement="top"  data-toggle="tooltip" data-original-title="<?php echo $this->lang->line("You can set a background image for your form which will be used as form background. Allowed files are .png, .jpg,.jpeg"); ?>"><i class='fa fa-info-circle'></i> </a>

					        </label>
					        <div id="uploademail_attachment" class="pointer"><?php echo $this->lang->line('Upload'); ?></div>
					    </div>
					</div>

					<div class="col-12 col-md-6" id="success_message_div" style="display: none;">
						<div class="form-group mb-0">
							<label><?php echo $this->lang->line('Success Message'); ?> <span class="red">*</span>
								<a href="#" data-placement="top"  data-toggle="popover" title="<?php echo $this->lang->line("Message"); ?>" data-content="<?php echo $this->lang->line("Set a Success Message, so system will show this message after successfull form submission."); ?>"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input type="text" name="success_message" id="success_message" class="form-control">
						</div>
					</div>
					<div class="col-12 col-md-6" id="redirect_url_div" style="display: none;">
						<div class="form-group mb-0">
							<label><?php echo $this->lang->line('Redirect URL'); ?> <span class="red">*</span>
								<a href="#" data-placement="top"  data-toggle="popover" title="<?php echo $this->lang->line("Redirect URL"); ?>" data-content="<?php echo $this->lang->line("Set Redirect URL, so that system will redirect to that URL after successfull form submission."); ?>"><i class='fa fa-info-circle'></i> </a>
							</label>
							<input type="text" name="redirect_url" id="redirect_url" class="form-control">
						</div>
					</div>

					<div class="col-12 col-md-6">
						<div class="form-group">
						  <label for=""><i class="fas fa-ankh"></i> <?php echo $this->lang->line('Enable Country Code for Phone');?></label><br>
						  <label class="custom-switch mt-2">
						    <input type="checkbox" name="enable_country_code" id="enable_country_code" value="1" class="custom-switch-input">
						    <span class="custom-switch-indicator"></span>
						    <span class="custom-switch-description"><?php echo $this->lang->line('Enable');?></span>
						    <span class="red"><?php echo form_error('enable_country_code'); ?></span>
						  </label>
						</div>
					</div>
					<div class="col-12 col-md-6" id="country_code_lists" style="display: none;">
						<div class="form-group">
							<label><?php echo $this->lang->line('Country Code'); ?>
								<a href="#" data-placement="top"  data-toggle="tooltip" data-original-title="<?php echo $this->lang->line("Choose a country code from the list and phone number will be inserted with that country code. User can also select country code during filling the phone number field."); ?>"><i class='fa fa-info-circle'></i> </a>
							</label>
							<select name="country_code_for_phone" id="country_code_for_phone" class="form-control select2" style="width:100%;">
								<option value=""><?php echo $this->lang->line('Default Country Code'); ?></option>
								<?php 
									foreach ($formatted_country_codes as $key => $value) {
										echo "<option value={$key}>{$value}</option>";
									}
								?>
							</select>
						</div>
					</div>

					<div class="col-12 col-md-6">
						<div class="form-group">
						  <label for=""><i class="fas fa-check-double"></i> <?php echo $this->lang->line('Double Opt-in for email');?>
						  <a href="#" data-placement="top"  data-toggle="tooltip" data-original-title="<?php echo $this->lang->line("If you enable double opt-in for email subscription, system will send a confirmation email to the submitted email address. By default system subscribe the subscriber directly."); ?>"><i class='fa fa-info-circle'></i> </a>
							</label><br>
						  <label class="custom-switch mt-2">
						    <input type="checkbox" name="is_double_optin" id="is_double_optin" value="1" class="custom-switch-input">
						    <span class="custom-switch-indicator"></span>
						    <span class="custom-switch-description"><?php echo $this->lang->line('Enable');?></span>
						    <span class="red"><?php echo form_error('is_double_optin'); ?></span>
						  </label>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div id="optin-form-builder"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style>
		/* #optin-form-builder {
			background-image:url('<?php //echo base_url("assets/builder_image/2.jpg") ?>');
		} */
		
	</style>
</section>

<script src="<?= base_url('plugins/formbuilder/form-builder.min.js') ?>"></script>
<script>
	var interval_time  = $('#interval_time');
	var popuptype  = $('#popupType');

	$(document).ready(function() {

		var contact_group = $('#contact_group')
		$(contact_group).select2({
			width: '100%',
		})
		var select_sequence_email_campaign_id = $('#sequence_email_campaign_id')
		$(select_sequence_email_campaign_id).select2({
			width: '100%',
		})
		var select_sequence_sms_campaign_id = $('#sequence_sms_campaign_id')
		$(select_sequence_sms_campaign_id).select2({
			width: '100%',
		})
		var select_form_position = $('#form_position')
		$(select_form_position).select2({
			width: '100%',
		});
		var popup_type = $('#popup_type')
		$(popup_type).select2({
			width: '100%',
		});


		$(document).on('change','input[name=enable_country_code]',function(){    
			if($("input[name=enable_country_code]:checked").val()=="1") {
				$("#country_code_lists").show();
			} else {

				$("#country_code_lists").hide();
				
			}
		});


		$(document).on('change','input[name=response_type]',function(){    
			if($("input[name=response_type]:checked").val()=="success_message_type") {
				$("#success_message_div").show();
				$("#redirect_url_div").hide();
			} else {

				$("#success_message_div").hide();
				$("#redirect_url_div").show();
				
			}
		});

		// create an new group and put inside group list
		$(document).on('click','#create_contact_group',function(e){
		  e.preventDefault();

		  swal("<?php echo $this->lang->line('Group Name'); ?>", {
		    content: "input",
		    button: {text: "<?php echo $this->lang->line('New Group'); ?>"},
		  })
		  .then((value) => {
		    var group_name = `${value}`;
		    if(group_name!="" && group_name!='null')
		    {
		      $("#save_changes").addClass("btn-progress");
		      $.ajax({
		        context: this,
		        type:'POST',
		        dataType:'JSON',
		        url:"<?php echo site_url();?>email_optin_form_builder/add_contact_group_action",
		        data:{group_name:group_name},
		        success:function(response){

		           $("#save_changes").removeClass("btn-progress");

		           if(response.error) {
		              var span = document.createElement("span");
		              span.innerHTML = response.error;

		              swal({
		                icon: 'error',
		                title: '<?php echo $this->lang->line('Error'); ?>',
		                content:span,
		              });

		           } else {
		              var newOption = new Option(response.text, response.id, true, true);
		              $('#contact_group').append(newOption).trigger('change');
		            }
		        }
		      });
		    }
		  });

		});
		

	   	$("#uploademail_attachment").uploadFile({
			url:'<?php echo base_url("email_optin_form_builder/ajax_attachment_upload")?>',
			fileName:"file",
			maxFileSize:1*1024*1024,
			showPreview:false,
			returnType: "json",
			dragDrop: true,
			showDelete: true,
			multiple:false,
			acceptFiles:".png,.jpg,.jpeg",
			maxFileCount:1,
			deleteCallback: function (data, pd) {
				var delete_url="<?php echo site_url('email_optin_form_builder/delete_attachment');?>";
			    for (var i = 0; i < data.length; i++) {
			        $.post(delete_url, {op: "delete",name: data[i]},
			            function (resp,textStatus, jqXHR) {                
			            });
			    }
		  	}
		});

		// Hides select boxes primarily
		
		$(interval_time).hide()
		$(popuptype).hide()

		// For interval time code . custom for hidden 
		$(document).on('change', '#form_position', function(){
			var formPosition= $('#form_position').val() 
			$(interval_time).hide()

			if(formPosition == "popup") {
				$(interval_time).show()
				$(popuptype).show();
			} else {
				$(interval_time).hide()
				$(popupType).hide();
			}

		})


	    var options = {
			// Makes fields to be used for one time only
			allowOneTimeFields: ['button'],

			// Decides whether controls should be draggable or not
			draggableControls: true,

			// Disables action button
			disabledActionButtons: ['data'], // save, data, clear

			disabledSubtypes: {text: ['color','password'],},
			
			// set control position on left side
			controlPosition: 'left',
			disableFields: ['autocomplete','textarea','radio-group','checkbox-group','date','time','number','hidden',,'text','select','button','file'],
			 fields : [
			 {
			 	class: "form-control",
			 	label: 'Agreement Text',
			 	name: "agreement_text",
			  	type: "paragraph",
			  	subtype: 'output',
			 	icon: '☑'
			 },
			 {
			 	class: "form-control",
			 	label: 'Phone number',
			 	placeholder: "Enter your Phone number",
			 	name: "phone_number",
			  	required: true,
			  	type: "text",
			  	subtype:'tel',
			 	icon: '📋'
			 },
			 {
			 	label: "Email",
			 	placeholder: "Enter your Email",
			 	type: "text",
			 	name: "email",
			 	required: true,
			 	subtype: "email",
			 	icon: "✉"
			 },	
			{
				class: "form-control",
				label: 'Last Name',
				placeholder: "Enter your Last name",
				name: "last_name",
			 	required: true,
			 	type: "text",
				icon: '📋'
			},
			 {
			 	class: "form-control",
			 	label: "First Name",
			 	placeholder: "Enter your first name",
			 	name: "first_name",
			 	required: true,
			 	type: "text",
				icon: '📰'
			},
			{
				class: "form-control",
				label: 'Subscribe button',
				name: "button",
				style:"primary",
			 	type: "button",
				icon: '💬'
			}

			],

			// Default Form when page is load
			defaultFields: [{
				className: "form-control",
			 	label: "First Name",
			 	placeholder: "Enter your first name",
			 	name: "first_name",
			 	required: true,
			 	type: "text",
				icon: '📰'
			},
			{
				className: "form-control",
				label: 'Last Name',
				placeholder: "Enter your Last name",
				name: "last_name",
			 	required: true,
			 	type: "text",
				icon: '📋'
			},
			{
				className: "form-control",
				label: 'Email',
				placeholder: "Enter your Email",
				type: "text",
				name: "email",
				required: true,
				subtype: "email",
				icon: "✉"
			},
			{
				class: "form-control",
				label: 'I agree to receive your newsletters and accept the data privacy statement.',
				name: "agreement_text",
			 	type: "paragraph",
			 	subtype: 'output',
				icon: '☑'
			},
			{
				className: "form-control",
				label: 'Button',
				name: "button",
			 	type: "button",
			 	style:"primary",
				icon: '💬'
			}

			],
			//control orders 
			controlOrder: ["First Name", "Last Name", "Full Name", "Email", "header","file","text"],
			

			// event to be used when saving data 
			onSave: function(e, formData) {
				e.preventDefault()

		        // Prepares data
		        var parsed_form_data = JSON.parse(formData)

		        // Shows error if button field doesn't exist
		        if (Array.isArray(parsed_form_data)) {
					var found = parsed_form_data.find((val) => {
						if (val && val.hasOwnProperty('type')) {
						  	return val.type === 'button'
						}
					})

		          	if (! found) {
		            	swal('<?php echo $this->lang->line('Warning!') ?>', '<?php echo $this->lang->line('You forgot to choose a button field') ?>', 'warning')

		            	return
		          	}
		        }

		        // Starts loading state
		        e.target.classList.remove('disabled', 'btn-progress')
		        e.target.classList.add('disabled', 'btn-progress')

		        // Prepares form data to be submitted
		        var form_data = { 
					user_id: '<?= md5($user_id) ?>', 
					form_name: $('#form-name').val(), 
					contact_group: $('#contact_group').val(),
					sequence_email_campaign_id: $('#sequence_email_campaign_id').val(),
					sequence_sms_campaign_id: $('#sequence_sms_campaign_id').val(),
					form_position: $('#form_position').val(),
					popup_type: $('#popup_type').val(),
					response_type: $("input[name=response_type]:checked").val(),
					success_message:$("#success_message").val(),
					redirect_url:$("#redirect_url").val(),
					enable_country_code:$("input[name=enable_country_code]:checked").val(),
					is_double_optin:$("input[name=is_double_optin]:checked").val(),
					country_code_for_phone:$("#country_code_for_phone").val(),
					image_link:'<?php echo $this->session->userdata("attachment_filename_scheduler"); ?>',
					interval_time: $('#interval_time_input').val()*1000,
					form_data: formData
		        }

		        $.ajax({
					type: 'POST',
					url: '<?= base_url('email_optin_form_builder/save_form_data') ?>',
					dataType: 'JSON',
					data: form_data || null,
					success: function (response) {
			            if (response) {
			              	if (response.success === true) {
				                // Shows success message
				                swal({
									title: 'Success!', 
									text: response.message, 
									icon: 'success'
				                })

				                // Changes loading state
				                e.target.classList.remove('disabled', 'btn-progress')

				                // Empties fields
				                if (parsed_form_data.length) {
									// Clears form name
									document.getElementById('form-name').value = ''

									// Resets page selection
									$('#contact_group').val(null).trigger("change")
									$('#sequence_email_campaign_id').val(null).trigger("change")
									$('#sequence_sms_campaign_id').val(null).trigger("change")
									$('#form_position').val(null).trigger("change")
									
									// Clears form builders
									var clearAll = document.querySelector('.clear-all')
									$(clearAll).trigger('click')

									// Redirects to webview manager
									setTimeout(function() {
										window.location.replace('<?= base_url('email_optin_form_builder') ?>')
									}, 2000)
				                }

			              	} else if (response.error === true) {
				                // Shows error message
				                swal({ 
									title: 'Error!', 
									text: response.message, 
									icon: 'error'
				                })

				                // Changes loading state
				                e.target.classList.remove('disabled', 'btn-progress')              
			              	}
			            }
		          	},
					error: function (xhr, status, error) {
						console.log('xhr: ', xhr)
						console.log('status: ', status)

						// Shows HTTP status error
						swal({
							title: 'Error!', 
							text: error, 
							icon: 'error'
						})
					}
		        })
	      	},
	    }
	    
	    $('#optin-form-builder').formBuilder(options)

	   // $('#optin-form-builder').formBuilder({fields})
  	})

	function generate_select_box(
		options_array, 
		name_attribute,
		multiple = false
	) {
		var multi_select = multiple ? 'multiple' : '';
		var str = '';
		str += '<select class="form-control" name="' + name_attribute + '" id="' + name_attribute + '" ' + multi_select + '>';
		str += '<option value=""></option>';
		
		if (Array.isArray(options_array)) {
			options_array.forEach(option => {
				str += '<option value="'+ option.value +'">'+ option.text +'</option>';
			});
		}

		str += '</select>';

		return str;
	}
</script>