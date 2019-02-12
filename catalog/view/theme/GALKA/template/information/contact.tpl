<?php echo $header; ?>
<div class="title-holder">
    <?php if(($this->config->get('GALKAControl_map_status') == '1') && ($this->config->get('GALKAControl_status') == '1')) { ?>
    <div class="google-maps">
        <div id="map_canvas" style="width:100%; height:440px"></div>
        <div class="directions_holder">
            <h3><i class="icon-map-marker"></i><?php echo $text_map_get_directions; ?></h3>
            <p><?php echo $text_map_route; ?></p>
            <form id="gmap" action="" onSubmit="calcRoute();return false;" id="routeForm" align="right">
                <input type="text" id="routeStart" value="" placeholder="Пример: Киев, пр. Мира 4" style="margin-top:3px"><br /><br />
                <input type="submit" value="Проложить маршрут" class="button" onclick="calcRoute();return false;"  />
            </form>
        </div>
    </div>
    <?php } ?>
    <div class="inner">
        <div class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
        </div>
    </div>
</div>
<div class="inner"> <?php echo $column_left; ?><?php echo $column_right; ?>
    <div id="content">
        <h2 class="heading_title"><span><?php echo $heading_title; ?></span></h2>
        <?php echo $content_top; ?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div class="contact-info">
                <div class="content">
                    <div class="one_third"><span class="address"><?php echo $text_address; ?></span><br />
            <span style="line-height:24px;"><b><?php echo $store; ?></b><br />
                <?php echo $address; ?></span> </div>
                    <div class="one_third">
                        <?php if ($telephone) { ?>
                        <span class="phone"><?php echo $text_telephone; ?></span><br />

                        <?php foreach ($telephone as $telephone) { ?>
                            <?php echo $telephone; ?><br/>
                        <?php } ?>

                        <?php echo $telephone; ?><br />
                        <br />
                        <?php } ?>
                        <?php if ($fax) { ?>
                        <span class="fax"><?php echo $text_fax; ?></span><br />
                        <?php echo $fax; ?>
                        <?php } ?>
                    </div>
                    <div class="one_third last"> <span class="hours"><?php echo $text_hours; ?></span> <br />
                        <?php if(($this->config->get('GALKAControl_footer_time') != null) && ($this->config->get('GALKAControl_status') == '1')) { ?>
                        <?php echo $this->config->get('GALKAControl_footer_time') ?>
                        <?php } ?>
                        <br />
                        <br />
                        <?php if (($this->config->get('GALKAControl_skype') != null) && ($this->config->get('GALKAControl_status') == '1')){ ?>
                        <span class="skype">Skype</span> <br />
                        <!--
                          Skype 'My status' button
                          http://www.skype.com/go/skypebuttons
                          -->
                        <script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
                        <a href="skype:<?php echo $this->config->get('GALKAControl_skype') ?>?<?php echo $this->config->get('GALKAControl_skype_mode') ?>"><img src="http://mystatus.skype.com/balloon/<?php echo $this->config->get('GALKAControl_skype') ?>" style="border: none;" width="150" height="60" alt="My status" /></a>
                        <?php } ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <h2 class="heading_title"><span><?php echo $text_contact; ?></span></h2>
            <div class="content"> <b><?php echo $entry_name; ?></b><br />
                <input type="text" name="name" value="<?php echo $name; ?>" />
                <br />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?>
                <br />
                <b><?php echo $entry_email; ?></b><br />
                <input type="text" name="email" value="<?php echo $email; ?>" />
                <br />
                <?php if ($error_email) { ?>
                <span class="error"><?php echo $error_email; ?></span>
                <?php } ?>
                <br />
                <b><?php echo $entry_enquiry; ?></b><br />
                <textarea name="enquiry" cols="40" rows="10" style="width: 99%;"><?php echo $enquiry; ?></textarea>
                <br />
                <?php if ($error_enquiry) { ?>
                <span class="error"><?php echo $error_enquiry; ?></span>
                <?php } ?>
            </div>
            <div class="buttons">
                <div class="right">
                    <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
                </div>
            </div>
        </form>
        <?php echo $content_bottom; ?></div>
</div>
<?php echo $footer; ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<?php if(($this->config->get('GALKAControl_map_status') == '1') && ($this->config->get('GALKAControl_status') == '1')) { ?>
<?php include(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/map.php'); ?>
<?php } ?>