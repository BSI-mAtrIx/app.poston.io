
<?php

$new_otn_url_builder = base_url("visual_flow_builder/load_builder/{$page_id}/1/{$media_type}");

$drop_menu = '<a href="'.$new_otn_url_builder.'" target="_BLANK" class="float-right btn btn-primary" title="'.$this->lang->line('Use Flow Builder').'"><i class="fab fa-stack-overflow"></i> '.$this->lang->line("New Template").'</a>&nbsp;';

?>

<script>


    var base_url="<?php echo site_url(); ?>";

    var drop_menu = '<?php echo $drop_menu;?>';
    setTimeout(function(){
        $("#mytable_filter").append(drop_menu);
    }, 1000);

    <?php if(!empty($page_info) and $page_id == 0 and $iframe == 0){ ?>
    window.location.href = base_url + 'messenger_bot/rcn_template_manager/' + $('#bot_list_select').val();
    <?php } ?>

    <?php if(!empty($page_info) and $page_id != 0 and $iframe == 0){ ?>
    $('#bot_list_select').val(<?php echo $page_id; ?>);
    <?php } ?>


    $(document).ready(function() {
        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing:true,
            bFilter: true,
            order: [[ 2, "desc" ]],
            pageLength: 10,
            ajax: {
                url: base_url+'messenger_bot/rcn_template_manager_data',
                type: 'POST',
                data: function ( d )
                {
                    d.page_id = $('#page_id').val();
                }
            },
            language:
                {
                    url: "<?php echo base_url('assets/modules/datatables/language/'.$this->language.'.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1,2,3],
                    visible: false
                },
                {
                    targets: '',
                    className: 'text-center'
                },
                {
                    targets: [0,1,2,4,5,8],
                    sortable: false
                },
                {
                    targets: [8],
                    "render": function ( data, type, row ) {
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
                        data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
                        data = data.replaceAll('fas fa-file-export', 'bx bx-export');
                        data = data.replaceAll('fa fa-comment', 'bx bx-comment');
                        data = data.replaceAll('fa fa-users', 'bx bx-user');
                        data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
                        data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                        data = data.replaceAll('fas fa-comments', 'bx bx-comment');
                        data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                        data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                        data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                        data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');
                        data = data.replaceAll('fas fa-key', 'bx bx-key');
                        data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                        data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                        data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                        data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                        data = data.replaceAll('fa fa-send', 'bx bx-send');
                        data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                        data = data.replaceAll('fa fa-code', 'bx bx-code');
                        data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
                        data = data.replaceAll('fas fa-pause', 'bx bx-pause');
                        data = data.replaceAll('fas fa-play', 'bx bx-play');
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
                        data = data.replaceAll('<div class="dropdown-title">Options</div>', '<h6 class="dropdown-header">Options</h6>');
                        data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                        data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                        data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                        data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');
                        data = data.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                        data = data.replaceAll('fa fa-info-circle', 'bx bx-info-circle');
                        data = data.replaceAll('fas fa-id-card', 'bx bxs-id-card');
                        data = data.replaceAll('fas fa-mars', 'bx bx-male-sign');
                        data = data.replaceAll('fas fa-language', 'bx bx-flag');
                        data = data.replaceAll('fas fa-globe', 'bx bx-globe');
                        data = data.replaceAll('far fa-clock', 'bx bx-time');
                        data = data.replaceAll('fas fa-ellipsis-v', 'bx bx-dots-vertical-rounded');
                        data = data.replaceAll('far fa-hand-point-right', 'bx bxs-hand-right');
                        data = data.replaceAll('fas fa-cogs', 'bx bx-cog');
                        data = data.replaceAll('far fa-pause-circle', 'bx bx-pause-circle');
                        data = data.replaceAll('fas fa-retweet', 'bx bxs-share');
                        data = data.replaceAll('fas fa-sync-alt', 'bx bx-sync');
                        data = data.replaceAll('fas fa-sync', 'bx bx-sync');
                        data = data.replaceAll('fas fa-briefcase', 'bx bx-briefcase');
                        data = data.replaceAll('far fa-stop-circle', 'bx bx-stop-circle');
                        data = data.replaceAll('far fa-play-circle', 'bx bx-play-circle');
                        data = data.replaceAll('fa fa-bug', 'bx bx-bug');

                        return data;
                    }
                },
            ],
            fnInitComplete:function(){  // when initialization is completed then apply scroll plugin
                if(areWeUsingScroll)
                {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function( oSettings ) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if(areWeUsingScroll)
                {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            }
        });

        var table2 = '';
        var perscroll2;

        $(document).on('click', '.get_otn_subscribers', function(event) {
            event.preventDefault();
            var get_subscriber_page_id = $(this).attr('page_table_id');
            var otn_postback_table_id = $(this).attr('otn_postback_table_id');
            $("#get_subscribers_page_id").val(get_subscriber_page_id);
            $("#get_otn_postback_table_id").val(otn_postback_table_id);
            $("#otn_subscribers_modal").modal();

            setTimeout(function(){
                if(table2 == '') {

                    table2 = $("#mytable2").DataTable({
                        serverSide: true,
                        processing:true,
                        bFilter: false,
                        order: [[ 7, "desc" ]],
                        pageLength: 10,
                        ajax: {
                            url: base_url+'messenger_bot/rcn_subscribers_data',
                            type: 'POST',
                            data: function ( d )
                            {
                                d.page_table_id = $('#get_subscribers_page_id').val();
                                d.otn_postback_table_id = $('#get_otn_postback_table_id').val();
                                d.postback_id = $('#postback_id').val();
                            }
                        },
                        language:
                            {
                                url: "<?php echo base_url('assets/modules/datatables/language/'.$this->language.'.json'); ?>"
                            },
                        dom: '<"top"f>rt<"bottom"lip><"clear">',
                        columnDefs: [
                            {
                                targets: [0,1],
                                visible: false
                            },
                            {
                                targets: '',
                                className: 'text-center'
                            },
                            {
                                targets: [0,4,6],
                                sortable: false
                            }
                        ],
                        fnInitComplete:function(){ // when initialization is completed then apply scroll plugin
                            if(areWeUsingScroll)
                            {
                                if (perscroll2) perscroll2.destroy();
                                perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                            }
                        },
                        scrollX: 'auto',
                        fnDrawCallback: function( oSettings ) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                            if(areWeUsingScroll)
                            {
                                if (perscroll2) perscroll2.destroy();
                                perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                            }
                        }
                    });

                } else {
                    table2.draw();
                }
            },1000);


        });

        $('#otn_subscribers_modal').on('hidden.bs.modal', function () {
            event.preventDefault();

            $("#postback_id").val('');
            table.draw();
        });




        $(document).on('click','.delete_template',function(e){
            e.preventDefault();

            swal({
                title: '<?php echo $this->lang->line("Delete!"); ?>',
                text: '<?php echo $this->lang->line("If you delete this template, all the token corresponding this template will also be deleted. Do you want to detete this template?"); ?>',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete)
                    {
                        var base_url = '<?php echo site_url();?>';
                        $(this).addClass('btn-progress');
                        var table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type:'POST' ,
                            url:"<?php echo site_url();?>messenger_bot/rcn_ajax_delete_template_info",
                            // dataType: 'json',
                            data:{table_id:table_id},
                            success:function(response){
                                $(this).removeClass('btn-progress');
                                if(response=='success')
                                {
                                    iziToast.success({title: '',message: '<?php echo $this->lang->line("Template and all the corresponding token has been deleted successfully."); ?>',position: 'bottomRight'});
                                    table.draw();
                                }
                                else if(response=='no_match')
                                {
                                    iziToast.error({title: '',message: '<?php echo $this->lang->line("No Template is found for this user with this ID."); ?>',position: 'bottomRight'});
                                }
                                else
                                {
                                    $("#delete_template_modal_body").html(response);
                                    $("#delete_template_modal").modal();
                                }
                            }
                        });
                    }
                });


        });


    });


</script>

