<?php
class Util {

  public static function IsPInt($str){  //Test if str is a positive integer
    $str = strval($str);
    return isset($str) && ctype_digit($str) && (int)$str > 0;
  }
    
	public static function HasValue($v, &$out = null){
        if (!isset($v))
          return false;
        if ((is_array($v) && count($v) > 0) || (is_bool($v) && $v == true) || (is_int($v) || is_float($v)) || (is_string($v) && strlen(trim($v))>0)){
          $out = $v;
          return true;
        }
        return false;
    }

    public static function HasValues(array $request, array $names = array(), &$out = null){
        foreach ($names as $n){
            if (!self::HasValue($request[$n]))
                return false;
        }
        $out = (object)$request;
        return true;
    }

    public static function FromSet($needle, $set=array(), $default=""){
      if (in_array($needle, $set))
        return $needle;
      if ($default=="" && count($set)>0)
        return $set[0];
      return $default;
    }

    static $EncodeOffset = 12345;
    public static function EncodeId($id){
      $id += self::$EncodeOffset;
      return base_convert($id, 10, 36);
    }
    
    public static function DecodeId($code){
      $id = (int)base_convert($code, 36, 10);
      $id -= self::$EncodeOffset;
      return $id;
    }

    public static function IsValidBattleTag($str){
        $res = preg_match("/^[a-zA-Z0-9]{3,16}$/", $str);
        return $res == 1;
    }

    public static function IsValidPassword($str){
        $res = preg_match("/^.{8,16}$/", $str);
        return $res == 1;
    }

    public static function IsValidEmail($str){
        if (strlen($str) > 128)
            return false;
        if (strstr($str, "@twitter.com"))
            return false;
        return preg_match("/^[a-zA-Z0-9\\._-]{2,64}@[a-zA-Z0-9\\._-]{2,64}$/i",$str);
    }
    
    public static function HtmlEntities($text){
        return htmlentities($text, ENT_COMPAT, "UTF-8");
    }

    public static function SanitizeForUrl($text){
      $saned_title = str_replace("/", "", $text); 
      $saned_title = str_replace(" ", "-", $saned_title);
      $saned_title = str_replace("%", "", $saned_title);
      $saned_title = str_replace("&", "", $saned_title);
      $saned_title = str_replace("?", "", $saned_title);
      $saned_title = str_replace("\"", "", $saned_title);
      $saned_title = str_replace("\'", "", $saned_title);
      return mb_strtolower($saned_title, "UTF-8");
    }

    public static function PrettyJsonEncode($json_obj){
        $tab = "  "; 
        $new_json = ""; 
        $indent_level = 0; 
        $in_string = false;
        if($json_obj === false) 
            return false; 
        $json = json_encode($json_obj); 
        $len = strlen($json); 

        for($c = 0; $c < $len; $c++){ 
            $char = $json[$c]; 
            switch($char) { 
                case '{': 
                case '[': 
                    if(!$in_string) { 
                        $new_json .= $char . "\n" . str_repeat($tab, $indent_level+1); 
                        $indent_level++; 
                    }else { 
                        $new_json .= $char; 
                    } 
                    break; 
                case '}': 
                case ']': 
                    if(!$in_string) { 
                        $indent_level--; 
                        $new_json .= "\n" . str_repeat($tab, $indent_level) . $char; 
                    }else{ 
                        $new_json .= $char; 
                    } 
                    break; 
                case ',': 
                    if(!$in_string) { 
                        $new_json .= ",\n" . str_repeat($tab, $indent_level); 
                    }else{ 
                        $new_json .= $char; 
                    } 
                    break; 
                case ':': 
                    if(!$in_string){ 
                        $new_json .= ": "; 
                    } else { 
                        $new_json .= $char; 
                    } 
                    break; 
                case '"': 
                    if($c > 0 && $json[$c-1] != '\\') { 
                        $in_string = !$in_string; 
                    } 
                default: 
                    $new_json .= $char; 
                    break;                    
            } 
        } 

        return $new_json; 
    }
    
}
?>