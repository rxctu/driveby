{{-- Toast notification — driven by Alpine store('toast') --}}
<div
    x-data
    x-show="$store.toast.visible"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="fixed bottom-6 right-6 z-50 max-w-sm w-full pointer-events-auto"
    style="display: none;"
>
    <div
        class="rounded-lg shadow-lg px-5 py-4 flex items-center gap-3 text-sm font-medium"
        :class="{
            'bg-primary-600 text-white': $store.toast.type === 'success',
            'bg-red-600 text-white':     $store.toast.type === 'error',
            'bg-blue-600 text-white':    $store.toast.type === 'info',
        }"
    >
        {{-- Icon --}}
        <template x-if="$store.toast.type === 'success'">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </template>
        <template x-if="$store.toast.type === 'error'">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </template>
        <template x-if="$store.toast.type === 'info'">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
            </svg>
        </template>

        {{-- Message --}}
        <span x-text="$store.toast.message"></span>

        {{-- Close button --}}
        <button
            @click="$store.toast.visible = false"
            class="ml-auto shrink-0 hover:opacity-75 transition-opacity cursor-pointer"
            aria-label="Fermer"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
