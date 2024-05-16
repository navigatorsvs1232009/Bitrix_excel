<?php
echo '<pre>';
var_dump($arResult);
echo '</pre>';
//use PhpOffice\PhpSpreadsheet\Spreadsheet; // Импорт класса Spreadsheet из библиотеки PhpSpreadsheet
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx; // Импорт класса Xlsx из библиотеки PhpSpreadsheet
//$spreadSheet = new Spreadsheet(); // Создание нового объекта класса Spreadsheet
//$writer = new Xlsx($spreadSheet); // Создание нового объекта класса Xlsx с передачей объекта $spreadSheet в конструктор
//$activeSheet = $spreadSheet->getActiveSheet(); // Получение активного листа из объекта $spreadSheet
//
//$column = 'A'; // Инициализация переменной $column со значением 'A'
//foreach ($arResult['COLUMNS'] as $value) { // Цикл по элементам массива $arResult['COLUMNS']
//    $activeSheet->setCellValue($column.'1', $value['name']); // Установка значения ячейки с помощью метода setCellValue для текущего столбца и строки 1
//    $column++; // Инкрементация переменной $column для перехода к следующему столбцу
//}
//
//$row = 2; // Установка начального значения переменной $row равным 2 для начала заполнения строк со второй
//foreach ($arResult['LIST'] as $value) { // Цикл по элементам массива $arResult['LIST']
//    $column = 'A'; // Сброс переменной $column в начало столбца перед каждой строкой
//    foreach ($value['data'] as $itemText) { // Цикл по элементам массива $value['data']
//        $activeSheet->setCellValue($column.$row, $itemText); // Установка значения ячейки с помощью метода setCellValue для текущего столбца и строки $row
//        $column++; // Инкрементация переменной $column для перехода к следующему столбцу
//    }
//    $row++; // Инкрементация переменной $row для перехода к следующей строке
//}
//
//$APPLICATION->RestartBuffer(); // Сброс буфера вывода
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // Установка заголовка для типа контента
//$writer->save('php://output'); // Сохранение файла в формате Xlsx в поток вывода
//
//exit(); // Прерывание выполнения скрипта


