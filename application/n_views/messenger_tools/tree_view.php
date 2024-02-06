<link rel="stylesheet"
      href="<?php echo base_url('plugins/jorgchartmaster/css/jquery.jOrgChart.css?ver=' . $n_config['theme_version']); ?>"/>
<link rel="stylesheet"
      href="<?php echo base_url('plugins/jorgchartmaster/css/custom.css?ver=' . $n_config['theme_version']); ?>"/>
<link href="<?php echo base_url('plugins/jorgchartmaster/css/prettify.css?ver=' . $n_config['theme_version']); ?>"
      type="text/css" rel="stylesheet"/>


<div class="section-header">
    <h1 style="font-style: normal !important;">
        <i class="bx bx-sitemap"></i> <?php echo $this->lang->line("Tree View"); ?> :
        <a href="https://facebook.com/<?php echo $page_info['page_id']; ?>"
           target="_BLANK"><?php echo $page_info['page_name']; ?></a>
    </h1>
    <div class="section-header-breadcrumb">
        <span id="percent">100</span>%&nbsp;&nbsp;
        <a href="" id="zoomin" class="zoomaction" data-toggle="tooltip" title="Zoom In"><i class="bx bx-plus-circle"
                                                                                           style="font-size: 17px;"></i></a>
        &nbsp;&nbsp;
        <a href="" id="zoomout" class="zoomaction" data-toggle="tooltip" title="Zoom Out"><i class="bx bx-minus-circle"
                                                                                             style="font-size: 17px;"></i></a>
        &nbsp;&nbsp;
        <a href="" id="resetzoom" class="zoomaction" data-toggle="tooltip" title="Reset Zoom"><i class="bx bx-sync"
                                                                                                 style="font-size: 17px;"></i></a>
        <input type="hidden" id="scale" value="1">
    </div>
</div>

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <div onload="prettyPrint();">
                    <ul id="org" style="display:none">
                        <?php echo $get_started_tree; ?>
                    </ul>

                    <?php
                    $i = 1;
                    $jrg_tree_vew_js = '';
                    foreach ($keyword_bot_tree as $key => $value) {
                        echo '<ul id="org' . $i . '" style="display:none">' . $value . '
                  </ul>';

                        $jrg_tree_vew_js .= '<script>
                    $(document).ready(function() {
                        $("#org' . $i . '").jOrgChart({
                            chartElement : "#chart",
                            dragAndDrop  : false
                        });
                    });
                    </script>';

                        $i++;
                    }
                    ?>

                    <ul id="org0" style="display:none">
                        <?php echo $no_match_tree; ?>
                    </ul>


                    <center>
                        <div class="table-responsive nicescroll">
                            <div id="chart" class="orgChart"></div>
                        </div>
                    </center>

                </div>
            </div>
        </div>

    </div>
</div>


<div class="modal fade" id="iframe_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bxs-cog"></i> <?php echo $page_title; ?>
                    : <?php echo $this->lang->line('Settings'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%"></iframe>
            </div>
        </div>
    </div>
</div>
