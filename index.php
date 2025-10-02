<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANME</title>

<link rel="icon" href="Logo_anme.jpg" type="image/x-icon">

    <link href="bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="style.css?v=<?php echo rand(0,10000);?>">
    <script src="api.js" async defer></script>

    
    <script src="app.js"></script>
    <script src="file_upload.js"></script>
    <script src="bootstrap3.js"></script>
</head>
<body>
<?php


include($_REQUEST['page'].'.html');



?>



</body>

</html>