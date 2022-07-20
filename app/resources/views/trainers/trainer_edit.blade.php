<div >
        <div >
            <form method="POST" action="{{route("trainers.update", [$trainer])}}">
                @method("PUT")
                @csrf
                <div >
                    <label >Nombre</label>
                    <input required value="{{$trainer->name}}" autocomplete="off" name="name"
                           type="text" placeholder="Nombre">
                </div>
                <button>Guardar</button>
                <a  href="{{route("trainers.index")}}">Volver</a>
            </form>
        </div>
    </div>