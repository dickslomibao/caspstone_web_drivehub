@include(SchoolFileHelper::$header, ['title' => 'Messages'])
<style>
    .content:hover+span {
        display: block !important;
    }
</style>
<div class="container-fluid" style="padding: 20px;margin-top:50px;">
    <div class="row">
        <div class="col-md-4">
            <div id="conversation">
                <input type="text" id="search-convo" placeholder="Search conversation...">
                <div id="conversation_list">

                </div>
            </div>
        </div>
        <div class="col-md-8" id="messages">
            @if ($convo_id)
                <div class="convo-info">
                    <div class="item d-flex align-items-center" style="column-gap: 10px;">
                        <div class="image">
                            <img src="/{{ $user->profile_image }}" alt="" srcset="" id="chat_profile">
                        </div>
                        <div class="d-flex align-items-center" style="justify-content: space-between">
                            <div>
                                <h6 id="chat_name">{{ $user->name }}</h6>
                                <p class="active">-</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="messages_container" style="padding: 0 20px 20px 20px">

                </div>
                <div class="action-messages">
                    <textarea placeholder="Enter your message here..." id="message_content" name="" id=""></textarea>
                    <button id="send_message"><i class="fa-solid fa-paper-plane"></i> Send</button>
                </div>
            @else
                <center>
                    <h6 style="margin-top: 250px">Select Conversation</h6>
                </center>
            @endif
        </div>
    </div>
</div>


<script>
    var parents = document.querySelector('#conversation_list');
    let convo_id = "{{ $convo_id }}";
    displayConveration(convo_id);
    displayConversationMessages(convo_id);

    function displayConveration() {
        $.ajax({
            type: "POST",
            url: '{{ route('get.convo') }}',
            processData: false,
            contentType: false,
            success: function(response) {
                $('#conversation_list').html('');
                response['conversation'].forEach(data => {
                    if (data['conversation_id'] == convo_id) {
                        $('#chat_profile').attr('src', "/" + data['profile_image']);
                        $('#chat_name').html(data['name']);
                    }
                    $('#conversation_list').append(`
                    <div id="` +
                        data['conversation_id'] +
                        `" class="item d-flex align-items-center" style="column-gap: 10px" onclick="onConvoClick('` +
                        data['conversation_id'] + `');">
                        <div class="image">
                            <img src="/` + data['profile_image'] + `"
                                alt="" srcset="">
                        </div>
                        <div class="d-flex align-items-center w-100" style="justify-content: space-between">
                            <div>
                                <h6>` + data['name'] + `</h6>
                                <p class="last-chat" id="last_chat_` + data['conversation_id'] + `"></p>
                            </div>
                            <div class="time" id="time-${data['conversation_id']}">
                                ${timeAgo(new Date(data['last_message']['date_created']))}
                            </div>
                        </div>
                    </div>
                `);
                    $('#last_chat_' + data['conversation_id']).text(data['last_message']['body']);
                    pusher.subscribe('private-message.' + data['conversation_id']).bind(
                        'receive-message',
                        function(element) {
                            $('#last_chat_' + data['conversation_id']).text(element['body']);
                            $('#time-' + data['conversation_id']).text(timeAgo(new Date(element[
                                'date_created'])));
                            $(`#${data['conversation_id']}`).prependTo('#conversation_list');
                        });
                }, );
            }
        });
    }

    function onConvoClick($id) {
        window.location.href = '/school/messages/' + $id;
    }

    function displayMessages() {
        if (convo_id != null) {

        }
    }
    $('#send_message').click(function(e) {

        $.ajax({
            type: "POST",
            url: "/school/messages/" + convo_id,
            data: {
                'body': $('#message_content').val()
            },
            success: function(response) {
                if(response.code == 201){
                    displayConveration(convo_id);
                }
                console.log(response);
            }
        });

        $('#message_content').val("");
    });

    let msgListScrolling = false;
    $('#messages_container').on('scroll', function() {
        if ((($(this).scrollTop() +
                $(this).innerHeight() + 5)) >=
            $(this)[0].scrollHeight) {
            msgListScrolling = false;
        } else {
            msgListScrolling = true;
        }
    });

    function displayConversationMessages(id) {
        $.ajax({
            type: "POST",
            url: "/school/messages/" + id + "/retrieve",
            success: function(response) {

                response['messages'].forEach(element => {
                    let side = element['sender_id'] == user_current_id ? "right" : "left";
                    $('#messages_container').append(`
            <div class=` + side + `>
           
                <div style="margin-bottom:10px">
                <div class="content">
<pre id="content-` + element['id'] + `">
</pre>
                </div>
                <span style="display:none">${element['date_created']}</span>
                </div>
            </div>
        `);
                    $('#content-' + element['id']).text(element['body']);
                });
                $('#messages_container').animate({
                    scrollTop: $('#messages_container')[0].scrollHeight
                }, "fast");
            }

        });
    }
</script>
<script>
    pusher.subscribe('private-message.' + convo_id).bind('receive-message', function(element) {
        console.log(element);
        if (msgListScrolling == false) {
            $('#messages_container').animate({
                scrollTop: $('#messages_container')[0].scrollHeight
            }, "fast");
        }
        let side = element['sender_id'] == user_current_id ? "right" : "left";
        $('#messages_container').append(`
            <div class=` + side + `>
           
                <div style="margin-bottom:10px">
                <div class="content">
<pre id="content-` + element['id'] + `">
</pre>
                </div>
                <span style="display:none">${element['date_created']}</span>
                </div>
            </div>
        `);
        $('#content-' + element['id']).text(element['body']);
    });

    pusher.subscribe('private-newconvo.' + user_current_id).bind('new', function(element) {
        displayConveration(convo_id);
    });

    const timeAgo = (date) => {
        const seconds = Math.floor((new Date() - date) / 1000);

        let interval = Math.floor(seconds / 31536000);
        if (interval >= 1) {
            return interval + 'y';
        }

        interval = Math.floor(seconds / 2592000);
        if (interval >= 1) {
            return interval + 'mo';
        }

        interval = Math.floor(seconds / 86400);
        if (interval >= 1) {
            return interval + 'd';
        }

        interval = Math.floor(seconds / 3600);
        if (interval >= 1) {
            return interval + 'hr';
        }

        interval = Math.floor(seconds / 60);
        if (interval >= 1) {
            return interval + 'm';
        }

        if (seconds < 10) return 'now';

        return Math.floor(seconds) + 's';
    };
</script>
{{-- @vite('resources/js/app.js'); --}}



@include(SchoolFileHelper::$footer)
