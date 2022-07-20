<h1> Centro de Limpieza de Pokemon </h1>
@foreach($response->cleaning_centers as $cleaning_center)
    <h2> Centro {{$cleaning_center->id}}</h2>
    <h3> Ganancias: {{$cleaning_center->profits}}</h3>
    <h2> Entrenadores en el centro:</h3>
    <table>
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Estado</th>
        </thead>
        <tbody>
            @foreach($response->trainers as $trainer)
                @if ($trainer->cleaning_center_id == $cleaning_center->id)
                    <tr>
                        <td>{{$trainer->name}}</td>
                        @if ($trainer->washing_state)
                            <td>En lavado</td>
                        @else
                            <td>Lavado</td>
                        @endif
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endforeach
<h2> Entrenadores libres:</h3>                                
<a href="{{route("trainers.index")}}" >Administrar Entrenadores</a>
<table >
        <thead>
        <tr>
            <th>Nombre</th>
            <th>Pokemon/Suciedad</th>
            <th>Acciones</th>
        </thead>
        <tbody>
            @foreach($response->trainers as $trainer)
                @if ($trainer->cleaning_center_id == null)
                    <tr>
                        <td>{{$trainer->name}}</td>
                        <td>
                            @foreach($trainer->pokemon as $pokemon)
                                {{$pokemon->name}}: {{$pokemon->dirt}}
                                <br>
                            @endforeach
                        </td>
                        @foreach($response->cleaning_centers as $cleaning_center)
                        <td>
                            <br>
                            <form action="{{route("start_cleaning", ['cleaning_center_id' => $cleaning_center->id, 'id' => $trainer->id])}}" method="post">
                                @method("post")
                                @csrf
                                <button type="submit" >
                                    <i >Lavar en centro {{$cleaning_center->id}}</i>
                                </button>
                            </form>
                           
                        </td>
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
</table>

<style>
    table, th, td {
        border: 1px solid;
    }
</style>