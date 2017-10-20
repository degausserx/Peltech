<?php

session_start();

$figure = parse_ini_file('../shop/config/connect.ini', true);
$figure = $figure['root'];
$figure_http = (isset($figure['http'])) ? $figure['http'] : 'http://';
$figure_root = (isset($figure['custom']) && $figure['custom'] != null) ? $figure['custom'] : $_SERVER['DOCUMENT_ROOT'];

// class autoloader
spl_autoload_register(function($class) {
    require_once('../shop/classes/' . $class . '.class.php');
});

// instantiate config class, app settings
define("SITESALT", "jFnFwExf50fl2X0EU8VwmfIIsg5G");

$config = new Config(array(
	'nav' => array(
		'preurl' => $figure_http, // should be needed
		'base' => '/', // if working from main DIR, just '/'
		'page' => 'home', // start page, if nothing else found
		'page_default' => 'home' // fallback page
	),
	'site' => array(
		'default_language' => 'FR', // EN FR NL
		'folder_images' => 'images/games/', // no starting slash, but a trailing slash
		'folder_images_slider' => 'images/promos/', // no starting slash, but a trailing slash
		'root' => $figure_root,
		'back' => $figure['backend']
	)
));

$figure = null;

$config->put(array('site/base' => $config->get('nav/base')));

// variables
$params = function($path){
	$url = explode('/', filter_var(trim($path, '/'), FILTER_SANITIZE_URL));
	$url = str_replace(';//', '://', $url);
	$url = str_replace('&amp;', '&#038;', $url);
	$url = str_replace("'", '&#039;', $url);
	return $url;
};
$ice = function(&$params, $n = 0){ array_splice($params, $n, 1); };
$params = $params($_SERVER['REQUEST_URI']);

for ($x = 1; $x < substr_count($config->get('nav/base'), '/'); $x++) $ice($params);

// URL to link external files
$config->put(array('nav/baselang' => $config->get('nav/base')));
$config->put(array('nav/extlink' => $config->get('nav/preurl') . $_SERVER['SERVER_NAME'] . $config->get('nav/base')));

// arrange URL
$x = -1;
$url_params = null;
while ($x < 0 || isset($params[$x])) {
	
	// if its a language, add as language
	if (isset($params[0]) && $x == -1 && Languages::exists(strtoupper($params[0]))) {
		$config->put(array('site/lang' => strtoupper($params[0])));
		$config->put(array('nav/base' => $config->get('nav/base') . strtolower($config->get('site/lang')) . '/'));
		$ice($params);
		$x--;
		continue;
	}
	
	// if the page exists
    elseif ($x < 0) {
        $x = 0;
        if (isset($params[$x]) && $config->get('pages/' . $params[$x])) {
            $config->put(array('nav/page' => $params[$x]));
            $ice($params);
            continue;
        }
    }
	
	if (isset($params[$x]) && ($params[$x] == null || $params[$x] !== Input::clean($params[$x]))) $ice($params, $x);
	else {
		if (isset($params[$x])) { $url_params .= '/' . $params[$x]; }
		$x++;
	}
}

$config->put(array('nav/params' => $url_params));

// add page parameters
$config->add('params', $params);
$params = null;

// add user if logged in
$user = new User();
$logout = false;

if (Sessions::check('user_val')) {
	if ($user->logged()) {
		if (!$config->get('site/lang')) {
			if ($result = Db::get()->single("
				SELECT a.id as id, b.language as language
				FROM users a, languages b
				WHERE a.id = ? AND a.language = b.id
			",
			array(Sessions::check('user_id')))->result()) {
				$config->put(array('site/lang' => strtoupper($result['language'])));
			}
		}
		else {
			Db::get()->put('users', 'language', Languages::exists($config->get('site/lang')), 'id', Sessions::check('user_id'));
		}
	}
	else $logout = true;
}

if (!$config->get('site/lang')) {
	// obtain language using sessions
	if (Sessions::check('language')) {
		$config->put(array('site/lang' => strtoupper(Sessions::check('language'))));
	}
	// fallback on browser
	elseif (Languages::exists(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))) {
		$config->put(array('site/lang' => strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))));
	}
	else $config->put(array('site/lang' => strtoupper($config->get('site/default_language'))));
}

// get language file and add to config
require_once($config->get('site/back') . 'language/' . $config->get('site/lang') . '.php');
array_walk($lang, function(&$arr){
	if (!is_array($arr)) $arr = Input::clean($arr);
});
$config->add('lang', $lang);
$lang = null;

// add session
Sessions::add('language', $config->get('site/lang'));

// logout if true
if ($logout === true) $user->logout('home', $config->get('lang/general/youve_logged_out'));

// get date
date_default_timezone_set('Europe/Brussels');
$config->put(array('site/time' => date('Y-m-d H:i:s', time())));

// access
if ($user->logged() && $config->get('pages/' . $config->get('nav/page')) === 'guest') $config->put(array('nav/page' => 'home'));
elseif (!$user->logged() && $config->get('pages/' . $config->get('nav/page')) === 'user') $config->put(array('nav/page' => 'home'));
$config->put(array('nav/page_include' => $config->get('nav/page')));