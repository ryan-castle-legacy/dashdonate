// For example on how to intiate graphs, or if you want to mess around with the data / style of these graphs, check the bottom of this panel.

(function ($) {

    $.fn.graphiq = function (options) {

        // Default options
        var settings = $.extend({
			data: {},
            subSet: false,
			colorLine: "#1db87f",
            subColorLine: "rgba(0, 0, 0, 0.15)",
            colorDot: "#1db87f",
            colorXGrid: "#7f7f7f",
            colorYGrid: "#7f7f7f",
            colorLabels: "#000000",
            colorUnits: "#000000",
            colorRange: "#000000",
            colorFill: "#1db87f",
            colorDotStroke: "#000000",
            dotStrokeWeight: 0,
            fillOpacity: 0.25,
            rangeOpacity: 0.5,
            dotRadius: 3,
            lineWeight: 2,
            yLines: true,
            dots: true,
            xLines: true,
            xLineCount: 5,
            fill: true,
            height: 100,
			fluidParent: null,
            minMax: false,
			currency: false,
        }, options);

		var values = [];
        var subSetValues = [];
        var entryDivision;
        var dataRange = settings.height + settings.dotRadius;
        var parent = this;
        var maxVal;
        var scaleFactor = settings.height / 100;
        var pathPoints = "";
		for (var key in settings.data) {
            values.push(settings.data[key]);
        }
		if (typeof settings.subSet == 'object') {
			for (var key in settings.subSet) {
	            subSetValues.push(settings.subSet[key]);
	        }
		}
		if (parent.hasClass('dd_graph_main_data_currency')) {
			settings.currency = true;
		}

		if (settings.minMax == true) {
			parent.append(
	            '<div class="graphiq__graph-values"></div><div class="graphiq__graph-layout"><svg class="graphiq__graph" viewBox="0 0 960 '+ (settings.height + 10) +'" shape-rendering="geometricPrecision"><path fill="'+ settings.colorFill +'" style="opacity: '+ settings.fillOpacity +'" class="graphiq__fill-path" d="" stroke-width="0" stroke="#000" fill="cyan"/></svg><div class="graphiq__graph-key"></div></div>'
	        );
		} else {
			parent.append(
	            '<div class="graphiq__graph-layout"><svg class="graphiq__graph" viewBox="0 0 960 '+ (settings.height + 10) +'" shape-rendering="geometricPrecision"><path fill="'+ settings.colorFill +'" style="opacity: '+ settings.fillOpacity +'" class="graphiq__fill-path" d="" stroke-width="0" stroke="#000" fill="cyan"/></svg><div class="graphiq__graph-key"></div></div>'
	        );
		}

            if (settings.fluidParent) {
                this.closest(".col").css("overflow", "auto");
            }
        parent.addClass('graphiq');

        var graph = this.find(".graphiq__graph");

		// Get data from table
        for (var key in settings.data) {
            this.find(".graphiq__graph-key").append('<div class="key" style="color: ' + settings.colorLabels + '">' + key + "</div>");
        }

		maxVal = Math.max.apply(Math, values);
        maxSubVal = Math.max.apply(Math, subSetValues);

		if (maxSubVal > maxVal) {
			maxVal = maxSubVal;
		}

		if (settings.minMax == true) {
        	this.find('.graphiq__graph-values').append('<span style="color: ' + settings.colorRange + '; opacity: ' + settings.rangeOpacity + '">' + maxVal + '</span><span style="color: ' + settings.colorRange + '; opacity: ' + settings.rangeOpacity + '" >0</span>');
		}


        // Set even spacing in the graph depending on amount of data

        var width = parent.find(".graphiq__graph-layout").width();

        if (settings.xLines) {
            unitLines(width, maxVal);
        }

        layoutGraph(width, true);

        $(window).on("resize", function () {
            pathPoints = "";
            width = parent.find(".graphiq__graph-layout").width();
            layoutGraph(width, false);
        });

       // buildFillPath();

        function percentageOf(max, current) {
            return (current / max * 100) * scaleFactor;
        }

        function layoutGraph(width, initial) {
			// Plot sub data graph
			if (subSetValues.length > 0) {
				graph.attr({
	                viewBox: "0 0 " + width + " " + (settings.height + 10),
	                width: width
	            });
	            entryDivision = width / (subSetValues.length - 1);
	            getCoordinates(initial, entryDivision, true);
			}
			// Plot main data graph
			graph.attr({
                viewBox: "0 0 " + width + " " + (settings.height + 10),
                width: width
            });
            entryDivision = width / (values.length - 1);
            getCoordinates(initial, entryDivision, false);
        }

        function getCoordinates(initial, entryDivision, subset) {

			var dataPoints = values;
			// Check if subset
			if (subset == true) {
				dataPoints = subSetValues;
			}

            for (i = 0; i < dataPoints.length; i++) {

                var offset;

                if (i == 0) {
                    offset = (settings.dotRadius + (settings.dotStrokeWeight)) + 1;
                }

                 else if (i == dataPoints.length - 1) {
                    offset = ((settings.dotRadius + (settings.dotStrokeWeight )) * -1) - 1;
                } else {
                    offset = 0;
                }

                var lineOffset = i == dataPoints.length - 2 ? (settings.dotRadius + (settings.dotStrokeWeight)) / 2 : 0;

                let nextI = i + 1;
                let xAxis = (entryDivision * i) + offset;
                let xAxis2 = entryDivision * nextI;

                // console.log(offset);


                let yAxis = dataRange - percentageOf(maxVal, dataPoints[i]);

                let yAxis2 = dataRange - percentageOf(maxVal, dataPoints[nextI]);

                if (i == dataPoints.length - 1) {
                    yAxis2 = yAxis;
                    xAxis2 = xAxis;
                }

              pathPoints += " L " + xAxis + " " + yAxis;


                if (i == dataPoints.length - 1 && settings.fill) {
                    buildFillPath(pathPoints);
                }

                if (initial) {

                    if (settings.yLines) {

                    $(document.createElementNS("http://www.w3.org/2000/svg", "line"))
                        .attr({
                            class: "graphiq__y-division",
                            x1: xAxis,
                            y1: yAxis,
                            x2: xAxis,
                            y2: settings.height + 5,
                            stroke: settings.colorYGrid,
                            "stroke-dasharray": "5 6",
                            "stroke-width": 1
                        })
                        .prependTo(graph);

                    }

                    // Draw the line

					// Check if subset
					if (subset == true) {
	                    $(document.createElementNS("http://www.w3.org/2000/svg", "line"))
	                        .attr({
	                            class: "graphiq__line graphiq__line_subset",
	                            x1: xAxis ,
	                            y1: yAxis,
	                            x2: xAxis2 - lineOffset,
	                            y2: yAxis2 + (settings.dotStrokeWeight / 2),
	                            stroke: settings.subColorLine,
	                            "stroke-width": settings.lineWeight,
	                            "vector-effect": "non-scaling-stroke"
	                        }).appendTo(graph);
					} else {
						// Get graph container
						var cont = $(graph).closest('.dd_graph_main_data');
						// See if max progress for dialogs has been reached
						if (cont.attr('dd_graph_progress') != false && (i + 2) > parseInt(cont.attr('dd_graph_progress'))) {
							$(document.createElementNS("http://www.w3.org/2000/svg", "line"))
		                        .attr({
		                            class: "graphiq__line xxx",
		                            x1: xAxis ,
		                            y1: yAxis,
		                            x2: xAxis2 - lineOffset,
		                            y2: yAxis2 + (settings.dotStrokeWeight / 2),
		                            stroke: settings.colorLine,
		                            "stroke-width": 1,
									"stroke-dasharray": "6 4",
		                            "stroke-width": 1,
		                            "vector-effect": "non-scaling-stroke"
		                        }).appendTo(graph);
						} else {
							$(document.createElementNS("http://www.w3.org/2000/svg", "line"))
		                        .attr({
		                            class: "graphiq__line",
		                            x1: xAxis ,
		                            y1: yAxis,
		                            x2: xAxis2 - lineOffset,
		                            y2: yAxis2 + (settings.dotStrokeWeight / 2),
		                            stroke: settings.colorLine,
		                            "stroke-width": settings.lineWeight,
		                            "vector-effect": "non-scaling-stroke"
		                        }).appendTo(graph);
						}
					}

                    // Draw the circle

					// Check if subset
					if (subset == false) {
						// Get graph container
						var cont = $(graph).closest('.dd_graph_main_data');
						// See if max progress for dialogs has been reached
						if (cont.attr('dd_graph_progress') != false && (i + 1) > parseInt(cont.attr('dd_graph_progress'))) {
		                    $(document.createElementNS("http://www.w3.org/2000/svg", "circle"))
		                        .attr({
		                            class: "graphiq__graph-dot",
		                            cx: xAxis,
		                            cy: yAxis + (settings.dotStrokeWeight / 2),
		                            r: settings.dots ? settings.dotRadius : 0,
		                            fill: 'transparent',
		                            stroke: 'transparent',
		                            "stroke-width": settings.dotStrokeWeight,
		                            "data-value": dataPoints[i],
		                            "vector-effect": "non-scaling-stroke"
		                        })
		                        .appendTo(graph);
						} else {
							$(document.createElementNS("http://www.w3.org/2000/svg", "circle"))
		                        .attr({
		                            class: "graphiq__graph-dot",
		                            cx: xAxis,
		                            cy: yAxis + (settings.dotStrokeWeight / 2),
		                            r: settings.dots ? settings.dotRadius : 0,
		                            fill: settings.colorDot,
		                            stroke: settings.colorDotStroke,
		                            "stroke-width": settings.dotStrokeWeight,
		                            "data-value": dataPoints[i],
		                            "vector-effect": "non-scaling-stroke"
		                        })
		                        .appendTo(graph);
						}
					}


                    // Resize instead of draw, used in resize
                } else {

                    parent.find(".graphiq__graph-dot")
                        .eq(i)
                        .attr({
                            cx: xAxis,
                        });
                    parent.find(".graphiq__line")
                        .eq(i)
                        .attr({
                            x1: xAxis,
                            x2: xAxis2 - lineOffset,
                        });
                    parent.find(".graphiq__y-division")
                        .eq(dataPoints.length - i - 1)
                        .attr({
                            x1: xAxis,
                            x2: xAxis
                        });
                    parent.find(".graphiq__x-line").each(function () {
                        $(this).attr({
                            x2: width
                        });
                    });
                }
            }
        }

        function buildFillPath(pathPoints) {

          parent.find('.graphiq__fill-path').attr("d", "M  " + (4 + settings.dotStrokeWeight) + " " + (settings.height + 5 + settings.dotStrokeWeight) + pathPoints +  " L " + (width - settings.dotRadius - settings.dotStrokeWeight) + " " + (settings.height + 5 + settings.dotStrokeWeight))
        }

        function unitLines(width, maxVal) {
            // Draw the max line

            var iteration = 100 / (settings.xLineCount - 1);


                for (i=0; i < settings.xLineCount; i++) {

                        $(document.createElementNS("http://www.w3.org/2000/svg", "line"))
                        .attr({
                            class: "graphiq__x-line",
                            y1: iteration * i + (settings.dotRadius + settings.dotStrokeWeight),
                            x2: width,
                            y2: iteration * i +  (settings.dotRadius + settings.dotStrokeWeight),
                            stroke: settings.colorXGrid,
                            // "stroke-dasharray": "5 6",
                            "stroke-width": 1
                        })
                        .prependTo(graph);

                }

        }

        parent.hover(function (e) {
			// Count dialogs
			var dialogs = 0;

			// Check if labels are not shown
			if ($('.graphiq__value-dialog').length == 0) {
	            $(this).find('.graphiq__graph-dot').each(function (index) {
					// Increment dialog counter
					dialogs += 1;
					// Get graph container
					var cont = $(this).closest('.dd_graph_main_data');
					// See if max progress for dialogs has been reached
					if (cont.attr('dd_graph_progress') != false && dialogs > parseInt(cont.attr('dd_graph_progress'))) {
						return;
					}
					// Check if currency
					if (settings.currency == true) {
						// Add dialog
		                $('body').append('<span style="color: '+ settings.colorUnits +'" class="graphiq__value-dialog value-' + index + '">&pound' + parseFloat($(this).attr("data-value")).toFixed(2) + '</span>');
		                $('.value-' + index).css({
		                    top: $(this).position().top - 20,
		                    left: $(this).position().left - ($('.value-' + index).outerWidth() / 2) + 3
		                });
					} else {
						// Add dialog
		                $('body').append('<span style="color: '+ settings.colorUnits +'" class="graphiq__value-dialog value-' + index + '">' + $(this).attr("data-value") + '</span>');
		                $('.value-' + index).css({
		                    top: $(this).position().top - 20,
		                    left: $(this).position().left - ($('.value-' + index).outerWidth() / 2) + 3
		                });
					}
	            });
			}
        }, function(e) {
			// Check if not the label itself
			if ($(e.target).closest('svg').length === 0) {
            	$('.graphiq__value-dialog').remove();
			}
        });

    };

}(jQuery));
