<div class="tab-pane" id="admin_settings" role="tabpanel"
     aria-labelledby="admin_settings" aria-expanded="false">

    <div class="">

        <h4 class="card-title"><?php echo $this->lang->line('Admin settings'); ?></h4>

        <div class="card-body">

            <div class="row">

                <div class="col-12">
                    <p><?php echo $this->lang->line('Add Sandbox Token to User ID'); ?></p>
                </div>

                <div class="col-3">
                    <fieldset class="form-group">
                        <label for="admin_user_id"><?php echo $this->lang->line('User ID'); ?></label>
                        <input type="text" class="form-control admin_user_id"
                               name="admin_user_id" id="admin_user_id"
                               placeholder="<?php echo $this->lang->line('user id'); ?>">
                    </fieldset>
                </div>

                <div class="col-8">
                    <fieldset class="form-group">
                        <label for="admin_user_token"><?php echo $this->lang->line('User Token'); ?></label>
                        <input type="text" class="form-control admin_user_token"
                               name="admin_user_token" id="admin_user_token"
                               placeholder="<?php echo $this->lang->line('user token'); ?>">
                    </fieldset>
                </div>

                <div class="col-1">
                    <button class="btn btn-primary mt-2" id="admin_add_token"><i
                                class="bx bx-plus"></i></button>

                </div>

            </div>

            <div class="row">
                <div class="12">
                    <p><?php echo $this->lang->line('Server Settings'); ?></p>

                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line('Settings'); ?></th>
                                <th><?php echo $this->lang->line('Current'); ?></th>
                                <th><?php echo $this->lang->line('Test new value'); ?></th>
                                <th><?php echo $this->lang->line('Recommend'); ?></th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td class="text-bold-500">PHP safe_mode</td>
                                <td><?php echo ini_get('safe_mode'); ?></td>
                                <td><?php echo $this->lang->line('Cant change via code'); ?></td>
                                <td><?php echo $this->lang->line('OFF'); ?>
                                    (<?php echo $this->lang->line('important'); ?>)
                                </td>
                            </tr>

                            <tr>
                                <td class="text-bold-500">PHP max_execution_time</td>
                                <td><?php echo ini_get('max_execution_time'); ?></td>
                                <td><?php
                                    set_time_limit(0);
                                    ini_set("max_execution_time", 0);
                                    echo ini_get('max_execution_time'); ?></td>
                                <td>60 (<?php echo $this->lang->line('recommend'); ?>)
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <form action="<?php echo base_url("n_adsmanager/?action=admin_save_settings"); ?>" method="POST">
                <input type="hidden" name="csrf_token" id="csrf_token"
                       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">


            <div class="row mt-2">
                <div class="col-12">
                    <h4><?php echo $this->lang->line('Admin Settings'); ?></h4>
                </div>

                <div class="col-6">
                    <fieldset class="form-group">
                        <label for="ads_image_size"><?php echo $this->lang->line('Maximum file size for image upload'); ?></label>
                        <input type="text" class="form-control"
                               name="ads_image_size" id="ads_image_size" value="<?php echo $n_ad_config['ads_image_size']; ?>"
                               placeholder="<?php echo $this->lang->line('Maximum file size for image upload (MB)'); ?>">
                    </fieldset>
                </div>

                <div class="col-6">
                    <fieldset class="form-group">
                        <label for="ads_video_size"><?php echo $this->lang->line('Maximum file size for video upload. 0 = disabled video views ads. (MB)'); ?></label>
                        <input type="text" class="form-control"
                               name="ads_video_size" id="ads_video_size" value="<?php echo $n_ad_config['ads_video_size']; ?>"
                               placeholder="<?php echo $this->lang->line('Maximum file size for video upload'); ?>">
                    </fieldset>
                </div>


                <div class="col-12">
                    <button class="btn btn-primary mt-2"><i
                                class="bx bx-save"></i> <?php echo $this->lang->line('Save'); ?></button>

                </div>


            </div>

            </form>

        </div>

    </div>

</div>