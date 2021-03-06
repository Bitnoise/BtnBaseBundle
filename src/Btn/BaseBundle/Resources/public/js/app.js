/* global PubSub, jQuery, Node, HTMLElement */
var BtnApp = (function (){
    'use strict';
     return {
        data: {
            debug: true
        },
        triggerEvent: function (state, input) {
            var statePrefixed = 'btn_admin.' + state;
            switch (typeof input) {
                case 'function':
                    PubSub.subscribe(statePrefixed, input);
                    break;
                case 'object':
                case 'undefined':
                    var parms = {context: this.tools.getContext(input)};
                    this.tools.log(statePrefixed, parms);
                    PubSub.publish(statePrefixed, parms);
                    break;
            }
        },
        init: function(input) {
            this.triggerEvent('init', input);
        },
        ready: function(input) {
            this.triggerEvent('ready', input);
        },
        refresh: function(input) {
            this.triggerEvent('refresh', input);
        },
    };
})();

// handy tools
BtnApp.tools = (function(){
    'use strict';
    return {
        log: function() {
            BtnApp.data.debug ? console.log.apply(console, arguments) : null;
        },
        warn: function() {
            BtnApp.data.debug ? console.warn.apply(console, arguments) : null;
        },
        error: function() {
            BtnApp.data.debug ? console.warn.error(console, arguments) : null;
        },
        isNode: function(o){
            return (typeof Node === 'object' ? o instanceof Node : o && typeof o === 'object' && typeof o.nodeType === 'number' && typeof o.nodeName==='string');
        },
        isElement: function(o){
            return (typeof HTMLElement === 'object' ? o instanceof HTMLElement : o && typeof o === 'object' && o !== null && o.nodeType === 1 && typeof o.nodeName==='string');
        },
        getContext: function(input) {
            if ('undefined' === typeof input) {
                return document;
            } else if (this.isElement(input)) {
                return input; // regulat input
            } else if (input.context) {
                return input.context; // object with context key
            } else if (1 === input.length && this.isElement(input[0])) {
                return input[0]; // probably one element jquery object
            } else {
                return document;
            }
        },
        findOnce: function(selector, context) {
            return jQuery(context || document).find('[' + selector + ']')
                .filter(':not([' + selector + '-selected])')
                .attr(selector + '-selected', true)
            ;
        }
    };
})();
