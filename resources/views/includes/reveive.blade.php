<li class="clearfix">
    <div class="message-data text-right">
        <span class="message-data-time">{{ now()->format('d/m/Y H:i') }}</span>
        {{-- <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar"> --}}
    </div>
    <div class="message other-message float-right"> {{ $message }} </div>
</li>
