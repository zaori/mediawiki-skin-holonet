/**
 * JavaScript functions for HoloNet skin
 * This is a fork of Monaco's main.js, forked on 15 April 2011
 *
 * @author Christian Williams
 * @author Inez Korczyński <korczynski@gmail.com>
 * @author Maciej Brencz
 * @author Jack Phoenix -- rewrote to use standard DOM functions + jQuery
 */

/**
 * Skin navigation (=functions required by the sidebar menu)
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 */
var m_timer;
var displayed_menus = new Array();
var last_displayed = '';
var last_over = '';

function menuItemAction( e ) {
	clearTimeout( m_timer );
	if( !e ) {
		var e = window.event;
	}
	e.cancelBubble = true;
	if( e.stopPropagation ) {
		e.stopPropagation();
	}
	var source_id = '*';
	try {
		source_id = e.target.id;
	} catch( ex ) {
		source_id = e.srcElement.id;
	}
	if( source_id.indexOf( 'a-' ) == 0 ) {
		source_id = source_id.substr( 2 );
	}
	if( source_id && menuitem_array[source_id] ) {
		if( document.getElementById( last_over ) ) {
			jQuery( last_over ).removeClass( 'navigation-hover' );
		}
		last_over = source_id;
		jQuery( source_id ).addClass( 'navigation-hover' );
		check_item_in_array( menuitem_array[source_id], source_id );
	}
}

function check_item_in_array( item, source_id ) {
	clearTimeout( m_timer );
	var sub_menu_item = 'sub-menu' + item;
	if(
		last_displayed == '' ||
		( ( sub_menu_item.indexOf( last_displayed ) != -1 ) && ( sub_menu_item != last_displayed ) )
	) {
		do_menuItemAction( item, source_id );
	} else {
		var exit = false;
		count = 0;
		var the_last_displayed;
		while( !exit && displayed_menus.length > 0 ) {
			the_last_displayed = displayed_menus.pop();
			if( ( sub_menu_item.indexOf( the_last_displayed.item ) == -1 ) ) {
				doClear( the_last_displayed.item, '' );
				jQuery( the_last_displayed.source ).removeClass( 'navigation-hover' );
			} else {
				displayed_menus.push( the_last_displayed );
				exit = true;
			}
			count++;
		}
		do_menuItemAction( item, source_id );
	}
}

function do_menuItemAction( item, source_id ) {
	if( document.getElementById( 'sub-menu' + item ) ) {
		document.getElementById( 'sub-menu' + item ).style.display = 'block';
		jQuery( source_id ).addClass( 'navigation-hover' );
		displayed_menus.push({'item' : 'sub-menu' + item, 'source' : source_id});
		last_displayed = 'sub-menu' + item;
	}
}

function sub_menuItemAction( e ) {
	clearTimeout( m_timer );
	if( !e ) {
		var e = window.event;
	}
	e.cancelBubble = true;
	if( e.stopPropagation ) {
		e.stopPropagation();
	}
	var source_id = '*';

	try {
		source_id = e.target.id;
	} catch( ex ) {
		source_id = e.srcElement.id;
	}
	if( source_id.indexOf( 'a-' ) == 0 ) {
		source_id = source_id.substr( 2 );
	}
	if( source_id && submenuitem_array[source_id] ) {
		check_item_in_array( submenuitem_array[source_id], source_id );
		for( var i = 0; i < displayed_menus.length; i++ ) {
			jQuery( displayed_menus[i].source ).addClass( 'navigation-hover' );
		}
	}
}

function clearBackground( e ) {
	if( !e ) {
		var e = window.event;
	}
	e.cancelBubble = true;
	if( e.stopPropagation ) {
		e.stopPropagation();
	}
	var source_id = '*';

	try {
		source_id = e.target.id;
	} catch( ex ) {
		source_id = e.srcElement.id;
	}

	var source_id = ( source_id.indexOf( 'a-' ) == 0 ) ? source_id.substr( 2 ) : source_id;
	if(
		source_id &&
		document.getElementById( source_id ) &&
		menuitem_array[source_id]
	) {
		jQuery( source_id ).removeClass( 'navigation-hover' );
		clearMenu( e );
	}
}

function clearMenu( e ) {
	clearTimeout( m_timer );
	m_timer = setTimeout( function() { doClearAll(); }, 300 );
}

function doClear( item, type ) {
	if( document.getElementById( type + item ) ) {
		document.getElementById( type + item ).style.display = 'none';
	}
}

function doClearAll() {
	var the_last_displayed;
	while( displayed_menus.length > 0 ) {
		the_last_displayed = displayed_menus.pop();
		doClear( the_last_displayed.item, '' );
		jQuery( the_last_displayed.source ).removeClass( 'navigation-hover' );
	}
	last_displayed = '';
}

// End menu functions