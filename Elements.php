<?include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?php

\Bitrix\Main\Loader::includeModule("iblock");

class Elements
{
	private static $ibId = 1;
	public static $sect = array();
	public static function GetSections(){
		$arFilter = array('IBLOCK_ID' => self::$ibId);
		$db_list = \CIBlockSection::GetList(array($by => $order), $arFilter, true);
		$arrSect = array();
		while ($ar_result = $db_list->GetNext()) {
			$arrSect[$ar_result['ID']] = $ar_result['NAME'];
		}
		//self::$sect = $arrSect;
		return $arrSect;
	}

	public static function GetElems(){
		$sect = self::GetSections();
		$arSelect = array("ID", "NAME", "DATE_ACTIVE_FROM", "PREVIEW_TEXT", "DETAIL_TEXT", "PREVIEW_PICTURE", "IBLOCK_SECTION_ID","CATALOG_GROUP_1");
		$arFilter = array("IBLOCK_ID"=>1, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", ">CATALOG_QUANTITY"=>0);
		$res = \CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
		$arr = array();
		while($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();
			$rsFile = CFile::GetFileArray($arFields["PREVIEW_PICTURE"]);
			$arFields['IMG'] = $rsFile['SRC'];
			$arr[] = array(
				$sect[$arFields['IBLOCK_SECTION_ID']],
				$arFields['NAME'],
				$arFields['CATALOG_PRICE_1'],
				'',
				'',
				'руб',
				$_SERVER[DOCUMENT_ROOT].$arFields['IMG'],
				strip_tags($arFields['PREVIEW_TEXT']),
				strip_tags($arFields['DETAIL_TEXT']),
				'в наличии'
			);
			//yield $arr;
		}
		return $arr;
		//yield $arr;
	}
}