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
            'dialog_event': $( '[action-special=block]' )
        }
    }

    $.extend( special.prototype, {
        init: function ( options ) {
            this._options = $.extend( this.options, options);

            //绑定时间
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

            var type = _options.dialog_event.attr( 'data-type'),
                name = _options.dialog_event.attr( 'data-name'),
                id = _options.dialog_event.attr( 'data-id');

            dialog_tpl( 'http://v3.heartphp.com/admin/menu/index', name, id, 500, 400);
            //console.log(type, name ,id)
        }
    } );

    w.special = new special();

})( jQuery,window );

//执行
jQuery(document).ready( function () {
    window.special.init( );
} );
