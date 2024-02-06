<?php
$doyouwanttodeletethiscontact = $this->lang->line("Do you want to delete this subscriber?");
$youhavenotselected = $this->lang->line("You have not selected any subscriber to assign label. You can choose upto");
$youhavenotselectanysubscribertoassignsequence = $this->lang->line("You have not selected any subscriber to assign sms/email sequence campaign. You can choose upto");
$youhavenotselected2 = $this->lang->line("You have not selected any subscriber to delete.");
$leadsatatime = $this->lang->line("subscribers at a time.");
$youcanselectupto = $this->lang->line("You can select upto");
$leadsyouhaveselected = $this->lang->line(",you have selected");
$leads = $this->lang->line("subscribers.");
$youhavenotselectedany = $this->lang->line("You have not selected any subscriber to delete. you can choose upto");
$youhavenotselectedanyleadtoassigngroup = $this->lang->line("You have not selected any subscriber to assign label.");
$youhavenotselectedanyleadtoassigndripcampaign = $this->lang->line("You have not selected any subscriber to assign sequence campaign.");
$youhavenotselectedanyleadgroup = $this->lang->line("You have not selected any label.");
$youhavenotselectedanysequence = $this->lang->line("You have not selected any sequence campaign.");
$pleasewait = $this->lang->line("Please wait...");
$groupshavebeenassignedsuccessfully = $this->lang->line("Labels have been assigned successfully");
$sequencehavebeenassignedsuccessfully = $this->lang->line("Sequence campaign have been assigned successfully");
$contactshavebeendeletedsuccessfully = $this->lang->line("Subscribers have been deleted successfully");
$somethingwentwrongpleasetryagain = $this->lang->line("Something went wrong, please try again.");

$ig_bot_exists = addon_exist($module_id = 320, $addon_unique_name = "instagram_bot") ? '1' : '0';

$disabledsuccessfully = $this->lang->line("Backgound scanning has been disabled successfully.");
$enabledsuccessfully = $this->lang->line("Backgound scanning has been enabled successfully.");

$ig_bot_exists = addon_exist($module_id = 320, $addon_unique_name = "instagram_bot") ? '1' : '0';
?>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/modules/chocolat/dist/css/chocolat.css?ver=<?php echo $n_config['theme_version']; ?>">
    <script src="<?php echo base_url(); ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/select/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script type="text/javascript"
            src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/pdfmake.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/vfs_fonts.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url(); ?>n_assets/plugins/summernote/summernote-bs4.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script type="text/javascript">
        var areWeUsingScroll = false;
        //TODO: areWeUsingScroll

        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,

            });
        });

        var is_webview_exist = "<?php echo $this->is_webview_exist; ?>"
        var base_url = "<?php echo base_url();?>";
        var youhavenotselected = "<?php echo $youhavenotselected;?>";
        var youhavenotselectanysubscribertoassignsequence = "<?php echo $youhavenotselectanysubscribertoassignsequence; ?>";
        var youhavenotselected2 = "<?php echo $youhavenotselected2;?>";
        var leadsatatime = "<?php echo $leadsatatime;?>";
        var youcanselectupto = "<?php echo $youcanselectupto;?>";
        var leadsyouhaveselected = "<?php echo $leadsyouhaveselected;?>";
        var leads = "<?php echo $leads;?>";
        var youhavenotselectedanyleadtoassigngroup = "<?php echo $youhavenotselectedanyleadtoassigngroup; ?>";
        var youhavenotselectedanyleadtoassigndripcampaign = "<?php echo $youhavenotselectedanyleadtoassigndripcampaign; ?>";
        var youhavenotselectedanyleadgroup = "<?php echo $youhavenotselectedanyleadgroup; ?>";
        var pleasewait = "<?php echo $pleasewait; ?>";
        var groupshavebeenassignedsuccessfully = "<?php echo $groupshavebeenassignedsuccessfully; ?>";
        var sequencehavebeenassignedsuccessfully = "<?php echo $sequencehavebeenassignedsuccessfully; ?>";
        var contactshavebeendeletedsuccessfully = "<?php echo $contactshavebeendeletedsuccessfully; ?>";
        var auto_selected_page = "<?php echo $auto_selected_page; ?>";
        var auto_selected_subscriber = "<?php echo $auto_selected_subscriber; ?>";
        var youhavenotselectedanysequence = "<?php echo $youhavenotselectedanysequence; ?>";
        var ig_bot_exists = "<?php echo $ig_bot_exists; ?>";

        setTimeout(function () {
            $('#search_date_range').daterangepicker({
                locale: daterange_locale,
                ranges: {
                    '<?php echo $this->lang->line("Last 30 Days");?>': [moment().subtract(29, 'days'), moment()],
                    '<?php echo $this->lang->line("This Month");?>': [moment().startOf('month'), moment().endOf('month')],
                    '<?php echo $this->lang->line("Last Month");?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            }, function (start, end) {
                $('#search_date_range_val').val(start.format('YYYY-M-D') + '|' + end.format('YYYY-M-D')).change();
            });
        }, 3000);

        function get_page_details(elem) {
            $('.multi_layout2 #middle_column .waiting').show();
            $('.multi_layout2 #middle_column_content_body').hide();

            var page_table_id = $('#bot_list_select').val();

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>subscriber_manager/get_page_details",
                data: {page_table_id: page_table_id},
                dataType: 'JSON',
                success: function (response) {

                    response.title = response.title.replaceAll('fab fa-instagram', 'bx bxl-instagram');
                    response.title = response.title.replaceAll('fab fa-facebook', 'bx bxl-facebook');
                    response.title = response.title.replaceAll('fas fa-info-circle', 'bx bx-info-circle');

                    $(".multi_layout2 #middle_column_content_title").html(response.title);

                    response.middle_column_content = response.middle_column_content.replaceAll('<span class="custom-switch-indicator"></span>', '');
                    response.middle_column_content = response.middle_column_content.replaceAll('<span class="custom-switch-description">', '<label class="custom-control-label mr-1" for="switch_to_instagram"></label2><span class="font-medium-1 flex-wrap">');
                    response.middle_column_content = response.middle_column_content.replaceAll('</a></span>', '</a></span>');
                    response.middle_column_content = response.middle_column_content.replaceAll('custom-switch-input', 'custom-control-input');
                    response.middle_column_content = response.middle_column_content.replaceAll('<label class="custom-switch float-right">', '<div class="custom-control custom-switch custom-control-inline mb-1 float-right">');
                    response.middle_column_content = response.middle_column_content.replaceAll('</label>', '</a></div>');
                    response.middle_column_content = response.middle_column_content.replaceAll('</label2>', '</label>');
                    response.middle_column_content = response.middle_column_content.replaceAll('full_width', 'container');
                    response.middle_column_content = response.middle_column_content.replaceAll('fab fa-instagram', 'bx bxl-instagram');
                    response.middle_column_content = response.middle_column_content.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                    response.middle_column_content = response.middle_column_content.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                    response.middle_column_content = response.middle_column_content.replaceAll('card-body pt-2', 'card-body');


                    $(".multi_layout2 #middle_column_content_body").html(response.middle_column_content).show();
                    $("#put_page_label_list").html(response.dropdown);
                    $('.multi_layout2 #middle_column .waiting').hide();
                }
            });
        }


        $("document").ready(function () {

            var perscroll_label;
            var table_label = '';
            var perscroll;
            var table1 = '';
            if (auto_selected_page != '' && auto_selected_page != '0') $('#bot_list_select').val(auto_selected_page).trigger('change');
            //$.fn.dataTable.ext.errMode = 'throw';
            setTimeout(function () {
                table_label = $("#mytablelabel").DataTable({
                    serverSide: true,
                    processing: true,
                    bFilter: false,
                    order: [[2, "asc"]],
                    pageLength: 10,
                    ajax: {
                        "url": base_url + 'subscriber_manager/contact_group_data',
                        "type": 'POST',
                        data: function (d) {
                            d.page_id = $('#bot_list_select').val();
                            d.searching = $('#searching').val();
                        }
                    },
                    responsive: true,
                    language:
                        {
                            url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                        },
                    dom: '<"top"f>rt<"bottom"lip><"clear">',
                    columnDefs: [
                        {
                            targets: [0, 1],
                            visible: false
                        },
                        {
                            targets: [0, 1],
                            sortable: false
                        },
                        {
                            targets: [2],
                            "render": function (data, type, row) {
                                data = data.replaceAll('fas fa-user-slash', 'bx bxs-user-x');
                                data = data.replaceAll('fas fa-comment-slash', 'bx bx-comment-x');
                                data = data.replaceAll('fas fa-map', 'bx bx-map');
                                data = data.replaceAll('fas fa-birthday-cake', 'bx bx-cake');
                                data = data.replaceAll('fas fa-headset', 'bx bx-headphone');
                                data = data.replaceAll('fas fa-phone', 'bx bx-phone');
                                data = data.replaceAll('fas fa-robot', 'bx bx-bot');
                                data = data.replaceAll('fas fa-envelope', 'bx bx-envelope');
                                data = data.replaceAll('fas fa-code', 'bx bx-code');
                                data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                                data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                                data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
                                data = data.replaceAll('far fa-copy', 'bx bx-copy');
                                data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                                data = data.replaceAll('fas fa-trash', 'bx bx-trash');
                                data = data.replaceAll('fa fa-eye', 'bx bxs-show');
                                data = data.replaceAll('fas fa-eye', 'bx bxs-show');
                                data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                                data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                                data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                                data = data.replaceAll('fas fa-briefcase', 'bx bx-briefcase');
                                data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
                                data = data.replaceAll('fas fa-file-export', 'bx bx-export');
                                data = data.replaceAll('fa fa-comment', 'bx bx-comment');
                                data = data.replaceAll('fa fa-user', 'bx bx-user');
                                data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
                                data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                                data = data.replaceAll('fas fa-comments', 'bx bx-comment');
                                data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                                data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                                data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                                data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');
                                data = data.replaceAll('fas fa-key', 'bx bx-key');
                                data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                                data = data.replaceAll('fas fa-male', 'bx bx-male')
                                data = data.replaceAll('fas fa-female', 'bx bx-female')
                                data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                                data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                                data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                                data = data.replaceAll('fa fa-send', 'bx bx-send');
                                data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                                data = data.replaceAll('fa fa-code', 'bx bx-code');
                                data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
                                data = data.replaceAll('fas fa-pause', 'bx bx-pause');
                                data = data.replaceAll('fa fa-cog', 'bx bx-cog');
                                data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
                                data = data.replaceAll('fas fa-comment', 'bx bx-comment');
                                data = data.replaceAll('swal(', 'swal.fire(');
                                data = data.replaceAll('rounded-circle', 'rounded-circle');
                                data = data.replaceAll('fas fa-check-circle', 'bx bx-check-circle');
                                data = data.replaceAll('fas fa-plug', 'bx bx-plug');
                                data = data.replaceAll('fas fa-times-circle', 'bx bx-time');
                                data = data.replaceAll('fas fa-chart-bar', 'bx bx-chart');
                                data = data.replaceAll('fas fa-cloud-download-alt', 'bx bxs-cloud-download');
                                data = data.replaceAll('padding-10', 'p-10');
                                data = data.replaceAll('padding-left-10', 'pl-10');
                                data = data.replaceAll('h4', 'h5 class="card-title font-medium-1"');
                                data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                                data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                                data = data.replaceAll('fas fa-city', 'bx bxs-city');
                                data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                                data = data.replaceAll('fas fa-at', 'bx bx-at');
                                data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                                data = data.replaceAll('<div class="dropdown-title"><?php echo $this->lang->line('Options'); ?></div>', '<h6 class="dropdown-header"><?php echo $this->lang->line('Options'); ?></h6>');
                                data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                                data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                                data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                                data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');
                                data = data.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                                data = data.replaceAll('fas fa-ellipsis-v', 'bx bx-dots-vertical-rounded');
                                data = data.replaceAll('208px', '308px');
                                data = data.replaceAll("data-toggle='tooltip'", " data-html='true' data-toggle='tooltip'");

                                data = data.replaceAll('fas fa-male', 'bx bx-male');
                                data = data.replaceAll('fas fa-female', 'bx bx-female');


                                return data;
                            }
                        },
                    ],
                    fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                        if (areWeUsingScroll) {
                            if (perscroll_label) perscroll_label.destroy();
                            perscroll_label = new PerfectScrollbar('#mytablelabel_wrapper .dataTables_scrollBody');
                        }
                    },
                    scrollX: 'auto',
                    fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                        if (areWeUsingScroll) {
                            if (perscroll_label) perscroll_label.destroy();
                            perscroll_label = new PerfectScrollbar('#mytablelabel_wrapper .dataTables_scrollBody');
                        }
                    },

                });
                var page_id = $('#bot_list_select').val();
                var return_social_media_by_force = '0';

                $.ajax({
                    context: this,
                    type: 'POST',
                    dataType: 'JSON',
                    url: "<?php echo site_url();?>home/switch_to_page",
                    data: {page_id, return_social_media_by_force},
                    success: function (response) {
                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>subscriber_manager/get_label_dropdown",
                            data: {page_id: page_id},
                            success: function (response) {
                                $("#label_dropdown").html(response);
                                if (table1 != '') table1.draw(false);
                                if (table_label != '') table_label.draw(false);
                                // $("#page_err").text("");
                            }
                        });
                    }
                });

            }, 1000);

            var hideCol = [3, 10, 11, 12, 13];
            if (selected_global_media_type == 'ig') {
                hideCol.push(5);
                hideCol.push(6);
            } else hideCol.push(7);

            setTimeout(function () {
                table1 = $("#mytable").DataTable({
                    serverSide: true,
                    processing: true,
                    bFilter: false,
                    order: [[12, "desc"]],
                    pageLength: 10,
                    ajax: {
                        url: base_url + 'subscriber_manager/bot_subscribers_data',
                        type: 'POST',
                        data: function (d) {
                            d.page_id = $('#bot_list_select').val();
                            d.search_value = $('#search_value').val();
                            d.label_id = $('#label_id').val();
                            d.email_phone_birth = $('#email_phone_birth').val();
                            d.gender = $('#gender').val();
                        }
                    },
                    language:
                        {
                            url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                        },
                    dom: '<"top"f>rt<"bottom"lip><"clear">',
                    columnDefs: [
                        {
                            targets: hideCol,
                            visible: false
                        },
                        {
                            targets: [0, 2, 4, 8, 9, 10, 11, 12],
                            className: 'text-center'
                        },
                        {
                            targets: [0, 1, 2, 8, 10],
                            sortable: false
                        },
                        {
                            targets: [5, 6, 7, 8, 9],
                            "render": function (data, type, row) {
                                data = data.replaceAll('fas fa-user-slash', 'bx bxs-user-x');
                                data = data.replaceAll('fas fa-comment-slash', 'bx bx-comment-x');
                                data = data.replaceAll('fas fa-map', 'bx bx-map');
                                data = data.replaceAll('fas fa-birthday-cake', 'bx bx-cake');
                                data = data.replaceAll('fas fa-headset', 'bx bx-headphone');
                                data = data.replaceAll('fas fa-phone', 'bx bx-phone');
                                data = data.replaceAll('fas fa-robot', 'bx bx-bot');
                                data = data.replaceAll('fas fa-envelope', 'bx bx-envelope');
                                data = data.replaceAll('fas fa-code', 'bx bx-code');
                                data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                                data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                                data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
                                data = data.replaceAll('far fa-copy', 'bx bx-copy');
                                data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                                data = data.replaceAll('fas fa-trash', 'bx bx-trash');
                                data = data.replaceAll('fa fa-eye', 'bx bxs-show');
                                data = data.replaceAll('fas fa-eye', 'bx bxs-show');
                                data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                                data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                                data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                                data = data.replaceAll('fas fa-briefcase', 'bx bx-briefcase');
                                data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
                                data = data.replaceAll('fas fa-file-export', 'bx bx-export');
                                data = data.replaceAll('fa fa-comment', 'bx bx-comment');
                                data = data.replaceAll('fa fa-user', 'bx bx-user');
                                data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
                                data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                                data = data.replaceAll('fas fa-comments', 'bx bx-comment');
                                data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                                data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                                data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                                data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');
                                data = data.replaceAll('fas fa-key', 'bx bx-key');
                                data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                                data = data.replaceAll('fas fa-male', 'bx bx-male')
                                data = data.replaceAll('fas fa-female', 'bx bx-female')
                                data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                                data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                                data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                                data = data.replaceAll('fa fa-send', 'bx bx-send');
                                data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                                data = data.replaceAll('fa fa-code', 'bx bx-code');
                                data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
                                data = data.replaceAll('fas fa-pause', 'bx bx-pause');
                                data = data.replaceAll('fa fa-cog', 'bx bx-cog');
                                data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
                                data = data.replaceAll('fas fa-comment', 'bx bx-comment');
                                data = data.replaceAll('swal(', 'swal.fire(');
                                data = data.replaceAll('rounded-circle', 'rounded-circle');
                                data = data.replaceAll('fas fa-check-circle', 'bx bx-check-circle');
                                data = data.replaceAll('fas fa-plug', 'bx bx-plug');
                                data = data.replaceAll('fas fa-times-circle', 'bx bx-time');
                                data = data.replaceAll('fas fa-chart-bar', 'bx bx-chart');
                                data = data.replaceAll('fas fa-cloud-download-alt', 'bx bxs-cloud-download');
                                data = data.replaceAll('padding-10', 'p-10');
                                data = data.replaceAll('padding-left-10', 'pl-10');
                                data = data.replaceAll('h4', 'h5 class="card-title font-medium-1"');
                                data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                                data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                                data = data.replaceAll('fas fa-city', 'bx bxs-city');
                                data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                                data = data.replaceAll('fas fa-at', 'bx bx-at');
                                data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                                data = data.replaceAll('<div class="dropdown-title"><?php echo $this->lang->line('Options'); ?></div>', '<h6 class="dropdown-header"><?php echo $this->lang->line('Options'); ?></h6>');
                                data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                                data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                                data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                                data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');
                                data = data.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                                data = data.replaceAll('fas fa-ellipsis-v', 'bx bx-dots-vertical-rounded');
                                data = data.replaceAll('208px', '308px');
                                data = data.replaceAll("data-toggle='tooltip'", " data-html='true' data-toggle='tooltip'");

                                data = data.replaceAll('fas fa-male', 'bx bx-male');
                                data = data.replaceAll('fas fa-female', 'bx bx-female');

                                data = data.replaceAll('blue', 'text-primary');
                                data = data.replaceAll('purple', 'text-danger');

                                data = data.replaceAll('&nbsp;', '');
                                data = data.replaceAll('fas fa-female', 'bx bx-female');


                                return data;
                            }
                        },
                        {
                            targets: [2],
                            "render": function (data, type, row) {
                                data = data.replaceAll('<img ', '<img onerror="this.onerror=null;" ');
                                data = data.replaceAll('null;', "null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>'");
                                return data;
                            }
                        }
                    ],
                    fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                        if (areWeUsingScroll) {
                            if (perscroll) perscroll.destroy();
                            perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                        }
                    },
                    scrollX: 'auto',
                    fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                        if (areWeUsingScroll) {
                            if (perscroll) perscroll.destroy();
                            perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                        }
                    }
                });
            }, 1000);

            $(document).on('change', '#bot_list_select', function (e) {
                var page_id = $('#bot_list_select').val();
                var return_social_media_by_force = '0';

                $.ajax({
                    context: this,
                    type: 'POST',
                    dataType: 'JSON',
                    url: "<?php echo site_url();?>home/switch_to_page",
                    data: {page_id, return_social_media_by_force},
                    success: function (response) {
                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>subscriber_manager/get_label_dropdown",
                            data: {page_id: page_id},
                            success: function (response) {
                                $("#label_dropdown").html(response);
                                if (table1 != '') table1.draw(false);
                                if (table_label != '') table_label.draw(false);
                                // $("#page_err").text("");
                            }
                        });
                    }
                });

                get_page_details('#bot_list_select');
            });

            if (auto_selected_subscriber != '' && auto_selected_subscriber != '0') {
                $("#search_value").val(auto_selected_subscriber);
                $("#search_subscriber").click();
            }

            $(document).on('click', '#search_subscriber', function (e) {
                e.preventDefault();
                table1.draw(false);
            });

            $(document).on('change', '#label_id', function (e) {
                table1.draw(false);
            });

            $(document).on('change', '#gender', function (e) {
                table1.draw(false);
            });

            $(document).on('change', '#email_phone_birth', function (e) {
                table1.draw(false);
            });


            $(document).on('click', '#assign_group', function (e) {
                e.preventDefault();
                var upto = 500;
                var selected_page = $('#bot_list_select').val(); // database id
                var ids = [];
                $(".datatableCheckboxRow:checked").each(function () {
                    ids.push(parseInt($(this).val()));
                });
                var selected = ids.length;

                if (selected_page == "") {
                    swal.fire('<?php echo $this->lang->line("Warning") ?>', "<?php echo $this->lang->line('To assign labels in bulk you have to search by any page first.');?>", 'warning');
                    return;
                }

                if (ids == "") {
                    swal.fire('<?php echo $this->lang->line("Warning") ?>', youhavenotselected + " " + upto + " " + leadsatatime, 'warning');
                    return;
                }
                if (selected > upto) {
                    swal.fire('<?php echo $this->lang->line("Warning") ?>', youcanselectupto + " " + upto + " " + leadsyouhaveselected + " " + selected + " " + leads, 'warning');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>subscriber_manager/get_label_dropdown_multiple",
                    data: {selected_page: selected_page},
                    success: function (response) {
                        $("#get_labels").html(response);
                    }
                });

                $("#assign_group_modal").modal();
            });

            $(document).on('click', '#assign_sms_email_sequence', function (event) {
                event.preventDefault();
                var upto = 500;
                var selected_page = $('#bot_list_select').val();
                var ids = [];

                $(".datatableCheckboxRow:checked").each(function () {
                    ids.push(parseInt($(this).val()));
                });
                var selected = ids.length;

                if (selected_page == "") {
                    swal.fire('<?php echo $this->lang->line("Warning") ?>', "<?php echo $this->lang->line('To assign sequence in bulk you have to search by any page first.');?>", 'warning');
                    return;
                }

                if (ids == "") {
                    swal.fire('<?php echo $this->lang->line("Warning") ?>', youhavenotselectanysubscribertoassignsequence + " " + upto + " " + leadsatatime, 'warning');
                    return;
                }
                if (selected > upto) {
                    swal.fire('<?php echo $this->lang->line("Warning") ?>', youcanselectupto + " " + upto + " " + leadsyouhaveselected + " " + selected + " " + leads, 'warning');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>subscriber_manager/get_sequence_campaigns",
                    data: {selected_page: selected_page},
                    success: function (response) {
                        $("#sequence_campaigns").html(response);
                    }
                });

                $("#assign_sqeuence_campaign_modal").modal();

            });

            $(document).on('click', '#assign_group_submit', function (e) {
                e.preventDefault();
                swal.fire({
                    title: '<?php echo $this->lang->line("Assign Label"); ?>',
                    text: '<?php echo $this->lang->line("Do you really want to assign selected labels to your selected subscribers? Please be noted that bulk assigning labels will replace subscribers previous labels if any."); ?>',
                    icon: 'warning',
                    confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                    cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                    showCancelButton: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete.isConfirmed) {
                            var ids = [];
                            $(".datatableCheckboxRow:checked").each(function () {
                                ids.push(parseInt($(this).val()));
                            });
                            var selected = ids.length;


                            if (ids == "") {
                                swal.fire('<?php echo $this->lang->line("Warning") ?>', youhavenotselected + " " + upto + " " + leadsatatime, 'warning');
                                return;
                            }

                            var group_id = $("#label_ids").val();
                            var page_id = $('#bot_list_select').val();
                            var count = group_id.length;

                            if (count == 0) {
                                swal.fire('<?php echo $this->lang->line("Error") ?>', youhavenotselectedanyleadgroup, 'error');
                                return;
                            }

                            $("#assign_group_submit").addClass("btn-progress");

                            $.ajax({
                                type: 'POST',
                                url: "<?php echo site_url(); ?>subscriber_manager/bulk_group_assign",
                                data: {ids: ids, group_id: group_id, page_id: page_id},
                                success: function (response) {
                                    $("#assign_group_submit").removeClass("btn-progress");
                                    swal.fire('<?php echo $this->lang->line("Label Assign") ?>', groupshavebeenassignedsuccessfully + " (" + selected + ")", 'success')
                                        .then((value) => {
                                            $("#assign_group_modal").modal('hide');
                                            table1.draw(false);
                                            table_label.draw(false);
                                        });

                                }
                            });
                        }
                    });
            });

            $(document).on('click', '#assign_sequence_submit', function (e) {
                e.preventDefault();

                var ids = [];
                $(".datatableCheckboxRow:checked").each(function () {
                    ids.push(parseInt($(this).val()));
                });
                var selected = ids.length;

                if (ids == "") {
                    swal.fire('<?php echo $this->lang->line("Warning") ?>', youhavenotselectanysubscribertoassignsequence + " " + upto + " " + leadsatatime, 'warning');
                    return;
                }

                var sequence_id = $("#sequence_ids").val();
                var page_id = $('#bot_list_select').val();
                var count = sequence_id.length;

                if (count == 0) {
                    swal.fire('<?php echo $this->lang->line("Error") ?>', youhavenotselectedanysequence, 'error');
                    return;
                }

                $("#assign_sequence_submit").addClass("btn-progress");

                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>subscriber_manager/bulk_sequence_campaign_assign",
                    data: {ids: ids, sequence_id: sequence_id, page_id: page_id},
                    success: function (response) {
                        $("#assign_sequence_submit").removeClass("btn-progress");
                        swal.fire('<?php echo $this->lang->line("Sequence Campaign Assign") ?>', sequencehavebeenassignedsuccessfully + " (" + selected + ")", 'success')
                            .then((value) => {
                                $("#assign_sqeuence_campaign_modal").modal('hide');
                                table1.draw(false);
                            });

                    }
                });

            });

            $(document).on('click', '#bulk_delete_contact', function (e) {
                e.preventDefault();
                var ids = [];
                var page_id = $('#bot_list_select').val();

                $(".datatableCheckboxRow:checked").each(function () {
                    ids.push(parseInt($(this).val()));
                });
                var selected = ids.length;

                if (page_id == "") {
                    swal.fire('<?php echo $this->lang->line("Warning") ?>', "<?php echo $this->lang->line('To delete subscribers in bulk you have to search by any page first.');?>", 'warning');
                    return;
                }
                if (ids == "") {
                    swal.fire('<?php echo $this->lang->line("Warning") ?>', youhavenotselected2, 'warning');
                    return;
                }

                swal.fire({
                    title: '<?php echo $this->lang->line("Delete Subscribers"); ?>',
                    text: '<?php echo $this->lang->line("Do you really want to delete selected subscribers?"); ?>',
                    icon: 'error',
                    confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                    cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                    showCancelButton: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete.isConfirmed) {
                            $.ajax({
                                type: 'POST',
                                url: "<?php echo site_url(); ?>subscriber_manager/delete_bulk_subscriber",
                                data: {ids: ids, page_id: page_id},
                                success: function (response) {
                                    swal.fire('<?php echo $this->lang->line("Delete Subscribers") ?>', contactshavebeendeletedsuccessfully + " (" + selected + ")", 'success')
                                        .then((value) => {
                                            table1.draw(false);
                                        });

                                }
                            });
                        }
                    });
            });


            $(document).on('click', '.subscriber_actions_modal', function (e) {
                e.preventDefault();

                var id = $(this).attr('data-id');
                var subscribe_id = $(this).attr('data-subscribe-id');
                var page_id = $(this).attr('data-page-id');
                $("#search_subscriber_id").val(subscribe_id);

                var social_media = 'ig';
                if (page_id.indexOf('fb') > -1) social_media = 'fb';

                $("#subscriber_actions_modal").modal();
                get_subscriber_action_content(id, subscribe_id, page_id);
                var user_input_flow_exist = "<?php echo $user_input_flow_exist; ?>";
                if (user_input_flow_exist == 'yes') {
                    get_subscriber_flowdata(id, subscribe_id, page_id);
                    get_subscriber_customfields(id, subscribe_id, page_id);
                } else {
                    $("#flowanswers-tab,#customfields-tab").hide();
                }

                if (is_webview_exist) {
                    get_subscriber_formdata(id, subscribe_id, page_id);
                } else $("#formdata-tab").hide();

                $("#default-tab").click();
            });


            function get_subscriber_flowdata(id, subscribe_id, page_id) {
                $(".flowanswers_div").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>');

                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>subscriber_manager/get_subscriber_inputflow_data",
                    data: {id: id, page_id: page_id, subscribe_id: subscribe_id},
                    success: function (response) {
                        $(".flowanswers_div").html(response);
                    }
                });
            }

            function get_subscriber_customfields(id, subscribe_id, page_id) {
                $(".customfields_div").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>');

                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>subscriber_manager/get_subscriber_customfields_data",
                    data: {id: id, page_id: page_id, subscribe_id: subscribe_id},
                    success: function (response) {
                        $(".customfields_div").html(response);
                    }
                });
            }

            function get_subscriber_formdata(id, subscribe_id, page_id) {
                $(".formdata_div").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div>');

                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url(); ?>subscriber_manager/get_subscriber_formdata",
                    data: {id: id, page_id: page_id, subscribe_id: subscribe_id},
                    success: function (response) {
                        $(".formdata_div").html(response);
                    }
                });
            }

            var table2 = '';

            $(document).on('change', '#search_status', function (e) {
                table2.draw();
            });

            $(document).on('change', '#search_date_range_val', function (e) {
                e.preventDefault();
                table2.draw();
            });

            $(document).on('keypress', '#search_value2', function (e) {
                if (e.which == 13) $("#search_action").click();
            });

            $(document).on('click', '#search_action', function (event) {
                event.preventDefault();
                table2.draw();
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var id = $(this).attr('id');
                if (id == 'purchase-tab') setTimeout(function () {
                    get_purchase_data();
                }, 1000);
            });


            function get_purchase_data() {
                var perscroll2;
                if (table2 == '') {
                    table2 = $("#mytable2").DataTable({
                        serverSide: true,
                        processing: true,
                        bFilter: false,
                        order: [[10, "desc"]],
                        pageLength: 10,
                        ajax: {
                            url: base_url + 'subscriber_manager/my_orders_data',
                            type: 'POST',
                            data: function (d) {
                                d.search_subscriber_id = $('#search_subscriber_id').val();
                                d.search_status = $('#search_status').val();
                                d.search_value = $('#search_value2').val();
                                d.search_date_range = $('#search_date_range_val').val();
                            }
                        },
                        language:
                            {
                                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                            },
                        dom: '<"top"f>rt<"bottom"lip><"clear">',
                        columnDefs: [
                            {
                                targets: [1, 3, 6, 7, 11],
                                visible: false
                            },
                            {
                                targets: [5, 7, 8, 9, 10, 11],
                                className: 'text-center'
                            },
                            {
                                targets: [3, 4],
                                className: 'text-right'
                            },
                            {
                                targets: [2, 8, 9],
                                sortable: false
                            },
                            {
                                targets: [5, 6, 7, 8, 9],
                                "render": function (data, type, row) {
                                    data = data.replaceAll('fas fa-user-slash', 'bx bxs-user-x');
                                    data = data.replaceAll('fas fa-comment-slash', 'bx bx-comment-x');
                                    data = data.replaceAll('fas fa-map', 'bx bx-map');
                                    data = data.replaceAll('fas fa-birthday-cake', 'bx bx-cake');
                                    data = data.replaceAll('fas fa-headset', 'bx bx-headphone');
                                    data = data.replaceAll('fas fa-phone', 'bx bx-phone');
                                    data = data.replaceAll('fas fa-robot', 'bx bx-bot');
                                    data = data.replaceAll('fas fa-envelope', 'bx bx-envelope');
                                    data = data.replaceAll('fas fa-code', 'bx bx-code');
                                    data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                                    data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                                    data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
                                    data = data.replaceAll('far fa-copy', 'bx bx-copy');
                                    data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                                    data = data.replaceAll('fas fa-trash', 'bx bx-trash');
                                    data = data.replaceAll('fa fa-eye', 'bx bxs-show');
                                    data = data.replaceAll('fas fa-eye', 'bx bxs-show');
                                    data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                                    data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                                    data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                                    data = data.replaceAll('fas fa-briefcase', 'bx bx-briefcase');
                                    data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
                                    data = data.replaceAll('fas fa-file-export', 'bx bx-export');
                                    data = data.replaceAll('fa fa-comment', 'bx bx-comment');
                                    data = data.replaceAll('fa fa-user', 'bx bx-user');
                                    data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
                                    data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                                    data = data.replaceAll('fas fa-comments', 'bx bx-comment');
                                    data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                                    data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                                    data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                                    data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');
                                    data = data.replaceAll('fas fa-key', 'bx bx-key');
                                    data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                                    data = data.replaceAll('fas fa-male', 'bx bx-male')
                                    data = data.replaceAll('fas fa-female', 'bx bx-female')
                                    data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                                    data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                                    data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                                    data = data.replaceAll('fa fa-send', 'bx bx-send');
                                    data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                                    data = data.replaceAll('fa fa-code', 'bx bx-code');
                                    data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
                                    data = data.replaceAll('fas fa-pause', 'bx bx-pause');
                                    data = data.replaceAll('fa fa-cog', 'bx bx-cog');
                                    data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
                                    data = data.replaceAll('fas fa-comment', 'bx bx-comment');
                                    data = data.replaceAll('swal(', 'swal.fire(');
                                    data = data.replaceAll('rounded-circle', 'rounded-circle');
                                    data = data.replaceAll('fas fa-check-circle', 'bx bx-check-circle');
                                    data = data.replaceAll('fas fa-plug', 'bx bx-plug');
                                    data = data.replaceAll('fas fa-times-circle', 'bx bx-time');
                                    data = data.replaceAll('fas fa-chart-bar', 'bx bx-chart');
                                    data = data.replaceAll('fas fa-cloud-download-alt', 'bx bxs-cloud-download');
                                    data = data.replaceAll('padding-10', 'p-10');
                                    data = data.replaceAll('padding-left-10', 'pl-10');
                                    data = data.replaceAll('h4', 'h5 class="card-title font-medium-1"');
                                    data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                                    data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                                    data = data.replaceAll('fas fa-city', 'bx bxs-city');
                                    data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                                    data = data.replaceAll('fas fa-at', 'bx bx-at');
                                    data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                                    data = data.replaceAll('<div class="dropdown-title"><?php echo $this->lang->line('Options'); ?></div>', '<h6 class="dropdown-header"><?php echo $this->lang->line('Options'); ?></h6>');
                                    data = data.replaceAll('fas fa-ellipsis-v', 'bx bx-dots-vertical-rounded');
                                    data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                                    data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                                    data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                                    data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');
                                    data = data.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                                    data = data.replaceAll('fa fa-image', 'bx bx-image');
                                    data = data.replaceAll('208px', '308px');
                                    data = data.replaceAll("data-toggle='tooltip'", " data-html='true' data-toggle='tooltip'");

                                    return data;
                                }
                            }
                        ],
                        fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                            if (areWeUsingScroll) {
                                if (perscroll2) perscroll2.destroy();
                                perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                            }
                        },
                        scrollX: 'auto',
                        fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                            if (areWeUsingScroll) {
                                if (perscroll2) perscroll2.destroy();
                                perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                            }
                        },
                        "drawCallback": function (settings) {
                            $('table [data-toggle="tooltip"]').tooltip('dispose');
                            $('table [data-toggle="tooltip"]').tooltip(
                                {
                                    placement: 'left',
                                    container: 'body',
                                    html: true,
                                    template: '<div class="tooltip tooltip_pd" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                                }
                            );
                        }
                    });
                } else table2.draw();
            }

            $(document).on('click', '#migrate_list', function (e) {

                e.preventDefault();

                swal.fire({
                    title: '<?php echo $this->lang->line("Migrate Conversations as Bot Subscriber"); ?>',
                    text: '<?php echo $this->lang->line("Do you really want to migrate all of your page converasations as bot subscribers?"); ?>',
                    icon: 'warning',
                    buttons: true,
                    confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                    cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                    showCancelButton: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete.isConfirmed) {
                            var base_url = '<?php echo site_url();?>';
                            $(this).parent().prev().addClass('btn-progress');

                            var user_page_id = $("#migrate_list").attr('button_id');

                            $.ajax({
                                context: this,
                                type: 'POST',
                                url: "<?php echo site_url();?>subscriber_manager/migrate_lead_to_bot",
                                dataType: 'json',
                                data: {},
                                success: function (response) {
                                    $(this).parent().prev().removeClass('btn-progress');
                                    if (response.status == '1') {
                                        swal.fire('<?php echo $this->lang->line("Migration Successful"); ?>', response.message, 'success');
                                    } else {
                                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                    }
                                }
                            });
                        }
                    });
            });

            $('#subscriber_actions_modal').on('hidden.bs.modal', function () {
                table1.draw(false);
            });
            $('#subscriber_actions_modal').on('shown.bs.modal', function () {
                $(document).off('focusin.modal');
            });


            $(document).on('click', '.add_label', function (event) {
                event.preventDefault();
                $("#name_err").text("");
                // $("#page_err").text("");
                $("#group_name").val("");
                // $("#page_id").val("").change();
                $("#add_label").modal();
            });

            // create new label
            $(document).on('click', '#create_label_main', function (event) {
                event.preventDefault();

                $("#name_err").text("");
                // $("#page_err").text("");

                group_name = $("#group_name").val();
                selected_page_id = $('#bot_list_select').val();

                if (group_name == '') {
                    $("#name_err").text("<?php echo $this->lang->line('Name is Required') ?>")
                    return false;
                }
                // if(selected_page_id == '') {
                //     $("#page_err").text("<?php echo $this->lang->line('Page is Required') ?>")
                //     return false;
                // }

                $(this).addClass('btn-progress');
                var that = $(this);

                $.ajax({
                    url: '<?php echo base_url('subscriber_manager/ajax_label_insert'); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {group_name: group_name, selected_page_id: selected_page_id},
                    success: function (response) {
                        $("#result_status").html('');
                        $("#result_status").css({"background": "", "padding": "", "margin": ""});

                        if (response.status == "0") {
                            var errorMessage = JSON.stringify(response, null, 10);
                            swal.fire('<?php echo $this->lang->line("Error"); ?>', errorMessage, "error");
                            // iziToast.error({title: '',message: response.message,position: 'bottomRight'});
                            $("#result_status").css({"background": "#EEE", "margin": "10px"});

                        } else if (response.status == '1') {
                            iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                        }

                        table_label.draw();
                        $(that).removeClass('btn-progress');
                    }
                });

            });

            $(document).on('keyup', '#group_name', function (event) {
                event.preventDefault();
                $("#name_err").text("");
            });

            $(document).on('keyup', '#searching', function (event) {
                table_label.draw();
            });


            // delete label
            $(document).on('click', '.delete_label', function (event) {
                event.preventDefault();

                swal.fire({
                    title: '<?php echo $this->lang->line("Delete Label"); ?>',
                    text: '<?php echo $this->lang->line("Do you want to delete this label?"); ?>',
                    icon: 'warning',
                    buttons: true,
                    confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                    cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                    showCancelButton: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete.isConfirmed) {
                            var table_id = $(this).attr("table_id");
                            var social_media = $(this).attr("social_media");

                            $(this).addClass('btn-danger btn-progress').removeClass('btn-outline-danger');
                            var that = $(this);

                            $.ajax({
                                url: '<?php echo base_url('subscriber_manager/ajax_delete_label'); ?>',
                                type: 'POST',
                                dataType: 'json',
                                data: {table_id: table_id, social_media: social_media},
                                success: function (response) {
                                    if (response.status == 'successfull') {
                                        iziToast.success({
                                            title: '',
                                            message: response.message,
                                            position: 'bottomRight'
                                        });

                                    } else if (response.status == 'failed') {
                                        swal.fire("<?php echo $this->lang->line('Error') ?>", response.message, "error")

                                    } else if (response.status == 'error') {
                                        var errorMessage = JSON.stringify(response, null, 10);
                                        swal.fire('<?php echo $this->lang->line("Error"); ?>', errorMessage, "error");
                                    } else if (response.status == 'wrong') {
                                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, "error");
                                    }

                                    table_label.draw();
                                    $(that).removeClass('btn-danger btn-progress').addClass('btn-outline-danger');
                                }
                            });
                        }
                    });

            });

            $('#add_label').on('hidden.bs.modal', function () {
                $("#name_err").text("");
                // $("#page_err").text("");
                $("#group_name").val("");
                // $("#page_id").val("").change();
                table_label.draw();
            });

            $("document").ready(function () {

                $(".page_list_item").click(function (e) {
                    e.preventDefault();
                    get_page_details(this);
                });

                $(document).on('click', '.import_data', function (e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    $("#start_scanning").attr("data-id", id);
                    $("#import_lead_modal").modal();
                });

                $(document).on('click', '.subscriber_info_modal', function (e) {
                    e.preventDefault();
                    $("#subscriber_info_modal").modal();
                });

                $(document).on('click', '#start_scanning', function (e) {
                    e.preventDefault();
                    var id = $(this).attr('data-id');
                    var scan_limit = $("#scan_limit").val();
                    var folder = $("#folder").val();
                    $("#start_scanning").addClass('btn-progress');
                    $(".auto_sync_lead_page").addClass('disabled');
                    $(".user_details_modal").addClass('disabled');
                    $("#scan_load").attr('class', '');
                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: "<?php echo site_url();?>subscriber_manager/import_lead_action",
                        data: {id: id, scan_limit: scan_limit, folder: folder},
                        dataType: 'JSON',
                        success: function (response) {
                            $("#start_scanning").removeClass('btn-progress');

                            if (response.status == '1') {
                                swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success');
                            } else {
                                swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                            }
                        }
                    });

                });

                $(document).on('click', '.auto_sync_lead_page', function (e) {
                    e.preventDefault();
                    var page_id = $(this).attr('auto_sync_lead_page_id');
                    var operation = $(this).attr('enable_disable');
                    var base_url = '<?php echo site_url();?>';

                    var disabledsuccessfully = '<?php echo $disabledsuccessfully;?>';
                    var enabledsuccessfully = '<?php echo $enabledsuccessfully;?>';

                    $(".import_data").addClass('disabled');
                    $(".auto_sync_lead_page").addClass('disabled');
                    $(".user_details_modal").addClass('disabled');
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo site_url();?>subscriber_manager/enable_disable_auto_sync",
                        data: {page_id: page_id, operation: operation},
                        success: function (response) {
                            if (operation == "0") iziToast.success({
                                title: '',
                                message: disabledsuccessfully,
                                position: 'bottomRight'
                            });
                            else iziToast.success({title: '', message: enabledsuccessfully, position: 'bottomRight'});

                            $(".page_list_item.active").click();
                        }
                    });

                });

                $('.modal').on("hidden.bs.modal", function (e) {
                    if ($('.modal:visible').length) {
                        $('body').addClass('modal-open');
                    }

                });

            });

            $("document").ready(function () {
                $('#import_lead_modal').on('hidden.bs.modal', function () {
                    $(".page_list_item.active").click();
                });
            });

            $("document").ready(function () {
                setTimeout(function () {
                    var session_value = "<?php echo $this->session->userdata('sync_subscribers_get_page_details_page_table_id'); ?>";
                    var elem;
                    // if(session_value=='')  elem = $(".list-group li:first");
                    // else elem = $("li[page_table_id='"+session_value+"']");
                    get_page_details($('#bot_list_select').val());
                }, 500);

            });


        });


    </script>

<?php include(FCPATH . 'application/n_views/messenger_tools/subscriber_actions_common_js.php'); ?>