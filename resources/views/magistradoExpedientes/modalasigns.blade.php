<div class="modal fade bs-example-modal-xl" aria-hidden="true" role="dialog" tabindex="-1" id="modal-{{$expediente->id}}">
  <div class="modal-dialog">
    <div class="modal-content panel default blue_border horizontal_border_1">
      <div class="modal-body">
        <div class="row">
          <div class="block-web">
            <div align="center" class="header">
              <h3 class="content-header theme_color">&nbsp;Validar - {{$expediente->num_expediente}}</h3>
            </div>
            <hr>
            <div align="center" class="modal-title" style="margin-bottom: -50px;">
              <h4 class="modal-title" id='modal-title'>¿Validar expediente?</h4><br>
              <div>
             
             </div>
             
              <p>Una vez validado el expediente, no se podrán modificar sus datos, solo podrá acceder un Administrador!"</p>
            </div><!--/porlets-content-->
          </div><!--/block-web-->
        </div>
      </section>
    </div>
    <br>
    <hr>
    <div class="modal-footer" style="margin-top: -10px;">
      <div class="row col-md-5 col-md-offset-7" style="margin-top: -5px;">
      <form action="{{url('validarExpediente', [$expediente->id])}}" method="POST">
         <input type="hidden" name="_method" value="POST">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
         
         <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Validar</button>
         
         <button type="button" data-dismiss="modal" class="btn btn-danger waves-effect">Cancelar</button>
       </form>
     </div>
   </div>
 </div><!--/modal-content-->
</div><!--/modal-dialog-->
</div><!--/modal-fade-->
