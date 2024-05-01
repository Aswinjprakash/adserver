@extends($activeTemplate.'layouts.publisher.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-12">
        <div class="order-wrap">
            <table class="table table--responsive--lg">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Type')</th>
                        <th>@lang('Click')</th>
                        <th>@lang('Impression')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($publisherAds as $ad)
                        <tr>
                            <td data-label="@lang('Name')">
                                {{__(@$ad->advertise->ad_name)}}
                            </td>

                            <td data-label="@lang('Type')">
                            <span class="badge badge--base"> {{__(@$ad->advertise->ad_type)}}</span>
                            </td>

                            <td data-label="@lang('Click')">
                                {{__($ad->click_count ?? 0)}}
                            </td>

                            <td data-label="@lang('Impression')">
                                {{__($ad->imp_count ?? 0)}}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center" data-label="@lang('Published Ad Table')">{{__($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($publisherAds->hasPages())
    <div class="d-flex justify-content-end">
        {{ paginateLinks($publisherAds) }}
    </div>
    @endif
</div>
@endsection

