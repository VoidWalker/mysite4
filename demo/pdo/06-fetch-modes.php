<?php

    $db = new PDO("sqlite:users.db");

	$sql = "SELECT * FROM user";

    $stmt = $db->query($sql);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<pre>";
    print_r($result);

    foreach($result as $key=>$val){
    	echo $key.' - '.$val.'<br>';
    }

?>