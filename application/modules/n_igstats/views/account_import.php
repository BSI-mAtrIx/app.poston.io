<section class="section section_custom">
    <div class="section-header">
        <h1><i class="fa fa-search-location"></i> <?php echo $page_title; ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a
                        href="<?php echo base_url('n_igstats/'); ?>"><?php echo $this->lang->line('statistics'); ?></a>
            </div>
            <div class="breadcrumb-item"><?php echo $page_title; ?></div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="container-fluid">
                        <div class="row clearfix">

                            <div class="col-xs-12" style="margin:15px auto;">
                                <h4>
                                    <div class="text-center" style="margin-bottom:80px;">
                                        <p style="font-size:15px; margin-top:15px; max-width:80%; margin:15px auto;">
                                            <?php echo $this->lang->line("Below are your Instagram business or creator accounts. Accounts must be linked to the Facebook page. If you don't see your account, import it."); ?>
                                        </p>
                                        <div class="text-center">
                                            <a style="color:#fff;" href="/social_accounts/index"
                                               class="center-block btn btn-primary update_your_account">
                                                <i class="fas fa-plus-circle"></i> <?php echo $this->lang->line("Import account"); ?>
                                            </a>
                                        </div>
                                    </div>
                                </h4>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:20px;">
                            <?php if ($existing_accounts != '0' && $show_import_account_box == 1 && !empty($existing_accounts)) { ?>
                                <?php $i = 0;
                                foreach ($existing_accounts as $value) : ?>

                                    <?php foreach ($value['instra_info_list'] as $instra_info) : ?>
                                        <div class="col-md-4" style="margin-bottom:50px;">
                                            <div class="text-center">
                                                <img src="<?php echo $instra_info['page_profile']; ?>"
                                                     class='custom-top-margin img-thumbnail' style="height:90px;">
                                            </div>
                                            <div class="text-center">
                                                <a href="https://www.instagram.com/<?php echo $instra_info['insta_username']; ?>">
                                                    <h3 style="font-size:13px; margin-top:20px; margin-bottom:20px;">
                                                        @<?php echo $instra_info['insta_username']; ?></h3>
                                                </a>
                                            </div>
                                            <div class="row text-center" style="margin-bottom:20px;">
                                                <div class="col-md-7">
                                                    <b><?php echo custom_number_format($instra_info['insta_followers_count']); ?></b> <?php echo $this->lang->line('Followers'); ?>
                                                </div>
                                                <div class="col-md-5">
                                                    <b><?php echo custom_number_format($instra_info['insta_media_count']); ?></b> <?php echo $this->lang->line('media'); ?>
                                                </div>
                                            </div>

                                            <a style="margin:0 0 5px 0;width:100%;" class="center-block btn btn-primary"
                                               href="<?php echo base_url('/n_igstats/user_insight/' . $instra_info['id']); ?>">
                                                <i class="fa fa-th-list"></i>
                                                <?php echo $this->lang->line("Account statistics") ?>
                                            </a>

                                            <a style="margin:0 0 5px 0;width:100%; color:#fff;"
                                               data-id="<?php echo $instra_info['id']; ?>"
                                               class="center-block btn btn-primary update_your_account">
                                                <i class="fa fa-retweet"></i>
                                                <?php echo $this->lang->line("Update account data"); ?>
                                            </a>

                                        </div>
                                    <?php endforeach; ?>

                                <?php endforeach; ?>
                            <?php } else echo "<br><br>"; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>


<link rel=stylesheet href="/plugins/alertifyjs/css/alertify.min.css"/>
<link rel=stylesheet href="/plugins/alertifyjs/css/themes/default.min.css"/>
<script src="/plugins/alertifyjs/alertify.min.js"></script>
<script>
    $("#instagram_menu").addClass('active');


    $('.update_your_account').click(function () {
        var base_url = '<?php echo site_url();?>';
        var id = this.getAttribute('data-id');
        var alert_id = "alert_" + id;
        $(".update_your_account").addClass('disabled');

        var loading = '<img src="' + base_url + 'assets/pre-loader/custom.gif" class="center-block">';
        $("#" + alert_id).removeClass("alert-success");
        $("#" + alert_id).show().html(loading);
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url();?>n_igstats/update_your_account_info",
            data: {
                id: id,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',

            },
            dataType: 'JSON',
            success: function (response) {
                $("#" + alert_id).addClass("alert-success");
                $("#" + alert_id).show().html(response.message);
                // alert(response.message);
                alertify.alert('Result', response.message, function () {
                    location.reload();
                });
            }
        });
    });


</script>


