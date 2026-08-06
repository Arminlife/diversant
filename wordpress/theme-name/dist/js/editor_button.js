(function() {
    tinymce.PluginManager.add('wdm_mce_button', function( editor, url ) {
        editor.addButton('wdm_mce_button', {
            text: '—',
            icon: false,
            onclick: function() {
                editor.insertContent('—');
            }
        });
    });
    tinymce.PluginManager.add('wdm_mce_button_1', function( editor, url ) {
        editor.addButton('wdm_mce_button_1', {
            text: '«',
            icon: false,
            onclick: function() {
                editor.insertContent('«');
            }
        });
    });
    tinymce.PluginManager.add('wdm_mce_button_2', function( editor, url ) {
        editor.addButton('wdm_mce_button_2', {
            text: '»',
            icon: false,
            onclick: function() {
                editor.insertContent('»');
            }
        });
    });
})();