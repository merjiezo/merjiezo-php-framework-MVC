<?php
return [
	'dsn'      => 'mysql:host=127.0.0.1;dbname=store',
	'user'     => 'root',
	'password' => '950826',
	'charset'  => 'utf8',

	'slaves' => [
		[
			'dsn'      => 'mysql:host=127.0.0.1;dbname=mjz',
			'user'     => 'root',
			'password' => '950826',
			'charset'  => 'utf8',
		],
	],
];