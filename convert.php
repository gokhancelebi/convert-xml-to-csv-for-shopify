<?php

include __DIR__ . '/vendor/autoload.php';
include  __DIR__ . '/lib.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;


$xml_content = file_get_contents($_FILES['xml_file']['tmp_name']);
$xml_content = simplexml_load_string($xml_content);


if (!file_exists(__DIR__ . '/files')){
    mkdir(__DIR__ . '/files');
}

# delete old files first

foreach (glob(__DIR__ . '/files/*') as $file){
    unlink($file);
}

# create excel file with

$i = 0;
$a = 0;

$files = [];


$column_index = 1;

$shopify_product_csv_lines = [];

$csv_column_names = "Handle,Title,Body (HTML),Vendor,Standardized Product Type,Custom Product Type,Tags,Published,Option1 Name,Option1 Value,Option2 Name,Option2 Value,Option3 Name,Option3 Value,Variant SKU,Variant Grams,Variant Inventory Tracker,Variant Inventory Qty,Variant Inventory Policy,Variant Fulfillment Service,Variant Price,Variant Compare At Price,Variant Requires Shipping,Variant Taxable,Variant Barcode,Image Src,Image Position,Image Alt Text,Gift Card,SEO Title,SEO Description,Google Shopping / Google Product Category,Status";

$spreadsheet = null;
$sheet = null;

foreach ($xml_content->produkt as $item) {

    if ( $i == 0 ){


        $shopify_product_csv_lines = [];


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $column_index = 1;

        foreach (explode(',', $csv_column_names) as $column_name) {
            $sheet->setCellValueByColumnAndRow($column_index, 1, $column_name);
            $column_index++;
        }

    }

    $title = $item->nazwy->nazwa->__toString();
    $sku = xml_attribute($item,'id');

    $options = [];

    $images = [];


    $category = $item->kategoria_tree->__toString();
    $sub_category = $item->kategoria->__toString();
    $quantity = $item->dostepnosc->__toString();
    $price = xml_attribute($item->cena->cena_netto,'wartosc');
    $description = $item->opisy->opis->__toString();
    $manufacturer = $item->producent->__toString();


    $handle = sef($title);
    $handle = seo_($title);

    $category = "";
    $sub_category = "";

    $shopify_product_csv_line = [
        $handle,
        $title,
        $description,
        $manufacturer,
        $category,
        $sub_category,
        '', // tags
        'TRUE', // published
        '', // option1 name
        '', // option1 value
        '', // option2 name
        '', // option2 value
        '', // option3 name
        '', // option3 value
        '', // variant sku
        '', // variant grams
        '', // variant inventory tracker
        $quantity, // variant inventory qty
        'deny', // variant inventory policy
        'manual', // variant fulfillment service
        $price, // variant price
        '', // variant compare at price
        'FALSE', // variant requires shipping
        'TRUE', // variant taxable
        '', // variant barcode
        '', // image src
        '', // image position
        '', // image alt text
        'FALSE', // gift card
        '', // seo title
        '', // seo description
        '', // google shopping / google product category
        'ACTIVE'
    ];

    $shopify_product_csv_lines[] = $shopify_product_csv_line;

    # create new lines with the same handle and add variants


    $id = 1;

    foreach ($item->zdjecia->zdjecie as $key => $image) {
        $image = xml_attribute($image,'url');
        $shopify_product_csv_line = [
            $handle,
            '',
            '',
            '',
            '',
            '',
            '', // tags
            '', // published
            '', // option1 name
            '', // option1 value
            '', // option2 name
            '', // option2 value
            '', // option3 name
            '', // option3 value
            '', // variant sku
            '', // variant grams
            '', // variant inventory tracker
            '', // variant inventory qty
            '', // variant inventory policy
            '', // variant fulfillment service
            '', // variant price
            '', // variant compare at price
            '', // variant requires shipping
            '', // variant taxable
            '', // variant barcode
            $image . '?format=.jpg', // image src
            $id++ , // image position
            '', // image alt text
            '', // gift card
            '', // seo title
            '', // seo description
            '', // google shopping / google product category,
            ''
        ];

        $shopify_product_csv_lines[] = $shopify_product_csv_line;
    }


    $i++;
    $a++;

    if ($i == 5000 || ($a + 1) == count($xml_content)){


        $row_index = 2;

        foreach ($shopify_product_csv_lines as $line){

            $column_index = 1;

            foreach ($line as $cell) {
                $sheet->setCellValueByColumnAndRow($column_index, $row_index, $cell);
                $column_index++;
            }

            $row_index++;

        }


        $name = time();
        $files[] = $name;

        $writer = new Csv($spreadsheet);
        $writer->save(__DIR__ . '/files/'.$name.'.csv');

        echo '<br><a href="download.php?file='.$name.'" download=""><b>Download File ('.$name.')</b></a>';

        $i = 0;

    }

}




?>



