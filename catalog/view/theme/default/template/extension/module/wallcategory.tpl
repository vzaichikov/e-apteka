<style type="text/css">
	.category_wall_allcat_container {
		margin-top:20px;
	    display: grid;
	    grid-template-columns: repeat(9, 1fr);
	    grid-gap: 10px;
	    text-align: center;
	    margin-bottom: 20px;
	}
	.category_wall_allcat_container .category_wall_allcat_item {
	    padding: 15px;
	    border: 1px solid transparent;
	    transition: .3s ease-in-out;
	}
	.category_wall_allcat_container .category_wall_allcat_item:hover {
	    background: #fff;
	    border: 1px solid #eae9e8;
	    box-shadow: 0 0 30px rgba(0,0,0,.1);
	}
	.category_wall_allcat_container .category_wall_allcat_item .image{
		width: 100px;
	    height: 100px;
	    margin: auto;
	}
	.category_wall_allcat_container .category_wall_allcat_item .image svg {
	    width: 100px;
	    height: 100px;
	    position: unset;
	    margin: 0;
	}
	.category_wall_allcat_item a h5{
		font-size: 16px;
		margin: 15px 0 0 0;
		display: block;
		padding-bottom: 10px;
		transition: .3s ease-in-out;
	}
	@media screen and (max-width: 1400px){
		.category_wall_allcat_container .category_wall_allcat_item a h5 {
		    font-size: 18px;
		}
		.category_wall_allcat_container .category_wall_allcat_item .image,
		.category_wall_allcat_container .category_wall_allcat_item .image svg {
		    width: 90px;
		    height: 90px;
		}
	}
	@media screen and (max-width: 992px){
		.category_wall_allcat_container {
		    grid-template-columns: repeat(4, 1fr);
		}
	}
	@media screen and (max-width: 567px){
		.category_wall_allcat_container {
		    grid-template-columns: repeat(3, 1fr);
		}
	}
	@media screen and (max-width: 480px){
		.category_wall_allcat_container .category_wall_allcat_item a h5 {
		    font-size: 14px;
		}
		.category_wall_allcat_container .category_wall_allcat_item .image,
		.category_wall_allcat_container .category_wall_allcat_item .image svg {
		    width: 60px;
		    height: 60px;
		}
	}
</style>
<div class="category_wall_allcat_container">
	<?php foreach ($categories as $category) { ?>
		<div class="category_wall_allcat_item">
			<a href="<?php echo $category['href']; ?>" class="">
				<div class="image">
					<?php if (isset($category['icon']) && !empty($category['icon'])) { ?>
					<svg class="icon catalog__list-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#<?php echo $category['icon']; ?>"></use></svg>
					<?php } ?>
				</div>
				<div>
					<h5 style="text-align:center;"> <?php echo $category['name']; ?></h5>       
				</div>   
			</a>
				</div>
	<?php } ?>
</div>