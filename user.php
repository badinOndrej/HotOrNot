<?php
include("kitlab_db.php");

/**
 * hashes password using sha256 and salt&pepper method
 * @param string $pass password
 * @return string hashed password
 */
function hash_password($pass) {
    $salt = "This will be a very strong password.";
    $pepper = "Don't believe me? Your mistake.";
    return hash("sha256", hash("sha256", $salt) . $pass . hash("sha256", $pepper));
}

/**
 * Registers a new user
 * @param string $email email
 * @param string $pass password
 * @param string $pass_veri again for verification
 * @param string $name name of the user
 * @return boolean true if successfuly registered, otherwise false
 */
function register($email, $pass, $pass_veri, $name) {
    $cnn = db_connect();
    if($pass !== $pass_veri) return false;
    $id = uniqid();
    $pass = hash_password($pass);
    $qry = $cnn->prepare("INSERT INTO user(id, name, email, pwd) VALUES(?, ?, ?, ?)");
    $qry->bind_param("ssss", $id, $name, $email, $pass);
    if($qry->execute()) return true;
    else return false;
}

/**
 * user login
 * @param string $email email
 * @param string $pass password
 */
function login($email, $pass) {
    $cnn = db_connect();
    $pass = hash_password($pass);
    $qry = $cnn->prepare("SELECT id, name FROM user WHERE email = ? AND pwd = ?");
    $qry->bind_param("ss", $email, $pass);
    if($qry->execute()) {
        if($obj = $qry->get_result()->fetch_object()) {
            session_start();
            $_SESSION["uid"] = $obj->id;
            $_SESSION["name"] = $obj->name;
            return true;
        } else return false;
    } else return false;
}

/**
 * changes user password
 * @param string $user user id
 * @param string $pass password
 * @param string $pass_veri again for verification
 * @return boolean true on success, else false
 */
function change_pass($user, $pass, $pass_veri) {
    $cnn = db_connect();
    if($pass !== $pass_veri) return false;
    $pass = hash_password($pass);
    $qry = $cnn->prepare("UPDATE user SET pwd = ? WHERE id = ?");
    $qry->bind_param("ss", $pass, $user);
    $qry->execute();
    return true;
}

/**
 * uploads profile photo
 * @param file $img image descriptor
 * @param string $user user id
 * @return boolean true on success, else false
 */
function upload_profile_photo($img, $user) {
    $type = strtolower(pathinfo($img["name"],PATHINFO_EXTENSION));
    $data = addslashes(file_get_contents($img["tmp_name"]));
    $cnn = db_connect();
    $qry = "UPDATE user SET pic = '$data', pic_type = '$type' WHERE id = '$user';";
    if($cnn->query($qry)) return true;
    else return false;
}

/**
 * deletes user
 * @param string $user user id
 */
function delete_user($user) {
    $qryA = "DELETE FROM user WHERE id = '" . $user . "';";
    $qryB = "DELETE FROM image WHERE user = '" . $user . "';";
    $cnn = db_connect();
    $cnn->query($qryA);
    $cnn->query($qryB);
    header("Location: logout.php");
}