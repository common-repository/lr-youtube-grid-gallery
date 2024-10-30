(function() {
    tinymce.create('tinymce.plugins.lr.youtube', {
        init : function(ed, url) {
            ed.addButton('showUtube', {
                title : 'LR YouTube Grid Gallery',
                image : url + '/icon-youtube.png',
                onclick : function() {
                    tb_show("Insert LR YouTube Grid Gallery", url+"/../tinymce/lryg-tinymce-page.php?a=a&width=670&height=600");
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "LR YouTube Grid Gallery"
            };
        }
    });
    tinymce.PluginManager.add('chrUtube', tinymce.plugins.lr.youtube);
})();