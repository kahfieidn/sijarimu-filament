<x-filament-panels::page>
    <x-filament-panels::form wire:submit.prevent="submit">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getFormActions()" />
    </x-filament-panels::form>

    @if (session()->has('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    @if ($result)
        <x-filament::section>
            <x-slot name="heading">
                Details
            </x-slot>
            <div style="margin-top: 20px;">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b border-gray-300 px-4 py-2 text-left">Nama</th>
                            <th class="border-b border-gray-300 px-4 py-2 text-left">No. Polisi</th>
                            <th class="border-b border-gray-300 px-4 py-2 text-left">Alamat</th>
                            <th class="border-b border-gray-300 px-4 py-2 text-left">Total</th>
                            <th class="border-b border-gray-300 px-4 py-2 text-left">Tanggal Masa Pajak</th>
                            <th class="border-b border-gray-300 px-4 py-2 text-left">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $items = json_decode($result);
                        @endphp

                        @if (is_array($items) || is_object($items))
                            @foreach ($items as $item)
                                <tr>
                                    <td class="border-b border-gray-200 px-4 py-2">{{ $item->nama }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2">{{ $item->nopol }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2">{{ $item->alamat }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2">{{ $item->total }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2">{{ $item->tgmspajak }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2">{{ $item->ket }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="border-b border-gray-200 px-4 py-2 text-center">Tidak ada data yang ditemukan!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    @endif
</x-filament-panels::page>
