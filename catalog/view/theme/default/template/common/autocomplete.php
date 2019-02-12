<?php
header('Content-Type: text/html; charset=utf-8');
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
//   if($_GET['q']){
    $base = @file("autocomplete.dat");
    for ( $i = 0; $i<count($base); $i++ ){
	  $row_base = explode(":", $base[$i]);
	  $res = mb_strpos(mb_strtolower($row_base[1],"UTF-8"), mb_strtolower($_GET['q'],"UTF-8"));
	  if($res!==false&&$res==0) {
	    $row_base[3] = trim($row_base[3]);
	  	print $row_base[1]."|".$row_base[3]."|".$row_base[2]."|".$row_base[0]."\n";
	  }
    }
//   }
}
?>