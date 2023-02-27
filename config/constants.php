<?php

define('IKUT_STATUS_PENDING', 'pending');
define('IKUT_STATUS_ALLOLWED', 'allowed');
define('IKUT_STATUS_KICKED', 'kicked');
define('IKUT_STATUS_DONE', 'done');

define('SOAL_TYPE_PILIHAN', 'pilihan');
define('SOAL_TYPE_ESAY', 'esay');

return [
	'nilai_esay' => [
		'0' => 0,
		'10' => 10,
		'20' => 20,
		'30' => 30,
		'40' => 40,
		'50' => 50,
		'60' => 60,
		'70' => 70,
		'80' => 80,
		'90' => 90,
		'100' => 100
	],
	'label_ikut_status' => [
		IKUT_STATUS_PENDING => 'Mengerjakan',
		IKUT_STATUS_ALLOLWED => 'Mengerjakan',
		IKUT_STATUS_KICKED => 'Dikeluarkan',
		IKUT_STATUS_DONE => 'Selesai',
	]
];