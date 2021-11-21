let users = [];

getListUsers();

$(document).ready(function () {
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
                userInfo.unread = 0;

                $(_this).parent().find('.unread .circle').text(0);
                $(_this).parent().find('.unread').hide();

                let $card = $('.user-info-wrapper-prepare').clone().show();
                $card.removeClass('user-info-wrapper-prepare');

                $card.find('.user-avatar img').attr('src', $(_this).find('img').attr('src'));
                $card.find('.user-avatar img').attr('alt', `Avatar of ${userInfo.name}`);

                $card.find('.user-name').text(userInfo.name);
                $card.find('.user-position').text(userInfo.position);
                $card.find('.user-company').text(userInfo.company);

                $card
                    .find('.btn-call-chat')
                    .unbind()
                    .on('click', function () {
                        const $chatBox = $('.chat-private');

                        $card.remove();

                        $chatBox.data('user-id', userInfo.userId);
                        $chatBox.find('h6').text(userInfo.name);

                        $chatBox.parent().addClass('chat-area-collapsed');
                        $chatBox.show();

                        initChatBox('.chat-private');
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
        $('.chat-private').parent().removeClass('chat-area-collapsed');
        $('.chat-private').hide();
    });

    initChatBox('.chat-public');
});

function getListUsers() {
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

                users.sort((a, b) => {
                    return b.isAvailable - a.isAvailable;
                });

                renderListUsers();
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
    if (data.length > 0) {
        data.forEach((usr) => {
            let availableUser = users.find((user) => {
                return user.userId == usr.userId;
            });

            availableUser.isAvailable = 1;
        });

        reloadListUsers();
    }
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
                $item.find('.unread .circle').text(user.unread);
                $item.find('.unread').show();
            } else {
                $item.find('.unread .circle').text(0);
                $item.find('.unread').hide();
            }

            $wrapper.append($item);
        });
    }
}

function initChatBox(wrapper) {
    $(wrapper).find('.append-message').empty();

    // LOAD CHAT LOGS HERE
    // Do something...

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
                $(wrapper).parent().addClass('chat-area-collapsed');
                $(wrapper).show();

                initChatBox('.chat-private');
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
            }
        }
    });
}
