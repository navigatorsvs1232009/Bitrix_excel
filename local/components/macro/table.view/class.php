<?php

use Bitrix\Iblock;
use Bitrix\Main\Loader;
use Bitrix\Main;
use \Models\ClientTable;//свой класс

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Engine\Contract\Controllerable;

class OtusTableComponent extends CBitrixComponent implements Controllerable
{
    private function _checkModules()
    {
        if (!Loader::includeModule("iblock") || !Loader::includeModule("crm")) { // Проверка загрузки модулей "iblock" и "crm"
            throw new \Exception('Не загружены модули необходимые для работы компонента'); // Выброс исключения, если модули не загружены
        }
        return true; // Возврат true, если модули успешно загружены
    }

    public function configureActions()
    {
        return [
            'getCount' => [ // Определение действия getCount
                'prefilters' => [], // Установка пустого массива prefilters
            ],
        ];
    }
//два метода: _checkModules, который проверяет загрузку модулей "iblock"
// и "crm", и configureActions, который настраивает доступные действия для компонента.
    public function getCountAction()
    {
        return ['result' => ClientTable::getCount()];//свой класс
    }
//Этот метод getCountAction возвращает результат вызова статического метода getCount() из класса ClientTable.
// Результатом будет массив с ключом 'result', содержащий количество записей, возвращенных методом getCount().
    public function onPrepareComponentParams($arParams)
    {
        if (isset($arParams['SHOW_CHECKBOXES']) && $arParams['SHOW_CHECKBOXES'] === 'Y') { // Проверка наличия параметра SHOW_CHECKBOXES и его значения 'Y'
            $arParams['SHOW_CHECKBOXES'] = true; // Установка значения параметра SHOW_CHECKBOXES в true, если равно 'Y'
        } else {
            $arParams['SHOW_CHECKBOXES'] = false; // Установка значения параметра SHOW_CHECKBOXES в false, если отсутствует или не равно 'Y'
        }
        return $arParams; // Возврат обновленного массива параметров
    }
//Этот метод onPrepareComponentParams проверяет значение параметра SHOW_CHECKBOXES и устанавливает его в true, если оно равно 'Y',
// иначе устанавливает в false. Обновленный массив параметров возвращается для дальнейшего использования в компоненте.

    public function executeComponent()
    {
        $this->_checkModules(); // Проверка загруженных модулей
        $this->setColumn(); // Установка колонок
        $this->_request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest(); // Получение объекта запроса

        if (isset($this->_request['report_list'])) { // Проверка наличия параметра 'report_list' в запросе
            $page = explode('page', $this->_request['report_list']); // Разделение параметра 'report_list' по строке 'page'
            $page = $page[1]; // Получение номера страницы из параметра 'report_list'
        } else {
            $page = 1; // Установка страницы по умолчанию, если параметр 'report_list' отсутствует
        }

        $limit = 20; // Установка лимита записей на странице

        $this->setList($page); // Установка списка данных для текущей страницы

        if ($this->_request['template'] === 'excel') { // Проверка, если запрос для экспорта в Excel
            $this->proceedExcel(); // Обработка экспорта в Excel
        }

        $this->arResult['COUNT'] = ClientTable::getCount(); // Получение общего количества записей
        $this->includeComponentTemplate(); // Подключение шаблона компонента
    }
//Этот метод executeComponent выполняет основную логику компонента: проверяет модули, устанавливает колонки,
// обрабатывает запросы для страниц и экспорта в Excel, получает общее количество записей,
// и подключает шаблон компонента для отображения данных.


    public function setColumn()
    {
        $fieldmap = ClientTable::getMap(); // Получение маппинга полей из класса ClientTable
        foreach ($fieldmap as $field) {
            $this->arResult['COLUMNS'][] = [
                'id' => $field->getName(), // Установка ID столбца как имя поля
                'name' => $field->getTitle(), // Установка имени столбца как заголовка поля
            ];
        }
    }
//Этот метод setColumn используется для создания структуры колонок таблицы на основе маппинга полей из класса ClientTable.
// Каждая колонка представлена массивом с ключами 'id' и 'name', где 'id' - это имя поля, а 'name' - его заголовок.

    private function setList($page = 1, $limit = 20)
    {
        $data = ClientTable::getList([ // Получение списка данных из класса ClientTable
            'order' => ['ID' => 'DESC'], // Сортировка по ID в порядке убывания
            'limit' => $limit, // Ограничение количества записей
            'offset' => $limit * ($page - 1), // Смещение для пагинации
        ]);

        while ($row = $data->fetch()) {
            $this->arResult['LIST'][] = [
                'data' => $row, // Добавление данных каждой строки в массив LIST
            ];
        }
    }
//Этот метод setList используется для получения данных из класса ClientTable, с сортировкой по ID в порядке убывания,
// установкой лимита записей и смещения для пагинации. Каждая строка данных добавляется в массив LIST
// для последующего отображения в компоненте.
    private function proceedExcel()
    {
        $this->setTemplateName("excel"); // Установка шаблона "excel"
        $this->includeComponentTemplate(); // Подключение шаблона компонента
    }
//Этот метод proceedExcel используется для обработки запроса экспорта в Excel.
// Он устанавливает шаблон "excel" и подключает соответствующий шаблон компонента для экспорта данных в Excel.

}