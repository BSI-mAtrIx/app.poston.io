<?php

if (empty($page_info)) { ?>


<?php } else { ?>


    <?php
    $pleaseputyourwebsitelink = $this->lang->line("Please put your keyword");
    ?>

    <script>

        $("#checkAll").click(function () {
            $('.checksel').not(this).prop('checked', this.checked);


            $.each($('.checksel'), function () {
                if ($(this)[0].checked) {
                    set_keyids($(this));
                } else {
                    unset_keyids($(this));
                }
                $('#list_keywords').html(keywords);
            });


        });

        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
        }

        var keys_id = new Array();
        var keywords = '';

        function set_keyids(val) {
            keys_id[val.attr("id")] = new Array();

            if (val.attr("data-audience") != undefined) {
                keys_id[val.attr("id")]['Keywords'] = val.attr("value");
                keys_id[val.attr("id")]['Audience Size'] = val.attr("data-audience");
                keys_id[val.attr("id")]['Category'] = val.attr("data-cat");
                keys_id[val.attr("id")]['Topic'] = val.attr("data-topic");
                keys_id[val.attr("id")]['Facebook'] = val.attr("data-fb");
                keys_id[val.attr("id")]['Google'] = val.attr("data-gl");
            } else {
                keys_id[val.attr("id")]['Keywords'] = val.attr("value");
                keys_id[val.attr("id")]['Coverage'] = val.attr("data-coverage");
            }
            keywords = keywords.replaceAll(val.attr("value") + ', ', "");
            keywords = keywords + val.attr("value") + ", ";
            return true;
        }

        function unset_keyids(val) {
//                 keys_id.splice(val.attr("id"), 1);
            delete keys_id[val.attr("id")];
            keywords = keywords.replaceAll(val.attr("value") + ', ', "");
            return true;
        }

        var objectToCSVRow = function (dataObject) {
            var dataArray = new Array;
            for (var o in dataObject) {
                var innerValue = dataObject[o] === null ? '' : dataObject[o].toString();
                var result = innerValue.replace(/"/g, '""');
                dataArray.push(result);
            }
            return dataArray.join('; ') + '\r\n';

        }

        var exportToCSV = function (arrayOfObjects) {


            var csvContent = "data:text/csv;charset=utf-8,";

            // headers
            //csvContent += objectToCSVRow(Object.keys(arrayOfObjects[0]));

            for (var item in arrayOfObjects) {
                csvContent += objectToCSVRow(arrayOfObjects[item]);
            }


            var encodedUri = encodeURI(csvContent);

            var a = document.createElement('a');
            a.href = encodedUri;
            a.download = 'selected_records.csv';
            a.textContent = 'download';
            document.body.append(a);
            a.click();
            a.remove();
            //window.URL.revokeObjectURL(url);
        }


        //         $("document").ready(function(){

        var base_url = "<?php echo base_url();?>";
        var get_button_var = "get_interest";


        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });


        var get_button_csv = function (button) {

            var domain_name = $("#domain_name").val();
            var language = $("#language").val();
            var type_int = $("#type_int").val();

            var pleaseputyourwebsitelink = "<?php echo $pleaseputyourwebsitelink; ?>";

            if (domain_name == "") {
                alertify.alert('<?php echo $this->lang->line("Alert");?>', pleaseputyourwebsitelink, function () {
                });
                return;
            }

            $("#preloader").html('<img width="30%" class="center-block text-center" src="<?php echo base_url('assets/pre-loader/loading-animations.gif')?>" alt="Processing...">');
            $(".get_button").addClass('disabled');
            $("#response").attr('class', '').html('');
            $("#wp_plugin").addClass('hidden');
            get_button_var = button;

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>marketing/get_interest_search",
                data: {
                    domain_name: domain_name,
                    language: language,
                    type_int: type_int,
                    get_button: get_button_var
                },
                dataType: 'JSON',
                success: function (response) {
                    $("#preloader").html("");
                    $(".get_button").removeClass('disabled');

                    if (get_button_var == "get_csv" && response.status == '1') {
                        //                         var uri = 'data:application/csv;charset=UTF-8,' + encodeURIComponent(response.js_code);
                        //                         window.open(uri, 'records.csv');
                        //                         get_button_var = "get_interest";

                        var a = document.createElement('a');
                        a.href = 'data:application/csv;charset=UTF-8,' + encodeURIComponent(response.js_code);
                        a.download = 'report_' + domain_name + '.csv';
                        a.textContent = 'download';
                        document.body.append(a);
                        a.click();
                        a.remove();
                        //window.URL.revokeObjectURL(url);
                        return;
                    }
                }
            })

        }

        $("#type_int").change(function () {
            keys_id = null;
            keys_id = new Array();
            keywords = '';
            $('#list_keywords').html(keywords);
        });

        //$(document.body).on('click','.get_button',get_button_data);

        //$('.get_button').click(get_button);


        document.getElementById("domain_name").addEventListener("keydown", function (e) {
            if (!e) {
                var e = window.event;
            }
            //e.preventDefault(); // sometimes useful

            // Enter is pressed
            if (e.keyCode == 13) {
                e.preventDefault();
                get_button_data();
            }
        }, false);


        //         });


    </script>

    <script>

        var get_button_data = function (button) {

            var domain_name = $("#domain_name").val();
            var language = $("#language").val();
            var type_int = $("#type_int").val();

            $('#interest_table').DataTable().clear();
            $('#interest_table').DataTable().destroy();

            var pleaseputyourwebsitelink = "<?php echo $pleaseputyourwebsitelink; ?>";

            if (domain_name == "") {
                alertify.alert('<?php echo $this->lang->line("Alert");?>', pleaseputyourwebsitelink, function () {
                });
                return;
            }

            $("#preloader").html('<img width="30%" class="center-block text-center" src="<?php echo base_url('assets/pre-loader/loading-animations.gif')?>" alt="Processing...">');
            $(".get_button").addClass('disabled');
            $("#response").attr('class', '').html('');
            $("#wp_plugin").addClass('hidden');
            get_button_var = button;

            var table = $("#interest_table").DataTable({
                serverSide: false,
                processing: false,
                bFilter: true,
                order: [[2, "desc"]],
                pageLength: 10000000,
                ajax: {
                    url: '<?php echo site_url();?>marketing/get_interest_search_table',
                    type: 'POST',
                    data: function (d) {
                        d.domain_name = domain_name;
                        d.language = language;
                        d.type_int = type_int;
                        d.get_button = get_button_var;
                    },
                    'dataSrc': function (result) {
                        if (result.data === null) {
                            result.data = [];
                        }
                        if (result.status == "0") {
                            result.data = [];
                            $("#alert_danger").show();
                            $("#alert_success").hide();
                            $("#copy_code").text('').attr('disabled', 'disabled');
                            $("#alert_danger span").html(result.message);
                            $("#response").html(result.message);
                            get_button_var = "get_interest";
                        }
                        if (result.status == "1") {
                            $("#alert_danger").hide();
                            $("#alert_success").show();
                            $("#alert_success span").html(result.message);
                            $("#table_data_show").show();
                        }
                        $('#counterlist').html(result.count);
                        $("#preloader").html("");
                        $("#audience_size").html(result.audience_size);
                        $(".get_button").removeClass('disabled');
                        return result.data;

                    }

                },

                dom: 'frt',
                columns: [
                    {data: 'select'},
                    {data: 'keyword'},
                    {data: 'size'},
                    {data: 'cat'},
                    {data: 'topic'},
                ],
                columnDefs: [
                    {
                        targets: [1, 3, 4],
                        className: 'text-left'
                    },
                    {
                        targets: [2],
                        className: 'text-right'
                    },
                    {
                        targets: [0],
                        className: 'text-center'
                    },
                ],
                fnDrawCallback: function (oSettings) {
                    $('span.tooltipcs').tooltip({
                        delay: {"show": 0, "hide": 100},
                        placement: "right"
                    });

                    $(".checksel").click(function () {
                        if ($(this)[0].checked) {
                            set_keyids($(this));
                        } else {
                            unset_keyids($(this));
                        }
                        $('#list_keywords').html(keywords);
                    });

                    for (var item in keys_id) {
                        $("#" + item).prop('checked', true);
                    }

                }
            })

        }


    </script>


<?php } ?>