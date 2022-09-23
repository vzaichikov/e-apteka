<?php if ($categories) { ?>
	<style type="text/css">
		.category_wall_allcat_container {
		display: grid;
		grid-template-columns: repeat(4, 1fr);
		grid-gap: 15px;
		text-align: center;
		margin-bottom: 30px;
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
		width: 120px;
		height: 120px;
		margin: auto;
		}
		.category_wall_allcat_container .category_wall_allcat_item .image svg {
		width: 120px;
		height: 120px;
		position: unset;
		margin: 0;
		}
		.category_wall_allcat_item h5{
		font-size: 18px;
		margin: 15px 0 0 0;
		display: block;
		padding-bottom: 10px;
		transition: .3s ease-in-out;
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
					<div>
						<h5 style="text-align:left;"><a href="<?php echo $category['href']; ?>" title="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a></h5>  
						<?php if ($category['children']) { ?>
							<ul class="category_wall_allcat_list">
							<?php foreach ($category['children'] as $child) { ?>
								<li>
									<a href="<?php echo $child['href']; ?>" title="<?php echo $child['name']; ?>"><?php echo $child['name']; ?></a>
								</li>
							<?php } ?>						
							</ul>
						<?php } ?>
					</div>   
				</a>
			</div>
		<?php } ?>
	</div>
<?php } ?>