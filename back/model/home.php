<?php

	$item_slider = new Items(Db::get(), $config->get('site/lang'));
	$item = new Items(Db::get(), $config->get('site/lang'), 0);