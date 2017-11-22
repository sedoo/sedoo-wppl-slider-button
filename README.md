# sedoo-wppl-slider-button

## Table des matières

- [Installation](#installation)
  - Importer
  - Lier ACF Pro avec sedoo-wppl-slider-button
- [Utilisation](#utilisation)
  - Créer un slider
  - Ajouter un slider à une page ou un article
 
## Installation

Pré-requis : 
- [Advanced Custom Fields Pro (ACF Pro)](http://www.advancedcustomfields.com/pro/)

1. Installer et activer **ACF Pro**
2. Installer et activer **sedoo-wppl-slider-button** via **GitHub Updater**

Si vous disposez déjà du fichier d'export du groupe de champs, aller directement à la section [Importer](#importer)

### Importer

Importer directement le fichier `acf-export-2017-06-13.json` décrivant le groupe de champs.

Dans `ACF > Outils`, sélectionner le fichier à importer avec le bouton `Parcourir...`

Cliquer sur `Importer`

### Lier ACF Pro avec sedoo-wppl-slider-button

1. Aller dans `SB Settings`
2. Vérifier que le `select` contient "Sliders"
3. Remplir les inputs avec les noms des champs ACF (ceux en minuscule dans `ACF > Groupes de champs > Sliders`) : choix, source, legende, diapos, image, legende_image, lien, titre

**NB :** Il se peut qu'il faille d'abord créer un slider pour que cela fonctionne (cf. **Créer un slider**, ci-dessous)

## Utilisation

### Créer un slider

1. Aller dans `Sliders`
2. Cliquer sur `Ajouter`
3. Renseigner un titre *(pas obligatoire, mais plus facile pour le retrouver ensuite)*
4. Renseigner le contenu *(facultatif)*
5. Choisir entre `slider` (carousel) et `survol` (superposition d'images)
6. Renseigner les champs des diapositives : les titres sont utilisé pour le système d'onglets (il est fortement conseillé de ne pas les laisser vides)

**NB :** le contenu peut avoir des images, une mise en forme particulières, etc. Comme pour l'édition d'un article. 

### Ajouter un slider à une page ou un article

1. Se rendre sur l'édition d'une page ou d'un article
2. Cliquer sur le bouton `Slider Button` de l'éditeur WYSIWYG
3. Sélectionner le module d'onglets à insérer
4. Cliquer sur `OK`

Un shortcode apparaît alors et génère le code sur la page ou l'article concernée.
