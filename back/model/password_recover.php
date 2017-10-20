<?php

	if (Input::exists()) {
		$val = new Validate(Db::get());
		$validate = $val->set(array(
			'email' => array(
				'reference' => $config->get('lang/inputs/provided_email'),
				'required' => true,
				'strmin' => 1,
				'strmax' => 50
			)
		));
		
		if (isset($validate) && $validate->pass()) {
			
			// check db for matching email, send message to generate new pasword or w/e.
			// not a priority for project
			
			Redirect::go($config->get('nav/base'), 'home', $config->get('lang/general/password_recovery_success'), 'warning');
		}
	}