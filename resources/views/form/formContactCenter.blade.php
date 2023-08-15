<div class="m-4">
    <form action="{{ route('contact') }}" method="POST">
        @csrf
          <!-- Campo oculto para enviar el valor del combobox seleccionado -->
          <input type="hidden" id="idPlazaC" name="idPlazaC" value="">
        <div class="form-group">
            <label for="fechaIC" class="col-md-4 control-label">Fecha inicial:</label>
            <div class="col-md-4">
                <input name="fechaIC" type="date" id="fechaIC" class="form-control form-control-sm  
                @error('fechaIC')
                border border-danger rounded-2
                @enderror" />
                @error('fechaIC')
                <div class="text-danger text-center">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="fechafC" class="col-md-4 control-label">Fecha final:</label>
            <div class="col-md-4">
                <input name="fechafC" type="date" id="fechafC" class="form-control form-control-sm 
                @error('fechafC')
                border border-danger rounded-2
                @enderror" />
                @error('fechafC')
                <div class="text-danger text-center">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>
        <div class="mt-2 button-center">
            <button type="submit" id="btnGenerarC" class="btn btn-save">Generar</button>
        </div>
    </form>
</div>