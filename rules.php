<?php

function Sorter(string $to = '', $all_options){
	foreach ($all_options as $form => $array){
		$to = strlen($to) > 0 ? $to : (isset($array['to']) ? $array['to'] : '');
		if (strlen($to) == 0) return false;
		$exts = $array['ext'];
		foreach ($exts as $key => $value){
			if (!is_array($value)){
				if (!is_string($key)) {
					if (count($all_options) > 1){
						$newarray[$to.'/'.$value][] = $form.'/*.'.$value;
					} else {
						$newarray[$to.'/'.$value] = $form.'/*.'.$value;
					}
					
				} else {
					if (count($all_options) > 1){
						$newarray[$to.'/'.$key][] = $form.'/*.'.$value;
					} else {
						$newarray[$to.'/'.$key] = $form.'/*.'.$value;
					}
					
				}
			} else {
				foreach ($value as $el){
					if (is_string($key)) $newarray[$to.'/'.$key][] = $form.'/*.'.$el;
				}
			}
		}
	}
	return $newarray;
}
$Sorter = Sorter('/home/kasiro/Загрузки/Permissions.', [
	'/home/kasiro/Загрузки' => [
		'ext' => [
			'gif',
			'json',
			'tar' => ['tar.*', 'rar'],
			'deb',
			'zip',
			'txt',
			'pdf',
			'iso',
			'torrent'
		]
	],
	'/home/kasiro/Загрузки/Telegram Desktop' => [
		'ext' => [
			'tar' => 'tar.*',
			'zip',
			'txt',
			'pdf',
			'torrent'
		]
	],
]);
$rules = array_merge($Sorter, [
	'/home/kasiro/Загрузки/Permissions./Telegram_download' => '/home/kasiro/Загрузки/photo_*-*-*_*-*-*.*',
	'/home/kasiro/Загрузки/Permissions./other' => [
		'not' => [
			'*.jpg',
			'*.jpeg',
			'*.png',
			'*.mp4',
			'*.webp',
			'*.gif'
		]
	],
]);