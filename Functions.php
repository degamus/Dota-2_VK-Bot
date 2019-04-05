<?php

function Steam32()
{
	global $Steam32, $request;
	$Steam32 = $request->object->body;
	strtolower($Steam32);
	$Steam32 = str_replace('профиль', '', $Steam32);
	$Steam32 = str_replace('wl', '', $Steam32);
	$Steam32 = str_replace('последний матч', '', $Steam32);
	$Steam32 = str_replace('refresh', '', $Steam32);
	$Steam32 = str_replace('топ', '', $Steam32);
	trim($Steam32);
	strval($Steam32);
}

function toCommunityID($id) {
	if (preg_match('/^STEAM_/', $id)) {
	    $parts = explode(':', $id);
	    return bcadd(bcadd(bcmul($parts[2], '2'), '76561197960265728'), $parts[1]);
	} elseif (is_numeric($id) && strlen($id) < 16) {
	    return bcadd($id, '76561197960265728');
	} else {
	    return $id; // We have no idea what this is, so just return it.
	}
}
