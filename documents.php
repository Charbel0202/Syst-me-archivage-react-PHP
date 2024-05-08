<?php
include('connect.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$iduser = $_GET['id'];
$req = "SELECT * FROM documents where id = '$iduser'";
$result = $bdd->query($req);

if ($result->num_rows > 0) {
  $data = array();

  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }

  echo json_encode($data);
} else {
  echo json_encode(array());
}

$bdd->close();
?>
