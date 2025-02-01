    var get;

    function loadList(editMode)
    {
        get = document.getElementsByName("data")[0].value;
        $('#title').show(function(){$("#title").load("process.php",{type:1,b:1,p:get},function(){$('#title').fadeIn(600,function()
        {
            if(!editMode)
            $(".briefdescription").load("process.php",{type:1,b:2,p:get},function(){$(".briefdescription").prepend("<p>Brief Description</p>");});
            else
            $(".briefdescription textarea").load("process.php",{type:1,b:2,p:get},function(){$(".briefdescription").prepend("<p>Brief Description</p>");});
            
           $(".main").hide();
        $(".main").load("process.php",{type:(editMode==true?2:1),b:0,p:get},function()
            { $(".main ol li").hide();
            $(".main").fadeIn(600,function(){
                $(".main ol li").each(function(index) {
        $(this).delay(60).fadeIn(60);
        });
            }); 
                });         
            
        });
            });
                });
        
        

    }
    function doubleReload(EM)
    {
        setTimeout(function(){ $(".main").load("process.php",{type:(EM==true?2:1),b:0,p:get}); },160);
    }
    function updateDesc(dom)
    {
        var text = $(dom).parent().find("textarea").first().val();
        $.ajax({
            url: "process.php",
            type: "post",
            data: { type:2 , a:text , b:6 , p:get }
        });
    }
    function changeState(param1,param2)
    {
        $.ajax({
            url: "process.php",
            type: "post",
            data: { type:2 , a:param1 , c:param2 , b:7 , p:get }
        });
        
        doubleReload();
    }
    function deleteSection(param1)
    {
        $.ajax({
            url: "process.php",
            type: "post",
            data: 
            { 
                type:2 , 
                a:param1 , 
                b:1 , 
                p:get , 
                operation:0
            }
        });
        doubleReload(true);
    }
    function deleteSubpoint(param1,param2)
    {
        $.ajax({
            url: "process.php",
            type: "post",
            data: 
            { 
                type:2 , 
                a:param1 , 
                c:param2 , 
                b:1 , 
                p:get , 
                operation:1
            }
        });
        doubleReload(true);
    }
    function deleteStep(param1,param2,param3)
    {
        $.ajax({
            url: "process.php",
            type: "post",
            data: 
            { 
                type:2 , 
                a:param1 , 
                c:param2 , 
                d:param3 , 
                b:1 , 
                p:get , 
                operation:2
            }
        });
        doubleReload(true);
    }
    function addSection()
    {
        $.ajax({
            url: "process.php",
            type: "post",
            data: 
            { 
                type:2 , 
                b:2 , 
                p:get , 
                operation:0
            }
        });
        doubleReload(true);
    }
    function addSubsection(param1)
    {
        $.ajax({
            url: "process.php",
            type: "post",
            data: 
            { 
                type:2 ,
                a:param1 ,
                b:2 , 
                p:get , 
                operation:1
            }
        });
        doubleReload(true);
    }
    function addStep(param1,param2)
    {
        $.ajax({
            url: "process.php",
            type: "post",
            data: 
            { 
                type:2 ,
                a:param1 ,
                c:param2 ,
                b:2 , 
                p:get , 
                operation:2
            }
        });
        doubleReload(true);
    }
    function rename(type,dom,param1,param2=null,param3=null)
    {
        var text = $(dom).parent().find("label").first().text();
        $(dom).parent().find("label").first().replaceWith("<div style=\"display:inline-block\"><input type=\"text\" value=\""+text+"\" ><a onclick=\"renameFinal("+type+",this,"+param1+","+param2+","+param3+");\">GO</a></div>");
    }
    function renameFinal(opr,dom,param1,param2,param3)
    {
        var text = $(dom).parent().find("input").val();
        $(dom).parent().parent().find("div").replaceWith("<label>"+text+"</label>");

        $.ajax({
            url: "process.php",
            type: "post",
            data: 
            { 
                type:2 ,
                a:text ,
                c:param1,
                d:param2,
                e:param3,
                b:4 , 
                p:get , 
                operation:opr
            }
        });
        
        doubleReload(true);
    }

    function moveDown(opr,param1,param2=null,param3=null)
    {
        $.ajax({
            url: "process.php",
            type: "post",
            data: 
            {
                type:2 ,
                a:param1,
                c:param2,
                d:param3,
                b:3 , 
                p:get , 
                operation:opr
            }
        });
        
        doubleReload(true);
    }
    function moveUp(opr,param1,param2=null,param3=null)
    {
        $.ajax({
            url: "process.php",
            type: "post",
            data: 
            {
                type:2 ,
                a:param1,
                c:param2,
                d:param3,
                b:3 , 
                p:get , 
                operation:opr+3
            }
        });
        
        doubleReload(true);
    }
    function insert(opr,param1,param2=null,param3=null)
    {
        $.ajax({
            url: "process.php",
            type: "post",
            data: 
            {
                type:2 ,
                a:param1,
                c:param2,
                d:param3,
                b:5 , 
                p:get , 
                operation:opr
            }
        });
        
        doubleReload(true);
    }

    function appear()
    {
        $('.inner .main p').slideDown(800);
        $('.inner .main .projects').fadeIn(800,function(){$('.inner .main .btn').fadeIn(500);});
        loadProjects();
    }
    function switchToProjectCreation()
    {
        $('.inner .main').fadeOut(500,function(){
            $('.inner .add').show();
            $('.inner .add p').slideDown(800,function(){ 
                $('.inner .add').fadeIn(600,
                function()
                {
                    $('.inner .add a').fadeIn(600);
                }
                ); 
            });
        });

    }
    function loadProjects()
    {
        $('.main table').load('process.php',{ type:0 , b:1 });
    }
    function createProject()
    {
        var data = document.getElementById("pName").value;
        $.ajax({
            url: "process.php",
            type: "post",
            data: { type:0 , a:data , b:0 }
        });
        setTimeout(function(){ window.location.reload() } , 200);
    }
    function deleteFile()
    {
        $.ajax({
            url: "process.php",
            type: "post",
            data: { type:3 }
        });
        setTimeout(function(){ window.location.reload() } , 200);
    }