﻿<?
class FetchIterator implements Iterator{
	/**
	* @var string
	*/
	public $_fetchCallback;
	/**
	* номер текущей итерации
	* @var int
	*/
	private $count;
	/**
	* текущее значение
	* @var mixed
	*/
	private $current;

	/**
	* @param string $fetchCallback функция обратного вызова
	*/
	public function __construct($fetchCallback){
		echo "construct";
        $this->_fetchCallback = $fetchCallback;
        $this->count = 0;
	}

    public function rewind(){}

    /**
     * Возврат ключа текущего элемента
     * @link http://php.net/manual/en/iterator.key.php
     * @return scalar скалярное значение, либо целое 0
     */
    public function key(){
        $this->count || $this->next();
        return $this->count + 1;
    }

	/**
	* Возврат значения текущего элемента
	* @link http://php.net/manual/en/iterator.current.php
	* @return mixed Возвращает любой тип
	*/
	public function current(){
        echo "current";
		$this->count || $this->next();
        return $this->current;
	}



	/**
	* Проверка текущей позиции
	* @link http://php.net/manual/en/iterator.valid.php
	* @return boolean Возвращаемое значение приводится к булеву типу, далее исполняется
	* Возвращает true или false
	*/
	public function valid(){
		$this->count || $this->next();
        return $this->validate();
	}

	/**
	* @return bool
	*/
	private function validate(){
		return false != $this->current || is_string($this->current);
	}

	/**
	* Смещаемся на следующий элемент
	* @link http://php.net/manual/en/iterator.next.php
	* @return void Любое возвращаемое значение игнорируется
	*/
	public function next(){
		if($this->count && ! $this->validate()){
            return;
        }
        $this->fetch();
        $this->count++;
	}

	/**
	* Используем функцию обратного вызова
	*/
	public function fetch(){
		$func = $this->_fetchCallback;
        $this->current = $func();
	}
}
?>