frmAcceso.addEventListener('submit', function (e) {
    e.preventDefault();
    logina = $('#logina').val();
    clavea = $('#clavea').val();

    $.post('../ajax/usuario.php?op=verificar', {
        'logina': logina,
        'clavea': clavea
    }, function (data) {
        if (data != 'null') {
            $(location).attr('href', 'registro.php');
        } else {
            notificacionSwal(document.title, "Usuario y/o contraseña incorrectos", "warning", "Ok");
        e.preventDefault();
        return;
        }
    });
});