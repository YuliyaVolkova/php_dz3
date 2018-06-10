<?php

//задание 1
function task1()
{
    $file = 'data.xml';
    $xml = new SimpleXMLElement(file_get_contents($file));
    // Собираем данные
    $orderNumber = $xml->attributes()->PurchaseOrderNumber->__toString();
    $orderDate = $xml->attributes()->OrderDate->__toString();
    $deliveryNotes = $xml->DeliveryNotes->__toString();
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
    $count = 0;
    foreach ($xml->Items->Item as $item) {
        $partNumber[$count] = $item['PartNumber'];
        $productName[$count] = $item->ProductName->__toString();
        $quantity[$count] = $item->Quantity->__toString();
        $price[$count] = $item->USPrice->__toString();
        $shipDate[$count] = $item->ShipDate->__toString() ? $item->ShipDate->__toString() : '--';
        $comment[$count++] = $item->Comment->__toString() ? $item->Comment->__toString() : '--';
    }
    // Готовим к выводу
    $shippingAddress = $shippingStreet . ', ' . $shippingCity . ', ' . $shippingState . ', ' . $shippingZip . ', ' . $shippingCountry;
    $billingAddress = $billingStreet . ', ' . $billingCity . ', ' . $billingState . ', ' . $billingZip . ', ' . $billingCountry;
    $tableRows = '';
    for ($i = 0; $i < $count; $i++) {
        $tableRows .=  '<tr>
                            <td>' . $partNumber[$i] . '</td>
                            <td>' . $productName[$i] . '</td>
                            <td>' . $quantity[$i] . '</td>
                            <td>' . $price[$i] . '</td>
                            <td>' . $shipDate[$i] . '</td>
                            <td>' . $comment[$i] . '</td>
                        </tr>';
    }
    $order = '<div class="order">
                <h3 class="order__title">Order № ' . $orderNumber . '</h3>
                <div class="order__date"><span>order date: ' . $orderDate . '</span></div>
                <h5 class="order__shipping-info">Shipping to <strong>' . $shippingName . '</strong>
                 , address: ' . $shippingAddress . '</h5>
                <div class="order__notes"> Delivery Notes:  ' . $deliveryNotes . '</div>
                <table>
                    <tr>
                        <th>Part Number</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>US Price</th>
                        <th>Ship Date</th>
                        <th>Comment</th>
                     </tr>
                     ' .$tableRows. '
                </table>
                <h6 class="order__billing-info">Billing info: ' . $billingName . ', address: ' . $billingAddress . '</h6>  
             </div>';
    // Выводим данные
    echo $order;
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
    $file1 = './output.json';
    $file2 = './output2.json';

    file_put_contents($file1, json_encode($data, JSON_UNESCAPED_UNICODE));

    echo '<p>Файл "output.json" успешно записан</p>';

    $decoded = json_decode(file_get_contents($file1), true);

    $decoded2 = array_slice($decoded, 0);
    $decoded2['company'] = (rand(0, 1)) ? mb_strtoupper($decoded2['company']) : $decoded2['company'];

    file_put_contents($file2, json_encode($decoded2, JSON_UNESCAPED_UNICODE));

    echo '<p>Файл "output2.json" успешно записан</p>';

    $decoded2 = json_decode(file_get_contents($file2), true);

    $diffs = array_diff_assoc($decoded, $decoded2);

    echo '<p>Инфо об отличаюшихся элементах в файлах "output.json" и "output2.json:</p>';
    print_r($diffs);
}

//задание 3
function task3()
{
    $csvfile = './numbers.csv';

    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 10; $j++) {
            $arr[$i][$j] = mt_rand(1, 100);
        }
    }

    $fp = fopen($csvfile, 'w');
    if(!$fp) {
        return;
    }

    foreach ($arr as $field) {
        fputcsv($fp, $field, ';');
    }
    fclose($fp);

    echo '<p>Файл "numbers.csv" успешно записан</p>';

    $fp = fopen($csvfile, 'r');
    if (!$fp) {
        return;
    }
    $sumEven = 0;
    while(($csvData = fgetcsv($fp, 100, ';')) !== false) {
        for ($i = 0; $i < count($csvData); $i++) {
            $sumEven += ($csvData[$i] % 2 === 0) ? $csvData[$i] : 0;
        }
    }
    fclose($fp);
    echo '<p>Сумма четных чисел в файле = ', $sumEven, '</p>';
}

//задание 4
function task4()
{
    $url = 'https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revision
s&rvprop=content&format=json';
    $decoded = json_decode(file_get_contents($url), true);
    $pageId = $decoded['query']['pages']['15580374']['pageid'];
    $pageTitle = $decoded['query']['pages']['15580374']['title'];
    $result = '<p>Данные с: ' . $url . '<br>title: ' . $pageTitle . '; page_id: ' . $pageId . ';</p>';
    echo $result;
}
