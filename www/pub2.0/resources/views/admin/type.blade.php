@extends('dashboard')

@section('dc')
    @inject('typeService','App\Services\TypeService)

    <div class="input-group col-md-12">
        <div class="col-md-12">
            <div class="input-group-btn" style="width: auto;margin:0 2px 0 0">
                <input class="form-control" type="text" id="newType">
                <button class="btn btn-default" type="button" onclick="addType()">+</button>
            </div>
        </div>
        @foreach($typeService->showTypes() as $type)
            <div class="col-md-2" style="margin: 2px 0 2px 0">
                <div class="input-group-btn" style="width: auto;">
                    <button class="btn btn-primary" type="button">{{$type->name}}</button>
                    <button class="btn btn" type="button" onclick="deleteType({{$type->id}})">—</button>
                </div>
            </div>
        @endforeach


    </div>
    <script>
        function deleteType(typeId) {
            $.get('{{url('/type/delete')}}/' + typeId, null, function (res) {
                window.location.href = res;
            })
        }

        function addType() {
            var typeName = document.getElementById('newType').value;
            var type = {
                name: typeName
            };
            $.post("{{url('/type')}}", type, function (res) {
                window.location.href = res;
            });
        }
    </script>
@endsection