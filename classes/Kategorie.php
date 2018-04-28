<?php

class Kategorie
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
	 * Pobiera wszystkie kategorie.
	 *
	 * @return array
	 */
	public function pobierzWszystkie()
	{
		$sql = "SELECT * FROM kategorie";

		return $this->db->pobierzWszystko($sql);
	}

}
