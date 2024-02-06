<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('announcement/full_list'); ?>"><?php echo $this->lang->line("Announcement"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('admin/theme/message'); ?>

<?php $description = preg_replace("/(https?:\/\/[a-zA-Z0-9\-._~\:\/\?#\[\]@!$&'\(\)*+,;=]+)/", '<a target="_BLANK" href="$1">$1</a>', $xdata['description']); // find and replace links with ancor tag ?>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $xdata['title']; ?></h4>
                </div>
                <div class="card-body">
                    <div class="p-1 mb-2 "><?php echo nl2br($description); ?></div>
                    <div class="section-title font-small-3"><?php echo $this->lang->line("Published"); ?><?php echo date_time_calculator($xdata['created_at'], true); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
