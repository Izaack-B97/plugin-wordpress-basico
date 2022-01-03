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

add_action( 'admin_menu', function() {
    add_menu_page(
        'MP Pruebas',
        'MP Pruebas',
        'manage_options',
        'mp_pruebas',
        'mp_pruebas_page_display',
        '',
        15
    );

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
            <form action="" method="POST">
                <input name="nonce" type="hidden" value="<?php echo $nonce ?>" />
                <input name="eliminar" type="hidden" value="eliminar" />
                <button type="submit">Eliminar</button>
            </form>
            <?php
        }
    }   
}