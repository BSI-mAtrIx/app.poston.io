<script type="text/javascript"
        src="<?php echo base_url('plugins/jorgchartmaster/js/prettify.js?ver=' . $n_config['theme_version']); ?>"></script>
<script src="<?php echo base_url('plugins/jorgchartmaster/js/jquery.jOrgChart.js?ver=' . $n_config['theme_version']); ?>"></script>

<script>
    $(document).ready(function () {
        $("#org").jOrgChart({
            chartElement: '#chart',
            dragAndDrop: false
        });

        $(document).on('click', '.iframed', function (e) {
            e.preventDefault();
            var iframe_url = $(this).attr('href');
            var iframe_height = $(this).attr('data-height');
            $("iframe").attr('src', iframe_url);
            $("#iframe_modal").modal();
        });

        $(document).on('click', '.zoomaction', function (e) {
            e.preventDefault();
            var zoomaction = $(this).attr("id");
            var scale = parseFloat($("#scale").val());
            var new_scale = 0;
            var steps = .1;

            if (zoomaction == "zoomin") new_scale = scale + steps;
            else if (zoomaction == "zoomout") new_scale = scale - steps;
            else new_scale = 1;

            if (new_scale >= .20 && new_scale <= 1) {
                $("#scale").val(new_scale);
                $(".jOrgChart").css('transform', 'scale(' + new_scale + ')');
                $(".jOrgChart").css('transform-origin', '0 0');

                var percent = parseInt(new_scale * 100);
                $("#percent").html(percent);

            }

        });


        $('#iframe_modal').on('hidden.bs.modal', function () {
            location.reload();
        });
    });
</script>

<?php echo $jrg_tree_vew_js; ?>

<script>
    $(document).ready(function () {
        $("#org0").jOrgChart({
            chartElement: '#chart',
            dragAndDrop: false
        });
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>