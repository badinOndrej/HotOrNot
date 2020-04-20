<?php 
    // login check
    session_start();
    $logged_in = false;
    if(isset($_SESSION["uid"])) $logged_in = true;
    
    include("image.php");
    
    if(isset($_POST["hot"])) {
        $img_id = htmlspecialchars($_POST["img_id"]);
        add_hot($img_id);
    }
    
    if(isset($_POST["not"])) {
        $img_id = htmlspecialchars($_POST["img_id"]);
        sub_hot($img_id);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hot || Not</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" crossorigin="anonymous"></script>
    <script src="lib/popper.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/login.css">
    <script src="js/hotornot.js"></script>
    <link rel="stylesheet" href="css/hotornot.css">
    <script src="https://kit.fontawesome.com/e40d413be0.js" crossorigin="anonymous"></script>
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
            if($logged_in) {
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
<div class="container w-100 h-100">
    <div class="row w-100 h-100">
        <div class="col-md-6 offset-md-3 h-100 d-flex align-items-center">
            <div style="margin: 0 auto">
                <div class="gallery d-flex flex-row justify-content-between align-items-center">
                    <?php 
                    $rand_img = get_random_image($_SESSION["uid"]);
                    if($rand_img !== null) {
                    ?>
                    <img src="getImage.php?img_id=<?php echo $rand_img; ?>" alt="image for voting" style="max-width: 500px; max-height: 500px;"/>
                </div>
                        <?php
                        if ($logged_in) {
                            ?>
                            <form method="post">
                            <div class="rating d-flex flex-row justify-content-between">
                                
                                    <input type="hidden" name="img_id" value="<?php echo $rand_img; ?>" />
                                    <button type="submit" class="btn btn-secondary px-3" name="not">
                                        <em class="fas fa-grin-squint-tears"></em>
                                        Not
                                    </button>
                                        <button type="submit" class="btn btn-primary px-3" name="hot">
                                        <em class="fab fa-hotjar"></em>
                                        Hot!
                                    </button>
                            </div>
                            </form>
                            <?php
                        } 
                    } else {
                        echo "<h3>No photos found</h3>\n</div>\n";
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
