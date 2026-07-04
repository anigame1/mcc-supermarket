@if (session('status'))
    @php
        $msg = session('status');
        $class = 'message-success';
        if (str_contains(strtolower($msg), 'updated')) $class = 'message-info';
        if (str_contains(strtolower($msg), 'remove') || str_contains(strtolower($msg), 'delete')) $class = 'message-error';
    @endphp
    <div class="message {{ $class }}" onclick="this.remove()">{{ $msg }}</div>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="message message-error" onclick="this.remove()">{{ $error }}</div>
    @endforeach
@endif

<script>
    window.addEventListener('load', function () {
        document.querySelectorAll('.message').forEach(function (el) {
            setTimeout(function () { el.remove(); }, 4000);
        });
    });
</script>
