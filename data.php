<?php
  # Fill our vars and run on cli
  # $ php -f db-connect-test.php
  $dbhost = 'HOST';
  $dbname = 'NAME';
  $dbuser = 'USER';
  $dbpass = 'PASSWORD';
  $data = array();
  $data_CA = array();

  $link = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
  mysqli_select_db($link, $dbname) or die("Could not open the db '$dbname'");

  $US_query = "SELECT * FROM infected_cases";
  $result_US = mysqli_query($link, $US_query);

  $CA_query = "SELECT * FROM infected_cases_canada";
  $result_CA = mysqli_query($link, $CA_query);

  while($values = mysqli_fetch_array($result_US)) {
    $data[] = $values;
  }

  while($values = mysqli_fetch_array($result_CA)) {
    $data_CA [] = $values;
  }

  // for debugging 
  // $js_array=json_encode($data);
  // echo $js_array;
  mysqli_close($link);
?>
