$(document).ready(function () {
    let step = $('.step')
    let backBtn = $('#back_btn')
    let nextBtn = $('#next_btn')
    let publishBtn = $('#publish_btn')
    let previewBtn = $('#preview_btn')
    let form = $('#shipping_policy_form')

    let data_answer = {
        official_location: '',
        how_to_change_order: '',
        days_to_process: '',
        contact_form: '',
        payment_method: '',
        supported_currencies: '',
        shipping_options: '',
        filing_exchange_request: '',
        return_process: '',
        return_processing_time: '',
        how_long_return_policy_last: '',
        affiliate_program: '',
        physical_store: '',
        warranty: '',
    }

    form.on('submit', function (e) {
        return false
    })

    generate_shipping_policy(data_answer)

    publishBtn.on('click', function () {
        console.log(data_answer)
        generate_shipping_policy(data_answer)
    })

    previewBtn.on('click', function () {
        console.log(data_answer)
        generate_shipping_policy(data_answer)
    })

    let currentStep = 0
    let totalSteps = step.length

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

    function toggle_show_hide_step(currentStep) {
        console.log(currentStep)
        step.eq(currentStep).removeClass('d-none').siblings().addClass('d-none')
        toggle_nav_current(currentStep)

        if (currentStep === 0) {
            backBtn.addClass('d-none')
            nextBtn.removeClass('d-none')
        } else if (currentStep === totalSteps - 1) {
            nextBtn.addClass('d-none')
            backBtn.removeClass('d-none')
        } else {
            backBtn.removeClass('d-none')
            nextBtn.removeClass('d-none')
        }
    }

    function toggle_nav_current(currentStep) {
        let dataNav = 0
        if (currentStep >= 0 && currentStep <= 4) dataNav = 0
        else if (currentStep >= 5 && currentStep <= 5) dataNav = 1

        $(`a[data-nav="${dataNav}"`).addClass('bg-white').siblings().removeClass('bg-white')
    }

    function progress(value) {
        $('#progress_bar').width(value + '%')
        $('#progress_bar').html(value + '%')
    }

    // question 1
    $('input[name="official_location"').on('click', function () {
        data_answer = {
            ...data_answer,
            official_location: $(this).val(),
        }
        if ($('#q_1_others').is(':checked')) {
            $('#q_1_others_text').removeClass('d-none')
        } else {
            $('#q_1_others_text').addClass('d-none')
        }
    })

    $('#q_1_others_text_input').on('keyup', function (e) {
        data_answer = {
            ...data_answer,
            official_location: e.target.value,
        }
        $('#q_1_others').val(e.target.value)
    })


    function generate_shipping_policy(data) {
        const template = `
                        <div>
                            <h1 class="mb-3 text-uppercase">Shipping Policy</h1>
                            <p>We are glad you chose us for your purchase. The following conditions define our
                                shipping policy for all orders and purchases made on the platform.</p>

                            <div class="shipping-policy-section">
                                <h2>Shipping Location</h2>
                                <p>We ship all orders from ${data.official_location}.</p>
                            </div>

                            <div class="shipping-policy-section">
                                <h2>Order Tracking</h2>
                                <p>You can view the status of your orders by visiting your account. The Order
                                    tab
                                    lets you view all your recent purchases. You can click on any current order
                                    to
                                    view their statuses.</p>
                            </div>
                            <div class="shipping-policy-section">
                                <h2>Modifying Your Order</h2>
                                <p>
                                    Our company is more than happy to allow you to change your orders. You can
                                    modify your orders by accessing the Order section in your account. Select
                                    the order you want to alter and ${data.how_to_change_order}.
                                </p>
                            </div>
                            <div class="shipping-policy-section">
                                <h2>Expected Delivery Time</h2>
                                <p>
                                    Expected delivery times are displayed on the product page. You can enter
                                    your PIN to find out how many days your items may take to reach you.
                                    Choosing different shipping options may impact the delivery time. We
                                    generally take ${data.days_to_process} working days to process and ship your
                                    orders.
                                </p>
                                <p>
                                    You can also view the expected delivery time when you pay for your order and
                                    check out. However, high volume may impact shipping times and cause delays.
                                </p>

                                <h4>Contact</h4>
                                <p>
                                    You can always contact us for any queries. We are available at
                                    ${data.contact_form}.
                                </p>
                            </div>
                            <div class="shipping-policy-section">
                                <h2>Payment</h2>
                                <p>
                                    We believe in flexibility and let you pay using several methods. You can
                                    pick your preferred method while paying for your order during checking out.
                                    We support ${data.payment_method}.
                                </p>
                                <p>
                                    Moreover, you can choose to pay in your preferred currencies. You will be
                                    able to change the currency to your choice during paying. We support the
                                    following currencies - ${data.supported_currencies}.
                                </p>

                                <h4>Payment Plans</h4>
                                <p>
                                    You can pay in affordable installments using our payment plans. The
                                    information about the plans is displayed when you check out. You will be
                                    able to compare your options and choose the right one.
                                </p>
                            </div>
                            <div class="shipping-policy-section">
                                <h2>Shipping Policy</h2>
                                <p>
                                    We pride ourselves on making deliveries simple and hassle-free. You can
                                    select your preferred shipping method from several options when you check
                                    out.
                                </p>
                                <p>
                                    Our team takes ${data.days_to_process} business days to process your orders. A high volume of purchases may delay processing. You will always be able to track the status of your order from your account.
                                </p>

                                <h4>Shipping Methods</h4>
                                <p>
                                    You can select the best shipping method for your needs when you order from our store. We offer the following shipping options:
                                </p>

                                ${data.shipping_options}

                                <h4>Shipping Costs</h4>
                                <p>
                                    Shipping costs are calculated based on several factors. The considerations include the nature of the item, weight, size, distance, and so on. You may also be liable to pay taxes on your shipping as per applicable regulations. 
                                </p>
                                <p>
                                    Our delivery partners always try to deliver your items at your convenience. You may even request a specific item to receive your order. Additionally, you may ask your delivery partner to leave your parcel with a neighbor. 
                                </p>

                                <h4>International Shipping</h4>
                                <p>
                                    International shipping may attract additional fees and taxes. You are liable to clear all charges to ensure a smooth delivery.
                                </p>
                            </div>
                            <div class="shipping-policy-section">
                                <h2>Exchanges</h2>
                                <p>
                                    Our team is happy to entertain exchanges if the product is damaged or doesn’t meet the description. You can request us to exchange your order using the steps below:
                                </p>
                                ${data.filing_exchange_request}
                            </div>
                            <div class="shipping-policy-section">
                                <h2>Returns</h2>
                                <p>
                                    We are glad to help you return your product if it turns out to be damaged. You may also be able to request returns for items that don’t match the product description. Follow the steps below to file a return request:
                                </p>
                                <p>
                                    ${data.return_process}
                                </p>
                                <p>
                                    You can return or exchange your item for free if it is damaged or different from the description. However, in other cases, you may need to pay for the shipping charges. 
                                </p>
                                <p>
                                    Additionally, we may take ${data.return_processing_time} business days to process returns and exchanges.
                                </p>
                                <p>
                                    Our team holds the ultimate right to decide whether to entertain your return or exchange request. We shall convey our decision and the cause regardless.
                                </p>
                                <p>
                                    Moreover, our return policy is valid for only ${data.how_long_return_policy_last} days of receiving your delivery. 
                                </p>
                            </div>
                            <div class="shipping-policy-section">
                                <h2>Misc</h2>

                                <h4>Affiliate Program</h4>
                                <p>

                                </p>

                                <h4>Physical Store</h4>
                                <p></p>

                                <h4>Warranty</h4>
                                <p></p>
                            </div>
                            <div class="shipping-policy-section"></div>
                        </div>
                    `
        $('.preview-content').html(template)

        $('#shipping_policy_template').html(template)
    }
})