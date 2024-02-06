<style>
    .d-print-thermal {
        display: none;
    }
</style>
<?php include(APPPATH . "views/ecommerce/common_style.php"); ?>
<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php e_link($store_home_url); ?>"><?php echo $l->line('Home'); ?></a></li>
                <li><?php echo $this->lang->line("Order"); ?></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="shop-content">
            <div class="container main-content">
                <?php echo $output; ?>
            </div>
        </div>
    </div>
</main>
