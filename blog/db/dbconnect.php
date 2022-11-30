<?php

include("../../pages/config.php");

/* Connection to database */

	$conn =mysqli_connect($localhost,$db_user,$db_password,$database);

	/* Check connection */
	if(mysqli_connect_error()) {
		echo "Connection failed";
		printf("Error : %s",mysqli_connect_error());
	}

?>
