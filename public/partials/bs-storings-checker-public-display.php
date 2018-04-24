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

<div class="bs-storings-form">
    <div id="sc-error" style="display:none">Dit is geen geldige postcode.</div>
    <div id="sc-not-found" style="display:none">Helaas, we leveren nog geen warmte op dit adres.</div>
    <div id="sc-found" style="display:none">Wij zijn niet op de hoogte van een storing of werkzaamheden op uw adres. Het is belangrijk om te weten waar de storing zich bevindt: in onze installatie of in uw binnenhuisinstallatie. <a href="/veelgestelde-vragen/">Waar zit de storing.</a></div>
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
<div uk-spinner id="sc-spinner" style="display:none" class="uk-margin"></div>
<div id="sc-storingen-intro" class="uk-margin" style="display:none; padding-top: 60px">Inderdaad, er vindt op dit moment een storing plaats op uw adres. We doen onze uiterste best om de warmtelevering zo snel mogelijk te hervatten!</div>
<div id="sc-storingen" class="uk-margin" style="display:none"></div>
