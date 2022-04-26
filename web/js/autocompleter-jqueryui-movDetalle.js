(function ($) {
    'use strict';
    $.fn.autocompleter = function (options) {
        var settings = {
            url_list: '',
            url_get:  '',
            min_length: 7,
            on_select_callback: null
        };
        return this.each(function () {
            if (options) {
                $.extend(settings, options);
            }
            var $this = $(this), $fakeInput = $this.clone();
            $fakeInput.attr('id', 'fake_' + $fakeInput.attr('id'));
            $fakeInput.attr('name', 'fake_' + $fakeInput.attr('name'));
            $this.hide().after($fakeInput);
            $fakeInput.autocomplete({
                source: settings.url_list,
                select: function (event, ui) {
                    $this.val(ui.item.id);
                    //Al seleccionar un item de la lista
                    $this.closest("tr").find(".nArticulo").html(ui.item.nArticulo) ;
                    $this.closest("tr").find(".intercambio").html(ui.item.intercambio) ;
                    $this.closest("tr").find(".cantXCaja").html(ui.item.cantXCaja) ;
                    $this.closest("tr").find(".cantCajas").html(ui.item.cantCajas) ;
                    $this.closest("tr").find(".total").html(ui.item.total) ;
                    $this.closest("tr").find(".cantCajasRestante").html(ui.item.cantCajasRestante) ;
                    
                    if (settings.on_select_callback) {
                        settings.on_select_callback($this);
                    }
                },
                minLength: settings.min_length
            });
            if ($this.val() !== '') {
                
                $.ajax({
                    url:     settings.url_get + $this.val(),
                    success: function (data) {
                        $fakeInput.val(data.caja);
                        
                        //Al inicializar, convierte el codigo de Caja a Texto
                        //$fakeInput.closest("tr").find(".nArticulo").html(data.nArticulo) ;
                        //$fakeInput.closest("tr").find(".intercambio").html(data.intercambio) ;
                        //$fakeInput.closest("tr").find(".cantXCaja").html(data.cantXCaja) ;
                        //$fakeInput.closest("tr").find(".cantCajas").html(data.cantCajas) ;
                        //$fakeInput.closest("tr").find(".total").html(data.total) ;
                    }
                });
            }
        });
    };
})(jQuery);
