<?php
	header("Access-Control-Allow-Origin: *");
	$response = array();
    include("connect.php");
	header("Content-Type: text/html; charset=utf-8");
	
	$query = "SELECT * FROM data";
    $result = pg_query($query);
	
	$count = pg_num_rows($result);
	
	$yes = 0;
	$no = 0;
	
    while ($row = pg_fetch_assoc($result)) {
        if($row['gpa'] == "Appropriate")
		{
			$yes += 1;
		}
		else if($row['gpa'] == "Inappropriate")
		{
			$no += 1;
		}
   }
   $response['appropriate'] =  number_format((float)($yes/$count) * 100, 2, '.', '');
   $response['inappropriate'] = number_format((float)($no/$count) * 100, 2, '.', '');
   $response['sumary'] = $count;
   echo json_encode( $response, JSON_UNESCAPED_UNICODE );   
   

	pg_close($dbconn);
	
?>