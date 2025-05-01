<?php

require_once 'vendor/tpl.php';
require_once 'Request.php';
require_once 'functions.php';

$request = new Request($_REQUEST);
$uri = $_SERVER['REQUEST_URI'];

$cmd = $request->param('cmd')
  ? $request->param('cmd')
  : '';

$lng = $request->param('lng')
  ? $request->param('lng')
  : '';

// Comment out when going live
// $pattern = '/(\w+)\/(\D+)$/';
// preg_match($pattern, $uri, $matches);
// if ($matches) {
//    $lng = $matches[1];
//    $cmd = $matches[2];
// } else {
//    preg_match('/(\w+)/', $uri, $lngMatch);
//    if ($lngMatch) {
//        $lng = $lngMatch[1];
//    }
// }

$data = array(
  'lng' => $lng,
  'languages' => getLanguages(),
  'menuCategories' => getMenuCategories($lng),
  'navigation' => "navigation.html"
);

$languageShortnames = array_map(function ($l) {
  return $l['short'];
}, $data['languages']);

if (!$data['menuCategories']) {
  $lng = 'et';
  $data['lng'] = $lng;
  $data['menuCategories'] = getMenuCategories($lng);
}

$menuShortnames = array_map(function ($m) {
  return $m['uri'];
}, $data['menuCategories']);

if (in_array($lng, $languageShortnames) && in_array($cmd, $menuShortnames)) {

  $menuItems = getMenu($lng, $cmd);
  $headline = $menuItems['heading'];
  $data['template'] = "menu.html";
  $data['menu'] = $menuItems['items'];
  $data['headline'] = $headline;
  $data['headingForTitle'] = "$headline | ";
} else if (in_array($lng, $languageShortnames)) {

  $data['template'] = "{$lng}/ordering.html";
  $data['headingForTitle'] = match ($lng) {
    'et' => 'Tellimine | ',
    'en' => 'Ordering | ',
    'ru' => 'Заказ | ',
    'fr' => 'Commande | ',
    default => '',
  };
} else {

  $data['template'] = "et/ordering.html";
  $data['headingForTitle'] = 'Tellimine | ';
}

print renderTemplate('templates/main.html', $data);
