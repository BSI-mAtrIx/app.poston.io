<script>


    var page_messages_new_conversations_unique_data = document.getElementById("page_messages_new_conversations_unique").getContext('2d');
    var page_messages_new_conversations_unique_data_label = <?php echo json_encode($page_messages_new_conversations_unique_data_label); ?>;
    var page_messages_new_conversations_unique_data_value = <?php echo json_encode($page_messages_new_conversations_unique_data_value); ?>;
    var page_messages_new_conversations_unique_chart = new Chart(page_messages_new_conversations_unique_data, {
        type: 'line',
        data: {
            labels: page_messages_new_conversations_unique_data_label,
            datasets: [{
                label: '<?php echo $this->lang->line("Unique New Conversations"); ?>',
                data: page_messages_new_conversations_unique_data_value,
                borderWidth: 2,
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
                        stepSize: <?php echo $page_messages_new_conversations_unique_steps; ?>
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    }
                }]
            },
        }
    });


    var page_messages_active_threads_unique_data = document.getElementById("page_messages_active_threads_unique").getContext('2d');
    var page_messages_active_threads_unique_data_label = <?php echo json_encode($page_messages_active_threads_unique_data_label); ?>;
    var page_messages_active_threads_unique_data_value = <?php echo json_encode($page_messages_active_threads_unique_data_value); ?>;
    var page_messages_active_threads_unique_chart = new Chart(page_messages_active_threads_unique, {
        type: 'line',
        data: {
            labels: page_messages_active_threads_unique_data_label,
            datasets: [{
                label: '<?php echo $this->lang->line("Active Conversations"); ?>',
                data: page_messages_active_threads_unique_data_value,
                borderWidth: 2,
                borderColor: '#63ed7a',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#63ed7a',
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
                        stepSize: <?php echo $page_messages_active_threads_unique_steps; ?>
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    }
                }]
            },
        }
    });


    var page_messages_blocked_conversations_unique_data = document.getElementById("page_messages_blocked_conversations_unique").getContext('2d');
    var page_messages_blocked_conversations_unique_data_label = <?php echo json_encode($page_messages_blocked_conversations_unique_data_label); ?>;
    var page_messages_blocked_conversations_unique_data_value = <?php echo json_encode($page_messages_blocked_conversations_unique_data_value); ?>;
    var page_messages_blocked_conversations_unique_chart = new Chart(page_messages_blocked_conversations_unique, {
        type: 'bar',
        data: {
            labels: page_messages_blocked_conversations_unique_data_label,
            datasets: [{
                label: '<?php echo $this->lang->line("Blocked Conversations"); ?>',
                data: page_messages_blocked_conversations_unique_data_value,
                borderWidth: 2,
                backgroundColor: 'rgba(20, 71, 118, .5)',
                borderColor: 'rgba(20, 71, 118, .5)',
                borderWidth: 0,
                pointBackgroundColor: '#ffffff',
                pointRadius: 4
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: <?php echo $page_messages_blocked_conversations_unique_steps; ?>
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


    var page_messages_reported_conversations_unique_data = document.getElementById("page_messages_reported_conversations_unique").getContext('2d');
    var page_messages_reported_conversations_unique_data_label = <?php echo json_encode(array_column($page_messages_reported_conversations_unique, 'date')); ?>;
    var page_messages_reported_conversations_unique_data_value = <?php echo json_encode(array_column($page_messages_reported_conversations_unique, 'value')); ?>;
    var page_messages_reported_conversations_unique_chart = new Chart(page_messages_reported_conversations_unique, {
        type: 'line',
        data: {
            labels: page_messages_reported_conversations_unique_data_label,
            datasets: [{
                label: '<?php echo $this->lang->line("Reported Conversations"); ?>',
                data: page_messages_reported_conversations_unique_data_value,
                borderWidth: 2,
                backgroundColor: 'rgba(254,86,83,.3)',
                borderColor: '#fc544b',
                borderWidth: 1,
                pointBackgroundColor: '#ffffff',
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
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: <?php echo $page_messages_reported_conversations_unique_steps; ?>
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


    var page_messages_reported_conversations_by_report_type_unique = document.getElementById("page_messages_reported_conversations_by_report_type_unique").getContext('2d');
    var page_messages_reported_conversations_by_report_type_unique_chart = new Chart(page_messages_reported_conversations_by_report_type_unique, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($page_messages_reported_conversations_by_report_type_unique_labels);?>,
            datasets: [{
                label: "<?php echo $this->lang->line('Spam');?>",
                data: <?php echo json_encode($page_messages_reported_conversations_by_report_type_unique_spam_values);?>,
                borderWidth: 2,
                backgroundColor: 'rgba(63,82,227,.6)',
                borderWidth: 0,
                borderColor: 'transparent',
                pointBorderWidth: 0,
                pointRadius: 2.5,
                pointBackgroundColor: 'rgba(63,82,227,.7)',
                pointHoverBackgroundColor: 'rgba(63,82,227,.7)',
            },
                {
                    label: "<?php echo $this->lang->line('Inappropriate');?>",
                    data: <?php echo json_encode($page_messages_reported_conversations_by_report_type_unique_inappropriate_values);?>,
                    borderWidth: 2,
                    backgroundColor: 'rgba(20, 71, 118, .5)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 2.5,
                    pointBackgroundColor: 'rgba(20, 71, 118, .7)',
                    pointHoverBackgroundColor: 'rgba(20, 71, 118, .7)',
                },
                {
                    label: "<?php echo $this->lang->line('Others');?>",
                    data: <?php echo json_encode($page_messages_reported_conversations_by_report_type_unique_other_values);?>,
                    borderWidth: 2,
                    backgroundColor: 'rgba(254,86,83,.5)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 2.5,
                    pointBackgroundColor: 'rgba(254,86,83,.7)',
                    pointHoverBackgroundColor: 'rgba(254,86,83,.7)',
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
                        // display: false,
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: <?php echo $page_messages_reported_conversations_by_report_type_unique_steps; ?>,
                        callback: function (value, index, values) {
                            return value;
                        }
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false,
                        tickMarkLength: 15,
                    }
                }]
            },
        }
    });


    var page_messages_reported_conversations_by_report_type_pie = document.getElementById("page_messages_reported_conversations_by_report_type_pie").getContext('2d');
    var page_messages_reported_conversations_by_report_type_pie_chart = new Chart(page_messages_reported_conversations_by_report_type_pie, {
        type: 'pie',
        data: {
            datasets: [{
                data: <?php echo json_encode($page_messages_reported_conversations_by_report_type_pie_values); ?>,
                backgroundColor: [
                    'rgba(63,82,227,.7)',
                    'rgba(20, 71, 118, .7)',
                    'rgba(254,86,83,.7)'
                ],
                label: 'Dataset 1'
            }],
            labels: [
                "<?php echo $this->lang->line('Spam');?>",
                "<?php echo $this->lang->line('Inappropriate');?>",
                "<?php echo $this->lang->line('Others');?>"
            ],
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom',
            },
        }
    });


    var page_messages_reported_vs_blocked_conversations = document.getElementById("page_messages_reported_vs_blocked_conversations").getContext('2d');
    var page_messages_reported_vs_blocked_conversations_chart = new Chart(page_messages_reported_vs_blocked_conversations, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($page_messages_reported_vs_blocked_conversations_labels);?>,
            datasets: [{
                label: "<?php echo $this->lang->line('Reported');?>",
                data: <?php echo json_encode($page_messages_reported_vs_blocked_conversations_reported_values);?>,
                borderWidth: 2,
                backgroundColor: 'rgba(254,86,83, .5)',
                borderWidth: 0,
                borderColor: 'transparent',
                pointBorderWidth: 0,
                pointRadius: 2.5,
                pointBackgroundColor: 'rgba(254,86,83, .7)',
                pointHoverBackgroundColor: 'rgba(254,86,83, .7)'
            },
                {
                    label: "<?php echo $this->lang->line('Blocked');?>",
                    data: <?php echo json_encode($page_messages_reported_vs_blocked_conversations_blocked_values);?>,
                    borderWidth: 2,
                    backgroundColor: 'rgba(20, 71, 118,.5)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 2.5,
                    pointBackgroundColor: 'rgba(20, 71, 1187,.7)',
                    pointHoverBackgroundColor: 'rgba(20, 71, 118,.7)'
                }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        // display: false,
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: <?php echo $page_messages_reported_vs_blocked_conversations_steps; ?>,
                        callback: function (value, index, values) {
                            return value;
                        }
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false,
                        tickMarkLength: 15,
                    }
                }]
            },
        }
    });


    var page_messages_total_messaging_connections = document.getElementById("page_messages_total_messaging_connections").getContext('2d');
    var page_messages_total_messaging_connections_label = <?php echo json_encode($page_messages_total_messaging_connections_label); ?>;
    var page_messages_total_messaging_connections_value = <?php echo json_encode($page_messages_total_messaging_connections_value); ?>;
    var page_messages_total_messaging_connections_chart = new Chart(page_messages_total_messaging_connections, {
        type: 'line',
        data: {
            labels: page_messages_total_messaging_connections_label,
            datasets: [{
                label: '<?php echo $this->lang->line("Conversations"); ?>',
                data: page_messages_total_messaging_connections_value,
                borderWidth: 2,
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
                        stepSize: <?php echo $page_messages_total_messaging_connections_steps; ?>
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#fbfbfb',
                        lineWidth: 2
                    }
                }]
            },
        }
    });


</script>