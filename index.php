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
    <body onload="appear()">
        <a onclick="deleteFile();"></a>
        <div class="fullscreen">
            <div class="inner">
               <div class="add">
                <p class="none">New project</p>
                       <i>Project name</i>
                        <input id="pName" type="text"><br>
                        <a class="btn notopmargin" style="display:none;" onClick="createProject()">Create</a>
                </div>
                <div class="main">
                <p style="margin-bottom:20px;" class="none">Projects</p>
                    <div class="projects none">
                        <table>
                                
                        
                        </table>
                    </div>
                <a class="btn" style="display:none;" onClick="switchToProjectCreation()">Create a new project</a>
                </div>
            </div>
            
        </div>
    </body>


</html>