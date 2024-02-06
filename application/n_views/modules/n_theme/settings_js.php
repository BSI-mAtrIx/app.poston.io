<link rel="stylesheet" type="text/css"
      href="<?php echo base_url(); ?>n_assets/js/spectrum/spectrum.min.css?ver=<?php echo $n_config['theme_version']; ?>"/>
<script src="<?php echo base_url(); ?>n_assets/js/spectrum/spectrum.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script>
    // main menu active gradient colors object
    var themeColor = {
        "theme-primary": "rgba(90, 141, 238, 0.2)",
        "theme-success": "rgba(57, 218, 138, 0.2)",
        "theme-danger": "rgba(255, 91, 92, 0.2)",
        "theme-info": "rgba(0, 207, 221, 0.2)",
        "theme-warning": "rgba(253, 172, 65, 0.2)",
        "theme-dark": "rgba(57, 76, 98, 0.2)",
    };
    // main menu active box shadow object
    var themeBoxShadow = {
        "theme-primary": "0 0 10px 1px rgba(90, 141, 238, 0.2)",
        "theme-success": "0 0 10px 1px rgba(57, 218, 138, 0.2)",
        "theme-danger": "0 0 10px 1px rgba(255, 91, 92, 0.2)",
        "theme-info": "0 0 10px 1px rgba(0, 207, 221, 0.2)",
        "theme-warning": "0 0 10px 1px rgba(253, 172, 65, 0.2)",
        "theme-dark": "0 0 10px 1px rgba(57, 76, 98, 0.2)",
    };
    var currentColor = {
        "theme-default": "#FFFFFF",
        "theme-primary": "#5A8DEE",
        "theme-success": "#39DA8A",
        "theme-danger": "#FF5B5C",
        "theme-info": "#00CFDD",
        "theme-warning": "#FDAC41",
        "theme-dark": "#394C62",
    };
    var LogoPosition = {
        "theme-primary": "-65px -54px",
        "theme-success": "-120px -10px",
        "theme-danger": "-10px -10px",
        "theme-info": "-10px -54px",
        "theme-warning": "-120px -54px",
        "theme-dark": "-65px -10px",
    };
    var body = $("body"),
        mainMenu = $(".main-menu"),
        mainMenuContent = $(".menu-content"),
        footer = $(".footer"),
        navbar = $(".header-navbar"),
        mainHeaderNavbar = $(".main-header-navbar"),
        navBarShadow = $(".header-navbar-shadow"),
        toggleIcon = $(".toggle-icon"),
        collapseSidebar = $("#collapse-sidebar-switch"),
        iconAnimation = $("#icon-animation-switch"),
        customizer = $(".customizer");


    $(document).on("click", "#customizer-theme-colors .color-box", function () {
        var $this = $(this);
        $this.siblings().removeClass("selected");
        $this.addClass("selected");
        var selectedColor = $(this).data("color"),
            changeColor = themeColor[selectedColor],
            selectedShadow = themeBoxShadow[selectedColor],
            selectedTextColor = currentColor[selectedColor],
            selectedLogo = LogoPosition[selectedColor];

        // Update livicon colors
        function updateLivicon(el) {
            el.updateLiviconEvo({
                strokeColor: selectedTextColor,
                solidColor: selectedTextColor,
                fillColor: selectedTextColor,
                strokeColorAlt: selectedTextColor,
            });
        }

        // main-menu
        if (mainMenuContent.find("li.active").length) {
            mainMenuContent.find("li.active a").css({
                color: selectedTextColor,
            });
            mainMenuContent.find("li.active a > i").css({
                color: selectedTextColor,
            });
            mainMenuContent.find("li.active a span.menu-item").css({
                color: selectedTextColor,
            });
            mainMenuContent.find("li.active").css({
                background: changeColor,
                "border-color": selectedTextColor,
            });
            // Update Active Menu item Icon with active color
            if ($("li.sidebar-group-active .menu-livicon").length) {
                updateLivicon($("li.sidebar-group-active .menu-livicon"));
            }
        } else {
            mainMenu.find(".nav-item.active a").css({
                background: changeColor,
                color: selectedTextColor,
            });
            mainMenu.find(".nav-item.active a .menu-title").css({
                color: selectedTextColor,
            });
            // Update Active Menu item Icon with active color
            if ($(".nav-item.active .menu-livicon").length) {
                updateLivicon($(".nav-item.active .menu-livicon"));
            }
        }
    });

    $("#customizer-navbar-colors .color-box").on("click", function () {
        var $this = $(this);
        $this.siblings().removeClass("selected");
        $this.addClass("selected");
        var navbarColor = $this.data("navbar-color");
        if ($(body).hasClass("vertical-layout")) {
            if ($(window).scrollTop() > 20) {
// changes navbar colors
                if (navbarColor) {
                    $(".vertical-layout")
                        .find(navbar)
                        .removeClass(
                            "bg-primary bg-success bg-danger bg-info bg-warning bg-dark navbar-light"
                        )
                        .addClass(navbarColor + " navbar-dark");
                } else {
                    $(".vertical-layout.navbar-sticky")
                        .find(navbar)
                        .addClass("navbar-light")
                        .removeClass("navbar-dark")
                        .removeClass(
                            "bg-primary bg-success bg-danger bg-info bg-warning bg-white bg-dark navbar-dark"
                        );
                }
                if (body.hasClass("dark-layout")) {
                    navbar.addClass("navbar-dark");
                }
            }
        } else {
            if (navbarColor) {
                $(".horizontal-layout")
                    .find(".navbar-with-menu")
                    .removeClass(
                        "bg-primary bg-success bg-danger bg-info bg-warning bg-dark"
                    )
                    .addClass(navbarColor);
            }
        }

    });

    $('#pwa_theme_color').spectrum();
    $('#pwa_background_color').spectrum();

    $('#colors_in input').spectrum();


    $(document).on('click', '#enable_paymongo_webhook', function (e) {
        $.ajax({
            type: 'POST',
            url: base_url + "n_paymongo/enable_webhook",
            dataType: 'JSON',
            success: function (response) {
                if (response.status == '1') {
                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                } else {
                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                }
            }
        });
    });
</script>
