<?php
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "http://".$_SERVER['HTTP_HOST']."/mysite4.local/demo/curl/test.php");
	curl_exec($curl);
	curl_close($curl);
?>