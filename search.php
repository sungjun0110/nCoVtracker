<?php
  $dbhost = '';
  $dbname = '';
  $dbuser = '';
  $dbpass = '';

  $link = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
  mysqli_select_db($link, $dbname) or die("Could not open the db '$dbname'");

  $search_query = "SELECT `name`,`confirmed` FROM `l37343129124732`.`world_case`;";
  $result_search = mysqli_query($link, $search_query);

  while($values = mysqli_fetch_array($result_search)) {
    $search[] = $values;
  }

  $q = $_REQUEST["q"];

  $hint = "";

  $n = 0;
  if ($q !== "") {
    $q = strtolower($q);
    $len = strlen($q);
    foreach($search as $value) {
      $name = $value[0];
      $confiremd = $value[1];
      if (stristr($q, substr($name, 0, $len)) && ($n < 7) && ($confiremd > 0)) {
        if($hint === "") {
          $hint = "<tr><td>" . "$name" . "</td></tr>";
        }
        else{
          $hint .= "<tr><td>". "$name" . "</td></tr>";
        }
        $n++;
      }
    }
  }

  echo $hint=== "" ? "" : $hint;
