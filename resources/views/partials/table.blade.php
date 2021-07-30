<div class="row">
    <div class="col-12">
        <table class="table table-bordered table-striped table-hover bg-white" id="my-table" data-url="{{ $url }}">
            <thead>
                <tr class="text-center">
                    @foreach($columns as $col)
                    <th scope="col" data-data="{{ $col['data'] }}" data-export="{{ $col['export'] }}" data-orderable="{{ !empty($col['orderable']) ? $col['orderable'] : 'true' }}" data-searchable="{{ !empty($col['searchable']) ? $col['searchable'] : 'true' }}">{{ $col['title'] }}</th>
                    @endforeach
                </tr>
            </thead>
        </table>
    </div>
</div>