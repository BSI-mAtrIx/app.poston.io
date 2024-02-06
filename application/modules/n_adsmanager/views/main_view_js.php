<script src="<?php echo base_url(); ?>assets/n_adsmanager/jquery.serialize.js"></script>

<script type="text/javascript">
    var instagram_pages = null;
    $('document').ready(function () {

        <?php
        if (!defined('NVX')) {
            require_once(APPPATH . 'modules/n_adsmanager/include/sweetalert_v1.php');
        }
        ?>

        var csrf_token = "<?php echo $this->session->userdata('csrf_token_session'); ?>";

        $('#bot_list_select').val(<?php echo $this->session->userdata('n_selected_ad_acc'); ?>);

        var langs = {};
        langs['keywords'] = "<?php echo $this->lang->line("Description your article. Use only keywords for best results."); ?>";
        langs['section_topic'] = "<?php echo $this->lang->line("Copy here your section topic."); ?>";
        langs['section_keywords'] = "<?php echo $this->lang->line("Description your section topic. Use only keywords for best results. (option)"); ?>";
        langs['bad_response'] = "<?php echo $this->lang->line("Bad response. Please contact with administration."); ?>";
        langs['success'] = "<?php echo $this->lang->line("Success"); ?>";
        langs['warning'] = "<?php echo $this->lang->line("Warning"); ?>";
        langs['Ok'] = "<?php echo $this->lang->line("Ok"); ?>";
        function get_lang($str) {
            return langs[$str];
        }

        function to_api($endpoint, $data) {
            return $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: $data,
                url: '<?php echo base_url('n_adsmanager/api/'); ?>' + $endpoint,
                success: function (res) {
                    $.unblockUI();
                    if (res.error != undefined && res.error) {
                        swal.fire({
                            icon: 'error',
                            text: res.error,
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                        });
                        return res;
                    }

                    if (res.status != undefined && res.status == "hidden") {
                        return res;
                    }

                    if (res.message != undefined && res.message.success == false && res.status != "false_alert") {
                        swal.fire({
                            icon: 'error',
                            text: res.message.description,
                            title: res.message.message,
                        });
                        return res;
                    }



                    if (res.message != undefined && res.status == "ok" && Array.isArray(res.message) == false && typeof res.message !== 'object') {
                        swal.fire({
                            icon: 'success',
                            text: res.message,
                            title: '<?php echo $this->lang->line('Success'); ?>',
                        });
                        return res;
                    }

                    if (res.status == "false_alert" && typeof res.message == 'object') {
                        iziToast.warning({title: '', message: res.message.message, position: 'bottomRight'});
                        return res;
                    }

                    if (res.status == "ok_alert" && typeof res.message == 'object') {
                        iziToast.success({title: '', message: res.message.message, position: 'bottomRight'});
                        return res;
                    }

                    if (res.status == "ok_alert") {
                        iziToast.success({title: '', message: res.message, position: 'bottomRight'});
                        return res;
                    }
                    if (res.status == "false_alert") {
                        iziToast.warning({title: '', message: res.message, position: 'bottomRight'});
                        return res;
                    }

                    return res;
                },
                error: function (xhr, status, error) {
                    // Shows error if something goes wrong
                    $.unblockUI();
                    swal.fire({
                        icon: 'error',
                        text: xhr.responseText,
                        title: '<?php echo $this->lang->line('Error!'); ?>',
                    });
                }
            });
        }


        $(document).on('click', '#accept_ad_account', function (e) {
            var load_more = $('#load_more_action').attr('data-start');

            var mes = '';
            mes = "<?php echo $this->lang->line('Do you really want to use this account?');?>";
            swal.fire({
                title: "<?php echo $this->lang->line("Ad Account");?>: <?php echo $current_ad_acc['user_name'] . ' (' . $current_ad_acc['net_id'] . ')'; ?>",
                text: mes,
                icon: "warning",
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then((val) => {
                if(typeof val == 'boolean'){
                    sa_confirmed = val;
                }else{
                    sa_confirmed = val.isConfirmed;
                }
                if (sa_confirmed) {
                    $.blockUI({
                        message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                        overlayCSS: {
                            backgroundColor: '#ffffff',
                            opacity: 0.8,
                            cursor: 'wait'
                        },
                        css: {
                            border: 0,
                            padding: 0,
                            backgroundColor: 'transparent'
                        }
                    });
                    var api_json = to_api('activate_account', {
                        csrf_token
                    }).done(function (res) {
                        if (res.status == 'ok') {
                            res.status = 'success';
                        }

                        swal.fire({
                            icon: res.status,
                            text: res.message,
                            title: get_lang(res.status),
                        }).then((val) => {
                            if(typeof val == 'boolean'){
                                sa_confirmed = val;
                            }else{
                                sa_confirmed = val.isConfirmed;
                            }
                            if (sa_confirmed) {
                                window.location.reload();
                            }
                        });
                    });
                }
            });


        });

        $(document).on('click', '#stop_autorenew_ad_account', function (e) {
            var load_more = $('#load_more_action').attr('data-start');

            var mes = '';
            mes = "<?php echo $this->lang->line('Do you really want to stop using this account to automatically renew?');?>";
            swal.fire({
                title: "<?php echo $this->lang->line("Ad Account");?>: <?php echo $current_ad_acc['user_name'] . ' (' . $current_ad_acc['net_id'] . ')'; ?>",
                text: mes,
                icon: "warning",
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then((val) => {
                if(typeof val == 'boolean'){
                    sa_confirmed = val;
                }else{
                    sa_confirmed = val.isConfirmed;
                }
                if (sa_confirmed) {
                    $.blockUI({
                        message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                        overlayCSS: {
                            backgroundColor: '#ffffff',
                            opacity: 0.8,
                            cursor: 'wait'
                        },
                        css: {
                            border: 0,
                            padding: 0,
                            backgroundColor: 'transparent'
                        }
                    });
                    var api_json = to_api('stop_autorenew_account', {
                        csrf_token
                    }).done(function (res) {
                        window.location.reload();
                    });
                }
            });
        });

        $(document).on('change', '#bot_list_select', function (e) {
            event.preventDefault();
            var ad_account = $('#bot_list_select').val();
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
            var api_json = to_api('change_account', {
                csrf_token,
                ad_account
            }).done(function (res) {
                window.location.reload();
            });
        });


        function get_account($period) {
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
            var api_json = to_api('account_overview', {
                csrf_token: csrf_token,
                period: $period,
            }).done(function (data) {
                if (data.status != 'ok') {
                    swal.fire({
                        icon: 'error',
                        text: data.message,
                        title: '<?php echo $this->lang->line('Error!'); ?>',
                    });
                    return;
                }
                data = data.message;
                var overview = '<div class="row page-titles">'
                    + '<div class="col-xl-6">'
                    + '<div class="dropdown">'
                    + '<button class="btn btn-secondary dropdown-toggle overview-filter-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                    + '<i class="far fa-calendar-alt"></i>'
                    + data.words.current
                    + '</button>'
                    + '<div class="dropdown-menu overview-filter-list" aria-labelledby="dropdownMenuButton">'
                    + '<a class="dropdown-item date_since_btn" href="#" data-type="today">'
                    + '<i class="far fa-calendar-alt"></i>'
                    + data.words.today
                    + '</a>'
                    + '<a class="dropdown-item date_since_btn" href="#" data-type="week">'
                    + '<i class="far fa-calendar-alt"></i>'
                    + data.words.week
                    + '</a>'
                    + '<a class="dropdown-item date_since_btn" href="#" data-type="month">'
                    + '<i class="far fa-calendar-alt"></i>'
                    + data.words.month
                    + '</a>'
                    + '<a class="dropdown-item date_since_btn" href="#" data-type="year">'
                    + '<i class="far fa-calendar-alt"></i>'
                    + data.words.year
                    + '</a>'
                    + '</div>'
                    + '</div>'
                    + '</div>'
                    + '<div class="col-xl-6 text-right clean">'
                    + '<button type="button" class="btn btn-success" id="ads-create-new-ad">'
                    + '<i class="icon-puzzle"></i>'
                    + "<?php echo $this->lang->line('New ad'); ?>"
                    + '</button>'
                    + '</div>'
                    + '</div>'
                    + '<div class="row mt-2">'
                    + '<div class="col-xl-4">'

                    + '<div class="card"><div class="card-body d-flex align-items-center justify-content-between">'
                    + '<div class="d-flex align-items-center">'
                    + '<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2"><div class="avatar-content">'
                    + '<i class="bx bx-user text-primary font-medium-2"></i>'
                    + '</div></div>'
                    + '<div class="total-amount">'
                    + '<h5 class="mb-0">' + data.account_insights.spend + ' ' + data.account_insights.account_currency + '</h5>'
                    + '<small class="text-muted">' + data.words.total_spent + '</small>'
                    + '</div></div></div></div>'

                    + '</div>'


                    + '<div class="col-xl-4">'

                    + '<div class="card"><div class="card-body d-flex align-items-center justify-content-between">'
                    + '<div class="d-flex align-items-center">'
                    + '<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2"><div class="avatar-content">'
                    + '<i class="bx bx-user text-primary font-medium-2"></i>'
                    + '</div></div>'
                    + '<div class="total-amount">'
                    + '<h5 class="mb-0">' + data.account_insights.social_spend + ' ' + data.account_insights.account_currency + '</h5>'
                    + '<small class="text-muted">' + data.words.social_spent + '</small>'
                    + '</div></div></div></div>'

                    + '</div>'
                    + '<div class="col-xl-4">'

                    + '<div class="card"><div class="card-body d-flex align-items-center justify-content-between">'
                    + '<div class="d-flex align-items-center">'
                    + '<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2"><div class="avatar-content">'
                    + '<i class="bx bx-user text-primary font-medium-2"></i>'
                    + '</div></div>'
                    + '<div class="total-amount">'
                    + '<h5 class="mb-0">' + data.account_insights.impressions + '</h5>'
                    + '<small class="text-muted">' + data.words.impressions + '</small>'
                    + '</div></div></div></div>'

                    + '</div>'
                    + '<div class="col-xl-4">'

                    + '<div class="card"><div class="card-body d-flex align-items-center justify-content-between">'
                    + '<div class="d-flex align-items-center">'
                    + '<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2"><div class="avatar-content">'
                    + '<i class="bx bx-user text-primary font-medium-2"></i>'
                    + '</div></div>'
                    + '<div class="total-amount">'
                    + '<h5 class="mb-0">' + data.account_insights.clicks + '</h5>'
                    + '<small class="text-muted">' + data.words.clicks + '</small>'
                    + '</div></div></div></div>'

                    + '</div>'
                    + '<div class="col-xl-4">'

                    + '<div class="card"><div class="card-body d-flex align-items-center justify-content-between">'
                    + '<div class="d-flex align-items-center">'
                    + '<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2"><div class="avatar-content">'
                    + '<i class="bx bx-user text-primary font-medium-2"></i>'
                    + '</div></div>'
                    + '<div class="total-amount">'
                    + '<h5 class="mb-0">' + data.account_insights.reach + '</h5>'
                    + '<small class="text-muted">' + data.words.reach + '</small>'
                    + '</div></div></div></div>'

                    + '</div>'
                    + '<div class="col-xl-4">'

                    + '<div class="card"><div class="card-body d-flex align-items-center justify-content-between">'
                    + '<div class="d-flex align-items-center">'
                    + '<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2"><div class="avatar-content">'
                    + '<i class="bx bx-user text-primary font-medium-2"></i>'
                    + '</div></div>'
                    + '<div class="total-amount">'
                    + '<h5 class="mb-0">' + data.account_insights.frequency + '</h5>'
                    + '<small class="text-muted">' + data.words.frequency + '</small>'
                    + '</div></div></div></div>'

                    + '</div>'
                    + '<div class="col-xl-4">'

                    + '<div class="card"><div class="card-body d-flex align-items-center justify-content-between">'
                    + '<div class="d-flex align-items-center">'
                    + '<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2"><div class="avatar-content">'
                    + '<i class="bx bx-user text-primary font-medium-2"></i>'
                    + '</div></div>'
                    + '<div class="total-amount">'
                    + '<h5 class="mb-0">' + data.account_insights.cpm + '</h5>'
                    + '<small class="text-muted">' + data.words.cpm + '</small>'
                    + '</div></div></div></div>'

                    + '</div>'
                    + '<div class="col-xl-4">'

                    + '<div class="card"><div class="card-body d-flex align-items-center justify-content-between">'
                    + '<div class="d-flex align-items-center">'
                    + '<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2"><div class="avatar-content">'
                    + '<i class="bx bx-user text-primary font-medium-2"></i>'
                    + '</div></div>'
                    + '<div class="total-amount">'
                    + '<h5 class="mb-0">' + data.account_insights.cpp + '</h5>'
                    + '<small class="text-muted">' + data.words.cpp + '</small>'
                    + '</div></div></div></div>'

                    + '</div>'
                    + '<div class="col-xl-4">'

                    + '<div class="card"><div class="card-body d-flex align-items-center justify-content-between">'
                    + '<div class="d-flex align-items-center">'
                    + '<div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2"><div class="avatar-content">'
                    + '<i class="bx bx-user text-primary font-medium-2"></i>'
                    + '</div></div>'
                    + '<div class="total-amount">'
                    + '<h5 class="mb-0">' + data.account_insights.ctr + '</h5>'
                    + '<small class="text-muted">' + data.words.ctr + '</small>'
                    + '</div></div></div></div>'

                    + '</div>'
                    + '</div>';

                // Show Overview
                $('#overview').html(overview);
            });
        }


        $(document).on('click', '.date_since_btn', function (e) {
            var date_since = $($(this)).attr('data-type');
            get_account(date_since);
        });

        <?php if($active_acc == 1){ ?>
        get_account('today');
        <?php } ?>


        function get_cpg($url = '') {
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var api_json = to_api('load_campaigns_by_pagination', {
                csrf_token: csrf_token,
                url: $url,
            }).done(function (data) {
                if (data.status != 'ok') {
                    return;
                }
                data = data.message;

                if (data.success === true) {

                    var campaigns = data.campaigns;
                    var all_campaigns = '';

                    for (var e = 0; e < campaigns.length; e++) {
                        var impressions = 0;
                        if (typeof campaigns[e].insights !== 'undefined') {
                            if (typeof campaigns[e].insights.data[0] !== 'undefined') {
                                if (typeof campaigns[e].insights.data[0].impressions !== 'undefined') {
                                    impressions = campaigns[e].insights.data[0].impressions;
                                }
                            }
                        }

                        var spend = 0;
                        if (typeof campaigns[e].insights !== 'undefined') {
                            if (typeof campaigns[e].insights.data[0] !== 'undefined') {
                                if (typeof campaigns[e].insights.data[0].spend !== 'undefined') {
                                    spend = campaigns[e].insights.data[0].spend;
                                }
                            }
                        }

                        if (typeof data.currency !== '---') {
                            spend = spend + ' ' + data.currency;
                        }

                        var objective = campaigns[e].objective;

                        switch (objective) {
                            case 'APP_INSTALLS':
                                objective = "<?php echo $this->lang->line('app_installs'); ?>";
                                break;

                            case 'BRAND_AWARENESS':
                                objective = "<?php echo $this->lang->line('brand_awareness'); ?>";
                                break;

                            case 'CONVERSIONS':
                                objective = "<?php echo $this->lang->line('conversions'); ?>";
                                break;

                            case 'EVENT_RESPONSES':
                                objective = "<?php echo $this->lang->line('event_responses'); ?>";
                                break;

                            case 'LEAD_GENERATION':
                                objective = "<?php echo $this->lang->line('lead_generation'); ?>";
                                break;

                            case 'LINK_CLICKS':
                                objective = "<?php echo $this->lang->line('link_clicks'); ?>";
                                break;

                            case 'LOCAL_AWARENESS':
                                objective = "<?php echo $this->lang->line('local_awareness'); ?>";
                                break;

                            case 'MESSAGES':
                                objective = "<?php echo $this->lang->line('messages'); ?>";
                                break;

                            case 'OFFER_CLAIMS':
                                objective = "<?php echo $this->lang->line('offer_claims'); ?>";
                                break;

                            case 'PAGE_LIKES':
                                objective = "<?php echo $this->lang->line('page_likes'); ?>";
                                break;

                            case 'POST_ENGAGEMENT':
                                objective = "<?php echo $this->lang->line('post_engagement'); ?>";
                                break;

                            case 'PRODUCT_CATALOG_SALES':
                                objective = "<?php echo $this->lang->line('product_catalog_sales'); ?>";
                                break;

                            case 'REACH':
                                objective = "<?php echo $this->lang->line('reach'); ?>";
                                break;

                            case 'STORE_VISITS':
                                objective = "<?php echo $this->lang->line('store_visits'); ?>";
                                break;

                            case 'VIDEO_VIEWS':
                                objective = "<?php echo $this->lang->line('video_views'); ?>";
                                break;
                        }

                        if(campaigns[e].status=='ACTIVE'){
                            campaigns[e].status = campaigns[e].status + '<a data-id="'+campaigns[e].id+'" class="btn btn-sm btn-primary p-0 ml-1 change_status" data-status="paused" data-type="ad_campaign" href="#"><i class="bx bx-pause"></i></a>';
                        }else{
                            campaigns[e].status = campaigns[e].status + '<a data-id="'+campaigns[e].id+'" class="btn btn-sm btn-primary p-0 ml-1 change_status" data-status="active" data-type="ad_campaign" href="#"><i class="bx bx-play"></i></a>';
                        }

                        all_campaigns += '<tr>'
                            + '<th scope="row">'
                            + '<div class="checkbox-option-select">'
                            + '<input id="ads-campaigns-' + campaigns[e].id + '" name="ads-campaigns-' + campaigns[e].id + '" type="checkbox" data-id="' + campaigns[e].id + '">'
                            + '<label for="ads-campaigns-' + campaigns[e].id + '"></label>'
                            + '</div>'
                            + '</th>'
                            + '<td>'
                            + campaigns[e].name
                            + '</td>'
                            + '<td>'
                            + campaigns[e].status
                            + '</td>'
                            + '<td>'
                            + objective
                            + '</td>'
                            + '<td>'
                            + impressions
                            + '</td>'
                            + '<td>'
                            + spend
                            + '</td>'
                            + '</tr>';

                    }
                    $('.main #campaigns tbody').html(all_campaigns);

                    if (data.previous) {
                        $('.main #campaigns .btn-previous').attr('data-url', data.previous);
                        $('.main #campaigns .btn-previous').removeClass('disabled');
                    } else {
                        $('.main #campaigns .btn-previous').addClass('disabled');
                    }

                    if (data.next) {
                        $('.main #campaigns .btn-next').attr('data-url', data.next);
                        $('.main #campaigns .btn-next').removeClass('disabled');
                    } else {
                        $('.main #campaigns .btn-next').addClass('disabled');
                    }
                    $('.main #ads-campaigns-all').prop('checked', false);
                } else {
                    var data = '<tr>'
                        + '<td colspan="6" class="p-3">'
                        + '<?php echo $this->lang->line('no_campaigns_found'); ?>'
                        + '</td>'
                        + '</tr>';

                    $('.main #campaigns tbody').html(data);

                    $('.main #campaigns .btn-previous').addClass('disabled');
                    $('.main #campaigns .btn-next').addClass('disabled');

                    $('.main #ads-campaigns-all').prop('checked', false);
                }


            });
        }

        $(document).on('click', '#cpg_view_btn', function (e) {
            get_cpg();
        });

        $(document).on('click', '.main .btn-campaign-pagination', function (e) {
            e.preventDefault();
            get_cpg($(this).attr('data-url'));
        });


        function get_adset($url = '') {
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var api_json = to_api('load_ad_sets_by_pagination', {
                csrf_token: csrf_token,
                url: $url,
            }).done(function (data) {
                if (data.status != 'ok') {
                    return;
                }
                data = data.message;

                if (data.success === true) {
                    var adsets = data.adsets;
                    var all_adsets = '';

                    for (var e = 0; e < adsets.length; e++) {
                        var impressions = 0;
                        if (typeof adsets[e].insights !== 'undefined') {
                            if (typeof adsets[e].insights.data[0] !== 'undefined') {
                                if (typeof adsets[e].insights.data[0].impressions !== 'undefined') {
                                    impressions = adsets[e].insights.data[0].impressions;
                                }
                            }
                        }

                        var spend = 0;

                        if (typeof adsets[e].insights !== 'undefined') {
                            if (typeof adsets[e].insights.data[0] !== 'undefined') {
                                if (typeof adsets[e].insights.data[0].spend !== 'undefined') {
                                    spend = adsets[e].insights.data[0].spend;

                                }

                            }

                        }

                        if (typeof data.currency !== '---') {
                            spend = spend + ' ' + data.currency;
                        }

                        if(adsets[e].status=='ACTIVE'){
                            adsets[e].status = adsets[e].status + '<a data-id="'+adsets[e].id+'" class="btn btn-sm btn-primary p-0 ml-1 change_status" data-status="paused" data-type="ad_set" href="#"><i class="bx bx-pause"></i></a>';
                        }else{
                            adsets[e].status = adsets[e].status + '<a data-id="'+adsets[e].id+'" class="btn btn-sm btn-primary p-0 ml-1 change_status" data-status="active" data-type="ad_set" href="#"><i class="bx bx-play"></i></a>';
                        }

                        all_adsets += '<tr>'
                            + '<th scope="row">'
                            + '<div class="checkbox-option-select">'
                            + '<input id="ads-adsets-' + adsets[e].id + '" name="ads-adsets-' + adsets[e].id + '" type="checkbox" data-id="' + adsets[e].id + '">'
                            + '<label for="ads-adsets-' + adsets[e].id + '"></label>'
                            + '</div>'
                            + '</th>'
                            + '<td>'
                            + adsets[e].name
                            + '</td>'
                            + '<td>'
                            + adsets[e].status
                            + '</td>'
                            + '<td>'
                            + adsets[e].campaign.name
                            + '</td>'
                            + '<td>'
                            + impressions
                            + '</td>'
                            + '<td>'
                            + spend
                            + '</td>'
                            + '</tr>';

                    }

                    $('.main #ad-sets tbody').html(all_adsets);

                    if (data.previous) {
                        $('.main #ad-sets .btn-previous').attr('data-url', data.previous);
                        $('.main #ad-sets .btn-previous').removeClass('disabled');
                    } else {
                        $('.main #ad-sets .btn-previous').addClass('disabled');
                    }

                    if (data.next) {
                        $('.main #ad-sets .btn-next').attr('data-url', data.next);
                        $('.main #ad-sets .btn-next').removeClass('disabled');
                    } else {
                        $('.main #ad-sets .btn-next').addClass('disabled');
                    }

                    $('.main #ads-adsets-all').prop('checked', false);
                } else {
                    var data = '<tr>'
                        + '<td colspan="6" class="p-3">'
                        + "<?php echo $this->lang->line('no_adsets_found'); ?>"
                        + '</td>'
                        + '</tr>';

                    $('.main #ad-sets tbody').html(data);

                    $('.main #ad-sets .btn-previous').addClass('disabled');
                    $('.main #ad-sets .btn-next').addClass('disabled');

                    $('.main #ads-adsets-all').prop('checked', false);
                }

            });
        }

        $(document).on('click', '#adset_view_btn', function (e) {
            get_adset();
        });

        $(document).on('click', '.main .btn-adsets-pagination', function (e) {
            e.preventDefault();
            get_adset($(this).attr('data-url'));
        });

        function get_ads($url = '') {
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var api_json = to_api('load_ads_by_pagination', {
                csrf_token: csrf_token,
                url: $url,
            }).done(function (data) {
                if (data.status != 'ok') {
                    return;
                }
                data = data.message;

                var status_text = "<?php echo $this->lang->line('status'); ?>";
                var status_order = 0;

                if (data.success === true) {
                    status_order = data.status;
                    switch (data.status) {
                        case '1':
                            status_text = "<?php echo $this->lang->line('ACTIVE'); ?>";
                            break;

                        case '2':
                            status_text = "<?php echo $this->lang->line('PAUSED'); ?>";
                            break;

                        case '3':
                            status_text = "<?php echo $this->lang->line('DELETED'); ?>";
                            break;

                        case '4':
                            status_text = "<?php echo $this->lang->line('ARCHIVED'); ?>";
                            break;

                    }
                }

                // Create the ads list
                var ads = ''
                    + '<div class="col-xl-12">'
                    + '<div class="table-responsive">'
                    + '<table class="table">'
                    + '<thead>'
                    + '<tr>'
                    + '<th scope="row" colspan="3">'
                    + '<button type="button" class="btn btn-success" id="ads-create-new-ad">'
                    + '<i class="icon-puzzle"></i>'
                    + "<?php echo $this->lang->line('New ad'); ?>"
                    + '</button>'
                    + '<button type="button" class="btn btn-dark ads-delete-ad">'
                    + '<i class="icon-trash"></i>'
                    + "<?php echo $this->lang->line('delete'); ?>"
                    + '</button>'
                    + '</th>'
                    + '<th scope="row" colspan="3">'
                    + '<button type="button" class="btn btn-dark pull-right btn-load-ad-insights" data-toggle="modal" data-target="#ads-ad-sets-insights">'
                    + '<i class="icon-graph"></i>'
                    + "<?php echo $this->lang->line('insights'); ?>"
                    + '</button>'
                    + '</th>'
                    + '</tr>'
                    + '<tr>'
                    + '<th scope="row">'
                    + '<div class="checkbox-option-select">'
                    + '<input id="ads-ad-all" name="ads-ad-alll" type="checkbox">'
                    + '<label for="ads-ad-all"></label>'
                    + '</div>'
                    + '</th>'
                    + '<th scope="col">'
                    + "<?php echo $this->lang->line('name'); ?>"
                    + '</th>'
                    + '<th scope="col">'
                    + '<div class="dropdown">'
                    + '<button class="btn btn-secondary dropdown-toggle ads-status-filter-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-order="' + status_order + '">'
                    + status_text
                    + '</button>'
                    + '<div class="dropdown-menu ads-status-filter-list" aria-labelledby="dropdownMenuButton" x-placement="bottom-start">'
                    + '<a class="dropdown-item" href="#" data-type="1">'
                    + "<?php echo $this->lang->line('ACTIVE'); ?>"
                    + '</a>'
                    + '<a class="dropdown-item" href="#" data-type="2">'
                    + "<?php echo $this->lang->line('PAUSED'); ?>"
                    + '</a>'
                    + '<a class="dropdown-item" href="#" data-type="3">'
                    + "<?php echo $this->lang->line('DELETED'); ?>"
                    + '</a>'
                    + '<a class="dropdown-item" href="#" data-type="4">'
                    + "<?php echo $this->lang->line('ARCHIVED'); ?>"
                    + '</a>'
                    + '</div>'
                    + '</div>'
                    + '</th>'
                    + '<th scope="col">'
                    + "<?php echo $this->lang->line('ad_set'); ?>"
                    + '</th>'
                    + '<th scope="col">'
                    + "<?php echo $this->lang->line('impressions'); ?>"
                    + '</th>'
                    + '<th scope="col">'
                    + "<?php echo $this->lang->line('spent'); ?>"
                    + '</th>'
                    + '</tr>'
                    + '</thead>'
                    + '<tbody>'
                    + '</tbody>'
                    + '<tfoot>'
                    + '<tr>'
                    + '<td colspan="6" class="text-right">'
                    + '<button type="button" class="btn btn-dark btn-previous btn-ad-pagination disabled">'
                    + '<i class="far fa-arrow-alt-circle-left"></i>'
                    + "<?php echo $this->lang->line('previous'); ?>"
                    + '</button>'
                    + '<button type="button" class="btn btn-dark btn-next btn-ad-pagination disabled">'
                    + "<?php echo $this->lang->line('next'); ?>"
                    + '<i class="far fa-arrow-alt-circle-right"></i>'
                    + '</button>'
                    + '</td>'
                    + '</tr>'
                    + '</tfoot>'
                    + '</table>'
                    + '</div>'
                    + '</div>';

                $('.main #ads').html(ads);
                $('.main #ads').removeClass('no-account-result');

                // Verify if the success response exists
                if (data.success === true) {
                    var ads = data.ads;
                    var all_ads = '';
                    for (var e = 0; e < ads.length; e++) {
                        var impressions = 0;
                        if (typeof ads[e].insights !== 'undefined') {
                            if (typeof ads[e].insights.data[0] !== 'undefined') {
                                if (typeof ads[e].insights.data[0].impressions !== 'undefined') {
                                    impressions = ads[e].insights.data[0].impressions;
                                }
                            }
                        }

                        var spend = 0;
                        if (typeof ads[e].insights !== 'undefined') {
                            if (typeof ads[e].insights.data[0] !== 'undefined') {
                                if (typeof ads[e].insights.data[0].spend !== 'undefined') {
                                    spend = ads[e].insights.data[0].spend;
                                }
                            }
                        }

                        if (typeof data.currency !== '---') {
                            spend = spend + ' ' + data.currency;
                        }

                        if(ads[e].status=='ACTIVE'){
                            ads[e].status = ads[e].status + '<a data-id="'+ads[e].id+'" class="btn btn-sm btn-primary p-0 ml-1 change_status" data-status="paused" data-type="ad" href="#"><i class="bx bx-pause"></i></a>';
                        }else{
                            ads[e].status = ads[e].status + '<a data-id="'+ads[e].id+'" class="btn btn-sm btn-primary p-0 ml-1 change_status" data-status="active" data-type="ad" href="#"><i class="bx bx-play"></i></a>';
                        }

                        all_ads += '<tr>'
                            + '<th scope="row">'
                            + '<div class="checkbox-option-select">'
                            + '<input id="ads-ad-' + ads[e].id + '" name="ads-ad-' + ads[e].id + '" type="checkbox" data-id="' + ads[e].id + '">'
                            + '<label for="ads-ad-' + ads[e].id + '"></label>'
                            + '</div>'
                            + '</th>'
                            + '<td>'
                            + ads[e].name
                            + '</td>'
                            + '<td>'
                            + ads[e].status
                            + '</td>'
                            + '<td>'
                            + ads[e].adset.name
                            + '</td>'
                            + '<td>'
                            + impressions
                            + '</td>'
                            + '<td>'
                            + spend
                            + '</td>'
                            + '</tr>';

                    }

                    $('.main #ads tbody').html(all_ads);

                    if (data.previous) {
                        $('.main #ads').find('.btn-previous').attr('data-url', data.previous);
                        $('.main #ads').find('.btn-previous').removeClass('disabled');
                    } else {
                        $('.main #ads').find('.btn-previous').addClass('disabled');
                    }

                    if (data.next) {
                        $('.main #ads').find('.btn-next').attr('data-url', data.next);
                        $('.main #ads').find('.btn-next').removeClass('disabled');
                    } else {
                        $('.main #ads').find('.btn-next').addClass('disabled');
                    }

                } else {
                    var data = '<tr>'
                        + '<td colspan="6" class="p-3">'
                        + "<?php echo $this->lang->line('no_ads_found'); ?>"
                        + '</td>'
                        + '</tr>';

                    $('.main #ads tbody').html(data);

                    $('.main #ads .btn-previous').addClass('disabled');
                    $('.main #ads .btn-next').addClass('disabled');
                }

            });
        }

        $(document).on('click', '.change_status', function (e) {
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });

            var type_update = $(this).attr('data-type');

            var api_json = to_api('update_status', {
                csrf_token: csrf_token,
                type: type_update,
                ad_id: $(this).attr('data-id'),
                status: $(this).attr('data-status'),
            }).done(function (data) {
                $.unblockUI();

                switch(type_update){
                    case 'ad':
                        get_ads();
                        break;
                    case 'ad_set':
                        get_adset();
                        break
                    case 'ad_campaign':
                        get_cpg();
                        break
                }

            });
        });

        $(document).on('click', '#ads_view_btn', function (e) {
            get_ads();
        });

        $(document).on('click', '.main .btn-ad-pagination', function (e) {
            e.preventDefault();
            get_ads($(this).attr('data-url'));
        });

        function get_conv_track($url = '') {
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var api_json = to_api('load_pixel_conversions_by_pagination', {
                csrf_token: csrf_token,
                url: $url,
            }).done(function (data) {
                if (data.status != 'ok') {
                    return;
                }
                data = data.message;


                if (data.success === true) {
                    var conversions = data.conversions;
                    var all_conversions = '';

                    for (var e = 0; e < conversions.length; e++) {
                        var custom_event_type = '';
                        switch (conversions[e].custom_event_type) {
                            case 'CONTENT_VIEW':
                                custom_event_type = words.view_content;
                                break;

                            case 'SEARCH':
                                custom_event_type = words.search;
                                break;

                            case 'ADD_TO_CART':
                                custom_event_type = words.add_to_cart;
                                break;

                            case 'ADD_TO_WISHLIST':
                                custom_event_type = words.add_to_wishlist;
                                break;

                            case 'INITIATED_CHECKOUT':
                                custom_event_type = words.initiate_checkout;
                                break;

                            case 'ADD_PAYMENT_INFO':
                                custom_event_type = words.add_payment_info;
                                break;

                            case 'PURCHASE':
                                custom_event_type = words.purchase;
                                break;

                            case 'LEAD':
                                custom_event_type = words.lead;
                                break;

                            case 'COMPLETE_REGISTRATION':
                                custom_event_type = words.complete_registration;
                                break;

                        }

                        var rule = '';

                        if (typeof conversions[e].rule !== 'undefined') {
                            var parse = JSON.parse(conversions[e].rule);
                            if (typeof parse.url !== 'undefined') {
                                if (typeof parse.url.i_contains !== 'undefined') {
                                    rule = parse.url.i_contains;
                                }
                            }
                        }

                        all_conversions += '<tr>'
                            + '<td>'
                            + conversions[e].name
                            + '</td>'
                            + '<td>'
                            + custom_event_type
                            + '</td>'
                            + '<td>'
                            + rule
                            + '</td>'
                            + '</tr>';

                    }

                    $('.main #pixel-conversion tbody').html(all_conversions);

                    if (data.previous) {
                        $('.main #pixel-conversion .btn-previous').attr('data-url', data.previous);
                        $('.main #pixel-conversion .btn-previous').removeClass('disabled');
                    } else {
                        $('.main #pixel-conversion .btn-previous').addClass('disabled');
                    }

                    if (data.next) {
                        $('.main #pixel-conversion .btn-next').attr('data-url', data.next);
                        $('.main #pixel-conversion .btn-next').removeClass('disabled');
                    } else {
                        $('.main #pixel-conversion .btn-next').addClass('disabled');
                    }

                } else {
                    var data = '<tr>'
                        + '<td colspan="6" class="p-3">'
                        + words.no_conversion_tracking_found
                        + '</td>'
                        + '</tr>';

                    $('.main #pixel-conversion tbody').html(data);
                    $('.main #pixel-conversion .btn-previous').addClass('disabled');
                    $('.main #pixel-conversion .btn-next').addClass('disabled');
                }

            });
        }

        $(document).on('click', '#con_track_view_btn', function (e) {
            get_conv_track();
        });

        $(document).on('click', '.main .btn-conversions-pagination', function (e) {
            e.preventDefault();
            get_conv_track($(this).attr('data-url'));
        });


        function get_custom_audiences_list($url = '') {
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var api_json = to_api('custom_audiences_list', {
                csrf_token: csrf_token,
                url: $url,
            }).done(function (data) {
                if (data.status != 'ok') {
                    return;
                }
                data = data.message;


                if (data.success === true) {
                    var c_audiences = data.custom_audiences;
                    var all_c_audiences = '';
					var status_ca = '';

                    for (var e = 0; e < c_audiences.length; e++) {
						
						if(c_audiences[e].operation_status.code==200){
							status_ca = '<div class="badge badge-primary"><?php echo $this->lang->line('Ready'); ?></div>';
						}else if(c_audiences[e].operation_status.code==300){
							status_ca = '<div class="badge badge-warning"><?php echo $this->lang->line('Updating'); ?></div>';
						}else{
							status_ca = '<div class="badge badge-danger"><?php echo $this->lang->line("Can't used"); ?></div>';
						}

                        all_c_audiences += '<tr>'
                            + '<td>'
                            + c_audiences[e].name
                            + '</td>'
							
							+ '<td>'
                            + status_ca
                            + '</td>'
							
                            + '</tr>';

                    }

                   $('.main #custom_audience_main tbody').html(all_c_audiences);

                    if (data.previous) {
                        $('.main #custom_audience_main .btn-previous').attr('data-url', data.previous);
                        $('.main #custom_audience_main .btn-previous').removeClass('disabled');
                    } else {
                        $('.main #custom_audience_main .btn-previous').addClass('disabled');
                    }

                    if (data.next) {
                        $('.main #custom_audience_main .btn-next').attr('data-url', data.next);
                        $('.main #custom_audience_main .btn-next').removeClass('disabled');
                    } else {
                        $('.main #custom_audience_main .btn-next').addClass('disabled');
                    }

                } else {
                    var data = '<tr>'
                        + '<td colspan="6" class="p-3">'
                        + words.no_conversion_tracking_found
                        + '</td>'
                        + '</tr>';

                    $('.main #custom_audience_main tbody').html(data);
                    $('.main #custom_audience_main .btn-previous').addClass('disabled');
                    $('.main #custom_audience_main .btn-next').addClass('disabled');
                }

            });
        }

        var ca_data_batch = {}

        $(document).on('click', '#ads_custom_audience_save_batch', function (e) {
            $('#custom_audience_step_one').hide();
            $('#custom_audience_step_two').show();

            $('#ads_custom_audience_save_batch').hide();

            ca_data_batch = {
                audience_source: $('#ads_custom_audience_source').val(),
                bot_source: $('#ads_custom_audience_source_bot').val(),
                bot_labels: $('#ads_custom_audience_source_labels').val(),
                ads_custom_audience_name: $('#ads_custom_audience_name').val(),
                ads_custom_audience_description: $('#ads_custom_audience_description').val(),
                fb_data: null,
                audience_id: null
            }

            create_custom_audience_batch(ca_data_batch);

        });

        function create_custom_audience_batch(data){
            var api_json = to_api('create_custom_audience_batch', {
                csrf_token: csrf_token,
                audience_source: data.audience_source,
                bot_source: data.bot_source,
                bot_labels: data.bot_labels,
                fb_data: data.fb_data,
                audience_id: data.audience_id,
                ads_custom_audience_name: data.ads_custom_audience_name,
                ads_custom_audience_description: data.ads_custom_audience_description,
				audience_data: data.audience_data
            }).done(function (data) {

                $('.swal2-modal').removeAttr('tabindex');
				
				if(data.error != undefined){
					$('#ads_custom_audience_save_batch').show();
                    $('#custom_audience_step_one').show();
                    $('#custom_audience_step_two').hide();
                    $('#custom_audience_step_three').hide();

					get_custom_audiences_list();
                    return;
				}

                if (data.status == 'hidden' && data.message.success == false) {
                    $('#ads_custom_audience_save_batch').show();
                    $('#custom_audience_step_one').show();
                    $('#custom_audience_step_two').hide();
                    $('#custom_audience_step_three').hide();

					get_custom_audiences_list();
                    return;
                }

                if(data.message.progress != undefined && data.message.progress == 'done'){
                    $('#custom_audience_step_two').hide();
                    $('#custom_audience_step_three').show();
					
					get_custom_audiences_list();
					return;
                }

                if(data.message.progress != undefined && data.message.progress == 'batch_resume'){


					$('#custom_audience_progress_unhide').show();
					$('#custom_audience_current_value').html(data.message.fb_data.num_received_total);
					$('#custom_audience_total_value').html(data.message.fb_data.total_data);
					
					var ca_progres = data.message.fb_data.num_received_total / data.message.fb_data.total_data * 100;
					
					$('#custom_audience_current_progress').css('width', ca_progres + "%");
					
					data.message.audience_source = $('#ads_custom_audience_source').val();
					data.message.bot_source = $('#ads_custom_audience_source_bot').val();
					data.message.bot_labels = $('#ads_custom_audience_source_labels').val();
					
					
                    create_custom_audience_batch(data.message);
                }

            });
        }
		
		$(document).on('click', '#new_custom_audiences_modal_btn', function (e) {
			$('#ads_custom_audience_save_batch').show();
            $('#custom_audience_step_one').show();
            $('#custom_audience_step_two').hide();
            $('#custom_audience_step_three').hide();
			
			$('#ads_custom_audience_name').val('');
            $('#ads_custom_audience_description').val('');
			$('#ads_custom_audience_source').val('').change();
			$('#ads_custom_audience_source_bot').val('').change();
			$('#ads_custom_audience_source_labels').val('').change();
			
			$('#ads_custom_audience_source_bot_div').hide();
			$('#ads_custom_audience_source_labels_div').hide();
        });

        $(document).on('click', '#custom_audience_view_btn', function (e) {
            get_custom_audiences_list();
        });
		
		$(document).on('click', '.main .btn-custom_audiences-pagination', function (e) {
            e.preventDefault();
            get_custom_audiences_list($(this).attr('data-url'));
        });

        $(document).on('change', '#ads_custom_audience_source', function (e) {
            $('#ads_custom_audience_source_bot_div').show();

            $('#ads_custom_audience_source_bot').val('').change();
            $('#ads_custom_audience_source_labels').val('').change();

            var params_custom = {
                audience_source: $('#ads_custom_audience_source').val()
            }

            ajax_select(
                '#ads_custom_audience_source_bot',
                'custom_audience_bot_select_source',
                "<?php echo $this->lang->line('Search for Bot '); ?>",
                params_custom
            );
        });

        $(document).on('change', '#ads_custom_audience_source_bot', function (e) {
            $('#ads_custom_audience_source_labels_div').show();

            $('#ads_custom_audience_source_labels').val('').change();

            var params_custom = {
                audience_source: $('#ads_custom_audience_source').val(),
                bot_source: $('#ads_custom_audience_source_bot').val()
            }

            ajax_select(
                '#ads_custom_audience_source_labels',
                'ads_custom_audience_source_labels',
                "<?php echo $this->lang->line('Search for Bot '); ?>",
                params_custom
            );
        });

        function ajax_select($element, $endpoint, $placeholder, $params_custom = '') {
            $($element).select2({
                placeholder: $placeholder,
                width: '100%',
                ajax: {
                    delay: 400,
                    url: base_url + 'n_adsmanager/api/' + $endpoint,
                    type: "POST",
                    dataType: 'json',
                    data: function (params) {
                        $.blockUI({
                            message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                            overlayCSS: {
                                backgroundColor: '#ffffff',
                                opacity: 0.8,
                                cursor: 'wait'
                            },
                            css: {
                                border: 0,
                                padding: 0,
                                backgroundColor: 'transparent'
                            }
                        });

                        var query = {
                            search: params.term,
                            csrf_token: csrf_token,
                            params: $params_custom
                        }

                        return query;
                    },
                    processResults: function (data) {

                        $.unblockUI();
                        if (data.status == '0') {
                            swal.fire({
                                icon: 'error',
                                text: data.error,
                                title: '<?php echo $this->lang->line('Error!'); ?>',
                            });
                            return;
                        }

                        if (data.message.select == undefined) {
                            return {
                                results: ''
                            };
                        }

                        return {
                            results: data.message.select.data
                        };
                    }
                }
            });
        }

        $(document).on('click', '#ads-create-new-ad', function (e) {
            $('.main .nav-pills li a').removeClass('active');
            $('.main .tab-main-action > .tab-pane').removeClass('active');
            $('#ads-create-new-ad-view').addClass('active');

            ajax_select('#ads-select-ad-campaign', 'select_ad_campaign', "<?php echo $this->lang->line('search_for_campaigns'); ?>");
        });


        $(document).on('click', '#select_ad_set_btn', function (e) {
            if ($('#ads-select-ad-campaign').val().length == 0) {
                swal.fire({
                    title: "<?php echo $this->lang->line("Warning");?>",
                    text: "<?php echo $this->lang->line('First, select or create a campaign.'); ?>",
                    icon: "warning",
                    confirmButtonText: "<?php echo $this->lang->line('Ok'); ?>",
                    showCancelButton: false,
                    dangerMode: true,
                }).then((val) => {
                    if(typeof val == 'boolean'){
                        sa_confirmed = val;
                    }else{
                        sa_confirmed = val.isConfirmed;
                    }
                    if (sa_confirmed) {
                        $('#ads-create-new-ad-view .nav-item a').removeClass('active');

                        $('#ads-create-new-ad-view .nav-pills li a').removeClass('active');
                        $('#ads-create-new-ad-view .tab-pane').removeClass('active');
                        $('#select_ad_campaign_btn').addClass('active');
                        $('#select_ad_campaign').addClass('active');

                    }
                });
                return;
            }

            // $('.main .nav-pills li a').removeClass('active');
            // $('.main .tab-main-action > .tab-pane').removeClass('active');
            //$('#ads-create-new-ad-view').addClass('active');

            ajax_select('#ads-selected-ad-set', 'load_select_ad_sets', "<?php echo $this->lang->line('search_for_adsets'); ?>", $('#ads-select-ad-campaign').val());
            $('#ads-selected-ad-set').val('').change();
        });


        $(document).on('click', '#create_ad_btn', function (e) {
            if ($('#ads-selected-ad-set').val().length == 0) {
                swal.fire({
                    title: "<?php echo $this->lang->line("Warning");?>",
                    text: "<?php echo $this->lang->line('First, select or create a ad set.'); ?>",
                    icon: "warning",
                    confirmButtonText: "<?php echo $this->lang->line('Ok'); ?>",
                    showCancelButton: false,
                    dangerMode: true,
                }).then((val) => {
                    if(typeof val == 'boolean'){
                        sa_confirmed = val;
                    }else{
                        sa_confirmed = val.isConfirmed;
                    }
                    if (sa_confirmed) {
                        $('#ads-create-new-ad-view .nav-item a').removeClass('active');

                        $('#ads-create-new-ad-view .nav-pills li a').removeClass('active');
                        $('#ads-create-new-ad-view .tab-pane').removeClass('active');
                        $('#select_ad_set_btn').addClass('active');
                        $('#select_ad_set').addClass('active');

                        $('#ad_creativity_details_messages_buttons_container').html('');

                    }
                });
                return;
            } else {
                //load_ad_identity();
                //load_posts_for_boosting();

                //load_all_pixel_coversions

                ajax_select('#select_adp_pixel', 'load_all_pixel_coversions', "<?php echo $this->lang->line('search_for_pixel_n'); ?>");


                $('#select_adp_convtracking').select2({
                    placeholder: "<?php echo $this->lang->line('search_pixel_conversions'); ?>",
                    width: '100%',
                    multiple: false,
                    ajax: {
                        delay: 400,
                        url: base_url + 'n_adsmanager/api/load_coversions_by_id',
                        type: "POST",
                        dataType: 'json',
                        dropdownParent: $("#create_adset .modal-content"),
                        data: function (params) {
                            // $.blockUI({
                            //     message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                            //     overlayCSS: {
                            //         backgroundColor: '#ffffff',
                            //         opacity: 0.8,
                            //         cursor: 'wait'
                            //     },
                            //     css: {
                            //         border: 0,
                            //         padding: 0,
                            //         backgroundColor: 'transparent'
                            //     }
                            // });`

                            var query = {
                                search: params.term,
                                csrf_token: csrf_token,
                                pixel_id: $('#select_adp_pixel').val()
                            }

                            return query;
                        },
                        processResults: function (data) {

                            // $.unblockUI();
                            if (data.status == '0') {
                                swal.fire({
                                    icon: 'error',
                                    text: data.error,
                                    title: '<?php echo $this->lang->line('Error!'); ?>',
                                });
                                return;
                            }

                            if (data.message.select == undefined) {
                                return {
                                    results: ''
                                };
                            }

                            return {
                                results: data.message.select.data
                            };
                        }
                    }
                });

                $('#select_adp_fb_page').select2({
                    placeholder: "<?php echo $this->lang->line('search_for_pages'); ?>",
                    width: '100%',
                    multiple: false,
                    ajax: {
                        delay: 400,
                        url: base_url + 'n_adsmanager/api/load_account_fb',
                        type: "POST",
                        dataType: 'json',
                        dropdownParent: $("#create_adset .modal-content"),
                        data: function (params) {
                            // $.blockUI({
                            //     message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                            //     overlayCSS: {
                            //         backgroundColor: '#ffffff',
                            //         opacity: 0.8,
                            //         cursor: 'wait'
                            //     },
                            //     css: {
                            //         border: 0,
                            //         padding: 0,
                            //         backgroundColor: 'transparent'
                            //     }
                            // });`

                            var query = {
                                search: params.term,
                                csrf_token: csrf_token,
                                pixel_id: $('#select_adp_pixel').val()
                            }

                            return query;
                        },
                        processResults: function (data) {

                            // $.unblockUI();
                            if (data.status == '0') {
                                swal.fire({
                                    icon: 'error',
                                    text: data.error,
                                    title: '<?php echo $this->lang->line('Error!'); ?>',
                                });
                                return;
                            }

                            if (data.message.select == undefined) {
                                return {
                                    results: ''
                                };
                            }

                            instagram_pages = data.message.instagram;

                            return {
                                results: data.message.select.data
                            };
                        }
                    }
                });





            }


        });

        $(document).on("change", "#select_adp_fb_page", function () {
            var fb_page_id = $('#select_adp_fb_page').val();

            if($('#data_campaign_objective').val()=='POST_ENGAGEMENT'){
                load_posts_for_boosting();
            }

            if (instagram_pages != undefined && instagram_pages.hasOwnProperty(fb_page_id)) {
                $("#select_adp_ig_page").select2('destroy');
                $("#select_adp_ig_page").html('');
                $("#select_adp_ig_page").select2({
                    'data': [{
                        id: instagram_pages[fb_page_id]['id'],
                        text: instagram_pages[fb_page_id]['text']
                    }]
                }).change();
            } else {
                $("#select_adp_ig_page").select2('destroy');
                $("#select_adp_ig_page").html('');
                $("#select_adp_ig_page").select2();
            }

        });

        function select_facebook_campaign($url = '') {
            if ($('#ads-select-ad-campaign').val().length == 0) {
                return;
            }
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var api_json = to_api('select_facebook_campaign', {
                csrf_token: csrf_token,
                campaign_id: $('#ads-select-ad-campaign').val(),
            }).done(function (data) {

                if (data.status == "false_alert") {
                    $('#ads-select-ad-campaign').val('').change();
                } else {
                    select_facebook_campaign_success(data);
                }

            });
        }

        $(document).on('click', '#mod_create_campaign', function (e) {
            e.preventDefault();
            create_facebook_campaign();
        })


        $(document).on('click', '.create_adset_btn', function (e) {
            $('#adset_cpg_id').val(null);
            $this = $(this);

            if ($this.hasClass('from_creator')) {
                $('#adset_cpg_show').hide();
                $('#adset_cpg_id').val($('#ads-select-ad-campaign').val());
            } else {
                $('#adset_cpg_show').show();
                ajax_select('#adset_select_ad_campaign', 'select_ad_campaign', "<?php echo $this->lang->line('search_for_campaigns'); ?>");
            }


            ajax_select('.countries-list', 'load_countries', "<?php echo $this->lang->line('search_for_countries'); ?>");

            ajax_select('#ad_set_custom_audience_include_list', 'load_custom_audience_select', "<?php echo $this->lang->line('Search for custom audiences'); ?>");
            ajax_select('#ad_set_custom_audience_exclude_list', 'load_custom_audience_select', "<?php echo $this->lang->line('Search for custom audiences'); ?>");


            $('#select_regions').select2({
                placeholder: "<?php echo $this->lang->line('search_for_regions'); ?>",
                width: '100%',
                multiple: true,
                ajax: {
                    delay: 400,
                    url: base_url + 'n_adsmanager/api/load_regions',
                    type: "POST",
                    dataType: 'json',
                    dropdownParent: $("#create_adset .modal-content"),
                    data: function (params) {
                        // $.blockUI({
                        //     message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                        //     overlayCSS: {
                        //         backgroundColor: '#ffffff',
                        //         opacity: 0.8,
                        //         cursor: 'wait'
                        //     },
                        //     css: {
                        //         border: 0,
                        //         padding: 0,
                        //         backgroundColor: 'transparent'
                        //     }
                        // });`

                        var query = {
                            search: params.term,
                            csrf_token: csrf_token,
                            code: $('.countries-list').val()
                        }

                        return query;
                    },
                    processResults: function (data) {

                        // $.unblockUI();
                        if (data.status == '0') {
                            swal.fire({
                                icon: 'error',
                                text: data.error,
                                title: '<?php echo $this->lang->line('Error!'); ?>',
                            });
                            return;
                        }

                        if (data.message.select == undefined) {
                            return {
                                results: ''
                            };
                        }

                        return {
                            results: data.message.select.data
                        };
                    }
                }
            });

            $('.select_cities').select2({
                placeholder: "<?php echo $this->lang->line('search_for_cities'); ?>",
                width: '100%',
                multiple: true,
                ajax: {
                    delay: 400,
                    url: base_url + 'n_adsmanager/api/load_cities',
                    type: "POST",
                    dataType: 'json',
                    dropdownParent: $("#create_adset .modal-content"),
                    data: function (params) {
                        // $.blockUI({
                        //     message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                        //     overlayCSS: {
                        //         backgroundColor: '#ffffff',
                        //         opacity: 0.8,
                        //         cursor: 'wait'
                        //     },
                        //     css: {
                        //         border: 0,
                        //         padding: 0,
                        //         backgroundColor: 'transparent'
                        //     }
                        // });

                        var query = {
                            search: params.term,
                            csrf_token: csrf_token,
                            region: $('#select_regions').val()
                        }

                        return query;
                    },
                    processResults: function (data) {

                        // $.unblockUI();
                        if (data.status == '0') {
                            swal.fire({
                                icon: 'error',
                                text: data.error,
                                title: '<?php echo $this->lang->line('Error!'); ?>',
                            });
                            return;
                        }

                        if (data.message.select == undefined) {
                            return {
                                results: ''
                            };
                        }

                        return {
                            results: data.message.select.data
                        };
                    }
                }
            });

            $('#search_for_targeting_suggestions').select2({
                placeholder: "<?php echo $this->lang->line('search_for_suggestions'); ?>",
                width: '100%',
                multiple: true,
                ajax: {
                    delay: 400,
                    url: base_url + 'n_adsmanager/api/search_for_targeting_suggestions',
                    type: "POST",
                    dataType: 'json',
                    dropdownParent: $("#create_adset .modal-content"),
                    data: function (params) {
                        // $.blockUI({
                        //     message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                        //     overlayCSS: {
                        //         backgroundColor: '#ffffff',
                        //         opacity: 0.8,
                        //         cursor: 'wait'
                        //     },
                        //     css: {
                        //         border: 0,
                        //         padding: 0,
                        //         backgroundColor: 'transparent'
                        //     }
                        // });

                        var query = {
                            search: params.term,
                            csrf_token: csrf_token,
                            //region: $('#select_regions').val()
                        }

                        return query;
                    },
                    processResults: function (data) {

                        // $.unblockUI();
                        if (data.status == '0') {
                            swal.fire({
                                icon: 'error',
                                text: data.error,
                                title: '<?php echo $this->lang->line('Error!'); ?>',
                            });
                            return;
                        }

                        if (data.message.select == undefined) {
                            return {
                                results: ''
                            };
                        }

                        return {
                            results: data.message.select.data
                        };
                    }
                }
            });

            $('#adset_creation_filter_fb_pages').select2({
                placeholder: "<?php echo $this->lang->line('search_for_suggestions'); ?>",
                width: '100%',
                multiple: false,
                ajax: {
                    delay: 400,
                    url: base_url + 'n_adsmanager/api/load_account_pages',
                    type: "POST",
                    dataType: 'json',
                    dropdownParent: $("#create_adset .modal-content"),
                    data: function (params) {
                        // $.blockUI({
                        //     message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                        //     overlayCSS: {
                        //         backgroundColor: '#ffffff',
                        //         opacity: 0.8,
                        //         cursor: 'wait'
                        //     },
                        //     css: {
                        //         border: 0,
                        //         padding: 0,
                        //         backgroundColor: 'transparent'
                        //     }
                        // });

                        var query = {
                            search: params.term,
                            csrf_token: csrf_token,
                            //region: $('#select_regions').val()
                        }

                        return query;
                    },
                    processResults: function (data) {

                        // $.unblockUI();
                        if (data.status == '0') {
                            swal.fire({
                                icon: 'error',
                                text: data.error,
                                title: '<?php echo $this->lang->line('Error!'); ?>',
                            });
                            return;
                        }

                        if (data.message.select == undefined) {
                            return {
                                results: ''
                            };
                        }

                        return {
                            results: data.message.select.data
                        };
                    }
                }
            });

            if(min_budgets==null){
                var api_currency = to_api('account_currency', {
                    csrf_token
                }).done(function (res) {
                    if (res.status != undefined && res.status == 'hidden') {;
                        min_budgets = res.message.currency.selected;
                        $('.ad_set_daily_budget').html(min_budgets.min_daily_budget_imp);
                        $('.ad_set_target_cost').html(min_budgets.min_daily_budget_imp);
                        $('#ads_campaign_optimization_goal').val('IMPRESSIONS').change();
                    }
                });
            }else{
                $('.ad_set_daily_budget').html(min_budgets.min_daily_budget_imp);
                $('.ad_set_target_cost').html(min_budgets.min_daily_budget_imp);
                $('#ads_campaign_optimization_goal').val('IMPRESSIONS').change();
            }

            if($('#data_campaign_objective').val()=='MESSAGES'){
                $('.ad_set_daily_budget').html(min_budgets.min_daily_budget_low_freq);
                $('.ad_set_target_cost').html(min_budgets.min_daily_budget_low_freq);
            }







        });


        $(document).on("change", "#ads_campaign_optimization_goal", function () {
            var adset_opt = $('#ads_campaign_optimization_goal').val();
            switch (adset_opt) {
                case 'LINK_CLICKS':
                case 'REACH':
                    $('.ad_set_daily_budget').html(min_budgets.min_daily_budget_imp);
                    $('.ad_set_target_cost').html(min_budgets.min_daily_budget_imp);
                    break;
                case 'TWO_SECOND_CONTINUOUS_VIDEO_VIEWS':
                case 'THRUPLAY':
                    $('.ad_set_daily_budget').html(min_budgets.min_daily_budget_video_views);
                    $('.ad_set_target_cost').html(min_budgets.min_daily_budget_video_views);
                    break;
                case 'IMPRESSIONS':
                    $('.ad_set_daily_budget').html(min_budgets.min_daily_budget_imp);
                    $('.ad_set_target_cost').html(min_budgets.min_daily_budget_imp);
                    break;
            }

            if($('#data_campaign_objective').val()=='MESSAGES'){
                $('.ad_set_daily_budget').html(min_budgets.min_daily_budget_low_freq);
                $('.ad_set_target_cost').html(min_budgets.min_daily_budget_low_freq);
            }

            if($('#data_campaign_objective').val()=='MESSAGES' && adset_opt!='IMPRESSIONS'){
                $('#ads_campaign_optimization_goal').val('IMPRESSIONS').change();
            }

        });

        function ads_pixel_save_conversion() {
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var api_json = to_api('create_pixel_conversion', {
                csrf_token: csrf_token,
                ads_pixel_conversion_name: $("#ads_pixel_conversion_name").val(),
                ads_pixel_conversion_url: $("#ads_pixel_conversion_url").val(),
                ads_select_conversion_type: $("#ads_select_conversion_type").val(),
            }).done(function (data) {

                if (data.message != undefined && data.message.success == true) {
                    $("#pixel-new-coversion").modal('hide');
                    if ($('#con_track_view_btn').hasClass('active')) {
                        $('#con_track_view_btn').click();
                    }
                }

            });
        }


        $(document).on('change', '#ads_adset_daily_budge_set', function (e) {
            e.preventDefault();

            $('#ad_set_lifetime_budget_show').hide();
            $('#ad_set_daily_budget_show').hide();

            if($('#ads_adset_daily_budge_set').val()=='lifetime'){
                $('#ad_set_lifetime_budget_show').show();
            }else{
                $('#ad_set_daily_budget_show').show();
            }

        });


        $(document).on('change', '#create_ad input', function (e) {
            e.preventDefault();
            generate_preview_ad();
        });

        $(document).on('change', 'input[name=post-engagement-boost-it]', function (e) {
            e.preventDefault();
            generate_preview_ad();
        });

        $(document).on('click', '#reload_preview', function (e) {
            e.preventDefault();
            generate_preview_ad();
        });

        $(document).on('change', '#create_ad select', function (e) {
            e.preventDefault();
            generate_preview_ad();
        });

        $(document).on('change', '#create_ad textarea', function (e) {
            e.preventDefault();
            generate_preview_ad();
        });

        function generate_preview_ad() {

            switch($('#data_campaign_objective').val()){
                case 'POST_ENGAGEMENT':
                    if (
                        $('#ad_name').val() == '' ||
                        $('input[name=post-engagement-boost-it]').val() == undefined ||
                        $('#select_adp_fb_page').val() ==  null
                    ){
                        return;
                    }
                    break;
                case 'MESSAGES':
                    $('#preview_ad_iframe').html('<p class="p-1"><?php echo $this->lang->line('Preview for Sponsored Message is not supported by Meta API.'); ?></p>');
                     return;
                    if (
                        $('#ad_name').val() == '' ||
                        $('#ad_text').val() == ''
                    ) {
                        return;
                    }
                    break;
                default:
                    if (
                        $('#ad_name').val() == '' ||
                        $('#ad_text').val() == '' ||
                        $('#website_url').val() == '' ||
                        $('#select_adp_fb_page').val() == ''
                    ) {
                        return;
                    }
                    break;
            }


            $('#preview_ad_iframe').block({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var api_json = to_api('generate_preview_ad', {
                csrf_token: csrf_token,
                objective: $('#ad_objective').val(),
                ad_name: $('#ad_name').val(),
                ad_text: $('#ad_text').val(),
                website_url: $('#website_url').val(),
                adimage: $('#image_hash').val(),
                preview_image: $('#preview_image').val(), //need add
                video_id: $('#ad_video_id').val(),
                fb_page_id: $('#select_adp_fb_page').val(),
                instagram_id: $('#select_adp_ig_page').val(),
                headline: $('#ad_headline').val(),
                description: $('#ad_description').val(),
                adset_id: $('#ads-selected-ad-set').val(),
                pixel_id: $('#select_adp_pixel').val(),
                pixel_conversion_id: $('#select_adp_convtracking').val(),
                post_id: $('input[name=post-engagement-boost-it]').val(),
                advideo: '',
                adset_promoted_object: $('#ads-selected-ad-set').select2('data')[0].page_id,
                messages_buttons: $('.facebook-ads-create-new-ad').serializeObject().messages_buttons,
                ad_img_title: $('#ad_img_title').val(),
                ad_img_subtitle:$ ('#ad_img_subtitle').val(),

            }).done(function (data) {

                if (data.message != undefined && data.message.success == true) {
                    data.message.description = data.message.description.replaceAll('`', '"');
                    $('#preview_ad_iframe').html(data.message.description);
                }
                $('#preview_ad_iframe').unblock();

            });
        }

        $(document).on('click', '#ads_save_ad_set', function (e) {
            e.preventDefault();
            create_facebook_campaign_ad();
        });

        function create_facebook_campaign_ad() {
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var api_json = to_api('create_facebook_campaign_ad', {
                csrf_token: csrf_token,
                objective: $('#ad_objective').val(),
                ad_name: $('#ad_name').val(),
                ad_text: $('#ad_text').val(),
                website_url: $('#website_url').val(),
                adimage: $('#image_hash').val(),
                preview_image: $('#preview_image').val(), //need add
                video_id: $('#ad_video_id').val(),
                fb_page_id: $('#select_adp_fb_page').val(),
                instagram_id: $('#select_adp_ig_page').val(),
                headline: $('#ad_headline').val(),
                description: $('#ad_description').val(),
                adset_id: $('#ads-selected-ad-set').val(),
                pixel_id: $('#select_adp_pixel').val(),
                pixel_conversion_id: $('#select_adp_convtracking').val(),
                post_id: $('input[name=post-engagement-boost-it]').val(),
                advideo: '',
                adset_promoted_object: $('#ads-selected-ad-set').select2('data')[0].page_id,
                messages_buttons: $('.facebook-ads-create-new-ad').serializeObject().messages_buttons,
                ad_img_title: $('#ad_img_title').val(),
                ad_img_subtitle: $('#ad_img_subtitle').val(),
                ad_creativity_details_messages_select_type: $('#ad_creativity_details_messages_select_type').val(),
                ad_creativity_status: $('.ad-creativity-status').val()

            }).done(function (data) {

                if (data.message != undefined && data.message.success == true) {

                }

            });
        }

        function create_facebook_campaign() {
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var api_json = to_api('create_facebook_campaign', {
                csrf_token: csrf_token,
                ads_crt_campaign_name: $("input[name=ads_crt_campaign_name]").val(),
                ads_crt_campaign_objective: $("select[name=ads_crt_campaign_objective]").val(),
                ads_crt_campaign_status: $("select[name=ads_crt_campaign_status]").val(),
                ads_crt_campaign_special: $("select[name=ads_crt_campaign_special]").val(),
                cpg_start_time: $("input[name=cpg_start_time]").val(),
                cpg_end_time: $("input[name=cpg_end_time]").val()
            }).done(function (data) {

                if (data.message != undefined && data.message.success == true) {
                    $("#create_campaign").modal('hide');
                    if ($('#cpg_view_btn').hasClass('active')) {
                        $('#cpg_view_btn').click();
                    }
                }

            });
        }

        function create_facebook_adset() {

            if ($('#adset_cpg_id').val() != '') {
                var adset_select_ad_campaign = $('#adset_cpg_id').val();
            } else {
                var adset_select_ad_campaign = $('#adset_select_ad_campaign').val();
            }

            var ads_adset_name = $('#ads_adset_name').val();

            if($('#ad_objective').val() != ''){
                var ad_objective = $('#ad_objective').val();
            }else{
                var ad_objective = $('#adset_select_ad_campaign').select2('data')[0].objective;
            }

            var ads_campaign_optimization_goal = $('#ads_campaign_optimization_goal').val();

            var billing_event_description = $('#billing_event_description').val();

            var ad_set_placement_facebook_feeds = $('#ad_set_placement_facebook_feeds').val();
            var ad_set_placement_instagram_feed = $('#ad_set_placement_instagram_feed').val();
            var ad_set_placement_messenger_inbox = $('#ad_set_placement_messenger_inbox').val();

            var ads_adset_target_cost = $('#ads_adset_target_cost').val();

            var ads_adset_daily_budget = $('#ads_adset_daily_budget').val();

            var ad_set_default_country = $('#ad_set_default_country').val();
            var select_regions = $('#select_regions').val();
            var select_cities = $('#select_cities').val();

            var ads_campaign_ad_genders = $('#ads_campaign_ad_genders').val();

            var ads_campaign_age_from_list = $('#ads_campaign_age_from_list').val();
            var ads_campaign_age_to_list = $('#ads_campaign_age_to_list').val();

            var ads_campaign_select_type = $('#ads_campaign_select_type').val();


            var adset_creation_filter_fb_pages = $('#adset_creation_filter_fb_pages').val();
            var search_for_targeting_suggestions = $('#search_for_targeting_suggestions').val();

            var ad_set_custom_audience_include_list = $('#ad_set_custom_audience_include_list').val();
            var ad_set_custom_audience_exclude_list = $('#ad_set_custom_audience_exclude_list').val();

            var adset_start_time = $('#adset_start_time').val();
            var adset_end_time = $('#adset_end_time').val();

            var ad_set_status = $('.ad-set-status').val();
            var ads_adset_daily_budget_set = $('#ads_adset_daily_budge_set').val();
            var ads_adset_lifetime_budget = $('#ads_adset_lifetime_budget').val();

            if(ads_adset_daily_budget_set=='lifetime' && adset_end_time==''){
                swal.fire({
                    icon: 'warning',
                    text: '<?php echo $this->lang->line('Ad set end date is not set for lifetime budget.'); ?>',
                    title: '<?php echo $this->lang->line('Warning'); ?>'
                });
                return;
            }

            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var api_json = to_api('create_facebook_adset', {
                csrf_token: csrf_token,
                ad_objective: ad_objective,
                adset_select_ad_campaign: adset_select_ad_campaign,
                ads_adset_name: ads_adset_name,
                ads_campaign_optimization_goal: ads_campaign_optimization_goal,
                billing_event_description: billing_event_description,
                ad_set_placement_facebook_feeds: ad_set_placement_facebook_feeds,
                ad_set_placement_instagram_feed: ad_set_placement_instagram_feed,
                ad_set_placement_messenger_inbox: ad_set_placement_messenger_inbox,
                ads_adset_target_cost: ads_adset_target_cost,
                ads_adset_daily_budget: ads_adset_daily_budget,
                ad_set_default_country: ad_set_default_country,
                select_regions: select_regions,
                select_cities: select_cities,
                ads_campaign_ad_genders: ads_campaign_ad_genders,
                ads_campaign_age_from_list: ads_campaign_age_from_list,
                ads_campaign_age_to_list: ads_campaign_age_to_list,
                ads_campaign_select_type: ads_campaign_select_type,
                adset_creation_filter_fb_pages: adset_creation_filter_fb_pages,
                search_for_targeting_suggestions: search_for_targeting_suggestions,
                ad_set_custom_audience_exclude_list: ad_set_custom_audience_exclude_list,
                ad_set_custom_audience_include_list: ad_set_custom_audience_include_list,
                adset_start_time: adset_start_time,
                adset_end_time: adset_end_time,
                ad_set_status: ad_set_status,
                ads_adset_daily_budget_set: ads_adset_daily_budget_set,
                ads_adset_lifetime_budget: ads_adset_lifetime_budget
            }).done(function (data) {

                if (data.message != undefined && data.message.success == true) {
                    $("#create_adset").modal('hide');
                    if ($('#select_ad_set_btn').hasClass('active')) {
                        $('#select_ad_set_btn').click();
                    }
                }

            });
        }

        //on change adset_select_ad_campaign hide targeting
        $(document).on('change', '#adset_select_ad_campaign', function (e){

            if($('#ad_objective').val() != ''){
                var ch_ad_objective = $('#ad_objective').val();
            }else{
                var ch_ad_objective = $('#adset_select_ad_campaign').select2('data')[0].objective;
            }

            if(ch_ad_objective=='MESSAGES'){
                $('.sponsored_messages_hide').hide();
            }else{
                $('.sponsored_messages_hide').show();
            }
        });

        $(document).on('click', '#mod_create_adset', function (e) {
            e.preventDefault();
            create_facebook_adset();
        });

        $(document).on('click', '#ads_pixel_save_conversion', function (e) {
            e.preventDefault();
            ads_pixel_save_conversion();
        });

        $(document).on('change', '#post-engagement-search-posts', function (e) {
            e.preventDefault();
            load_posts_for_boosting();
        });



        function load_posts_for_boosting() {
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });

            var key = '';
            var network = '';
            var page_id = '';
            // Get selected social network
            key = $('#post-engagement-search-posts').val();
            if ($('#post-engagement-from-network').val()=='facebook') {
                network = 'facebook';
                page_id = $('#select_adp_fb_page').val();
            } else if ($('#post-engagement-from-network').val()=='instagram') {
                network = 'instagram';
                page_id = $('#select_adp_ig_page').val();
            }


            // data[$('.facebook-ads-create-ad').attr('data-csrf')] = $('input[name="' + $('.facebook-ads-create-ad').attr('data-csrf') + '"]').val();


            var api_json = to_api('load_posts_for_boosting', {
                csrf_token: csrf_token,
                network: network,
                key: key,
                page_id: page_id
            }).done(function (data) {
                if (data.status == "false_alert") {
                    //$('#ads-select-ad-campaign').val('').change();
                } else {
                    data = data.message;

                    if ( data.success) {
                        var all_posts = '';

                        for ( var e = 0; e < data.posts.length; e++ ) {

                            if(data.posts[e].nophoto==true){
                                data.posts[e].picture = base_url + data.posts[e].picture;
                            }

                            all_posts += '<tr>'
                                + '<td style="width:10%">'
                                + '<img style="width:65px" src="' + data.posts[e].picture + '">'
                                + '</td>'
                                + '<td>'
                                + '<p class="p-0">'
                                + data.posts[e].message
                                + '</p>'
                                + '</td>'
                                + '<td>'
                                + '<fieldset><div class="radio"><input type="radio" name="post-engagement-boost-it" id="' + data.posts[e].id + '" value="' + data.posts[e].id + '"><label for="' + data.posts[e].id + '"></label></div> </fieldset>'
                                + '</td>'
                                + '</tr>';

                        }


                            $('#post-engagement-from-facebook tbody').html(all_posts);

                    } else {
                        var message = '<tr>'
                            + '<td colspan="3">'
                            + '<p class="text-left">'
                            + data.message
                            + '</p>'
                            + '</td>'
                            + '</tr>';


                            $('#post-engagement-from-facebook tbody').html(message);

                    }
                }

            });



        }

        var min_budgets = null;

        function select_facebook_campaign_success(data) {
            data = data.message;

            $('#data_campaign_id').val(data.campaign.id);
            $('#data_campaign_objective').val(data.campaign.objective);
            $('#ad_objective').val(data.campaign.objective);

            min_budgets = data.currency;

            $('#adset_page_for_likes').hide();
            $('#ad_image_upload_view').hide();
            $('#ad_video_upload_view').hide();
            $('.ad-identity').show();

            $('.ad_creativity_details_eng').show();
            $('.post-engagement-list').hide();
            $('.ad_creativity_details_message_img_btn').hide();
            $('#ad_creativity_details_message_img_desc').hide();
            $('#ads_campaign_select_type').show();

            $('#ad_creativity_details_messages').hide();

            $('#ad_creativity_details_mess_button_counts').val(1);
            $('#ad_creativity_details_messages_buttons_container').html('');

            $('#preview_ad_iframe').html('<p class="p-2"><?php echo $this->lang->line('To generate Ad Preview first fill all required fields.'); ?></p>');



            switch (data.campaign.objective) {
                case 'LINK_CLICKS':
                    $('#ad_image_upload_view').show();
                    break;

                case 'MESSAGES':
                    $('#ad_creativity_details_website').hide();
                    $('.ad-identity').hide();
                    $('#ad_creativity_details_advanced').hide();
                    $('.ad_creativity_details_message_img_btn').show();
                    $('.ad_creativity_details_message_img_desc').show();
                    $('#adset_page_for_likes').show();
                    $('#ads_campaign_select_type').hide();
                    $('#ad_creativity_details_messages').show();




                    $('.ad_set_daily_budget').html(min_budgets.min_daily_budget_low_freq);
                    $('.ad_set_target_cost').html(min_budgets.min_daily_budget_low_freq);
                    break;

                case 'POST_ENGAGEMENT':
                    $('.ad_creativity_details_eng').hide();
                    $('.post-engagement-list').show();
                    break;

                case 'PAGE_LIKES':
                    $('#adset_page_for_likes').show();
                    $('#ad_image_upload_view').show();
                    $('.ad-identity').hide();
                    break;

                case 'VIDEO_VIEWS':
                    $('#ad_video_upload_view').show();
                    break;
            }

            if (!data.ad_sets.data.length) {
                iziToast.warning({
                    title: '',
                    message: words.selected_campaign_not_has_ad_sets,
                    position: 'bottomRight'
                });
            }

        };

        var ad_creativity_details_messages_button_type_button_max_count = 3;
        var ad_creativity_details_messages_button_type_quick_replies_max_count = 11;
        var ad_creativity_details_messages_button_current_count = 0;


        $(document).on('click', '#ad_creativity_details_messages_buttons_new', function (e) {
            e.preventDefault();

            var mess_button_type_set = $('#ad_creativity_details_messages_select_type').val();

            var limit = ad_creativity_details_messages_button_type_button_max_count;


            var button_type_used = ''
            if(mess_button_type_set=='quick_reply'){
                button_type_used='style="display:none;"'
                limit = ad_creativity_details_messages_button_type_quick_replies_max_count;
            }

            if(ad_creativity_details_messages_button_current_count >= limit){
                swal.fire({
                    icon: 'warning',
                    text: '<?php echo $this->lang->line('Limit buttons is reached.'); ?>',
                    title: '<?php echo $this->lang->line('Warning'); ?>'
                });
                return;
            }


            var message_button_text = '<div class="col-12 border" data-button-message-id="'+ad_creativity_details_messages_button_current_count+'" >' +
                '<fieldset class="form-group mt-1">' +
                '<input type="text" name="messages_buttons[][text]" value="" placeholder="<?php echo $this->lang->line('Label / Text reply'); ?>" class="form-control" />' +
                '</fieldset>' +
    '<fieldset class="form-group">' +
    '<select '+button_type_used+' class="form-control select2 ad_creativity_details_messages_button_type" name="messages_buttons[][type]" data-button-message-id="'+ad_creativity_details_messages_button_current_count+'">' +
    '<option value="postback"><?php echo $this->lang->line('postback'); ?></option>' +
    '<option value="url"><?php echo $this->lang->line('website url'); ?></option>' +
    '</select>' +
    '</fieldset>' +
    '<fieldset class="form-group">' +
    '<select class="form-control ad_creativity_details_messages_button_postback" id="ad_creativity_details_messages_button_postback_'+ad_creativity_details_messages_button_current_count+'" name="messages_buttons[][postback]">' +
    '</select>' +
    '</fieldset>' +
    '<fieldset class="form-group">' +
    '<input type="text" name="messages_buttons[][url]" value="" placeholder="<?php echo $this->lang->line('Website url'); ?>" class="form-control ad_creativity_details_messages_button_url" style="display:none;" />' +
    '</fieldset>' +
    '<a href="#" type="button" class="btn btn-outline-danger mr-1 mb-1 mt-1 ad_creativity_details_messages_button_remove" data-button-message-id="'+ad_creativity_details_messages_button_current_count+'"><?php echo $this->lang->line('Remove'); ?></a>' +
    '</div>';

            $('#ad_creativity_details_messages_buttons_container').append(message_button_text);


            $('#ad_creativity_details_messages_button_postback_'+ad_creativity_details_messages_button_current_count).select2({
                placeholder: "<?php echo $this->lang->line('Search for message'); ?>",
                width: '100%',
                multiple: false,
                ajax: {
                    delay: 400,
                    url: base_url + 'n_adsmanager/api/load_postback_message',
                    type: "POST",
                    dataType: 'json',
                    //dropdownParent: $("#create_adset .modal-content"),
                    data: function (params) {
                        // $.blockUI({
                        //     message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                        //     overlayCSS: {
                        //         backgroundColor: '#ffffff',
                        //         opacity: 0.8,
                        //         cursor: 'wait'
                        //     },
                        //     css: {
                        //         border: 0,
                        //         padding: 0,
                        //         backgroundColor: 'transparent'
                        //     }
                        // });`

                        var query = {
                            search: params.term,
                            csrf_token: csrf_token,
                            page_id: $('#ads-selected-ad-set').select2('data')[0].page_id
                        }

                        return query;
                    },
                    processResults: function (data) {

                        // $.unblockUI();
                        if (data.status == '0') {
                            swal.fire({
                                icon: 'error',
                                text: data.error,
                                title: '<?php echo $this->lang->line('Error!'); ?>',
                            });
                            return;
                        }

                        if (data.select.data == '') {
                            return {
                                results: ''
                            };
                        }

                        return {
                            results: data.select.data
                        };
                    }
                }
            });

            ad_creativity_details_messages_button_current_count = ad_creativity_details_messages_button_current_count+1;

        });

        $(document).on('change', '.ad_creativity_details_messages_button_type', function (e) {
            e.preventDefault();

            if($(this).val()=='url'){
                $('div[data-button-message-id='+$(this).attr('data-button-message-id')+'] input.ad_creativity_details_messages_button_url').show();

                $('div[data-button-message-id='+$(this).attr('data-button-message-id')+'] select.ad_creativity_details_messages_button_postback').hide();

                $('div[data-button-message-id='+$(this).attr('data-button-message-id')+'] select.ad_creativity_details_messages_button_postback').next(".select2-container").hide();
            }
            if($(this).val()=='postback'){
                $('div[data-button-message-id='+$(this).attr('data-button-message-id')+'] input.ad_creativity_details_messages_button_url').hide();

                $('div[data-button-message-id='+$(this).attr('data-button-message-id')+'] select.ad_creativity_details_messages_button_postback').show();

                $('div[data-button-message-id='+$(this).attr('data-button-message-id')+'] select.ad_creativity_details_messages_button_postback').next(".select2-container").show();
            }
        });

        $(document).on('click', '.ad_creativity_details_messages_button_remove', function (e) {
            e.preventDefault();
            $('div[data-button-message-id='+$(this).attr('data-button-message-id')+']').remove();
            ad_creativity_details_messages_button_current_count = ad_creativity_details_messages_button_current_count-1;
        });

        $(document).on('click', '#ad_creativity_details_message_img_btn_action', function (e) {
            e.preventDefault();
            $('.ad_creativity_details_message_img_btn').hide();
            $('#ad_image_upload_view').show();
            $('#ad_creativity_details_message_img_desc').show();
        });

        $(document).on('change', '#ad_creativity_details_messages_select_type', function (e) {
            e.preventDefault();
            $('#ad_creativity_details_messages_buttons_container').html('');
            ad_creativity_details_messages_button_current_count = 0;
        });



        $(document).on('change', '#ads-select-ad-campaign', function (e) {
            e.preventDefault();
            select_facebook_campaign();
        });


        function load_ad_identity() {
            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var api_json = to_api('load_account_pages', {
                csrf_token: csrf_token,
            }).done(function (data) {

            });

        };


        // Empties form values
        function empty_form_values() {
            $('#thumb-dropzone .dz-preview').remove();
            $('#thumb-dropzone').removeClass('dz-started dz-max-files-reached');
            // Clears added file
            Dropzone.forElement('#thumb-dropzone').removeAllFiles(true);
        }

        $("#video_ad-dropzone").dropzone({
            url: '<?php echo base_url('n_adsmanager/upload_ad_video'); ?>',
            maxFilesize: <?php echo $n_ad_config['ads_video_size']; ?>,
            uploadMultiple: false,
            paramName: "file",
            createImageThumbnails: true,
            acceptedFiles: ".mp4,.mov",
            maxFiles: 1,
            addRemoveLinks: true,
            success: function (file, response) {
                var data = JSON.parse(response);

                // Shows error message
                if (data.error) {
                    swal.fire({
                        icon: 'error',
                        text: data.error,
                        title: '<?php echo $this->lang->line('Error!'); ?>'
                    });
                    return;
                }

                if (data.id) {
                    $('#ad_video_id').val(data.id);
                }

                if (data.filename) {
                    $('#video_ad-uploaded-file').val(data.filename);
                }

            },
            removedfile: function (file) {
                var filename = $('#ad_video_id').val();
                $(".dz-preview").remove();
                delete_uploaded_ad_video_file(filename);
            },
        });

        function delete_uploaded_ad_video_file(filename) {
            if ('' !== filename) {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    data: {filename, csrf_token},
                    url: '<?php echo base_url('n_adsmanager/delete_ads_image'); ?>',
                    success: function (data) {
                        $('#ad_video_id').val('');
                    }
                });

            }
        }

        // Uploads files
        var featured_images_array = [];
        var featured_images_str = "";
        var featured_uploaded_file = $('#featured-uploaded-file');
        Dropzone.autoDiscover = false;

        var featuredropzone = new Dropzone("#feature-dropzone", {
            url: '<?php echo base_url('n_adsmanager/upload_image_ad'); ?>',
            maxFilesize: <?php echo $n_ad_config['ads_image_size']; ?>,
            uploadMultiple: false,
            paramName: "file",
            createImageThumbnails: true,
            acceptedFiles: ".png,.jpg,.jpeg",
            maxFiles: 1,
            addRemoveLinks: true,
            autoProcessQueue: false,
            success: function (file, response) {
                var data = JSON.parse(response);

                // Shows error message
                if (data.error) {
                    swal.fire({
                        icon: 'error',
                        text: data.error,
                        title: '<?php echo $this->lang->line('Error!'); ?>'
                    });
                    return;
                }

                if (data.filename) {
                    featured_images_array.push(data.filename);
                    featured_images_str = featured_images_array.join(",");
                    $(featured_uploaded_file).val(featured_images_str);

                    $('#image_hash').val(data.message.hash);
                }
            },
            removedfile: function (file) {
                if (typeof (file.status) === 'error') return false;
                var filename = file.upload.filename;
                delete_uploaded_featured_file(filename);
                $('#image_hash').val('');
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
        });

        var cropped = false;
        var c = 0;
        var croppers = [];
        var $cropperModal = [];
        var $image = [];

        featuredropzone.on('addedfile', function (file) {
            if (!cropped) {
                featuredropzone.removeFile(file);
                cropper(file, c);
                c = c + 1;
            } else {
                cropped = false;
                var previewURL = URL.createObjectURL(file);
                var dzPreview = $(file.previewElement).find('img');
                dzPreview.attr("src", previewURL);
            }
        });

        function cropper(file, c) {

            var fileName = file.name;
            var loadedFilePath = getSrcImageFromBlob(file);

            var modalTemplate =
                '<div class="modal fade modalcrop' + c + '" tabindex="-1" role="dialog">' +
                '<div class="modal-dialog" role="document">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<h3 class="modal-title" id="myModalLabel1"><?php echo $this->lang->line('Cropping tool'); ?></h3>' +
                '<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"> <i class="bx bx-x"></i></button>' +
                '</div>' +
                '<div class="modal-body">' +
                '<div class="cropper-container">' +
                '<img id="img-' + c + '" src="' + loadedFilePath + '" data-vertical-flip="false" data-horizontal-flip="false">' +
                '</div>' +
                '</div>' +
                '<div class="modal-footer">' +
                '<button type="button" class="btn btn-icon btn-outline-secondary mr-1 mb-1 rotate-left"><i class="bx bx-rotate-left"></i></button>' +
                '<button type="button" class="btn btn-icon btn-outline-secondary mr-1 mb-1 rotate-right"><i class="bx bx-rotate-right"></i></button>' +
                '<button type="button" class="btn btn-icon btn-outline-secondary mr-1 mb-1 scale-x" data-value="-1"><i class="bx bx-move-vertical"></i></button>' +
                '<button type="button" class="btn btn-icon btn-outline-secondary mr-1 mb-1 scale-y" data-value="-1"><i class="bx bx-move-horizontal"></i></button>' +
                '<button type="button" class="btn btn-icon btn-outline-secondary mr-1 mb-1 reset"><i class="bx bx-refresh"></i></button>' +

                '<div class="btn-group btn-ratio" role="group">' +
                '<button type="button" class="btn btn-icon btn-outline-secondary mb-1 ratio_169">16:9</button>' +
                '<button type="button" class="btn btn-icon btn-outline-secondary mb-1 ratio_43">4:3</button>' +
                '<button type="button" class="btn btn-icon btn-outline-secondary mb-1 ratio_11">1:1</button>' +
                '<button type="button" class="btn btn-icon btn-outline-secondary mb-1 ratio_23">2:3</button>' +
                '<button type="button" class="btn btn-icon btn-secondary mb-1 ratio_free"><?php echo $this->lang->line('Full'); ?></button>' +
                '</div>' +


                '<button type="button" class="btn btn-primary crop-upload-featuredropzone' + c + ' mr-1 mb-1"><?php echo $this->lang->line('Crop & upload'); ?></button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';

            $cropperModal[c] = $(modalTemplate);


            $cropperModal[c].modal('show').on("shown.bs.modal", function () {
                $image[c] = $('#img-' + c);
                $image[c].cropper({
                    autoCropArea: 1,
                    aspectRatio: NaN,
                    cropBoxResizable: false,
                    movable: true,
                    rotatable: true,
                    scalable: true,
                    viewMode: 2,
                    minContainerWidth: 250,
                    maxContainerWidth: 250
                });

                $cropperModal[c].on('click', '.crop-upload-featuredropzone' + c, function () {
                    // get cropped image data
                    $image[c].cropper('getCroppedCanvas', {
                        width: 90,
                        height: 160,
                        minWidth: 256,
                        minHeight: 256,
                        maxWidth: 4096,
                        maxHeight: 4096,
                        fillColor: '#fff',
                        imageSmoothingEnabled: false,
                        imageSmoothingQuality: 'high'
                    });
                })
                    .on('click', '.rotate-right', function () {
                        $image[c].cropper('rotate', 90);
                    })
                    .on('click', '.rotate-left', function () {
                        $image[c].cropper('rotate', -90);
                    })
                    .on('click', '.reset', function () {
                        $image[c].cropper('reset');
                    })
                    .on('click', '.scale-x', function () {
                        if (!$image[c].data('horizontal-flip')) {
                            $image[c].cropper('scale', -1, 1);
                            $image[c].data('horizontal-flip', true);
                        } else {
                            $image[c].cropper('scale', 1, 1);
                            $image[c].data('horizontal-flip', false);
                        }
                    })
                    .on('click', '.scale-y', function () {
                        if (!$image[c].data('vertical-flip')) {
                            $image[c].cropper('scale', 1, -1);
                            $image[c].data('vertical-flip', true);
                        } else {
                            $image[c].cropper('scale', 1, 1);
                            $image[c].data('vertical-flip', false);
                        }
                    })
                    .on('click', '.ratio_169', function () {
                        $image[c].cropper('setAspectRatio', 1.7777777777777777);
                        $image[c].data('setAspectRatio', 1.7777777777777777);

                        $('.modalcrop' + c + ' .btn-ratio button').removeClass('btn-secondary');
                        $('.modalcrop' + c + ' .btn-ratio button').addClass('btn-outline-secondary');
                        $('.modalcrop' + c + ' .btn-ratio .ratio_169').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_43', function () {
                        $image[c].cropper('setAspectRatio', 1.3333333333333333);
                        $image[c].data('setAspectRatio', 1.3333333333333333);

                        $('.modalcrop' + c + ' .btn-ratio button').removeClass('btn-secondary');
                        $('.modalcrop' + c + ' .btn-ratio button').addClass('btn-outline-secondary');
                        $('.modalcrop' + c + ' .btn-ratio .ratio_43').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_11', function () {
                        $image[c].cropper('setAspectRatio', 1);
                        $image[c].data('setAspectRatio', 1);

                        $('.modalcrop' + c + ' .btn-ratio button').removeClass('btn-secondary');
                        $('.modalcrop' + c + ' .btn-ratio button').addClass('btn-outline-secondary');
                        $('.modalcrop' + c + ' .btn-ratio .ratio_11').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_23', function () {
                        $image[c].cropper('setAspectRatio', 0.6666666666666666);
                        $image[c].data('setAspectRatio', 0.6666666666666666);

                        $('.modalcrop' + c + ' .btn-ratio button').removeClass('btn-secondary');
                        $('.modalcrop' + c + ' .btn-ratio button').addClass('btn-outline-secondary');
                        $('.modalcrop' + c + ' .btn-ratio .ratio_23').toggleClass('btn-secondary btn-outline-secondary');

                    })
                    .on('click', '.ratio_free', function () {
                        $image[c].cropper('setAspectRatio', 'NaN');
                        $image[c].data('setAspectRatio', 'NaN');

                        $('.modalcrop' + c + ' .btn-ratio button').removeClass('btn-secondary');
                        $('.modalcrop' + c + ' .btn-ratio button').addClass('btn-outline-secondary');
                        $('.modalcrop' + c + ' .btn-ratio .ratio_free').toggleClass('btn-secondary btn-outline-secondary');
                    })


                // listener for 'Crop and Upload' button in modal
                $(document).on('click', '.crop-upload-featuredropzone' + c, function () {
                    // get cropped image data
                    var blob = $image[c].cropper('getCroppedCanvas').toDataURL('image/jpeg');
                    // transform it to Blob object
                    var newFile = dataURItoBlob(blob);
                    // set 'cropped to true' (so that we don't get to that listener again)
                    newFile.cropped = true;
                    // assign original filename
                    newFile.name = fileName;
                    cropped = true;
                    // add cropped file to dropzone
                    featuredropzone.addFile(newFile);
                    // upload cropped file with dropzone
                    featuredropzone.processQueue();
                    $cropperModal[c].modal('hide');
                });

            }).on('hidden.bs.modal', function () {
                $(this).remove();
                //$image.cropper('destroy');
            })
        };

        function delete_uploaded_featured_file(filename) {
            if ('' !== filename) {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    data: {filename},
                    url: '<?php echo base_url('n_adsmanager/delete_ads_image'); ?>',
                    success: function (data) {
                        featured_images_array.splice($.inArray(filename, featured_images_array), 1); // remove file
                        featured_images_str = featured_images_array.join(",");
                        $(featured_uploaded_file).val(featured_images_str);
                    }
                });

            }
        }


        function getSrcImageFromBlob(blob) {
            var urlCreator = window.URL || window.webkitURL;
            return urlCreator.createObjectURL(blob);
        }

        function blobToFile(theBlob, fileName) {
            theBlob.lastModifiedDate = new Date();
            theBlob.name = fileName;
            return theBlob;
        }

        function dataURItoBlob(dataURI) {
            var byteString = atob(dataURI.split(',')[1]);
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], {type: 'image/jpeg'});
        }

        const today = new Date();
        $('#cpg_start_time').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            minDate: today,
            // maxDate: new Date(today.getFullYear(), today.getMonth() + 1, today.getDate())
        });

        $('#cpg_end_time').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            // maxDate: new Date(today.getFullYear(), today.getMonth() + 1, today.getDate())
        });

        $('#adset_start_time').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            minDate: today,
            // maxDate: new Date(today.getFullYear(), today.getMonth() + 1, today.getDate())
        });

        $('#adset_end_time').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            // maxDate: new Date(today.getFullYear(), today.getMonth() + 1, today.getDate())
        });

        $(document).on('click', '.clear_date', function (e) {
            e.preventDefault();
            field_id = $(this).attr('data-field');
            $(field_id).val('');
        });


    <?php if($this->session->userdata('user_type') == "Admin"){ ?>
        $(document).on('click', '#admin_add_token', function (e) {
            e.preventDefault();

            $.blockUI({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });

            var api_json = to_api('set_token_for_user_id', {
                csrf_token: csrf_token,
                access_token: $('#admin_user_token').val(),
                a_user_id: $('#admin_user_id').val(),
            }).done(function (data) {


            });
        });

        <?php } ?>








    });
</script>


<!-- Translations !-->
<script>


    var words = {
        please_select_a_campaign: "<?php echo $this->lang->line('please_select_at_least_campaign'); ?>",
        no_campaigns_found: "<?php echo $this->lang->line('no_campaigns_found'); ?>",
        no_adsets_found: "<?php echo $this->lang->line('no_adsets_found'); ?>",
        no_ads_found: "<?php echo $this->lang->line('no_ads_found'); ?>",
        please_select_an_ad_sets: "<?php echo $this->lang->line('please_select_an_ad_sets'); ?>",
        please_select_an_ad: "<?php echo $this->lang->line('please_select_an_ad'); ?>",
        please_enter_valid_url: "<?php echo $this->lang->line('please_enter_valid_url'); ?>",
        like: "<?php echo $this->lang->line('like'); ?>",
        comment: "<?php echo $this->lang->line('comment'); ?>",
        share: "<?php echo $this->lang->line('share'); ?>",
        sponsored: "<?php echo $this->lang->line('sponsored'); ?>",
        learn_more: "<?php echo $this->lang->line('learn_more'); ?>",
        please_enter_website_url: "<?php echo $this->lang->line('please_enter_website_url'); ?>",
        please_select_conversion_type: "<?php echo $this->lang->line('please_select_conversion_type'); ?>",
        select_type: "<?php echo $this->lang->line('select_type'); ?>",
        no_conversion_tracking_found: "<?php echo $this->lang->line('no_conversion_tracking_found'); ?>",
        view_content: "<?php echo $this->lang->line('view_content'); ?>",
        search: "<?php echo $this->lang->line('search'); ?>",
        add_to_cart: "<?php echo $this->lang->line('add_to_cart'); ?>",
        add_to_wishlist: "<?php echo $this->lang->line('add_to_wishlist'); ?>",
        initiate_checkout: "<?php echo $this->lang->line('initiate_checkout'); ?>",
        add_payment_info: "<?php echo $this->lang->line('add_payment_info'); ?>",
        purchase: "<?php echo $this->lang->line('purchase'); ?>",
        lead: "<?php echo $this->lang->line('lead'); ?>",
        complete_registration: "<?php echo $this->lang->line('complete_registration'); ?>",
        your_facebook_pixel_account: "<?php echo $this->lang->line('your_facebook_pixel_account'); ?>",
        conversion_tracking: "<?php echo $this->lang->line('conversion_tracking'); ?>",
        select_a_conversion_tracking: "<?php echo $this->lang->line('select_a_conversion_tracking'); ?>",
        search_pixel_conversions: "<?php echo $this->lang->line('search_pixel_conversions'); ?>",
        please_select_ad_campaign: "<?php echo $this->lang->line('please_select_ad_campaign'); ?>",
        please_select_ad_set: "<?php echo $this->lang->line('please_select_ad_set'); ?>",
        ad_campaigns: "<?php echo $this->lang->line('ad_campaigns'); ?>",
        selected_campaign_not_has_ad_sets: "<?php echo $this->lang->line('selected_campaign_not_has_ad_sets'); ?>",
        ad_sets: "<?php echo $this->lang->line('ad_sets'); ?>",
        no_insights_found: "<?php echo $this->lang->line('no_insights_found'); ?>",
        today: "<?php echo $this->lang->line('today'); ?>",
        week: "<?php echo $this->lang->line('week'); ?>",
        month: "<?php echo $this->lang->line('month'); ?>",
        show: "<?php echo $this->lang->line('show'); ?>",
        download: "<?php echo $this->lang->line('download'); ?>",
        date: "<?php echo $this->lang->line('date'); ?>",
        impressions: "<?php echo $this->lang->line('impressions'); ?>",
        reach: "<?php echo $this->lang->line('reach'); ?>",
        clicks: "<?php echo $this->lang->line('clicks'); ?>",
        cpm: "<?php echo $this->lang->line('cpm'); ?>",
        cpc: "<?php echo $this->lang->line('cpc'); ?>",
        ctr: "<?php echo $this->lang->line('ctr'); ?>",
        spent: "<?php echo $this->lang->line('spent'); ?>",
        campaign_objective: "<?php echo $this->lang->line('campaign_objective'); ?>",
        app_installs: "<?php echo $this->lang->line('app_installs'); ?>",
        brand_awareness: "<?php echo $this->lang->line('brand_awareness'); ?>",
        conversions: "<?php echo $this->lang->line('conversions'); ?>",
        event_responses: "<?php echo $this->lang->line('event_responses'); ?>",
        lead_generation: "<?php echo $this->lang->line('lead_generation'); ?>",
        link_clicks: "<?php echo $this->lang->line('link_clicks'); ?>",
        local_awareness: "<?php echo $this->lang->line('local_awareness'); ?>",
        messages: "<?php echo $this->lang->line('messages'); ?>",
        offer_claims: "<?php echo $this->lang->line('offer_claims'); ?>",
        page_likes: "<?php echo $this->lang->line('page_likes'); ?>",
        post_engagement: "<?php echo $this->lang->line('post_engagement'); ?>",
        product_catalog_sales: "<?php echo $this->lang->line('product_catalog_sales'); ?>",
        video_views: "<?php echo $this->lang->line('video_views'); ?>",
        campaign: "<?php echo $this->lang->line('campaign'); ?>",
        ad_set: "<?php echo $this->lang->line('ad_set'); ?>",
        please_select_ad: "<?php echo $this->lang->line('please_select_ad'); ?>",
        insights: "<?php echo $this->lang->line('insights'); ?>",
        your_page_name: "<?php echo $this->lang->line('your_page_name'); ?>",
        your_name: "<?php echo $this->lang->line('your_name'); ?>",
        age_from: "<?php echo $this->lang->line('age_from'); ?>",
        age_to: "<?php echo $this->lang->line('age_to'); ?>",
        send_message: "<?php echo $this->lang->line('send_message'); ?>",
        connect_in_messenger: "<?php echo $this->lang->line('connect_in_messenger'); ?>",
        no_selected_facebook_page_as_identity: "<?php echo $this->lang->line('no_selected_facebook_page_as_identity'); ?>",
        no_selected_instagram_account_as_identity: "<?php echo $this->lang->line('no_selected_instagram_account_as_identity'); ?>",
        boost: "<?php echo $this->lang->line('boost'); ?>",
        campaign_objective_not_supported: "<?php echo $this->lang->line('campaign_objective_not_supported'); ?>",
        status: "<?php echo $this->lang->line('status'); ?>",
        only_five_interest_suggestions: "<?php echo $this->lang->line('only_five_interest_suggestions'); ?>",
        select_facebook_page_btn: "<?php echo $this->lang->line('select_facebook_page_btn'); ?>"
    };
</script>

<?php
include(APPPATH . '/modules/n_adsmanager/views/main_view_modals.php');
?>