<html>
<head>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        jQuery(document).ready(function ($) {

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

        #page-overlay {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            display: none;
        / / background-color: rgba(0, 0, 0, 0.4);
        }

        #page-overlay .item {
            display: none;
            position: absolute;
        / / background-color: rgba(255, 255, 255, 0.8);
            transition: all 1s;
        }
    </style>


</head>
<body>

<section class="container">
    <div id="erste-kachel" data-item="1" class="item item-a">one</div>
    <div id="zweite-kachel" data-item="2" class="item item-b">two</div>
    <div id="plumpsklo" data-item="3" class="item item-c">three</div>
    <div id="oma" data-item="4" class="item item-d">four</div>
</section>

<div id="page-overlay">
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
