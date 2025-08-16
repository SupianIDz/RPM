<div
    id="impersonate"
    class="fixed bottom-0 flex h-[48px] w-full items-center justify-center gap-x-5 border-t border-gray-950/5 bg-white dark:divide-white/10 dark:border-white/10 dark:bg-gray-900"
>
    <style>
        html {
            margin-bottom: 48px !important;
        }

        div.fi-layout > aside.fi-sidebar {
            height: calc(100vh - 48px);
        }

        #impersonate {
            height: 48px;
        }
    </style>

    <div class="flex items-center gap-x-2 text-sm">
        <span class="text-sm">ANDA SEDANG BERTINDAK SEBAGAI</span>
        <span class="font-bold uppercase">{{ $user->name }}</span>
    </div>

    <x-filament::button icon="lucide-log-out" size="xs" wire:click="leave">TINGGALKAN</x-filament::button>
</div>
