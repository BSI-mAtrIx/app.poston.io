<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Add a new board', true); ?></h4>
        </div>
        <div class="card-body">
            <form class="formAjax" action="<?php echo base_url(); ?>task/new_board" method="post">
                <div class="row">
                    <div class="col-12">
                        <label for="board_name_add"><?php echo $this->lang->line('Title', true); ?>:</label>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control task_title" name="board_name" id="board_name_add"
                                   placeholder="<?php echo $this->lang->line('Title', true); ?>">
                            <div class="form-control-position">
                                <i class="bx bx-text"></i>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="template_add">Template</label>
                                </div>
                                <select class="form-control" id="template_add" name="template">
                                    <option value="0" selected>Blank</option>
                                    <option value="1">GTD Method</option>
                                    <option value="2">Basic ToDo</option>
                                    <option value="3">Customer introduce</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <button type="submit"
                        class="btn btn-primary"><?php echo $this->lang->line('Add new board', true); ?></button>
            </form>
        </div>
    </div>
</div>

