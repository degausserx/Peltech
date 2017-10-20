<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<strong><?=$config->get('lang/general/profile');?> </strong>
		</h3>
	</div>
	<div class="panel-body">
		<form role="form" action="<?=$config->get('nav/base');?>profile" method="post">
			<?php if (isset($validate) && !empty($validate->errors())) $validate->error_list(); ?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="text" name="first_name" id="first_name" class="form-control" placeholder="<?=$config->get('lang/forms/first_name');?>" tabindex="<?=Display::tab();?>" value="<?=Input::clean($user->get_profile()['first_name']);?>" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="text" name="last_name" id="last_name" class="form-control " placeholder="<?=$config->get('lang/forms/last_name');?>" tabindex="<?=Display::tab();?>" value="<?=Input::clean($user->get_profile()['last_name']);?>" required>
					</div>
				</div>
			</div>
			<hr style="margin: 0 0 15px;" />
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-8">
					<div class="form-group">
						<input type="text" name="address" id="address" class="form-control" placeholder="<?=$config->get('lang/forms/address');?>" tabindex="<?=Display::tab();?>" value="<?=Input::clean($user->get_profile()['address']);?>" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="postcode" id="postcode" class="form-control " placeholder="<?=$config->get('lang/forms/postcode');?>" tabindex="<?=Display::tab();?>" value="<?=Input::clean($user->get_profile()['postcode']);?>" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="city" id="city" class="form-control" placeholder="<?=$config->get('lang/forms/city');?>" tabindex="<?=Display::tab();?>" value="<?=Input::clean($user->get_profile()['city']);?>" required>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="county" id="county" class="form-control" placeholder="<?=$config->get('lang/forms/county');?>" tabindex="<?=Display::tab();?>" value="<?=Input::clean($user->get_profile()['county']);?>">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="country" id="country" class="form-control" placeholder="<?=$config->get('lang/forms/country');?>" tabindex="<?=Display::tab();?>" value="<?=Input::clean($user->get_profile()['country']);?>" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="password" name="password" id="password" class="form-control " placeholder="<?=$config->get('lang/forms/password_new');?>" tabindex="<?=Display::tab();?>">
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="password" name="password_confirmation" id="password_confirmation" class="form-control " placeholder="<?=$config->get('lang/forms/password_new_confirm');?>" tabindex="<?=Display::tab();?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="submit" class="btn btn-success" tabindex="<?=Display::tab();?>"><?=$config->get('lang/buttons/update');?></button>
				</div>
			</div>
		</form>
	</div>
</div>
