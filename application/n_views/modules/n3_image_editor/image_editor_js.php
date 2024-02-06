<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/3.6.0/fabric.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script type="text/javascript"
        src="https://uicdn.toast.com/tui.code-snippet/v1.5.0/tui-code-snippet.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script type="text/javascript"
        src="https://uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script type="text/javascript"
        src="<?= base_url() ?>plugins/tui/dist/tui-image-editor.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script type="text/javascript"
        src="<?= base_url() ?>plugins/tui/examples/js/theme/white-theme.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script type="text/javascript"
        src="<?= base_url() ?>plugins/tui/examples/js/theme/black-theme.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script>
    // Image editor
    var imageEditor = new tui.ImageEditor('#tui-image-editor-container', {
        includeUI: {
            loadImage: {
                path: '<?= base_url() ?>plugins/tui/examples/img/sampleImage2.png',
                name: 'SampleImage'
            },
            //locale: locale_ru_RU,
            theme: blackTheme, // or whiteTheme
            initMenu: 'filter',
            menuBarPosition: 'top'
        },
        cssMaxWidth: 700,
        cssMaxHeight: 1000,
        usageStatistics: false
    });
    window.onresize = function () {
        imageEditor.ui.resizeEditor();
    }


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

