<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 22.07.14
 * Time: 18:39
 */

//one more commit
//recommit
class Author{
    private $fname;
    private $lname;

    public function _construct($fn, $ln){
        $this->fname = $fn;
        $this->lname = $ln;

    }

    function getFName(){/**/}
    function getLName(){/**/}


}

class Book{
    private $_title;
    private $_author;

    public function _construct($t, Author $a){
        $this->_title = $t;
        $this->_author = $a;

    }
    function getAuthor(){/**/}
    function getTitle(){/**/}
}
?>