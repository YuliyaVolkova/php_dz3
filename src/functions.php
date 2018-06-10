<?php

// ucwords($str); // преобразует в верхний регистр первую букву строки
// strtoupper($str); // преобразует английские слова в строке в верхний регистр

//задание 1
function task1()
{
    $file = file_get_contents('data.xml');
    $xml = new SimpleXMLElement($file); //root

    $orderNumber = $xml->attributes()->PurchaseOrderNumber->__toString();
    $orderDate = $xml->attributes()->OrderDate->__toString();

    echo '<div class="order">';

    echo '<h3 class="order__title">Order № ', $orderNumber, '</h3>';
    echo '<div class="order__date"><span>order date: ', $orderDate, '</span></div>';

    foreach ($xml->Address as $address) {
        $addressType = $address['Type'];
        switch ($addressType) {
            case ('Shipping'):
                $shippingName = $address->Name->__toString();
                $shippingStreet = $address->Street->__toString();
                $shippingCity = $address->City->__toString();
                $shippingState = $address->State->__toString();
                $shippingZip = $address->Zip->__toString();
                $shippingCountry = $address->Country->__toString();
                break;
            case ('Billing'):
                $billingName = $address->Name->__toString();
                $billingStreet = $address->Street->__toString();
                $billingCity = $address->City->__toString();
                $billingState = $address->State->__toString();
                $billingZip = $address->Zip->__toString();
                $billingCountry = $address->Country->__toString();
                break;
            default:
                break;
        }
    }

    echo '<h5 class="order__shipping-info">Shipping to <strong>', $shippingName ,'</strong> address: ',
    $shippingStreet, ', ', $shippingCity, ', ', $shippingState, ', ', $shippingZip, ', ',
    $shippingCountry, '</h5>';

    echo '<div class="order__notes"> Delivery Notes: ', $xml->DeliveryNotes->__toString(), '</div>';

    echo '<table>';

    echo '<tr><th>Part Number</th><th>Product Name</th><th>Quantity</th>',
    '<th>US Price</th><th>Ship Date</th><th>Comment</th></tr>';

    foreach ($xml->Items->Item as $item) {
        $partNumber = $item['PartNumber'];
        $productName = $item->ProductName->__toString();
        $quantity = $item->Quantity->__toString();
        $price = $item->USPrice->__toString();
        $shipDate = $item->ShipDate->__toString()?$item->ShipDate->__toString():'--';
        $comment = $item->Comment->__toString()?$item->Comment->__toString():'--';
        echo '<tr><td>', $partNumber, '</td><td>', $productName, '</td><td>', $quantity, '</td><td>',
        $price, '</td><td>', $shipDate, '</td><td>', $comment, '</td></tr>';
    }
    
    echo '</table>';
    
    echo '<h6 class="order__billing-info">Billing info: ', $billingName ,', ',
    $billingStreet, ', ', $billingCity, ', ', $billingState, ', ', $billingZip, ', ',
    $billingCountry, '</h6>';

    echo '</div>';
}

//задание 2
function task2()
{
    $data = [
        "company" => "Coding Блог",
        "owner" => "Nic Крутой",
        "employees" => [
            [
                "firstname" => "Nic",
                "lastname" => "Крутой"
            ],
            [
                "firstname" => "Maria",
                "lastname" => "Canpos"
            ]
        ]
    ];

    $encoded = json_encode($data, JSON_UNESCAPED_UNICODE);
    file_put_contents('./output.json', $encoded);

    echo '<p>Файл "output.json" успешно записан</p>';

    $data =  file_get_contents('./output.json');
    $decoded = json_decode($data, true);
    $decoded2 = array_slice($decoded, 0);

    if(rand(0,1)) {
        $decoded2['company'] = mb_strtoupper($decoded2['company']);
    }

    $encoded2 = json_encode($decoded2, JSON_UNESCAPED_UNICODE);
    file_put_contents('./output2.json', $encoded2);

    echo '<p>Файл "output2.json" успешно записан</p>';

    $data2 = file_get_contents('./output2.json');
    $decoded2 = json_decode($data2, true);

    $diffs = array_diff_assoc($decoded, $decoded2);

    echo '<p>Инфо об отличаюшихся элементах в файлах "output.json" и "output2.json:</p>';
    print_r($diffs);
}

//задание 3
function task3()
{
    $csvfile = './numbers.csv';
    $arr = array();

    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 10; $j++) {
            $arr[$i][$j] = mt_rand(1, 100);
        }
    }

    $fp = fopen($csvfile, 'w');
    foreach ($arr as $field) {
        fputcsv($fp, $field, ';');
    }
    fclose($fp);

    echo '<p>Файл "numbers.csv" успешно записан</p>';

    $fp = fopen($csvfile, 'r');
    if ($fp) {
        $sumEven = 0;
        while(($csvData = fgetcsv($fp, 200, ';')) !== false) {
            for ($i = 0; $i < count($csvData); $i++) {
                if($csvData[$i] % 2 === 0) {
                    $sumEven += $csvData[$i];
                }
            }
        }
    }
    fclose($fp);
    echo '<p>Сумма четных чисел в файле = ', $sumEven, '</p>';
}
