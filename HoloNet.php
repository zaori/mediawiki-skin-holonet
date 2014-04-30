<?php
/**
 * HoloNet skin for Darthipedia
 *
 * A fork of Monobook (from version 1.16.4 of MW) with some additional goodies
 * (such as Monaco-esque sidebar).
 *
 * @file
 * @ingroup Skins
 * @author Jack Phoenix <jack@shoutwiki.com>
 * @author Calimonius the Estrange
 * @date 2013
 * @license Do whatever the fuck you want with our code; other people's code may
 * be copyrighted, I think that Monaco is GPL2+, and so is MW
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not a valid entry point.' );
}

// Skin credits that will show up on Special:Version

$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'HoloNet skin',
	'version' => '0.1.0',
	'author' => array( 'Jack Phoenix', 'maybe someone else' ),
	'descriptionmsg' => 'holonet-desc',
);

# Autoload the skin class, make it a valid skin, set up i18n, set up CSS & JS
# (via ResourceLoader)
$skinID = basename( dirname( __FILE__ ) );
$dir = dirname( __FILE__ ) . '/';

# Autoload the skin class, make it a valid skin, set up i18n

# The first instance must be strtolower()ed so that useskin=nimbus works and
# so that it does *not* force an initial capital (i.e. we do NOT want
# useskin=HoloNet) and the second instance is used to determine the name of
# *this* file.
$wgValidSkinNames[strtolower( $skinID )] = 'HoloNet';

$wgAutoloadClasses['SkinHoloNet'] = $dir . 'HoloNet.skin.php';
$wgExtensionMessagesFiles['SkinHoloNet'] = $dir . 'HoloNet.i18n.php';
$wgResourceModules['skins.holonet'] = array(
	'styles' => array(
		'skins/HoloNet/unholy_soup.css' => array( 'media' => 'screen' )
	),
	'scripts' => '/skins/HoloNet/main.js',
	'position' => 'top'
);
