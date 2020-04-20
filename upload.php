<?php 
    // login check
    session_start();
    $logged_in = false;
    if(isset($_SESSION["uid"])) $logged_in = true;
    else header("Location: index.php");
    
    include("image.php");
    
    //upload picture
    $result = null;
    if(isset($_POST["upload"])) {
        $img = $_FILES["choose"];
        $result = upload_photo($img, $_SESSION["uid"]);
    }
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
	<h2 style="margin: 15px;">Upload image</h2>
	<div class="row">
                <div class="gallery d-flex flex-row justify-contents-center align-items-center">
                    <img id="preview" src="placeholder.png" style="max-width: 500px; max-height: 500px" alt="foto"/>
                </div>
                <div class="gallery d-flex flex-row align-items-center">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="file" id="choose" name="choose" accept="image/png, image/jpeg" required />
			<button type="submit" name="upload" id="upload" class="btn btn-primary px-3"><em class="fas fa-file-upload"></em> Upload</button>
                    </form>
                </div>
        </div>
        <div class="row">
            <?php 
            if($result === true) echo "<h3>Success!</h3>\n";
            else if($result === false) echo "<h3>Error uploading photo</h3>\n";
            ?>
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
    <script>
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#preview').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#choose").change(function() {
  readURL(this);
  // file size limit - 2MB
  // more than enough for selfies :-)
  if(this.files[0].size > 524288){
       alert("File is too big! Size limit: 0.5MB");
       $("#upload").attr("enabled", false);
  } else {
       $("#upload").attr("enabled", true);
  }
});
    </script>
</body>
</html>
