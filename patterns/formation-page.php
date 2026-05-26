<?php
/**
 * Title: Page formation
 * Slug: improcestout/formation-page
 * Categories: improcestout_page
 * Description: Modele de page pour structurer une formation avec hero, infos, contenu et appel a contact.
 *
 * @package WordPress
 * @subpackage Improcestout
 * @since Impro C'est Tout 1.6
 */
?>

<!-- wp:improcestout/formation-hero {"align":"full"} /-->

<!-- wp:group {"align":"wide","className":"impro-formation-pattern-body","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide impro-formation-pattern-body">
	<!-- wp:improcestout/formation-info-list {"align":"wide"} /-->

	<!-- wp:group {"tagName":"section","className":"is-style-theatre-section","layout":{"type":"constrained"}} -->
	<section class="wp-block-group is-style-theatre-section">
		<!-- wp:group {"className":"is-style-theatre-section-heading","layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-theatre-section-heading">
			<!-- wp:paragraph -->
			<p>Objectifs</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading -->
			<h2 class="wp-block-heading">Ce que la formation permet de travailler</h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:list {"className":"is-style-theatre-objectives-list"} -->
		<ul class="wp-block-list is-style-theatre-objectives-list">
			<!-- wp:list-item -->
			<li>Clarifier les objectifs de la session.</li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li>Mettre en pratique avec des situations concretes.</li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li>Repartir avec des reperes directement utilisables.</li>
			<!-- /wp:list-item -->
		</ul>
		<!-- /wp:list -->
	</section>
	<!-- /wp:group -->

	<!-- wp:columns {"className":"is-style-theatre-cta"} -->
	<div class="wp-block-columns is-style-theatre-cta">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading -->
			<h2 class="wp-block-heading">Parlons de votre besoin</h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph -->
			<p>Chaque formation peut etre adaptee au groupe, au terrain et au contexte d'intervention.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"className":"is-style-theatre-cta-button"} -->
				<div class="wp-block-button is-style-theatre-cta-button"><a class="wp-block-button__link wp-element-button" href="/contact/">Contact</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
