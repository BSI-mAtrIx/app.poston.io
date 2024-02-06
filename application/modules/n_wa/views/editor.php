<?php
$include_alertify=1;
$include_dropzone=1;
$include_cropper=1;
?>

<style>
.n_editor_sidebar{
    position: fixed;
    top: 0;
    right: 0;
    width: 400px;
    z-index: 1001;
}
.n_editor_sidebar #main_card{
    height: 100vh;
}

.editor_images_remove_button_action{display:none;}

.editor_images_remove_button_wrapper:hover .editor_images_remove_button_action{
    display:block;
    position: absolute;
    right: 0;
    background: #fff;
    padding-left: 2px;
    border-radius: 5px;
    padding-top: 2px;
}

.dock_cointainer{
    /*height: 250px;*/
    /* overflow-x: auto; */
    /* overflow-y: hidden; */

    position: fixed;
    width: 400px;
    z-index: 1000;
    background: #fff;
}
.dock-item{
    text-align: center;
}

.dock-item p{
    text-transform: capitalize;
    text-align: center;
}

.dock-item img{
    max-width: 40px!important;
    margin-bottom: 5px;
}

.dock-item.start{display: none;}
.dock .preview{display:none;}

</style>
<?php
if (!defined('NVX')) { ?>
    <section class="section section_custom">
        <div class="section-header">
            <h1><i class="fa fa-search-location"></i> <?php echo $page_title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>n_wa"><?php echo $this->lang->line("WhatsApp"); ?></a></div>
                <div class="breadcrumb-item"><?php echo $page_title; ?></div>
            </div>
        </div>
    </section>
<?php } else { ?>
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                    <ol class="breadcrumb p-0 mb-0 pl-1">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url(); ?>dashboard">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url(); ?>n_wa">
                                <?php echo $this->lang->line("WhatsApp"); ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <?php
}
?>



<div class="n_editor_sidebar" style="display: none;">

    <div class="card" id="main_card">
        <div class="card-header">
            <h4 class="card-title">
                <?php echo $this->lang->line("Message editor"); ?>
            </h4>
            <div class="heading-elements">
                        <a href="#"class="sidebar_close">
                            <i class="bx bx-x"></i>
                        </a>
            </div>
        </div>
        <div class="card-body">


            <div class="row">
                <input type="hidden" id="editor_id" name="editor_id"/>

                <div class="col-12 mb-1">
                    <div class="divider">
                        <div class="divider-text"><?php echo $this->lang->line('General'); ?></div>
                    </div>
                    <fieldset>
                        <label for="editor_command">
                            <?php echo $this->lang->line("Command (optional)"); ?>
                            <i class="bx bx-info-circle"
                               data-toggle="tooltip"
                               data-placement="top"
                               title="User chatbot can use /command to skip flow and start from /command"
                            ></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="editor_command_1">/</span>
                            </div>
                            <input type="text" id="editor_command" name="editor_command"  class="form-control" placeholder="command" aria-describedby="editor_command_1">
                        </div>
                    </fieldset>
                </div>

                <div class="col-sm-12 col-6">
                    <div class="form-group">
                        <label class="custom-switch">
                            <input type="checkbox" name="editor_trigger_checkbox"
                                   id="editor_trigger_checkbox" value="1"
                                   class="custom-control-input">
                            <label class="custom-control-label mr-1"
                                   for="editor_trigger_checkbox"></label>
                            <span><?php echo $this->lang->line('Typing enabled'); ?></span>
                            <span class="text-danger"><?php echo form_error('editor_trigger_checkbox'); ?></span>
                        </label>
                    </div>
                </div>

                <div class="col-sm-12 col-6">
                    <div class="form-group">
                        <label class="custom-switch">
                            <input type="checkbox" name="state_human_agent"
                                   id="state_human_agent" value="1"
                                   class="custom-control-input">
                            <label class="custom-control-label mr-1"
                                   for="state_human_agent"></label>
                            <span><?php echo $this->lang->line('Stop bot after send message (human agent)'); ?></span>
                            <span class="text-danger"><?php echo form_error('state_human_agent'); ?></span>
                        </label>
                    </div>
                </div>




                <div class="col-12 mb-1">
                    <div class="divider">
                        <div class="divider-text"><?php echo $this->lang->line('Text message'); ?></div>
                    </div>
                    <?php if($content_generator){ ?>
                    <div class="form-group">
                        <label class="custom-switch">
                            <input type="checkbox" name="editor_ai_reply_on"
                                   id="editor_ai_reply_on" value="1"
                                   class="custom-control-input">
                            <label class="custom-control-label mr-1"
                                   for="editor_ai_reply_on"></label>
                            <span><?php echo $this->lang->line('AI reply'); ?></span>
                            <span class="text-danger"><?php echo form_error('editor_ai_reply_on'); ?></span>
                        </label>
                    </div>
                    <?php } ?>


                    <label for="editor_message">
                        <span><?php echo $this->lang->line("Message"); ?></span>
                        <i class="bx bx-info-circle"
                           data-toggle="tooltip"
                           data-placement="top"
                           title="Message longer than 4096 characters split into multiple messages. If empty then send only images, video or files."
                        ></i>
                    </label>
                    <fieldset class="form-label-group mb-0">
                        <textarea data-length=4096 class="form-control char-textarea" id="editor_message" rows="5" placeholder="Message"></textarea>

                    </fieldset>
                    <small class="counter-value float-right">
                        <span class="char-count">0</span> / 4096
                    </small>
                    <?php if($content_generator){ ?>
                        <a data-toggle="modal" data-target="#generator_modal_message" href="#" id="ai_generate_button">
                            <?php echo $this->lang->line("Generate message"); ?>
                        </a>
                    <?php } ?>
                </div>

                <div class="col-12 mb-1">
                    <div class="divider">
                        <div class="divider-text"><?php echo $this->lang->line('Images'); ?></div>
                    </div>
                    <textarea class="d-none" id="editor_images"></textarea>
                    <div class="row" id="preview_images_editor">
                        <div class="col-4">
                                <div class="card">
                                    <img class="card-img-top img-fluid" src="#" alt="Card image cap" />
                                    <div class="card-body p-0 text-center">
                                        <a href="#" id="edit"><small><?php echo $this->lang->line('edit caption'); ?></small></a>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div id="thumb-dropzone" class="dropzone p-0 mb-1" style="min-height: 40px; padding:0;">
                            <div class="dz-default dz-message" style="margin: 1em 0;">
                                <input class="form-control" name="thumbnail" id="uploaded-file" type="hidden">
                                <span >
                                        <i class="bx bx-cloud-upload"
                                           style="color: #6777ef;"></i>
                                        <?php echo $this->lang->line('Add image'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-1">
                    <div class="divider">
                        <div class="divider-text"><?php echo $this->lang->line('Audio/Voice'); ?></div>
                    </div>
                    <textarea class="d-none" id="editor_audio"></textarea>
                    <div class="row" id="preview_audio_editor">
                    </div>
                    <div class="col-12">
                        <div id="file_audio-dropzone" class="dropzone p-0 mb-1" style="min-height: 40px; padding:0;">
                            <div class="dz-default dz-message" style="margin: 1em 0;">
                                <input class="form-control" name="thumbnail" id="uploaded-file_audio" type="hidden">
                                <span>
                                        <i class="bx bx-cloud-upload" style="color: #6777ef;"></i>
                                        <?php echo $this->lang->line('Add audio / voice'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-1">
                    <div class="divider">
                        <div class="divider-text"><?php echo $this->lang->line('Files'); ?></div>
                    </div>
                    <textarea class="d-none" id="editor_file"></textarea>
                    <div class="row" id="preview_file_file">
                    </div>
                    <div class="col-12">
                        <div id="file_file-dropzone" class="dropzone p-0 mb-1" style="min-height: 40px; padding:0;">
                            <div class="dz-default dz-message" style="margin: 1em 0;">
                                <input class="form-control" name="thumbnail" id="uploaded-file_file" type="hidden">
                                <span>
                                        <i class="bx bx-cloud-upload" style="color: #6777ef;"></i>
                                        <?php echo $this->lang->line('Add file'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-1">
                    <div class="divider">
                        <div class="divider-text">
                            <?php echo $this->lang->line('Buttons'); ?>
                        <?php if($is_whatsapp){ ?>
                            <i class="bx bx-info-circle"
                               data-toggle="tooltip"
                               data-placement="top"
                               title="<?php echo $this->lang->line('Buttons only send with only with text and one image. Image is optional.'); ?>"
                            ></i>
                        <?php } ?>
                        </div>
                    </div>
                    <div id="editor_node_buttons"></div>
                    <a data-toggle="modal" data-target="#editor_add_new_button" id="editor_add_new_button_new" href="#">
                        <?php echo $this->lang->line("Add new button"); ?>
                        <i class="bx bx-plus text-right"></i>
                    </a>
                </div>

                <div class="col-12 mb-1">
                    <div class="divider">
                        <div class="divider-text"><?php echo $this->lang->line('Others'); ?></div>
                    </div>
                    <a id="editor_adv_set" href="#">
                        <?php echo $this->lang->line("Advanced settings"); ?>
                        <i class="bx bx-plus text-right"></i>
                    </a>
                </div>

            </div>

            <div class="row" id="editor_adv_set_row" style="display: none;">
                <div class="col-12 mb-1">
                    <label for="editor_label_add">
                        <?php echo $this->lang->line("Add user label after send message"); ?>
                    </label>
                    <fieldset class="form-group">
                        <select class="form-control" id="editor_label_add" name="editor_label_add[]" multiple="multiple">

                        </select>
                        <a data-toggle="modal" data-target="#add_label" href="#">
                            <?php echo $this->lang->line("Add new label"); ?>
                        </a>
                    </fieldset>
                </div>

                <div class="col-12 mb-1">
                    <label for="editor_label_remove">
                        <?php echo $this->lang->line("Remove user label after send message"); ?>
                    </label>
                    <fieldset class="form-group">
                        <select class="form-control" name="editor_label_remove[]" id="editor_label_remove" multiple="multiple">

                        </select>
                    </fieldset>
                </div>

                <div class="col-12 mb-1">
                    <fieldset>
                        <label for="editor_point_user">
                            <?php echo $this->lang->line("Point user"); ?>
                            <i class="bx bx-info-circle"
                               data-toggle="tooltip"
                               data-placement="top"
                               title="You use characters + or - to add or remove point. Without characters is set point."
                            ></i>
                        </label>
                        <div class="input-group">
                            <input type="text" id="editor_point_user" name="editor_point_user"  class="form-control" placeholder="Points" aria-describedby="editor_point_user_1">
                        </div>
                    </fieldset>
                </div>

                <div class="col-12 mb-1">
                    <label for="editor_step_action">
                        <?php echo $this->lang->line("Action after send message"); ?>
                        <i class="bx bx-info-circle"
                           data-toggle="tooltip"
                           data-html="true"
                           data-placement="top"
                           title="*Userinput: Waiting for text reply from user<br />*Question/Survey: Save answer to use it later<br \>*Default: default action, like click to button in message<br \>*Reset step: user return to start after message"></i>
                    </label>
                    <fieldset class="form-group">
                        <select class="form-control" id="editor_step_action">
                            <option value="default"><?php echo $this->lang->line('Default'); ?></option>
                            <option value="userinput"><?php echo $this->lang->line('Userinput'); ?></option>
<!--                            <option value="question">--><?php //echo $this->lang->line('Question/Survey'); ?><!--</option>-->
<!--                            <option value="reset">--><?php //echo $this->lang->line('Reset step'); ?><!--</option>-->
                        </select>
                    </fieldset>
                </div>

                <div class="col-sm-12 mb-1">
                    <div class="form-group">
                        <label class="custom-switch">
                            <input type="checkbox" name="editor_message_markdown"
                                   id="editor_message_markdown" value="1"
                                   class="custom-control-input">
                            <label class="custom-control-label mr-1"
                                   for="editor_message_markdown"></label>
                            <span><?php echo $this->lang->line('Message is markdown'); ?></span>
                            <span class="text-danger"><?php echo form_error('editor_message_markdown'); ?></span>
                        </label>
                    </div>
                </div>

                <?php
                    if(file_exists(APPPATH . 'n_generator_config.php')){
               ?>
                <div class="col-12 mb-1">
                    <label for="editor_step_action">
                        <?php echo $this->lang->line("AI Engine Version"); ?>
                    </label>
                    <fieldset class="form-group">
                        <select class="form-control" id="editor_engine_version">
                            <?php
                           $chat_completions = [
                               'engine_v1' => 'Engine 1 (default)',
                               'engine_v2' => 'Engine 2 (Cheap for Chat)',

                           ];
                           include(APPPATH . 'n_generator_config.php');

                           if($n_gen_config['engine']=='1'){$chat_completions['engine_v3'] = 'Engine 3 (Best Universal)';}

                           foreach ($chat_completions as  $k => $value): ?>
                            <option value="<?php echo $k ?>"><?php echo $value?></option>
                            <?php endforeach; ?>
                        </select>
                    </fieldset>
                </div>
                <?php } ?>

            </div>


            <div class="row">
                <div class="col-12 mb-1">
                    <button class="btn btn-primary set_id_editor">
                        <?php echo $this->lang->line('Save'); ?>
                    </button>
                    <button class="btn btn-secondary sidebar_close">
                        <?php echo $this->lang->line('Cancel'); ?>
                    </button>
                </div>

            </div>

        </div>
    </div>

</div>

<div class="content-body">


    <div class="row">
        <div class="col-12">
            <div class="card dock_cointainer">
                <div class="card-header">
                    <h5 class="text-title">
                        <?php echo $this->lang->line('Dock Menu'); ?>
                    </h5>
                    <div class="invoice-create-btn mb-1">
                        <a href="#" id="editor_save_action"
                           class="btn btn-sm btn-primary">
                            <i class="bx bx-save"></i>
                            <?php echo $this->lang->line('Save'); ?>
                        </a>
                        <a href="#" id="editor_zoom_plus_action"
                           class="btn btn-sm btn-primary">
                            <i class="bx bx-zoom-in"></i>
                        </a>
                        <a href="#" id="editor_zoom_minus_action"
                           class="btn btn-sm btn-primary">
                            <i class="bx bx-zoom-out"></i>
                        </a>
                        <a href="#" id="editor_show_hide_dock"
                           class="btn btn-sm btn-primary">
                            <i class="bx bx-menu"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="dock row"></div>
                </div>
            </div>

            <div id="WhatsApp_builder" style="min-height: 80vh;"></div>
        </div>
    </div>
</div>

