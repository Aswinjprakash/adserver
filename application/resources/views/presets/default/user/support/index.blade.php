@extends($activeTemplate.'layouts.'.$layout)
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-12">
        <div class="order-wrap">
            <div class="row justify-content-end">
                <div class="col-md-3 mb-3">
                    <div class="text-end">
                        <a href="{{route('ticket.open') }}" class="btn btn--base"> <i class="fa fa-plus"></i> @lang('New Ticket')</a>
                    </div>
                </div>
            </div>
            <table class="table table--responsive--lg">
                <thead>
                <tr>
                    <th>@lang('Subject')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Priority')</th>
                    <th>@lang('Last Reply')</th>
                    <th>@lang('Action')</th>
                </tr>
                </thead>
                <tbody>
                    @forelse($supports as $support)
                        <tr>
                            <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="fw-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                            <td data-label="@lang('Status')">
                                @php echo $support->statusBadge; @endphp
                            </td>
                            <td data-label="@lang('Priority')">
                                @if($support->priority == 1)
                                    <span class="badge bg-dark">@lang('Low')</span>
                                @elseif($support->priority == 2)
                                    <span class="badge bg-success">@lang('Medium')</span>
                                @elseif($support->priority == 3)
                                    <span class="badge bg-primary">@lang('High')</span>
                                @endif
                            </td>
                            <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                            <td data-label="@lang('Action')">
                                <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn--base btn--sm outline">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center" data-label="@lang('Support Ticket Table')">{{ __($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{$supports->links()}}
        </div>
    </div>
</div>
@endsection
