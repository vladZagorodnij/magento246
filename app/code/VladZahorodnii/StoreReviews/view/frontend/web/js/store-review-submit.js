define([
    'jquery',
    'validation',
    'jquery-ui-modules/widget'
], function ($) {
    'use strict';

    $.widget('dv.storeReviewSubmit', {

        /**
         * Initialize
         */
        _init: function () {
            this._on(this.element, {
                submit: this.onSubmit.bind(this)
            })
        },

        onSubmit(event) {
            event.preventDefault();

            if (!this.element.validation('isValid')) {
                console.log('form is not valid!');

                return this;
            }

            console.log('form is valid? send Ajax!')
        }
    });

    return $.dv.storeReviewSubmit;
});
