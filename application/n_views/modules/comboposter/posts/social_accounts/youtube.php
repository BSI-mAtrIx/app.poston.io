<?php
//TODO: new feature file to change
<!--
                                    <?php if($this->session->userdata('user_type') == 'Admin' || in_array(33,$this->module_access)) : ?>
                            <div role="tabpanel" class="tab-pane card" id="bxl-youtube" aria-labelledby="brand"  aria-expanded="true">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Youtube Channels'); ?></h4>
                                    <div class="heading-elements" style="top:13px;">
                                        <?php echo $youtube_login_button; ?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <tbody>
                                                <?php foreach ($youtube_channel_list as $key => $single_account): ?>
                                                    <?php $img_src = $single_account['profile_image']; ?>
                                                    <tr>
                                                        <td class="width-15-per p-0">
                                                            <div class="avatar bg-rgba-primary p-25 ml-0">
                                                                <img class="img-fluid" src="<?php echo $img_src; ?>" alt="img placeholder" height="70" width="70">
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <div>
                                                                <h5 class="font-small-3 bold"><?php echo $single_account['name']; ?> ( @<?php echo $single_account['screen_name'] ?> )</h5>
                                                                <div class="font-small-2"><?php echo $this->lang->line('Videos'); ?>: <?php echo $single_account['video_count']; ?></div>
                                                                <div class="font-small-2"><?php echo $this->lang->line('Subscribers'); ?>: <?php echo $single_account['subscriber_count']; ?></div>
                                                            </div>
                                                        </td>
                                                        <td class="width-40-per ">
                                                            <div class="float-right">
                                                                <a style="margin-top:10px;margin-right:5px;" href="#" class="btn-circle btn btn-outline-danger delete_account" table_id="<?php echo $single_account['id']; ?>" title="<?php echo $this->lang->line("Delete Account"); ?>" data-placement="left" data-toggle="tooltip">
                                                                    <i class="bx bx-trash-alt"></i>
                                                                </a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                                </tbody>
                                            </table>
                                        </div>




                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                                    -->

<div class="card">
  <div class="card-header" style="border:.5px solid #ececec;border-bottom: none;">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input youtube_all_channel_select" id="youtube_all_channel_select" >
      <label class="mb-3 custom-control-label" for="youtube_all_channel_select" title="<?php echo $this->lang->line("Select all"); ?>"></label>
    </div>
    <div class="pl-3 mt-1">
      <h4 class="d-inline"><i class="bx bxl-youtube-square" style="font-size: 14px;"></i> <?php echo $this->lang->line("Youtube"); ?></h4>
    </div>
  </div>
  <div class="card-body makeScroll_1 account_div_height" style="border:.5px solid #ececec;">
    <ul class="list-unstyled list-unstyled-border">
        
        <?php $i = 0; ?>
        <?php foreach ($youtube_account_list as $single_account): ?>

          <li class="media">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" name="youtube_channel_list[]" class="custom-control-input youtube_single_channel" id="youtube_single_channel-<?php echo $i; ?>" value="youtube_channel_list-<?php echo $single_account['channel_id'] ?>"  <?php 
                   if (($post_action == 'edit' || $post_action == 'clone') && count($campaigns_social_media) > 0) {
                       $temp = "youtube_channel_list-" . $single_account['channel_id'];
                       if (in_array($temp, $campaigns_social_media)) {
                         echo "checked";
                       }
                   }
                ?> >
                <label class="mb-2 custom-control-label" for="youtube_single_channel-<?php echo $i; ?>"></label>
              </div>
              <img class="mr-3 rounded-circle" width="50" src="<?php echo $single_account['profile_image']; ?>" alt="avatar">
              <div class="media-body">
                  <div class="accounts_details_collapse pointer">
                      <h6 class="media-title"><?php echo $single_account['title']; ?></h6>
                      <div class="text-small text-muted"><?php echo $single_account['channel_id']; ?></div>
                  </div>
              </div>
              

          </li>
          
          <?php $i++; ?>
        <?php endforeach ?>

    </ul>
  </div>
</div>
