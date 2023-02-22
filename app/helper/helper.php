<?php
    function cleanFormString($string)
    {
        $string = str_replace("/", " ", $string);
        $regex = "/[ ](=[ ])|[^-_:,A-Za-z0-9.`: ]+/m";
        $string = str_replace("'", "`", $string);
        return preg_replace($regex, "", $string);
    }

    function setDecimal($num){
        $num = str_replace(',','.',$num);
        return $num;
    }

    function genereteDataQuery($array, $method)
    {
    	$insert_query = "";
        $keys = '(';
        $values = '(';
		foreach ($array as $key => $value) {
            if ($method == 'POST'){
                $keys .= "$key,";
                if($value == null){
                    $values .= "null,";
                } else {
                    $values .= "'$value',";
                }
            } else {
                if($value != null){
                    $insert_query .= "$key='$value',";
                }
            }
        }

        if ($method == 'POST'){
            $keys = rtrim($keys, ',');
            $keys .= ')';
            $values = rtrim($values, ',');
            $values .= ')';

            $insert_query = "$keys VALUES $values";
        } else {
            $insert_query = rtrim($insert_query, ',');
        }

        return $insert_query;
    }

    function uploadPicture($upload_dir,$path_name,$file_request,$is_create_dir = 1){
        // $pic_path       = $req->file('Pic_Path');
        $pic_path       = $file_request;
        $fileName       = $pic_path->getClientOriginalName();

        $ext = $pic_path->getClientOriginalExtension();
        if (preg_match('/jpg|jpeg/i',$ext))
            $imageTmp=imagecreatefromjpeg($pic_path->getRealPath());
        else if (preg_match('/png/i',$ext))
            $imageTmp=imagecreatefrompng($pic_path->getRealPath());
        else if (preg_match('/gif/i',$ext))
            $imageTmp=imagecreatefromgif($pic_path->getRealPath());
        else if (preg_match('/bmp/i',$ext))
            $imageTmp=imagecreatefrombmp($pic_path->getRealPath());
        else {
            $notsupported = 1;
        }

        if(!isset($notsupported)){
            $uploaded = 1;
            // Upload Image
                $path = base_path("public/".$upload_dir.$path_name);
                if($is_create_dir === 1 && !file_exists($path)){
                    mkdir($path);
                }
                imagejpeg($imageTmp, $path."/".$fileName, 40);
        } else {
            $uploaded = 0;
        }

        $response['status']     = $uploaded;
        $response['file_name']  = $fileName;
        return $response;
    }

    function group_array($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
?>
