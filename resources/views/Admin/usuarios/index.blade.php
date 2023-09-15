<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuários') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex ...">
                <div class="grow h-14 ...">
                </div>
                <div class="flex-none w-34 h-14 ...">
                    <a href="{{ route('admin.createPermissions') }}"
                        class="text-white bg-gradient-to-r from-green-500 via-green-600 to-green-700
                                hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300
                                font-medium rounded-md text-sm px-8 py-2.5 text-center mr-2 mb-2">Permissões
                        Usuário
                    </a>
                </div>
            </div>
            <div class="bg-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 bg-gray-700 text-white ">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Nome
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tipo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Data Criação
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Data Atualização
                                </th>
                                <th class="text-center">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="bg-gray-200 border-b  ">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                        {{ $user->name }}
                                    </th>
                                    <td class="px-6 py-4 ">
                                        <ul>
                                            @foreach ($user->roles as $role)
                                                <li
                                                    class="{{ $role->name === 'admin' ? 'text-red-500 font-bold' : 'font-bold text-blue-500' }}">
                                                    {{ $role->name === 'admin' ? 'Administrador' : 'Comum' }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('m/d/Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($user->updated_at)->format('m/d/Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button type="button" onclick="abreModal('{{ $user }}', this)"
                                            data-userPermissions="{{ $user->permissions }}"
                                            class="
                                            open-btn
                                            text-white
                                            bg-gradient-to-r
                                            from-indigo-500 via-indigo-600 to-indigo-700 hover:bg-gradient-to-br
                                            focus:ring-4 focus:outline-none focus:ring-indigo-300
                                            font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                            Editar Permissões
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            !alertify.customModal && alertify.dialog('customModal', function factory() {
                var placeholder = null
                return {
                    main: function(content) {

                        if (content instanceof HTMLElement && content.parentNode) {
                            placeholder = placeholder || document.createComment('')
                            content.parentNode.insertBefore(placeholder, content)
                        }
                        this.setContent(content);
                    },
                    setup: function() {
                        return {

                            focus: {
                                element: 0
                            },
                            options: {
                                transition: true,
                                resizable: false,
                            }
                        };
                    },
                }
            });

            function updatePermission(input, usuario, permissao) {
                if (input.dataset.originalChecked === undefined) {
                    input.dataset.originalChecked = input.checked;
                }
                alertify.confirm('Deseja realmente realizar essa configuração ?', 'Confirmar',
                    function() {
                        let data = {
                            permission_id: permissao,
                            checked: input.checked,
                            _token: "{{ csrf_token() }}"
                        };
                        var url = "{{ route('admin.updatePermissionUser', ':id') }}";
                        url = url.replace(':id', usuario);
                        $.ajax({
                            type: 'PUT',
                            url: url,
                            contentType: 'application/json',
                            data: JSON.stringify(data), // access in body
                        }).done(function(msg) {
                            alertify.notify(msg.success, 'success', 5, function() {
                                console.log('dismissed');
                            });
                        }).fail(function(msg) {
                            console.log('FAIL');
                        }).always(function(msg) {
                            console.log('ALWAYS');
                        });
                    },
                    function() {
                        input.checked = (input.checked ? input.dataset.originalChecked === true : input.dataset
                            .originalChecked !== false);

                        alertify.notify('Cancelado!', 'error');
                    }
                );
            }

            function abreModal(user, button, callbackfunction = null) {
                const usuario = JSON.parse(user);
                const permissions = {!! $permissions !!};
                const userPermissions = JSON.parse($(button).attr('data-userPermissions'));
                const permissionsPerColumn = 10;
                const customContent = [];
                for (let i = 0; i < permissions.length; i += permissionsPerColumn) {
                    const columnContent = permissions
                        .slice(i, i + permissionsPerColumn)
                        .map(item => {
                            const permissionExists = userPermissions.some(u => u.pivot.permission_id === item.id);
                            const checkboxId = `checkPermission_${usuario.id}_${item.id}`;
                            const isChecked = permissionExists ? 'checked' : '';
                            return `<label class="relative inline-flex items-center mr-5 cursor-pointer">
                            <input onchange="updatePermission(this, ${usuario.id}, ${item.id})"
                                id="${checkboxId}" type="checkbox" name="${checkboxId}" value=""
                                class="sr-only peer" ${isChecked}>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-1 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-purple-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900">${item.name}</span>
                        </label>`;
                        })
                        .join('');

                    customContent.push(`
                    <div class="grid grid-cols-2 gap-4 border p-4 mb-4">
                        ${columnContent}
                    </div>`);
                }
                if (customContent.length === 0) {
                    customContent.push(
                        ` <div class="grid grid-cols-1 gap-0 mt-7 text-blue-600  text-center justify-content-center p-4 mb-4">Nenhum Registro encontrado.</div>`
                    );
                }

                alertify.customModal(customContent.join(''), callbackfunction)
                    .set('title', 'Permissões para o Usuário:<span class="text-blue-500 font-bold"> ' + usuario.name +
                        '</span>')
                    .set('modalClass', 'ajs-button')
                    .set('onclose', () => location.reload());
            }
        </script>
    @endpush
</x-app-layout>
