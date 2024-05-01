@extends($activeTemplate.'layouts.publisher.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-12">
        <div class="order-wrap">
            <div class="row justify-content-end">
                <div class="col-md-3 mb-3">
                    <div class="search-box w-100">
                        <form action="">
                            <div class="form-group">
                                <input type="text" name="search" class="form--control" value="{{ request()->search }}"
                                placeholder="">
                                <label class="form--label">@lang('Search')</label>
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table--responsive--lg">
                <thead>
                    <tr>
                        <th>@lang('Gateway')</th>
                        <th>@lang('Initiated')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Conversion')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdraws as $withdraw)
                    <tr>
                        <td>
                             {{__(@$withdraw->method->name) }}</>
                        </td>
                        <td>
                            {{ showDateTime($withdraw->created_at) }}
                        </td>
                        <td >
                            {{ showAmount($withdraw->amount-$withdraw->charge) }} {{ __($general->cur_text) }}
                        </td>
                        <td>
                            {{ showAmount($withdraw->final_amount) }} {{ __($withdraw->currency) }}
                        </td>
                        <td>
                            @php echo $withdraw->statusBadge @endphp
                        </td>
                        <td>
                            <button class="btn btn--sm btn--base detailBtn"
                                data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                @if($withdraw->status == 3)
                                data-admin_feedback="{{ $withdraw->admin_feedback }}"
                                @endif
                                >
                                <i class="la la-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($withdraws->hasPages())
            <div class="text-end">
                {{$withdraws->links()}}
            </div>
            @endif
        </div>
    </div>
</div>
{{-- APPROVE MODAL --}}
<div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Details')</h5>
                <span type="button" class="close btn btn--danger btn--sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div class="modal-body">
                <ul class="list-group userData">

                </ul>
                <div class="feedback"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--base btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        $('.detailBtn').on('click', function () {
            var modal = $('#detailModal');
            var userData = $(this).data('user_data');
            var html = ``;
            userData.forEach(element => {
                if (element.type != 'file') {
                    html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                }
            });
            modal.find('.userData').html(html);

            if ($(this).data('admin_feedback') != undefined) {
                var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
            } else {
                var adminFeedback = '';
            }

            modal.find('.feedback').html(adminFeedback);

            modal.modal('show');
        });
    })(jQuery);

</script>
@endpush
