<div class="header-bg-box">
<header id="masthead" class="foursix-header foursix-inline-menu">
		<nav id="site-navigation" class="foursix-navbar">
		    <div class="container">
				<div class="foursix-menu-wrap">
					<div class="foursix-brand-wrap">
						<?php  
							/**
							 * foursix_before_logo hook
							 */
							do_action( 'foursix_before_logo' );
						?>
						<a class="foursix-navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php foursix_custom_logo(); ?>
						</a>
						<?php  
							/**
							 * foursix_after_logo hook
							 */
							do_action( 'foursix_after_logo' );
						?>
						<span class="foursix-navbar-toggler js-show-nav">
							<i class="fas fa-bars"></i>
						</span>
					</div>
					<?php
						if( has_nav_menu( 'primary' ) ) :
							wp_nav_menu( array(
								'theme_location'	=> 'primary',
								'container'			=> false,
								'menu_class'		=> 'foursix-main-menu foursix-inline-menu',
								'menu_id'			=> false,
							) );
						endif;
					?>
				</div>
				<div class="head-right-button">
		      <ul>
			      <li class="login-btn"><a href="#"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12.6667 14V12.6667C12.6667 11.9594 12.3858 11.2811 11.8857 10.781C11.3856 10.281 10.7073 10 10 10H6.00004C5.2928 10 4.61452 10.281 4.11442 10.781C3.61433 11.2811 3.33337 11.9594 3.33337 12.6667V14" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M8.00004 7.33333C9.4728 7.33333 10.6667 6.13943 10.6667 4.66667C10.6667 3.19391 9.4728 2 8.00004 2C6.52728 2 5.33337 3.19391 5.33337 4.66667C5.33337 6.13943 6.52728 7.33333 8.00004 7.33333Z" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

<span>Login</span></a></li>
				  <li class="nibondon-btn"><a href="#">Sign Up</a></li>
			 </ul>
		</div>
		    </div>
			
		</nav>
		
	</header><!-- #masthead -->
	</div>