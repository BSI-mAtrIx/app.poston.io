<style>
    #settings .select2 {
        width: 100% !important;
    }

    .filter_frameworks_select .select2 {
        width: 100% !important;
    }
</style>


<?php if (!defined('NVX')) { ?>
    <section class="section section_custom">
        <div class="section-header">
            <h1><i class="fa fa-search-location"></i> <?php echo $page_title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a
                            href="<?php echo base_url("n_generator"); ?>"><?php echo $this->lang->line("Content Generator"); ?></a></div>
                <div class="breadcrumb-item"><?php echo $page_title; ?></div>
            </div>
        </div>
    </section>


    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/gen_thirdn/jodit-3.10.2/build/jodit.min.css">
    <script src="<?php echo base_url(); ?>assets/gen_thirdn/jodit-3.10.2/build/jodit.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/gen_thirdn/jquery.blockUI.js"></script>
    <style>
        .ntheme textarea.form-control {
            height: auto!important;
            min-height: 200px;
            resize: vertical!important;
        }

        .ntheme .avatar .avatar-content {
            width: 32px;
            height: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .ntheme .font-medium-5 {
            font-size: 1.5rem !important;
        }

        .ntheme .avatar {
            white-space: nowrap;
            background-color: #c3c3c3;
            border-radius: 50%;
            position: relative;
            cursor: pointer;
            color: #FFFFFF;
            display: inline-flex;
            font-size: 0.8rem;
            text-align: center;
            vertical-align: middle;
            margin: 5px;
        }

        .ntheme .bg-rgba-primary {
            background: rgba(90, 141, 238, 0.2) !important;
        }

        .ntheme .mr-1, .ntheme .mx-1 {
            margin-right: 1rem !important;
        }

        .ntheme .p-25 {
            padding: 0.25rem !important;
        }

        .ntheme .m-0 {
            margin: 0 !important;
        }

        .ntheme .chip {
            background-color: #f0f0f0;
            font-size: 0.8rem;
            border-radius: 1.428rem;
            display: inline-flex;
            padding: 0 10px;
            margin-bottom: 5px;
            vertical-align: middle;
            justify-content: center;
            float: right;
        }

        .ntheme .chip .chip-body {
            color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: space-between;
            min-height: 1.857rem;
            min-width: 1.857rem;
        }

        .ntheme .chip .chip-body .avatar {
            background-color: #c3c3c3;
            display: flex;
            width: 24px;
            height: 24px;
            margin: 2px 0;
            border-radius: 50%;
            justify-content: center;
            align-items: center;
            color: #FFFFFF;
            transform: translate(-8px);
        }

        .ntheme .chip .chip-body .chip-text {
            vertical-align: middle;
            align-self: center;
        }

        .ntheme .card-title{
            margin-bottom: 0;
        }

        .ntheme .card .card-header {
            align-items: center;
            flex-wrap: wrap;
            justify-content: space-between;
        }

    </style>

<?php } else { ?>
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                    <ol class="breadcrumb p-0 mb-0 pl-1">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                        class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a
                                    href="<?php echo base_url("n_generator"); ?>"><?php echo $this->lang->line("Content Generator"); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <?php
    $jodit = 1;
    $include_select2 = 1;
} ?>

<div class="section-body ntheme">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">


                        <div class="col-sm-12 col-md-4">
                            <form>
                                <div class="card bg-transparent shadow-none border">
                                    <div class="card-header">
                                        <h4 class="card-title"><?php echo $this->lang->line("Tools"); ?></h4>
                                        <div class="chip mr-1">
                                            <div class="chip-body">
                                                <div class="avatar bg-success">
                                                    <span><?php echo $this->lang->line("CP"); ?></span>
                                                </div>
                                                <span id="credits_cp" class="chip-text"><?php echo $credits; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">


                                        <ul class="nav nav-tabs nav-fill nav_action">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-tab-fill" data-toggle="pill"
                                                   href="#home-fill" aria-expanded="true">
                                                    <?php echo $this->lang->line("Frameworks"); ?>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profile-tab-fill" data-toggle="pill"
                                                   href="#profile-fill"
                                                   aria-expanded="false">
                                                    <?php echo $this->lang->line("History"); ?>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="settings-fill" data-toggle="pill"
                                                   href="#settings" aria-expanded="false">
                                                    <?php echo $this->lang->line("Settings"); ?>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content pl-0 tabs_action">
                                            <div role="tabpanel" class="tab-pane active" id="home-fill"
                                                 aria-labelledby="home-tab-fill" aria-expanded="true">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <fieldset class="form-group">
                                                            <input type="text" class="form-control"
                                                                   onkeyup="search_in_ul_n(this)"
                                                                   placeholder="<?php echo $this->lang->line("Search"); ?>"
                                                                   spellcheck="false"/>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 filter_frameworks_select">
                                                        <div class="form-group">
                                                            <select name="filter_frameworks" id="filter_frameworks"
                                                                    class="select2 form-control">
                                                                <option value="all"><?php echo $this->lang->line("Filter"); ?></option>
                                                                <?php foreach($filters_data as $k => $v){ ?>
                                                                    <option value="filter_<?php echo $k; ?>"><?php echo $this->lang->line($v['name']); ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row position-relative" id="framework_list" style="max-height:65vh;">

                                                    <ul class="list-group list-group-flush" id="filters">
                                                        <?php foreach($frameworks_data as $k => $v){
                                                            if(isset($v['hidden'])){
                                                                continue;
                                                            }

                                                            if($gpt4_enabled==1){
                                                                $v['field_1_max_char'] = $v['field_1_gpt4_max_char'];
                                                                $v['field_2_max_char'] = $v['field_2_gpt4_max_char'];
                                                            }

                                                            $field_2 = '';
                                                            if($v['field_2']=='true'){
                                                                $field_2 = 'c1_count_limit="'.$v['field_2_max_char'].'" custom1_editor="'.$v['field_2_name'].'"';
                                                            }


                                                            ?>
                                                            <li class="filter_<?php echo $v['category']; ?> list-group-item list-group-item-action border-0 p-0 pr-1 mb-1 d-flex align-items-center justify-content-between pointer"
                                                                action="<?php echo $k; ?>" count_limit="<?php echo $v['field_1_max_char']; ?>" textarea_title="<?php echo $v['field_1_name']; ?>" <?php echo $field_2; ?>
                                                            >

                                                                <div class="list-left d-flex">
                                                                    <div class="list-icon mr-1">
                                                                        <div class="avatar bg-rgba-primary m-0 p-25">
                                                                            <div class="avatar-content">
                                                                                <i class="<?php echo $filters_data[$v['category']]['icon']; ?> text-primary font-medium-5"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="list-content">
                                                                        <span class="list-title"><?php echo $this->lang->line($v['list_title']); ?></span>
                                                                        <small class="text-muted d-block"><?php echo $this->lang->line($v['list_desc']); ?>

                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="readable-mark-icon" data-toggle="tooltip"
                                                                     data-placement="left"
                                                                     title="<?php echo $this->lang->line("Next step"); ?>">
                                                                    <i class='bx bx-chevron-right'></i>
                                                                </div>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>

                                                </div>

                                            </div>

                                            <div class="tab-pane" id="profile-fill" role="tabpanel"
                                                 aria-labelledby="profile-tab-fill"
                                                 aria-expanded="false">

                                                <div id="history_load">
                                                    <?php
                                                    $h_i = 0;
                                                    foreach ($history as $h_k => $h_v) { ?>
                                                        <div class="border p-1 mb-1 d-block">
                                                            <div class="action vote_<?php echo $h_v['id']; ?>">
                                                                <?php if ($h_v['vote'] == 'none') { ?>
                                                                    <?php echo $this->lang->line("Feedback: "); ?>
                                                                    <a href="#" class="feedback_action"
                                                                       data-id="<?php echo $h_v['id']; ?>"
                                                                       data-vote="yes"><i
                                                                                class='bx bx-happy-heart-eyes'></i></a>
                                                                    <a href="#" class="feedback_action"
                                                                       data-id="<?php echo $h_v['id']; ?>"
                                                                       data-vote="no"> <i class='bx bx-sad'></i></a>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="ai_content border-top">
                                                                <?php echo $h_v['response']; ?>
                                                            </div>

                                                        </div>

                                                        <?php
                                                        $h_i++;
                                                    }
                                                    ?>

                                                </div>
                                                <?php if ($h_i >= 10) { ?>
                                                    <button class="btn btn-primary" data-start="11"
                                                            id="load_more_action" name="load_more_action" type="button">
                                                        <span class="align-middle ml-25"><?php echo $this->lang->line("Load more"); ?></span>
                                                    </button>
                                                    <?php
                                                }
                                                ?>

                                                <div id="no_more_results"
                                                     style="display: none"><?php echo $this->lang->line("No more results"); ?></div>


                                            </div>


                                            <div class="tab-pane" id="settings" role="tabpanel"
                                                 aria-labelledby="settings-fill"
                                                 aria-expanded="false">
                                                <h6><?php echo $this->lang->line("Language"); ?></h6>
                                                <div class="form-group">
                                                    <?php echo form_dropdown('language', $sdk_locale, $config_sdk_locale, 'class="select2 form-control" id="language"'); ?>
                                                </div>

                                                <h6><?php echo $this->lang->line("Creativity"); ?></h6>
                                                <div class="form-group">
                                                    <?php
                                                    $select_lan = 'false';
                                                    if (isset($config_creativity)) {
                                                        $select_lan = $config_creativity;
                                                    }
                                                    $options = array();
                                                    $options['Optimal'] = $this->lang->line("Optimal");
                                                    $options['None'] = $this->lang->line("None (more factual)");
                                                    $options['Low'] = $this->lang->line("Low");
                                                    $options['Medium'] = $this->lang->line("Medium");
                                                    $options['High'] = $this->lang->line("High");
                                                    $options['Max'] = $this->lang->line("Max (less factual)");

                                                    echo form_dropdown('creativity', $options, $select_lan, 'class="select2 form-control" id="creativity"'); ?>
                                                </div>

                                                <h6><?php echo $this->lang->line("Tone"); ?></h6>
                                                <div class="form-group">
                                                    <?php
                                                    $select_lan = 'false';
                                                    if (isset($config_tone)) {
                                                        $select_lan = $config_tone;
                                                    }
                                                    $options = array();
                                                    $options['Appreciative'] = $this->lang->line("Appreciative");
                                                    $options['Assertive'] = $this->lang->line("Assertive");
                                                    $options['Awestruck'] = $this->lang->line("Awestruck");
                                                    $options['Candid'] = $this->lang->line("Candid");
                                                    $options['Casual'] = $this->lang->line("Casual");
                                                    $options['Cautionary'] = $this->lang->line("Cautionary");
                                                    $options['Compassionate'] = $this->lang->line("Compassionate");
                                                    $options['Convincing'] = $this->lang->line("Convincing");
                                                    $options['Critical'] = $this->lang->line("Critical");
                                                    $options['Earnest'] = $this->lang->line("Earnest");
                                                    $options['Enthusiastic'] = $this->lang->line("Enthusiastic");
                                                    $options['Formal'] = $this->lang->line("Formal");
                                                    $options['Funny'] = $this->lang->line("Funny");
                                                    $options['Humble'] = $this->lang->line("Humble");
                                                    $options['Humorous'] = $this->lang->line("Humorous");
                                                    $options['Informative'] = $this->lang->line("Informative");
                                                    $options['Inspirational'] = $this->lang->line("Inspirational");
                                                    $options['Joyful'] = $this->lang->line("Joyful");
                                                    $options['Passionate'] = $this->lang->line("Passionate");
                                                    $options['Thoughtful'] = $this->lang->line("Thoughtful");
                                                    $options['Urgent'] = $this->lang->line("Urgent");
                                                    $options['Worried'] = $this->lang->line("Worried");

                                                    echo form_dropdown('tone', $options, $select_lan, 'class="select2 form-control" id="tone"'); ?>
                                                </div>

                                                <h6><?php echo $this->lang->line("Autosave"); ?></h6>
                                                <div class="form-group">
                                                    <?php
                                                    $select_lan = 'false';
                                                    if (isset($config_autosave)) {
                                                        $select_lan = $config_autosave;
                                                    }
                                                    $options = array();
                                                    $options['true'] = $this->lang->line("True");
                                                    $options['false'] = $this->lang->line("False");

                                                    echo form_dropdown('autosave', $options, $select_lan, 'class="select2 form-control" id="autosave"'); ?>
                                                </div>


                                            </div>

                                            <div class="tab-pane" id="action-fill" role="tabpanel"
                                                 aria-labelledby="action-tab-fill"
                                                 aria-expanded="false">
                                                <input type="hidden" name="action_api" id="action_api" value=""/>
                                                <div class="row mt-1">
                                                    <div class="col-12">
                                                        <h5 class="mb-1" id="framework_title"></h5>
                                                    </div>


                                                    <div class="col-12">
                                                        <fieldset class="form-label-group mb-0">
                                                            <h6 id="main_title"></h6>
                                                            <textarea data-length="0"
                                                                      class="form-control char-textarea customs"
                                                                      id="textarea-counter" rows="3"></textarea>
                                                        </fieldset>
                                                        <small class="counter-value float-right"><span
                                                                    class="char-count">0</span> / <span
                                                                    id="count_limit">0</span> </small>
                                                    </div>


                                                    <div class="col-12 customs_editor" id="custom1"
                                                         style="display: none;">
                                                        <fieldset class="form-label-group mb-0">
                                                            <h6 id="custom1_title"></h6>
                                                            <textarea data-length="0"
                                                                      class="form-control char-textarea customs"
                                                                      id="textarea-c1" rows="3"></textarea>
                                                        </fieldset>
                                                        <small class="counter-value float-right"><span
                                                                    class="char-count">0</span> / <span
                                                                    id="count_limit_c1">0</span> </small>
                                                    </div>


                                                    <div class="col-12 d-flex mt-2  justify-content-end">
                                                        <button class="btn btn-primary" id="generate_action"
                                                                name="generate" type="button"><i
                                                                    class='bx bxs-paint'></i> <span
                                                                    class="align-middle ml-25"><?php echo $this->lang->line("Generate text"); ?></span>
                                                        </button>
                                                    </div>

                                                    <div class="col-12 mt-2 generate_result">

                                                    </div>


                                                </div>
                                            </div>


                                        </div>


                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-sm-12 col-md-8 ">
                            <form>
                                <input type="hidden" name="csrf_token" id="csrf_token"
                                       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                                <?php if (!empty($doc_id)) { ?>
                                    <input type="hidden" name="doc_id" id="doc_id" value="<?php echo $doc_id; ?>">
                                <?php } ?>
                                <fieldset class="mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="doc_title" id="doc_title"
                                               placeholder="<?php echo $this->lang->line("Document name"); ?>"
                                               value="<?php echo $doc_title; ?>">
                                        <div class="input-group-append">
                                            <button id="button-editor-save" class="btn btn-primary"
                                                    type="button"><?php echo $this->lang->line("SAVE"); ?></button>
                                        </div>
                                    </div>
                                </fieldset>

                                <textarea id="document" name="document" class="jodit">
                                    <?php if (!empty($doc_id)) {
                                        echo stripslashes(html_entity_decode($doc_text));
                                    } ?>
                                </textarea>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
