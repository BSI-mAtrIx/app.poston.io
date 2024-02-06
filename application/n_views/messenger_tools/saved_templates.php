<?php
$include_upload = 1;  //upload_js
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

<?php


$image_upload_limit = 1;
if ($this->config->item('messengerbot_image_upload_limit') != '')
    $image_upload_limit = $this->config->item('messengerbot_image_upload_limit');
?>
<style>
    .category_sidebar {
        position: sticky;
        top: 0;
    }

    .article.article-style-c {
        border-radius: 20px !important;
    }

    .article.article-style-c .article-header {
        height: 150px !important;
        background-color: none !important;
    }

    .article.article-style-c .article-details .article-category {
        margin-bottom: 10px !important;
    }

    .article .article-header .article-image {
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
    }

    .article .article-details {
        padding: 15px;
        line-height: 0px !important;
        background-color: transparent;
    }

    .article.article-style-c .template_description {
        line-height: 20px;
        word-break: break-all;
        height: 40px;
    }



    .list-group-flush .list-group-item:first-child {
        border-top-right-radius: 5px;
        border-top-left-radius: 5px;
    }

    .list-group-flush .list-group-item:last-child {
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
    }

    .list-group-flush .list-group-item:hover {
        color: #6777ef;
    }

    .list-group-flush .list-group-item:hover {
        -webkit-animation: swing 1s ease;
        animation: swing 1s ease;
        -webkit-animation-iteration-count: 1;
        animation-iteration-count: 1;
    }

    #bot_category {
        width: 100% !important;
    }

    @keyframes swing {
        15% {
            -webkit-transform: translateX(5px);
            transform: translateX(5px);
        }
        30% {
            -webkit-transform: translateX(-5px);
            transform: translateX(-5px);
        }
        50% {
            -webkit-transform: translateX(3px);
            transform: translateX(3px);
        }
        65% {
            -webkit-transform: translateX(-3px);
            transform: translateX(-3px);
        }
        80% {
            -webkit-transform: translateX(2px);
            transform: translateX(2px);
        }
        100% {
            -webkit-transform: translateX(0);
            transform: translateX(0);
        }
    }

    .dotted_elipse i {
        font-size: 18px !important;
    }

    .pagination {
        align-items: center;
        justify-content: center;
    }

    div.tooltip {
        top: 0px !important;
    }
</style>


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("messenger_bot/bot_list"); ?>"><?php echo $this->lang->line("Bot Manager"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="#" class="btn btn-primary mb-1 export_bot">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Upload Template"); ?>
        </a>
        <?php if ($selected_global_media_type == 'fb') { ?>
            <a href="#" class="btn btn-primary social_switch mb-1"
               data-value="fb"><?php echo $this->lang->line("Change to Instagram"); ?></a>
        <?php } else { ?>
            <a href="#" class="btn btn-primary social_switch mb-1"
               data-value="ig"><?php echo $this->lang->line("Change to Facebook"); ?></a>
        <?php } ?>
    </div>
</div>

<?php $category_id = isset($_GET['category']) ? $_GET['category'] : ""; ?>
<div class="section-body">

    <div class="row">
        <div class="col-12 col-md-2">
            <div class="category_sidebar">
                <ul class="list-group  list-group-flush">
                    <li class="list-group-item pointer <?php if ($category_id == '') echo 'active'; ?>">
                        <a class="<?php if ($category_id == '') echo 'active text-white'; ?> "
                           href="<?php echo base_url("messenger_bot/saved_templates"); ?>"><i
                                    class="bx bx-book-open"></i> <?php echo $this->lang->line('All Categories'); ?></a>
                    </li>
                    <?php foreach ($category_list as $category) { ?>
                        <li class="list-group-item pointer <?php if ($category_id == $category['id']) echo 'active'; ?>"
                            title="<?php echo $category['category_name']; ?>">
                            <a href="<?php echo base_url("messenger_bot/saved_templates/?category={$category['id']}"); ?>" class="<?php if ($category_id == $category['id']) echo 'text-white'; ?>"
                               title="<?php echo $category['category_name']; ?>">
                                <i class="bx bx-book-open"></i> <?php echo (strlen($category['category_name']) > 10) ? substr($category['category_name'], 0, 12) . '...' : $category['category_name']; ?>
                            </a>
                            <?php if ($this->user_id == $category['user_id']) : ?>
                                <a href="#" class="float-right <?php if ($category_id == $category['id']) echo 'text-white'; ?> delete_template_category"
                                   title="<?php echo $this->lang->line("Delete Category") ?>"
                                   cat_id="<?php echo $category['id']; ?>"><i class="bx bx-trash"></i></a>
                            <?php else : ?>
                                <a href="#" class="float-right <?php if ($category_id == $category['id']) echo 'text-white'; ?>" disabled="disabled"
                                   title="<?php echo $this->lang->line("You do not have permission to delete this.") ?>"><i
                                            class="bx bx-trash"></i></a>
                            <?php endif; ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="col-12 col-md-9">
            <div class="row">
                <?php foreach ($template_lists as $template) :
                    $preview_img = isset($template["preview_image"]) ? $template["preview_image"] : "";
                    if ($preview_img != '' && file_exists('upload/image/' . $template['user_id'] . '/' . $preview_img)) {
                        $preview_img = base_url('upload/image/' . $template['user_id'] . '/' . $preview_img);
                    } else {
                        $preview_img = base_url() . 'assets/img/news/img01.jpg';
                    }
                    ?>

                    <div class="col-12 col-md-4">
                        <article class=" card article article-style-c">
                            <img class="card-img-top img-fluid" src="<?php echo $preview_img; ?>" alt="Card image cap">
                            <div class="article-details template_details">
                                <div class="article-category">
                                    <a><?php echo (strlen($template['category_name']) > 12) ? substr($template['category_name'], 0, 10) . '...' : $template['category_name']; ?></a>
                                    <div class="bullet"></div>
                                    <a><?php echo date_time_calculator($template['saved_at'], true) ?></a>
                                </div>
                                <div class="article-title template_title">
                                    <h4>
                                        <a href="#"><?php echo (strlen($template['template_name']) > 24) ? substr($template['template_name'], 0, 24) . '...' : $template['template_name']; ?></a>
                                    </h4>
                                </div>
                                <div class="template_description text-muted"><?php echo (strlen($template['description']) > 70) ? substr($template['description'], 0, 60) . '...' : $template['description']; ?></div>
                                <hr>
                                <div class="text-center">

                                    <div class="text-center mb-1">
                                        <?php $action_width = (4 * 47) + 20; ?>
                                        <a target="_BLANK" data-toggle='tooltip'
                                           title='<?php echo $this->lang->line('View Template'); ?>'
                                           href='<?php echo base_url('messenger_bot/saved_template_view/' . $template['id']); ?>'
                                           class='btn btn-circle btn-outline-primary'><i class='bx bxs-show'></i></a>
                                        <?php if ($template['user_id'] == $this->user_id) { ?>
                                            <a data-toggle='tooltip'
                                               title='<?php echo $this->lang->line('Edit Template'); ?>' href=''
                                               class='btn btn-circle btn-outline-warning export_bot_edit'
                                               table_id="<?php echo $template['id'] ?>"><i class='bx bx-edit'></i></a>
                                        <?php } ?>

                                        <?php if ($n_config['saved_template_hide_save_btn'] == 'false' OR $this->session->userdata("user_type") == 'Admin') { ?>
                                        <a data-toggle='tooltip'
                                           title='<?php echo $this->lang->line('Download Template'); ?>'
                                           href='<?php echo base_url("messenger_bot/export_bot_download/" . $template['id']) ?>'
                                           class='btn btn-circle btn-outline-success'
                                           table_id="<?php echo $template['id'] ?>"><i
                                                    class='bx bxs-cloud-download'></i></a>
                                        <?php } ?>

                                        <a data-toggle='tooltip'
                                           title='<?php echo $this->lang->line('Delete Template'); ?>' href=''
                                           class='btn btn-circle btn-outline-danger delete_template'
                                           table_id="<?php echo $template['id'] ?>"><i class='bx bx-trash'></i></a>
                                    </div>

                                    <button class="btn btn-primary btn-block install_template"
                                            current_template_id="<?php echo $template['id']; ?>"
                                            media_type="<?php echo $media_type; ?>"><?php echo $this->lang->line('Install Template'); ?></button>


                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php echo $page_links; ?>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="export_bot_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding-left: 30px;">
                <h3 class="modal-title"><?php echo $this->lang->line("Upload Template"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="export_bot_modal_body">

                <form id="export_bot_form" method="POST">
                    <div class="col-12">
                        <div class="well text-justify" style="border:1px solid #6777ef;padding:15px;color:#6777ef;">
                            <?php echo $this->lang->line("Webview form will not be exported/imported. If bot settings have webview form created, then after importing that bot settings for a page, you will need to create new form & change the form URL by the new URL for that page."); ?>
                        </div>
                    </div>
                    <br>
                    <!-- <input type="hidden" name="export_id" id="export_id"> -->
                    <div class="col-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('Template Name'); ?> *</label>
                            <input type="text" name="template_name" class="form-control" id="template_name">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('Template Description'); ?> </label>
                            <textarea type="text" rows="4" name="template_description" class="form-control"
                                      id="template_description"></textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label> <?php echo $this->lang->line('Template Category'); ?></label>
                            <small class="blue float-right pointer" id="create_category"><i
                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Create category'); ?>
                            </small>
                            <select name="bot_category" id="bot_category" class="form-control select2 bot_category"
                                    style="width:100% !important">
                                <option value=""><?php echo $this->lang->line('Select Category'); ?></option>
                                <?php foreach ($category_list as $key => $value) {
                                    echo '<option value="' . $value['id'] . '">' . $value['category_name'] . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('Template Preview Image'); ?>
                                        <a href="#" data-placement="top" data-toggle="popover"
                                           title="<?php echo $this->lang->line("Template Preview Image"); ?>"
                                           data-content="<?php echo $this->lang->line("Upload a preview image for this template and the image will be showed as preview image of the template.") . 'Square image like (400x400) is recommended.'; ?>"><i
                                                    class='bx bx-info-circle'></i> </a>&nbsp;
                                        <span style="cursor:pointer;"
                                              title="<?php echo $this->lang->line('Preview'); ?>"
                                              class="badge badge-status blue load_preview_modal float-right"
                                              item_type="image" file_path=""><i class="bx bx-show"></i></span>
                                    </label>


                                    <input type="hidden" name="template_preview_image" class="form-control"
                                           id="template_preview_image">
                                    <div id="template_preview_image_div"><?php echo $this->lang->line("upload") ?></div>
                                </div>
                            </div>

                            <div class="col-6 type3">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('Upload Template JSON'); ?></label>
                                    <div class="form-group">
                                        <div id="json_upload"><?php echo $this->lang->line('Upload'); ?></div>
                                        <input type="hidden" id="json_upload_input" name="json_upload_input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($this->session->userdata("user_type") == 'Admin') { ?>
                        <div class="col-12">

                            <div class="form-group">
                                <div class="control-label"><?php echo $this->lang->line('Template Access'); ?> *</div>
                                <div class="custom-switches-stacked mt-2">
                                    <label class="custom-switch">
                                        <input type="radio" name="template_access" value="private" id="only_me_input"
                                               class="custom-switch-input" checked>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description"><?php echo $this->lang->line("Only me"); ?></span>
                                    </label>
                                    <label class="custom-switch">
                                        <input type="radio" name="template_access" value="public" id="other_user_input"
                                               class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description"><?php echo $this->lang->line("Me as well as other users"); ?></span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 hidden" id="allowed_package_ids_con">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('Choose User Packages'); ?> *</label><br/>
                                <?php echo form_dropdown('allowed_package_ids[]', $package_list, '', 'class="form-control select2" style="width:100%" id="allowed_package_ids" multiple'); ?>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-6">
                            <a href="#" id="export_bot_submit" class="btn btn-primary"><i
                                        class="bx bx-export"></i> <?php echo $this->lang->line("Upload Template"); ?>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" id="cancel_bot_submit" class="btn btn-secondary float-right"><i
                                        class="bx bx-x"></i> <?php echo $this->lang->line("Cancel"); ?></a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_export_bot_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding-left: 30px;">
                <h3 class="modal-title"><i
                            class="bx bx-edit"></i> <?php echo $this->lang->line("Edit Saved Template"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="edit_export_bot_modal_body">
                <br>
                <div class="text-center waiting previewLoader"><i class="bx bx-loader bx-spin blue text-center"
                                                                  style="font-size: 40px;"></i></div>
                </br>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_for_preview" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-show"></i> <?php echo $this->lang->line('item preview'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div id="image_preview_div_modal" style="display: none;">
                    <img id="modal_preview_image" width="100%" src="">
                </div>
                <div id="video_preview_div_modal" style="display: none;">
                    <video width="100%" id="modal_preview_video" controls>

                    </video>
                </div>
                <div id="audio_preview_div_modal" style="display: none;">
                    <audio width="100%" id="modal_preview_audio" controls>

                    </audio>
                </div>
                <div>
                    <input class="form-control" type="text" id="preview_text_field">
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="install_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bxs-cloud-download"></i> <?php echo $this->lang->line('Install Template'); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form action="#" id="install_template_form" method="POST">
                            <input type="hidden" name="template_id" id="template_id" value="">
                            <input type="hidden" name="media_type" id="media_type" value="">
                            <div class="form-group">
                                <?php if ($media_type == 'ig') : ?>
                                    <label for=""> <?php echo $this->lang->line('Intall to account'); ?> </label>
                                <?php else : ?>
                                    <label for=""> <?php echo $this->lang->line('Intall to Page'); ?> </label>
                                <?php endif; ?>
                                <select name="page_id" id="page_id" class="form-control select2"
                                        style="width:100% !important;">
                                    <?php if ($media_type == 'ig') : ?>
                                        <label for=""> <?php echo $this->lang->line('Select Account'); ?> </label>
                                    <?php else : ?>
                                        <label for=""> <?php echo $this->lang->line('Select Page'); ?> </label>
                                    <?php endif; ?>

                                    <?php foreach ($page_lists as $page) {
                                        if ($media_type == 'ig')
                                            echo "<option value={$page['id']}>{$page['insta_username']} [{$page['account_name']}]</option>";
                                        else
                                            echo "<option value={$page['id']}>{$page['page_name']} [{$page['account_name']}]</option>";
                                    } ?>
                                </select>
                            </div>

                            <div>
                                <button class="btn btn-primary btn-block  install_template_action"><i
                                            class="bx bxs-cloud-download"></i><?php echo $this->lang->line('Install'); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




