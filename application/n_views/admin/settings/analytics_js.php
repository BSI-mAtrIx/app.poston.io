
<script type="text/javascript">
    $('document').ready(function () {

        $('textarea').each(function () {
            <?php if($jodit_cg){
            echo "editor = Jodit.make(this, {
                                    direction: 'ltr',
                                    defaultMode: Jodit.MODE_SOURCE,
                                    disablePlugins: [
                                        'about'
                                    ],
                                    buttons: [
                                        ...Jodit.defaultOptions.buttons,
                                    ],
                                    extraButtons: ext_butt
                });";
        }else{
            echo 'var editor = new Jodit(this, {
                direction: "ltr",
                defaultMode: Jodit.MODE_SOURCE,
            });';
        } ?>
        });


    });
</script>