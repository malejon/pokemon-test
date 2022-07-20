<div>
    <div>
        <form method="POST" action="{{route("trainers.store")}}">
            @csrf
            <div>
                <label>Nombre</label>
                <input required autocomplete="off" name="name"
                        type="text" placeholder="Nombre">
            </div>
            <button >Guardar</button>
            <a  href="{{route("trainers.index")}}">Volver al listado</a>
        </form>
    </div>
</div>