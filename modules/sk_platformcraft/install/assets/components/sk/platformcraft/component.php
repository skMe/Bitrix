<?php
//error_reporting(E_ALL);
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
$authhost = "https://auth.platformcraft.ru";
$streamhost = "https://streamer.platformcraft.ru/2";
$apihost = "https://api.platformcraft.ru/1";
$module_id = "sk.platformcraft";

$login = COption::GetOptionString($module_id, "pc_login", "");
$pass = COption::GetOptionString($module_id, "pc_pass", "");
$arResult["ERRORS"] = array();
$ts = time();
if (!$login || !$pass) $arResult["ERRORS"][] = "Login or password is empty. Check module options.";

// Authorization
if (!$arResult["ERRORS"] && ($auth = PC::getAuth($authhost, $login, $pass, $ts)) === false) $arResult["ERRORS"][] = PC::$err;
if ($arParams["MODE"] == "broadcast" || $arParams["MODE"] == "schedule") {
	$channame = trim($arParams["CHANNEL_NAME"]);
	// Get channels
	if (!$arResult["ERRORS"] && ($channel = PC::getChannel($streamhost, $auth["owner_id"], $auth["access_token"], $channame)) === false) $arResult["ERRORS"][] = PC::$err;
	if (!$arResult["ERRORS"]) $arResult["CHANNEL"] = $channel;

	// Get mediablocks
	if (!$arResult["ERRORS"] && ($mediablocks = PC::getMediablocks($streamhost, $auth["owner_id"], $auth["access_token"], $channel["id"])) === false) $arResult["ERRORS"][] = PC::$err;
	if (!$arResult["ERRORS"]) $arResult["MEDIABLOCKS"] = $mediablocks;
	if (!$arResult["ERRORS"]) {
		if ($arParams["MODE"] == "broadcast") {
			$arResult["NEXT"] = $arResult["NOW"] = array();
			$cnt = 0;
			$next_cnt = isset($arParams["NEXT_CNT"]) && is_numeric($arParams["NEXT_CNT"]) ? (int)$arParams["NEXT_CNT"] : 0;
			foreach($mediablocks as $block) {
				if ($cnt >= $next_cnt) break;
				if ($block["stop_ts"] < $ts) continue;
				$keyname = "NEXT";
				if ($block["stop_ts"] > $ts && $block["timestamp"] < $ts) $keyname = "NOW";
				$arResult[$keyname][] = array("name" => $block["name"], "start" => date("H:i", $block["timestamp"]), "stop" => date("H:i", $block["stop_ts"]), "duration" => $block["duration"]);
				if ($keyname == "NEXT") $cnt++;
			}
			
		} else if ($arParams["MODE"] == "schedule") {
			$ar_weekdays = array("", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье");
			$ar_months = array("","января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
			$arResult["SCHEDULE"] = array();
			$period = in_array($arParams["PERIOD"], array("1", "2", "3")) ? $arParams["PERIOD"] : "1";
			$from = strtotime("today 0:00:00");
			$to = strtotime("today 23:59:59");
			if ($period == "2") {
				$from = strtotime("this week Monday 0:00:00");
				$to = strtotime("this week Sunday 23:59:59");
			}
			if ($period == "3") {
				$from = strtotime("first day of this month 0:00:00");
				$to = strtotime("last day of this month 23:59:59");
			}
			foreach($mediablocks as $block) {
				if ($block["timestamp"] > $to) break;
				if ($block["timestamp"] < $from) continue;
				$k = date("Y-m-d", $block["timestamp"]);
				$day_status = "today";
				if ($block["timestamp"] <= strtotime("today 0:00:00")) $day_status = "before";
				if ($block["timestamp"] >= strtotime("today 23:59:59")) $day_status = "after";
				$arResult["SCHEDULE"][$k]["STATUS"] = $day_status;
				$arResult["SCHEDULE"][$k]["WEEKDAY"] = $ar_weekdays[date("N", $block["timestamp"])];
				$arResult["SCHEDULE"][$k]["DAYMONTH"] = date("j", $block["timestamp"])." ".$ar_months[date("n", $block["timestamp"])];
				$arResult["SCHEDULE"][$k]["YEAR"] = date("Y", $block["timestamp"]);
				$arResult["SCHEDULE"][$k]["DATE"] = date("d.m.Y", $block["timestamp"]);
				$arResult["SCHEDULE"][$k]["ITEMS"][] = array("name" => $block["name"], "start" => date("H:i", $block["timestamp"]), "stop" => date("H:i", $block["stop_ts"]), "duration" => $block["duration"], "status" => $block["status"]);
			}
		}
	} 
}
if ($arParams["MODE"] == "releases") {
	// Get releases
	$pp = trim($arParams["ITEMS_PP"]);
	$pp = is_numeric($pp) ? (int)$pp : 4;
	$p = (isset($_REQUEST["p"]) && is_numeric($_REQUEST["p"])) ? (int)$_REQUEST["p"] : 1;
	$p = $p < 0 ? 1 : $p;
	$start = $p * $pp - $pp;
	$data = array("folder" => trim($arParams["DIR_NAME"]), "limit" => $pp, "start" => $start);
	if (!$arResult["ERRORS"] && ($releases = PC::getReleases($apihost, $auth["access_token"], $data)) === false) $arResult["ERRORS"][] = PC::$err;
	if (!$arResult["ERRORS"]) {
		$arResult["RELEASES"] = array();
		$arResult["RELEASES"] = array("ITEMS" => $releases["players"], "PAGER" => array("TOTAL" => $releases["count"], "PAGE" => $p, "PAGES" => ceil($releases["count"]/$pp)));
	}
}

$this->IncludeComponentTemplate();


class PC {
	static $err = "";
	static $httpCode = 200;

	static function getAuth($host, $login, $pass, $ts) {
		if (file_exists(__DIR__."/.".$login)) {
			$str = file_get_contents(__DIR__."/.".$login);
			if (($auth = json_decode($str,1)) && (($auth["expires_at"] - 120) > $ts)) return $auth;
		}
		if (($json = PC::REQUEST("POST", $host, "/token", array("login" => $login, "password" => $pass))) === false) return false;
		if (isset($json["code"])) { self::$err = $json["msg"]." (".$json["code"].")"; return false; }
		$json["expires_at"] = strtotime("+1 day");
		file_put_contents(__DIR__."/.".$login, json_encode($json));
		return $json;
	}

	static function getChannel($host, $owner, $token, $channame) {
		if (($json = PC::REQUEST("GET", $host, "/streams/".$owner, array(), $token)) === false) return false;
		if (isset($json["code"])) { self::$err = $json["msg"]." (".$json["code"].")"; return false; }
		foreach ($json as $channel) {
			if ($channel["name"] == $channame) return $channel;
		}
		self::$err = "Not found channel \"$channame\"";
		return false;
	}

	static function getMediablocks($host, $owner, $token, $chanid) {
		if (($json = PC::REQUEST("GET", $host, "/streams/".$owner."/".$chanid."/block", array(), $token)) === false) return false;
		if (isset($json["code"])) { self::$err = $json["msg"]." (".$json["code"].")"; return false; }
		return $json;
	}

	static function getReleases($host, $token, $data = array()) {
		if (($json = PC::REQUEST("GET", $host, "/players", $data, $token)) === false) return false;
		if (isset($json["status"]) && $json["status"] != "success") { self::$err = $json["msg"]." (".$json["code"].")"; return false; }
		return $json;
	}

	static function REQUEST($method, $host, $url, $data = array(), $token = "") {
		if (!$host) {
			self::$err = "Invalid data for connect to PlatformCraft";
			return false;
		}
		if ("GET" == $method) $url .= ($data ? "?".http_build_query($data) : "");
		$ch = curl_init(trim($host, "/").$url);
		if ("POST" == $method) curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if ($token) curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: ".$token));
		if ("GET" != $method && $data) curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$resp = @curl_exec($ch);
		if ($resp === false) self::$err = curl_error($ch);
		self::$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close ($ch);
		if (!$jsndec = json_decode($resp,1) ) {
			self::$err = "Not valid response from PlatformCraft ($host)";
			return false;
		}
		return $jsndec;
	}
}
