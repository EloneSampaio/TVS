
$(document).ready(function() {
    senha();
    apagar()
});



function apagar() {

    $(document).on('click', '#delete', function() {
        if (confirm('Pretendes Apagar este Item?')) {

// get the id
            var id = $(this).attr('rel');
            // remover o 8080 quando entrar em produção
            $.post("http://localhost:8080/Tvs/usuario/apagar/", {'id': id})
                    .done(function(data) {
                        alert("usuario apagado");
                        console.log(data);
                    });
        }
        else {
            return false;
        }
    });
}

function senha() {

    $("input[name='enable']").click(function() {
        if ($(this).is(':checked')) {
            $('input[name="senha"]').attr("disabled", true);
        }
        else if ($(this).not(':checked')) {
            var ok = confirm('Pretendes alterar a senha?');
            if (ok) {
                var remove = '';
                $('input[name="senha"]').attr('value', remove);
                $('input[name="senha"]').attr("disabled", false);
            }
        }
    });
}