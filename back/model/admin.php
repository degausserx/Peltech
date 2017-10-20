<?php

	if (!$user->admin()) {
		$config->put(array('nav/page_include' => 'home'));
		include($config->get('site/back') . '/model/' . $config->get('nav/page_default') . '.php');
	}
	
	else {
		if ($config->get('params/0') == 'items') {
			
			if ($config->get('params/1') == 'new') {
				// similar to edit, but we just want to use a fresh page
				// make arrays to hold genre + console
				
				if (Input::exists()) {
					// verify input
					// if valid, go to main admin page
					// $item = new Items(Db::get(), $config->get('site/lang'), 0, true);
					$validate_array = array(
						'stock' => array(
							'reference' => $config->get('lang/inputs/stock'),
							'required' => true,
							'min' => 0,
							'max' => 100000,
							'integer' => true
						),
						'price' => array(
							'reference' => $config->get('lang/inputs/price'),
							'required' => true,
							'min' => 0,
							'max' => 100000,
							'decimal' => true
						),
						'genre' => array(
							'reference' => $config->get('lang/inputs/genre'),
							'required' => true,
							'exists' => 'items_genre',
							'search' => 'id'
						),
						'vendor' => array(
							'reference' => $config->get('lang/inputs/vendor'),
							'required' => true,
							'exists' => 'items_vendor',
							'search' => 'id'
						),
						'console' => array(
							'reference' => $config->get('lang/inputs/console'),
							'required' => true,
							'exists' => 'groups_items',
							'search' => 'id'
						)
					);
					
					// get names

					foreach(Languages::llist() as $l) {
						$validate_array['title_' . $l] = array(
							'reference' => $config->get('lang/inputs/title') . '(' . strtoupper($l) . ')',
							'required' => true,
							'strmin' => 1,
							'strmax' => 150
						);
						
						$validate_array['description_' . $l] = array(
							'reference' => $config->get('lang/inputs/description') . '(' . strtoupper($l) . ')',
							'required' => false,
							'strmin' => 1,
							'strmax' => 2000
						);
					}
					
					if (Input::get('image') && is_uploaded_file(Input::get('file_image', 'tmp_name')) && !Input::get('file_image', 'error')) {
						$validate_array['image'] = array(
							'reference' => $config->get('lang/inputs/image'),
							'image' => $_SERVER['DOCUMENT_ROOT'] . $config->get('site/base') . $config->get('site/folder_images') . Input::get('image'),
							'object' => Input::get('file_image')
						);
					}
					if (Input::get('image_large') && is_uploaded_file(Input::get('file_image_large', 'tmp_name')) && !Input::get('file_image_large', 'error')) {
						$validate_array['image_large'] = array(
							'reference' => $config->get('lang/inputs/sliding_image'),
							'image' => $_SERVER['DOCUMENT_ROOT'] . $config->get('site/base') . $config->get('site/folder_images_slider') . Input::get('image_large'),
							'object' => Input::get('file_image_large')
						);
					}
					
					$val = new Validate(Db::get(), $config);
					$validate = $val->set($validate_array);			
					if (isset($validate) && $validate->pass()) {
						
						$query = Db::get()->query(
							"INSERT INTO items VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
							array(
								null,
								Input::get('vendor'),
								Input::get('console'),
								Input::get('genre'),
								Input::get('stock'),
								Input::get('file_image', 'name'),
								Input::get('file_image_large', 'name'),
								Input::get('price') * 100,
								0,
								$config->get('site/time')
							)
						);
						
						if (!$query->error()) {
							$new_id = Db::get()->getid();
							foreach(Languages::llist() as $l) {
								$query = Db::get()->query(
									"INSERT INTO items_text VALUES (?, ?, ?, ?, ?)",
									array(
										null,
										$new_id,
										Languages::exists($l),
										Input::get('title_' . $l),
										Input::get('description_' . $l)
									)
								);
							}
							
							if (!$query->error()) {
							
								if ($validate->get('image')) {
									$image_path = $_SERVER['DOCUMENT_ROOT'] . $config->get('site/base') . $config->get('site/folder_images') . Input::get('image');
									move_uploaded_file(Input::get('file_image', 'tmp_name'), $image_path);
								}
								
								if ($validate->get('image_large')) {
									$image_path = $_SERVER['DOCUMENT_ROOT'] . $config->get('site/base') . $config->get('site/folder_images_slider') . Input::get('image_large');
									move_uploaded_file(Input::get('file_image_large', 'tmp_name'), $image_path);
								}
								
								// redirect
								Redirect::go($config->get('nav/base'), 'admin/items', str_replace('%s%', $new_id, $config->get('lang/general/item_added')), 'success');
							
							}
						}
					}
				}
				
				$config->put(array('nav/page_include' => 'admin_new'));
			}

			elseif ($config->get('params/1') == 'edit' && Db::get()->single("SELECT id FROM items WHERE id = ?", array($config->get('params/2')))->track() > 0) {
				
				if (Input::exists()) {
					// big update here. 
					$validate_array = array(
						'stock' => array(
							'reference' => $config->get('lang/inputs/stock'),
							'required' => true,
							'min' => 0,
							'max' => 100000,
							'integer' => true
						),
						'price' => array(
							'reference' => $config->get('lang/inputs/price'),
							'required' => true,
							'min' => 0,
							'max' => 100000,
							'decimal' => true
						),
						'genre' => array(
							'reference' => $config->get('lang/inputs/genre'),
							'required' => true,
							'exists' => 'items_genre',
							'search' => 'id'
						),
						'vendor' => array(
							'reference' => $config->get('lang/inputs/vendor'),
							'required' => true,
							'exists' => 'items_vendor',
							'search' => 'id'
						),
						'console' => array(
							'reference' => $config->get('lang/inputs/publisher'),
							'required' => true,
							'exists' => 'groups_items',
							'search' => 'id'
						)
					);
					
					// get names

					foreach(Languages::llist() as $l) {
						$validate_array['title_' . $l] = array(
							'reference' => $config->get('lang/inputs/title') . '(' . strtoupper($l) . ')',
							'required' => true,
							'strmin' => 1,
							'strmax' => 150
						);
						
						$validate_array['description_' . $l] = array(
							'reference' => $config->get('lang/inputs/description') . '(' . strtoupper($l) . ')',
							'required' => false,
							'strmin' => 1,
							'strmax' => 2000
						);
					}
					
					if (Input::get('image') && is_uploaded_file(Input::get('file_image', 'tmp_name')) && !Input::get('file_image', 'error')) {
						$validate_array['image'] = array(
							'reference' => $config->get('lang/inputs/image'),
							'image' => $config->get('site/root') . $config->get('site/base') . $config->get('site/folder_images') . Input::get('image'),
							'object' => Input::get('file_image')
						);
					}
					if (Input::get('image_large') && is_uploaded_file(Input::get('file_image_large', 'tmp_name')) && !Input::get('file_image_large', 'error')) {
						$validate_array['image_large'] = array(
							'reference' => $config->get('lang/inputs/sliding_image'),
							'image' => $config->get('site/root') . $config->get('site/base') . $config->get('site/folder_images_slider') . Input::get('image_large'),
							'object' => Input::get('file_image_large')
						);
					}
					
					$val = new Validate(Db::get(), $config);
					$validate = $val->set($validate_array);
					
					if (isset($validate)) {
						
						$val = [];

						$query = 'UPDATE items SET ';
						$query2 = Db::get()->single("SELECT image, image_large FROM items WHERE id = ?", array($config->get('params/2')))->result();;
						
						if ($validate->get('price') !== false) { $query .= 'price = ?, '; $val[] = Input::get('price') * 100; }
						if ($validate->get('stock') !== false) { $query .= 'stock = ?, '; $val[] = Input::get('stock'); }
						if ($validate->get('console') !== false) { $query .= 'id_group = ?, '; $val[] = Input::get('console'); }
						if ($validate->get('vendor') !== false) { $query .= 'id_vendor = ?, '; $val[] = Input::get('vendor'); }
						if ($validate->get('genre') !== false) { $query .= 'id_genre = ?, '; $val[] = Input::get('genre'); }
						if ($validate->get('image') !== false) {
							$image_path = $config->get('site/root') . $config->get('site/base') . $config->get('site/folder_images') . Input::get('image');
							$old_image = $config->get('site/root') . $config->get('site/base') . $config->get('site/folder_images') . $query2['image'];
							if (file_exists($old_image) && $query2['image']) unlink($old_image);
							move_uploaded_file(Input::get('file_image', 'tmp_name'), $image_path);
							$query .= 'image = ?, ';
							$val[] = Input::get('image');
						}
						if ($validate->get('image_large') !== false) {
							$image_path = $config->get('site/root') . $config->get('site/base') . $config->get('site/folder_images_slider') . Input::get('image_large');
							$old_image = $config->get('site/root') . $config->get('site/base') . $config->get('site/folder_images_slider') . $query2['image'];
							if (file_exists($old_image) && $query2['image']) unlink($old_image);
							move_uploaded_file(Input::get('file_image_large', 'tmp_name'), $image_path);
							$query .= 'image_large = ?, ';
							$val[] = Input::get('image_large');
						}
						
						$val[] = $config->get('params/2');
						$query = substr($query, 0, -2);
						$query .= ' WHERE id = ?';
						Db::get()->query($query, $val);
						
						foreach(Languages::llist() as $l) {
							$query = 'UPDATE items_text SET ';
							$val = null;
							if ($validate->get('title_' . $l) !== false) { $query .= 'title = ?, '; $val[] = Input::get('title_' . $l); }
							if ($validate->get('description_' . $l) !== false) { $query .= 'description = ?, '; $val[] = Input::get('description_' . $l); }
							if (!empty($val)) {
								$val[] = $config->get('params/2');
								$val[] = Languages::exists($l);
								$query = substr($query, 0, -2);
								$query .= ' WHERE id_item = ? AND id_language = ?';
								Db::get()->query($query, $val);
							}
						}
						
						if ($validate->pass()) Redirect::go($config->get('nav/base'), 'admin/items', str_replace('%s%', $config('params/2'), $config->get('lang/general/item_edited')), 'success');
						
					}
					
				}
				
				$product = new Product(Db::get(), $config->get('site/lang'), $config->get('params/2'), true);
				$config->put(array('nav/page_include' => 'admin_edit'));
			}
			elseif ($config->get('params/1') == 'delete' && (Input::exists())) {
				// loop through ids, if set, delete
				
				$result = Db::get()->query("SELECT id FROM items", array())->result();
				foreach ($result as $key => $value) {
					if (Input::get('check_' . $value->id)) $delete[] = $value->id;
				}
				$result = Db::get()->query("DELETE FROM items WHERE id IN (" . implode(', ', $delete) .")", array())->result();
				$result = Db::get()->query("DELETE FROM items_text WHERE id_item IN (" . implode(', ', $delete) .")", array())->result();
				
				$item = new Items(Db::get(), $config->get('site/lang'), 0, true);
				
				$config->put(array('nav/page_include' => 'admin_items'));
			}
			
			else {
				$config->put(array('nav/page_include' => 'admin_items'));
				$item = new Items(Db::get(), $config->get('site/lang'), 0, true);
			}
		
		}
		
		elseif ($config->get('params/0') == 'users') {
			$config->put(array('nav/page_include' => 'admin_users'));
		}
		
		else $config->put(array('nav/page_include' => 'blank'));
	}
	
	