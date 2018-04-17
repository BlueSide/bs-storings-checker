<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.blueside.nl
 * @since      1.0.0
 *
 * @package    Bs_Storings_Checker
 * @subpackage Bs_Storings_Checker/public/partials
 */
?>
<div id="storingen"></div>
<div class="bs-storings-form">
    <div id="sc-error" style="display:none">Geen geldige postcode!</div>
    <div id="sc-not-found" style="display:none">De postcode is niet gevonden!</div>
    <div id="sc-found" style="display:none">Er zijn geen storingen bekend in uw postcodegebied.</div>
    <form class="uk-grid-small">
            <div class="uk-width-1-2">
                <input type="text" id="sc-postcode" class="uk-input" placeholder="Postcode"/>
            </div>
            <div class="uk-width-1-2">
                <button type="button" class="check-storing uk-button uk-button-primary">Check</button>
            </div>
    </form>
</div>
