<div class="row">
    <div id="box" class="chatbox chatbox22 chatbox--tray">
        <div class="chatbox__title">
            <h5><a href="javascript:void()" onclick="box(this)">Chat với chúng tôi</a></h5>
            <button class="chatbox__title__close">
                <span>
                    <svg viewBox="0 0 12 12" width="12px" height="12px">
                        <line stroke="#FFFFFF" x1="11.75" y1="0.25" x2="0.25" y2="11.75"></line>
                        <line stroke="#FFFFFF" x1="11.75" y1="11.75" x2="0.25" y2="0.25"></line>
                    </svg>
                </span>
            </button>
        </div>
        <div class="chatbox__body" id="chat-body">
            <div class="chatbox__body__message chatbox__body__message--left">
                <img src="<?= URL_ROOT . '/public/images/admin.png' ?>" alt="Picture">
                <div class="clearfix"></div>
                <div class="ul_section_full">
                    <ul class="ul_msg">
                        <li><strong>Admin</strong></li>
                        <li>Chào bạn, bạn cần shop tư vấn gì ạ?</li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="input-group">
                <input id="btn-input" type="text" required class="form-control input-sm chat_set_height" placeholder="Soạn tin nhắn..." tabindex="0" dir="ltr" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off" contenteditable="true" />
                <span class="input-group-btn">
                    <button class="btn bt_bg btn-sm" id="btn-chat" onclick="send()">
                        Gửi
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>
<script>
    function box() {
        document.getElementById('box').classList.toggle("chatbox--tray");
    }

    var element = document.getElementById("btn-input");
    element.addEventListener("keypress", function(event) {
        if (event.key === "Enter" && element.value != "") {
            send();
        }
    });

    function send() {
        var queries = document.getElementById('btn-input').value;
        document.getElementById('chat-body').innerHTML += '<div class="chatbox__body__message chatbox__body__message--right">' +
            '<img src="' + window.location + 'public/images/user.jpg" alt="Picture">' +
            '<div class="clearfix"></div>' +
            ' <div class="ul_section_full">' +
            ' <ul class="ul_msg">' +
            '<li><strong>Tui</strong></li>' +
            '<li>' + queries + '</li>' +
            '</ul>' +
            '<div class="clearfix"></div>' +
            '</div>' +
            '</div>';
        document.getElementById('btn-input').value = "";

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "http://localhost/luanvan/chat/send/" + queries, true);
        xhr.onload = function() {
            if (xhr.readyState === 4) {
                if (xhr.readyState === 4) {
                    var res = JSON.parse(this.responseText);
                    var replies = "";
                    if (res.length > 1) {
                        replies = "<li><b>Có " + res.length + " kết quả tìm thấy:</b></li>";
                    }
                    for (let index = 0; index < res.length; index++) {
                        if (res.length > 1) {
                            replies += '<li>' + (index + 1) + ') ' + res[index].replies + '</li>';
                        } else {
                            replies += '<li>' + res[index].replies + '</li>';
                        }
                    }

                    document.getElementById('chat-body').innerHTML += '<div class="chatbox__body__message chatbox__body__message--left">' +
                        '<img src="' + window.location + 'public/images/admin.png" alt="Picture">' +
                        '<div class="clearfix"></div>' +
                        ' <div class="ul_section_full">' +
                        ' <ul class="ul_msg">' +
                        '<li><strong>Admin</strong></li>' +
                        replies +
                        '</ul>' +
                        '<div class="clearfix"></div>' +
                        '</div>' +
                        '</div>';

                    var myDiv = document.getElementById('chat-body');
                    myDiv.scrollTop = 10000000;

                    // var status = xhr.status;
                    // if (status === 200) {
                    //     setTimeout(function() {
                    //         window.location.reload();
                    //     }, 1000);

                    // } else if (status === 501) {
                    //     alert('Số lượng sản phẩm không đủ để thêm vào giỏ hàng!');
                    //     // e.value = parseInt(e.value) - 1;
                    //     window.location.reload();
                    // } else {
                    //     alert('Cập nhật giỏ hàng thất bại!');
                    //     window.location.reload();
                    // }
                }
            }
        };
        xhr.onerror = function(e) {
            console.error(xhr.statusText);
        };
        xhr.send(null);
    }
</script>