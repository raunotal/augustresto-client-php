<?php

require_once 'MenuItem.php';
require_once 'constants.php';

function getMenu($language, $menuPart): array
{
    $result = getResponseResult("menu?lng=$language&cat=$menuPart");
    $menuItems = array(
        'heading' => $result['title'],
        'items' => []
    );

    foreach ($result['items'] as $row) {
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
        $menuItems['items'][] = new MenuItem($name, $description, $price);
    }

    return $menuItems;
}

function getLanguages() {
    return getResponseResult("active-languages");
}

function getMenuCategories($language) {
    return getResponseResult("categories?lng=$language");
}

function getResponseResult($endpoint) {
    $baseUrl = BASE_URL;
    $client = curl_init("$baseUrl/$endpoint");
    curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
    $response = curl_exec($client);
    return json_decode($response, true);
}