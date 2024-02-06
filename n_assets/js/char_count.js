$("document").ready(function() {
    var $html = $("html")
    var $body = $("body")
    var $danger = "#FF5B5C"
    var $primary = "#5A8DEE"
    var $primary_lighten = "#e7edf3"
    var $warning = "#FDAC41"
    var $textcolor = "#304156"

    function checkTextAreaMaxLengthCustom(textBox, e) {
        var maxLength = parseInt($(textBox).data("length"));

        if (!checkSpecialKeys(e)) {
            //TODO: substring
           // if ($(textBox).text().length < maxLength - 1)
                //$(textBox).text($(textBox).text().substring(0, maxLength));
        }
        $(".char-count").html($(textBox).text().length)

        if ($(textBox).text().length > maxLength) {
            $(".counter-value").css("background-color", $danger)
            $(".char-textarea2").css("color", $danger)
            // to change text color after limit is maxedout out
            $(".char-textarea2").addClass("max-limit")
        } else {
            $(".counter-value").css("background-color", $primary)
            $(".char-textarea2").css("color", $textcolor)
            $(".char-textarea2").removeClass("max-limit")
        }

        return true
    }

    function checkSpecialKeys(e) {
        if (
            e.keyCode != 8 &&
            e.keyCode != 46 &&
            e.keyCode != 37 &&
            e.keyCode != 38 &&
            e.keyCode != 39 &&
            e.keyCode != 40
        )
            return false
        else return true
    }

    $(document).on('keyup','.emojionearea-editor',function(){
        checkTextAreaMaxLengthCustom(this, event)
        // to later change text color in dark layout
        // $(this).addClass("active")
    });


});

