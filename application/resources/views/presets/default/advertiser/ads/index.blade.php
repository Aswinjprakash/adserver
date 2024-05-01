@extends($activeTemplate.'layouts.advertiser.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-12">
        <div class="order-wrap">
            <table class="table table--responsive--lg">
                <thead>
                    <tr>
                        <th>@lang('Ad Name')</th>
                        <th>@lang('Ad Title')</th>
                        <th>@lang('Image')</th>
                        <th>@lang('Type')</th>
                        <th>@lang('Resolution')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advertises as $item)
                    <tr>
                        <td data-label="@lang('Ad Name')">{{__($item->ad_name)}}</td>
                        <td data-label="@lang('Ad Title')">{{__($item->title)}}</td>
                        <td data-label="@lang('Image')"><img src="{{ getImage(getFilePath('adImage').'/'.@$item->image)}}" alt="Image" class="rounded adimagList"></td>
                        <td data-label="@lang('Type')">
                            <span class="badge badge--info">{{__($item->ad_type)}}</span> </span>
                        </td>
                        <td data-label="@lang('Resolution')">{{__($item->resolution)}} @lang('px')</td>
                        <td data-label="@lang('Status')">
                            @php
                                echo $item->statusBadge($item->status);
                            @endphp
                        </td>
                        <td data-label="@lang('Action')">
                            <a href="{{ route('advertiser.ad.edit', $item->id) }}" class="btn btn--base btn--sm outline" title="@lang('Edit')">
                                <i class="fa fa-edit"></i>
                            </a>

                            @if ($item->status != 2)
                                @if ($item->status == 1)
                                    <a href="javascript:void(0)" class="btn btn--danger btn--sm outline deactivateBtn" data-id="{{$item->id}}" title="@lang('Ban')">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                @else
                                    <a href="javascript:void(0)" class="btn btn--success btn--sm outline activeBtn" data-id="{{$item->id}}" title="@lang('Active')">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif

                                <a href="javascript:void(0)" class="btn btn--danger btn--sm outline rejectBtn" data-id="{{$item->id}}" title="@lang('Delete')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @else
                                <a href="javascript:void(0)" class="btn btn--danger btn--sm outline rejectBtn" title="@lang('Delete')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="100%" class="text-center" data-label="Advertise Table">{{ __($emptyMessage) }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($advertises->hasPages())
    <div class=" d-flex justify-content-end">
        {{ paginateLinks($advertises) }}
    </div>
    @endif
</div>


 {{-- delete modal --}}
 <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Delete Advertise Confirmation')</h5>
                <button type="button" class="close btn btn--danger btn--sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('advertiser.ad.delete')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to') <span class="fw-bold">@lang('delete')</span> <span
                            class="fw-bold withdraw-amount text-success"></span> @lang('this advertise') <span
                            class="fw-bold withdraw-user"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base">@lang('Delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>

 {{-- deactive modal --}}
 <div id="deactivateModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmation Alert')!</h5>
                <button type="button" class="close btn btn--danger btn--sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('advertiser.ad.update.status')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="status" value="0">
                <div class="modal-body">
                    <p><span class="fw-bold withdraw-amount text-success"></span> @lang('Are you sure to deactive this advertise') ?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base ">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>

 {{-- active modal --}}
 <div id="activeModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmation Alert')!</h5>
                <button type="button" class="close btn btn--danger btn--sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{route('advertiser.ad.update.status')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="status" value="1">
                <div class="modal-body">
                    <p><span class="fw-bold withdraw-amount text-success"></span> @lang('Are you sure to active this advertise') ?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--base ">@lang('Yes')</button>
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

        $('.rejectBtn').on('click', function () {
            var modal = $('#rejectModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });

        $('.activeBtn').on('click', function () {
            var modal = $('#activeModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });

        $('.deactivateBtn').on('click', function () {
            var modal = $('#deactivateModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });

    })(jQuery);

</script>
@endpush


