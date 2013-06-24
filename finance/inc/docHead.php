<?php
#this is a generated file, with only a few changes in the links and scripts locations

	function get_title() {
		$exp = explode('/',$_SERVER['REQUEST_URI']);
		if(end($exp) == '' || $exp[count($exp)-1] == 'finance')
			header('Location:index.php');
		
		if(end($exp) == 'index.php'){
			return ' | Login';
		}
		else{
			$exp2 = explode('.',end($exp));
		}
		
		
		return ' | '.ucfirst($exp2[0]);
	}

?><!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ender's Finance <?php print get_title(); ?></title>
<link rel="icon" 
      type="image/png" 
      href="favicon.png">
<link href="boilerplate.css" rel="stylesheet" type="text/css">
<link href="css/fin.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/flexigrid.pack.css" />

<!-- 
To learn more about the conditional comments around the html tags at the top of the file:
paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/
-->

<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="respond.min.js"></script>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/json2.js"></script>
<script type="text/javascript" src="js/flexigrid.js"></script>
<script type="text/javascript" src="js/validate.js"></script>
<script type="text/javascript">

</script>
</head>