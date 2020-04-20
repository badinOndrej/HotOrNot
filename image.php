<?php
include("kitlab_db.php");

/**
 * returns count of user's images
 * @param string $user user id
 * @return int count of images
 */
function img_count($user) {
    $cnn = db_connect();
    $qry = "SELECT COUNT(id) AS cnt FROM image WHERE user = '" . $user . "';";
    if($result = $cnn->query($qry)) {
        return $result->fetch_object()->cnt;
    } else return 0;
}

/**
 * returns user's hottness
 * @param string $user user id
 * @return int hottness
 */
function hot_score($user) {
    $cnn = db_connect();
    $qry = "SELECT SUM(hot) as hot FROM image WHERE user = '" . $user . "';";
    if($result = $cnn->query($qry)) {
        return $result->fetch_object()->hot;
    } else return 0;
}

/**
 * returns array of images by user and image hottness
 * @param string $user user id
 * @return array images and hottness
 */
function images_by_user($user) {
    $cnn = db_connect();
    $imgs = array();
    $qry = "SELECT id, hot FROM image WHERE user = '" . $user . "';";
    if($result = $cnn->query($qry)) {
        while($obj = $result->fetch_object()) {
            $tmp = array("id" => $obj->id, "hot" => $obj->hot);
            array_push($imgs, $tmp);
        }
    }
    return $imgs;
}

/**
 * uploads a photo
 * @param file $img image descriptor
 * @param string $user user id
 * @return boolean true if success, else false
 */
function upload_photo($img, $user) {
    $id = uniqid();
    $type = strtolower(pathinfo($img["name"],PATHINFO_EXTENSION));
    $data = addslashes(file_get_contents($img["tmp_name"]));
    $cnn = db_connect();
    $qry = "INSERT INTO image(id, user, type, data) VALUES ('$id', '$user', '$type', '$data');";
    if($cnn->query($qry)) return true;
    else return false;
}

/**
 * returns random image not by user
 * @return string image id
 */
function get_random_image($user) {
    $cnn = db_connect();
    $qry = "SELECT id FROM image WHERE user NOT LIKE '" . $user . "' ORDER BY RAND() LIMIT 1";
    if($result = $cnn->query($qry)) {
        if($row = $result->fetch_assoc()) return $row["id"];
        else return null;
    } else return null;
}

/**
 * adds to image hottness
 * @param string $img image id
 */
function add_hot($img) {
    $cnn = db_connect();
    $qry = "UPDATE image SET hot = hot + 1 WHERE id = '" . $img . "';";
    $cnn->query($qry);
}

/**
 * subtracts from image hottness
 * @param string $img image id
 */
function sub_hot($img) {
    $cnn = db_connect();
    $qry = "UPDATE image SET hot = hot - 1 WHERE id = '" . $img . "';";
    $cnn->query($qry);
}