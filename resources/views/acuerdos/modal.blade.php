<div class="modal fade bs-example-modal-xl" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Escaneo escrito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <embed src="../OFICIALIA/archivos/ingresos/{{$DetalleExp->escaneo_escrito}}" frameborder="0" width="100%" height="400px">

                <button data-dismiss="modal" class="btn btn-secondary waves-effect">
                                Cerrar
                            </button>
            </div>

        </div>
    </div>
</div>