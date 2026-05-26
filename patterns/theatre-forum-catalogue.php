<?php
/**
 * Title: Théâtre forum catalogue
 * Slug: improcestout/theatre-forum-catalogue
 * Categories: improcestout_page
 * Description: Composition issue du catalogue social et médico-social pour présenter le théâtre forum.
 *
 * @package WordPress
 * @subpackage Improcestout
 * @since Impro C'est Tout 1.5
 */

$theatre_forum_image = get_theme_file_uri( 'assets/images/theatre-forum-pouvoir-agir.jpg' );
?>

<!-- wp:group {"className":"impro-tf","layout":{"type":"constrained"}} -->
<div class="wp-block-group impro-tf">
	<!-- wp:cover {"url":"<?php echo esc_url( $theatre_forum_image ); ?>","dimRatio":0,"isDark":false,"align":"full","className":"is-style-theatre-hero","layout":{"type":"constrained"}} -->
	<div class="wp-block-cover alignfull is-light is-style-theatre-hero">
		<span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span>
		<img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $theatre_forum_image ); ?>" data-object-fit="cover"/>
		<div class="wp-block-cover__inner-container">
			<!-- wp:paragraph {"className":"is-style-theatre-kicker"} -->
			<p class="is-style-theatre-kicker">Théâtre participatif</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":1,"className":"is-style-theatre-hero-title"} -->
			<h1 class="wp-block-heading is-style-theatre-hero-title">Face aux problèmes, on expérimente des solutions.</h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"is-style-theatre-framed-text"} -->
			<p class="is-style-theatre-framed-text">Le théâtre forum met une situation sous les yeux du groupe, ouvre le débat et invite chacun à devenir spect-acteur pour tester d'autres façons d'agir.</p>
			<!-- /wp:paragraph -->

			<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"className":"is-style-theatre-tag"} -->
				<p class="is-style-theatre-tag">Pouvoir d'agir</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"className":"is-style-theatre-tag"} -->
				<p class="is-style-theatre-tag">Cohésion sociale</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"className":"is-style-theatre-tag"} -->
				<p class="is-style-theatre-tag">Transformation sociale</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
	</div>
	<!-- /wp:cover -->

	<!-- wp:group {"className":"impro-tf-manifesto","layout":{"type":"constrained"}} -->
	<div class="wp-block-group impro-tf-manifesto">
		<!-- wp:paragraph -->
		<p>Une scène montre une tension, une injustice ou un blocage. Le public ne reste pas assis devant le problème : il remplace, rejoue, propose, ajuste. Le théâtre devient un laboratoire concret pour chercher ensemble des issues.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"className":"is-style-theatre-info-cards"} -->
	<div class="wp-block-columns is-style-theatre-info-cards">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Pour qui ?</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Travailleurs sociaux, structures sociales et médico-sociales, scolaires, collectivités, étudiants, associations ou groupes concernés par une problématique commune.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Combien ?</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>De 6 à 12 participants en atelier ou analyse de pratiques. En spectacle, le public n'a pas de limite.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Combien de temps ?</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Ateliers au rythme du groupe, formation sur 3 à 5 jours, ou analyse de pratiques avec une séance mensuelle.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Format</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Intra, inter, particuliers ou espace public. Le projet se construit selon le terrain, les personnes et le sujet à travailler.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:group {"tagName":"section","className":"is-style-theatre-section","layout":{"type":"constrained"}} -->
	<section class="wp-block-group is-style-theatre-section">
		<!-- wp:group {"className":"is-style-theatre-section-heading","layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-theatre-section-heading">
			<!-- wp:paragraph -->
			<p>Objectifs</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading -->
			<h2 class="wp-block-heading">Passer du constat à l'action</h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:list {"className":"is-style-theatre-objectives-list"} -->
		<ul class="wp-block-list is-style-theatre-objectives-list">
			<!-- wp:list-item -->
			<li>Sensibiliser et participer collectivement à la transformation sociale.</li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li>Redonner au public son pouvoir d'agir.</li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li>Rechercher activement des solutions au service des personnes opprimées.</li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li>Renforcer la solidarité et la cohésion sociale.</li>
			<!-- /wp:list-item -->
		</ul>
		<!-- /wp:list -->
	</section>
	<!-- /wp:group -->

	<!-- wp:group {"tagName":"section","className":"is-style-theatre-section","layout":{"type":"constrained"}} -->
	<section class="wp-block-group is-style-theatre-section">
		<!-- wp:group {"className":"is-style-theatre-section-heading","layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-theatre-section-heading">
			<!-- wp:paragraph -->
			<p>Formats</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading -->
			<h2 class="wp-block-heading">Plusieurs manières de faire forum</h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"is-style-theatre-formats-grid","layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-theatre-formats-grid">
			<!-- wp:group {"className":"is-style-theatre-format-card","layout":{"type":"constrained"}} -->
			<div class="wp-block-group is-style-theatre-format-card">
				<!-- wp:heading {"level":3} -->
				<h3 class="wp-block-heading">Ateliers</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph -->
				<p>Un groupe explore des situations d'oppression. Les participants deviennent tour à tour acteurs, metteurs en scène et chercheurs de solutions.</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:group {"className":"is-style-theatre-format-card","layout":{"type":"constrained"}} -->
			<div class="wp-block-group is-style-theatre-format-card">
				<!-- wp:heading {"level":3} -->
				<h3 class="wp-block-heading">Spectacles</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph -->
				<p>Des témoignages nourrissent plusieurs saynètes. Le public monte ensuite sur scène pour changer le cours de l'histoire.</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:group {"className":"is-style-theatre-format-card","layout":{"type":"constrained"}} -->
			<div class="wp-block-group is-style-theatre-format-card">
				<!-- wp:heading {"level":3} -->
				<h3 class="wp-block-heading">Analyse de pratiques</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph -->
				<p>Dans le social et médico-social, le jeu aide à comprendre les mécanismes relationnels, dédramatiser et outiller les professionnels.</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:group {"className":"is-style-theatre-format-card","layout":{"type":"constrained"}} -->
			<div class="wp-block-group is-style-theatre-format-card">
				<!-- wp:heading {"level":3} -->
				<h3 class="wp-block-heading">Formation</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph -->
				<p>Les travailleurs sociaux s'approprient cet outil pour animer eux-mêmes des sessions au sein de leurs structures.</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:group {"className":"is-style-theatre-format-card","layout":{"type":"constrained"}} -->
			<div class="wp-block-group is-style-theatre-format-card">
				<!-- wp:heading {"level":3} -->
				<h3 class="wp-block-heading">Espace public</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph -->
				<p>Une saynète apparaît dans le quotidien, rend visible une injustice et invite les passants à entrer dans le forum.</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	</section>
	<!-- /wp:group -->

	<!-- wp:group {"tagName":"section","className":"is-style-theatre-theme-strip","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}} -->
	<section class="wp-block-group is-style-theatre-theme-strip" aria-label="Thématiques possibles">
		<!-- wp:paragraph {"className":"is-style-theatre-tag"} -->
		<p class="is-style-theatre-tag">Vivre ensemble</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"is-style-theatre-tag"} -->
		<p class="is-style-theatre-tag">Racisme</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"is-style-theatre-tag"} -->
		<p class="is-style-theatre-tag">Sexisme</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"is-style-theatre-tag"} -->
		<p class="is-style-theatre-tag">Harcèlement</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"is-style-theatre-tag"} -->
		<p class="is-style-theatre-tag">Réseaux sociaux</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"is-style-theatre-tag"} -->
		<p class="is-style-theatre-tag">Stéréotypes de genre</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"is-style-theatre-tag"} -->
		<p class="is-style-theatre-tag">Discriminations</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"is-style-theatre-tag"} -->
		<p class="is-style-theatre-tag">Violences</p>
		<!-- /wp:paragraph -->
	</section>
	<!-- /wp:group -->

	<!-- wp:columns {"className":"is-style-theatre-cta","verticalAlignment":"center"} -->
	<div class="wp-block-columns are-vertically-aligned-center is-style-theatre-cta">
		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:paragraph {"className":"impro-tf-kicker"} -->
			<p class="impro-tf-kicker">Sur mesure</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading -->
			<h2 class="wp-block-heading">Un sujet, une tension, une équipe ?</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Le contenu, le nombre de séances et le format se co-construisent avec l'organisation. Les prises en charge par les OPCO ou les demandes de subventions peuvent être étudiées selon le projet.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"240px"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:240px">
			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"className":"is-style-theatre-cta-button"} -->
				<div class="wp-block-button is-style-theatre-cta-button"><a class="wp-block-button__link wp-element-button" href="/contact/">Construire le projet</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:shortcode -->
	[improcestout_intervenants categories="theatre-forum"]
	<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->
