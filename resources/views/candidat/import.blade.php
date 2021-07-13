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
 <form action="/import" method="post" enctype="multipart/form-data">
    @csrf
    <label class="label-info small">Upload file</label>
    <input type="file" class="form-control-file" name="file" id="file" />
    <input type="submit" name="submit" value="Submit" />
</form>
 </body>
</html>
