# torrestir-tracking

## Description
The "torrestir-tracking" plugin is designed to provide tracking functionalities for users. It parses HTML data to extract relevant event information and caches results for efficient retrieval.

## Installation
1. Upload the `torrestir-tracking` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage
Once activated, the plugin can be used to track events by calling the `torrestir_tracking_get_last_event( $tracking_id )` function with a valid tracking ID. This function will return the last event details or an error if the tracking ID is invalid or if the request fails.

## Functions
- **torrestir_tracking_parse_last_event( $html )**: Parses the provided HTML to extract the last event details.
- **torrestir_tracking_get_last_event( $tracking_id )**: Retrieves the last event based on the tracking ID, utilizing caching for performance.

## Requirements
- WordPress 5.0 or higher
- PHP 7.0 or higher

## Author
Your Name

## License
This plugin is licensed under the GPLv2 or later.