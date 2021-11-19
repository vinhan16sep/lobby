<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <title>Test chat</title>

    </head>
    <body>
        <div class="container" style="height: 100vh">
            <div class="d-flex justify-content-center align-items-center" style="height: 100%">
                <div class="card" style="width: 40vw">
                    <div class="card-header">
                        <h6>Chatbox</h6>
                    </div>
                    <div class="card-body" style="height: 400px; padding: 0.75rem; overflow-x: hidden; overflow-y: auto">
                        <div id="appendMessage"></div>
                    </div>
                    <div class="card-footer">
                        <div class="input-group">
                            <input type="text" class="form-control" id="inputMessage"/>
                            <button class="btn btn-primary" id="btnSendMessage" type="button">
                                Send
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>        
        <script>
            $(document).ready(function(){
                $('#inputMessage').on('keyup', function(e){
                    if(e.keyCode == 13){
                        $('#btnSendMessage').trigger('click')
                    }
                })

                $('#btnSendMessage').on('click', function(){
                    sendMessage()
                })
            })

            let currentUserId = 0;
            let data = {
                userId: 1,
                userName: 'User name',
                message: 'haha'
            }

            function receiveMessage(data){
                const $wrapper = $('#appendMessage');

                let $p = $('<p></p>')
                $p.data('user-id', data.userId)
                $p.append(`<b>${data.userName}:</b> ${data.message}`)

                $wrapper.append($p)
                $wrapper.parent().scrollTop(document.getElementById('appendMessage').scrollHeight)
            }

            let blockMessage = false;

            function sendMessage(){
                const $wrapper = $('#appendMessage');
                let message = $('#inputMessage').val();

                if(message == ''){
                    return
                }

                $wrapper.find('.block-message').remove();

                if(blockMessage){
                    $wrapper.append('<p class="block-message">Please wait for 1 min for next message</p>');
                    return;
                }

                blockMessage = true;

                let $p = $('<p></p>');
                $p.data('user-id', currentUserId)
                $p.append(`<b>Me:</b> ${message}`)

                $wrapper.append($p)
                $wrapper.parent().scrollTop(document.getElementById('appendMessage').scrollHeight)

                $('#inputMessage').val('');

                setTimeout(function(){
                    blockMessage = false
                }, 1000)
            }
        </script>
    </body>
</html>
