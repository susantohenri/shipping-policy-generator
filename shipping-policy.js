$(document).ready(function () {
    let step = $('.step')
    let backBtn = $('#back_btn')
    let nextBtn = $('#next_btn')
    let previewBtn = $('#preview_btn')
    let form = $('#shipping_policy_form')
    let doneBtn = $('#done_btn')
    let copy = $('#copy_btn')
    let generateBtn = $('#btn_shipping_form')

    let data_answer = {}
    let currentStep = 0
    let totalSteps = step.length

    form.on('submit', function (e) {
        return false
    })

    generate_shipping_policy(data_answer)

    generateBtn.on('click', function() {
        $('#shipping_policy_generator_form_container').removeClass('d-none')
        $(this).parent().addClass('d-none')
    })

    previewBtn.on('click', function () {
        console.log(data_answer)
        generate_shipping_policy(data_answer)
    })

    copy.on('click', function () {
        let temp = $('<div></div>')
        $('body').append(temp)
        temp.attr('contenteditable', true)
            .html($('#result .shipping_policy_template').html()).select()
            .on('focus', function() {
                document.execCommand('selectAll', false, null)
            })
            .focus()
        document.execCommand('copy')
        temp.remove()
    })

    toggle_show_hide_step(currentStep)

    nextBtn.on('click', function () {
        if (currentStep < totalSteps - 1) {
            currentStep++
            toggle_show_hide_step(currentStep)
        }
    })

    backBtn.on('click', function () {
        if (currentStep > 0) {
            currentStep--
            toggle_show_hide_step(currentStep)
        }
    })

    doneBtn.on('click', function () {
        $('#result').removeClass('d-none').siblings().addClass('d-none')
        generate_shipping_policy(data_answer)
    })

    function toggle_show_hide_step(currentStep) {
        step.eq(currentStep).removeClass('d-none').siblings().addClass('d-none')
        toggle_nav_current(currentStep)

        if (currentStep === 0) {
            backBtn.addClass('d-none')
            nextBtn.removeClass('d-none')
            doneBtn.addClass('d-none')
        } else if (currentStep === totalSteps - 1) {
            nextBtn.addClass('d-none')
            backBtn.removeClass('d-none')
            doneBtn.removeClass('d-none')
        } else {
            backBtn.removeClass('d-none')
            nextBtn.removeClass('d-none')
            doneBtn.addClass('d-none')
        }
    }

    function toggle_nav_current(currentStep) {
        let dataNav = 0
        if (currentStep >= 0 && currentStep <= 4) dataNav = 0
        else if (currentStep >= 5 && currentStep <= 5) dataNav = 1
        else if (currentStep >= 6 && currentStep <= 7) dataNav = 2
        else if (currentStep >= 8 && currentStep <= 12) dataNav = 3
        else if (currentStep >= 13 && currentStep <= 15) dataNav = 4
        else if (currentStep >= 16 && currentStep <= 16) dataNav = 5
        else if (currentStep >= 17 && currentStep <= 18) dataNav = 6
        else if (currentStep >= 19 && currentStep <= 20) dataNav = 7
        else if (currentStep >= 21 && currentStep <= 21) dataNav = 8
        else if (currentStep >= 22) dataNav = 9

        if (currentStep >= 25) {
            progress(100)
        } else {
            progress(dataNav * 10)
        }

        $(`a[data-nav="${dataNav}"`).addClass('bg-white text-primary').siblings().removeClass('bg-white text-primary')
    }

    function progress(value) {
        $('#progress_bar').width(value + '%')
        $('#progress_bar').html(value + '%')
    }

    $('.form-check').each(function () {
        $(this).find('input[type="radio"]').on('click', function () {
            let name = $(this).attr('name')
            let value = $(this).val()
            data_answer = {
                ...data_answer,
                [name]: value,
            }

            if ($(this).parent().hasClass('form-others')) {
                $(this).parent().find($('.form-group')).removeClass('d-none')
                
                data_answer = {
                    ...data_answer,
                    [name]: $(this).parent().find($('.form-group')).find($('input[type="text"]')).val(),
                }

                $(this).parent().find($('.form-group')).find($('input[type="text"]')).on('keyup', function (e) {
                    data_answer = {
                        ...data_answer,
                        [name]: e.target.value,
                    }
                })
            } else if ($(this).parent().hasClass('form-textarea')) {
                $(this).parent().find($('.form-group')).removeClass('d-none')

                data_answer = {
                    ...data_answer,
                    [name]: $(this).parent().find($('.form-group')).find($('textarea')).val(),
                }

                $(this).parent().find($('.form-group')).find($('textarea')).on('keyup', function (e) {
                    data_answer = {
                        ...data_answer,
                        [name]: e.target.value,
                    }
                })
            } else {
                $(this).parent().parent().find($('.form-group')).addClass('d-none')
            }
        })
    })

    $('input[name="website_url"').on('keyup', function (e) {
        let name = $(this).attr('name')
        data_answer = {
            ...data_answer,
            [name]: e.target.value,
        }
    })


    function generate_shipping_policy(data) {
        const template = `
                        <div class="shipping-policy-title">
                            <h2 class="mb-2 text-uppercase">Shipping Policy</h2>
                            <p>We are glad you chose us for your purchase. The following conditions define our
                                shipping policy for all orders and purchases made on the platform.</p>
                        </div>

                        <div class="shipping-policy-section">
                            <h4>Shipping Location</h4>
                            <p>We ship all orders from ${data.official_location}.</p>
                        </div>

                        <div class="shipping-policy-section">
                            <h4>Order Tracking</h4>
                            <p>You can view the status of your orders by visiting your account. The Order
                                tab
                                lets you view all your recent purchases. You can click on any current order
                                to
                                view their statuses.</p>
                        </div>
                        ${
                            (() => {
                                if (data.change_order !== 'No') {
                                    return `
                                        <div class="shipping-policy-section">
                                            <h4>Modifying Your Order</h4>
                                            <p>
                                                Our company is more than happy to allow you to change your orders. You can
                                                modify your orders by accessing the Order section in your account. Select
                                                the order you want to alter and ${data.change_order}.
                                            </p>
                                        </div>
                                    `
                                } else {
                                    return ''
                                }
                            })()
                        }
                        <div class="shipping-policy-section">
                            <h4>Expected Delivery Time</h4>
                            <p>
                                Expected delivery times are displayed on the product page. You can enter
                                your PIN to find out how many days your items may take to reach you.
                                Choosing different shipping options may impact the delivery time. We
                                generally take ${data.how_long_does_an_order_take_to_dispatch} working days to process and ship your
                                orders.
                            </p>
                            <p>
                                You can also view the expected delivery time when you pay for your order and
                                check out. However, high volume may impact shipping times and cause delays.
                            </p>

                            <h6>Contact</h6>
                            <p>
                                You can always contact us for any queries. We are available at
                                ${data.customer_get_in_touch_with_you}.
                            </p>
                        </div>
                        <div class="shipping-policy-section">
                            <h4>Payment</h4>
                            <p>
                                We believe in flexibility and let you pay using several methods. You can
                                pick your preferred method while paying for your order during checking out.
                                We support ${data.forms_of_payments}.
                            </p>
                            <p>
                                Moreover, you can choose to pay in your preferred currencies. You will be
                                able to change the currency to your choice during paying. We support the
                                following currencies - ${data.payment_currencies}.
                            </p>

                            <h6>Payment Plans</h6>
                            <p>
                                You can pay in affordable installments using our payment plans. The
                                information about the plans is displayed when you check out. You will be
                                able to compare your options and choose the right one.
                            </p>
                        </div>
                        <div class="shipping-policy-section">
                            <h4>Shipping Policy</h4>
                            <p>
                                We pride ourselves on making deliveries simple and hassle-free. You can
                                select your preferred shipping method from several options when you check
                                out.
                            </p>
                            <p>
                                Our team takes ${data.how_long_does_an_order_take_to_dispatch} business days to process your orders. A high volume of purchases may delay processing. You will always be able to track the status of your order from your account.
                            </p>

                            <h6>Shipping Methods</h6>
                            <p>
                                You can select the best shipping method for your needs when you order from our store. We offer the following shipping options:
                            </p>

                            ${data.shipping_work}

                            <h6>Shipping Costs</h6>
                            <p>
                                Shipping costs are calculated based on several factors. The considerations include the nature of the item, weight, size, distance, and so on. You may also be liable to pay taxes on your shipping as per applicable regulations. 
                            </p>
                            <p>
                                Our delivery partners always try to deliver your items at your convenience. You may even request a specific item to receive your order. Additionally, you may ask your delivery partner to leave your parcel with a neighbor. 
                            </p>

                            ${(() => {
                                switch (data.international_shipping) {
                                    case 'Yes':
                                        return `
                                            <h6>International Shipping</h6>
                                            <p>
                                                International shipping may attract additional fees and taxes. You are liable to clear all charges to ensure a smooth delivery.
                                            </p>
                                        `
                                    default:
                                        return ''
                                }
                            })()}
                        </div>
                        <div class="shipping-policy-section">
                            <h4>Exchanges</h4>
                            <p>
                                Our team is happy to entertain exchanges if the product is damaged or doesn’t meet the description. You can request us to exchange your order using the steps below:
                            </p>
                            ${(() => {
                                switch (data.how_long_does_customer_raise_exchange_request) {
                                    case 'We have a no exchange policy':
                                        return ''
                                    case 'We have a no exchange policy on certain products':
                                        return ''
                                    default:
                                        return `
                                            <p>
                                                ${data.how_long_does_customer_raise_exchange_request}
                                            </p>
                                        `
                                }
                            })()}
                        </div>
                        <div class="shipping-policy-section">
                            <h4>Returns</h4>
                            <p>
                                We are glad to help you return your product if it turns out to be damaged. You may also be able to request returns for items that don’t match the product description. Follow the steps below to file a return request:
                            </p>
                            ${(() => {
                                switch (data.how_long_does_customer_raise_return_request) {
                                    case 'We have a no return policy':
                                        return ''
                                    case 'We have a no return policy on certain products':
                                        return ''
                                    default:
                                        return `
                                            <p>
                                                ${data.how_long_does_customer_raise_return_request}
                                            </p>
                                        `
                                }
                            })()}
                            <p>
                                You can return or exchange your item for free if it is damaged or different from the description. However, in other cases, you may need to pay for the shipping charges. 
                            </p>
                            <p>
                                Additionally, we may take ${data.how_long_does_it_take_to_initiate_return_exchange} business days to process returns and exchanges.
                            </p>
                            <p>
                                Our team holds the ultimate right to decide whether to entertain your return or exchange request. We shall convey our decision and the cause regardless.
                            </p>
                            ${(() => {
                                switch (data.how_long_does_customer_raise_return_request) {
                                    case 'We have a no return policy':
                                        return ''
                                    case 'We have a no return policy on certain products':
                                        return ''
                                    case 'Return requests need to be generated by contacting our team directly':
                                        return `
                                            <p>
                                                Return requests need to be generated by contacting our team directly
                                            </p>
                                        `
                                    default:
                                        return `
                                            <p>
                                                Moreover, our return policy is valid for only ${data.how_long_does_customer_raise_return_request} days of receiving your delivery. 
                                            </p>
                                        `
                                }
                            })()}
                        </div>
                        <div class="shipping-policy-section">
                            <h4>Misc</h4>

                            <h6>Affiliate Program</h6>
                            ${(() => {
                                switch (data.affiliate_program) {
                                    case 'No':
                                        return `
                                            <p>
                                                We don’t have an affiliate program at the moment. You can always check back later.
                                            </p>
                                        `
                                    default:
                                        return `
                                            <p>
                                                We are glad to offer an affiliate program with attractive commissions. You can find the details of the program on our website. You can also get in touch with us for more information.
                                            </p>
                                        `
                                }
                            })()}

                            <h6>Physical Store</h6>
                            ${(() => {
                                switch (data.physical_store) {
                                    case 'No':
                                        return `
                                            <p>
                                                We do not have a physical store. You can buy from us online for a great shopping experience.
                                            </p>
                                        `
                                    default:
                                        return `
                                            <p>
                                                Our physical outlet is located at ${data.physical_store}
                                            </p>
                                        `
                                }
                            })()}

                            <h6>Warranty</h6>
                            ${(() => {
                                switch (data.warranty) {
                                    case 'No':
                                        return `
                                            <p>
                                                No, we don’t offer warranties.
                                            </p>
                                        `
                                    case 'We offer a warranty on specific products':
                                        return `
                                            <p>
                                                Selected products come with warranties. Find the details on the product page.
                                            </p>
                                        `
                                    default:
                                        return `
                                            <p>
                                                Our products carry warranties for complete peace of mind. You can find information on warranty on the product page.
                                            </p>
                                        `
                                }
                            })()}
                        </div>
                    `
        $('.preview-content').html(template)

        $('.shipping_policy_template').html(template)
    }
})