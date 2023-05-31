<?php
print_r('The php script is called....');
print_r('The value of $_POST["myText"] is :  ');
var_dump($_POST['myText']);
$post_data = $_POST['myText'];
    $filename ='data.json';
    //$location = file_get_contents($filename);
    //echo $location; 
    $myfile = fopen($filename, "w") or die("Unable to open file!");
    $txt = $post_data;
    fwrite($myfile, $txt);
    //file_put_contents($filename,$txt);
    fclose($myfile);
?>