<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no" />
    <title>Image Editor</title>
    <style>
        html, body, #editor-container {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
    </style>
</head>
<body>
<div id="editor-container"></div>
<script src="<?php echo base_url(); ?>/plugins/pixie/dist/pixie.umd.js"></script>
<script>
    const pixie = new Pixie({
        selector: "#editor-container",
        baseUrl: '<?php echo base_url(); ?>/plugins/pixie',

        openImageDialog: {
            show: true
        },
        ui: {
            activeTheme: 'light_custom',
            themes: [
                {
                    name: 'light_custom',
                    isDark: false,
                    colors: {
                        '--be-background': '#F2F4F4',
                        '--be-background-alt': '250 250 250',
                    }
                }
            ],
            nav: {
                position: 'top',
            },

        },
        tools: {
            text: {
                replaceDefault: false,
                defaultCategory: 'handwriting',
                items: [
                    {
                        family: 'Tajawal Regular',
                        src: 'fonts/Tajawal-Regular.woff2',
                    },
                    {
                        family: 'Tajawal Bold',
                        src: 'fonts/Tajawal-Bold.woff2',
                    },
                    {
                        family: 'Cairo Regular',
                        src: 'fonts/Cairo-Regular.woff2',
                    },
                    {
                        family: 'Cairo Bold',
                        src: 'fonts/Cairo-Bold.woff2',
                    },
                ]
            }
        }
    });
</script>
</body>
</html>