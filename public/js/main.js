$.fn.masonryImagesReveal = function( $items ) {
    var msnry = this.data('masonry');
    var itemSelector = msnry.options.itemSelector;
    // hide by default
    $items.hide();
    // append to container
    this.append( $items );
    $items.imagesLoaded().progress( function( imgLoad, image ) {
        // get item
        // image is imagesLoaded class, not <img>, <img> is image.img
        var $item = $( image.img ).parents( itemSelector );
        // un-hide item
        $item.show();
        // masonry does its thing
        msnry.appended( $item );
    });

    return this;
};

// The page of images that we are on.
var currentPage = 0;

// The number of images to show on the page by default.
var perPage = 15;

var imagesType = 'recent';

var $imagesContainerElement = null;
var $imagesContainer = null;

var $loadingBar = null;

var loadingBarWaypoint;

var waypointInterval = null;

$(document).ready(function() {
    $imagesContainerElement = $('#imagesContainer');
    $loadingBar = $('#loadingBar');
    if ($imagesContainerElement.length > 0) {
        $imagesContainer = $imagesContainerElement.masonry({
            itemSelector: '.grid-item',
            columnWidth: 200
        });
    }
    initWaypoints();
});

function initWaypoints()
{
    loadingBarWaypoint = new Waypoint.Inview({
        element: $loadingBar,
        enter: function(direction) {
            loadNextPage();
        }
    });
    waypointInterval = setInterval(refreshWaypoints, 3000);
}

function refreshWaypoints()
{
    Waypoint.refreshAll();
}

function loadRecentImages(page, perPage, $element)
{
    return loadImages('fetch', page, perPage, $element);
}

function loadImages(method, page, perPage, $element)
{
    $loadingBar.addClass('active');
    var url = '/images/' + method + '/' + page + '/' + perPage;
    var data = {api_key: 'd23de45t56h4t3frrrer231232r'};
    $.get(url, data, function(data) {
        if (typeof data.photos != 'undefined') {
            var images = [];
            if (typeof data.photos.photo != 'undefined') {
                images = data.photos.photo;
            }
            appendImages(images, $element);
        }
    }, 'json');
    $loadingBar.removeClass('active');
}

function appendImages(images, $element)
{
    var html = '';

    images.forEach(function(image) {
        html += getImageHtml(image);
    });

    var $items = $(html);
    $element.masonryImagesReveal($items);

    refreshWaypoints();
}

function getImageHtml(image)
{
    var url = getImageProperty('url', image, true);

    var html = "<div class='image grid-item'>" +
        "<img src='" + url + "' />" +
        "</div>";

    return html;
}

function getImageProperty(propertyName, image, wildcardSearch)
{
    var result = null;

    if (wildcardSearch) {
        for (var prop in image) {
            // Skip loop if the property is from prototype
            if (!image.hasOwnProperty(prop)) continue;

            if (prop.indexOf(propertyName) == 0) {
                result = image[prop];
                break;
            }
        }
    } else {
        if (typeof image[propertyName] != 'undefined') {
            result = image[propertyName];
        }
    }

    return result;
}

function loadNextPage()
{
    currentPage++;
    switch (imagesType) {
        case 'recent':
            loadRecentImages(currentPage, perPage, $imagesContainer);
            break;

        default:
            console.log("Unhandled image type: " + imagesType);
            break;
    }
}