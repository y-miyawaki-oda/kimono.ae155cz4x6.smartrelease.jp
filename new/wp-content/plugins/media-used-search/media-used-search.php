<?php


class Media_Used_Search {
	protected static $instance = null;

	protected $post_all_types = array();
	protected $post_all_metas = array();
	protected $omit_border = 0;

	//	無視ポストタイプリスト
	protected $post_type_ignore_list = array( 
//			'post',
//			'page',
			'attachment',
			'revision',
//			'nav_menu',
//			'nav_menu_item',
		);
	//	優先メタネームリスト
	protected $post_meta_precedence_name_list = array( 
			'thumbnail',
			'image',
			'img',
			'photo',
		);
	/**
	 *コンストラクタ
	 */
	function __construct() {
		/* 有効にした時に引数で指定したファンクションを実行 */
        if (function_exists('register_activation_hook')) {
            register_activation_hook(MUS_PLUGIN_FULL_PATH, array( $this, 'activation_init'));
        }
        /* 停止した時に引数で指定したファンクションを実行 */
        if (function_exists('register_deactivation_hook')) {
            register_deactivation_hook(MUS_PLUGIN_FULL_PATH, array( $this, 'deactivation_delete'));
        }
		
		$this->set_post_types();
		$this->set_post_metas();
		$this->set_omit_border();
        add_action('plugins_loaded', array($this, 'mus_load_translation'));
		add_filter('plugin_action_links', array( $this, 'mus_add_settings_link'), 10, 2);

		add_filter( 'pre_get_posts' , array( $this, 'mus_pre_get_posts' ) );
		add_filter( 'manage_media_columns', array( $this, 'add_used_posts_column' ) );
		add_action( 'manage_media_custom_column', array( $this, 'set_used_posts' ), 10, 2 );

		// 管理画面を作成する
		add_action('admin_menu', array($this, 'admin_menu'));
		add_action('admin_init', array($this, 'admin_init'));
		
	}

	/**
	 * 
	 */
    function mus_load_translation() {
		load_plugin_textdomain('media-used-search', '', dirname( plugin_basename( MUS_PLUGIN_FULL_PATH ) ) .'/languages');

		// Here once described for the corresponding in po edit
		__('If you are using a custom field associated with the post to image, to view the post that you are using the media list. Further images can be searched for that post by applying a search posts titles are used.', 'media-used-search') ;
    }

	/**
	 * プラグイン画面に設定へのリンクを追加
	 * 
	 * @param type $links
	 * @param type $file
	 * @return type $links
	 */
	function mus_add_settings_link( $links, $file ) {
		if( $file == 'media-used-search/bootstrap.php' && function_exists( "admin_url" ) ) {
			$settings_link = '<a href="' . admin_url( 'options-general.php?page=mus_admin' ) . '">' . __('Settings', 'media-used-search') . '</a>';
			array_unshift( $links, $settings_link );
		}
		return $links;
	}

	/**
	 * wp_optionsに保存したデータのoptions_nameを取得
	 * 
	 * @param type $base_option_label
	 * @param type $base_option_name
	 * @return string
	 */
	public function get_option_name( $base_option_label, $base_option_name ){
		$ret_option_name = get_option($base_option_label);
		if( !$ret_option_name ) {
			$ret_option_name = $this->set_option_label( $base_option_label, $base_option_name );
		}
		
		return $ret_option_name;
	}

	/**
	 * wp_optionsにデータを保存するoptions_nameを保存して返す
	 * 
	 * @param type $set_option_label
	 * @param type $base_option_name
	 * @return string 
	 */
	public function set_option_label( $set_option_label, $base_option_name ){
		$ret_option_name = $base_option_name;

		$count = 1;
		while( 1 ){
			if( !get_option( $ret_option_name ) ){
				break;
			}
			$ret_option_name .= $count;
			$count++;
		}
		update_option($set_option_label, $ret_option_name);

		return $ret_option_name;
	}
	
	/**
	 * プラグイン有効時に必要なオプションデータを生成
	 */
	public function activation_init() {
		//	ターゲットポストタイプ群のオプションデータの保存
		update_option( $this->get_option_name( MUS_OPT_NAME_POST_TYPES_LABEL, MUS_OPT_NAME_POST_TYPES ), 'post');

		$eyecatch_word = __('Featured Images');
		//	ターゲットポストメタ群のオプションデータの保存
		update_option( $this->get_option_name( MUS_OPT_NAME_POST_METAS_LABEL, MUS_OPT_NAME_POST_METAS ), sprintf( 'post:_thumbnail_id:%s', $eyecatch_word ));

		//	省略文字数のオプションデータの保存
		update_option( $this->get_option_name( MUS_OPT_NAME_OMIT_NUM_LABEL, MUS_OPT_NAME_OMIT_NUM ), '0' );
	}
	
	/**
	 * プラグイン停止・アンインストール時に生成したオプションデータを削除
	 */
	public function deactivation_delete() {
		delete_option( $this->get_option_name( MUS_OPT_NAME_POST_TYPES_LABEL, MUS_OPT_NAME_POST_TYPES ) );
		delete_option( MUS_OPT_NAME_POST_TYPES_LABEL );
		delete_option( $this->get_option_name( MUS_OPT_NAME_POST_METAS_LABEL, MUS_OPT_NAME_POST_METAS ) );
		delete_option( MUS_OPT_NAME_POST_METAS_LABEL );
		delete_option( $this->get_option_name( MUS_OPT_NAME_OMIT_NUM_LABEL, MUS_OPT_NAME_OMIT_NUM ) );
		delete_option( MUS_OPT_NAME_OMIT_NUM_LABEL );
	}

	/**
	 * 管理画面初期化
	 * ここでオプションへの保存を行う
	 */
	public function admin_init(){
		if(isset($_REQUEST['_mussavenonce'], $_REQUEST['title_omit_border']) && wp_verify_nonce($_REQUEST['_mussavenonce'], 'mus_save')){
			
			update_option( $this->get_option_name( MUS_OPT_NAME_POST_TYPES_LABEL, MUS_OPT_NAME_POST_TYPES ), implode(',', $_REQUEST['select_posts']) );

			$set_cast_option = $this->set_meta_cast_option($_REQUEST['select_metas'], $_REQUEST['select_meta_label']);
			update_option( $this->get_option_name( MUS_OPT_NAME_POST_METAS_LABEL, MUS_OPT_NAME_POST_METAS ), $set_cast_option );

			$omit = (int)$_REQUEST['title_omit_border'];
			if( $omit < 0 ) $omit = 0;
			update_option( $this->get_option_name( MUS_OPT_NAME_OMIT_NUM_LABEL, MUS_OPT_NAME_OMIT_NUM ), $omit );
			header("Location: ".admin_url('admin.php?page=mus_admin'));
			exit;
		}
	}
	
	/**
	 * メタ情報をオプションへ保存するために形成する
	 * @param type $meta_keys
	 * @param type $meta_label
	 * @return type
	 */
	private function set_meta_cast_option( $meta_keys, $meta_label ) {
		$ret_set_cast_option = '';
		for( $i=0; $i < count($meta_keys); $i++ ){
			if( $i ) $ret_set_cast_option .= ',';
			$ret_set_cast_option .= sprintf('%s:%s', $meta_keys[$i], $meta_label[$i]);
		}
		return $ret_set_cast_option;
	}

	/**
	 * メタ情報オプションデータを内部で使用する形に形成
	 * @param type $cast_meta
	 * @return type
	 */
	private function set_meta_cast( $cast_meta ) {
		$ret_set_cast_list = array();
		$exp_cast = explode(',', $cast_meta);
		foreach( $exp_cast as $cast ){
			$exp_meta = explode(':', $cast);
			$type = !empty($exp_meta[0]) ? $exp_meta[0] : '';
			$key = !empty($exp_meta[1]) ? $exp_meta[1] : '';
			$label = !empty($exp_meta[2]) ? $exp_meta[2] : '';
			$ret_set_cast_list[$type][$key] = $label;
		}
		return $ret_set_cast_list;
	}

	/**
	 * 各種管理画面用設定
	 */
	public function admin_menu(){
        wp_enqueue_style('mus_admin', plugin_dir_url(__FILE__) . 'css/admin.css', array(), false, 'screen');
        wp_enqueue_script('mus_admin_js', plugin_dir_url( __FILE__ ).'js/media_used_search.min.js', array('jquery'));

		$hook_name = add_options_page('Media Used Search', 'Media Used Search', 'manage_options', 'mus_admin', array($this, 'show_admin'));
	}
	/**
	 * 管理画面を表示する
	 */
	public function show_admin(){
		require dirname(__FILE__).'/admin.php';
	}

	/**
	 * インスタンス取得
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * クエリ事前操作
	 * 検索SQL文に指定メディアを使用中の記事タイトルも引っ張ってくるようにする
	 * 
	 * @param type $wp_query
	 */
	public function mus_pre_get_posts( &$wp_query ) {
		global $pagenow;
		if ( $wp_query->is_main_query() && is_admin() && ( 'upload.php' == $pagenow || 'media-upload.php' == $pagenow ) && isset( $_GET['s'] ) && !empty( $_GET['s'] ) ) {
			// フィルターをかける
			add_filter('posts_where', array( $this, 'mus_posts_where') );
		}
	}

    /**
     * _fpv_preget_posts関数でSQLクエリ操作のWHERE句を変更する実動作部分
     * 
     * @global type $wpdb
     * @param string $where 現在のWHERE句
     * @return string 変更後のWHERE句
     */
    function mus_posts_where($where){
        global $wpdb, $wp_query;
		$post_types = $this->get_selected_post_types();
		$post_metas = $this->set_meta_cast( $this->get_option_post_metas() );
		$pm_list = array();
		foreach( $post_types as $pt ){
			if( !empty( $post_metas[$pt] ) ) {
				foreach( $post_metas[$pt] as $pm=>$label ){
					$pm_list[$pt][] = $pm;
				}
			}
		}
		// SQL to search
		//	複数検索のOR文生成
		$search_terms = !empty($wp_query->query_vars['search_terms']) ? $wp_query->query_vars['search_terms'] : array() ;
		$set_search_sql = '';
		foreach( $search_terms as $key => $search_word ){
			if( $key !== 0 ) $set_search_sql .= 'AND ';
			$set_search_sql .= sprintf( 'p2.post_title LIKE "%%%s%%" ', mysql_real_escape_string($search_word) );
		}

		$base_where = <<<EOS
				 {$where} OR
					( {$wpdb->posts}.ID IN(
						SELECT pm.meta_value FROM {$wpdb->postmeta} AS pm 
						INNER JOIN {$wpdb->posts} AS p2 ON pm.post_id = p2.ID 
						WHERE {$set_search_sql} AND ( 
EOS;
				foreach( $post_types as $pk=>$post_type ) {
					if( empty($pm_list[$post_type]) ) continue;
					$set_conjunction = $pk !== 0 ? 'OR' : null ;
		$base_where .= <<<EOS
						{$set_conjunction} ( 
							p2.post_type IN( "{$post_type}" ) 
							AND pm.meta_key IN( 
EOS;
								foreach( $pm_list[$post_type] as $mk=>$post_meta ){
									$set_delimiter = $mk !== 0 ? ',' : null ;
		$base_where .= <<<EOS
								{$set_delimiter} "{$post_meta}"
EOS;
								}
		$base_where .= <<<EOS
								)
							)
EOS;
					}
		$base_where .= <<<EOS
					))
				)
			 AND {$wpdb->posts}.post_type = "attachment" 
EOS;
        remove_filter( 'posts_where', array( $this, 'mus_posts_where') );
        return $base_where;
    }

	/**
	 * 
	 * @param type $column
	 * @param type $post_id
	 */
	public function add_used_posts_column($column){
		$column['used_posts'] = __('Use article name (label text or custom field name)', 'media-used-search');
		return $column;
	}

	/**
	 * 
	 * @param type $column_name
	 * @param type $id
	 */
	public function set_used_posts( $column_name, $id ) {
		if ( $column_name == 'used_posts' ) {
			$post_meta_list = $this->get_post_meta_list();

			$display_used_post_list = array();
			$count = 0;
			foreach( $post_meta_list as $meta_info ){
				if( !empty($meta_info['key']) ) {
					$used_posts = $this->get_used_posts( $id, $meta_info['key'], $meta_info['type'] );
					$label = !empty($meta_info['label']) ? $meta_info['label'] : $meta_info['key'] ;
					$label = esc_html($label);
					foreach( $used_posts as $post ){
						$set_title = esc_html($post->post_title);
						if( $this->omit_border ) {
							$set_title = mb_strimwidth( $set_title, 0, $this->omit_border*2, '...', 'UTF-8' );
						}
						if( !$set_title ) $set_title = '_';
						$display_used_post_list[$post->ID]['title'] = $set_title ;
						$display_used_post_list[$post->ID]['label'] = empty($display_used_post_list[$post->ID]['label']) ? $label : $display_used_post_list[$post->ID]['label'] . ', ' . $label ;
						$count++;
					}
				}
			}
			foreach( $display_used_post_list as $post_id => $info ){
				$labels = isset($info['label']) ? '( '. $info['label']. ' )' : '' ;
				echo sprintf( '・<a href='. get_edit_post_link($post_id, true). ' >%s</a>%s<br />', $info['title'], $labels );
			}
			
			if( $count === 0 ) {
				_e('Not used', 'media-used-search');
			}
		}
	}

	/**
	 * 
	 * @param type $image_id
	 * @param type $image_meta
	 * @return null
	 */
	private function get_used_posts( $image_id = null, $image_meta, $post_types ) {
		$post_per_page = -1;
		$used_posts = get_posts( array(
			'post_status' => 'any',
			'posts_per_page' => $post_per_page,
			'orderby' => 'date',
			'post_type' => $post_types,
			'order' => 'ASC',
			'meta_query' => array(
				array( 
					'key' => $image_meta,
					'value' => $image_id,
				),
			),
		));
		return $used_posts;
	}

	/**
	 * 選択したポストタイプを取得
	 * @return type
	 */
	public function get_selected_post_types(){
		$ret_selected_post_types = array();

		$option_post_types = $this->get_option_post_types();
		if( $option_post_types ) {
			$ret_selected_post_types = explode(',', $option_post_types);
		}
		return $ret_selected_post_types;
	}
	
	/**
	 * 選択したポストメタを取得
	 * @return array
	 */
	public function get_post_meta_list(){
		$ret_selected_post_metas = array();

		$option_post_metas = $this->get_option_post_metas();
		if( $option_post_metas ) {
			$exp_metas = explode(',', $option_post_metas);
			foreach( $exp_metas as $meta ) {
				$exp_meta_info = explode(':', $meta);
				$type = !empty($exp_meta_info[0]) ? $exp_meta_info[0] : '' ;
				$key = !empty($exp_meta_info[1]) ? $exp_meta_info[1] : '' ;
				$label = !empty($exp_meta_info[2]) ? $exp_meta_info[2] : '' ;
				$ret_selected_post_metas[] = array( 'type'=>$type, 'key'=>$key, 'label'=>$label );
			}
		}

		return $ret_selected_post_metas;
	}

	/**
	 * 文字省略規定数のセット
	 */
	private function set_omit_border(){
		$this->omit_border = $this->get_omit_border();
	}
	/**
	 * 記事に存在するポストタイプをセットする
	 * @return string
	 */
	private function set_post_types(){
		global $wpdb;
		//	現在使われているポストタイプで件数が多い物から順に取得
		$post_types = $wpdb->get_results(
			"SELECT `post_type`, COUNT(`post_type`) AS `cnt_pt` FROM `$wpdb->posts` GROUP BY post_type ORDER BY `cnt_pt` DESC"
		);

		$set_post_types = array( );
		$set_after_inserts = array();
		foreach( $post_types as $type ){
			//	無視リストに入ってるものは除く
			if( in_array( $type->post_type, $this->post_type_ignore_list )) {
				continue;
			}
			$set_post_types[] = $type->post_type;
		}
		
		$this->post_all_types = $set_post_types;
	}
	/**
	 * 各ポストタイプで使用しているポストメタをセットする
	 * @return string
	 */
	private function set_post_metas(){
		global $wpdb;

		if( !$this->post_all_types ) $this->set_post_types();

		$post_used_metas = array();
		foreach( $this->post_all_types as $pt ){
			$post_id_list = $wpdb->get_results(
				"SELECT `ID` FROM `$wpdb->posts` WHERE `post_type` = '$pt' ORDER BY `ID`"
			);
			$pids = array();
			foreach( $post_id_list as $pid ){
				$pids[] = $pid->ID;
			}
			$post_metas = '';
			if( $pids ) {
				$post_metas = $wpdb->get_results(
					"SELECT DISTINCT(`meta_key`) FROM `$wpdb->postmeta` WHERE `post_id` IN(". implode(',', $pids) .")"
				);
			}
			$post_used_metas[$pt] = $post_metas;
		}
		//	メタネームによって表示順に優先性を与える
		$changed_metas = array();
		foreach( $post_used_metas as $post_type => $metas ){
			$meta_change_line = array();
			foreach( $metas as $meta ){
				$meta_change_line[] = $meta;
			}
			foreach( array_reverse($this->post_meta_precedence_name_list) as $precedence_word ){
				foreach( $meta_change_line as $key=>$line ) {
					if( strpos($line->meta_key, $precedence_word) !== false ) {
						array_splice($meta_change_line, $key, 1);
						array_unshift($meta_change_line, $line);
					}
				}
			}
			$changed_metas[$post_type] = $meta_change_line;
		}
		
		$this->post_all_metas = $changed_metas;
	}

	/**
	 * 設定ポストタイプのオプション保存内容を取得
	 * @return type
	 */
	public function get_option_post_types(){
		return get_option( $this->get_option_name( MUS_OPT_NAME_POST_TYPES_LABEL, MUS_OPT_NAME_POST_TYPES ));
	}
	/**
	 * 設定ポストメタのオプション保存内容を取得
	 * @return type
	 */
	public function get_option_post_metas(){
		return get_option( $this->get_option_name( MUS_OPT_NAME_POST_METAS_LABEL, MUS_OPT_NAME_POST_METAS ));
	}
	/**
	 * 省略文字数のオプション保存内容を取得
	 * @return type
	 */
	public function get_omit_border(){
		return get_option( $this->get_option_name( MUS_OPT_NAME_OMIT_NUM_LABEL, MUS_OPT_NAME_OMIT_NUM ));
	}

	/**
	 * 全ポストタイプの状態を取得
	 * @return type
	 */
	public function get_post_types_info(){
		$ret_selected_post_types = array();

		$exp_post_types = $this->get_selected_post_types();
		foreach( $this->post_all_types as $post_type ){
			$ret_selected_post_types[] = array( 
				'type' => $post_type,
				'checked' => in_array($post_type, $exp_post_types),
			);
		}
		return $ret_selected_post_types;
	}
	
	/**
	 * 全ポストメタの状態を取得
	 * @return type
	 */
	public function get_post_metas_info(){
		$ret_all_post_metas = array();

		$seted_post_metas = $this->set_meta_cast( $this->get_option_post_metas() );
		foreach( $this->post_all_metas as $post_type => $post_metas ){
			$selected_post_metas = $rest_post_metas = array();
			foreach( $post_metas as $meta ){
				$label = !empty($seted_post_metas[$post_type][$meta->meta_key]) ? $seted_post_metas[$post_type][$meta->meta_key] : NULL;
				$is_checked = isset($seted_post_metas[$post_type][$meta->meta_key]) ? true : false;
				if( $is_checked ) {
					$selected_post_metas[] = array( 
						'type' => $post_type,
						'meta' => $meta->meta_key,
						'label' => $label,
						'checked' => $is_checked ? true : false,
					);
				}
				else {
					$rest_post_metas[] = array( 
						'type' => $post_type,
						'meta' => $meta->meta_key,
						'label' => $label,
						'checked' => $is_checked ? true : false,
					);
				}
			}
			foreach( $selected_post_metas as $selected_meta )
				$ret_all_post_metas[] = $selected_meta;
			foreach( $rest_post_metas as $rest_meta )
				$ret_all_post_metas[] = $rest_meta;
		}
		return $ret_all_post_metas;
	}
}
	