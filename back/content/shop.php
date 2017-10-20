<form action="<?=$config->get('nav/base');?>shop<?=$config->get('nav/params');?>" method="POST">
	<div class="row">
		<div class="col-md-12">
			<span>
				<div class="form-group col-sm-4">
					<label for="sortby"><?=$config->get('lang/forms/sort_by');?> </label>
					<select class="form-control" name="sortby" onchange="this.form.submit()">
						<option value="rating"<?php print (Input::get('sortby') == 'rating') ? ' selected' : '';?>><?=$config->get('lang/forms/by_rating');?></option>
						<option value="price"<?php print (Input::get('sortby') == 'price') ? ' selected' : '';?>><?=$config->get('lang/forms/by_price');?></option>
						<option value="timestamp"<?php print (Input::get('sortby') == 'timestamp') ? ' selected' : '';?>><?=$config->get('lang/forms/by_newest');?></option>
					</select>
				</div>
			</span>
			<span>		
				<div class="form-group col-sm-4">
					<label for="sortby"><?=$config->get('lang/forms/order_by');?> </label>
					<select class="form-control" name="orderby" onchange="this.form.submit()">
						<option value="desc"<?php print (Input::get('orderby') == 'desc') ? ' selected' : '';?>><?=$config->get('lang/forms/by_desc');?></option>
						<option value="asc"<?php print (Input::get('orderby') == 'asc') ? ' selected' : '';?>><?=$config->get('lang/forms/by_asc');?></option>
					</select>
				</div>
			</span>
		</div>
	</div>
</form>

<hr>
 
	<?php
	
	if (isset($item) && is_array($item->items())) {
		foreach ($item->items() as $key => $piece) {
			if ($key % 3 === 0) {  print '<div class="row">'; };

?>
	<div class="col-sm-4 col-lg-4 col-md-4">
		<div class="thumbnail">
			<img src="<?=$config->get('nav/baselang') . $config->get('site/folder_images') . $piece->image;?>" alt="">
			<div class="caption">
				<h4 class="pull-right">€<?=Input::clean($piece->price) / 100;?></h4>
				<h4><a href="<?=$config->get('nav/base');?>shop/<?=$piece->category;?>/<?=$piece->id;?>"><?=Input::clean($piece->title);?></a>
				</h4>
				<p><?=Input::clean($piece->description);?></p>
			</div>
			<div class="ratings">
				<p>
					<?=$item->rating($piece->rating);?>
				</p>
			</div>
		</div>
	</div>	
	<?php
	if ($key % 3 === 2) { print '</div>'; }
	} }
	?>
 
</div>