define([
    'jquery',
    'mage/translate',
    'Magento_Customer/js/customer-data',
    'mage/storage',
    'mage/url',
    'validation',
    'jquery-ui-modules/widget'
], function ($, $t, customerData, storage, urlBuilder) {
    'use strict';

    $.widget('vladZahorodnii.storeReviewSubmit', {
        options: {
            action: urlBuilder.build(`store_review/index/review`)
        },

        /**
         * Initialize
         */
        _init: function () {
            this.addEventListeners();
        },

        /**
         * addEventListeners
         */
        addEventListeners() {
            this._on(this.element, {
                submit: this.onSubmit.bind(this)
            })
        },

        /**
         * onSubmit
         * @param event
         * @returns {vladZahorodnii.storeReviewSubmit}
         */
        onSubmit(event) {
            event.preventDefault();

            if (!this.element.validation('isValid')) {
                throw new Error($t(`Form is not valid!`))
            }

            this.sendAjax();
        },

        sendAjax() {
            // return storage.post()
            let formData = new FormData($(this.element).get(0));

            return $.ajax({
                url: this.options.action,
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                type: 'post',
                beforeSend: this.beforeAjax.bind(this),
                error: this.onAjaxError.bind(this),
                success: this.onAjaxSuccess.bind(this),
                afterSend: this.afterAjax.bind(this)
            })
        },

        beforeAjax() {
            $('body').trigger('processStart');
        },

        onAjaxError(response) {
            this.showMessage(response.responseJSON.message ?? $t('Oops, something went wrong!'))
        },

        onAjaxSuccess(response) {
            this.showMessage($t('Your review was sent! Thank you!'), 'success');
        },

        afterAjax() {
            $('body').trigger('processStop');
        },

        showMessage(text='', type='error') {
            if (!text) return this;

            const section = customerData.get('message')() ?? {};
            const messages = section.messages ?? [];

            customerData.set('messages', {
                messages: [
                    ...messages,
                    {
                        text,
                        type
                    }
                ]
            })
        }
    });

    return $.vladZahorodnii.storeReviewSubmit;
});
