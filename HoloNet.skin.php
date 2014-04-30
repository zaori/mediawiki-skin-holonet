<?php

/**
 * HoloNet skin
 *
 * @file
 * @ingroup Skins
 * @author Jack Phoenix
 * @author Calimonius the Estrange
 * @authors Whoever wrote monobook
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @ingroup Skins
 */
class SkinHoloNet extends SkinTemplate {
	var $skinname = 'holonet', $stylename = 'holonet',
		$template = 'HoloNetTemplate', $useHeadElement = true;

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {

		parent::setupSkinUserCss( $out );

		# Add css
		$out->addModuleStyles( 'skins.common.normalize' );
		$out->addModuleStyles( 'skins.holonet' );

		# Add jQuery in case resourceloader doesn't figure out old main.js (?)
		# $out->includeJQuery();

		# main.js contains sidebar support functions
		# $out->addModuleScripts( 'skins.holonet' );
	}
}

/**
 * Main HTML template for the HoloNet skin.
 * @ingroup Skins
 */
class HoloNetTemplate extends BaseTemplate {

	/**
	 * Template filter callback for HoloNet skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 */
	public function execute() {
		global $wgRequest;

		$this->skin = $skin = $this->data['skin'];
		$action = $wgRequest->getText( 'action' );

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

		$this->html( 'headelement' );
		?>
		<div id="globalWrapper">

		<div id="column-content">
		<div id="content" class="mw-body-primary" role="main">
			<a id="top"></a>
			<?php if ( $this->data['sitenotice'] ) { ?><div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div><?php } ?>

			<h1 id="firstHeading" class="firstHeading" lang="<?php
			$this->data['pageLanguage'] = $this->getSkin()->getTitle()->getPageViewLanguage()->getHtmlCode();
			$this->text( 'pageLanguage' );
			?>"><span dir="auto"><?php $this->html( 'title' ) ?></span></h1>

			<div id="bodyContent" class="mw-body">

				<div id="siteSub"><?php $this->msg( 'tagline' ) ?></div>
				<div id="contentSub"<?php $this->html( 'userlangattributes' ) ?>><?php $this->html( 'subtitle' ) ?></div>

				<?php if ( $this->data['undelete'] ) { ?>
					<div id="contentSub2"><?php $this->html( 'undelete' ) ?></div>
				<?php } ?><?php if ( $this->data['newtalk'] ) { ?>
					<div class="usermessage"><?php $this->html( 'newtalk' ) ?></div>
				<?php } ?>
				<div id="jump-to-nav" class="mw-jump"><?php $this->msg( 'jumpto' ) ?> <a href="#column-one"><?php $this->msg( 'jumptonavigation' ) ?></a><?php $this->msg( 'comma-separator' ) ?><a href="#searchInput"><?php $this->msg( 'jumptosearch' ) ?></a></div>

				<!-- start content -->
				<?php $this->html( 'bodytext' ) ?>
				<?php if ( $this->data['catlinks'] ) { $this->html( 'catlinks' ); } ?>
				<!-- end content -->

				<?php if ( $this->data['dataAfterContent'] ) { $this->html( 'dataAfterContent' ); } ?>
				<div class="visualClear"></div>
			</div>
		</div>
		</div>

		<div id="column-one"<?php $this->html( 'userlangattributes' ) ?>>
			<h2><?php $this->msg( 'navigation-heading' ) ?></h2>
			<?php $this->cactions(); ?>
			<div class="portlet" id="p-personal" role="navigation">
				<h3><?php $this->msg( 'personaltools' ) ?></h3>
				<div class="pBody">
					<ul<?php $this->html( 'userlangattributes' ) ?>>
					<?php
					foreach ( $this->getPersonalTools() as $key => $item ) { 	echo $this->makeListItem( $key, $item );
					} ?>
					</ul>
				</div>
			</div>
			<div class="portlet" id="p-logo" role="banner">
			<?php
			echo Html::element( 'a', array(
				'href' => $this->data['nav_urls']['mainpage']['href'],
				'style' => "background-image: url({$this->data['logopath']});" )
				+ Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) ); ?>
			</div>
			<?php
			$this->renderPortals( $this->data['sidebar'] );
			?>
		</div>
		<!-- end of the left (by default at least) column -->

		<div class="visualClear"></div>
		<?php
		$validFooterIcons = $this->getFooterIcons( "icononly" );
		$validFooterLinks = $this->getFooterLinks( "flat" ); // Additional footer links
		?>

		<div id="footer" role="contentinfo"<?php $this->html( 'userlangattributes' ) ?>>
			<?php
			foreach ( $validFooterIcons as $blockName => $footerIcons ) { ?>
				<div id="f-<?php echo htmlspecialchars( $blockName ); ?>ico">
				<?php foreach ( $footerIcons as $icon ) {
					echo $this->getSkin()->makeFooterIcon( $icon );
				}
				?>
				</div>
				<?php
			}
			?>
			<div id="f-note">
				<?php echo wfMessage( 'holonet-footer-note' )->escaped() ?>
			</div>
			<ul id="f-list">
				<?php
				foreach ( $validFooterLinks as $aLink ) { ?>
					<li id="<?php echo $aLink ?>"><?php $this->html( $aLink ) ?></li>
				<?php
				}
				?>
			</ul>

			<div id="gonk-footer"><?php echo wfMessage( 'holonet-footer-end' )->escaped() ?></div>

			<!-- Piwik -->
			<script type="text/javascript">
				var pkBaseURL = (("https:" == document.location.protocol) ? "https://darthipedia.com/piwik/" : "http://darthipedia.com/piwik/");
				document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
			</script>
			<script type="text/javascript">
				try {
				var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
				piwikTracker.trackPageView();
				piwikTracker.enableLinkTracking();
				} catch( err ) {}
			</script>
			<noscript>
				<p><img src="http://darthipedia.com/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p>
			</noscript>
			<!-- End Piwik Tracking Code -->
			<?php
		echo $footerEnd;
		?>
	</div>

	<?php
	$this->printTrail();
	echo Html::closeElement( 'body' );
	echo Html::closeElement( 'html' );
	wfRestoreWarnings();
	} // end of execute() method

	/*************************************************************************************************/

	/**
	 * @param $sidebar array
	 */
	protected function renderPortals( $sidebar ) {

		/* Ensure this appears at the top */
		$this->searchBox();

		foreach ( $sidebar as $boxName => $content ) {
			if ( $content === false ) {
				continue;
			}
			if ( $boxName == 'SEARCH' ) {
				continue;
			} elseif ( $boxName == 'TOOLBOX' ) {
				continue;
			} elseif ( $boxName == 'LANGUAGES' ) {
				continue;
			} else {
				$this->customBox( $boxName, $content );
			}
		}

		/* Ensure these appear at the bottom */
		$this->toolbox();
		$this->languageBox();
	}

	function searchBox() {
		global $wgUseTwoButtonsSearchForm;
		?>
		<div id="p-search" class="portlet" role="search">
			<h3><label for="searchInput"><?php $this->msg( 'search' ) ?></label></h3>
			<div id="searchBody" class="pBody">
				<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform">
					<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
					<?php echo $this->makeSearchInput( array( "id" => "searchInput" ) ); ?>

					<?php echo $this->makeSearchButton( "go", array( "id" => "searchGoButton", "class" => "searchButton" ) );
					if ( $wgUseTwoButtonsSearchForm ) { ?>&#160;
					<?php echo $this->makeSearchButton( "fulltext", array( "id" => "mw-searchButton", "class" => "searchButton" ) );
					} else { ?>

					<div><a href="<?php $this->text( 'searchaction' ) ?>" rel="search"><?php $this->msg( 'powersearch-legend' ) ?></a></div><?php
					} ?>

				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * Prints the cactions bar.
	 * Shared between Monobook and Modern
	 */
	function cactions() {
	?>
		<div id="p-cactions" class="portlet" role="navigation">
			<div class="pBody">
				<ul>
				<?php
					foreach ( $this->data['content_actions'] as $key => $tab ) {
						echo '
					' . $this->makeListItem( $key, $tab );
					}
					?>
				</ul>
			</div>
		</div>
	<?php
	}

	/*************************************************************************************************/
	function toolbox() {
	?>
		<div class="portlet" id="p-tb" role="navigation">
			<h3><?php $this->msg( 'toolbox' ) ?></h3>
			<div class="pBody">
				<ul>
				<?php
					foreach ( $this->getToolbox() as $key => $tbitem ) {
						echo $this->makeListItem( $key, $tbitem );
					}
					$title = $this->getSkin()->getTitle();
					# history
					if ( $this->getSkin()->getOutput()->isArticleRelated() ) {
						$link = Linker::link( $title, wfMessage( 'greystuff-history' )->text(), array(), array( 'action' => 'history' ) ); ?>
						<li id="t-history"><?php echo $link; ?></li>
						<?php
					}
					# purge
					$link = Linker::link( $title, wfMessage( 'greystuff-purge' )->text(), array(), array( 'action' => 'purge' ) ); ?>
					<li id="t-purge"><?php echo $link; ?></li>

					<?php
					wfRunHooks( 'MonoBookTemplateToolboxEnd', array( &$this ) );
					wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this, true ) );
				?>
				</ul>
			</div>
		</div>
	<?php
	}

	/*************************************************************************************************/
	function languageBox() {
		if ( $this->data['language_urls'] ) {
		?>
			<div id="p-lang" class="portlet" role="navigation">
				<h3<?php $this->html( 'userlangattributes' ) ?>><?php $this->msg( 'otherlanguages' ) ?></h3>
				<div class="pBody">
					<ul>
					<?php
					foreach ( $this->data['language_urls'] as $key => $langlink ) {
						?>
						<?php echo $this->makeListItem( $key, $langlink );
					}
					?>
					</ul>
				</div>
			</div>
		<?php
		}
	}

	/*************************************************************************************************/
	function customBox( $bar, $cont ) {
		$portletAttribs = array( 'class' => 'generated-sidebar portlet', 'id' => Sanitizer::escapeId( "p-$bar" ), 'role' => 'navigation' );
		$tooltip = Linker::titleAttrib( "p-$bar" );
		if ( $tooltip !== false ) {
			$portletAttribs['title'] = $tooltip;
		}
		echo '	' . Html::openElement( 'div', $portletAttribs );
		$msgObj = wfMessage( $bar );
		?>

		<h3><?php echo htmlspecialchars( $msgObj->exists() ? $msgObj->text() : $bar ); ?></h3>
		<div class='pBody'>
			<?php   if ( is_array( $cont ) ) { ?>
			<ul>
			<?php
				foreach ( $cont as $key => $val ) {
					echo $this->makeListItem( $key, $val );
				}
			?>
			</ul>
			<?php
		} else {
			# allow raw HTML block to be defined by extensions
			print $cont;
		}
		?>
		</div>
	</div>
	<?php
	}


} // end of class