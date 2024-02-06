<?php
$pleaseputyourwebsitelink = $this->lang->line("Please put your code");
?>

<script>

    $("document").ready(function () {

        var base_url = "<?php echo base_url();?>";


        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });


        function get_button() {

            var domain_name = $("#domain_name").val();
            var language = $("#language").val();
            var type_int = $("#type_int").val();
            var pleaseputyourwebsitelink = "<?php echo $pleaseputyourwebsitelink; ?>";

            if (domain_name == "") {
                swal.fire({
                    icon: 'error',
                    text: pleaseputyourwebsitelink,
                    title: '<?php echo $this->lang->line('Error!'); ?>'
                });
                return;
            }


            $("#loading").removeClass('hidden');
            $("#get_button").addClass('disabled');
            $("#response").attr('class', '').html('');
            $("#wp_plugin").addClass('hidden');

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>extra/update_code",
                data: {domain_name: domain_name},
                dataType: 'JSON',
                success: function (response) {
                    $("#loading").addClass('hidden');
                    $("#get_button").removeClass('disabled');

                    if (response.status == '1') {
                        $("#response").attr('class', 'alert alert-success text-center');
                        $("#copy_code").removeAttr('disabled').html(response.js_code);
                    } else {
                        $("#response").attr('class', 'alert alert-danger text-center');
                        $("#copy_code").text('').attr('disabled', 'disabled');
                    }

                    $("#response").html(response.message);

                }
            });


        }

        $(document.body).on('click', '#get_button', get_button);


    });


</script>
