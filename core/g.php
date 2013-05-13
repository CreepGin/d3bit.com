<?php
class G
{
    public static $pageTitle = "D3Bit";
    public static $version = "10000";
    public static $CF_NAME = "";
    public static $CF_KEY = "";
    public static $templateName = "default";
    public static $controllerName = "home";
    public static $caching = false;
    public static $args = array();
    public static $table_columns = array();

    public static function GetColumnNames($table_name){
        if (array_key_exists($table_name, self::$table_columns)){
            return self::$table_columns[$table_name];
        }
        $names = Crud::GetColumnNames($table_name);
        self::$table_columns[$table_name] = $names;
        return $names;
    }

    public static function RenderView($name, $vars=null){
    	$file_path = "view/$name.tpl.php";
    	return G::GetOutput($file_path, $vars);
    }
    
    public static function GetOutput($file_path, $vars=null){
        if ($vars != null) {
            if (is_object($vars))
                $vars = get_object_vars($vars);
            extract($vars, EXTR_SKIP);
        }
        ob_start();
        include $file_path;
        $result = ob_get_clean();
        return $result;
    }

    public static function GetRows($sql, $values){
        $rows = R::getAll($sql, $values);
        $res = array();
        foreach ($rows as $row) {
            $res[] = (object)$row;
        }
        return $res;
    }
    
}
?>