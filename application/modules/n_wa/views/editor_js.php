
<!--<script src="--><?php //echo base_url(); ?><!--plugins/n_wa/js/alertify.js"></script>-->
<!--<script src="--><?php //echo base_url(); ?><!--plugins/n_wa/js/sweetalert2.js"></script>-->
<!--<script src="--><?php //echo base_url(); ?><!--plugins/n_wa/js/jquery-3.6.1.min.js"></script>-->
<link rel="stylesheet" id="styles" href="<?php echo base_url(); ?>plugins/n_wa/css/style.css">

<script>
    var lang = <?php echo $language; ?>;
    var content_generator = <?php echo $content_generator; ?>;
    var bot_id = <?php echo $bot_id; ?>;
    var labels_data = <?php echo $editor_labels; ?>;
    var base_url = "<?php echo base_url(); ?>";
    var csrf_token = "<?php echo $this->session->userdata('csrf_token_session'); ?>";

    var data_js_notparsed = '<?php echo str_replace('\"', '\\\"', $flow_builder_json); ?>';
    data_js_notparsed = data_js_notparsed.replaceAll('\n', '\\n');
    var data_json = JSON.parse(data_js_notparsed);
    var stats = JSON.parse('<?php echo $nodes_stats; ?>');

    var is_whatsapp = <?php echo $is_whatsapp ? 'true' : 'false'; ?>;
    var is_telegram = <?php echo $is_telegram ? 'true' : 'false'; ?>;

    <?php require_once(APPPATH.'modules/n_wa/include/sweetalert_v1.php'); ?>
</script>

<script src="<?php echo base_url(); ?>plugins/n_wa/js/vue.prod.js"></script>
<script src="<?php echo base_url(); ?>plugins/n_wa/js/d3.js"></script>

<script src="<?php echo base_url(); ?>plugins/n_wa/js/rete.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/n_wa/js/vue-render-plugin.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/n_wa/js/connection-plugin.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/n_wa/js/context-menu-plugin.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/n_wa/js/area-plugin.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/n_wa/js/history-plugin.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/n_wa/js/task-plugin.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/n_wa/js/connectionpath-plugin.min.js"></script>

<script src="<?php echo base_url(); ?>plugins/n_wa/js/dock-plugin.min.js"></script>

<script src="<?php echo base_url(); ?>plugins/n_wa/js/app.message.js"></script>
<script src="<?php echo base_url(); ?>plugins/n_wa/js/components.js"></script>
<script src="<?php echo base_url(); ?>plugins/n_wa/js/app.js"></script>


<?php
include(APPPATH.'modules/n_wa/include/buttons_modal.php');
include(APPPATH.'modules/n_wa/include/new_label_modal.php');
$file = APPPATH.'modules/n_generator/include/modal_message.php';
if(file_exists($file)){
    include($file);
}
?>