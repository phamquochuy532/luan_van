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
        <div class="chatbox__body">

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

    function send() {
        var queries = document.getElementById('btn-input').value;
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "http://localhost/luanvan/chat/send/" + queries, true);
        xhr.onload = function() {
            if (xhr.readyState === 4) {
                if (xhr.readyState === 4) {
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