<div class="table-responsive">
	<table class="table" data-click-to-select="true">
		<thead>
		  <tr>
			<th></th>
			<th><?=$config->get('lang/tables/name');?></th>
			<th><?=$config->get('lang/tables/display');?></th>
			<th><?=$config->get('lang/tables/email');?></th>
			<th><?=$config->get('lang/tables/registered');?></th>
			<th><?=$config->get('lang/tables/language');?></th>
			<th><?=$config->get('lang/tables/admin');?></th>
		  </tr>
		</thead>
		<tbody>
			<form action="<?=$config->get('nav/base');?>admin" method="POST" id="admin_form">

<?php

	$users = Db::get()->query("
		SELECT a.id, a.display_name, a.email, a.date_registered, a.language, a.admin, b.first_name, b.last_name
		FROM users AS a, users_address AS b
		WHERE a.id = b.user_id
	", array())->result();

	if (isset($users) && is_array($users)) {
		foreach ($users as $key => $piece) {
			$color = ($piece->admin == true) ? 'success' : 'primary';
			$admin = ($piece->admin == true) ? 'Admin' : 'User';
?>

		  <tr class="<?=$color;?>" data-id="<?=$piece->id;?>">
			<td><?=$piece->id;?></td>
			<td><?=Input::clean($piece->first_name . ' ' . $piece->last_name);?></td>
			<td><?=Input::clean($piece->display_name);?></td>
			<td><?=Input::clean($piece->email);?></td>
			<td><?=Input::clean($piece->date_registered);?></td>
			<td><?=$config->get('lang/lang/' . Languages::exists($piece->language, true));?></td>
			<td><?=Input::clean($admin);?></td>
		  </tr>

<?php
		}
	}
?>

			</form>
		</tbody>
	</table>
</div>