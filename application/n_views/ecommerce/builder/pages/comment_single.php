<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php e_link($store_home_url); ?>"><?php echo $l->line('Home'); ?></a></li>
                <li><?php echo $this->lang->line("Comments"); ?></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="shop-content">
            <div class="container main-content">
                <?php
                if ($this->ecommerce_review_comment_exist): ?>
                    <div class="card mt-2 mb-2 shadow-none" id="comment_section">
                        <div class="card-header p-0 pt-3 pb-3">
                            <h4><i class="w-icon-comment"></i> <?php echo $this->lang->line("Comments"); ?></h4>
                        </div>
                        <div class="card-body p-0">

                            <div>
                                <ul class="comments list-style-none" id="load_data">

                                </ul>
                            </div>

                            <div class="text-center" id="waiting" style="width: 100%;margin: 30px 0;">
                                <i class=" w-icon-return2 blue" style="font-size:60px;"></i>
                            </div>

                            <div class="card shadow-none m-0" id="nodata" style="display: none">
                                <div class="card-body">
                                    <div class="empty-state p-0">
                                        <h6 class="mt-0"><?php echo $this->lang->line("We could not find any comment.") ?></h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

