<div class="chat-header clearfix">
    <div class="row">
        <div class="col-lg-6">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
            </a>
            <div class="chat-about">
                <h6 class="m-b-0">{{ $user->fullname() }}</h6>
                <small>Last seen: 2 hours ago</small>
            </div>
        </div>
        <div class="col-lg-6 hidden-sm text-right">
            <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
            <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
            <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
            <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
        </div>
    </div>
</div>
<div class="chat-history" data-session-id="{{ $user->chat_session_id($user->id) }}">
    <ul class="m-b-0">
        @foreach ($user->messages($user->chat_session_id($user->id)) as $message)
            <li class="clearfix">
                <div class="message-data {{ $message->from_id != auth()->id() ? 'text-right' : '' }}">
                    <span class="message-data-time">10:15 AM, Today</span>
                </div>
                <div
                    class="message {{ $message->from_id != auth()->id() ? 'other-message float-right' : '' }} my-message">
                    {{ $message->message }}</div>
            </li>
        @endforeach
    </ul>
</div>
<div class="chat-message clearfix">
    <div class="input-group mb-0">
        <input type="text" class="form-control" id="message-text" placeholder="Enter text here...">
        <div class="input-group-prepend" id="send-message" data-id="{{ $user->id }}">
            <span class="input-group-text"><i class="fa fa-send"></i></span>
        </div>
    </div>
</div>
