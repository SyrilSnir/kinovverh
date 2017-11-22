<?php if($APPLICATION->GetProperty("container") == "Y"){?>
</div></div>
<?php } ?>
</div>
    <footer>
        <div class="container">
            <div class="col-md-12">
                <p class="copyright text-center">© Кинозал семейного кино «Вверх» 2016</p>
            </div>
        </div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter40318850 = new Ya.Metrika({
                    id:40318850,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/40318850" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=SITE_TEMPLATE_PATH?>/js/jquery-1.12.3.min.js"></script>
    <!--<script src="<?=SITE_TEMPLATE_PATH?>/js/1jquery.mobile-1.4.5.min.js"></script>-->
    <script src="<?=SITE_TEMPLATE_PATH?>/js/main.js"></script>

    <script src="<?=SITE_TEMPLATE_PATH?>/js/inputmask.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.inputmask.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/inputmask.date.extensions.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.bxslider.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=SITE_TEMPLATE_PATH?>/js/bootstrap.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.fancybox.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/owl.carousel.min.js"></script>


<!-- Фильм добавлен в избранное -->
    <div class="modal fade" id="pop-favorite">
    	<div class="modal-dialog modal-sm">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
    			</div>
    			<div class="modal-body">
    				<p class="text-center">Фильм добавлен в раздел «Избранное» в <a href="/lk/">личном кабинете</a></p>
    			</div>

    		</div>
    	</div>
    </div>
<!-- Вход -->
	<div class="modal fade" id="pop-enter">
    	<div class="modal-dialog modal-sm">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
    			</div>
    			<div class="modal-body">
                
    				<p class="modal-title">Вход / Регистрация</p>
					<form class="enter-form" method="post" action="?" >
                        <input type="hidden" name="code" value="<?=$_GET['code'];?>" />
						<input type="text" placeholder="E-mail" name="login" required="required" />
						<input type="password" placeholder="Пароль" name="pass" required="required" />
						<button type="submit"  class="enter-form__button" >Вход</button>
						<a href="#pop-register" data-dismiss="modal" data-toggle="modal" class="enter-form__button">Регистрация</a>
					</form>
                    <p class="enter-form__rez"></p>
					<div class="soc-enter">

						<p class="soc-enter__title">Войти с помощью социальных сетей</p>
                        <?php $APPLICATION->IncludeComponent("bitrix:system.auth.form","",Array(
                         "REGISTER_URL" => "/login/",
                         "FORGOT_PASSWORD_URL" => "",
                         "PROFILE_URL" => "/lk/",
                         "SHOW_ERRORS" => "Y"
                         ));?>

					</div>
    			</div>
    		</div>
    	</div>
    </div>
<!-- Регистрация -->
    <div class="modal fade" id="pop-register">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                </div>
                <div class="modal-body">

                    <p class="modal-title">Регистрация</p>
                    <form class="enter-form" method="post" target="/lk/register.php">
                        <input type="text" placeholder="E-mail" name="login" required="required" />
                        <input type="password" placeholder="Пароль" name="pass" required="required" />
                        <input type="password" placeholder="Подтверждение пароля" name="pass2" required="required" />
                        <button type="submit" name="acton" value="register" class="enter-form__button" >Регистрация</button>
                    </form>
                    <p class="enter-form__rez"></p>
                    <div class="soc-enter">
                        <p class="soc-enter__title">Войти с помощью социальных сетей</p>
                        <?php $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons",
                           array(
                              "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                              "SUFFIX"=>"form",
                           ),
                           $component,
                           array("HIDE_ICONS"=>"Y")
                        );?>
                        <?php if($arResult["AUTH_SERVICES"]):?>
                            <?php $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
                            array(
                            "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                            "AUTH_URL"=>$arResult["AUTH_URL"],
                            "POST"=>$arResult["POST"],
                            "POPUP"=>"Y",
                            "SUFFIX"=>"form",
                            ),
                            $component,
                            array("HIDE_ICONS"=>"N")
                            );?>
                        <?php endif;?>
                         <?php $APPLICATION->IncludeComponent("bitrix:system.auth.form","",Array(
                         "REGISTER_URL" => "/login/",
                         "FORGOT_PASSWORD_URL" => "",
                         "PROFILE_URL" => "/lk/",
                         "SHOW_ERRORS" => "Y"
                         ));?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php /** ******* ФОРМЫ ОПЛАТЫ ФИЛЬМОВ **************** **/?>
    <?php $APPLICATION->IncludeComponent("racoon:pop.pay","",
        Array("FILM_ID" => $_SESSION["FILM_ID"], "FORM_ID" => "pop-pay")
    );?>
<!-- Оплатить просмотр фильма -->
<?php /*	<div class="modal fade" id="pop-pay" data-film="<?=$arResult['ID']?>">
    	<div class="modal-dialog modal-sm">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
    			</div>
    			<div class="modal-body">
    				<p class="modal-title">Оплатить просмотр фильма<br />«<?=$arResult['NAME']?>»</p>
					<!--<a href="#" class="pop-button">30 рублей</a>-->
                    <? // XZJE0Nl63hwf2RoYLhp4  kTNr7IXLgA970wr4fJfZ
                    if(CModule::IncludeModule("iblock")){
                        $arSelect = Array("ID","PROPERTY_S_ID");
                        $arFilter = Array("IBLOCK_ID"=>18, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                        $res = CIBlockElement::GetList(Array("id"=>"desc"), $arFilter, false, Array("nPageSize"=>1), $arSelect);
                        if($ob = $res->GetNextElement())
                        {
                            $arZakaz = $ob->GetFields();
                        }
                        unset($arSelect, $arFilter, $res, $ob);
                    }

                    global $USER;
                    $schet_one = $schet_all = false;
                    //pre_print($arUser);//UF_SCHET
                    if($USER->IsAuthorized()){
                        $rsUser = CUser::GetByID($USER->GetID());
                        $arUser = $rsUser->Fetch();
                        if($arUser['UF_SCHET'] >= ONE_FILM_SUMM){
                            $schet_one = true;
                        }
                        if($arUser['UF_SCHET'] >= ALL_FILM_SUMM){
                            $schet_all = true;
                        }
                    }

                    $mrh_login = MRH_LOGIN;
                    $mrh_pass1 = MRH_PASS1;
                    $inv_id = $arZakaz['PROPERTY_S_ID_VALUE'] + 1;
                    $inv_desc = "Оплата фильма ".$arResult['NAME'];
                    $out_summ = ONE_FILM_SUMM;
                    $IsTest = IS_TEST;
                    $Shp_dir = $APPLICATION->GetCurDir();
                    $Shp_film = $arResult['ID'];
                    $Shp_user = $USER->GetID();

                    $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_dir=$Shp_dir:Shp_film=$Shp_film:Shp_user=$Shp_user");
                      // build URL
                    $url = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&".
                        "OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc&IsTest=$IsTest&Shp_film=$Shp_film&Shp_user=$Shp_user&Shp_dir=$Shp_dir";

                    // print URL if you need
                    if($schet_one == false)
                        echo "<a href='$url' class=\"pop-button\">".ONE_FILM_SUMM." рублей</a>";
                    else
                        echo"<a class=\"pop-button schet-out \" data-summ='".ONE_FILM_SUMM."' href='#'> списать ".ONE_FILM_SUMM." рублей<br /> со счета</a>";

                    ?>
					<p class="modal-title">Оплатить просмотр<br />всех фильмов на сайте</p>
                    <?
                      $inv_desc = "Оплата фильмов";
                        $out_summ = ALL_FILM_SUMM;
                        $Shp_film = "ALL";
                        $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_dir=$Shp_dir:Shp_film=$Shp_film:Shp_user=$Shp_user");
                        $url = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&".
                            "OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc&IsTest=$IsTest&Shp_film=$Shp_film&Shp_user=$Shp_user&Shp_dir=$Shp_dir";

                        if($schet_all == false)
                            echo "<a href='$url' class=\"pop-button\">".ALL_FILM_SUMM." рублей</a>";
                        else
                            echo"<a class=\"pop-button schet-out \" data-summ='".ALL_FILM_SUMM."' href='#'> списать ".ALL_FILM_SUMM." рублей<br /> со счета</a>";
                    ?>
					<p class="pay-description">Купленные фильмы будут доступны для просмотра в течение <span><?=FILM_RANGE?></span> дней</p>
					<p class="pay-description2">Если просмотр фильма уже оплачен для другого устройства, введите код</p>
					<div class="film_code">
                    <form method="get" action="">
                        <input class="film_code__input" required placeholder="Ввести код" type="text" name="code">
                        <button class="film_code__button">OK</button>
                    </form>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
*/?>
<!-- Спасибо, ваш платеж принят -->
	<div class="modal fade" id="pop-pay-ok">
    	<div class="modal-dialog modal-sm">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
    			</div>
    			<div class="modal-body">
    				<p class="modal-title">Спасибо, ваш платеж принят</p>
					<p class="pay-description2">Пожалуйста, зарегистрируйтесь или войдите в свой аккаунт, чтобы просматривать фильмы на любом устройстве</p>
					<a href="#pop-enter" data-toggle="modal" data-dismiss="modal" class="pop-button">Вход</a>
					<a href="/login/?register=yes&code=<?=$_GET['code']?>" class="pop-button">Регистрация</a>
					<div class="soc-enter">
						<p class="soc-enter__title">Войти с помощью социальных сетей</p>
                        <?php
                        $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons",
                           array(
                              "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                              "SUFFIX"=>"form",
                           ),
                           $component,
                           array("HIDE_ICONS"=>"Y")
                        );?>
                        <?if($arResult["AUTH_SERVICES"]):?>
                            <?$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
                            array(
                            "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                            "AUTH_URL"=>$arResult["AUTH_URL"],
                            "POST"=>$arResult["POST"],
                            "POPUP"=>"Y",
                            "SUFFIX"=>"form",
                            ),
                            $component,
                            array("HIDE_ICONS"=>"N")
                            );?>
                        <? endif;?>
						<ul class="soc-enter__icons">
							<li><a href="#"><img src="<?=SITE_TEMPLATE_PATH?>/img/vk.svg" /></a></li>
							<li><a href="#"><img src="<?=SITE_TEMPLATE_PATH?>/img/fb.svg" /></a></li>
							<li><a href="#"><img src="<?=SITE_TEMPLATE_PATH?>/img/odn.svg" /></a></li>
						</ul>
					</div>

					<p class="pay-description">Или сразу перейдите к просмотру фильма. Чтобы посмотреть фильма позже или на другом устройстве, запишите код:</p>
					<p class="pay__new-code"><?=$u_code; ?></p>
					<a href="?code=<?=$u_code; ?>" data-dismiss="modal" class="pop-button pop-button--small pop-pay-ok__view">Смотреть без регистрации</a>
    			</div>
    		</div>
    	</div>
    </div>
<!-- Пополнить счет -->
	<div class="modal fade" id="pop-pay-add">
    	<div class="modal-dialog modal-sm">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
    			</div>
    			<div class="modal-body">
    				<p class="modal-title">Пополнить счет</p>
					<p class="pay-description2">Укажите сумму, на которую хотите пополнить свой личный счет:</p>
					 <?/*
                     $inv_desc = "Пополнить счет пользователя ".$Shp_user;
                     $def_sum = "300";
                     $Shp_shet="Y";
                      $crc = md5("$mrh_login::$inv_id:$mrh_pass1:Shp_shet=$Shp_shet:Shp_user=$Shp_user");
                      print "<html><script language=JavaScript ".
                          "src='https://auth.robokassa.ru/Merchant/PaymentForm/FormFLS.js?".
                          "MerchantLogin=$mrh_login&DefaultSum=$def_sum&InvoiceID=$inv_id".
                          "&Description=$inv_desc&SignatureValue=$crc&IsTest=$IsTest&Shp_shet=$Shp_shet&Shp_user=$Shp_user'></script></html>"; */
                    ?>
                    <form method="post" action="/pay/">
                        <input class="pay-summ" value="" required="required" name="summ" />
    					<button type="submit" class="pop-button" >Пополнить</button>
                    </form>
    			</div>
    		</div>
    	</div>
    </div>
<!--<?// pre_print($arAuthResult);?>-->
<?php if(is_array($arAuthResult) && $arAuthResult['TYPE'] == 'ERROR'){?>
    <script type="text/javascript">
        function popErr(){
                $("#pop-enter .enter-form__rez").html("<?=$arAuthResult['MESSAGE'];?>");
                $("#pop-enter").modal('show');
            }
        $(function(){
            setTimeout("popErr()", 500);
        });
    </script>
<?php }?>
<?php//<script src="http://vjs.zencdn.net/5.8.8/video.js"></script>?>
<script src="http://vjs.zencdn.net/6.2.8/video.js"></script>
<script type="text/javascript">
    videojs.addLanguage("ru",{
  "Play": "Воспроизвести",
  "Pause": "Приостановить",
  "Current Time": "Текущее время",
  "Duration Time": "Продолжительность",
  "Remaining Time": "Оставшееся время",
  "Stream Type": "Тип потока",
  "LIVE": "ОНЛАЙН",
  "Loaded": "Загрузка",
  "Progress": "Прогресс",
  "Fullscreen": "Полноэкранный режим",
  "Non-Fullscreen": "Неполноэкранный режим",
  "Mute": "Без звука",
  "Unmute": "Со звуком",
  "Playback Rate": "Скорость воспроизведения",
  "Subtitles": "Субтитры",
  "subtitles off": "Субтитры выкл.",
  "Captions": "Подписи",
  "captions off": "Подписи выкл.",
  "Chapters": "Главы",
  "You aborted the media playback": "Вы прервали воспроизведение видео",
  "A network error caused the media download to fail part-way.": "Ошибка сети вызвала сбой во время загрузки видео.",
  "The media could not be loaded, either because the server or network failed or because the format is not supported.": "Невозможно загрузить видео из-за сетевого или серверного сбоя либо формат не поддерживается.",
  "The media playback was aborted due to a corruption problem or because the media used features your browser did not support.": "Воспроизведение видео было приостановлено из-за повреждения либо в связи с тем, что видео использует функции, неподдерживаемые вашим браузером.",
  "No compatible source was found for this media.": "Совместимые источники для этого видео отсутствуют."
});
</script>
</body>
</html>