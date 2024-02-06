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
$include_chartjs = 1;
$include_owlcar = 0;
$include_prism = 0;
?>

<?php
$name = isset($affiliate_info[0]["name"]) ? $affiliate_info[0]["name"] : "";
$email = isset($affiliate_info[0]["email"]) ? $affiliate_info[0]["email"] : "";
$username = isset($affiliate_info[0]["username"]) ? $affiliate_info[0]["username"] : "";
$mobile = isset($affiliate_info[0]["mobile"]) ? $affiliate_info[0]["mobile"] : "";
$address = isset($affiliate_info[0]["address"]) ? $affiliate_info[0]["address"] : "";
$reg = date("M j, Y H:i A", strtotime($affiliate_info[0]["add_date"]));
$logo = isset($affiliate_info[0]["profile_img"]) ? $affiliate_info[0]["profile_img"] : "";
if ($logo == "") {
    $logo = file_exists("assets/img/avatar/avatar-1.png") ? base_url("assets/img/avatar/avatar-1.png") : "https://mysitespy.net/envato_image/avatar.png";
} else
    $logo = base_url() . 'upload/affiliator/' . $logo;
?>

<style>
    .name {
        font-size: 24px;
    }

</style>
<style>
    #my_name {
        font-size: 20px;
    }

    #email {
        font-size: 14px;
        font-family: cursive;
    }

    .profile-widget-header {
        padding: 20px;
    }

    .profile-widget-header img {
        width: 120px !important;
    }

    .request_info_profile .media .media-items .media-item {
        padding: 0 60px;
    }

    .request_info_profile .email, .request_info_profile {
        font-size: 12px;
    }

    .request_info_profile .media-title {
        font-size: 18px;
    }

    .select2-container--disabled .select2-selection__rendered {
    }

    .select2-container--disabled .select2-selection--single {
        background: #eee !important;
        border: red !important;
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
                                href="<?php echo base_url('affiliate_system/affiliate_users'); ?>"><?php echo $this->lang->line("Affiliate Users"); ?></a>
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
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="list-unstyled user-details list-unstyled-border list-unstyled-noborder mb-0 request_info_profile">
                                <li class="media">
                                    <img alt="image" class="mr-3 img-thumbnail" width="80" src="<?php echo $logo; ?>">
                                    <div class="media-body">
                                        <div class="media-title mb-0 text-primary"><?php echo $name; ?></div>
                                        <div class="mb-0 text-small ">@<?php echo $username; ?></div>
                                        <div class="text-muted email"><?php echo $email; ?></div>
                                        <div class="text-muted mobile"><?php echo !empty($mobile) ? $mobile : $this->lang->line("Not Available");; ?></div>
                                    </div>
                                    <div class="media-items mt-4">
                                        <div class="media-item">
                                            <div class="media-value"><?php echo $total_users_by_affiliate; ?></div>
                                            <div class="media-label"><?php echo $this->lang->line('Users'); ?></div>
                                        </div>
                                        <div class="media-item">
                                            <div class="media-value"><?php echo $curency_icon . $affiliate_info[0]['total_earn']; ?></div>
                                            <div class="media-label"><?php echo $this->lang->line('Earned'); ?></div>
                                        </div>
                                        <div class="media-item">
                                            <div class="media-value"><?php echo $curency_icon . $transferedAmount; ?></div>
                                            <div class="media-label"><?php echo $this->lang->line('Withdrawed'); ?></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <canvas id="affiliate_all_info" height="200"></canvas>
                        </div>
                        <div class="col-12 col-md-6">
                            <canvas id="affiliate_all_info2" height="200"></canvas>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="section-title mb-4"><?php echo $this->lang->line("Withdrawal Methods"); ?></div>
                        </div>
                        <div class="col-12">
                            <ul class="list-group">
                                <div class="row">
                                    <?php foreach ($methods as $key => $value) { ?>
                                        <div class="col-12 col-md-3">
                                            <?php echo $value['method']; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="section-title mb-4"><?php echo $this->lang->line('Withdrawal Requests Summary'); ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mb-0">
                                <select class="select2 form-control" id="search_request_status"
                                        name="search_request_status" style="width:30%;">

                                    </style>>
                                    <option value=""><?php echo $this->lang->line("Status"); ?></option>
                                    <option value="0"><?php echo $this->lang->line("Pending"); ?></option>
                                    <option value="1"><?php echo $this->lang->line("Approved"); ?></option>
                                    <option value="2"><?php echo $this->lang->line("Canceled"); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <a href="javascript:;" id="request_date_range"
                               class="btn btn-primary icon-left btn-icon float-right"><i
                                        class="bx bx-calendar"></i> <?php echo $this->lang->line("Choose Date"); ?>
                            </a><input type="hidden" id="request_date_range_val">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 data-card">
                            <div class="table-responsive2">
                                <input type="hidden" value="<?php echo $affiliate_id; ?>" name="affiliate_id"
                                       id="affiliate_id">
                                <table class="table table-bordered" id="mytable_affiliate_requests">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line("ID"); ?></th>
                                        <th><?php echo $this->lang->line("Method"); ?></th>
                                        <th><?php echo $this->lang->line("Amount") . ' ' . $curency_icon; ?></th>
                                        <th><?php echo $this->lang->line("State"); ?></th>
                                        <th><?php echo $this->lang->line("Status"); ?></th>
                                        <th><?php echo $this->lang->line("Issued"); ?></th>
                                        <th><?php echo $this->lang->line("Approved"); ?></th>
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
    </div>

</div>


<div class="modal fade" id="method_details_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h3 class="modal-title text-center blue">
                    <i class="bx bx-dots-horizontal-rounded"></i> <?php echo $this->lang->line("Method Details"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body section">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-small"><?php echo $this->lang->line('Method Name'); ?></div>
                        <div class="section-lead" id="method_name"></div>

                        <div class="section-title text-small"><?php echo $this->lang->line('Method Details'); ?></div>
                        <div class="section-lead">
                            <div class="alert alert-light" id="method_details"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


