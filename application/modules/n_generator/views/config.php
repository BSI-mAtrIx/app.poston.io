<?php if (!defined('NVX')) { ?>
    <section class="section section_custom">
        <div class="section-header">
            <h1><i class="fa fa-search-location"></i> <?php echo $page_title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><?php echo $page_title; ?></div>
            </div>
        </div>
    </section>
<?php } else { ?>
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
<?php } ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="col-12">
                        <p class="font-weight-bold"><?php echo $this->lang->line('Engine Davinci cost 0.06 USD / 1K tokens.'); ?></p>

                        <p><?php echo $this->lang->line('For tokens you need include request (prompt) up to 400-450 characters. Its up to 150 tokens. 1 token is 4 characters.'); ?></p>

                        <p><?php echo $this->lang->line('For API Key you need register here: https://beta.openai.com/signup'); ?></p>

                        <p class="font-weight-bold"><?php echo $this->lang->line('After that send request approve app. Instruction here: https://nvxgroup.com/docs/nvx-addon-manager/ai-content-generator/'); ?></p>

                        <p class="font-weight-bold"><?php echo $this->lang->line('In package manager please use one option for package:'); ?></p>

                        <p><?php echo $this->lang->line('1. Credits, cost per 1k tokens (not used credits move to next month)'); ?></p>
                        <p><?php echo $this->lang->line('2. OR Words package, pay for characters (not used credits disappear)'); ?></p>
                        <p><?php echo $this->lang->line('3. OR Words package, pay for characters (not used credits move to next month)'); ?></p>

                        <p class="font-weight-bold"><?php echo $this->lang->line('You need manually calculate cost for API. Do not select more than 1 option per package.'); ?></p>

                        <p><?php echo $this->lang->line('If you want edit manually CREDITS open PHPMyAdmin, select table USERS, column n_credits'); ?></p>

                        <p><?php echo $this->lang->line('If you want edit manually WORDS open PHPMyAdmin, select table USERS, column n_words'); ?></p>

                        <p><?php echo $this->lang->line('You can think of tokens as pieces of words used for natural language processing. For English text, 1 token is approximately 4 characters or 0.75 words. As a point of reference, the collected works of Shakespeare are about 900,000 words or 1.2M tokens.<br /><br />

To learn more about how tokens work and estimate your usage…<br /><br />

Experiment with our interactive Tokenizer tool. https://beta.openai.com/tokenizer<br />
Log in to your account and enter text into the Playground. The counter in the footer will display how many tokens are in your text.'); ?></p>


                        <p><?php echo $this->lang->line('OpenAI not return in API how many tokens used. Im use 1 token for 2 characters (after my test 1 token is 2-3 characters.)'); ?></p>

                        <p><?php echo $this->lang->line('This Version: only credits works.'); ?></p>

                        <p><?php echo $this->lang->line('If you have a trouble with charset, try this:'); ?> <a
                                    href="<?php echo base_url('n_generator/fix_charset_mb4'); ?>"><?php echo $this->lang->line('Change Charset to utf8mb4_general_ci'); ?></a>
                        </p>



                    </div>

                    <div class="row">
                        <div class="col-12">
                        <p>SIMULATOR</p>
                        </div>
                        <div class="col-2 mb-1">
                            <fieldset>
                                <label for="sim_tokens"><?php echo $this->lang->line('OpenAI TOKENS'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">TK</span>
                                    </div>
                                    <input type="number" id="sim_tokens" name="sim_tokens"
                                           class="form-control" value="1000">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-2 mb-1">
                            <fieldset>
                                <label for="sim_cp"><?php echo $this->lang->line('CP Cost'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">CP</span>
                                    </div>
                                    <input type="number" id="sim_cp" name="sim_cp"
                                           class="form-control" value="600">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-2 mb-1">
                            <fieldset>
                                <label for="sim_calc"><?php echo $this->lang->line('Price CP'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">CP</span>
                                    </div>
                                    <input type="number" id="sim_calc" name="sim_calc"
                                           class="form-control" value="600" readonly>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-2 mb-1">
                            <fieldset>
                                <label for="sim_calc_oi_new"><?php echo $this->lang->line('Price OpenAI'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">USD</span>
                                    </div>
                                    <input type="number" id="sim_calc_oi_new" name="sim_calc_oi_new"
                                           class="form-control" value="0.02">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-2 mb-1">
                            <fieldset>
                                <label for="sim_calc_oi"><?php echo $this->lang->line('Price Total OpenAI'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">USD</span>
                                    </div>
                                    <input type="number" id="sim_calc_oi" name="sim_calc_oi"
                                           class="form-control" value="0.02" readonly>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <hr />

                    <form class="form-horizontal text-c" action="<?php echo site_url() . 'n_generator/config'; ?>"
                          method="POST">
                        <input type="hidden" name="csrf_token" id="csrf_token"
                               value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

                        <div class="col-12 mb-1">
                            <fieldset>
                                <label for="openai_api"><?php echo $this->lang->line('OpenAI API Key'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class='bx bxs-key'></i></span>
                                    </div>
                                    <input type="text" id="openai_api" name="openai_api" class="form-control"
                                           value="<?php echo $openai_api; ?>">
                                </div>
                                <span class="text-danger"><?php echo form_error('openai_api'); ?></span>
                            </fieldset>
                        </div>

                        <div class="col-12 mb-1">
                            <fieldset>
                                <label for="cost_per1k_tokens"><?php echo $this->lang->line('Credits - Cost per 1k tokens. 1000 tokens is 600 CreditsPoints (CP). 600 CP is 0.06 USD'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">CP</span>
                                    </div>
                                    <input type="number" id="cost_per1k_tokens" name="cost_per1k_tokens"
                                           class="form-control" value="<?php echo $cost_per1k_tokens; ?>">
                                </div>
                                <span class="text-danger"><?php echo form_error('cost_per1k_tokens'); ?></span>
                            </fieldset>
                        </div>

                        <hr />

                        <h3><?php echo $this->lang->line('OpenAI GPT-4 Settings'); ?></h3>
                        <p><?php echo $this->lang->line('Enable it only if you have access to OpenAI GPT-4'); ?></p>

                        <div class="col-12 mb-1">
                            <div class="form-group">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="engine" id="engine" value="1"
                                           class="custom-control-input" <?php echo $engine; ?>>
                                    <label class="custom-control-label mr-1" for="engine"></label>
                                    <span><?php echo $this->lang->line('Enable GPT-4'); ?></span>
                                    <span class="text-danger"><?php echo form_error('engine'); ?></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 mb-1">
                            <fieldset>
                                <label for="gpt4_cost_per1k_tokens_prompt"><?php echo $this->lang->line('Prompt Credits - Cost per 1k tokens.'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">CP</span>
                                    </div>
                                    <input type="number" id="gpt4_cost_per1k_tokens_prompt" name="gpt4_cost_per1k_tokens_prompt"
                                           class="form-control" value="<?php echo $gpt4_cost_per1k_tokens_prompt; ?>">
                                </div>
                                <span class="text-danger"><?php echo form_error('gpt4_cost_per1k_tokens_prompt'); ?></span>
                            </fieldset>
                        </div>

                        <div class="col-12 mb-1">
                            <fieldset>
                                <label for="gpt4_cost_per1k_tokens_completions"><?php echo $this->lang->line('Completion Credits - Cost per 1k tokens.'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">CP</span>
                                    </div>
                                    <input type="number" id="gpt4_cost_per1k_tokens_completions" name="gpt4_cost_per1k_tokens_completions"
                                           class="form-control" value="<?php echo $gpt4_cost_per1k_tokens_completions; ?>">
                                </div>
                                <span class="text-danger"><?php echo form_error('gpt4_cost_per1k_tokens_completions'); ?></span>
                            </fieldset>
                        </div>

                        <h3><?php echo $this->lang->line('OpenAI GPT-3.5 Settings'); ?></h3>
                        <p><?php echo $this->lang->line('This settings only apply for user choices in bot settings or AI Integration with integration Content Generator'); ?></p>

                        <div class="col-12 mb-1">
                            <fieldset>
                                <label for="gpt35_cost_per1k_tokens_prompt"><?php echo $this->lang->line('Prompt Credits - Cost per 1k tokens.'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">CP</span>
                                    </div>
                                    <input type="number" id="gpt35_cost_per1k_tokens_prompt" name="gpt35_cost_per1k_tokens_prompt"
                                           class="form-control" value="<?php echo $gpt35_cost_per1k_tokens_prompt; ?>">
                                </div>
                                <span class="text-danger"><?php echo form_error('gpt35_cost_per1k_tokens_prompt'); ?></span>
                            </fieldset>
                        </div>

                        <div class="col-12 mb-1">
                            <fieldset>
                                <label for="gpt35_cost_per1k_tokens_completions"><?php echo $this->lang->line('Completion Credits - Cost per 1k tokens.'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">CP</span>
                                    </div>
                                    <input type="number" id="gpt35_cost_per1k_tokens_completions" name="gpt35_cost_per1k_tokens_completions"
                                           class="form-control" value="<?php echo $gpt35_cost_per1k_tokens_completions; ?>">
                                </div>
                                <span class="text-danger"><?php echo form_error('gpt35_cost_per1k_tokens_completions'); ?></span>
                            </fieldset>
                        </div>

                        <div class="col-12 mb-1">
                            <button type="submit" id="save-btn" class="btn btn-outline-success mr-1">
                                <i class="bx bx-save"></i>
                                <span class="align-middle ml-25"><?php echo $this->lang->line("Save"); ?></span>
                            </button>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
