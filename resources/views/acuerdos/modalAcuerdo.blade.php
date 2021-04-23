<div class="modal fade bs-example-modal-xl" id="modalAcuerdo{{$acuerdo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Acuerdo generado versión: {{$acuerdo->version}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <embed src="/SALAS/acuerdos/{{$acuerdo->acuerdo}}" frameborder="0" width="100%" height="400px">

                <button data-dismiss="modal" class="btn btn-secondary waves-effect">
                                Cerrar
                            </button>
            </div>

        </div>
    </div>
</div>