<?php

	if (Input::exists()) {
		
		$val = new Validate(Db::get(), $config);
		$validate = $val->set(array(
			'email' => array(
				'reference' => $config->get('lang/inputs/provided_email'),
				'email' => true,
				'required' => true,
			),
			'password' => array(
				'reference' => $config->get('lang/inputs/provided_password'),
				'required' => true,
			)
		));
		
		if (isset($validate) && $validate->pass()) {
			$user = new User();
			$valid = $user->verify(Input::get('email'), Input::get('password'));
			if ($valid) {
				Redirect::go($config->get('nav/base'), 'home', $config->get('lang/general/you_loggedin'), 'success');
			}
		}
		
	}