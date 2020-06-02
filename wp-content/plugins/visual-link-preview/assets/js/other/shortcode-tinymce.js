(function() {
    tinymce.PluginManager.add('visuallinkpreview', function(editor, url) {
        function replaceShortcodes(content) {
            var shortcode_id = 0;
            return content.replace(/\[visual-link-preview ([^\]]*)\]/g, function(match) {
                shortcode_id++;
                return html( match, shortcode_id );
            });
        }

        function html(data, shortcode_id) {
            var encoded = data.match(/encoded="([^"]*)/i);
            
            if(!encoded) {
                return data;
            }

            var original_shortcode = window.encodeURIComponent(data);
            var link = VisualLinkPreview.admin.decodeLink(encoded[1]);

            var preview = '<div class="vlp-shortcode" style="display: block; cursor: pointer; margin: 5px; padding: 10px; border: 1px solid #999;" contentEditable="false" data-vlp-encoded="' + encoded[1] + '" data-vlp-shortcode-id="' + shortcode_id + '" data-vlp-shortcode="' + original_shortcode + '" data-mce-resize="false" data-mce-placeholder="1">';
            if(link.image_url) {
                preview += '<span contentEditable="false" style="display: inline-block; float: left; margin: 0 10px 0 0;"><img src="' + link.image_url + '" style="width: 100px; height: auto;"></span>';
            }
            preview += '<span contentEditable="false" style="font-weight: bold;">' + link.title + '</span><br/>';
            preview += '<span contentEditable="false">' + link.summary + '</span>';
            preview += '<span contentEditable="false" style="display: block; clear: both; height: 1px; line-height: 1px;">&nbsp;</span>';
            preview += '</div>';

            return preview;
        }

        function restoreShortcodes(content) {
            function getAttr(str, name) {
                name = new RegExp(name + '=\"([^\"]+)\"').exec(str);
                return name ? window.decodeURIComponent(name[1]) : '';
            }

            content = content.replace(/<p><span class="vlp-(?=(.*?span>))\1\s*<\/p>/g, '');
            content = content.replace(/<span class="vlp-.*?span>/g, '');

            return content.replace(/(?:<p(?: [^>]+)?>)*(<div [^>]+>[\s\S]*?<\/div>)(?:<\/p>)*/g, function(match, div) {
                var data = getAttr(div, 'data-vlp-shortcode');

                if (data) {
                    return '<p>' + data + '</p>';
                }

                return match;
            });
        }

        editor.on('mouseup', function(event) {
            var dom = editor.dom,
                node = event.target,
                shortcode = jQuery(node).hasClass('vlp-shortcode') ? jQuery(node) : jQuery(node).parents('.vlp-shortcode');

            if (event.button !== 2 && shortcode.length > 0) {
                var encoded = jQuery(shortcode).data('vlp-encoded');
                var shortcode_id = jQuery(shortcode).data('vlp-shortcode-id');

                VisualLinkPreview.admin.modal.open(editor.id, {
                    encoded: encoded,
                    shortcode_id: shortcode_id
                });
            }
        });

        editor.on('BeforeSetContent', function(event) {
            event.content = event.content.replace(/(<p>)?\s*<span class="vlp-placeholder" data-mce-contenteditable="false">&nbsp;<\/span>\s*(<\/p>)?/gi,'');
            event.content = event.content.replace(/^(\s*<p>)(\s*\[visual-link-preview)/, '$1<span class="vlp-placeholder" contentEditable="false">&nbsp;</span>$2');
            event.content = replaceShortcodes(event.content);
        });

        editor.on('PostProcess', function(event) {
            if (event.get) {
                event.content = restoreShortcodes(event.content);
            }
        });
    });
})();
