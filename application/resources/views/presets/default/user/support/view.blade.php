@extends($activeTemplate . 'layouts.' . $layout)
@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="{{ auth()->guard('publisher')->check()
            ? 'col-lg-12'
            : (auth()->guard('advertiser')->check()
                ? 'col-lg-12'
                : 'col-lg-8 py-80') }}">
            <div class="order-wrap  payment-info">
                <div class="row mb-3 justify-content-between align-items-center ">
                    <div class="col-md-11">
                        <h5 class="mb-0">
                            @php echo $myTicket->statusBadge; @endphp
                            [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                        </h5>
                    </div>
                    <div class="col-md-1 text-end">
                        @if ($myTicket->status != 3 && $myTicket->user)
                        <button class="btn btn--danger btn-sm confirmationBtn" type="button" data-question="@lang('Are you sure to close this ticket?')"
                            data-action="{{ route('ticket.close', $myTicket->id) }}"><i
                                class="fa fa-lg fa-times-circle"></i>
                        </button>
                        @endif
                    </div>
                </div>
                @if ($myTicket->status != 4)
                    <form method="post" action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-between">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="message" class="form--control" rows="4">{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mb-3">
                            <a href="javascript:void(0)" class="btn btn--base btn-sm addFile"><i class="fa fa-plus"></i>
                                @lang('Add New')</a>
                        </div>
                        <div class="form-group mb-3">
                            <input type="file" name="attachments[]" class="form-control form--control" placeholder="" />
                            <label class="form--label">@lang('Attachments')</label>
                            <div id="fileUploadsContainer"></div>

                        </div>
                        <button type="submit" class="btn btn--base mb-3"> <i class="fa fa-reply"></i> @lang('Reply')</button>
                    </form>
                @endif

                @foreach ($messages as $message)
                    @if ($message->admin_id == 0)
                        <div class="row border mx-1 py-2">
                            <div class="col-md-3 border-end text-end">
                                <h5 class="my-3">{{ $message->ticket->name }}</h5>
                            </div>
                            <div class="col-md-9">
                                <p class="text-muted fw-bold my-3">
                                    @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                <p>{{ $message->message }}</p>
                                @if ($message->attachments->count() > 0)
                                    <div class="mt-2">
                                        @foreach ($message->attachments as $k => $image)
                                            <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="me-3"><i
                                                    class="fa fa-file"></i> @lang('Attachment') {{ ++$k }} </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                    <div class="row border mx-1 py-2">
                            <div class="col-md-3 border-end text-end">
                                <h5 class="my-3">{{ $message->admin->name }}</h5>
                                <p class="lead text-muted">@lang('Staff')</p>
                            </div>
                            <div class="col-md-9">
                                <p class="text-muted fw-bold my-3">
                                    @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                <p>{{ $message->message }}</p>
                                @if ($message->attachments->count() > 0)
                                    <div class="mt-2">
                                        @foreach ($message->attachments as $k => $image)
                                            <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="me-3"><i
                                                    class="fa fa-file"></i> @lang('Attachment') {{ ++$k }} </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form--control" required placeholder="" />
                        <label class="form--label">@lang('Attachments')</label>
                        <button class="input-group-text btn--danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
