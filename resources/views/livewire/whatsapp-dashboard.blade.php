@section('title', 'Whatsapp Dashboard')
@section('scriptsrc')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.min.js"
        integrity="sha512-Xm9qbB6Pu06k3PUwPj785dyTl6oHxgsv9nHp7ej7nCpAqGZT3OZpsELuCYX05DdonFpTlBpXMOxjavIAIUwr0w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
<div class="container max-w-7xl mx-auto mb-96 font-inter" x-data="whatsappDashboard" x-init="initSocket()">
    <div class="container max-w-7xl mx-auto py-[20px] px-[35px] sm:py-[40px] sm:px-[70px]">
        <div class="mx-auto grid grid-cols-1 sm:grid-cols-3 gap-8">
            <div class="flex py-4 px-8 bg-white border-gray-500 rounded-lg shadow-lg">
                <div class="flex justify-center w-[60px] h-[60px] bg-[#e8e9ea] rounded-lg">
                    <svg class="self-center fill-current w-[25px] h-[25px] sm:w-[32px] sm:h-[32px] text-[#1f2937]"
                        xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
                        <path
                            d="M16 64C16 28.7 44.7 0 80 0H304c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H80c-35.3 0-64-28.7-64-64V64zM224 448a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM304 64H80V384H304V64z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xl sm:text-2xl text-[#bcc1c9]">Total Device</p>
                    <p class="text-xl sm:text-2xl font-semibold text-[#1f2937]"><span x-text="totalDevice"></span></p>
                </div>
            </div>
            <div class="flex py-4 px-8 bg-white border-gray-500 rounded-lg shadow-lg">
                <div class="flex justify-center w-[60px] h-[60px] bg-[#e8e9ea] rounded-lg">
                    <svg class="self-center fill-current w-[25px] h-[25px] sm:w-[32px] sm:h-[32px] text-[#1f2937]"
                        xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
                        <path
                            d="M416 176c0 97.2-93.1 176-208 176c-38.2 0-73.9-8.7-104.7-23.9c-7.5 4-16 7.9-25.2 11.4C59.8 346.4 37.8 352 16 352c-6.9 0-13.1-4.5-15.2-11.1s.2-13.8 5.8-17.9l0 0 0 0 .2-.2c.2-.2 .6-.4 1.1-.8c1-.8 2.5-2 4.3-3.7c3.6-3.3 8.5-8.1 13.3-14.3c5.5-7 10.7-15.4 14.2-24.7C14.7 250.3 0 214.6 0 176C0 78.8 93.1 0 208 0S416 78.8 416 176zM231.5 383C348.9 372.9 448 288.3 448 176c0-5.2-.2-10.4-.6-15.5C555.1 167.1 640 243.2 640 336c0 38.6-14.7 74.3-39.6 103.4c3.5 9.4 8.7 17.7 14.2 24.7c4.8 6.2 9.7 11 13.3 14.3c1.8 1.6 3.3 2.9 4.3 3.7c.5 .4 .9 .7 1.1 .8l.2 .2 0 0 0 0c5.6 4.1 7.9 11.3 5.8 17.9c-2.1 6.6-8.3 11.1-15.2 11.1c-21.8 0-43.8-5.6-62.1-12.5c-9.2-3.5-17.8-7.4-25.2-11.4C505.9 503.3 470.2 512 432 512c-95.6 0-176.2-54.6-200.5-129zM228 72c0-11-9-20-20-20s-20 9-20 20V86c-7.6 1.7-15.2 4.4-22.2 8.5c-13.9 8.3-25.9 22.8-25.8 43.9c.1 20.3 12 33.1 24.7 40.7c11 6.6 24.7 10.8 35.6 14l1.7 .5c12.6 3.8 21.8 6.8 28 10.7c5.1 3.2 5.8 5.4 5.9 8.2c.1 5-1.8 8-5.9 10.5c-5 3.1-12.9 5-21.4 4.7c-11.1-.4-21.5-3.9-35.1-8.5c-2.3-.8-4.7-1.6-7.2-2.4c-10.5-3.5-21.8 2.2-25.3 12.6s2.2 21.8 12.6 25.3c1.9 .6 4 1.3 6.1 2.1l0 0 0 0c8.3 2.9 17.9 6.2 28.2 8.4V280c0 11 9 20 20 20s20-9 20-20V266.2c8-1.7 16-4.5 23.2-9c14.3-8.9 25.1-24.1 24.8-45c-.3-20.3-11.7-33.4-24.6-41.6c-11.5-7.2-25.9-11.6-37.1-15l-.7-.2c-12.8-3.9-21.9-6.7-28.3-10.5c-5.2-3.1-5.3-4.9-5.3-6.7c0-3.7 1.4-6.5 6.2-9.3c5.4-3.2 13.6-5.1 21.5-5c9.6 .1 20.2 2.2 31.2 5.2c10.7 2.8 21.6-3.5 24.5-14.2s-3.5-21.6-14.2-24.5c-6.5-1.7-13.7-3.4-21.1-4.7V72z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xl sm:text-2xl  text-[#bcc1c9]">Total Message</p>
                    <p class="text-xl sm:text-2xl font-semibold text-[#1f2937]"><span x-text="totalMessage"></span></p>
                </div>
            </div>
            <div class="flex py-4 px-8 bg-white border-gray-500 rounded-lg shadow-lg">
                <div class="flex justify-center w-[60px] h-[60px] bg-[#e8e9ea] rounded-lg">
                    <svg class="self-center fill-current w-[25px] h-[25px] sm:w-[32px] sm:h-[32px] text-[#1f2937]"
                        xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
                        <path
                            d="M54.2 202.9C123.2 136.7 216.8 96 320 96s196.8 40.7 265.8 106.9c12.8 12.2 33 11.8 45.2-.9s11.8-33-.9-45.2C549.7 79.5 440.4 32 320 32S90.3 79.5 9.8 156.7C-2.9 169-3.3 189.2 8.9 202s32.5 13.2 45.2 .9zM320 256c56.8 0 108.6 21.1 148.2 56c13.3 11.7 33.5 10.4 45.2-2.8s10.4-33.5-2.8-45.2C459.8 219.2 393 192 320 192s-139.8 27.2-190.5 72c-13.3 11.7-14.5 31.9-2.8 45.2s31.9 14.5 45.2 2.8c39.5-34.9 91.3-56 148.2-56zm64 160a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xl sm:text-2xl text-[#bcc1c9]">Device Connected</p>
                    <p class="text-xl sm:text-2xl font-semibold text-[#1f2937]"><span x-text="totalDevice"></span></p>
                </div>
            </div>

        </div>
    </div>
    <div class="container max-w-7xl mx-auto py-[20px] px-[35px] sm:px-[70px] sm:py-[40px]">
        <div class="container max-w-7xl mx-auto bg-white border border-white rounded-lg shadow py-4 px-8">
            <div class="flex justify-between">
                <h4 class="text-xl font-bold self-center ">Devices</h4>
                <div class="flex flex-col sm:flex-row sm:justify-between space-y-2 sm:space-x-2 sm:space-y-0">
                    <button x-on:click="showModalPassword = !showModalPassword;"
                        class="flex justify-between space-x-2 bg-lime-600 rounded-md py-[8px] px-[16px] border border-lime-600 hover:scale-95 hover:opacity-75 transition ease-in">
                        <svg class="self-center fill-current w-[15px] h-[15px] text-white"
                            xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512">
                            <path
                                d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c1.8 0 3.5-.2 5.3-.5c-76.3-55.1-99.8-141-103.1-200.2c-16.1-4.8-33.1-7.3-50.7-7.3H178.3zm308.8-78.3l-120 48C358 277.4 352 286.2 352 296c0 63.3 25.9 168.8 134.8 214.2c5.9 2.5 12.6 2.5 18.5 0C614.1 464.8 640 359.3 640 296c0-9.8-6-18.6-15.1-22.3l-120-48c-5.7-2.3-12.1-2.3-17.8 0zM591.4 312c-3.9 50.7-27.2 116.7-95.4 149.7V273.8L591.4 312z" />
                        </svg>
                        <p class="text-white">Update Pass</p>
                    </button>
                    <button x-on:click="showModalQr = !showModalQr;"
                        class="flex justify-between space-x-2 bg-[#1f2937] rounded-md py-[8px] px-[16px] border border-[#1f2937] hover:scale-95 hover:opacity-75 transition ease-in">
                        <svg class="self-center fill-current w-[15px] h-[15px] text-white"
                            xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                            <path
                                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                        </svg>
                        <p class="text-white">Add Device</p>
                    </button>
                </div>
            </div>
            <hr class="my-3 border border-gray-400" />
            <div class="relative w-full overflow-auto">
                <table class="caption-bottom text-sm w-full rounded-lg overflow-hidden shadow-md bg-white">
                    <thead class="[&amp;_tr]:border-b">
                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                            <th
                                class="h-12 px-4 text-left align-middle font-bold text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 w-1/3">
                                Device Name
                            </th>
                            <th
                                class="h-12 px-4 align-middle font-bold text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 w-1/3 text-center">
                                Total Message
                            </th>
                            <th
                                class="h-12 px-4 text-center align-middle font-bold text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 w-1/3">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="[&amp;_tr:last-child]:border-0">
                        <template x-for="(data,index) in $wire.listCollections" :key="index">
                            <tr class="border-b hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-semibold"><span
                                        x-text="data.token"></span></td>
                                <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 text-center"><span
                                        x-text="data.quota"></span></td>
                                <td
                                    class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-semibold flex justify-center space-x-2">
                                    <template x-if="!data.is_active">
                                        <button x-on:click="useInstanceFunc(data.token)"
                                            class="justify-center rounded-md text-sm font-medium ring-offset-background  focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-green-600 text-white hover:opacity-75 hover:scale-95 transition ease-in h-10 px-4 py-2 w-full">
                                            Gunakan
                                        </button>
                                    </template>
                                    <button x-on:click="deleteInstanceStep(data.token)"
                                        class="justify-center rounded-md text-sm font-medium ring-offset-background  focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-red-600 text-white hover:opacity-75 hover:scale-95 transition ease-in h-10 px-4 py-2 w-full">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="whatsapp-modal" tabindex="-1"
            class="fixed top-0 left-0 right-0 z-40  w-full px-4 pt-5 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
            x-show="showModalQr" x-cloak>
            <div class="fixed top-0 left-0 right-0 bottom-0 backdrop-blur-sm bg-black/30"></div>
            <div class="mx-auto max-w-md relative w-full max-h-full" x-show="showModalQr"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <button type="button" x-on:click="showModalQr=!showModalQr;"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                            Add Device Form
                        </h3>
                        <hr class="border-gray-500 w-full" />
                        <form class="" action="#" x-on:submit.prevent='createInstanceFunc()'
                            method="POST">
                            <template x-if="!qrCode">
                                <div class="my-3">
                                    <label for="deviceName"
                                        class="block text-sm font-medium leading-6 text-gray-900 mt-2">
                                        Device Name
                                    </label>
                                    <input type="text" name="name" id="deviceName"
                                        class="block w-full rounded-md border border-gray-300 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-4 cursor-pointer"
                                        x-model="deviceName" placeholder="Whatsapp_bot">
                                </div>
                            </template>
                            <template x-if="qrCode">
                                <div class="w-full flex flex-col justify-center">
                                    <h3 class="text-center text-lg font-semibold text-black">Device Name: <span
                                            x-text="deviceName"></span></h3>
                                    <img :src="qrCode" alt="" srcset=""
                                        class="object-cover object-center">
                                </div>
                            </template>
                            <button type="submit" :disabled="!deviceName || qrCode != ''"
                                class="w-full text-white bg-green-main border border-green-main  font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-4 hover:bg-transparent hover:text-green-main hover:scale-95 active:scale-90 transition ease-in disabled:opacity-50 disabled:pointer-events-none">
                                <span x-text="'Generate QRCode'"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="password-modal" tabindex="-1"
            class="fixed top-0 left-0 right-0 z-40  w-full px-4 pt-5 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
            x-show="showModalPassword" x-cloak>
            <div class="fixed top-0 left-0 right-0 bottom-0 backdrop-blur-sm bg-black/30"></div>
            <div class="mx-auto max-w-md relative w-full max-h-full" x-show="showModalPassword"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <button type="button" x-on:click="showModalPassword=!showModalPassword;"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                            Update Password Form
                        </h3>
                        <hr class="border-gray-500 w-full" />
                        <form class="" action="#" x-on:submit.prevent='' method="POST">
                            <div class="my-3">
                                <label for="oldPassword"
                                    class="block text-sm font-medium leading-6 text-gray-900 mt-2">
                                    Old Password
                                </label>
                                <input type="text" name="name" id="oldPassword"
                                    class="block w-full rounded-md border border-gray-300 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-4 cursor-pointer">
                            </div>
                            <div class="my-3">
                                <label for="newPassword"
                                    class="block text-sm font-medium leading-6 text-gray-900 mt-2">
                                    New Password
                                </label>
                                <input type="text" name="name" id="newPassword"
                                    class="block w-full rounded-md border border-gray-300 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-4 cursor-pointer">
                            </div>
                            <button type="submit" x-on:click="isQrGenerated=true"
                                class="w-full text-white bg-green-main border border-green-main  font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-4 hover:bg-transparent hover:text-green-main hover:scale-95 active:scale-90 transition ease-in">
                                <span x-text="'Update Password'"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="delete-modal" tabindex="-1"
            class="fixed top-0 left-0 right-0 z-40  w-full px-4 pt-5 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
            x-show="showDeleteModal"
            x-cloak>
            <div class="fixed top-0 left-0 right-0 bottom-0 backdrop-blur-sm bg-black/30"></div>
            <div class="mx-auto max-w-md relative w-full max-h-full"
            x-show="showDeleteModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            >
                <!-- Modal content -->
                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                    <button type="button"
                        x-on:click="showDeleteModal = false"
                        class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="deleteModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <p class="mb-4 text-gray-500 dark:text-gray-300">Apakah kamu yakin ingin melakukan delete pada instance ini?</p>
                    <div class="flex justify-center items-center space-x-4">
                        <button data-modal-toggle="deleteModal" type="button"
                            x-on:click="showDeleteModal = false"
                            class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            No, cancel
                        </button>
                        <button type="button"
                            x-on:click="deleteInstanceFunc(deleteInstance)"
                            class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                            Yes, I'm sure
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
    @script
        <script>
            Alpine.data('whatsappDashboard', () => {
                return {
                    deviceName: '',
                    deleteInstance:'',
                    showDeleteModal:false,
                    totalDevice:$wire.listCollections.length,
                    totalMessage: $wire.totalQuota,
                    showModalQr: false,
                    showModalPassword: false,
                    isQrGenerated: false,
                    qrCode: '',
                    socket: null,
                    initSocket() {
                        const socket = io('{{ env("WHATSAPP_URL") }}')
                        socket.on('connected', () => {
                            this.socket = socket
                            console.log('connected')
                        })
                        socket.on('message', (data) => {
                            console.log('message:', data)
                        })
                        socket.on('qrcode', async (data) => {
                            if (data.status) {
                                this.qrCode = data.qrcode
                                iziToast.success({
                                    title: 'Success',
                                    message: data.message,
                                    position: 'topRight'
                                })
                                return;
                            }
                            iziToast.error({
                                title: 'Error',
                                message: data.message,
                                position: 'topRight'
                            })
                            this.showModalQr = false
                        })
                        socket.on('qrCodeSuccess', async (data) => {
                            if (data.status) {
                                await $wire.getListCollection();
                                this.totalDevice = $wire.listCollections.length
                                iziToast.success({
                                    title: 'Success',
                                    message: data.message,
                                    position: 'topRight'
                                })
                                this.showModalQr = false
                            }
                        })
                    },
                    loadingConfigToast: {
                        title: 'Please wait...',
                        color: '#164138',
                        position: 'topRight',
                        overlay: true,
                        image: "{{ asset('assets/images/puff.svg') }}",
                        timeout: false,
                        close: false,
                        class: 'loadingrefresh',
                    },
                    async useInstanceFunc(instanceName) {
                        iziToast.show(this.loadingConfigToast)
                        let response = await $wire.useInstance(instanceName)
                        iziToast.hide({}, document.querySelector('.loadingrefresh'))
                        if (response.status) {
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight'
                            })
                            return;
                        }
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight'
                        })
                    },
                    deleteInstanceStep(instanceName){
                        this.showDeleteModal = true
                        this.deleteInstance = instanceName
                    },
                    async deleteInstanceFunc(instanceName) {
                        iziToast.show(this.loadingConfigToast)
                        let response = await $wire.deleteInstance(instanceName);
                        this.totalDevice = $wire.listCollections.length
                        iziToast.hide({}, document.querySelector('.loadingrefresh'))
                        if (response.status) {
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight'
                            })
                            this.showDeleteModal = false
                            this.deleteInstance = ''
                            return;
                        }
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight'
                        })
                        this.showDeleteModal = false
                        this.deleteInstance = ''
                    },
                    async createInstanceFunc() {
                        let instanceName = this.deviceName
                        iziToast.show(this.loadingConfigToast)
                        let response = await $wire.createInstance(instanceName);
                        iziToast.hide({}, document.querySelector('.loadingrefresh'))
                        if (response.status) {
                            this.socket.emit('joinRoom', {
                                room: instanceName
                            })
                            iziToast.success({
                                title: 'Success',
                                message: response.message,
                                position: 'topRight'
                            })
                            return;
                        }
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight'
                        })
                    }
                }
            })
        </script>
    @endscript
@endsection
