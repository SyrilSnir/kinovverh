<?php if($APPLICATION->GetProperty("container") == "Y"){?>
</div></div>
<?php } ?>
</div>
    <footer>
        <div class="container">
            <div class="col-md-12">
                <p class="copyright text-center">� ������� ��������� ���� ������� 2016</p>
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


<!-- ����� �������� � ��������� -->
    <div class="modal fade" id="pop-favorite">
    	<div class="modal-dialog modal-sm">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
    			</div>
    			<div class="modal-body">
    				<p class="text-center">����� �������� � ������ ���������� � <a href="/lk/">������ ��������</a></p>
    			</div>

    		</div>
    	</div>
    </div>
<!-- ���� -->
	<div class="modal fade" id="pop-enter">
    	<div class="modal-dialog modal-sm">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
    			</div>
    			<div class="modal-body">
                
    				<p class="modal-title">���� / �����������</p>
					<form class="enter-form" method="post" action="?" >
                        <input type="hidden" name="code" value="<?=$_GET['code'];?>" />
						<input type="text" placeholder="E-mail" name="login" required="required" />
						<input type="password" placeholder="������" name="pass" required="required" />
						<button type="submit"  class="enter-form__button" >����</button>
						<a href="#pop-register" data-dismiss="modal" data-toggle="modal" class="enter-form__button">�����������</a>
					</form>
                    <p class="enter-form__rez"></p>
					<div class="soc-enter">

						<p class="soc-enter__title">����� � ������� ���������� �����</p>
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
<!-- ����������� -->
    <div class="modal fade" id="pop-register">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                </div>
                <div class="modal-body">

                    <p class="modal-title">�����������</p>
                    <form class="enter-form" method="post" target="/lk/register.php">
                        <input type="text" placeholder="E-mail" name="login" required="required" />
                        <input type="password" placeholder="������" name="pass" required="required" />
                        <input type="password" placeholder="������������� ������" name="pass2" required="required" />
                        <button type="submit" name="acton" value="register" class="enter-form__button" >�����������</button>
                    </form>
                    <p class="enter-form__rez"></p>
                    <div class="soc-enter">
                        <p class="soc-enter__title">����� � ������� ���������� �����</p>
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
<?php /** ******* ����� ������ ������� **************** **/?>
    <?php $APPLICATION->IncludeComponent("racoon:pop.pay","",
        Array("FILM_ID" => $_SESSION["FILM_ID"], "FORM_ID" => "pop-pay")
    );?>
<!-- �������� �������� ������ -->
<?php /*	<div class="modal fade" id="pop-pay" data-film="<?=$arResult['ID']?>">
    	<div class="modal-dialog modal-sm">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
    			</div>
    			<div class="modal-body">
    				<p class="modal-title">�������� �������� ������<br />�<?=$arResult['NAME']?>�</p>
					<!--<a href="#" class="pop-button">30 ������</a>-->
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
                    $inv_desc = "������ ������ ".$arResult['NAME'];
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
                        echo "<a href='$url' class=\"pop-button\">".ONE_FILM_SUMM." ������</a>";
                    else
                        echo"<a class=\"pop-button schet-out \" data-summ='".ONE_FILM_SUMM."' href='#'> ������� ".ONE_FILM_SUMM." ������<br /> �� �����</a>";

                    ?>
					<p class="modal-title">�������� ��������<br />���� ������� �� �����</p>
                    <?
                      $inv_desc = "������ �������";
                        $out_summ = ALL_FILM_SUMM;
                        $Shp_film = "ALL";
                        $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_dir=$Shp_dir:Shp_film=$Shp_film:Shp_user=$Shp_user");
                        $url = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&".
                            "OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc&IsTest=$IsTest&Shp_film=$Shp_film&Shp_user=$Shp_user&Shp_dir=$Shp_dir";

                        if($schet_all == false)
                            echo "<a href='$url' class=\"pop-button\">".ALL_FILM_SUMM." ������</a>";
                        else
                            echo"<a class=\"pop-button schet-out \" data-summ='".ALL_FILM_SUMM."' href='#'> ������� ".ALL_FILM_SUMM." ������<br /> �� �����</a>";
                    ?>
					<p class="pay-description">��������� ������ ����� �������� ��� ��������� � ������� <span><?=FILM_RANGE?></span> ����</p>
					<p class="pay-description2">���� �������� ������ ��� ������� ��� ������� ����������, ������� ���</p>
					<div class="film_code">
                    <form method="get" action="">
                        <input class="film_code__input" required placeholder="������ ���" type="text" name="code">
                        <button class="film_code__button">OK</button>
                    </form>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
*/?>
<!-- �������, ��� ������ ������ -->
	<div class="modal fade" id="pop-pay-ok">
    	<div class="modal-dialog modal-sm">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
    			</div>
    			<div class="modal-body">
    				<p class="modal-title">�������, ��� ������ ������</p>
					<p class="pay-description2">����������, ����������������� ��� ������� � ���� �������, ����� ������������� ������ �� ����� ����������</p>
					<a href="#pop-enter" data-toggle="modal" data-dismiss="modal" class="pop-button">����</a>
					<a href="/login/?register=yes&code=<?=$_GET['code']?>" class="pop-button">�����������</a>
					<div class="soc-enter">
						<p class="soc-enter__title">����� � ������� ���������� �����</p>
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

					<p class="pay-description">��� ����� ��������� � ��������� ������. ����� ���������� ������ ����� ��� �� ������ ����������, �������� ���:</p>
					<p class="pay__new-code"><?=$u_code; ?></p>
					<a href="?code=<?=$u_code; ?>" data-dismiss="modal" class="pop-button pop-button--small pop-pay-ok__view">�������� ��� �����������</a>
    			</div>
    		</div>
    	</div>
    </div>
<!-- ��������� ���� -->
	<div class="modal fade" id="pop-pay-add">
    	<div class="modal-dialog modal-sm">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
    			</div>
    			<div class="modal-body">
    				<p class="modal-title">��������� ����</p>
					<p class="pay-description2">������� �����, �� ������� ������ ��������� ���� ������ ����:</p>
					 <?/*
                     $inv_desc = "��������� ���� ������������ ".$Shp_user;
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
    					<button type="submit" class="pop-button" >���������</button>
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
  "Play": "�������������",
  "Pause": "�������������",
  "Current Time": "������� �����",
  "Duration Time": "�����������������",
  "Remaining Time": "���������� �����",
  "Stream Type": "��� ������",
  "LIVE": "������",
  "Loaded": "��������",
  "Progress": "��������",
  "Fullscreen": "������������� �����",
  "Non-Fullscreen": "��������������� �����",
  "Mute": "��� �����",
  "Unmute": "�� ������",
  "Playback Rate": "�������� ���������������",
  "Subtitles": "��������",
  "subtitles off": "�������� ����.",
  "Captions": "�������",
  "captions off": "������� ����.",
  "Chapters": "�����",
  "You aborted the media playback": "�� �������� ��������������� �����",
  "A network error caused the media download to fail part-way.": "������ ���� ������� ���� �� ����� �������� �����.",
  "The media could not be loaded, either because the server or network failed or because the format is not supported.": "���������� ��������� ����� ��-�� �������� ��� ���������� ���� ���� ������ �� ��������������.",
  "The media playback was aborted due to a corruption problem or because the media used features your browser did not support.": "��������������� ����� ���� �������������� ��-�� ����������� ���� � ����� � ���, ��� ����� ���������� �������, ���������������� ����� ���������.",
  "No compatible source was found for this media.": "����������� ��������� ��� ����� ����� �����������."
});
</script>
</body>
</html>