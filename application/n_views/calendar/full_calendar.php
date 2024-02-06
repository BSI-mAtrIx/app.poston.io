<?php
$user_id_url = $this->uri->segment(3);
if (empty($user_id_url)) $user_id_url = 0;
?>

<!-- fullCalendar -->
<link rel="stylesheet"
      href="<?php echo base_url(); ?>assets/modules/fullcalendar/main.min.css?ver=<?php echo $n_config['theme_version']; ?>">

<style>
    .popover {
        min-width: 250px;
        background: -webkit-linear-gradient(90deg, #FFFFFF, #FAFDFB, #D7E9F7)
    }

    .fc .fc-popover {
        min-width: 260px;
    }

    .fc .fc-toolbar.fc-header-toolbar {
        margin-bottom: 0;
    }

    .text-success.fc-daygrid-event .fc-event-title {
        color: #09ce2a !important;
    }

    .fc .fc-daygrid-day-top {
        justify-content: center;
    }

    .fc .fc-daygrid-day-number {
        font-weight: 500;
    }

    .fc .fc-day-other .fc-daygrid-day-top {
    }

    .fc-view > table th {
        padding: 0;
        vertical-align: top !important;
        border-bottom-width: 1px;
    }

    .fc-view > table td {
        vertical-align: top !important;
    }

    .dashboard_fullCalendar .fc .fc-daygrid-day-frame {
        min-height: 100% !important;
    }

    .fc-daygrid-dot-event .fc-event-title {
        flex-grow: 0 !important;
    }

    .fc-daygrid-dot-event .fc-event-time {
        color: #535050 !important;
        font-weight: 700;
    }

    .fc .fc-daygrid-more-link {
        float: left;
        font-weight: 600;
        text-decoration: none;
        font-size: 13px;
    }

    .fc-daygrid.fc-dayGridMonth-view.fc-view {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }

    .fc-daygrid-dot-event.fc-event-mirror, .fc-daygrid-dot-event:hover {
        background: none;
        color: var(--blue);
    }

    .fc-daygrid-event-dot {
        border: calc(var(--fc-daygrid-event-dot-width, 8px) / 1.6) solid var(--fc-event-border-color, #3788d8)
    }

    .fc .fc-daygrid-day.fc-day-today {
        background: unset;
    }

    .fc-view > table td.has_events {
        background: -webkit-linear-gradient(270deg, #FFFFFF, #FAFDFB, #D7E9F7);
    }

    .fc-view > table td.has_events.fc-day-today {
        background: -webkit-linear-gradient(270deg, #FFFFFF, #FAFDFB, #D7E9F7);
    }

    .fc-view > table tr:not(.event_row) {
        height: 30px !important;
    }

    .event_description hr {
        color: #c4c0c0;
        margin-top: -5px;
    }

    .fc-list-empty {
        background: -webkit-linear-gradient(90deg, #FFFFFF, #FAFDFB, #D7E9F7) !important;
    }

    .table-active, .table-active > td, .table-active > th {
        background: #D7E9F7 !important;
    }
</style>
<!-- full calender -->

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="section-body">
    <div class="card">
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>



