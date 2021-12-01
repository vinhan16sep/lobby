let users = [];
// getListUsers();

$(document).ready(function () {
    // SCROLL TO LIVE EVENT
    if (typeof $('.event-item.live').offset() !== "undefined" && $('.tab-pane.active').offset() !== undefined) {
        $('.tab-pane.active')
            .stop()
            .animate({
                scrollTop: $('.event-item.live').offset().top - $('.tab-pane.active').offset().top
            });
    }

    $(document)
        .on('click', function (e) {
            if ($(e.target).parents('.user-info-wrapper').length == 0) {
                $('body').find('.user-info-wrapper.show').remove();
            }
        })
        .on('click', '.select-user', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const _this = this;

            $('body').find('.user-info-wrapper.show').remove();

            let offset = $(this).parent().offset();
            let id = $(this).data('user-id');
            let userInfo = users.find((usr) => {
                return usr.userId == id;
            });

            if (userInfo) {
                let $card = $('.user-info-wrapper-prepare').clone().show();
                $card.removeClass('user-info-wrapper-prepare');

                $card.find('.user-avatar img').attr('src', $(_this).find('img').attr('src'));
                $card.find('.user-avatar img').attr('alt', `Avatar of ${userInfo.name}`);

                $card.find('.user-name').text(userInfo.name);
                $card.find('.user-position').text(userInfo.position);
                $card.find('.user-company').text(userInfo.company);

                $card
                    .find('.btn-close-call')
                    .unbind()
                    .on('click', function () {
                        $card.remove();
                    });

                $card
                    .find('.btn-call-chat')
                    .unbind()
                    .on('click', function () {
                        const $chatBox = $('.chat-private');

                        $card.remove();

                        $chatBox.data('user-id', userInfo.userId);
                        $chatBox.find('h6').text(userInfo.name);

                        $chatBox.parents('.card').addClass('chat-area-collapsed');

                        $chatBox.find('.append-message').empty();
                        $chatBox.show();

                        $(_this).parent().find('.unread .circle').text(0);
                        $(_this).parent().find('.unread').hide();

                        initChatPrivate(userInfo.userId);
                    });

                $card.addClass('show');

                $card.css({
                    top: offset.top,
                    left: offset.left
                });

                $card.appendTo($('body'));
            }
        });

    $('.btn-close-chat').on('click', function () {
        $('.chat-private').removeData('user-id');
        $('.chat-private').parents('.card').removeClass('chat-area-collapsed');
        $('.chat-private').hide();
    });

    initChatBox('.chat-public');
    initChatBox('.chat-private');
});

function getListUsers(callback = false) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'GET',
        url: '/home/getListUsers',
        data: {
            _token: CSRF_TOKEN
        },
        success: (res) => {
            let dataUsers = JSON.parse(res.users);

            if (dataUsers.length > 0) {
                dataUsers.forEach((usr) => {
                    users.push({
                        userId: usr.id,
                        name: usr.name,
                        company: usr.company,
                        position: usr.position,
                        isAvailable: 0,
                        unread: 0
                    });
                });

                if (callback) {
                    callback();
                }
            }
        },
        error: () => {}
    });
}

function getUserUnread() {
    let socketUrl;

    if (typeof socket == 'undefined') {
        throw new Error('Can not find socket');
    }

    socketUrl = socket.io.uri;

    let url = `${socketUrl}/message/countUnread`;

    url = commonFunc.buildUrl(url, 'userId', currentUser.id);
    url = commonFunc.buildUrl(url, 'socketId', socket.id);

    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        crossDomain: true,
        success: function (res) {
            if (typeof res.response == 'object' && Object.keys(res.response).length > 0) {
                $.each(res.response, (id, count) => {
                    let user = users.find((usr) => {
                        return usr.userId == id;
                    });

                    if (user) {
                        user.unread = count;
                    }
                });
            }
        },
        error: () => {}
    });
}

function setUserReadMessage(id, callback = false) {
    let socketUrl;

    if (typeof socket == 'undefined') {
        throw new Error('Can not find socket');
    }

    socketUrl = socket.io.uri;

    let url = `${socketUrl}/message/setReadMessage`;

    url = commonFunc.buildUrl(url, 'userId', currentUser.id);
    url = commonFunc.buildUrl(url, 'socketId', socket.id);
    url = commonFunc.buildUrl(url, 'userPartner', id);

    $.ajax({
        url: url,
        method: 'POST',
        dataType: 'json',
        crossDomain: true,
        success: function (res) {
            if (res.response == 'Success' && callback) {
                callback();
            }
        },
        error: () => {}
    });
}

function reloadListUsers() {
    users.sort((a, b) => {
        return b.isAvailable - a.isAvailable;
    });

    renderListUsers();
}

function recvListUser(data) {
    getListUsers(() => {
        if (data.online.length > 0) {
            data.online.forEach((usr) => {
                let availableUser = users.find((user) => {
                    return user.userId == usr.userId;
                });

                availableUser.isAvailable = 1;
            });

            if (Object.keys(data.unread).length > 0) {
                $.each(data.unread, (id, count) => {
                    let user = users.find((usr) => {
                        return usr.userId == id;
                    });

                    if (user) {
                        user.unread = count;
                    }
                });
            }

            reloadListUsers();

            initChatPublic();
        }
    });
}

function addUser(data) {
    let user = users.find((usr) => {
        return usr.userId == data.userId;
    });

    user.isAvailable = 1;

    reloadListUsers();
}

function removeUser(data) {
    let user = users.find((usr) => {
        return usr.userId == data.userId;
    });

    user.isAvailable = 0;

    reloadListUsers();
}

function renderListUsers() {
    const $wrapper = $('#appendListUsers');
    $wrapper.empty();

    if (users.length > 0) {
        users.forEach((user) => {
            if (user.userId == currentUser.id) {
                return;
            }

            let $item = $('.select-user-prepare').clone().show();
            $item.removeClass('select-user-prepare');

            $item.find('.select-user').data('user-id', user.userId);

            $item.find('img').attr('src', user.avatar != null ? user.avatar : `https://ui-avatars.com/api/?name=${user.name}`);
            $item.find('img').attr('alt', `Avatar of ${user.name}`);

            $item.find('h6').text(user.name);

            if (user.isAvailable) {
                $item.find('.status .circle').addClass('bg-success');
            }

            if (user.unread > 0) {
                $item.find('.unread .circle').text(user.unread < 10 ? user.unread : '10+');
                $item.find('.unread').show();
            } else {
                $item.find('.unread .circle').text(0);
                $item.find('.unread').hide();
            }

            $wrapper.append($item);
        });
    }
}

const CHATLOG = {
    PUBLIC: 0,
    PRIVATE: 1
};

function initChatPublic() {
    getChatLogs(CHATLOG.PUBLIC);
}

function initChatPrivate(userId) {
    getChatLogs(CHATLOG.PRIVATE, userId);

    setUserReadMessage(userId, () => {
        let userInfo = users.find((usr) => {
            return usr.userId == userId;
        });

        if (userInfo) {
            userInfo.unread = 0;
        }
    });
}

let chatlogPerResponse = 14;

function loadChatDialog(type, data, prepend = false) {
    let $wrapper, $append;

    if (type == 0) {
        $wrapper = $('.chat-public');
        $append = $wrapper.find('.append-message');
    } else if (type == 1) {
        $wrapper = $('.chat-private');
        $append = $wrapper.find('.append-message');
    }

    $append.find('.chat-loading').remove();

    let limitStart, limitEnd;

    let $chatWrapPrepare = $(`
        <div class="chat-item">
            <div class="item-avatar">
                <div class="img-mask img-mask-circle">
                    <img src="" alt="">
                </div>
            </div>

            <div class="item-content">
                <p class="p-name"></p>

                <div class="content-chat"></div>
            </div>
        </div>
    `);

    if (prepend) {
        limitStart = 0;
        limitEnd = limitStart + chatlogPerResponse;

        if (limitEnd > data.length - 1) {
            limitEnd = data.length - 1;
        }

        for (let i = limitStart; i < limitEnd; i++) {
            let msg = data[i];

            let fromUser = users.find((usr) => {
                return usr.userId == msg.fromUser;
            });

            let $chatWrap = $chatWrapPrepare.clone();

            $chatWrap.find('.img-mask img').attr('src', fromUser.avatar != null ? fromUser.avatar : `https://ui-avatars.com/api/?name=${fromUser.name}`);
            $chatWrap.find('.img-mask img').attr('alt', `Avatart of ${fromUser.name}`);

            $chatWrap.find('.p-name').text(fromUser.name);
            $chatWrap.data('user-id', fromUser.id);

            if (type == CHATLOG.PRIVATE) {
                $chatWrap.find('.item-avatar').remove();
                $chatWrap.find('.p-name').remove();
            }

            if (type == CHATLOG.PUBLIC && msg.fromUser == currentUser.id) {
                $chatWrap.find('.item-avatar').remove();
                $chatWrap.find('.p-name').text('Me');
            }

            if (msg.fromUser == currentUser.id) {
                $chatWrap.addClass('chat-item-mine');
            }

            let a = i;
            let b = i + 1;
            if (b > limitEnd) {
                b = limitEnd;
            }

            if (data[a].fromUser != data[b].fromUser || data[b].fromUser != $append.find('.chat-item:first-child').data('user-id')) {
                $append.prepend($chatWrap);
            }

            let $message = $(`<p>${msg.content}</p>`);
            $message.data('time', msg.time);

            $message.prependTo($append.find('.chat-item:first-child').find('.content-chat'));
            $append.scrollTop(150);
        }
    } else {
        data = data.reverse();
        limitStart = data.length - chatlogPerResponse;
        limitEnd = data.length - 1;

        if (limitStart < 0) {
            limitStart = 0;
        }

        for (let i = limitStart; i <= limitEnd; i++) {
            let msg = data[i];

            let fromUser = users.find((usr) => {
                return usr.userId == msg.fromUser;
            });

            let $chatWrap = $chatWrapPrepare.clone();

            $chatWrap.find('.img-mask img').attr('src', fromUser.avatar != null ? fromUser.avatar : `https://ui-avatars.com/api/?name=${fromUser.name}`);
            $chatWrap.find('.img-mask img').attr('alt', `Avatart of ${fromUser.name}`);

            $chatWrap.find('.p-name').text(fromUser.name);

            $chatWrap.data('user-id', fromUser.id);

            if (type == CHATLOG.PRIVATE) {
                $chatWrap.find('.item-avatar').remove();
                $chatWrap.find('.p-name').remove();
            }

            if (type == CHATLOG.PUBLIC && msg.fromUser == currentUser.id) {
                $chatWrap.find('.item-avatar').remove();
                $chatWrap.find('.p-name').text('Me');
            }

            if (msg.fromUser == currentUser.id) {
                $chatWrap.addClass('chat-item-mine');
            }

            let a = i - 1;
            let b = i;
            if (a < limitStart) {
                a = limitStart;
            }

            if (data[a].fromUser != data[b].fromUser) {
                $append.append($chatWrap);
            }

            let $message = $(`<p>${msg.content}</p>`);
            $message.data('time', msg.time);

            $message.appendTo($append.find('.chat-item:last-child').find('.content-chat'));
            $append.scrollTop($wrapper.find('.append-message')[0].scrollHeight);
        }
    }
}

function initChatBox(wrapper) {
    $(wrapper)
        .find('.input-message')
        .on('keyup', function (e) {
            if (e.keyCode == 13) {
                $(wrapper).find('.btn-send-message').trigger('click');
            }
        });

    $(wrapper)
        .find('.btn-send-message')
        .on('click', function () {
            sendChatMessage(wrapper);
        });

    let timeoutLoadmore;

    $(wrapper)
        .find('.append-message')
        .on('scroll', function () {
            if ($(wrapper).find('.append-message').scrollTop() == 0) {
                let time = $(wrapper).find('.append-message .chat-item:first-child .content-chat p:first-child').data('time');
                let type, id;

                if (wrapper == '.chat-public') {
                    type = CHATLOG.PUBLIC;
                    id = currentUser.id;
                } else if (wrapper == '.chat-private') {
                    type = CHATLOG.PRIVATE;
                    id = $(wrapper).data('user-id');
                }

                getChatLogs(type, id, time);
            }
        });
}

function getChatLogs(type, id, time = false) {
    let chatLogs = [];

    let socketUrl;

    if (typeof socket == 'undefined') {
        throw new Error('Can not find socket');
    }

    socketUrl = socket.io.uri;

    let url = `${socketUrl}/message`;

    switch (type) {
        case CHATLOG.PUBLIC:
            url = `${url}/getGlobalMessage`;
            break;
        case CHATLOG.PRIVATE:
            url = `${url}/getMessage`;
            url = commonFunc.buildUrl(url, 'userPartner', id);
            break;
    }

    url = commonFunc.buildUrl(url, 'userId', currentUser.id);

    url = commonFunc.buildUrl(url, 'socketId', socket.id);

    if (time) {
        url = commonFunc.buildUrl(url, 'time', time);
    }

    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        crossDomain: true,
        success: function (res) {
            if (typeof res.response == 'object') {
                if (time) {
                    loadChatDialog(type, res.response, true);
                } else {
                    loadChatDialog(type, res.response);
                }
            }
        },
        error: () => {}
    });

    return chatLogs;
}

let blockMessage = false;

function sendChatMessage(wrapper) {
    const $append = $(wrapper).find('.append-message');
    const $input = $(wrapper).find('.input-message');

    let recvId = $(wrapper).data('user-id');

    let message = $input.val();

    if (message == '') {
        return;
    }

    $append.find('.chat-delay').remove();

    if (blockMessage) {
        $append.append('<p class="p-overline chat-delay">Please wait for 1 sec for next message</p>');
        $append.scrollTop($(wrapper).find('.append-message')[0].scrollHeight);
        return;
    }

    let $chatWrap = $(`
        <div class="chat-item chat-item-mine">
            <div class="item-content">
                <p class="p-name">
                    Me
                </p>
                <div class="content-chat"></div>
            </div>
        </div>
    `);

    const $box = $append.find('.chat-item.chat-item-mine:last-child');

    if ($box.length == 0) {
        $append.append($chatWrap);
    }

    let $span = $(`<p>${message}</p>`);
    $span.appendTo($append.find('.chat-item.chat-item-mine:last-child').find('.content-chat'));

    if (typeof recvId == 'undefined') {
        sendGlobalMessage(message);
    } else {
        sendPrivateMessage(message, recvId);
    }

    blockMessage = true;

    $input.val('');

    $append.scrollTop($(wrapper).find('.append-message')[0].scrollHeight);

    setTimeout(function () {
        blockMessage = false;
    }, 1000);
}

let messageFormData = {
    id: 1,
    message: 'Hello World!'
};

function receiveChatMessage(wrapper, data) {
    const $append = $(wrapper).find('.append-message');

    let userId = data.id;
    let user = users.find((usr) => {
        return usr.userId == userId;
    });

    if (user) {
        if (wrapper == '.chat-private') {
            if ($(wrapper).is(':visible') && $(wrapper).data('user-id') != userId) {
                $('#appendListUsers')
                    .find('.select-user-item')
                    .each(function () {
                        if ($(this).find('a.select-user').data('user-id') == userId) {
                            user.unread++;

                            $(this).find('.unread .circle').text(user.unread);
                            $(this).find('.unread').show();
                        }
                    });
                return;
            } else {
                $(wrapper).find('h6').text(user.name);
                $(wrapper).data('user-id', data.id);
                $(wrapper).parents('.card').addClass('chat-area-collapsed');
                $(wrapper).show();

                initChatPrivate(userId);
            }
        }

        let userAvatar = user.avatar != null ? user.avatar : `https://ui-avatars.com/api/?name=${user.name}`;

        let $chatWrap = $(`
            <div class="chat-item" data-sender-id="${userId}">
                <div class="item-avatar">
                    <div class="img-mask img-mask-circle">
                        <img src="${userAvatar}" alt="Avatar of ${user.name}">
                    </div>
                </div>

                <div class="item-content">
                    <p class="p-name">
                        ${user.name}
                    </p>

                    <div class="content-chat"></div>
                </div>
            </div>
        `);

        if (wrapper == '.chat-private') {
            $chatWrap.find('.item-avatar').remove();
            $chatWrap.find('.p-name').remove();
        }

        const $box = $append.find('.chat-item:last-child');

        if ($box.length == 0 || $box.data('sender-id') != userId) {
            $append.append($chatWrap);
        }

        let $span = $(`<p>${data.message}</p>`);
        $span.appendTo($append.find('.chat-item:last-child').find('.content-chat'));

        $append.scrollTop($(wrapper).find('.append-message')[0].scrollHeight);
    }
}

function addToWishlist(seminarId) {
    $.ajax({
        url: '/home/addToWishlist',
        method: 'GET',
        data: {
            seminarId: seminarId
        },
        success: function (res) {
            if (res.code == '200') {
                $('#followSuccessModal').modal('show');
                $('#btn-' + seminarId).prop('disabled', true);
                $('#btn-' + seminarId).text('Đang theo dõi');
            }
        }
    });
}

function getSeminarDetail(seminarId) {
    $.ajax({
        url: '/home/getSeminarDetail',
        method: 'GET',
        data: {
            seminarId: seminarId
        },
        success: function (res) {
            if (res.code == '200') {
                const $modal = $('#modalSeminarDetail');

                $modal.find('.modal-body').html(res.html);

                $modal.modal('show');
            }
        }
    });
}

function blockChatBox(block = true) {
    $('.chat-area .card').find('.card-block').removeClass('show');

    if (block) {
        $('.chat-area .card').find('.card-block').addClass('show');
    }
}
