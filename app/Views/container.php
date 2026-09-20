<?php 
echo view('header');
if(isset($include) && $include!=""){
	echo view($include);
}
echo view('footer'); 
?>