function clickbutton(id, id_datos){
    
    var ruta_url = $('#ruta').val();
    
    var url = ruta_url + "/" +id+ "/"+ id_datos;
    $(location).attr('href',url);
}


