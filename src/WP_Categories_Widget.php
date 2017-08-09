<?php
Namespace DMG\WP_Categories_Widget;

/*
	Related pages widget class.

    Copyright (C) 2016  Dan Gifford

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

Use DMG\WP_Widget_Base\WP_Widget_Base;


class WP_Categories_Widget extends WP_Widget_Base {

	public function __construct()
	{
		// Instantiate the parent object
		parent::__construct( 
			'dmg_categories_widget',
			__('DMG Categories List'), 
			[
				'classname' => 'widget_categories', 
				'description' => __( "A list or dropdown of categories.")
			] 
		);
	}


	public function widget( $args, $instance )
	{
		$count 			= ! empty( $instance['count'] ) ? '1' : '0';
		$hierarchical 	= ! empty( $instance['hierarchical'] ) ? '1' : '0';
		$dropdown  		= ! empty( $instance['dropdown'] ) ? '1' : '0';
		$taxonomy 		= ! empty( $instance['taxonomy'] ) ? $instance['taxonomy'] : 'category';
		$list_class 	= ! empty( $instance['list_class'] ) ? $instance['list_class'] : '';
		$orderby 		= ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'name';

		echo $args['before_widget'];
		echo $this->getTitle( $args, $instance, $this->id_base . '_title' );


		$cat_args = array('orderby' => $orderby, 'show_count' => $count, 'hierarchical' => $hierarchical, 'taxonomy' => $taxonomy);

		if ( $dropdown ) {
			$cat_args['show_option_none'] = __('Select Category');

			/**
			 * Filter the arguments for the Categories widget drop-down.
			 *
			 * @since 2.8.0
			 *
			 * @see wp_dropdown_categories()
			 *
			 * @param array $cat_args An array of Categories widget drop-down arguments.
			 */
			wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args ) );
?>

<script type='text/javascript'>
/* <![CDATA[ */
	var dropdown = document.getElementById("cat");
	function onCatChange() {
		if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
			location.href = "<?php echo home_url(); ?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
		}
	}
	dropdown.onchange = onCatChange;
/* ]]> */
</script>

<?php
		} else {

		echo '<ul';
		if(!empty($list_class))
		{
			echo ' class="'.$list_class.'">';
		}
		else
		{
			echo '>';
		}

		$cat_args['title_li'] = '';


		/**
		 * Filter the arguments for the Categories widget.
		 *
		 * @since 2.8.0
		 *
		 * @param array $cat_args An array of Categories widget options.
		 */
		wp_list_categories( apply_filters( 'widget_categories_args', $cat_args ) );
?>
		</ul>
<?php
		}

		echo $args['after_widget'];
	}



	public function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['count'] 			= !empty($new_instance['count']) ? 1 : 0;
		$instance['hierarchical'] 	= !empty($new_instance['hierarchical']) ? 1 : 0;
		$instance['dropdown'] 		= !empty($new_instance['dropdown']) ? 1 : 0;
		$instance['taxonomy'] 		= strip_tags($new_instance['taxonomy']);
		$instance['list_class'] 	= strip_tags($new_instance['list_class']);
		$instance['orderby'] 		= strip_tags($new_instance['orderby']);
		$instance['title_url'] 		= esc_url($new_instance['title_url']);
		$instance['show_title'] 	= $this->sanitizeBoolean($new_instance['show_title']);

		$this->deleteCacheOptions();

		return $instance;
	}



	public function form( $instance )
	{
		$instance = wp_parse_args( (array) $instance, ['title' => '', 'count' => false, 'hierarchical' => false, 'dropdown' => false, 'taxonomy' => 'category', 'list_class' => '', 'orderby' => 'name', 'show_title' => 1,'title_url' => ''] );

		//Defaults
		$count 			= isset( $instance['count']) 			? (bool) $instance['count'] :false;
		$hierarchical 	= isset( $instance['hierarchical'] ) 	? (bool) $instance['hierarchical'] : false;
		$dropdown 		= isset( $instance['dropdown'] ) 		? (bool) $instance['dropdown'] : false;

		$this->textControl( 'title', 'Title:', $this->sanitizeTitle($instance['title']) );

		$this->taxonomySelectControl( 'taxonomy', 'Taxonomy:',  esc_attr($instance['taxonomy']) );

		$this->openAdvancedSection();

			$this->textControl( 'title_url', 'URL for the title (make the title a link):', esc_url( $instance['title_url'] ) );

			$this->booleanControl( 'show_title', 'Show the Title', $this->sanitizeBoolean( $instance['show_title'] ) );

			$this->textControl( 'list_class', 'CSS class(es) applied to list wrapper:', $this->sanitizeCSSClasses( $instance['list_class'] ) );

			$this->textControl( 'orderby', 'Order by:',  esc_attr($instance['orderby']) );

			$this->booleanControl( 'dropdown', 'Display as dropdown', $this->sanitizeBoolean( $instance['dropdown'] ) );

			$this->booleanControl( 'count', 'Show post counts', $this->sanitizeBoolean( $instance['count'] ) );

			$this->booleanControl( 'hierarchical', 'Show hierarchy', $this->sanitizeBoolean( $instance['hierarchical'] ) );

		$this->closeAdvancedSection();
	}
}