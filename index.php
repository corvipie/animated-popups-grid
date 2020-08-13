<html>
<head>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        jQuery(document).ready(function ($) {

            let gridItemHandler = (function () {

                // variables
                const ITEM_CONTAINER_ID = '#item-container';
                const PANEL_CONTAINER_ID = '#panel-container';
                const EXPANDED_PANEL_POSITIONS = {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                }

                // functions
                const activatePanel = function (item) {
                    let item_id = getElementDataId(item);
                    let active_panel = $(PANEL_CONTAINER_ID + ' .item[data-item=' + item_id + ']');
                    let item_positions = getItemPositions(item);

                    showPanel(active_panel, item_positions);
                    setTimeout(expandPanel, 10, active_panel);

                    if (item.attr('id') !== undefined && item.attr('id') !== "" && window.location.hash != '#' + item.attr('id')) {
                        window.location.hash = '#' + item.attr('id');
                    }
                }

                const deactivatePanel = function (active_panel) {
                    let panel_id = getElementDataId(active_panel);
                    let active_item = $(ITEM_CONTAINER_ID + ' .item[data-item=' + panel_id + ']');
                    let item_positions = getItemPositions(active_item);

                    collapsePanel(active_panel, item_positions);
                    setTimeout(hidePanel, 1000);

                    window.location.hash = '';
                }

                const getElementDataId = function (item) {
                    return item.data('item');
                }

                const getItemPositions = function (item) {
                    let top_position = item.offset().top;
                    let left_position = item.offset().left;
                    let bottom_position = window.innerHeight - (top_position + item.outerHeight());
                    let right_position = window.innerWidth - (left_position + item.outerWidth());

                    return {
                        top: top_position,
                        right: right_position,
                        bottom: bottom_position,
                        left: left_position
                    };
                }

                const showPanel = function (active_panel, item_positions) {
                    $(PANEL_CONTAINER_ID).show();
                    active_panel.css(item_positions);
                    active_panel.show();
                }

                const hidePanel = function () {
                    $(PANEL_CONTAINER_ID).hide();
                    $(PANEL_CONTAINER_ID).children().hide();
                }

                const expandPanel = function (active_panel) {
                    active_panel.css(EXPANDED_PANEL_POSITIONS);
                }

                const collapsePanel = function (active_panel, item_positions) {
                    active_panel.css(item_positions);
                }

                // Public API
                return {
                    activatePanel: activatePanel,
                    deactivatePanel: deactivatePanel,
                };
            })();


            $('.item').on('click', function () {
                if ($(this).parent().hasClass('container')) {
                    let clicked_item = $(this);
                    gridItemHandler.activatePanel(clicked_item);
                }
            });

            $('.close-pop-up').on('click', function () {
                let active_panel = $(this).parent();
                gridItemHandler.deactivatePanel(active_panel);
            });

            if (location.hash && location.hash.length) {
                var hash = decodeURIComponent(location.hash.substr(1));

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $('#' + hash).offset().top
                });

                let clicked_item = $('#' + hash);
                gridItemHandler.activatePanel(clicked_item)
            }

            /*
                        const activateItem = function (item) {
                            let top_position = item.offset().top;
                            let left_position = item.offset().left;
                            let bottom_position = window.innerHeight - (top_position + item.outerHeight());
                            let right_position = window.innerWidth - (left_position + item.outerWidth());

                            let item_id = item.data('item');
                            let active_item = $('#page-overlay .item[data-item=' + item_id + ']');

                            let styles = {
                                top: top_position,
                                right: right_position,
                                bottom: bottom_position,
                                left: left_position
                            };

                            $('#page-overlay').show();
                            active_item.css(styles);
                            active_item.show();

                            setTimeout(
                                function (active_item) {
                                    let styles = {
                                        top: 0,
                                        right: 0,
                                        bottom: 0,
                                        left: 0
                                    };
                                    active_item.css(styles);
                                }, 10, active_item);

                            if (item.attr('id') !== undefined && item.attr('id') !== "") {
                                window.location.hash = '#' + item.attr('id');
                            }
                        }

                        const deactivateItem = function (active_item) {
                            window.location.hash = '';

                            $('#page-overlay').hide();
                            $('#page-overlay .item').hide();
                        }

                        if (location.hash && location.hash.length) {
                            var hash = decodeURIComponent(location.hash.substr(1));

                            // Using jQuery's animate() method to add smooth page scroll
                            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                            $('html, body').animate({
                                scrollTop: $('#' + hash).offset().top
                            });

                            let obj = $('#' + hash);
                            activateItem(obj);
                        }


                        $('.item').on('click', function () {
                            if ($(this).parent().hasClass('container')) {
                                let obj = $(this);
                                activateItem(obj);
                            }
                        });

                        $('.close-pop-up').on('click', function () {
                            let active_item = $(this);
                            deactivateItem(active_item);
                        });

             */
        });
    </script>

    <style>
        .container {
            height: 100%;
            display: grid;
        / / grid-template-columns: repeat(auto-fill, minmax(200 px, 1 fr));
            grid-gap: 1rem;
            grid-template-columns: repeat(2, 1fr) 200px 20%;
            grid-template-rows: 200px 30% 1fr;
            grid-template-areas:
    "header header header header"
    "main main . sidebar"
    "footer footer footer footer";
        }

        .item {
            background-color: lightblue;
        }

        .item-a {
            grid-area: header;
            background-color: green;
        }

        .item-b {
            grid-area: main;
            background-color: blue;
        }

        .item-c {
            grid-area: sidebar;
            background-color: red;
        }

        .item-d {
            grid-area: footer;
            background-color: purple;
        }

        #panel-container {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            display: none;
            //background-color: rgba(0, 0, 0, 0.8);
        }

        #panel-container .item {
            display: none;
            position: absolute;
            //background-color: rgba(255, 255, 255, 0.8);
            transition: all 1s;
        }
    </style>


</head>
<body>

<section id="item-container" class="container">
    <div id="erste-kachel" data-item="1" class="item item-a">one</div>
    <div id="zweite-kachel" data-item="2" class="item item-b">two</div>
    <div id="plumpsklo" data-item="3" class="item item-c">three</div>
    <div id="oma" data-item="4" class="item item-d">four</div>
</section>

<div id="panel-container">
    <div data-item="1" class="item item-a">one active!!
        <div class="close-pop-up">SCHLIESSEN X</div>
    </div>
    <div data-item="2" class="item item-b">two active!!
        <div class="close-pop-up">SCHLIESSEN X</div>
    </div>
    <div data-item="3" class="item item-c">three active!!
        <div class="close-pop-up">SCHLIESSEN X</div>
    </div>
    <div data-item="4" class="item item-d">four active!!
        <div class="close-pop-up">SCHLIESSEN X</div>
    </div>
</div>

</body>
</html>
