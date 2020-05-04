<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5ee5657126.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">
    <title>Lab 4 Image Gallery</title>
</head>

<body>
    <div class="container-fluid">
        <header>
            <h1>Image Gallery</h1>
            <h2>Welcome to Lab 4 Image Gallery</h2>
            <div class="line"></div>
        </header>

        <p>Here you can upload your pictures below from anywhere from your computer. First click the 'Choose File' button below, then once you selected a picture click on the 'upload' button to have your picture appear below.</p>
        <p>If you ever want to delete a picture, click on the X in the top right corner of each picture.</p>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="100000000">
            <input type="file" id="file" name="file_upload">
            <label for="file" class="btn-primary text-light mr-2">Choose an Image</label>
            <input class="btn-primary" type="submit" name="submit" value="Upload">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $tmp_file = $_FILES['file_upload']['tmp_name'];

            $target_file = basename($_FILES['file_upload']['name']);

            $upload_dir = 'uploads';

            $message = "<p>Photo ready to upload</p>";

            if (move_uploaded_file($tmp_file, $upload_dir . "/" . $target_file)) {
                echo "<p>Photo uploaded successfully</p>";
            } else {
                echo "<p>Couldn't upload photo successfully</p>";
            } // end of if
        }
        ?>
        <div class="photo-wrapper">

            <?php

            if (isset($_GET['file'])) {

                copy("uploads/" . $_GET['file'], "backups/" . $_GET['file']);

                if (unlink("uploads/" . $_GET['file'])) {
                    header('Location: lab-4.php');
                } else {
                    echo '<p>Couldn\'t not delete that file.</p>';
                }
            }

            $dir = "./uploads";
            if (is_dir($dir)) {
                if ($dir_handle = opendir($dir)) {
                    while ($filename = readdir($dir_handle)) {
                        if (!is_dir($filename) && $filename != '.DS_Store') {
                            $filename = urldecode($filename);
                            echo "<div class=\"photo\"><img src=\"uploads/$filename\" alt=\"A photo\" height=\"275\"></div>";
                            echo "<div class=\"circle\"><a href=\"lab-4.php?file=$filename\"><i class=\"fas fa-times\" alt=\"Delete this photo\"></i></a></div>";
                        }
                    }
                    closedir($dir_handle);
                }
            }
            ?>
        </div>
    </div>
</body>

</html>