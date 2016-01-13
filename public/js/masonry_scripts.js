/**
 * Append to the masonry library.
 * This adds a nice effect when adding items to the grid rather than having them just 'appear'.
 * @param $items
 * @returns {$}
 */
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
var perPage = 16;

// The type of request that is going to be made when loadNextPage() is called.
var imagesType = 'recent';

// The div that is acting as the masonry grid.
var $imagesContainer = null;

// The loading bar container div. Stored here on doc.ready because we set up a waypoint for it to trigger loadNextPage().
var $flickrLoadingBar = null;

// Stores the actual waypoint we create in case we need to manually clear it or something.
var flickrLoadingBarWaypoint;

// Stores the id of an interval used to 'refresh' the waypoint positions. This is needed because of the way we append data to the page.
var waypointInterval = null;

$(document).ready(function() {
    var $imagesContainerElement = $('#imagesContainer');
    $flickrLoadingBar = $('#flickrLoadingBar');
    if ($imagesContainerElement.length > 0) {
        $imagesContainer = $imagesContainerElement.masonry({
            itemSelector: '.grid-item',
            columnWidth: '.grid-sizer',
            gutter: '.gutter-sizer',
            percentPosition: true
        });
    }
    initWaypoints();
});

function initWaypoints()
{
    flickrLoadingBarWaypoint = new Waypoint.Inview({
        element: $flickrLoadingBar,
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
    var html = "";

    if (url != null) {
        html += "<div class='image grid-item'>" +
            "<img src='" + url + "' />" +
            "</div>";
    }

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