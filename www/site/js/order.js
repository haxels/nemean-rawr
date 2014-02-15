
var Nemean = Nemean || {};

    Nemean.order =(function($){
    var selected = "selected",
        checked = "checked",
        mainSelector = "#mainProducts .product",
        mainCourse = {"tileName": "", "id" : 0},
        products = [];

    function isSelected(tile) {
        return tile.hasClass(selected);
    }

    function select(tile) {
        tile.addClass(selected);
        updateCheckbox(tile.find("input"));
        if (tile.find("input").attr("value") != mainCourse.id && mainCourse.id != 0) {
            products.push(tile.find("input").attr("value"));
            updateCartProducts();
        }
    }

    function deselect(tile) {
        tile.removeClass(selected);
        updateCheckbox(tile.find("input"));
        if (tile.find("input").attr("value") != mainCourse.id) {
            removeProduct(tile.find("input").attr("value"));
            updateCartProducts();
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

    function updateCartMainCourse() {
        $("#mainCourse").load("index.php?m=kiosk&aAct=getProduct&pID=" + mainCourse.id);
    }

    function updateCartProducts() {
        $("#accessories").load("index.php?m=kiosk&aAct=getProducts&IDs=" + products);
    }

    $(".accessories .product").click(function() {
        var product = $(this);
        updateProductTile(product);
    });

    $(mainSelector).click(function() {
        var mainTile = $(this),
            tileName = getTileClass(mainTile),
            siblings = mainTile.siblings("a");

        if(isSelected(mainTile)){
            deselect(mainTile);
            hideAccessories(tileName);
            mainCourse = {"tileName": "", "id" : 0};
            $("#cart").fadeOut(500);
            products = [];
            updateCartProducts();
        }
        else if (isSelected(siblings)) {
            select(mainTile);
            deselect(siblings);
            showAccessories(tileName);
            mainCourse = {"tileName": tileName, "id" : mainTile.find("input").attr("value")};
            products = [];
            updateCartProducts();
        }
        else
        {
            select(mainTile);
            showAccessories(tileName);
            mainCourse = {"tileName": tileName, "id" : mainTile.find("input").attr("value")};
            $("#cart").fadeIn(500);
        }
        updateCartMainCourse();
        deselectAccessories(getTileClass(siblings));
    });
});
