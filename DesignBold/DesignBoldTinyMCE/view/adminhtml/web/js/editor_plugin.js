(function () {
    tinymce.create('tinymce.plugins.DesignBold_DesignBoldTinyMCE', {
        /**
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init: function (ed, url) {
            var t = this;
            t.editor = ed;
            tinymce.DOM.loadCSS(ed.settings.magentoPluginsOptions.DesignBold_DesignButton.css);
            ed.addCommand('mceButtonDesignBold', t._displayTool, t);
            ed.addButton('DesignBold_DesignButton', {
                title: 'Image design',
                tooltip: 'DesignBold image design',
                cmd: 'mceButtonDesignBold',
                image : url + "/img/icon.svg"
            });
            var scriptLoader = new tinymce.dom.ScriptLoader();
            scriptLoader.add(ed.settings.magentoPluginsOptions.DesignBold_DesignButton.js);
            scriptLoader.loadQueue();
        },

        _displayTool: function () {
            DBSDK.startOverlay();
        }
    });

    // Register plugin
    tinymce.PluginManager.add('DesignBold_DesignButton', tinymce.plugins.DesignBold_DesignBoldTinyMCE);
})();