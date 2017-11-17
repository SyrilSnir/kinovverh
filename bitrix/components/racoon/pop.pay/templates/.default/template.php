<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
global $USER;
if(empty($arResult))
	return "";
//pre_print($arResult);
?>
<div class="modal fade" id="<?=$arParams["FORM_ID"]?>" data-film="<?=$arResult["FILM"]['ID']?>">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
			</div>
			<div class="modal-body">
				
					<p class="modal-title">Смотреть фильм<br />«<?=$arResult["FILM"]['NAME']?>»</p>
	                <?
	                // Просмотреть фильм
	                if($arResult["SCHET_VIEW"])
	                	echo"<a class=\"pop-button schet-out \" data-summ='".$arResult["VIEW_SUMM"]."' href='#'> списать ".$arResult["VIEW_SUMM"]." рублей<br /> со счета</a>";
	                else    
	                    echo "<a href='".$arResult["PAY"]["URL_FILM"]."' class=\"pop-button\">".$arResult["VIEW_SUMM"]." рублей</a>";
	                // Доплата за просмотр
                    if($arResult["PAY"]["URL_FILM_DOPLATA"]){
                    	echo "<p class='pay-description'>У вас на счету ".$arResult["SCHET"]." рублей.</p>";
                    	echo "<a href='".$arResult["PAY"]["URL_FILM_DOPLATA"]."' class=\"pop-button f-doplata\" data-summ='".$arResult["SCHET"]."' > Доплатить ".$arResult["PAY"]["FILM_DOPLATA"]." рублей</a>";
                    }
	                ?>
	                <p class="pay-description">Фильм надо посмотреть в течение 30 дней.</p>
					<p class="modal-title">Скачать фильм <br />«<?=$arResult["FILM"]['NAME']?>»</p>
	                <?
	                // Загрузить фильм
	                if($arResult["SCHET_DOWNLOAD"])
                		echo"<a class=\"pop-button schet-out \" data-summ='".$arResult["DOWNLOAD_SUMM"]."' data-download=\"Y\" href='#'> списать ".$arResult["DOWNLOAD_SUMM"]." рублей<br /> со счета</a>";
                    else
                        echo "<a href='".$arResult["PAY"]["URL_DOWNLOAD"]."' class=\"pop-button\">".$arResult["DOWNLOAD_SUMM"]." рублей</a>";
                    // Доплата за скачивание hhh
                    if($arResult["PAY"]["URL_DOWNLOAD_DOPLATA"]){
                    	echo "<p class='pay-description'>У вас на счету ".$arResult["SCHET"]." рублей.</p>";
                    	echo "<a href='".$arResult["PAY"]["URL_DOWNLOAD_DOPLATA"]."' class=\"pop-button d-doplata\" data-summ='".$arResult["SCHET"]."' > Доплатить ".$arResult["PAY"]["DOWNLOAD_DOPLATA"]." рублей</a>";
                    }
	                ?>
					<p class="pay-description">Вы можете скачать фильм в течении 30 дней.</p>

					<?/*p class="modal-title">Цена за скачивание<br />«<?=$arResult["FILM"]['NAME']?>»</p>
					<a href="<?=$arResult["PAY"]["URL_DOWNLOAD"]?>" class="pop-button"><?=$arResult["DOWNLOAD_SUMM"]?> рублей</a*/?>
					<p class="pay-description2">Если Вы уже ранее оплатили фильм на другом устройстве, введите код, полученный при оплате</p>
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