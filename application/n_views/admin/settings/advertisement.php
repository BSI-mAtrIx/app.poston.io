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

<?php
if (array_key_exists(0, $config_data))
    $section1_html = $config_data[0]["section1_html"];
else $section1_html = "";

if (array_key_exists(0, $config_data))
    $section1_html_mobile = $config_data[0]["section1_html_mobile"];
else $section1_html_mobile = "";;

if (array_key_exists(0, $config_data))
    $section2_html = $config_data[0]["section2_html"];
else $section2_html = "";;

if (array_key_exists(0, $config_data))
    $section3_html = $config_data[0]["section3_html"];
else $section3_html = "";;

if (array_key_exists(0, $config_data))
    $section4_html = $config_data[0]["section4_html"];
else $section4_html = "";

if (array_key_exists(0, $config_data))
    $status = $config_data[0]["status"];
else $status = "1";

if ($status == 0) $class = "disabled";
else $class = "";

$placeholder = htmlspecialchars('<img src="http://yoursite.com/images/sample.png">');
?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="<?php echo base_url("admin/advertisement_settings_action"); ?>" method="POST">

                <input type="hidden" name="csrf_token" id="csrf_token"
                       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="force_https"><i
                                        class="bx bx-bullseye"></i> <?php echo $this->lang->line('Display/Hide Advertisement'); ?>
                                ?</label>
                            <div class="custom-switches-stacked mt-2">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="status" id="status_1" value="1"
                                                   class="custom-control-input" <?php if ($status == '1') echo 'checked'; ?>>
                                            <label class="custom-control-label mr-1" for="status_1"></label>
                                            <span><?php echo $this->lang->line('I want to display advertisement'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="custom-control custom-switch custom-control-inline">
                                            <input type="radio" name="status" id="status_2" value="0"
                                                   class="custom-control-input" <?php if ($status == '0') echo 'checked'; ?>>
                                            <label class="custom-control-label mr-1" for="status_2"></label>
                                            <span><?php echo $this->lang->line('I do not want to display advertisement'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger"><?php echo form_error('status'); ?></span>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Section - 1 (970x90 px)"); ?>
                                    </label>
                                    <textarea name="section1_html" id="section1_html"
                                              placeholder="<?php echo $placeholder; ?>"
                                              class="change_status form-control <?php echo $class; ?>"><?php echo $section1_html; ?></textarea>
                                    <span class="text-danger"><?php echo form_error('section1_html'); ?></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Section - 1 : Mobile  (320x100 px)"); ?>
                                    </label>
                                    <textarea name="section1_html_mobile" placeholder="<?php echo $placeholder; ?>"
                                              id="section1_html_mobile"
                                              class="change_status form-control <?php echo $class; ?>"><?php echo $section1_html_mobile; ?></textarea>
                                    <span class="text-danger"><?php echo form_error('section1_html_mobile'); ?></span>
                                    <div class="space"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Section: 2 (300x250 px)"); ?>
                                    </label>
                                    <textarea name="section2_html" placeholder="<?php echo $placeholder; ?>"
                                              id="section2_html"
                                              class="change_status form-control <?php echo $class; ?>"><?php echo $section2_html; ?></textarea>
                                    <span class="text-danger"><?php echo form_error('section2_html'); ?></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Section: 3 (300x250 px)"); ?>
                                    </label>
                                    <textarea name="section3_html" placeholder="<?php echo $placeholder; ?>"
                                              id="section3_html"
                                              class="change_status form-control <?php echo $class; ?>"><?php echo $section3_html; ?></textarea>
                                    <span class="text-danger"><?php echo form_error('section3_html'); ?></span>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Section: 4 (300x600 px)"); ?>
                                    </label>
                                    <textarea name="section4_html" placeholder="<?php echo $placeholder; ?>"
                                              id="section4_html"
                                              class="change_status form-control <?php echo $class; ?>"><?php echo $section4_html; ?></textarea>
                                    <span class="text-danger"><?php echo form_error('section4_html'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-whitesmoke">
                        <button class="btn btn-primary" id="save-btn" type="submit"><i class="bx bxs-save"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                        <button class="btn btn-secondary float-right" onclick='goBack("admin/settings")' type="button">
                            <i class="bx bx-trash"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

