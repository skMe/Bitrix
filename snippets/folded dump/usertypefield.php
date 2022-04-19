<?
//##### add user type for fields #####
AddEventHandler("iblock", "OnIBlockPropertyBuildList", array("CUserTypeSectionLink", "GetUserTypeDescription"));

class CUserTypeSectionLink
{
	private static $Script_included = false;

	function GetUserTypeDescription()
	{
		return array(
			"USER_TYPE_ID" => "SECTION_LINK",
			"CLASS_NAME" => "CUserTypeSectionLink",
			"DESCRIPTION" => "Ссылка на раздел",
			"BASE_TYPE" => "string",
			"PROPERTY_TYPE" => "N",
			"USER_TYPE" => "SECTION_LINK",
			"GetPublicViewHTML" => array("CUserTypeSectionLink","GetPublicViewHTML"),
			"GetPropertyFieldHtml" => array("CUserTypeSectionLink","GetPropertyFieldHtml"),
		);
	}

	public static function GetPublicViewHTML($arProperty, $value, $strHTMLControlName)
	{
		return $value['VALUE'];
	}

	public function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
	{

		$sectionsList=array();
		$ibNames=array();

		$rsIB = CIBlock::GetList();
		while ($ib = $rsIB->GetNext()) {
			$ibNames[$ib['ID']] = $ib['NAME'];
		}

		$rsBindValues = CIBlockSection::GetList(
			array("left_margin" => "asc"),
			array(),
			false,
			array(
				"ID",
				"IBLOCK_ID",
				"IBLOCK_NAME",
				"NAME",
				"DEPTH_LEVEL",
				"SECTION_PAGE_URL"
			),
			false
		);
		while ($bind_value = $rsBindValues->GetNext()) {
			$sectionsList[$bind_value['IBLOCK_ID']]['NAME'] = $ibNames[$bind_value['IBLOCK_ID']];
			$sectionsList[$bind_value['IBLOCK_ID']]['SECTIONS'][] = $bind_value;
		}

		$optionsHTML='<option value=""> &equiv; не выбрано &equiv; </option>';

		foreach($sectionsList as $ib){

			$optionsHTML .= '<optgroup label="'.$ib['NAME'].'">';

			foreach($ib['SECTIONS'] as $s){
				$optionsHTML .= '<option value="'.$s["ID"].'"'.
					( $value["VALUE"]==$s['ID'] ? ' selected' : '' ).
					'>'.str_repeat("- ", $s['DEPTH_LEVEL'] - 1).$s['NAME'].' ['.$s['ID'].']'.'</option>';
			}

			$optionsHTML .= '</optgroup>';

		}

		return	'<select name="'.$strHTMLControlName["VALUE"].'">'.$optionsHTML.'</select>';

	}

}

?>