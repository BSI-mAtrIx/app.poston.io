<div class="toolbox-item toolbox-sort select-box text-dark">
    <label><?php echo $l->line('Sort By:'); ?></label>
    <select name="set_sort" id="set_sort" class="form-control">
        <option value="sort_default" selected="selected"><?php echo $l->line('Default sorting'); ?></option>
        <option value="new_asc"><?php echo $l->line('new_asc'); ?></option>
        <option value="new_desc"><?php echo $l->line('new_desc'); ?></option>
        <option value="price_asc"><?php echo $l->line('price_asc'); ?></option>
        <option value="price_desc"><?php echo $l->line('price_desc'); ?></option>
        <option value="sale_asc"><?php echo $l->line('sale_asc'); ?></option>
        <option value="sale_desc"><?php echo $l->line('sale_desc'); ?></option>
        <option value="random_asc"><?php echo $l->line('random_asc'); ?></option>
        <!--                                <option value="random_desc">-->
        <?php //echo $l->line('random_desc'); ?><!--</option>-->
        <option value="name_asc"><?php echo $l->line('name_asc'); ?></option>
        <option value="name_desc"><?php echo $l->line('name_desc'); ?></option>
    </select>
</div>