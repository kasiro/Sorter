<?php
// require './assoc.php';
function set_ext(string $to, string $form, array $exts){
	$array = [];
	foreach ($exts as $key => $value){
		if (!is_array($value)){
			if (!is_string($key)) {
				$array[$to.'/'.$value] = $form.'/*.'.$value;
			} else {
				$array[$to.'/'.$key] = $form.'/*.'.$value;
			}
		} else {
			foreach ($value as $el){
				$array[$to.'/'.$key]['allow'][] = $form.'/*.'.$el;
			}
		}
	}
	return $array;
}

$downloads = '/home/kasiro/Загрузки';
$telegram_desktop = $downloads.'/Telegram Desktop';
$downloads_to_name = 'Permissions.';

# $downloads_to - /home/kasiro/Загрузки/Permissions.
$downloads_to = $downloads.'/'.$downloads_to_name;
$downloads_options = set_ext($downloads_to, $downloads, [
	'gif',
	'json',
	'tar' => ['tar.*', 'rar'],
	'deb',
	'zip',
	'txt',
	'pdf',
	'iso',
	'torrent'
]);
$telegram_desktop_options = set_ext($downloads_to, $telegram_desktop, [
	'json',
	'tar' => ['tar.*', 'rar'],
	'zip',
	'txt',
	'pdf',
	'torrent'
]);
$rules = array_merge(
	$downloads_options,
	$telegram_desktop_options,
	[
		$downloads_to.'/other' => [
			'not' => [
				'*.jpg',
				'*.jpeg',
				'*.png',
				'*.mp4',
				'*.webp',
				'*.gif'
			]
		],
		$downloads_to.'/Telegram_download' => $downloads.'/photo_*-*-*_*-*-*.*',
	]
);
// print_r($rules);