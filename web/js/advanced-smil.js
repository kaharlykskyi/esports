/**
 - This is jQuery plugin declaration for points per game graph
 - @html: ./html-component/player_stats.html
 - @deps: jQuery, Chartist.js
 - @using: ./js/main.js
 - @author torbara (https://themeforest.net/user/torbara)
 - */

(function ($, Chartist) {

    "use strict";

    $.fn.advancesmill = function (labels, series, low, legendNames, clickable, position) {

        var $el = $(this);

        if ($el.length === 0) {
            throw new Error('Advancesmill: target element not found');
        }

        var id = $el.attr('id');


        $(this).on('visible', function () {
            var chart = Chartist.Line('#' + id, {
                labels: labels,
                series: series
            }, {
                low: low,
                plugins: [
                    Chartist.plugins.legend({
                        legendNames: legendNames,
                        clickable: clickable === undefined ? true : clickable,
                        position: position
                    })
                ]

            });

            var seq = 0,
                    delays = 80,
                    durations = 500;

// Once the chart is fully created we reset the sequence
            chart.on('created', function () {
                seq = 0;
            });

// On each drawn element by Chartist we use the Chartist.Svg API to trigger SMIL animations
            chart.on('draw', function (data) {
                seq++;

                if (data.type === 'line') {
                    // If the drawn element is a line we do a simple opacity fade in. This could also be achieved using CSS3 animations.
                    data.element.animate({
                        opacity: {
                            // The delay when we like to start the animation
                            begin: seq * delays + 1000,
                            // Duration of the animation
                            dur: durations,
                            // The value where the animation should start
                            from: 0,
                            // The value where it should end
                            to: 1
                        }
                    });
                } else if (data.type === 'label' && data.axis === 'x') {
                    data.element.animate({
                        y: {
                            begin: seq * delays,
                            dur: durations,
                            from: data.y + 100,
                            to: data.y,
                            // We can specify an easing function from Chartist.Svg.Easing
                            easing: 'easeOutQuart'
                        }
                    });
                } else if (data.type === 'label' && data.axis === 'y') {
                    data.element.animate({
                        x: {
                            begin: seq * delays,
                            dur: durations,
                            from: data.x - 100,
                            to: data.x,
                            easing: 'easeOutQuart'
                        }
                    });
                } else if (data.type === 'point') {
                    data.element.animate({
                        x1: {
                            begin: seq * delays,
                            dur: durations,
                            from: data.x - 10,
                            to: data.x,
                            easing: 'easeOutQuart'
                        },
                        x2: {
                            begin: seq * delays,
                            dur: durations,
                            from: data.x - 10,
                            to: data.x,
                            easing: 'easeOutQuart'
                        },
                        opacity: {
                            begin: seq * delays,
                            dur: durations,
                            from: 0,
                            to: 1,
                            easing: 'easeOutQuart'
                        }
                    });
                } else if (data.type === 'grid') {
                    // Using data.axis we get x or y which we can use to construct our animation definition objects
                    var pos1Animation = {
                        begin: seq * delays,
                        dur: durations,
                        from: data[data.axis.units.pos + '1'] - 30,
                        to: data[data.axis.units.pos + '1'],
                        easing: 'easeOutQuart'
                    };

                    var pos2Animation = {
                        begin: seq * delays,
                        dur: durations,
                        from: data[data.axis.units.pos + '2'] - 100,
                        to: data[data.axis.units.pos + '2'],
                        easing: 'easeOutQuart'
                    };

                    var animations = {};
                    animations[data.axis.units.pos + '1'] = pos1Animation;
                    animations[data.axis.units.pos + '2'] = pos2Animation;
                    animations.opacity = {
                        begin: seq * delays,
                        dur: durations,
                        from: 0,
                        to: 1,
                        easing: 'easeOutQuart'
                    };

                    data.element.animate(animations);
                }
            });

// For the sake of the example we update the chart every time it's created with a delay of 10 seconds
            chart.on('created', function () {
                if (window.__exampleAnimateTimeout) {
                    clearTimeout(window.__exampleAnimateTimeout);
                    window.__exampleAnimateTimeout = null;
                }
                //window.__exampleAnimateTimeout = setTimeout(chart.update.bind(chart), 12000);
            });
        });

        $(this).showVisible();




    };

})(jQuery, Chartist);


