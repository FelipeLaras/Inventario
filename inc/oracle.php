<?php

	$conn_oracle = oci_connect("robot19", "robot2019", "//10.100.1.209:1523/APOLLO");
	if (!$conn_oracle) {
	   $m = oci_error();
	   echo $m['message'], "\n";
	   exit;
	}

?>