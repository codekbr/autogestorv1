<x-guest-layout>
    <!-- component -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center bg-gray-200 ">
        <div class="relative sm:max-w-sm w-full">
            <div
                class="card bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br  hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 shadow-lg  w-full h-full rounded-3xl absolute  transform -rotate-6">
            </div>
            <div
                class="card bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 shadow-lg  w-full h-full rounded-3xl absolute  transform rotate-6">
            </div>
            <div class="relative w-full rounded-3xl  px-6 py-4 bg-gray-100 shadow-md">
                <label for="" class="block mt-3 text-sm text-gray-700 text-center font-semibold">
                    Entrar AutoGestor
                </label>
                <form method="POST" action="{{ route('login') }}">
                    @csrf


                    <div class="mt-7">
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                            autocomplete="username" placeholder="Email"
                            class="mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-7">
                        <x-text-input id="password" type="password" name="password" required
                            autocomplete="new-password" placeholder="Senha"
                            class="mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>





                    <div class="mt-7">
                        <button
                            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg w-full shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                            Entrar
                        </button>
                    </div>

                    <div class="flex mt-7 items-center text-center">
                        <hr class="border-gray-300 border-1 w-full rounded-md">
                        <label class="block font-medium text-sm text-gray-600 w-full">
                            Entrar com
                        </label>
                        <hr class="border-gray-300 border-1 w-full rounded-md">
                    </div>

                    <div class="flex mt-7 justify-center w-full">
                        <button
                            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">

                            Facebook
                        </button>

                        <button
                            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">

                            Google
                        </button>
                    </div>

                    <div class="mt-7">
                        <div class="flex justify-center items-center">
                            <label class="mr-2">Não possui uma conta?</label>
                            <a href="{{ route('register') }}"
                                class=" text-dark text-purple-500 font-bold transition duration-500 ease-in-out  transform hover:-translate-x hover:scale-105 ">
                                Registre - se
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-guest-layout>
