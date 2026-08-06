		</main>

	<?php
		$is_map_project = get_field('is_map_project');
		?>

	<?php if ( $is_map_project ) : ?>
		<?php get_template_part( 'parts/footer-v2' ); ?>
	<?php else : ?>
		<footer class="footer mt-auto">
			<style>
			  footer .bottom-footer .container .footer-bottom-one {
				padding-bottom: 20px;
			  }
			  footer .bottom-footer .container  .footer-bottom-one:first-child {
				width: 80%;
				padding-right: 10px;
			  }
			  footer .bottom-footer .container  .footer-bottom-one:not(:first-child) {
				width: 40%;
			  }

			  /* Адаптив */
			  @media (max-width: 768px) {
				footer .bottom-footer .container  .footer-bottom-one:first-child,
				footer .bottom-footer .container  .footer-bottom-one:not(:first-child){
				  width: 100%;
				}
			  }
			</style>

			<div class="mobile_footer_menus">
				<div class="top_nav">
					<?php
						wp_nav_menu(
							[
								'theme_location' 	=> 'top-navigation',
								'depth'          	=> 2,
								'container' 		=> false,
								'menu_class'    	=> '',
								'fallback_cb'     	=> '__return_false',
								'items_wrap'     	=> '<ul id="%1$s" class="navbar-nav mr-auto mt-lg-0 %2$s">%3$s</ul>',
								'walker' 			=> new bootstrap_4_walker_nav_menu(),
							]
						);
					?>
				</div>
				<div class="sub_nav">
					<?php
						wp_nav_menu(
							[
								'theme_location' 	=> 'sub-header-navigation',
								'depth'          	=> 2,
								'container' 		=> false,
								'menu_class'    	=> '',
								'fallback_cb'     	=> '__return_false',
								'items_wrap'     	=> '<ul id="%1$s" class="navbar-nav mr-auto mt-2 mt-lg-0 %2$s">%3$s</ul>',
								'walker' 			=> new bootstrap_4_walker_nav_menu(),
							]
						);
					?>
				</div>
			</div>
            <?php if ( is_front_page() ) { ?>
			<div class="container widgets">
				<div><?php dynamic_sidebar('footer-one'); ?></div>
				<div><?php dynamic_sidebar('footer-two'); ?></div>
				<div><?php dynamic_sidebar('footer-tree'); ?></div>
			</div>
			<?php }?>
			<div class="bottom-footer">
				<div class="container">
					<?php dynamic_sidebar('footer-bottom-one'); ?>

					<div class="footer-bottom-contacts footer-bottom-one">
						<div >Телефон: <span class="phone">+ 38 (050) 975-56-21</span></div>
						<div>Електронна пошта: <span class="mail"><a href="#">slidstvo.info@gmail.com</a></span></div>
						<div class="social">
							Напишіть нам:
                            <?php CC_Functions::showSocialProfiles(); ?>
						</div>
					</div>

					<div class="footer-bottom-contacts footer-bottom-one">
						<div >Поштова адреса: <span>Україна, 04071, місто Київ, <br>вул. Щекавицька, будинок 30/39, квартира 248</span></div>
						<div>Ідентифікатор онлайн-медіа в Реєстрі: <span>№ R-40-03691</span></div>
					</div>

					<?php /*
					<div class="dev-copyright">
						<style>.hoppers-logo .st0{display:none;fill:#FFFFFF;}.hoppers-logo .st1{fill:#616161;}.hoppers-logo .st2{fill:#414141;}.hoppers-logo:hover .st1{fill:#18662b;}.hoppers-logo:hover .st2{fill:#289b44;}</style>
						<span class="cprt-text">Developed by</span>
						<a href="https://hoppers.agency/" rel="_nofollow noopener noreferrer" target="_blank">
							<svg version="1.1" class="hoppers-logo" id="hoppers-logo-bw" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 640.3 360.1" style="enable-background:new 0 0 640.3 360.1;" xml:space="preserve"><g><path class="st0" d="M597.9-0.7c14.3,0,28.5,0,42.8,0c0,120.5,0,241,0,361.5c-160,0-320,0-480,0c0-120.5,0-241,0-361.5 c144,0,288,0,432,0c-1.5,1.8-4,3.4-4.4,5.4c-5.2,30.1-10.2,60.3-14.9,90.5c-0.7,4.5-2.4,7-6.6,9.1c-34.9,17.8-69.6,35.9-104.4,54 c-0.4,0.2-0.8,0.5-1.2,0.8c35.5,29.7,53.9,71,75.8,110.3c12-6,24-12.1,36.1-18c1.8-0.9,4-1.5,6-1.7c9.3-0.8,17.5-4,24.3-10.4 c6.6-6.1,11.2-13.5,14-21.9c10.1-30.4,7.6-60-5.6-88.9c-0.8-1.6-1.3-3.9-0.8-5.5c9-28.7,18.1-57.4,27.3-86.1 c1.5-4.6,0.4-7.1-3.8-8.5c-4.7-1.5-8.2,0.1-9.6,4.2c-6.8,20.5-13.6,41-20.4,61.5c-1.8,5.4-3.6,10.8-5.5,16.2 c-3.4-2.2-6.2-4.2-9.2-5.9c-1.7-0.9-2.2-1.8-1.9-3.8c4.8-31,9.3-62,14.2-92.9C602.6,3.8,601.9,1,597.9-0.7z M473.1,357.1 c1.7-21,3.3-41.1,4.8-61.1c7.6-3.3,14.9-6.4,22.3-9.6c0.9,1.2,1.7,2.2,2.4,3.2c15.2,21.2,28.9,43.5,40.7,66.8 c0.6,1.2,1.9,2.8,2.9,2.8c8.8,0,17.6-0.4,26.8-0.7c-0.6-1.3-0.9-2.3-1.3-3.1c-8.3-16.9-16.5-33.9-24.9-50.8 c-16.4-33-32.6-66-52.4-97.2c-10.1-16-21.3-31.1-35.6-43.8c-2-1.8-3.5-1.9-5.9-0.7c-24.9,12.1-49.9,24.1-74.8,36.3 c-2.5,1.2-4.1,0.9-6.3-0.8c-21.9-16.2-43.7-32.4-65.9-48.2c-14.9-10.7-30.6-20.4-45.5-31c-10.5-7.5-26.1-1.9-28.5,10.9 c-1.6,8.3,2.7,14.4,8.3,19.8c21.1,20.3,42.5,40.2,63.1,60.9c21,21.1,41.3,42.9,58.6,67.2c17.6,24.7,32.5,50.9,45.4,78.3 c0.6,1.2,1.8,2.9,2.7,2.9c10.6,0.2,21.1,0.1,32.5,0.1c-41.1-67.7-83.6-133.3-145-184.2c1.9,0.6,3.4,1.5,5,2.5 c25.8,16.6,48.5,36.9,69.9,58.7c30.6,31.2,57.4,65.6,84.5,99.8C462.1,342.8,467.3,349.6,473.1,357.1z M379.1,330.5 c-0.6-1.3-0.7-1.7-1-2.2c-18.9-35.4-42.1-67.6-69.8-96.6c-1.7-1.8-3.1-1.3-4.9-0.6c-36.6,13.3-73.2,26.6-109.8,39.8 c-9.6,3.5-19.2,7-28.8,10.5c-3.1,1.1-4.1,3.1-3.5,6.4c1.3,8.1,5.7,14.3,11.8,19.4c9.1,7.6,19.8,12,30.8,15.8 c13.4,4.5,27.1,8.4,41.5,6.2c9.6-1.5,18.9-4.4,28.4-6.4c1.7-0.4,3.8-0.1,5.5,0.6c4.8,1.8,9.3,4.3,14.1,5.9 c20.2,6.7,41,7.3,61.9,4.8C363.1,333.3,370.8,331.8,379.1,330.5z M450.2,156.8c-4.2-2.4-7.4-4.5-10.9-6.2 c-31.9-14.8-63.7-29.8-96.9-41.7c-10.6-3.8-20.9,1.9-23.5,12.9c-1.4,5.9,0.4,10.1,5.1,13.3c22.9,15.6,45.8,31.2,68.6,46.9 c1.8,1.2,3,1.4,5,0.5c14.9-7.3,29.8-14.6,44.7-21.8C444.7,159.6,447,158.4,450.2,156.8z"></path><path class="st1" d="M566.2,1.1c2.8-0.1,5.4,4.5,4.6,8.8c-6,30.9-11.7,61.8-17.6,92.7c-0.4,2,0.1,2.8,2.1,3.8 c3.5,1.7,6.8,3.8,10.6,6c2.2-5.4,4.4-10.8,6.6-16.1c8.2-20.4,16.3-40.8,24.4-61.2c1.6-4.1,5.8-5.6,11.2-4.1 c4.8,1.4,6.1,3.9,4.3,8.5c-10.9,28.5-21.9,57.1-32.7,85.6c-0.6,1.6,0,3.9,0.9,5.5c15,29.1,17.5,58.8,5.4,89 c-3.3,8.3-8.8,15.7-16.5,21.7c-8,6.2-17.6,9.3-28.3,10c-2.4,0.1-4.8,0.7-7,1.6c-14.1,5.7-28.1,11.6-42,17.4 c-24.8-39.7-45.6-81.2-86.4-111.5c0.5-0.3,0.9-0.6,1.4-0.8c40.5-17.5,81-35.1,121.7-52.4c4.8-2.1,6.8-4.5,7.7-9 c5.9-30.1,12.1-60.2,18.5-90.3c1.5-4.2,2.7-4.2,5.1-5.3C562.1,1,564.2,1,566.2,1.1z M567.9,145.2c0.4-5.5-2.3-11.1-7.3-16.2 c-7.1-7.3-18.6-9.1-27.8-3.8c-16,9.1-16.1,32.7-0.3,42.1c7.1,4.2,16.4,4.3,23.5,0C564.3,162.2,567.8,155,567.9,145.2z"></path><path class="st1" d="M410.7,357.1c-6.7-7.5-12.7-14.3-18.9-21c-31.5-34.2-61.7-69.9-98.4-99.8c-26-21.1-34.2-30.9-66.1-52 c-0.1-0.1-19.6-14.6-19.7-14.7c-2.6-1.6-26.9-19.7-29-20.3c66.2,44.7,134.1,120.9,196.4,210c-13.3,0-25.6,0.1-37.9-0.1 c-1.1,0-2.5-1.7-3.1-2.9c-15-27.4-34.4-53.6-54.9-78.3c-20.1-24.3-41.8-46.1-66.2-67.2c-24-20.7-52-43.6-76.2-65.1 c-14.5-12.9-26.6-21.5-33.3-37c-5.4-14.1,6.6-27.4,22.8-21.1c17.5,8.3,40.9,21.5,87.1,53.1c25.8,15.8,53,38.6,78.5,54.8 c2.5,1.6,4.7,1.7,8.4,0.8c33.9-11.9,55-19.5,87-31.3c2.8-1.2,4.5-1,6.8,0.7c16.6,12.6,29.6,25.8,41.4,41.8 c23,31.2,41.9,64.2,61,97.2c9.8,16.9,19.3,33.8,29,50.8c0.5,0.9,0.9,1.8,1.6,3.1c-10.7,0.3-20.9,0.6-31.2,0.7 c-1.1,0-2.7-1.6-3.3-2.8c-13.8-23.3-29.7-45.5-47.4-66.8c-0.8-1-1.7-2-2.8-3.2c-8.6,3.2-17.1,6.3-25.9,9.6 C414.5,315.9,412.7,336,410.7,357.1z"></path><path class="st1" d="M300.3,330.5c-10.5,1.3-20.3,2.8-30.3,3.7c-26.6,2.4-53,1.8-78.8-4.8c-6.1-1.6-11.9-4.1-18-5.9 c-2.1-0.6-4.8-0.9-7-0.6c-12.1,2-24,4.9-36.2,6.4c-18.2,2.2-35.7-1.7-52.8-6.2c-14.1-3.7-27.7-8.2-39.2-15.8 c-7.8-5.1-13.3-11.3-15-19.4c-0.7-3.3,0.6-5.3,4.5-6.4c12.2-3.5,24.4-7,36.7-10.5c46.6-13.3,93.1-26.5,139.7-39.8 c2.6-0.8,4.3-1.2,6.3,0.6c35.2,29,64.7,61.3,88.8,96.6C299.4,328.8,299.6,329.2,300.3,330.5z"></path><path class="st2" d="M374.7,155.6c-3.3,1.2-5.8,2.2-8.2,3.1c-15.6,5.7-31.2,11.3-46.8,17.1c-2,0.8-3.3,0.4-4.9-1 c-21.1-18-43.4-35-65.4-51.8c-9.1-6.9-23.8-19.2-19.7-28.7c4.5-10.4,21.4-7.9,42.7,2.6c31.7,15.3,61.8,33.5,92,51.6 C367.8,150.3,370.8,152.8,374.7,155.6z"></path><path class="st0" d="M601,143.4c0.1,9.8-2.9,17-10,22.2c-6,4.4-14.1,4.5-20.3,0.3c-13.8-9.2-14-32.8-0.3-42.1 c7.9-5.4,17.8-3.7,24,3.5C598.9,132.4,601.2,137.9,601,143.4z"></path></g>
							</svg>
						</a>
						+
						<a href="http://webolatory.com/" rel="_nofollow noopener noreferrer" target="_blank" class="wbl"><img src="https://slidstvo.webolatory.com/wp-content/uploads/2019/07/webolatory_logo_2019.svg" alt="webolatory"></a>

					</div>
					*/ ?>
				</div>
			</div>
		</footer>
	<?php endif; ?>
		<?php wp_footer(); ?>

<!--		<script type="text/javascript" src="--><?php //echo get_stylesheet_directory_uri().'/dist/js/bootstrap.js'; ?><!--"></script>-->
<!--		<script type="text/javascript" src="--><?php //echo get_stylesheet_directory_uri().'/dist/js/main.js'; ?><!--"></script>-->

<span aria-hidden="true" id="to_top_scrollup" class="dashicons dashicons-arrow-up-alt2" style="opacity: 0.5; display: inline;"><span class="screen-reader-text">Scroll Up</span></span>


		<script src="https://apis.google.com/js/platform.js"></script>
	</body>
</html>
