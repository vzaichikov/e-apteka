<?php if ($categories) { ?>
	<style type="text/css">
		.category_wall_allcat_container {
		display: grid;
		grid-template-columns: repeat(8, 1fr);
		grid-gap: 15px;
		text-align: center;
		margin-bottom: 10px;
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
		.category_wall_allcat_item h5 a{
			color:#353535;
		}
		.category_wall_allcat_list{
			list-style-type:disc;
		}
		.category_wall_allcat_list li{
			text-align:left;
		}
		@media screen and (max-width: 1400px){
		.category_wall_allcat_container .category_wall_allcat_item h5 {
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
		grid-template-columns: repeat(2, 1fr);
		}
		}
		@media screen and (max-width: 567px){
		.category_wall_allcat_container {
		grid-template-columns: repeat(1, 1fr);
		}
		}
		@media screen and (max-width: 480px){
		.category_wall_allcat_container .category_wall_allcat_item h5 {
		font-size: 14px;
		}
		}
	</style>
	<div class="row">
		<?php foreach ($categories as $category) { ?>
			<div class="col-xs-6 col-lg-2" style="padding:10px 5px;">
				<h5 style="text-align:left;"><a href="<?php echo $category['href']; ?>" title="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a></h5>  
			</div>   
		<?php } ?>
	</div>
<?php } ?>