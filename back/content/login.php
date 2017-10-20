<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<strong><?=$config->get('lang/general/login');?> </strong>
		</h3>
	</div>
	<div class="panel-body">
		<form role="form" action="<?=$config->get('nav/base');?>login" method="post">
		<?php
			if (Input::exists()) {
				if (!empty($validate->errors())) $validate->error_list();
				else print Display::clist('danger', array($config->get('lang/errors/bad_pass')));
			}
		?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="email" name="email" id="email" class="form-control " placeholder="<?=$config->get('lang/forms/email');?>" value="<?php print Input::getc('email'); ?>" tabindex="<?=Display::tab();?>" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="password" name="password" id="password" class="form-control " placeholder="<?=$config->get('lang/forms/password');?>" tabindex="<?=Display::tab();?>" required>
						<div class="help-block text-right">
							<?=$config->get('lang/general/forgot_password');?> <a href="<?=$config->get('nav/base');?>password_recover">
							<?=$config->get('lang/general/click_here');?> </a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="submit" class="btn btn-success" tabindex="<?=Display::tab();?>"><?=$config->get('lang/general/sign_in');?></button>
				</div>
			</div>
			<div class="input-group">
				<div class="checkbox">
					<label>
					  <input id="remember" type="checkbox" name="remember" tabindex="<?=Display::tab();?>"> <?=$config->get('lang/general/remember_me');?>
					</label>
				</div>
			</div>            
		</form>
	</div>
</div>