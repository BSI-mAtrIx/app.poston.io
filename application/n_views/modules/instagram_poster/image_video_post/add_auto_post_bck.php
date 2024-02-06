<?php
    $upload_js=true;
	$image_upload_limit = 1; 
	if($this->config->item('facebook_poster_image_upload_limit') != '')
	$image_upload_limit = $this->config->item('facebook_poster_image_upload_limit'); 
	
	$video_upload_limit = 10; 
	if($this->config->item('facebook_poster_video_upload_limit') != '')
	$video_upload_limit = $this->config->item('facebook_poster_video_upload_limit');
	
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>n_assets/css/emojionearea.min.css" media="screen">
<link href="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.css?ver=<?php echo $n_config['theme_version']; ?>" rel="stylesheet" type="text/css" />



<style type="text/css">
	.colmid{padding-left: 0px;}
	.full-documentation{cursor: pointer;}
	.input-group-prepend{margin-left:-1px;}
	.input-group-text{background: #eee;}
	.card-body #post_tab_content { border:solid 1px #dee2e6;border-top:0 !important;padding:25px 20px; }
    video{width:100%!important;}
</style>


<?php
 	if($this->session->userdata("user_type")=="Admin" || in_array(74,$this->module_access)) $like_comment_Share_reply_block_class="";
 	else $like_comment_Share_reply_block_class="hidden";
?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url("instagram_poster"); ?>"><?php echo $this->lang->line("Instagram Poster"); ?></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

	
	<div class="section-body">
		<div class="row">
			<div class="col-12 col-md-7">
				<div class="card main_card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Campaign Form'); ?></h4>
                    </div>
		          	<div class="card-body nav-tabs-centered">
			          	<!-- tab body started -->
                        <ul class="nav nav-tabs justify-content-center mb-0 pb-0" role="tablist">

                            <li class="nav-item">
                                <a id="image_post" class="nav-link post_type active" data-toggle="tab" href="#imagePost" role="tab" aria-selected="true">
                                    <i class="bx bx-image align-middle"></i>
                                    <span class="align-middle"><?php echo $this->lang->line("Image"); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a id="video_post" class="nav-link post_type" data-toggle="tab" href="#videoPost" role="tab" aria-selected="false">
                                    <i class="bx bx-video align-middle"></i>
                                    <span class="align-middle"><?php echo $this->lang->line("Video"); ?></span>
                                </a>
                            </li>
                        </ul>
			          	<div class="tab-content" id="post_tab_content">
							<form action="#" enctype="multipart/form-data" id="auto_poster_form" method="post">

                                <label for="campaign_name"><?php echo $this->lang->line('Campaign Name');?></label>
                                <fieldset class="form-group position-relative has-icon-left">
                                    <input name="campaign_name" id="campaign_name"
                                           class="form-control" type="text" placeholder="<?php echo $this->lang->line('Campaign Name');?>">
                                    <div class="form-control-position">
                                        <i class="bx bxs-compass"></i>
                                    </div>
                                    <span class="text-danger"><?php echo form_error('campaign_name'); ?></span>
                                </fieldset>

                                <label for="message"><?php echo $this->lang->line('Caption'); ?> <a href="#" data-placement="right"  data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("caption") ?>" data-content="<?php echo $this->lang->line("support Spintax"); ?>, Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"><i class='bx bx-info-circle'></i> </a></label>
                                <fieldset class="form-label-group mb-0">
                                    <textarea data-length=2500 name="message" class="form-control char-textarea2" id="message" placeholder="<?php echo $this->lang->line('Type your message here...');?>"></textarea>

                                </fieldset>
                                <small class="counter-value float-right"><span class="char-count">0</span> / 2500 </small>


                                <div id="image_block">
                                    <label for="image_url" class="mt-1"><?php echo $this->lang->line('Image URL');?> <a href="#" data-placement="right"  data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("Supported Format") ?>" data-content="<?php echo $this->lang->line("JPEG is the only image format supported. Extended JPEG formats such as MPO and JPS are not supported. The image's aspect ratio must falls withing a 4:5 to 1.91:1 range"); ?>"><i class='bx bx-info-circle'></i> </a></label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input name="image_url" id="image_url"
                                               class="form-control" type="text" placeholder="<?php echo $this->lang->line('Image URL');?>">
                                        <div class="form-control-position">
                                            <i class="bx bx-image"></i>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('image_url'); ?></span>
                                    </fieldset>
                                    <div class="form-group">
                                        <div id="image_url_upload"><?php echo $this->lang->line('Upload');?></div>
                                    </div>
                                </div>



								<div id="video_block">
                                    <label for="video_url" class="mt-1"><?php echo $this->lang->line('Video URL');?> <a href="#" class="video_format_info"><i class='bx bx-info-circle'></i> </a></label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input name="video_url" id="video_url"
                                               class="form-control" type="text" placeholder="<?php echo $this->lang->line('Image URL');?>">
                                        <div class="form-control-position">
                                            <i class="bx bx-image"></i>
                                        </div>
                                        <span class="text-danger"><?php echo form_error('video_url'); ?></span>
                                    </fieldset>
                                    <div class="form-group">
                                        <div id="video_url_upload"><?php echo $this->lang->line('Upload');?></div>
                                    </div>
								</div>

								<div class="row">
									<div class="col-12 col-md-6">
                                        <label for="post_to_pages"><?php echo $this->lang->line("Post to Instagram Accounts");?>
                                            <a href="#" data-placement="right" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("Select Account"); ?>" data-content="<?php echo $this->lang->line("Select the account you want to post. You can select multiple account to post."); ?>"><i class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <div class="form-group">

											<select multiple="multiple" class="select2 form-control  " id="post_to_pages" name="post_to_pages[]" style="width:100%;">
											<?php
												foreach($account_list as $key=>$val)
												{
													$id=$val['id'];
													$insta_username=$val['insta_username'];
													echo "<option value='{$id}'>{$insta_username}</option>";
												}
											 ?>
											</select>
										</div>
									</div>

									<div class="col-12 col-md-6">
                                        <fieldset>
                                            <p class="label_cust"><?php echo $this->lang->line("Posting Time") ?> <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="<?php echo $this->lang->line("Posting Time") ?>" data-content="<?php echo $this->lang->line("If you schedule a campaign, system will automatically process this campaign at mentioned time and time zone. Schduled campaign may take upto 1 hour longer than your schedule time depending on server's processing.") ?>"><i class='bx bx-info-circle'></i> </a></p>
                                            <div class="checkbox">
                                                <input type="checkbox" name="schedule_type" id="schedule_type" value="now" class="checkbox-input" checked>
                                                <label for="schedule_type"><?php echo $this->lang->line('Post Now');?></label>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('schedule_type'); ?></span>
                                        </fieldset>
									</div>
								</div>	

								<div class="row">
									<div class="schedule_block_item col-12 col-md-6">
                                        <label for="schedule_time"><?php echo $this->lang->line('Schedule time'); ?></label>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input name="schedule_time" id="schedule_time"
                                                   class="form-control datepicker_x" type="text" placeholder="<?php echo $this->lang->line('Schedule time'); ?>">
                                            <div class="form-control-position">
                                                <i class="bx bx-time"></i>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('schedule_time'); ?></span>
                                        </fieldset>
									</div>

									<div class="schedule_block_item col-12 col-md-6">
                                        <label for="time_zone"><?php echo $this->lang->line('Time zone'); ?></label>
										<div class="form-group">
											<?php
											$time_zone[''] =$this->lang->line('Please Select');
											echo form_dropdown('time_zone',$time_zone,$this->config->item('time_zone'),' class="form-control select2" id="time_zone" required');
											?>
										</div>
									</div>

									<div class=" schedule_block_item col-12 col-md-6">
										<div class="input-group">
                                            <label for="repeat_times"><?php echo $this->lang->line('repost this post'); ?></label>
                                            <fieldset>
                                                <div class="input-group">
                                                    <input type="number" name="repeat_times" id="repeat_times" class="form-control" placeholder="<?php echo $this->lang->line('repost this post'); ?>" aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2"><?php echo $this->lang->line('Times'); ?></span>
                                                    </div>
                                                </div>
                                            </fieldset>
										</div>
									  	
									</div>
									<div class="col-12 col-md-6">
										<div class="schedule_block_item">
                                            <label for="time_interval"><?php echo $this->lang->line('time interval'); ?></label>
											<div class="form-group">
												<?php
													$time_interval[''] = $this->lang->line('Please Select Periodic Time Schedule');
													echo form_dropdown('time_interval',$time_interval,set_value('time_interval'),' class="form-control select2" id="time_interval" required style="width:100%;"');
												?>
											</div>
										</div>
									</div>
								</div>
								
								<div class="clearfix"></div>

								<div class="card-footer p-0">
									<input type="hidden" name="submit_post_hidden" id="submit_post_hidden" value="image_submit">
									<button class="btn btn-primary" submit_type="image_submit" id="submit_post" name="submit_post" type="button"><i class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Create Campaign") ?> </button>
									<a class="btn btn-light float-right" onclick='goBack("instagram_poster/image_video",0)'><i class="bx bx-time"></i> <?php echo $this->lang->line("Cancel") ?> </a>
								</div>

							</form>
						</div>
			        </div>
	          	</div>          
	        </div>
			<!-- preview section -->
			<div class="col-12 col-md-5 colmid d-none d-sm-block">
				<div class="card main_card">

                    <div class="card-header">
                        <h4 class="card-title d-flex align-items-center">
                            <?php echo $this->lang->line('Preview'); ?>
                        </h4>
                    </div>
		          	<div class="card-body">
                        <p class="text-info">
                            <?php echo $this->lang->line('This preview may differ with actual post.'); ?>
                        </p>
                        <?php $profile_picture=(isset($account_list[0]['page_profile']) && $account_list[0]['page_profile']!="")?$account_list[0]['page_profile']:base_url('assets/img/avatar/avatar-1.png'); ?>
                        <div class="preview-instagram preview-instagram-photo item-post-type" data-type="media" style="">
                            <div class="preview-content">
                                <div class="user-info">
                                    <img class="round" src="<?php echo $profile_picture;?>" alt="avatar">
                                    <span><?php echo isset($account_list[0]['insta_username'])?$account_list[0]['insta_username']:"Username";?></span>
                                </div>
                                <div class="preview-media preview_only_img_block" data-max-image="1">
                                    <img src="<?php echo base_url('n_assets/img/placeholder.png');?>" class="only_preview_img" alt="No Image Preview">
                                </div>
                                <div class="preview-media preview_video_block">
                                    <video controls="" width="100%" poster="" style="border:1px solid #ccc"><source  src=""></source></video>
                                    <br/>
                                    <div class="video_preview_og_info_desc inline-block">
                                    </div>
                                </div>

                                <div class="post-info">
                                    <div class="info-active pull-left"> Be the first to Like this <span class="float-right">1s</span></div>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="caption pt0 preview_message">
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text"></div>
                                    <div class="line-no-text w50"></div>
                                </div>
                                <div class="preview-comment">
                                    <i class="bx bx-heart"></i>
                                    Add a comment
                                    <i class="bx bx-dots-horizontal-rounded float-right"></i>
                                </div>
                            </div>
                        </div>



		          	</div>          
		        </div>
			</div>
		</div>
	</div>



<div class="modal fade" id="response_modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i></button>
				<h4 class="modal-title"><?php echo $this->lang->line('Auto Post Campaign Status'); ?></h4>
			</div>
			<div class="modal-body">
				<div class="alert text-center" id="response_modal_content">

				</div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo $this->lang->line("Close") ?></span>
                </button>
            </div>

        </div>
	</div>
</div>



<style type="text/css" media="screen">
	.padding-5{padding:5px;}
	.padding-20{padding:20px;}
	.box-body,.box-footer{padding:20px;}
	.box-header{padding-left: 20px;}
	.preview
	{
		font-family: helvetica,arial,sans-serif;
		padding: 20px;
	}
	/*.preLoader{ margin-bottom:30px !important; }*/
	.preview_cover_img
	{
		width:45px;
		height:45px;
		border: .5px solid #ccc;
	}
	.preview_page
	{
		padding-left: 7px;
		color: #365899;
		font-weight: 700;
		font-size: 14px;
		cursor: pointer;
	}
	.preview_page_sm
	{
		padding-left: 7px;
		padding-top: 7px;
		color: #9197a3;
		font-size: 13px;
		font-weight: 300;
		cursor: pointer;
	}
	.preview_img
	{
		width:100%;
		border: 1px solid #ccc;
		border-bottom: none;
		cursor: pointer;
	}
	.only_preview_img
	{
		width:100%;
		border: 1px solid #ccc;
		cursor: pointer;
	}
	.demo_preview
	{
		width:100%;
		/*border: 1px solid #f5f5f5; */
		cursor: pointer;
	}
	.preview_og_info
	{
		border: 1px solid #ccc;
		
		padding: 10px;
		cursor: pointer;

	}
	.preview_og_info_title
	{
		font-size: 23px;
		font-weight: 400;
		font-family: 'Times New Roman',helvetica,arial;

	}
	.preview_og_info_desc
	{
		margin-top: 5px;
		font-size: 13px;
	}
	.preview_og_info_link
	{
		text-transform: uppercase;
		color: #9197a3;
		margin-top: 7px;
	}


	.ms-choice span
	{
		padding-top: 2px !important;
	}
	.hidden
	{
		display: none;
	}
	.box-primary
	{
		-webkit-box-shadow: 0px 2px 14px -5px rgba(0,0,0,0.75);
		-moz-box-shadow: 0px 2px 14px -5px rgba(0,0,0,0.75);
		box-shadow: 0px 2px 14px -5px rgba(0,0,0,0.75);
	}
	.ajax-upload-dragdrop{width:100% !important;}
</style>


<div class="modal fade" id="video_format_info_modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo $this->lang->line('Video Requirements'); ?></h4>
				<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i></button>
			</div>
			<div class="modal-body">
				<p>Videos must meet the following specifications:</p>
				<br/>
				<ul>
					<li><b>Container:</b> MOV or MP4 (MPEG-4 Part 14), no edit lists, moov atom at the front of the file.</li>
					<li><b>Audio codec:</b> AAC, 48khz sample rate maximum, 1 or 2 channels (mono or stereo).</li>
					<li><b>Video codec:</b> HEVC or H264, progressive scan, closed GOP, 4:2:0 chroma subsampling.</li>
					<li><b>Frame rate:</b> 23-60 FPS.</li>
					<li><b>Picture size:</b>
						<ul>
							<li>Maximum columns (horizontal pixels): 1920</li>
							<li>Minimum aspect ratio [cols / rows]: 4 / 5</li>
							<li>Maximum aspect ratio [cols / rows]: 16 / 9</li>
						</ul>
					</li>
					<li><b>Video bitrate:</b> VBR, 5Mbps maximum</li>
					<li><b>Audio bitrate:</b> 128kbps</li>
					<li><b>Duration:</b> 60 seconds maximum, 3 seconds minimum</li>
					<li><b>File size:</b> 100MB maximum</li>
				</ul>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo $this->lang->line("Close") ?></span>
                </button>
            </div>

        </div>
	</div>
</div>