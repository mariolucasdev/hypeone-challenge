<div class="max-w-7xl mx-auto  sm:px-6 lg:px-8">
    <div class="bg-white h-full py-12 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 flex">
            <div id="chat" class="flex-1 w-120 col-xl-8">
                <h3 class="font-semibold text-3xl text-gray-800 leading-tight mb-12"> Iniciar Novo Chat </h3>

                <label for="input-title">Assunto</label>
                <input id="input-title" placeholder="Dúvidas sobre produtos..." class="border-gray-300 rounded-md w-full p-3" type="text">
                <input id="input-name" type="text" {{ $attributes }} class="border-gray-300 rounded-md w-full p-3">
                <button id="button-create-chat" class="bg-indigo-600 rounded-md p-2 py-3 text-white mt-12 w-full"> Iniciar Chat </button>
            </div>
        </div>
    </div>
</div>

<script>
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
                console.log(response)
            })
        }
    })
</script>