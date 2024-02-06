<script>

    //page_post_stories_talking_about_this

    var page_content_activity_unique_data = document.getElementById("page_post_stories_talking_about_this").getContext('2d');

    var page_content_activity_data_label = <?php echo json_encode($page_content_activity_data_label); ?>;
    var page_content_activity_data_values = <?php echo json_encode($page_content_activity_data_values); ?>;
    var page_content_activity_by_action_type_fan_values = <?php echo json_encode($page_content_activity_by_action_type_fan_value); ?>;
    var page_content_activity_by_action_type_other_values = <?php echo json_encode($page_content_activity_by_action_type_other_value); ?>;
    var page_content_activity_by_action_type_page_post_values = <?php echo json_encode($page_content_activity_by_action_type_page_post_value); ?>;
    var page_messages_new_conversations_unique_chart = new Chart(page_content_activity_unique_data, {
        type: 'line',
        data: {
            labels: page_content_activity_data_label,
            datasets: [{
                label: '<?php echo $this->lang->line("Page Content Activity"); ?>',
                data: page_content_activity_data_values,
                borderWidth: 3,
                borderColor: '#36a2eb',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#36a2eb',
                pointRadius: 2
            },
                {
                    label: '<?php echo $this->lang->line("Page Content Activity Type Unique Fan"); ?>',
                    data: page_content_activity_by_action_type_fan_values,
                    borderWidth: 3,
                    borderColor: '#4bc0c0',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4bc0c0',
                    pointRadius: 2
                }, {
                    label: '<?php echo $this->lang->line("Page Content Activity Type Unique Other"); ?>',
                    data: page_content_activity_by_action_type_other_values,
                    borderWidth: 3,
                    borderColor: '#ff6384',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#ff6384',
                    pointRadius: 2
                }, {
                    label: '<?php echo $this->lang->line("Page Content Activity Type Unique Page Post"); ?>',
                    data: page_content_activity_by_action_type_page_post_values,
                    borderWidth: 3,
                    borderColor: '#6777ef',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6777ef',
                    pointRadius: 2

                }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: <?php echo $page_content_activity_unique_steps; ?>
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    },
                    type: 'time',
                    time: {

                        displayFormats: {
                            quarter: 'MMM YYYY'
                        }
                    },
                }],

            },
        }
    });


    // Page Impressions Latest Country Unique

    var page_impressions_latest_country_config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: <?php echo json_encode(array_values(isset($page_impressions_by_country_unique_total['value']) ? $page_impressions_by_country_unique_total['value'] : array())); ?>,
                backgroundColor: [
                    '#ff5e57',
                    '#ff6384',
                    '#6777ef',
                    '#ffa426',
                    '#c32849',
                    '#fe8886',
                    '#63ed7a',
                    '#655dd0',
                    '#273c75',
                    '#fd79a8'
                ],

            }],
            labels: <?php echo json_encode(array_keys(isset($page_impressions_by_country_unique_total['value']) ? $page_impressions_by_country_unique_total['value'] : array())); ?>
        },
        options: {
            responsive: true,
            legend: {
                display: false,
            },

            animation: {
                animateScale: true,
                animateRotate: true
            },
            rotation: 1 * Math.PI,
            circumference: 1 * Math.PI

        }
    };


    var page_impressions_latest_country_ctx = document.getElementById('page_impressions_latest_country').getContext('2d');
    var page_impressions_latest_country_my_chart = new Chart(page_impressions_latest_country_ctx, page_impressions_latest_country_config);

    //Page Impressions
    var page_impressions = document.getElementById("page_impressions").getContext('2d');
    var page_impressions_chart_data = new Chart(page_impressions, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($page_impressions_data_label1); ?>,
            datasets: [{
                label: '<?php echo $this->lang->line("Page Impressions"); ?>',
                data: <?php echo json_encode($page_impressions_values); ?>,
                borderWidth: 3,
                borderColor: '#36a2eb',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#36a2eb',
                pointRadius: 2
            },
                {
                    label: '<?php echo $this->lang->line("Page Impressions Unique"); ?>',
                    data: <?php echo json_encode($page_impressions_unique_values); ?>,
                    borderWidth: 3,
                    borderColor: '#4bc0c0',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4bc0c0',
                    pointRadius: 2
                }, {
                    label: '<?php echo $this->lang->line("Page Impressions Viral"); ?>',
                    data: <?php echo json_encode($page_impressions_viral_values); ?>,
                    borderWidth: 3,
                    borderColor: '#ff6384',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#ff6384',
                    pointRadius: 2
                },
                {
                    label: '<?php echo $this->lang->line("Page Impressions Viral Unique"); ?>',
                    data: <?php echo json_encode($page_impressions_viral_unique_values) ?>,
                    borderWidth: 3,
                    borderColor: '#6777ef',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6777ef',
                    pointRadius: 2

                },
                {
                    label: '<?php echo $this->lang->line("Page Impressions Non Viral"); ?>',
                    data: <?php echo json_encode($page_impressions_nonviral_values) ?>,
                    borderWidth: 3,
                    borderColor: '#a55eea',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#a55eea',
                    pointRadius: 2

                },
                {
                    label: '<?php echo $this->lang->line("Page Impressions Non Viral Unique"); ?>',
                    data: <?php echo json_encode($page_impressions_nonviral_unique_values) ?>,
                    borderWidth: 3,
                    borderColor: '#63ed7a',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#63ed7a',
                    pointRadius: 2

                },

            ]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: <?php echo $page_impressions_steps2; ?>
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    },
                    type: 'time',
                    time: {

                        displayFormats: {
                            quarter: 'MMM YYYY'
                        }
                    },
                }]
            },

        }
    });
    //Page Impressions Paid vs Unpaid
    var ctx_impressesion_p_un = document.getElementById("page_impressions_paid_vs_unpaid").getContext('2d');
    var page_impressions_data_label = <?php echo json_encode($page_impressions_data_label); ?>;
    var page_impressions_organic = <?php echo json_encode($page_impressions_organic); ?>;
    var page_impressions_organic_unique = <?php echo json_encode($page_impressions_organic_unique); ?>;
    var page_impressions_paid_data_value = <?php echo json_encode($page_impressions_paid_data_value); ?>;
    var page_impressions_paid_unique_data_value = <?php echo json_encode($page_impressions_paid_unique_data_value); ?>;

    var page_ImpressionPaid_vs_unpaidChart = new Chart(ctx_impressesion_p_un, {
        type: 'line',
        data: {
            labels: page_impressions_data_label,
            datasets: [{
                label: '<?php echo $this->lang->line("Page Impressions Unpaid"); ?>',
                data: page_impressions_organic,
                borderWidth: 2,
                backgroundColor: 'rgba(63,82,227,.8)',
                borderWidth: 0,
                borderColor: 'transparent',
                pointBorderWidth: 0,
                pointRadius: 3.5,
                pointBackgroundColor: 'transparent',
                pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
            },
                {
                    label: '<?php echo $this->lang->line("Page Impressions Unpaid Unique") ?>',
                    data: page_impressions_organic_unique,
                    borderWidth: 2,
                    backgroundColor: 'rgb(78, 89, 167)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgb(78, 89, 167)',
                },
                {
                    label: '<?php echo $this->lang->line("Page Impressions Paid") ?>',
                    data: page_impressions_paid_data_value,
                    borderWidth: 2,
                    backgroundColor: 'rgb(254, 136, 134)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgb(254, 136, 134)',
                },
                {
                    label: '<?php echo $this->lang->line("Page Impressions Paid Unique") ?>',
                    data: page_impressions_paid_unique_data_value,
                    borderWidth: 2,
                    backgroundColor: 'rgb(93, 210, 118)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgb(93, 210, 118)',
                }
            ]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },

                    ticks: {
                        beginAtZero: true,
                        stepSize: <?php echo $page_impressions_steps; ?>,
                        callback: function (value, index, values) {
                            return value;
                        }
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    },
                    type: 'time',
                    time: {

                        displayFormats: {
                            quarter: 'MMM YYYY'
                        }
                    },

                }]
            },
        }
    });


    //Page Engagement
    var page_engagement_canvas_id = document.getElementById("page_engagements").getContext('2d');
    var page_engaged_users_data_label = <?php echo json_encode($page_engaged_users_data_label); ?>;
    var page_enagagement_data = {
        labels: page_engaged_users_data_label,
        datasets: [{
            backgroundColor: '#36a2eb',
            borderColor: 'transparent',
            data: <?php echo json_encode($page_engaged_users_data_values); ?>,
            hidden: false,
            label: '<?php echo $this->lang->line("Page Engaged Users"); ?>'
        },
            {
                backgroundColor: '#4bc0c0',
                borderColor: 'transparent',
                data: <?php echo json_encode($page_post_engagements_data_values); ?>,
                label: '<?php echo $this->lang->line("Page Post Engagement"); ?>',
                fill: '-1'
            },
            {
                backgroundColor: '#ff6384',
                borderColor: 'transparent',
                data: <?php echo json_encode($page_consumptions_data_values); ?>,
                label: '<?php echo $this->lang->line("Page Consumptions") ?>',
                fill: 1
            },
            {
                backgroundColor: '#6777ef',
                borderColor: 'transparent',
                data: <?php echo json_encode($page_consumptions_unique_data_values); ?>,
                label: '<?php echo $this->lang->line("Page Consumptions Unique"); ?>',
                fill: '-1'
            },
            {
                backgroundColor: '#ffa426',
                borderColor: 'transparent',
                data: <?php echo json_encode($page_places_checkin_total_data_values) ?>,
                label: '<?php echo $this->lang->line("Page Places Checkin Total"); ?>',
                fill: '-1'
            },
            {
                backgroundColor: '#fe8886',
                borderColor: 'transparent',
                data: <?php echo json_encode($page_negative_feedback_data_values); ?>,
                label: '<?php echo $this->lang->line("Page Negative Feedback"); ?>',
                fill: '+2'
            },
            {
                backgroundColor: '#8BC34A',
                borderColor: 'transparent',
                data: <?php echo json_encode($page_positive_feedback_by_type_total); ?>,
                label: '<?php echo $this->lang->line("Page Positive Feedback"); ?>',
                fill: 1
            },
            {
                backgroundColor: '#e25f5d',
                borderColor: 'transparent',
                data: <?php echo json_encode($page_fans_online_per_day_data_values); ?>,
                label: '<?php echo $this->lang->line("Page Fans Online Per Day"); ?>',
                fill: 1
            }


        ]
    };

    var page_engagement_options = {
        legend: {
            display: false
        },
        animation: {
            animateScale: true,
            animateRotate: true
        },
        maintainAspectRatio: false,
        elements: {
            line: {
                tension: 0.4
            }
        },
        scales: {
            yAxes: [{
                stacked: true,
                gridLines: {
                    display: false,
                    drawBorder: false,
                }

            }],
            xAxes: [{
                gridLines: {
                    color: '#fbfbfb',
                    lineWidth: 2
                },
                type: 'time',
                time: {

                    displayFormats: {
                        quarter: 'MMM YYYY'
                    }
                },

            }]
        },
        plugins: {
            filler: {
                propagate: true
            },

        }
    };

    var page_engagements_chart = new Chart(page_engagement_canvas_id, {
        type: 'line',
        data: page_enagagement_data,
        options: page_engagement_options
    });

    // Page Reaction 

    var page_reactions_config = {
        type: 'line',
        data: {
            labels: <?php echo json_encode($page_actions_post_reactions_like_total_data_label); ?>,
            datasets: [{
                label: '<?php echo $this->lang->line("Daily Page Post Total Like"); ?>',
                data: <?php echo json_encode($page_actions_post_reactions_like_total_data_values); ?>,
                backgroundColor: '#6777ef',
                borderColor: '#6777ef',
                fill: false,
                borderDash: [5, 5],
                pointRadius: 4,
                pointHoverRadius: 6,
            },
                {
                    label: '<?php echo $this->lang->line("Daily Page Post Total Love Reaction"); ?>',
                    data: <?php echo json_encode($page_actions_post_reactions_love_total_data_values); ?>,
                    backgroundColor: '#ff6384',
                    borderColor: '#ff6384',
                    fill: false,
                    borderDash: [5, 5],
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
                {
                    label: '<?php echo $this->lang->line("Daily Page Post Total Wow Reaction"); ?>',
                    data: <?php echo json_encode($page_actions_post_reactions_wow_total_data_values); ?>,
                    backgroundColor: '#ffa426',
                    borderColor: '#ffa426',
                    fill: false,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
                {
                    label: '<?php echo $this->lang->line("Daily Page Post Total Haha Reaction"); ?>',
                    data: <?php echo json_encode(array_column($page_actions_post_reactions_haha_total, 'value')); ?>,
                    backgroundColor: '#36a2eb',
                    borderColor: '#36a2eb',
                    fill: false,
                    pointHitRadius: 15,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
                {
                    label: '<?php echo $this->lang->line("Daily Page Post Total Sad Reaction"); ?>',
                    data: <?php echo json_encode(array_column($page_actions_post_reactions_sorry_total, 'value')); ?>,
                    backgroundColor: '#fe8886',
                    borderColor: '#fe8886',
                    fill: false,
                    borderDash: [5, 5],
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
                {
                    label: '<?php echo $this->lang->line("Daily Page Post Total Angry Reaction"); ?>',
                    data: <?php echo json_encode(array_column($page_actions_post_reactions_anger_total, 'value')); ?>,
                    backgroundColor: '#c32849',
                    borderColor: '#c32849',
                    fill: false,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
        },
        options: {
            responsive: true,
            legend: {
                display: false
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            hover: {
                mode: 'index'
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    },
                    type: 'time',
                    time: {

                        displayFormats: {
                            quarter: 'MMM YYYY'
                        }
                    },

                }],
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    }

                }]
            },

        }
    };

    var page_reactions_chart = document.getElementById('page_reactions').getContext('2d');
    var page_reactions_my_chart = new Chart(page_reactions_chart, page_reactions_config);


    //Page CTA Clicks
    var page_cta_clicks_ctx1 = document.getElementById("page_cta_clicks").getContext('2d');
    var myChart = new Chart(page_cta_clicks_ctx1, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($page_total_actions_data_label); ?>,
            datasets: [{
                label: '<?php echo $this->lang->line("Page CTA Total"); ?>',
                data: <?php echo json_encode($page_total_actions_data_values); ?>,
                backgroundColor: '#6777ef',
                borderColor: 'transparent',
                hidden: false,

            },

                {
                    label: '<?php echo $this->lang->line("Page CTA Click User Logged-in"); ?>',
                    data: <?php echo json_encode(array_column($page_cta_clicks_logged_in_total, 'value')); ?>,
                    backgroundColor: '#ffb1c1',
                    borderColor: 'transparent',
                    fill: '-1'
                },
                {
                    label: '<?php echo $this->lang->line("Clicked Page Call Now Button Unique"); ?>',
                    data: <?php echo json_encode(array_column($page_call_phone_clicks_logged_in_unique, 'value')); ?>,
                    backgroundColor: '#9ad0f5',
                    borderColor: 'transparent',
                    fill: 1
                },
                {
                    label: '<?php echo $this->lang->line("Clicked Page Get Direection Button Unique"); ?>',
                    data: <?php echo json_encode(array_column($page_get_directions_clicks_logged_in_unique, 'value')); ?>,
                    backgroundColor: '#ff6384',
                    borderColor: 'transparent',
                    fill: '-1'
                },


            ]
        },
        options: {
            legend: {
                display: false
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: <?php echo $page_cta_clicks; ?>
                    }
                }],
                xAxes: [{
                    ticks: {
                        display: false
                    },
                    gridLines: {
                        display: false
                    }
                }]
            },
        }
    });


    //Page CTA Clicks 2

    var page_cta_divices_stats_config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: <?php echo json_encode(array_values(isset($page_website_clicks_by_site_logged_in_unique['value']) ? $page_website_clicks_by_site_logged_in_unique['value'] : array())); ?>,
                backgroundColor: [
                    '#ff5e57',
                    '#ff6384',
                    '#6777ef',
                    '#ffa426',
                    '#c32849',
                    '#fe8886',
                    '#63ed7a',
                    '#655dd0',
                    '#273c75',
                    '#fd79a8'
                ],

            }],
            labels: <?php echo json_encode(array_keys(isset($page_website_clicks_by_site_logged_in_unique['value']) ? $page_website_clicks_by_site_logged_in_unique['value'] : array())); ?>
        },
        options: {
            responsive: true,
            legend: {
                display: false,
            },

            animation: {
                animateScale: true,
                animateRotate: true
            },


        }
    };


    var page_cta_device_stats_ctx = document.getElementById('page_cta_clicks2').getContext('2d');
    var page_cta_device_stats_my_chart = new Chart(page_cta_device_stats_ctx, page_cta_divices_stats_config);

    // Page Fans
    var page_user_demographics_ctx = document.getElementById("page_user_demographics").getContext('2d');
    var page_user_demographics_chart = new Chart(page_user_demographics_ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($page_fans, 'date')) ?>,
            datasets: [{
                label: '<?php echo $this->lang->line("Page Fans"); ?>',
                data: <?php echo json_encode(array_column($page_fans, 'value')) ?>,
                borderWidth: 3,
                borderColor: '#36a2eb',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#36a2eb',
                pointRadius: 2
            },
            ]
        },
        options: {
            legend: {
                display: false
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: <?php echo $page_fans_steps; ?>
                    }

                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    },
                    type: 'time',
                    time: {

                        displayFormats: {
                            quarter: 'MMM YYYY'
                        }
                    },
                }],

            },
        }
    });

    //Page Fan adds and remove
    var page_user_demographics_add_remove_ctx = document.getElementById("page_user_adds_removes").getContext('2d');
    var page_user_demographics_add_remove_chart = new Chart(page_user_demographics_add_remove_ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($page_fan_adds, 'date')) ?>,
            datasets: [
                {
                    label: '<?php echo $this->lang->line("Daily Page Fan Adds"); ?>',
                    data: <?php echo json_encode(array_column($page_fan_adds, 'value')); ?>,
                    borderWidth: 3,
                    borderColor: '#4bc0c0',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4bc0c0',
                    pointRadius: 2
                }, {
                    label: '<?php echo $this->lang->line("Daily Page Fan Removes"); ?>',
                    data: <?php echo json_encode(array_column($page_fan_removes, 'value')); ?>,
                    borderWidth: 3,
                    borderColor: '#ff6384',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#ff6384',
                    pointRadius: 2
                }
            ]
        },
        options: {
            legend: {
                display: false
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: <?php echo $demo_steps; ?>
                    }

                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    },
                    type: 'time',
                    time: {

                        displayFormats: {
                            quarter: 'MMM YYYY'
                        }
                    },
                }],

            },
        }
    });
    // Page User Demographics Country
    var page_user_demographics_country_config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: <?php echo json_encode(array_values(isset($page_fans_country['country']) ? $page_fans_country['country'] : array())); ?>,
                backgroundColor: [
                    '#ff5e57',
                    '#ff6384',
                    '#6777ef',
                    '#ffa426',
                    '#c32849',
                    '#fe8886',
                    '#63ed7a',
                    '#655dd0',
                    '#273c75',
                    '#fd79a8'
                ],

            }],
            labels: <?php echo json_encode(array_keys(isset($page_fans_country['country']) ? $page_fans_country['country'] : array())); ?>
        },
        options: {
            responsive: true,
            legend: {
                display: false,
            },

            animation: {
                animateScale: true,
                animateRotate: true
            },

        }
    };


    var page_user_demographics_country_ctx = document.getElementById('page_user_demographics_country').getContext('2d');
    var page_user_demographics_country_chart = new Chart(page_user_demographics_country_ctx, page_user_demographics_country_config);

    // Page Content


    //Page Views
    var page_content_config = {
        type: 'pie',
        data: {
            datasets: [{
                data: <?php echo json_encode(array_values(isset($page_views_by_profile_tab_total['value']) ? $page_views_by_profile_tab_total['value'] : array())); ?>,
                backgroundColor: [

                    '#ff5e57',
                    '#ff6384',
                    '#6777ef',
                    '#ff6384',
                    '#c32849',
                    '#fe8886',
                    '#63ed7a',
                    '#655dd0',
                    '#273c75',
                    '#fd79a8'


                ],


            }],
            labels: <?php echo json_encode(array_keys(isset($page_views_by_profile_tab_total['value']) ? $page_views_by_profile_tab_total['value'] : array())); ?>
        },
        options: {
            responsive: true,
            legend: {
                display: false,
            },

            animation: {
                animateScale: true,
                animateRotate: true
            },
        }
    };


    var page_content_ctx = document.getElementById('page_profile_each_tabs').getContext('2d');
    var page_content_ctx_chart = new Chart(page_content_ctx, page_content_config);

    // Page Views 2
    var page_views_devices_stats_config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: <?php echo json_encode(array_values(isset($page_views_by_site_logged_in_unique['value']) ? $page_views_by_site_logged_in_unique['value'] : array())); ?>,
                backgroundColor: [
                    '#ff5e57',
                    '#ff6384',
                    '#6777ef',
                    '#ffa426',
                    '#c32849',
                    '#fe8886',
                    '#63ed7a',
                    '#655dd0',
                    '#273c75',
                    '#fd79a8'
                ],

            }],
            labels: <?php echo json_encode(array_keys(isset($page_views_by_site_logged_in_unique['value']) ? $page_views_by_site_logged_in_unique['value'] : array())); ?>
        },
        options: {
            responsive: true,
            legend: {
                display: false,
            },

            animation: {
                animateScale: true,
                animateRotate: true
            },


        }
    };


    var page_views_device_stats_ctx = document.getElementById('page_view_devices_stats').getContext('2d');
    var page_views_device_my_chart = new Chart(page_views_device_stats_ctx, page_views_devices_stats_config);
    // Page Views 3

    var page_views_refferer_config = {
        data: {
            datasets: [{
                data: <?php echo json_encode(array_values(isset($page_views_by_referers_logged_in_unique['value']) ? $page_views_by_referers_logged_in_unique['value'] : array())) ?>,
                backgroundColor: [
                    '#ff5e57',
                    '#ff6384',
                    '#6777ef',
                    '#8e44ad',
                    '#c32849',
                    '#fe8886',
                    '#63ed7a',
                    '#655dd0',
                    '#273c75',
                    '#fd79a8'
                ],
                label: 'My dataset' // for legend
            }],
            labels: <?php echo json_encode(array_keys(isset($page_views_by_referers_logged_in_unique['value']) ? $page_views_by_referers_logged_in_unique['value'] : array())) ?>
        },
        options: {
            responsive: true,
            legend: {
                display: false,
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        drawBorder: false,
                        display: false,
                        circular: true
                    },
                    ticks: {
                        display: false
                    }

                }],
                xAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                        circular: true
                    },
                    ticks: {
                        display: false
                    }
                }]
            },

            animation: {
                animateRotate: false,
                animateScale: true
            }
        }
    };


    var page_views_refferar_ctx = document.getElementById('page_views_refferer');
    var page_views_refferer_config_mychart = Chart.PolarArea(page_views_refferar_ctx, page_views_refferer_config);

    //Page Video Views Paid vs Unpaid
    var page_video_views_paid_vs_un_ctx = document.getElementById("page_video_views_paid_vs_unpaid").getContext('2d');


    var page_video_views_paid_vs_un_chart = new Chart(page_video_views_paid_vs_un_ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($page_video_views_paid_data_label); ?>,
            datasets: [
                {
                    label: '<?php echo $this->lang->line("Page Video Views Unpaid") ?>',
                    data: <?php echo json_encode($page_video_views_organic_data_values); ?>,
                    borderWidth: 2,
                    backgroundColor: '#6777ef',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: '#6777ef',
                },
                {
                    label: '<?php echo $this->lang->line("Page Video Views Paid"); ?>',
                    data: <?php echo json_encode($page_video_views_paid_data_values); ?>,
                    borderWidth: 2,
                    backgroundColor: '#0984e3',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: '#0984e3',
                },


            ]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },

                    ticks: {
                        beginAtZero: true,
                        stepSize: <?php echo $page_video_steps; ?>,
                        callback: function (value, index, values) {
                            return value;
                        }
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    },
                    type: 'time',
                    time: {

                        displayFormats: {
                            quarter: 'MMM YYYY'
                        }
                    },

                }]
            },
        }
    });

    // Page Video Views

    var page_video_views_ctx = document.getElementById("page_video_views").getContext('2d');
    var page_video_views_mychart = new Chart(page_video_views_ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($page_video_views_data_label); ?>,
            datasets: [{
                label: '<?php echo $this->lang->line("Page Videos View "); ?>',
                data: <?php echo json_encode($page_video_views_data_values); ?>,
                borderWidth: 2,
                backgroundColor: '#36a2eb',
                borderWidth: 0,
                borderColor: 'transparent',
                pointBorderWidth: 0,
                pointRadius: 3.5,
                pointBackgroundColor: 'transparent',
                pointHoverBackgroundColor: '#36a2eb',
            },
                {
                    label: '<?php echo $this->lang->line("Page Videos View By Auto Played"); ?>',
                    data: <?php echo json_encode($page_video_views_autoplayed_data_values); ?>,
                    borderWidth: 2,
                    backgroundColor: '#4bc0c0',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: '#4bc0c0',
                }, {
                    label: '<?php echo $this->lang->line("Page Videos View By Click"); ?>',
                    data: <?php echo json_encode($page_video_views_click_to_play_data_values); ?>,
                    borderWidth: 2,
                    backgroundColor: '#ff6384',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: '#ff6384',
                }, {
                    label: '<?php echo $this->lang->line("Page Videos View Unique"); ?>',
                    data: <?php echo json_encode($page_video_views_unique_data_values); ?>,
                    borderWidth: 2,
                    backgroundColor: '#6777ef',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: '#6777ef',

                },
                {
                    label: '<?php echo $this->lang->line("Total Vidoes View Time in milliseconds"); ?>',
                    data: <?php echo json_encode($page_video_view_time_data_values); ?>,
                    borderWidth: 2,
                    backgroundColor: '#6777ef',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: '#6777ef',

                }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: <?php echo $page_video_steps2; ?>
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    },
                    type: 'time',
                    time: {

                        displayFormats: {
                            quarter: 'MMM YYYY'
                        }
                    },
                }],

            },
        }
    });

    // Page Post Impressions viral and Nonviral
    var page_post_impression_viral_non_ctx = document.getElementById("page_post_impression_viral_nonviral").getContext('2d');
    var page_post_impression_viral_non_my_chart = new Chart(page_post_impression_viral_non_ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($page_posts_impressions_viral_data_label); ?>,
            datasets: [{
                label: '<?php echo $this->lang->line("Page Post Impressions Nonviral "); ?>',
                data: <?php echo json_encode($page_posts_impressions_nonviral_data_values); ?>,
                borderWidth: 2,
                backgroundColor: '#36a2eb',
                borderWidth: 0,
                borderColor: 'transparent',
                pointBorderWidth: 0,
                pointRadius: 3.5,
                pointBackgroundColor: 'transparent',
                pointHoverBackgroundColor: '#36a2eb',
            },
                {
                    label: '<?php echo $this->lang->line("Page Post Impressions Viral"); ?>',
                    data: <?php echo json_encode($page_posts_impressions_viral_data_values); ?>,
                    borderWidth: 2,
                    backgroundColor: '#6c5ce7',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: '#6c5ce7',
                },]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: <?php echo $page_post_impressions_steps; ?>
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    },
                    type: 'time',
                    time: {

                        displayFormats: {
                            quarter: 'MMM YYYY'
                        }
                    },
                }],

            },
        }
    });

    // Page Post Impressions Paid Vs Unpaid

    var page_post_impression_paid_unpaid_ctx = document.getElementById("page_post_impression_paid_vs_unpaid").getContext('2d');
    var page_post_impression_paid_unpaid_my_chart = new Chart(page_post_impression_paid_unpaid_ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($page_posts_impressions_paid_data_label); ?>,
            datasets: [{
                label: '<?php echo $this->lang->line("Page Post Impressions Paid "); ?>',
                data: <?php echo json_encode($page_posts_impressions_paid_data_values); ?>,
                borderWidth: 2,
                backgroundColor: '#36a2eb',
                borderWidth: 0,
                borderColor: 'transparent',
                pointBorderWidth: 0,
                pointRadius: 3.5,
                pointBackgroundColor: 'transparent',
                pointHoverBackgroundColor: '#36a2eb',
            },
                {
                    label: '<?php echo $this->lang->line("Page Post Impressions Unpaid"); ?>',
                    data: <?php echo json_encode($page_posts_impressions_organic_data_values); ?>,
                    borderWidth: 2,
                    backgroundColor: '#6c5ce7',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: '#6c5ce7',
                },]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: <?php echo $page_post_impressions_steps2; ?>
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    },
                    type: 'time',
                    time: {

                        displayFormats: {
                            quarter: 'MMM YYYY'
                        }
                    },
                }],

            },
        }
    });

</script>