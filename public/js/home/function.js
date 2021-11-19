let users = [];

$(document).ready(function () {
    for (let i = 0; i < 20; i++) {
        users.push({
            name: `User name ${i + 1}`,
            avatar: 'https://images.unsplash.com/photo-1541823709867-1b206113eafd?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=687&q=80',
            company: `Company ${i + 1}`,
            position: 'Employee',
            status: 1
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

            $('body').find('.user-info-wrapper.show').remove();

            let offset = $(this).offset();
            let userIndex = $(this).data('index');
            let userInfo = users[userIndex];

            if (userInfo) {
                let $card = $('.user-info-wrapper-prepare').clone().show();
                $card.removeClass('user-info-wrapper-prepare');

                $card.find('.user-avatar img').attr('src', userInfo.avatar != null ? userInfo.avatar : `https://ui-avatars.com/api/?name=${userInfo.name}`);
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

                        $chatBox.data('user-id', userInfo.id);
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

    getListUsers();

    initChatBox('.chat-public');
});

function getListUsers() {
    const $wrapper = $('#appendListUsers');
    $wrapper.empty();

    if (users.length > 0) {
        users.forEach((user, index) => {
            let $item = $('.select-user-prepare').clone().show();
            $item.removeClass('select-user-prepare');

            $item.data('index', index);

            $item.find('img').attr('src', user.avatar != null ? user.avatar : `https://ui-avatars.com/api/?name=${user.name}`);
            $item.find('img').attr('alt', `Avatar of ${user.name}`);

            if (user.status) {
                $item.find('.circle').addClass('bg-success');
            }

            $wrapper.append($item);
        });
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
}

let blockMessage = false;

function sendChatMessage(wrapper) {
    const $append = $(wrapper).find('.append-message');
    const $input = $(wrapper).find('.input-message');
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

    blockMessage = true;

    $input.val('');

    $append.scrollTop($(wrapper).find('.append-message')[0].scrollHeight);

    setTimeout(function () {
        blockMessage = false;
    }, 1000);

    setTimeout(function () {
        for (let i = 0; i < 2; i++) {
            receiveChatMessage(wrapper, messageFormData);
        }
    }, 1000);
}

let messageFormData = {
    id: 1,
    name: 'User name',
    avatar: 'https://images.unsplash.com/photo-1558507652-2d9626c4e67a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=687&q=80',
    message: 'Hello World!'
};

function receiveChatMessage(wrapper, data) {
    const $append = $(wrapper).find('.append-message');

    let userId = data.id;
    let userAvatar = data.avatar != null ? data.avatar : `https://ui-avatars.com/api/?name=${data.name}`;

    let $chatWrap = $(`
        <div class="chat-item" data-sender-id="${userId}">
            <div class="item-avatar">
                <div class="img-mask img-mask-circle">
                    <img src="${userAvatar}" alt="Avatar of ${data.name}">
                </div>
            </div>

            <div class="item-content">
                <p class="p-name">
                    ${data.name}
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
