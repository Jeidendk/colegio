<div class="table-wrap"><table class="data-table"><thead><tr><th>Solicitud</th><th>Asignatura</th><th>Equipo</th><th>Fecha</th><th>Estado</th><th></th></tr></thead><tbody>
@foreach($rows as $request)
<tr data-search-row><td><b>{{ $request['id'] }}</b></td><td>{{ $request['subject'] }}</td><td>{{ $request['items'] }}</td><td>{{ $request['date'] }}</td><td><x-badge :value="$request['status']" /></td><td><button class="row-action" data-toast="Detalle de {{ $request['id'] }}"><i data-lucide="eye"></i></button></td></tr>
@endforeach
</tbody></table></div>
