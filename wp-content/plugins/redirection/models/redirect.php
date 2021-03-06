<?php

class Red_Item {
	private $id          = null;
	private $url         = null;
	private $regex       = false;
	private $action_data = null;
	private $action_code = 0;
	private $action_type;
	private $match_type;
	private $title;
	private $last_access = null;
	private $last_count  = 0;
	private $status;
	private $position;
	private $group_id;

	function __construct( $values, $type = '', $match = '' ) {
		if ( is_object( $values ) ) {
			$this->load_from_data( $values );

			if ( $this->last_access === '0000-00-00 00:00:00' ) {
				$this->last_access = 0;
			} else {
				$this->last_access = mysql2date( 'U', $this->last_access );
			}
		}
	}

	private function load_from_data( stdClass $values ) {
		foreach ( $values as $key => $value ) {
			$this->$key = $value;
		}

		if ( $this->match_type === '' ) {
			$this->match_type = 'url';
		}

		$this->regex = (bool)$this->regex;
		$this->match              = Red_Match::create( $this->match_type, $this->action_data );
		$this->match->id          = $this->id;
		$this->match->action_code = $this->action_code;

		$action = false;

		if ( $this->action_type ) {
			$action = Red_Action::create( $this->action_type, $this->action_code );
		}

		if ( $action ) {
			$this->action = $action;
			$this->match->action = $this->action;
		}
		else {
			$this->action = Red_Action::create( 'nothing', 0 );
		}
	}

	static function get_all_for_module( $module ) {
		global $wpdb;

		$sql = $wpdb->prepare( "SELECT {$wpdb->prefix}redirection_items.* FROM {$wpdb->prefix}redirection_items
			INNER JOIN {$wpdb->prefix}redirection_groups ON {$wpdb->prefix}redirection_groups.id={$wpdb->prefix}redirection_items.group_id
			AND {$wpdb->prefix}redirection_groups.status='enabled' AND {$wpdb->prefix}redirection_groups.module_id=%d
			WHERE {$wpdb->prefix}redirection_items.status='enabled'
			ORDER BY {$wpdb->prefix}redirection_groups.position,{$wpdb->prefix}redirection_items.position", $module );

		$rows  = $wpdb->get_results( $sql );
		$items = array();

		foreach ( (array) $rows as $row ) {
			$items[] = new Red_Item( $row );
		}

		return $items;
	}

	static function get_for_url( $url ) {
		global $wpdb;

		$sql = $wpdb->prepare( "SELECT {$wpdb->prefix}redirection_items.*,{$wpdb->prefix}redirection_groups.position AS group_pos
			FROM {$wpdb->prefix}redirection_items INNER JOIN {$wpdb->prefix}redirection_groups ON
			{$wpdb->prefix}redirection_groups.id={$wpdb->prefix}redirection_items.group_id AND {$wpdb->prefix}redirection_groups.status='enabled'
			AND {$wpdb->prefix}redirection_groups.module_id=%d WHERE ({$wpdb->prefix}redirection_items.regex=1
			OR {$wpdb->prefix}redirection_items.url=%s)", WordPress_Module::MODULE_ID, $url );

		$rows = $wpdb->get_results( $sql );
		$items = array();
		if ( count( $rows ) > 0 ) {
			foreach ( $rows as $row ) {
				$items[] = array( 'position' => ( $row->group_pos * 1000 ) + $row->position, 'item' => new Red_Item( $row ) );
			}
		}

		usort( $items, array( 'Red_Item', 'sort_urls' ) );
		$items = array_map( array( 'Red_Item', 'reduce_sorted_items' ), $items );

		// Sort it in PHP
		ksort( $items );
		$items = array_values( $items );
		return $items;
	}

	static function get_all() {
		global $wpdb;

		$rows = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}redirection_items" );
		$items = array();

		foreach ( (array) $rows as $row ) {
			$items[] = new Red_Item( $row );
		}

		return $items;
	}

	static function sort_urls( $first, $second ) {
		if ( $first['position'] === $second['position'] ) {
			return 0;
		}

		return ($first['position'] < $second['position']) ? -1 : 1;
	}

	static function reduce_sorted_items( $item ) {
		return $item['item'];
	}

	static function get_by_id( $id ) {
		global $wpdb;

		$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}redirection_items WHERE id=%d", $id ) );
		if ( $row )
			return new Red_Item( $row );
		return false;
	}

	public static function disable_where_matches( $url ) {
		global $wpdb;

		$wpdb->update( $wpdb->prefix.'redirection_items', array( 'status' => 'disabled' ), array( 'url' => $url ) );
	}

	public function delete() {
		global $wpdb;

		$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}redirection_items WHERE id=%d", $this->id ) );

		Red_Module::flush( $this->group_id );
	}

	static function create( array $details ) {
		global $wpdb;

		$sanitizer = new Red_Item_Sanitize();
		$data = $sanitizer->get( $details );
		if ( is_wp_error( $data ) ) {
			return $data;
		}

		$data['status'] = 'enabled';
		$data['position'] = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}redirection_items WHERE group_id=%d", $data['group_id'] ) );
		$data = apply_filters( 'redirection_create_redirect', $data );

		// Create
		if ( $wpdb->insert( $wpdb->prefix.'redirection_items', $data ) ) {
			Red_Module::flush( $data['group_id'] );
			return self::get_by_id( $wpdb->insert_id );
		}

		return new WP_Error( 'redirect', __( 'Unable to add new redirect' ) );
	}

	public function update( $details ) {
		global $wpdb;

		$sanitizer = new Red_Item_Sanitize();
		$data = $sanitizer->get( $details );

		if ( is_wp_error( $data ) ) {
			return $data;
		}

		$old_group = false;
		if ( $data['group_id'] !== $this->group_id ) {
			$old_group = $this->group_id;
		}

		// Save this
		$wpdb->update( $wpdb->prefix.'redirection_items', $data, array( 'id' => $this->id ) );

		$this->load_from_data( (object) $data );

		Red_Module::flush( $this->group_id );

		if ( $old_group !== $this->group_id ) {
			Red_Module::flush( $old_group );
		}

		return true;
	}

	public function matches( $url ) {
		$this->url = str_replace( ' ', '%20', $this->url );
		$matches   = false;

		// Check if we match the URL
		if ( ( $this->regex === false && ( $this->url === $url || $this->url === rtrim( $url, '/' ) || $this->url === urldecode( $url ) ) ) || ( $this->regex === true && @preg_match( '@'.str_replace( '@', '\\@', $this->url ).'@', $url, $matches ) > 0) || ( $this->regex === true && @preg_match( '@'.str_replace( '@', '\\@', $this->url ).'@', urldecode( $url ), $matches ) > 0) ) {
			// Check if our match wants this URL
			$target = $this->match->get_target( $url, $this->url, $this->regex );
			$target = apply_filters( 'redirection_url_target', $target, $this->url );

			if ( $target && $this->is_enabled() ) {
				$this->visit( $url, $target );
				return $this->action->process_before( $this->action_code, $target );
			}
		}

		return false;
	}

	public function visit( $url, $target ) {
		global $wpdb;

		$options = red_get_options();

		// Update the counters
		$this->last_count++;
		$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}redirection_items SET last_count=last_count+1, last_access=NOW() WHERE id=%d", $this->id ) );

		if ( isset( $options['expire_redirect'] ) && $options['expire_redirect'] > 0 ) {
			$log = RE_Log::create( $url, $target, Redirection_Request::get_user_agent(), Redirection_Request::get_ip(), Redirection_Request::get_referrer(), array( 'redirect_id' => $this->id, 'group_id' => $this->group_id ) );
		}
	}

	public function is_enabled() {
		return $this->status === 'enabled';
	}

	public function reset() {
		global $wpdb;

		$this->last_count  = 0;
		$this->last_access = '0000-00-00 00:00:00';

		$wpdb->update( $wpdb->prefix.'redirection_items', array( 'last_count' => 0, 'last_access' => $this->last_access ), array( 'id' => $this->id ) );
	}

	public function enable() {
		global $wpdb;

		$this->status = 'enabled';
		$wpdb->update( $wpdb->prefix.'redirection_items', array( 'status' => $this->status ), array( 'id' => $this->id ) );
	}

	public function disable() {
		global $wpdb;

		$this->status = 'disabled';
		$wpdb->update( $wpdb->prefix.'redirection_items', array( 'status' => $this->status ), array( 'id' => $this->id ) );
	}

	public function get_id() {
		return intval( $this->id, 10 );
	}

	public function get_position() {
		return intval( $this->position, 10 );
	}

	public function get_group_id() {
		return intval( $this->group_id, 10 );
	}

	public function get_url() {
		return $this->url;
	}

	public function get_title() {
		return $this->title ? $this->title : '';
	}

	public function get_hits() {
		return intval( $this->last_count, 10 );
	}

	public function get_last_hit() {
		return intval( $this->last_access, 10 );
	}

	public function is_regex() {
		return $this->regex ? true : false;
	}

	public function get_match_type() {
		return $this->match_type;
	}

	public function get_action_type() {
		return $this->action_type;
	}

	public function get_action_code() {
		return intval( $this->action_code, 10 );
	}

	public function get_action_data() {
		return $this->action_data ? $this->action_data : '';
	}

	public static function get_filtered( array $params ) {
		global $wpdb;

		$orderby = 'id';
		$direction = 'DESC';
		$limit = RED_DEFAULT_PER_PAGE;
		$offset = 0;
		$where = '';

		if ( isset( $params['orderBy'] ) && in_array( $params['orderBy'], array( 'url', 'last_count', 'last_access', 'position' ), true ) ) {
			$orderby = $params['orderBy'];
		}

		if ( isset( $params['direction'] ) && in_array( $params['direction'], array( 'asc', 'desc' ), true ) ) {
			$direction = strtoupper( $params['direction'] );
		}

		if ( isset( $params['filter'] ) && strlen( $params['filter'] ) > 0 ) {
			if ( isset( $params['filterBy'] ) && $params['filterBy'] === 'group' ) {
				$where = $wpdb->prepare( "WHERE group_id=%d", intval( $params['filter'], 10 ) );
			} else {
				$where = $wpdb->prepare( 'WHERE url LIKE %s', '%'.$wpdb->esc_like( trim( $params['filter'] ) ).'%' );
			}
		}

		if ( isset( $params['perPage'] ) ) {
			$limit = intval( $params['perPage'], 10 );
			$limit = min( 100, $limit );
			$limit = max( 5, $limit );
		}

		if ( isset( $params['page'] ) ) {
			$offset = intval( $params['page'], 10 );
			$offset = max( 0, $offset );
			$offset *= $limit;
		}

		$table = $wpdb->prefix.'redirection_items';
		$sql = trim( "SELECT * FROM {$table} $where " ).$wpdb->prepare( " ORDER BY $orderby $direction LIMIT %d,%d", $offset, $limit );

		$rows = $wpdb->get_results( $sql );
		$total_items = intval( $wpdb->get_var( "SELECT COUNT(*) FROM {$table} ".$where ) );
		$items = array();

		foreach ( $rows as $row ) {
			$group = new Red_Item( $row );
			$items[] = $group->to_json();
		}

		return array(
			'items' => $items,
			'total' => intval( $total_items, 10 ),
		);
	}

	public function to_json() {
		return array(
			'id' => $this->get_id(),
			'url' => $this->get_url(),
			'action_code' => $this->get_action_code(),
			'action_type' => $this->get_action_type(),
			'action_data' => maybe_unserialize( $this->get_action_data() ),
			'match_type' => $this->get_match_type(),
			'title' => $this->get_title(),
			'hits' => $this->get_hits(),
			'regex' => $this->is_regex(),
			'group_id' => $this->get_group_id(),
			'position' => $this->get_position(),
			'last_access' => $this->get_last_hit() > 0 ? date_i18n( get_option( 'date_format' ), $this->get_last_hit() ) : '-',
			'enabled' => $this->is_enabled(),
		);
	}
}

class Red_Item_Sanitize {
	public function get( array $details ) {
		$data = array();

		$details = array_map( 'trim', $details );
		$details = array_map( 'stripslashes', $details );

		$data['regex'] = isset( $details['regex'] ) && ( $details['regex'] === 'true' || $details['regex'] === '1' ) ? 1 : 0;
		$data['title'] = isset( $details['title'] ) ? $details['title'] : null;
		$data['url'] = $this->get_url( empty( $details['url'] ) ? $this->auto_generate() : $details['url'], $data['regex'] );
		$data['group_id'] = $this->get_group( isset( $details['group_id'] ) ? $details['group_id'] : 0 );
		$data['position'] = $this->get_position( $details );

		$matcher = Red_Match::create( isset( $details['match_type'] ) ? $details['match_type'] : false );
		if ( ! $matcher ) {
			return new WP_Error( 'redirect', __( 'Invalid redirect matcher', 'redirection' ) );
		}

		$action_code = isset( $details['action_code'] ) ? intval( $details['action_code'], 10 ) : 0;
		$action = Red_Action::create( isset( $details['action_type'] ) ? $details['action_type'] : false, $action_code );
		if ( ! $action ) {
			return new WP_Error( 'redirect', __( 'Invalid redirect action', 'redirection' ) );
		}

		$data['action_type'] = $details['action_type'];
		$data['action_code'] = $this->get_code( $details['action_type'], $action_code );
		$data['match_type'] = $details['match_type'];

		$match_data = $matcher->save( $details, ! $this->is_url_type( $data['action_type'] ) );

		$data['action_data'] = is_array( $match_data ) ? serialize( $match_data ) : $match_data;

		// Any errors?
		foreach ( $data as $value ) {
			if ( is_wp_error( $value ) ) {
				return $value;
			}
		}

		return apply_filters( 'redirection_validate_redirect', $data );
	}

	protected function get_position( $details ) {
		if ( isset( $details['position'] ) ) {
			return max( 0, intval( $details['position'], 10 ) );
		}

		return 0;
	}

	protected function is_url_type( $type ) {
		if ( $type === 'url' || $type === 'pass' ) {
			return true;
		}

		return false;
	}

	protected function get_code( $action_type, $code ) {
		if ( $action_type === 'url' || $action_type === 'random' ) {
			if ( in_array( $code, array( 301, 302, 307, 308 ), true ) ) {
				return $code;
			}
		}

		if ( $action_type === 'error' ) {
			if ( in_array( $code, array( 401, 404, 410 ), true ) ) {
				return $code;
			}
		}

		return 0;
	}

	protected function get_group( $group_id ) {
		$group_id = intval( $group_id, 10 );

		if ( ! Red_Group::get( $group_id ) ) {
			return new WP_Error( 'redirect', __( 'Invalid group when creating redirect', 'redirection' ) );
		}

		return $group_id;
	}

	protected function get_url( $url, $regex ) {
		$url = self::sanitize_url( $url, $regex );

		if ( $url === '' ) {
			return new WP_Error( 'redirect', __( 'Invalid source URL', 'redirection' ) );
		}

		return $url;
	}

	protected function auto_generate() {
		$options = red_get_options();
		$url = '';

		if ( isset( $options['auto_target'] ) && $options['auto_target'] ) {
			$id = time();
			$url = str_replace( '$dec$', $id, $options['auto_target'] );
			$url = str_replace( '$hex$', sprintf( '%x', $id ), $url );
		}

		return $url;
	}

	public function sanitize_url( $url, $regex = false ) {
		// Make sure that the old URL is relative
		$url = preg_replace( '@^https?://(.*?)/@', '/', $url );
		$url = preg_replace( '@^https?://(.*?)$@', '/', $url );

		// No hash
		$url = preg_replace( '/#.*$/', '', $url );

		// No new lines
		$url = preg_replace( "/[\r\n\t].*?$/s", '', $url );

		// Clean control codes
		$url = preg_replace( '/[^\PC\s]/u', '', $url );

		// Ensure a slash at start
		if ( substr( $url, 0, 1 ) !== '/' && $regex === false ) {
			$url = '/'.$url;
		}

		return $url;
	}
}
