<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arResult = array();
//$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");

if(CModule::IncludeModule("iblock")){
    // Получаем последний номер счета
    $arSelect = Array("ID","PROPERTY_S_ID");
    $arFilter = Array("IBLOCK_ID"=>18, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array("PROPERTY_S_ID"=>"desc,nulls"), $arFilter, false, Array("nPageSize"=>1), $arSelect);
    if($ob = $res->GetNextElement())
    {
        $arZakaz = $ob->GetFields();
    }
    unset($arSelect, $arFilter, $res, $ob);
    // ПОЛУЧАЕМ ФИЛЬМ 
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PICTURE", "PREVIEW_TEXT", "DETAIL_PAGE_URL");
    $arFilter = Array("IBLOCK_ID"=>FILM_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID"=>$arParams["FILM_ID"]);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
    if($ob = $res->GetNextElement())
    {
         $fields = $ob->GetFields();
         $prop = $ob->GetProperties();
    }
}

    // Стоимость
    $v_price = ($prop["PRICE_W"]["VALUE"])?$prop["PRICE_W"]["VALUE"]:ONE_FILM_SUMM; 
    define("V_PRICE", $v_price);                    // Стоимость просмотра
    define("D_PRICE", $prop["PRICE_D"]["VALUE"]);   // Стоимость скачивания
    //
    global $USER;
    $schet_one = $schet_all = false;
    // Счет пользователя
    if($USER->IsAuthorized()){
        $rsUser = CUser::GetByID($USER->GetID());
        $arUser = $rsUser->Fetch();
        if($arUser['UF_SCHET'] >= V_PRICE){
            $schet_one = true;
        }
        if($arUser['UF_SCHET'] >= D_PRICE){
            $schet_all = true;
        }
    }
// TEST
if($_GET["test"]){
    echo "<pre>";
    print_r($prop);
    echo "USER::\n";
    print_r($arUser);
    echo "</pre>";
}
    // *** СЧЕТ ПОЛЬЗОВАТЕЛЯ ***
    $arResult["SCHET_VIEW"] = $schet_one;
    $arResult["SCHET_DOWNLOAD"] = $schet_all;
    $arResult["SCHET"] = $arUser['UF_SCHET'];
    //
    // *** ЦЕНЫ ***
    $arResult["VIEW_SUMM"] = V_PRICE;
    $arResult["DOWNLOAD_SUMM"] = D_PRICE;
    // *** ДАННЫЕ ФИЛЬМА ***
    $arResult["FILM_RANGE"] = FILM_RANGE;
    $arResult["FILM"]["ID"] = $arParams["FILM_ID"];
    $arResult["FILM"]["NAME"] = $fields["NAME"];
    $arResult["FILM"]["PRICE_W"] = $prop["PRICE_W"]["VALUE"];
    $arResult["FILM"]["PRICE_D"] = $prop["PRICE_D"]["VALUE"];

    // 
    $mrh_login = MRH_LOGIN;
    $mrh_pass1 = MRH_PASS1;
    $inv_id = $arZakaz['PROPERTY_S_ID_VALUE'] + 1;
    $IsTest = IS_TEST;
    $Shp_user = $USER->GetID();
    $Shp_dir = $APPLICATION->GetCurDir();

    $inv_desc = "Оплата фильма ".$arResult['NAME'];
    $out_summ = ($prop["PRICE_W"]["VALUE"])?$prop["PRICE_W"]["VALUE"]:ONE_FILM_SUMM;
    $Shp_film = $arParams["FILM_ID"];
// Оплата просмотра фильма  $url=
    //$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_dir=$Shp_dir:Shp_film=$Shp_film:Shp_user=$Shp_user");
    $dop_arr = array('dir'=>$Shp_dir,'film'=>$Shp_film,'user'=>$Shp_user);
    $crc = Film::getFilmCrc($out_summ,$inv_id,$dop_arr);
    $arResult["PAY"]["URL_FILM"] = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&".
        "OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc&IsTest=$IsTest&Shp_film=$Shp_film&Shp_user=$Shp_user&Shp_dir=$Shp_dir";

// Оплата всех фильмов
/*	$inv_desc = "Оплата фильмов";
    $out_summ = ALL_FILM_SUMM;
    $Shp_film = "ALL";
    $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_dir=$Shp_dir:Shp_film=$Shp_film:Shp_user=$Shp_user");
    $arResult["PAY"]["URL_FILMS"] = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&".
        "OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc&IsTest=$IsTest&Shp_film=$Shp_film&Shp_user=$Shp_user&Shp_dir=$Shp_dir";*/

// Оплата скачивания
    $inv_desc = "Покупка фильма";
    $out_summ = $prop["PRICE_D"]["VALUE"];
    //$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_dir=$Shp_dir:Shp_down=1:Shp_film=$Shp_film:Shp_user=$Shp_user");
    $dop_arr = array('dir'=>$Shp_dir,'film'=>$Shp_film,'user'=>$Shp_user, 'down'=>1);
    $crc = Film::getFilmCrc($out_summ,$inv_id,$dop_arr);
    $arResult["PAY"]["URL_DOWNLOAD"] = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&".
        "OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc&IsTest=$IsTest&Shp_film=$Shp_film&Shp_user=$Shp_user&Shp_dir=$Shp_dir&Shp_down=1";

// Частичная оплата со счета
    if($USER->IsAuthorized()){
        if($arUser['UF_SCHET'] > 0 && $arUser['UF_SCHET'] < V_PRICE){
            $inv_desc = "Оплата фильма ".$arResult['NAME'];
            $out_summ = V_PRICE - $arUser['UF_SCHET'];
            $arResult["PAY"]["FILM_DOPLATA"] = $out_summ;
            // Оплата просмотра фильма 
            //$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_dir=$Shp_dir:Shp_film=$Shp_film:Shp_user=$Shp_user");
            $dop_arr = array('dir'=>$Shp_dir,'film'=>$Shp_film,'user'=>$Shp_user);
            $crc = Film::getFilmCrc($out_summ,$inv_id,$dop_arr);
            $arResult["PAY"]["URL_FILM_DOPLATA"] = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&".
                "OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc&IsTest=$IsTest&Shp_film=$Shp_film&Shp_user=$Shp_user&Shp_dir=$Shp_dir";
        }
        if($arUser['UF_SCHET'] > 0 && $arUser['UF_SCHET'] < D_PRICE){
            $inv_desc = "Покупка фильма ".$arResult['NAME'];
            $out_summ = D_PRICE - $arUser['UF_SCHET'];
            $arResult["PAY"]["DOWNLOAD_DOPLATA"] = $out_summ;
            // Оплата скачивания фильма
            //$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_dir=$Shp_dir:Shp_down=1:Shp_film=$Shp_film:Shp_user=$Shp_user");
            $dop_arr = array('dir'=>$Shp_dir,'film'=>$Shp_film,'user'=>$Shp_user, 'down'=>1);
            $crc = Film::getFilmCrc($out_summ,$inv_id,$dop_arr);
            $arResult["PAY"]["URL_DOWNLOAD_DOPLATA"] = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&".
                "OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc&IsTest=$IsTest&Shp_film=$Shp_film&Shp_user=$Shp_user&Shp_dir=$Shp_dir&Shp_down=1";

        }
    }

$this->IncludeComponentTemplate();
?>