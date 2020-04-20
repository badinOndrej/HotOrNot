<?php
/**
 * REST
 * GET
 * Fetch profile image data from database
 * arguments: user_id -- user id
 */
require("kitlab_db.php");

if(isset($_GET["user_id"])) {
    $cnn = db_connect();
    $user_id = $cnn->escape_string($_GET["user_id"]);
    $qry = "SELECT pic, pic_type FROM user WHERE id = '" . $user_id . "';";
    $result = $cnn->query($qry) or die("Error!");
    $row = $result->fetch_array();
    if($row["pic"]) {
        header("Content-type: image/" . $row["pic_type"]);
        echo($row["pic"]);
    } else {
        header("Content-type: image/png");
        echo(file_get_contents("placeholder.png"));
    }
}