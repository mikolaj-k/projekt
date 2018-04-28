<?php
require_once 'classes/Ksiazki.php';

$ksiazki = new Ksiazki();
$lista = $ksiazki->pobierzBestsellery();
?>

<div class="col-md-3">
    <h1>Bestsellery</h1>

    <ul>
        <?php foreach ($lista as $ks): ?>
            <li>
                <a href="ksiazki.szczegoly.php?id=<?= $ks['id'] ?>" title="szczegóły">
                    <p><?= $ks['tytul'] ?> , <?= $ks['autor'] ?></p>
                </a>
                <?php if (!empty($ks['zdjecie'])): ?>
                    <img src="zdjecia/<?= $ks['zdjecie'] ?>" alt="<?= $ks['tytul'] ?>" />
                <?php else: ?>
                    brak zdjęcia
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>