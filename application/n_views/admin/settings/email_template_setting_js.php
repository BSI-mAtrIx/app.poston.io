<script>
    $('[data-toggle="popover"]').popover();
    $('[data-toggle="popover"]').on('click', function (e) {
        e.preventDefault();
        return true;
    });
</script>


<script type="text/javascript">
    $('document').ready(function () {
        $(".settings_menu a").click(function () {
            $(".settings_menu a").removeClass("active");
            $(this).addClass("active");
        });

        $('textarea').each(function () {
            <?php if($jodit_cg){
            echo "editor = Jodit.make(this, {
                                    disablePlugins: [
                                        'about'
                                    ],
                                    buttons: [
                                        ...Jodit.defaultOptions.buttons,
                                    ],
                                    extraButtons: ext_butt
                });";
        }else{
            echo 'var editor = new Jodit(this);';
        } ?>
        });


    });
</script>