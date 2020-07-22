<?php
    //the build-function put the diffrent parts together
    function build($file){
        if(isset($_SESSION['user'])){
            $header = "header_user.php";
            
        } else {
            $header = "header_default.php";
        }

        ?>
            <!DOCTYPE html>
            <html lang="de">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Flight emmissions tracker</title>
                
                <link rel="stylesheet" type="text/css" href="./css/main.css">
            </head>
            <body>
                <header>
                    <?php require_once "header/$header"?>
                </header>
                <main>
                    <?php require_once "./view/$file" ?>
                </main>
                <footer>
                    <?php require_once "footer/footer_default.php" ?>
                </footer>
                <script src="js/main.js"></script>
            </body>
        <?php
    }
?>