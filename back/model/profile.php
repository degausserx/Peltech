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
	
	if (isset($validate)) {
		$val = [];

		$query = 'UPDATE users_address SET ';
		if ($validate->get('first_name')) { $query .= 'first_name = ?, '; $val[] = Input::get('first_name'); }
		if ($validate->get('last_name')) { $query .= 'last_name = ?, '; $val[] = Input::get('last_name'); }
		if ($validate->get('address')) { $query .= 'address = ?, '; $val[] = Input::get('address'); }
		if ($validate->get('postcode')) { $query .= 'postcode = ?, '; $val[] = Input::get('postcode'); }
		if ($validate->get('city')) { $query .= 'city = ?, '; $val[] = Input::get('city'); }
		if ($validate->get('county')) { $query .= 'county = ?, '; $val[] = Input::get('county'); }
		if ($validate->get('country')) { $query .= 'country = ?, '; $val[] = Input::get('country'); }
		$val[] = Sessions::check('user_id');
		$query = substr($query, 0, -2);
		$query .= ' WHERE user_id = ?';
		
		Db::get()->query($query, $val);
		
		if ($validate->get('password') && $validate->get('password_confirmation')) {
			$query = "UPDATE users SET password = ?, salt = ? WHERE id = ?";
			$salt = Hasher::salt();
			Db::get()->query($query, array(Hasher::make(Input::get('password'), $salt), $salt, Sessions::check('user_id')));
		} 
	}