<?php

class Ksiazki
{
	/**
	 * Instancja klasy obsługującej połączenie do bazy.
	 *
	 * @var Db
	 */
	private $db;

	public function __construct()
	{
		$this->db = new Db();
	}

	/**
	 * Pobiera wszystkie książki.
	 *
	 * @return array
	 */
	public function pobierzWszystkie()
	{
		$sql = "select k.*, CONCAT(a.imie, ' ', a.nazwisko) as autor, kat.nazwa as nazwa_kategorii from ksiazki k join autorzy a on k.id_autora = a.id join kategorie kat on k.id_kategorii = kat.id";

		return $this->db->pobierzWszystko($sql);
	}

	/**
	 * Pobiera zapytanie SELECT oraz jego parametry;
	 *
	 * @return array
	 */
	public function pobierzZapytanie($params)
	{
		$parametry = [];
		$sql = "SELECT k.*, CONCAT(a.imie, ' ', a.nazwisko) as autor, kat.nazwa as nazwa_kategorii FROM ksiazki k join autorzy a on k.id_autora = a.id join kategorie kat on k.id_kategorii = kat.id WHERE 1=1 "; 
                //where 1=1 jest potrzebne do budowania warunków, żeby sie potem nie zastanwaic czy dodac Where czy juz AND

		// dodawanie warunków do zapytanie
		if(!empty($params['fraza'])) {
			$sql .= "AND (k.tytul LIKE :fraza OR k.opis LIKE :fraza OR CONCAT(a.imie, ' ', a.nazwisko) LIKE :fraza)";
			$parametry[':fraza'] = "%$params[fraza]%";
		}
		if(!empty($params['id_kategorii'])) {
			$sql .= "AND k.id_kategorii = :id_kategorii ";
			$parametry[':id_kategorii'] = $params['id_kategorii'];
		}
		
		// dodawanie sortowania
		if(!empty($params['sortowanie'])) {
			$kolumny = ['k.tytul', 'k.cena', 'a.nazwisko'];
			$kierunki = ['ASC', 'DESC'];
			list($kolumna, $kierunek) = explode(' ', $params['sortowanie']);
			
			if(in_array($kolumna, $kolumny) && in_array($kierunek, $kierunki)) {
				$sql .= " ORDER BY " . $params['sortowanie'];
			}
		}
		
		return ['sql' => $sql, 'parametry' => $parametry];
	}
	
	/**
	 * Pobiera stronę z danymi książek.
	 * 
	 * @param string $select
	 * @param array $params
	 * @return array
	 */
	public function pobierzStrone($select, $params)
	{
		return $this->db->pobierzWszystko($select, $params);
	}
	
	/**
	 * Pobiera dane książki o podanym id.
	 * 
	 * @param int $id
	 * @return array
	 */
	public function pobierz($id)
	{
		return $this->db->pobierz('ksiazki', $id);
	}

	/**
	 * Pobiera najlepiej sprzedające się książki.
	 * 
	 */
	public function pobierzBestsellery()
	{
		$sql = "select k.*, CONCAT(a.imie, ' ', a.nazwisko) as autor, kat.nazwa as nazwa_kategorii from ksiazki k join autorzy a on k.id_autora = a.id join kategorie kat on k.id_kategorii = kat.id ORDER BY RAND() LIMIT 5";

		// uzupełnić funkcję
                return $this->db->pobierzWszystko($sql);
	}
}