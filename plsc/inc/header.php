<?php 
			$name = $_SERVER['PHP_SELF'];
			$name = explode('/',$name);
			$name = end($name);
			$name = explode('.',$name);
			$name = $name[0] == 'index' ? 'Home' : ucfirst($name[0]);
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
<title>PLSC 328 | <?php print $name ?></title>
<link href="boilerplate.css" rel="stylesheet" type="text/css">
<link href="do.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<!-- 
To learn more about the conditional comments around the html tags at the top of the file:
paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/

Do the following if you're using your customized build of modernizr (http://www.modernizr.com/):
* insert the link to your js here
* remove the link below to the html5shiv
* add the "no-js" class to the html tags at the top
* you can also remove the link to respond.min.js if you included the MQ Polyfill in your modernizr build 
-->
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="respond.min.js"></script>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
</head>
<body>
<div class="gridContainer clearfix">
	<div id="LayoutDivHead">
		
		<h1>PLSC 328 <?php print $name ?></h1>
	</div>
	<div id="LayoutDiv1"><ul id="MenuBar1" class="MenuBarHorizontal">
	<li><a href="index">Home</a></li>
	<li><a class="MenuBarItemSubmenu" href="notes">Class Notes</a>
		<ul>
			<li><a href="notes?q=0">Notes by Author</a></li>
			<li><a href="notes?q=1">Notes by Topic</a></li>
			<li><a href="notes?q=2">Notes by Week</a></li>
		</ul>
	</li>
	<li><a href="#">Commands and Equations</a>
		<ul>
			<li><a href="stata">STATA commands</a></li>
			<li><a href="equations">Equations</a></li>
		</ul>
	</li>
	<li><a href="outline">Course Outline</a></li>
</ul>
</div>

