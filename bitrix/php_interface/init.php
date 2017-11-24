<?php
function pre_print($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}
define("FILM_ID", 11);		// ������
define("SLIDER_ID", 16);
define("GENRE_ID", 12);		// ��������� (����������, �����)
define("ACTERS_ID", 15);
define("PASS_ID", 13);		// ������



define("ONE_FILM_SUMM", 149);// 30 ������ �� �����
define("ALL_FILM_SUMM", 299);// 300 ������ �� ��� ������
define("FILM_RANGE", 30);// 30 ����



define("MRH_LOGIN", "kinozal");//kinozal
//define("MRH_LOGIN", "vverhtest");//kinozal
define("IS_TEST", 0);//test
if(IS_TEST == 1){
	define("MRH_PASS1", "B1bzWrJ29Z98ogFZiGGI");
	define("MRH_PASS2", "pJLMuMxSY82m96PYT4sv");
}else{
	define("MRH_PASS1", "rKfTTT311yoa59PbffRo");//rKfTTT311yoa59PbffRo
	define("MRH_PASS2", "C1L08UcQAhDEn5EE3rZZ");//C1L08UcQAhDEn5EE3rZZ
}

AddEventHandler("main", "OnAfterUserAuthorize", "OnAfterUserAuthorizeHandler");
AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");



    // ������� ���������� ������� "OnAfterUserAuthorize"
function OnAfterUserAuthorizeHandler($arUser)
{
	 // ��������� ��� �������� ��������� � ������������
  	
	//AddMessage2Log("USER_AUT:: ".print_r($arUser, true)."\n code = ".$_REQUEST["code"], "main");
	// *** ���������� ������ ���� ������������ ������������� ($user_in_aut ������������ ������������� ����� �������)

	if((int)$_POST["code"]){
        
        $code = (int)$_POST["code"];
        //$down = ($Shp_down == 1)?true:false;
        //$code = $film->add_code(0, $USER->GetID(), $arResult['ID'], $down, 0);
        $film = new Film;
        $film->addUserToCode($arUser["user_fields"]["ID"], $code);
    }
	if((int)$_GET["code"] == 0)
		LocalRedirect("/lk/");
}

function OnAfterUserRegisterHandler(&$arFields){

	//AddMessage2Log("USER_REG:: ".print_r($arFields, true)."\n code = ".$_GET["code"], "main");
	//$arFields["USER_ID"]
	if($arFields["RESULT_MESSAGE"]["TYPE"] != "ERROR" &&  CModule::IncludeModule("iblock") && (int)$_GET["code"] > 0){

    	$ob = CIBlockElement::GetList( Array("SORT"=>"ASC"), Array("IBLOCK_ID" => PASS_ID, "PROPERTY_code_number" => $_GET["code"]), false, false, Array("ID"));
    	if($rez = $ob->GetNextElement()){
    		$arResult = $rez->GetFields();
    		$ID = $arResult["ID"];
    		CIBlockElement::SetPropertyValuesEx( $ID, PASS_ID, array("USER_ID" => $arFields["USER_ID"]));
    	}
    	LocalRedirect("/lk/");
	}
}



class Film{
	private $USER;
	private $v_count = 10;// ���������� ����������
	private $d_count = 10;// ���������� ����������
	function __construct(){
		CModule::IncludeModule('iblock');
		CModule::IncludeModule('sale');
		CModule::IncludeModule('catalog');
        $this->d_count = COption::GetOptionInt("racoon.pay", "DOWNLOAD_COUNT");
        $this->v_count = COption::GetOptionInt("racoon.pay", "VIEW_COUNT");
		global $USER;
		$this->USER = $USER;
	}
	/**
	* �������� ��� �� ������ ������
	* @param int $order_id ����� �����
	 * @return int/false ��� ��� ���������
	*/
	function getCodeFromOrderId($order_id){
		$u_arSelect = Array("ID", "PROPERTY_CODE_NUMBER");
		$u_arFilter = Array("IBLOCK_ID"=>PASS_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_ORDER_ID"=>$order_id);
		$u_res = CIBlockElement::GetList(Array("created"=>"desc"), $u_arFilter, false, false, $u_arSelect);
		if($u_res->SelectedRowsCount() > 0){
			$u_ob = $u_res->GetNextElement();
			$arResult = $u_ob->GetFields();
			return $arResult["PROPERTY_CODE_NUMBER_VALUE"];
		}
		return false;
	}

    /**
     * @param int $out_summ �����
     * @param int $user_id ������������� ������������
     * @param int $film_id ������������� ������
     * @param bool $download  ��� ����������
     * @param int $schet ����� �����
     * @return int ���
     */
	public function add_code($out_summ, $user_id, $film_id, $download = false, $schet)
	{
		//if($code = $this->getCodeFromOrderId($order_id)) return  $code;
	    $code = rand(1000, 9999);
	    $el   = new CIBlockElement;
	    $PROP                = array();
	    $PROP['code_number'] = $code;
	    $PROP['email']       = iconv('utf-8', 'windows-1251', $_POST['mail']);
	    $PROP['summa']       = $out_summ;
	    $PROP['USER_ID'] = $user_id;
	    $PROP['FILM_ID'] = $film_id;
	    $PROP['ORDER_ID'] = $schet;
	    if($download){
	    	$PROP['DOWNLOAD'] = true;
	    	$PROP["DOWN_COUNT"] = $this->d_count;
	    }else{
	    	$PROP["VIEW_COUNT"] = $this->v_count;
	    }
	    //pre_print($PROP );
	    $arLoadProductArray  = array(
	        //"MODIFIED_BY"       => $USER->GetID(), // ������� ������� ������� �������������
	        "IBLOCK_SECTION_ID" => false, // ������� ����� � ����� �������
	        "IBLOCK_ID"         => PASS_ID,
	        "PROPERTY_VALUES"   => $PROP,
	        "DATE_ACTIVE_FROM"  => ConvertTimeStamp(time(), "FULL"),
	        "DATE_ACTIVE_TO"    => ConvertTimeStamp(time() + (FILM_RANGE * 24 * 60 * 60), "FULL"), //date("d-m-Y",time() + (2 * 24 * 60 * 60)),    // 2 ��� 60 ���. 60 ���.*/
	        "NAME"              => "�������_" . $code,
	        "ACTIVE"            => "Y", // �������
	        "PREVIEW_TEXT"      => "����� ��� ������ ���������",
	        "DETAIL_TEXT"       => "����� ��� ���������� ���������",
	    );

	    $PRODUCT_ID = $el->Add($arLoadProductArray);

	 return $code;
	}
	/* ��������� ����� � ��������� */
	function user_add_pay_film(){
		$arUser['UF_PAID'];
	}

	public function update_schet($out_summ, $Shp_user){
	    $ID = (int)$Shp_user;
	    $rsUser = CUser::GetByID($ID);
	    $arUser = $rsUser->Fetch();
	    $schet = $arUser["UF_SCHET"];
	    $schet += $out_summ;
	    $user = new CUser;
	    $fields = Array(
	      "UF_SCHET" => $schet
	      );
	    if($user->Update($ID, $fields))
	    	return true;
	    else
	    	$user->LAST_ERROR;
	}

	public function get_film_from_id($id){
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PICTURE", "PREVIEW_TEXT", "DETAIL_PAGE_URL");
		$arFilter = Array("IBLOCK_ID"=>FILM_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID"=>$id);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
		if($ob = $res->GetNextElement())
		{
			 $arResult = $ob->GetFields();
			 $arResult['PROP'] = $ob->GetProperties();
			 $arResult['IMG'] = CFile::GetPath($arResult['DETAIL_PICTURE']);
		}
		return $arResult;
	}

	public function get_genre_from_id($id){
		$arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL");
		$arFilter = Array("IBLOCK_ID"=>GENRE_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID"=>$id);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
		if($ob = $res->GetNextElement())
		{
			 $arResult = $ob->GetFields();
		}
		return $arResult;
	}
	public function get_acter_from_id($id){
		$arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL");
		$arFilter = Array("IBLOCK_ID"=>15, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID"=>$id);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
		if($ob = $res->GetNextElement())
		{
			 $arResult = $ob->GetFields();
		}
		return $arResult;
	}
	/**
	* �������� ������ ����� �� ID ������������ � ID ������
	* @param int $user ID ������������
	* @param int $film ID ������
	 * @return array ������ �����
	**/
	function get_pass($user, $film, $download = false){
		$user = $user || $this->USER->GetID();
		$u_arSelect = Array("ID", "PROPERTY_code_number" );
		$u_arFilter = Array("IBLOCK_ID"=>PASS_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_FILM_ID"=>$film,"PROPERTY_USER_ID"=>$user);
		if($download) {
			$u_arFilter["PROPERTY_DOWNLOAD"] = 1;
			$u_arFilter[">PROPERTY_DOWN_COUNT"] = 0;
		}else{
			$u_arFilter[">PROPERTY_VIEW_COUNT"] = 0;
		}
		$u_res = CIBlockElement::GetList(Array(), $u_arFilter, false, false, $u_arSelect);
		if($u_res->SelectedRowsCount() > 0){
			$arResult = array();
			while($ob = $u_res->GetNextElement()){
				$arResult[] = $ob->GetFields();
			}
			return $arResult;
		}
		return false;
	}

	/**
	* 	��������� ������������ � ����
	* @param int $film_id ID  ������
	* @param int $user_id ID ������������
	* @param int $code - ���
	 * @return int/false ID ������ � �����
	*/
	function addUserToCode($user_id, $code, $film_id = false){
		$sel = Array(
			"IBLOCK_ID" => PASS_ID, 
			"PROPERTY_code_number" => $code, 
		);
		if($film_id)
			$sel['PROPERTY_FILM_ID'] = $film_id;

		$ob = CIBlockElement::GetList( Array("SORT"=>"ASC"), $sel, false, false, Array("ID"));
    	if($rez = $ob->GetNextElement()){
    		$arResult = $rez->GetFields();
    		$ID = $arResult["ID"];
    		CIBlockElement::SetPropertyValuesEx( $ID, PASS_ID, array("USER_ID" => $user_id));
    		return $ID;
    	}
    	return false;
	}

    /**
     * @param int $out_summ ����� � ������
     * @param int $inv_id ����� �����
     * @param array $dop �������������� ���������
     * @return string HASH
     */
	static function getFilmCrc($out_summ,$inv_id,$dop){
		$ar_params = array(MRH_LOGIN,$out_summ,$inv_id,MRH_PASS1);
		$text_params = implode(":",$ar_params);

		$text_dop = "";
		ksort($dop);
		foreach ($dop as $key => $value) {
		  $text_dop .= ":Shp_".$key."=".$value;
		}
		//echo $text_params.$text_dop;
		return md5($text_params.$text_dop);
	}

}

?>