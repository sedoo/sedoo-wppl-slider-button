/**
 * Permet de gérer les interactions avec le Slider, qu'il soit en mode "survol" ou "slider" 
 */

( function( $ ) {

	console.log('plugin ready');

	/**
	 * Mode Survol
	 */

	/* On prépare une liste ul vide pour afficher les légendes des images */
	$('section.survol+article').each(function() {
		var list = document.createElement('ul');
		list.setAttribute('class', 'legendes');
		$(this).append(list);
	});
	
	/* Tableau d'objets qui contient les légendes de chaque image */
	var captions = [{
		key: "",
		value: ""
	}];

	$('.survol nav a').each(function() {
		// on stocke la valeur de l'attribut data-img de chaque lien
		var dataImg = $(this).attr('data-img'); 
		var caption = $(this).parents('section.survol').children('.slides').children('figure[data-img="'+dataImg+'"]').children('figcaption').html();

		// on cache les légendes de chaque image de survol
		$('figure[data-img="'+dataImg+'"] > figcaption').hide();

		var obj = {};
		obj.key = dataImg;
		obj.value = caption;

		// on remplit un tableau avec le contenu des figcaption
		captions.push(obj);
		
		$(this).click(function (e) {
			// on empêche le comportement par défaut
			e.preventDefault(); 
			$(this).toggleClass('active'); 
			// on fait apparaître ou disparaître l'image qui possède la même valeur d'attribut data-img que le lien cliqué
			$(this).parent().next().children('[data-img="'+dataImg+'"]').css("z-index","1").toggleClass('hidden');

			var listElement = document.createElement('li');
			
			if ( $(this).hasClass('active') ) {
				for (var i = 0 ; i < captions.length ; i++) {					
					if ( dataImg === captions[i].key ) listElement.innerHTML = '<strong>' + $(this).html() + '</strong> : ' + captions[i].value;
					$(this).parents('section.survol').next('article').children('.legendes').append(listElement);

				}
			} else {
				for (var i = 0 ; i < captions.length ; i++) {	

					if ( dataImg === captions[i].key ) {
						/* on enlève les balises pour pouvoir comparer les chaines et enlever la bonne */
						var regex = /(<([^>]+)>)/ig
						var contentWithTags = captions[i].value;
						var content = contentWithTags.replace(regex, "");
						$(this).parents('section.survol').next('article').children('.legendes').children('li').remove(":contains('"+content+"')");
					}
				}
			}
		});
	}); 
	
	/**
	 * @todo Gestion du hover : affichage de la légende on hover?
	 */
	 // $('.survol nav a:first-of-type').each(function() {
	 // 	// on stocke la valeur de l'attribut data-img de chaque lien
	 // 	var dataImg = $(this).attr('data-img'); 
	 // 	var caption = $(this).parents('section.survol').children('.slides').children('figure[data-img="'+dataImg+'"]').children('figcaption').html();

	 // 	var listElement = document.createElement('li');

 	// 	if ( ! $(this).parent().prev().children('a[data-img="'+dataImg+'"]:visible') ) {
		 	
		//  	$(this).parent().next().children('[data-img="'+dataImg+'"]').hover( function() {

		//  		listElement.innerHTML = '<strong>' + $(this).parent().prev().children('a[data-img="'+dataImg+'"]').html() + '</strong> : ' + caption;
		// 		$(this).parents('section.survol').next('article').children('.legendes').append(listElement);

		//  		},function() {
		//  			$(this).parents('section.survol').next('article').children('.legendes').children('li').remove(":contains('"+caption+"')");
	 // 			}
	 // 		);
	 // 	}
	 // });
	/** --- Fin Mode Survol */


	/**
	 * Mode Slider
	 */
	var sliderMarkup = $('section.slider div').html(); //on enregistre le markup de la div section.slider
	var sliderNav = $('section.slider nav').html(); 

	/**
	 * @requires Slick slider - inséré avec enqueue_scripts dans slider-button.php
	 * on configure les sliders, et ils se mettent en marche
	 */
	$('section.slider div').slick({
		arrows: false,
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 3000, 
		infinite: true, 
		pauseOnFocus: false
	});
	
	// pour chaque lien du nav
	$('section.slider nav a').each(function() {
		var figures = $('figure');

		// si ce lien est cliqué
		$(this).click(function (e) {
			e.preventDefault();

			// on enregistre l'attribut [data-img] des liens pour pouvoir contrôler les figures qui ont les mêmes attributs
			var dataImg = $(this).attr('data-img');

			// on parcoure les figures pour trouver les attributs correspondant à l'image en question 
			for ( var i=0 ; i<figures.length ; i++ ) {
	     		if (figures[i].getAttribute('data-img') === dataImg) {
					var srcImg = $('[data-img="'+figures[i].getAttribute('data-img')+'"] > img').attr('src');
					var altImg = $('[data-img="'+figures[i].getAttribute('data-img')+'"] > img').attr('alt');
					var figcaption = $('[data-img="'+figures[i].getAttribute('data-img')+'"] > figcaption').html();
	     		}
			}

			$(this).toggleClass('active');

			if ( $(this).hasClass('active') ) {

				// si un lien est actif, on désactive les autres
				$(this).prevAll().removeClass('active');
				$(this).nextAll().removeClass('active');

				// on cache le slider
				$(this).parents('.slider').children('div').hide();	

				// on montre l'image active à la place du slider
				$('<div class="slides">')
				.html('<figure data-img="'+dataImg+'"><img src="'+srcImg+'" alt="'+altImg+'"><figcaption>'+figcaption+'</figcaption></figure>')
				.appendTo($(this).parents('section.slider'));	

			} else {
				
				// si aucun lien n'est actif, on supprime le slider
				$(this).parents('section.slider').children('div').remove();

				// et on le remplace avec le html enregistré pour le réinitialiser
				$('<div class="slides">').html(sliderMarkup).appendTo($(this).parents('section.slider'));

				$(this).parents('section.slider').children('div').slick({
					arrows: false,
					slidesToShow: 1,
					slidesToScroll: 1,
			    	autoplay: true,
			  		autoplaySpeed: 3000, 
					infinite: true, 
					pauseOnFocus: false
				});
			}

		});
	}); /** --- Fin Mode Slider */

} )( jQuery );