<!DOCTYPE html>
<?php
if(isset($_SESSION["uid"])) header("Location: index.php"); // if logged in, get out

include("user.php"); // user manipulation functions

//login
$result_log = null;
if(isset($_POST["login"])) {
    $email = htmlspecialchars($_POST["email_login"]);
    $pass = htmlspecialchars($_POST["password_login"]);
    
    $result_log = login($email, $pass);
    if($result_log) header("Location: index.php");
}

//register new user
$result_reg = null;
if(isset($_POST["register"])) {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $pass = htmlspecialchars($_POST["password"]);
    $pass_veri = htmlspecialchars($_POST["veri_password"]);
    
    $result_reg = register($email, $pass, $pass_veri, $name);
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hot || Not</title>
    <script src="lib/jquery.min.js"></script>
    <script src="lib/popper.js"></script>
    <link rel="stylesheet" href="lib/bootstrap-4.3.1-dist/css/bootstrap.css">
    <script src="lib/bootstrap-4.3.1-dist/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<h2 style="text-align: center; padding-top: 20px;">Hot||Not</h1>
<div class="container login-container">
    <div class="row">
        <div class="col-md-6 login-form-1">
            <h3>Login</h3>
            <!-- jako placeholder odkazuje přímo na hlavní stránku -->
            <form method="POST">
                <div class="form-group">
                    <input required type="email" name="email_login" class="form-control" placeholder="Your Email *" value="" title="email"/>
                </div>
                <div class="form-group">
                    <input required type="password" name="password_login" class="form-control" placeholder="Your Password *" value="" title="password"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="login" class="btnSubmit" value="Login" />
                </div>
            </form>
            <?php
            if($result_log === false) echo("<h3>Login error</h3>\n");
            ?>
        </div>
        <div class="col-md-6 login-form-2">
            <h3>Register now!</h3>
            <form method="POST">
                <div class="form-group">
                    <input required type="email" name="email" class="form-control" placeholder="Your Email *" value="" title="email"/>
                </div>
                <div class="form-group">
                    <input required type="text" name="name" class="form-control" placeholder="Your Name *" value="" title="name"/>
                </div>
                <div class="form-group">
                    <input required type="password" name="password" minlength="8" class="form-control" placeholder="Your Password *" value="" title="password"/>
                </div>
                <div class="form-group">
                    <input required type="password" name="veri_password" minlength="8" class="form-control" placeholder="Password check *" value="" title="password"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="register" class="btnSubmit" value="Register" />
                </div>
            </form>
            <?php
            if($result_reg === true) echo("<h3>Success!</h3>\n");
            else if($result_reg === false) echo("<h3>Error. Please check the information you entered.</h3>\n");
            ?>
        </div>
    </div>
</div>
</body>
</html>
