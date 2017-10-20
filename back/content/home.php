<div class="row carousel-holder">
 
    <div class="col-md-12">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
			<?php		
			foreach ($item_slider->items() as $k => $key) {
			?>
                <div class="item<?php if (!$k) print ' active'; ?>">
                    <img class="slide-image" src="<?=$config->get('nav/extlink');?>images/promos/<?=$key->image_large;?>" alt="">
					<div class="carousel-caption">
						<form action="<?=$config->get('nav/base');?>basket" method="POST">
							<input type="hidden" value="<?=$key->id;?>" name="id_cart" id="id_cart" /> 
							<input type="submit" class="btn btn-xl btn-carosel" value="€<?=$key->price / 100;?>" />
							<a type="button" class="btn btn-xl btn-carosel" href="<?=$config->get('nav/base');?>shop/<?=$key->category;?>/<?=$key->id;?>"><?=$config->get('lang/buttons/info');?></a>
						</form>
					</div>
                </div>
			<?php } ?>
							
            </div>
        </div>
    </div>
 
</div>

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