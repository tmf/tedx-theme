(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
require('./widgets.js');
},{"./widgets.js":2}],2:[function(require,module,exports){
;
(function ($) {
    $(document).ready(function () {
        /**
         *
         * @param $widget
         */
        var addService = function ($widget) {
            var data = $('form', $widget).serializeArray();
            data.push({
                name: 'action',
                value: 'get_service_template'
            });
            $.post(ajaxurl, $.param(data), function (response) {
                var $response = $(response),
                    $serviceContainer = $('.services', $widget);
                initializeSelect($('select', $response));
                if (!$serviceContainer.hasClass('ui-sortable')) {
                    initializeSortable($serviceContainer);
                }

                $serviceContainer
                    .append($response)
                    .sortable('refresh');
            }, 'html');
        };

        /**
         *
         * @param $service
         */
        var removeService = function ($service) {
            $service.remove();
        };

        /**
         *
         * @param $elements
         */
        var initializeSelect = function ($elements) {
            $elements.selectize({
                render: {
                    option: function (item, escape) {
                        var field_label = this.settings.labelField,
                            field_value = this.settings.valueField;
                        return '<div class="option"><i class="icon icon__' + item[field_value] + '"></i><span>' + item[field_label] + '</span></div>';
                    },
                    item: function (item, escape) {
                        var field_label = this.settings.labelField,
                            field_value = this.settings.valueField;
                        return '<div class="item"><i class="icon icon__' + item[field_value] + '"></i><span>' + item[field_label] + '</span></div>';
                    }
                }
            });
        };

        /**
         *
         * @param $serviceContainer
         */
        var initializeSortable = function ($serviceContainer) {
            $serviceContainer.sortable({
                items: " > li"
            });
        };

        /**
         *
         */
        var initializeWidgetComponents = function ($widget) {
            initializeSelect($('select', $widget));
            initializeSortable($('.services', $widget));
        };

        //
        initializeWidgetComponents($('.widget-liquid-right .widget-with-selects'));

        //
        $(document).on('widget-updated widget-added', function (e, $widget) {
            initializeWidgetComponents($widget);
        });

        //
        $('.widget-liquid-right')
            //
            .on('click', '.add-social-media-service', function (e) {
                addService($(this).closest('.widget'));
                e.preventDefault();
            })
            //
            .on('click', '.social-media-services .services .remove-service', function (e) {
                removeService($(this).closest('.service'));
            })
            .on('change', '.teaser-widget-options select', function(e){
                var newType = this.selectize.getValue(),
                    newClass = newType.length > 0 ? 'type-' + newType : '';
                $(this).closest('.teaser-widget-options')
                    .removeClass('type-alert type-calendar type-venue type-')
                    .addClass(newClass);
            });
    });
})(jQuery);
},{}]},{},[1]);
