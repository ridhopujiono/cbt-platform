<table class="table table-bordered">
<thead>
<tr>
    <th width="40">#</th>
    <th>Mapel</th>
    <th>Soal</th>
</tr>
</thead>
<tbody>

@foreach ($questions as $q)
<tr>
    <td>
        <input type="checkbox"
               name="questions[]"
               value="{{ $q->id }}"
               {{ in_array($q->id, $selected) ? 'checked' : '' }}>
    </td>
    <td>{{ $q->subject->name }}</td>
    <td>{{ Str::limit(strip_tags($q->content), 80) }}</td>
</tr>
@endforeach

</tbody>
</table>

{{ $questions->links() }}
