<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 1;
$include_tagsinput = 1;
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
                                href="<?php echo site_url() . 'blog/posts'; ?>"><?php echo $this->lang->line("Blog Manager"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo $this->lang->line("Write Your Post") ?></h4>
                </div>
                <form class="form-horizontal" name="post-store"
                      action="<?php echo site_url() . 'blog/add_post_action'; ?>" method="POST">
                    <div class="card-body">
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><?php echo $this->lang->line("Title") ?></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="title" name="title" value="<?php echo set_value('title'); ?>"
                                       class="form-control" placeholder="<?php echo $this->lang->line("Title") ?>">
                                <div class="red title_error"></div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><?php echo $this->lang->line("Keywords") ?></label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" id="keywords" name="keywords"
                                       value="<?php echo set_value('keywords'); ?>" class="form-control inputtags"
                                       placeholder="<?php echo $this->lang->line("Keywords") ?>">
                                <div class="red title_error"></div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><?php echo $this->lang->line("Category") ?></label>
                            <div class="col-sm-12 col-md-7">
                                <?php echo form_dropdown('category_id', $category_lists, set_value('category_id'), array('class' => 'select2 form-control', 'id' => 'category_id')); ?>
                                <div class="red category_id_error"></div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="body"
                                   class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><?php echo $this->lang->line("Content") ?></label>
                            <div class="col-sm-12 col-md-7">
                                <textarea name="body" id="body"></textarea>
                                <div class="red body_error"></div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><?php echo $this->lang->line("Thumbnail") ?></label>
                            <div class="col-sm-12 col-md-4">
                                <div id="dropzone" class="dropzone dz-clickable">
                                    <div class="dz-default dz-message" style="">
                                        <input class="form-control" name="thumbnail" id="thumbnail" placeholder=""
                                               type="hidden">
                                        <span style="font-size: 20px;"><i class="bx bx-cloud-upload"
                                                                          style="font-size: 35px;color: #6777ef;"></i> <?php echo $this->lang->line('Upload'); ?></span>
                                    </div>
                                </div>
                                <div class="red thumbnail_error"></div>
                                <span class="text-muted"><?php echo $this->lang->line("Maximum Size 1MB, Recommended dimension 750x400"); ?></span>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><?php echo $this->lang->line("Tags") ?></label>
                            <div class="col-sm-12 col-md-7">
                                <?php echo form_dropdown('tags[]', $tag_lists, set_value('tags'), array('class' => 'select2 form-control', 'id' => 'tags', 'multiple' => true)); ?>
                                <span class="red tags_error"></span>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><?php echo $this->lang->line('Status'); ?></label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control selectric" name="status" id="status">
                                    <option value="1"><?php echo $this->lang->line('Publish'); ?></option>
                                    <option value="0"><?php echo $this->lang->line('Draft'); ?></option>
                                    <option value="2"><?php echo $this->lang->line('Pending'); ?></option>
                                </select>
                                <span class="red status_error"></span>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button name="submit" type="submit" id="save_post" class="btn btn-primary"><i
                                            class="bx bxs-save"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span>
                                </button>
                                <button type="button" class="btn btn-secondary float-right"
                                        onclick='goBack("blog/posts",0)'><i class="bx bx-trash"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span>
                                </button>
                            </div>
                        </div>
                    </div><!--/.card-body-->
                </form>
            </div>
        </div>
    </div>
</div>


