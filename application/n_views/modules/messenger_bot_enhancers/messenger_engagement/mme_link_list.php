<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 1;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$include_prism = 1;
?>

<?php $this->load->view('admin/theme/message'); ?>
<style>
    .dropdown-toggle::after {
        content: none !important;
    }

    .dropdown-toggle::before {
        content: none !important;
    }

    #search_ref_name {
        max-width: 30% !important;
    }

    #search_page_id {
        width: 150px !important;
    }

    @media (max-width: 575.98px) {
        #search_page_id {
            width: 130px !important;
        }

        #search_ref_name {
            max-width: 77% !important;
        }
    }
</style>

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
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php
$builder_load_url = base_url("visual_flow_builder/load_builder/" . $page_id . '/1/' . $media_type . '?type=messenger-engagement&plugin=m_me_link&action=messenger_engagement_plugin');
?>

<div class="row">


        <?php

        if (!empty($page_info) and $iframe == 0) { ?>
        <div class="col-sm-12 col-md-6">
            <fieldset class="form-group" id="store_list_field">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"
                               for="bot_list_select"><?php if ($media_type == 'ig') echo $this->lang->line("Accounts"); else echo $this->lang->line("Pages"); ?></label>
                    </div>
                    <select class="form-control select2" id="bot_list_select">

                        <?php $i = 0;
                        $current_store_data = array();
                        foreach ($page_info as $key => $value) {
                            if ($key == $this->session->userdata("ecommerce_selected_store")) $current_store_data = $value;

                            ?>
                            <option value="<?php echo $key; ?>" <?php if ($i == 0 || $key == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?>>
                                <?php
                                if (addon_exist($module_id = 320, $addon_unique_name = "instagram_bot")) {
                                    if (isset($media_type) && $media_type == "ig") {
                                        echo $value['insta_username'] . " [" . $value . "]";
                                    } else {
                                        echo $value;
                                    }
                                } else {
                                    echo $value;
                                }
                                ?>
                            </option>

                            <?php $i++;
                        } ?>
                    </select>
                </div>
            </fieldset>
        </div>
        <?php } ?>
    <div class="col-sm-12 col-md-6">
                <a target="_BLANK" href="<?php echo $builder_load_url; ?>" class="btn btn-primary mb-1">
                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Plugin"); ?>
                </a>
    </div>
</div>
<input type="hidden" name="page_id" id="page_id" value="<?php echo $page_id; ?>">

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("Campaign ID"); ?></th>
                                <th><?php echo $this->lang->line("Page"); ?></th>
                                <th><?php echo $this->lang->line("Embed Code"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
                                <th><?php echo $this->lang->line("Editor Type"); ?></th>
                                <th><?php echo $this->lang->line("Link Code"); ?></th>
                                <th><?php echo $this->lang->line('Reference'); ?></th>
                                <th><?php echo $this->lang->line('Created at'); ?></th>
                                <th><?php echo $this->lang->line('Label'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" role="dialog" id="get_embed_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-code"></i> <?php echo $this->lang->line('M.me link embed code'); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label> <?php echo $this->lang->line("Copy the code below and paste inside the html element of your webpage where you want to display this plugin.") ?> </label>

                            <pre class="language-javascript"><code id="test"
                                                                   class="dlanguage-javascript description"></code></pre>

                            <br>
                            <label> <?php echo $this->lang->line("m.me link") ?> </label>
                            <pre class="language-javascript"><code id="mme" class="dlanguage-javascript"></code></pre>

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

<div class="modal fade" role="dialog" id="get_embed_modal2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-code-alt"></i> <?php echo $this->lang->line('M.me link QR code'); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body text-center" id="qr_container">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-left" data-dismiss="modal"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line('Close'); ?></button>
            </div>
        </div>
    </div>
</div>


