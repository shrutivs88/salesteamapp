<?php
session_start();
if(!isset($_SESSION["email"])) {
    header("Location:../login.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/config.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sales Team Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASEURL; ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASEURL; ?>assets/css/styles.css" />
    <script src="<?php echo BASEURL; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo BASEURL; ?>assets/js/bootstrap.min.js"></script>
</head>
<body>
    <?php include 'navbar.php';?>
    <div class="content-view">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <?php include("sidemenu.php"); ?>
                </div>
                <div class="col-sm-9">
                    <h2 class="text-center">Welcome To Home</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <!-- Admin Access Only -->
                    <?php if ($_SESSION['role'] == "ADMIN") : ?>
                        <div id="admin-container" class="role-container">
                        
                        </div>
                    <?php endif; ?>
                    <!-- BDM Access Only -->
                    <?php if ($_SESSION['role'] == "BDM") : ?>
                        <div id="bdm-container" class="role-container">
                            <h2 class="text-center">BDM</h2>
                        </div>
                    <?php endif; ?>
                    <!-- BDE Access Only -->
                    <?php if ($_SESSION['role'] == "BDE") : ?>
                        <div id="bde-container" class="role-container">
                            <h2 class="text-center">BDE</h2>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div> 
    </div>
    <?php include 'footer.php';?>
</body>
</html>