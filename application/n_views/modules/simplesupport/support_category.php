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
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
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
                                href="<?php echo base_url("simplesupport/tickets"); ?>"><?php echo $this->lang->line("Support Desk"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="<?php echo site_url('simplesupport/add_category'); ?>" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Category"); ?>
        </a>
    </div>
</div>


<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("ID"); ?></th>
                                <th><?php echo $this->lang->line("Category Name"); ?></th>
                                <th style="min-width: 150px"><?php echo $this->lang->line("Actions"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sl = 0;
                            foreach ($category_data as $key => $value) {
                                $sl++;
                                $id = $value['id'];
                                $action = "<a href='" . base_url() . "simplesupport/edit_category/" . $value['id'] . "' class='btn btn-circle btn-outline-warning' title='" . $this->lang->line("Edit") . "' '><i class='bx bx-edit'></i></a>&nbsp;<a href='" . base_url() . "simplesupport/delete_category/" . $value['id'] . "' class='btn btn-circle btn-outline-danger are_you_sure_datatable non_ajax' title='" . $this->lang->line("Delete") . "'><i class='bx bx-trash'></i></a>";
                                echo "<tr>";
                                echo "<td>" . $sl . "</td>";
                                echo "<td>" . $id . "</td>";
                                echo "<td>" . $value['category_name'] . "</td>";
                                echo "<td>" . $action . "</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>








