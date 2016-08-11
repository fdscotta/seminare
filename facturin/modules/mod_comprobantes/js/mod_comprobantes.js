function ajax(paginacion){
	pag=paginar(paginacion,Number($j('#limite option:selected').val()));
	limit="&limite="+$j('#limite option:selected').val();
	user="&user="+$j('#id_usuario').val();

	$j.ajax
      ({
          url: 'http://'+$j(location).attr('host')+$j("#url_path_ajaxphp").val()+pag+limit+user,
          type: 'post',
          success: function(data){
					if (data.resultados.length !== 0) {
						llenar_tabla_comprobantes(data.resultados);
						$j('#pagina').val(pag2);
						$j('#pagina').html(pagina);
						$j("#paginador").show();
						$j('#sample_1_info').show();
						$j('#sample_1_info').html("Cantidad de Resultados: "+data.cant_registros);
						$j('#cantidad_pagina').html(data.cantidad_pagina+" p&aacute;gina de "+data.cantidad_total);
					}
				},dataType:'json'
      });
};
