<?php

// check sort options

if ($result = Db::get()->query("
	SELECT id
	FROM groups_items
	WHERE category = ?
", array($config->get('params/0')))->result()) {
	$item = new Items(Db::get(), $config->get('site/lang'), $result[0]->id);
	$product = new Product(Db::get(), $config->get('site/lang'), $config->get('params/1'));
	if ($config->get('params/1') && $product->exists()) {
		$config->put(array('nav/page_include' => 'item'));
	}
}
else $item = new Items(Db::get(), $config->get('site/lang'), 0, true);