<?php
  $dbhost = '';
  $dbname = '';
  $dbuser = '';
  $dbpass = '';
  $chartData = array();

  $link = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
  mysqli_select_db($link, $dbname) or die("Could not open the db '$dbname'");

  if (isset($_POST['a'])) {
    $chartData_query = "SELECT * FROM `" . $_POST['a'] . "`" . "ORDER BY `Date` Desc;";
    $result_chartData= mysqli_query($link, $chartData_query);
    while($value = mysqli_fetch_array($result_chartData)) {
      $chartData[] = $value;
    }
    echo json_encode($chartData, true);
  }
  else{
    echo "failed";
  }

  mysqli_close($link);
?>
