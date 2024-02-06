<?php $this->load->view('admin/theme/message'); ?>
<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 1;
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
$location_table_id = $this->uri->segment(4);
$star_number = $this->uri->segment(3);
// $stars = ['five_star' => 'FIVE', 'four_star' => 'FOUR', 'three_star' => 'THREE', 'two_star' => 'TWO', 'one_star' => 'ONE'];
?>
<style>
    .dropdown-toggle::after {
        content: none !important;
    }

    .dropdown-toggle::before {
        content: none !important;
    }

    #searching {
        max-width: 30% !important;
    }

    #page_id {
        width: 150px !important;
    }

    #review_star {
        width: 110px !important;
    }

    @media (max-width: 575.98px) {
        #page_id {
            width: 130px !important;
        }

        #review_star {
            max-width: 105px !important;
        }

        #searching {
            max-width: 77% !important;
        }
    }

    .media-post-title {
        line-height: 22px;
        font-weight: normal !important;
    }

    div.tooltip_pd {
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
                                href="<?php echo base_url('gmb'); ?>"><?php echo $this->lang->line('Google My Business'); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="row">
                        <div class="col-md-9 col-12">
                            <div class="input-group mb-3 float-left" id="searchbox">
                                <!-- search by post type -->
                                <div class="input-group-prepend">
                                    <select class="select2 form-control" id="review_star" name="review_star">
                                        <option value=""><?php echo $this->lang->line("All Stars"); ?></option>
                                        <option value="FIVE" <?php if ($star_number == 'five_star') echo 'selected'; ?> ><?php echo $this->lang->line("5 Star"); ?></option>
                                        <option value="FOUR" <?php if ($star_number == 'four_star') echo 'selected'; ?> ><?php echo $this->lang->line("4 Star"); ?></option>
                                        <option value="THREE" <?php if ($star_number == 'three_star') echo 'selected'; ?> ><?php echo $this->lang->line("3 Star"); ?></option>
                                        <option value="TWO" <?php if ($star_number == 'two_star') echo 'selected'; ?> ><?php echo $this->lang->line("2 Star"); ?></option>
                                        <option value="ONE" <?php if ($star_number == 'one_star') echo 'selected'; ?> ><?php echo $this->lang->line("1 Star"); ?></option>
                                    </select>
                                </div>

                                <!-- search by page name -->
                                <div class="input-group-prepend">
                                    <select class="select2 form-control" id="location_name" name="location_name">
                                        <option value=""><?php echo $this->lang->line("Location Name"); ?></option>
                                        <?php if (count($locations)): ?>
                                            <?php foreach ($locations as $key => $value): ?>
                                                <option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $location_table_id) echo 'selected'; ?> ><?php echo $value['location_display_name']; ?></option>
                                            <?php endforeach ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

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
                        <div class="col-md-3 col-12">
                            <a href="javascript:;" id="post_date_range"
                               class="btn btn-primary float-right icon-left btn-icon"><i
                                        class="bx bx-calendar"></i> <?php echo $this->lang->line("Choose Date"); ?>
                            </a><input type="hidden" id="post_date_range_val">
                        </div>
                    </div>
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line("ID"); ?></th>
                                <th><?php echo $this->lang->line("Photo"); ?></th>
                                <th><?php echo $this->lang->line("Name"); ?></th>
                                <th><?php echo $this->lang->line("Star"); ?></th>
                                <th><?php echo $this->lang->line("Comment"); ?></th>
                                <th><?php echo $this->lang->line("Reply"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
                                <th><?php echo $this->lang->line("Location Name"); ?></th>
                                <th><?php echo $this->lang->line("Replied at"); ?></th>
                                <th><?php echo $this->lang->line('Error'); ?></th>
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

<div class="modal fade" tabindex="-1" role="dialog" id="update-review-reply-modal" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $this->lang->line("Reply to review") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form id="update-review-reply-form">
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line('Reply message'); ?>
                            <a href="#"
                               data-placement="bottom"
                               data-toggle="popover"
                               data-trigger="focus"
                               title="<?php echo $this->lang->line("Spintax"); ?>"
                               data-content="Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"
                            >
                                <i class='bx bx-info-circle'></i>
                            </a>
                        </label>
                        <textarea id="review-reply-message" class="form-control"></textarea>
                    </div>
                    <input type="hidden" id="review-id">
                    <input type="hidden" id="review-star">
                    <input type="hidden" id="review-comment">
                    <input type="hidden" id="reviewer-location-name">
                    <input type="hidden" id="reply-type" value="review_report">
                    <button type="submit" class="btn btn-primary btn-shadow"
                            id="update-review-reply-submit"><?php echo $this->lang->line('Reply now'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>


