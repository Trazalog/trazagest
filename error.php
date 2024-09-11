<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="author" content="<?php echo APP_TITLE; ?>" />
	<meta name="description" content="<?php echo APP_TITLE; ?>" />
	<meta name="keywords" content="RIA, web app, application" />	
	<link rel="stylesheet" type="text/css" href="<?php echo THEME_PATH; ?>style.css" media="screen" />
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="icon" type="image/gif" href="animated_favicon1.gif">
	<title><?php echo APP_TITLE; ?></title>
</head>
<body>
	<div id="content">
		<div id="top_info">
			<p>Bienvenido al <b>SISTEMA</b> <span id="loginbutton"><a href="#" title="Log In">&nbsp;</a></span><br />
			<b>You are not Logged in!</b> <a href="logout.php">Log in</a> to check your messages.
		</div>
		
		<div id="logo">
			<h1><a href="#" title="We share the relevant."><?php echo APP_TITLE, ' - Ver. ', APP_VERSION; ?></a></h1>
			<p class="style2" id="slogan">EMPAQUE S.A.</p>
	  </div>
				
<ul id="tablist">
			<li><a class="current" href="#" accesskey="n"><span class="key">N</span>ews</a></li><li><a href="#" accesskey="b"><span class="key">B</span>logs</a></li><li><a href="#" accesskey="p"><span class="key">P</span>hotos</a></li><li><a href="#" accesskey="r">P<span class="key">r</span>ofiles</a></li><li><a href="#" accesskey="f"><span class="key">F</span>eeds</a></li><li><a href="#" accesskey="o">Br<span class="key">o</span>adcast News</a></li>
		</ul>
		<div id="buttons">
			<div id="buttons_set">
				<?php echo $the_buttons_set; ?>
			</div>
		</div>
		<div id="search">
			<form method="post" action="?">
				<p><input type="text" name="search" class="search" /> <input type="submit" value="Search" class="button" /></p>
			</form>
		</div>
		<div id="sidebar">
			<div class="sidebar_articles">
				<p><img src="<?php echo THEME_PATH; ?>images/image1.gif" alt="Image" title="Image" class="image" /><b>Lorem ipsum dolor sit amet</b><br />
			  consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam <a href="#">erat volutpat</a>. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis <a href="#">nisl ut aliquip ex</a>.</p>
		  	</div>
		</div>

		<div id="main">
			<div class="subheader">
				<p>RECORCHOLIS! Parece que no tiene permisos suficientes para acceder a esta p&aacute;gina - <a href="javascript:history.back()"> Volver </A></p>
			</div>
		</div>
		
		<div id="footer">
			<p class="left">EMPAQUE S.A. - Av. Circunvalación y Pedro Alvarez <br />
		  C.P. 5400 - San Juan - Argentina - Tel.: (+054)-(0264) 4214137 - 4215657 </p>
		  <p class="right"><?php echo APP_TITLE, ' - Ver. ', APP_VERSION; ?><br />Desarrollado por <a href="http://www.omnimedios.com.ar/" target="_blank">OMNIMEDIOS</a>, bajo licencia <a href="http://creativecommons.org/licenses/by/2.5/">Creative Commons</a><br /></p>
		</div>
</div>
</body>
</html>