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


<div class="section-body row">

    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h4><?php echo $this->lang->line('Provide data for generate link'); ?></h4>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <input type="text" name="number_phone" id="number_phone" class="form-control"
                           placeholder="<?php echo $this->lang->line('What\'s your phone number?'); ?>"/>
                    <p><?php echo $this->lang->line('Make sure you include the country code followed by the area code. E.g.1 for the US, 44 for the UK.'); ?></p>
                </div>

                <div class="form-group">
                    <input type="text" name="message" id="message" class="form-control"
                           placeholder="<?php echo $this->lang->line('What message do you want your customers to see when they contact you?'); ?>"/>
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary" id="save-btn" onclick="get_button_data()">
                    <i class="bx bx-magic-wand"></i>
                    <?php echo $this->lang->line('Generate link'); ?>
                </button>
            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card" id="info">

            <div class="card-header">
                <h4><?php echo $this->lang->line('Create Your Link'); ?></h4>
            </div>
            <div class="card-body">
                <p><?php echo $this->lang->line("Get your customer's phone number and make the most of WhatsApp Marketing by establishing a more fluid communication with them!"); ?></p>
            </div>
        </div>


        <div class="card" id="generated" style="display:none;">
            <div class="card-header">
                <h4><?php echo $this->lang->line('Generated link and QR'); ?></h4>
            </div>
            <div class="card-body">


                <div class="input-group">
                    <input class="form-control" id="your_link" placeholder="..." readonly="" type="text" disabled>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button" onclick="copyToClipboard('input#your_link')">
                            <span class="bx bx-copy"></span>
                            <?php echo $this->lang->line('Copy Link'); ?>
                        </button>
                    </span>
                </div>

                <!--
 <p><?php echo $this->lang->line('Embed this widget on your site'); ?><br /><span><?php echo $this->lang->line('You only need to paste this piece of code'); ?></span></p>
                <textarea class="form-control name_list" id="iframe" style="height: 146px!important;margin-bottom: 24px;" disabled></textarea>
 -->
            </div>

            <div class="card-footer">
                <p><?php echo $this->lang->line('QR Code'); ?>:</p>
                <div id="qrcode"></div>
            </div>
        </div>

    </div>

</div>



