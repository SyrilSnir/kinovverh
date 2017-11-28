<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$dir = explode("/",$APPLICATION->GetCurDir());

global $USER;

if(CModule::IncludeModule("iblock"))
{
	// Получаем фильм по его коду из Гет параметра
	$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PICTURE", "PREVIEW_TEXT", "DETAIL_PAGE_URL");
	$arFilter = Array("IBLOCK_ID"=>FILM_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "CODE"=>$_GET['cat']);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount"=>1), $arSelect);
	if($ob = $res->GetNextElement())
	{
		 $arFields = $ob->GetFields();
		 $prop = $ob->GetProperties();
		 $arResult = $arFields;
		 $arResult['IMG'] = CFile::GetPath($arResult['DETAIL_PICTURE']);
	}

	$_SESSION["FILM_ID"] = $arResult['ID'];
	// *** Добавление фильма если пользователь авторизовался ($user_in_aut Пользователь авторизовался после покупки)
	/*echo "UIA:".$user_in_aut;
	echo "PC:".(int)$_POST["code"];*/
	/*if($USER->IsAuthorized() && $user_in_aut && (int)$_POST["code"]){
        $film = new Film;
        $code = (int)$_POST["code"];
        //$down = ($Shp_down == 1)?true:false;
        //$code = $film->add_code(0, $USER->GetID(), $arResult['ID'], $down, 0);
        $film->addUserToCode($arResult['ID'], $USER->GetID(), $code);
        $_SESSION['U_CODE'][$arResult['ID']] = $code;
    }*/
	// *** Сохранение получение кода из сессии
	//if(!$USER->IsAuthorized()){
	    if(isset($_GET['code']) && $_GET['code'] != "" ){//&& !$USER->IsAuthorized()
	    	$_SESSION['U_CODE'][$arResult['ID']] = $_GET['code'];
	        //$_SESSION['U_CODE'] = $_GET['code'];
	    }
	    if(isset($_SESSION['U_CODE'][$arResult['ID']])) $u_code = $_SESSION['U_CODE'][$arResult['ID']];
   // }
	// *** Получаем Названия категорий
	foreach ($prop['GENRE']['VALUE'] as $g_id) {
		$arSelect = Array("NAME");
		$arFilter = Array("IBLOCK_ID"=>GENRE_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID" => $g_id);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		if($ob = $res->GetNextElement())
		{
			$g = $ob->GetFields();
			$prop['R_GENRE'][] = $g['NAME'];
		}
	}
	//
	//pre_print($prop);
	$APPLICATION->SetTitle("Смотреть фильм - ".$arResult['NAME']);

	if($prop['F_FREE']['VALUE'] == "Y"){
		// ************ Бесплатные ********************
		$film_free = true;
		$f_hash = md5($prop['URL_VIDEO']['VALUE'].":".$_SERVER['REMOTE_ADDR'].":".date("d:m:Y:H"));//$arFields['ID'].":".$_SERVER['REMOTE_ADDR'].":".date("d:m:Y:H")
		$_SESSION['OUT_HASH'] = $f_hash;
		$_SESSION['OUT_FILM'] = $prop['URL_VIDEO'];
		$film["VIEW"] = array(
						"ACTIVE" => true,
						"COUNT" => 999,
						"URL" => $prop['URL_VIDEO']['VALUE'],
					);
		$film["DOWNOLAD"] = array(
						"ACTIVE" => true,
						"COUNT" => 999,
						"URL" => $prop['D_LINK']['VALUE'],
					);
	}else{
		/*
		*	*** ПЛАТНЫЕ ***
		*
		* *** Выдергиваем Купленные фильмы для пользователя ***
		*/
		if($USER->IsAuthorized() || (isset($u_code) && $u_code !="")){

			$p_arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_FILM_ID", "PROPERTY_DOWNLOAD", "PROPERTY_VIEW_COUNT", "PROPERTY_DOWN_COUNT","PROPERTY_USER_ID");
			$p_arFilter = Array("IBLOCK_ID"=>13, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_FILM_ID" => array($arFields['ID']));

			if(isset($u_code)){
				$p_arFilter['PROPERTY_CODE_NUMBER'] = $u_code;			                                
                        } else {
                            if($USER->IsAuthorized()){
                                $p_arFilter["PROPERTY_USER_ID"] = $USER->GetID();
                            }
                        }
                        /*
			if($USER->IsAuthorized()){
                            $p_arFilter["PROPERTY_USER_ID"] = $USER->GetID();
                        }
			else{
                            $p_arFilter["PROPERTY_USER_ID"] = false;
                        }                         
                         */
			//if($_GET["test"]) print_r($p_arFilter);		
			$p_res = CIBlockElement::GetList(Array("active_from" => "desc"), $p_arFilter, false, false, $p_arSelect);

			//echo $p_res->SelectedRowsCount();
			$film["DOWNOLAD"] = array("ACTIVE" => false);
			$film["VIEW"] = array("ACTIVE" => false);                        
                        
			$film_free = false;
                        
                        
                        // флаги:
                        $exist = false; // код не найден
                        $show_expired = false; // срок действия кода истек                        
                        $anon_code = false; // введен анонимный код авторизованным пользователем
                        $other_user = false; // анонимом введен пользовательский код 

			while($p_ob = $p_res->GetNextElement())
			{                                
                                $exist = true;
				$p_arFields = $p_ob->GetFields();
                                $show_expired = ($p_arFields["PROPERTY_VIEW_COUNT_VALUE"] > 0) ? false: true;
				$f_hash = md5($prop['URL_VIDEO']['VALUE'].":".$_SERVER['REMOTE_ADDR'].":".date("d:m:Y:H"));//$arFields['ID'].":".$_SERVER['REMOTE_ADDR'].":".date("d:m:Y:H")
				$_SESSION['OUT_HASH'] = $f_hash;
				$_SESSION['OUT_FILM'] = $prop['URL_VIDEO'];
                                if (!$USER->IsAuthorized()) {
                                    if ($p_arFields['PROPERTY_USER_ID_VALUE']) {
                                        $other_user = true;
                                        break;
                                    }
                                }
				if($p_arFields["PROPERTY_DOWNLOAD_VALUE"] == 1 && $p_arFields['PROPERTY_DOWN_COUNT_VALUE'] > 0){
					$film["DOWNOLAD"] = array(
						"ACTIVE" => true,
						"COUNT" => $p_arFields['PROPERTY_DOWN_COUNT_VALUE'],
						"ID" => $p_arFields['ID'],
						"URL" => $prop['D_LINK']['VALUE']
					);
				}
				if($p_arFields['PROPERTY_FILM_ID_VALUE'] == $arResult['ID'] && $p_arFields["PROPERTY_VIEW_COUNT_VALUE"] > 0){
                               // if (true) {
					$film["VIEW"] = array(
						"ACTIVE" => true,
						"COUNT" => $p_arFields["PROPERTY_VIEW_COUNT_VALUE"],
						"ID" => $p_arFields['ID'],
						"URL" => $prop['URL_VIDEO']['VALUE'],
					);
					$f_hash = md5($prop['URL_VIDEO']['VALUE'].":".$_SERVER['REMOTE_ADDR'].":".date("d:m:Y:H"));//$arFields['ID'].":".$_SERVER['REMOTE_ADDR'].":".date("d:m:Y:H")
					$_SESSION['OUT_HASH'] = $f_hash;
					$_SESSION['OUT_FILM'] = $prop['URL_VIDEO'];
				}
                                if (!$p_arFields['PROPERTY_USER_ID_VALUE']) {
                                    $anon_code = true;
                                }
				

			}
		}
	}

}

// модальнон окно добавления анонимного кода
if ($anon_code) {
    if ($USER->IsAuthorized()) {
            ?>
        <script>
            window.onload = function() {
                $('#pop-add-code').modal('show');
                $('#add-code-user').click(function () {
                    $.ajax({
                        url: "/ajax.php",
                        type: "POST",
                        data: {
                            action: "add_code_to_user",
                            code: <?php echo $u_code ?>
                        },
                        success: function(response){
                            $('#pop-add-code').modal('hide');
                        }
                    });
                });
            };
        </script>>
        
 <?php
    }
}
if ((!$exist || $show_expired || $other_user) && !$film_free) {
    if ($other_user) {
        $err_text = 'Введен код, принадлежащий зарегистрированному пользователю';
    }
    elseif (!empty($_GET['code'])) { 
        unset ($p_arFilter["ACTIVE_DATE"]);
        unset ($p_arFilter["ACTIVE"]);
        $p_res = CIBlockElement::GetList(Array("active_from" => "desc"), $p_arFilter, false, false, $p_arSelect);
        if ($p_res->GetNextElement() && !$show_expired) {
            $err_text = 'Истек срок действия кода доступа';
        } else {
            if ($show_expired == true) {
                $err_text = 'Превышено число просмотров';
            }
            else {
                $err_text = 'Введен неверный код доступа';
            }
        } 
    }
    
    ?>


    <script>
	window.onload = function(){
                $('#pop-pay .enter-form__rez').text('<?=$err_text ?>');
		$('#pop-pay').modal('show');                
	}
</script>
    <?php    
}

// TEST
if($_GET["test"]){
	echo "code:";
	pre_print($_SESSION['U_CODE']);
	echo "film:";
	pre_print($film);
} 

/*
* 		*** Скрываем пустые страницы ***
*/
$arHidden = array();
if((int)$prop['FORUM_MESSAGE_CNT']['VALUE'] == 0)
	$arHidden['comment'] = true;
if($prop['trailer']['VALUE'] == "")
	$arHidden['traylers'] = true;
if($prop['F_PANORAMA']['VALUE'] == "")
	$arHidden['panorama'] = true;
if($prop['F_CADRS']['VALUE'] == "")
	$arHidden['cadrs'] = true;
if($prop['F_ACTERS']['VALUE'] == "" && $prop['director']['VALUE'] == "")
	$arHidden['creators'] = true;
if($prop['URL_VIDEO']['VALUE'] == "")
	$arHidden['download'] = true;

global $USER;
?>
		<section class="section-1 film">
			<div class="container" >
				<div class="row film m-row">
					<!-- FID:: <?=$arResult['ID']?> -->
					<?php
					//$film = $p_arFields['PROPERTY_FILM_ID_VALUE'] == $arResult['ID'] && $p_arFields["PROPERTY_VIEW_COUNT_VALUE"] > 0 || $prop['F_FREE']['VALUE'] == "Y";
					//$download = ($p_arFields["PROPERTY_DOWNLOAD_VALUE"] == 1 && $p_arFields['PROPERTY_DOWN_COUNT_VALUE'] > 0)?"Y":"N";
					//echo "<!-- FILM:: ".(($film)?"Y":"N")." PD:: ".$download." FREE:: ".(($prop['F_FREE']['VALUE'] == "Y")?"Y":"N")." -->";


					if($film["VIEW"]["ACTIVE"]):?>
						<?php // ПРОСМОТР ФИЛЬМА VIEW_COUNT -1 53
						if($film["VIEW"]["ID"])
							CIBlockElement::SetPropertyValuesEx($film["VIEW"]["ID"], 13, array("VIEW_COUNT" => ($film["VIEW"]["COUNT"] - 1)));

						echo "Осталось просмотреть ".($film["VIEW"]["COUNT"] - 1)." раз.";
						?>
						<video id="my-video" class="video-js  vjs-default-skin vjs-big-play-centered" width="1000px" data-height="auto" data-setup='{"language":"ru"}' controls="controls" preload="auto" >
							<source src="/video/<?=$f_hash;//out/?file=<?=$arFields['ID'];?>" type='video/mp4; codecs="avc1.4D401E, mp4a.40.2"'><!--type='video/mp4'   autoplay="autoplay"-->
							<track kind="subtitles" src="<?=CFile::GetPath($prop['F_SUBTITLE']['VALUE']);?>" srclang="ru" label="Русский" default>
								<p class="vjs-no-js">
							      To view this video please enable JavaScript, and consider upgrading to a web browser that
							      <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
							    </p>
						</video>
						
					<?php else:
							// Скачивание фильма DOWN_COUNT -1 52
						
						if($film["DOWNOLAD"]["ACTIVE"]){
							//CIBlockElement::SetPropertyValuesEx($film["DOWNOLAD"]["ID"], 13, array("DOWN_COUNT" => ($film["DOWNOLAD"]["COUNT"] - 1)));
							echo "Осталось скачать ".($film["DOWNOLAD"]["COUNT"] - 1)." раз.";
						}?>
						<div class="col-md-3 film__img">
							<img src="<?=$arResult['IMG'];?>" class="img-responsive" alt="Image">
						</div>
						<div class="col-md-9 film__text ">
							<p class="film__title">Кинозал семейного просмотра</p>
							<p class="film__description">Только проверенные фильмы в хорошем качестве. Купите этот фильм или подписку на все фильмы и наслаждайтесь просмотром фильма без рекламы и на любом устройстве!</p>
							<div class="film__buttons ">
								<a href="#pop-pay" class="caption-btn__btn" data-toggle="modal" >Оплатить</a>
								<?php if($film["DOWNOLAD"]["ACTIVE"]):?>
									<a href="/kinozal/download/<?=$film["DOWNOLAD"]["ID"]?>/<?=$film["DOWNOLAD"]["URL"]?>" class="caption-btn__btn film-download" data-toggle="modal" download >Скачать фильм</a>
								<?php endif;?>
								<?php if($arHidden['panorama'] != true):?>
									<a href="<?=$arResult["DETAIL_PAGE_URL"];?>panorama/" class="caption-btn__btn">Кинопанорама</a>
								<?php endif;?>
								<a href="<?php if ($USER->IsAuthorized()) echo"#pop-favorite"; else echo"#pop-enter"?>" class="caption-btn__btn caption-btn__btn--inverse" data-toggle="modal" data-id="<?=$arResult['ID'];?>">Смотреть позже <i class="glyphicon glyphicon-bookmark"></i></a>
							</div>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</section>
		<section class="section-2">
			<div class="container">
				<p class="film-title"><?=$arResult['NAME']?></p>
				<div class="film-tabs" role="tabpanel">
					<?php $APPLICATION->IncludeFile("include/middle-nav.php",array("f_id" => $arResult['ID'], "hidden" => $arHidden ));?>

					<!-- Tab panes -->
					<div class="films-tabs__content tab-content">

						<div role="tabpanel" class="tab-pane active" id="home">
							<div class="row">
								<div class=" col-md-3 hidden-mobile">
									<div class="film-tabs__img"><img src="<?=$arResult['IMG'];?>" class="img-responsive" alt="Image" /></div>
								</div>
								<div class="film-tabs__description col-md-9">
									<p>
									<span>Год выпуска:</span> <?=$prop['year']['VALUE'];?>
									<span>Страна:</span> <?=$prop['F_COUNTRY']['VALUE'];?>
									<span>Рейтинг:</span> <?=$prop['rating']['VALUE'];?>
									<span>Жанр:</span> <?=implode(", ",$prop['R_GENRE']);?>
									<span>Время:</span> <?=$prop['F_TIME']['VALUE'];?> мин.
									</p>
									<p><?=$arResult['PREVIEW_TEXT'];?></p>
								</div>
							</div>

							<div class="film-commens hidden-dt">
<?php $APPLICATION->IncludeComponent("bitrix:forum.topic.reviews", ".default", array(
	"FORUM_ID" => "1",
	"IBLOCK_TYPE" => "kinozal",
	"IBLOCK_ID" => "11",
	"ELEMENT_ID" => $arResult["ID"],
	"POST_FIRST_MESSAGE" => "Y",
	"POST_FIRST_MESSAGE_TEMPLATE" => "#IMAGE#[url=#LINK#]#TITLE#[/url]#BODY#",
	"URL_TEMPLATES_READ" => "read.php?FID=#FID#&TID=#TID#",
	"URL_TEMPLATES_DETAIL" => "photo_detail.php?ID=#ELEMENT_ID#",
	"URL_TEMPLATES_PROFILE_VIEW" => "profile_view.php?UID=#UID#",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "0",
	"MESSAGES_PER_PAGE" => "2",
	"PAGE_NAVIGATION_TEMPLATE" => ".default",
	"DATE_TIME_FORMAT" => "d.m.Y",
	"NAME_TEMPLATE" => "",
	"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
	"EDITOR_CODE_DEFAULT" => "Y",
	"SHOW_AVATAR" => "N",
	"SHOW_RATING" => "N",
	"RATING_TYPE" => "like",
	"SHOW_MINIMIZED" => "N",
	"USE_CAPTCHA" => "N",
	"PREORDER" => "Y",
	"SHOW_LINK_TO_FORUM" => "N",
	"FILES_COUNT" => "0",
	"AJAX_POST" => "Y"
	),
	false
);?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
<?php if($u_code != "" && $_GET['pop']=="Y" && !$USER->IsAuthorized()):?>
<script>
	window.onload = function(){
		$('#pop-pay-ok').modal('show');
	}
</script>
<?php endif; ?>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>