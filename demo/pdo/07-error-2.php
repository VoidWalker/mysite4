<?php
try {
    $db = new PDO("sqlite:users.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connected to database<br>';



    $sql = "SELECT username FROM user";
    foreach ($db->query($sql) as $row){
        print $row['name'] .' - '. $row['email'] . '<br>';
    }

    $db = null;
}catch(PDOException $e){
	echo $e->getCode()."<br>";
    echo $e->getMessage()."<br>";
}

?>