<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissões') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto ">

            <div class="hidden space-x-8  sm:flex">
                <div class="flex-none w-34 h-14 ...">
                    <a href="{{ route('admin.indexUsers') }}"
                        class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700
                                hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300
                                font-medium rounded-md text-sm px-8 py-2.5 text-center mr-2 mb-2">Voltar

                    </a>
                </div>
            </div>
            @if ($message = Session::get('success'))
                <div class="bg-lime-100 border mt-10 border-lime-400 text-lime-700 px-4 py-3 rounded relative"
                    id="alert" role="alert">
                    <strong class="font-bold">Successo!</strong>
                    <span class="block sm:inline">{{ $message }}</span>
                    <span id="close-btn" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-lime-500" role="button"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            @endif
            <form action="{{ route('admin.storePermissions') }}" method="POST">
                @csrf
                @method('POST')
                @if (count($permissoesDisponiveis) > 0)
                    <div class="flex flex-wrap -mx-3 mb-6 mt-10">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900">Permissões</label>
                            <select id="name" name="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Selecione uma permissão</option>
                                @foreach ($permissoesDisponiveis as $chave => $description)
                                    <option value="{{ $chave }}">{{ $description }}</option>
                                @endforeach
                            </select>
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-row-reverse">
                        <button
                            class="cursor-pointer text-white bg-gradient-to-r hover:text-white from-lime-500 via-lime-600 to-lime-700
                    hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300
                    font-medium rounded-md text-sm px-8 py-2.5 text-center mr-2 mb-2">
                            Salvar
                        </button>
                    </div>
                @endif
            </form>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 bg-gray-700 text-white ">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Nome da Permissão
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Descrição da Permissão
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Data Criação
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Data Atualização
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allpermissoes as $permission)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                        {{ $permission->name }}
                                    </th>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                        {{ $permission->description ?? 'Nenhuma descrição atribuída' }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($permission->created_at)->format('m/d/Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($permission->updated_at)->format('m/d/Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('admin.deletePermissionUser', $permission->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="cursor-pointer text-white bg-gradient-to-r hover:text-white from-red-500 via-red-600 to-red-700
                                                            hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300
                                                            font-medium rounded-md text-sm px-8 py-2.5 text-center mr-2 mb-2">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>









            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-2">








            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            // Selecionar o botão e o elemento div
            const closeButton = document.getElementById("close-btn");
            const alertDiv = document.getElementById("alert");

            // Adicionar um ouvinte de evento de clique ao botão
            if (closeButton) {
                closeButton.addEventListener("click", function() {
                    // Ocultar o elemento div quando o botão for clicado
                    alertDiv.style.display = "none";
                });
            }
        </script>
    @endpush
</x-app-layout>
