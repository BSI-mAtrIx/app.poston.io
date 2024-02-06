<?php
include(FCPATH . 'application/n_views/include/upload_js.php');
?>
<script src="<?php echo base_url(); ?>plugins/emoji/dist/emojionearea.js" type="text/javascript"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%',
        });

        var base_url = '<?php echo base_url(); ?>',
            extraHours = (Date.now() + 60000 * 60 * 1),
            minDateTime = new Date(extraHours);

        /* Handles datatime picker */
        $(document).on('click blur keydown mousedown', '.manual-schedule', function (e) {
            $('.datepicker_x').datetimepicker({
                theme: 'light',
                format: 'Y-m-d H:i:s',
                formatDate: 'Y-m-d H:i:s',
                timepicker: true,
                minDate: minDateTime,
                minTime: minDateTime,
            });
        });

        /* Handles starting date */
        $('#postStartDate').datetimepicker({
            theme: 'light',
            format: 'Y-m-d',
            formatDate: 'Y-m-d',
            timepicker: false,
            minDate: minDateTime,
        });

        $('#postStartTime, #postEndTime').datetimepicker({
            format: 'H:i',
            datepicker: false,
        });

        /* Draws datatable from cached data */
        var cachedTableData = localStorage.getItem('xit-pp-prepared-csvdata');
        if (cachedTableData) {

            var jsonCachedTableData;

            try {

                /* Prepares JSON data */
                jsonCachedTableData = JSON.parse(cachedTableData);

                /* Displays button link to clear cache data */
                $('#pp-link-clear-cached-data').removeClass('d-none');

                /* Shows spinner */
                $('#pp-datatable-container .xit-spinner').show();

                /* Generates table rows from cached data */
                var cachedTableRows = generateTableRowWithTableData(jsonCachedTableData);

                /* Draws datatable */
                drawDatatableWithTableData(cachedTableRows);

            } catch (e) {
                throw e;
            }

        } else {
            $('#pp-csv-info').removeClass('d-none');
            $('#pp-upload-container').removeClass('d-none');
        }

        /* Clears cahced table data */
        $(document).on('click', '#pp-link-clear-cached-data', function (e) {
            var cachedTableData = localStorage.getItem('xit-pp-prepared-csvdata');

            if (!cachedTableData) {
                return;
            }

            swal.fire({
                title: '<?php echo $this->lang->line("Warning!") ?>',
                text: '<?php echo $this->lang->line("Are you sure? If you do so, that can not be undone!"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
            }).then((value) => {
                if (value.isDenied || value.isDismissed) {
                    return;
                }
                if (willDelete.isConfirmed) {
                    localStorage.removeItem('xit-pp-prepared-csvdata');
                    window.location.reload();
                }
            });
        });

        /* Truncates strings */
        function truncateString(str, charsLength, endDelimiter = '...') {
            if (str.length < charsLength) {
                return str;
            }

            return str.trim().slice(0, charsLength) + endDelimiter;
        }

        /* Renders table data */
        function generateTableRowWithTableData(data) {
            if (!Array.isArray(data) && 6 !== data[0].length) {
                return;
            }

            var output = '', i = 1, j = 0;

            for (let item of data) {
                let row_number = i++;
                let campaign_Id = j++;

                var truncatedName = item[0] ? truncateString(item[0], 35) : '';
                var link = item[3] ? '<a id="pp-source-link" class="btn btn-link" data-toggle="tooltip" data-original-title="<?php echo $this->lang->line("Source link"); ?>" href="' + item[3] + '" target="_blank"><i class="bx bx-link"></i></a>' : '';

                output += '<tr>';
                output += '<td>' + row_number + '</td>';
                output += '<td>' + truncatedName + '</td>';
                output += '<td>' + item[1] + '</td>';
                output += '<td>' + link + '</td>';
                output += '<td id="pp-datatable-action">\
                        <span id="action-automatic"><?php echo $this->lang->line("Automatic"); ?></span>\
                        <input class="form-control manual-schedule datepicker_x d-none" type="text" name="manualSchedule[]" placeholder="Date and Time" required>\
                        <input id="campaign-ids" type="hidden" name="manualSettingsData[]" value="' + campaign_Id + '">\
                    </td>';
                output += '</tr>';
            }

            return output;
        }

        /* Prepares select options */
        function createSelectOptionsFromArray(data, type, selected = null) {
            if (!Array.isArray(data)) {
                return;
            }

            if (null !== selected && !Array.isArray(selected)) {
                return;
            }

            const media = ['facebook', 'twitter', 'linkedin', 'reddit'];

            if (media.indexOf(type) < 0) {
                return;
            }

            var output = '';

            for (let median of data) {

                switch (type) {
                    case 'facebook':
                        const facebookValue = 'facebook_rx_fb_page_info-' + median.id;
                        output += '<option value="' + facebookValue + '">' + median.page_name + '</option>';
                        break;
                    case 'twitter':
                    case 'linkedin':
                        const twitterLinkedinValue = type + '_users_info-' + median.id;
                        output += '<option value="' + twitterLinkedinValue + '">' + median.name + '</option>';
                        break;
                    case 'reddit':
                        const redditValue = type + '_users_info-' + median.id;
                        output += '<option value="' + redditValue + '">' + median.username + '</option>';
                        break;
                }
            }

            return output;
        }

        /* Prepares select options */
        function createSelectOptionsFromObject(data, selected = null) {
            if (typeof data !== 'object') {
                return;
            }

            if (!Object.keys(data).length > 0) {
                return;
            }

            if (null !== selected && !Array.isArray(selected)) {
                return;
            }

            var output = '';

            for (const [key, value] of Object.entries(data)) {
                let isSelected = (selected && selected.indexOf(key) > -1) ? 'selected' : '';
                output += '<option value="' + key + '" ' + isSelected + '>' + value + '</option>';
            }

            return output;
        }

        /* Renders select field */

        /* data = { data: data, type: type, data.multiple, data.selected } */
        function createSelectBox(data) {
            let selectBox = '';

            switch (data.type) {
                case 'facebook':
                case 'twitter':
                case 'linkedin':
                case 'reddit':
                    const optionsFromArray = createSelectOptionsFromArray(data.data, data.type, data.selected);
                    const isMultipleSocial = data.multiple ? 'multiple' : '';
                    selectBox = '<select id="' + data.type + 'SelectBox" class="select2 form-control" name="' + data.type + 'SelectBox" ' + isMultipleSocial + ' style="width: 100%">\
                        <option value=""></option>' + optionsFromArray + '</select>\
                        <script>$("#' + data.type + 'SelectBox").select2();<\/script>';
                    return selectBox;
                case 'subreddit':
                case 'timezone':
                    const optionsFromObject = createSelectOptionsFromObject(data.data, data.selected);
                    const isMultipleOther = data.multiple ? 'multiple' : '';
                    selectBox = '<select id="' + data.type + 'SelectBox" class="select2 form-control" name="' + data.type + 'SelectBox" ' + isMultipleOther + ' style="width: 100%">\
                        <option value=""></option>' + optionsFromObject + '</select>\
                        <script>$("#' + data.type + 'SelectBox").select2();<\/script>';
                    return selectBox;
            }
        }

        /* Fetches social configurations */
        function getSocialConfig() {
            var link = base_url + 'post_planner/campaign_settings';

            $.get(link).always(function () {
                $('.xit-spinner').show();
            }).done(function (response) {

                let html = '<form id="pp-social-settings-form">';
                html += '<div class="row">';

                if (response.timezones) {
                    const args = {
                        data: response.timezones,
                        type: 'timezone',
                        multiple: false,
                        selected: [response.defaultTimeZone],
                    };
                    const selectBox = createSelectBox(args);

                    html += '<div class="col-md-6">\
                        <div class="form-group">\
                            <label><?php echo $this->lang->line("Posting Timezone"); ?></label>\
                            ' + selectBox + '\
                        </div>\
                    </div>';
                }

                if (response.facebook_accounts) {
                    const args = {
                        data: response.facebook_accounts,
                        type: 'facebook',
                        multiple: true,
                        selected: null,
                    };
                    const selectBox = createSelectBox(args);
                    html += '<div class="col-md-6">\
                        <div class="form-group">\
                            <label><?php echo $this->lang->line("Post to facebook pages"); ?></label>\
                            ' + selectBox + '\
                        </div>\
                    </div>';
                }

                if (response.twitter_accounts) {
                    const args = {
                        data: response.twitter_accounts,
                        type: 'twitter',
                        multiple: true,
                        selected: null,
                    };
                    const selectBox = createSelectBox(args);

                    html += '<div class="col-md-6">\
                        <div class="form-group">\
                            <label><?php echo $this->lang->line("Post to twitter accounts"); ?></label>\
                            ' + selectBox + '\
                        </div>\
                    </div>';
                }

                if (response.linkedin_accounts) {
                    const args = {
                        data: response.linkedin_accounts,
                        type: 'linkedin',
                        multiple: true,
                        selected: null,
                    };
                    const selectBox = createSelectBox(args);

                    html += '<div class="col-md-6">\
                        <div class="form-group">\
                            <label><?php echo $this->lang->line("Post to linkedin accounts"); ?></label>\
                            ' + selectBox + '\
                        </div>\
                    </div>';
                }

                if (response.reddit_accounts) {
                    const args = {
                        data: response.reddit_accounts,
                        type: 'reddit',
                        multiple: true,
                        selected: null,
                    };
                    const selectBox = createSelectBox(args);

                    html += '<div class="col-md-6">\
                        <div class="form-group">\
                            <label><?php echo $this->lang->line("Post to reddit accounts"); ?></label>\
                            ' + selectBox + '\
                        </div>\
                    </div>';
                }

                if (response.subreddits) {
                    const args = {
                        data: response.subreddits,
                        type: 'subreddit',
                        multiple: false,
                        selected: null,
                    };
                    const selectBox = createSelectBox(args);

                    html += '<div class="col-md-6">\
                        <div class="form-group">\
                            <label><?php echo $this->lang->line("Post to subreddit accounts"); ?></label>\
                            ' + selectBox + '\
                        </div>\
                    </div>';
                }

                html += '</div><!-- ends .row -->';
                html += '</form><!-- ends form -->';

                $("#feed_setting_container").html(html).promise().done(function () {
                    $('.xit-spinner').hide();
                    $("#settings_modal").modal();
                });
            }).fail(function (xhr, status, error) {
                console.log('status: ', status);
                console.log('error: ', error);
            });
        }

        /* Draws datatable with table data */
        function drawDatatableWithTableData(tableRows) {
            $('#csv-data-container').html('');
            $('#csv-data-container').html(tableRows).promise().done(function () {
                var perscroll;
                var table = $("#pp-csv-data-table").DataTable({
                    serverSide: false,
                    processing: true,
                    order: [[1, "desc"]],
                    pageLength: 10,
                    language: {
                        url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                    },
                    dom: '<"d-flex justify-content-end align-items-center"f>rt<"d-flex justify-content-between align-items-center"lip><"clear">',
                    columnDefs: [{
                        targets: [],
                        visible: false
                    }, {
                        targets: [0, 2, 3, 4],
                        className: 'text-center'
                    }, {
                        targets: [3, 4],
                        sortable: false
                    }
                    ],
                    /* when initialization is completed then apply scroll plugin */
                    fnInitComplete: function () {
                        // if(areWeUsingScroll) {
                        //     if (perscroll) {
                        //         perscroll.destroy();
                        //         perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                        //     }
                        // }
                    },
                    scrollX: 'auto',
                    /* on paginition page 2,3.. often scroll shown, so reset it and assign it again */
                    fnDrawCallback: function (oSettings) {
                        // if(areWeUsingScroll) {
                        //     if (perscroll) {
                        //         perscroll.destroy();
                        //         perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                        //     }
                        // }

                        // Hides spinner
                        $('#pp-datatable-container .xit-spinner').hide();

                        // Opens up required elements
                        $('#pp-actions-button').removeClass('d-none');
                        $('#pp-datatable-wrapper').removeClass('d-none');

                        var settingsType = $('#settings-type').val();

                        if ('manual' === settingsType) {
                            $("#pp-csv-data-table").find('tr > td > #action-automatic').addClass('d-none');
                            $("#pp-csv-data-table").find('tr > td > .manual-schedule').removeClass('d-none');
                        } else if ('automatic') {
                            $("#pp-csv-data-table").find('tr > td > .manual-schedule').addClass('d-none');
                            $("#pp-csv-data-table").find('tr > td > #action-automatic').removeClass('d-none');
                        }

                    }
                });

                window.ppDataTable = table;

                // Falls back to drawing again if there is any problem for the table display
                table.draw();
            });
        }

        /* Handles elements visibility for manual and automatic buttons */
        $(document).on('click', '#pp-manual-button, #pp-automatic-button', function (e) {
            var settingsType = $(this).data('settings-type'),
                actionButton = $('#pp-datatable-action');

            if ('manual' === settingsType) {
                $('#pp-automatic-button').removeClass('active');
                $(this).addClass('active');

                $('#settings-type').val(settingsType);
                $("#pp-csv-data-table").find('tr > td > #action-automatic').addClass('d-none');
                $("#pp-csv-data-table").find('tr > td > .manual-schedule').removeClass('d-none');
                $('#pp-schedule-settings').addClass('d-none');
                $('#pp-datatable-wrapper').removeClass('d-none');
                $('#pp-social-settings').removeClass('d-none');

            } else if ('automatic' === settingsType) {
                $('#pp-manual-button').removeClass('active');
                $(this).addClass('active');

                $('#settings-type').val(settingsType);
                $('#pp-datatable-wrapper').addClass('d-none');
                $('#pp-schedule-settings').removeClass('d-none');
                $("#pp-csv-data-table").find('tr > td > .manual-schedule').addClass('d-none');
                $("#pp-csv-data-table").find('tr > td > #action-automatic').removeClass('d-none');
                $('#pp-social-settings').removeClass('d-none');
            }
        });

        /* Handles social configuration options */
        $(document).on('click', '#social-settings-button', function (e) {
            var settingsType = $('#settings-type').val()
            settingsForm = document.getElementById('pp-settings-form');

            if (!settingsType) {
                swal.fire({
                    title: '<?php echo $this->lang->line("Warning!") ?>',
                    text: '<?php echo $this->lang->line("Click on Manual or Automatic button to start configuring campaign settings"); ?>',
                    icon: 'warning',
                });

                return;
            }

            var table = window.ppDataTable;
            var settingsFormData = $(settingsForm).serializeArray();
            var allInputData = table.$('input').serializeArray();

            window.ppSettingsType = settingsType;

            if ('manual' === settingsType) {
                var filteredFormData = allInputData.filter(item => ('manualSchedule[]' === item.name)),
                    isFilledInEachField = item => ("" !== item.value);

                if (!filteredFormData.every(isFilledInEachField)) {
                    swal.fire({
                        title: '<?php echo $this->lang->line("Warning!") ?>',
                        text: '<?php echo $this->lang->line("Please fill in all the datetime fields"); ?>',
                        icon: 'warning',
                    });

                    return;
                }

                // Sets the settings type
                $('#settings-type').val(settingsType);

                /* Prepares data */
                window.ppManauSchduleData = allInputData.map(item => item.name === 'manualSchedule[]' ? item.value : '').filter(Boolean);
                window.ppCampaignIds = allInputData.map(item => item.name === 'manualSettingsData[]' ? item.value : '').filter(Boolean);

            } else if ('automatic' === settingsType) {
                var postStartDate = $('#postStartDate').val(),
                    postStartTime = $('#postStartTime').val(),
                    postEndTime = $('#postEndTime').val(),
                    postInterval = $('#postInterval').val(),
                    postDayOff = $('#postDayOff').val();
                recyclePost = $('#recyclePost').val();

                if (!postStartDate || !postInterval) {
                    swal.fire({
                        title: '<?php echo $this->lang->line("Warning!") ?>',
                        text: '<?php echo $this->lang->line("Please fill in required fields"); ?>',
                        icon: 'warning',
                    });

                    return;
                }

                // Sets the settings type
                $('#settings-type').val(settingsType);

                window.ppPostStartDate = postStartDate;
                window.ppPostStartTime = postStartTime;
                window.ppPostEndTime = postEndTime;
                window.ppPostInterval = postInterval;
                window.ppPostDayOff = postDayOff;
                window.recyclePost = recyclePost;

                var date = new Date(postStartDate),
                    day = date.toLocaleString('en-us', {weekday: 'long'});

                if (!postStartDate) {
                    swal.fire({
                        title: '<?php echo $this->lang->line("Warning!") ?>',
                        text: '<?php echo $this->lang->line("Post start date can not be empty"); ?>',
                        icon: 'warning',
                    });

                    return;
                }

                if (parseInt(postInterval, 10) < 0 || parseInt(postInterval, 10) > 259200) {
                    swal.fire({
                        title: '<?php echo $this->lang->line("Warning!") ?>',
                        text: '<?php echo $this->lang->line("Post interval must be greater than 0 and less than or equal to 259200 mins"); ?>',
                        icon: 'warning',
                    });

                    return;
                }

                if (Array.isArray(postDayOff) && (postDayOff.indexOf(day) !== -1)) {
                    swal.fire({
                        title: '<?php echo $this->lang->line("Warning!") ?>',
                        text: '<?php echo $this->lang->line("The start-date is similar to the day(s) that are off"); ?>',
                        icon: 'warning',
                    });

                    return;
                }
            }

            // Opens up modal with social configuration
            getSocialConfig();
        });

        /* Handles CSV file upload and prepares data */
        $(document).on('click', '#upload_this', function (e) {
            var post_type = $(this).data('post-type');

            // Triggers the input file
            $('#postfile').trigger('click');

            $(document).on('change', '#postfile', function (e) {

                if (e.target.files && e.target.files[0]) {

                    // Hides upload container
                    $('#pp-csv-info').hide();
                    $('#pp-upload-container').hide();

                    // Shows spinner
                    $('#pp-datatable-container .xit-spinner').show();

                    // Prepares form data
                    var formData = new FormData();
                    formData.append('post_type', post_type);
                    formData.append('post_file', e.target.files[0]);

                    $.ajax({
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        url: '<?php echo base_url("post_planner/manage_csv_data"); ?>',
                        success: function (res) {
                            if (true === res.status) {
                                var tableRows = generateTableRowWithTableData(res.data);

                                /* Puts table rows into localStorage */
                                if (!localStorage.getItem('xit-pp-prepared-csvdata')) {
                                    localStorage.setItem('xit-pp-prepared-csvdata', JSON.stringify(res.data));
                                }

                                /* Draws datatable */
                                drawDatatableWithTableData(tableRows);

                            } else if (false === res.status) {
                                swal.fire({
                                    title: '<?php echo $this->lang->line("Warning!") ?>',
                                    text: res.message,
                                    icon: 'warning',
                                });

                                setTimeout(function () {
                                    window.location.reload();
                                }, 3000);
                            } else {
                                window.location.reload();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            });
        });

        $(document).on('click', '.campaign_settings', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-id');

            $.ajax({
                type: 'POST',
                url: base_url + 'post_planner/campaign_settings',
                data: {id: id},
                dataType: 'JSON',
                success: function (response) {
                    if (response.status == '0') {
                        $("#settings_modal .modal-footer").hide();
                    } else {
                        $("#settings_modal .modal-footer").show();
                    }

                    $("#feed_setting_container").html(response.html);
                    $("#settings_modal").modal();
                }
            });
        });

        /* Tries saving campaign saving data */
        $(document).on('click', '#save_settings', function (e) {
            // $(this).attr('disabled', true);
            // $(this).addClass('disabled');

            var postTimeZone = $('#timezoneSelectBox').val(),
                facebookSelectBox = $('#facebookSelectBox').val(),
                twitterSelectBox = $('#twitterSelectBox').val(),
                linkedinSelectBox = $('#linkedinSelectBox').val(),
                redditSelectBox = $('#redditSelectBox').val(),
                subredditSelectBox = $('#subredditSelectBox').val(),

                formId = document.getElementById('pp-social-settings-form'),
                formData = new FormData();

            formData.append('settingsType', window.ppSettingsType);

            if ('manual' === window.ppSettingsType) {
                formData.append('campaignIds', window.ppCampaignIds);
                formData.append('manauSchduleData', window.ppManauSchduleData);
            } else {
                formData.append('postStartDate', window.ppPostStartDate);
                formData.append('postInterval', window.ppPostInterval);
                formData.append('postStartTime', window.ppPostStartTime);
                formData.append('postEndTime', window.ppPostEndTime);
                formData.append('postDayOff', window.ppPostDayOff);
                formData.append('recyclePost', window.recyclePost);
            }

            formData.append('postTimeZone', postTimeZone);
            formData.append('facebookSelectBox', facebookSelectBox);
            formData.append('twitterSelectBox', twitterSelectBox);
            formData.append('linkedinSelectBox', linkedinSelectBox);
            formData.append('redditSelectBox', redditSelectBox);
            formData.append('subredditSelectBox', subredditSelectBox);
            formData.append('csvData', localStorage.getItem('xit-pp-prepared-csvdata'));

            $.ajax({
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                url: base_url + 'post_planner/manage_submitted_data',
                success: function (response) {
                    if (true === response.status) {

                        /* Deletes table rows from localStorage */
                        if (localStorage.getItem('xit-pp-prepared-csvdata')) {
                            localStorage.removeItem('xit-pp-prepared-csvdata');
                        }

                        var textCampaigns = (false !== response.data.text)
                            ? response.data.text
                            : 0;

                        var linkCampaigns = (false !== response.data.link)
                            ? response.data.link
                            : 0;

                        var imageCampaigns = (false !== response.data.image)
                            ? response.data.image
                            : 0;

                        var message = '<?php echo $this->lang->line("We have created");?> <a href="' + base_url + 'comboposter/text_post/campaigns">' + textCampaigns + ' <?php echo $this->lang->line("text campaign(s)"); ?></a>, <a href="' + base_url + 'comboposter/image_post/campaigns">' + imageCampaigns + ' <?php echo $this->lang->line("image campaign(s)"); ?></a>, <a href="' + base_url + 'comboposter/link_post/campaigns">' + linkCampaigns + ' <?php echo $this->lang->line("link campaign(s)"); ?></a> <?php echo $this->lang->line("from the CSV upload.");?>';

                        var para = document.createElement("P");
                        para.innerHTML = message;

                        swal.fire({
                            title: '<?php echo $this->lang->line("Success!") ?>',
                            content: para,
                            icon: 'success',
                            closeOnClickOutside: false,
                            confirmButtonText: "<?php echo $this->lang->line('Create'); ?>",
                            cancelButtonText: "<?php echo $this->lang->line('Cancel'); ?>",
                            showCancelButton: true,
                        }).then(function (reload) {
                            if (reload.isConfirmed) {
                                window.location.reload();
                            }
                        });

                    } else if (false === response.status) {
                        swal.fire({
                            title: '<?php echo $this->lang->line("Warning!") ?>',
                            text: response.message,
                            icon: 'warning',
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log(status);
                    console.log(error);
                    swal.fire({
                        title: '<?php echo $this->lang->line("Error!") ?>',
                        text: error,
                        icon: 'error',
                    });
                }
            });
        });
    });

</script>