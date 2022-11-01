<?php

/**
 * Shipping Policy Generator
 *
 * @package     ShippingPolicyGenerator
 * @author      Henri Susanto
 * @copyright   2022 Henri Susanto
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Shipping Policy Generator
 * Plugin URI:  https://github.com/susantohenri
 * Description: Wordpress plugin for generating shipping policy base on user supplied information
 * Version:     1.0.0
 * Author:      Henri Susanto
 * Author URI:  https://github.com/susantohenri
 * Text Domain: ShippingPolicyGenerator
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

add_shortcode('shipping-policy-generator', function () {

    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.6.1.js');
    wp_enqueue_script('jquery');

    wp_register_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_script('bootstrap');

    wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap');

    wp_register_style('shipping-policy-generator', plugin_dir_url(__FILE__) . 'shipping-policy-generator.css?cache-breaker=' . time());
    wp_enqueue_style('shipping-policy-generator');

    wp_register_script('shipping-policy-generator', plugin_dir_url(__FILE__) . 'shipping-policy-generator.js?cache-breaker=' . time());
    wp_enqueue_script('shipping-policy-generator');

    return "
        <div id='shipping_policy_generator'>
            <button id='btn_shipping_form' class='btn btn-primary'>Generate Shipping Policy</button>
            <div id='shipping_form'>
                <div class='d-flex'>
                    <div class='bg-light pt-4 min-vh-100'>
                        <div class='px-4 pb-3 border-bottom' style='width: 200px;'>
                            <h6>Progress</h6>
                            <div class='progress'>
                                <div id='progress_bar' class='progress-bar' role='progressbar' style='width: 0%;' aria-valuemin='0'
                                    aria-valuemax='100'></div>
                            </div>
                        </div>
                        <div class='py-4' style='width: 200px;'>
                            <div class='navigation d-flex flex-column'>
                                <a href='#' class='px-4 bg-white py-2' data-nav='0'>General</a>
                                <a href='#' class='px-4 py-2' data-nav='1'>Same day dispatch services</a>
                                <a href='#' class='px-4 py-2' data-nav='2'>Shipping Questions</a>
                                <a href='#' class='px-4 py-2' data-nav='3'>Return policy</a>
                                <a href='#' class='px-4 py-2' data-nav='4'>Payment policy</a>
                                <a href='#' class='px-4 py-2' data-nav='5'>What happens to out of stock items?</a>
                                <a href='#' class='px-4 py-2' data-nav='6'>International Shipping</a>
                                <a href='#' class='px-4 py-2' data-nav='7'>Delivery Logistic</a>
                                <a href='#' class='px-4 py-2' data-nav='8'>Contact details</a>
                                <a href='#' class='px-4 py-2' data-nav='9'>Other details</a>
                            </div>
                        </div>
                    </div>
                    <div class='flex-fill bg-white py-4 px-5'>
                        <div class='d-flex justify-content-between'>
                            <h3>Shipping Policy</h3>

                            <div class='modal fade' id='result_modal' tabindex='-1' aria-hidden='true'>
                                <div class='modal-dialog modal-fullscreen'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Shipping Policy</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <div id='shipping_policy_template'></div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-8'>
                                <form id='shipping_policy_form' action='' method='post'>
                                    <div class='step-container pb-5 border-bottom'>
                                        <div class='step'>
                                            <h5 class='question mb-4'>
                                                Where are most of your customers located - the UK or the US?
                                            </h5>

                                            <div>
                                                <div class='form-check'>
                                                    <input class='form-check-input' type='radio' name='official_location' id='q_1_uk'
                                                        value='UK'>
                                                    <label class='form-check-label' for='q_1_uk'>
                                                        UK
                                                    </label>
                                                </div>
                                                <div class='form-check'>
                                                    <input class='form-check-input' type='radio' name='official_location' id='q_1_usa'
                                                        value='USA'>
                                                    <label class='form-check-label' for='q_1_usa'>
                                                        USA
                                                    </label>
                                                </div>
                                                <div class='form-check'>
                                                    <input class='form-check-input' type='radio' name='official_location'
                                                        id='q_1_canada' value='Canada'>
                                                    <label class='form-check-label' for='q_1_canada'>
                                                        Canada
                                                    </label>
                                                </div>
                                                <div class='form-check'>
                                                    <input class='form-check-input' type='radio' id='q_1_others'
                                                        name='official_location' value=''>
                                                    <label class='form-check-label' for='q_1_others'>
                                                        Others
                                                    </label>
                                                    <div class='form-group d-none' id='q_1_others_text'>
                                                        <label class='text-muted'>Please specify in the section below</label>
                                                        <input type='text' id='q_1_others_text_input' class='form-control'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class='step d-none'>
                                            <h5 class='question mb-4'>
                                                What is your website URL? Attach the link in the section below
                                            </h5>
                                            <input type='text' class='form-control' name='website_url'>
                                        </div>

                                        <div class='step d-none'>
                                            <h5 class='question mb-4'>
                                                How do customers view their order status?
                                            </h5>

                                            <div>
                                                <div class='form-check'>
                                                    <input class='form-check-input' type='radio' name='view_order_status' id='q_3_id'
                                                        value='They get a tracking ID'>
                                                    <label class='form-check-label' for='q_3_id'>
                                                        They get a tracking ID
                                                    </label>
                                                </div>
                                                <div class='form-check'>
                                                    <input class='form-check-input' type='radio' name='view_order_status'
                                                        id='q_3_contact' value='They can contact customer care'>
                                                    <label class='form-check-label' for='q_3_contact'>
                                                        They can contact customer care
                                                    </label>
                                                </div>
                                                <div class='form-check'>
                                                    <input class='form-check-input' type='radio' name='view_order_status' id='q_3_page'
                                                        value='They can log in to our page to track order'>
                                                    <label class='form-check-label' for='q_3_page'>
                                                        They can log in to our page to track order
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class='step d-none'>
                                            <h5 class='question mb-4'>
                                                Can customers change or modify their order?
                                            </h5>

                                            <div>
                                                <div class='form-check'>
                                                    <input class='form-check-input' type='radio' name='can_customers_change_order'
                                                        id='q_4_a' value='Yes, customizations post order is available'>
                                                    <label class='form-check-label' for='q_4_a'>
                                                        Yes, customizations post order is available
                                                    </label>
                                                </div>
                                                <div class='form-check'>
                                                    <input class='form-check-input' type='radio' name='can_customers_change_order'
                                                        id='q_4_b' value='No, customizations are not available post order'>
                                                    <label class='form-check-label' for='q_4_b'>
                                                        No, customizations are not available post order
                                                    </label>
                                                </div>
                                                <div class='form-check'>
                                                    <input class='form-check-input' type='radio' name='can_customers_change_order'
                                                        id='q_4_c'
                                                        value='Customizations are available on special request. The customer must contact our team'>
                                                    <label class='form-check-label' for='q_4_c'>
                                                        Customizations are available on special request. The customer must contact
                                                        our team
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class='step d-none'>
                                            <h5 class='question mb-4'>
                                                How long does an order take to dispatch?
                                            </h5>

                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_an_order_take_to_dispatch' id='q_5_a' value='Same day dispatch'>
                                                <label class='form-check-label' for='q_5_a'>
                                                    Same day dispatch
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_an_order_take_to_dispatch' id='q_5_b'
                                                    value='Dispatched depending on inventory'>
                                                <label class='form-check-label' for='q_5_b'>
                                                    Dispatched depending on inventory
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_an_order_take_to_dispatch' id='q_5_c'
                                                    value='Dispatched in a standard two days post order placement'>
                                                <label class='form-check-label' for='q_5_c'>
                                                    Dispatched in a standard two days post order placement
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_an_order_take_to_dispatch' id='q_5_d'
                                                    value='Dispatch is dependent on the location of delivery'>
                                                <label class='form-check-label' for='q_5_d'>
                                                    Dispatch is dependent on the location of delivery
                                                </label>
                                            </div>
                                        </div>

                                        <div class='step d-none'>
                                            <h5 class='question mb-4'>
                                                Do you offer any same day dispatch services to your customers?
                                            </h5>

                                            <div>
                                                <div class='form-check'>
                                                    <input class='form-check-input' type='radio' name='offer_same_day_dispatch_service'
                                                        id='q_6_yes' value='Yes'>
                                                    <label class='form-check-label' for='q_6_yes'>
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class='form-check'>
                                                    <input class='form-check-input' type='radio' name='offer_same_day_dispatch_service'
                                                        id='q_6_no' value='No'>
                                                    <label class='form-check-label' for='q_6_no'>
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class='d-flex justify-content-between pt-4'>
                                        <div>
                                            <button id='back_btn' class='btn btn-outline-primary'>BACK</button>
                                        </div>
                                        <div>
                                            <button id='next_btn' class='btn btn-primary'>NEXT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class='col-md-4'>
                                <div class='preview-wrapper p-4 bg-light rounded'>
                                    <div class='preview-content rounded'></div>
                                </div>
                                <div class='d-grid pt-4'>
                                    <button id='preview_btn' class='btn btn-outline-primary' data-bs-toggle='modal'
                                        data-bs-target='#result_modal'>PREVIEW</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ";
});
