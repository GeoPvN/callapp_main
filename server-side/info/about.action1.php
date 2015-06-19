<?php
require_once('../../includes/classes/core.php');
header('Content-Type: text/html; charset=utf-8');
$info_id 		= $_REQUEST['id'];

	$res1 = mysql_fetch_assoc(mysql_query("	SELECT  `id`,
													`name`,
													`body`
											FROM    `info_base`
											WHERE   `id` = $info_id" ));


	$data ='

	  	 	<p><center><b>' . $res1['name'] . '</b></center></p>
			<p>' . $res1['body'] . '</p>';
	echo nl2br($data);
	
	?>