<?php
$html = file_get_contents('http://finance.detik.com/'); //get the html returned from the following url

$detik_doc = new DOMDocument();
libxml_use_internal_errors(TRUE); //disable libxml errors

$detik_doc ->loadHTML($html);

$detik_xpath = new DOMXPath($detik_doc);

$row_title = $detik_xpath -> query('//div[@id="box-pop"]//div[@class="title_lnf"]');
$row_link = $detik_xpath -> query('//div[@id="box-pop"]/ul[@class="list_fokus list_fokus_add"]/li/article/a');

$json_result = array();

if ($row_title->length >0) {
  for ($i = 0; $i < $row_title->length; $i++) {
    $obj = (object) [
      'nama' => trim($row_title[$i]->nodeValue),
      'link' => $row_link[$i]->getAttribute("href")
    ];
    $json_result[] = $obj;
  }
}

$final_result = (object)[
  'data' => $json_result
];

echo json_encode($final_result);

?>
