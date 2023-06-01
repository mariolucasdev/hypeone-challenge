<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <div class="flex w-200 justify-center col-xl-8 gap-2 mb-2 pw-2">
        <h3 class="font-semibold text-xl text-gray-800 leading-tight"> {{ session()->get('title') }} </h3>
        <div class="text-right flex-1">
            <button id="button-close-chat" class="bg-gray-800 rounded-md p-2 text-white"> Finalizar Chat </button>
        </div>
    </div>

    <div class="bg-white w-full align-middle overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 justify-between">
            <div id="chat" class="gap-3 w-full overflow-auto mb-16"></div>
        </div>
    </div>


</div>
<div id="form-area" class="fixed mx-auto bottom-0 w-full bg-white p-3">
    <div class="flex-1 overflow-hidden sm:rounded-lg flex-col text-gray-900">
        <input id="input-message" class="border-gray-300 rounded-md w-full p-3" type="text">
        <input id="input-chat-id" class="border-gray-300 rounded-md w-full p-3" value="{{ session()->get('chat_id') }}" type="hidden">
        <input id="input-username" class="border-gray-300 rounded-md w-full p-3" value="{{ session()->get('username') }}" type="hidden">
        <button id="button-send-message" class="bg-indigo-600 rounded-md p-2 text-white mt-2 w-full"> Enviar mensagem </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const chat = document.querySelector('#chat');
        const inputMessage = document.querySelector('#input-message')
        const inputUsername = document.querySelector('#input-username')
        const inputChatId = document.querySelector('#input-chat-id')

        const buttonSendMessage = document.querySelector('#button-send-message')
        const buttonCloseChat = document.querySelector('#button-close-chat')
        const formChatArea = document.querySelector('#button-close-chat')

        buttonSendMessage.addEventListener('click', sendMessage);
        buttonCloseChat.addEventListener('click', closeChat);

        Echo.private(`chat.${inputChatId.value}`)
            .listen('ChannelMessage', (e) => render(e))
        // .listen(`chats.${inputChatId.value}.closed`, (e) => {
        //     buttonCloseChat.hide()
        //     formChatArea.hide()
        //     console.log(e)
        // })


        // Echo.channel('chat')
        //     .listen('channelChat', (e) => {

        //         if (e.user == inputUsername.value) {
        //             chat.innerHTML += `<span class="float-right mt-5 font-semibold text-gray-500">${e.user}</span> <div my-3 class='w-full float-right bg-indigo-600 text-indigo-200 rounded-md text-right p-3'> ${e.message} </div>`
        //         } else {
        //             chat.innerHTML += `<span class="float-left mt-5 font-semibold text-gray-500">${e.user}</span>
        //                                 <div my-3 class='w-full float-left bg-indigo-100 text-indigo-600 rounded-md text-left p-3'> ${e.message} </div>`
        //         }
        //         window.scrollTo(0, document.body.scrollHeight);
        //     });

        function render(message) {
            if (message.username == inputUsername.value) {
                chat.innerHTML += `<span class="float-right mt-5 font-semibold text-gray-500">${message.username}</span> <div my-3 class='w-full float-right bg-indigo-600 text-indigo-200 rounded-md text-right p-3'> ${message.content} </div>`
            } else {
                chat.innerHTML += `<span class="float-left mt-5 font-semibold text-gray-500">${message.username}</span>
                                            <div my-3 class='w-full float-left bg-indigo-100 text-indigo-600 rounded-md text-left p-3'> ${message.content} </div>`
            }

            window.scrollTo(0, document.body.scrollHeight);
        }

        async function getMessages() {
            await axios.get(`http://localhost:8000/api/message/${inputChatId.value}`).then(response => {
                response.data.map(message => render(message))
            });
        }

        async function sendMessage(e) {
            e.preventDefault();

            message = inputMessage.value;

            await axios.post('http://localhost:8000/api/message/store', {
                chat_id: inputChatId.value,
                content: message,
                username: inputUsername.value
            }).then(
                function(response) {
                    if (response.status == 201) {
                        inputMessage.value = ''
                        window.scrollTo(0, document.body.scrollHeight);
                    }
                })
        }

        function closeChat() {
            axios.put(`http://localhost:8000/api/chat/${inputChatId.value}/close`).then((response) => {
                if (response.status == 200) {
                    window.location.reload(true);
                }
            })
        }

        getMessages();
    })
</script>