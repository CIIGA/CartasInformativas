<div class="m-4">
    <form action="{{ route('pregrabadas') }}" method="POST">
        @csrf
          <!-- Campo oculto para enviar el valor del combobox seleccionado -->
          <input type="hidden" id="idPlaza" name="idPlaza" value="">
        <div class="form-group">
            <label for="fechaI" class="col-md-4 control-label">Fecha inicial:</label>
            <div class="col-md-4">
                <input name="fechaI" type="date" id="fechaI" class="form-control form-control-sm  
                @error('fechaI')
                border border-danger rounded-2
                @enderror" required/>
                @error('fechaI')
                <div class="text-danger text-center">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="fechaf" class="col-md-4 control-label">Fecha final:</label>
            <div class="col-md-4">
                <input name="fechaf" type="date" id="fechaf" class="form-control form-control-sm 
                @error('fechaf')
                border border-danger rounded-2
                @enderror" required/>
                @error('fechaf')
                <div class="text-danger text-center">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>
        <div class="mt-2 button-center">
            <button type="submit" id="btnGenerar" class="btn btn-save">Generar</button>
        </div>
    </form>
</div>