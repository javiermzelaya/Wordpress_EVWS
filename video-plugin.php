<?php
/*
Plugin Name: Embed videos with Subtitles
Description: A plugin to play embed videos with subtitles.
Version: 1.0
Author: https://github.com/javiermzelaya/
*/

// Agregar el menú de configuración del plugin
function video_plugin_menu() {
    add_menu_page(
        'Plugin Settings', // Título de la página
        'EVWS',                   // Título del menú
        'manage_options',                    // Capacidad necesaria
        'video-plugin-settings',             // Slug del menú
        'video_plugin_settings_page',        // Función para mostrar la página
        'dashicons-video-alt3',              // Icono del menú
        100                                 // Posición en el menú
    );
}
add_action('admin_menu', 'video_plugin_menu');

// Mostrar la página de configuración
function video_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('video_plugin_options_group');
            do_settings_sections('video-plugin-settings');
            submit_button();
            ?>
        </form>
		<h1>Shortcode</h1>
		<h2>[video_player url="VIDEO_URL"]</h2>
    </div>
    <?php
}

// Registrar configuraciones del plugin
function video_plugin_settings() {
    register_setting('video_plugin_options_group', 'video_plugin_enable_subtitles');

    add_settings_section(
        'video_plugin_main_section',
        'Main Options',
        null,
        'video-plugin-settings'
    );

    add_settings_field(
        'video_plugin_enable_subtitles',
        'Enable subtitle upload',
        'video_plugin_enable_subtitles_callback',
        'video-plugin-settings',
        'video_plugin_main_section'
    );
}
add_action('admin_init', 'video_plugin_settings');

// Mostrar el campo de habilitación de subtítulos
function video_plugin_enable_subtitles_callback() {
    $option = get_option('video_plugin_enable_subtitles');
    ?>
    <input type="checkbox" name="video_plugin_enable_subtitles" value="1" <?php checked(1, $option, true); ?> />
    <label for="video_plugin_enable_subtitles">Allow users to upload subtitles</label>
    <?php
}

// Modificar el shortcode para verificar la opción de carga de subtítulos
function video_plugin_shortcode($atts) {
    $atts = shortcode_atts(array(
        'url' => '',
    ), $atts, 'video_player');

    $enable_subtitles = get_option('video_plugin_enable_subtitles', 1);

    ob_start();
    ?>
    <div class="video-container">
        <video id="video-player" controls>
            <source src="<?php echo esc_url($atts['url']); ?>" type="video/mp4">
            Your browser does not support the video element.
        </video>
    </div>
    <div id="subtitle-upload-container" class="subtitle-upload" style="display: <?php echo $enable_subtitles ? 'block' : 'none'; ?>;">
        <label for="subtitle-input" class="upload-button">
            <span>Upload a subtitle file (.srt or .vtt UTF-8)</span>
            <input type="file" id="subtitle-input" accept=".srt,.vtt" />
        </label>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('video_player', 'video_plugin_shortcode');

// Enqueue CSS y JS
function video_plugin_enqueue_scripts() {
    wp_enqueue_style('video-plugin-style', plugins_url('css/video-plugin.css', __FILE__));
    wp_enqueue_script('video-plugin-script', plugins_url('js/video-plugin.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'video_plugin_enqueue_scripts');<?php
/*
Plugin Name: Embed videos with Subtitles
Description: A plugin to play embed videos with subtitles.
Version: 1.0
Author: MY-RLS
*/

// Agregar el menú de configuración del plugin
function video_plugin_menu() {
    add_menu_page(
        'Plugin Settings', // Título de la página
        'EVWS',                   // Título del menú
        'manage_options',                    // Capacidad necesaria
        'video-plugin-settings',             // Slug del menú
        'video_plugin_settings_page',        // Función para mostrar la página
        'dashicons-video-alt3',              // Icono del menú
        100                                 // Posición en el menú
    );
}
add_action('admin_menu', 'video_plugin_menu');

// Mostrar la página de configuración
function video_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('video_plugin_options_group');
            do_settings_sections('video-plugin-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Registrar configuraciones del plugin
function video_plugin_settings() {
    register_setting('video_plugin_options_group', 'video_plugin_enable_subtitles');

    add_settings_section(
        'video_plugin_main_section',
        'Main Options',
        null,
        'video-plugin-settings'
    );

    add_settings_field(
        'video_plugin_enable_subtitles',
        'Enable subtitle upload',
        'video_plugin_enable_subtitles_callback',
        'video-plugin-settings',
        'video_plugin_main_section'
    );
}
add_action('admin_init', 'video_plugin_settings');

// Mostrar el campo de habilitación de subtítulos
function video_plugin_enable_subtitles_callback() {
    $option = get_option('video_plugin_enable_subtitles');
    ?>
    <input type="checkbox" name="video_plugin_enable_subtitles" value="1" <?php checked(1, $option, true); ?> />
    <label for="video_plugin_enable_subtitles">Allow users to upload subtitles</label>
    <?php
}

// Modificar el shortcode para verificar la opción de carga de subtítulos
function video_plugin_shortcode($atts) {
    $atts = shortcode_atts(array(
        'url' => '',
    ), $atts, 'video_player');

    $enable_subtitles = get_option('video_plugin_enable_subtitles', 1);

    ob_start();
    ?>
    <div class="video-container">
        <video id="video-player" controls>
            <source src="<?php echo esc_url($atts['url']); ?>" type="video/mp4">
            Your browser does not support the video element.
        </video>
    </div>
    <div id="subtitle-upload-container" class="subtitle-upload" style="display: <?php echo $enable_subtitles ? 'block' : 'none'; ?>;">
        <label for="subtitle-input" class="upload-button">
            <span>Upload a subtitle file (.srt or .vtt UTF-8)</span>
            <input type="file" id="subtitle-input" accept=".srt,.vtt" />
        </label>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('video_player', 'video_plugin_shortcode');

// Enqueue CSS y JS
function video_plugin_enqueue_scripts() {
    wp_enqueue_style('video-plugin-style', plugins_url('css/video-plugin.css', __FILE__));
    wp_enqueue_script('video-plugin-script', plugins_url('js/video-plugin.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'video_plugin_enqueue_scripts');