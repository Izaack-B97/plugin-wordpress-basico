<?php
function addMenusPage ( $menus ) {
    if ( is_array( $menus ) ) {
        for ( $i=0; $i < count( $menus ); $i++ ) { 
            add_menu_page(
                $menus[ $i ][ 'pageTitle' ],
                $menus[ $i ][ 'menuTitle' ],
                $menus[ $i ][ 'capability' ],
                $menus[ $i ][ 'menuSlug' ],
                $menus[ $i ][ 'functionName' ],
                $menus[ $i ][ 'iconUrl' ],
                $menus[ $i ][ 'position' ],
            );        
        }
    }
}