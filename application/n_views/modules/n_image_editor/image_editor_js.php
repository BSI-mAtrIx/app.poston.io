<script>

    var fullscreen = 0;

    jQuery("#fullscreen_switch").click(function (e) {
        e.preventDefault();
        jQuery("#editormain").toggleClass("fullscreen_ie");

        if ($('body').hasClass('menu-expanded') == true) {
            jQuery.app.menu.toggle()
        }

        setTimeout(function () {
            jQuery(window).trigger("resize")
        }, 200)

        return false

    });

</script>

