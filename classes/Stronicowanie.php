<?php

class Stronicowanie
{
	/**
	 * Instancja klasy obsługującej połączenie do bazy.
	 *
	 * @var Db
	 */
	private $db;

	/**
	 * Liczba rekordów wyświetlanych na stronie.
	 * 
	 * @var int
	 */
	private $naStronie = 5;

	/**
	 * Aktualnie wybrana strona.
	 *
	 * @var int
	 */
	private $strona = 0;

	/**
	 * Dodatkowe parametry przekazywane w pasku adresu (metodą GET).
	 * 
	 * @var array
	 */
	private $parametryGet = [];

	/**
	 * Parametry przekazywane do zapytania SQL.
	 * 
	 * @var array
	 */
	private $parametryZapytania;
	
	public function __construct($parametryGet, $parametryZapytania)
	{
		$this->db = new Db();
		$this->parametryGet = $parametryGet;
		$this->parametryZapytania = $parametryZapytania;

		if(!empty($parametryGet['strona']))
			$this->strona = (int) $parametryGet['strona'];
	}

	/**
	 * Dodaje do zapytania SELECT klauzulę LIMIT.
	 *
	 * @param string $select
	 * @return string
	 */
	public function dodajLimit($select)
	{
		return $select . " LIMIT " . ($this->strona * $this->naStronie) . ", $this->naStronie";
	}
        

        public function getNaStronie($select)
        {
            $start = ($this->strona * $this->naStronie) + 1;
            $stop = $start + $this->naStronie - 1;
            $rekordow = $this->db->policzRekordy($select, $this->parametryZapytania);
            
            if($rekordow == 1)
                return "<p> Wyświetlanie $rekordow rekordu</p>";
            if($rekordow < $this->naStronie)
                return "<p> Wyświetlanie $rekordow z $rekordow rekordów</p>";
            if($stop > $rekordow)
                return "<p> Wyświetlanie $start - $rekordow z $rekordow rekordów</p>"; 
            return "<p> Wyświetlanie $start - $stop z $rekordow rekordów</p>";
        }
        
	/**
	 * Generuje linki do wszystkich podstron.
	 *
	 * @param string $select Zapytanie SELECT
	 * @param string $plik Nazwa pliku, do którego będą kierować linki
	 * @return string
	 */
	public function pobierzLinki($select, $plik)
	{
		$rekordow = $this->db->policzRekordy($select, $this->parametryZapytania);
		$liczbaStron = ceil($rekordow / $this->naStronie);
		$parametry = $this->_przetworzParametry();
                $ostatnia = $liczbaStron -1;
                $poprzednia = $this->strona -1;
                $nastepna = $this->strona +1;

		$linki = "<ul class='pagination'>";
                
                if($liczbaStron > 1 && ($this->strona +1) > 1)
                {
                    $linki.="<li class='page-item'><a class='page-link' href='$plik?$parametry&strona=0'>Początek</a></li>";                    
                    $linki.="<li class='page-item'><a class='page-link' href='$plik?$parametry&strona=$poprzednia'>Poprzednia</a></li>";
                }
                
		for($i = 0; $i < $liczbaStron; $i++) {
			if($i == $this->strona)
				$linki .= "<li class='active'><span>" . ($i + 1) . "</span></li>";
			else
				$linki .= "<li><a href='$plik?$parametry&strona=$i'>" . ($i + 1) . "</a></li>";
				
		}
                if($liczbaStron > 1 && ($this->strona +1) < $liczbaStron)
                {
                    $linki.="<li class='page-item'><a class='page-link' href='$plik?$parametry&strona=$nastepna'>Następna</a></li>";
                    $linki.="<li class='page-item'><a class='page-link' href='$plik?$parametry&strona=$ostatnia'>Koniec</a></li>";

                }
		$linki .= "</li>";

		return $linki;
	}

	/**
	 * Przetwarza parametry wyszukiwania.
	 * Wyrzuca zbędne elementy i tworzy gotowy do wstawienia w linku zestaw parametrów.
	 *
	 * @return string
	 */
	private function _przetworzParametry()
	{
		$temp = array();
		$usun = array('szukaj', 'strona');
		foreach($this->parametryGet as $kl => $wart) {
			if(!in_array($kl, $usun))
				$temp[] = "$kl=$wart";
		}

		return implode('&', $temp);
	}
}
