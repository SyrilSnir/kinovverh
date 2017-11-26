<?php
// обработчик запросов ajax
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/php_interface/init.php");

// выполняем
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
if ($action) {
    // возвращаемый код выполнения запроса:
    // 0: OK
    // 1: операция не выполнена...
    $err_code = 1;
    switch ($action) {
        case 'add_code_to_user':
            if ($USER->IsAuthorized()) {
                $code = isset($_REQUEST['code']) ? (int) $_REQUEST['code'] : '';
                if (is_int($code)) {
                    $film = new Film();
                    $film->addUserToCode($USER->GetID(), $code);  
                    $err_code = 0;
                }
            }
            echo $err_code;
        break;
    }
}
die();
