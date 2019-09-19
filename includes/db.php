<?php
//Osnovni podaci od baze podataka koji su store u array
$db['db_host'] = "localhost";
$db['db_user'] = 'root';
$db['db_pass'] = '';
$db['db_name'] = 'cms';


//Loop kroz array i uspostva Const varijabli
foreach($db as $key => $value){
    define(strtoupper($key), $value);
}

//Upotreba const varijabli sa podacima od baze pdoataka i mysqli funkcija za uspsotavu konekcije sa istom
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

/*if($connection){
  echo "We are connected";
}*/



?>