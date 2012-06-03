<?
global $Session;
$username = htmlspecialchars(get('username'),ENT_QUOTES);
$password = md5(get('password'));
$user_id = $DB->lookup('SELECT id FROM sec_users WHERE username="'. $username .'" AND password="'. $password .'" AND !disabled AND !deleted');
if($user_id) {
    echo "yes";
    $Session->set('user_id', $user_id);
} else {
	echo "no"; 
}