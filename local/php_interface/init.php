<?php

define('LOG_FILENAME', $_SERVER['DOCUMENT_ROOT'] . '/log.txt');

function dump($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function logVar($var)
{
    file_put_contents(__DIR__ . '/log.txt', print_r($var, true) . "\r\n\r\n", FILE_APPEND);
}

//Стили и скрипты подключаемые в админке
if (defined('ADMIN_SECTION') && ADMIN_SECTION === true) {
    $asset = \Bitrix\Main\Page\Asset::getInstance();
    $asset->addString('<link rel="stylesheet" href="/local/assets/custom_admin_styles.css">');
    $asset->addJs('/local/assets/custom_admin_scripts.js');
}


AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("AdminProductService", "OnAfterIBlockElementUpdateHandler"));

class AdminProductService
{
    // создаем обработчик события "OnAfterIBlockElementUpdate"
    public static function OnAfterIBlockElementUpdateHandler(&$arFields)
    {
        $promoProductProperty = 25;
        $isPromoProduct = $arFields["PROPERTY_VALUES"][$promoProductProperty][0]["VALUE"] == 18;
        $currentSection = $arFields["IBLOCK_SECTION"][0];
        //текущая секция и секция "Акционные товары"(16)
        $sectionsIds = [$currentSection, 16];
        $productId = $arFields["ID"];
        $iBlockID = $arFields["IBLOCK_ID"];

        // Если товар акционный, то добавляем его в 2 секции, в противном случае только в текущей оставляем
        if ($isPromoProduct) {
            CIBlockElement::SetElementSection($productId, $sectionsIds);
            \Bitrix\Iblock\PropertyIndex\Manager::updateElementIndex($iBlockID, $productId);
        } else {
            CIBlockElement::SetElementSection($productId, $currentSection);
            \Bitrix\Iblock\PropertyIndex\Manager::updateElementIndex($iBlockID, $productId);
        }
    }
}
