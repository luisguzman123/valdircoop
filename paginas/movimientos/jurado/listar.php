<div class="container-fluid card" style="padding: 30px;">
    <div class="row">
        <div class="col-md-10">
            <h3>Lista de Jurados</h3>
        </div>
        <div class="col-md-3">
            <button class="form-control btn btn-primary" onclick="mostrarAgregarJurado(); return false;"><i class="fa fa-save"></i> Agregar</button>
        </div>
        <div class="col-md-12" style="margin-top: 30px;">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-head-bg-primary mt-4">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre y Apellido</th>
                            <th>C&eacute;dula</th>
                            <th>Estado</th>
                            <th>Operaciones</th>
                        </tr>
                    </thead>
                    <tbody id="jurado_tb"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
