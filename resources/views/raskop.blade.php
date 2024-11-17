@extends('layouts.mainlayout')
@section('title', 'Home')
@section('content')
    {{-- End Nav --}}
    <div x-data="Data()" x-cloak>
        <div x-show="isLoading" tabindex="-1"
            class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-black opacity-75 flex flex-col items-center justify-center">
            <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
        </div>
        <div class="container max-w-full h-[635px] relative"
            style="background: url('/assets/images/bg-logo2.png'); background-color: rgba(0, 0, 0, 0.4); background-blend-mode: multiply; ">
            <div
                class="absolute inset-0 flex items-center justify-center text-white text-[34px] font-bold font-['DM Sans'] tracking-[3.40px]">
                <p><span class="bg-[#E08756]">KENANG</span> MASANYA<br><span>SIMPAN <span class="bg-green-main">RASANYA</span>
                </p>
            </div>
        </div>
        <div class="container max-w-full mx-auto mt-4">
            <div class="container mx-auto">
                <div class="px-2 lg:px-1 grid grid-cols-1 xl:grid-cols-2 gap-5 lg:gap-3">
                    @foreach ($rooms as $ruangan)
                        <div class="grid grid-cols-1">
                            <div class="bg-cover bg-center h-[347px] rounded-md shadow-md overflow-hidden"
                                style="background-image:url('{{ $ruangan->getImage() }}')">
                                <div class="w-full h-full pt-60 pl-3 lg:pt-52 lg:pb-3 lg:pl-9 bg-black bg-opacity-30">
                                    <div class="w-[275px] lg:w-full">
                                        <h1 class="text-white text-3xl md:text-4xl font-extrabold">{{ $ruangan->room_name }}</h1>
                                        <button
                                            class="bg-green-main text-white text-center w-full lg:w-1/3 py-1.5 px-5 mt-3 rounded-md border border-green-main hover:bg-transparent hover:text-green-main hover:scale-95 transition duration-300 ease-in-out"
                                            type="button"
                                            x-on:click="showModal=true;selectedRoom='Ruangan Luar';roomId={{ $ruangan->id_room }}">Reservasi
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="px-1 lg:px-0">
                                <p class="text-justify">{{ $ruangan->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="container mx-auto mt-12">
            <div class="grid sm:grid-cols-1 xl:grid-cols-2 gap-[150px]">
                <div class="col-span-1 mt-8 p-4 md:p-auto">
                    <h2 class="text-6xl font-extrabold">
                        <span class="bg-green-main text-white"> RASA</span>
                        <span class="bg-[#E08756] text-white">KOPI</span>
                    </h2>
                    <div class="mt-6 text-justify text-sm md:text-base">
                        <p class="mt-4">
                            Selamat datang di kedai RASA KOPI, tempat di mana setiap tegukan membawa kenangan dan sentuhan bermakna. Berdiri sejak tahun 2019, RASA KOPI mempersembahkan kehangatan kopi dalam suasana yang santai dan penuh kenangan.
                        </p>
                        <p class="mt-6">
                            Terletak di Perumahan Palem 1 Residence, Dayeuhkolot, Bandung, kami dengan bangga menjadi bagian dari komunitas yang berkembang pesat di sekitar Telkom University Berawal dari hasrat untuk menciptakan tempat yang bukan hanya sekadar kedai kopi, tetapi juga menjadi panggung bagi pengalaman yang mendalam. Dengan kopi sebagai pusatnya, kami merintis perjalanan kami untuk memberikan lebih dari sekadar minuman; kami menciptakan kenangan yang tak terlupakan.
                        </p>
                    </div>
                </div>
                <div class="col-span-1 ">
                    <img src="{{ asset('assets/images/MAP.png') }}" class="" alt="Image">
                </div>
            </div>
        </div>
        {{-- modal start --}}
        <div id="reservasi-modal" tabindex="-1"
            class="fixed top-0 left-0 right-0 z-40  w-full px-4 pt-5 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
            x-show="showModal" x-cloak>
            <div class="fixed top-0 left-0 right-0 bottom-0 backdrop-blur-sm bg-black/30"></div>
            <div class="mx-auto max-w-md relative w-full max-h-full" x-show="showModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <button type="button" x-on:click="showModal=!showModal;"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Reservasi - <span
                                x-text="selectedRoom"></span>
                        </h3>
                        <form class="" action="#" x-on:submit.prevent='submitModalOrder' method="POST">
                            <div x-data="datepickers" x-init="[initDate(), getNoOfDays()]">
                                <label for="datepicker" class="block text-sm font-medium leading-6 text-gray-900">
                                    Tanggal
                                </label>
                                <div class="relative">
                                    <input type="hidden" name="date" x-ref="date" :value="datepickerValue" />
                                    <input type="text" id="datepicker" x-on:click="showDatepicker = !showDatepicker"
                                        x-model="datepickerValue" x-on:keydown.escape="showDatepicker = false"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-4 cursor-pointer"
                                        placeholder="Select date" readonly />
                                    <div class="absolute top-1.5 right-1 cursor-pointer"
                                        x-on:click="showDatepicker=!showDatepicker">
                                        <svg class="h-6 w-6 text-gray-700 hover:scale-105 hover:text-gray-400 transition-all ease-in"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="bg-white mt-12 rounded-lg shadow p-4 absolute top-0 left-0 w-full"
                                        x-show="showDatepicker" @click.away="showDatepicker = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="opacity-0 transform scale-90"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-90">
                                        <div class="flex justify-between items-center mb-2">
                                            <div>
                                                <span x-text="MONTH_NAMES[month]"
                                                    class="text-lg font-bold text-gray-800"></span>
                                                <span x-text="year"
                                                    class="ml-1 text-lg text-gray-600 font-normal"></span>
                                            </div>
                                            <div>
                                                <button type="button"
                                                    class="focus:outline-none focus:shadow-outline transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-100 p-1 rounded-full"
                                                    :class="{
                                                        'pointer-events-none opacity-25': month == todayMonth && year ==
                                                            todayYear
                                                    }"
                                                    x-on:click="decrementMonth">
                                                    <svg class="h-6 w-6 text-gray-400 inline-flex" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 19l-7-7 7-7" />
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                    class="focus:outline-none focus:shadow-outline transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-100 p-1 rounded-full"
                                                    x-on:click="incrementMonth">
                                                    <svg class="h-6 w-6 text-gray-400 inline-flex" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap mb-3 -mx-1">
                                            <template x-for="(day, index) in DAYS" :key="index">
                                                <div style="width: 14.26%" class="px-0.5">
                                                    <div x-text="day"
                                                        class="text-gray-800 font-medium text-center text-xs"></div>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="flex flex-wrap -mx-1">
                                            <template x-for="blankday in blankdays">
                                                <div style="width: 14.28%"
                                                    class="text-center border p-1 border-transparent text-sm"></div>
                                            </template>
                                            <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                                                <div style="width: 14.28%" class="px-1 mb-1">
                                                    <div x-on:click="selectDate(date);" x-text="date"
                                                        class="cursor-pointer text-center text-sm rounded-full leading-loose transition ease-in-out duration-100"
                                                        :class="{
                                                            'bg-indigo-200': isToday(date) == true,
                                                            'opacity-25 pointer-events-none': isDateFutureOrCurrent(
                                                                date) != true && isToday(date) != true,
                                                            'text-gray-600 hover:bg-indigo-200': isToday(date) ==
                                                                false &&
                                                                isSelectedDate(date) == false,
                                                            'bg-red-500 text-white hover:bg-opacity-75': isSelectedDate(
                                                                    date) ==
                                                                true
                                                        }">
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div x-show="isDateSelected">
                                    <div>
                                        <label for="starthours"
                                            class="block text-sm font-medium leading-6 text-gray-900 mt-2">
                                            Jam Mulai
                                        </label>
                                        <div
                                            class="block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-4 cursor-pointer">
                                            <div class="flex">
                                                <select name="starthours"
                                                    class="text-lg bg-transparent appearance-none outline-none"
                                                    x-model="selectedHour">
                                                    <template x-for="(time, index) in startHours"
                                                        :key="index">
                                                        <option x-model="time" class=""
                                                            x-text="time < 10 ? `0${time}`:time">
                                                        </option>
                                                    </template>
                                                </select>
                                                <span class="">:</span>
                                                <select name="startminutes"
                                                    class="text-lg bg-transparent appearance-none outline-none"
                                                    x-model="selectedMinute">
                                                    <template x-for="minutes in 60">
                                                        <option x-model="minutes" class=""
                                                            x-text="minutes = minutes < 11 ? `0${minutes-1}`:minutes-1">
                                                        </option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="endhour"
                                            class="block text-sm font-medium leading-6 text-gray-900 mt-2">
                                            Jam Selesai
                                        </label>
                                        <div
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 bg-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-4 pointer-events-none">
                                            <div class="flex">
                                                <select name="endhour"
                                                    class="pl-1 text-lg bg-transparent appearance-none outline-none">
                                                    <option x-text="parseInt(selectedHour)+3" selected></option>
                                                </select>
                                                <span class="">:</span>
                                                <select name="startminutes"
                                                    class="text-lg bg-transparent appearance-none outline-none">
                                                    <option x-text="selectedMinute" class=""></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div x-show="isDateSelected">
                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium leading-6 text-gray-900 mt-2">Nama</label>
                                    <div class="">
                                        <input type="text" name="name" id="name" autocomplete="name"
                                            class="block w-full rounded-md border border-gray-300 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-4 cursor-pointer"
                                            x-model="name">
                                    </div>
                                </div>
                                <div>
                                    <label for="phone"
                                        class="block text-sm font-medium leading-6 text-gray-900 mt-2">Nomer
                                        WhatsApp</label>
                                    <div class="">
                                        <input type="text" name="phone" id="phone" autocomplete="phone"
                                            class="block w-full rounded-md border border-gray-300 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-4 cursor-pointer"
                                            x-model="phone" placeholder="+62xxxxxx">
                                    </div>
                                </div>
                                <div>
                                    <label for="faculty"
                                        class="block text-sm font-medium leading-6 text-gray-900 mt-2">Fakultas</label>
                                    <div class="">
                                        <input type="text" name="faculty" id="faculty" autocomplete="faculty"
                                            class="block w-full rounded-md border border-gray-300 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-4 cursor-pointer"
                                            x-model="faculty" placeholder="FRI/Fakultas Rekayasa Industri">
                                    </div>
                                </div>
                                <div>
                                    <label for="totalperson"
                                        class="block text-sm font-medium leading-6 text-gray-900 mt-2">Jumlah Orang</label>
                                    <div class="">
                                        <input type="number" name="totalperson" id="totalperson"
                                            class="block w-full rounded-md border border-gray-300 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-4 cursor-pointer"
                                            x-model="totalPerson" placeholder="20">
                                    </div>
                                </div>
                                <div>
                                    <label for="order"
                                        class="block text-sm font-medium leading-6 text-gray-900 mt-2">Order</label>
                                    <div class="">
                                        <input type="text" name="order" id="order" autocomplete="order"
                                            class="block w-full rounded-md border border-gray-300 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-4 cursor-pointer"
                                            x-model="order">
                                    </div>
                                </div>
                                <div>
                                    <label for="note"
                                        class="block text-sm font-medium leading-6 text-gray-900 mt-2">note</label>
                                    <div class="">
                                        <textarea id="note" name="note" rows="3"
                                            class="block w-full rounded-md border border-gray-300 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 pl-4"
                                            placeholder="Raskop less ice" x-model="note"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-green-main border border-green-main  font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-4 hover:bg-transparent hover:text-green-main hover:scale-95 active:scale-90 transition ease-in">
                                Reservasi Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const loadingConfigToast = {
            title: 'Please wait...',
            color: '#164138',
            position: 'topRight',
            overlay: true,
            image: "{{ asset('assets/images/puff.svg') }}",
            timeout: false,
            close: false,
            class: 'loadingrefresh',
        };

        function navData() {
            return {
                showNav: false
            }
        }

        function Data() {
            return {
                showModal: false,
                selectedRoom: '',
                roomId: '',
                name: '',
                phone: '',
                faculty: '',
                totalPerson: '',
                order: '',
                note: '',
                selectedHour: '',
                selectedMinute: '',
                datepickerValue: "",
                isDateSelected: false,
                isLoading: false,
                datepickers() {
                    return {
                        showDatepicker: false,
                        month: "",
                        year: "",
                        todayMonth: "",
                        todayYear: "",
                        no_of_days: [],
                        startHours: [],
                        blankdays: [],
                        initDate() {
                            let today;
                            today = new Date();
                            this.month = today.getMonth();
                            this.year = today.getFullYear();
                            this.todayMonth = this.month;
                            this.todayYear = this.year;
                            // this.datepickerValue = this.formatDateForDisplay(
                            //     today
                            // );
                        },
                        formatDateForDisplay(date) {
                            let formattedDay = DAYS[date.getDay()];
                            let formattedDate = ("0" + date.getDate()).slice(
                                -2
                            ); // appends 0 (zero) in single digit date kepake
                            let formattedMonth = MONTH_NAMES[date.getMonth()];
                            let formattedMonthShortName =
                                MONTH_SHORT_NAMES[date.getMonth()];
                            let formattedMonthInNumber = (
                                "0" +
                                (parseInt(date.getMonth()) + 1)
                            ).slice(-2); //kepake
                            let formattedYear = date.getFullYear(); //kepake
                            return `${formattedDate}-${formattedMonthInNumber}-${formattedYear}`; // 02-04-2021
                        },
                        isSelectedDate(date) {
                            const d = new Date(this.year, this.month, date);
                            return this.datepickerValue ===
                                this.formatDateForDisplay(d) ?
                                true :
                                false;
                        },
                        isToday(date) {
                            const today = new Date();
                            const d = new Date(this.year, this.month, date);
                            return today.toDateString() === d.toDateString() ?
                                true :
                                false;
                        },
                        isDateFutureOrCurrent(date) {
                            const today = new Date();
                            const d = new Date(this.year, this.month, date);
                            return today <= d ? true : false;
                        },
                        selectDate(date) {
                            let selectedDate = new Date(
                                this.year,
                                this.month,
                                date
                            );
                            this.datepickerValue = this.formatDateForDisplay(
                                selectedDate
                            );
                            this.isSelectedDate(date);
                            this.showDatepicker = false;
                            iziToast.show(loadingConfigToast);
                            this.isDateSelected = false;
                            // get schedules
                            this.getSchedules(this.roomId, this.datepickerValue).then((res) => {
                                res = res['reserved_times'];
                                this.startHours = this.getStartHours(res);
                                console.log('2_start hours: ' + this.startHours)
                                if (this.startHours.length == 0) {
                                    console.log('ruangan penuh')
                                    iziToast.hide({}, document.getElementsByClassName('loadingrefresh')[0])
                                    iziToast.error({
                                        title: 'Error',
                                        message: 'Ruangan sudah penuh, silahkan pilih tanggal lain',
                                        position: 'topRight',
                                        overlay: false,
                                        timeout: 3000,
                                        close: true,
                                        class: 'error',
                                    });
                                    return;
                                }
                                this.selectedHour = this.startHours[0];
                                this.selectedMinute = '00';
                                iziToast.hide({}, document.getElementsByClassName('loadingrefresh')[0])
                                this.isDateSelected = true;
                            });

                        },
                        getNoOfDays() {
                            let daysInMonth = new Date(
                                this.year,
                                this.month + 1,
                                0
                            ).getDate();
                            // find where to start calendar day of week
                            let dayOfWeek = new Date(
                                this.year,
                                this.month
                            ).getDay();
                            let blankdaysArray = [];
                            for (var i = 1; i <= dayOfWeek; i++) {
                                blankdaysArray.push(i);
                            }
                            let daysArray = [];
                            for (var i = 1; i <= daysInMonth; i++) {
                                daysArray.push(i);
                            }
                            this.blankdays = blankdaysArray;
                            this.no_of_days = daysArray;
                        },
                        decrementMonth() {
                            if (this.month != this.todayMonth || this.year != this.todayYear) {
                                if (this.month == 0) {
                                    this.year--;
                                    this.month = 12;
                                }
                                this.month--;
                                this.getNoOfDays();
                            }
                        },
                        incrementMonth() {
                            if (this.month == 11) {
                                this.month = 0;
                                this.year++;
                            } else {
                                this.month++;
                            }
                            this.getNoOfDays();
                        },
                        getStartHours(reserved_times) {
                            let all_hours = [];
                            for (let i = 10; i < 24; i++) {
                                let is_reserved = false;
                                reserved_times.forEach(element => {
                                    console.log("====================================");
                                    let start_time = new Date(`2000-01-01T${element['start_time']}`);
                                    let end_time = element['end_time'].split(":")[0].startsWith("00") ? new Date(
                                        `2000-01-02T${element['end_time']}`) : new Date(
                                        `2000-01-01T${element['end_time']}`);
                                    console.log("start_time: " + start_time);
                                    console.log("end_time: " + end_time);
                                    let current_time = new Date(`2000-01-01T${i}:00`);
                                    let current_time_plus_3 = new Date(`2000-01-01T${i+3}:00`);
                                    if (start_time <= current_time_plus_3 && current_time_plus_3 < end_time) {
                                        is_reserved = true;
                                        console.log('=================')
                                        console.log(current_time)
                                        console.log('reserved on +3')
                                        console.log('reserved on: ' + element['start_time'] + ' - ' + element[
                                            'end_time'])
                                        console.log('=================')
                                    }
                                    if (start_time <= current_time && current_time < end_time) {
                                        is_reserved = true;
                                        console.log('=================')
                                        console.log(current_time)
                                        console.log('reserved on current')
                                        console.log('reserved on: ' + element['start_time'] + ' - ' + element[
                                            'end_time'])
                                        console.log('=================')
                                    }
                                    console.log("====================================")
                                });
                                if (i > 20) {
                                    is_reserved = true;
                                }
                                if (!is_reserved) {
                                    all_hours.push(i);
                                }
                            }
                            console.log('all hours: ' + all_hours)
                            return all_hours;
                        },
                        async getSchedules(room_id, date) {
                            try {
                                date = date.split('-').reverse().join('-');
                                const response = await axios.get(
                                    `{{ env('ASSET_URL') }}/api/rereservations-time-check?room_id=${room_id}&date=${date}`
                                )
                                if (response.status == 200) {
                                    return response.data;
                                }
                                return false;
                            } catch (error) {
                                return false
                            }
                        },
                    };
                },
                async submitModalOrder() {
                    try {
                        iziToast.show(loadingConfigToast);
                        if (this.name == '' || this.phone == '' || this.faculty == '' || this.order == '' || this
                            .note == '' || this.datepickerValue == '' || this.selectedHour == '' && this
                            .selectedMinute == '' || this.totalPerson == '') {
                            iziToast.hide({}, document.getElementsByClassName('loadingrefresh')[0])
                            iziToast.error({
                                title: 'Error',
                                message: 'Harap isi semua form',
                                position: 'topRight',
                                overlay: false,
                                timeout: 5000,
                                close: true,
                                class: 'error',
                            });
                            return;
                        }
                        let response = await axios.post('{{ env('ASSET_URL') }}/api/reservasi', {
                            nama: this.name,
                            nomer: this.phone,
                            fakultas: this.faculty,
                            pesanan: this.order,
                            note: this.note,
                            ruangan: this.roomId,
                            tanggal: this.datepickerValue,
                            jumlah: this.totalPerson,
                            mulai: this.selectedHour + ':' + this.selectedMinute,
                            selesai: parseInt(this.selectedHour) + 3 + ':' + this.selectedMinute,
                        })
                        if (response.status == 200 && !response.data.error) {
                            iziToast.hide({}, document.getElementsByClassName('loadingrefresh')[0])
                            navigator.clipboard.writeText(response.data.kode_reservasi);
                            console.log(response.data.kode_reservasi)
                            iziToast.success({
                                title: 'Success',
                                message: response.data.success,
                                position: 'topRight',
                                overlay: true,
                                timeout: 5000,
                                close: true,
                                class: 'success',
                            });
                            this.showModal = false;
                            this.name = '';
                            this.phone = '';
                            this.faculty = '';
                            this.order = '';
                            this.note = '';
                            this.selectedHour = '';
                            this.selectedMinute = '';
                            this.datepickerValue = "";
                            this.isDateSelected = false;
                        } else {
                            iziToast.hide({}, document.getElementsByClassName('loadingrefresh')[0])
                            iziToast.error({
                                title: 'Error',
                                message: response.data.error,
                                position: 'topRight',
                                overlay: true,
                                timeout: 5000,
                                close: true,
                                class: 'error',
                            });
                        }
                    } catch (error) {
                        iziToast.hide({}, document.getElementsByClassName('loadingrefresh')[0])
                        iziToast.error({
                            title: 'Error',
                            message: response.data.error,
                            position: 'topRight',
                            overlay: true,
                            timeout: 5000,
                            close: true,
                            class: 'error',
                        });
                    }
                }
            }
        }
    </script>
@endsection
