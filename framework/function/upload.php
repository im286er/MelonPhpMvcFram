<?php

    $filename=$_FILES['myFile']['name'];
    $type=$_FILES['myFile']['type'];
    $tmp_name=$_FILES['myFile']['tmp_name'];
    $size = $_FILES['myFile']['size'];
    $error=$_FILES['myFile']['error'];
    
    if($error == UPLOAD_ERR_OK){
        if(move_uploaded_file($tmp_name, 'uploads/'.$filename)){
            echo '图片'.$filename.'上传成功';
        }  else {
            echo '图片'.$filename.'上传失败';
        }
    }  else {
        switch ($error){
            case 1:
                echo '文件过大';
                break;
            case 2:
                echo '文件过大';
                break;
            case 3:
                echo '文件上传不完整';
                break;
            case 4:
                echo '没有文件';
                break;
            case 6:
                echo '找不到目录';
                break;
            case 7:
                echo '';
                break;
            case 8:
                echo 'ÒòÎªphpÀ©Õ¹ÉÏ´«Ê§°Ü';
                break;
        }
    }
    
    