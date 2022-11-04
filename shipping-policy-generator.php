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
            <div class='text-center p-4'>
                <button id='btn_shipping_form' class='btn btn-primary'>Generate Shipping Policy</button>
            </div>
            <div id='result' class='d-none'>
                <div class='row m-0'>
                    <div class='col-md-6'>
                        <div class='d-flex align-items-center vh-100'>
                            <div class='p-5'>
                                <div class='mb-4'>
                                    <h1>Here's your new policy</h1>
                                    <p class='' style='font-size: 20px;'>Click the button below to copy your shipping policy
                                    </p>
                                </div>

                                <button id='copy_btn' class='btn-copy text-uppercase'>COPY TO CLIPBOARD</button>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='d-flex flex-column justify-content-center vh-100 gap-4 pe-5'>
                            <div class='shadow p-4' style='height: 70vh;'>
                                <div class='border-bottom pb-2'>
                                    <h3>Shipping Policy</h3>
                                </div>
                                <div class='my-4' style='overflow: auto; height: 80%;'>
                                    <div class='shipping_policy_template result-preview'></div>
                                </div>
                            </div>
                            <div>
                                <p class='text-muted'>
                                    These sample policies should not be taken as legal advice. By using this for your store,
                                    you agree to this
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id='shipping_policy_generator_form_container' class='d-flex d-none'>
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
                        <h3 class='text-uppercase'>Shipping Policy</h3>

                        <div class='modal fade' id='result_modal' tabindex='-1' aria-hidden='true'>
                            <div class='modal-dialog modal-fullscreen'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title'>Shipping Policy</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'
                                            aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <div class='shipping_policy_template'></div>
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
                                    <!-- question 1 -->
                                    <div class='step'>
                                        <h5 class='question mb-4'>
                                            Where are most of your customers located - the UK or the US?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='official_location'
                                                    id='q_1_uk' value='UK'>
                                                <label class='form-check-label' for='q_1_uk'>
                                                    UK
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='official_location'
                                                    id='q_1_usa' value='USA'>
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
                                            <div class='form-check form-others'>
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

                                    <!-- question 2 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            What is your website URL? Attach the link in the section below
                                        </h5>
                                        <input type='text' class='form-control' name='website_url'>
                                    </div>

                                    <!-- question 3 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            How do customers view their order status?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='view_order_status'
                                                    id='q_3_id' value='They get a tracking ID'>
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
                                                <input class='form-check-input' type='radio' name='view_order_status'
                                                    id='q_3_page' value='They can log in to our page to track order'>
                                                <label class='form-check-label' for='q_3_page'>
                                                    They can log in to our page to track order
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 4 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            Can customers change or modify their order?
                                        </h5>

                                        <div>
                                            <div class='form-check form-textarea'>
                                                <input class='form-check-input' type='radio' name='change_order' id='q_4_a'
                                                    value='Yes'>
                                                <label class='form-check-label' for='q_4_a'>
                                                    Yes, customizations post order is available
                                                </label>
                                                <div class='form-group d-none'>
                                                    <label class='text-muted'>Please specify how to change order</label>
                                                    <textarea class='form-control' rows='5'></textarea>
                                                </div>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='change_order' id='q_4_b'
                                                    value='No'>
                                                <label class='form-check-label' for='q_4_b'>
                                                    No, customizations are not available post order
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 5 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            How long does an order take to dispatch?
                                        </h5>

                                        <div class='form-check'>
                                            <input class='form-check-input' type='radio'
                                                name='how_long_does_an_order_take_to_dispatch' id='q_5_a'
                                                value='same day dispatch'>
                                            <label class='form-check-label' for='q_5_a'>
                                                Same day dispatch
                                            </label>
                                        </div>
                                        <div class='form-check'>
                                            <input class='form-check-input' type='radio'
                                                name='how_long_does_an_order_take_to_dispatch' id='q_5_b'
                                                value='dispatched depending on inventory'>
                                            <label class='form-check-label' for='q_5_b'>
                                                Dispatched depending on inventory
                                            </label>
                                        </div>
                                        <div class='form-check'>
                                            <input class='form-check-input' type='radio'
                                                name='how_long_does_an_order_take_to_dispatch' id='q_5_c'
                                                value='dispatched in a standard two days post order placement'>
                                            <label class='form-check-label' for='q_5_c'>
                                                Dispatched in a standard two days post order placement
                                            </label>
                                        </div>
                                        <div class='form-check'>
                                            <input class='form-check-input' type='radio'
                                                name='how_long_does_an_order_take_to_dispatch' id='q_5_d'
                                                value='dispatch is dependent on the location of delivery'>
                                            <label class='form-check-label' for='q_5_d'>
                                                Dispatch is dependent on the location of delivery
                                            </label>
                                        </div>
                                    </div>

                                    <!-- question 6 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            Do you offer any same day dispatch services to your customers?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='offer_same_day_dispatch_service' id='q_6_yes' value='Yes'>
                                                <label class='form-check-label' for='q_6_yes'>
                                                    Yes
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='offer_same_day_dispatch_service' id='q_6_no' value='No'>
                                                <label class='form-check-label' for='q_6_no'>
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 7 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            Does your company offer free shipping services to customers?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='offer_free_shipping_services'
                                                    id='q_7_a' value='Yes, depending on the distance of the delivery'>
                                                <label class='form-check-label' for='q_7_a'>
                                                    Yes, depending on the distance of the delivery
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='offer_free_shipping_services'
                                                    id='q_7_b' value='No, we do not offer free delivery'>
                                                <label class='form-check-label' for='q_7_b'>
                                                    No, we do not offer free delivery
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='offer_free_shipping_services'
                                                    id='q_7_c'
                                                    value='Our free delivery is limited to customers with premium memberships'>
                                                <label class='form-check-label' for='q_7_c'>
                                                    Our free delivery is limited to customers with premium memberships
                                                </label>
                                            </div>
                                            <div class='form-check form-others'>
                                                <input class='form-check-input' type='radio' id='q_7_e'
                                                    name='offer_free_shipping_services' value=''>
                                                <label class='form-check-label' for='q_7_e'>
                                                    Others
                                                </label>
                                                <div class='form-group d-none' id='q_7_e_input_wrapper'>
                                                    <label class='text-muted'>Please specify in the section below</label>
                                                    <input type='text' id='q_7_e_input' class='form-control'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 8 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            How does shipping work?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='shipping_work' id='q_8_a'
                                                    value='Orders are shipped once payment is received'>
                                                <label class='form-check-label' for='q_8_a'>
                                                    Orders are shipped once payment is received
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='shipping_work' id='q_8_b'
                                                    value='Orders are shipped when an item is in stock'>
                                                <label class='form-check-label' for='q_8_b'>
                                                    Orders are shipped when an item is in stock
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='shipping_work' id='q_8_c'
                                                    value='All orders are shipped together'>
                                                <label class='form-check-label' for='q_8_c'>
                                                    All orders are shipped together
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='shipping_work' id='q_8_d'
                                                    value='Orders are shipped in parts, depending on the inventory of each product'>
                                                <label class='form-check-label' for='q_8_d'>
                                                    Orders are shipped in parts, depending on the inventory of each product
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 9 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            Do you have a return/exchange policy in place?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='do_you_have_return_policy'
                                                    id='q_9_a' value='Yes'>
                                                <label class='form-check-label' for='q_9_a'>
                                                    Yes
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='do_you_have_return_policy'
                                                    id='q_9_b' value='No'>
                                                <label class='form-check-label' for='q_9_b'>
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 10 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            How long does the customer have to raise an exchange request?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_customer_raise_exchange_request' id='q_10_a'
                                                    value='7 days'>
                                                <label class='form-check-label' for='q_10_a'>
                                                    7 days
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_customer_raise_exchange_request' id='q_10_b'
                                                    value='15 days'>
                                                <label class='form-check-label' for='q_10_b'>
                                                    15 days
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_customer_raise_exchange_request' id='q_10_c'
                                                    value='30 days'>
                                                <label class='form-check-label' for='q_10_c'>
                                                    30 days
                                                </label>
                                            </div>
                                            <div class='form-check form-others'>
                                                <input class='form-check-input' type='radio' id='q_10_d'
                                                    name='how_long_does_customer_raise_exchange_request' value=''>
                                                <label class='form-check-label' for='q_10_d'>
                                                    Others
                                                </label>
                                                <div class='form-group d-none' id='q_10_d_input_wrapper'>
                                                    <label class='text-muted'>Please specify in the section below</label>
                                                    <input type='text' id='q_10_d_input' class='form-control'>
                                                </div>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_customer_raise_exchange_request' id='q_10_e'
                                                    value='We have a no exchange policy'>
                                                <label class='form-check-label' for='q_10_e'>
                                                    We have a no exchange policy
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_customer_raise_exchange_request' id='q_10_f'
                                                    value='We have a no exchange policy on certain products'>
                                                <label class='form-check-label' for='q_10_f'>
                                                    We have a no exchange policy on certain products
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_customer_raise_exchange_request' id='q_10_g'
                                                    value='Exchange requests need to be generated by contacting our team directly '>
                                                <label class='form-check-label' for='q_10_g'>
                                                    Exchange requests need to be generated by contacting our team directly
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 11 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            How long does the customer have to raise a return request?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_customer_raise_return_request' id='q_11_a'
                                                    value='7 days'>
                                                <label class='form-check-label' for='q_11_a'>
                                                    7 days
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_customer_raise_return_request' id='q_11_b'
                                                    value='15 days'>
                                                <label class='form-check-label' for='q_11_b'>
                                                    15 days
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_customer_raise_return_request' id='q_11_c'
                                                    value='30 days'>
                                                <label class='form-check-label' for='q_11_c'>
                                                    30 days
                                                </label>
                                            </div>
                                            <div class='form-check form-others'>
                                                <input class='form-check-input' type='radio' id='q_11_d'
                                                    name='how_long_does_customer_raise_return_request' value=''>
                                                <label class='form-check-label' for='q_11_d'>
                                                    Others
                                                </label>
                                                <div class='form-group d-none' id='q_11_d_input_wrapper'>
                                                    <label class='text-muted'>Please specify in the section below</label>
                                                    <input type='text' id='q_11_d_input' class='form-control'>
                                                </div>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_customer_raise_return_request' id='q_11_e'
                                                    value='We have a no return policy'>
                                                <label class='form-check-label' for='q_11_e'>
                                                    We have a no return policy
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_customer_raise_return_request' id='q_11_f'
                                                    value='We have a no return policy on certain products'>
                                                <label class='form-check-label' for='q_11_f'>
                                                    We have a no return policy on certain products
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_customer_raise_return_request' id='q_11_g'
                                                    value='Return requests need to be generated by contacting our team directly'>
                                                <label class='form-check-label' for='q_11_g'>
                                                    Return requests need to be generated by contacting our team directly
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 12 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            Does the customer have to pay additional charges for return/exchange?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='does_customer_pay_additional_charges' id='q_12_a' value='Yes'>
                                                <label class='form-check-label' for='q_12_a'>
                                                    Yes
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='does_customer_pay_additional_charges' id='q_12_b' value='No'>
                                                <label class='form-check-label' for='q_12_b'>
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 13 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            How long does it take to initiate a return/exchange?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_it_take_to_initiate_return_exchange' id='q_13_a'
                                                    value='It is immediate '>
                                                <label class='form-check-label' for='q_13_a'>
                                                    It is immediate
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_it_take_to_initiate_return_exchange' id='q_13_b'
                                                    value='5 - 7'>
                                                <label class='form-check-label' for='q_13_b'>
                                                    5 - 7 working days
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='how_long_does_it_take_to_initiate_return_exchange' id='q_13_c'
                                                    value='The timeline depends on the availability of the product requested'>
                                                <label class='form-check-label' for='q_13_c'>
                                                    The timeline depends on the availability of the product requested
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 14 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            What forms of payments do you offer for the customer?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='forms_of_payments'
                                                    id='q_14_a' value='online payments only'>
                                                <label class='form-check-label' for='q_14_a'>
                                                    Online payments only
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='forms_of_payments'
                                                    id='q_14_b' value='cash on delivery'>
                                                <label class='form-check-label' for='q_14_b'>
                                                    Cash on delivery is available
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='forms_of_payments'
                                                    id='q_14_c' value='net banking options'>
                                                <label class='form-check-label' for='q_14_c'>
                                                    Net banking options are available
                                                </label>
                                            </div>
                                            <div class='form-check form-others'>
                                                <input class='form-check-input' type='radio' id='q_14_d'
                                                    name='forms_of_payments' value=''>
                                                <label class='form-check-label' for='q_14_d'>
                                                    Others
                                                </label>
                                                <div class='form-group d-none' id='q_14_d_input_wrapper'>
                                                    <label class='text-muted'>Please specify in the section below</label>
                                                    <input type='text' id='q_14_d_input' class='form-control'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 15 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            What payment currencies do you accept?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='payment_currencies'
                                                    id='q_15_a' value='In Dollars'>
                                                <label class='form-check-label' for='q_15_a'>
                                                    In Dollars
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='payment_currencies'
                                                    id='q_15_b' value='In Euros'>
                                                <label class='form-check-label' for='q_15_b'>
                                                    In Euros
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='payment_currencies'
                                                    id='q_15_c' value='In Pounds'>
                                                <label class='form-check-label' for='q_15_c'>
                                                    In Pounds
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='payment_currencies'
                                                    id='q_15_d' value='All international currency payments are accepted'>
                                                <label class='form-check-label' for='q_15_d'>
                                                    All international currency payments are accepted
                                                </label>
                                            </div>
                                            <div class='form-check form-others'>
                                                <input class='form-check-input' type='radio' id='q_15_e'
                                                    name='payment_currencies' value=''>
                                                <label class='form-check-label' for='q_15_e'>
                                                    Others
                                                </label>
                                                <div class='form-group d-none' id='q_15_e_input_wrapper'>
                                                    <label class='text-muted'>Please specify in the section below</label>
                                                    <input type='text' id='q_15_e_input' class='form-control'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 16 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            Do you offer any special payment plans or schemes?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='do_you_offer_any_special_payment_plans' id='q_16_a'
                                                    value='Installments are available'>
                                                <label class='form-check-label' for='q_16_a'>
                                                    Installments are available
                                                </label>
                                            </div>
                                            <div class='form-check form-others'>
                                                <input class='form-check-input' type='radio' id='q_16_e'
                                                    name='do_you_offer_any_special_payment_plans' value=''>
                                                <label class='form-check-label' for='q_16_e'>
                                                    Other payment plans are available on request (Please specify the type)
                                                </label>
                                                <div class='form-group d-none' id='q_16_e_input_wrapper'>
                                                    <input type='text' id='q_16_e_input' class='form-control'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 17 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            What is your policy when some items are out of stock or unavailable?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='policy_when_some_items_are_unavailable' id='q_17_a'
                                                    value='Cancel the unavailable items from the shopping list and give the customer a refund for that item'>
                                                <label class='form-check-label' for='q_17_a'>
                                                    Cancel the unavailable items from the shopping list and give the
                                                    customer a
                                                    refund for that item
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='policy_when_some_items_are_unavailable' id='q_17_b'
                                                    value='Wait for out of stock items to be back in stock and ship after'>
                                                <label class='form-check-label' for='q_17_b'>
                                                    Wait for out of stock items to be back in stock and ship after
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='policy_when_some_items_are_unavailable' id='q_17_c'
                                                    value='Send the package in parts. Send the available items first, and send the out of stock item later'>
                                                <label class='form-check-label' for='q_17_c'>
                                                    Send the package in parts. Send the available items first, and send the
                                                    out
                                                    of stock item later
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 18 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            Do you offer international shipping services?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='international_shipping'
                                                    id='q_18_a' value='Yes'>
                                                <label class='form-check-label' for='q_18_a'>
                                                    Yes
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='international_shipping'
                                                    id='q_18_b' value='No'>
                                                <label class='form-check-label' for='q_18_b'>
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 19 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            In the case of international shipping, what are the Import Duty & Taxes?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='import_duty_taxes'
                                                    id='q_19_a'
                                                    value='You pre-pay Import Duty & Taxes on behalf of the customer'>
                                                <label class='form-check-label' for='q_19_a'>
                                                    You pre-pay Import Duty & Taxes on behalf of the customer
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='import_duty_taxes'
                                                    id='q_19_b'
                                                    value='The customer needs to pay Import Duty & Taxes when the package arrives at the destination country'>
                                                <label class='form-check-label' for='q_19_b'>
                                                    The customer needs to pay Import Duty & Taxes when the package arrives
                                                    at
                                                    the destination country
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='import_duty_taxes'
                                                    id='q_19_c'
                                                    value='The customer has the option to choose whether they want to pre-pay Import Duty & Taxes'>
                                                <label class='form-check-label' for='q_19_c'>
                                                    The customer has the option to choose whether they want to pre-pay
                                                    Import
                                                    Duty & Taxes
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 20 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            Do you offer in-store or curbside pickups?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='in_store_curbside_pickups'
                                                    id='q_20_a' value='In-store'>
                                                <label class='form-check-label' for='q_20_a'>
                                                    In-store
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='in_store_curbside_pickups'
                                                    id='q_20_b' value='Curbside'>
                                                <label class='form-check-label' for='q_20_b'>
                                                    Curbside
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='in_store_curbside_pickups'
                                                    id='q_20_c' value='Both'>
                                                <label class='form-check-label' for='q_20_c'>
                                                    Both
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='in_store_curbside_pickups'
                                                    id='q_20_d' value='Neither'>
                                                <label class='form-check-label' for='q_20_d'>
                                                    Neither
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 21 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            What happens if the customer is not at home?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='customer_is_not_at_home'
                                                    id='q_21_a' value='Order is returned to the original address'>
                                                <label class='form-check-label' for='q_21_a'>
                                                    Order is returned to the original address
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='customer_is_not_at_home'
                                                    id='q_21_b' value='The delivery agent makes 2-3 attempts to deliver'>
                                                <label class='form-check-label' for='q_21_b'>
                                                    The delivery agent makes 2-3 attempts to deliver
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='customer_is_not_at_home'
                                                    id='q_21_c'
                                                    value='The delivery agent calls the customer for an alternative delivery option'>
                                                <label class='form-check-label' for='q_21_c'>
                                                    The delivery agent calls the customer for an alternative delivery option
                                                </label>
                                            </div>
                                            <div class='form-check form-others'>
                                                <input class='form-check-input' type='radio' id='q_21_d'
                                                    name='customer_is_not_at_home' value=''>
                                                <label class='form-check-label' for='q_21_d'>
                                                    Others
                                                </label>
                                                <div class='form-group d-none' id='q_21_d_input_wrapper'>
                                                    <label class='text-muted'>Please specify in the section below</label>
                                                    <input type='text' id='q_21_d_input' class='form-control'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 22 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            How do customers get in touch with you to enquire about your shipping policy?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='customer_get_in_touch_with_you' id='q_22_a' value='phone'>
                                                <label class='form-check-label' for='q_22_a'>
                                                    Phone
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio'
                                                    name='customer_get_in_touch_with_you' id='q_22_b' value='email'>
                                                <label class='form-check-label' for='q_22_b'>
                                                    Email
                                                </label>
                                            </div>
                                            <div class='form-check form-others'>
                                                <input class='form-check-input' type='radio'
                                                    name='customer_get_in_touch_with_you' id='q_22_c' value=''>
                                                <label class='form-check-label' for='q_22_c'>
                                                    We have a contact form
                                                </label>
                                                <div class='form-group'>
                                                    <label class='text-muted'>Please specify in the section below</label>
                                                    <input type='text' class='form-control'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 23 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            What can customers do if their tracking ID stops updating?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='tracking_id_stop_updating'
                                                    id='q_23_a' value='Talk to our customer care executive'>
                                                <label class='form-check-label' for='q_23_a'>
                                                    Talk to our customer care executive
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='tracking_id_stop_updating'
                                                    id='q_23_b' value='Contact us via email/phone/contact form'>
                                                <label class='form-check-label' for='q_23_b'>
                                                    Contact us via email/phone/contact form
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='tracking_id_stop_updating'
                                                    id='q_23_c' value='Talk to us on chat'>
                                                <label class='form-check-label' for='q_23_c'>
                                                    Talk to us on chat
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='tracking_id_stop_updating'
                                                    id='q_23_d' value='Refresh their page to see a changed status'>
                                                <label class='form-check-label' for='q_23_d'>
                                                    Refresh their page to see a changed status
                                                </label>
                                            </div>
                                            <div class='form-check form-others'>
                                                <input class='form-check-input' type='radio' id='q_23_e'
                                                    name='tracking_id_stop_updating' value=''>
                                                <label class='form-check-label' for='q_23_e'>
                                                    Others
                                                </label>
                                                <div class='form-group d-none' id='q_23_e_input_wrapper'>
                                                    <label class='text-muted'>Please specify in the section below</label>
                                                    <input type='text' id='q_23_e_input' class='form-control'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 24 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            Do you guys offer an affiliate program?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='affiliate_program'
                                                    id='q_24_a' value='Yes'>
                                                <label class='form-check-label' for='q_24_a'>
                                                    Yes
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='affiliate_program'
                                                    id='q_24_b' value='No'>
                                                <label class='form-check-label' for='q_24_b'>
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 25 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            Do you have any physical stores?
                                        </h5>

                                        <div>
                                            <div class='form-check form-others'>
                                                <input class='form-check-input' type='radio' name='physical_store' id='q_25_a'
                                                    value=''>
                                                <label class='form-check-label' for='q_25_a'>
                                                    Yes
                                                </label>
                                                <div class='form-group d-none'>
                                                    <label class='text-muted'>Please specify in the section below</label>
                                                    <input type='text' class='form-control'>
                                                </div>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='physical_store' id='q_25_b'
                                                    value='No'>
                                                <label class='form-check-label' for='q_25_b'>
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- question 26 -->
                                    <div class='step d-none'>
                                        <h5 class='question mb-4'>
                                            Do you offer a warranty?
                                        </h5>

                                        <div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='warranty' id='q_26_a'
                                                    value='Yes'>
                                                <label class='form-check-label' for='q_26_a'>
                                                    Yes
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='warranty' id='q_26_b'
                                                    value='No'>
                                                <label class='form-check-label' for='q_26_b'>
                                                    No
                                                </label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='warranty' id='q_26_c'
                                                    value='We offer a warranty on specific products'>
                                                <label class='form-check-label' for='q_26_c'>
                                                    We offer a warranty on specific products
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
                                        <button id='done_btn' class='btn btn-primary d-none'>DONE</button>
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
    ";
});
