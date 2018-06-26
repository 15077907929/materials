<?php
session_start();
		require ('ValidateCode.class.php');
		$_vc = new \ValidateCode();		//实例化一个对象
		$_vc->doimg();
