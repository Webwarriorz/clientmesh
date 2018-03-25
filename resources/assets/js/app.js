/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(document).ready(function () {
    $('#search').keyup(function () {
        searchTable($(this).val());
    });

    function searchTable(value) {

        // Filter only the rows
        $("#clients tr[data-hide='true']").each(function () {
            var found = 'false';

            $(this).each(function () {

                var selector = $("[data-type='name'],[data-type='address']", this);

                if (selector.text().toLowerCase().indexOf(value.toLowerCase()) >= 0) {
                    found = 'true';
                }
            });

            if (found == 'true') {
                $(this).show();
            }
            else {
                $(this).hide();
            }
        });

        // Show/Hide/Update the alphabet characters
        $("#clients tr.character").each(function () {

            var character = $(this).data("character");

            var resultsCounter = $("[data-parent-character=" + character + "]:visible").length;

            // Update the counters
            $("[data-character-counter-id=" + character + "]").text(resultsCounter);

            // Show / Hide the alphabet character rows
            if($("[data-parent-character=" + character + "]").is(':visible')){
                $(this).show();
            } else {
                $(this).hide();
            }

        });
    }
});