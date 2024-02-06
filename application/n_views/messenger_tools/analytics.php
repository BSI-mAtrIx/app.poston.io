<?php
//todo: 00000 before release
?>
<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 1;
$include_owlcar = 0;
$include_prism = 0;
?>
<div class="section-header">
    <h1>
        <i class="bx bx-pie-chart"></i>
        <?php $fb_page_id = isset($page_info['page_id']) ? $page_info['page_id'] : ""; ?>
        <?php $page_auto_id = isset($page_info['id']) ? $page_info['id'] : 0; ?>
        <?php echo $this->lang->line("Bot Analytics"); ?> :
        <a href="<?php echo "https://facebook.com/" . $fb_page_id; ?>"
           target="_BLANK"><?php echo isset($page_info['page_name']) ? $page_info['page_name'] : ""; ?></a>

    </h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item">
            <form method="POST" action="<?php echo base_url('messenger_bot_analytics/result/' . $page_auto_id); ?>">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="bx bx-calendar"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control datepicker" value="<?php echo $from_date; ?>" id="from_date"
                           name="from_date" style="width:115px">
                    <input type="text" class="form-control datepicker" value="<?php echo $to_date; ?>" id="to_date"
                           name="to_date" style="width:115px">
                    <button class="btn btn-outline-primary" style="margin-left:1px" type="submit"><i
                                class="bx bx-search"></i> <?php echo $this->lang->line("Search"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="section-body">
    <?php
    if ($error_message == "") { ?>

        <div class="row">
            <div class="col-lg-4 col-12">
                <div class="card card-statistic-2">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo $this->lang->line("Latest Summary"); ?></h4>
                    </div>
                    <div class="card-body row">
                        <div class="col-4">
                            <div class="card text-center">
                                <div class="card-body p-0">
                                    <p class="text-muted mb-0 line-ellipsis"><?php echo $this->lang->line("New"); ?></p>
                                    <h2 class="mb-0"><?php echo $page_messages_new_conversations_unique_summary['today']; ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card text-center">
                                <div class="card-body p-0">
                                    <p class="text-muted mb-0 line-ellipsis"><?php echo $this->lang->line("Blocked"); ?></p>
                                    <h2 class="mb-0"><?php echo $page_messages_blocked_conversations_unique_summary['today']; ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card text-center">
                                <div class="card-body p-0">
                                    <p class="text-muted mb-0 line-ellipsis"><?php echo $this->lang->line("Reported"); ?></p>
                                    <h2 class="mb-0"><?php echo $page_messages_reported_conversations_unique_summary['today']; ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


            <div class="col-lg-4 col-12">
                <div class="card card-statistic-2">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo $this->lang->line("7 Days Summary"); ?></h4>
                    </div>
                    <div class="card-body row">
                        <div class="col-4">
                            <div class="card text-center">
                                <div class="card-body p-0">
                                    <p class="text-muted mb-0 line-ellipsis"><?php echo $this->lang->line("New"); ?></p>
                                    <h2 class="mb-0"><?php echo $page_messages_new_conversations_unique_summary['week']; ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card text-center">
                                <div class="card-body p-0">
                                    <p class="text-muted mb-0 line-ellipsis"><?php echo $this->lang->line("Blocked"); ?></p>
                                    <h2 class="mb-0"><?php echo $page_messages_blocked_conversations_unique_summary['week']; ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card text-center">
                                <div class="card-body p-0">
                                    <p class="text-muted mb-0 line-ellipsis"><?php echo $this->lang->line("Reported"); ?></p>
                                    <h2 class="mb-0"><?php echo $page_messages_reported_conversations_unique_summary['week']; ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


            <div class="col-lg-4 col-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo $this->lang->line("30 Days Summary"); ?></h4>
                        </div>
                        <div class="card-body row">
                            <div class="col-4">
                                <div class="card text-center">
                                    <div class="card-body p-0">
                                        <p class="text-muted mb-0 line-ellipsis"><?php echo $this->lang->line("New"); ?></p>
                                        <h2 class="mb-0"><?php echo $page_messages_new_conversations_unique_summary['month']; ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card text-center">
                                    <div class="card-body p-0">
                                        <p class="text-muted mb-0 line-ellipsis"><?php echo $this->lang->line("Blocked"); ?></p>
                                        <h2 class="mb-0"><?php echo $page_messages_blocked_conversations_unique_summary['month']; ?></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card text-center">
                                    <div class="card-body p-0">
                                        <p class="text-muted mb-0 line-ellipsis"><?php echo $this->lang->line("Reported"); ?></p>
                                        <h2 class="mb-0"><?php echo $page_messages_reported_conversations_unique_summary['month']; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-12">
                <div class="card card-statistic-1">

                    <div class="card-wrap">
                        <div class="card-header">
                            <h4><?php echo $this->lang->line("Total Connections"); ?></h4>
                        </div>
                        <div class="card-body">
                            <?php echo $total_connections; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card card-statistic-1">
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4><?php echo $this->lang->line("Total Blocked"); ?></h4>
                        </div>
                        <div class="card-body">
                            <?php echo $page_messages_blocked_conversations_unique_summary['search']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card card-statistic-1">
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4><?php echo $this->lang->line("Total Reported"); ?></h4>
                        </div>
                        <div class="card-body">
                            <?php echo $page_messages_reported_conversations_unique_summary['search']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Daily Unique New Conversations'); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Daily unique new conversations") ?>"
                               data-content="<?php echo $this->lang->line("Daily: The number of messaging conversations on Facebook Messenger that began with people who had never messaged with your business before.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_messages_new_conversations_unique" height="182"></canvas>
                    </div>
                </div>
            </div>
            <!-- DEPRECATED -->
            <div class="col-12 col-lg-6" style="display: none;">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Daily Active Conversations'); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Daily active conversations") ?>"
                               data-content="<?php echo $this->lang->line("The number of daily active conversations between users and the page") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_messages_active_threads_unique" height="182"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Messaging Connections'); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Messaging connections") ?>"
                               data-content="<?php echo $this->lang->line("Daily: The number of people your business can send messages to.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_messages_total_messaging_connections" height="182"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Daily Unique Blocked Conversations'); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Daily unique blocked conversations") ?>"
                               data-content="<?php echo $this->lang->line("Daily: The number of conversations with the Page that have been blocked") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_messages_blocked_conversations_unique" height="182"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Daily Unique Reported Conversations'); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Daily unique reported conversations") ?>"
                               data-content="<?php echo $this->lang->line("Daily: The number of conversations from your Page that have been reported by people for reasons such as spam, or containing inappropriate content") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_messages_reported_conversations_unique" height="182"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- DEPRECATED -->
        <div class="row" style="display: none;">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Daily Unique Reported Conversations by Type'); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Daily unique reported conversations by type") ?>"
                               data-content="<?php echo $this->lang->line("Daily: The number of conversations from your Page that have been reported by people for reasons such as spam, or containing inappropriate content broken down by report type") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_messages_reported_conversations_by_report_type_unique" height="182"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Total Reported'); ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_messages_reported_conversations_by_report_type_pie" height="410"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Daily Unique Reported vs Blocked Conversations'); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Daily unique reported vs blocked conversations") ?>"
                               data-content="<?php echo $this->lang->line("Conversations from your Page that have been reported by people vs conversations with the page that have been blocked") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_messages_reported_vs_blocked_conversations" height="100"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <?php
    } else {
        echo '
			<div class="card">
              <div class="card-header">
                <h4>' . $this->lang->line("Something Went Wrong") . '</h4>
              </div>
              <div class="card-body">
                <div class="empty-state" data-height="400" style="height: 400px;">
                  <div class="empty-state-icon bg-danger">
                    <i class="bx bx-time"></i>
                  </div>
                  <h2>' . $this->lang->line("Something Went Wrong") . '</h2>
                  <p class="lead">
                   ' . $error_message . '
                  </p>
                </div>
              </div>
            </div>';

    } ?>
</div>


<?php

$steps = 10;

$page_messages_new_conversations_unique_data_label = array_column($page_messages_new_conversations_unique, 'date');
$page_messages_new_conversations_unique_data_value = array_column($page_messages_new_conversations_unique, 'value');
$page_messages_new_conversations_unique_steps = (!empty($page_messages_new_conversations_unique_data_value)) ? round(max($page_messages_new_conversations_unique_data_value) / $steps) : 1;
if ($page_messages_new_conversations_unique_steps == 0) $page_messages_new_conversations_unique_steps = 1;


$page_messages_active_threads_unique_data_label = array_column($page_messages_active_threads_unique, 'date');
$page_messages_active_threads_unique_data_value = array_column($page_messages_active_threads_unique, 'value');
$page_messages_active_threads_unique_steps = (!empty($page_messages_active_threads_unique_data_value)) ? round(max($page_messages_active_threads_unique_data_value) / $steps) : 1;
if ($page_messages_active_threads_unique_steps == 0) $page_messages_active_threads_unique_steps = 1;


$page_messages_blocked_conversations_unique_data_label = array_column($page_messages_blocked_conversations_unique, 'date');
$page_messages_blocked_conversations_unique_data_value = array_column($page_messages_blocked_conversations_unique, 'value');
$page_messages_blocked_conversations_unique_steps = (!empty($page_messages_blocked_conversations_unique_data_value)) ? round(max($page_messages_blocked_conversations_unique_data_value) / $steps) : 1;
if ($page_messages_blocked_conversations_unique_steps == 0) $page_messages_blocked_conversations_unique_steps = 1;


$page_messages_reported_conversations_unique_data_label = array_column($page_messages_reported_conversations_unique, 'date');
$page_messages_reported_conversations_unique_data_value = array_column($page_messages_reported_conversations_unique, 'value');
$page_messages_reported_conversations_unique_steps = (!empty($page_messages_reported_conversations_unique_data_value)) ? round(max($page_messages_reported_conversations_unique_data_value) / $steps) : 1;
if ($page_messages_reported_conversations_unique_steps == 0) $page_messages_reported_conversations_unique_steps = 1;


$page_messages_reported_conversations_by_report_type_unique_labels = array_column($page_messages_reported_conversations_by_report_type_unique, 'date');
$page_messages_reported_conversations_by_report_type_unique_spam_values = array_column($page_messages_reported_conversations_by_report_type_unique, 'spam');
$page_messages_reported_conversations_by_report_type_unique_inappropriate_values = array_column($page_messages_reported_conversations_by_report_type_unique, 'inappropriate');
$page_messages_reported_conversations_by_report_type_unique_other_values = array_column($page_messages_reported_conversations_by_report_type_unique, 'other');
$max1 = (!empty($page_messages_reported_conversations_by_report_type_unique_spam_values)) ? max($page_messages_reported_conversations_by_report_type_unique_spam_values) : 0;
$max2 = (!empty($page_messages_reported_conversations_by_report_type_unique_inappropriate_values)) ? max($page_messages_reported_conversations_by_report_type_unique_inappropriate_values) : 0;
$max3 = (!empty($page_messages_reported_conversations_by_report_type_unique_other_values)) ? max($page_messages_reported_conversations_by_report_type_unique_other_values) : 0;
$max_array = array($max1, $max2, $max3);
$page_messages_reported_conversations_by_report_type_unique_steps = round(max($max_array) / $steps);
if ($page_messages_reported_conversations_by_report_type_unique_steps == 0) $page_messages_reported_conversations_by_report_type_unique_steps = 1;


$page_messages_reported_conversations_by_report_type_pie_values = array_column($page_messages_reported_conversations_by_report_type_pie, 'value');


$page_messages_reported_vs_blocked_conversations_labels = array_column($page_messages_reported_vs_blocked_conversations, 'date');
$page_messages_reported_vs_blocked_conversations_reported_values = array_column($page_messages_reported_vs_blocked_conversations, 'reported');
$page_messages_reported_vs_blocked_conversations_blocked_values = array_column($page_messages_reported_vs_blocked_conversations, 'blocked');
$max1 = (!empty($page_messages_reported_vs_blocked_conversations_reported_values)) ? max($page_messages_reported_vs_blocked_conversations_reported_values) : 0;
$max2 = (!empty($page_messages_reported_vs_blocked_conversations_blocked_values)) ? max($page_messages_reported_vs_blocked_conversations_blocked_values) : 0;
$max_array = array($max1, $max2, $max3);
$page_messages_reported_vs_blocked_conversations_steps = round(max($max_array) / $steps);
if ($page_messages_reported_vs_blocked_conversations_steps == 0) $page_messages_reported_vs_blocked_conversations_steps = 1;


$page_messages_total_messaging_connections_label = array_column($page_messages_total_messaging_connections, 'date');
$page_messages_total_messaging_connections_value = array_column($page_messages_total_messaging_connections, 'value');
$page_messages_total_messaging_connections_steps = (!empty($page_messages_total_messaging_connections_value)) ? round(max($page_messages_total_messaging_connections_value) / $steps) : 1;
if ($page_messages_total_messaging_connections_steps == 0) $page_messages_total_messaging_connections_steps = 1;

?>

