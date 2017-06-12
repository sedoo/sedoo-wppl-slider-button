<?php
/**
 * Code pour enregistrer un Custom Post Type (CPT) `em_slider`
 * @package em_slider
 */
add_action( 'init', 'em_slider_cpt' );
/**
 * Enregistrer un CPT public
 */
function em_slider_cpt() {
	// Bonne pratique : le type de Post doit être préfixé, au singulier, et ne devrait pas dépasser 20 caractères
	register_post_type( 
		'slider', 							
		array(
			'label' => 'Sliders', 			
			'labels' => array(    			
				'name' => 'Sliders',
				'singular-name' => 'Slider',
				'all_items' => 'Tous les sliders',
				'add_new_item' => 'Ajouter un slider',
				'edit_item' => 'Editer le slider',
				'new_item' => 'Nouveau slider',
				'view_item' => 'Voir le slider',
				'search_item' => 'Rechercher parmis les sliders',
				'not_found' => 'Pas de slider trouvé',
				'not_found_in_trash' => 'Pas de slider dans la corbeille'
			),
			'public' => true, 				
			'show_in_rest' => true,         
			'capability_type' => 'post',	
			'supports' => array(			
				'title',
				'thumbnail',
				'editor'	
			),
			'has_archive' => true, 
			// Url vers une icone ou à choisir parmi celles de WP : https://developer.wordpress.org/resource/dashicons/.
			'menu_icon'   => 'dashicons-images-alt2'
		) 
	);
}