<?php
/*
Plugin Name: TSA Organizer
Plugin URI: https://wordpress.org/plugins/tsa-organizer
Description: TSA Custom Post Type
Version: 0.3
Author: jarruego
Author URI: 
License: GPL2
License URI: https://www.gnu.org/licenses/gpl.html
*/

/*
Función para cargar los scripts necesarios
Estaría bien añadir varias opciones para activar o desactivar la carga de estos scripts, es posible que ya vengan cargados en la theme
*/
function tsao_prefix_enqueue() 
{   	
	if( ! wp_style_is( 'prefix_bootstrap', 'queue' )) {
	    // CSS
	    wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
	    wp_enqueue_style('prefix_bootstrap');
	}
    
    if( ! wp_script_is( 'prefix_bootstrap', 'queue' ) ){
		// JS
    	wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js');
    	wp_enqueue_script('prefix_bootstrap');
	}  
}
add_action( 'wp_enqueue_scripts', 'tsao_prefix_enqueue' );



// Register Custom Post Type Familia TSA
// Post Type Key: familiatsa
function tsao_create_familiatsa_cpt() {

	$labels = array(
		'name' => __( 'Familias TSA', 'Post Type General Name', 'textdomain' ),
		'singular_name' => __( 'Familia TSA', 'Post Type Singular Name', 'textdomain' ),
		'menu_name' => __( 'Familias TSA', 'textdomain' ),
		'name_admin_bar' => __( 'Familia TSA', 'textdomain' ),
		'archives' => __( 'Archivos Familia TSA', 'textdomain' ),
		'attributes' => __( 'Atributos Familia TSA', 'textdomain' ),
		'parent_item_colon' => __( 'Padres Familia TSA:', 'textdomain' ),
		'all_items' => __( 'Todas Familias TSA', 'textdomain' ),
		'add_new_item' => __( 'Añadir nueva Familia TSA', 'textdomain' ),
		'add_new' => __( 'Añadir nueva', 'textdomain' ),
		'new_item' => __( 'Nueva Familia TSA', 'textdomain' ),
		'edit_item' => __( 'Editar Familia TSA', 'textdomain' ),
		'update_item' => __( 'Actualizar Familia TSA', 'textdomain' ),
		'view_item' => __( 'Ver Familia TSA', 'textdomain' ),
		'view_items' => __( 'Ver Familias TSA', 'textdomain' ),
		'search_items' => __( 'Buscar Familia TSA', 'textdomain' ),
		'not_found' => __( 'No se encontraron Familias TSA.', 'textdomain' ),
		'not_found_in_trash' => __( 'Ningún Familia TSA encontrado en la papelera.', 'textdomain' ),
		'featured_image' => __( 'Imagen destacada', 'textdomain' ),
		'set_featured_image' => __( 'Establecer imagen destacada', 'textdomain' ),
		'remove_featured_image' => __( 'Borrar imagen destacada', 'textdomain' ),
		'use_featured_image' => __( 'Usar como imagen destacada', 'textdomain' ),
		'insert_into_item' => __( 'Insertar en la Familia TSA', 'textdomain' ),
		'uploaded_to_this_item' => __( 'Subido a esta Familia TSA', 'textdomain' ),
		'items_list' => __( 'Lista de Familias TSA', 'textdomain' ),
		'items_list_navigation' => __( 'Navegación por el listado de Familias TSA', 'textdomain' ),
		'filter_items_list' => __( 'Lista de Familias TSA filtradas', 'textdomain' ),
	);
	$args = array(
		'label' => __( 'Familia TSA', 'textdomain' ),
		'description' => __( 'Familia de productos para el TSA', 'textdomain' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-networking',
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'custom-fields', ),		
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => false,
		'hierarchical' => true,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'page',
	);
	register_post_type( 'familiatsa', $args );
}
add_action( 'init', 'tsao_create_familiatsa_cpt', 0 );



//Nueva taxonomía Grupos TSA
function tsao_create_grupos_TSA_hierarchical_taxonomy() {
 // Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI 
  $labels = array(
    'name' => _x( 'Grupos de TSA', 'taxonomy general name' ),
    'singular_name' => _x( 'Grupo TSA', 'taxonomy singular name' ),
    'search_items' =>  __( 'Buscar Grupos de TSA' ),
    'all_items' => __( 'Todos los Grupos de TSA' ),
    'parent_item' => __( 'Grupo de TSA padre' ),
    'parent_item_colon' => __( 'Grupo de TSA padre:' ),
    'edit_item' => __( 'Editar Grupos de TSA' ), 
    'update_item' => __( 'Actualizar Grupo de TSA' ),
    'add_new_item' => __( 'Añadir Grupo de TSA' ),
    'new_item_name' => __( 'Nuevo nombre de Grupo de TSA' ),
    'menu_name' => __( 'Grupos de TSA' ),
  );     
  register_taxonomy('grupos_tsa',array('familiatsa'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'grupo_tsa' ),
  )); 
}
add_action( 'init', 'tsao_create_grupos_TSA_hierarchical_taxonomy', 0 );



//2 funciones para borrar los slug de los enlaces permanentes del custom post familiatsa
function tsao_remove_evil_slugs($post_link, $post, $leavename) {

    if('familiatsa' != $post->post_type ||'publish' != $post->post_status) {
        return $post_link;
    }

    $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);

    return $post_link;
}
add_filter('post_type_link', 'tsao_remove_evil_slugs', 10, 3);

function  tsao_parse_evil_slugs($query) {

    if(!$query->is_main_query() || 2 != count($query->query) || !isset($query->query['page'])) {
        return;
    }

    if(!empty($query->query['name'])) {
        $query->set('post_type', array('post', 'familiatsa', 'page'));
    }
}
add_action('pre_get_posts', 'tsao_parse_evil_slugs');



/*Crea los metaboxes y custom fields para el CPT familiatsa*/
function tsao_TSAs_metabox() {
  add_meta_box( 'tsao_TSAs-metabox', 'Información para TSA', 'tsao_campos_TSA', 'familiatsa', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'tsao_TSAs_metabox' );

function tsao_campos_TSA($post) {
  //si existen se recuperan los valores de los metadatos
  $TSA_descripcion = get_post_meta( $post->ID, 'TSA_descripcion', true );
  $TSA_busquedas = get_post_meta( $post->ID, 'TSA_busquedas', true );
 
  // Se añade un campo nonce para probarlo más adelante cuando validemos
  wp_nonce_field( 'campos_TSA_metabox', 'campos_TSA_metabox_nonce' );?>
 
  <table width="100%" cellpadding="1" cellspacing="1" border="0">
    <tr>
      <td width="20%"><strong>Descripción Corta</strong><br /></td>
      <td width="80%"><input type="text" autofocus id="TSA_descripcion" name="TSA_descripcion" value="<?php echo sanitize_text_field($TSA_descripcion);?>" class="large-text" placeholder="Descripción de la Familia del TSA" autocomplete="off"  /></td>      
    </tr>
    <tr>
      <td width="20%"><strong>Nº Búsquedas</strong><br /></td>
      <td width="80%"><input type="text" name="TSA_busquedas" value="<?php echo sanitize_text_field($TSA_busquedas);?>" class="large-text" placeholder="Nº Búsquedas" /></td>
    </tr>
  </table>
<?php }?>
<?php
/*Guarda los datos de los nuevos metaboxes al guardar cualquier Post*/
function tsao_campos_TSA_save_data($post_id) {
  // Comprobamos si se ha definido el nonce.
  if ( ! isset( $_POST['campos_TSA_metabox_nonce'] ) ) {
    return $post_id;
  }
  $nonce = $_POST['campos_TSA_metabox_nonce'];
 
  // Verificamos que el nonce es válido.
  if ( !wp_verify_nonce( $nonce, 'campos_TSA_metabox' ) ) {
    return $post_id;
  }
 
  // Si es un autoguardado nuestro formulario no se enviará, ya que aún no queremos hacer nada.
  if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
    return $post_id;
  }
 
  // Comprobamos los permisos de usuario.
  if ( $_POST['post_type'] == 'page' ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }
 
  // Vale, ya es seguro que guardemos los datos.
 
  // Si existen entradas antiguas las recuperamos
  $old_TSA_descripcion = get_post_meta( $post_id, 'TSA_descripcion', true );
  $old_TSA_busquedas = get_post_meta( $post_id, 'TSA_busquedas', true );
  
  // Saneamos lo introducido por el usuario.
  $TSA_descripcion = sanitize_text_field( $_POST['TSA_descripcion'] );
  $TSA_busquedas = sanitize_text_field( $_POST['TSA_busquedas'] );
 
  // Actualizamos el campo meta en la base de datos.
  update_post_meta( $post_id, 'TSA_descripcion', $TSA_descripcion, $old_TSA_descripcion );
  update_post_meta( $post_id, 'TSA_busquedas', $TSA_busquedas, $old_TSA_busquedas );
}
add_action( 'save_post', 'tsao_campos_TSA_save_data' );



/*Función de shortcode muestra un listado de enlaces a las familias TSA 
Por defeto: listado de familias con más búsquedas que la Familia Actual
Personalizado: podemos filtrar por ids de familia a mostrar separados por comas y también podemos limitar el número de elementos*/
function tsao_grid_TSA($atts){
    $p = shortcode_atts( array (
    'filtro' => '*',//podemos pasarle los IDs separados por comas
	'num_posts' => 30,
	'grupos'=>''
    ), $atts );
	

	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	if ( ! empty( get_post_meta( get_the_ID(), 'TSA_busquedas', true ) ) ) {
		$TSA_busquedas = get_post_meta( get_the_ID(), 'TSA_busquedas', true );
	}else{
		$TSA_busquedas = 0;
	}
	  

	
	if ($p['filtro']=="*") {
		$args = array(
			'post_type' => 'familiatsa',
            'tax_query' => array('relation' => 'OR'),
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $p['num_posts'],
			'orderby' => 'rand',
			'paged' => $paged,
			'post__not_in' => array(get_the_ID()), 
			'meta_query'	=> array(
				'relation'		=> 'AND',
				array(
					'key'	 	=> 'TSA_busquedas',
					'value'	  	=> $TSA_busquedas,
					'type'		=> 'NUMERIC',
					'compare' 	=> '>=',
				)
			)
		);
	}else{
		$no_whitespaces = preg_replace( '/\s*,\s*/', ',', filter_var( $p['filtro'], FILTER_SANITIZE_STRING ) ); 
		echo $no_whitespaces;
		$array_posts = explode( ',', $no_whitespaces ); 		
		$args = array(
			'post_type' => 'familiatsa',
            'tax_query' => array('relation' => 'OR'),
			'post__in' => $array_posts, 
			'ignore_sticky_posts' => 1,
			'orderby' => 'rand',
			'paged' => $paged,
		);
	}

	/*Filtramos las TSA a mostrar según los grupos al que pertenece la familia TSA
	  Si no pertenece a ningún grupo muestra todos
	  Si pasamos el parámetro grupos muestra sólo esos grupos*/
	if ($p['grupos']=='') {	
		$array_grupos = get_the_terms( get_the_ID(), 'grupos_tsa' );
		$typeName = array();
		if (!empty($array_grupos)) {
			foreach ( $array_grupos as $grupo ) {
				$typeName[] = $grupo->name;
				foreach ( $typeName as $nombre_grupo ) {
					array_push( 
						$args['tax_query'],
						array(
							'taxonomy' => 'grupos_tsa',
							'field'    => 'slug',
							'terms'    => $nombre_grupo,
							)
					 );		
				}			
			}
		}
	}else{
		$array_grupos =explode(",",$p['grupos']);
		foreach ( $array_grupos as $nombre_grupo ) {
			array_push( 
				$args['tax_query'],
				array(
					'taxonomy' => 'grupos_tsa',
					'field'    => 'slug',
					'terms'    => $nombre_grupo,
					)
			 );		
		}		
	}
	
	
	$loop = new WP_Query($args);
	
	ob_start();
	
    if ( $loop->have_posts() ) :
		?>
		<div class="container">
		<div class="card-deck">
		<?php
		$total = $loop->post_count;
		$cont=1;

        while ( $loop->have_posts() ) : $loop->the_post(); 
		?>		
			<div class="card card-tsa mb-4 mr-2 ml-2">
				<a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
					<?php the_post_thumbnail('medium', array('class' => 'card-img-top','title' => get_the_title()) ); ?>
				</a>
				<div class="card-body p-0">
					<div class="card-title p-2 mb-0">
						<h3>
							<a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a>
						</h3>
					</div>
					<div class="card-text p-2 mb-0">
						<p class="desccorta"><?php echo "<br>".substr(get_post_meta(get_the_ID(),'TSA_descripcion',true),0,400);?></p><!-- /.descripción corta -->
					</div>
				</div>
			</div>        
		<?php
			//añado un div de salto de línea de forma responsive
			if ($cont % 2 == 0) {
				echo '<div class="w-100 d-none d-sm-block d-md-none"><!-- wrap every 2 on sm--></div>';
			}
			if ($cont % 3 == 0) {
				echo '<div class="w-100 d-none d-md-block d-lg-none"><!-- wrap every 3 on md--></div>';
			}
			if ($cont % 4 == 0){
				echo '<div class="w-100 d-none d-lg-block d-xl-none"><!-- wrap every 4 on lg--></div>';
			}
			if ($cont % 5 == 0) {
				echo '<div class="w-100 d-none d-xl-block"><!-- wrap every 5 on xl--></div>';
			}
			if ($total==$cont){
				if ($cont < $p['num_posts'] ) {
					//echo dibujar_add_ruta($array_etiquetas);
					$total++;		
				}
				//Según el número de rutas, añado cards para cuadrar el grid de forma responsive
				if($total%2!=0){for ($i=2-($total%2);$i>0;$i--){echo '<div class="card mb-4 d-none d-sm-block d-md-none border-0"></div>';}}
				if($total%3!=0){for ($i=3-($total%3);$i>0;$i--){echo '<div class="card mb-4 d-none d-md-block d-lg-none border-0"></div>';}}
				if($total%4!=0){for ($i=4-($total%4);$i>0;$i--){echo '<div class="card mb-4 d-none d-lg-block d-xl-none border-0"></div>';}}
				if($total%5!=0){for ($i=5-($total%5);$i>0;$i--){echo '<div class="card mb-4 d-none d-xl-block border-0"></div>';}}
			}
			$cont++;
		endwhile;
		?>

		</div>
		</div>
		<?php
    endif;
    wp_reset_postdata();
	
    $output = ob_get_clean();
    return $output;
	
}
add_shortcode('grid_TSA','tsao_grid_TSA');


/*Añadimos el listado de familias del TSA al final de cada Post de tipo Familia TSA*/
function tsao_list_TSA_after_content( $content ) {
	$output_shortcode= $content;
    if ( 'familiatsa' == get_post_type() ){
		$Listado_TSA = do_shortcode( '[grid_TSA]' );
		if ($Listado_TSA!=''){
			$output_shortcode = $content."<h2>Además de ".get_the_title().", en nuestra tienda también puedes encontrar:</h2> ".$Listado_TSA;
		}
	}
    return $output_shortcode;
}
add_filter( 'the_content', 'tsao_list_TSA_after_content');




