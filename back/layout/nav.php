<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav_collapse">
                <span class="sr-only"><?=$config->get('lang/nav/toggle');?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=$config->get('nav/base');?>">Peltech</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-right" id="nav_collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-blackboard"></span>
                        <?=$config->get('lang/lang/' . $config->get('site/lang'));?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=$config->get('nav/baselang') . 'fr/' . $config->get('nav/page') . $config->get('nav/params');?>"><?=$config->get('lang/lang/FR');?></a></li>
                        <li><a href="<?=$config->get('nav/baselang') . 'nl/' . $config->get('nav/page') . $config->get('nav/params');?>"><?=$config->get('lang/lang/NL');?></a></li>
                        <li><a href="<?=$config->get('nav/baselang') . 'en/' . $config->get('nav/page') . $config->get('nav/params');?>"><?=$config->get('lang/lang/EN');?></a></li>
                    </ul>
                </li>
					<?php
					if ($user->admin()) { ?>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<span class="glyphicon glyphicon-lock"></span>
								<?=$config->get('lang/nav/admin');?> <span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="<?=$config->get('nav/base');?>admin/users"><span class="glyphicon glyphicon-flash"></span> <?=$config->get('lang/nav/users');?></a></li>
								<li><a href="<?=$config->get('nav/base');?>admin/items"><span class="glyphicon glyphicon-transfer"></span> <?=$config->get('lang/nav/items');?></a></li>
							</ul>
						</li>
					<?php } ?>
						<li>
							<a href="<?=$config->get('nav/base');?>basket"><span class="glyphicon glyphicon-lock"></span> <?=$config->get('lang/nav/basket');?></a>
						</li>
                <li>
						<?php
						if (!$user->logged()) { ?>
						<a href="<?=$config->get('nav/base');?>register"><span class="glyphicon glyphicon-user"></span> <?=$config->get('lang/general/register');?></a>
						<?php } else { ?>
						<a href="<?=$config->get('nav/base');?>profile"><span class="glyphicon glyphicon-user"></span> <?=$config->get('lang/general/profile');?></a>
						<?php } 
					?>
                </li>
					<?php
						if (!$user->logged()) { ?>

                <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-log-in"></span> <?=$config->get('lang/general/login');?> <span class="caret"></span>
					</a>
                    <ul id="login-dp" class="dropdown-menu">
                        <li>
                            <div class="row">
                                    <div class="col-md-12">
                                        <div class="help-block text-top"><?=$config->get('lang/general/no_account');?> <a href="<?=$config->get('nav/base');?>register"><b><?=$config->get('lang/general/join_us');?></b></a></div>
                                        <form class="form" action="<?=$config->get('nav/base');?>login" method="post">
                                            <div class="form-group">
                                                <label class="sr-only" for="login_email"><?=$config->get('lang/forms/email');?></label>
                                                <input type="email" class="form-control" placeholder="<?=$config->get('lang/forms/email');?>" id="login_email" name="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="login_password"><?=$config->get('lang/forms/password');?></label>
                                                <input type="password" class="form-control" placeholder="<?=$config->get('lang/forms/password');?>" id="login_password" name="password" required>
                                                <div class="help-block text-right"><a href="<?=$config->get('nav/base');?>password_recover"><?=$config->get('lang/general/forgot_password');?></a></div>
                                            </div>
                                            <div class="form-group">
                                                 <button type="submit" class="btn btn-primary btn-block"><?=$config->get('lang/general/sign_in');?></button>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="login_remember" name="remember"> <?=$config->get('lang/general/remember_me');?>
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                            </div>
                        </li>
                    </ul>
                </li>
					<?php } else { ?>
				<li>
					<a href="<?=$config->get('nav/base');?>logout"><span class="glyphicon glyphicon-user"></span> <?=$config->get('lang/general/logout');?></a>
				</li>
					<?php }
					?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
 
<!-- Page Content -->
<div class="container">
	  
	<?php
	if (!$config->get('pages_nav/' . $config->get('nav/page'))) {
		print '<ul class="nav nav-pills nav-colorful">';
		foreach(Datalist::console() as $k => $v) {
			if ($config->get('params/0') == $v->category) print '<li><a href="#" class="bg-primary"> ' . strtoupper($v->category) . '</a></li>';
			else print '<li><a href="' . $config->get('nav/base') . 'shop/' . $v->category . '"> ' . strtoupper($v->category) . '</a></li>';
		}
		print '</ul>';
	}
	?>

	<div class="row">
		<div class="col-md-12">
			<?=Redirect::check();?>
		</div>
	</div>
 
    <div class="row">
 
        <div class="col-md-12">