
var Nemean = Nemean || {};

    Nemean.order =(function($){
    var selected = "selected",
        checked = "checked",
        mainSelector = "#mainProducts .product";

    function isSelected(tile) {
        return tile.hasClass(selected);
    }

    function select(tile) {
        tile.addClass(selected);
        updateCheckbox(tile);
    }

    function deselect(tile) {
        tile.removeClass(selected);
        updateCheckbox(tile);
    }

    function showAccessories(tileName) {
        var tile = $(".accessories");
        tile.children().hide();
        $("."+tileName).fadeIn();
    }

    function hideAccessories(tileName) {
         $("."+tileName).fadeOut();
    }

    function getTileClass(tile) {
        return tile.attr("value");
    }

    function updateCheckbox(box) {
        box.attr(checked) ? box.attr(checked, false) : box.attr(checked, true);
    }

    function updateProductTile(product) {
        isSelected(product) ? deselect(product) : select(product);
    }

    $(".product").click(function() {
        var product = $(this);
        updateProductTile(product);
    });

    $(mainSelector).click(function() {
        var mainTile = $(this),
            tileName = getTileClass(mainTile),
            siblings = mainTile.siblings("a");

        if(isSelected(mainTile)){
            select(mainTile);
            deselect(siblings)
            showAccessories(tileName);
        }
        else {
            deselect(mainTile);
            hideAccessories(tileName);
        }
    });
});
