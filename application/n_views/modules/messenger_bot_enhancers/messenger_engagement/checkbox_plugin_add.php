<style>
    .add_template, .ref_template {
        font-size: 10px;
        margin-top: 5px
    }
</style>
<link rel="stylesheet"
      href="<?php echo base_url('n_assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css?ver=' . $n_config['theme_version']) ?>">
<div id="put_script"></div>
<div class="content-header row d-none">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("messenger_bot"); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("messenger_bot_enhancers/checkbox_plugin_list"); ?>"><?php echo $this->lang->line("Checkbox Plugin"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card main_card">

                <div class="card-body">
                    <form action="#" enctype="multipart/form-data" id="plugin_form">
                        <div class="row">
                            <div class="form-group col-12 col-md-4 d-none">
                                <label>
                                    <?php echo $this->lang->line("select page"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("select page") ?>"
                                       data-content='<?php echo $this->lang->line("Select your Facebook page for which you want to generate the plugin.") ?>'><i
                                                class='bx bxs-help-circle'></i> </a>
                                </label>
                                <?php $page_info[''] = $this->lang->line("select page"); ?>
                                <?php echo form_dropdown('page', $page_info, $page_id, 'class="form-control select2" id="page" style="width:100%;"'); ?>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label>
                                    <?php echo $this->lang->line("domain"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("domain") ?>"
                                       data-content='<?php echo $this->lang->line("Domain where you want to embed this plugin. Domain must have https.") ?>'><i
                                                class='bx bxs-help-circle'></i> </a>
                                </label>
                                <input type="text" name="domain_name" autocomplete="off" id="domain_name"
                                       class="form-control" placeholder="https://example.com">
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label>
                                    <?php echo $this->lang->line("language"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("language") ?>"
                                       data-content='<?php echo $this->lang->line("plugin will be loaded in this language.") ?>'><i
                                                class='bx bxs-help-circle'></i> </a>
                                </label>
                                <?php echo form_dropdown('language', $sdk_list, 'en_US', 'class="form-control select2" id="language" style="width:100%;"'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-md-3">
                                <label>
                                    <?php echo $this->lang->line("Plugin skin"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Plugin skin") ?>"
                                       data-content='<?php echo $this->lang->line("light skin is suitable for pages with dark background and dark skin is suitable for pages with light background.") ?>'><i
                                                class='bx bxs-help-circle'></i> </a>
                                </label>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="skin" value="dark" id="dark"
                                                       class="selectgroup-input">
                                                <span class="selectgroup-button"> <?php echo $this->lang->line("Light") ?></span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="skin" value="light" id="light"
                                                       class="selectgroup-input" checked>
                                                <span class="selectgroup-button"> <?php echo $this->lang->line("Dark") ?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label>
                                    <?php echo $this->lang->line("Center align"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("center align") ?>"
                                       data-content='<?php echo $this->lang->line("choosing yes will make the plugin aligned center, otherwise left.") ?>'><i
                                                class='bx bxs-help-circle'></i> </a>
                                </label>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="center_align" value="true" id="centeryes"
                                                       class="selectgroup-input" checked>
                                                <span class="selectgroup-button"> <?php echo $this->lang->line("Yes"); ?></span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="center_align" value="false" id="centerno"
                                                       class="selectgroup-input">
                                                <span class="selectgroup-button"> <?php echo $this->lang->line("No") ?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Plugin size"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("plugin size") ?>"
                                       data-content='<?php echo $this->lang->line("overall plugin size.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="selectgroup selectgroup-pills">
                                    <?php
                                    $i = 0;
                                    foreach ($btn_sizes as $key => $value) {
                                        $i++;
                                        $checked = $selected = '';
                                        if ($value == 'medium') {
                                            $selected = 'default-label';
                                            $checked = 'checked';
                                        }
                                        $val_print = $value;
                                        if ($val_print == "xlarge") $val_print = "Extra Large";
                                        echo '<label class="selectgroup-item">
									                    <input type="radio" name="btn_size" value="' . $value . '" id="btn_size' . $i . '" ' . $checked . ' class="selectgroup-input">
									                    <span class="selectgroup-button">' . $this->lang->line($val_print) . '</span>
									                  </label>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <!--<div class="form-group col-12 col-md-6">
						    <label>
						      <?php echo $this->lang->line("JS Event"); ?> *
						       <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("javascript event") ?>" data-content='<?php echo $this->lang->line("What javascript event you want to perform the OPT-IN functionality?") ?>'><i class='bx bx-info-circle'></i> </a>
						    </label>
						    <div class="selectgroup selectgroup-pills">
						    <?php
                            $i = 0;
                            foreach ($js_events as $key => $value) {
                                $i++;
                                $checked = $selected = '';
                                if ($key == 'click') {
                                    $selected = 'default-label';
                                    $checked = 'checked';
                                }

                                echo '<label class="selectgroup-item">
							                     <input type="radio" name="js_event" value="' . $key . '" id="js_event_' . $i . '" ' . $checked . ' class="selectgroup-input">
							                     <span class="selectgroup-button">' . $this->lang->line($value) . '</span>
							                   </label>';

                            }
                            ?>
						    </div>               
						  </div>  -->

                        </div>

                        <div class="row">

                            <!-- <div class="col-12 col-md-6">
				           		<div class="form-group">
				           		  <label class="custom-switch mt-2">

				           		    <input type="checkbox" name="new_button" id="new_or_old" class="custom-control-input">
				           		    <label class="custom-control-label mr-1" for="new_or_old"></label>
				           		    <span><?php echo $this->lang->line("I want to add a new html element") ?></span>
				           		  
				           		  </label>
				           		</div>        				           	
				            </div>  -->

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="custom-switch mt-2">

                                        <input type="checkbox" name="redirect" id="redirect_or_not"
                                               class="custom-control-input">
                                        <label class="custom-control-label mr-1" for="redirect_or_not"></label>
                                        <span><?php echo $this->lang->line("Redirect to a webpage on successful OPT-IN") ?></span>

                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row existing_button_block">
	 					  <div class="form-group col-12 col-md-6">
						    <label>
						      <?php echo $this->lang->line("Element type"); ?> *
						       <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("element type") ?>" data-content='<?php echo $this->lang->line("the HTML element will trigger the OPT-IN functionality is a class or ID?") ?>'><i class='bx bx-info-circle'></i> </a>
						    </label>
						    <br>

						     <div class="custom-control custom-radio custom-control-inline">
	                           <input type="radio" value="class" id="elementclass" name="element_type" class="custom-control-input">
	                           <label class="custom-control-label" for="elementclass"><?php echo $this->lang->line('Class'); ?></label>
	                         </div>
	                         <div class="custom-control custom-radio custom-control-inline">
                               <input type="radio" value="id" id="elementid" name="element_type" class="custom-control-input" checked>
                               <label class="custom-control-label" for="elementid"><?php echo $this->lang->line('ID'); ?></label>
                             </div>
           
						  </div>  
	 					  <div class="form-group col-12 col-md-6">
						    <label>
						      <?php echo $this->lang->line("Element selector (Class/Id value)"); ?> *
						       <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("element selector (class/id value)") ?>" data-content='<?php echo $this->lang->line("If element typr is an ID then put ID value otherwise put the class value.") ?>'><i class='bx bx-info-circle'></i> </a>
						    </label>
						    <input type="text" name="id_or_class_value" id="id_or_class_value" class="form-control">                      
						  </div>  
						</div> 

						<div class="row new_button_block">
	 					  <div class="form-group col-12 col-md-6">
						    <label class="margin-bottom-label">
						      <?php echo $this->lang->line("New button text"); ?> *
						       <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("new button text") ?>" data-content='<?php echo $this->lang->line("System will create a new button to perform the OPT-IN functionality. Type the button text here.") ?>'><i class='bx bx-info-circle'></i> </a>
						    </label>
						    <input type="text" name="new_button_display" id="new_button_display" class="form-control" value="Confirm OPT-IN">                     
						  </div>
	 					  <div class="form-group col-12 col-md-6">
						    <label class="margin-bottom-label">
						      <?php echo $this->lang->line("Button position"); ?> *
						       <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("button position") ?>" data-content='<?php echo $this->lang->line("where will be the new button placed relative to the checkbox?") ?>'><i class='bx bx-info-circle'></i> </a>
						    </label>

    					    <div class="selectgroup selectgroup-pills">
                                <label class="selectgroup-item">
                                  <input type="radio" name="new_button_position" value="top" class="selectgroup-input" id="new_button_position1">
                                  <span class="selectgroup-button selectgroup-button-icon"><?php echo $this->lang->line('Top'); ?></span>
                                </label>
                                <label class="selectgroup-item">
                                  <input type="radio" name="new_button_position" value="bottom" class="selectgroup-input" id="new_button_position2" checked>
                                  <span class="selectgroup-button selectgroup-button-icon"> <?php echo $this->lang->line('Bottom'); ?></span>
                                </label>
    					     </div> 
             
						  </div>
						</div>  -->

                        <div class="row new_button_block">
                            <div class="form-group col-12 col-md-3">
                                <label>
                                    <?php echo $this->lang->line("Button background"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("button background") ?>"
                                       data-content='<?php echo $this->lang->line("new button backgroung color") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="new_button_bg_color"
                                           id="new_button_bg_color" value="#0084FF">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label class="margin-bottom-label">
                                    <?php echo $this->lang->line("Button text color"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("button text color") ?>"
                                       data-content='<?php echo $this->lang->line("new button text color") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="new_button_color"
                                           id="new_button_color" value="#FFFFFF">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label class="margin-bottom-label">
                                    <?php echo $this->lang->line("Button hover background"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("button hover background") ?>"
                                       data-content='<?php echo $this->lang->line("new button background color on mouse over") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="new_button_bg_color_hover"
                                           id="new_button_bg_color_hover" value="#367FA9">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label class="margin-bottom-label">
                                    <?php echo $this->lang->line("Button text hover color"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("button text hover color") ?>"
                                       data-content='<?php echo $this->lang->line("new button text color on mouse over") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="new_button_color_hover"
                                           id="new_button_color_hover" value="#FFFDDD">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row display_messsage_block">
                            <div class="form-group col-12">
                                <label>
                                    <?php echo $this->lang->line("OPT-IN success message in website"); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("OPT-IN success message") ?>"
                                       data-content='<?php echo $this->lang->line("this message will be displayed after successful OPT-IN.") ?> <?php echo $this->lang->line('Keep it blank if you do not want.'); ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <textarea class="form-control"
                                          placeholder="<?php echo $this->lang->line('Keep it blank if you do not want.'); ?>"
                                          name="button_click_success_message" id="button_click_success_message"
                                          style="width: 100%;"><?php echo 'You have been subscribed successfully, thank you.'; ?></textarea>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" value="1" class="custom-control-input"
                                           name="add_button_with_message" id="add_button_with_message">
                                    <label class="custom-control-label"
                                           for="add_button_with_message"><?php echo $this->lang->line("I want to add a button in success message"); ?></label>
                                </div>

                            </div>


                        </div>

                        <div class="row display_messsage_block display_button_block">
                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("button text"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("button text") ?>"
                                       data-content='<?php echo $this->lang->line("This button will be embeded with OPT-IN successful message.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="success_button" id="success_button" class="form-control"
                                       value="Send Message">
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Button URL"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Button URL") ?>"
                                       data-content='<?php echo $this->lang->line("Button click action URL") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="success_url" id="success_url" class="form-control" value="">
                            </div>
                        </div>

                        <div class="row display_messsage_block display_button_block">


                            <div class="form-group col-12 col-md-3">
                                <label>
                                    <?php echo $this->lang->line("Button background"); ?> *

                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="success_button_bg_color"
                                           id="success_button_bg_color" value="#5CB85C">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label class="margin-bottom-label">
                                    <?php echo $this->lang->line("Button text color"); ?> *

                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="success_button_color"
                                           id="success_button_color" value="#FFFFFF">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label class="margin-bottom-label">
                                    <?php echo $this->lang->line("Button hover background"); ?> *

                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="success_button_bg_color_hover"
                                           id="success_button_bg_color_hover" value="#339966">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label class="margin-bottom-label">
                                    <?php echo $this->lang->line("Button text hover color"); ?> *

                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="success_button_color_hover"
                                           id="success_button_color_hover" value="#FFFDDD">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row redirect_block">
                            <div class="form-group col-12">
                                <label class="margin-bottom-label">
                                    <?php echo $this->lang->line("OPT-IN success redirect URL"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("OPT-IN success redirect URL") ?>"
                                       data-content='<?php echo $this->lang->line("Visitors will be redirected to this URL after successful OPT-IN.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="success_redirect_url" id="success_redirect_url"
                                       class="form-control" value="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <label>
                                    <?php echo $this->lang->line("checkbox validation error message"); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("checkbox validation error message") ?>"
                                       data-content='<?php echo $this->lang->line("this message will be displayed if checkbox is not checked.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <textarea name="validation_error" id="validation_error" style="width: 100%;"
                                          class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12 <?php if (!$this->is_broadcaster_exist) echo 'col-md-6'; else echo 'col-md-5'; ?>">
                                <label>
                                    <?php echo $this->lang->line("OPT-IN inbox confirmation message template"); ?> *
                                    <a href="#" data-html="true" data-placement="top" data-toggle="popover"
                                       data-trigger="focus"
                                       title="<?php echo $this->lang->line("OPT-IN inbox confirmation message template") ?>"
                                       data-content='<?php echo $this->lang->line("This content will be sent to messenger inbox on OPT-IN.") ?> <?php echo $this->lang->line("You must select page to fill this list with data."); ?> <?php echo $this->lang->line("You can create template from ") . ' <a href="' . base_url("messenger_bot/create_new_template") . '">' . $this->lang->line("here.") ?></a> <?php echo $this->lang->line("First name & last name in template will not work."); ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <?php echo form_dropdown('template_id', array(), '', 'class="select2 form-control" id="template_id" style="width:100%;"'); ?>
                                <a href="" class="add_template float-left" page_id_add_postback=""><i
                                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Template"); ?>
                                </a>
                                <a href="" class="ref_template float-right" page_id_refresh_postback=""><i
                                            class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?></a>
                            </div>
                            <div class="form-group col-12 <?php if (!$this->is_broadcaster_exist) echo 'col-md-6'; else echo 'col-md-3'; ?>">
                                <label>
                                    <?php echo $this->lang->line("reference"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("reference") ?>"
                                       data-content='<?php echo $this->lang->line("put a unique reference to track this plugin later.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="reference" id="reference" class="form-control" value="">
                            </div>
                            <div class="form-group col-12 col-md-4 <?php if (!$this->is_broadcaster_exist) echo 'hidden'; ?>">
                                <label class="d-block">
                                    <?php echo $this->lang->line("select label"); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("select label") ?>"
                                       data-content='<?php echo $this->lang->line("subscriber obtained from this plugin will be enrolled in these labels.") ?> <?php echo $this->lang->line("You must select page to fill this list with data."); ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                    <a class="blue float-right pointer" page_id_for_label=""
                                       id="create_label_checkbox_plugin"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create Label"); ?>
                                    </a>
                                </label>
                                <?php echo form_dropdown('label_ids[]', array(), '', 'style="height:45px;overflow:hidden;width:100%;" multiple="multiple" class="select2 form-control" id="label_ids"'); ?>
                            </div>
                        </div>

                        <button class="btn btn-primary" id="get_button" name="get_button" type="button"><i
                                    class="bx bx-code"></i> <?php echo $this->lang->line("Generate Embed code"); ?>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- postback template add modal -->
<div class="modal fade" id="add_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Template'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%"></iframe>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-dark"><i class="bx bx-sync"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("Close & Refresh List"); ?></span>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" role="dialog" id="get_plugin_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-code"></i> <?php echo $this->lang->line('Checkbox Plugin Embed Code'); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div id="response"></div>
                        <div class="form-group js_code_con">
                            <label for="description"> <?php echo $this->lang->line("copy the code below and paste inside the html element of your webpage where you want to display this plugin.") ?> </label>

                            <pre class="language-javascript"><code id="test"
                                                                   class="dlanguage-javascript description"></code></pre>

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line('Close'); ?></button>
            </div>
        </div>
    </div>
</div>

