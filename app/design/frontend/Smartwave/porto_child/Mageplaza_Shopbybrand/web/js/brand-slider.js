/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license sliderConfig is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_Shopbybrand
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

define([
    'jquery',
    'mageplaza/core/owl.carousel'
], function ($) {
    'use strict';
    return function (config, element) {
        $(element).owlCarousel({
            loop: true,
            margin: 18,
            autoHeight: false,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            lazyLoad: true,
            dots: false,
            nav: true,
            navRewind: true,
            navText: ["<i class='fas fa-chevron-left'></i>","<i class='fas fa-chevron-right'></i>"],
            responsiveClass: true,
            responsive: {
                0: {items: 1},
                480: {items: 2},
                860: {items: 3},
                990: {items: 4},
                1290: {items: 5}
            }
        });
    };
});
