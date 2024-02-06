<script>
    $("document").ready(function () {
        'use strict';

        var base_url = '<?php echo base_url(); ?>';

        $("#right_column .makeScroll").mCustomScrollbar({
            autoHideScrollbar: true,
            theme: "rounded-dark"
        });

        $('#post-analytics-modal').on('hidden.bs.modal', function (e) {
            $('#post-insights-container').html('');
            $('#post-insights-container').html('<canvas id="local_post_views_search" height="200"></canvas>');
        });

        $(document).on('click', '.post_analytics', function (e) {
            e.preventDefault();

            // Grabs post name
            var post_name = $(this).data('post-name');

            // Starts spinner
            $('.xit-spinner').show();

            // Displays modal
            $('#post-analytics-modal').modal();

            $.ajax({
                'type': 'POST',
                dataType: 'JSON',
                data: {post_name},
                url: base_url + 'gmb/post_insights',
                success: function (response) {
                    // Hides spinner
                    $('.xit-spinner').hide();

                    if (true === response.status) {
                        if ('object' === typeof JSON.parse(response.data)) {
                            var local_post_views_search_obj = JSON.parse(response.data);
                            var local_post_views_search_ctx = document.getElementById("local_post_views_search").getContext('2d');

                            new Chart(local_post_views_search_ctx, {
                                type: 'line',
                                data: {
                                    labels: local_post_views_search_obj.date,
                                    datasets: [{
                                        label: '<?php echo $this->lang->line('Local post viewed'); ?>',
                                        data: local_post_views_search_obj.value,
                                        backgroundColor: 'rgba(103, 119, 239, 0.3)',
                                        borderColor: '#6777EF',
                                        borderWidth: 1,
                                        pointBackgroundColor: 'transparent',
                                        pointRadius: 0,
                                        fill: 'origin'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    title: {
                                        display: true,
                                        text: '<?php echo $this->lang->line('Local post views search'); ?>',
                                    },
                                    legend: {
                                        display: false
                                    },
                                    scales: {
                                        yAxes: [{
                                            gridLines: {
                                                display: true,
                                                color: 'rgba(0, 0, 0, 0.1)',
                                            },
                                        }],
                                        xAxes: [{
                                            gridLines: {
                                                display: true,
                                                color: 'rgba(0, 0, 0, 0.1)',
                                            },
                                            type: 'time',
                                            time: {
                                                unit: 'day'
                                            }
                                        }]
                                    },
                                }
                            });
                        }
                    }

                    if (false === response.status) {
                        swal.fire({
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                            text: response.message,
                            icon: 'error',
                            buttons: '<?php echo $this->lang->line('Ok'); ?>'
                        });
                    }
                },
                error: function (xhr, xhrStatus, xhrError) {
                    // Hides spinner
                    $('.xit-spinner').hide();

                    if ('string' === typeof xhrError) {
                        swal.fire({
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                            text: xhrError,
                            icon: 'error',
                            buttons: '<?php echo $this->lang->line('Ok'); ?>'
                        });
                    }
                }
            });
        });
    });
</script>