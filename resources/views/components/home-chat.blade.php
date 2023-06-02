<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white h-full py-6 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 flex">
            <div id="chat" class="flex-1 gap-3 w-120 col-xl-8">
                <h3 class="font-semibold text-3xl text-gray-800 leading-tight mb-12"> Iniciar Novo Chat </h3>

                <label for="input-title">Assunto</label>
                <input id="input-title" placeholder="Dúvidas sobre produtos..." class="border-gray-300 rounded-md w-full p-3" type="text">
                <button id="button-create-chat" class="bg-indigo-600 rounded-md p-2 py-3 text-white mt-2 w-full"> Iniciar Chat </button>
                <input id="input-name" type="hidden" {{ $attributes }} class="border-gray-300 rounded-md w-full p-3">
            </div>

        </div>
    </div>
</div>
<div class="max-w-7xl mx-auto mt-3 sm:px-6 lg:px-8">

    <h3 class="font-semibold text-3xl text-gray-800 leading-tight mb-4 mx-6"> Chats Ativos </h3>

    <div class=" h-full py-4 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="px-6 text-gray-900 flex">
            <div id="chats" class="flex-1 gap-3 w-120 col-xl-8"></div>
        </div>
    </div>

</div>

<script>
    async function joinChat(chatId) {
        await axios.get(`http://localhost:8000/api/chat/${chatId}/join`).then((response) => {
            return window.location.reload(true);
        })
    }

    document.addEventListener('DOMContentLoaded', function() {

        var inputTitle = document.querySelector('#input-title');
        var inputName = document.querySelector('#input-name');
        var buttonCreateChat = document.querySelector('#button-create-chat')

        buttonCreateChat.addEventListener('click', createChat)

        function createChat() {
            axios.post('http://localhost:8000/api/chat', {
                title: inputTitle.value,
                username: inputName.value,
            }).then((response) => {
                window.location.reload(true);
            })
        }

        async function getChatsActive() {

            var chatsContent = document.querySelector('#chats');

            await axios.get('http://localhost:8000/api/chats').then((response) => {

                var chats = response.data;

                chats.map(chat => {
                    chatsContent.innerHTML += `<div class="bg-white border p-2 mb-2">
                        <h3 class="font-semibold text-2xl"> ${ chat.title } </h3>
                        <p> Criado por <strong>${ chat.username }</strong></p>
                        <button onclick="joinChat(${chat.id})" class="bg-indigo-600 rounded-md p-1 py-1 text-white w-full mt-2"> Entrar </button>
                    </div>`;
                })
            })
        }

        getChatsActive();
    })
</script>