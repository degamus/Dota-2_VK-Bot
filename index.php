<?php
require 'Defines.php';
require 'DotaFunc.php';
require 'VkFunc.php';
require 'Functions.php';
file_put_contents("log.txt", file_get_contents('php://input'));

if (!isset($_REQUEST)) {
	echo "Pavel KEK";
}

$request = json_decode( file_get_contents('php://input') );
$user_id = $request->object->user_id;

if ( $request->type == 'confirmation' and $request->group_id == '164047681' ) {
	echo "f68cb4eb";
	exit();
}

if ( $request->type == 'message_new' and substr_count($request->object->body, 'профиль') == 1 ) {
	Steam32();
	if ( GetName() == "" ) {
		Send_Message(MSG_PROFILE_CANT_GET);
	} else {
		Send_Message( GetProfileInfo() );
	}

} elseif ( $request->type == 'message_new' and substr_count($request->object->body, 'wl' ) == 1) {
	Steam32();
	if (GetWin() != "" or GetLose() != "") {
		Send_Message( GetWL() );
	} else {
		Send_Message(MSG_PROFILE_CANT_GET);
	}

} elseif ( $request->type == 'message_new' and substr_count($request->object->body, 'топ') == 1 ) {
	Steam32();
	if (GetTopPlayers( $Steam32 ) != "") {
		Send_Message( GetTopPlayers( $Steam32 ) );
	} else {
		Send_Message(MSG_ARGUMENTS_CANT_GET);
	}

} elseif ( $request->type == 'message_new' and substr_count($request->object->body, 'последний матч') == 1 ) {
	Steam32();

	if ( GetLastMatch() != "" ) {
		Send_Message( GetLastMatch() );
	} else {
		Send_Message(MSG_PROFILE_CANT_GET);
	}

} elseif ( $request->type == 'message_new' and substr_count($request->object->body, 'новости') == 1 ) {
	Send_Message( GetNews() );
	
} elseif ( $request->type == 'message_new' and substr_count($request->object->body, 'refresh') == 1 ) {
	Steam32();
	ODotaUpdate();
	Send_Message(MSG_REFRESH);

} elseif ( $request->type == 'message_new' and substr_count($request->object->body, 'помощь') == 1 ) {
	Send_Message(MSG_HELP);

} elseif ( $request->type == 'message_new' ) {
	Send_Message(MSG_WRONG_COMMAND);

}
echo "ok";

// $txt = "Ник: ". GetName() ."\nMMR: ". GetMMR() ."\nРанк: ". GetRank() ."\nПобед: ". GetWin() ."   Поражений: ". GetLose();
// print( $txt );
