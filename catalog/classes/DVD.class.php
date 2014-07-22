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
?>