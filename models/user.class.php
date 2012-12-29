<?php
class User extends DatabaseModel
{

	public $id;
	public $username;
	public $password;
	public $email;
	public $subscribed;
	public $lastlogin;
	public $firstname;
	public $lastname;
	public $dob;
	public $avator;
	public $facebook;
	public $twitter;
	public $icq;
	public $googleplus;
	public $skype;
	public $gender;
	public $country;
	public $status;
	public $phone;
	public $privilege;
	public $secretquestion;
	public $secretanswer;
	public $activation;
	public $acttime;
	public $publicview;

	protected $tableName = 'users';
	protected $fields = array("username", "password", "email", "subscribed", "lastlogin",
					"firstname", "lastname", "dob", "avator", "facebook", "twitter", "icq",
					"googleplus", "skype", "gender", "country", "status", "phone", "privilege",
					"secretquestion", "secretanswer", "activation", "acttime", "publicview");
	
	public static function userExists($username)
	{
	    $sql = "SELECT * FROM users WHERE username = '" . $username . "' LIMIT 1";
	    $userFound =  User::read($sql);
	    return ($userFound) ? true : false;
	}
	
	public static function activate($activation)
	{
	    $today = date('Y-m-d');
	    $sql = "SELECT * FROM users WHERE activation = '" . $activation . "' AND acttime >= '" . $today . "'";
	    $foundUser = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
	    if($foundUser) {
	        $foundUser->status = 1;
	        $foundUser->activation = '';
	        $foundUser->acttime = '';
	        $foundUser->save();
	        return true;
	    }
	    return false;
	}
	
	public static function authenticate()
	{
		if (isset($_POST['login'])) {
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			$sql = "SELECT * FROM users WHERE username = '" . $username . "' AND password = '" . $password . "' LIMIT 1";
			$foundUser = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
			if($foundUser) {
				$_SESSION['loggedIn'] = true;
				$_SESSION['user'] = $foundUser;
				$foundUser->lastlogin = date('Y-m-d H:i:s');
				$foundUser->save();
				if(isset($_POST['remember'])) {
					if(!isset($_COOKIE['username']) && !isset($_COOKIE['password'])) {
						$expire = 3 * 30 * 24 * 60 * 60 + time();
						setcookie('username', $username, $expire);
						setcookie('password', $_POST['password'], $expire);
					}
				} else {
					setcookie('username', '', time() - 1000);
					setcookie('password', '', time() - 1000);
				}
				header("Location: /");
			}
			return false;
		}
	}
	
	public static function theUser()
	{
	    return (isset($_SESSION['user'])) ? $_SESSION['user'] : new self();
	}
	
	public static function isLoggedIn()
	{
		return (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) ? true : false;
	}
	
	public function isAdmin()
	{
	    return $this->privilege == 1 ? true : false;
	}
}