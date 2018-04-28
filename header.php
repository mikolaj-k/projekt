<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

define('ROK_AKADEMICKI', (date('Y') - 1) . '/' . date('Y'));

require_once 'classes/Db.php';
require_once 'classes/Menu.php';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Internetowe Bazy Danych <?= ROK_AKADEMICKI ?></title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/styl.css" type="text/css" rel="stylesheet" />

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Pokaż nawigację</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">
						<span class="glyphicon glyphicon-book" aria-hidden="true"></span>
						Księgarnia internetowa IBD
					</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<?= Menu::generujOpcje('index.php', 'Strona główna') ?>
						<?= Menu::generujOpcje('ksiazki.lista.php', 'Książki')?>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</nav>

		<div class="container">
			<div class="row">
				<div class="col-md-9">