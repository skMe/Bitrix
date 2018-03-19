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
				$res["ID"] = $jsn["user"]["id"];
				$res["PROFILE_PIC_URL"] = $jsn["user"]["profile_pic_url"];
				$res["PROFILE_PIC_URL_HD"] = $jsn["user"]["profile_pic_url_hd"];
				$res["USERNAME"] = $jsn["user"]["username"];
				$res["FULL_NAME"] = $jsn["user"]["full_name"];
				$res["BIOGRAPHY"] = $jsn["user"]["biography"];
				$res["EXTERNAL_URL"] = $jsn["user"]["external_url"];
				$res["FOLLOWED_BY"] = $jsn["user"]["followed_by"]["count"];
				$res["FOLLOWS"] = $jsn["user"]["follows"]["count"];
				foreach ($jsn["user"]["media"]["nodes"] as $item)
				{
					$res["ITEMS"][] = array(
						"IMG" => array("SRC" => $item["display_src"], "WIDTH" => $item["dimensions"]["width"], "HEIGHT" => $item["dimensions"]["height"]),
						"THUMB" => array(
							"SRC" => $item["thumbnail_resources"][$tsz]["src"],
							"WIDTH" => $item["thumbnail_resources"][$tsz]["config_width"],
							"HEIGHT" => $item["thumbnail_resources"][$tsz]["config_height"],
						),
						"INSTA_CODE" => $item["code"],
						"CAPTION" => $item["caption"],
						"DATE" => date("j.m.Y", $item["date"]),
						"TIME" => date("G:i", $item["date"]),
						"COMMENTS" => $item["comments"]["count"],
						"LIKES" => $item["likes"]["count"],
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

