<?php

	define('ROOT', '.');

	require(ROOT . '/lib/config.php');

	if (isset($_GET['guielement'])) {
		GUIOutputElement();
	} else {
		GUIOutputPage();
	}

