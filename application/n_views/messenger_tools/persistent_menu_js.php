<script type="text/javascript">
    var js_array = [<?php echo '"' . implode('","', $postback_id_array) . '"' ?>];
    var text_with_button_counter_level1 = 1; // initialize level 1 menu count var
    var level1 = "<?php echo $level1;?>";
    var level2 = "<?php echo $level2;?>";
    var level3 = "<?php echo $level3;?>";

    for (var temp = 1; temp <= level1; temp++) {
        var variable = 'text_with_button_counter_level2_' + temp;
        var str = variable + ' = 0';
        eval(str); // initialize level 2 menu count var

        for (var temp2 = 1; temp2 <= level2; temp2++) {
            var variable2 = 'text_with_button_counter_level3_' + temp + "_" + temp2;
            var str2 = variable2 + ' = 0';
            eval(str2); // initialize level 3 menu count var
        }
    }

    function reinitialize_variable() {

        for (var temp = 1; temp <= level1; temp++) {
            var variable = 'text_with_button_counter_level2_' + temp;
            var str = variable + ' = 0';
            eval(str); // initialize level 2 menu count var

            for (var temp2 = 1; temp2 <= level2; temp2++) {
                var variable2 = 'text_with_button_counter_level3_' + temp + "_" + temp2;
                var str2 = variable2 + ' = 0';
                eval(str2); // initialize level 3 menu count var
            }
        }

        $('.level1').each(function () {
            var tempId = $(this).attr('id');
            var tempClass = $(this).attr('class');
            var explode = tempId.split('_');
            var i = explode[explode.length - 1];

            $('#' + tempId + " .level2").each(function () {
                var tempId2 = $(this).attr('id');
                var tempClass2 = $(this).attr('class');
                var explode2 = tempId2.split('_');
                var j = explode2[explode2.length - 1];

                var variable2 = 'text_with_button_counter_level2_' + i;
                var found2 = false;

                if ($("#" + tempId2).hasClass("hidden")) found2 = true;
                if (!found2) {
                    str2 = variable2 + '++';
                    eval(str2);
                }

                $('#' + tempId2 + " .level3").each(function () {
                    var tempId3 = $(this).attr('id');
                    var tempClass3 = $(this).attr('class');
                    var explode3 = tempId3.split('_');
                    var k = explode2[explode2.length - 1];

                    var variable3 = 'text_with_button_counter_level3_' + i + "_" + j;
                    var found3 = false;
                    if ($("#" + tempId3).hasClass("hidden")) found3 = true;
                    if (!found3) {
                        str3 = variable3 + '++';
                        eval(str3);
                    }

                });
            });

        });


    }


    function printer() // to print variables in console
    {
        for (var temp = 1; temp <= level1; temp++) {
            var variable = 'text_with_button_counter_level2_' + temp;
            console.log(variable);
            var str = 'console.log(' + variable + ')';
            console.log('\n');
            eval(str); // initialize level 2 menu count var

            for (var temp2 = 1; temp2 <= level2; temp2++) {
                var variable2 = 'text_with_button_counter_level3_' + temp + "_" + temp2;
                console.log(variable2);
                var str2 = 'console.log(' + variable2 + ')';
                console.log('\n');
                eval(str2); // initialize level 2 menu count var
            }
        }
    }

    function validation() {
        for (var i = 1; i <= text_with_button_counter_level1; i++) {
            var button_id = i;
            var text_with_buttons_text = "#text_with_buttons_text_" + button_id;
            var text_with_button_type = "#text_with_button_type_" + button_id;

            var text_with_buttons_text_check = $(text_with_buttons_text).val();
            if (text_with_buttons_text_check == '') {
                showerror("<?php echo $this->lang->line('missing menu title : leve1-1 menu')?>");

                return false;
            }

            if (text_with_buttons_text_check.length > 30) {
                showerror("<?php echo $max_length?>");

                return false;
            }

            var text_with_button_type_check = $(text_with_button_type).val();
            if (text_with_button_type_check == '') {
                showerror("<?php echo $this->lang->line('missing menu type : leve1-1 menu')?>");

                return false;
            } else if (text_with_button_type_check == 'post_back') {
                var text_with_button_post_id = "#text_with_button_post_id_" + button_id;
                var text_with_button_post_id_check = $(text_with_button_post_id).val();
                if (text_with_button_post_id_check == '') {
                    showerror("<?php echo $this->lang->line('missing menu postback ID : leve1-1 menu')?>");

                    return false;
                }
                // if(jQuery.inArray(text_with_button_post_id_check.toUpperCase(), js_array) !== -1){
                //   showerror("<?php echo $this->lang->line('The PostBack ID you have given is allready exist. Please provide different PostBack Id')?>");
                //
                //   return false;
                // }
            } else if (text_with_button_type_check == 'web_url') {
                var text_with_button_web_url = "#text_with_button_web_url_" + button_id;
                var text_with_button_web_url_check = $(text_with_button_web_url).val();
                if (text_with_button_web_url_check == '') {
                    showerror("<?php echo $this->lang->line('Please Provide Your Web Url')?>");

                    return false;
                }
            } else if (text_with_button_type_check == 'nested') // checking level2 menu
            {
                var text_with_button_counter_level2;
                var st = "text_with_button_counter_level2=text_with_button_counter_level2_" + i;
                eval(st);
                if (text_with_button_counter_level2 >= 1) {
                    for (var j = 1; j <= text_with_button_counter_level2; j++) {
                        var text_with_buttons_text2 = "#text_with_buttons_text_" + i + "_" + j;
                        var text_with_button_type2 = "#text_with_button_type_" + i + "_" + j;

                        var text_with_buttons_text_check2 = $(text_with_buttons_text2).val();
                        if (text_with_buttons_text_check2 == '') {
                            showerror("<?php echo $this->lang->line('missing menu title : leve1-2 menu')?>");

                            return false;
                        }

                        if (text_with_buttons_text_check2.length > 30) {
                            showerror("<?php echo $max_length?>");

                            return false;
                        }

                        var text_with_button_type_check2 = $(text_with_button_type2).val();
                        if (text_with_button_type_check2 == '') {
                            showerror("<?php echo $this->lang->line('missing menu type : leve1-2 menu')?>");

                            return false;
                        } else if (text_with_button_type_check2 == 'post_back') {
                            var text_with_button_post_id2 = "#text_with_button_post_id_" + i + "_" + j;
                            var text_with_button_post_id_check2 = $(text_with_button_post_id2).val();
                            if (text_with_button_post_id_check2 == '') {
                                showerror("<?php echo $this->lang->line('missing menu postback ID : leve1-2 menu')?>");

                                return false;
                            }
                            // if(jQuery.inArray(text_with_button_post_id_check2.toUpperCase(), js_array) !== -1){
                            //   showerror("<?php echo $this->lang->line('The PostBack ID you have given is allready exist. Please provide different PostBack Id')?>");
                            //
                            //   return false ;
                            // }
                        } else if (text_with_button_type_check2 == 'web_url') {
                            var text_with_button_web_url2 = "#text_with_button_web_url_" + i + "_" + j;
                            var text_with_button_web_url_check2 = $(text_with_button_web_url2).val();
                            if (text_with_button_web_url_check2 == '') {
                                showerror("<?php echo $this->lang->line('Please Provide Your Web Url')?>");

                                return false;
                            }
                        } else if (text_with_button_type_check2 == 'nested') // checking level 3 menu
                        {
                            var text_with_button_counter_level3;
                            var st = "text_with_button_counter_level3=text_with_button_counter_level3_" + i + "_" + j;
                            eval(st);
                            if (text_with_button_counter_level3 >= 1) {
                                for (var k = 1; k <= text_with_button_counter_level3; k++) {
                                    var text_with_buttons_text3 = "#text_with_buttons_text_" + i + "_" + j + "_" + k;
                                    var text_with_button_type3 = "#text_with_button_type_" + i + "_" + j + "_" + k;

                                    var text_with_buttons_text_check3 = $(text_with_buttons_text3).val();
                                    if (text_with_buttons_text_check3 == '') {
                                        showerror("<?php echo $this->lang->line('missing menu title : leve1-3 menu')?>");

                                        return false;
                                    }

                                    if (text_with_buttons_text_check3.length > 30) {
                                        showerror("<?php echo $max_length?>");

                                        return false;
                                    }

                                    var text_with_button_type_check3 = $(text_with_button_type3).val();
                                    if (text_with_button_type_check3 == '') {
                                        showerror("<?php echo $this->lang->line('missing menu type : leve1-3 menu')?>");

                                        return false;
                                    } else if (text_with_button_type_check3 == 'post_back') {
                                        var text_with_button_post_id3 = "#text_with_button_post_id_" + i + "_" + j + "_" + k;
                                        var text_with_button_post_id_check3 = $(text_with_button_post_id3).val();
                                        if (text_with_button_post_id_check3 == '') {
                                            showerror("<?php echo $this->lang->line('missing menu postback ID : leve1-3 menu')?>");

                                            return false;
                                        }
                                        // if(jQuery.inArray(text_with_button_post_id_check3.toUpperCase(), js_array) !== -1){
                                        //   showerror("<?php echo $this->lang->line('The PostBack ID you have given is allready exist. Please provide different PostBack Id')?>");
                                        //
                                        //   return false ;
                                        // }
                                    } else if (text_with_button_type_check == 'web_url') {
                                        var text_with_button_web_url3 = "#text_with_button_web_url_" + i + "_" + j + "_" + k;
                                        var text_with_button_web_url_check3 = $(text_with_button_web_url3).val();
                                        if (text_with_button_web_url_check3 == '') {
                                            showerror("<?php echo $this->lang->line('Please Provide Your Web Url')?>");

                                            return false;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return true;
    }

    function level2_add(add_button_id) {
        var explode = [];
        explode = add_button_id.split('_');
        var i = explode[explode.length - 1];

        var variable;
        var str = 'variable=text_with_button_counter_level2_' + i;
        eval(str);

        var variable = 'text_with_button_counter_level2_' + i;
        var str = variable + '++';
        eval(str);

        var compare;
        str = 'compare=' + variable;
        eval(str);

        $("#text_with_buttons_row_" + i + " .level2.hidden:first").removeClass('hidden');
        if (compare == level2)
            $("#" + add_button_id).addClass('hidden');
        else $("#" + add_button_id).removeClass('hidden');

        if (compare == 1)
            $("#remove_menu_" + i).addClass('hidden');
        else $("#remove_menu_" + i).removeClass('hidden');
    }

    function level3_add(add_button_id) {
        var explode = [];
        explode = add_button_id.split('_');
        var i = explode[explode.length - 2];
        var j = explode[explode.length - 1];

        var variable = 'text_with_button_counter_level3_' + i + "_" + j;
        var str = variable + '++';
        eval(str);

        var compare;
        str = 'compare=' + variable;
        eval(str);

        $("#text_with_buttons_row_" + i + "_" + j + " .level3.hidden:first").removeClass('hidden');
        if (compare == level3)
            $("#" + add_button_id).addClass('hidden');
        else $("#" + add_button_id).removeClass('hidden');

        if (compare == 1)
            $("#remove_menu_" + i + "_" + j + "_" + j).addClass('hidden');
        else $("#remove_menu_" + i + "_" + j).removeClass('hidden');
    }

    function level2_remove(remove_button_id) {
        var explode = [];
        explode = remove_button_id.split('_');
        var i = explode[explode.length - 1];

        var variable;
        var current_id = $("#text_with_buttons_row_" + i + " .level2:not(.hidden):last").attr("id");

        $("#" + current_id + " input").val(''); // making all input blank  level 2/3
        $("#" + current_id + " select").val('web_url');  // making all dropdown default level 2/3
        $("#" + current_id + " .level3_remove").addClass('hidden'); // hiding level3 remove buttons
        $("#" + current_id + " .level3").addClass('hidden'); // hiding level3 blocks
        $("#" + current_id).addClass('hidden'); // hiding level2 blocks

        reinitialize_variable();
        variable = eval("text_with_button_counter_level2_" + i);

        if (variable == 1)
            $("#" + remove_button_id).addClass('hidden');
        else $("#" + remove_button_id).removeClass('hidden');
    }

    function level3_remove(remove_button_id) {
        var explode = [];
        explode = remove_button_id.split('_');
        var i = explode[explode.length - 2];
        var j = explode[explode.length - 1];

        var variable;
        var current_id = $("#text_with_buttons_row_" + i + "_" + j + " .level3:not(.hidden):last").attr("id");

        $("#" + current_id + " input").val(''); // making all input blank  level 3
        $("#" + current_id + " select").val('web_url');  // making all dropdown default level 3
        $("#" + current_id).addClass('hidden'); // hiding level3 blocks

        reinitialize_variable();
        variable = eval("text_with_button_counter_level3_" + i + "_" + j);

        if (variable == 1)
            $("#" + remove_button_id).addClass('hidden');
        else $("#" + remove_button_id).removeClass('hidden');
    }

    $(document).on('click', '#add_more', function (e) { // add new level 1 menu
        e.preventDefault();
        if (validation()) {
            text_with_button_counter_level1++;
            $("#text_with_buttons_row_" + text_with_button_counter_level1).removeClass('hidden');
            if (text_with_button_counter_level1 == level1)
                $("#add_more").addClass("hidden");

            if (text_with_button_counter_level1 == 1)
                $("#remove_menu").addClass('hidden');
            else $("#remove_menu").removeClass('hidden');

        }
    });

    $(document).on('click', '.level2_add', function (e) { // add new level 2 menu
        e.preventDefault();
        if (validation()) {
            var add_button_id = $(this).attr('id');
            level2_add(add_button_id);
        }
    });


    $(document).on('click', '.level3_add', function (e) { // add new leve3 menu
        e.preventDefault();
        if (validation()) {
            var add_button_id = $(this).attr('id');
            level3_add(add_button_id);
        }
    });

    $(document).on('click', '#remove_menu', function (e) { // remove level 1 menu
        e.preventDefault();
        $("#text_with_buttons_row_" + text_with_button_counter_level1 + " input").val(''); // making all input blank  level 1/2/3
        $("#text_with_buttons_row_" + text_with_button_counter_level1 + " select").val('web_url');  // making all dropdown default level 1/2/3
        $("#text_with_buttons_row_" + text_with_button_counter_level1 + " .level3_remove").addClass('hidden'); // hiding level3 remove buttons
        $("#text_with_buttons_row_" + text_with_button_counter_level1 + " .level2_remove").addClass('hidden'); // hiding level2 remove buttons
        $("#text_with_buttons_row_" + text_with_button_counter_level1 + " .level3").addClass('hidden'); // hiding level3 blocks
        $("#text_with_buttons_row_" + text_with_button_counter_level1 + " .level2").addClass('hidden'); // hiding level2 blocks
        $("#text_with_buttons_row_" + text_with_button_counter_level1).addClass('hidden'); // hiding level1 block

        reinitialize_variable(); // recalculating the count variables
        text_with_button_counter_level1--; // reinitialize_variable does not handle level1 variables

        if (text_with_button_counter_level1 < level1)
            $("#add_more").removeClass("hidden"); // displaying level1 add button

        if (text_with_button_counter_level1 == 1)
            $("#remove_menu").addClass('hidden'); // hiding level1 remove button
        else $("#remove_menu").removeClass('hidden'); // removing level1 remove button
    });

    $(document).on('click', '.level2_remove', function (e) { // remove level 2 menu
        e.preventDefault();
        var remove_button_id = $(this).attr('id');
        level2_remove(remove_button_id);

    });

    $(document).on('click', '.level3_remove', function (e) { // remove leve3 menu
        e.preventDefault();
        var remove_button_id = $(this).attr('id');
        level3_remove(remove_button_id);
    });

    var previous_val = "";
    var now_id = "";

    $(document).on('click', '.text_with_button_type_class_level1', function () {
        previous_val = $(this).val();
        now_id = $(this).attr('id');

    }).on('change', '.text_with_button_type_class_level1', function () {
        var id = $(this).attr('id');

        var button_type = $("#" + id).val();
        var explode = id.split('_');
        var i = explode[explode.length - 1];

        if (previous_val == 'nested') {
            $("#text_with_buttons_row_" + i + " .level3_add").addClass('hidden');
            $("#text_with_buttons_row_" + i + " .level2_add").addClass('hidden');
            $("#text_with_buttons_row_" + i + " .level3").addClass('hidden');
            $("#text_with_buttons_row_" + i + " .level2").addClass('hidden');
            $("#text_with_buttons_row_" + i + " .level2 input").val('');
            $("#text_with_buttons_row_" + i + " .level2 select").val('web_url');
            reinitialize_variable();
        }

        if (button_type == 'post_back') {
            $("#text_with_button_postid_div_" + i).show();
            $("#text_with_button_web_url_div_" + i).hide();
            $("#text_with_button_web_url_div_" + i + " input").val('');
        } else if (button_type == 'web_url') {
            $("#text_with_button_postid_div_" + i).hide();
            $("#text_with_button_web_url_div_" + i).show();
            $("#text_with_button_postid_div_" + i + " input").val('');
        } else {
            $("#text_with_button_postid_div_" + i).hide();
            $("#text_with_button_web_url_div_" + i).hide();
            $("#text_with_button_web_url_div_" + i + " input").val('');
            $("#text_with_button_postid_div_" + i + " input").val('');

            var variable;
            var str = 'variable=text_with_button_counter_level2_' + i;
            eval(str);

            if (variable == 0) {
                var param = "add_more_" + i;
                level2_add(param);
                $("#" + param).removeClass('hidden');
            }
        }

    });

    var previous_val2 = "";
    var now_id2 = "";
    $(document).on('click', '.text_with_button_type_class_level2', function () {
        previous_val2 = $(this).val();
        now_id2 = $(this).attr('id');
    }).on('change', '.text_with_button_type_class_level2', function () {

        var id = now_id2;
        var button_type = $("#" + id).val();
        var explode = id.split('_');
        var i = explode[explode.length - 2];
        var j = explode[explode.length - 1];

        if (previous_val2 == 'nested') {
            $("#text_with_buttons_row_" + i + "_" + j + " .level3_add").addClass('hidden');
            $("#text_with_buttons_row_" + i + "_" + j + " .level3").addClass('hidden');
            $("#text_with_buttons_row_" + i + "_" + j + " .level3 input").val('');
            $("#text_with_buttons_row_" + i + "_" + j + " .level3 select").val('web_url');
            reinitialize_variable();
        }

        if (button_type == 'post_back') {
            $("#text_with_button_postid_div_" + i + "_" + j).show();
            $("#text_with_button_web_url_div_" + i + "_" + j).hide();
            $("#text_with_button_web_url_div_" + i + "_" + j + " input").val('');
        } else if (button_type == 'web_url') {
            $("#text_with_button_postid_div_" + i + "_" + j).hide();
            $("#text_with_button_web_url_div_" + i + "_" + j).show();
            $("#text_with_button_postid_div_" + i + "_" + j + " input").val('');
        } else if (button_type == 'nested') {
            $("#text_with_button_postid_div_" + i + "_" + j).hide();
            $("#text_with_button_web_url_div_" + i + "_" + j).hide();
            $("#text_with_button_web_url_div_" + i + "_" + j + " input").val('');
            $("#text_with_button_postid_div_" + i + "_" + j + " input").val('');

            var variable;
            var str = 'variable=text_with_button_counter_level3_' + i + "_" + j;
            eval(str);

            if (variable == 0) {
                var param = "add_more_" + i + "_" + j;
                level3_add(param);
                $("#" + param).removeClass('hidden');
            }
        }

    });


    var previous_val3 = "";
    var now_id3 = "";
    $(document).on('click', '.text_with_button_type_class_level3', function () {
        previous_val3 = $(this).val();
        now_id3 = $(this).attr('id');
    }).on('change', '.text_with_button_type_class_level3', function () {

        var id = now_id3;
        var button_type = $("#" + id).val();
        var explode = id.split('_');
        var i = explode[explode.length - 3];
        var j = explode[explode.length - 2];
        var k = explode[explode.length - 1];

        if (button_type == 'post_back') {
            $("#text_with_button_postid_div_" + i + "_" + j + "_" + k).show();
            $("#text_with_button_web_url_div_" + i + "_" + j + "_" + k).hide();
            $("#text_with_button_web_url_div_" + i + "_" + j + "_" + k + " input").val('');
        } else if (button_type == 'web_url') {
            $("#text_with_button_postid_div_" + i + "_" + j + "_" + k).hide();
            $("#text_with_button_web_url_div_" + i + "_" + j + "_" + k).show();
            $("#text_with_button_postid_div_" + i + "_" + j + "_" + k + " input").val('');
        } else {
            $("#text_with_button_postid_div_" + i + "_" + j + "_" + k).hide();
            $("#text_with_button_web_url_div_" + i + "_" + j + "_" + k).hide();
            $("#text_with_button_web_url_div_" + i + "_" + j + "_" + k + " input").val('');
            $("#text_with_button_postid_div_" + i + "_" + j + "_" + k + " input").val('');
        }

    });


    $(document).on('click', '#submit', function (e) {
        e.preventDefault();
        var base_url = "<?php echo base_url(); ?>";
        var page_table_id = $("#page_table_id").val();
        if (!validation()) return false;

        $(this).addClass('btn-progress');

        var queryString = new FormData($("#messenger_bot_form")[0]);
        $.ajax({
            type: 'POST',
            url: base_url + "messenger_bot/create_persistent_menu_action",
            data: queryString,
            dataType: 'JSON',
            // async: false,
            cache: false,
            contentType: false,
            processData: false,
            context: this,
            success: function (response) {
                $(this).removeClass('btn-progress');

                if (response.status == '1')
                    window.location.assign(base_url + "messenger_bot/persistent_menu_list/" + page_table_id + "/1");
                else
                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
            }

        });

    });

    // postback dropdown

    $(document).ready(function () {
        var base_url = "<?php echo base_url(); ?>";
        // getting postback list and making iframe
        var page_id = "<?php echo $page_auto_id;?>";
        var iframe_link = "<?php echo base_url('messenger_bot/create_new_template/1/');?>" + page_id;
        $('#add_template_modal').on('shown.bs.modal', function () {
            $(this).find('iframe').attr('src', iframe_link);
        });

        $('#add_template_modal').on('hidden.bs.modal', function (e) {
            var current_id = $("#add_template_modal").attr("current_id");
            var page_id = "<?php echo $page_auto_id;?>";
            if (page_id == "") {
                alertify.alert('<?php echo $this->lang->line("Alert"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", function () {
                });
                return false;
            }
            $.ajax({
                type: 'POST',
                url: base_url + "messenger_bot/get_postback_for_persistent_menu",
                data: {page_id: page_id},
                success: function (response) {
                    $("#" + current_id).html(response);
                }
            });
        });
        refresh_template();
        $("#loader").addClass('hidden');
        // getting postback list and making iframe// getting postback list and making iframe
    });


    $(document).on('click', '.add_template', function (e) {
        e.preventDefault();
        var current_id = $(this).prev().attr("id");
        var page_id = "<?php echo $page_auto_id;?>";
        if (page_id == "") {
            alertify.alert('<?php echo $this->lang->line("Alert"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", function () {
            });
            return false;
        }
        $("#add_template_modal").attr("current_id", current_id);
        $("#add_template_modal").modal();
    });

    $(document).on('click', '.ref_template', function (e) {
        e.preventDefault();
        var base_url = "<?php echo base_url(); ?>";
        var current_val = $(this).prev().prev().val();
        var current_id = $(this).prev().prev().attr("id");
        var page_id = "<?php echo $page_auto_id;?>";
        if (page_id == "") {
            alertify.alert('<?php echo $this->lang->line("Alert"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", function () {
            });
            return false;
        }
        $.ajax({
            type: 'POST',
            url: base_url + "messenger_bot/get_postback_for_persistent_menu",
            data: {page_id: page_id},
            success: function (response) {
                $("#" + current_id).html(response).val(current_val);
            }
        });
    });


    function refresh_template() {
        var base_url = "<?php echo base_url(); ?>";
        var page_id = "<?php echo $page_auto_id;?>";
        if (page_id == "") {
            alertify.alert('<?php echo $this->lang->line("Alert"); ?>', "<?php echo $this->lang->line('Please select a page first')?>", function () {
            });
            return false;
        }
        $.ajax({
            type: 'POST',
            url: base_url + "messenger_bot/get_postback_for_persistent_menu",
            data: {page_id: page_id, order_by: "template_name"},
            success: function (response) {
                $(".push_postback").html(response);
            }
        });
    }

    function showerror(content) {
        swal.fire('<?php echo $this->lang->line("Warning!"); ?>', content, 'warning');
        return;
    }

</script>