
@extends('layouts.master')

@section('css')
@endsection

@section('content')
    <div class="container-fluid mt-2 pt-2">
        <div class="row pt-4">
            <div class="col-lg-12">

            </div>
        </div>
    </div>
@stop


@section('javascript')

    <script>
        $('document').ready(function () {

        });

        $('#misearch2').on('keypress', async function (e) {
            if(e.which === 13){
                var result = await axios("{{ setting('admin.url') }}api/search/"+this.value)
                localStorage.setItem('miproducts', JSON.stringify(result.data));
                location.href = "{{ route('pages', 'search') }}";
            }
        });
    </script>
@endsection
