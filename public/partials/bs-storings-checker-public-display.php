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
    <div id="sc-found" style="display:none">Wij zijn niet op de hoogte van een storing of werkzaamheden op uw adres. Het is belangrijk om te weten waar de storing zich bevindt: in onze installatie of in uw binnenhuisinstallatie. <a href="/veelgestelde-vragen/">Waar zit de storing.</a></div>
    <div uk-spinner id="sc-spinner"  style="display:none"></div>
    <div class="bs-form-div">
        <form class="uk-grid-small">
                <div class="uk-width-1-2">
                    <input type="text" id="sc-postcode" class="uk-input" placeholder="Zoek uw postcode, bijvoorbeeld 1234AA"/>
                </div>
                <div class="uk-width-1-2">
                    <button type="button" class="check-storing uk-button uk-button-primary">Check</button>
                </div>
        </form>
    </div>
</div>
