<?php
/**
 * Admin Page
 *
 * @package parsijoo-map
 * @author NasimNet
 * @since 3.0.0
 */

defined( 'ABSPATH' ) || exit; ?>

<div class="wrap">
	<div id="api-map-form" class="postbox">
		<h2 class="hndle ui-sortable-handle pad10 margin-0">
			<span>
				<span class="nasimnet-map-icon dashicons dashicons-admin-generic"></span>
				<?php esc_html_e( 'Parsijoo MAP Plugin Settings', 'parsijoo-map' ); ?>
			</span>
		</h2>
		<div class="inside">
			<div class="main">
				<form method="post">
					<table class="form-table">
						<tbody>
							<tr>
								<th>
									<label for="parsijoo_api_map"><?php esc_html_e( 'Parsijoo API', 'parsijoo-map' ); ?></label>
								</th>
								<td>
									<input name="parsijoo_api_map" id="parsijoo_api_map" value="<?php echo esc_html( get_option( 'parsijoo_api_map' ) ); ?>" class="regular-text" type="text">
									<div class="description">
										<?php esc_html_e( 'Enter the Parsijoo Map API Key,', 'parsijoo-map' ); ?>
										<a href="http://addmap.parsijoo.ir/addmap/بلاگ/306-راهنمای-دریافت-api-key-نقشه-پارسی-جو" target="_blank"><?php esc_html_e( 'API Key Get Guide', 'parsijoo-map' ); ?></a>
									</div>
								</td>								
							</tr>
							<tr>
								<th></th>
								<td>
									<?php wp_nonce_field( 'parsijoo_settings_action', 'parsijoo_settings_nonce_field' ); ?>
									<input name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Submit', 'parsijoo-map' ); ?>" type="submit">
								</td>
							</tr>
						</tbody>
					</table>					
				</form>
			</div>
		</div>
	</div>

	<?php
	if ( ! get_option( 'parsijoo_api_map' ) ) {
		printf(
			'<p class="danger" style="margin:20px"><span class="dashicons dashicons-warning"></span> %s</p>',
			esc_html__( 'To view the map and build the shotcode, please enter the Parsijoo Maps API.', 'parsijoo-map' )
		);
		return;
	}
	?>

	<div id="create-shortcode" class="postbox">
		<h2 class="hndle ui-sortable-handle pad10 margin-0">
			<span>
				<span class="nasimnet-map-icon dashicons dashicons-sticky"></span>
				<?php esc_html_e( 'Create Shortcode', 'parsijoo-map' ); ?>
			</span>
		</h2>
		<div class="inside">
			<div class="main">
				<p class="help-map">
					<span class="dashicons dashicons-location-alt"></span>
					<?php esc_html_e( 'Select the place you want and copy your shortcode.', 'parsijoo-map' ); ?>
				</p>
				<div id="leaflet"></div>

				<div class="map-details">
					<div>
						<label><?php esc_html_e( 'Lat', 'parsijoo-map' ); ?></label>
						<input type="text" id="latMAP" class="input-example" value="">
					</div>
					<div>
						<label><?php esc_html_e( 'Lng', 'parsijoo-map' ); ?></label>
						<input type="text" id="lngMAP" class="input-example" value="">
					</div>
					<div>
						<label><?php esc_html_e( 'Zoom', 'parsijoo-map' ); ?></label>
						<input type="text" id="zoomMAP" class="input-example" value="">
					</div>
				</div>

				<div class="nasimnet-shortcode">
					<p>
						<?php esc_html_e( 'Copy and paste your shortcode into a post, page or custom widget', 'parsijoo-map' ); ?>
					</p>
					<input id="parsijoo-shortcode" type="text" value='[parsijoo_map latlng="31.879897, 54.317292" zoom="5" height="300"]'>
				</div>
			</div>
		</div>
	</div>

	<div id="map-lerning" class="postbox">
		<h2 class="hndle ui-sortable-handle pad10 margin-0">
			<span>
				<span class="nasimnet-map-icon dashicons dashicons-admin-collapse"></span>
				<?php esc_html_e( 'MAP Lerning', 'parsijoo-map' ); ?>
			</span>
		</h2>
		<div class="inside">
			<div class="main">
				<p>
					<?php esc_html_e( 'To use the map on your site, you can use the following shortcode.', 'parsijoo-map' ); ?>
				</p>
				<p><code>[parsijoo_map latlng="" zoom="" height=""]</code></p>
				<ul class="parametrs">
					<li>
                        <?php printf( esc_html__( 'Parameter %s : Latitude and Longitude, Example: 31.879897, 54.317292', 'parsijoo-map' ), '<code>latlng</code>' ); //phpcs:ignore ?>
					</li>
					<li>
                        <?php printf( esc_html__( 'Parameter %s : Map zoom, only a numeric value for this parameter is allowed, the use of this parameter is optional.', 'parsijoo-map' ), '<code>zoom</code>' ); // //phpcs:ignore ?>
					</li>
					<li>
                        <?php printf( esc_html__( 'Parameter %s : The height of the map, only a numeric value for this parameter is allowed, the use of this parameter is optional.', 'parsijoo-map' ), '<code>height</code>' ); //phpcs:ignore ?>
					</li>
				</ul>
				<p><?php esc_html_e( 'The sample is as follows', 'parsijoo-map' ); ?></p>
				<p><code>[parsijoo_map latlng="31.879897, 54.317292" zoom="20" height="300"]</code></p>
			</div>
		</div>
	</div>

	<div id="popup-parameters" class="postbox">
		<h2 class="hndle ui-sortable-handle pad10 margin-0">
			<span>
				<span class="nasimnet-map-icon dashicons dashicons-format-status"></span>
				<?php esc_html_e( 'POP-UP Parameters', 'parsijoo-map' ); ?>
			</span>
		</h2>
		<div class="inside">
			<div class="main">
				<div class="row-example">
					<div class="column">
						<?php echo do_shortcode( '[parsijoo_map latlng="31.879897, 54.317292" height="400" text="' . __( 'I am a pop-up', 'parsijoo-map' ) . '"]' ); ?>
						<input type="text" class="input-example" value='[parsijoo_map latlng="31.879897, 54.317292" height="400" text="<?php esc_html_e( 'I am a pop-up', 'parsijoo-map' ); ?>"]'>
					</div>
					<div class="column">
						<?php echo do_shortcode( '[parsijoo_map latlng="31.879897, 54.317292" height="400" title="' . __( 'Title pop-up', 'parsijoo-map' ) . '" text="' . __( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'parsijoo-map' ) . '"]' ); ?>

						<input type="text" class="input-example" value='[parsijoo_map latlng="31.879897, 54.317292" height="400" title="<?php esc_html_e( 'Title pop-up', 'parsijoo-map' ); ?>" text="<?php esc_html_e( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', 'parsijoo-map' ); ?>"]'>
					</div>
					<div class="column">
						<?php echo do_shortcode( '[parsijoo_map latlng="31.879897, 54.317292" height="400" title="گروه طراحی نسیم نت" text="نسیم نت در آبان سال ۱۳۸۶ با محوریت طراحی و برنامه نویسی وبسایت و نرم افزارهای تحت وب به صورت رسمی آغاز به کار کرد ." details="شماره تماس : 09197437752<br>آدرس سایت : https://nasimnet.ir" image="' . NASIMNET_PMAP_URL . 'assets/css/images/image-popup.jpg"]' ); ?>

						<input type="text" class="input-example" value='[parsijoo_map latlng="31.879897, 54.317292" height="400" title="گروه طراحی نسیم نت" text="نسیم نت در آبان سال ۱۳۸۶ با محوریت طراحی و برنامه نویسی وبسایت و نرم افزارهای تحت وب به صورت رسمی آغاز به کار کرد ." details="شماره تماس : 09197437752<br>آدرس سایت : https://nasimnet.ir" image="<?php echo esc_url( NASIMNET_PMAP_URL ); ?>assets/css/images/image-popup.jpg"]'>
					</div>
				</div>

				<ul class="parametrs">
					<li><?php esc_html_e( 'Applicable in all shortcodes', 'parsijoo-map' ); ?></li>
                    <li><?php printf( __( 'Parameter %s : POPUP Image', 'parsijoo-map' ), '<code>image</code>' ); //phpcs:ignore ?></li>
                    <li><?php printf( __( 'Parameter %s : POPUP Title', 'parsijoo-map' ), '<code>title</code>' ); //phpcs:ignore ?></li>
                    <li><?php printf( __( 'Parameter %s : POPUP Text', 'parsijoo-map' ), '<code>text</code>' ); //phpcs:ignore ?></li>
                    <li><?php printf( __( 'Parameter %s : POPUP Details', 'parsijoo-map' ), '<code>datails</code>' ); //phpcs:ignore ?></li>
				</ul>
			</div>
		</div>
	</div>

	<div id="circle-shortcode" class="postbox">
		<h2 class="hndle ui-sortable-handle pad10 margin-0">
			<span>
				<span class="nasimnet-map-icon dashicons dashicons-marker"></span>
				<?php esc_html_e( 'Circle Shortcode', 'parsijoo-map' ); ?>
			</span>
		</h2>
		<div class="inside">
			<div class="main">
				<div class="map-circle">
					<?php echo do_shortcode( '[parsijoo_map_circle latlng="34.627821624020775,50.866999626159675" zoom="13" height="400"  radius="1000"]' ); ?>
					<ul class="parametrs">
						<li><?php printf( esc_html__( 'ShortCode %s', 'parsijoo-map' ), '<code>[parsijoo_map_circle]</code>' ); //phpcs:ignore ?></li>
						<li><?php printf( esc_html__( 'Parameter %s : Radius', 'parsijoo-map' ), '<code>radius</code>' ); //phpcs:ignore ?></li>
						<li><?php printf( esc_html__( 'Parameter %s : Latitude and Longitude', 'parsijoo-map' ), '<code>latlng</code>' ); //phpcs:ignore ?></li>
						<li><?php printf( esc_html__( 'Parameter %s : Map zoom', 'parsijoo-map' ), '<code>zoom</code>' ); //phpcs:ignore ?></li>
						<li><?php printf( esc_html__( 'Parameter %s : The height of the map', 'parsijoo-map' ), '<code>height</code>' ); //phpcs:ignore ?></li>
					</ul>
					<input type="text" class="input-example" value='[parsijoo_map_circle latlng="34.627821624020775,50.866999626159675" zoom="13" height="400"  radius="1000"]'>
				</div>
			</div>
		</div>
	</div>

	<div id="polygon-shortcode" class="postbox">
		<h2 class="hndle ui-sortable-handle pad10 margin-0">
			<span>
				<span class="nasimnet-map-icon dashicons dashicons-star-empty"></span>
				<?php esc_html_e( 'Polygon Shortcode', 'parsijoo-map' ); ?>
			</span>
		</h2>
		<div class="inside">
			<div class="main">
				<div class="map-polygon">
				<?php echo do_shortcode( '[parsijoo_map_polygon  height="400" polygon="31.881134, 54.319148-31.879512, 54.311713-31.877325, 54.314320"]' ); ?>
				<ul class="parametrs">
                    <li><?php printf( __( 'ShortCode %s', 'parsijoo-map' ), '<code>[parsijoo_map_polygon]</code>' ); //phpcs:ignore ?></li>
                    <li><?php printf( __( 'Parameter %s : To use the parameter polygon, the latitude and longitude must be separated by "-"', 'parsijoo-map' ), '<code>polygon</code>' ); //phpcs:ignore ?></li>
                    <li><?php printf( __( 'Parameter %s : Map zoom', 'parsijoo-map' ), '<code>zoom</code>' ); //phpcs:ignore ?>
                    </li><li><?php printf( __( 'Parameter %s : The height of the map', 'parsijoo-map' ), '<code>height</code>' ); //phpcs:ignore ?></li>
				</ul>
				<input type="text" class="input-example" value='[parsijoo_map_polygon  height="400" polygon="31.881134, 54.319148-31.879512, 54.311713-31.877325, 54.314320"]'>
			</div>
			</div>
		</div>
	</div>

	<div class="copyright">
		<p>
			<?php
			printf(
                esc_html__( 'Developed with %1$s - Version %2$s', 'parsijoo-map' ), //phpcs:ignore
				'<a href="https://nasimnet.ir" target="_blank">nasimnet</a>',
				esc_html( NASIMNET_PMAP_VERSION )
			);
			?>
		</p>
	</div>    
</div>
