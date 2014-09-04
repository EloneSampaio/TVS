$(document).ready(function() {
    open();
    apagar();
    if (validar()) {
        return true;    //cadastrar();
    }
    else {
        return false;
    }
    $('.datepicker').datepicker();
});
function open() {


    $(document).on('click', '#novocl', function() {
        var id = $(this).attr('rel');
        console.log(id);
        var link = "http://localhost/Tvs/views/cliente/novo"
        setTimeout("$('#pageContent').load('" + link + "'", 1000);
    });
}


function cadastrar() {
    $(document).on("click", "#novo", function() {

        var data = $("#cliente :input").serializeArray();
        $.post($("#cliente").attr('action'), data, function(mensagem) {
            $("#mensagem").html(mensagem);
            console.log(mensagem)
        });
        limparCampos();
    });

    $("#cliente").submit(function() {
        return false;
    });
}

function limparCampos() {

    $("cliente :input").each(function() {
        this.val("");
    });
}


function apagar() {

    $(document).on('click', '#delete', function() {
        if (confirm('Pretendes Apagar este Item?')) {

// get the id
            var id = $(this).attr('rel');
            // trigger the delete file
            $.post("http://localhost/Tvs/cliente/apagar/", {'id': id})
                    .done(function(data) {
                        alert("cliente apagado");
                        console.log(data);
                    });
        }
        else{
            return false;
        }
    });
}


function validar() {

    $("#cliente").validate({
        rules: {
            p_nome: {
                required: true,
                minlength: 5
            },
            u_nome: {
                required: true,
                minlength: 5
            },
            morada: {
                required: true,
                minlength: 5
            },
            telefone: {
                required: true,
                minlength: 8,
                maxlength: 9
            }


        },
        messages: {
            p_nome: {
                required: "Preencha um nome valido"
            },
            u_nome: {
                required: "Preencha um nome valido"
            },
            morada: {
                required: "Preencha uma morada valida"

            },
            telefone: {
                required: "Preencha um numero valido"

            }
        }
    });
}