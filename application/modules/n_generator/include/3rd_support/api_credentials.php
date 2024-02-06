<section class="section section_custom">
  <div class="section-header">
    <h1><i class="far fa-credit-card"></i> <?php echo $page_title; ?></h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="<?php echo base_url('integration'); ?>"><?php echo $this->lang->line("Integration"); ?></a></div>
      <div class="breadcrumb-item"><?php echo $page_title; ?></div>
    </div>
  </div>

  <?php $this->load->view('admin/theme/message'); ?>
  <?php 

    if(isset($xvalue['instruction_to_ai']) && !empty($xvalue['instruction_to_ai'])){
      $xvalue['instruction_to_ai'] = $xvalue['instruction_to_ai'];
    }
    else{
      $xvalue['instruction_to_ai'] = $this->lang->line('The following is a conversation with an AI assistant. The assistant is helpful, creative, clever, and very friendly.');
    }
  $custom_oai = file_exists(APPPATH.'custom_oai_library.php');

  if($custom_oai){
      $chat_completions = [
          'text-davinci-003' => 'Engine 1 (default)',
          'gpt-3.5-turbo' => 'Engine 2 (Cheap for Chat)',

      ];
      include(APPPATH . 'n_generator_config.php');

      if($n_gen_config['engine']=='1'){$chat_completions['gpt-4'] = 'Engine 3 (Best Universal)';}
  }else{
      $text_completions =[
          'text-davinci-003',
          'text-davinci-002',
          'text-curie-001',
          'text-babbage-001',
          'text-ada-001',
          'davinci',
          'curie',
          'babbage',
          'ada'];

      $chat_completions = [
          'gpt-4','gpt-4-0314','gpt-4-32k','gpt-4-32k-0314','gpt-3.5-turbo','gpt-3.5-turbo-0301'
      ];
  }
   ?>
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <form action="<?php echo base_url("integration/open_ai_api_credentials_action"); ?>" method="POST">
          <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
          <div class="card">
            <div class="card-body">

                <div class="row  <?php if($custom_oai){ echo 'd-none'; } ?>">
                  <div class="col-12 col-md-12">
                    <div class="form-group">
                      <label for=""><i class="fas fa-key"></i>  <?php echo $this->lang->line("Open AI secret key");?></label>
                      <input name="open_ai_secret_key" value="<?php echo isset($xvalue['open_ai_secret_key']) ? $xvalue['open_ai_secret_key'] :""; ?>" class="form-control" type="text">  
                      <span class="red"><?php echo form_error('open_ai_secret_key'); ?></span>
                    </div>
                  </div>
                </div>   
                <div class="row">
                  <div class="col-12 col-md-12">
                    <div class="form-group">
                      <label for=""><i class="fas fa-quote-right"></i>  <?php echo $this->lang->line("Instruction To AI ");?></label>
                      <textarea class="form-control" name="instruction_to_ai"><?php echo $xvalue['instruction_to_ai'] ?></textarea>
                      <span class="red"><?php echo form_error('instruction_to_ai'); ?></span>
                    </div>
                  </div>
                </div>  
                <div class="row">
                    <div class="col-12 col-md-12">
                      <div class="form-group">
                        <label for="models"><i class="fas fa-paper-plane"></i>  <?php echo $this->lang->line("Models");?></label>
                        <select class="select2 w-100" name="models">
                          <option value=""><?php echo $this->lang->line("Select Models"); ?></option>

                            <?php
                            if($custom_oai){
                                foreach ($chat_completions as  $k => $value): ?>
                                    <option value="<?php echo $k ?>" <?php if(isset($xvalue['models']) && $k == $xvalue['models']) echo 'selected'; ?> ><?php echo $value?></option>
                                <?php endforeach;

                            }else{?>


                                <optgroup label="Text Completions">
                                    <?php foreach ($text_completions as  $value): ?>
                                        <option value="<?php echo $value ?>" <?php if(isset($xvalue['models']) && $value == $xvalue['models']) echo 'selected'; ?> ><?php echo $value?></option>
                                    <?php endforeach ?>
                                </optgroup>
                                <optgroup label="Chat Completions">
                                    <?php foreach ($chat_completions as  $value): ?>
                                        <option value="<?php echo $value ?>" <?php if(isset($xvalue['models']) && $value == $xvalue['models']) echo 'selected'; ?> ><?php echo $value?></option>
                                    <?php endforeach ?>
                                </optgroup>

                            <?php } ?>
                        </select>
                        <span class="red"><?php echo form_error('models'); ?></span>
                     </div>
                    </div>
                </div>
                <div class="row  <?php if($custom_oai){ echo 'd-none'; } ?>">
                  <div class="col-12 col-md-12">
                    <div class="form-group">
                      <label for=""><i class="fas fa-solid fa-route"></i>  <?php echo $this->lang->line("Maximum Token");?></label>
                      <input name="maximum_token" value="<?php echo isset($xvalue['maximum_token']) ? $xvalue['maximum_token'] :"1500"; ?>" class="form-control" type="text">  
                      <span class="red"><?php echo form_error('maximum_token'); ?></span>
                    </div>
                  </div>
              </div>   
            <div class="card-footer bg-whitesmoke">
              <button class="btn btn-primary btn-lg" id="save-btn" type="submit"><i class="fas fa-save"></i> <?php echo $this->lang->line("Save");?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
