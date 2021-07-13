<!DOCTYPE html>
<html>
 <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>How to Crop And Upload Image in Laravel 6 using jQuery Ajax</title>
  <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/imgareaselect.css" />
        <link href="css/styles.css" rel="stylesheet" />
  <!--<script src="{{ asset('js/bootstrap.min.js') }}"></script>!-->
  
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
 </head>
 <body>
 <form action="crop.php" method="post" enctype="multipart/form-data">
    Upload Image: <input type="file" name="image" id="image" />
    <input type="hidden" name="x1" value="" />
    <input type="hidden" name="y1" value="" />
    <input type="hidden" name="w" value="" />
    <input type="hidden" name="h" value="" /><br><br>
    <input type="submit" name="submit" value="Submit" />
</form>
 
<p ><img id="previewimage" height="300px" width="400px" style="display:none;"/></p>
    <script src="js/jquery.imgareaselect.js"></script> 
    <script src="js/crop.js"></script>
 </body>
</html>