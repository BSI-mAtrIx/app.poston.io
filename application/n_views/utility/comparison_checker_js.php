<script>
    var base_url = "<?php echo site_url(); ?>";
    $("document").ready(function () {


        $(document).on('click', '.action_button', function (event) {
            event.preventDefault();

            var url1 = $("#domain_name1").val();
            var url2 = $("#domain_name2").val();
            $("#custom_spinner").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center"></i></div><br/>');
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>search_tools/comparison_action",
                data: {url1: url1, url2: url2},
                dataType: "json",
                success: function (response) {

                    if (response.empty == 'empty' && response.empty1 == 'empty1') {
                        swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please Enter URL '); ?>", 'error');
                        $("#custom_spinner").html("");
                        return false;
                    }
                    if (response.status == '0') {
                        swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('limit has been exceeded. you can no longer use this feature. '); ?>", 'error');
                    }
                    $("#custom_spinner").html("");

                    response.output1 = response.output1.replaceAll('card-stats-title', 'card-title pl-1 pr-1 pt-1');
                    response.output1 = response.output1.replaceAll('card-stats-items"', 'card-stats-items d-flex"');
                    response.output1 = response.output1.replaceAll('card-stats-item"', 'card-stats-item col-md-4 text-center"');
                    response.output1 = response.output1.replaceAll('card-stats-item-count', 'font-medium-2');
                    response.output1 = response.output1.replaceAll('style="font-size:15px;"', 'class="font-medium-2"');

                    response.output2 = response.output2.replaceAll('card-stats-title', 'card-title pl-1 pr-1 pt-1');
                    response.output2 = response.output2.replaceAll('card-stats-items"', 'card-stats-items d-flex"');
                    response.output2 = response.output2.replaceAll('card-stats-item"', 'card-stats-item col-md-4 text-center"');
                    response.output2 = response.output2.replaceAll('card-stats-item-count', 'font-medium-2');
                    response.output2 = response.output2.replaceAll('style="font-size:15px;"', 'class="font-medium-2"');


                    $(".one").html(response.output1);
                    $(".two").html(response.output2);
                    if (response.empty1 == 'empty1')
                        $('.two').html("");
                    if (response.empty == 'empty')
                        $(".one").html("");


                }
            });


        });


    });
</script>