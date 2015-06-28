<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>UNTAR's Programming Teams - UVa Scoreboard Monitor</title>
    <!-- Local bootstrap -->
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css"> -->
    <link rel="icon" href="<?=base_url()?>/favicon.ico" type="image/ico">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <style type="text/css">
        body {
            margin-left: 10px;
            margin-right: 10px;
            padding-top: 20px;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="ranklist">
        <?php echo $this->table->generate(); ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="/assets/js/moment.min.js" type="text/javascript" charset="utf-8"></script>
    <!-- <script src="assets/js/jquery-2.1.4.min.js" type="text/javascript" charset="utf-8"></script> -->
    <!-- <script src="assets/js/myscript.js" type="text/javascript" charset="utf-8"></script> -->
</body>
</html>
