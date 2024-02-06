<?php

if ($this->basic->is_exist("add_ons", array("project_id" => 31)))
    echo "<style>
 	#new-webview-form-submission-alert{
 		display: block;
 	}
 </style>";
else
    echo "<style>
	 	#new-webview-form-submission-alert{
	 		display: none;
	 	}
	 </style>";

if ($this->basic->is_exist("add_ons", array("project_id" => 47)))
    echo "<style>
 	#double-opt-in-confirmation-email{
 		display: block;
 	}
 </style>";
else
    echo "<style>
	 	#double-opt-in-confirmation-email{
	 		display: none;
	 	}
	 </style>";

if ($this->basic->is_exist("add_ons", array("project_id" => 49)))
    echo "<style>
 	#new-input-flow-submission-alert{
 		display: block;
 	}
 </style>";
else
    echo "<style>
	 	#new-input-flow-submission-alert{
	 		display: none;
	 	}
	 </style>";

if ($this->basic->is_exist("add_ons", array("project_id" => 57)))
    echo "<style>
 	#affiliate-signup-activation,#affiliate-withdrawal-request-approval,#affiliate-withdrawal-request-cancelation,#new-withdrawal-request{
 		display: block;
 	}
 </style>";
else
    echo "<style>
	 	#affiliate-signup-activation,#affiliate-withdrawal-request-approval,#affiliate-withdrawal-request-cancelation,#new-withdrawal-request{
	 		display: none;
	 	}
	 </style>";


?>
<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 1;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 1;
$jodit = 1;
?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('admin/settings'); ?>"><?php echo $this->lang->line("Settings"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<?php $save_button = '<div class="card-footer bg-whitesmoke">
	                      <button class="btn btn-primary" id="save-btn" type="submit"><i class="bx bx-save"></i> ' . $this->lang->line("Save") . '</button>
	                      <button class="btn btn-secondary float-right" onclick=\'goBack("admin/settings")\' type="button"><i class="bx bx-trash"></i> ' . $this->lang->line("Cancel") . '</button>
	                    </div>'; ?>

<?php $double_email = array("membership_expiration_10_days_before", "membership_expiration_1_day_before", "membership_expiration_1_day_after", "paypal_payment", "paypal_new_payment_made", "stripe_payment", "stripe_new_payment_made"); ?>


<form class="form-horizontal text-c" action="<?php echo site_url('admin/email_template_settings_action'); ?>"
      method="POST">

    <input type="hidden" name="csrf_token" id="csrf_token"
           value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

    <div class="section-body">
        <div id="output-status"></div>
        <div class="row">

            <div class="col-md-8">
                <?php
                $i = 0;
                foreach ($emailTemplatetabledata as $value) {
                    if ($this->session->userdata('license_type') != 'double' && in_array($value['template_type'], $double_email)) continue;

                    $temp_fildset = strtolower(str_replace(array(' ', '_'), '-', $value['title'])); ?>

                    <div class="card" id="<?php echo $temp_fildset; ?>">

                        <div class="card-header">
                            <h4>
                                <i class="<?php echo $value['icon']; ?>"></i> <?php echo $this->lang->line($value['title']); ?>
                                <a data-html='true' data-toggle="popover" data-placement="bottom"
                                   title="<?php echo $this->lang->line($value['info']); ?>"
                                   data-content="<b><u><?php echo $this->lang->line('Variable List') . ' : </b></u><br>' . str_replace(',', '<br>', $value['tooltip']); ?>"><i
                                            class="bx bx-info-circle"></i></a>
                            </h4>
                        </div>
                        <div class="card-body">


                            <div class="form-group">
                                <label for="<?php echo $value['template_type'] . '-subject'; ?>"><i
                                            class="bx bx-dots-horizontal-rounded"></i> <?php echo $this->lang->line('Subject'); ?>
                                </label>

                                <input name="<?php echo $value['template_type'] . '-subject'; ?>"
                                       value='<?php if ($value['subject'] != '') echo $value['subject']; else echo $default_values[$i]['subject']; ?>'
                                       class="form-control" type="text"
                                       id="<?php echo $value['template_type'] . '-subject'; ?>">
                                <span class="text-danger"><?php echo form_error($value['template_type'] . '-subject'); ?></span>
                            </div>

                            <div class="form-group">
                                <label for="<?php echo $value['template_type'] . '-message' ?>"><i
                                            class="bx bx-envelope"></i> <?php echo $this->lang->line("Message"); ?>
                                </label>

                                <textarea name="<?php echo $value['template_type'] . '-message' ?>"
                                          id="<?php echo $value['template_type'] . '-message' ?>"
                                          class="codeeditor"><?php if ($value['message'] != '') echo $value['message']; else echo $default_values[$i]['message']; ?></textarea>
                                <span class="text-danger"><?php echo form_error($value['template_type'] . '-message'); ?></span>
                            </div>
                            <a href="<?php echo base_url() . "admin/delete_email_template/" . $value['template_type']; ?>"
                               class="float-right"><i
                                        class="bx bx-sync"></i> <?php echo $this->lang->line("Restore To Default"); ?>
                            </a>


                        </div>
                        <?php echo $save_button; ?>
                    </div>
                    <?php
                    $i++;
                };
                ?>
            </div>


            <div class="col-md-4 d-none d-sm-block">
                <div class="sidebar-item">
                    <div class="make-me-sticky">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="bx bx-columns"></i> <?php echo $this->lang->line("Sections"); ?></h4>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills flex-column settings_menu">
                                    <?php
                                    foreach ($emailTemplatetabledata as $value) {
                                        if ($this->session->userdata('license_type') != 'double' && in_array($value['template_type'], $double_email)) continue;
                                        $temp_fildset = strtolower(str_replace(array(' ', '_'), '-', $value['title']));
                                        $fieldset = ucwords(str_replace('_', ' ', $value['template_type']));
                                        ?>

                                        <li class="nav-item">
                                            <a href="#<?php echo $temp_fildset; ?>" class="nav-link">
                                                <i class="<?php echo $value['icon']; ?>"></i> <?php echo $this->lang->line($value['title']); ?>
                                            </a>
                                        </li>
                                        <?php
                                    } ?>
                                </ul>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
   				




