<?php
    $dbhost = 'localhost';
    $dbname = 'mining';
    $dbuser = 'postgres';
    $dbpass = '12345678';

    $dbconn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass") or die('Could not connect: ' . pg_last_error());
	pg_set_client_encoding($dbconn, "UTF-8");

   

    //pg_free_result($result);
    //pg_close($dbconn);
?>