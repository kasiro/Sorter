<?php

require './assoc.php';
require './rules.php';
// $downloads = '/home/kasiro/Загрузки';
// $downloads_to_name = 'Permissions.';

// # /home/kasiro/Загрузки/Permissions.
// $downloads_to = $downloads.'/'.$downloads_to_name;
// $rules = [
// 	$downloads_to.'/gif' => $downloads.'/*.gif',
// 	$downloads_to.'/json' => $downloads.'/*.json',
// 	$downloads_to.'/tar' => $downloads.'/*.tar.*',
// 	$downloads_to.'/deb' => $downloads.'/*.deb',
// 	$downloads_to.'/zip' => $downloads.'/*.zip',
// 	$downloads_to.'/txt' => $downloads.'/*.txt',
// 	$downloads_to.'/pdf' => $downloads.'/*.pdf',
// 	$downloads_to.'/iso' => $downloads.'/*.iso',
// 	$downloads_to.'/torrent' => $downloads.'/*.torrent',
// 	$downloads_to.'/other' => [
// 		'not' => [
// 			'*.jpg',
// 			'*.jpeg',
// 			'*.png',
// 			'*.mp4',
// 			'*.webp',
// 			'*.gif'
// 		]
// 	],
// 	$downloads_to.'/Telegram_download' => $downloads.'/photo_*-*-*_*-*-*.*',
// ];

foreach ($rules as $to => $what){
	if (is_string($what)) {
		$find = glob($what);
		if (file_exists($to)){
			$f = array_diff(
				scandir($to),
				['.', '..']
			);
		} else {
			$f = [];
		}
		if (empty($f) && empty($find)){
			if (file_exists($to)) rmdir($to);
		}
		if (!file_exists($to) && !empty($find)) mkdir($to);
		foreach ($find as $path){
			if (is_file($path) || is_file($path) && !str_contains(basename($path), '.')) {
				$filename = basename($path);
				rename($path, "$to/$filename");
			}
		}
	} else {
		if (is_assoc($what)){
			foreach ($what as $option => $value){
				switch ($option){
					case 'not':
						$dir = dirname($to);
						$all = [];
						foreach ($value as $el){
							$files = glob($dir.'/'.$el);
							$all = array_merge($all, $files);
						}
						$f = array_diff(
							scandir($dir),
							['.', '..']
						);
						foreach ($f as $el){
							$path = $dir.'/'.$el;
							if (!in_array($path, $all) && is_file($path)){
								rename($path, "$to/$el");
							}
						}
						break;
					
					case 'allow':
						
						break;
				}
			}
		} else {
			foreach ($what as $p){
				foreach (glob($p) as $path){
					$filename = basename($path);
					rename($path, "$to/$filename");
				}
			}
		}
		
	}
}
system('notify-send "Sorter" "Папки Отсортированны"');