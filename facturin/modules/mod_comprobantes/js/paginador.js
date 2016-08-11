function paginar(paginacion,limite) {
	pag= "paginacion=";
	pagina = Number($j('#pagina').html());
	if (paginacion == 0) {
		pag2 = Number($j('#pagina').val()) - limite;
		pagina = pagina - 1;
		if (pag2 < 0) {pag2 = 0;pagina = 1;}
		pag = pag+pag2;
	}else if (paginacion == 1) {
		pag2 = Number($j('#pagina').val()) + limite;
		if (Number($j('#pagina').html())==0) {pagina = pagina + 1;}
		pagina = pagina + 1;
		pag = pag+pag2;
	}else {
		pag2 = 0;
		pag = pag+pag2;
		pagina = 1;
	}
	return pag;
}
