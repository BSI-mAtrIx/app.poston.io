<link rel="stylesheet"
      href="<?php echo base_url(); ?>n_assets/plugins/summernote/summernote-bs4.css?ver=<?php echo $n_config['theme_version']; ?>">
<link href="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.css?ver=<?php echo $n_config['theme_version']; ?>"
      rel="stylesheet" type="text/css"/>
<style>
    .bx-none {
        box-shadow: none !important;
    }

    .brTop {
        border-top: solid .5px #f9f9f9 !important;
    }

    .layOut {
        margin: 0;
        border: .5px solid #efefef;
        padding: 0 1px !important;
    }

    .layOut .card-header {
        border-bottom: .5px solid #f9f9f9 !important;
    }

    .layOut .sub_selection {
        padding-left: 0px;
        padding-right: 0px;
        border-right: .5px solid #efefef;
    }

    .layOut .sub_counter {
        padding-left: 0px;
        padding-right: 0px;
    }

    .ajax-upload-dragdrop span {
        display: unset !important;
    }

    .ajax-upload-dragdrop {
        border: .7px dashed #6777ef;
        cursor: pointer
    }


    .modal-backdrop, .modal-backdrop.in {
        display: none !important;
    }

    .note-dialog .modal-dialog {
        z-index: 1050;
    }

    .fw_700 {
        font-weight: 700 !important;
    }

    ;
    .fw_400 {
        font-weight: 400 !important;
    }

    ;
    .fw_none {
        font-weight: normal !important;
    }

    .email_subject {
        font-weight: 400;
        font-size: 18px;
    }

    .list-style-none {
        list-style: none !important;
    }

    #searching_campaign, #report_search {
        max-width: 50% !important;
    }

    #campaign_status, #rate_type {
        width: 110px !important;
    }

    .summary .summary-info {
        padding: 20px 0;
    }

    .list-group-item {
        border: 1px solid rgba(148, 147, 147, 0.125);
    }

    .summary .summary-item .card-body .list-group .list-group-item .tittle-text {
        font-size: 12px;
    }

    .summary .summary-item .card-body .list-group .list-group-item .badge-pill {
        background: none;
        color: #484747;
        padding: 0
    }

    .progress {
        background-color: #caced2 !important;
    }

    .report_font_styles {
        font-size: 14px !important;
    }

    .bbw {
        border-bottom-width: thin !important;
        border-bottom: solid .5px #f9f9f9 !important;
        padding-bottom: 20px;
    }

    @media (max-width: 575.98px) {
        #searching_campaign, #report_search {
            max-width: 77% !important;
        }
    }

    @media (min-width: 480px) {
        /* smartphones, Android phones, landscape iPhone */
    }

    #attachment_btn {
        padding: 20px;
    }

    #attachment_btn i {
        font-size: 20px;
    }

    #borderDiv {
        border-top: dotted 1px #d6d6d6;
        margin: 10px 0;
    }

</style>