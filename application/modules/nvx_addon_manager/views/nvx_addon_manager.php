<section class="section">
    <div class="section-header">
        <h1><i class="fas fa-leaf"></i> <?php echo $page_title; ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><?php echo $this->lang->line("System"); ?></div>
            <div class="breadcrumb-item"><?php echo $page_title; ?></div>
        </div>
    </div>

    <?php $modals_to_footer = ''; ?>
    <div class="section-body">

        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-12">

                <div class="card">
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4><?php echo $this->lang->line("Join to our group on Facebook"); ?>: <br/> <a
                                        href="https://www.facebook.com/groups/457356838761613"
                                        target="_blank""><?php echo $this->lang->line("Go to Facebook"); ?></a></h4>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">

                <div class="card">
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4><?php echo $this->lang->line("BUG Reports"); ?>: <br/> <a
                                        href="https://docs.google.com/forms/d/e/1FAIpQLSetMDrc-b4cHUHtD_BF1td0caYInkPwPTxWKWxW9tZYmZ-zJw/viewform"
                                        target="_blank""><?php echo $this->lang->line("Go to BUG Report Form"); ?></a>
                            </h4>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-lg-4 col-md-4 col-sm-12">

                <div class="card">
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4><?php echo $this->lang->line("Like my job?"); ?> <br/> <a
                                        href="https://nvxgroup.com/donate-for-hard-work-and-yerba-mate/" target="_blank""><?php echo $this->lang->line("Go to TIP"); ?></a>
                            </h4>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="card">

            <div class="card-header">
                <h4 style="width: 100%">
                    <i class="fas fa-toolbox"></i>&nbsp; <span id="get_nviews_title_1019">Re-design dashboard UI XeroChat</span>
                    <?php if ($nviews['installed'] == 1) { ?> <span class="badge badge-light"><i
                                class="fas fa-check-circle"></i> <?php echo $this->lang->line("Active"); ?></span> <?php } ?>
                    <?php if ($nviews['installed'] == 0) { ?> <span class='badge badge-light'><i
                                class='fas fa-ban'></i> <?php echo $this->lang->line("Inactive"); ?></span> <?php } ?>
                    <?php if ($nviews['code'] == 0) { ?><span class='badge badge-light'><i
                            class='fas fa-ban'></i> <?php echo $this->lang->line("Purchase code invalid"); ?>
                        </span><?php } ?>
                    <code class="float-right">
                        <?php if (!empty($nviews['version'])) {
                            echo $this->lang->line('Your Version'); ?> : <b>v<?php echo $nviews['version']; ?></b>
                            <br/><?php } ?>
                        <?php if (!empty($nviews['Latest_Version']) and $nviews['Latest_Version'] > $nviews['version']) {
                            echo $this->lang->line('New Version'); ?> : <b>
                            v<?php echo $nviews['Latest_Version']; ?></b><?php } ?>
                    </code>
                </h4>
            </div>

            <div class="card-body">
                <p class="text-danger">Please check News before update XeroChat.</p>

                <?php if ($nviews['downloaded'] == 1 and $nviews['activated'] == 1) { ?>

                    <a title="<?php echo $this->lang->line("Deactivate"); ?>"
                       class="btn btn-outline-primary activate_ntheme_action" href="#"
                       data-text="<?php echo $this->lang->line("Do you really want to deactivate this dashboard theme?"); ?>"
                       data-title="<?php echo $this->lang->line("Deactivate theme?"); ?>"
                    >
                        <i class="fa fa-ban"></i> <?php echo $this->lang->line('Deactivate'); ?>
                    </a>


                <?php } ?>

                <?php if ($nviews['downloaded'] == 1 and $nviews['activated'] == 0) { ?>

                    <a title="<?php echo $this->lang->line("Activate"); ?>"
                       class="btn btn-outline-primary activate_ntheme_action" href="#"
                       data-text="<?php echo $this->lang->line("Do you really want to activate this dashboard theme?"); ?>"
                       data-title="<?php echo $this->lang->line("Activate theme?"); ?>"
                    >
                        <i class="fa fa-check"></i> <?php echo $this->lang->line('Activate'); ?>
                    </a>


                <?php } ?>


                <?php if (!empty($nviews['Latest_Version']) and $nviews['Latest_Version'] > $nviews['version'] and $nviews['code'] == 1) { ?>

                    <a title="<?php echo $this->lang->line("Install/Update"); ?>" class="btn btn-outline-primary"
                       data-i='<?php echo $nviews['PID']; ?>' data-base="<?php echo $nviews['BASE']; ?>"
                       data-key="<?php echo $nviews['KEY']; ?>" href="#" data-toggle="modal"
                       data-target="#iu_nviews_action_modal"><i
                                class="fa fa-file-upload"></i> <?php echo $this->lang->line('Install/Update'); ?></a>


                <?php } ?>


                <!-- //check API -->

                <?php if ($nviews['code'] == 0) { ?>

                    <a title="<?php echo $this->lang->line("Change purchase code"); ?>"
                       class="btn btn-outline-primary code_action" data-i='<?php echo $nviews['PID']; ?>'
                       data-base="<?php echo $nviews['BASE']; ?>" data-key="<?php echo $nviews['KEY']; ?>" href="#"
                       data-href="<?php echo '/nvx_addon_manager/purchase_code'; ?>"><i
                                class="fa fa-code"></i> <?php echo $this->lang->line('Change purchase code'); ?></a>

                <?php } ?>




                <?php if (!empty($nviews['changelog'])) { ?>

                    <a title="<?php echo $this->lang->line("See Log"); ?>"
                       class="btn btn-outline-primary changelog_action" data-i='<?php echo $nviews['PID']; ?>'
                       data-base="<?php echo $nviews['BASE']; ?>" data-key="<?php echo $nviews['KEY']; ?>" href="#"
                       data-toggle="modal" data-target="#changelog_<?php echo $nviews['PID']; ?>"><i
                                class="fa fa-eye"></i> <?php echo $this->lang->line('See Log'); ?></a>


                <?php } ?>

                <?php

                echo $nviews['URL_Product'];

                ?>

            </div>

        </div>

        <?php

        foreach ($products as $value) {
            if ($value['XID'] == 1019) {
                continue;
            }

            ?>
            <div class="card">

                <div class="card-header">
                    <h4 style="width: 100%">
                        <i class="fas fa-toolbox"></i>&nbsp; <span
                                id="get_add_on_title_<?php echo $value['XID']; ?>"><?php echo $value['Name']; ?></span>
                        <?php if ($value['addon_data']['installed'] == 1) { ?> <span class="badge badge-light"><i
                                    class="fas fa-check-circle"></i> <?php echo $this->lang->line("Active"); ?></span> <?php } ?>
                        <?php if ($value['addon_data']['installed'] == 0) { ?> <span class='badge badge-light'><i
                                    class='fas fa-ban'></i> <?php echo $this->lang->line("Inactive"); ?></span> <?php } ?>
                        <?php if ($value['addon_data']['code'] == 0) { ?><span class='badge badge-light'><i
                                class='fas fa-ban'></i> <?php echo $this->lang->line("Purchase code invalid"); ?>
                            </span><?php } ?>
                        <code class="float-right">
                            <?php if (!empty($value['addon_data']['version'])) {
                                echo $this->lang->line('Your Version'); ?> :
                                <b>v<?php echo $value['addon_data']['version']; ?></b><br/><?php } ?>
                            <?php if (!empty($value['Latest_Version']) and $value['Latest_Version'] > $value['addon_data']['version']) {
                                echo $this->lang->line('New Version'); ?> : <b>
                                v<?php echo $value['Latest_Version']; ?></b><?php } ?>
                        </code>
                    </h4>
                </div>

                <div class="card-body">


                    <?php $module_controller = str_replace('.php', '', strtolower('/nvx_addon_manager')); ?>
                    <?php if ($value['XID'] != 1012 and !empty($value['addon_data']['controller_name'])) {
                        $module_controller = str_replace('.php', '', strtolower($value['addon_data']['controller_name']));

                    } ?>


                    <!-- //check API -->

                    <?php if ($value['XID'] != 1012 and $value['addon_data']['code'] == 0 or $value['XID'] != 1012 and $value['addon_data']['installed'] == 0) { ?>
                        <a title="<?php echo $this->lang->line("Change purchase code"); ?>"
                           class="btn btn-outline-primary code_action" data-i='<?php echo $value['PID']; ?>'
                           data-base="<?php echo $value['BASE']; ?>" data-key="<?php echo $value['KEY']; ?>" href="#"
                           data-href="<?php echo '/nvx_addon_manager/purchase_code'; ?>"><i
                                    class="fa fa-code"></i> <?php echo $this->lang->line('Change purchase code'); ?>
                        </a> <?php } ?>

                    <!-- //if module not exist -->
                    <?php if ($value['XID'] != 1012 and empty($value['addon_data']['downloaded']) and $value['addon_data']['code'] == 1) { ?>

                        <a title="<?php echo $this->lang->line("Download"); ?>"
                           class="btn btn-outline-primary download_action" data-i='<?php echo $value['PID']; ?>'
                           data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>"
                           data-key="<?php echo $value['KEY']; ?>" href="#"
                           data-href="<?php echo '/nvx_addon_manager/download'; ?>"><i
                                    class="fa fa-download"></i> <?php echo $this->lang->line('Download'); ?></a>

                    <?php } ?>
                    <!-- //if module exist and update availably  -->
                    <?php

                    if (!empty($value['addon_data']['version']) and !empty($value['Latest_Version']) and $value['Latest_Version'] > $value['addon_data']['version']) {

                        if ($value['XID'] != 1012) { ?>

                            <a title="<?php echo $this->lang->line("Update"); ?>"
                               class="btn btn-outline-primary update_action" data-i='<?php echo $value['PID']; ?>'
                               data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>"
                               data-key="<?php echo $value['KEY']; ?>" href="#"
                               data-href="<?php echo '/nvx_addon_manager/update_script'; ?>"><i
                                        class="fa fa-file-upload"></i> <?php echo $this->lang->line('Update'); ?></a>

                        <?php }

                        if ($value['XID'] == 1012) { ?>

                            <a title="<?php echo $this->lang->line("Update"); ?>"
                               class="btn btn-outline-primary update_nm_action" data-i='<?php echo $value['PID']; ?>'
                               data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>"
                               data-key="<?php echo $value['KEY']; ?>" href="#"
                               data-href="<?php echo '/nvx_addon_manager/update_script_manager'; ?>"><i
                                        class="fa fa-file-upload"></i> <?php echo $this->lang->line('Update'); ?></a>

                        <?php } ?>

                    <?php } ?>

                    <a title="<?php echo $this->lang->line("Update"); ?>"
                       class="btn btn-outline-primary changelog_action" data-i='<?php echo $value['PID']; ?>'
                       data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>"
                       data-key="<?php echo $value['KEY']; ?>" href="#"
                       data-href="<?php echo '/nvx_addon_manager/changelog'; ?>" data-toggle="modal"
                       data-target="#changelog_<?php echo $value['PID']; ?>"><i
                                class="fa fa-eye"></i> <?php echo $this->lang->line('See Log'); ?></a>

                    <?php

                    if (empty($value["changelog"])) {
                        $value["changelog"] = 'Purchase code not provided';
                    }


                    $modals_to_footer .= '
			        					<div class="modal fade"  tabindex="-1" role="dialog" id="changelog_' . $value["PID"] . '" data-backdrop="static" data-keyboard="false">
			        					  <div class="modal-dialog modal-lg" role="document">

			        					    <!-- Modal content-->
			        					    <div class="modal-content">
			        					      <div class="modal-header">			        					       
			        					        <h5 class="modal-title">' . $value['Name'] . ' ' . $value['Latest_Version'] . ' ( ' . $this->lang->line('Change Log') . ' )</h5>
			        					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										          <span aria-hidden="true">&times;</span>
										        </button>
			        					      </div>
			        					      <div class="modal-body">
			        					        ' . $value["changelog"] . '
			        					      </div>
			        					      <div class="modal-footer bg-whitesmoke br">
										        <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal"><i class="fas fa-remove"></i>' . $this->lang->line("Close") . '</button>
										      </div>
			        					    </div>
			        					  </div>
			        					</div> '; ?>


                    <!-- //check install.txt -->
                    <?php if ($value['addon_data']['installed'] == 0 and $value['addon_data']['downloaded'] == 1 and $value['addon_data']['code'] == 1) { ?>

                        <a title="<?php echo $this->lang->line("activate"); ?>"
                           class="btn btn-outline-primary activate_action" data-i='<?php echo $value['PID']; ?>'
                           data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>"
                           data-key="<?php echo $value['KEY']; ?>" href="#"
                           data-href="<?php echo $module_controller . '/activate'; ?>"><i
                                    class="fa fa-check"></i> <?php echo $this->lang->line('activate'); ?></a>

                    <?php }

                    if ($value['addon_data']['installed'] == 1 and $value['addon_data']['downloaded'] == 1 and $value['addon_data']['code'] == 1) { ?>

                        <a title="<?php echo $this->lang->line("deactivate"); ?>"
                           class="btn btn-outline-dark deactivate_action" href="#" data-i='<?php echo $value['PID']; ?>'
                           data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>"
                           data-key="<?php echo $value['KEY']; ?>"
                           data-href="<?php echo '/nvx_addon_manager/n_deactivate'; ?>"><i
                                    class="fa fa-ban"></i> <?php echo $this->lang->line('deactivate'); ?></a>

                    <?php }

                    echo $value['URL_Product'];

                    ?>
                    <!--

                                    //if exist install.txt then
                     -->

                    <!--                 <a title="<?php echo $this->lang->line("delete"); ?>" class="btn btn-outline-danger delete_action" href="#" data-i='<?php echo $value['PID']; ?>' data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>" data-key="<?php echo $value['KEY']; ?>" data-href="<?php echo $module_controller . '/delete'; ?>"><i class="fa fa-trash"></i> <?php echo $this->lang->line('delete'); ?></a> -->


                </div>

            </div>
            <?php


        }


        ?>


    </div>
</section>


<script>

    var base_url = "<?php echo base_url(); ?>";
    var is_demo = 0;
    $("document").ready(function () {

        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });


        $(".code_action").click(function (e) {
            e.preventDefault();
            var action = $(this).attr('data-href');
            var datai = $(this).attr('data-i');
            var base = $(this).attr('data-base');
            var key = $(this).attr('data-key');
            $("#href-action").val(action);
            $("#xid-action").val(datai);
            $("#base-action").val(base);
            $("#key-action").val(key);
            $(".put_add_on_title").html($("#get_add_on_title_" + datai).html());
            $("#activate_action_modal_refesh").val('0');
            $("#activate_action_modal").modal();
        });

        $('#activate_action_modal').on('hidden.bs.modal', function () {
            if ($("#activate_action_modal_refesh").val() == "1")
                location.reload();
        })

        $("#activate_submit").click(function () {
            if (is_demo == '1') {
                alertify.alert('<?php echo $this->lang->line("Alert");?>', 'Permission denied', function () {
                });
                return false;
            }
            $("#activate_submit").addClass('disabled');
            var action = base_url + 'nvx_addon_manager/purchase_code';
            var purchase_code = $("#purchase_code").val();
            var xid = $("#xid-action").val();
            var base = $("#base-action").val();
            var key = $("#key-action").val();

            $("#activate_action_modal_msg").removeClass('alert').removeClass('alert-success').removeClass('alert-danger');
            var loading = '<img src="' + base_url + 'assets/pre-loader/color/Preloader_9.gif" class="center-block" height="30" width="30">';
            $("#activate_action_modal_msg").html(loading);

            $.ajax({
                type: 'POST',
                url: action,
                data: {purchase_code: purchase_code, xid: xid, base: base, key: key},
                dataType: 'JSON',
                success: function (response) {
                    $("#activate_action_modal_msg").html('');

                    if (response.status == '1') {
                        swal('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                            .then((value) => {
                                location.reload();
                            });
                    } else {
                        swal('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                }
            });
        });


        $(".deactivate_action").click(function (e) {
            e.preventDefault();

            var action = base_url + $(this).attr('data-href');
            var xid = $(this).attr('data-i');
            var base = $(this).attr('data-base');
            var key = $(this).attr('data-key');
            var dir = $(this).attr('data-dir');

            swal({
                title: '<?php echo $this->lang->line("Deactive Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to deactive this add-on? Your add-on data will still remain."); ?>',
                icon: 'error',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: action,
                            data: {xid: xid, base: base, key: key, dir: dir},
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                                        .then((value) => {
                                            location.reload();
                                        });
                                } else {
                                    swal('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });


        $(".activate_action").click(function (e) {
            e.preventDefault();
            var action = base_url + $(this).attr('data-href');

            swal({
                title: '<?php echo $this->lang->line("Activate Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to activate this add-on?"); ?>',
                icon: 'success',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: action,
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                                        .then((value) => {
                                            location.reload();
                                        });
                                } else {
                                    swal('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });

        $("#iu_update_submit").click(function (e) {
            e.preventDefault();

            var action = base_url + 'nvx_addon_manager/install_update_nviews';
            var xid = $(this).attr('data-i');
            var dir = $(this).attr('data-dir');

            swal({
                title: '<?php echo $this->lang->line("Update Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you want to update this add-on?"); ?>',
                icon: 'success',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: action,
                            data: {xid: xid, dir: dir},
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                                        .then((value) => {
                                            location.reload();
                                        });
                                } else {
                                    swal('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });


        $(".update_action").click(function (e) {
            e.preventDefault();

            var action = base_url + 'nvx_addon_manager/update_script';
            var xid = $(this).attr('data-i');
            var dir = $(this).attr('data-dir');

            swal({
                title: '<?php echo $this->lang->line("Update Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you want to update this add-on?"); ?>',
                icon: 'success',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: action,
                            data: {xid: xid, dir: dir},
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                                        .then((value) => {
                                            location.reload();
                                        });
                                } else {
                                    swal('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });

        $(".update_nm_action").click(function (e) {
            e.preventDefault();

            var action = base_url + 'nvx_addon_manager/update_script_manager';
            var xid = $(this).attr('data-i');
            var dir = $(this).attr('data-dir');

            swal({
                title: '<?php echo $this->lang->line("Update Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you want to update this add-on?"); ?>',
                icon: 'success',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: action,
                            data: {xid: xid, dir: dir},
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                                        .then((value) => {
                                            location.reload();
                                        });
                                } else {
                                    swal('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });

        $(".activate_ntheme_action").click(function (e) {
            e.preventDefault();
            var action = base_url + 'nvx_addon_manager/n_theme_activate';

            swal({
                title: $(this).attr('data-title'),
                text: $(this).attr('data-text'),
                icon: 'success',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: action,
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                                        .then((value) => {
                                            location.reload();
                                        });
                                } else {
                                    swal('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });

        $(".download_action").click(function (e) {
            e.preventDefault();

            var action = base_url + 'nvx_addon_manager/download_script';
            var xid = $(this).attr('data-i');
            var dir = $(this).attr('data-dir');

            swal({
                title: '<?php echo $this->lang->line("Download Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you want to download this add-on?"); ?>',
                icon: 'success',
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: action,
                            data: {xid: xid, dir: dir},
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                                        .then((value) => {
                                            location.reload();
                                        });
                                } else {
                                    swal('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });


    });

    // $('.modal-dialog').parent().on('show.bs.modal', function(e){
    //     if($(this).attr('id')!="update_success"){
    //         console.log(e);
    //         console.log(e.relatedTarget.attributes);
    //         $(e.relatedTarget.attributes['data-target'].value).appendTo('body');
    //     }
    // })
</script>


<?php if (!empty($nviews['changelog'])) { ?>

    <!-- Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="changelog_<?php echo $nviews['PID']; ?>"
         data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $nviews['Name']; ?> <?php echo $nviews['Latest_Version']; ?>
                        ( <?php echo $this->lang->line('Change Log'); ?> )</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $nviews['changelog']; ?>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal"><i
                                class="fas fa-remove"></i> <?php echo $this->lang->line("Close"); ?></button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>


<div class="modal fade" tabindex="-1" role="dialog" id="activate_action_modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-check"></i> <?php echo $this->lang->line("activate"); ?> <span
                            class="put_add_on_title"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div id="activate_action_modal_msg" class="text-center"></div>
                <div class="form-group">
                    <label>
                        <?php echo $this->lang->line("add-on purchase code"); ?>
                    </label>
                    <input type="text" class="form-control" name="purchase_code" id="purchase_code">
                    <input type="hidden" id="href-action" value="">
                    <input type="hidden" id="xid-action" value="">
                    <input type="hidden" id="base-action" value="">
                    <input type="hidden" id="key-action" value="">
                    <input type="hidden" id="activate_action_modal_refesh" value="0">
                </div>

            </div>

            <div class="modal-footer bg-whitesmoke">
                <button type="button" id="activate_submit" class="btn btn-primary"><i
                            class="fa fa-check-circle"></i> <?php echo $this->lang->line("Activate"); ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fas fa-remove"></i> <?php echo $this->lang->line("Close"); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="iu_nviews_action_modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-check"></i> <?php echo $this->lang->line("Install/Update"); ?>
                    <span class="put_add_on_title"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $nviews['news']; ?>

                <div id="activate_action_modal_msg" class="text-center"></div>
                <div class="form-group">
                    <input type="hidden" id="href-action" value="">
                    <input type="hidden" id="xid-action" value="">
                    <input type="hidden" id="base-action" value="">
                    <input type="hidden" id="key-action" value="">
                    <input type="hidden" id="iu_nviews_action_modal_refresh" value="0">
                </div>

            </div>

            <div class="modal-footer bg-whitesmoke">
                <button type="button" id="iu_update_submit" class="btn btn-primary btn-lg"><i
                            class="fa fa-check-circle"></i> <?php echo $this->lang->line("Install/Update"); ?></button>
                <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal"><i
                            class="fas fa-remove"></i> <?php echo $this->lang->line("Close"); ?></button>
            </div>
        </div>
    </div>
</div>

<?php echo $modals_to_footer; ?>