<?php
/**
 * Plugin Name: Shelters Extend
 * Description: Taxonomies, REST API, and importer for existing 'shelters' post type
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * ============================================
 * 1. ENABLE REST API FOR EXISTING POST TYPE
 * ============================================
 */
function shelters_enable_rest( $args, $post_type ) {
  if ( $post_type === 'shelters' ) {
    $args['show_in_rest'] = true;
    $args['rest_base']    = 'shelters';
  }
  return $args;
}
add_filter( 'register_post_type_args', 'shelters_enable_rest', 10, 2 );

/**
 * ============================================
 * 2. REGISTER TAXONOMIES
 * ============================================
 */
function shelters_register_taxonomies() {

  $taxonomies = array(
    // Show in admin columns
    array( 'marker-type',       'Тип маркера',          true,  true ),
    array( 'shelter-district',  'Район',                true,  true ),
    array( 'condition',         'Стан укриття',         true,  true ),

    // Hide from admin columns
    array( 'shelter-category',  'Вид укриття',          true,  false ),
    array( 'inclusivity',       'Інклюзивність',        true,  false ),
    array( 'fullday',           'Цілодобово',           true,  false ),
    array( 'seats',             'Місця для сидіння',    true,  false ),
    array( 'wc',                'Вбиральня',            true,  false ),
    array( 'water',             'Вода',                 true,  false ),
    array( 'capacity',          'Місткість',            false, false ),
    array( 'area',              'Площа',                false, false ),
    array( 'additional-info',   'Додаткова інформація', false, false ),
  );

  foreach ( $taxonomies as $tax ) {
    register_taxonomy( $tax[0], 'shelters', array(
      'labels' => array(
        'name'          => $tax[1],
        'singular_name' => $tax[1],
        'menu_name'     => $tax[1],
      ),
      'hierarchical'      => $tax[2],
      'public'            => true,
      'show_ui'           => true,
      'show_admin_column' => $tax[3],
      'show_in_rest'      => true,
      'rewrite'           => array( 'slug' => $tax[0] ),
    ) );
  }

  // Create default marker types
  $marker_types = array(
    'shelter'            => 'Укриття',
    'destroyed_building' => 'Зруйновані будівлі',
    'child_death'        => 'Загибель дітей',
    'expensive_shelters' => 'Дорогі укриття',
  );

  foreach ( $marker_types as $slug => $name ) {
    if ( ! term_exists( $slug, 'marker-type' ) ) {
      wp_insert_term( $name, 'marker-type', array( 'slug' => $slug ) );
    }
  }
}
add_action( 'init', 'shelters_register_taxonomies', 0 );

/**
 * ============================================
 * 3. ADMIN COLUMNS
 * ============================================
 */
function shelters_admin_columns( $columns ) {
  return array(
    'cb'                        => $columns['cb'],
    'title'                     => 'Адреса',
    'taxonomy-marker-type'      => 'Тип',
    'taxonomy-shelter-district' => 'Район',
    'shelter_coords'            => 'Координати',
    'date'                      => 'Дата',
  );
}
add_filter( 'manage_shelters_posts_columns', 'shelters_admin_columns' );

function shelters_admin_columns_content( $column, $post_id ) {
  if ( $column === 'shelter_coords' ) {
    $lat = get_post_meta( $post_id, 'shelter_lat', true );
    $lng = get_post_meta( $post_id, 'shelter_lng', true );
    echo ( $lat && $lng )
      ? '<small>' . esc_html( "$lat, $lng" ) . '</small>'
      : '<span style="color:#c00;">❌</span>';
  }
}
add_action( 'manage_shelters_posts_custom_column', 'shelters_admin_columns_content', 10, 2 );

/**
 * ============================================
 * 4. META BOX FOR COORDINATES
 * ============================================
 */
function shelters_add_meta_box() {
  add_meta_box( 'shelter_coords', 'Координати', 'shelters_meta_box_html', 'shelters', 'side' );
}
add_action( 'add_meta_boxes', 'shelters_add_meta_box' );

function shelters_meta_box_html( $post ) {
  $lat = get_post_meta( $post->ID, 'shelter_lat', true );
  $lng = get_post_meta( $post->ID, 'shelter_lng', true );
  $address = get_post_meta( $post->ID, 'shelter_address', true );
  wp_nonce_field( 'shelter_meta', 'shelter_meta_nonce' );
  ?>
  <p>
    <label>Адреса:</label><br>
    <input type="text" name="shelter_address" value="<?php echo esc_attr( $address ); ?>" style="width:100%;">
  </p>
  <p>
    <label>Широта (lat):</label><br>
    <input type="text" name="shelter_lat" value="<?php echo esc_attr( $lat ); ?>" style="width:100%;">
  </p>
  <p>
    <label>Довгота (lng):</label><br>
    <input type="text" name="shelter_lng" value="<?php echo esc_attr( $lng ); ?>" style="width:100%;">
  </p>
  <?php
}

function shelters_save_meta( $post_id ) {
  if ( ! isset( $_POST['shelter_meta_nonce'] ) ||
       ! wp_verify_nonce( $_POST['shelter_meta_nonce'], 'shelter_meta' ) ) {
    return;
  }
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

  $fields = array( 'shelter_address', 'shelter_lat', 'shelter_lng' );
  foreach ( $fields as $field ) {
    if ( isset( $_POST[ $field ] ) ) {
      update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
    }
  }
}
add_action( 'save_post_shelters', 'shelters_save_meta' );




/**
 * ============================================
 * 5. REST API
 * ============================================
 */
function shelters_register_rest_routes() {
  register_rest_route( 'shelters/v1', '/list', array(
    'methods'             => 'GET',
    'callback'            => 'shelters_api_list',
    'permission_callback' => '__return_true',
  ) );

  register_rest_route( 'shelters/v1', '/(?P<id>\d+)', array(
    'methods'             => 'GET',
    'callback'            => 'shelters_api_single',
    'permission_callback' => '__return_true',
  ) );
}
add_action( 'rest_api_init', 'shelters_register_rest_routes' );


/**
 * ============================================
 * REVIEWS SYSTEM
 * ============================================
 */

/**
 * Register review submission endpoint
 */
function shelters_register_review_routes() {
  // Submit review
  register_rest_route( 'shelters/v1', '/review', array(
    'methods'             => 'POST',
    'callback'            => 'shelters_submit_review',
    'permission_callback' => '__return_true',
    'args'                => array(
      'shelter_id' => array(
        'required'          => true,
        'type'              => 'integer',
        'sanitize_callback' => 'absint',
      ),
      'name' => array(
        'required'          => true,
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field',
      ),
      'email' => array(
        'required'          => false,
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_email',
      ),
      'rating' => array(
        'required'          => true,
        'type'              => 'integer',
        'sanitize_callback' => 'absint',
      ),
      'text' => array(
        'required'          => true,
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_textarea_field',
      ),
    ),
  ) );

  // Get reviews for specific shelter
  register_rest_route( 'shelters/v1', '/reviews/(?P<id>\d+)', array(
    'methods'             => 'GET',
    'callback'            => 'shelters_get_reviews_endpoint',
    'permission_callback' => '__return_true',
  ) );
}
add_action( 'rest_api_init', 'shelters_register_review_routes' );

/**
 * Submit review handler
 */
function shelters_submit_review( $request ) {
  $shelter_id = absint( $request->get_param( 'shelter_id' ) );
  $name       = sanitize_text_field( $request->get_param( 'name' ) );
  $email      = sanitize_email( $request->get_param( 'email' ) );
  $rating     = absint( $request->get_param( 'rating' ) );
  $text       = sanitize_textarea_field( $request->get_param( 'text' ) );
  $images     = $request->get_param( 'images' );

  // Validate shelter exists
  $post = get_post( $shelter_id );

	do_action( 'qm/info', $post );


  if ( ! $post || $post->post_type !== 'shelters' ) {
    return new WP_Error( 'invalid_shelter', 'Укриття не знайдено', array( 'status' => 404 ) );
  }

  // Validate name
  if ( empty( $name ) ) {
    return new WP_Error( 'name_required', "Введіть ваше ім'я", array( 'status' => 400 ) );
  }

  // Validate rating
  $rating = max( 1, min( 5, $rating ) );

  // Validate text length
  if ( mb_strlen( $text ) < 10 ) {
    return new WP_Error( 'text_too_short', 'Відгук занадто короткий (мін. 10 символів)', array( 'status' => 400 ) );
  }

  // Check for spam (rate limiting by IP)
  $ip = $_SERVER['REMOTE_ADDR'];
  $recent = get_comments( array(
    'post_id'    => $shelter_id,
    'author_ip'  => $ip,
    'date_query' => array( 'after' => '1 minute ago' ),
    'count'      => true,
  ) );

  if ( $recent > 0 ) {
    // return new WP_Error( 'rate_limit', 'Зачекайте 1 хвилину перед наступним відгуком', array( 'status' => 429 ) );
  }

  // Insert comment
  $comment_id = wp_insert_comment( array(
    'comment_post_ID'      => $shelter_id,
    'comment_author'       => $name,
    'comment_author_email' => $email,
    'comment_author_IP'    => $ip,
    'comment_content'      => $text,
    'comment_type'         => 'review',
    'comment_approved'     => 0, // Pending moderation
    'user_id'              => get_current_user_id(),
  ) );

  if ( ! $comment_id ) {
    return new WP_Error( 'insert_failed', 'Не вдалося зберегти відгук', array( 'status' => 500 ) );
  }



  // Save rating
  add_comment_meta( $comment_id, 'rating', $rating );

  // Save images if any
  if ( ! empty( $images ) && is_array( $images ) ) {
    add_comment_meta( $comment_id, 'images', array_map( 'esc_url', $images ) );
  }

  $admin_email = get_option('admin_email');
  $subject = 'Новий коментар на мапі укриттів';
  $comment_link = admin_url('edit-comments.php');
  $comment_content = isset($text) ? $text : 'Без тексту';
  $message = "Новий коментар був доданий.\n\nЗміст коментаря: $comment_content\nВи можете переглянути його та заапрувити за посиланням: $comment_link";

  wp_mail($admin_email, $subject, $message);

  return rest_ensure_response( array(
    'success'    => true,
    'message'    => 'Дякуємо! Ваш відгук буде опубліковано після модерації.',
    'comment_id' => $comment_id,
  ) );
}

/**
 * Get reviews for specific shelter
 */
function shelters_get_reviews_endpoint( $request ) {
  $shelter_id = (int) $request['id'];

  $post = get_post( $shelter_id );
  if ( ! $post || $post->post_type !== 'shelters' ) {
    return new WP_Error( 'not_found', 'Not found', array( 'status' => 404 ) );
  }

  $reviews = shelters_get_reviews( $shelter_id );
  $stats   = shelters_get_review_stats( $shelter_id );

  return rest_ensure_response( array(
    'shelter_id' => $shelter_id,
    'stats'      => $stats,
    'reviews'    => $reviews,
  ) );
}

/**
 * Get review statistics
 */
function shelters_get_review_stats( $id ) {
  $comments = get_comments( array(
    'post_id' => $id,
    'status'  => 'approve',
  ) );

  if ( empty( $comments ) ) {
    return array(
      'count'   => 0,
      'average' => 0,
      'stars'   => array( 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0 ),
    );
  }

  $total = 0;
  $stars = array( 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0 );

  foreach ( $comments as $comment ) {
    $rating = (int) get_comment_meta( $comment->comment_ID, 'rating', true ) ?: 5;
    $total += $rating;
    $stars[ $rating ]++;
  }

  return array(
    'count'   => count( $comments ),
    'average' => round( $total / count( $comments ), 1 ),
    'stars'   => $stars,
  );
}
/**
 * AJAX handler for image upload (optional)
 */
function shelters_upload_image() {

  if ( empty( $_FILES['file'] ) ) {
    wp_send_json_error( array( 'message' => 'No file uploaded' ) );
  }

	$file = $_FILES['file'];

	// Validate file
	$validation = shelter_validate_image_file($file);

	if (is_wp_error($validation)) {
		wp_send_json_error(array('message' => $validation->get_error_message()), 400);
	}

  require_once ABSPATH . 'wp-admin/includes/image.php';
  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/media.php';

  $attachment_id = media_handle_upload( 'file', 0 );

  if ( is_wp_error( $attachment_id ) ) {
    wp_send_json_error( array( 'message' => $attachment_id ) );
  }

  wp_send_json_success( array(
    'id'  => $attachment_id,
    'url' => wp_get_attachment_url( $attachment_id ),
  ) );
}
add_action( 'wp_ajax_shelter_upload_image', 'shelters_upload_image' );
add_action( 'wp_ajax_nopriv_shelter_upload_image', 'shelters_upload_image' );

function shelters_get_reviews( $id ) {
  $comments = get_comments( array(
    'post_id' => $id,
    'status'  => 'approve',
    'type'    => array( 'comment', 'review' ),
    'orderby' => 'comment_date',
    'order'   => 'DESC',
  ) );

  return array_map( function( $c ) {
    $rating = (int) get_comment_meta( $c->comment_ID, 'rating', true );
    $images = get_comment_meta( $c->comment_ID, 'images', true );

    return array(
      'id'     => (int) $c->comment_ID,
      'name'   => $c->comment_author,
      'stars'  => $rating ?: 5,
      'date'   => date( 'd.m.y', strtotime( $c->comment_date ) ),
      'time'   => date( 'H:i', strtotime( $c->comment_date ) ),
      'text'   => $c->comment_content,
      'images' => is_array( $images ) ? $images : array(),
    );
  }, $comments );
}

/**
 * Validate image file
 */
function shelter_validate_image_file($file) {
	// Allowed MIME types
	$allowed_types = array(
		'image/jpeg',
		'image/png',
		'image/gif',
		'image/webp',
	);

	// Allowed extensions
	$allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');

	// Max file size (5MB)
	$max_size = 5 * 1024 * 1024;

	// Check for upload errors
	if ($file['error'] !== UPLOAD_ERR_OK) {
		$error_messages = array(
			UPLOAD_ERR_INI_SIZE   => 'Файл перевищує максимальний розмір',
			UPLOAD_ERR_FORM_SIZE  => 'Файл перевищує максимальний розмір',
			UPLOAD_ERR_PARTIAL    => 'Файл завантажено частково',
			UPLOAD_ERR_NO_FILE    => 'Файл не завантажено',
			UPLOAD_ERR_NO_TMP_DIR => 'Помилка сервера',
			UPLOAD_ERR_CANT_WRITE => 'Помилка запису',
			UPLOAD_ERR_EXTENSION  => 'Завантаження заблоковано',
		);

		$message = isset($error_messages[$file['error']])
			? $error_messages[$file['error']]
			: 'Помилка завантаження';

		return new WP_Error('upload_error', $message);
	}

	// Check file size
	if ($file['size'] > $max_size) {
		return new WP_Error('file_too_large', 'Файл занадто великий. Максимум 5MB');
	}

	// Check file extension
	$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
	if (!in_array($extension, $allowed_extensions)) {
		return new WP_Error('invalid_extension', 'Недопустиме розширення файлу. Дозволено: ' . implode(', ', $allowed_extensions));
	}

	// Check MIME type from file info
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime_type = finfo_file($finfo, $file['tmp_name']);
	finfo_close($finfo);

	if (!in_array($mime_type, $allowed_types)) {
		return new WP_Error('invalid_type', 'Недопустимий тип файлу. Дозволено тільки зображення: JPG, PNG, GIF, WebP');
	}

	// Additional check: verify it's actually an image
	$image_info = @getimagesize($file['tmp_name']);
	if ($image_info === false) {
		return new WP_Error('not_image', 'Файл не є зображенням');
	}

	// Check image dimensions (optional - prevent very large images)
	$max_dimension = 5000; // pixels
	if ($image_info[0] > $max_dimension || $image_info[1] > $max_dimension) {
		return new WP_Error('image_too_large', "Зображення занадто велике. Максимум {$max_dimension}x{$max_dimension} пікселів");
	}

	return true;
}

function shelters_api_list( $request ) {
  $args = array(
    'post_type'      => 'shelters',
    'post_status'    => 'publish',
    'posts_per_page' => $request->get_param( 'per_page' ) ?: -1,
    'paged'          => $request->get_param( 'page' ) ?: 1,
    'tax_query'      => array(),
  );

  // Filters
  $filters = array(
    'type'     => 'marker-type',
    'district' => 'shelter-district',
  );

  foreach ( $filters as $param => $taxonomy ) {
    $value = $request->get_param( $param );
    if ( $value ) {
      $args['tax_query'][] = array(
        'taxonomy' => $taxonomy,
        'field'    => 'slug',
        'terms'    => $value,
      );
    }
  }

  if ( count( $args['tax_query'] ) > 1 ) {
    $args['tax_query']['relation'] = 'AND';
  }

  $query = new WP_Query( $args );
  $items = array_map( 'shelters_format_post', $query->posts );

  return rest_ensure_response( $items );
}

function shelters_api_single( $request ) {
  $post = get_post( (int) $request['id'] );

  if ( ! $post || $post->post_type !== 'shelters' ) {
    return new WP_Error( 'not_found', 'Not found', array( 'status' => 404 ) );
  }

  return rest_ensure_response( shelters_format_post( $post ) );
}

function shelters_format_post( $post ) {
  $id = $post->ID;

  $reviews = shelters_get_reviews( $id );
  $stats   = shelters_get_review_stats( $id );

  return array(
    'id'        => $id,
    'type'      => shelters_get_term_slug( $id, 'marker-type' ) ?: 'shelter',
    'type_cyr'      => shelters_get_term_name( $id, 'marker-type' ) ?: 'Сховище',
    'lat'       => get_post_meta( $id, 'shelter_lat', true ) ?: null,
    'lon'       => get_post_meta( $id, 'shelter_lng', true ) ?: null,
    'district'  => shelters_get_district_code( $id ),
    'district_cyr' => shelters_get_term_name( $id, 'shelter-district' ),
    'adress'    => get_post_meta( $id, 'shelter_address', true ) ?: $post->post_title,
    'kind'    => shelters_get_term_name( $id, 'shelter-category' ),
    'inclusive' => shelters_get_term_name( $id, 'inclusivity' ),
    'fullday'   => shelters_get_term_name( $id, 'fullday') ?: 'Цілодобово',
    'condition' => shelters_get_term_name( $id, 'condition' ),
    'seats'     => shelters_get_term_name( $id, 'seats' ),
    //'wc'        => shelters_is_true( $id, 'wc' ),
    'wc'  => shelters_get_term_name( $id, 'wc' ),
    'water'     => shelters_get_term_name( $id, 'water' ),
    'capacity'  => shelters_get_term_name( $id, 'capacity' ),
    'square'    => shelters_get_term_name( $id, 'area' ),
    'gallery'   => shelters_get_gallery( $id ),
    'review_stats' => $stats,
    'reviews'      => $reviews,
    'destroyed' => shelters_destroyed_building($id),
    'info'      => get_the_excerpt($id),
    'exits'     => shelters_get_exits($id),
  );
}


// Helper functions
function shelters_get_term_name( $id, $tax ) {
  $terms = get_the_terms( $id, $tax );
  return ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : null;
}

function shelters_get_term_slug( $id, $tax ) {
  $terms = get_the_terms( $id, $tax );
  return ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->slug : null;
}

function shelters_is_true( $id, $tax, $check = null ) {
  $terms = get_the_terms( $id, $tax );
  if ( ! $terms || is_wp_error( $terms ) ) return false;

  $name = mb_strtolower( $terms[0]->name );

  if ( $check ) return $name === mb_strtolower( $check );

  return in_array( $name, array( 'так', 'є', 'yes', 'true', '1', 'наявна', 'наявний', 'доступно' ) );
}

function shelters_get_district_code( $id ) {
  $slug = shelters_get_term_slug( $id, 'shelter-district' );
  if ( ! $slug ) return null;

  $codes = array(
    'holosiivskyi' => 'gol', 'голосіївський' => 'gol',
    'darnytskyi' => 'dar', 'дарницький' => 'dar',
    'desnianskyi' => 'des', 'деснянський' => 'des',
    'dniprovskyi' => 'dni', 'дніпровський' => 'dni',
    'obolonskyi' => 'obo', 'оболонський' => 'obo',
    'pecherskyi' => 'pec', 'печерський' => 'pec',
    'podilskyi' => 'pod', 'подільський' => 'pod',
    'sviatoshynskyi' => 'svy', 'святошинський' => 'svy',
    'shevchenkivskyi' => 'shev', 'шевченківський' => 'shev',
    'solomianskyi' => 'sol', "солом'янський" => 'sol',
  );

  return $codes[ $slug ] ?? $slug;
}

function shelters_get_gallery( $id ) {
  $gallery = array();

  $thumb = get_post_thumbnail_id( $id );
  if ( $thumb ) $gallery[] = wp_get_attachment_url( $thumb );

  if ( function_exists( 'get_field' ) ) {
    $acf = get_field( 'gallery', $id );
    if ( $acf ) {
      foreach ( (array) $acf as $img ) {
        $gallery[] = is_array( $img ) ? $img['url'] : wp_get_attachment_url( $img );
      }
    }
  }

  $meta = get_post_meta( $id, 'shelter_gallery', true );
  if ( $meta ) {
    foreach ( explode( ',', $meta ) as $item ) {
      $item = trim( $item );
      $gallery[] = is_numeric( $item ) ? wp_get_attachment_url( $item ) : $item;
    }
  }

  return $gallery;
  // return array_values( array_filter( array_unique( $gallery ) ) );
}

function shelters_get_exits( $id ) {
  $exits = array();

  if ( function_exists( 'get_field' ) ) {
    $acf = get_field( 'metro_exit', $id );
    if ( $acf ) {
      foreach ( (array) $acf as $exit ) {
        $exits[] = $exit;
      }
    }
  }

  return $exits;
}

function shelters_destroyed_building( $id ) {
  $destroyed = array();

  if ( function_exists( 'get_field' ) ) {
    $acf = get_field( 'destroyed', $id );
  }

  return $acf;

  // return array_values( array_filter( array_unique( $gallery ) ) );
}

/**
 * ============================================
 * 6. COMMENT RATING
 * ============================================
 */
function shelters_comment_rating_field( $fields ) {
  $fields['rating'] = '<p class="comment-form-rating">
        <label>Оцінка</label>
        <select name="rating">
            <option value="5">★★★★★</option>
            <option value="4">★★★★☆</option>
            <option value="3">★★★☆☆</option>
            <option value="2">★★☆☆☆</option>
            <option value="1">★☆☆☆☆</option>
        </select>
    </p>';
  return $fields;
}
add_filter( 'comment_form_default_fields', 'shelters_comment_rating_field' );

function shelters_save_comment_rating( $id ) {
  if ( isset( $_POST['rating'] ) ) {
    add_comment_meta( $id, 'rating', max( 1, min( 5, (int) $_POST['rating'] ) ) );
  }
}
add_action( 'comment_post', 'shelters_save_comment_rating' );

/**
 * ============================================
 * 7. IMPORTER
 * ============================================
 */
function shelters_importer_menu() {
  add_menu_page( 'Імпорт укриттів', 'Імпорт укриттів', 'manage_options', 'shelter-importer', 'shelters_importer_page', 'dashicons-download', 30 );
}
add_action( 'admin_menu', 'shelters_importer_menu' );

function shelters_importer_page() {
  ?>
  <div class="wrap">
    <h1>Імпорт укриттів з Google Sheets</h1>
    <form method="post">
      <?php wp_nonce_field( 'shelter_import', '_nonce' ); ?>
      <table class="form-table">
        <tr>
          <th>Google Sheet CSV URL</th>
          <td><input type="url" name="url" class="large-text" required
                     value="https://docs.google.com/spreadsheets/d/15Dg0sqTboNPv2bUzRu_eEcUabCUbdUAuy1VbmAroVtw/export?format=csv&gid=1553904709"></td>
        </tr>
        <tr>
          <th>Геокодування</th>
          <td>
            <select name="geocoding">
              <option value="nominatim">OpenStreetMap</option>
              <option value="google">Google Maps API</option>
              <option value="none">Вимкнено</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>Google API Key</th>
          <td><input type="text" name="api_key" class="regular-text"
                     value="<?php echo esc_attr( get_option( 'shelter_google_api_key' ) ); ?>"></td>
        </tr>
        <tr>
          <th>Місто</th>
          <td><input type="text" name="city" value="Київ, Україна"></td>
        </tr>
        <tr>
          <th>Опції</th>
          <td>
            <label><input type="checkbox" name="skip_existing" checked> Пропустити існуючі</label><br>
            <label><input type="checkbox" name="dry_run"> Тестовий запуск</label>
          </td>
        </tr>
      </table>
      <p class="submit">
        <button type="submit" name="action" value="debug" class="button">🔍 Показати стовпці</button>
        <button type="submit" name="action" value="import" class="button button-primary">📥 Імпортувати</button>
      </p>
    </form>
    <?php
    if ( isset( $_POST['action'] ) && wp_verify_nonce( $_POST['_nonce'], 'shelter_import' ) ) {
      $_POST['action'] === 'debug' ? shelters_debug_columns() : shelters_process_import();
    }
    ?>
  </div>
  <?php
}

function shelters_fetch_csv( $url ) {
  $response = wp_remote_get( $url, array( 'timeout' => 60 ) );
  if ( is_wp_error( $response ) ) return $response;

  $rows = array_map( 'str_getcsv', explode( "\n", wp_remote_retrieve_body( $response ) ) );
  $headers = array_map( 'trim', array_shift( $rows ) );

  return array( 'headers' => $headers, 'rows' => $rows );
}

function shelters_debug_columns() {
  $data = shelters_fetch_csv( $_POST['url'] );
  if ( is_wp_error( $data ) ) {
    echo '<div class="notice notice-error"><p>' . $data->get_error_message() . '</p></div>';
    return;
  }

  echo '<div class="notice notice-info" style="padding:15px;"><h3>Стовпці:</h3><ol>';
  foreach ( $data['headers'] as $h ) {
    echo '<li><code>' . esc_html( $h ) . '</code></li>';
  }
  echo '</ol></div>';
}

function shelters_process_import() {
  $data = shelters_fetch_csv( $_POST['url'] );
  if ( is_wp_error( $data ) ) {
    echo '<div class="notice notice-error"><p>' . $data->get_error_message() . '</p></div>';
    return;
  }

  $skip     = isset( $_POST['skip_existing'] );
  $dry      = isset( $_POST['dry_run'] );
  $geocoding = $_POST['geocoding'];
  $api_key  = sanitize_text_field( $_POST['api_key'] );
  $city     = sanitize_text_field( $_POST['city'] );

  if ( $api_key ) update_option( 'shelter_google_api_key', $api_key );

  $stats = array( 'imported' => 0, 'skipped' => 0, 'geocoded' => 0, 'errors' => 0 );

  echo '<h3>Результати:</h3><div style="max-height:400px;overflow:auto;background:#f5f5f5;padding:10px;font-family:monospace;font-size:12px;">';

  foreach ( $data['rows'] as $i => $row ) {
    if ( empty( array_filter( $row ) ) ) continue;

    $item = array();
    foreach ( $data['headers'] as $j => $header ) {
      $item[ $header ] = isset( $row[ $j ] ) ? trim( $row[ $j ] ) : '';
    }

    $mapped = shelters_map_columns( $item );
    $row_num = $i + 2;

    if ( empty( $mapped['address'] ) ) {
      echo "<div style='color:#960;'>⚠️ #{$row_num}: Немає адреси</div>";
      $stats['skipped']++;
      continue;
    }

    if ( $skip ) {
      $exists = get_posts( array(
        'post_type'      => 'shelters',
        'meta_key'       => 'shelter_address',
        'meta_value'     => $mapped['address'],
        'posts_per_page' => 1,
      ) );
      if ( $exists ) {
        echo "<div style='color:#666;'>⏭️ #{$row_num}: Існує</div>";
        $stats['skipped']++;
        continue;
      }
    }

    if ( $geocoding !== 'none' && empty( $mapped['lat'] ) ) {
      $coords = shelters_geocode( $mapped['address'] . ', ' . $city, $geocoding, $api_key );
      if ( $coords ) {
        $mapped['lat'] = $coords['lat'];
        $mapped['lng'] = $coords['lng'];
        $stats['geocoded']++;
      }
      if ( $geocoding === 'nominatim' ) sleep( 1 );
    }

    if ( $dry ) {
      echo "<div style='color:#090;'>🔍 #{$row_num}: " . esc_html( mb_substr( $mapped['address'], 0, 50 ) ) . "</div>";
      $stats['imported']++;
      continue;
    }

    $post_id = wp_insert_post( array(
      'post_type'   => 'shelters',
      'post_title'  => $mapped['address'],
      'post_status' => 'publish',
    ) );

    if ( is_wp_error( $post_id ) ) {
      echo "<div style='color:#c00;'>❌ #{$row_num}: " . $post_id->get_error_message() . "</div>";
      $stats['errors']++;
      continue;
    }

    update_post_meta( $post_id, 'shelter_address', $mapped['address'] );
    if ( $mapped['lat'] ) update_post_meta( $post_id, 'shelter_lat', $mapped['lat'] );
    if ( $mapped['lng'] ) update_post_meta( $post_id, 'shelter_lng', $mapped['lng'] );

    $tax_fields = array(
      'marker-type', 'shelter-district', 'shelter-category',
      'status', 'inclusivity',
      'condition', 'seats', 'wc', 'water', 'capacity', 'area', 'additional-info',
    );

    foreach ( $tax_fields as $tax ) {
      if ( ! empty( $mapped[ $tax ] ) ) {
        $term = term_exists( $mapped[ $tax ], $tax );
        if ( ! $term ) $term = wp_insert_term( $mapped[ $tax ], $tax );
        if ( ! is_wp_error( $term ) ) {
          wp_set_object_terms( $post_id, (int) ( is_array( $term ) ? $term['term_id'] : $term ), $tax );
        }
      }
    }

    echo "<div style='color:#090;'>✅ #{$row_num}: ID {$post_id}</div>";
    $stats['imported']++;
  }

  echo '</div>';
  echo "<div class='notice notice-success' style='margin-top:15px;'><p>";
  echo "✅ {$stats['imported']} | ⏭️ {$stats['skipped']} | 📍 {$stats['geocoded']} | ❌ {$stats['errors']}</p></div>";
}

function shelters_map_columns( $row ) {
  // ⚠️ ADJUST COLUMN NAMES TO YOUR SPREADSHEET!
  return array(
    'address'          => $row['Адреса'] ?? $row['адреса'] ?? '',
    'lat'              => $row['Широта'] ?? $row['lat'] ?? '',
    'lng'              => $row['Довгота'] ?? $row['lng'] ?? $row['lon'] ?? '',
    'marker-type'      => $row['Тип'] ?? 'shelter',
    'shelter-district' => $row['Район'] ?? '',
    // 'shelter-type'     => $row['Тип укриття'] ?? '',
    'shelter-category' => $row['Вид'] ?? '',
    // 'building-type'    => $row['Тип будівлі'] ?? '',
    // 'owner'            => $row['Власник'] ?? '',
    // 'owner-form'       => $row['Форма власності'] ?? '',
    'status'           => $row['Стан'] ?? '',
    // 'phone'            => $row['Номер телефону'] ?? '',
    'inclusivity'      => $row['Інклюзивність'] ?? '',
    'condition'        => $row['Стан укриття'] ?? $row['Стан'] ?? '',
    'seats'            => $row['Місця для сидіння'] ?? '',
    'wc'               => $row['Туалет'] ?? $row['WC'] ?? '',
    'water'            => $row['Вода'] ?? '',
    'capacity'         => $row['Місткість'] ?? '',
    'area'             => $row['Площа'] ?? '',
    'fullday'          => $row['Режим роботи'] ?? '',
    // 'additional-info'  => $row['Додаткова інформація'] ?? $row['Примітки'] ?? '',
  );
}

function shelters_geocode( $address, $service, $api_key = '' ) {
  if ( $service === 'google' && $api_key ) {
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?' . http_build_query( array(
        'address' => $address, 'key' => $api_key, 'language' => 'uk', 'region' => 'ua',
      ) );
    $body = json_decode( wp_remote_retrieve_body( wp_remote_get( $url, array( 'timeout' => 10 ) ) ), true );
    if ( isset( $body['results'][0]['geometry']['location'] ) ) {
      $loc = $body['results'][0]['geometry']['location'];
      return array( 'lat' => $loc['lat'], 'lng' => $loc['lng'] );
    }
  } else {
    $url = 'https://nominatim.openstreetmap.org/search?' . http_build_query( array(
        'q' => $address, 'format' => 'json', 'limit' => 1,
      ) );
    $body = json_decode( wp_remote_retrieve_body( wp_remote_get( $url, array(
      'timeout' => 10, 'headers' => array( 'User-Agent' => 'WP Shelter Importer/1.0' ),
    ) ) ), true );
    if ( isset( $body[0]['lat'] ) ) {
      return array( 'lat' => $body[0]['lat'], 'lng' => $body[0]['lon'] );
    }
  }
  return false;
}



/**
 * Display review images in WordPress admin comments
 */

/**
 * Add custom column to comments list
 */
add_filter('manage_edit-comments_columns', 'shelter_comments_columns');
function shelter_comments_columns($columns) {
  $new_columns = array();

  foreach ($columns as $key => $value) {
    $new_columns[$key] = $value;

    // Add after 'comment' column
    if ($key === 'comment') {
      $new_columns['review_rating'] = 'Оцінка';
      $new_columns['review_images'] = 'Фото';
    }
  }

  return $new_columns;
}

/**
 * Display content in custom columns
 */
add_action('manage_comments_custom_column', 'shelter_comments_column_content', 10, 2);
function shelter_comments_column_content($column, $comment_id) {
  switch ($column) {
    case 'review_rating':
      $rating = get_comment_meta($comment_id, 'rating', true);
      if ($rating) {
        $stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
        echo '<span style="color: #f5a623; font-size: 16px;">' . $stars . '</span>';
        echo '<br><small>(' . $rating . '/5)</small>';
      } else {
        echo '—';
      }
      break;

    case 'review_images':
      $images = get_comment_meta($comment_id, 'images', true);
      if (!empty($images) && is_array($images)) {
        echo '<div style="display: flex; gap: 5px; flex-wrap: wrap;">';
        foreach ($images as $image_url) {
          echo '<a href="' . esc_url($image_url) . '" target="_blank">';
          echo '<img src="' . esc_url($image_url) . '" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">';
          echo '</a>';
        }
        echo '</div>';
        echo '<small>' . count($images) . ' фото</small>';
      } else {
        echo '—';
      }
      break;
  }
}

/**
 * Add images to comment edit screen (meta box)
 */
add_action('add_meta_boxes_comment', 'shelter_comment_meta_box');
function shelter_comment_meta_box() {
  add_meta_box(
    'shelter_review_details',
    'Деталі відгуку',
    'shelter_review_meta_box_callback',
    'comment',
    'normal',
    'high'
  );
}

/**
 * Meta box content
 */
function shelter_review_meta_box_callback($comment) {
  $rating = get_comment_meta($comment->comment_ID, 'rating', true);
  $images = get_comment_meta($comment->comment_ID, 'images', true);

  wp_nonce_field('shelter_review_meta', 'shelter_review_meta_nonce');
  ?>
  <style>
      .shelter-review-meta { padding: 10px 0; }
      .shelter-review-meta label { display: block; font-weight: 600; margin-bottom: 5px; }
      .shelter-review-meta .rating-display { font-size: 24px; color: #f5a623; letter-spacing: 2px; }
      .shelter-review-meta .images-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
      .shelter-review-meta .image-item { position: relative; }
      .shelter-review-meta .image-item img {
          width: 150px;
          height: 150px;
          object-fit: cover;
          border-radius: 8px;
          border: 2px solid #ddd;
          cursor: pointer;
          transition: border-color 0.2s;
      }
      .shelter-review-meta .image-item img:hover { border-color: #2271b1; }
      .shelter-review-meta .image-item a { text-decoration: none; }
      .shelter-review-meta .image-url {
          display: block;
          font-size: 11px;
          color: #666;
          max-width: 150px;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
          margin-top: 5px;
      }
      .shelter-review-meta .no-images { color: #666; font-style: italic; }
      .shelter-review-meta .rating-select { margin-top: 5px; }
  </style>

  <div class="shelter-review-meta">
    <!-- Rating -->
    <div style="margin-bottom: 20px;">
      <label>⭐ Оцінка</label>
      <?php if ($rating) : ?>
        <div class="rating-display">
          <?php echo str_repeat('★', $rating) . str_repeat('☆', 5 - $rating); ?>
          <span style="font-size: 14px; color: #333;">(<?php echo $rating; ?>/5)</span>
        </div>
      <?php else : ?>
        <p class="no-images">Оцінка не вказана</p>
      <?php endif; ?>

      <!-- Edit rating -->
      <div class="rating-select">
        <label for="shelter_rating">Змінити оцінку:</label>
        <select name="shelter_rating" id="shelter_rating">
          <option value="">— Без змін —</option>
          <?php for ($i = 1; $i <= 5; $i++) : ?>
            <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>>
              <?php echo $i; ?> <?php echo str_repeat('★', $i); ?>
            </option>
          <?php endfor; ?>
        </select>
      </div>
    </div>

    <!-- Images -->
    <div>
      <label>📷 Фото відгуку (<?php echo !empty($images) ? count($images) : 0; ?>)</label>

      <?php if (!empty($images) && is_array($images)) : ?>
        <div class="images-grid">
          <?php foreach ($images as $index => $image_url) : ?>
            <div class="image-item">
              <a href="<?php echo esc_url($image_url); ?>" target="_blank" title="Відкрити в новій вкладці">
                <img src="<?php echo esc_url($image_url); ?>" alt="Фото <?php echo $index + 1; ?>">
              </a>
              <span class="image-url"><?php echo esc_html(basename($image_url)); ?></span>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Image URLs for reference -->
        <details style="margin-top: 15px;">
          <summary style="cursor: pointer; color: #2271b1;">Показати URL фото</summary>
          <ul style="margin-top: 10px; font-size: 12px;">
            <?php foreach ($images as $image_url) : ?>
              <li>
                <a href="<?php echo esc_url($image_url); ?>" target="_blank">
                  <?php echo esc_html($image_url); ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </details>
      <?php else : ?>
        <p class="no-images">Фото не завантажено</p>
      <?php endif; ?>
    </div>
  </div>
  <?php
}

/**
 * Save rating when comment is edited
 */
add_action('edit_comment', 'shelter_save_comment_meta');
function shelter_save_comment_meta($comment_id) {
  if (!isset($_POST['shelter_review_meta_nonce']) ||
      !wp_verify_nonce($_POST['shelter_review_meta_nonce'], 'shelter_review_meta')) {
    return;
  }

  if (isset($_POST['shelter_rating']) && !empty($_POST['shelter_rating'])) {
    $rating = absint($_POST['shelter_rating']);
    $rating = max(1, min(5, $rating));
    update_comment_meta($comment_id, 'rating', $rating);
  }
}

/**
 * Show images below comment text in comments list
 */
add_filter('comment_text', 'shelter_append_images_to_comment', 10, 2);
function shelter_append_images_to_comment($comment_text, $comment = null) {
  // Only in admin
  if (!is_admin() || !$comment) {
    return $comment_text;
  }

  $images = get_comment_meta($comment->comment_ID, 'images', true);
  $rating = get_comment_meta($comment->comment_ID, 'rating', true);

  $extra = '';

  // Add rating
  if ($rating) {
    $stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
    $extra .= '<div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">';
    $extra .= '<strong style="color: #f5a623;">' . $stars . '</strong> ';
    $extra .= '<small>(' . $rating . '/5)</small>';
    $extra .= '</div>';
  }

  // Add images
  if (!empty($images) && is_array($images)) {
    $extra .= '<div style="margin-top: 10px; display: flex; gap: 5px; flex-wrap: wrap;">';
    foreach ($images as $image_url) {
      $extra .= '<a href="' . esc_url($image_url) . '" target="_blank">';
      $extra .= '<img src="' . esc_url($image_url) . '" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">';
      $extra .= '</a>';
    }
    $extra .= '</div>';
  }

  return $comment_text . $extra;
}

/**
 * Add CSS to admin
 */
add_action('admin_head', 'shelter_comments_admin_css');
function shelter_comments_admin_css() {
  $screen = get_current_screen();

  if ($screen && ($screen->id === 'edit-comments' || $screen->id === 'comment')) {
    ?>
    <style>
        .column-review_rating { width: 100px; }
        .column-review_images { width: 180px; }

        /* Make images column not wrap */
        .column-review_images img {
            vertical-align: middle;
        }
    </style>
    <?php
  }
}

/**
 * Make columns sortable (optional)
 */
add_filter('manage_edit-comments_sortable_columns', 'shelter_comments_sortable_columns');
function shelter_comments_sortable_columns($columns) {
  $columns['review_rating'] = 'review_rating';
  return $columns;
}