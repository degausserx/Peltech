<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<strong><?=$config->get('lang/general/password_recovery');?> </strong>
		</h3>
	</div>
	<div class="panel-body">
		<form role="form" action="<?php print $config->get('nav/base'); ?>password_recover" method="post">
		<?php if (Input::exists() && isset($validate)) { 
			if (!empty($validate->errors())) { $validate->error_list(); }
		}
		?>
			<div class="alert alert-info">
				<a class="close" data-dismiss="alert" href="#">×</a><?=$config->get('lang/general/password_recovery_instruct');?>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="email" name="email" id="email" class="form-control " placeholder="<?=$config->get('lang/forms/email');?>" value="<?php print Input::getc('email'); ?>" tabindex="<?=Display::tab();?>" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="submit" class="btn btn-success" tabindex="<?=Display::tab();?>"><?=$config->get('lang/buttons/send');?></button>
				</div>
			</div>        
		</form>
	</div>
</div>