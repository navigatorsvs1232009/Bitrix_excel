<?php
\Bitrix\Main\UI\Extension::load("ui.buttons");
?>

<?php

$grid_options = new Bitrix\Main\Grid\Options('report_list'); // Создание объекта класса Options для работы с опциями таблицы с идентификатором 'report_list'
$nav_params = $grid_options->GetNavParams(); // Получение параметров навигации из объекта $grid_options
$nav = new Bitrix\Main\UI\PageNavigation('report_list'); // Создание объекта класса PageNavigation для постраничной навигации с идентификатором 'report_list'
$nav->allowAllRecords(false) // Ограничение количества записей на странице
->setPageSize($nav_params['nPageSize']) // Установка количества записей на странице из полученных параметров
->initFromUri(); // Инициализация объекта навигации из URI

$nav->setRecordCount($arResult['COUNT']); // Установка общего количества записей для навигации из данных $arResult

$APPLICATION->IncludeComponent( // Включение компонента Bitrix
    'bitrix:main.ui.grid', // Тип компонента для отображения таблицы
    '', // Шаблон компонента (пустой в данном случае)
    array( // Параметры компонента
        'GRID_ID' => 'MY_GRID_ID', // Идентификатор таблицы
        'COLUMNS' => $arResult['COLUMNS'], // Колонки таблицы из данных $arResult
        'ROWS' => $arResult['LIST'], // Строки таблицы из данных $arResult
        'NAV_OBJECT' => $nav, // Объект навигации для постраничной навигации
        'AJAX_MODE' => 'Y', // Включение режима AJAX
        'AJAX_OPTION_JUMP' => 'N', // Отключение прокрутки к началу при AJAX
        'AJAX_OPTION_HISTORY' => 'N', // Отключение работы с историей браузера при AJAX
        'SHOW_ROW_CHECKBOXES' => $arParams['SHOW_CHECKBOXES'], // Показ флажков для строк в зависимости от параметров
    )
);



?>
