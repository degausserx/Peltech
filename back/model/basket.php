<?php

	if (Input::get('id_cart') && Db::get()->single("SELECT id FROM items WHERE id = ?", array(Input::get('id_cart')))->track() > 0) {
		$basket = new Basket(Db::get(), $config, Sessions::check('user_id'));
		$quantity = (Input::get('quantity')) ? Input::get('quantity') : 1;
		$basket->setbase($config->get('nav/base'));
		$basket->add(Input::get('id_cart'), $quantity);
		$basket->populate();
	}
	else {
		$basket = new Basket(Db::get(), $config, Sessions::check('user_id'));
		$basket->populate();
	}