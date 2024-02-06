<?php

$include_select2 = 1;

$include_datatable = 1;



$user_input_flow_exist = 'no';

if ($this->basic->is_exist("add_ons", array("project_id" => 49))) {

    if ($this->session->userdata('user_type') == 'Admin' || in_array(292, $this->module_access))

        $user_input_flow_exist = 'yes';

    else

        $user_input_flow_exist = 'no';

}



$webview_access = 'no';

if ($this->session->userdata('user_type') == 'Admin' && $this->basic->is_exist("add_ons", array("project_id" => 31))) $webview_access = 'yes';

if ($this->session->userdata('user_type') == 'Member' && in_array(261, $this->module_access)) $webview_access = 'yes';



$ecommerce_exist = 'no';

if ($this->session->userdata('user_type') == 'Admin') $ecommerce_exist = 'yes';

if ($this->session->userdata('user_type') == 'Member' && in_array(268, $this->module_access)) $ecommerce_exist = 'yes';

if((isset($rtl_on) && $rtl_on == true) OR (isset($is_rtl) && $is_rtl == true)){
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>n_assets/app-assets/css-rtl/livechat.css">
    <?php
}else{
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('n_assets/app-assets/css/livechat.css'); ?>">
<?php }

?>



<div class="content-header row">

    <div class="content-header-left col-12 mb-2 mt-1">

        <div class="breadcrumbs-top">

            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line('Live Chat'); ?> </h5>

            <div class="breadcrumb-wrapper d-none d-sm-block">

                <ol class="breadcrumb p-0 mb-0 pl-1">

                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i

                                    class="bx bx-home-alt"></i></a></li>

                    <li class="breadcrumb-item"><a

                                href="<?php echo base_url("subscriber_manager"); ?>"><?php echo $this->lang->line("subscriber manager"); ?></a>

                    </li>

                    <li class="breadcrumb-item active"><?php echo $this->lang->line('Live Chat'); ?></li>

                </ol>

            </div>

        </div>

    </div>

</div>



<div class="row">

    <div class="col-sm-12 col-md-6">

        <fieldset class="form-group" id="store_list_field">

            <div class="input-group">

                <div class="input-group-prepend">

                    <label class="input-group-text"

                           for="page_id"><?php echo $this->lang->line("Accounts"); ?></label>

                </div>

                <select name="page_id" id="page_id" class="form-control select2">

                    <option value=""><?php echo $this->lang->line('Select'); ?></option>

                    <?php foreach ($page_info as $page) : ?>

                        <option value="<?php echo $page['id'] ?>" <?php if ($page['id'] == $page_table_id) echo 'selected'; ?>><?php echo $page['page_name']; ?></option>



                    <?php endforeach; ?>

                </select>

            </div>

        </fieldset>

    </div>

    <div class="col-sm-12 col-md-6">

        <?php if ($selected_global_media_type == 'fb') { ?>

            <a href="#" class="btn btn-primary social_switch mb-1"

               data-value="fb"><?php echo $this->lang->line("Change to Instagram"); ?></a>

        <?php } else { ?>

            <a href="#" class="btn btn-primary social_switch mb-1"

               data-value="ig"><?php echo $this->lang->line("Change to Facebook"); ?></a>

        <?php } ?>

    </div>

</div>



<?php if (empty($page_info)) { ?>

    <div class="card" id="nodata">

        <div class="card-body">

            <div class="empty-state">

                <img class="img-fluid" style="height: 200px"

                     src="<?php echo base_url('assets/img/drawkit/drawkit-nature-man-colour.svg'); ?>" alt="image">

                <h2 class="mt-0"><?php echo $this->lang->line("We could not find any page."); ?></h2>

                <p class="lead"><?php echo $this->lang->line("Please import account if you have not imported yet.") . "<br>" . $this->lang->line("If you have already imported account then enable bot connection for one or more page to continue.") ?></p>

                <a href="<?php echo base_url('social_accounts'); ?>" class="btn btn-outline-primary mt-4"><i

                            class="bx bx-right-arrow-circle"></i> <?php echo $this->lang->line("Continue"); ?></a>

            </div>

        </div>

    </div>



<?php } else { ?>

    <style>
        .row-actions{display:none;}
        tr:hover .row-actions{display:block;}

        #infoscrollbarblock{
            position: absolute;
            bottom: 110px;
            text-align: center;
            width:100%;
        }
    </style>

    <div class="chat-application">
        <div class="content-area-wrapper m-0">
            <div class="sidebar-left">
                <div class="sidebar">
                    <!-- app chat user profile left sidebar start -->
                    <div class="chat-user-profile">
                        <header class="chat-user-profile-header text-center border-bottom">
                            <span class="chat-profile-close">
                                <i class="bx bx-x"></i>
                            </span>
                            <div class="my-2">
                                <div class="avatar">
                                    <img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="user_avatar" height="100" width="100">
                                </div>
                                <h5 class="mb-0">John Doe</h5>
                                <span>Designer</span>
                            </div>
                        </header>
                        <div class="chat-user-profile-content">
                            <div class="chat-user-profile-scroll">
                                <h6 class="text-uppercase mb-1">ABOUT</h6>
                                <p class="mb-2">It is a long established fact that a reader will be distracted by the readable content .</p>
                                <h6>PERSONAL INFORAMTION</h6>
                                <ul class="list-unstyled mb-2">
                                    <li class="mb-25">email@gmail.com</li>
                                    <li>+1(789) 950 -7654</li>
                                </ul>
                                <h6 class="text-uppercase mb-1">CHANNELS</h6>
                                <ul class="list-unstyled mb-2">
                                    <li><a href="javascript:void(0);"># Devlopers</a></li>
                                    <li><a href="javascript:void(0);"># Designers</a></li>
                                </ul>
                                <h6 class="text-uppercase mb-1">SETTINGS</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-50 "><a href="javascript:void(0);" class="d-flex align-items-center"><i class="bx bx-tag mr-50"></i> Add
                                            Tag</a></li>
                                    <li class="mb-50 "><a href="javascript:void(0);" class="d-flex align-items-center"><i class="bx bx-star mr-50"></i>
                                            Important Contact</a>
                                    </li>
                                    <li class="mb-50 "><a href="javascript:void(0);" class="d-flex align-items-center"><i class="bx bx-image-alt mr-50"></i>
                                            Shared
                                            Documents</a></li>
                                    <li class="mb-50 "><a href="javascript:void(0);" class="d-flex align-items-center"><i class="bx bx-trash-alt mr-50"></i>
                                            Deleted
                                            Documents</a></li>
                                    <li><a href="javascript:void(0);" class="d-flex align-items-center"><i class="bx bx-block mr-50"></i> Blocked
                                            Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- app chat user profile left sidebar ends -->
                    <!-- app chat sidebar start -->
                    <div class="chat-sidebar card">
                        <span class="chat-sidebar-close">
                            <i class="bx bx-x"></i>
                        </span>
                        <div class="chat-sidebar-search">
                            <div class="d-flex align-items-center">
                                <div class="chat-sidebar-profile-toggle">
                                    <div class="avatar">
                                        <img src="<?php echo base_url(); ?>assets/img/avatar/avatar-1.png" alt="user_avatar" height="36" width="36">
                                    </div>
                                </div>
                                <fieldset class="form-group position-relative has-icon-left mx-75 mb-0">
                                    <input type="text" class="form-control round" id="chat-search" placeholder="Search">
                                    <div class="form-control-position">
                                        <i class="bx bx-search-alt text-dark"></i>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="chat-sidebar-list-wrapper pt-1 mt-0">


                            <h6 id="refresh_contact_list" class="px-2 pt-2 pb-25 mb-0"><?php echo $this->lang->line('Contacts'); ?><i id="refresh_data" page_table_id="<?php echo $page_table_id; ?>" class="bx bx-refresh float-right cursor-pointer"></i></h6>
                            <ul class="chat-sidebar-list" id="contact_list">

                            </ul>
                        </div>
                    </div>
                    <!-- app chat sidebar ends -->
                </div>
            </div>
            <div class="content-right">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <!-- app chat overlay -->
                        <div class="chat-overlay"></div>
                        <!-- app chat window start -->
                        <section class="chat-window-wrapper">
                            <div class="chat-start">
                                <span class="bx bx-message chat-sidebar-toggle chat-start-icon font-large-3 p-3 mb-1"></span>
                                <h4 class="d-none d-lg-block py-50 text-bold-500"><?php echo $this->lang->line('Select a contact to start a chat!'); ?></h4>
                                <button class="btn btn-light-primary chat-start-text chat-sidebar-toggle d-block d-lg-none py-50 px-1"><?php echo $this->lang->line('Start Conversation!'); ?></button>
                            </div>
                            <div class="chat-area d-none">
                                <div class="chat-header">
                                    <header class="d-flex justify-content-between align-items-center border-bottom px-1 py-75 mb-0 pb-0">
                                        <div class="d-flex align-items-center">


                                            <div class="chat-sidebar-toggle d-block d-lg-none mr-1"><i class="bx bx-menu font-large-1 cursor-pointer"></i>
                                            </div>

                                            <div class="avatar chat-profile-toggle m-0 mr-1">
                                                <img src="<?php echo base_url(); ?>assets/img/avatar/avatar-1.png" alt="avatar" height="36" width="36" />
                                            </div>

                                            <h6 class="mb-0 chat-profile-toggle" id="livechat_name_header"></h6>

                                        </div>
                                        <div class="chat-header-icons  d-none">
                                            <span class="chat-icon-favorite">
                                                <i class="bx bx-star font-medium-5 cursor-pointer"></i>
                                            </span>
                                            <span class="dropdown">
                                                <i class="bx bx-dots-vertical-rounded font-medium-4 ml-25 cursor-pointer dropdown-toggle nav-hide-arrow cursor-pointer" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                                                </i>
                                                <span class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="JavaScript:void(0);"><i class="bx bx-pin mr-25"></i> Pin to top</a>
                                                    <a class="dropdown-item" href="JavaScript:void(0);"><i class="bx bx-trash mr-25"></i> Delete chat</a>
                                                    <a class="dropdown-item" href="JavaScript:void(0);"><i class="bx bx-block mr-25"></i> Block</a>
                                                </span>
                                            </span>
                                        </div>
                                    </header>
                                </div>
                                <!-- chat card start -->
                                <div class="card chat-wrapper shadow-none">
                                    <div class="card-body chat-container">
                                        <div class="chat-content" id="chat-content-section">

                                        </div>

                                    </div>
                                    <div id="infoscrollbarblock" style="display: none;">
                                        <a href="#" type="button" class="btn btn-icon rounded-circle btn-info"><i class='bx bx-down-arrow-alt'></i></a>
                                    </div>
                                    <div class="card-footer chat-footer border-top px-2 pt-1 pb-0 mb-1">


                                        <form class="d-flex align-items-center" onsubmit="" action="javascript:void(0);">
                                                    <div class="input-group-append">
                                                        <button type="button" title="<?php echo $this->lang->line('Send Postback Template');?>" class="btn btn-danger" id="postback_reply_button" data-toggle="modal" data-target="#postbackModal">
                                                            <i class='bx bx-bot'></i>
                                                        </button>
                                                    </div>
                                                    <?php echo form_dropdown('message_tag', $tag_list, 'HUMAN_AGENT','class="form-control select2" id="message_tag"'); ?>
                                                    <input type="text" class="form-control chat-message-send mx-1" placeholder="<?php echo $this->lang->line('Type your message here...'); ?>">
                                                    <button id="final_reply_button" type="submit" class="btn btn-primary glow send d-lg-flex"><i class="bx bx-paper-plane"></i>
                                                        <span class="d-none d-lg-block ml-1"><?php echo $this->lang->line('Send'); ?></span></button>
                                        </form>
                                    </div>
                                </div>
                                <!-- chat card ends -->
                            </div>
                        </section>




                        <section class="chat-profile d-none"  >

                            <header class="chat-profile-header chat-profile-header text-center border-bottom ">
                                        <span class="chat-profile-close">
                                            <i class="bx bx-x"></i>
                                        </span>

                            </header>


                            <div class="chat-profile-content pl-1 pr-1 ps--active-y">


                                <div class="card card-primary shadow-none">
                                    <div class="card-header">
                                        <h4 class="w-100">
                                            <?php echo $this->lang->line('Actions'); ?>
                                        </h4>
                                        <div class="heading-elements">
                                            <a class="btn btn-outline-primary btn-circle n_subscriber_actions_modal" href=""><i
                                                        class="bx bx-briefcase"></i></a>
                                        </div>


                                    </div>


                                    <div class="card-body p-0" id="subscriber_action">

                                    </div>

                                </div>


                            </div>
                        </section>



                        <!--                             </div>
                         -->                        </section>
                        <!-- app chat profile right sidebar ends -->

                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="n_subscriber_actions_modal" data-backdrop="static" data-keyboard="false">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header" style="padding:15px;">

                    <h3 class="modal-title"><?php echo $this->lang->line("Subscriber Actions"); ?></h3>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <i class="bx bx-x"></i>

                    </button>

                </div>



                <div class="modal-body" id="subscriber_actions_modal_body" style="padding:0 15px 15px 15px;"

                     data-backdrop="static" data-keyboard="false">



                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                        <li class="nav-item">

                            <a class="nav-link d-none" id="default-tab" data-toggle="tab" href="#default" role="tab"

                               aria-controls="default"

                               aria-selected="true"><?php echo $this->lang->line("Subscriber Data"); ?></a>

                        </li>



                        <?php if ($user_input_flow_exist == 'yes') : ?>

                            <li class="nav-item">

                                <a class="nav-link active" id="flowanswers-tab" data-toggle="tab" href="#flowanswers"

                                   role="tab" aria-controls="flowanswers"

                                   aria-selected="false"><?php echo $this->lang->line("User Input Flow Answer"); ?></a>

                            </li>

                            <li class="nav-item">

                                <a class="nav-link" id="customfields-tab" data-toggle="tab" href="#customfields"

                                   role="tab" aria-controls="customfields"

                                   aria-selected="false"><?php echo $this->lang->line("Custom Fields"); ?></a>

                            </li>

                        <?php endif; ?>



                        <?php if ($webview_access == 'yes') : ?>

                            <li class="nav-item">

                                <a class="nav-link" id="formdata-tab" data-toggle="tab" href="#formdata" role="tab"

                                   aria-controls="formdata"

                                   aria-selected="false"><?php echo $this->lang->line("Custom Form Data"); ?></a>

                            </li>

                        <?php endif; ?>

                        <?php if ($ecommerce_exist == 'yes') : ?>

                            <li class="nav-item">

                                <a class="nav-link" id="purchase-tab" data-toggle="tab" href="#purchase" role="tab"

                                   aria-controls="purchase"

                                   aria-selected="false"><?php echo $this->lang->line("Purchase History"); ?></a>

                            </li>

                        <?php endif; ?>



                    </ul>



                    <div class="tab-content" id="myTabContent">



                        <div class="tab-pane fade d-none" id="default" role="tabpanel" aria-labelledby="default-tab">

                            <div class="row multi_layout">

                            </div>

                        </div>



                        <div class="tab-pane fade" id="formdata" role="tabpanel" aria-labelledby="formdata-tab">

                            <div class="card shadow-none"

                                 style="border:1px solid #dee2e6;border-top:none;border-radius:0">

                                <div class="card-body">

                                    <div class="row formdata_div" style="padding-top:20px;"></div>

                                </div>

                            </div>

                        </div>



                        <div class="tab-pane fade active show" id="flowanswers" role="tabpanel"

                             aria-labelledby="flowanswers-tab">

                            <div class="card shadow-none"

                                 style="border:1px solid #dee2e6;border-top:none;border-radius:0">

                                <div class="card-body">

                                    <div class="row flowanswers_div" style="padding-top:20px;"></div>

                                </div>

                            </div>

                        </div>



                        <div class="tab-pane fade" id="customfields" role="tabpanel" aria-labelledby="customfields-tab">

                            <div class="card shadow-none"

                                 style="border:1px solid #dee2e6;border-top:none;border-radius:0">

                                <div class="card-body">

                                    <div class="row customfields_div" style="padding-top:20px;"></div>

                                </div>

                            </div>

                        </div>



                        <div class="tab-pane fade" id="purchase" role="tabpanel" aria-labelledby="purchase-tab">

                            <div class="card shadow-none data-card"

                                 style="border:1px solid #dee2e6;border-top:none;border-radius:0">

                                <div class="card-body">

                                    <div class="row purchase_div" style="padding-top:20px;"></div>

                                    <div class="row">

                                        <div class="col-12 col-md-9">

                                            <?php

                                            $status_list[''] = $this->lang->line("Status");

                                            echo

                                                '<div class="input-group mb-3" id="searchbox">

                            <div class="input-group-prepend d-none">

                              <input type="text" value="" name="search_subscriber_id" id="search_subscriber_id">

                            </div>

                            <div class="input-group-prepend d-none">

                              ' . form_dropdown('search_status', $status_list, '', 'class="select2 form-control" id="search_status"') . '

                            </div>

                            <input type="text" class="form-control" id="search_value2" autofocus name="search_value2" placeholder="' . $this->lang->line("Search...") . '" style="max-width:25%;">

                            <div class="input-group-append">

                              <button class="btn btn-primary" type="button" id="search_action"><i class="bx bx-search"></i> <span class="d-none d-sm-inline">' . $this->lang->line("Search") . '</span></button>

                            </div>

                          </div>'; ?>

                                        </div>



                                        <div class="col-12 col-md-3">



                                            <?php

                                            echo $drop_menu = '<a href="javascript:;" id="search_date_range" class="btn btn-primary float-right has-icon-left btn-icon"><i class="bx bx-calendar"></i> ' . $this->lang->line("Choose Date") . '</a><input type="hidden" id="search_date_range_val">';

                                            ?>





                                        </div>

                                    </div>



                                    <div class="table-responsive2">

                                        <table class="table table-bordered" id="mytable2">

                                            <thead>

                                            <tr>

                                                <th>#</th>

                                                <th style="vertical-align:middle;width:20px">

                                                    <input class="regular-checkbox" id="datatableSelectAllRows"

                                                           type="checkbox"/><label for="datatableSelectAllRows"></label>

                                                </th>

                                                <th style="max-width: 130px"><?php echo $this->lang->line("Status") ?></th>

                                                <th><?php echo $this->lang->line("Coupon") ?></th>

                                                <th><?php echo $this->lang->line("Amount") ?></th>

                                                <th><?php echo $this->lang->line("Currency") ?></th>

                                                <th><?php echo $this->lang->line("Method") ?></th>

                                                <th><?php echo $this->lang->line("Transaction ID") ?></th>

                                                <th><?php echo $this->lang->line("Invoice") ?></th>

                                                <th><?php echo $this->lang->line("Docs") ?></th>

                                                <th><?php echo $this->lang->line("Ordered at") ?></th>

                                                <th><?php echo $this->lang->line("Paid at") ?></th>

                                            </tr>

                                            </thead>

                                        </table>

                                    </div>



                                </div>

                            </div>

                        </div>



                    </div>





                </div>



            </div>

        </div>

    </div>





<?php } ?>



