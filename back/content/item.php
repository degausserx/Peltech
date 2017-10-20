<?php

$product = $product->get();

?>

<div class="row">
	<div class="col-md-6">
		<img class="img-responsive" src="<?=$config->get('nav/baselang') . $config->get('site/folder_images') . $product['image'];?>" alt="" />
	</div>
	<div class="col-md-6">
		<div class="caption-full">
			<h4 class="pull-right">€<?=$product['price'] / 100;?></h4>
			<h4>
				<a href="#"><?=Input::clean($product['title']);?></a>
			</h4>
			<p><?=Input::clean($product['description']);?></p>
		</div>
		<div class="ratings">
			<p><?=$item->rating($product['rating']);?></p>
		</div>
	</div>

	<div class="col-md-12">
		<span class="pull-right">
			<form action="<?=$config->get('nav/base');?>basket" method="POST">
				<input type="hidden" value="<?=$product['id'];?>" name="id_cart" id="id_cart" /> 
				<input type="submit" class="btn btn-lg btn-success" value="Add to Cart" />
			</form>
		</span>
	</div>
</div>