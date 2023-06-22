<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User List</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>
<body>
<div style="text-align: center;">
    <h3>Data table with dynamic pagination</h3>
</div>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $dataRow)
            <tr class="@if(($key + 1) % 2 == 0 ) even @else odd @endif">
                <td>{{$key + 1}}</td>
                <td>{{$dataRow->name}}</td>
                <td>{{$dataRow->email}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Sl No</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </tfoot>
    </table>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 15,
            ajax: '{{route("user.list.data")}}',
            deferLoading: '{{$datacount}}',
        });
    });
</script>



</body>
</html>