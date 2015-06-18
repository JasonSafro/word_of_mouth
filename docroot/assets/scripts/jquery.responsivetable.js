(function ($) {
    var defaults, w, rt = 'responsiveTable', tableStatic, tableStaticRow, rowCells, rowCellsClone;

    $.fn.responsiveTable = function (options) {
        w = $(window);
        defaults = {
            staticColumns: 1,
            scrollRight: true,
            scrollHintEnabled: true,
            scrollHintDuration: 2000
        };
        options = $.extend(defaults, options);

        function resizeResponsiveTable(table) {
            if (table.parent().hasClass('overflowContainer')) {
                var oc, rtc, rtcw, scw;
                // Hide the table while working out the container sizes
                table.hide();
                // Calculate the container width
                oc = table.parent();
                rtc = oc.parent();
                rtcw = rtc.innerWidth();
                scw = rtc.find('.staticContainer').outerWidth();
                // Set the overflow container width
                oc.width(rtcw - scw - 1);
                // Show the table again
                table.show();
                // Scroll right so the right hand side is displayed by default
                if (options.scrollRight) {
                    oc.scrollLeft(table.width());
                }
            }
        }

        function setupScrollHint(table, offset) {
            // Display a hint to the user that the table contents are scrollable
            var uid = rt + 'UiHint';
            if ($('#' + uid).length == 0) {
                uiHint = $('<div id="' + uid + '">&lt;&lt;  Scroll table left and right  &gt;&gt;</div>');
                $('body').prepend(uiHint);
                var ht = w.height() / 2;
                if (offset.top > 0 && table.height() > 0) {
                    ht = offset.top + (table.height() * 0.4);
                }
                uiHint.css({
                    "position": "absolute",
                    "z-index": 1000000,
                    "padding": "0.5em",
                    "background-color": "#888",
                    "color": "#eee",
                    "font-size": "1.1em",
                    "border-radius": "0.6em"
                }).css({
                    "top": ht,
                    "left": (w.width() / 2) - (uiHint.width() / 2)
                });
            }
            setTimeout('$("#' + uid + '").hide();', options.scrollHintDuration);
        }

        function setResponsiveTable(table) {
            if (!table.parent().hasClass('overflowContainer')) {
                var tos = table.offset();
                table.wrap('<div class="' + rt + 'Container" style="overflow: hidden;" />');
                tableStatic = $('<table />');

                // Copy table attributes
                $.each(table[0].attributes, function (index, a) {
                    if (a.name !== 'id') {
                        tableStatic.attr(a.name, a.value);
                    }
                });
                tableStatic.addClass(rt + 'Static');
                tableStatic.css('border-right', 'ridge');
                tableStatic.width(0);
                table.before(tableStatic);
                // Select direct child rows only, we don't want rows from nested tables
                table.find('> tr, > tbody > tr').each(function (i, element) {
                    tableStaticRow = $('<tr />');
                    // Set the height to the calculated height of the original row, the natural height of the cloned cells may be different
                    tableStaticRow.outerHeight($(element).outerHeight());
                    // Copy row attributes
                    $.each($(element)[0].attributes, function (index, a) {
                        if (a.name !== 'id') {
                            tableStaticRow.attr(a.name, a.value);
                        }
                    });
                    for (i = 0; i <= options.staticColumns; i++) {
                        // Clone the cells for configured number of columns
                        rowCells = $(element).find('> th:nth-child(' + i + '), > td:nth-child(' + i + ')');
                        rowCellsClone = rowCells.clone();
                        rowCells.css('display', 'none');
                        tableStaticRow.append(rowCellsClone);
                        tableStatic.append(tableStaticRow);
                    }
                });

                table.wrap('<div class="overflowContainer" style="float: left; overflow: scroll; overflow-y: hidden; " />');
                tableStatic.wrap('<div class="staticContainer" style="float: left;" />');

                if (options.scrollHintEnabled) {
                    setupScrollHint(table, tos);
                }
            }

            resizeResponsiveTable(table);
        }

        function unsetResponsiveTable(table) {
            if (table.parent().hasClass('overflowContainer')) {
                $('.staticContainer').remove();
                table.unwrap().unwrap().find('tr').each(function (i, element) {
                    for (i = 0; i <= options.staticColumns; i++) {
                        $(element).find('th:nth-child(' + i + '), td:nth-child(' + i + ')').css('display', '');
                    }
                });
            }
        }

        function setupResponsiveTable(table) {
            // Detect overflow by checking the table width against that of its parent tree
            var ov = false;
            table.parents().each(function () {
                if (table.width() > $(this).width()) {
                    ov = true;
                    // break out of each
                    return (false);
                }
            });
            // Set or in set the responsive table
            if (ov) {
                setResponsiveTable(table);
            } else {
                unsetResponsiveTable(table);
            }
        }

        return this.each(function () {
            var $this = $(this);
            w.on('resize orientationchange', function () {
                setupResponsiveTable($this);
            });
            setupResponsiveTable($this);
        });
    };
})(jQuery); 