<div class="card">
    <div class="card-body">
        <h4 class="card-title">{{$title}}</h4>
        <h6 class="card-subtitle">{{$subtitle}}</h6>
        <div class="table-responsive m-t-40">
            <table id="{{$id}}" class="table color-bordered-table table-striped full-color-table full-info-table hover-table" data-display-length='-1' data-order="[]">
                <thead>
                    <tr>
                        @foreach($cols as $col)
                        <th>{{$col}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($items as $item)
                    <tr>
                        @foreach($atts as $att)

                        @if(is_array($att))
                        @if(array_key_exists('edit', $att))
                        <td><a href="{{ url( $att['edit']['url'] . $item->{$att['edit']['att']}) }}"><img src="{{ asset('images/edit.png') }}" width=25 height=25></a></td>
                        @elseif(array_key_exists('foreign', $att))
                        <td>{{ $item->{$att['foreign'][0]}->{$att['foreign'][1]}  }}</td>
                        @elseif(array_key_exists('url', $att))
                        <td><a href="{{ url($att['url'][0]) }}">{{ $item->{$att['url']['att']}  }}</a></td>
                        @elseif(array_key_exists('state', $att))
                        <td><span class="label {{ $att['state']['classes'][$item->{$att['state']['att']}] }}">{{ $item->{$att['state']['rel']}->{$att['state']['foreignAtt']}  }}</span></td>
                        @elseif(array_key_exists('date', $att))
                        <td>{{ $item->{$att['date']['att']}->format($att['date']['format'])  }}</a></td>
                        @elseif(array_key_exists('foreignUrl', $att))
                        <td><a href="{{ url($att['foreignUrl'][0] . '/' . $item->{$att['foreignUrl']['1']}) }}">{{ $item->{$att['foreignUrl'][2]}->{$att['foreignUrl'][3]}  }}</a></td>
                        @endif
                        @else
                        <td>{{ $item->{$att} }}</td>
                        @endif
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="{{ asset('assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/datatables/datatables.min.js') }}"></script>
<script>
    $(function () {
            $(function () {

                var table = $('#{{$id}}').DataTable({
                    "displayLength": 25,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'PetMatch',
                            footer: true,
                        }
                    ]
                });
            })
        })
</script>