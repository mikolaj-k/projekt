<?php
include 'header.php';
require_once 'classes/Ksiazki.php';
require_once 'classes/Kategorie.php';
require_once 'classes/Stronicowanie.php';

// pobieranie kategorii
$kategorie = new Kategorie();
$listaKategorii = $kategorie->pobierzWszystkie();

// pobieranie książek
$ksiazki = new Ksiazki();
$zapytanie = $ksiazki->pobierzZapytanie($_GET);

// dodawanie warunków stronicowania i generowanie linków do stron
$stronicowanie = new Stronicowanie($_GET, $zapytanie['parametry']);
$linki = $stronicowanie->pobierzLinki($zapytanie['sql'], 'ksiazki.lista.php');
$select = $stronicowanie->dodajLimit($zapytanie['sql']);
$lista = $ksiazki->pobierzStrone($select, $zapytanie['parametry']);
?>

<h1>Książki</h1>

<form method="get" action="" class="form-inline">
	<div class="form-group">
		<label for="fraza">Szukaj</label>
	    <input type="text" name="fraza" id="fraza" class="form-control" value="<?=(!empty($_GET['fraza']) ? $_GET['fraza'] : '')?>" />
	</div>
    <div class="form-group">
	    <label for="id_kategorii">Kategoria</label>
	    <select name="id_kategorii" id="id_kategorii" class="form-control">
			<option value="">-</option>

			<?php foreach($listaKategorii as $kat): ?>
				<option
				value="<?=$kat['id']?>"
				<?php if(!empty($_GET['id_kategorii']) && $_GET['id_kategorii'] == $kat['id']) echo 'selected="selected"' ?>
				><?=$kat['nazwa']?></option>
			<?php endforeach; ?>
	    </select>
    </div>
	
    <div class="form-group">
	    <label for="sortowanie">Sortowanie</label>
	    <select name="sortowanie" id="sortowanie" class="form-control">
			<option value="">-</option>
			<option value="k.tytul ASC" 
				<?php if(!empty($_GET['sortowanie']) && $_GET['sortowanie'] == 'k.tytul ASC') echo 'selected="selected"' ?>
			>tytule rosnąco</option>
			<option value="k.tytul DESC"
				<?php if(!empty($_GET['sortowanie']) && $_GET['sortowanie'] == 'k.tytul DESC') echo 'selected="selected"' ?>
			>tytule malejąco</option>
			<option value="k.cena ASC"
				<?php if(!empty($_GET['sortowanie']) && $_GET['sortowanie'] == 'k.cena ASC') echo 'selected="selected"' ?>
			>cenie rosnąco</option>
			<option value="k.cena DESC"
				<?php if(!empty($_GET['sortowanie']) && $_GET['sortowanie'] == 'k.cena DESC') echo 'selected="selected"' ?>
			>cenie malejąco</option>
                        <option value="a.nazwisko ASC"
				<?php if(!empty($_GET['sortowanie']) && $_GET['sortowanie'] == 'a.nazwisko ASC') echo 'selected="selected"' ?>
			>nazwisku autora rosnąco</option>
			<option value="a.nazwisko DESC"
				<?php if(!empty($_GET['sortowanie']) && $_GET['sortowanie'] == 'a.nazwisko DESC') echo 'selected="selected"' ?>
			>nazwisku autora malejąco</option>
	    </select>
    </div>
	
	<button class="btn btn-default" type="submit">Szukaj</button>
</form>

<hr/>

<table class="table table-striped table-condensed">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Tytuł</th>
			<th>Autor</th>
			<th>Kategoria</th>
			<th>Cena PLN</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($lista as $ks): ?>
			<tr>
				<td>
					<?php if(!empty($ks['zdjecie'])): ?>
						<img src="zdjecia/<?=$ks['zdjecie']?>" alt="<?=$ks['tytul']?>" />
					<?php else: ?>
						brak zdjęcia
					<?php endif; ?>
				</td>
				<td><?=$ks['tytul']?></td>
				<td><?=$ks['autor']?></td>
				<td><?=$ks['nazwa_kategorii']?></td>
				<td><?=$ks['cena']?></td>
				<td>
					<a href="#" title="dodaj do koszyka">
						<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
					</a>
					<a href="ksiazki.szczegoly.php?id=<?=$ks['id']?>" title="szczegóły">
						<span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?=$stronicowanie->getNaStronie($zapytanie['sql']); ?>

<nav class="text-center">
    <?=$linki?>
</nav>


<?php include 'footer.php'; ?>