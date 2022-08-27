<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload File</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <!-- Upload form -->
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="xml_file" class="form-control" required>
        <button type="submit" class="btn btn-primary mt-2">Upload</button>
        <?php
        if (isset($_FILES['xml_file'])){
            include __DIR__ . '/convert.php';
        }
        ?>
    </form>
</div>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>
</html>