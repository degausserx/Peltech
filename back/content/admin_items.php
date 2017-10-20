<div class="row">
	<div class="col-md-12">
		<span>
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?=$config->get('lang/general/action');?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" id="admin_action">
					<li><a href="<?=$config->get('nav/base');?>admin/items/new"><?=$config->get('lang/items/new_item');?></a></li>
					<li id ="admin_action_delete"><a href="#"><?=$config->get('lang/items/delete_selected');?></a></li>
				</ul>
			</div>
		</span>
	</div>
</div>

<div class="table-responsive">
	<table class="table" data-click-to-select="true">
		<thead>
		  <tr>
			<th></th>
			<th></th>
			<th><?=$config->get('lang/tables/item');?></th>
			<th><?=$config->get('lang/tables/console');?></th>
			<th><?=$config->get('lang/tables/genre');?></th>
			<th><?=$config->get('lang/tables/price');?></th>
			<th><?=$config->get('lang/tables/stock');?></th>
			<th><?=$config->get('lang/tables/image');?></th>
		  </tr>
		</thead>
		<tbody>
			<form action="<?=$config->get('nav/base');?>admin" method="POST" id="admin_form">

<?php
	if (isset($item) && is_array($item->items())) {
		foreach ($item->items() as $key => $piece) {
			if ($piece->stock > 30) $color = 'success';
			else $color = ($piece->stock < 6) ? 'warning' : 'primary';
?>

		  <tr class="<?=$color;?>" data-id="<?=$piece->id;?>">
			<td><input type="checkbox" class="checkthis" id="check_<?=$piece->id;?>" name="check_<?=$piece->id;?>" /></td>
			<td><a href="<?=$config->get('nav/base');?>admin/items/edit/<?=$piece->id;?>"><?=$config->get('lang/general/edit');?></a></td>
			<td><a href="<?=$config->get('nav/base');?>shop/<?=$piece->category;?>/<?=$piece->id;?>"><?=Input::clean($piece->title);?></a></td>
			<td><a href="<?=$config->get('nav/base');?>shop/<?=$piece->category;?>"><?=Input::clean($piece->category);?></a></td>
			<td><?=Input::clean($piece->genre);?></td>
			<td>€<?=Input::clean($piece->price) / 100;?></td>
			<td><?=$piece->stock;?></td>
			<td><?php if ($piece->image) print '<a href="' . $config->get('nav/baselang') . $config->get('site/folder_images') . $piece->image . '">Image</a>'; ?></td>
		  </tr>

<?php
		}
	}
?>

			</form>
		</tbody>
	</table>
</div>