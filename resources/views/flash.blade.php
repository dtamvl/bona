
@if ($message = Session::get('success'))
<div class="block-header">
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>	
    <strong>{{ $message }}</strong>
</div>
</div>
@endif


@if ($message = Session::get('error'))
<div class="block-header">
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="block-header">
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
</div>
@endif


@if ($message = Session::get('info'))
<div class="block-header">
<div class="alert alert-info alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
</div>
@endif


@if ($errors->any())
<div class="block-header">
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
    Kiểm tra thông tin nhập liệu
</div>
</div>
@endif
