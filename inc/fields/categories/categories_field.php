<?php

	/*
	 *	Advanced Custom Fields - New field template
	 *
	 *	Create your field's functionality below and use the function:
	 *	register_field($class_name, $file_path) to include the field
	 *	in the acf plugin.
	 *
	 *	Documentation:
	 *
	 */

	class Categories_field extends acf_Field {

		/*--------------------------------------------------------------------------------------
		 *
		 *	Constructor
		 *	- This function is called when the field class is initalized on each page.
		 *	- Here you can add filters / actions and setup any other functionality for your field
		 *
		 *	@author Elliot Condon
		 *	@since 2.2.0
		 *
		 *-------------------------------------------------------------------------------------*/

		function __construct($parent) {
			// do not delete!
			parent::__construct($parent);
			// set name / title
			$this->name = 'categories';
			// variable name (no spaces / special characters / etc)
			$this->title = __("Categories", 'acf');
			// field label (Displayed in edit screens)

		}


		/*--------------------------------------------------------------------------------------
	   *
	   *	create_options
	   *	- this function is called from core/field_meta_box.php to create extra options
	   *	for your field
	   *
	   *	@params
	   *	- $key (int) - the $_POST obejct key required to save the options to the field
	   *	- $field (array) - the field object
	   *
	   *	@author Nontas Ravazoulas
	   *	@since 1.0.0
	   *
	   *-------------------------------------------------------------------------------------*/

		function create_options($key, $field) {
			// defaults
            $field['post_type']    = isset($field['post_type']) ? $field['post_type'] : 'post';
            $field['child_of']     = isset($field['child_of']) ? $field['child_of'] : '0';
            $field['parent']       = isset($field['parent']) ? $field['parent'] : '';
            $field['hide_empty']   = isset($field['hide_empty']) ? $field['hide_empty'] : '1';
            $field['hierarchical'] = isset($field['hierarchical']) ? $field['hierarchical'] : '1';
            $field['taxonomy']     = isset($field['taxonomy']) ? $field['taxonomy'] : 'category';
            $field['include']      = isset($field['include']) ? $field['include'] : '';
            $field['exclude']      = isset($field['exclude']) ? $field['exclude'] : '';
            $field['display_type'] = isset($field['display_type']) ? $field['display_type'] : '1';
            $field['ret_val']      = isset($field['ret_val']) ? $field['ret_val'] : 'category_slug';
            $field['orderby']      = isset($field['orderby']) ? $field['orderby'] : 'id';
            $field['order']        = isset($field['order']) ? $field['order'] : 'ASC';

?>

		<tr class  = "field_option field_option_<?php echo $this->name;?>">
			<td class = "label">
				<label><?php _e("Type", 'acf');?></label>

				<p class="description">
					<a href="http://codex.wordpress.org/Function_Reference/get_categories"
					   target="_blank">See Documentation
					</a>
				</p>

			</td>
			<td>
				<?php
                    $args = array(
                        'public' => true,
                        '_builtin' => false
                   );
                    $post_types = get_post_types($args, 'objects');
                    $types = array();
                    $types['post'] = 'Post';

                    foreach ($post_types as $post_type) {
                        $types[$post_type->name] = $post_type->label;
                    }

                    $this->parent->create_field(array(
						'type'    => 'select',
						'name'    => 'fields[' . $key . '][post_type]',
						'value'   => $field['post_type'],
						'choices' => $types
                   ));
                    unset($types);
                ?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Child Of", 'acf');?></label>

				<p class="description">
					<a href="http://codex.wordpress.org/Function_Reference/get_categories"
					   target="_blank">See Documentation
					</a>
				</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'  => 'text',
						 'name'  => 'fields[' . $key . '][child_of]',
						 'value' => $field['child_of'],
				  ));
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Parent", 'acf');?></label>

				<p class="description">
					<a href="http://codex.wordpress.org/Function_Reference/get_categories"
					   target="_blank">See Documentation
					</a>
				</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'  => 'text',
						 'name'  => 'fields[' . $key . '][parent]',
						 'value' => $field['parent'],
				  ));
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Order By", 'acf');?></label>

				<p class="description">
					<a href="http://codex.wordpress.org/Function_Reference/get_categories"
					   target="_blank">See Documentation
					</a>
				</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'    => 'select',
						 'name'    => 'fields[' . $key . '][orderby]',
						 'value'   => $field['orderby'],
						 'choices' => array (
							 'id'    => 'Category ID',
							 'name'  => 'Category Title',
							 'slug'  => 'Category Slug',
							 'count' => 'Categories Count'
						)
				  ));
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Order", 'acf');?></label>

				<p class="description">
					<a href="http://codex.wordpress.org/Function_Reference/get_categories"
					   target="_blank">See Documentation
					</a>
				</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'    => 'radio',
						 'name'    => 'fields[' . $key . '][order]',
						 'value'   => $field['order'],
						 'choices' => array (
							 'ASC'  => 'Asc',
							 'DESC' => 'Desc',
						),
						 'layout'  => 'horizontal',
				  ));
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Hide Empty", 'acf');?></label>

				<p class="description">
					<a href="http://codex.wordpress.org/Function_Reference/get_categories"
					   target="_blank">See Documentation
					</a>
				</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'    => 'radio',
						 'name'    => 'fields[' . $key . '][hide_empty]',
						 'value'   => $field['hide_empty'],
						 'choices' => array (
							 '1' => 'Yes',
							 '0' => 'No',
						),
						 'layout'  => 'horizontal',
				  ));
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Hierarchical", 'acf');?></label>

				<p class="description">
					<a href="http://codex.wordpress.org/Function_Reference/get_categories"
					   target="_blank">See Documentation
					</a>
				</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'    => 'radio',
						 'name'    => 'fields[' . $key . '][hierarchical]',
						 'value'   => $field['hierarchical'],
						 'choices' => array (
							 '1' => 'Yes',
							 '0' => 'No',
						),
						 'layout'  => 'horizontal',
				  ));
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Taxonomy", 'acf');?></label>

				<p class="description">
					<a href="http://codex.wordpress.org/Function_Reference/get_categories"
					   target="_blank">See Documentation
					</a>
				</p>

			</td>
			<td>
				<?php
				$args       = array (
					'public' => true
				);
				$post_types = get_taxonomies($args, 'objects');
				$taxonomies = array ();

				foreach ($post_types as $post_type) {
					$taxonomies[$post_type->name] = $post_type->label;
				}

				$this->parent->create_field(array (
					   'type'    => 'select',
					   'name'    => 'fields[' . $key . '][taxonomy]',
					   'value'   => $field['taxonomy'],
					   'choices' => $taxonomies
				));

				unset($taxonomies);
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Include Categories", 'acf');?></label>

				<p class="description">
					<a href="http://codex.wordpress.org/Function_Reference/get_categories"
					   target="_blank">See Documentation
					</a>
				</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'  => 'text',
						 'name'  => 'fields[' . $key . '][include]',
						 'value' => $field['include'],
				  ));
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Exclude Categories", 'acf');?></label>

				<p class="description">
					<a href="http://codex.wordpress.org/Function_Reference/get_categories"
					   target="_blank">See Documentation
					</a>
				</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'  => 'text',
						 'name'  => 'fields[' . $key . '][exclude]',
						 'value' => $field['exclude'],
				  ));
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Display Type", 'acf');?></label>

				<p class="description">The display type in admin area. Dropdown or Multicheckboxes</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'    => 'select',
						 'name'    => 'fields[' . $key . '][display_type]',
						 'value'   => $field['display_type'],
						 'choices' => array (
							 'drop_down'  => 'Drop Down',
							 'checkboxes' => 'Checkboxes',
						)
				  ));
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Show All", 'acf');?></label>

				<p class="description">
					If the 'show all' categories option should be visible
				</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'    => 'radio',
						 'name'    => 'fields[' . $key . '][show_all]',
						 'value'   => (isset($field['show_all']) ? $field['show_all'] : null),
						 'choices' => array (
							 '1' => 'Yes',
							 '0' => 'No',
						),
						 'layout'  => 'horizontal',
				  ));
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Show None", 'acf');?></label>

				<p class="description">
					If the 'show none' categories option should be visible
				</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'    => 'radio',
						 'name'    => 'fields[' . $key . '][show_none]',
						 'value'   => (isset($field['show_none']) ? $field['show_none'] : null),
						 'choices' => array (
							 '1' => 'Yes',
							 '0' => 'No',
						),
						 'layout'  => 'horizontal',
				  ));
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Show Parent", 'acf');?></label>

				<p class="description">
					If true displays category parent in Parent->Child format, in the admin
				</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'    => 'radio',
						 'name'    => 'fields[' . $key . '][show_parent]',
						 'value'   => (isset($field['show_parent']) ? $field['show_parent'] : null),
						 'choices' => array (
							 '1' => 'Yes',
							 '0' => 'No',
						),
						 'layout'  => 'horizontal',
				  ));
				?>
			</td>
		</tr>

		<tr class="field_option field_option_<?php echo $this->name;?>">
			<td class="label">
				<label><?php _e("Return Value", 'acf');?></label>

				<p class="description">The return type when retrieving value from API. ID, Name, Taxonomy, Parent, Link <a
					href="http://codex.wordpress.org/Function_Reference/wp_dropdown_categories" target="_blank">Dropdown
					- See Documentation</a>
				</p>
			</td>
			<td>
				<?php $this->parent->create_field(array (
						 'type'    => 'select',
						 'name'    => 'fields[' . $key . '][ret_val]',
						 'value'   => $field['ret_val'],
						 'choices' => array (
							'category_slug'     => 'Categories Slug',
							'category_name'     => 'Category Name',
							'category_id'       => 'Category ID',
							'category_dropdown' => 'Categories DropDown',
							'category_taxonomy' => 'Categories Taxonomy',
							'category_parent'   => 'Categories Parent',
							'category_link'     => 'Categories Link'
						)
				  ));
				?>
			</td>
		</tr>

		<?php
		}


		/*--------------------------------------------------------------------------------------
		 *
		 *	pre_save_field
		 *	- this function is called when saving your acf object. Here you can manipulate the
		 *	field object and it's options before it gets saved to the database.
		 *
		 *	@author Elliot Condon
		 *	@since 2.2.0
		 *
		 *-------------------------------------------------------------------------------------*/

		function pre_save_field($field) {
			// do stuff with field (mostly format options data)

			return parent::pre_save_field($field);
		}


		/*--------------------------------------------------------------------------------------
		 *
		 *	create_field
		 *	- this function is called on edit screens to produce the html for this field
		 *
		 *  @author Nontas Ravazoulas
		 *  @since 1.0.0
		 *
		 *-------------------------------------------------------------------------------------*/

		function create_field($field) {
			$field['value'] = isset($field['value']) ? $field['value'] : '';
			$type           = (isset($field['post_type'])) ? (empty($field['post_type']) ? 'post' : $field['post_type']) : 'post';
			$child_of       = (isset($field['child_of'])) ? (empty($field['child_of']) ? 0 : $field['child_of']) : 0;
			$parent         = (isset($field['parent'])) ? ((empty($field['parent']) && $field['parent'] != 0) ? '' : $field['parent']) : '';
			$hide_empty     = isset($field['hide_empty']) ? $field['hide_empty'] : '1';
			$hierarchical   = isset($field['hierarchical']) ? $field['hierarchical'] : '1';
			$taxonomy       = (isset($field['taxonomy'])) ? (empty($field['taxonomy']) ? 'category' : $field['taxonomy']) : 'category';
			$include        = (isset($field['include'])) ? (empty($field['include']) ? '' : $field['include']) : '';
			$exclude        = (isset($field['exclude'])) ? (empty($field['exclude']) ? '' : $field['exclude']) : '';
			$orderby        = (isset($field['orderby'])) ? (empty($field['orderby']) ? 'name' : $field['orderby']) : 'name';
			$order          = (isset($field['order'])) ? (empty($field['order']) ? 'ASC' : $field['order']) : 'ASC';
			$show_all       = isset($field['show_all']) ? $field['show_all'] : '1';
			$show_none      = isset($field['show_none']) ? $field['show_none'] : '1';
			$show_parent      = isset($field['show_none']) ? $field['show_parent'] : '1';

			$args = array (
				'type'         => $type,
				'child_of'     => $child_of,
				'parent'       => $parent,
				'hide_empty'   => $hide_empty,
				'hierarchical' => $hierarchical,
				'exclude'      => $exclude,
				'include'      => $include,
				'taxonomy'     => $taxonomy,
				'orderby'      => $orderby,
				'order'        => $order,
				'pad_counts'   => 1
			);
			$categories     = get_categories($args);
			$selected_value = $field['value'];
			$is_selected    = '';
			?>

		<?php if ($field['display_type'] == 'drop_down') : ?>
			<select id="<?php echo $field['name'] ?>" class="<?php echo $field['class'] ?>" name="<?php echo $field['name'] ?>">
				<?php if ($show_all): ?>
				<?php if ($selected_value == "all") {
					$is_selected = 'selected="selected"';
				} ?>
				<option value="all" <?php echo $is_selected ?>>Show All</option>
				<?php endif ?>

				<?php if ($show_none): ?>
				<?php if ($selected_value == "none") {
					$is_selected = 'selected="selected"';
				} ?>
				<option value="none" <?php echo $is_selected ?>>Show None</option>
				<?php endif ?>

				<?php foreach ($categories as $category) : ?>
				<?php if ($category->slug == $selected_value) {
					$is_selected = 'selected="selected"';
				} else {
					$is_selected = '';
				} ?>
				<?php $category_name = $category->name ?>
				<?php if($show_parent) : ?>
					<?php if($category->parent > 0) : ?>
						<?php $category_name = get_cat_name($category->parent) . '->' . $category->name; ?>
					<?php endif; ?>
				<?php endif; ?>
				<option value="<?php echo $category->slug ?>" <?php echo $is_selected ?>><?php echo $category_name ?></option>
				<?php endforeach ?>
			</select>
			<?php endif ?>

		<?php if ($field['display_type'] == 'checkboxes') : ?>
			<ul>
				<?php if ($show_all): ?>
				<?php if (in_array("all", $field['value'])) {
					$is_selected = 'checked';
				} else {
					$is_selected = '';
				} ?>
				<li>
					<input id="<?php echo $field['key'] . '_all' ?>" name="<?php echo $field['name'] . '[]' ?>"
						   type="checkbox" value="all" <?php echo $is_selected ?> />&nbsp;Show All
				</li>
				<?php endif ?>

				<?php
                    if (!$show_none) {
                        $display_none = ' style="display:none"';
                    } else {
                        $display_none = '';
                    }
                ?>
				<?php if (in_array("none", $field['value'])) {
					$is_selected = 'checked';
				} else {
					$is_selected = '';
				} ?>
				<li<?php echo $display_none; ?>>
					<input id="<?php echo $field['key'] . '_none' ?>" name="<?php echo $field['name'] . '[]' ?>"
						   type="checkbox" value="none" <?php echo $is_selected ?> />&nbsp;Show None
				</li>

				<?php foreach ($categories as $category) : ?>
				<?php if (is_array($field['value'])): ?>
					<?php if (in_array($category->slug, $field['value'])) {
						$is_selected = 'checked';
					} else {
						$is_selected = '';
					} ?>
					<?php endif ?>
				<li>
					<?php $category_name = $category->name ?>
					<?php if($show_parent) : ?>
						<?php if($category->parent > 0) : ?>
							<?php $category_name = get_cat_name($category->parent) . '->' . $category->name; ?>
						<?php endif; ?>
					<?php endif; ?>
					<input id="<?php echo $field['key'] . '_'.$category->slug; ?>" name="<?php echo $field['name'] . '[]' ?>"
						   type="checkbox" value="<?php echo $category->slug ?>" <?php echo $is_selected ?> /> <?php echo $category_name ?>
				</li>
				<?php endforeach ?>
			</ul>
            <script type="text/javascript">
	            jQuery('#post').submit(function() {
	                var any_checked = false;

	                jQuery('.field-categories ul li input').each(function() {
	                    if(jQuery(this).is(':checked')) {
	                        any_checked = true;
	                    }
	                    var field_name = jQuery(this).attr('name');
	                });

	                if(!any_checked) {
	                   var select_none_id = '#<?php echo $field['key'].'_none'; ?>';
	                   jQuery(select_none_id).attr('checked','checked');
	                }
	            });
            </script>
			<?php endif ?>
		<?php
		}


		/*--------------------------------------------------------------------------------------
		 *
		 *	admin_head
		 *	- this function is called in the admin_head of the edit screen where your field
		 *	is created. Use this function to create css and javascript to assist your
		 *	create_field() function.
		 *
		 *	@author Elliot Condon
		 *	@since 2.2.0
		 *
		 *-------------------------------------------------------------------------------------*/

		/*--------------------------------------------------------------------------------------
		 *
		 *	admin_print_scripts / admin_print_styles
		 *	- this function is called in the admin_print_scripts / admin_print_styles where
		 *	your field is created. Use this function to register css and javascript to assist
		 *	your create_field() function.
		 *
		 *	@author Elliot Condon
		 *	@since 3.0.0
		 *
		 *-------------------------------------------------------------------------------------*/

		function admin_print_scripts() {
		}


		function admin_print_styles() {
		}


		/*--------------------------------------------------------------------------------------
		 *
		 *	update_value
		 *	- this function is called when saving a post object that your field is assigned to.
		 *	the function will pass through the 3 parameters for you to use.
		 *
		 *	@params
		 *	- $post_id (int) - usefull if you need to save extra data or manipulate the current
		 *	post object
		 *	- $field (array) - usefull if you need to manipulate the $value based on a field option
		 *	- $value (mixed) - the new value of your field.
		 *
		 *	@author Elliot Condon
		 *	@since 2.2.0
		 *
		 *-------------------------------------------------------------------------------------*/

		function update_value($post_id, $field, $value) {
			// do stuff with value

			// save value
			parent::update_value($post_id, $field, $value);
		}


		/*--------------------------------------------------------------------------------------
		 *
		 *	get_value
		 *	- called from the edit page to get the value of your field. This function is useful
		 *	if your field needs to collect extra data for your create_field() function.
		 *
		 *	@params
		 *	- $post_id (int) - the post ID which your value is attached to
		 *	- $field (array) - the field object.
		 *
		 *	@author Elliot Condon
		 *	@since 2.2.0
		 *
		*-------------------------------------------------------------------------------------*/

		function get_value($post_id, $field) {
			// get value
			$value = parent::get_value($post_id, $field);

			// format value

			// return value
			return $value;
		}


		/*--------------------------------------------------------------------------------------
		 *
		 *	get_value_for_api
		 *	- called from your template file when using the API functions (get_field, etc).
		 *	This function is useful if your field needs to format the returned value
		 *
		 *	@params
		 *	- $post_id (int) - the post ID which your value is attached to
		 *	- $field (array) - the field object.
		 *
		 *	@author Elliot Condon
		 *	@since 3.0.0
		 *
		 *-------------------------------------------------------------------------------------*/

		function get_value_for_api($post_id, $field) {
			// get value
			$value   = $this->get_value($post_id, $field);
			$ret_val = '';

			$type         = (isset($field['post_type'])) ? (empty($field['post_type']) ? 'post' : $field['post_type']) : 'post';
			$child_of     = (isset($field['child_of'])) ? (empty($field['child_of']) ? 0 : $field['child_of']) : 0;
			$parent       = (isset($field['parent'])) ? (empty($field['parent']) ? '' : $field['parent']) : '';
			$hide_empty   = isset($field['hide_empty']) ? $field['hide_empty'] : '1';
			$hierarchical = isset($field['hierarchical']) ? $field['hierarchical'] : '1';
			$taxonomy     = (isset($field['taxonomy'])) ? (empty($field['taxonomy']) ? 'category' : $field['taxonomy']) : 'category';
			$include      = (isset($field['include'])) ? (empty($field['include']) ? '' : $field['include']) : '';
			$exclude      = (isset($field['exclude'])) ? (empty($field['exclude']) ? '' : $field['exclude']) : '';
			$orderby      = (isset($field['orderby'])) ? (empty($field['orderby']) ? 'name' : $field['orderby']) : 'name';
			$order        = (isset($field['order'])) ? (empty($field['order']) ? 'ASC' : $field['order']) : 'ASC';
			$is_all       = false;

			$args = array (
				'type'         => $type,
				'child_of'     => $child_of,
				'parent'       => $parent,
				'hide_empty'   => $hide_empty,
				'hierarchical' => $hierarchical,
				'exclude'      => $exclude,
				'include'      => $include,
				'taxonomy'     => $taxonomy,
				'orderby'      => $orderby,
				'order'        => $order,
				'pad_counts'   => 1,
				'echo'         => 0
			);

			if ($field['display_type'] == 'drop_down') {
				if ($value == "all" || $value == "none") {
					return $value;
				}

				$value = get_term_by('slug', $value, $field['taxonomy']);

				switch ($field['ret_val']) {
					case 'category_slug':
						$ret_val = $value->slug;
						break;
					case 'category_name':
						$ret_val = $value->name;
						break;
					case 'category_dropdown':
						return wp_dropdown_categories($args);
						break;
					case 'category_id':
						$ret_val = $value->term_id;
						break;
					case 'category_taxonomy':
						$ret_val = $value->taxonomy;
						break;
					case 'category_parent':
						$ret_val = $value->parent;
						break;
					case 'category_link':
						$category_link = get_term_link($value->slug, $value->taxonomy);
						$ret_val       = $category_link;
						break;
				}
			}


			if ($field['display_type'] == 'checkboxes') {
				$ret_val = array ();

				if (is_array($value)) {
                                        // none is not a category - we don't need to return it
					if (in_array("none", $value)) {
                                            $index = array_search('none',$value);
                                            unset($value[$index]);
					}

					if (in_array("all", $value)) {
						$value  = get_categories($args);
						$is_all = true;
					}
				}

				switch ($field['ret_val']) {
					case 'category_slug':
						foreach ($value as $ret_value) {
							if ($is_all) {
								$value = get_term_by('slug', $ret_value->slug, $field['taxonomy']);
							} else {
								$value = get_term_by('slug', $ret_value, $field['taxonomy']);
							}
							array_push($ret_val, $value->slug);
						}
						break;
					case 'category_name':
						foreach ($value as $ret_value) {
							if ($is_all) {
								$value = get_term_by('slug', $ret_value->slug, $field['taxonomy']);
							} else {
								$value = get_term_by('slug', $ret_value, $field['taxonomy']);
							}
							array_push($ret_val, $value->name);
						}
						break;
					case 'category_dropdown':
						return wp_dropdown_categories($args);
						break;
					case 'category_id':
						foreach ($value as $ret_value) {
							if ($is_all) {
								$value = get_term_by('slug', $ret_value->slug, $field['taxonomy']);
							} else {
								$value = get_term_by('slug', $ret_value, $field['taxonomy']);
							}
							array_push($ret_val, $value->term_id);
						}
						break;
					case 'category_taxonomy':
						foreach ($value as $ret_value) {
							if ($is_all) {
								$value = get_term_by('slug', $ret_value->slug, $field['taxonomy']);
							} else {
								$value = get_term_by('slug', $ret_value, $field['taxonomy']);
							}
							array_push($ret_val, $value->taxonomy);
						}
						break;
					case 'category_parent':
						foreach ($value as $ret_value) {
							if ($is_all) {
								$value = get_term_by('slug', $ret_value->slug, $field['taxonomy']);
							} else {
								$value = get_term_by('slug', $ret_value, $field['taxonomy']);
							}
							array_push($ret_val, $value->parent);
						}
						break;
					case 'category_link':
						foreach ($value as $ret_value) {
							if ($is_all) {
								$value = get_term_by('slug', $ret_value->slug, $field['taxonomy']);
							} else {
								$value = get_term_by('slug', $ret_value, $field['taxonomy']);
							}
							$category_link = get_term_link($value->slug, $value->taxonomy);
							array_push($ret_val, $category_link);
						}
						break;
				}
			}

			return $ret_val;
		}
	}

?>