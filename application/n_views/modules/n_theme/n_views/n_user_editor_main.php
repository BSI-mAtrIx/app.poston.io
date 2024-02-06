<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Page editor</title>

    <!-- GrapeJs -->
    <link href="<?php echo base_url('n_assets/js/n_editor/'); ?>css/grapes.min.css?ver=<?php echo $n_config['theme_version']; ?>"
          rel="stylesheet">
    <script src="<?php echo base_url('n_assets/js/n_editor/'); ?>grapes.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

    <script src="<?php echo base_url('n_assets/js/ckeditor/'); ?>ckeditor.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

    <!-- UIKit -->
    <link rel="stylesheet" href="<?php echo base_url('n_assets/js/n_edit/'); ?>assets/uikit-3.3.3/css/uikit.min.css"/>
    <script src="<?php echo base_url('n_assets/js/n_edit/'); ?>assets/uikit-3.3.3/js/uikit.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_edit/'); ?>assets/uikit-3.3.3/js/uikit-icons.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

    <!-- Style -->
    <link rel="stylesheet"
          href="<?php echo base_url('n_assets/js/n_edit/'); ?>assets/css/style.css?ver=<?php echo $n_config['theme_version']; ?>">

    <!-- Plugins -->
    <script src="<?php echo base_url('n_assets/js/n_edit/'); ?>editor/plugins/custom-page-manager.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_edit/'); ?>editor/plugins/custom-code-editor.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_edit/'); ?>editor/plugins/customize-devices.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_edit/'); ?>editor/plugins/customize-options.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_edit/'); ?>editor/plugins/customize-views.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-component-countdown.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-lory-slider.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-style-bg.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-plugin-modal.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-style-gradient.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-style-filter.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-tabs.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-plugin-export.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-plugin-ckeditor.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-blocks-basic.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-parser-postcss.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-typed.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-custom-code.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-navbar.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-tooltip.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-touch.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script src="<?php echo base_url('n_assets/js/n_editor/plugins/'); ?>grapesjs-swiper-slider.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

    <!-- JQuery -->
    <script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/vendors.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

    <link rel=stylesheet
          href="<?php echo base_url(); ?>plugins/alertifyjs/css/alertify.min.css?ver=<?php echo $n_config['theme_version']; ?>"/>
    <link rel=stylesheet
          href="<?php echo base_url(); ?>plugins/alertifyjs/css/themes/default.min.css?ver=<?php echo $n_config['theme_version']; ?>"/>
    <script src="<?php echo base_url(); ?>plugins/alertifyjs/alertify.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
</head>
<body>
<div id="gjs"></div>

<!--Script  -->
<script type="text/javascript">
    var alert_editor = function (res) {
        if (res == 'SUCCESS') {
            alertify.success('Saved');
        }
        if (res == 'FAILED') {
            alertify.error('Something wrong');
        }
    }

    const categories = {
        'layout': 'Layout <span class="gjs-title-tags">Elements</span>',
        'basic': 'Basic <span class="gjs-title-tags">Elements</span>',
        'typography': 'Typography <span class="gjs-title-tags">Elements</span>',
        'media': 'Media <span class="gjs-title-tags">Elements</span>',
        'components': 'Components <span class="gjs-title-tags">Layout structure</span>',
        'pages': 'Pages <span class="gjs-title-tags">Fully constructed layouts</span>',
    }
    var filterInput = {
        name: 'Filter',
        property: 'filter',
        type: 'filter', // <- the new type
        full: 1,
    };
    const editor = grapesjs.init({
        container: '#gjs',
        height: '100vh',

        canvas: {
            styles: [
                '<?php echo base_url(); ?>n_assets/app-assets/vendors/css/vendors.min.css',
            ],
            //scripts: [
            //    '<?php //echo base_url('n_assets/js/n_edit/'); ?>//assets/uikit-3.3.3/js/uikit.min.js',
            //    '<?php //echo base_url('n_assets/js/n_edit/'); ?>//assets/uikit-3.3.3/js/uikit-icons.min.js'
            //]
        },

        plugins: [
            'grapesjs-blocks-basic',
            'grapesjs-plugin-modal',
            // 'customPageManager',
            // 'customCodeEditor',
            'customizeDevices',
            'customizeOptions',
            'customizeViews',
            'gjs-component-countdown',
            'grapesjs-lory-slider',
            'grapesjs-style-bg',
            'grapesjs-custom-code',
            'grapesjs-style-gradient',
            'grapesjs-style-filter',


            'grapesjs-typed',
            'grapesjs-navbar',
            'grapesjs-tooltip',
            'grapesjs-tabs',

            'grapesjs-plugin-export',
            'gjs-plugin-ckeditor',
            'grapesjs-parser-postcss',
            'grapesjs-touch',
            'grapesjs-swiper-slider',

            // Plugin temporary code
            editor => {
            },
        ],

        pluginsOpts: {
            'gjs-plugin-ckeditor': {
                position: 'center',
                options: {
                    language: 'en',
                    //skin: 'moono-dark',
                }
            },
            'grapesjs-swiper-slider': {
                // options
            }
        },

        storageManager: {
            type: 'remote',
            autosave: false,         // Store data automatically
            stepsBeforeSave: 1,
            contentTypeJson: true,
            urlStore: '<?php echo base_url('n_theme'); ?>/user_page_save/<?php echo $page_edit; ?>',
            urlLoad: '<?php echo base_url('n_theme'); ?>/user_page_load/<?php echo $page_edit; ?>',
            storeComponents: true,
            storeStyles: true,
            storeHtml: true,
            storeCss: true,
            headers: {
                'Content-Type': 'application/json'
            }
        },

        assetManager: {
            storageType: '',
            storeOnChange: true,
            storeAfterUpload: true,
            upload: '<?php echo base_url(); ?>n_theme/upload_assets/ecommerce',
            assets: [],
            uploadFile: function (e) {
                var files = e.dataTransfer ? e.dataTransfer.files : e.target.files;
                var formData = new FormData();
                for (var i in files) {
                    formData.append('file-' + i, files[i]) //containing all the selected images from local
                }
                $.ajax({
                    url: '<?php echo base_url(); ?>n_theme/upload_assets/ecommerce',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    crossDomain: true,
                    dataType: 'json',
                    mimeType: "multipart/form-data",
                    processData: false,
                    success: function (result) {
                        if (result.error != undefined) {
                            alertify.error(result.error);
                            return;
                        }

                        var myJSON = [];
                        $.each(result['data'], function (key, value) {
                            myJSON[key] = value;
                        });
                        var images = myJSON;
                        editor.AssetManager.add(images); //adding images to asset
                        //manager of GrapesJS
                    }
                });
            },
        },


        // Disable the storage manager for the moment
        // storageManager: false,
    });

    var pnm = editor.Panels;
    pnm.addButton('options', [{
        id: 'undo',
        className: 'fa fa-undo',
        attributes: {title: 'Undo'},
        command: function () {
            editor.runCommand('core:undo')
        }
    }, {
        id: 'redo',
        className: 'fa fa-repeat',
        attributes: {title: 'Redo'},
        command: function () {
            editor.runCommand('core:redo')
        }
    }
    ]);

    var pfx = editor.getConfig().stylePrefix
    var modal = editor.Modal
    var cmdm = editor.Commands
    var htmlCodeViewer = editor.CodeManager.getViewer('CodeMirror').clone()
    var cssCodeViewer = editor.CodeManager.getViewer('CodeMirror').clone()
    var container = document.createElement('div')
    var btnEdit = document.createElement('button')


    htmlCodeViewer.set({
        codeName: 'htmlmixed',
        readOnly: 0,
        theme: 'hopscotch',
        autoBeautify: true,
        autoCloseTags: true,
        autoCloseBrackets: true,
        lineWrapping: true,
        styleActiveLine: true,
        smartIndent: true,
        indentWithTabs: true
    })

    cssCodeViewer.set({
        codeName: 'css',
        readOnly: 0,
        theme: 'hopscotch',
        autoBeautify: true,
        autoCloseTags: true,
        autoCloseBrackets: true,
        lineWrapping: true,
        styleActiveLine: true,
        smartIndent: true,
        indentWithTabs: true
    })

    btnEdit.innerHTML = 'Save'
    btnEdit.className = pfx + 'btn-prim ' + pfx + 'btn-import'
    btnEdit.onclick = function () {
        var html = htmlCodeViewer.editor.getValue()
        var css = cssCodeViewer.editor.getValue()
        editor.DomComponents.getWrapper().set('content', '')
        editor.setComponents(html.trim())
        editor.setStyle(css)
        modal.close()
    }

    cmdm.add('edit-code', {
        run: function (editor, sender) {
            sender && sender.set('active', 0)
            var htmlViewer = htmlCodeViewer.editor
            var cssViewer = cssCodeViewer.editor
            modal.setTitle('Edit code')
            if (!htmlViewer && !cssViewer) {
                var txtarea = document.createElement('textarea')
                var cssarea = document.createElement('textarea')
                container.appendChild(txtarea)
                container.appendChild(cssarea)
                container.appendChild(btnEdit)
                htmlCodeViewer.init(txtarea)
                cssCodeViewer.init(cssarea)
                htmlViewer = htmlCodeViewer.editor
                cssViewer = cssCodeViewer.editor
            }
            var InnerHtml = editor.getHtml()
            var Css = editor.getCss()
            modal.setContent('')
            modal.setContent(container)
            htmlCodeViewer.setContent(InnerHtml)
            cssCodeViewer.setContent(Css)
            modal.open()
            htmlViewer.refresh()
            cssViewer.refresh()
        }
    })

    pnm.addButton('options',
        [
            {
                id: 'edit',
                className: 'fa fa-edit',
                command: 'edit-code',
                attributes: {
                    title: 'Edit Code'
                }
            }
        ]
    )

    pnm.addButton('options',
        [{
            id: 'save',
            className: 'btn-alert-button',
            label: 'Save',
            command: function (editor1, sender) {
                editor.store(
                    res => alert_editor(res)
                );
            },
            attributes: {title: 'Save'}
        }
        ]);


    // Vars for other scripts like pages.js, elements.js
    const blockManager = editor.BlockManager;
    const commands = editor.Commands;
    editor.StyleManager.addProperty('extra', filterInput);
    editor.on('load', () => {
        const blockBtn = editor.Panels.getButton('views', 'open-blocks');
        blockBtn.set('active', 1);
    })

    // Error handling
    editor.on('asset:upload:error', (err) => {
        alertify.error(err.error);
    });


</script>

<!-- Blocks -->
<!--<script src="-->
<?php //echo base_url('n_assets/js/n_edit/'); ?><!--editor/blocks/pages.js?ver=<?php echo $n_config['theme_version']; ?>"></script>-->
<script src="<?php echo base_url('n_assets/js/n_edit/'); ?>editor/blocks/elements.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
</body>
</html>