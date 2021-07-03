<?php

function is_assoc(array $array): bool {
	return !empty(
		preg_grep(
			'/[^0-9]/',
			array_keys($array)
		)
	);
}