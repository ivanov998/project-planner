<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script src="jscontrol.js"></script>
        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    </head>
    <body onLoad="loadList(true);">
        <input type="hidden" name="data" value="<?php $get = @$_GET['id']; echo $get; ?>" />
                <p id="title" style="margin-top:60px;margin-bottom:10px;text-transform:uppercase;-webkit-user-select:none;">...</p>
                <a href="project.php?id=<?php echo $get; ?>">
                    <img style="margin:10px auto; display:block; width:20px;height:20px;"  class="large" src="delete.png"/>
                </a>
                <div class="projecttree">
                   <span class="briefdescription">
                       <textarea onchange="updateDesc(this);" style="width:100%;max-width:100%; padding:10px 20px;background:none;"></textarea>
                    </span>
                    <ol class="main">
                        
                        
                    </ol>
                </div>
    </body>
</html>