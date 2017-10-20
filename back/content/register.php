<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<strong><?=$config->get('lang/general/register');?> </strong>
		</h3>
	</div>
	<div class="panel-body">
		<form role="form" action="<?=$config->get('nav/base');?>register" method="post">
			<?php if (isset($validate) && !empty($validate->errors())) $validate->error_list(); ?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="text" name="first_name" id="first_name" class="form-control" placeholder="<?=$config->get('lang/forms/first_name');?>" tabindex="<?=Display::tab();?>" value="<?=Input::getc('first_name');?>" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="text" name="last_name" id="last_name" class="form-control " placeholder="<?=$config->get('lang/forms/last_name');?>" tabindex="<?=Display::tab();?>" value="<?=Input::getc('last_name');?>" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="text" name="display_name" id="display_name" class="form-control " placeholder="<?=$config->get('lang/forms/display_name');?>" tabindex="<?=Display::tab();?>" value="<?=Input::getc('display_name');?>" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="email" name="email" id="email" class="form-control " placeholder="<?=$config->get('lang/forms/email');?>" tabindex="<?=Display::tab();?>" value="<?=Input::getc('email');?>" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="password" name="password" id="password" class="form-control " placeholder="<?=$config->get('lang/forms/password');?>" tabindex="<?=Display::tab();?>" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="password" name="password_confirmation" id="password_confirmation" class="form-control " placeholder="<?=$config->get('lang/forms/password_confirm');?>" tabindex="<?=Display::tab();?>" required>
					</div>
				</div>
			</div>
			<hr style="margin: 0 0 15px;" />
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-8">
					<div class="form-group">
						<input type="text" name="address" id="address" class="form-control" placeholder="<?=$config->get('lang/forms/address');?>" tabindex="<?=Display::tab();?>" value="<?=Input::getc('address');?>" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="postcode" id="postcode" class="form-control " placeholder="<?=$config->get('lang/forms/postcode');?>" tabindex="<?=Display::tab();?>" value="<?=Input::getc('postcode');?>" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="city" id="city" class="form-control" placeholder="<?=$config->get('lang/forms/city');?>" tabindex="<?=Display::tab();?>" value="<?=Input::getc('city');?>" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="county" id="county" class="form-control" placeholder="<?=$config->get('lang/forms/county');?>" tabindex="<?=Display::tab();?>" value="<?=Input::getc('county');?>">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="country" id="country" class="form-control" placeholder="<?=$config->get('lang/forms/country');?>" tabindex="<?=Display::tab();?>" value="<?=Input::getc('country');?>" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="submit" class="btn btn-success" tabindex="<?=Display::tab();?>"><?=$config->get('lang/general/submit');?></button>
				</div>
			</div>
			<div class="form-group">    
				<div style="font-size: 85%; padding-top: 10px;">
					<?=$config->get('lang/general/account_already');?> <a href="<?=$config->get('nav/base');?>login">
					<?=$config->get('lang/general/login_here');?> </a>
				</div>
			</div>
		</form>
	</div>
</div>