<?php

// jesli nie podano parametru id, przekieruj do listy książek
if(empty($_GET['id'])) {
    header("Location: ksiazki.lista.php");
    exit();
}

$id = (int)$_GET['id'];

include 'header.php';
require_once 'classes/Ksiazki.php';

$ksiazki = new Ksiazki();
$dane = $ksiazki->pobierz($id)

?>

<h2><?=$dane['tytul']?></h2>

<p>
	<a href="ksiazki.lista.php">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		Powrót
	</a>
</p>

<p>szczegóły książki......</p>

<?php include 'footer.php'; ?>