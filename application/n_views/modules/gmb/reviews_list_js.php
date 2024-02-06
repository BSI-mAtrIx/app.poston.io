<script>
    $("document").ready(function () {
        var base_url = '<?php echo base_url(); ?>';

        $("#right_column .makeScroll").mCustomScrollbar({
            autoHideScrollbar: true,
            theme: "rounded-dark"
        });

        $("#review-reply-message").emojioneArea({
            <?php if ($rtl_on) {
                echo "dir: 'rtl',";
            } ?>
            autocomplete: false,
            pickerPosition: "bottom",
            // hideSource: false,
        });

        // Updates review reply
        $(document).on('click', '.update-review-reply', function (e) {
            e.preventDefault();
            var review_id = $(this).data('review-id'),
                review_star = $(this).data('review-star'),
                review_comment = $(this).data('review-comment'),
                reviewer_location_name = $(this).data('location-name'),
                reviewer_display_name = $(this).data('display-name'),
                reviewer_profile_photo = $(this).data('profile-photo');

            $('#review-id').val(review_id);
            $('#review-star').val(review_star);
            $('#review-comment').val(review_comment);
            $('#reviewer-location-name').val(reviewer_location_name);
            $('#reviewer-display-name').val(reviewer_display_name);
            $('#reviewer-profile-photo').val(reviewer_profile_photo);

            // Opens up modal
            $('#update-review-reply-modal').modal();
        });
        $(document).on('submit', '#update-review-reply-form', function (e) {
            e.preventDefault();

            // Starts spinner
            $('#update-review-reply-submit').addClass('btn-progress');

            // Gets form data
            var review_id = $('#review-id').val(),
                reply_type = $('#reply-type').val(),
                review_star = $('#review-star').val(),
                review_comment = $('#review-comment').val(),
                reviewer_location_name = $('#reviewer-location-name').val(),
                reviewer_display_name = $('#reviewer-display-name').val(),
                reviewer_profile_photo = $('#reviewer-profile-photo').val(),
                review_reply_message = $('#review-reply-message').val();

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {
                    review_id,
                    reply_type,
                    review_star,
                    review_comment,
                    reviewer_location_name,
                    reviewer_display_name,
                    reviewer_profile_photo,
                    review_reply_message
                },
                url: '<?php echo base_url('gmb/reply_to_review'); ?>',
                success: function (response) {
                    $('#update-review-reply-submit').removeClass('btn-progress');
                    if (false === response.status) {
                        if (response.message) {
                            swal.fire({
                                title: '<?php echo $this->lang->line("Error!"); ?>',
                                text: response.message,
                                icon: 'error'
                            });
                            return;
                        }

                        var error_content = '';
                        if (response.errors) {
                            for (var error_item of Object.values(response.errors)) {
                                error_content += '<span class="d-block">' + error_item + '</span>';
                            }

                            var span = document.createElement("span");
                            span.innerHTML = error_content;
                            swal.fire({title: '<?php echo $this->lang->line("Error!"); ?>', html: span, icon: 'error'});
                        }
                    } else if (true === response.status) {
                        $('#review-reply-message').val('');
                        $('#update-review-reply-modal').modal('hide');

                        if (response.message) {
                            swal.fire({
                                title: '<?php echo $this->lang->line("Success!"); ?>',
                                text: response.message,
                                icon: "success",
                                button: '<?php echo $this->lang->line('Ok'); ?>',
                            }).then(() => {
                                var waiting_div_content = '<div class="text-center waiting"><i class="bx bx-spin bx-loader blue text-center"></i></div>';
                                $("#main_review_content").html(waiting_div_content)

                                setTimeout(function () {
                                    window.location.replace(base_url + 'gmb/review_list');
                                }, 12000);
                            });
                        }
                    }
                },
                error: function (xhr, xhrStatus, xhrError) {
                    $('#update-review-reply-submit').removeClass('btn-progress');
                    if ('string' === typeof xhrError) {
                        swal.fire({
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                            text: xhrError,
                            icon: 'error'
                        });
                    }
                }
            });
        });

        // Deletes reviews
        $(document).on('click', '.delete-review-reply', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: "<?php echo $this->lang->line('Do you really want to delete the review reply from google and database?'); ?>",
                icon: 'warning',
                buttons: true,
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {

                    var review_id = $(this).data('review-id');

                    $.ajax({
                        context: this,
                        type: 'POST',
                        dataType: 'JSON',
                        data: {review_id},
                        url: '<?php echo base_url('gmb/delete_reply_to_review'); ?>',
                        success: function (response) {
                            if (false === response.status) {
                                swal.fire({
                                    title: '<?php echo $this->lang->line("Error!"); ?>',
                                    text: response.message,
                                    icon: "error",
                                })
                            } else if (true === response.status) {
                                swal.fire({
                                    title: '<?php echo $this->lang->line("Success!"); ?>',
                                    text: response.message,
                                    icon: "success",
                                    button: '<?php echo $this->lang->line('Ok'); ?>',
                                }).then(() => {
                                    var waiting_div_content = '<div class="text-center waiting"><i class="bx bx-spin bx-loader blue text-center"></i></div>';
                                    $("#main_review_content").html(waiting_div_content)

                                    setTimeout(function () {
                                        window.location.replace(base_url + 'gmb/review_list');
                                    }, 15000);
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>