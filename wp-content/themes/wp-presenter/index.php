<?php
/**
 * The main page for displaying the slideshow.
 *
 * @package WP Presenter
 */

$background_types = array(
    'Select One' => 'Select One',
    'Color' => 'Color',
    'Image' => 'Image',
    'Tiled Image' => 'Tiled Image',
    'Video' => 'Video'
);

$slide_types =  array(
    'blank' => 'blank',
    'title' => 'lone_title',
    'title-subtitle' => 'subtitle',
    'title-content' => 'slide_content_title_content',
    'two-columns' => 'content_left_column_two_columns',
    'content-image-right' => 'content_content_image_right',
    'title-image' => 'image_title_image',
    'code' => 'code',
    'iframe' => 'iframe',
);

get_header();?>

	<?php $slides = get_posts( 'post_type=slide&post_status=publish&posts_per_page=-1&orderby=menu_order&order=ASC' );?>

	<?php foreach ( $slides as $slide ) : ?>
	<?php
            $what_type_of_slide = get_post_meta($slide->ID, 'slide_layout', true);
            $vslides = get_post_meta( $slide->ID, 'add_a_vertical_slide', true );
			$vslide_title = get_post_meta( $slide->ID, 'vertical_slide_title', true );
			$vslide_content = get_post_meta( $slide->ID, 'vertical_slide_content', true );
            $background_type = get_post_meta ( $slide->ID, 'change_slide_background', true );
			// Video Background
			$video_bkg = get_post_meta( $slide->ID, 'video', true );
			$video_src = get_attached_media( $video_bkg );
			$video_url = wp_get_attachment_url( $video_bkg );
			// Full Size Image Background
			$bkg_img = get_post_meta( $slide->ID, 'image', true );
			$bkg_img_url = wp_get_attachment_image_src( $bkg_img, 'full' );
			// Iframe
			$iframe = get_post_meta( $slide->ID, 'iframe', true );
			// Color
			$bkg_color = get_post_meta( $slide->ID, 'background_color', true );
	?>

	<?php if( $vslides && $vslides[0] == 'vertical_slide_yes' ) : ?>
		<section><?php // This OPENING tag will only exist if there are vertical slides that need to be nested with the main slide ?>
	<?php endif;?>

		<?php // If a slide has a background video chosen ?>
		<?php if ( $background_type == 'Video' && $video_url ) : ?>
			<?php // display the video as a data-attribute ?>
			<section id="video-background" class="stretch" data-background-video="<?php echo $video_url; ?>">

			<?php // if a slide has a background color chosen ?>
		<?php elseif ( $background_type == 'no_color' && $bkg_color ) : ?>
			<?php // display the background color as a data-attribute ?>
			<section id="background-color" data-background="<?php echo $bkg_color; ?>">

			<?php // if a slide has a background image chosen ?>
		<?php elseif ( $background_type == 'Image' && $bkg_img ) : ?>
			<?php // display the image url as a data-attribute ?>
			<section id="background-image" data-background="<?php echo $bkg_img_url[0]; ?>">

			<?php // if a slide has an iframe chosen ?>
		<?php elseif ( $what_type_of_slide == 'Iframe' && $iframe ) :?>
			<?php // display the image url as a data-attribute ?>
			<section id="iframe" data-background-iframe="<?php echo $iframe['url'];?>">

		<?php // if a slide has no alternate background chosen ?>
		<?php else:?>
	<section>
		<?php endif;?>

					<?php // title ?>
                    <?php if( !empty($what_type_of_slide) && $what_type_of_slide !== 'blank'   ) :?>
                        <h2 class="title"><?php echo $slide->post_title; ?></h2>
                    <?php endif ?>
					<?php // subtitle ?>
					<?php $subtitle = get_post_meta( $slide->ID, 'subtitle', true );if( $subtitle ) :?>
						<h3 class="title"><?php echo $subtitle;?></h3>
					<?php endif ?>

					<?php // content ?>
					<?php $content_title_content = get_post_meta( $slide->ID, 'slide_content_title_content', true ); if( $slide_types[$what_type_of_slide] == "slide_content_title_content" && $content_title_content ): ?>
					<div class="content"><?php echo wpautop( do_shortcode($content_title_content) );?></div>
					<?php endif ?>

					<?php // content left column ?>
					<?php $content_left = get_post_meta( $slide->ID, 'content_left_column_two_columns', true ); if( $slide_types[$what_type_of_slide] == "content_left_column_two_columns" && $content_left ): ?>
						<div class="content-left"><?php echo wpautop( $content_left );?></div>
					<?php endif ?>

					<?php // content right column ?>
					<?php $content_right = get_post_meta( $slide->ID, 'content_right_column_two_columns', true ); if( $slide_types[$what_type_of_slide] == "content_left_column_two_columns" && $content_right ): ?>
						<div class="content-right"><?php echo wpautop( $content_right );?></div>
					<?php endif ?>

					<?php // content - content left image right ?>
					<?php $content_left_image_right = get_post_meta( $slide->ID, 'content_content_image_right', true ); if( $slide_types[$what_type_of_slide] == "content_content_image_right" && $content_left_image_right ): ?>
						<div class="content-left"><?php echo wpautop( $content_left_image_right );?></div>
					<?php endif ?>

					<?php // image - content left image right ?>
					<?php $image_right = get_post_meta( $slide->ID, 'image_content_image_right', true ); if( $slide_types[$what_type_of_slide] == "content_content_image_right" && $image_right ):
						$image_url = wp_get_attachment_image_src( $image_right, 'full' );?>
						<div class="content-right"><img src="<?php echo $image_url[0]; ?>"></div>
					<?php endif ?>

					<?php // image - title/image ?>
					<?php $image = get_post_meta( $slide->ID, 'image_title_image', true ); if( $slide_types[$what_type_of_slide] == "image_title_image" && $image ):
						$image_url = wp_get_attachment_image_src( $image, 'full' );?>
						<img src="<?php echo $image_url[0]; ?>">
					<?php endif ?>

					<?php // code ?>
					<?php $code = get_post_meta( $slide->ID, 'code', true ); if( $slide_types[$what_type_of_slide] == "code" && $code ): ?>
						<pre>
							<code data-trim>
								<?php echo $code;?>
							</code>
						</pre>
					<?php endif ?>

								<?php $speaker_notes = get_post_meta( get_the_ID(), 'speaker_notes', true ); if( $speaker_notes ) : ?>
								<aside class="notes">
									<?php echo $speaker_notes; ?>
								</aside>
								<?php endif ?>
	</section><?php // slide end ?>

				<?php // vertical slides start here ?>
				<?php if( $vslides && $vslides[0] == 'vertical_slide_yes' ) : ?>
					<section>
					        <h2 class="title"><?php echo $vslide_title;?></h2>
						<?php echo $vslide_content;?>
					</section>
					<?php endif;?>
			    <?php // vertical slide ends here ?>

	<?php if( $vslides && $vslides[0] == 'vertical_slide_yes' ) : ?>
		</section><?php // This CLOSING tag will only exist if there are vertical slides that need to be nested with the main slide ?>
		<?php endif ?>
	<?php endforeach ;?>

<?php get_footer(); ?>