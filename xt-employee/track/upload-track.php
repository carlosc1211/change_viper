<?php
require_once("../../lib/core.php");

$_dir = $_REQUEST["_dir"];
$targetPath = "../../images/track/$_dir/";   //2

    if(isset($_GET["opc"]) && $_GET["opc"] == "list")
    {
        $photo_list = is_dir($targetPath) ? scandir($targetPath) : NULL;
        if(is_array($photo_list) && count($photo_list) > 0){
            array_shift($photo_list);
            array_shift($photo_list); // elimino . y ..
        }

        if(is_array($photo_list) && count($photo_list) > 0){
            natsort($photo_list);
            $result  = array();

            if ( false!==$photo_list ) {
                foreach ( $photo_list as $file ) {
                    if ( '.'!=$file && '..'!=$file) {       //2
                        $obj['name'] = $file;
                        $obj['size'] = filesize($targetPath.$file);
                        $result[] = $obj;
                    }
                }
            }

            header('Content-type: text/json');              //3
            header('Content-type: application/json');
            echo json_encode($result);
        }

    }
    if(isset($_GET["opc"]) && $_GET["opc"] == "delete")
    {
        $name = $_POST["filename"];
        if(file_exists($targetPath.$name))
        {
            unlink($targetPath.$name);

            echo json_encode(array("res" => true));
        }
        else
        {
            echo json_encode(array("res" => false));
        }
    }
    else
    {
        $file = GUID() . $_FILES["file"]["name"] ;;
        $filetype = $_FILES["file"]["type"];
        $filesize = $_FILES["file"]["size"];

        if(!is_dir($targetPath))
            mkdir($targetPath, 0777);

        $file && move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath.$file);

        echo $file;

    }
?>