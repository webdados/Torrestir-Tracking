# Torrestir Tracking

## Description

A micro-plugin for tracking shipments via the [Torrestir](https://tracking.torrestir.com/) carrier. It fetches the tracking page for a given tracking ID, parses the HTML response to extract the latest event, and caches the result using WordPress transients for efficient repeated lookups.

## Installation

1. Upload the `torrestir-tracking` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the **Plugins** menu in WordPress.

Updates are delivered automatically from [GitHub Releases](https://github.com/webdados/Torrestir-Tracking) using the bundled Plugin Update Checker library.

## Usage

Call `tt_get_last_event( $tracking_id )` from within the `NakedCatPlugins\TorrestirTracking` namespace (or use the fully-qualified name) with a valid Torrestir tracking ID. The function returns an associative array of event fields on success, or a `WP_Error` on failure.

```php
use function NakedCatPlugins\TorrestirTracking\tt_get_last_event;

$event = tt_get_last_event( 'M0010005E00344451499' );

if ( is_wp_error( $event ) ) {
    echo 'Error: ' . $event->get_error_message();
} else {
    print_r( $event ); // e.g. [ 'Description' => 'Entregue', ... ]
}
```

## Functions

All functions live in the `NakedCatPlugins\TorrestirTracking` namespace.

| Function | Description |
|---|---|
| `tt_get_last_event( $tracking_id )` | Fetches and returns the last tracking event for the given ID. Results are cached via WordPress transients: **1 hour** for in-transit shipments, **1 week** for delivered shipments (`Description` = `"Delivered"` or `"Entregue"`). Returns `array` or `WP_Error`. |
| `tt_parse_last_event( $html )` | Parses the raw HTML from the Torrestir tracking page and returns the last table row's event data as an associative array, or a `WP_Error` if no rows are found. |
| `tt_get_tracking_link( $tracking_id )` | Returns the full tracking URL for the given ID: `https://tracking.torrestir.com/?lang=pt&id={tracking_id}`. |

## Caching

Results are stored in WordPress transients under the key `torrestir_tracking_{tracking_id}`:

- **Delivered** (`"Delivered"` / `"Entregue"`): cached for **1 week**.
- **All other statuses**: cached for **1 hour**.

## Requirements

- WordPress 5.9 or higher
- PHP 7.2 or higher

## Author

**Naked Cat Plugins** (by Webdados) — [nakedcatplugins.com](https://nakedcatplugins.com)

## License

This plugin is licensed under the [GPLv3](https://www.gnu.org/licenses/gpl-3.0.html) or later.

---

*This README was written by AI based on the plugin source code.*