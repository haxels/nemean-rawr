/**
 * Created with JetBrains PhpStorm.
 * User: Ragnar
 * Date: 05.08.12
 * Time: 15:13
 * To change this template use File | Settings | File Templates.
 */
jQuery.fn.reset = function(fn) {
    return fn ? this.bind("reset", fn) : this.trigger("reset");
};