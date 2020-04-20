<?php 
    // login check
    session_start();
    $logged_in = false;
    if(isset($_SESSION["uid"])) $logged_in = true;
    else header("Location: index.php");
    
    include("image.php");
    
    //hot?
    $hot_score = hot_score($_SESSION["uid"]);
    if(!$hot_score) $hot_score = 0;
    
    //how many images?
    $img_count = 0;
    $img_count = img_count($_SESSION["uid"]);
?>
<!DOCTYPE html>
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
    <script src="js/hotornot.js"></script>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="lib/fontawesome-free-5.11.2-web/css/all.min.css">
    <script src="lib/fontawesome-free-5.11.2-web/js/all.min.js"></script>
    <link rel="stylesheet" href="css/common.css">
</head>
<body>
<div class="wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Hot||Not</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php
                if ($logged_in) {
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="upload.php">Upload image</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="settings.php">Settings</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">

            <div class="col-md-8 offset-2 d-flex flex-row profile-header">
                <div class="profile-pic">
                    <img src="getProfilePic.php?user_id=<?php echo $_SESSION["uid"]; ?>" height="160" width="160" alt="picture"/>
                </div>

                <div class="info">
                    <div><?php echo $_SESSION["name"]; ?></div>
                    <div><em class="fab fa-hotjar"></em> <?php echo $hot_score; ?></div>
                    <div><em class="fas fa-image"></em> <?php echo $img_count; ?></div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-8 offset-2">
                <h2>Gallery</h2>
                <div class="gallery">
                    <?php
                    //get images
                    $imgs = images_by_user($_SESSION["uid"]);
                    if(empty($imgs)) {
                        echo "<h3>No pictures found</h3>";
                    }
                    foreach($imgs as $img) {
                    ?>
                    <div class="image">
                        <div class="image-info">
                            <div><em class="fab fa-hotjar"></em> <?php if(!$img["hot"]) echo "0";  else echo $img["hot"]; ?></div>
                        </div>
                        <img src="getImage.php?img_id=<?php echo $img["id"]; ?>" height="160" width="160" alt="picture"/>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-light py-1">
        <div class="container">
            <div class="row vcenter">
                <div class="pull-left col-lg-4 col-xs-12">
                    <p>Copyright &copy;2019</p>
                </div>
                <div class="col-lg-4 col-lg-offset-4 col-xs-12">
                    <div class="pull-right">
                        Skupina 01 Client side
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
