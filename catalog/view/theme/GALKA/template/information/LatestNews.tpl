<?php
//-----------------------------------------------------
// LatestNews Module for GALKA Premium theme by Dimitar Koev 
// Copyright (C) 2012 Dimitar Koev. All Rights Reserved!
// Author: Dimitar Koev
// Author websites: http://www.althemist.com  /  http://www.dimitarkoev.com
// @license - Copyrighted Commercial Software                           
// support@althemist.com                         
//-----------------------------------------------------
?>

<?php echo $header; ?>
<div class="title-holder">
<div class="inner">
<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	
</div>
</div>
<div class="inner">
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
<h2 class="heading_title"><span><?php echo $heading_title; ?></span></h2>
<?php echo $content_top; ?>	
	<?php if(isset($LatestNews_info)) { ?>
		<div class="LatestNews-holder">

            <div class="LatestNews-content">
				
				
				<?php echo $description; ?>
			</div>
<?php
$havID = $app_id;
?>            
<?php if($havID != null) { ?>            
<div class="box">
  <h3><?php echo $comments; ?> <?php echo $heading_title; ?> (<fb:comments-count href="<?php echo $current_url; ?>"></fb:comments-count>)</h3>
  <div class="box-content">
    <div class="box-product">
		<div class="fb-comments" data-href="<?php echo $current_url; ?>" data-num-posts="10" data-width="700" data-colorscheme="light"></div>
    </div>
  </div>
</div>

<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo $app_id; ?>', // App ID
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     d.getElementsByTagName('head')[0].appendChild(js);
   }(document));   
</script>
<?php } ?>
		</div>
		
        
        
	<?php } elseif (isset($LatestNews_data)) { ?>
		<?php foreach ($LatestNews_data as $LatestNews) { ?>
        <?php $image_feature = $this->model_tool_image->resize($LatestNews['thumb'],  150, 113); ?>
			<div class="LatestNews-unit-big">
				<h3><?php echo $LatestNews['title']; ?></h3>
                
					<a title="<?php echo $LatestNews['title']; ?>" href="<?php echo $LatestNews['href']; ?>"><img src="<?php echo $image_feature; ?>" alt="<?php echo $LatestNews['title'];?>" /></a>
                    
                    <p><?php echo strip_tags($LatestNews['description']); ?>...</p>
                    
                    <a class="r_more" href="<?php echo $LatestNews['href']; ?>"> <?php echo $text_more; ?></a>
					
					<span class="post_date"><?php echo $LatestNews['posted']; ?></span>
				
			</div>
		<?php } ?>
	
    	<div class="pagination"><?php echo $pagination; ?></div>
	<?php } ?>
<?php echo $content_bottom; ?>    
</div>
</div>


<?php echo $footer; ?>