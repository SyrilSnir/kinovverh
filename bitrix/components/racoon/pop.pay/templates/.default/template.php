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
				
					<p class="modal-title">�������� �����<br />�<?=$arResult["FILM"]['NAME']?>�</p>
	                <?
	                // ����������� �����
	                if($arResult["SCHET_VIEW"])
	                	echo"<a class=\"pop-button schet-out \" data-summ='".$arResult["VIEW_SUMM"]."' href='#'> ������� ".$arResult["VIEW_SUMM"]." ������<br /> �� �����</a>";
	                else    
	                    echo "<a href='".$arResult["PAY"]["URL_FILM"]."' class=\"pop-button\">".$arResult["VIEW_SUMM"]." ������</a>";
	                // ������� �� ��������
                    if($arResult["PAY"]["URL_FILM_DOPLATA"]){
                    	echo "<p class='pay-description'>� ��� �� ����� ".$arResult["SCHET"]." ������.</p>";
                    	echo "<a href='".$arResult["PAY"]["URL_FILM_DOPLATA"]."' class=\"pop-button f-doplata\" data-summ='".$arResult["SCHET"]."' > ��������� ".$arResult["PAY"]["FILM_DOPLATA"]." ������</a>";
                    }
	                ?>
	                <p class="pay-description">����� ���� ���������� � ������� 30 ����.</p>
					<p class="modal-title">������� ����� <br />�<?=$arResult["FILM"]['NAME']?>�</p>
	                <?
	                // ��������� �����
	                if($arResult["SCHET_DOWNLOAD"])
                		echo"<a class=\"pop-button schet-out \" data-summ='".$arResult["DOWNLOAD_SUMM"]."' data-download=\"Y\" href='#'> ������� ".$arResult["DOWNLOAD_SUMM"]." ������<br /> �� �����</a>";
                    else
                        echo "<a href='".$arResult["PAY"]["URL_DOWNLOAD"]."' class=\"pop-button\">".$arResult["DOWNLOAD_SUMM"]." ������</a>";
                    // ������� �� ���������� hhh
                    if($arResult["PAY"]["URL_DOWNLOAD_DOPLATA"]){
                    	echo "<p class='pay-description'>� ��� �� ����� ".$arResult["SCHET"]." ������.</p>";
                    	echo "<a href='".$arResult["PAY"]["URL_DOWNLOAD_DOPLATA"]."' class=\"pop-button d-doplata\" data-summ='".$arResult["SCHET"]."' > ��������� ".$arResult["PAY"]["DOWNLOAD_DOPLATA"]." ������</a>";
                    }
	                ?>
					<p class="pay-description">�� ������ ������� ����� � ������� 30 ����.</p>

					<?/*p class="modal-title">���� �� ����������<br />�<?=$arResult["FILM"]['NAME']?>�</p>
					<a href="<?=$arResult["PAY"]["URL_DOWNLOAD"]?>" class="pop-button"><?=$arResult["DOWNLOAD_SUMM"]?> ������</a*/?>
					<p class="pay-description2">���� �� ��� ����� �������� ����� �� ������ ����������, ������� ���, ���������� ��� ������</p>
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