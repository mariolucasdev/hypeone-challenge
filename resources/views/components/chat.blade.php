<div class="max-w-7xl mx-auto">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 flex">
            <div class="flex-1 w-120 col-xl-8 gap-2">
                <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-3"> {{ session()->get('title') }} </h3>

                <div id="chat" class="gap-3 overflow-auto mb-20"></div>
            </div>
        </div>
    </div>

    <div class="fixed m-auto bottom-0 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white w-full overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-3 flex flex-col text-gray-900">
                <input id="input-message" class="border-gray-300 rounded-md w-full p-3" type="text">
                <input id="input-chat-id" class="border-gray-300 rounded-md w-full p-3" value="{{ session()->get('chat_id') }}" type="hidden">
                <input id="input-username" class="border-gray-300 rounded-md w-full p-3" value="{{ session()->get('name') }}" type="hidden">
                <button id="button-send-message" class="bg-indigo-600 rounded-md p-2 text-white mt-2 w-full"> Enviar mensagem </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        getMessages();

        const chat = document.querySelector('#chat');
        const inputMessage = document.querySelector('#input-message')
        const buttonSendMessage = document.querySelector('#button-send-message')

        Echo.channel('chat')
            .listen('channelChat', (e) => {
                var inputUsername = document.querySelector('#input-username')

                if (e.user == inputUsername.value) {
                    chat.innerHTML += `<span class="float-right mt-5 font-semibold text-gray-500">${e.user}</span> <div my-3 class='w-full float-right bg-indigo-600 text-indigo-200 rounded-md text-right p-3'> ${e.message} </div>`
                } else {
                    chat.innerHTML += `<span class="float-left mt-5 font-semibold text-gray-500">${e.user}</span>
                                        <div my-3 class='w-full float-left bg-indigo-100 text-indigo-600 rounded-md text-left p-3'> ${e.message} </div>`
                }

                window.scrollTo(0, document.body.scrollHeight);
            });



        buttonSendMessage.addEventListener('click', sendMessage);

        async function getMessages() {
            var inputChatId = document.querySelector('#input-chat-id')
            await axios.get(`http://localhost:8000/api/message/${inputChatId.value}'`).then(function() {
                window.scrollTo(0, document.body.scrollHeight);
            });
        }

        function sendMessage(e) {
            e.preventDefault();
            var inputChatId = document.querySelector('#input-chat-id')

            message = inputMessage.value;
            axios.post('http://localhost:8000/api/message/store', {
                chat_id: inputChatId.value,
                content: message,
                username: 'Mário Lucas'
            }).then((response) => {
                if (response.status == 201) {
                    inputMessage.value = ''
                    window.scrollTo(0, document.body.scrollHeight);
                }
            })
        }
    })
</script>