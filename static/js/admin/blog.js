define([
  'jquery-nos-appdesk'
], function($) {
    "use strict";
    return function(appDesk) {
        return {

            /**
             * Config variables
             */
            blognews : {
                namespace   : 'Nos\\BlogNews\\Blog',
                dir         : 'noviusos_blog',
                icon_name   : 'blog'
            }
        };
    };
});
