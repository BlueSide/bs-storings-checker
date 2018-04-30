<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.blueside.nl
 * @since      1.0.0
 *
 * @package    Bs_Storings_Checker
 * @subpackage Bs_Storings_Checker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bs_Storings_Checker
 * @subpackage Bs_Storings_Checker/public
 * @author     Marlon Peeters <marlon@blueside.nl>
 */
class Bs_Storings_Checker_Public
{

    /**
     * The URL to get the RSS feed from
     *
     * @since    1.0.0
     * @access   private
     * @var      string    rss_url    The URL to get the RSS feed from
     */
    private $rss_url_storingen = 'https://ennatuurlijk.nl/rss/storingen.rss';
    private $rss_url_werkzaamheden = 'https://ennatuurlijk.nl/rss/werkzaamheden.rss';

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

	$this->plugin_name = $plugin_name;
	$this->version = $version;

    }

    /**
     * 
     *
     * @since    1.0.0
     */
    public function storings_check()
    {
        // Check if postcode is acutally sent
        if(!isset($_POST['postcode']))
        {
            wp_die();
        }

        // Get the postcodes of our region from the Database
        $csvrows = explode("\n", get_option('postcodes'));
        $postcodes = array();
        foreach($csvrows as $row)
        {
            $comp = preg_split("/[\t]/", $row);
            array_push($postcodes, $comp[0]);
        }

        // Check if the postcode is in our region, return 'not_found' if not
        if(!in_array($_POST['postcode'], $postcodes))
        {
            $response->status = "not_found";
            echo json_encode($response);
            wp_die();
        }

        $response->items_storingen = $this->load_RSS_items($this->rss_url_storingen);
        $response->items_werkzaamheden = $this->load_RSS_items($this->rss_url_werkzaamheden);

        echo json_encode($response);

        wp_die();
    }

    /**
     * Get all titles, descriptions and postcodes from provided RSS feed.
     * 
     * @param    string    $url       The URL of the RSS feed.
     * @since    1.0.0
     */
    private function load_RSS_items($url)
    {
        $xml = new DOMDocument();
        $xml->load($url);
        $channel = $xml->getElementsByTagName('channel')->item(0);
        $items = $xml->getElementsByTagName('item');

        $entries = array();
        
        foreach($items as $item)
        {
            $entry = null;
            $entry->title = $item->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
            $entry->description = $item->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
            $entry->postcodes = $this->parse_postcodes_from_rss($entry->description);
            
            if($this->is_present($_POST['postcode'], $entry->postcodes))
            {
                array_push($entries, $entry);
            }
        }
        
        return $entries;
    }

    private function is_present($postcode, $postcodes)
    {
        /* NOTE:
         * Postcodes can be present as a single postcode (1234AA)
         * or as postcode area (1234), so we check first which
         * one is present in the $item.
         */
        foreach($postcodes as $item)
        {
            if(strlen((string)$item) === 6)
            {
                if($item === $postcode)
                {
                    return true;
                }

            }

            if(strlen((string)$item) === 4)
            {
                if($item === substr($postcode, 0, 4))
                {
                    return true;
                }
            }
        }

        return false;
    }

                private function parse_postcodes_from_rss($description)
                {
                    $result = array();
                    $postcodes = 'Postcodes: ';
                    $start = strpos($description , 'Postcodes: ');
                    $end = strlen($description);
                    $postcodes_str = substr($description, $start + strlen($postcodes), $end);
                    $sanitized_postcodes = preg_replace('/[^A-Za-z0-9\-]/', ' ', $postcodes_str);
                    $candidates = explode(" ", $sanitized_postcodes);

                    foreach ($candidates as $key => $element)
                    {
                        if (strlen($element) < 4 || strlen($element) > 6)
                        {
                            unset($candidates[$key]);
                        }
                    }
                    return $candidates;
                }
                
                /**
                 * 
                 *
                 * @since    1.0.0
                 */
                public function shortcode_callback()
                {
                    ob_start();
                    include dirname( __FILE__ ) . '/partials/bs-storings-checker-public-display.php';
                    return ob_get_clean();
                }

                /**
                 * Register the stylesheets for the public-facing side of the site.
                 *
                 * @since    1.0.0
                 */
                public function enqueue_styles()
                {
	            wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bs-storings-checker-public.css', array(), $this->version, 'all' );
                }

                /**
                 * Register the JavaScript for the public-facing side of the site.
                 *
                 * @since    1.0.0
                 */
                public function enqueue_scripts()
                {
	            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bs-storings-checker-public.js', array( 'jquery' ), $this->version, false );
                    wp_localize_script( $this->plugin_name, 'storings_checker', array('ajax_url' => admin_url( 'admin-ajax.php' )));
                }

            }
