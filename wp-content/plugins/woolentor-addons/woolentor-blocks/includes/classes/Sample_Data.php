<?php
namespace WooLentorBlocks;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load general WP action hook
 */
class Sample_Data {

    private $cache_data = [];

	/**
     * [$_instance]
     * @var null
     */
    private static $_instance = null;

    /**
     * [instance] Initializes a singleton instance
     * @return [Sample_Data]
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * [generate_hash_key] Generate hash key
     */
    private function generate_hash_key( $string ) {
        $string = str_replace( '/','woolentor', $string );
		return $string . md5( $string );
	}

    /**
     * Load Dynamic blocks
     */
    public static function remote_request( $force_update, $route_url ){
        global $wp_version;

        $request_url = get_rest_url( null, 'woolentor/v1/'.$route_url );

        $timeout = ( $force_update ) ? 25 : 8;
        $request = wp_remote_get(
            $request_url,
            [
                'timeout'    => $timeout,
                'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url(),
            ]
        );

        if ( is_wp_error( $request ) || 200 !== (int) wp_remote_retrieve_response_code( $request ) ) {
            return [];
        }

        $response = json_decode( wp_remote_retrieve_body( $request ), true );
        return $response;
    }

    /**
     * Retrieve template library and save as a transient.
     */
    public static function set_request_data( $force_update = false, $route_url = '' ) {
        $info = [];
        if ( $force_update && !empty( $route_url ) ) {
            $info = self::remote_request( $force_update, $route_url );
        }
        return $info;
    }

    /**
     * Get template info.
     */
    public function get_sample_data( $force_update = false, $route_url = '' ) {

        $transient_key = $this->generate_hash_key( $route_url );
        // delete_transient( $transient_key );

        $transient = get_transient( $transient_key );
        if ( ! $transient || $force_update ) {
            $data = self::set_request_data( true, $route_url );
            set_transient( $transient_key, $data, DAY_IN_SECONDS );
        }
        return get_transient( $transient_key );

    }


}
