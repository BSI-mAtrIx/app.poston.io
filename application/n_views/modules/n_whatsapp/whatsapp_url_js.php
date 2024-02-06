<script src="<?= base_url() ?>plugins/nqr/qrcode.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
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