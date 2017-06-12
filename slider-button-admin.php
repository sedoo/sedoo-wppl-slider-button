<?php 

/**
 * @todo validation de formulaire en fonction des données entrées
 */

/* Vérifie que ACF est installé */
if ( !function_exists('get_field') ) return;

/**
 * Gestion des données du formulaire 
 */
if ( isset($_POST['sb_hidden']) && $_POST['sb_hidden'] == 'Y' ) {
	
	// données du formulaire envoyées

	/*
		On enregistre la valeur envoyée dans la variable
	*/
	$acf_name 	= $_POST['sb_acf_name'];
	$choice 	= $_POST['sb_choice'];
	$source 	= $_POST['sb_source'];
	$caption 	= $_POST['sb_caption'];
	$repeater 	= $_POST['sb_repeater'];
	$_img 		= $_POST['sb_image'];
	$_content 	= $_POST['sb_content'];
	$_link 		= $_POST['sb_link'];
	$_title 	= $_POST['sb_title'];

	/*
		On met à jour la table "wp_options" dans la BDD 
		on crée ou met à jour les champs 'sb_XXX' avec les valeurs $XXX
	*/
	update_option( 'sb_acf_name', $acf_name ); // ($option_name, $option_value)
	update_option( 'sb_choice'	, $choice 	); 
	update_option( 'sb_source'	, $source 	);
	update_option( 'sb_caption'	, $caption 	);
	update_option( 'sb_repeater', $repeater );
	update_option( 'sb_image'	, $_img 	);
	update_option( 'sb_content'	, $_content );
	update_option( 'sb_link'	, $_link 	);
	update_option( 'sb_title'	, $_title 	);

	// Requête qui retourne tous les posts du Custom Post Type 'slider'
	$cpt_slider = new WP_Query( array( 'post_type'=>'slider' ) );

	if ( $cpt_slider->have_posts() ) {

		// Le custom post type 'slider' existe
		while ( $cpt_slider->have_posts() ) {
			$cpt_slider->the_post();

			// enregistrement des valeurs pour validation du formulaire
			$acf_choix = get_field($choice);
			$acf_source = get_field($source);
			$acf_caption = get_field($caption);
			$acf_repeater = get_field($repeater);

			if( have_rows($repeater) ):

			    while( have_rows($repeater) ) : the_row();
			        
					$acf_image = get_sub_field($_img);
					$acf_content = get_sub_field($_content);
					$acf_link = get_sub_field($_link);
					$acf_title = get_sub_field($_title);

			    endwhile;

			endif;
		}
		wp_reset_postdata();
	}


?>
	<!-- Affichage d'une alerte quand les options sont enregistrées -->
	<div class="updated">
		<p><strong><?php _e('Options enregistrées.'); ?></strong></p>
	</div>
<?php
} else {

	// affichage normal de la page

	/*
		On récupère les valeurs des champs 'sb_XXX'  	
		dans la table 'wp_options' de la BDD 			
	*/
	$acf_name 	= get_option( 'sb_acf_name'	); // ($option_name)
	$choice 	= get_option( 'sb_choice'	);
	$source 	= get_option( 'sb_source'	);
	$caption 	= get_option( 'sb_caption'	);
	$repeater 	= get_option( 'sb_repeater'	);
	$_img 		= get_option( 'sb_image'	);
	$_content 	= get_option( 'sb_content'	);
	$_link 		= get_option( 'sb_link'		);
	$_title 	= get_option( 'sb_title' 	);

	// Requête qui retourne tous les posts du Custom Post Type 'slider'
	$cpt_slider = new WP_Query( array( 'post_type'=>'slider' ) );

	if ( $cpt_slider->have_posts() ) {

		// Le custom post type 'slider' existe
		while ( $cpt_slider->have_posts() ) {
			$cpt_slider->the_post();

			// enregistrement des valeurs pour validation du formulaire
			$acf_choix = get_field($choice);
			$acf_source = get_field($source);
			$acf_caption = get_field($caption);
			$acf_repeater = get_field($repeater);

			if( have_rows($repeater) ):

			    while( have_rows($repeater) ) : the_row();
			        
					$acf_image = get_sub_field($_img);
					$acf_content = get_sub_field($_content);
					$acf_link = get_sub_field($_link);
					$acf_title = get_sub_field($_title);

			    endwhile;

			endif;
		}
		wp_reset_postdata();
	}
}
?>
<!-- Div de contenu de l'interface admin avec un id unique pour cibler notre plugin -->
<div class="wrap" id="admin-settings">
    <?php    echo "<h2>" . __( 'Slider Button Options', 'sb_trdom' ) . "</h2>"; ?>
     
    <form name="sliderbutton_form" id="sliderbutton_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <!-- champ caché utilisé pour savoir si la page est affichée après que l'utilisateur a cliqué sur le bouton ou pas -->
        <input type="hidden" name="sb_hidden" value="Y">

        <!-- Select qui permet de choisir le groupe de champs ACF utilisé pour les sliders -->
        <p><label for="sb_acf_name">Veuillez sélectionner le groupe de champs qui contient le template de Slider</label></p>
        <select id="sb_acf_name" name="sb_acf_name">
<?php 

// Requête qui retourne tous les posts du Custom Post Type 'slider'
$cpt_slider = new WP_Query( array( 'post_type'=>'slider' ) );

if ( $cpt_slider->have_posts() ) {

	// Le custom post type 'slider' existe

	// Requête qui retourne tous les posts du Custom Post Type 'acf-field-group' (groupes de champs)
	$cpt_acf_field_group = new WP_Query( array( 'post_type'=>'acf-field-group' ) );
	// si des groupes de champs existent
	if ( $cpt_acf_field_group->have_posts() ) {
 
		while ( $cpt_acf_field_group->have_posts() ) {
			$cpt_acf_field_group->the_post();
			$acf_id = $cpt_acf_field_group->get_the_ID();
?>
			<!-- on fait en sorte de pouvoir les sélectionner -->
			<option value="<?php echo get_the_excerpt(); ?>" <?php if (get_the_excerpt() === $acf_name) echo 'selected'; ?>><?php echo get_the_title(); ?></option>
<?php
		}
		wp_reset_postdata(); 
?>
		</select>

<?php

	} else {
?>
		<!-- il n'y a pas de groupe de champs à afficher -->
		<option value="not_found" selected disabled>Pas de champ ACF trouvé.</option>
		</select>
		<div class="updated">Veuillez créer un groupe de champs avec ACF.</div>
<?php 
	}

?>
		<!-- inputs qui permettent de lier les noms des champs au plugin -->
        <label for="sb_choice">choice</label>
        <input type="text" name="sb_choice" id="sb_choice" value="<?php echo $choice; ?>" >
        <span class="notice <?php if ($acf_choix !== NULL) echo 'input-success'; else echo 'notice-error'; ?> ">
        	<?php if ($acf_choix == NULL) echo 'Ce nom de champ n\'existe pas dans le groupe ' . $acf_name . '.'; ?>        	
        </span>
        <label for="sb_source">source</label>
        <input type="text" name="sb_source"  id="sb_source" value="<?php echo $source; ?>" >
        <span class="notice <?php if ($acf_source !== NULL) echo 'input-success'; else echo 'notice-error'; ?> ">
        	<?php if ($acf_source == NULL) echo 'Ce nom de champ n\'existe pas dans le groupe ' . $acf_name . '.'; ?>        	
        </span>
        <label for="sb_caption">caption</label>
        <input type="text" name="sb_caption"  id="sb_caption" value="<?php echo $caption; ?>" >
        <span class="notice <?php if ($acf_caption !== NULL) echo 'input-success'; else echo 'notice-error'; ?> ">
        	<?php if ($acf_caption == NULL) echo 'Ce nom de champ n\'existe pas dans le groupe ' . $acf_name . '.'; ?>        	
        </span>
        <label for="sb_repeater">repeater</label>
        <input type="text" name="sb_repeater"  id="sb_repeater" value="<?php echo $repeater; ?>" >
        <span class="notice <?php if ($acf_repeater !== NULL) echo 'input-success'; else echo 'notice-error'; ?> ">
        	<?php if ($acf_repeater == NULL) echo 'Ce nom de champ n\'existe pas dans le groupe ' . $acf_name . '.'; ?>        	
        </span>
        <label for="sb_image">image</label>
        <input type="text" name="sb_image"  id="sb_image" value="<?php echo $_img; ?>" >
        <span class="notice <?php if ( isset($acf_image) && is_array($acf_image) ) echo 'input-success'; else echo 'notice-error'; ?> ">
	        <?php 
		        if ( ! isset($acf_image) ) echo 'Le nom du repeater n\'est pas valide'; 
		        else if ( ! is_array($acf_image) ) echo 'Ce nom de champ n\'existe pas dans le groupe ' . $acf_name . '.'; 
	        ?>	
        </span>
        <label for="sb_content">content</label>
        <input type="text" name="sb_content"  id="sb_content" value="<?php echo $_content; ?>" >
        <span class="notice <?php if ( isset($acf_content) && $acf_content !== false ) echo 'input-success'; else echo 'notice-error'; ?> ">
        	<?php 
        		if ( ! isset($acf_content) ) echo 'Le nom du repeater n\'est pas valide';
        		else if ( $acf_content === false ) echo 'Ce nom de champ n\'existe pas dans le groupe ' . $acf_name . '.'; 
        	?>
        </span>
        <label for="sb_link">link</label>
        <input type="text" name="sb_link"  id="sb_link" value="<?php echo $_link; ?>" >
        <span class="notice <?php if ( isset($acf_link) && $acf_link !== false ) echo 'input-success'; else echo 'notice-error'; ?> ">
        	<?php 
        		if ( ! isset($acf_link) ) echo 'Le nom du repeater n\'est pas valide';
        		else if ( $acf_link === false ) echo 'Ce nom de champ n\'existe pas dans le groupe ' . $acf_name . '.'; 
        	?>
        </span>
        <label for="sb_title">title</label>
        <input type="text" name="sb_title"  id="sb_title" value="<?php echo $_title; ?>" >
        <span class="notice <?php if ( isset($acf_title) && $acf_title !== false ) echo 'input-success'; else echo 'notice-error'; ?> ">
        	<?php 
        		
        		if ( ! isset($acf_title) ) echo 'Le nom du repeater n\'est pas valide';
        		else if ( $acf_title === false) echo 'Ce nom de champ n\'existe pas dans le groupe ' . $acf_name . '.'; 
        	?>
        </span>

		<script>
        	
        	/* Indication sur les données envoyées */
			var inputs = document.querySelectorAll('input[type="text"]'); 
			var spans = document.querySelectorAll('input+span');

			for (var i = 0 ; i < spans.length ; i++) {
				if (spans[i].hasAttribute('class')) {
					var notice = spans[i];

					var inputSibling = notice.previousSibling.previousSibling;
					var noticeError = notice.className.match(/\bnotice-error\b/);
					var noticeSuccess = notice.className.match(/\binput-success\b/);

					if ( noticeError ) {
						inputSibling.style.borderColor = "red";
					} else if ( noticeSuccess ) {
						notice.style.display = "none";
						inputSibling.style.borderColor = "green";
					}					
				}
			}

        </script>
<?php
} else {
	// Le CPT 'slider' n'existe pas
	/**
	 * Fonction qui crée le CPT 'slider' 
	 */
	function sb_register_slider() {		
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
				'has_archive' => true 
			) 
		);
	}
	add_action( 'init', 'sb_register_slider' );
}
?>

    	<input class="submit" type="submit" name="Submit" value="<?php _e('Valider', 'sb_trdom' ) ?>" />

    </form>
</div>

<?php 
