<?php


require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

function seo($str, $options = array())
{
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => true
    );
    $options = array_merge($defaults, $options);
    $char_map = array(
        '-' => "º",
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',
        // Latin symbols
        '©' => '(c)',
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',
        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$xml = simplexml_load_file(__DIR__ . '/products.xml');

$line = 1;

$first_column_values = 'Handle	Title	Body (HTML)	Vendor	Product Category	Type	Tags	Published	Option1 Name	Option1 Value	Option2 Name	Option2 Value	Option3 Name	Option3 Value	Variant SKU	Variant Grams	Variant Inventory Tracker	Variant Inventory Qty	Variant Inventory Policy	Variant Fulfillment Service	Variant Requires Shipping	Variant Taxable	Variant Barcode	Variant Price	Variant Weight Unit	Image Src	Image Position	Status';

$first_column_values = explode("\t", $first_column_values);

foreach ($first_column_values as $key => $value) {
    $sheet->setCellValueByColumnAndRow(($key + 1), $line, $value);
}

$line++;

foreach ($xml->product as $product_) {

    $title = $product_->name->__toString();
    $images = $product_->images->__toString();
    $images = explode(',', $images);
    $description = "";
    $handle = explode('/', $product_->url->__toString());
    $handle = $handle[count($handle) - 1];
    $handle = str_replace('.html', '', $handle);
    $qty = $product_->quantity->__toString();
    $sku = $product_->reference->__toString();
    $barcode = $product_->ean13->__toString();
    $barcode = $product_->ean13->__toString();
    $weight = $product_->weight->__toString();
    $weight = floatval($weight) * 1000;

    $kelvins = [];

    if (isset($product_->features->feature)){
        foreach ($product_->features->feature as $feature) {
            $value = $feature->__toString();
            if (strstr($value, 'Kelvin')) {
                $kelvin = explode(':', $value);
                $kelvin = $kelvin[1];
                $kelvins = explode('//', $kelvin);
            }
        }
    }

    $kelvins = array_map('trim', $kelvins);

    if ($qty < 0) {
        $qty = 0;
    }

    # set price
    $price = $product_->price->__toString();
    # round to higher

    if (strstr($price, '.')) {
        $price = explode('.', $price);
        $price = $price[0] . ',99';
    }

    $kelvin_key = 0;

    if (isset($product_->combinations->combination)) {
        foreach ($product_->combinations->combination as $combination) {

            $name = $combination->attribute->__toString();
            $name = explode(':', $name);
            $name = $name[0];

            $value = $combination->value->__toString();
            $value = explode(':', $value);
            $value = $value[0];

            # add to description
            $description .= $name . ': ' . $value . '<br>';

        }
    }

    if (isset($product_->features->feature)) {
        foreach ($product_->features->feature as $feature) {
            $description .= $feature->__toString() . "<br>";
        }
    }


    $category = $product_->category_names->__toString();

    $category = str_replace(',', ' > ', $category);

    $category = "";

    $sheet->setCellValueByColumnAndRow(1, $line, $handle);
    $sheet->setCellValueByColumnAndRow(2, $line, $title);
    $sheet->setCellValueByColumnAndRow(3, $line, $description);
    $sheet->setCellValueByColumnAndRow(4, $line, "Lifestyle Gerber");
    $sheet->setCellValueByColumnAndRow(5, $line, $category);
    $sheet->setCellValueByColumnAndRow(6, $line, $category);


    $sheet->setCellValueByColumnAndRow(15, $line, $sku);
    $sheet->setCellValueByColumnAndRow(16, $line, $weight);

    $sheet->setCellValueByColumnAndRow(17, $line, "shopify");

    $sheet->setCellValueByColumnAndRow(18, $line, $qty);


    # set Inventory Policy for S column
    $sheet->setCellValueByColumnAndRow(19, $line, 'deny');

    # set inventory fullfillment service for T column
    $sheet->setCellValueByColumnAndRow(20, $line, 'manual');
    $sheet->setCellValueByColumnAndRow(21, $line, 'true');
    $sheet->setCellValueByColumnAndRow(22, $line, 'false');
    $sheet->setCellValueByColumnAndRow(23, $line, $barcode);

    # set price
    $sheet->setCellValueByColumnAndRow(24, $line, $price);


    # set price
    $sheet->setCellValueByColumnAndRow(25, $line, "kg");

    # set status active
    $sheet->setCellValueByColumnAndRow(count($first_column_values), $line, 'draft');

    # set images
    $image_column = count($first_column_values) - 2;
    $image_position = 1;

    if (isset($product_->combinations->combination)) {

        if (count($product_->combinations->combination) > 0) {

            foreach ($product_->combinations->combination as $combination) {
                $name = $combination->attribute->__toString();
                $name = explode(':', $name);
                $name = $name[0];

                $value = $combination->value->__toString();
                $value = explode(':', $value);
                $value = $value[0];

                if(isset($kelvins[$kelvin_key])){
                    $value = $kelvins[$kelvin_key] .  'K - ' .$value;
                    $kelvin_key++;
                }

                # detect and convert to utf 8
                $value = mb_convert_encoding($value, mb_detect_encoding($value), 'UTF-8');



                $sheet->setCellValueByColumnAndRow(1, $line, $handle);

                $sheet->setCellValueByColumnAndRow(9, $line, $name);
                $sheet->setCellValueByColumnAndRow(10, $line, $value);


                $sheet->setCellValueByColumnAndRow(15, $line, $combination->reference->__toString());
                $sheet->setCellValueByColumnAndRow(16, $line, $weight);

                $sheet->setCellValueByColumnAndRow(17, $line, "shopify");

                $sheet->setCellValueByColumnAndRow(18, $line, $combination->quantity->__toString());


                # set Inventory Policy for S column
                $sheet->setCellValueByColumnAndRow(19, $line, 'deny');

                # set inventory fullfillment service for T column
                $sheet->setCellValueByColumnAndRow(20, $line, 'manual');
                $sheet->setCellValueByColumnAndRow(21, $line, 'true');
                $sheet->setCellValueByColumnAndRow(22, $line, 'false');
                $sheet->setCellValueByColumnAndRow(23, $line, $barcode);

                # set price
                $sheet->setCellValueByColumnAndRow(24, $line, $price);


                # set price
                $sheet->setCellValueByColumnAndRow(25, $line, "kg");


                if (count($images) > 0) {
                    $image = $images[0];
                    $sheet->setCellValueByColumnAndRow($image_column, $line, $image);
                    #position
                    $sheet->setCellValueByColumnAndRow($image_column + 1, $line, $image_position);
                    $image_position++;
                    $images = array_values($images);
                }


                $line++;
            }
        }

    }

    # add new line for each image
    foreach ($images as $image) {
        if ($image != ""){
            $sheet->setCellValueByColumnAndRow(1, $line, $handle);
            $sheet->setCellValueByColumnAndRow($image_column, $line, $image);
            #position
            $sheet->setCellValueByColumnAndRow($image_column + 1, $line, $image_position);
            $line++;
            $image_position++;
        }

    }

//    if (count($product_->combinations->combination) > 1) {
//        break;
//    }

}


$writer = new Csv($spreadsheet);
$writer->save(__DIR__ . '/export.csv');
