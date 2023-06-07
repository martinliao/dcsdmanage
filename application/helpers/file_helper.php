<?php

class File_helper{
	public static function download($file_path, $zip=false){
		$file_name = basename($file_path);
		$ua = $_SERVER["HTTP_USER_AGENT"]; 

		if (preg_match("/MSIE/", $ua) || preg_match("/Edge/", $ua)){
	   		$file_name = urlencode($file_name); 
    		$file_name = str_replace("+", "%20", $file_name);			
		} 

        if($zip){
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: binary");
        } else {
            header('Content-Type: application/octet-stream');
        }
		
		header('Content-Disposition: attachment; filename='.$file_name);
		readfile($file_path); 
	}

	public static function zipFile($zip_name, $files, $password, $tmp_dir = "/www/html/eda/manage/resource/evaluation/"){
		$zip_name=basename($zip_name);
		
		if(!empty($password)){
			$zip_shell = "cd ".$tmp_dir."; zip -jP ". $password .' '.$zip_name;
		} else {
			$zip_shell = "cd ".$tmp_dir."; zip -j ".$zip_name;
		}
		
		foreach ($files as $file) {
			$zip_shell .= " ".$file;
		}

	    $status = true;
	    $output = '';
	    exec($zip_shell, $output, $status);

	    if ($status != 0) return ["status" => false, "output" => $output];

	    return ["status" => true, "output" => $tmp_dir.$zip_name];
	}
}

?>