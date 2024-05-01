@extends($activeTemplate . 'layouts.' . $layout)
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-12">
        <div class="order-wrap payment-info">
            <div class="row justify-content-end">
                <div class="col-md-3 mb-3">
                    <div class="text-end">
                        <a href="{{route('ticket') }}" class="btn btn-sm btn--base mb-2">@lang('My Support Ticket')</a>
                    </div>
                </div>
            </div>
            <form action="{{route('ticket.store')}}" method="post" enctype="multipart/form-data"
            onsubmit="return submitUserForm();">
            @csrf
            @if(auth()->guard('advertiser')->check())
                <input type="hidden" name="user_type" value="advertiser">
            @else
            <input type="hidden" name="user_type" value="publisher">
            @endif
            <div class="row">
                <div class="form-group col-md-6 mb-3">
                    <input type="text" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}"
                        class="form--control" required readonly placeholder="">
                    <label class="form--label">@lang('Name')</label>

                </div>
                <div class="form-group col-md-6 mb-3">
                    <input type="email" name="email" value="{{@$user->email}}"
                        class="form--control" required readonly placeholder="">
                    <label class="form--label">@lang('Email Address')</label>

                </div>

                <div class="form-group col-md-6 mb-3">
                    <input type="text" name="subject" value="{{old('subject')}}"
                        class="form--control" required placeholder="">
                    <label class="form--label">@lang('Subject')</label>

                </div>
                <div class="form-group col-md-6 mb-3">
                    <select name="priority" class=" select form--control" required>
                        <option value="3">@lang('High')</option>
                        <option value="2">@lang('Medium')</option>
                        <option value="1">@lang('Low')</option>
                    </select>
                    <label class="form--label">@lang('Priority')</label>
                </div>
                <div class="col-12 form-group mb-3">
                    <textarea name="message" id="inputMessage" rows="6" class="form--control"
                        required placeholder="">{{old('message')}}</textarea>
                    <label class="form--label">@lang('Message')</label>
                </div>
            </div>

            <div class="text-end mb-3">
                <button type="button" class="btn btn--base btn-sm addFile">
                    <i class="fa fa-plus"></i> @lang('Add New')
                </button>
            </div>
            <div class="form-group col-12 mb-3">
                <div class="file-upload">
                    <input type="file" name="attachments[]" id="inputAttachments"
                        class="form--control" placeholder="" />
                    <label class="form--label">@lang('Attachments')</label>
                    <div id="fileUploadsContainer"></div>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn--base" type="submit" id="recaptcha"><i
                        class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
            </div>
        </form>

        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        var fileAdded = 0;
        $('.addFile').on('click', function () {
            if (fileAdded >= 4) {
                notify('error', 'You\'ve added maximum number of file');
                return false;
            }
            fileAdded++;
            $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required placeholder="" />
                        <label class="form--label">@lang('Attachments')</label>
                        <button class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
        });
        $(document).on('click', '.remove-btn', function () {
            fileAdded--;
            $(this).closest('.input-group').remove();
        });
    })(jQuery);
</script>
@endpush
