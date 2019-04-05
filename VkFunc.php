<?php

function Send_Message($msg)
{
	global $user_id;
	$param = [
		'user_id' => $user_id,
		'access_token' => "INPUT_TOKEN_HERE",
		'v' => '5.73',
		'message' => $msg,
		];
	$url = 'https://api.vk.com/method/messages.send?'. http_build_query($param);
	file_get_contents($url);
}

