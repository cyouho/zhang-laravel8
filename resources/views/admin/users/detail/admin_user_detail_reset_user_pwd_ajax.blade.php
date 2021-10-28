@if (isset($resetPwdRecord))
@foreach ($resetPwdRecord as $value)
<tr>
    <td>{{$value['admin_id']}}</td>
    <td>{{$value['admin_name']}}</td>
    <td>{{date("Y-m-d H:i:s", $value['update_at'])}}</td>
</tr>
@endforeach
@endif