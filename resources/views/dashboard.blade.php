<x-layouts.app>
    <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 p-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Welcome back</p>
            <h1 class="mt-1 text-3xl font-semibold text-zinc-900 dark:text-white">{{ auth()->user()->name }}</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Your portal administration tools are ready.</p>
        </div>
        <a class="w-fit rounded-lg bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800" href="{{ route('admin.dashboard') }}">Open admin dashboard</a>
    </div>
</x-layouts.app>
