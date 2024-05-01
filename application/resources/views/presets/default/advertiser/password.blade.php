@extends($activeTemplate.'layouts.advertiser.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-xl-8 col-lg-8">
        <div class="user-profile global-card">
            <form action="" method="post">
                @csrf
                <div class="row gy-3">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input id="current_password" type="password" class="form--control" name="current_password" placeholder="" required>
                            <label for="current_password" class="form--label required">@lang('Current Password')</label>
                            <div class="password-show-hide fas toggle-password-change-ad fa-eye-slash" data-target="current_password"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input id="password" type="password" class="form--control" name="password" placeholder="" required>
                            <label for="password" class="form--label required">@lang('Password')</label>
                            <div class="password-show-hide fas toggle-password-change-ad fa-eye-slash" data-target="password"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input id="password_confirmation" type="password" class="form--control" name="password_confirmation" placeholder="" required>
                            <label for="password_confirmation" class="form--label required">@lang('Confirm Password')</label>
                            <div class="password-show-hide fas toggle-password-change-ad fa-eye-slash" data-target="password_confirmation"></div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn--base">@lang('Change Password')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('script')

<script>
        $(".toggle-password-change-ad").on('click', function() {
      var targetId = $(this).data("target");
      var target = $("#" + targetId);
      var icon = $(this);
      if (target.attr("type") === "password") {
          target.attr("type", "text");
          icon.removeClass("fa-eye-slash");
          icon.addClass("fa-eye");
      } else {
          target.attr("type", "password");
          icon.removeClass("fa-eye");
          icon.addClass("fa-eye-slash");
      }
  });
</script>

@endpush
