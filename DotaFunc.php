<?php

function GetProfileInfo()
{
	global $data_profile, $data_SteamProfile, $data_OffDotaProfile, $Steam32;

	CheckData("data_profile");
	CheckData("data_OffDotaProfile");
	CheckData("data_SteamProfile");

	$msg = "Ник: ". $data_SteamProfile->response->players[0]->personaname;

	if ($data_OffDotaProfile->result->TeamName != "") {
		$msg .= "\nКоманда: ". $data_OffDotaProfile->result->TeamName;
	}

	if ($data_OffDotaProfile->result->TeamTag != "") {
		$msg .= "\nТэг команды: ". $data_OffDotaProfile->result->TeamTag;
	}

	if ($data_OffDotaProfile->result->Sponsor != "") {
		$msg .= "\nСпонсор: ". $data_OffDotaProfile->result->Sponsor;
	}

	$msg .= "\nПримерный MMR: ". $data_profile->mmr_estimate->estimate;

	$rank = $data_profile->rank_tier;
	switch ($rank) {
		case 00:
			$rank = 'Без ранга';
			break;
		case 10:
			$rank = 'Рекрут [0]';
			break;
		case 11:
			$rank = 'Рекрут [1]';
			break;
		case 12:
			$rank = 'Рекрут [2]';
			break;
		case 13:
			$rank = 'Рекрут [3]';
			break;
		case 14:
			$rank = 'Рекрут [4]';
			break;
		case 15:
			$rank = 'Рекрут [5]';
			break;
		case 20:
			$rank = 'Страж [0]';
			break;
		case 21:
			$rank = 'Страж [1]';
			break;
		case 22:
			$rank = 'Страж [2]';
			break;
		case 23:
			$rank = 'Страж [3]';
			break;
		case 24:
			$rank = 'Страж [4]';
			break;
		case 25:
			$rank = 'Страж [5]';
			break;
		case 30:
			$rank = 'Рыцарь [0]';
			break;
		case 31:
			$rank = 'Рыцарь [1]';
			break;
		case 32:
			$rank = 'Рыцарь [2]';
			break;
		case 33:
			$rank = 'Рыцарь [3]';
			break;
		case 34:
			$rank = 'Рыцарь [4]';
			break;
		case 35:
			$rank = 'Рыцарь [5]';
			break;
		case 40:
			$rank = 'Герой [0]';
			break;
		case 41:
			$rank = 'Герой [1]';
			break;
		case 42:
			$rank = 'Герой [2]';
			break;
		case 43:
			$rank = 'Герой [3]';
			break;
		case 44:
			$rank = 'Герой [4]';
			break;
		case 45:
			$rank = 'Герой [5]';
			break;
		case 50:
			$rank = 'Легенда [0]';
			break;
		case 51:
			$rank = 'Легенда [1]';
			break;
		case 52:
			$rank = 'Легенда [2]';
			break;
		case 53:
			$rank = 'Легенда [3]';
			break;
		case 54:
			$rank = 'Легенда [4]';
			break;
		case 55:
			$rank = 'Легенда [5]';
			break;
		case 60:
			$rank = 'Властелин [0]';
			break;
		case 61:
			$rank = 'Властелин [1]';
			break;
		case 62:
			$rank = 'Властелин [2]';
			break;
		case 63:
			$rank = 'Властелин [3]';
			break;
		case 64:
			$rank = 'Властелин [4]';
			break;
		case 65:
			$rank = 'Властелин [5]';
			break;
		case 70:
			$rank = 'Божество [0]';
			break;
		case 71:
			$rank = 'Божество [1]';
			break;
		case 72:
			$rank = 'Божество [2]';
			break;
		case 73:
			$rank = 'Божество [3]';
			break;
		case 74:
			$rank = 'Божество [4]';
			break;
		case 75:
			$rank = 'Божество [5]';
			break;
		case 76:
			$rank = 'Божество [5]';
			break;
	}
	$msg .= "\nРанг: ". $rank;

	CheckData("data_profile");
	$msg .= "\nСсылка на профиль: ". $data_profile->profile->profileurl;

	return $msg;
}

function CheckData($data)
{
	global $data_profile, $data_SteamProfile, $data_OffDotaProfile, $data_wl, $data_LastMatch_info, $data_TopPlayers, $data_News, $Steam32;
	switch ($data) {
		case 'data_profile':
			if (!isset($data_profile)) {
				$data_profile = json_decode(file_get_contents("https://api.opendota.com/api/players/". (integer) $Steam32));
			}
			break;
		case 'data_OffDotaProfile':
			if (!isset($data_OffDotaProfile)) {
				$data_OffDotaProfile = json_decode(file_get_contents("https://api.steampowered.com/IDOTA2Fantasy_570/GetPlayerOfficialInfo/v1/?key=9D3248F26F3D8354046CFD8FC24480BB&format=json&accountid=". (integer) $Steam32));
			}
			break;
		case 'data_SteamProfile':
			if (!isset($data_SteamProfile)) {
				$data_SteamProfile = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=9D3248F26F3D8354046CFD8FC24480BB&steamids=". toCommunityID( (integer) $Steam32) ));
				file_put_contents("log.txt", $data_SteamProfile);
			}
			break;
		case 'data_wl':
			if (!isset($data_wl)) {
				$data_wl = json_decode(file_get_contents("https://api.opendota.com/api/players/". (integer) $Steam32 ."/wl"));
			}
			break;
		case 'data_LastMatch':
			if (!isset($data_LastMatch)) {	
				// $data_LastMatch = json_decode(file_get_contents("https://api.opendota.com/api/players/". (integer) $Steam32 ."/recentMatches"));
				$data_LastMatch = json_decode(file_get_contents("https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/v1/?key=9D3248F26F3D8354046CFD8FC24480BB&format=json&matches_requested=1&account_id=". (integer) $Steam32 ));
				if ($data_LastMatch->result->matches[0]->match_id != "" or $data_LastMatch->result->matches[0]->match_id != null) {
					$match_id = $data_LastMatch->result->matches[0]->match_id;
				}
				$data_LastMatch_info = json_decode(file_get_contents("https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/v1/?key=9D3248F26F3D8354046CFD8FC24480BB&format=json&match_id=". $match_id ));
			}
			break;
		case 'data_News':
			if (!isset($data_News)) {
				$data_News = json_decode(file_get_contents("http://api.steampowered.com/ISteamNews/GetNewsForApp/v0002/?appid=570&count=3&maxlength=300&feeds=steam_community_announcements&format=json"));
			}
			break;
		case 'data_TopPlayers':
			if (!isset($data_TopPlayers)) {
				$data_TopPlayers = json_decode(file_get_contents("https://api.steampowered.com/IDOTA2Fantasy_570/GetProPlayerList/v1/?key=9D3248F26F3D8354046CFD8FC24480BB&format=json"));
			}
			break;
	}
}

function GetTopPlayers($division)
{
	global $data_TopPlayers;
	CheckData("data_TopPlayers");
	$div = $division - 1;
	for ($i=1; $i <= 3; $i++) { 
		$id[$i] = $data_TopPlayers->leaderboards[$div]->account_ids[$i-1];
	}
	if ( $id[1] == "" or $id[2] == "" or $id[3] == "") {
		$msg = "";
		return $msg;
	}
	foreach ($id as $id_key => $id_value) {
		//$msg .= $id_key .". Ник: ". $data_TopPlayers->player_infos[$key]->name ."\n";
		//$msg .= "fantasy_role: ". $data_TopPlayers->player_infos[$key]->fantasy_role ."\n";
		$data_SteamProfile = json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=9D3248F26F3D8354046CFD8FC24480BB&steamids=". toCommunityID( (integer) $id_value) ));
		$name = $data_SteamProfile->response->players[0]->personaname;
		$msg .= $id_key .". 🏷 ". $name ."\n";
		//$msg .= "id аккаунта: ". $id_value ."\n";
		$msg .= "Больше информации ➡️ \"профиль ". $id_value ."\"\n\n";
	}
	return $msg;
}

function GetNews()
{
	global $data_News;
	CheckData("data_News");
	$News = $data_News->appnews->newsitems;
	$msg .= "Новости:\n\n";
	foreach ($News as $key => $value) {
		$title = $News[$key]->title;
		$date = date("d-m-Y H:s", $News[$key]->date);
		$url = $News[$key]->url;
		$msg .= "Заголовок: ". $title ."\nПолная новость: ". $url ."\nДата публикации: ". $date ."\n\n";
	}
	return $msg;
}

function GetName()
{
	global $data_SteamProfile, $Steam32;
	CheckData("data_SteamProfile");
	$name = $data_SteamProfile->response->players[0]->personaname;
	return $name;
}

function GetProfileURL()
{
	global $data_profile, $Steam32;
	CheckData("data_profile");
	$URL = $data_profile->profile->profileurl;
	return $URL;
}

function GetWL()
{
	global $data_wl, $Steam32;
	CheckData("data_wl");
	$win = (integer) $data_wl->win;
	$lose = (integer) $data_wl->lose;
	$msg = "Побед: ". $win ."\nПоражений: ". $lose ."\nПроцент побед: ". number_format(($win / ( $win + $lose ) * 100 ), 2) ."%";
	return $msg;
}

function GetWin()
{
	global $data_wl, $Steam32;
	CheckData("data_wl");
	$win = $data_wl->win;
	return $win;
}

function GetLose()
{
	global $data_wl, $Steam32;
	CheckData("data_wl");
	$lose = $data_wl->lose;
	return $lose;
}

function HeroName($id)
{
	$Obj_Heroes = json_decode( file_get_contents("assets/heroes.json") );
	foreach ($Obj_Heroes->heroes as $key => $value) {
		if ( $id ==  $Obj_Heroes->heroes[$key]->id) {
			$hero_name = $Obj_Heroes->heroes[$key]->localized_name;
		}
	}
	return $hero_name;
}

function ODotaUpdate()
{
	global $Steam32;
	file_put_contents('log.txt', file_get_contents("https://api.opendota.com/api/players/". (integer) $Steam32 ."/refresh"));
}

function GetLastMatch()
{	
	global $data_LastMatch_info, $Steam32;
	CheckData("data_LastMatch");
	$result = $data_LastMatch_info->result;
	if ( GetName() == "" ) { // Проверка на наличие информации
		$msg = ""; // Если вернулось пустое поле, скрипт "index.php" это проверит
		return $msg;
	}

	$msg = "Последий матч у ". GetName() ."\n";
	if (isset($result->radiant_win)) {
		if ($result->radiant_win == true) {
			$msg .= "\n🔵 Силы Света победили со счётом ". $result->radiant_score .":". $result->dire_score ." !\n";
		} else {
			$msg .= "\n🔴 Силы Тьмы победили со счётом ". $result->radiant_score .":". $result->dire_score ." !\n";
		}
	}
	if (isset($result->match_id)) {
		$msg .= "\n🆔 матча: ". $result->match_id;
	} elseif ($data_LastMatch->result->matches[0]->match_id == "" or $data_LastMatch->result->matches[0]->match_id == null) {
		$match_id = $data_LastMatch->result->matches[0]->match_id;
		$msg = "";
		return $msg;
	}
	/*if (isset($data_LastMatch[0]->player_slot)) {
		$msg .= "\nplayer_slot: ". $data_LastMatch[0]->player_slot;
	}*/
	if (isset($result->start_time)) {
		$start_time = getdate($result->start_time);
		$msg .= "\n🕔 Время начала игры: ". $start_time['year'] .'.'. $start_time['mon'] .'.'. $start_time['mday'] .' '. $start_time['hours'] .':'. $start_time['minutes'] .':'. $start_time['seconds'];
	}
	if (isset($result->duration)) {
		$msg .= "\n⏲️ Продолжительность матча: ". round($result->duration / 60) ." мин.";
	}
	if (isset($result->game_mode)) {
		$Obj_GameModes =  json_decode( file_get_contents("assets/game_modes.json") );
		$gameMode =  $Obj_GameModes->{$result->game_mode}->name;
		$msg .= "\n🎮 Режим игры: ". $gameMode;
	}
	if (isset($result->lobby_type)) {
		$Obj_LobbyTypes = json_decode( file_get_contents("assets/lobby_types.json") );
		$lobbyType = $Obj_LobbyTypes->{$result->lobby_type}->name;
		$msg .= "\n🛋 Тип лобби: ". $lobbyType;
	}
	foreach ($result->players as $key => $value) {
		if ( $result->players[$key]->account_id == $Steam32) {

			if (isset($result->players[$key]->hero_id)) {
				$msg .= "\n💂 Герой: ". HeroName($result->players[$key]->hero_id);
			}
			if (isset($result->players[$key]->level)) {
				$msg .= "\n🎓 Уровень: ". $result->players[$key]->level;
			}
			if (isset($result->players[$key]->xp_per_min)) {
				$msg .= "\n💡🕜 Опыта в минуту: ". $result->players[$key]->xp_per_min;
			}
			if (isset($result->players[$key]->kills)) {
				$msg .= "\n🔪 Убийств: ". $result->players[$key]->kills;
			}
			if (isset($result->players[$key]->deaths)) {
				$msg .= "\n☠️ Смертей: ". $result->players[$key]->deaths;
			}
			if (isset($result->players[$key]->assists)) {
				$msg .= "\n🆘 Помощи: ". $result->players[$key]->assists;
			}
			if (isset($result->players[$key]->gold)) {
				$msg .= "\n💰 Золота: ". $result->players[$key]->gold;
			}
			if (isset($result->players[$key]->gold_spent)) {
				$msg .= "\n💸 Потрачено золота: ". $result->players[$key]->gold_spent;
			}
			if (isset($result->players[$key]->gold_per_min)) {
				$msg .= "\n💰🕜 Золота в минуту: ". $result->players[$key]->gold_per_min;
			}
			if (isset($result->players[$key]->hero_damage)) {
				$msg .= "\n🤕 Урон: ". $result->players[$key]->hero_damage;
			}
			if (isset($result->players[$key]->last_hits)) {
				$msg .= "\n🔪🐸 Добитых крипов: ". $result->players[$key]->last_hits;
			}
			if (isset($result->players[$key]->tower_damage)) {
				$msg .= "\n🤕🏘 Урон по строениям: ". $result->players[$key]->tower_damage;
			}
			if (isset($result->players[$key]->hero_healing)) {
				$msg .= "\n👨‍⚕️ Лечение: ". $result->players[$key]->hero_healing;
			}
		}
	}
	return $msg;
}
