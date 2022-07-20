<div>
    <div >
        <a href="{{route("trainers.create")}}" >Agregar</a>
        <table>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Pokemon</th>
                <th>Editar</th>
                <th>Eliminar</th></tr>
            </thead>
            <tbody>
            @foreach($trainers as $trainer)
                <tr>
                    <td>{{$trainer->name}}</td>
                    @if ($trainer->washing_state)
                        <td>En lavado</td>
                    @else
                        <td>Libre</td>
                    @endif
                    <td>
                    @foreach($trainer->pokemon as $pokemon)
                        {{$pokemon->name}},
                    @endforeach
                    </td>
                    <td>
                        <a  href="{{route("trainers.edit",[$trainer])}}">
                            <i >Modificar</i>
                        </a>
                    </td>
                    <td>
                        <form action="{{route("trainers.destroy", [$trainer])}}" method="post">
                            @method("delete")
                            @csrf
                            <button type="submit" >
                                <i >Eliminar</i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{route("main")}}" >volver</a>
</div>
<style>
    table, th, td {
        border: 1px solid;
    }
</style>