<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="box">    <div class="heading">
            <h1><img src="view/image/country.png" alt="" /> <?php echo $heading_title_depart; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <tr>
                        <td><span class="required">*</span> <?php echo $entry_title_depart; ?></td>
                        <td>
                            <input size="100" type="text" name="title_depart" value="<?php echo $title_depart; ?>" />
                            <?php if ($error_title_depart) { ?>
                            <span class="error"><?php echo $error_title_depart; ?></span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_title_country; ?></td>
                        <td><?php echo $country['name']; ?></td>
                    </tr>
                    <tr>
                        <td>
                            <span class="required">*</span> <?php echo $entry_title_zone; ?>
                        </td>
                        <td>
                            <select name="zone_id" onchange="getCities(this.options[this.selectedIndex].value)">
                                <?php foreach($zones as $zone) { ?>
                                <?php if ($zone['zone_id'] == $zone_id) { ?>
                                <option selected value="<?php echo $zone['zone_id']; ?>"><?php echo $zone['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $zone['zone_id']; ?>"><?php echo $zone['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="required">*</span> <?php echo $entry_title_city; ?>
                        </td>
                        <td>
                            <select name="city_id"  id="city_id">
                                <?php foreach($cities as $city) { ?>
                                <?php if ($city['city_id'] == $city_id) { ?>
                                <option selected value="<?php echo $city['city_id']; ?>"><?php echo $city['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $city['city_id']; ?>"><?php echo $city['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                                <option value="0"><?php echo $text_no; ?></option>
                            </select>
                            <?php if ($error_city_id) { ?>
                            <span class="error"><?php echo $error_city_id; ?></span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_status_depart; ?></td>
                        <td><select name="status_depart">
                                <?php if ($status_depart) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>

<script type="text/javascript">
    var token = '<?php echo $_GET['token']; ?>';

    function getCities(zone_id) {
        var url = "index.php?route=localisation/novapochta/getCities&token=" + token;

        $.get(
                url,
                "zone_id=" + zone_id,
                function (result) {
                    if (result.type == 'error') {
                        return(false);
                    } else {
                        html = '';

                        $(result.data).each(function() {
                            html += '<option value="' + $(this).attr('city_id') + '" >' + $(this).attr('name') + '</option>';
                        });

                        html += '<option value="0"><?php echo $text_no; ?></option>';
                        $('#city_id').html(html);
                    }
                },
                "json"
        );
    }
</script>