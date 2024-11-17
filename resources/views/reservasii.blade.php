@extends('layouts.mainlayout')
@section('title', 'Reservasi')


{{-- content --}}
@section('content')
    <div x-data="reservasiData()" x-cloak>
        <div class="container max-w-sm sm:max-w-sm md:max-w-md xl:max-w-5xl h-screen mx-auto">
            <div class="py-10 sm:pt-48 sm:pb-10 px-2 sm:px-0 flex flex-col space-y-7 items-center justify-center font-sans">
                <h1 class="text-2xl text-black">Hai Kamu,<span class="block md:inline text-4xl font-extrabold">Cek Reservasi
                        Kamu disini!</span></h1>
                <form action="" 
                x-on:submit.prevent="checkReservasi()"
                class="w-full"
                >
                    <div class="relative">
                        <input type="text"
                            x-model="searchReservasi"
                            class="block w-full p-4 ps-10 bg-gray-50 border border-gray-150 rounded-full focus:ring-1 focus:ring-white"
                            placeholder="Kode Reservasi">
                        <svg class="w-[20px] h-[20px] fill-current absolute left-3 top-5 text-gray-400"
                            xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                            <path
                                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                        </svg>
                        <button type="submit"
                            class="absolute py-2 px-4 rounded-full right-2 top-2 bg-amber-500 text-white font-bold hover:scale-95 hover:opacity-70 transition ease-in">
                            Search
                        </button>
                    </div>
                </form>
            </div>
            <div class="container max-w-sm md:max-w-md xl:max-w-2xl mx-auto px-2 sm:px-0" x-show="showModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90">
                <div class="sm:flex py-2 px-4 border border-gray-200 rounded-md">
                    <div class="border border-gray-200 rounded-md py-5 px-2 sm:w-[187px]">
                        <h4 class="text-black text-5xl font-semibold inset-x-0 text-center"><span
                                x-text="tanggalReservasi"></span></h4>
                        <h4 class='mt-1 text-zinc-400 text-3xl font-semibold text-center'><span
                                x-text="bulanReservasi"></span></h4>
                        <div class="flex text-zinc-400 mt-1 justify-center">
                            <svg class="fill-current w-[15px] h-[15px] my-auto mr-1" xmlns="http://www.w3.org/2000/svg"
                                height="16" width="16" viewBox="0 0 512 512">
                                <path
                                    d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                            </svg>
                            <p class="text-md font-semibold"><span x-text="jamMulaiReservasi"></span> - <span
                                    x-text="jamSelesaiReservasi"></span></p>
                        </div>
                    </div>
                    <div class="w-full ml-2 py-8 px-4">
                        <div class="flex justify-between">
                            <h4 class="text-black text-2xl font-bold">#<span x-text="kodeReservasi.toUpperCase()"></span>
                            </h4>
                            <div :class="bgColor? `bg-${bgColor} text-${txtColor} font-bold rounded-lg py-2 px-4` : 'font-bold rounded-lg py-2 px-4'">
                                <span x-text="statusReservasi"></span>
                            </div>
                        </div>
                        <hr class="mt-1 border border-gray-400" />
                        <div class="mt-1 flex justify-between">
                            <h4 class="text-zinc-400 text-base font-semibold">Name</h4>
                            <h4 class="text-zinc-600 text-base font-semibold"><span x-text="customerReservasi"></span></h4>
                        </div>
                        <div class="mt-1 flex justify-between">
                            <h4 class="text-zinc-400 text-base font-semibold">Ruangan</h4>
                            <h4 class="text-zinc-600 text-base font-semibold"><span x-text="ruanganReservasi"></span></h4>
                        </div>
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

        function reservasiData() {
            return {
                showModal: false,
                bgColor: '',
                txtColor:'',
                searchReservasi: '',
                kodeReservasi: '',
                tanggalReservasi: '',
                bulanReservasi: '',
                jamMulaiReservasi: '',
                jamSelesaiReservasi: '',
                statusReservasi: '',
                statusColorReservasi: '',
                customerReservasi: '',
                ruanganReservasi: '',
                async checkReservasi() {
                    if (this.searchReservasi == '') {
                        iziToast.error({
                            title: 'Error',
                            message: 'Kode reservasi tidak boleh kosong',
                            position: 'topRight'
                        });
                        return;
                    }
                    try {
                        iziToast.show(loadingConfigToast);
                        let response = await axios.get(
                            `{{ env('ASSET_URL') }}/api/cek-reservasi?kode=${this.searchReservasi}`)
                        let responseJson = response.data
                        console.log(response)
                        if (responseJson.data) {
                            let dataReservasi = responseJson.data[0]
                            let splitTanggal = dataReservasi.tanggal.split('-')
                            this.kodeReservasi = dataReservasi.kode_reservasi
                            this.tanggalReservasi = splitTanggal[splitTanggal.length - 1]
                            console.log(splitTanggal)
                            this.bulanReservasi = MONTH_SHORT_NAMES[parseInt(splitTanggal[1])-1]
                            console.log(this.bulanReservasi)
                            let jamMulai = dataReservasi.jam_mulai.split(':')
                            this.jamMulaiReservasi = `${jamMulai[0]}.${jamMulai[1]}`
                            let jamSelesai = dataReservasi.jam_selesai.split(':')
                            this.jamSelesaiReservasi = `${jamSelesai[0]}.${jamSelesai[1]}`
                            this.statusReservasi = dataReservasi.status
                            this.ruanganReservasi = dataReservasi.ruangan.nama_ruangan
                            this.customerReservasi = dataReservasi.pelanggan.nama
                            if (dataReservasi.status == 'pending') {
                                this.bgColor = 'amber-300'
                                this.txtColor = 'amber-500'
                            } else if (dataReservasi.status == 'approved') {
                                this.bgColor = 'teal-300'
                                this.txtColor = 'teal-500'
                            } else if (dataReservasi.status == 'rejected') {
                                this.bgColor = 'red-300'
                                this.txtColor = 'red-500'
                            }
                            this.showModal = true
                            iziToast.hide({}, document.getElementsByClassName('loadingrefresh')[0])
                            iziToast.success({
                                title: 'Success',
                                message: 'Reservasi ditemukan',
                                position: 'topRight'
                            });
                        } else {
                            iziToast.hide({}, document.getElementsByClassName('loadingrefresh')[0])
                            iziToast.error({
                                title: 'Error',
                                message: 'Reservasi tidak ditemukann',
                                position: 'topRight'
                            });
                        }

                    } catch (xhr) {
                        let response = xhr.response
                        iziToast.hide({}, document.getElementsByClassName('loadingrefresh')[0])
                        iziToast.error({
                            title: 'Error',
                            message: 'Reservasi tidak ditemukan',
                            position: 'topRight'
                        });
                    }
                }
            }
        }
    </script>
@endsection
