<div class="row">

<?php

if ($basket->errors()) {
	print Display::clist('danger', $basket->errors());
} else {
?>

<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th><?=$config->get('lang/items/product');?></th>
				<th><?=$config->get('lang/items/quantity');?></th>
				<th class="text-center"><?=$config->get('lang/items/price');?></th>
				<th class="text-center"><?=$config->get('lang/items/total');?></th>
				<th> </th>
			</tr>
		</thead>
		<tbody>
			<form action="<?=$config->get('nav/base');?>basket" method="POST" id="basket_form">

<?php
	if (isset($basket) && is_array($basket->items())) {
		$tracker = 0;
		$shipping = 395;
		foreach ($basket->items() as $key => $piece) {
			$product = new Product(Db::get(), $config->get('site/lang'), $piece->id_item);
			if (!$product->exists()) continue;
			$product = $product->get();
			if (!$product['stock']) $stock = 'danger';
			else $stock = ($product['stock'] > 10) ? 'success' : 'warning';
?>

				<tr>
                        <td class="col-sm-8 col-md-8">
                            <a class="pull-left href="#"> <img src="<?=$config->get('nav/baselang') . $config->get('site/folder_images') . $product['image'];?>" style="width: 72px; height: 72px; margin-right: 5px;"> </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#"><?=Input::clean($product['title']);?></a></h4>
                                <h5 class="media-heading"> <?=$config->get('lang/items/by');?> <a href="#"><?=Input::clean($product['vendor']);?></a></h5>
                                <span><?=$config->get('lang/items/status');?> </span>
								<span class="text-<?=$stock;?>">
									<strong><?php
									if ($stock == 'danger') print $config->get('lang/items/stock_out');
									elseif ($stock == 'warning') print $config->get('lang/items/stock_limited');
									elseif ($stock == 'success') print $config->get('lang/items/stock_in');
									?></strong>
								</span>
                            </div>
						</td>
                        <td class="text-center">
                        <input type="email" class="form-control" id="exampleInputEmail1" value="<?=$piece->quantity;?>">
                        </td>
                        <td class="text-center"><strong>€<?=$product['price'] / 100;?></strong></td>
                        <td class="text-center"><strong>€<?=($product['price'] / 100) * $piece->quantity;?></strong></td>
                        <td>
                        <button type="button" class="btn btn-primary">
                            <span class="glyphicon glyphicon-refresh"></span>
                        </button>
						<button type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
						</td>
                </tr>

<?php
			$tracker += ($product['price'] * $piece->quantity);
		}
	}
?>

					<tr>
                        <td colspan="3"></td>
                        <td><h5><?=$config->get('lang/items/subtotal');?></h5></td>
                        <td class="text-right"><h5><strong>€<?=$tracker / 100;?></strong></h5></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td><h5><?=$config->get('lang/items/shipping');?></h5></td>
                        <td class="text-right"><h5><strong>€<?=$shipping / 100;?></strong></h5></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td><h3><?=$config->get('lang/items/total');?></h3></td>
                        <td class="text-right"><h3><strong>€<?=($tracker + $shipping) / 100;?></strong></h3></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td>
							<a type="button" class="btn btn-default" href="<?=$config->get('nav/base');?>shop">
								<span class="glyphicon glyphicon-shopping-cart"></span> <?=$config->get('lang/buttons/continue');?>
							</a>
						</td>
                        <td>
							<button type="button" class="btn btn-success">
								<?=$config->get('lang/buttons/checkout');?> <span class="glyphicon glyphicon-play"></span>
							</button>
						</td>
                    </tr>
					
					
				
				
			</form>
		</tbody>
	</table>
</div>

</div>

<?php
}
