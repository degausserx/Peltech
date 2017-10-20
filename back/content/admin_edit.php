<?php

	$counter = 0;
	
	$productinfo = $product->get();
	$producttext = $product->getext();

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<strong><?=$config->get('lang/items/edit_item');?> </strong>
		</h3>
	</div>
	<div class="panel-body">
		<form role="form" action="<?=$config->get('nav/base');?>admin/items/edit/<?=$productinfo['id'];?>" method="post" enctype="multipart/form-data">
			<?php if (isset($validate) && !empty($validate->errors())) $validate->error_list(); ?>
			<?php foreach($producttext as $key => $l) {
				if ($counter % 3 == 0) print '<div class="row">';
			?>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="title_<?=strtolower(Languages::exists($l->id_language, true));?>" id="title_<?=strtolower(Languages::exists($l->id_language, true));?>" class="form-control" placeholder="<?=$config->get('lang/items/title');?> (<?=strtoupper(Languages::exists($l->id_language, true));?>)" tabindex="<?=Display::tab();?>" value="<?=Input::clean($l->title);?>" required>
					</div>
				</div>
			<?php
				if (($counter + 1) % 3 == 0) print '</div>';
				$counter++;
			}
			if ($counter % 3 != 0) print '</div>';
			?>
			
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<select name="console" id="console" class="form-control" tabindex="<?=Display::tab();?>" required>
						<?php foreach (Datalist::console() as $row => $data) { ?>
							<option value="<?=$data->id;?>"<?php if ($data->id == Input::clean($productinfo['id_group'])) print ' selected'; ?>><?=$data->console;?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<select name="vendor" id="vendor" class="form-control" tabindex="<?=Display::tab();?>" required>
						<?php foreach (Datalist::vendor() as $row => $data) { ?>
							<option value="<?=$data->id;?>"<?php if ($data->id == Input::clean($productinfo['id_vendor'])) print ' selected'; ?>><?=$data->vendor;?></option>
						<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<select name="genre" id="genre" class="form-control" tabindex="<?=Display::tab();?>" required>
						<?php foreach (Datalist::genres() as $row => $data) { ?>
							<option value="<?=$data->id;?>"<?php if ($data->id == Input::clean($productinfo['id_genre'])) print ' selected'; ?>><?=$data->genre;?></option>
						<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<hr style="margin: 0 0 15px;" />
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-8">
					<div class="input-group">
						<label class="input-group-btn">
							<span class="btn btn-primary" tabindex="<?=Display::tab();?>">
								<?=$config->get('lang/buttons/browse');?> <input type="file" style="display: none;" name="file_image" id="file_image">
							</span>
						</label>
						<input type="text" class="form-control" placeholder="<?=$config->get('lang/items/new_item_image');?>" name="image" id="image" readonly>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="stock" id="stock" class="form-control " placeholder="<?=$config->get('lang/items/stock_number');?>" tabindex="<?=Display::tab();?>" value="<?=Input::clean($productinfo['stock']);?>" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-8">
					<div class="input-group">
						<label class="input-group-btn">
							<span class="btn btn-primary" tabindex="<?=Display::tab();?>">
								<?=$config->get('lang/buttons/browse');?> <input type="file" style="display: none;" name="file_image_large" id="file_image_large">
							</span>
						</label>
						<input type="text" class="form-control" placeholder="<?=$config->get('lang/items/new_item_image_slider');?>" name="image_large" id="image_large" readonly>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<div class="form-group">
						<input type="text" name="price" id="price" class="form-control " placeholder="<?=$config->get('lang/items/price_nn');?>" tabindex="<?=Display::tab();?>" value="<?=Input::clean($productinfo['price'] / 100);?>" required>
					</div>
				</div>
			</div>
			
			<?php foreach($producttext as $key => $l) { ?>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
						<textarea class="form-control" name="description_<?=strtolower(Languages::exists($l->id_language, true));?>" id="description_<?=strtolower(Languages::exists($l->id_language, true));?>" placeholder="<?=$config->get('lang/items/input_description');?> (<?=strtoupper(Languages::exists($l->id_language, true));?>)" tabindex="<?=Display::tab();?>"><?=Input::clean($l->description);?></textarea>
					</div>
				</div>
			</div>
			<?php } ?>
			
			<div class="row">
				<div class="col-md-12">
					<button type="submit" class="btn btn-success" tabindex="<?=Display::tab();?>"><?=$config->get('lang/buttons/update');?></button>
				</div>
			</div>
		</form>
	</div>
</div>