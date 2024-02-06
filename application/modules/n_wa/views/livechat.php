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



<?php
$include_select2 = 1;
$include_dropzone = 1;
$include_cropper = 1;
$include_datatable=1;

if (!defined('NVX')) { ?>

    <style>
        .change_contact  .avatar,
        .chat-avatar .avatar{
            white-space: nowrap;
            background-color: #c3c3c3;
            border-radius: 50%;
            position: relative;
            cursor: pointer;
            color: #FFFFFF;
            display: inline-flex;
            font-size: 0.8rem;
            text-align: center;
            vertical-align: middle;
            margin: 5px;
            height: initial;
            width: initial;
        }
        .chat-avatar .avatar img{
            height: 36px;
            width: 36px;
        }

        .avatar .avatar-content {
            width: 32px;
            height: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .avatar .avatar-content .avatar-icon {
            font-size: 1.2rem;
        }
        html .content.app-content .content-overlay {
            position: fixed;
            opacity: 0;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            cursor: pointer;
            transition: all 0.7s;
            z-index: -1;
        }

        .sidebar {
            position: relative;
            width: 100%;
        }

        @media (min-width: 992px) {
            .sidebar {
                vertical-align: top;
            }
        }

        html .content.app-content .content-area-wrapper .content-wrapper {
            margin-top: 0;
            height: calc(100vh - 9rem);
        }



        html .content.app-content .content-area-wrapper {
            height: calc(100% - 5rem);
            margin: calc(5rem) 2.2rem 0;
            display: flex;
            position: relative;
        }
        @media (min-width: 992px) {
            body .content-right {
                width: calc(100% - 290px);
                float: right;
            }
            body .content-left {
                width: calc(100% - 290px);
                float: left;
            }
            body .content-detached {
                width: 100%;
            }
            body .content-detached.content-right {
                float: right;
                margin-left: -260px;
            }
            body .content-detached.content-right .content-body {
                margin-left: calc(260px + 2.2rem);
            }
            body .content-detached.content-left {
                float: left;
                margin-right: -260px;
            }
            body .content-detached.content-left .content-body {
                margin-right: calc(260px + 2.2rem);
            }
            .sidebar-right.sidebar-sticky {
                float: right !important;
                margin-left: -260px;
                width: 260px !important;
                margin-top: 6rem;
            }
            [data-col="content-left-sidebar"] .sticky-wrapper {
                float: left;
            }
        }
        @media (min-width: 992px) {
            .sidebar-left {
                float: left;
            }
            .sidebar-right {
                float: right;
            }
        }
    </style>

    <section class="section section_custom">
        <div class="section-header">
            <h1><i class="fa fa-search-location"></i> <?php echo $page_title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>n_telegram"><?php echo $this->lang->line("WhatsApp"); ?></a></div>
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>n_wa"><?php echo $this->lang->line('WhatsApp bot'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <?php
    $jodit = 1;
    $include_select2 = 1;
}
?>
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
                            <h6 class="px-2 pt-1 pb-25 mb-0" id="filters_add"><?php echo $this->lang->line('Filters'); ?><i class="bx bx-plus float-right cursor-pointer"></i></h6>
                            <div class="row m-0 pt-1">
                                <div class="col-12" id="livechat_filters_labels" style="display: none">
                                    <label for="livechat_filters_labels_select"><?php echo $this->lang->line('Label'); ?></label>
                                    <select class="form-control select2" name="livechat_filters_labels" id="livechat_filters_labels_select"  style="width:100%;">
                                    </select>

                                    <div class="form-group mt-1">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="state_human_agent"
                                                   id="state_human_agent" value="1"
                                                   class="custom-control-input">
                                            <label class="custom-control-label mr-1"
                                                   for="state_human_agent"></label>
                                            <span><?php echo $this->lang->line('Show only Human Agent'); ?></span>
                                            <span class="text-danger"><?php echo form_error('state_human_agent'); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>



                            <h6 id="refresh_contact_list" class="px-2 pt-2 pb-25 mb-0"><?php echo $this->lang->line('Contacts'); ?><i class="bx bx-refresh float-right cursor-pointer"></i></h6>
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
                                            <h6 class="mb-0" id="livechat_name_header"></h6>
                                            <div class="ml-1 form-group mb-0">
                                                <label class="custom-switch">
                                                    <input type="checkbox" name="state_human_agent_user"
                                                           id="state_human_agent_user" value="1"
                                                           class="custom-control-input">
                                                    <label class="custom-control-label mr-1"
                                                           for="state_human_agent_user"></label>
                                                    <span><?php echo $this->lang->line('Bot disabled'); ?></span>
                                                    <span class="text-danger"><?php echo form_error('state_human_agent_user'); ?></span>
                                                </label>
                                            </div>
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
                                        <div class="chat-content">

                                        </div>
                                    </div>
                                    <div id="infoscrollbarblock" style="display: none;">
                                        <a href="#" type="button" class="btn btn-icon rounded-circle btn-info"><i class='bx bx-down-arrow-alt'></i></a>
                                    </div>
                                    <div class="card-footer chat-footer border-top px-2 pt-1 pb-0 mb-1">

                                        <form class="d-flex align-items-center" onsubmit="chatMessagesSend();" action="javascript:void(0);">
                                            <a href="#" id="select-files" class="btn btn-primary"><i class="bx bx-file"></i></a>
                                            <i class="bx bx-face cursor-pointer d-none"></i>
                                            <i class="bx bx-paperclip ml-1 cursor-pointer  d-none"></i>
                                            <input type="text" class="form-control chat-message-send mx-1" placeholder="Type your message here...">
                                            <button type="submit" class="btn btn-primary glow send d-lg-flex"><i class="bx bx-paper-plane"></i>
                                                <span class="d-none d-lg-block ml-1"><?php echo $this->lang->line('Send'); ?></span></button>
                                        </form>
                                    </div>
                                </div>
                                <!-- chat card ends -->
                            </div>
                        </section>
                        <!-- app chat window ends -->
                        <!-- app chat profile right sidebar start -->
                        <section class="chat-profile  d-none">
                            <header class="chat-profile-header text-center border-bottom">
                                <span class="chat-profile-close">
                                    <i class="bx bx-x"></i>
                                </span>
                                <div class="my-2">
                                    <div class="avatar">
                                        <img src="<?php echo base_url(); ?>assets/img/avatar/avatar-1.png" alt="chat avatar" height="100" width="100">
                                    </div>
                                    <h5 class="app-chat-user-name mb-0">Elizabeth Elliott</h5>
                                    <span>Devloper</span>
                                </div>
                            </header>
                            <div class="chat-profile-content p-2">
                                <h6 class="mt-1">ABOUT</h6>
                                <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                <h6 class="mt-2">PERSONAL INFORMATION</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-25">email@gmail.com</li>
                                    <li>+1(789) 950-7654</li>
                                </ul>
                            </div>
                        </section>
                        <!-- app chat profile right sidebar ends -->

                    </div>
                </div>
            </div>
        </div>
</div>
