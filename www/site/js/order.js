
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
        resetProducts();
    }
    function isSelected(tile) {
        return tile.hasClass(selected);
    }

    function select(tile) {
        tile.addClass(selected);
        updateCheckbox(tile.find("input"), true);
        addProduct(tile.find("input"));
    }

    function deselect(tile) {
        tile.removeClass(selected);
        updateCheckbox(tile.find("input"), false);
        removeProduct(tile.find("input"));
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

    function updateCheckbox(box, value) {
        box.prop(checked, value);
    }

    function deselectAccessories(tileName) {
        $("." + tileName).find(".product").each(function() {
            updateCheckbox($(this).find("input"), false);
        }).removeClass("selected");
    }

    function updateProductTile(product) {
        isSelected(product) ? deselect(product) : select(product);
    }

    function updateCartProducts() {
        $("#total").load("index.php?m=kiosk&aAct=getTotal&IDs=" + products + "&pID=" + mainCourse.id);
    }

    $(".accessories .product").click(function() {
        updateProductTile($(this));
        updateCartProducts();
    });

    $(mainSelector).click(function() {
        var mainTile = $(this),
            tileName = getTileClass(mainTile),
            siblings = mainTile.siblings("a");
            
        if(isSelected(mainTile)){
            deselect(mainTile);
            mainCourse = {"tileName": "", "id" : 0};
            hideAccessories(tileName);
            deselectAccessories(getTileClass(mainTile));
            $("#orderSubmit").hide();
            resetProducts();
        }
        else if (isSelected(siblings)) {
            mainCourse = {"tileName": tileName, "id" : mainTile.find("input").attr("value")};
            select(mainTile);
            deselect(siblings);
            deselectAccessories(getTileClass(siblings));
            showAccessories(tileName);
            $("#orderSubmit").show();
            resetProducts();
        }
        else
        {
            mainCourse = {"tileName": tileName, "id" : mainTile.find("input").attr("value")};
            select(mainTile);
            showAccessories(tileName);
            $("#orderSubmit").show();
        }
        updateCartProducts();
    });

    function addProduct(product) {
        var value = product.attr("value");
        if (value != mainCourse.id) {
            products.push(product.attr("value"));
        }
    }

    function removeProduct(product) {
        var value = product.attr("value");
        if (value != mainCourse.id) {
            var index = products.indexOf(product);
            products.splice(index, 1);
        }
    }

    function resetProducts() {
        products = [];
    }
});
