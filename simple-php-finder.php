<?php
$path_to_check = './yuki/';
if(isset($_REQUEST['path_to_check'])){
	if(!empty($_REQUEST['path_to_check'])) $path_to_check = $_REQUEST['path_to_check'];
}
$needle = 'base64_decode';
if(isset($_REQUEST['needle'])){
	if(!empty($_REQUEST['needle'])) $needle = $_REQUEST['needle'];
}

echo '<h3>Search on: <u>'.$path_to_check.'</u></h3>';
echo '<form name="fw" method="post" action="'.$_SERVER['php_self'].'"><input type="text" name="needle" placeholder="keywordnya" value="'.$needle.'" /><br><input type="text" name="path_to_check" placeholder="Path nya.. ./wp-admin/" value="'.$path_to_check.'" /><br /><input type="submit" value="cari" /></form><hr />';


function getDirContents($dir,$needle="",&$results = array()){
    $files = scandir($dir);
    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
					$results[] = $path;
					$file_parts = pathinfo($path);
					if(strtolower($file_parts['extension'])=="php"){
						foreach(file($path) as $fli=>$fl){
							if(strpos($fl, $needle)!==false){
								echo '<b>'.$path . ' on line ' . ($fli+1) . ':</b><hr /><pre>' . $fl . '</pre><hr /><br />';
							}
						}
					}
        } else if($value != "." && $value != "..") {
            getDirContents($path,$needle, $results);
            $results[] = $path;
        }
    }

    return $results;
}
if(strlen($needle)>0) getDirContents($path_to_check,$needle);

/*
foreach(glob($path . '*.php') as $filename){
	foreach(file($filename) as $fli=>$fl){
							if(strpos($fl, $needle)!==false){
								echo '<b>'.$filename . ' on line ' . ($fli+1) . ':</b><hr /><pre>' . $fl . '</pre><hr /><br />';
							}
						}
					}
*/