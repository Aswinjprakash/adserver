@php
$blog = getContent('blog.content', true);
$blogElements = App\Models\Frontend::where('data_keys','blog.element')->orderBy('id','desc')->paginate(getPaginate(3));
@endphp
<section class="blog-section py-115">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-content">
                    <h2 class="section-title mb-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">{{__($blog->data_values->heading)}}</h2>
                    <div class="title-btm-border mb-3 wow animate__animated animate__fadeInUp"  data-wow-delay="0.3s"></div>
                </div>
            </div>
        </div>
        <div class="row g-5 justify-content-center py-60">
            @foreach ($blogElements as $item)
            <div class="col-lg-4 col-md-6">
                <div class="nws-card_body wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                    <div class="card-img">
                        <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                            <img src="{{ getImage(getFilePath('blog') . '/' . 'thumb_' . $item->data_values->blog_image) }}" alt="@lang('blog img')" >
                        </a>
                    </div>
                    <div class="card-item">
                        <div class="date">
                            <p><i class="fas fa-clock"></i> {{ showDateTime($item->created_at) }}</p>
                        </div>
                        <div class="nws-title pt-3">
                            <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                            <h4>
                                @if (strlen(__($item->data_values->title)) > 50)
                                {{ substr(__($item->data_values->title), 0, 50) . '...' }}
                                @else
                                    {{ __($item->data_values->title) }}
                                @endif
                            </h4>
                        </a>
                        </div>
                        <div class="py-2">
                            <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}" class="btn btn--base">@lang('Read More') <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
         <!-- pagination -->
         <div class="row">
            @if ($blogElements->hasPages())
            <div class=" d-flex justify-content-end">
                {{ paginateLinks($blogElements) }}
            </div>
            @endif
        </div>
        <!-- / pagination -->
    </div>
</section>
