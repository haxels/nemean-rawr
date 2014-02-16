
var Nemean = Nemean || {};

    Nemean.order =(function($){
    var selected = "selected",
        checked = "checked",
        mainSelector = "#mainProducts .product",
        mainCourse = {"tileName": "", "id" : 0},
        products = [];

    Nemean.order.reset = function() {
        $(".product").removeClass("selected");
        $("input[type=checkbox]").attr("checked", false);
        hideAccessories(mainCourse.tileName);
    }
    function isSelected(tile) {
        return tile.hasClass(selected);
    }

    function select(tile) {
        tile.addClass(selected);
        updateCheckbox(tile.find("input"));
        if (tile.find("input").attr("value") != mainCourse.id && mainCourse.id != 0) {
            products.push(tile.find("input").attr("value"));
        }
    }

    function deselect(tile) {
        tile.removeClass(selected);
        updateCheckbox(tile.find("input"));
        if (tile.find("input").attr("value") != mainCourse.id) {
            removeProduct(tile.find("input").attr("value"));
        }
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

    function deselectAccessories(tileName) {
        $("." + tileName).find(".product").each(function() {
            $(this).find("input").attr(checked, false);
        }).removeClass("selected");
        products = [];
    }

    function updateProductTile(product) {
        isSelected(product) ? deselect(product) : select(product);
    }

    function removeProduct(product) {
        var index = products.indexOf(product);
        products.splice(index, 1);
    }

    function updateCartProducts() {
        $("#total").load("index.php?m=kiosk&aAct=getTotal&IDs=" + products + "&pID=" + mainCourse.id);
    }

    $(".accessories .product").click(function() {
        var product = $(this);
        updateProductTile(product);
        updateCartProducts();
    });

    $(mainSelector).click(function() {
        var mainTile = $(this),
            tileName = getTileClass(mainTile),
            siblings = mainTile.siblings("a");
            
        if(isSelected(mainTile)){
            deselect(mainTile);
            hideAccessories(tileName);
            mainCourse = {"tileName": "", "id" : 0};
            products = [];
            deselectAccessories(getTileClass(mainTile));
            $("#orderSubmit").hide();
        }
        else if (isSelected(siblings)) {
            select(mainTile);
            deselect(siblings);
            showAccessories(tileName);
            mainCourse = {"tileName": tileName, "id" : mainTile.find("input").attr("value")};
            products = [];
            $("#orderSubmit").show();
        }
        else
        {
            select(mainTile);
            showAccessories(tileName);
            mainCourse = {"tileName": tileName, "id" : mainTile.find("input").attr("value")};
            $("#orderSubmit").show();
        }
        updateCartProducts();
        deselectAccessories(getTileClass(siblings));
    });
});
