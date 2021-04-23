<div class="modal fade bs-example-modal-xl" id="modal-delete-{{$user->id}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Datos modificados por el usuario: {{$user->name}}
                    {{$user->apellido_p}} {{$user->apellido_m}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                                               
                            @if($user->tipo_movimiento == "sesion")
                            <h4 class="card-title">Tipo de movimiento : El usuario inicio sesión</h4>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Usuario: {{$user->name}}
                                        {{$user->apellido_p}} {{$user->apellido_m}}</h5>
                                    <p class="card-text">Fecha de inicio de sesión: {{$user->created_at}}.</p>
                                    <p class="card-text">
                                    </p>
                                </div>
                            </div>

                            @else
                            @if($user->tipo_movimiento == "create")
                            <h4 class="card-title">Tipo de movimiento : Inserción (El usuario creó un nuevo registro)</h4>
                            @elseif($user->tipo_movimiento == "update")
                            <h4 class="card-title">Tipo de movimiento : Update (El usuario actualizo datos de un registro)</h4>
                            @else
                            <h4 class="card-title">Tipo de movimiento : Delete (El usuario elimino o inactivo registros) </h4>
                            @endif                        
                            @if($user->valor_nuevo )
                            <?php
                            $datos_actualizados=base64_decode($user->valor_nuevo);                                                   
                           ?>
                            @else
                            <?php
                            $datos_actualizados="";                                                   
                           ?>
                            @endif
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Valor modificado</h5>
                                    <p class="card-text">{{$datos_actualizados}}.</p>
                                    <p class="card-text">
                                        <small class="text-muted">Fecha de movimiento: {{$user->created_at}}</small>
                                    </p>
                                </div>
                            </div>

                            @if($user->valor_anterior )
                            <?php
                            $datos_anteriores=base64_decode($user->valor_anterior);                                                   
                           ?>
                            @else
                            <?php
                            $datos_anteriores="SIN VALORES ANTERIORES";                                                   
                           ?>
                            @endif

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Valor anterior</h5>
                                    <p class="card-text">{{$datos_anteriores}}.</p>
                                    <p class="card-text">
                                        <small class="text-muted">Fecha de movimiento: {{$user->created_at}}</small>
                                    </p>
                                </div>
                            </div>

                            @endif

                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
        </div>
    </div>
</div>