<div class="modal fade bs-example-modal-xl" id="modalText{{$acuerdo->id}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Texto del acuerdo version {{$acuerdo->version}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          
                <div class="modal-body">
                <form method="POST" action="#"  id="formulario2">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token2">

               
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleTextarea">Acuerdo</label>
                                <textarea class="ckeditor" id="acuerdo" name="acuerdo" rows="20">
                            {{$acuerdo->acuerdo_text}}                                                                                           
                             </textarea>
                            </div>
                        </div>
                    

                  
                    <div class="modal-footer">
                    
                            <button data-dismiss="modal" class="btn btn-secondary waves-effect">
                                Cerrar
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
          


        </div>
    </div>
</div>