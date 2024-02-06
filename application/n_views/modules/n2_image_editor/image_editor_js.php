<script>


    // $('body').append('<div id="fullscreen_ie"></div>');
    // $('#fullscreen_ie').hide();
    var fullscreen = 0;

    $("#fullscreen_switch").click(function (e) {
        e.preventDefault();
        $("#editormain").toggleClass("fullscreen_ie");

        // Toggle menu
        $.app.menu.toggle()

        setTimeout(function () {
            $(window).trigger("resize")
        }, 200)

        if ($("#collapsed-sidebar").length > 0) {
            setTimeout(function () {
                if ($body.hasClass("menu-expanded") || $body.hasClass("menu-open")) {
                    $("#collapsed-sidebar").prop("checked", false)
                } else {
                    $("#collapsed-sidebar").prop("checked", true)
                }
            }, 1000)
        }

        // Hides dropdown on click of menu toggle
        // $('[data-toggle="dropdown"]').dropdown('hide');

        // Hides collapse dropdown on click of menu toggle
        if (
            $(
                ".vertical-overlay-menu .navbar-with-menu .navbar-container .navbar-collapse"
            ).hasClass("show")
        ) {
            $(
                ".vertical-overlay-menu .navbar-with-menu .navbar-container .navbar-collapse"
            ).removeClass("show")
        }

        return false

    });

</script>