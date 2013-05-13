<?php
class Auth
{
    public static $user;
    public static $CURRENT_URL;

	public static function Initialize(){
        self::$CURRENT_URL = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	
		// change the following paths if necessary 
		$config   = 'hybridauth/config.php';
		require_once( "hybridauth/Hybrid/Auth.php" );

		try{
			$hybridauth = new Hybrid_Auth( $config );
		}
		catch( Exception $e ){
			echo "Ooophs, we got an error: " . $e->getMessage();
		}
		if( $_SESSION["loggedin"] === true && isset( $_GET["logout"] ) ){
			$provider = $_SESSION["provider"];
			$adapter = $hybridauth->getAdapter( $provider );
			$adapter->logout();
			$_SESSION["loggedin"] = false;
			setcookie("provider", "", time()-2592000, "/");
			setcookie("identifier", "", time()-2592000, "/");
			header( "Location: /"  );
			die();
		}else if ( $_SESSION["loggedin"] != true && isset( $_GET["connected_with"] ) && $hybridauth->isConnectedWith( $_GET["connected_with"] )  ){
			$provider = $_GET["connected_with"];
			$adapter = $hybridauth->getAdapter( $provider );
			$profile = $adapter->getUserProfile();
			$_SESSION["loggedin"] = true;
			$_SESSION["provider"] = $provider;
			$_SESSION["identifier"] = $profile->identifier;
			setcookie("provider", $provider, time()+2592000, "/");
			setcookie("identifier", $profile->identifier, time()+2592000, "/");
			header( "Location: /user/"  );
			die();
		}else if ( $_SESSION["loggedin"] != true && isset( $_COOKIE["provider"] ) && isset( $_COOKIE["identifier"] ) && self::$user = R::findOne("user", " provider=? AND identifier=?", array($_COOKIE["provider"], $_COOKIE["identifier"]))){
			$_SESSION["loggedin"] = true;
			$_SESSION["provider"] = $_COOKIE["provider"];
			$_SESSION["identifier"] = $_COOKIE["identifier"];
		}
		if ($_SESSION["loggedin"] === true){
			if (!self::$user){
				self::$user = R::findOne("user", " provider=? AND identifier=?", array($_SESSION["provider"], $_SESSION["identifier"]));
				if (!self::$user){	//If not found, create the user for the first time
					self::$user = R::dispense("user");
					self::$user->provider = $_SESSION["provider"];
					self::$user->identifier = $_SESSION["identifier"];
					self::$user->secret = rand(3461529, 9999999999);
					R::store(self::$user);
				}
			}
			setcookie("provider", self::$user->provider, time()+2592000, "/");
			setcookie("identifier", self::$user->identifier, time()+2592000, "/");
		}
    }
}
?>