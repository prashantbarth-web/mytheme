<?php
/**
 * The front page template for Astra Child Theme
 * 
 * @package astra-child
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php
		/**
		 * Hero Section
		 */
		?>
		<section class="hero-section">
			<div class="hero-content">
				<div class="hero-overlay"></div>
				<div class="hero-text-wrapper">
					<h1 class="hero-title">Government Schemes & Benefits</h1>
					<p class="hero-subtitle">Discover schemes and benefits tailored for you</p>
				</div>
			</div>
		</section>

		<?php
		/**
		 * Category Wise Posts Sections
		 */
		if ( has_categories_with_posts() ) {
			$categories = get_categories_with_posts();

			foreach ( $categories as $category ) {
				$query = get_posts_by_category( $category->term_id, 4 );

				if ( $query->have_posts() ) {
					?>
					<section class="category-section">
						<div class="container">
							<div class="category-header">
								<h2 class="category-title">
									<i class="<?php echo esc_attr( get_category_icon( $category->name ) ); ?>"></i>
									<?php echo esc_html( $category->name ); ?>
								</h2>
								<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="view-all-link">
									View All <i class="fas fa-arrow-right"></i>
								</a>
							</div>

							<div class="posts-grid">
								<?php
								while ( $query->have_posts() ) {
									$query->the_post();
									$post_id = get_the_ID();
									?>
									<article class="post-card">
										<div class="post-thumbnail-wrapper">
											<img 
												src="<?php echo esc_url( get_featured_image_url( $post_id ) ); ?>" 
												alt="<?php echo esc_attr( get_the_title() ); ?>"
												class="post-thumbnail"
											/>
											<div class="post-overlay">
												<span class="post-category-badge"><?php echo esc_html( $category->name ); ?></span>
											</div>
										</div>

										<div class="post-content">
											<h3 class="post-title">
												<a href="<?php the_permalink(); ?>">
													<?php the_title(); ?>
												</a>
											</h3>

											<p class="post-description">
												<?php echo esc_html( get_custom_excerpt( $post_id, 15 ) ); ?>
											</p>

											<a href="<?php the_permalink(); ?>" class="read-more-link">
												Read More <i class="fas fa-chevron-right"></i>
											</a>
										</div>
									</article>
									<?php
								}
								wp_reset_postdata();
								?>
							</div>
						</div>
					</section>
					<?php
				}
			}
		} else {
			?>
			<section class="no-content-section">
				<div class="container">
					<p><?php esc_html_e( 'No schemes available at the moment. Please check back soon!', 'astra-child' ); ?></p>
				</div>
			</section>
			<?php
		}
		?>

		<?php
		/**
		 * Category Navigator Section
		 */
		if ( has_categories_with_posts() ) {
			$categories = get_categories_with_posts();
			?>
			<section class="category-navigator-section">
				<div class="container">
					<h2 class="navigator-title">Browse by Category</h2>
					<div class="category-navigator">
						<?php
						foreach ( $categories as $category ) {
							$icon_class = get_category_icon( $category->name );
							$category_posts_count = $category->count;
							?>
							<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="category-nav-item">
								<div class="nav-icon-wrapper">
									<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
								</div>
								<div class="nav-text">
									<h3 class="nav-category-name"><?php echo esc_html( $category->name ); ?></h3>
									<p class="nav-posts-count"><?php echo esc_html( $category_posts_count ); ?> Schemes</p>
								</div>
								<i class="fas fa-arrow-right nav-arrow"></i>
							</a>
							<?php
						}
						?>
					</div>
				</div>
			</section>
			<?php
		}
		?>

	</main>
</div>

<?php get_footer(); ?>
