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
$include_dropzone = 0;
?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="<?php echo site_url('blog/add_post'); ?>" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Post"); ?>
        </a>
    </div>
</div>

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
                                <th><?php echo $this->lang->line("ID"); ?></th>
                                <th><?php echo $this->lang->line("Title"); ?></th>
                                <th><?php echo $this->lang->line("Category"); ?></th>
                                <th><?php echo $this->lang->line("Author"); ?></th>
                                <th><?php echo $this->lang->line("Status"); ?></th>
                                <th><?php echo $this->lang->line("Created At"); ?></th>
                                <th><?php echo $this->lang->line("Published At"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
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


<?php
$drop_menu = '<div class="btn-group dropleft float-right"><button type="button" class="btn btn-primary float-right has-icon-left btn-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  ' . $this->lang->line("Tag & Category") . '  </button>  <div class="dropdown-menu dropleft"> <a class="dropdown-item has-icon pointer" href="' . base_url("blog/tag") . '"><i class="bx bx-tag"></i> ' . $this->lang->line("Tag Manager") . '</a><a class="dropdown-item has-icon pointer" href="' . base_url("blog/category") . '"><i class="bx bx-columns"></i> ' . $this->lang->line("Category Manager") . '</a>';
$drop_menu .= '</div> </div>';
?> 

