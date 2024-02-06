<?php
$include_upload = 1;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 0;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
?>
<?php $is_demo = $this->is_demo; ?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('themes/lists'); ?>"><?php echo $this->lang->line("Theme Manager"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>
<?php if ($this->session->flashdata('theme_upload_success') != "") echo "<div class='alert alert-success text-center'><i class='bx bx-check'></i> " . $this->session->flashdata('theme_upload_success') . "</div>"; ?>

<div class="section-body">
    <div class="row">

        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4><i class="bx bx-cloud-upload"></i> <?php echo $this->lang->line("Upload New Theme"); ?></h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div id="addon_url_upload"><?php echo $this->lang->line('Upload'); ?></div>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke text-justify">
                    <h6><?php echo $this->lang->line('After you upload theme file you will be taken to Theme Manager page, you need to active the theme there.'); ?><?php echo $this->lang->line('If you are having trouble uploading file using our uploader then you can simply upload theme zip file in application/views/site folder, unzip it and then activate it from Theme Manager.'); ?></h6>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card" id="server-status">
                <div class="card-header">
                    <h4><i class="bx bx-server"></i> <?php echo $this->lang->line("Server Status"); ?></h4>
                </div>
                <div class="card-body">
                    <?php
                    $list1 = $list2 = "";
                    if (function_exists('ini_get')) {
                        $make_dir = (!function_exists('mkdir')) ? $this->lang->line("Not Enabled") : $this->lang->line("Enabled");
                        $zip_archive = (!class_exists('ZipArchive')) ? $this->lang->line("Not Enabled") : $this->lang->line("Enabled");
                        $list1 .= "<li class='list-group-item'><b>mkdir</b> : " . $make_dir . "</li>";
                        $list1 .= "<li class='list-group-item'><b>upload_max_filesize</b> : " . ini_get('upload_max_filesize') . "</li>";
                        $list1 .= "<li class='list-group-item'><b>max_input_time</b> : " . ini_get('max_input_time') . "</li>";
                        $list2 .= "<li class='list-group-item'><b>ZipArchive</b> : " . $zip_archive . "</li>";
                        $list2 .= "<li class='list-group-item'><b>post_max_size</b> : " . ini_get('post_max_size') . "</li>";
                        $list2 .= "<li class='list-group-item'><b>max_execution_time</b> : " . ini_get('max_execution_time') . "</li>";
                    }
                    ?>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <ul class="list-group">
                                <?php echo $list1; ?>
                            </ul>
                        </div>
                        <div class="col-12 col-md-6">
                            <ul class="list-group">
                                <?php echo $list2; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>
