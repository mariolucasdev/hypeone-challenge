<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 flex">
            <div id="chat" class="flex-1 w-120 col-xl-8">
                <h3 class="font-semibold text-xl text-gray-800 leading-tight"> {{ session()->get('title') }} </h3>
            </div>
        </div>
    </div>

    <div class="w-full fixed m-auto bottom-0 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white w-full overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-3 flex flex-col text-gray-900">

                <input id="input-message" class="border-gray-300 rounded-md w-full p-3" type="text">
                <button id="button-send-message" class="bg-indigo-600 rounded-md p-2 text-white mt-2 w-full"> Enviar mensagem </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var chat = document.querySelector('#chat');

        Echo.channel('chat')
            .listen('channelChat', (e) => {
                chat.innerHTML += "<div class='bg-indigo-300 p-3'>" + e.message + "</div>"
            });


        var inputMessage = document.querySelector('#input-message')
        var buttonSendMessage = document.querySelector('#button-send-message')

        buttonSendMessage.addEventListener('click', sendMessage);

        function sendMessage(e) {
            e.preventDefault();
            message = inputMessage.value;
            axios.post('http://localhost:8000/api/message/store', {
                chat_id: 3,
                content: message,
                username: 'Mário Lucas'
            }).then((response) => {
                if (response.status == 201) {
                    inputMessage.value = ''
                }
            })
        }
    })
</script>