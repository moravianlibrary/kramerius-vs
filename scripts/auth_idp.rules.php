#!/bin/php
<?php
$file = $argv[1];

$content = file_get_contents('wayf-filter.txt');
$filter = json_decode(base64_decode($content));
$result = array();
foreach ($filter->{'allowFeeds'} as $group => $idps) {
  foreach ($idps->{'allowIdPs'} as $idp) {
    $result[] = $idp;
  }
}
foreach (array_slice($argv, 2) as $idp) {
  $result[] = $idp;
}
foreach ($result as $idp) {
  $escapedIdp = preg_quote($idp);
  echo "SetEnvIf Shib-Identity-Provider $escapedIdp authorized_by_idp=true\n";
}

