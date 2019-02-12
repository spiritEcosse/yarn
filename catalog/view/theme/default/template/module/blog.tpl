<div class="box">

  <div class="box-title">

<ins class="box-ins"><?php echo $heading_title; ?></ins>
</div>



    <div class="box-ul">

<?php
if (count($myblogs)>0) {
foreach ($myblogs as $blogs)
{
?>
<!--
<div style="padding-left:<?php echo $blogs['level']*20; ?>px;">
 <a href="<?php echo $blogs['href']; ?>"><?php echo $blogs['name']; ?></a>
</div>
-->
<?php
for ($i=0; $i<$blogs['flag_start']; $i++)
{


?>
<ul style="padding-left:<?php echo ($blogs['level']*10)+10; ?>px; <?php if(!$blogs['display']) echo 'display:none;' ?>  ">
<li><a href="<?php if($blogs['active']=='active') echo $blogs['href']."#";  else echo $blogs['href']; ?>" class="<?php if($blogs['active']=='active') echo 'active'; if($blogs['active']=='pass') echo 'pass'; ?>"><?php echo $blogs['name']; if ($blogs['count']>0) echo  " (".$blogs['count'].")"; ?></a>
<?php


for ($m=0; $m<$blogs['flag_end']; $m++)
{
?> </li>
</ul>
<?php
}
}
?>


<?php
}
}
?>


   </div>
</div>