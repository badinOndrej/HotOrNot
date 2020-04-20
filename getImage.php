<?php
/**
 * REST
 * GET
 * Fetch image data from database
 * arguments: img_id -- image id
 */
require("kitlab_db.php");

if(isset($_GET["img_id"])) {
    $cnn = db_connect();
    $img_id = $cnn->escape_string($_GET["img_id"]);
    $qry = "SELECT data, type FROM image WHERE id = '" . $img_id . "';";
    $result = $cnn->query($qry) or die("Error!");
    if($row = $result->fetch_array()) {
	    header("Content-type: image/" . $row["type"]);
	    echo($row["data"]);
    } else {
	    header("Content-type: image/png");
	    echo(file_get_contents("placeholder.png"));
    }
}
