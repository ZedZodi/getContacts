<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php"); // Подключение ядра Bitrix24
require 'vendor/autoload.php';

use Bitrix\Crm\ContactTable;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$order = ['ID' => 'ASC'];
$filter = [];
$select = ['ID', 'NAME', 'LAST_NAME', 'EMAIL'];

$contacts = ContactTable::getList([
    'order' => $order,
    'filter' => $filter,
    'select' => $select,
])->fetchAll();

// Export to CSV
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    $filename = 'contacts.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');

    if (!empty($contacts)) {
        fputcsv($output, array_keys($contacts[0]));
    }

    foreach ($contacts as $contact) {
        fputcsv($output, $contact);
    }

    fclose($output);
    exit;
}

// Export to XLSX
if (isset($_GET['export']) && $_GET['export'] === 'xlsx') {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    if (!empty($contacts)) {
        $headers = array_keys($contacts[0]);
        $sheet->fromArray($headers, null, 'A1');
    }

    $row = 2;
    foreach ($contacts as $contact) {
        $sheet->fromArray($contact, null, 'A' . $row);
        $row++;
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'contacts.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $writer->save('php://output');
    exit;
}