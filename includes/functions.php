<?php
/**
 * Functions file for Torrestir Tracking - Ideally this should be a class
 */

namespace NakedCatPlugins\TorrestirTracking;

/**
 * Parses the HTML response from Torrestir to extract the last event data.
 *
 * @param string $html The HTML content to parse.
 * @return array|\WP_Error An associative array of event data or a WP_Error on failure.
 */
function tt_parse_last_event( $html ) {
	libxml_use_internal_errors( true );
	$dom = new \DOMDocument();
	$dom->loadHTML( $html );
	$xpath = new \DOMXPath( $dom );
	$rows  = $xpath->query( '//tr[contains(@class, "tabela-linhas")]' );

	if ( $rows->length === 0 ) {
		return new \WP_Error( 'torrestir_tracking_parse_failed', 'No rows found' );
	}

	$last_row = $rows->item( $rows->length - 1 );
	$data     = array();

	foreach ( $last_row->getElementsByTagName( 'input' ) as $input ) {
		$key          = trim( explode( '.', $input->getAttribute( 'name' ) )[1] ?? $input->getAttribute( 'name' ) );
		$data[ $key ] = trim( $input->getAttribute( 'value' ) );
	}

	return $data;
}

/**
 * Retrieves the last tracking event for a given tracking ID.
 *
 * @param string $tracking_id The tracking ID to query.
 * @return array|\WP_Error An associative array of event data or a WP_Error on failure.
 */
function tt_get_last_event( $tracking_id ) {
	$tracking_id   = trim( sanitize_text_field( $tracking_id ) );
	$transient_key = 'torrestir_tracking_' . $tracking_id;
	$cached_event  = get_transient( $transient_key );

	if ( $cached_event ) {
		return $cached_event;
	}

	$response = wp_remote_get( tt_get_tracking_link( $tracking_id ) );
	if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
		return new \WP_Error( 'torrestir_tracking_request_failed', 'Failed to retrieve tracking data' );
	}

	$body       = wp_remote_retrieve_body( $response );
	$event_data = tt_parse_last_event( $body );

	if ( is_wp_error( $event_data ) ) {
		return $event_data;
	}

	if (
		isset( $event_data['Description'] )
		&&
		( $event_data['Description'] === 'Delivered' || $event_data['Description'] === 'Entregue' )
	) {
		$transient_validity = WEEK_IN_SECONDS;
	} else {
		$transient_validity = HOUR_IN_SECONDS;
	}

	set_transient( $transient_key, $event_data, $transient_validity );
	return $event_data;
}

/**
 * Constructs the tracking URL for a given tracking ID.
 *
 * @param string $tracking_id The tracking ID to construct the URL for.
 * @return string The constructed tracking URL.
 */
function tt_get_tracking_link( $tracking_id ) {
	return "https://tracking.torrestir.com/?lang=pt&id={$tracking_id}";
}
