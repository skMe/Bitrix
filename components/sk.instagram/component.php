<?php
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

$arParams["INST_ACCOUNT"] = trim($arParams["INST_ACCOUNT"]);
$arParams["CACHE_TIME"] = IntVal($arParams["CACHE_TIME"]);
if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 3600;
$arResult["ERROR_MESSAGE"] = array();

if ($this->StartResultCache())
{
	if($arParams["INST_ACCOUNT"] <> '')
	{
		$insta = file_get_contents('https://www.instagram.com/'.$arParams["INST_ACCOUNT"].'/?__a=1');
		if ($insta)
		{
			if ($jsn = json_decode($insta, true))
			{
				$tsz = $arParams["THUMB_SIZE"];
				$res["ID"] = $jsn["graphql"]["user"]["id"];
				$res["PROFILE_PIC_URL"] = $jsn["graphql"]["user"]["profile_pic_url"];
				$res["PROFILE_PIC_URL_HD"] = $jsn["graphql"]["user"]["profile_pic_url_hd"];
				$res["USERNAME"] = $jsn["graphql"]["user"]["username"];
				$res["FULL_NAME"] = $jsn["graphql"]["user"]["full_name"];
				$res["BIOGRAPHY"] = $jsn["graphql"]["user"]["biography"];
				$res["EXTERNAL_URL"] = $jsn["graphql"]["user"]["external_url"];
				$res["FOLLOWED_BY"] = $jsn["graphql"]["user"]["edge_followed_by"]["count"];
				$res["FOLLOWS"] = $jsn["graphql"]["user"]["edge_follow"]["count"];
				foreach ($jsn["graphql"]["user"]["edge_owner_to_timeline_media"]["edges"] as $item)
				{
					$res["ITEMS"][] = array(
						"IMG" => array("SRC" => $item["node"]["display_url"], "WIDTH" => $item["node"]["dimensions"]["width"], "HEIGHT" => $item["node"]["dimensions"]["height"]),
						"THUMB" => array(
							"SRC" => $item["node"]["thumbnail_resources"][$tsz]["src"],
							"WIDTH" => $item["node"]["thumbnail_resources"][$tsz]["config_width"],
							"HEIGHT" => $item["node"]["thumbnail_resources"][$tsz]["config_height"],
						),
						"INSTA_CODE" => $item["node"]["shortcode"],
						"CAPTION" => $item["node"]["edge_media_to_caption"]["edges"]["0"]["node"]["text"],
						"DATE" => date("j.m.Y", $item["node"]["taken_at_timestamp"]),
						"TIME" => date("G:i", $item["node"]["taken_at_timestamp"]),
						"COMMENTS" => $item["node"]["edge_media_to_comment"]["count"],
						"LIKES" => $item["node"]["edge_liked_by"]["count"],
					);
				}
				$arResult = array_merge($arResult, $res);
			}
			else
			{
				$arResult["ERROR_MESSAGE"][] = GetMessage("DV_JSON_DECODE_FAIL");
			}
		}
		else
		{
		$arResult["ERROR_MESSAGE"][] = GetMessage("DV_INST_ACCOUNT_WRONG");
		}
	}
	else
	{
	$arResult["ERROR_MESSAGE"][] = GetMessage("DV_INST_ACCOUNT_EMPTY");
	}
	$this->IncludeComponentTemplate();
}

