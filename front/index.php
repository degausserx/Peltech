<?php

// initialise
include('../shop/core/init.php');

// model
include($config->get('site/back') . 'model/' . $config->get('nav/page') . '.php');

//includes
include($config->get('site/back') . 'layout/head.php');
include($config->get('site/back') . 'layout/nav.php');
include($config->get('site/back') . 'content/' . $config->get('nav/page_include') . '.php');
include($config->get('site/back') . 'layout/foot.php');

// close dba_close
Db::get()->close();