<?php
$check_delivery_time = '';
if ($check_delivery_time == "") $check_delivery_time = date("Y-m-d H:i:s");
$check_date = date('Y-m-d', strtotime($check_delivery_time));
$check_day = date('l', strtotime($check_delivery_time));
$check_time = date('H:i:s', strtotime($check_delivery_time));
$ecommerce_store_business_hours = array();
if (!empty($check_day)) {
    $ecommerce_store_business_hours = $this->basic->get_data("ecommerce_store_business_hours", array("where" => array("store_id" => $store_id, "schedule_day" => $check_day)));
    if (isset($ecommerce_store_business_hours[0])) {
        if ($ecommerce_store_business_hours[0]['off_day'] == '1') {
            echo '<div class="container">
    <div class="alert alert-icon alert-warning alert-bg alert-inline show-code-action">
        <h4 class="alert-title">
            <i class="w-icon-exclamation-triangle"></i></h4>
        ' . $this->lang->line('Sorry, but we cannot take the order. We are closed on') . " " . $this->lang->line($check_day) . '!' . '
    </div>
</div>';
        } else {
            $start_time = $check_date . " " . $ecommerce_store_business_hours[0]['start_time'] . ":00";
            $end_time = $check_date . " " . $ecommerce_store_business_hours[0]['end_time'] . ":00";

            $time_ok = false;
            if (strtotime($check_delivery_time) >= strtotime($start_time) && strtotime($check_delivery_time) <= strtotime($end_time))
                $time_ok = true;

            if (!$time_ok) {
                echo '<div class="container">
    <div class="alert alert-icon alert-warning alert-bg alert-inline show-code-action">
        <h4 class="alert-title">
            <i class="w-icon-exclamation-triangle"></i></h4>
        ' . $this->lang->line('Sorry, but we cannot take the order. We are closed now.') . '
    </div>
</div>';
            }

        }
    }
}