<?php
G::$args = explode('/', $_SERVER['REQUEST_URI']);
array_shift(G::$args);
R::setup('mysql:host=d3bitdb;dbname=d3bit','sai','20000724');
R::freeze( true );
Auth::Initialize();
if (file_exists("settings.php"))
  require_once("settings.php");

if (file_exists("controller/" . G::$args[0] . ".php")){
  G::$controllerName = G::$args[0];
}
$controllerOutput = G::GetOutput("controller/" . G::$controllerName . ".php");
echo G::GetOutput("template/" . G::$templateName . ".tpl.php", array(
	"content" => $controllerOutput
));


//Functions
function __autoload($class_name) {
    //$lib_files = array_merge(listdir("core", "php"), listdir("controller", "php"));
    $lib_files = listdir("core", "php");
    $file = strtolower($class_name) . '.php';
    $keys = array_keys($lib_files);
    if (in_array($file, $keys)){
        require_once $_SERVER['DOCUMENT_ROOT']. '/' . $lib_files[$file];
    }
}

function listdir($dir='.', $ext=false) { 
    if (!is_dir($dir)) { 
        return false; 
    } 
    
    $files = array(); 
    listdiraux($dir, $files, $ext); 

    return $files; 
} 

function listdiraux($dir, &$files, $ext=false) { 
    $handle = opendir($dir); 
    while (($file = readdir($handle)) !== false) { 
        if ($file == '.' || $file == '..') { 
          continue; 
        } 
        $filepath = $dir == '.' ? $file : $dir . '/' . $file; 
        if (is_link($filepath)) 
          continue; 
        if (is_file($filepath)) {
          if ($ext!=false){
            $extension = end(explode('.',$filepath));
            if ($extension == $ext)
              $files[$file] = $filepath; 
            continue;
          } 
          $files[] = $filepath; 
        }else if (is_dir($filepath)) {
          listdiraux($filepath, $files, $ext); 
        }
          
    } 
    closedir($handle); 
}
?>