<?php
  $data_scrapped = file_get_contents('https://en.wikipedia.org/wiki/Template:2019%E2%80%9320_Wuhan_coronavirus_data');
  $tmp_value = explode('coronavirus outbreak">Mainland China</a>', $data_scrapped);
  $tmp_value = $tmp_value[1];
  $tmp_value = explode('<tr style="text-align:center;" class="sortbottom">', $tmp_value)[0];
  $values = explode('</th>', $tmp_value);
  $values = implode($values);
  $values = explode('</a>', $tmp_value);
  $values = implode($values);
  $values = explode('<td>', $tmp_value);
  $values = implode($values);
  $values = explode('<td style="color:gray;">', $tmp_value);
  $values = implode($values);
  $values = explode('<td align="right">', $values);
  $values = implode($values);
  $values = explode('</td>', $values);

  // $countries_values = explode('title="2019–20 Wuhan coronavirus outbreak by country and territory">', $data_scrapped);
  // unset($rest_countries[0]);
  // $values = implode($values);
  // $values2 = explode('<td align="right" style="color:gray;">', $values);
?>
