<?php

//AGOO::$globals[]=$category_options;


if ($category_options) { ?>
<style type="text/css">
    #filters{line-height: 22px;}
    #filters b{display:block;padding: 2px 5px 1px 15px;}
    .filter-item{margin: 0 5px;}
    .filter-item label{margin-left:0px;padding-left:0px;display: block;cursor:pointer;color: white;}
    .filter-item label input{margin: 0 3px;}
    .filter-item label a{text-decoration:none;color: #CAFF70;}
    .filter-item label.active a{color: #E56101;font-weight:bold;}
    .filter-item select{margin-left:10px;min-width:100px;}
    .filter-item label + label{border-top: 1px solid #ECECEC;}
</style>
<div class="box">
    <div class="box-heading"><?php echo $heading_title; ?></div>
    <div class="box-content">
        <form id="filters">
            <?php foreach ($category_options as $category_option) { ?>
            <?php $isFlag = 0; ?>

            <?php if ($category_option['values']) { ?>
                <?php foreach ($category_option['values'] as $value) { ?>
                    <?php if ($value['products']) { ?>
                        <?php $isFlag = 1; ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            
            <?php if ($isFlag) { ?>
            <b><?php echo $category_option['name']; ?></b>
            <div class="filter-item">
                <?php if ($category_option['values']) { ?>
                <?php foreach ($category_option['values'] as $value) { ?>
                <?php if (in_array($value['value_id'], $filter_values_id)) { ?>
                <label class="active"><input type="checkbox" onclick="window.location='<?php echo $value['href']; ?>'" checked="checked"><a href="<?php echo $value['href']; ?>"><?php echo $value['name']; ?></a></label>
                <?php } else { ?>
                <?php if ($value['products']) { ?>
                <label><input type="checkbox" onclick="window.location='<?php echo $value['href']; ?>'"><a href="<?php echo $value['href']; ?>"><?php echo $value['name']; ?></a> (<?php echo $value['products']; ?>)</label>
                <?php } else { ?>
                <!--<label><input type="checkbox" disabled="disabled"><span class="grey"><?php echo $value['name']; ?> (<?php echo $value['products']; ?>)</span></label>-->
                <?php } ?>
                <?php } ?>
                <?php } ?>
                <?php } ?>
            </div>
            <?php } ?>

            <?php } ?>
        </form>
    </div>
    <div class="bottom">&nbsp;</div>
</div>
<?php } ?>