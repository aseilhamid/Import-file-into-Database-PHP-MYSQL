<?php
//Connection variables
$SERVER = "localhost";
$username = "root";
$PASSWORD = "";
$db = "work";

$error_msg = '';
$success_msg = '';
$result;
$number_of_pages = 1;

//Connection
$conn = new mysqli($SERVER, $username,$PASSWORD);

//create db
$sql = "CREATE DATABASE " .$db;
$conn->query($sql);

//New connection with the created db = "work"
$conn = new mysqli($SERVER, $username, $PASSWORD, $db);

// Create table in the database
if (isset($_POST['creatdb'])) {

  $sql = "CREATE TABLE data (
    ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    client_id INT(3) NOT NULL,
    client VARCHAR(30) NOT NULL,
    deal_id INT(3) NOT NULL,
    deal VARCHAR(30) NOT NULL,
    hour DATETIME(6),
    accepted INT(3) NOT NULL,
    refused INT(3) NOT NULL
    )";

  if ($conn->query($sql) == true) {
    $success_msg = "DB & Table created successfully";
  } else {
    $error_msg = '<label class="text-danger">Already Exist</label>' . $conn->connect_error;
  }
}

//Upload .csv file into database 
if (isset($_POST["import"])) {

  //Check if file .csv extention
  if ($_FILES['file']['name']) {
    $filexe = explode(".", $_FILES['file']['name']);    
    if (end($filexe) == "csv") {
      $filename = $_FILES['file']['name'];

      //change [#,@] to [,] delimiter
      move_uploaded_file($_FILES['file']['tmp_name'], $filename);
      $updatefile = file_get_contents($filename);
      $updatefile = str_replace(str_split('#@'), ",", $updatefile);
      file_put_contents($filename, $updatefile);

      //insert file data into database
      $handle = fopen($filename, "r");
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $sql = "INSERT INTO data(client_id, client, deal_id, deal, hour, accepted, refused)
          VALUES ('$data[1]', '$data[0]', '$data[3]', '$data[2]', '$data[4]', '$data[5]', '$data[6]')";
        $conn->query($sql);
      }
      fclose($handle);
      header("location: index.php?create=1");
    } else { 
      //File not .csv
      $error_msg = 'Please Select .CSV File only';
    }
  }else {
    //No file selected
    $error_msg = 'Please Select File';
  }
}

//Drop database & table
if (isset($_POST['reset'])) {
  $sql = "DROP DATABASE work";
  $conn->query($sql);
  $result = 0;
  $number_of_pages=0;
  $success_msg = "Database Droped";
  header("location:index.php");
  $conn->close();
}



if(!isset($_POST['reset'])){
   //define total number of results you want per page  
 $results_per_page = 50;  

 //find the total number of results stored in the database  
 $sql = "SELECT * FROM data";  
 $result = $conn->query($sql);  
 if($result){
  $number_of_result = $result->num_rows;

  //no of pages
  $number_of_pages = ceil($number_of_result / $results_per_page);

  if(!isset($_GET['page'])){
      $page = 1;
  }else{
      $page = $_GET['page'];
  }

  $offset = ($page - 1) * $results_per_page;

  $sql = "SELECT * FROM data LIMIT " . $offset . ',' . $results_per_page;
  $result = $conn->query($sql);
  }
}
