<?php

//
//
//   Written by Quadcore
//

error_reporting(E_ALL);
ini_set('display_errors', 1);
//

$postType = $_POST['type'];
if($postType >= 0 && $postType <= 4)
{
    $a = @$_POST['a'];
    $b = @$_POST['b'];
    $c = @$_POST['c'];
    $d = @$_POST['d'];
    $p = @$_POST['p'];
    $op = @$_POST['operation'];
    //File Handler
    $fn = "projects.pj";
    $fh = fopen($fn,"a+");
    $array = @unserialize(fread($fh,filesize($fn)));
}

switch($postType):
    case 0://Create Project or read projects  :: Hierarchy = Section -> Subsection -> Step
        if($b==0)
        {
            if(empty($array))
                $array = array();
            $newProjectArray = 
                array('Name' => $a,'Description' => "Opisanie",'Sections' =>
                    array(
                            array('Name'=>"Head section",'Complete'=>false,'Subsections'=>
                                 array(
                                    array('Name'=>"Subsection",'Complete'=>false,'Steps' => 
                                            array(
                                                "Step one","Step two","Step three"
                                                )
                                         ),
                                    array('Name'=>"Subsection",'Complete'=>false,'Steps' => 
                                            array(
                                                "Step one","Step two","Step three"
                                                )
                                         ),
                                    array('Name'=>"Subsection two",'Complete'=>false,'Steps' => 
                                            array(
                                                "Step one","Step two","Step three"
                                                )
                                         )
                                    )
                                ),
                            array('Name'=>"Head section",'Complete'=>false,'Subsections'=>
                                 array(
                                    array('Name'=>"Subsection",'Complete'=>false,'Steps' => 
                                            array(
                                                "Step one","Step two","Step three"
                                                )
                                         ),
                                    array('Name'=>"Subsection two",'Complete'=>false,'Steps' => 
                                            array(
                                                "Step one","Step two","Step three"
                                                )
                                         )
                                    )
                                )
                        )
                     );
            array_push($array,$newProjectArray);
        }
        elseif($b==1)
            {
                if(!is_array($array))
                {
                    echo "<b style=\"margin-top:50px;\">No projects found</b>";
                    break;
                }
                for($i=0;$i<count($array);$i++)
                echo "<tr><td id=\"num\">".($i+1)."</td><td><a href=\"project.php?id=$i\">" . $array[$i]['Name'] . "</a></td></tr>";
            }
    break;

    case 1://Read project data
        if($b==0)
        {
            $arr = $array[$p]['Sections'];
            for($i = 0;$i<count($arr);$i++)
            {
                
                echo "<li " . ($arr[$i]['Complete']==true?"class=\"complete\"":null) . ">" . $arr[$i]['Name'] . "<ol>";

                $sub = $arr[$i]['Subsections'];
                
                    for($k = 0;$k<count($sub);$k++)
                    {
                        echo "<li><label onClick=\"changeState($i,$k)\">" . $sub[$k]['Name'] ."</label>". ($sub[$k]['Complete']==true?"<img src=\"check.png\" />":null) . "<ol>";
                        $step = $sub[$k]['Steps'];
                        
                            for($m = 0;$m<count($step);$m++)
                            {
                                echo "<li>".$step[$m]."</li>";
                            }
                            echo "</ol></li>";
                    }
                
                        echo "</ol></li>";    
            }
        }
            elseif($b==1)
            {
                echo $array[$p]['Name'];
            }
            elseif($b==2)
            {
                echo $array[$p]['Description'];
            }
    break;
    
    case 2://Alter project data
        if($b==0)
        {
            $arr = @$array[$p]['Sections'];
            for($i = 0;$i<count($arr);$i++)
            {
                
                echo "<li><label>" . $arr[$i]['Name'] . "</label>
                <img onClick=\"deleteSection($i);\" class=\"large\" src=\"delete.png\" />
                <img onClick=\"insert(0,$i);\" class=\"large\" src=\"add.png\" />
                <img onClick=\"rename(0,this,$i);\" class=\"large\" src=\"rename.png\" />"
                    .
                    ($i<count($arr)-1?"<img onclick=\"moveDown(0,$i)\" class=\"large\" src=\"down.png\" />":null)
                    .
                    ($i>0?"<img onclick=\"moveUp(0,$i)\" class=\"large\" src=\"up.png\" />":null)
                    .
                    "<ol>";

                $sub = $arr[$i]['Subsections'];
                
                    for($k = 0;$k<count($sub);$k++)
                    {
                        echo "<li><label>" . $sub[$k]['Name'] . "</label>
                    <img onClick=\"deleteSubpoint($i,$k);\" class=\"medium\" src=\"delete.png\" />
                    <img onClick=\"insert(1,$i,$k);\" class=\"medium\" src=\"add.png\" />
                    <img onClick=\"rename(1,this,$i,$k);\" class=\"medium\" src=\"rename.png\" />" .
                        ($k<count($sub)-1 ?
                        "<img onclick=\"moveDown(1,$i,$k)\" class=\"medium\" src=\"down.png\" />":null) .
                            ($k>0?
                        "<img onclick=\"moveUp(1,$i,$k)\" class=\"medium\" src=\"up.png\" />":null) . 
                        "
                    <ol>";
                        $step = $sub[$k]['Steps'];
                        
                            for($m = 0;$m<count($step);$m++)
                            {
                                echo "<li><label>".$step[$m]. "</label>
                        <img onClick=\"deleteStep($i,$k,$m);\" class=\"small\" src=\"delete.png\" />
                        <img onClick=\"insert(2,$i,$k,$m);\" class=\"small\" src=\"add.png\" />
                        <img onClick=\"rename(2,this,$i,$k,$m);\" class=\"small\" src=\"rename.png\" />
                        " 
                            . 
                            ($m<count($step)-1 ? "<img onclick=\"moveDown(2,$i,$k,$m)\" class=\"small\" src=\"down.png\" />":null)
                            .
                            ($m>0?"<img onclick=\"moveUp(2,$i,$k,$m)\" class=\"small\" src=\"up.png\" />":null) 
                            . 
                        "</li>";
                            }
                            echo "<i onClick=\"addStep($i,$k);\">Add step</i></ol></li>";
                    }
                
                        echo "<i onClick=\"addSubsection($i);\">Add subsection</i></ol></li>";    
            }
            echo "<i onClick=\"addSection();\">Add section</i>";
        }
            elseif($b==1)//Operations for deletion
            {
                switch($op)
                {
                    case 0:
                        unset($array[$p]['Sections'][$a]);
                        $array[$p]['Sections'] = array_values($array[$p]['Sections']);
                    break;
                    case 1:
                        unset($array[$p]['Sections'][$a]['Subsections'][$c]);
                        $array[$p]['Sections'][$a]['Subsections'] = array_values($array[$p]['Sections'][$a]['Subsections']);
                    break;
                    case 2:
                        unset($array[$p]['Sections'][$a]['Subsections'][$c]['Steps'][$d]);
                        $array[$p]['Sections'][$a]['Subsections'][$c]['Steps'] = array_values($array[$p]['Sections'][$a]['Subsections'][$c]['Steps']);
                    break;
                }
            }
            elseif($b==2)//Operations for addition
            {
                switch($op)
                {
                    case 0:
                        array_push($array[$p]['Sections'],array('Name'=>"Head section",'Complete'=>false,'Subsections'=>array()));
                    break;
                    case 1:
                        array_push($array[$p]['Sections'][$a]['Subsections'],array('Name'=>"Subsection",'Complete'=>false,'Steps' =>array()));
                    break;
                    case 2:
                        array_push($array[$p]['Sections'][$a]['Subsections'][$c]['Steps'],"Step");
                    break;
                }
            }
            elseif($b==3)//Operations for moving
            {
                switch($op)
                {
                    case 0:
                        $third = $array[$p]['Sections'][$a];
                        $array[$p]['Sections'][$a] = $array[$p]['Sections'][$a+1];
                        $array[$p]['Sections'][$a+1] = $third;
                    break;
                    case 1:
                        $third = $array[$p]['Sections'][$a]['Subsections'][$c];
                        $array[$p]['Sections'][$a]['Subsections'][$c] = $array[$p]['Sections'][$a]['Subsections'][$c+1];
                        $array[$p]['Sections'][$a]['Subsections'][$c+1] = $third;
                    break;
                    case 2:
                        $third = $array[$p]['Sections'][$a]['Subsections'][$c]['Steps'][$d];
                        $array[$p]['Sections'][$a]['Subsections'][$c]['Steps'][$d] = $array[$p]['Sections'][$a]['Subsections'][$c]['Steps'][$d+1];
                        $array[$p]['Sections'][$a]['Subsections'][$c]['Steps'][$d+1] = $third;
                    break;
                    case 3:
                        $third = $array[$p]['Sections'][$a];
                        $array[$p]['Sections'][$a] = $array[$p]['Sections'][$a-1];
                        $array[$p]['Sections'][$a-1] = $third;
                    break;
                    case 4:
                        $third = $array[$p]['Sections'][$a]['Subsections'][$c];
                        $array[$p]['Sections'][$a]['Subsections'][$c] = $array[$p]['Sections'][$a]['Subsections'][$c-1];
                        $array[$p]['Sections'][$a]['Subsections'][$c-1] = $third;
                    break;
                    case 5:
                        $third = $array[$p]['Sections'][$a]['Subsections'][$c]['Steps'][$d];
                        $array[$p]['Sections'][$a]['Subsections'][$c]['Steps'][$d] = $array[$p]['Sections'][$a]['Subsections'][$c]['Steps'][$d-1];
                        $array[$p]['Sections'][$a]['Subsections'][$c]['Steps'][$d-1] = $third;
                    break;
                }
            }
            elseif($b==4)//Operations for rename
            {
                switch($op)
                {
                    case 0:
                        $array[$p]['Sections'][$c]['Name']=$a;
                    break;
                    case 1:
                        $array[$p]['Sections'][$c]['Subsections'][$d]['Name']=$a;
                    break;
                    case 2:
                        $array[$p]['Sections'][$c]['Subsections'][$d]['Steps'][$_POST['e']]=$a;
                    break;
                }
            }
            elseif($b==5)//Operations for insertion
            {
                switch($op)
                {
                    case 0:
                        array_splice($array[$p]['Sections'], $a+1, 0,array(array('Name'=>"Head section",'Complete'=>false,'Subsections'=>array())));
                    break;
                    case 1:
                        array_splice($array[$p]['Sections'][$a]['Subsections'], $c+1, 0,array(array('Name'=>"Subsection",'Complete'=>false,'Steps' =>array())));
                    break;
                    case 2:
                        array_splice($array[$p]['Sections'][$a]['Subsections'][$c]['Steps'], $d+1, 0,"Step");
                    break;
                }
            }
            elseif($b==6)//Description update
            {
                $array[$p]['Description']=$a;
            }
            elseif($b==7)//Description update
            {
                $array[$p]['Sections'][$a]['Subsections'][$c]['Complete']=!$array[$p]['Sections'][$a]['Subsections'][$c]['Complete'];
                $subsections = $array[$p]['Sections'][$a]['Subsections'];
                $isComplete = true;
                for($i = 0;$i<count($subsections);$i++)
                {
                    if($subsections[$i]['Complete']==false)
                    {
                        $isComplete = false;
                        break;
                    }
                }
                $array[$p]['Sections'][$a]['Complete'] = $isComplete;
            }
    break;
endswitch;
function checkHeadingIsComplete($hID)
{
    $ary = $array[$p]['Sections'][$hID];
    $subsections = $ary['Subsections'];
    $isComplete = true;
    for($i = 0;$i<count($subsections);$i++)
    {
        if($subsections[$i]['Complete']==false)
        {
            $isComplete = false;
            break;
        }
    }
    if(empty($subsections))
    {
        $isComplete = false;
    }
    $ary['Complete'] = !$isComplete;
}

if($postType >= 0 && $postType <= 4)
{
    $data = serialize($array);
    ftruncate($fh,0);
    fwrite($fh,$data);
    if($postType==3)
        ftruncate($fh,0);
    fclose($fh);
}

?>