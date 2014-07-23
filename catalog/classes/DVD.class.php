<?php
class DVD{
	protected $_id;
	protected $_title;
	protected $_band;
	protected $_tracks = array();
	protected $_db;
	
	function __construct($id=0){
		$this->_id = $id;
		$this->_db = DB::getInstance();
	}
	
	public function setTitle($title){
		$this->_title = $title;
	}
	
	public function setBand($band){
		$this->_band = $band;
	}
	/* ���������� ����� � ��������� ��� ����������� ��������� ����������� */
	public function addTrack($track){
		$this->_tracks[] = $track;
	}
	/* ������������ ������ ����� */
	public function buy(){
		$this->_db->updateQuantity($this->_id, -1);
		// ������ ��������
	}
	/* ���������� ������ ����������� - ������ */
	public function showCatalog(){
		$result = $this->_db->selectItems();
		if(is_array($result))
			return $result;
		else
			return '�� ��������';
	}
	/* 	���������� ������ ���� ������ ���������� ����������� 
	*	��������������� �� ��������
	*/
	public function showBand($band){
		$result = $this->_db->selectItemsByBand($band);
		if(is_array($result))
			return $result;
		else
			return '�� ��������';
	}
	/* ���������� ��������� ������ �� ������� ������ */
	public function showAlbum($id){
		$result = $this->_db->selectItemsByTitle($id);
		if(is_array($result))
			return $result;
		else
			return '�� ��������';
	}
	/* ���������� ���������� �� ������� � ������� XML */
	public function getXML($id){
        $doc = new DomDocument('1.0', 'utf-8');
        $doc->formatOutput = true;
        $doc->preserveWhiteSpace = false;
        $root = $doc->createElement('dvd');
        $doc->appendChild($root);
        $band = $doc->createElement('band', $this->_band);
        $root->appendChild($band);
        $title = $doc->createElement('title', $this->_title);
        $root->appendChild($title);

        $tracks = $doc->createElement('tracks');
        $root->appendChild($tracks);
        $result = $this->_db->selectItemsByTitle($id);
        foreach($result as $item){
            $track = $doc->createElement('track', $item['title']);
            $tracks->appendChild($track);
        }
        $file_name = $this->_band.'-'.$this->_title.'.xml';
        file_put_contents('output/'.$file_name, $doc->saveXML());
	}
	
	/* ���������� ��������� ������ � ����. ������ ��� ������������ */
	function __destruct(){
		if($this->_tracks){
			file_put_contents(__DIR__.'\tracks.log', time().'|'.serialize($this->_tracks)."\n", FILE_APPEND);
		}
	}
}

class DVDStrategy{
    protected  $_strategy;

    public function setStrategy($strategy){
        $this->_strategy = $strategy;
    }
    public function get($id){
        $this->_strategy->get($id);
    }

    function __call($method, $args){
        $this->_strategy->$method($args[0]);
    }
}

interface DVDFormat{
    function get($id);
}

class DVDasXML extends DVD implements DVDFormat{
    public function get($id){
        $doc = new DomDocument('1.0', 'utf-8');
        $doc->formatOutput = true;
        $doc->preserveWhiteSpace = false;
        $root = $doc->createElement('dvd');
        $doc->appendChild($root);
        $band = $doc->createElement('band', $this->_band);
        $root->appendChild($band);
        $title = $doc->createElement('title', $this->_title);
        $root->appendChild($title);

        $tracks = $doc->createElement('tracks');
        $root->appendChild($tracks);
        $result = $this->_db->selectItemsByTitle($id);
        //print_r($result);
        //exit;
        foreach($result as $item){
            $track = $doc->createElement('track', $item['title']);
            $tracks->appendChild($track);
        }
        $file_name = $this->_band.'-'.$this->_title.'.xml';
        file_put_contents('output/'.$file_name, $doc->saveXML());
    }
}

class DVDasJSON extends DVD implements DVDFormat{
    public function get($id){
        $doc = array();
        $doc['dvd']['band'] = $this->_band;
        $doc['dvd']['title'] = $this->_title;
        $doc['dvd']['tracks'] = array();
        $result = $this->_db->selectItemsByTitle($id);
        foreach($result as $item){
            $doc['dvd']['tracks'][] = $item['title'];
        }
        $file_name = $this->_band."-".$this->_title.".json";
        file_put_contents("output/".$file_name, json_encode($doc));

    }
}

class BonusDVD extends DVD{
    function __construct($id=0){
        parent::__construct();
        $this->_tracks[] = -1;

    }
}

class DVDFactory{
    public static function create($dvdType){
        if($dvdType=='Bonus')
            return new BonusDVD();
        else
            return new DVD();
    }
}
?>