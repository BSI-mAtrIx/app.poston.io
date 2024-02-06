<section class="section section_custom">
    <div class="section-header">
        <h1><i class="fa fa-search-location"></i> <?php echo $page_title; ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a
                        href="<?php echo base_url('n_whatsapp'); ?>"><?php echo $this->lang->line('whatsapp_link'); ?></a>
            </div>
            <div class="breadcrumb-item"><?php echo $page_title; ?></div>
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
                    <button class="btn btn-primary btn-lg" id="save-btn" onclick="get_button_data()">
                        <i class="fas fa-magic"></i>
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
                        <button class="btn btn-primary btn-lg" type="button"
                                onclick="copyToClipboard('input#your_link')">
                            <span class="fa fa-copy"></span>
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


</section>


<script src="<?= base_url() ?>plugins/nqr/qrcode.js"></script>
<script type="text/javascript">


    var get_button_data = function (button) {

        var message = $("#message").val();
        var phone = $("#number_phone").val();
        message = message.replaceAll(' ', '%20');
        var link = 'https://api.whatsapp.com/send?phone=' + phone + '&text=' + message;

        $('#qrcode').html('');

        new QRCode("qrcode", link);

        // qrcode.stringToBytes = qrcode.stringToBytesFuncs['UTF-8'];
        //
        // var QR_CODE = qrcode(0, 'M');
        // QR_CODE.addData(link, 'Byte');
        // QR_CODE.make();
        // $('#qrcode').html(QR_CODE.createImgTag(5));

        $('#your_link').val(link);
        $('#iframe').html('<iframe src="' + link + '" style="border:0px #ffffff none;" name="postcron" scrolling="no" frameborder="1" marginheight="0px" marginwidth="0px" height="800px" width="400px" allowfullscreen></iframe>');

        $('#info').hide();
        $('#generated').show();

    }

    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).val()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>