<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$include_prism = 0;
?>
<style>
    #page_id {
        width: 150px;
    }

    #searching {
        max-width: 40%;
    }

    .swal-text {
        text-align: left !important;
    }

    @media (max-width: 575.98px) {
        #page_id {
            width: 90px;
        }

        #searching {
            max-width: 50%;
        }

        #add_custom_field {
            max-width: 100% !important;
        }
    }

    div.tooltip_pd {
        top: 0px !important;
    }

    #get_subscriber_formdata {
        z-index: 1060 !important;
    }
</style>
<input type="hidden" name="csrf_token" id="csrf_token"
       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
<input type="hidden" name="page_id" id="page_id" value="<?php echo $page_id; ?>">
<input type="hidden" name="media_type" id="media_type" value="<?php echo $media_type; ?>">

<div class="content-header row d-none">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <?php if ($media_type == 'ig') {
                        ?>
                        <li class="breadcrumb-item"><a
                                    href="<?php echo base_url("bot_instagram"); ?>"><?php echo $this->lang->line("Instagram Bot"); ?></a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="breadcrumb-item"><a
                                    href="<?php echo base_url("messenger_bot/bot_menu_section"); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a>
                        </li>
                        <?php
                    } ?>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<?php
$builder_load_url = base_url("visual_flow_builder/load_builder/" . $page_id . '/1/' . $media_type);
?>
<div class="row">



        <?php


        if ($media_type == 'ig') {
            $join = array('facebook_rx_fb_user_info' => 'facebook_rx_fb_page_info.facebook_rx_fb_user_info_id=facebook_rx_fb_user_info.id,left');

            $data['page_title'] = $this->lang->line('Instagram Post-back Manager');
            $ig_page_info = $this->basic->get_data('facebook_rx_fb_page_info', array('where' => array('facebook_rx_fb_page_info.user_id' => $this->user_id, 'bot_enabled' => '1', 'has_instagram' => '1')), array('facebook_rx_fb_page_info.id', 'page_name', 'name', 'insta_username'), $join);

            $ig_flow_page_list = array();
            if (isset($ig_page_info) && count($ig_page_info) > 0) {
                $ig_flow_page_list['media_name'] = $this->lang->line("Instagram");
                foreach ($ig_page_info as $ig_value) {
                    $ig_flow_page_list['page_list'][$ig_value['id']] = $ig_value['page_name'] . " [" . $ig_value['insta_username'] . "]";
                }
                //array_push($group_page_list,$ig_flow_page_list);
            }
            $ig_flow_page_list = $ig_flow_page_list['page_list'];

            if (!empty($ig_flow_page_list) and $iframe == 0) { ?>
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
                            foreach ($ig_flow_page_list as $key => $value) {
                                if ($key == $this->session->userdata("ecommerce_selected_store")) $current_store_data = $value;

                                ?>
                                <option value="<?php echo $key; ?>" <?php if ($i == 0 || $key == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?>>
                                    <?php echo $value; ?>
                                </option>

                                <?php $i++;
                            } ?>
                        </select>
                    </div>
                </fieldset>
        </div>
            <?php }

        }

        if ($media_type == 'fb') {


            // Gets user info ID
            $facebook_rx_fb_user_info_id = $this->session->userdata('facebook_rx_fb_user_info');

            // Prepares sql statements and clauses
            $where = [
                'where' => [
                    'facebook_rx_fb_user_info_id' => $facebook_rx_fb_user_info_id,
                    'bot_enabled' => '1',
                ]
            ];

            $select = ['id', 'page_name'];

            // Executes query
            $pages = $this->basic->get_data('facebook_rx_fb_page_info', $where, $select, []);


            if (count($pages) > 0) {
                $page_info = $pages;
            } else {
                $page_info = array();
            }

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
                            foreach ($page_info as $value) {
                                if ($value['id'] == $this->session->userdata("ecommerce_selected_store")) $current_store_data = $value;

                                ?>
                                <option value="<?php echo $value['id']; ?>" <?php if ($i == 0 || $value['id'] == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?>>
                                    <?php
                                    if (addon_exist($module_id = 320, $addon_unique_name = "instagram_bot")) {
                                        if (isset($media_type) && $media_type == "ig") {
                                            echo $value['insta_username'] . " [" . $value['page_name'] . "]";
                                        } else {
                                            echo $value['page_name'];
                                        }
                                    } else {
                                        echo $value['page_name'];
                                    }
                                    ?>
                                </option>

                                <?php $i++;
                            } ?>
                        </select>
                    </div>
                </fieldset>
</div>
            <?php }

        }

        ?>
    <div class="col-sm-12 col-md-6">
        <a href="<?php echo $builder_load_url; ?>" class="btn btn-primary mb-1 add_custom_field">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Flow"); ?>
        </a>
    </div>
</div>


<?php $this->load->view('admin/theme/message'); ?>


<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="row">
                        <div class="col-md-8 col-12">
                            <div class="input-group mb-3 float-left" id="searchbox">
                                <input type="text" class="form-control" id="searching" name="searching" autofocus
                                       placeholder="<?php echo $this->lang->line('Search...'); ?>" aria-label=""
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="search_submit"
                                            title="<?php echo $this->lang->line('Search'); ?>" type="button"><i
                                                class="bx bx-search"></i> <span
                                                class="d-none d-sm-inline"><?php echo $this->lang->line('Search'); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("ID"); ?></th>
                                <th><?php echo $this->lang->line("Flow Name"); ?></th>
                                <th><?php echo $this->lang->line("Page Name"); ?></th>
                                <th><?php echo $this->lang->line("Editor Type"); ?></th>
                                <th><?php echo $this->lang->line("Action"); ?></th>
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


<div class="modal fade" id="detail-flow-input" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-user"></i> <?php echo $this->lang->line("Flow Subscribers"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body" id="subscriber_actions_modal_body" data-backdrop="static" data-keyboard="false">
                <div class="card shadow-none">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body pb-0">
                                <input type="text" id="searching2" name="searching2" class="form-control"
                                       placeholder="<?php echo $this->lang->line("Search..."); ?>" style='width:200px;'>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card-body data-card">
                                <div class="table-responsive2">
                                    <input type="hidden" id="put_table_id">
                                    <input type="hidden" id="media_type" value="<?php echo $media_type; ?>">
                                    <table class="table table-bordered" id="mytable1">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo $this->lang->line("Avatar"); ?></th>
                                            <th><?php echo $this->lang->line("First Name"); ?></th>
                                            <th><?php echo $this->lang->line("Last Name"); ?></th>
                                            <th><?php echo $this->lang->line("Subscriber ID"); ?></th>
                                            <th><?php echo $this->lang->line("Submitted At"); ?></th>
                                            <th><?php echo $this->lang->line("Actions"); ?></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- <div id="detail-first-view">
                            <div class="first-view-spinner">
                                <i class="bx bx-sync bx-spin bx-2x blue"></i>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="get_subscriber_formdata" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-info-circle"></i> <?php echo $this->lang->line("All Submitted Data"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body" data-backdrop="static" data-keyboard="false">
                <div class="row">
                    <div class="col-12">
                        <div class="row formdata_div"></div>
                    </div>

                    <div class="text-center waiting" id="waiting-div">
                        <i class="bx bx-sync bx-spin blue text-center" style="font-size:40px"></i>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
            </div>

        </div>
    </div>
</div>