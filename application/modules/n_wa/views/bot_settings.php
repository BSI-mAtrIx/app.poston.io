<?php
$include_select2 = 1;
$include_dropzone = 1;
$include_cropper = 1;
$include_datatable=1;

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
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                        class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>n_wa"><?php echo $this->lang->line('WhatsApp bot'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php include(APPPATH . 'modules/n_wa/include/alert_message.php');
$botid=0;
$dnone = '';
$dshow = false;
if(isset($bot_data['id'])){
    $botid = $bot_data['id'];
    $dnone = 'd-none';
    $dshow = true;
}

$bspon = '';
if(isset($bot_data['bsp_on']) AND $bot_data['bsp_on']==1){
    $bspon = 'd-none';
}
$customer_hide = '';
if(isset($bsp_on) AND $bsp_on=='checked' AND isset($api_customer_on) AND $api_customer_on==''){
    $customer_hide = 'd-none';
    ?> <style>.bot_busines_manuall{display:none;}</style> <?php
}

$hide_login = '';
if(isset($bot_data['bsp_on']) AND $bot_data['bsp_on']==0){
    $hide_login = 'd-none';
}

?>

<div class="section-body ntheme main">
    <form action="<?php echo base_url("n_wa/save_bot_settings/").$botid; ?>" method="POST">
        <div class="card" id="nodata">
            <div class="card-header">
                <h5 class="card-title"><?php echo $this->lang->line('Connect WhatsApp Bot'); ?></h5>
            </div>
            <div class="card-body">

                <input type="hidden" name="csrf_token" id="csrf_token"
                       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

                <input type="hidden" name="bsp_access_token" id="bsp_access_token" value="">

                <?php if(empty($bot_data)){ ?>
                    <input type="hidden" name="is_new" id="is_new" value="1">
                <?php } ?>

                <input type="hidden" name="bsp_on" id="bsp_on" value="<?php echo isset($bot_data['bsp_on'])  ? $bot_data['bsp_on'] : ''; ?>">

                <div class="row mt-2 ">
                    <div class="col-12 mb-1 <?php echo $bspon; ?>">
                        <p><?php echo $this->lang->line('This option allow connect your Facebook APP with our tool. For instruction create app click here.'); ?></p>
                    </div>

                    <div class="col-12 <?php echo $dnone; ?>">
                        <h4><?php echo $this->lang->line('Step 1'); ?></h4>
                    </div>

                    <div class="col-12 mb-1 <?php echo $bspon; ?> <?php echo $hide_login; ?>">
                        <p> <?php echo $this->lang->line('You can connect to our app using button Facebook Login:');?></p>
                        <button id="launchWhatsAppSignup" style="background-color: #1877f2; border: 0; border-radius: 4px; color: #fff; cursor: pointer; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: bold; height: 40px; padding: 0 24px;">Login with Facebook</button>
                    </div>

                    <div class="col-12 mt-1" id="bsp_bot_business_id_unhide" style="display: none">
                        <label for="bsp_bot_business_id"><?php echo $this->lang->line('Select WhatsApp Business ID'); ?></label>
                        <fieldset>
                            <select id="bsp_bot_business_id" name="bsp_bot_business_id">
                                <option value="" selected="selected"><?php echo $this->lang->line('WhatsApp Business ID'); ?></option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-12 mb-1 bot_busines_manuall">
                        <label for="bot_business_id"><?php echo $this->lang->line('Provide your WhatsApp Business ID'); ?></label>
                        <fieldset>
                            <div class="input-group">
                                <input type="text" class="form-control" value="<?php echo isset($bot_data['business_id'])  ? $bot_data['business_id'] : ''; ?>" <?php echo $readonly; ?>  name="bot_business_id" id="bot_business_id">
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-12 bot_busines_manuall <?php echo $bspon; ?>">
                        <label for="bot_access_token"><?php echo $this->lang->line('Provide your Access Token'); ?></label>
                        <fieldset>
                            <div class="input-group">
                                <input type="text" class="form-control" value="<?php echo isset($bot_data['access_token'])  ? $bot_data['access_token'] : ''; ?>" <?php echo $readonly; ?>  name="bot_access_token" id="bot_access_token">
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-12 mt-2 <?php echo $dnone; ?>">
                        <h4><?php echo $this->lang->line('Step 2'); ?></h4>
                    </div>
                    <div class="col-12 mt-1 <?php echo $dnone; ?>">
                        <p><?php echo $this->lang->line('Select your number phone after click button get numbers.'); ?></p>
                        <a href="#" id="bot_get_numbers" class="btn btn-primary">
                            <?php echo $this->lang->line('Get phone numbers'); ?>
                        </a>
                    </div>
                    <div class="col-12 mt-1" id="select_bot_id_number_unhide" style="display: none">
                        <label for="select_bot_id_number"><?php echo $this->lang->line('Select phone number for bot'); ?></label>
                        <fieldset>
                            <select id="select_bot_id_number" name="select_bot_id_number">
                                <option value="" selected="selected"><?php echo $this->lang->line('Select phone number'); ?></option>
                            </select>
                        </fieldset>
                    </div>

                    <?php if($dshow){ ?>
                        <input type="hidden" value="<?php echo isset($bot_data['wa_id'])  ? $bot_data['wa_id'] : ''; ?>" <?php echo $readonly; ?>  name="select_bot_id_number" id="select_bot_id_number">
                        <div class="col-12 mt-1">
                            <label for="bot_phone_number"><?php echo $this->lang->line('Phone Number'); ?></label>
                            <fieldset>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo isset($bot_data['number_phone'])  ? $bot_data['number_phone'] : ''; ?>" <?php echo $readonly; ?>  name="bot_phone_number" id="bot_phone_number">
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-12 mt-1 <?php echo $bspon; ?>">
                            <label for="verify_token"><?php echo $this->lang->line('Webhook URL'); ?></label>
                            <fieldset>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo base_url('n_wa/webhook'); ?>" <?php echo $readonly; ?>  name="verify_token" id="verify_token">
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-12 mt-1 <?php echo $bspon; ?>">
                            <label for="verify_token"><?php echo $this->lang->line('Webhook Verify Token'); ?></label>
                            <fieldset>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo isset($bot_data['verify_token'])  ? $bot_data['verify_token'] : ''; ?>" <?php echo $readonly; ?>  name="verify_token" id="verify_token">
                                </div>
                            </fieldset>
                        </div>


                    <?php } ?>

                    <div class="col-12 mt-2" id="save_bot_settings_unhide3" style="display:none">
                        <h4><?php echo $this->lang->line('Step 3'); ?></h4>
                    </div>
                    <div class="col-12 <?php if($readonly!=''){echo 'd-none';}; ?>" id="save_bot_settings_unhide" style="display:none">
                        <button class="btn btn-primary mt-2"><i
                                    class="bx bx-save"></i> <?php echo $this->lang->line('Save'); ?></button>

                    </div>
                </div>



            </div>
        </div>

        <?php if(!empty($bot_data)){ ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo $this->lang->line('Bot settings').' '.$bot_data['bot_name']; ?></h5>
                </div>
                <div class="card-body">

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="bot_general-tab" data-toggle="tab" href="#bot_general" aria-controls="bot_general" role="tab" aria-selected="true">
                                <span class="align-middle"><?php echo $this->lang->line('General'); ?></span>
                            </a>
                        </li>
                        <li class="nav-item d-none">
                            <a class="nav-link" id="bot_menu-tab" data-toggle="tab" href="#bot_menu" aria-controls="bot_menu" role="tab" aria-selected="false">
                                <span class="align-middle"><?php echo $this->lang->line('Menu'); ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bot_messages-tab" data-toggle="tab" href="#bot_messages" aria-controls="bot_messages" role="tab" aria-selected="false">
                                <span class="align-middle"><?php echo $this->lang->line('Default messages'); ?></span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="bot_general" aria-labelledby="bot_general-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active"
                                                   id="active" value="1" <?php if($bot_data['active']==1){echo 'checked'; } ?>
                                                   class="custom-control-input">
                                            <label class="custom-control-label mr-1"
                                                   for="active"></label>
                                            <span><?php echo $this->lang->line('Active bot'); ?></span>
                                            <span class="text-danger"><?php echo form_error('active'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="bot_whoami"
                                                   id="bot_whoami" value="1" <?php if($bot_data['com_whoami']==1){echo 'checked'; } ?>
                                                   class="custom-control-input">
                                            <label class="custom-control-label mr-1"
                                                   for="bot_whoami"></label>
                                            <span><?php echo $this->lang->line('Command /whoami (user can check own information)'); ?></span>
                                            <span class="text-danger"><?php echo form_error('bot_whoami'); ?></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 d-none">
                                    <div class="form-group">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="inline_show_selected"
                                                   id="inline_show_selected" value="1" <?php if($bot_data['inline_show_selected']==1){echo 'checked'; } ?>
                                                   class="custom-control-input">
                                            <label class="custom-control-label mr-1"
                                                   for="inline_show_selected"></label>
                                            <span><?php echo $this->lang->line('Show selected button'); ?></span>
                                            <span class="text-danger"><?php echo form_error('inline_show_selected'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane" id="bot_menu" aria-labelledby="bot_menu-tab" role="tabpanel">
                            <div class="repeater-default">
                                <div data-repeater-list="group-a">

                                    <?php

                                    $options = array();
                                    $options[''] = $this->lang->line('Select command for menu');
                                    foreach($bot_data['all_commands'] as $k => $v){
                                        $options['/'.$v['command']] = '/'.$v['command'];
                                    }

                                    if(empty($bot_data['menu_bot']) OR $bot_data['menu_bot']=='null'){
                                        $bot_data['menu_bot'] = array();
                                        $bot_data['menu_bot'][] = array(
                                            'menu_command' => '',
                                            'menu_description' => '',
                                        );
                                    }else{
                                        $bot_data['menu_bot'] = json_decode($bot_data['menu_bot'], true);
                                    }
                                    foreach ($bot_data['menu_bot'] as $k => $v) {
                                        if($v['menu_command']=='brand'){
                                            continue;
                                        }
                                        ?>
                                        <div data-repeater-item>
                                            <div class="row">

                                                <div class="col-sm-12 col-md-5">
                                                    <fieldset>
                                                        <label for="menu_description"><?php echo $this->lang->line("Menu item description"); ?> </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="<?php echo $v['menu_description']; ?>"  name="menu_description" id="menu_description" aria-describedby="basic-addon2">
                                                        </div>
                                                    </fieldset>
                                                </div>

                                                <div class="col-sm-12 col-md-5">
                                                    <label for="menu_command">
                                                        <?php echo $this->lang->line("Menu item command"); ?>
                                                    </label>
                                                    <div class="form-group">
                                                        <?php
                                                        echo form_dropdown('menu_command', $options, $v['menu_command'], 'class="select2 form-control" style="width:100%;" id="menu_command"'); ?>
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <button class="btn btn-danger text-nowrap px-1 mt-2" data-repeater-delete
                                                            type="button">
                                                        <i class="bx bx-x"></i>
                                                        <?php echo $this->lang->line("Delete"); ?>
                                                    </button>
                                                </div>

                                            </div>

                                        </div>
                                    <?php } ?>

                                </div>

                                <button class="btn btn-primary" data-repeater-create type="button">
                                    <i class="bx bx-plus"></i>
                                    <?php echo $this->lang->line("Add"); ?>

                                </button>

                            </div>


                        </div>
                        <div class="tab-pane" id="bot_messages" aria-labelledby="bot_messages-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="bot_mess_no_match"><?php echo $this->lang->line("No match message (if empty, it does not send the message)"); ?></label><br/>
                                        <textarea id="bot_mess_no_match" name="bot_mess_no_match" style="height:200px !important;" class="form-control" id="description"><?php echo $bot_data['bot_mess_no_match']; ?></textarea>
                                        <span class="text-danger"><?php echo form_error('bot_mess_no_match'); ?></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="bot_command_no_match"><?php echo $this->lang->line("No match command message (if empty, it does not send the message)"); ?></label><br/>
                                        <textarea id="bot_command_no_match" name="bot_command_no_match" style="height:200px !important;" class="form-control" id="description"><?php echo $bot_data['bot_command_no_match']; ?></textarea>
                                        <span class="text-danger"><?php echo form_error('bot_command_no_match'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary mt-2">
                                <i class="bx bx-save"></i>
                                <?php echo $this->lang->line('Save'); ?>
                            </button>
                        </div>
                    </div>



                </div>
            </div>
        <?php } ?>

    </form>
</div>
