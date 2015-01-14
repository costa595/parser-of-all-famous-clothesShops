<?php

$host = 'localhost';
$dbname = 'items';

$user="root";
$pass="";

try{
	$DBH = new PDO("mysql:host=$host;dbname=$dbname",$user,$pass);
}

catch(PDOException $e) {  
    echo $e->getMessage();  
}

$query1 = $DBH->prepare("CREATE TABLE IF NOT EXISTS clothes(id MEDIUMINT UNSIGNED AUTO_INCREMENT NOT NULL,label VARCHAR(4) NOT NULL , brand VARCHAR(20) NOT NULL , type VARCHAR(30) NOT NULL , price VARCHAR(30) NOT NULL , src VARCHAR(60) NOT NULL , sizes TEXT NOT NULL, shop VARCHAR(30) NOT NULL, sex VARCHAR(1) NOT NULL,PRIMARY KEY(id))");

$query1->execute();

?>