<style>
    .dropzone .dz-preview .dz-image img {
        margin: auto; /* center the image inside the thumbnail */
    }

    .dropzone .dz-preview .dz-error-message {
        top: 140px; /* move the tooltip below the "Remove" link */
    }

    .dropzone .dz-preview .dz-error-message:after {
        left: 30px; /* move the tooltip's arrow to the left of the "Remove" link */
        top: -18px;
        border-bottom-width: 18px;
    }

    .dropzone .dz-preview .dz-remove {
        margin-top: 4px;
        font-size: 11px;
        text-transform: uppercase;
    }
</style>
<script>
    $(document).ready(function () {

        $('.singleAttributeName').on('change', function (e) {
            var value = $(this).val();
            if (value == 'x') {
                $(this).parent().next().children('.form-control').val('');
                $(this).parent().next().children('.form-control').attr('readonly', '');
            } else {
                $(this).parent().next().children('.form-control').removeAttr('readonly');
            }
        });

        // Uploads files
        var uploaded_file = $('#uploaded-file');
        Dropzone.autoDiscover = false;


        var myDropzone = new Dropzone("#thumb-dropzone", {
            url: '<?php echo base_url('ecommerce/upload_product_thumb'); ?>',
            maxFilesize: 1,
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
            error: function (file, message, xhr) {
                //$(file.previewElement).remove();
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
                cropperthumb(file);
            } else {
                cropped = false;
                var previewURL = URL.createObjectURL(file);
                var dzPreview = $(file.previewElement).find('img');
                dzPreview.attr("src", previewURL);
            }
        });

        function cropperthumb(file) {
            var c = 0;
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


                '<button type="button" class="btn btn-primary crop-upload mr-1 mb-1"><?php echo $this->lang->line('Crop & upload'); ?></button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';

            var $cropperModal = $(modalTemplate);
            var $image = null;

            $cropperModal.modal('show').on("shown.bs.modal", function () {
                var $image = $('#img-' + c);
                var cropper = $image.cropper({
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

                $cropperModal.on('click', '.crop-upload', function () {
                    // get cropped image data
                    $image.cropper('getCroppedCanvas', {
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
                        $image.cropper('rotate', 90);
                    })
                    .on('click', '.rotate-left', function () {
                        $image.cropper('rotate', -90);
                    })
                    .on('click', '.reset', function () {
                        $image.cropper('reset');
                    })
                    .on('click', '.scale-x', function () {
                        if (!$image.data('horizontal-flip')) {
                            $image.cropper('scale', -1, 1);
                            $image.data('horizontal-flip', true);
                        } else {
                            $image.cropper('scale', 1, 1);
                            $image.data('horizontal-flip', false);
                        }
                    })
                    .on('click', '.scale-y', function () {
                        if (!$image.data('vertical-flip')) {
                            $image.cropper('scale', 1, -1);
                            $image.data('vertical-flip', true);
                        } else {
                            $image.cropper('scale', 1, 1);
                            $image.data('vertical-flip', false);
                        }
                    })
                    .on('click', '.ratio_169', function () {
                        $image.cropper('setAspectRatio', 1.7777777777777777);
                        $image.data('setAspectRatio', 1.7777777777777777);

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_169').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_43', function () {
                        $image.cropper('setAspectRatio', 1.3333333333333333);
                        $image.data('setAspectRatio', 1.3333333333333333);

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_43').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_11', function () {
                        $image.cropper('setAspectRatio', 1);
                        $image.data('setAspectRatio', 1);

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_11').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_23', function () {
                        $image.cropper('setAspectRatio', 0.6666666666666666);
                        $image.data('setAspectRatio', 0.6666666666666666);

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_23').toggleClass('btn-secondary btn-outline-secondary');
                    })
                    .on('click', '.ratio_free', function () {
                        $image.cropper('setAspectRatio', 'NaN');
                        $image.data('setAspectRatio', 'NaN');

                        $('.btn-ratio button').removeClass('btn-secondary');
                        $('.btn-ratio button').addClass('btn-outline-secondary');
                        $('.btn-ratio .ratio_free').toggleClass('btn-secondary btn-outline-secondary');
                    })


                // listener for 'Crop and Upload' button in modal
                $(document).on('click', '.crop-upload', function () {
                    // get cropped image data
                    var blob = $image.cropper('getCroppedCanvas').toDataURL('image/jpeg');
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
                    $cropperModal.modal('hide');
                });

            }).on('hidden.bs.modal', function () {
                $(this).remove();
                //$image.cropper('destroy');
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
                    url: '<?php echo base_url('ecommerce/delete_product_thumb'); ?>',
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


        // Uploads files
        var featured_images_array = [];
        var featured_images_str = "";
        var featured_uploaded_file = $('#featured-uploaded-file');
        Dropzone.autoDiscover = false;

        var featuredropzone = new Dropzone("#feature-dropzone", {
            url: '<?php echo base_url('ecommerce/upload_featured_image'); ?>',
            maxFilesize: 2,
            uploadMultiple: false,
            paramName: "file",
            createImageThumbnails: true,
            acceptedFiles: ".png,.jpg,.jpeg",
            maxFiles:<?php echo $n_config['ecommerce_product_gallery']; ?>,
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
                }
            },
            removedfile: function (file) {
                if (typeof (file.status) === 'error') return false;
                var filename = file.upload.filename;
                delete_uploaded_featured_file(filename);
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
                    url: '<?php echo base_url('ecommerce/delete_featured_image'); ?>',
                    success: function (data) {
                        featured_images_array.splice($.inArray(filename, featured_images_array), 1); // remove file
                        featured_images_str = featured_images_array.join(",");
                        $(featured_uploaded_file).val(featured_images_str);
                    }
                });

            }
        }


        // Uploads Product files
        var upload_product_file = $('#uploaded-product-file');
        Dropzone.autoDiscover = false;
        $("#product-file-dropzone").dropzone({
            url: '<?php echo base_url('ecommerce/upload_product_file'); ?>',
            // maxFilesize:1,
            uploadMultiple: false,
            paramName: "file",
            createImageThumbnails: true,
            acceptedFiles: ".zip",
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

                if (data.filename) {
                    $(upload_product_file).val(data.filename);
                }
            },
            removedfile: function (file) {
                var filename = $(upload_product_file).val();
                delete_uploaded_product_file(filename);
                $("#tmb_preview").show();
            },
        });

        function delete_uploaded_product_file(filename) {
            if ('' !== filename) {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    data: {filename},
                    url: '<?php echo base_url('ecommerce/delete_product_file'); ?>',
                    success: function (data) {
                        $('#uploaded-product-file').val('');
                    }
                });
            }
            // Empties form values
            empty_product_form_values();
        }

        // Empties form values
        function empty_product_form_values() {
            $('#product-file-dropzone .dz-preview').remove();
            $('#product-file-dropzone').removeClass('dz-started dz-max-files-reached');
            // Clears added file
            Dropzone.forElement('#product-file-dropzone').removeAllFiles(true);
        }


    });
</script>