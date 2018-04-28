<?php

/**
 * Klasa obsługująca generowanie menu.
 *
 */
class Menu
{
    /**
     * Generuje opcję listy menu.
     *
     * @param string $plik Nazwa pliku do którego ma kierować link
     * @param string $nazwa Nazwa która ma wyświetlić się na linku
     * @return string
     */
    public static function generujOpcje($plik, $nazwa)
    {
	$biezacy = basename($_SERVER["SCRIPT_NAME"]);

	if($biezacy == $plik)
	    return "<li class='active'><a href='$plik'>$nazwa</a></li>";
	else
	    return "<li><a href='$plik'>$nazwa</a></li>";
    }
}