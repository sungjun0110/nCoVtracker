<?php
  $dbhost = '';
  $dbname = '';
  $dbuser = '';
  $dbpass = '';

  $link = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
  mysqli_select_db($link, $dbname) or die("Could not open the db '$dbname'");

  $search_query = "SELECT `name` FROM `l37343129124732`.`world_case`;";
  $result_search = mysqli_query($link, $search_query);

  while($values = mysqli_fetch_array($result_search)) {
    $search[] = $values;
  }

  $q = $_REQUEST["q"];
