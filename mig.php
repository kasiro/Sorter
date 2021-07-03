<?php

require '/home/kasiro/Документы/projects/testphp/user_modules/fs.php';

require './rules.php';

foreach ($rules as $where => $to){
	$dir = $downloads;
	$to = $downloads_to_name;
	$folder = basename($where);
	$newPath = "$dir/$to/$folder";
	$from = "$dir/$folder";
	if (!file_exists($newPath) && file_exists($from)){
		// mkdir($newPath);
		echo 'copy: "'.$from.'"...' . PHP_EOL;
		fs::folder_copy($from, $newPath);
	}
}