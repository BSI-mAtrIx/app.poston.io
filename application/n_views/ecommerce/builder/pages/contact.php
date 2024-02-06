<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php e_link($store_home_url); ?>"><?php echo $l->line('Home'); ?></a></li>
                <li><?php echo $this->lang->line("Contact"); ?></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="shop-content">
            <div class="main-content">
                <style>
                    <?php echo $gjs['gjs-css']; ?>
                </style>

                <?php echo $gjs['gjs-html']; ?>
            </div>
        </div>
    </div>
</main>
