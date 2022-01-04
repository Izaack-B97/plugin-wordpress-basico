<?php
/*
Plugin Name: Mi Primer Plugin
Plugin URI: https://miprimerplugin.com
Description: Este es mi primer plugin para practicar
Version: 1.0
Author: Isaac Bustamante
Author URI: https://miurlpersonal.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.o.html
Text Domain: miprimerplugin
Domain Path /languages
*/

function mp_install () {
    echo "<script>console.log('Hola mundo')</script>";
    // require_once "activador.php";
}

function mp_uninstall () {
    flush_rewrite_rules();
}

function mp_delete_plugin () {
    // Borrar tablas d e la bd
    // Quitar configuraciones
    // Limpiar opciones
}

register_activation_hook( __FILE__, "mp_install" );
register_deactivation_hook( __FILE__, "mp_uninstall" );
register_uninstall_hook( __FILE__, "mp_delete_plugin" );  

add_action( 'plugins_loaded' , 'plugins_cargados' );

function plugins_cargados () {
    if ( current_user_can( 'edit_pages' ) && !function_exists( 'mp_add_meta_description' ) ) {
        add_action( 'wp_head', 'mp_add_meta_description' );
    
        function mp_add_meta_description () {
            echo "<meta name='description' content='Creacion de plugins en Wordpress' >";
        }
    }
    
    $input = "Hola camarada <?php echo 'DELETE, UPDATE, INSERT'; ?> que me cuentas";
    // echo sanitize_text_field( $input );
}


$output = "<a href='". esc_url('file://google.com', ['file', 'otro']) . "'>Google</a>";
// echo esc_html( $output );

$menus = [];
$menus[] = [
    'pageTitle' => 'MP Pruebas',
    'menuTitle' => 'MP Pruebas',
    'capability' => 'manage_options',
    'menuSlug' => 'mp_pruebas',
    'functionName' => 'mp_pruebas_page_display',
    // 'iconUrl' => plugin_dir_url( __FILE__ ) . 'assets/img/icon.png',
    'iconUrl' => '',
    'position' => 15
];
$menus[] = [
    'pageTitle' => 'MP Pruebas1',
    'menuTitle' => 'MP Pruebas1',
    'capability' => 'manage_options',
    'menuSlug' => 'mp_pruebas1',
    'functionName' => 'mp_pruebas_page_display',
    // 'iconUrl' => plugin_dir_url( __FILE__ ) . 'assets/img/icon.png',
    'iconUrl' => '',
    'position' => 16
];
$menus[] = [
    'pageTitle' => 'MP Pruebas2',
    'menuTitle' => 'MP Pruebas2',
    'capability' => 'manage_options',
    'menuSlug' => plugin_dir_path( __FILE__ ) . 'admin/vista.php',
    'functionName' => null,
    // 'iconUrl' => plugin_dir_url( __FILE__ ) . 'assets/img/icon.png',
    'iconUrl' => '',
    'position' => 17
];

require_once plugin_dir_path( __FILE__ ) . 'libs/helpers.php';

add_action( 'admin_menu', function() use ( $menus ) {
    addMenusPage( $menus );

    add_submenu_page(
        'mp_pruebas',
        'Titulo Submenu 1',
        'Titulo Submenu 1',
        'manage_options',
        'submenu1_mp_pruebas',
        'submenu1_mp_pruebas_display'
    );

    remove_menu_page( 'mp_pruebas1' );
    remove_menu_page( 'edit.php?post_type=page' );
});

if ( !function_exists('mp_pruebas_page_display') ) {
    function mp_pruebas_page_display () {
        if ( current_user_can( 'edit_others_posts' ) ) {
            $nonce = wp_create_nonce('este_es_mi_nonce_personalizado');
        
            if ( isset( $_POST[ 'nonce' ] ) && !empty( $_POST[ 'nonce' ] ) ) {
                if ( wp_verify_nonce( $_POST[ 'nonce' ], 'este_es_mi_nonce_personalizado' ) ) {
                    echo 'Nonce verificado';
                } else {
                    echo 'Este nonce no es correcto';
                }
            }

            ?>
            <br />
            <?php if ( current_user_can('manage_options') ) { ?>    
                <form action="" method="POST" class="wrap">
                    <input name="nonce" type="hidden" value="<?php echo $nonce ?>" />
                    <input name="eliminar" type="hidden" value="eliminar" />
                    <input name="texto" type="text" placeholder="Texto a enviar" />
                    <!-- <button type="submit">Eliminar</button> -->
                    <?php submit_button('Enviar'); ?>
                </form>
            <?php } else { ?>
                <p>No tienes acceso a este apartado</p>
            <?php } ?>
            <?php
        }
    }   
}

if ( !function_exists('submenu1_mp_pruebas_display') ) {
    function submenu1_mp_pruebas_display () {
        if ( current_user_can( 'edit_others_posts' ) ) {
            $nonce = wp_create_nonce('este_es_mi_nonce_personalizado');
        
            if ( isset( $_POST[ 'nonce' ] ) && !empty( $_POST[ 'nonce' ] ) ) {
                if ( wp_verify_nonce( $_POST[ 'nonce' ], 'este_es_mi_nonce_personalizado' ) ) {
                    echo 'Nonce verificado';
                } else {
                    echo 'Este nonce no es correcto';
                }
            }

            ?>
            <br />
            <h1>Este es el submenu 1</h1>
            <?php if ( current_user_can('manage_options') ) { ?>    
                <form action="" method="POST" class="wrap">
                    <input name="nonce" type="hidden" value="<?php echo $nonce ?>" />
                    <input name="eliminar" type="hidden" value="eliminar" />
                    <input name="texto" type="text" placeholder="Texto a enviar" />
                    <!-- <button type="submit">Eliminar</button> -->
                    <?php submit_button('Enviar'); ?>
                </form>
            <?php } else { ?>
                <p>No tienes acceso a este apartado</p>
            <?php } ?>
            <?php
        }
    }   
}

// Filters
add_filter( 'the_title', 'mp_filtro_titulo', 10, 2 );
function mp_filtro_titulo ( $title, $post_id ) {
    $vocals = [ 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U' ];
    $title = str_replace( $vocals, '*', $title ); 
    return "$title, $post_id"; 
}

add_filter( 'the_content', 'mp_filtro_content' );
function mp_filtro_content ( $content ) {
    $vocals = [ 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U' ];
    $content = str_replace( $vocals, '*', $content ); 

    if ( is_singular( 'post' ) && has_post_thumbnail() ) {
        $thumbnail = get_the_post_thumbnail();
        $content = $content . $thumbnail;
    }
    return $content; 
}

add_filter('body_class', 'mp_class_body');
function mp_class_body( $classes ) {
    
    if ( in_array( 'post-template-default', $classes ) ) {
        $index = array_search( 'post-template-default', $classes );
        unset( $classes[ $index ] );
    }

    if ( !is_admin() ) {
        $classes[] = 'mi-nueva-clase';
    }
    return $classes;
}













