<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <? /*if(isset($_GET['m']) && $_GET['m'] == 1)
            echo " <meta name='viewport' content='width=device-width, initial-scale=1'>";
        else
            echo " <meta name='viewport' content='width=1170, user-scalable=yes'>";*/
        if(isset($_POST['login'])){
            global $USER;
            if (!is_object($USER)) $USER = new CUser;
            if($arAuthResult = $USER->Login($_POST['login'], $_POST['pass'], "N")){
                /*if($USER->IsAuthorized() && (int)$_POST["code"]){
                    $film = new Film;
                    $down = ($Shp_down == 1)?true:false;
                    $code = $film->add_code($out_summ, $Shp_user, $Shp_film, $down);
                }*/
                $user_in_aut = true;
            }
            
            //$APPLICATION->arAuthResult = $arAuthResult;
        }
        if($_REQUEST['logout']=="Y") $USER->Logout();


    ?>
    <?$APPLICATION->ShowHead();?>


    <script language=JavaScript>
      <!--
var message="Правый клик запрещен!";
///////////////////////////////////
/*
      function clickIE4(){
      if (event.button==2){
      alert(message);
      return false;
      }
      }
function clickNS4(e){
      if (document.layers||document.getElementById&&!document.all){
      if (e.which==2||e.which==3){
      alert(message);
      return false;
      }
      }
      }
if (document.layers){
      document.captureEvents(Event.MOUSEDOWN);
      document.onmousedown=clickNS4;
      }
      else if (document.all&&!document.getElementById){
      document.onmousedown=clickIE4;
      }
document.oncontextmenu=new Function("return false")*/
// --> 
      </script>
      
      
    <meta name='viewport' content='width=1170' />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?$APPLICATION->ShowTitle()?></title>

    <!-- Bootstrap -->
    <link href="<?=SITE_TEMPLATE_PATH?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=SITE_TEMPLATE_PATH?>/css/jquery.bxslider.css" rel="stylesheet">
    <!--<link href="<?=SITE_TEMPLATE_PATH?>/css/1jquery.mobile.structure-1.4.5.css" rel="stylesheet">-->
    <link href="<?=SITE_TEMPLATE_PATH?>/css/main.css" rel="stylesheet">
    <?/* if(isset($_GET['m']) && $_GET['m'] == 1):?>
        <link href="<?=SITE_TEMPLATE_PATH?>/css/mobile.css" rel="stylesheet">
    <? else:?>
        <link href="<?=SITE_TEMPLATE_PATH?>/css/dt.css" rel="stylesheet">
    <? endif;*/ ?>
    <link href="<?=SITE_TEMPLATE_PATH?>/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=SITE_TEMPLATE_PATH?>/css/jquery.fancybox.css" rel="stylesheet">
    <link href="<?=SITE_TEMPLATE_PATH?>/css/jquery-ui.min.css" rel="stylesheet">
    <link href="<?=SITE_TEMPLATE_PATH?>/css/owl.carousel.css" rel="stylesheet">
    <link href="<?=SITE_TEMPLATE_PATH?>/css/owl.theme.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--[if gt IE 9]>
        <link href="<?=SITE_TEMPLATE_PATH?>/css/ie.css" rel="stylesheet">
    <![endif]-->
    <?/*<link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
    <!-- If you'd like to support IE8 -->
    <script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>*/?>
    <link href="http://vjs.zencdn.net/6.2.8/video-js.css" rel="stylesheet">
    <!-- If you'd like to support IE8 -->
    <script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
</head>
<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
    <header>
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-inverse" role="navigation">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="logo" href="/"><img src="<?=SITE_TEMPLATE_PATH?>/img/logo.png" /></a>
                            <div class="visible-mobile pull-right">
                                <a class="btn" href="/search/"><i class="glyphicon glyphicon-search"></i></a>
                                <? if ($USER->IsAuthorized()):?>
                                    <a class="btn" href="/lk/" data-toggle="modal"><i class="glyphicon glyphicon-user"></i></a>
                                <? else: ?>
                                    <a class="btn" href="#pop-enter" data-toggle="modal"><i class="glyphicon glyphicon-user"></i></a>
                                <? endif;?>
                            </div>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse navbar-ex1-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="/kinozal/">Главная</a></li>
                                <li><a href="/about/o_kinozale/">О кинозале</a></li>
                                <li class="nav-dd"><a href="/kinozal/categories/">Фильмы</a><i class="glyphicon glyphicon-plus hidden-dt"></i>
                                    <?if(CModule::IncludeModule("iblock")){
                                            $arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL");
                                            $arFilter = Array("IBLOCK_ID"=>GENRE_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                                            $res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, Array("nPageSize"=>50), $arSelect); 
                                            while($ob = $res->GetNextElement())
                                            {
                                             $arCat[] = $ob->GetFields();
                                            }
                                        }?>
                                    <ul class="dropdown-menu hidden-xs " role="menu" aria-labelledby="dLabel">
                                        <? foreach ($arCat as $key => $item):
                                            $arMobile[$item['NAME']] = $item['DETAIL_PAGE_URL'];
                                            //
                                            $f_res = CIBlockElement::GetList(Array("sort"=>"asc"),array("IBLOCK_ID"=>FILM_ID,"PROPERTY_GENRE.NAME"=>$item['NAME'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y") , false, false, array("ID"));
                                            $f_rc = $f_res->SelectedRowsCount();
                                            //


                                            if($key == 0) echo "<li>";?>
                                                <?if($f_rc > 0):?><a  data-count='<?=$f_rc?>' href="<?=$item["DETAIL_PAGE_URL"]?>"><?=$item["NAME"]?></a><?endif;?>
                                        <? if(($key + 1) % 4 == 0 && $key != 0) echo "</li><li>";
                                        endforeach; ?> 
                                    </ul>
                                    <ul class="visible-mobile">
                                        <? ksort($arMobile, SORT_STRING);
                                        foreach ($arMobile as $key=>$item):?>
                                            <li><a href="<?=$item?>"><?=$key?></a></li>
                                        <? endforeach; ?> 
                                    </ul>
                                </li>
                                <li><a href="/about/usloviya/">Условия</a></li>
                                <li><a href="/contacts/kinozal/">Контакты</a></li>
                            </ul>
                            <span class="nav-bl3 navbar-left hidden-xs">
		  					
    		  					<form class="navbar-form navbar-left" action="/search/" role="search">
                                    <div class="form-group">
                                        <input type="text" name="q" class="form-control" placeholder="Поиск" /><i class="glyphicon glyphicon-search"></i>
                                    </div>
                                </form>
                                <? global $USER;
                                if ($USER->IsAuthorized()):?>
                                <ul class="user">
                                    <li><a class="btn btn-default btn-xs" href="/lk/" ><?=$USER->GetFirstName();?> <i class="glyphicon glyphicon-user"></i></a>
                                        <ul>
                                            <li><a href="/kinozal/?logout=Y" class="user__out" >Выйти</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                
                                <? else:?>
                                <a class="btn btn-default btn-xs" href="#pop-enter" data-toggle="modal">Войти <i class="glyphicon glyphicon-user"></i></a>
                                <? endif;?>
                                
                                
    	  					</span>
                        
                        </div>
                        <!-- /.navbar-collapse -->
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <div class="navbar-bg-right"></div>
    <div class="page-content">
<? if($APPLICATION->GetProperty("container") == "Y"){?>
<div class="container">
    <h1><?$APPLICATION->ShowTitle(false)?></h1>
    <div class="stat-page">
<?}?>