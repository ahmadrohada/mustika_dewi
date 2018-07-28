<?php

$username  = 'root';

$pass  = '';

try {

    $koneksi = new PDO('mysql:host=localhost;dbname=db_mustika_dewi', $username, $pass);
    
	// set error mode
	$koneksi->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

} catch (PDOException $e) {

    print "Error!: " . $e->getMessage() . "<br/>";

    die();

}

//$koneksi = null;

?>