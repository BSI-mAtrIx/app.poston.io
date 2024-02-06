<style type="text/css">
    .alert a {
        text-decoration: none;
    }

    #copy_code .row:hover {
        background: #e0e0e0;
    }

    div.tooltip {
        top: 0px !important;
    }
</style>
<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$include_datatable = 1; //datatables
$include_alertify = 1;
$include_select2 = 1;


if (empty($page_info)) { ?>

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

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card" id="nodata">
                    <div class="card-body">
                        <div class="empty-state">
                            <img class="img-fluid" style="height: 200px"
                                 src="<?= base_url() ?>assets/img/drawkit/drawkit-nature-man-colour.svg" alt="image">
                            <h2 class="mt-0"><?php echo $this->lang->line('We could not find any page.'); ?></h2>
                            <p class="lead"><?php echo $this->lang->line('Please import account if you have not imported yet.'); ?>
                                <br/>
                                <?php echo $this->lang->line('If you have already imported account then enable bot connection for one or more page to continue.'); ?>
                            </p>
                            <a href="/social_accounts" class="btn btn-outline-primary mt-4"><i
                                        class="bx bx-right-arrow-circle"></i> <?php echo $this->lang->line('Continue'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } else { ?>


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

    <?php include(APPPATH . 'n_views/include/alerts.php'); ?>

    <div class="section-body">

        <div class="row">
            <div class="col-xs-12 col-md-7 col-lg-8">

                <div class="card">

                    <div class="card-body">
                        <br>
                        <form action="#" enctype="multipart/form-data" style="padding: 0 20px 20px 20px">

                            <div class="form-group text-center">
                                <label style="width:100%">
                                    <?php echo $this->lang->line("Keyword Interest, ex. soccer title"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Keyword Interest, ex. soccer help title") ?>"
                                       data-content='<?php echo $this->lang->line("Keyword Interest, ex. soccer help") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="domain_name" id="domain_name" class="form-control"
                                       placeholder="<?php echo $this->lang->line("Keyword Interest, ex. soccer placeholder"); ?>">
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group text-center  " style='padding:0;'>
                                        <label style="width:100%">
                                            <?php echo $this->lang->line("Type"); ?>
                                        </label>

                                        <?php

                                        $ad_type = array(
                                            'adeducationschool' => $this->lang->line("College targeting"),
                                            'adeducationmajor' => $this->lang->line("College major targeting"),
                                            //'adgeolocation' => 'combined for country, city, state & zip',
                                            //'adcountry' => 'country',
                                            'adgeolocation' => $this->lang->line("Zip code"),
                                            //'adgeolocationmeta' => 'Additional metadata for geolocations',
                                            //'adradiussuggestion' => 'Returns recommended radius around location',
                                            'adinterest' => $this->lang->line("Interest targeting"),
                                            'adinterestsuggestion' => $this->lang->line("Suggestions based on interest targeting"),
                                            //'adinterestvalid' => 'Validates string as valid interest targeting option',
                                            //'adlocale' => 'Locale targeting',
                                            //'adeducationmajor' => 'Education major',
                                            'adworkemployer' => $this->lang->line("Work employer"),
                                            'adworkposition' => $this->lang->line("Job title"),
                                            'adTargetingCategory:interests' => $this->lang->line("Targeting interests (put any string keyword)"),
                                            'adTargetingCategory:behaviors' => $this->lang->line("Targeting behaviors (put any string keyword)"),
                                            'adTargetingCategory:life_events' => $this->lang->line("Life events (put any string keyword)"),
                                            'adTargetingCategory:industries' => $this->lang->line("Industries (put any string keyword)"),
                                            'adTargetingCategory:income' => $this->lang->line("Income (put any string keyword)"),
                                            'adTargetingCategory:family_statuses' => $this->lang->line("Family statuses (put any string keyword)"),
                                            'adTargetingCategory:user_device' => $this->lang->line("User device (put any string keyword)"),
                                            //'adTargetingCategory:user_os' => 'User os (put any string keyword)' $this->lang->line("Type"),
                                            'adTargetingCategory:demographics' => $this->lang->line("Demographics (put any string keyword)"),
                                        );

                                        echo form_dropdown('type_int', $ad_type, 'adinterest', 'class="select2 form-control" id="type_int"'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group text-center " style='padding:0;'>
                                        <label style="width:100%">
                                            <?php echo $this->lang->line("language"); ?>
                                        </label>
                                        <?php echo form_dropdown('language', $sdk_locale, $config_sdk_locale, 'class="select2 form-control" id="language"'); ?>
                                    </div>
                                </div>

                            </div>
                            <div class="clearfix"></div>

                            <div class="box-footer text-center">
                                <!-- <div class="col-xs-12"> -->
                                <button style='width:100%; max-width:350px; margin-bottom:10px;'
                                        class="btn btn-primary center-block get_button" id="get_button"
                                        name="get_button" type="button" value="get_records"
                                        onclick="get_button_data('get_interest')"><i
                                            class="bx bx-task"></i> <?php echo $this->lang->line("Get Interest"); ?>
                                </button>
                                <button style='width:100%; max-width:350px; margin-bottom:10px;'
                                        class="btn btn-primary center-block get_button" name="get_button" type="button"
                                        value="get_csv" onclick="get_button_csv('get_csv')"><i
                                            class="bx bx-file-blank"></i> <?php echo $this->lang->line("Get CSV"); ?>
                                </button>
                                <!-- </div> -->
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-5 col-lg-4">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo $this->lang->line("Selected keywords"); ?></h4>
                    </div>
                    <div class="card-body">
                        <form action="#" style="padding-right: 15px">
                            <textarea class="form-control name_list" id="list_keywords"
                                      style="height: 146px!important;margin-bottom: 24px;"></textarea>
                            <button style='width:45%; max-width:350px; margin-bottom:10px;'
                                    class="btn btn-sm btn-primary center-block"
                                    onclick="copyToClipboard('textarea#list_keywords')" name="get_button" type="button"
                                    value="get_csv"><i
                                        class="bx bx-copy"></i> <?php echo $this->lang->line("Copy to clipboard"); ?>
                            </button>
                            <button style='width:45%; max-width:350px; margin-bottom:10px;'
                                    class="btn btn-sm btn-primary center-block" onclick="exportToCSV(keys_id)"
                                    name="get_button" type="button" value="get_csv"><i
                                        class="bx bx-file-blank"></i> <?php echo $this->lang->line("Export to CSV"); ?>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="row" id="table_data_show" style="display:none;">
            <div class="col-xs-12 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo $this->lang->line("Interest Explorer Result"); ?>: <span
                                    id="counterlist"></span></h4>
                    </div>
                    <div class="card-body">
                        <div class="box-body">
                            <div class="form-group text-center">

                                <div id="preloader" class="text-center"></div>

                                <table class="table display compact" id="interest_table">
                                    <thead>
                                    <tr>
                                        <th style="max-width:80px;"><input
                                                    type="checkbox"
                                                    id="checkAll"
                                            /> <label
                                                    for="checkAll"><?php echo $this->lang->line("Select all"); ?></label>
                                        </th>
                                        <th style="width:35%;"><?php echo $this->lang->line("Keywords") ?></th>
                                        <th id="audience_size"><?php echo $this->lang->line("Audience Size") ?></th>
                                        <th><?php echo $this->lang->line("Category") ?></th>
                                        <th><?php echo $this->lang->line("Topic") ?></th>
                                    </tr>
                                    </thead>
                                </table>

                                <div id="copy_code" style="padding:15px;"></div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


<?php } ?>