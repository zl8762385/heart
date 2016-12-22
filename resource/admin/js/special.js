/**
 *  专题相关JS
 *
 * @copyright			(C) 2016 Heart
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
(function ( $, w) {
    var special = function () {
        //默认options
        this.options = {
            //碎片弹窗事件
            'dialog_event': $( '[action-special=block]' ),
            //编辑器类型url
            'editor_url': '',
            //文本框类型url
            'textarea_url': '',
            //数据类型url
            'datalist_url': '',
        }
    }

    $.extend( special.prototype, {
        init: function ( options ) {
            this._options = $.extend( this.options, options);

            //绑定事件
            this.bind();
        },
        bind: function () {
            var obj = { 'self': this };

            this._options.dialog_event.bind( 'click', obj, this.dialog );

        },
        //专题弹窗
        dialog: function ( d ) {
            var self = d.data.self,
                _options = self._options;

            console.log( _options )
            var type = _options.dialog_event.attr( 'data-type'),
                name = _options.dialog_event.attr( 'data-name'),
                id = _options.dialog_event.attr( 'data-id'),
                sid = _options.dialog_event.attr( 'data-sid'),
                url = '';

            //url
            switch( parseInt( type  ) ) {
                case 0:
                    //编辑器
                    url = _options.editor_url;
                    break;
                case 1:
                    //文本框
                    url = _options.textarea_url;
                    break;
                case 2:
                    url = _options.datalist_url;
                    break;
                    //数据列表
                    break;
            }
            if( url != '' ) {
                url += '?id='+id+'&sid='+sid;
            }

            //dialog
            dialog_tpl( url, name, id, 900, 600);
        }
    } );

    w.special = new special();

})( jQuery,window );
