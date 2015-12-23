/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
define([
    'jquery',
    'mage/mage'
], function ($, mage) {
    'use strict';

    return function (config, element) {
        $(element).mage('validation', {
            errorPlacement: function (error, element) {
                    element.after(error);
            }
        });
    };
});
