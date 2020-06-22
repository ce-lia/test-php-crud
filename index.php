<?php
  require 'vendor/autoload.php';

  $mng = new MongoDB\Client("mongodb://localhost:27017");
  $database = $mng->test;
  $collection = $database->selectCollection('users');


  if($_POST){
    $insert = array(
      'first_name' => $_POST['first_name'],
      'last_name' => $_POST['last_name'],
      'favorite_cat' => $_POST['favorite_cat']
    );

    if (isset($_POST['mid'])){
      $id = array('_id' => new MongoDB\BSON\ObjectID($_POST["mid"]));
      $collection->updateOne($id, ['$set' => $insert]);
    } else {
      $collection->insertOne($insert);
    }
  }

  if(isset($_GET['did'])){
    $id = array('_id' => new MongoDB\BSON\ObjectID($_GET["did"]));
    $collection->deleteOne($id);
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>All entries</title>
</head>

  <body>
    <h1>Add data in Database</h1>
    <form action="index.php" method="post">
      <input type="text" name="first_name" value="First name">
      <input type="text" name="last_name" value="Last name">
      <input type="text" name="favorite_cat" value="Favorite cat">
      <button type="submit" name="button">Save</button>
    </form>
    </br>

  <?php
    $cursor = $collection->find();
    foreach ( $cursor as $document)
    {
        echo 'Name: '.$document["first_name"]."<br />";
        echo 'Last name: '.$document["last_name"]."<br />";
        echo 'Favorite cat: '.$document["favorite_cat"]."<br />";
        echo '<a href="show.php?mid='.$document['_id'].'">Show</a><br />';
        echo '<a href="index.php?did='.$document['_id'].'">Delete</a><br /><br />';
    }
  ?>
  </body>

</html>
