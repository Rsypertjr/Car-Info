<?php
print_r('The php script is called....');
print_r('The value of $_POST["myText"] is :  ');
var_dump($_POST['myText']);
$post_data = $_POST['myText'];
    $filename ='data.json';
    $myfile = fopen($filename, "w") or die("Unable to open file!");
    $txt = $post_data;
    fwrite($myfile, $txt);
    fclose($myfile);
?>