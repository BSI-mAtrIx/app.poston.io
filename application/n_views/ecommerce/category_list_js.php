<script>
    var cropped2 = false;
    var c = 0;
    var croppers2 = [];
    var $cropperModal2 = [];
    var $image2 = [];

    function edit_crop_init() {
        //if (Dropzone.instances.length > 0) Dropzone.instances.forEach(bz => bz.destroy());

        var uploaded_file2 = $('#uploaded-file2');
        Dropzone.autoDiscover = false;


        var myDropzone2 = new Dropzone("#thumb-dropzone2", {
            url: '<?php echo base_url('ecommerce/upload_category_thumb'); ?>',
            maxFilesize: 5,
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
                    $(uploaded_file2).val(data.filename);
                    $("#tmb_preview").hide();
                }
            },
            removedfile: function (file) {
                var filename = $(uploaded_file2).val();
                delete_uploaded_file2(filename);
                $("#tmb_preview").show();
            },
        });

        var cropped2 = false;

        myDropzone2.on('addedfile', function (file) {
            if (!cropped2) {
                myDropzone2.removeFile(file);
                cropper2(file, c);
                c = c + 1;
            } else {
                cropped2 = false;
                var previewURL = URL.createObjectURL(file);
                var dzPreview = $(file.previewElement).find('img');
                dzPreview.attr("src", previewURL);
            }
        });

        function cropper2(file, c) {
            var fileName = file.name;
            var loadedFilePath = getSrcImageFromBlob2(file);

            var modalTemplate =
                '<div class="modal fade" style="z-index:5000" tabindex="-1" role="dialog">' +
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

            $cropperModal2[c] = $(modalTemplate);


            $cropperModal2[c].modal('show').on("shown.bs.modal", function () {
                $image2[c] = $('#img-' + c);
                $image2[c].cropper({
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

                $cropperModal2[c].on('click', '.crop-upload-featuredropzone' + c, function () {
                    // get cropped image data
                    $image2[c].cropper('getCroppedCanvas', {
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
                        $image2[c].cropper('rotate', 90);
                    })
                    .on('click', '.rotate-left', function () {
                        $image2[c].cropper('rotate', -90);
                    })
                    .on('click', '.reset', function () {
                        $image2[c].cropper('reset');
                    })
                    .on('click', '.scale-x', function () {
                        if (!$image2[c].data('horizontal-flip')) {
                            $image2[c].cropper('scale', -1, 1);
                            $image2[c].data('horizontal-flip', true);
                        } else {
                            $image2[c].cropper('scale', 1, 1);
                            $image2[c].data('horizontal-flip', false);
                        }
                    })
                    .on('click', '.scale-y', function () {
                        if (!$image2[c].data('vertical-flip')) {
                            $image2[c].cropper('scale', 1, -1);
                            $image2[c].data('vertical-flip', true);
                        } else {
                            $image2[c].cropper('scale', 1, 1);
                            $image2[c].data('vertical-flip', false);
                        }
                    })
                    .on('click', '.ratio_169', function () {
                        $image2[c].cropper('setAspectRatio', 1.7777777777777777);
                        $image2[c].data('setAspectRatio', 1.7777777777777777);

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_169').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_43', function () {
                        $image2[c].cropper('setAspectRatio', 1.3333333333333333);
                        $image2[c].data('setAspectRatio', 1.3333333333333333);

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_43').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_11', function () {
                        $image2[c].cropper('setAspectRatio', 1);
                        $image2[c].data('setAspectRatio', 1);

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_11').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_23', function () {
                        $image2[c].cropper('setAspectRatio', 0.6666666666666666);
                        $image2[c].data('setAspectRatio', 0.6666666666666666);

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_23').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_free', function () {
                        $image2[c].cropper('setAspectRatio', 'NaN');
                        $image2[c].data('setAspectRatio', 'NaN');

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_free').toggleClass('btn-secondary btn-outline-secondary');
                    })


                // listener for 'Crop and Upload' button in modal
                $(document).on('click', '.crop-upload-featuredropzone' + c, function () {
                    // get cropped image data
                    var blob = $image2[c].cropper('getCroppedCanvas').toDataURL('image/jpeg');
                    // transform it to Blob object
                    var newFile = dataURItoBlob2(blob);
                    // set 'cropped to true' (so that we don't get to that listener again)
                    newFile.cropped = true;
                    // assign original filename
                    newFile.name = fileName;
                    cropped2 = true;
                    // add cropped file to dropzone
                    myDropzone2.addFile(newFile);
                    // upload cropped file with dropzone
                    myDropzone2.processQueue();

                    var height = $(document).height();
                    $(window.parent.document).find('iframe').height(height);
                    $cropperModal2[c].modal('hide');
                });

            }).on('hidden.bs.modal', function () {
                $(this).remove();
                //$image2.cropper('destroy');
            })
        };


        function getSrcImageFromBlob2(blob) {
            var urlCreator = window.URL || window.webkitURL;
            return urlCreator.createObjectURL(blob);
        }

        function blobToFile2(theBlob, fileName) {
            theBlob.lastModifiedDate = new Date();
            theBlob.name = fileName;
            return theBlob;
        }

        function dataURItoBlob2(dataURI) {
            var byteString = atob(dataURI.split(',')[1]);
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], {type: 'image/jpeg'});
        }

        function delete_uploaded_file2(filename) {
            if ('' !== filename) {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    data: {filename},
                    url: '<?php echo base_url('ecommerce/delete_category_thumb'); ?>',
                    success: function (data) {
                        $('#uploaded-file2').val('');
                    }
                });
            }
            empty_form_values2();
        }

        function empty_form_values2() {
            $('#thumb-dropzone2 .dz-preview').remove();
            $('#thumb-dropzone2').removeClass('dz-started dz-max-files-reached');
            Dropzone.forElement('#thumb-dropzone2').removeAllFiles(true);
        }
    }

</script>

<script>
    var base_url = "<?php echo site_url(); ?>";

    $(document).ready(function () {

        $('[data-toggle=\"tooltip\"]').tooltip();

        var drop_menu = '<?php echo $drop_menu;?>';
        setTimeout(function () {
            $("#mytable_filter").append(drop_menu);
        }, 1000);


        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[2, "asc"]],
            pageLength: 10,
            ajax: {
                url: base_url + 'ecommerce/category_list_data',
                type: 'POST'
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1, 2, 7],
                    visible: false
                },
                {
                    targets: [3, 4, 5, 6, 7],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 3, 6],
                    sortable: false
                },
                {
                    targets: [5],
                    "render": function (data, type, row) {
                        data = data.replaceAll('text-success', '');
                        return data;
                    }
                },
                {
                    targets: [6],
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
                        data = data.replaceAll('fa fa-image', 'bx bx-image');
                        data = data.replaceAll('208px', '308px');
                        data = data.replaceAll("data-toggle='tooltip'", " data-html='true' data-toggle='tooltip'");
                        data = data.replaceAll('fa fa-info-circle', 'bx bx-info-circle');
                        data = data.replaceAll('fas fa-id-card', 'bx bxs-id-card');
                        data = data.replaceAll('fas fa-mars', 'bx bx-male-sign');
                        data = data.replaceAll('fas fa-language', 'bx bx-flag');
                        data = data.replaceAll('fas fa-globe', 'bx bx-globe');
                        data = data.replaceAll('far fa-clock', 'bx bx-time');

                        return data;
                    }
                },
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
        var editor = null;
        $(document).on('click', '#add_new_row', function (event) {
            event.preventDefault();
            $('#thumb-dropzone .dz-preview').remove();
            $('#thumb-dropzone').removeClass('dz-started dz-max-files-reached');
            // Clears added file
            Dropzone.forElement('#thumb-dropzone').removeAllFiles(true);
            $("#add_row_form_modal").modal();
        });
        $('textarea').each(function () {
            <?php if($jodit_cg){
            echo "editor = Jodit.make(this, {
                                    disablePlugins: [
                                        'about'
                                    ],
                                    buttons: [
                                        ...Jodit.defaultOptions.buttons,
                                    ],
                                    extraButtons: ext_butt
                });";
        }else{
            echo 'var editor = new Jodit(this);';
        } ?>
        });

        $(document).on('click', '#save_row', function (event) {
            event.preventDefault();

            var store_id = $("#store_id").val();
            var category_name = $("#category_name").val();

            if (store_id == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Store is required"); ?>', 'warning');
                return;
            }

            if (category_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Category name is required"); ?>', 'warning');
                return;
            }

            $(this).addClass('btn-progress')
            var that = $(this);

            var alldatas = new FormData($("#row_add_form")[0]);

            $.ajax({
                url: base_url + 'ecommerce/ajax_create_new_category',
                type: 'POST',
                dataType: 'JSON',
                data: alldatas,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(that).removeClass('btn-progress');

                    if (response.status == "1") {
                        iziToast.success({title: '', message: response.message, position: 'bottomRight'});

                    } else {
                        iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                    }
                    $("#add_row_form_modal").modal('hide');

                }
            })

        });

        $(document).on('click', '.edit_row', function (event) {
            event.preventDefault();
            $("#update_row_form_modal").modal();

            var table_id = $(this).attr("table_id");
            var loading = '<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center" style="font-size:40px"></i></div>';
            $("#update_contact_modal_body").html(loading);

            $.ajax({
                url: base_url + 'ecommerce/ajax_get_category_update_info',
                type: 'POST',
                data: {table_id: table_id},
                success: function (response) {
                    $("#update_row_modal_body").html(response);
                    edit_crop_init();
                    $('#desc' + table_id).each(function () {
                        <?php if($jodit_cg){
                        echo "editor = Jodit.make(this, {
                                    disablePlugins: [
                                        'about'
                                    ],
                                    buttons: [
                                        ...Jodit.defaultOptions.buttons,
                                    ],
                                    extraButtons: ext_butt
                });";
                    }else{
                        echo 'var editor = new Jodit(this);';
                    } ?>
                    });
                }
            })
        });


        $(document).on('click', '#update_row', function (event) {
            event.preventDefault();

            var category_name = $("#category_name2").val();

            if (category_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Category name is required"); ?>', 'warning');
                return;
            }

            $(this).addClass('btn-progress')
            var that = $(this);


            var alldatas = new FormData($("#row_update_form")[0]);

            $.ajax({
                url: base_url + 'ecommerce/ajax_update_category',
                type: 'POST',
                dataType: 'JSON',
                data: alldatas,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(that).removeClass('btn-progress');

                    if (response.status == "1") {
                        iziToast.success({title: '', message: response.message, position: 'bottomRight'});

                    } else {
                        iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                    }
                    $("#update_row_form_modal").modal('hide');

                }
            })

        });

        var Doyouwanttodeletethisrecordfromdatabase = "<?php echo $this->lang->line('Do you want to detete this record?'); ?>";
        $(document).on('click', '.delete_row', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: Doyouwanttodeletethisrecordfromdatabase,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            dataType: 'JSON',
                            url: "<?php echo base_url('ecommerce/delete_category')?>",
                            data: {table_id: table_id},
                            success: function (response) {
                                if (response.status == '1') {
                                    iziToast.success({
                                        title: '',
                                        message: response.message,
                                        position: 'bottomRight',
                                        timeout: 3000
                                    });
                                } else {
                                    iziToast.error({
                                        title: '',
                                        message: response.message,
                                        position: 'bottomRight',
                                        timeout: 3000
                                    });
                                }
                                table.draw(false);
                            }
                        });
                    }
                });
        });


        // $("#add_row_form_modal").on('hidden.bs.modal', function ()
        // {
        //     $("#row_add_form").trigger('reset');
        //     table.draw();
        // });

        $("#add_row_form_modal").on('hidden.bs.modal', function (event) {
            event.preventDefault();
            $("#row_add_form").trigger('reset');
            table.draw();
        });

        $("#update_row_form_modal").on('hidden.bs.modal', function () {
            table.draw(false);
        });
    });
</script>

<script>
    $(document).ready(function () {

        $("#sortable_main_div").sortable();

        $(document).on('click', '#sort_cat', function (e) {
            var serial = [];
            var count = 0;
            $('#sortable_main_div li').each(function (i, obj) {
                serial[count] = $(this).attr('data-id');
                count++;
            });
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {serial},
                url: '<?php echo base_url('ecommerce/sort_category'); ?>',
                success: function (response) {
                    if (response.status == '0')
                        swal.fire("<?php echo $this->lang->line('Error'); ?>", response.message, 'error');
                    else swal.fire("<?php echo $this->lang->line('Success'); ?>", response.message, 'success').then((value) => {
                        location.reload();
                    });
                }
            });
        });

        // Uploads files
        var uploaded_file = $('#uploaded-file');
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#thumb-dropzone", {
            url: '<?php echo base_url('ecommerce/upload_category_thumb'); ?>',
            maxFilesize: 5,
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
                    $(uploaded_file).val(data.filename);
                    $("#tmb_preview").hide();
                }
            },
            removedfile: function (file) {
                var filename = $(uploaded_file).val();
                delete_uploaded_file(filename);
                $("#tmb_preview").show();
            },
        });

        var cropped = false;

        myDropzone.on('addedfile', function (file) {
            if (!cropped) {
                myDropzone.removeFile(file);
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
                '<div class="modal fade" tabindex="-1" role="dialog">' +
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


                '<button type="button" class="btn btn-primary crop-upload' + c + ' mr-1 mb-1"><?php echo $this->lang->line('Crop & upload'); ?></button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';

            $cropperModal2[c] = $(modalTemplate);


            $cropperModal2[c].modal('show').on("shown.bs.modal", function () {
                $image2[c] = $('#img-' + c);
                $image2[c].cropper({
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

                $cropperModal2[c].on('click', '.crop-upload' + c, function () {
                    // get cropped image data
                    $image2[c].cropper('getCroppedCanvas', {
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
                        $image2[c].cropper('rotate', 90);
                    })
                    .on('click', '.rotate-left', function () {
                        $image2[c].cropper('rotate', -90);
                    })
                    .on('click', '.reset', function () {
                        $image2[c].cropper('reset');
                    })
                    .on('click', '.scale-x', function () {
                        if (!$image2[c].data('horizontal-flip')) {
                            $image2[c].cropper('scale', -1, 1);
                            $image2[c].data('horizontal-flip', true);
                        } else {
                            $image2[c].cropper('scale', 1, 1);
                            $image2[c].data('horizontal-flip', false);
                        }
                    })
                    .on('click', '.scale-y', function () {
                        if (!$image2[c].data('vertical-flip')) {
                            $image2[c].cropper('scale', 1, -1);
                            $image2[c].data('vertical-flip', true);
                        } else {
                            $image2[c].cropper('scale', 1, 1);
                            $image2[c].data('vertical-flip', false);
                        }
                    })
                    .on('click', '.ratio_169', function () {
                        $image2[c].cropper('setAspectRatio', 1.7777777777777777);
                        $image2[c].data('setAspectRatio', 1.7777777777777777);

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_169').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_43', function () {
                        $image2[c].cropper('setAspectRatio', 1.3333333333333333);
                        $image2[c].data('setAspectRatio', 1.3333333333333333);

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_43').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_11', function () {
                        $image2[c].cropper('setAspectRatio', 1);
                        $image2[c].data('setAspectRatio', 1);

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_11').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_23', function () {
                        $image2[c].cropper('setAspectRatio', 0.6666666666666666);
                        $image2[c].data('setAspectRatio', 0.6666666666666666);

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_23').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_free', function () {
                        $image2[c].cropper('setAspectRatio', 'NaN');
                        $image2[c].data('setAspectRatio', 'NaN');

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_free').toggleClass('btn-secondary btn-outline-secondary');
                    })


                // listener for 'Crop and Upload' button in modal
                $(document).on('click', '.crop-upload' + c, function () {
                    // get cropped image data
                    var blob = $image2[c].cropper('getCroppedCanvas').toDataURL('image/jpeg');
                    // transform it to Blob object
                    var newFile = dataURItoBlob(blob);
                    // set 'cropped to true' (so that we don't get to that listener again)
                    newFile.cropped = true;
                    // assign original filename
                    newFile.name = fileName;
                    cropped = true;
                    // add cropped file to dropzone
                    myDropzone.addFile(newFile);
                    // upload cropped file with dropzone
                    myDropzone.processQueue();

                    var height = $(document).height();
                    $(window.parent.document).find('iframe').height(height);
                    $cropperModal2[c].modal('hide');
                });

            }).on('hidden.bs.modal', function () {
                $(this).remove();
                //$image2[c].cropper('destroy');
            })
        };


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


        function delete_uploaded_file(filename) {
            if ('' !== filename) {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    data: {filename},
                    url: '<?php echo base_url('ecommerce/delete_category_thumb'); ?>',
                    success: function (data) {
                        $('#uploaded-file').val('');
                    }
                });
            }
            // Empties form values
            empty_form_values();
        }

        // Empties form values
        function empty_form_values() {
            $('#thumb-dropzone .dz-preview').remove();
            $('#thumb-dropzone').removeClass('dz-started dz-max-files-reached');
            // Clears added file
            Dropzone.forElement('#thumb-dropzone').removeAllFiles(true);
        }
    });
</script>

