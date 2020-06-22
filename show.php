<?php
  require 'vendor/autoload.php';

  $mng = new MongoDB\Client("mongodb://localhost:27017");
  $database = $mng->test;
  $collection = $database->selectCollection('users');

  $document = $collection->findOne(['_id' => new MongoDB\BSON\ObjectID($_GET["mid"])]);
  $first_name = $document["first_name"];
  $last_name = $document["last_name"];
  $favorite_cat = $document["favorite_cat"];
  $id = $document["_id"];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo "See / Modify ".$document["first_name"]." ". $document["last_name"];?></title>
</head>
  <body>
    <?php
    echo "First name: ".$document["first_name"]."</br>";
    echo "Last name: ".$document["last_name"]."</br>";
    echo "Favorite cat: ".$document["favorite_cat"]."</br>";
    echo "<a href=index.php>Retour</a>";
    ?>

    <h4>Modify</h1>
    <form action="index.php" method="post">
      <input type="text" name="first_name" value="<?php echo $first_name; ?>">
      <input type="text" name="last_name" value="<?php echo $last_name; ?>">
      <input type="text" name="favorite_cat" value="<?php echo $favorite_cat; ?>">
      <input type="hidden" name="mid" value="<?php echo $id; ?>">
      <button type="submit" name="button">Save</button>
    </form>
    </br>
  </body>

</html>
