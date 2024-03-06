@extends('base')
@section('title', "task - form")
@section('content')
    <div class="container mb-5">
        <form id="contactForm" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label text-center">@lang('messages.form.full_name'):</label>
                <div class="col-sm-3">
                    <input type="text" id="fullName" name="fullName" class="form-control" maxlength="100" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-sm-3 col-form-label text-center">@lang('messages.form.phone_number'):</label>
                <div class="col-sm-3">
                    <input type="tel" id="phoneNumber" name="phoneNumber" class="form-control" pattern="[0-9]{9,15}" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label text-center">@lang('messages.form.email'):</label>
                <div class="col-sm-3">
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="message" class="col-sm-3 col-form-label text-center">@lang('messages.form.message'):</label>
                <div class="col-sm-3">
                    <textarea id="message" name="message" class="form-control" maxlength="500" required></textarea>
                </div>
            </div>
            <div class="col-sm-7 text-center text-danger" id="fileError"></div>
            <div class="form-group row">
                <label for="attachment" class="col-sm-3 col-form-label text-center">@lang('messages.form.file'):</label>
                <div class="col-sm-3">
                    <input type="file" id="file" name="file" class="form-control-file" accept=".jpg,.pdf" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 text-center">
                    <button type="submit" class="btn btn-primary">@lang('messages.button.send')</button>
                </div>
            </div>
        </form>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

<script>
    $(document).ready(function() {
        $('#attachment').on('change', function() {
            if (this.files[0].size > 5 * 1024 * 1024) {
                $('#fileError').text("@lang('messages.error.file')");
                $(this).val('');
            } else {
                $('#fileError').text('');
            }
        });

        $('#contactForm').submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#contactForm')[0]);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '/message',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $.toast({
                            text: response.message,
                            showHideTransition: 'slide',
                            bgColor: '#7EC857',
                            textColor: '#eee',
                            allowToastClose: true,
                            hideAfter: 5000,
                            stack: 5,
                            textAlign: 'center',
                        });
                        $('#contactForm')[0].reset();
                    }
                },
                error: function(xhr) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'error') {
                        $.toast({
                            text: response.message,
                            showHideTransition: 'slide',
                            bgColor: '#EA5455',
                            textColor: '#eee',
                            allowToastClose: true,
                            hideAfter: 5000,
                            stack: 5,
                            textAlign: 'center',
                    });
                    }
                }
            });
        });
    });
</script>
