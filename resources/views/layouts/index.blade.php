@include("layouts.header")
<div class="content-wrapper">
    @include("errors.fetchErrors")
    @include("success.success")
    @yield('content')
</div>
@include("layouts.footer")
