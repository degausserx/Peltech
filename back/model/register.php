<?php

	if (Input::exists()) {
		$val = new Validate(Db::get(), $config);
		$validate = $val->set(array(
			'first_name' => array(
				'reference' => $config->get('site/inputs/first'),
				'required' => true,
				'strmin' => 1,
				'strmax' => 20
			),
			'last_name' => array(
				'reference' => $config->get('site/inputs/last'),
				'required' => true,
				'strmin' => 1,
				'strmax' => 20
			),
			'display_name' => array(
				'reference' => $config->get('site/inputs/display'),
				'required' => true,
				'strmin' => 1,
				'strmax' => 20,
				'unique' => 'users'
			),
			'email' => array(
				'reference' => $config->get('site/inputs/email'),
				'required' => true,
				'strmin' => 7,
				'strmax' => 50,
				'unique' => 'users',
				'email' => true
			),
			'password' => array(
				'reference' => $config->get('site/inputs/password'),
				'required' => false,
				'strmin' => 6,
				'strmax' => 30
			),
			'password_confirmation' => array(
				'reference' => $config->get('site/inputs/mpassword'),
				'equals' => 'password',
			),
			'address' => array(
				'reference' => $config->get('site/inputs/address'),
				'required' => true,
				'strmin' => 5,
				'strmax' => 100
			),
			'postcode' => array(
				'reference' => $config->get('site/inputs/postcode'),
				'required' => true,
				'strmin' => 1,
				'strmax' => 15
			),
			'city' => array(
				'reference' => $config->get('site/inputs/city'),
				'required' => true,
				'strmin' => 1,
				'strmax' => 50
			),
			'county' => array(
				'reference' => $config->get('site/inputs/county'),
				'required' => false,
				'strmin' => 0,
				'strmax' => 50
			),
			'country' => array(
				'reference' => $config->get('site/inputs/country'),
				'required' => true,
				'strmin' => 1,
				'strmax' => 50
			)
		));
		
	}
	
	if (isset($validate) && $validate->pass()) {
		$salt = Hasher::salt();
		$langid = Languages::exists($config->get('site/lang'));
		$query = Db::get()->query(
			"INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
			array(
				null,
				Input::get('display_name'),
				Input::get('email'),
				Hasher::make(Input::get('password'), $salt),
				$salt,
				$config->get('site/time'),
				$config->get('site/time'),
				$langid,
				0
			)
		);
		
		if (!$query->error()) {
			$query = Db::get()->query(
				"INSERT INTO users_address VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
				array(
					null,
					Db::get()->getid(),
					Input::get('first_name'),
					Input::get('last_name'),
					Input::get('address'),
					Input::get('postcode'),
					Input::get('city'),
					Input::get('county'),
					Input::get('country')
				)
			);
		}
		
		if (!$query->error()) Redirect::go($config->get('nav/base'), 'home', $config->get('site/general/you_registered'), 'success');
	}

?>

