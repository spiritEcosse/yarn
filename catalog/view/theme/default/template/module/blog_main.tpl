<style>


.fich {margin: 0px 0 0px 0px; overflow:hidden}

.gallery_fich .section {float:left; width:250px; margin:1px 1px 0 0; margin-right: 10px; position:relative}


.gallery_fich .section a img {width:250px; height:134px;}

.gallery_fich .hid, .gallery_fich .hid_small {text-shadow: 0 1px 0 rgba(0, 0, 0, 0.5);}
.gallery_fich .hid {position:absolute; bottom:0; color:#fff;
opacity: 0.6;
background: #000; width:410px; font-size: 14px; padding: 9px 75px 8px 16px;text-decoration:none !important;

}
.gallery_fich a {text-decoration:none !important;}
.gallery_fich .hid_small {width: 190px; padding: 7px 45px 7px 15px;}
.gallery_fich .section .width_img{width:250px; height:134px; display:block}
.gallery_fich a:hover .hid {background-color:black; text-decoration:none !important; opacity: 1;}
.fich  p { margin-bottom: -5px; }


.comments-count {
    display: block;
    right: 8px;
    color: #999999;
    position: absolute;
    top: 8px;
}


.bubble a {
    background: none repeat scroll 0 0 #000000;
    color: #FFFFFF;
    font-size: 11px;
    line-height: 1;
    padding: 3px 7px;
    text-decoration: none;
}

.mbubble {
display: block;
  width: 0;
    height: 0;
    border-top: 10px solid black;
    border-right: 10px solid transparent;
   margin-top: 3px;
   margin-left: 5px;
}

.com-text {
    display: none;
}

</style>

 <?php if ($records) { ?>
   <div class="box-title">

<ins class="box-ins"><?php echo $heading_title; ?></ins>
</div>
<div class="fich">
    <div class="gallery_fich">
     <?php foreach ($records as $record) { ?>
         <div class="section">

                <a class="width_img" href="<?php echo $record['href']; ?>" title="">
                <img src="<?php echo $record['thumb']; ?>" width="255" height="135" alt="" title=""/>

                <p class="hid hid_small"><?php echo $record['name']; ?></p>
                </a>

                    <span class="comments-count small_g">
                        <span class="com-text"><?php echo $text_comments; ?></span>
                            <span class="bubble">
                            <a href="<?php echo $record['href']; ?>#tab-comment"><?php echo $record['comments']; ?></a>
                            </span>
                            <span class="mbubble">
                            </span>
            		</span>

        </div>

<?php } ?>

                    </div>
</div>
<?php } ?>

<div style="overflow: hidden; width: 100%; margin-bottom: 0px;">&nbsp;</div>