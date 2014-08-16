<?php
//include "FetchIterator.class.php";
include "INewsDB.class.php";

class NewsDB implements INewsDB, IteratorAggregate{
	const DB_NAME = 'news.db';
	protected $_db;
    protected $_items = [];
	function __construct(){
		if(is_file(self::DB_NAME) and filesize(self::DB_NAME)>0){
			$this->_db = new PDO("sqlite:".self::DB_NAME);
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}else{
            try{
                $this->_db = new PDO("sqlite:".self::DB_NAME);
                $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->_db->beginTransaction();
                $sql = "CREATE TABLE msgs(
                                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                                        title TEXT,
                                        category INTEGER,
                                        description TEXT,
                                        source TEXT,
                                        datetime INTEGER
                                    )";
                $this->_db->exec($sql);
                $sql = "CREATE TABLE category(
                                            id INTEGER PRIMARY KEY AUTOINCREMENT,
                                            name TEXT
                                        )";
                $this->_db->exec($sql);
                $sql = "INSERT INTO category(id, name)
                            SELECT 1 as id, 'Politics' as name
                            UNION SELECT 2 as id, 'Culture' as name
                            UNION SELECT 3 as id, 'Sport' as name";
                $this->_db->exec($sql);

                $this->_db->commit();
            }catch (PDOException $e){
                echo $e->getCode().":".$e->getMessage();
                $this->_db->rollBack();
                echo "Cannot create DB.<br>";
            }
		}
        $this->getCategories();
	}
    protected function getCategories(){
        try{
            $sql = "SELECT id, name
                    FROM category";
            $result = $this->_db->query($sql);
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $this->_items[$row['id']] = $row['name'];
        }
        }catch (PDOException $e){
            echo $e->getCode().":".$e->getMessage();
        }
    }
	function __destruct(){
		unset($this->_db);
	}
    function getIterator(){
        return new ArrayIterator($this->_items);
    }
	function saveNews($title, $category, $description, $source){
		try{
        $dt = time();
		$sql = "INSERT INTO msgs(title, category, description, source, datetime)
					VALUES($title, $category, $description, $source, $dt)";
		$ret = $this->_db->exec($sql);
		if($ret === false)
			return false;
		return true;
        }catch (PDOException $e){
            echo $e->getCode().":".$e->getMessage();
        }
	}	
	protected function db2Arr($data){
		$arr = array();
		while($row = $data->fetch(PDO::FETCH_ASSOC))
			$arr[] = $row;
		return $arr;	
	}
	public function getNews(){
		try{
			$sql = "SELECT msgs.id as id, title, category.name as category, description, source, datetime 
					FROM msgs, category
					WHERE category.id = msgs.category
					ORDER BY msgs.id DESC";
			$result = $this->_db->query($sql);
			return $this->db2Arr($result);
		}catch(PDOException $e){
            echo $e->getCode().":".$e->getMessage();
		}
	}	
	public function deleteNews($id){
		try{
			$sql = "DELETE FROM msgs WHERE id = $id";
			$this->_db->exec($sql);
			return true;
		}catch(PDOException $e){
            echo $e->getCode().":".$e->getMessage();
			return false;
		}
	}
	function clearData($data){
		return $this->_db->quote($data);
	}	
}
?>