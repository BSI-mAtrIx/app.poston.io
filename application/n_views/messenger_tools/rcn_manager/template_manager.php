<?php
$include_upload=0;  //upload_js
$include_datatable=1; //datatables
$include_datetimepicker=1; //datetimepicker, daterange, moment
$include_emoji=0;
$include_summernote=0;
$include_colorpicker=0;
$include_select2=1;
$include_jqueryui=0;
$include_mCustomScrollBar=0;
$include_cropper=1;
$include_dropzone=0;
$include_tagsinput=0;
$include_alertify=0;
$include_morris=0;
$include_chartjs=0;
$include_owlcar=0;
$include_prism=0;
$include_perfectscroll=0;
$jodit=0;
?>

  <?php $this->load->view('admin/theme/message'); ?>

  <input type="hidden" value="<?php echo $page_id; ?>" id="page_id" name="page_id">
  <div class="table-responsive data-card">
    <table class="table table-bordered table-sm table-striped" id="mytable">
      <thead>
        <tr>
          <th>#</th>      
          <th style="vertical-align:middle;width:20px">
              <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label for="datatableSelectAllRows"></label>        
          </th>
          <th><?php echo $this->lang->line("id")?></th>
          <th><?php echo $this->lang->line("Page name")?></th>
          <th><?php echo $this->lang->line("Template name")?></th>
          <th><?php echo $this->lang->line("RCN postback ID")?></th>
          <th><?php echo $this->lang->line("Total OPTin subscribers")?></th>
          <th><?php echo $this->lang->line("Last send time")?></th>
          <th><?php echo $this->lang->line("Actions")?></th>
        </tr>
      </thead>
    </table>
  </div>

  <div class="modal fade" id="otn_subscribers_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="min-width: 95%;">
      <div class="modal-content">
        <div class="modal-header bbw">
          <h5 class="modal-title blue"><i class="fas fa-users"></i> <?php echo $this->lang->line("RCN Subscribers");?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>

          <div id="modalBody" class="modal-body">
            <input type="text" class="form-control" id="postback_id" autofocus placeholder="<?php echo $this->lang->line('RCN PostBack ID'); ?>" aria-label="" aria-describedby="basic-addon2" style="max-width: 40%">
            <div class="table-responsive2 data-card">
              <input type="hidden" value="" id="get_subscribers_page_id" name="get_subscribers_page_id">
              <input type="hidden" value="" id="get_otn_postback_table_id" name="get_otn_postback_table_id">
              <table class="table table-bordered table-sm table-striped" id="mytable2">
                <thead>
                  <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line("Page Name"); ?></th> 
                    <th><?php echo $this->lang->line("First Name"); ?></th> 
                    <th><?php echo $this->lang->line("Last Name"); ?></th> 
                    <th><?php echo $this->lang->line("RCN PostBack"); ?></th> 
                    <th><?php echo $this->lang->line("Subscriber ID"); ?></th>      
                    <th><?php echo $this->lang->line("OPT-in Token"); ?></th>
                    <th><?php echo $this->lang->line("OPT-in Time"); ?></th>
                  </tr>
                </thead>
              </table>
            </div>          
          </div>

          <div class="modal-footer bg-whitesmoke">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> <?php echo $this->lang->line("Close"); ?></button>
          </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="delete_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center"><i class="fa fa-trash"></i> <?php echo $this->lang->line("Template Delete Confirmation"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="delete_template_modal_body">                

            </div>
        </div>
    </div>
</div>