
var Nemean = Nemean || {};

    Nemean.order =(function($){
    var selected = "selected",
        checked = "checked",
        mainSelector = "#mainProducts .product",
        mainCourse = {"tileName": "", "id" : 0};

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
        updateCheckbox(tile.find("input"), true);
    }

    function deselect(tile) {
        tile.removeClass(selected);
        updateCheckbox(tile.find("input"), false);
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
    });

    $(mainSelector).click(function() {
        var mainTile = $(this),
            tileName = getTileClass(mainTile),
            siblings = mainTile.siblings("a");
            
        if(isSelected(mainTile)){
            deselect(mainTile);
            hideAccessories(tileName);
            mainCourse = {"tileName": "", "id" : 0};
            deselectAccessories(getTileClass(mainTile));
            $("#orderSubmit").hide();
        }
        else if (isSelected(siblings)) {
            select(mainTile);
            deselect(siblings);
            deselectAccessories(getTileClass(siblings));
            showAccessories(tileName);
            mainCourse = {"tileName": tileName, "id" : mainTile.find("input").attr("value")};
            $("#orderSubmit").show();
        }
        else
        {
            select(mainTile);
            showAccessories(tileName);
            mainCourse = {"tileName": tileName, "id" : mainTile.find("input").attr("value")};
            $("#orderSubmit").show();
        }
    });

    $(".product").click(function() {
       updateCartProducts();
    });
});
