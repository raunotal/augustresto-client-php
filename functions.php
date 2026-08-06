<?php

require_once 'MenuItem.php';
require_once 'constants.php';

function getMenu($language, $menuPart): array
{
    $result = getResponseResult("menu?lng=$language&cat=$menuPart");
    if (!is_array($result) || !isset($result['title'], $result['items']) || !is_array($result['items'])) {
        return ['heading' => '', 'items' => []];
    }

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

function getLanguages(): array
{
    $result = getResponseResult("active-languages");
    return isListOfAssocArrays($result, ['short', 'long']) ? $result : defaultLanguages();
}

function getMenuCategories($language): array
{
    $result = getResponseResult("categories?lng=$language");
    return isListOfAssocArrays($result, ['name', 'uri']) ? $result : [];
}

function defaultLanguages(): array
{
    return [
        ['short' => 'et', 'long' => 'Eesti'],
        ['short' => 'en', 'long' => 'English'],
        ['short' => 'ru', 'long' => 'Русский'],
        ['short' => 'fr', 'long' => 'Français'],
    ];
}

function isListOfAssocArrays($value, array $requiredKeys): bool
{
    if (!is_array($value) || $value === []) {
        return false;
    }

    foreach ($value as $item) {
        if (!is_array($item)) {
            return false;
        }
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $item)) {
                return false;
            }
        }
    }

    return true;
}

function getResponseResult($endpoint)
{
    $baseUrl = BASE_URL;
    $client = curl_init("$baseUrl/$endpoint");
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($client);

    if ($response === false) {
        return null;
    }

    $result = json_decode($response, true);
    if (!is_array($result)) {
        return null;
    }

    if (isset($result['code'])) {
        return null;
    }

    return $result;
}