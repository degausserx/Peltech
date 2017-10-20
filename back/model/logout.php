<?php

if ($user->logged()) {
	$user->logout($config->get('nav/base'), $config->get('lang/general/youve_logged_out'));
}