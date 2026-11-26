<x-layouts.app>
    <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 p-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">IT Portal administration</p>
            <h1 class="mt-1 text-3xl font-semibold text-zinc-900 dark:text-white">Admin dashboard</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Manage course information, staff profiles, and contact form messages.</p>
        </div>

        @if (session('status'))
            <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800" role="status">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-3">
            @foreach ([
                ['label' => 'Courses', 'count' => $courseCount, 'href' => route('admin.courses.index')],
                ['label' => 'Staff members', 'count' => $staffCount, 'href' => route('admin.staff.index')],
                ['label' => 'Contact messages', 'count' => $messageCount, 'href' => route('admin.messages.index')],
            ] as $summary)
                <a href="{{ $summary['href'] }}" class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm transition hover:border-teal-500 dark:border-zinc-700 dark:bg-zinc-900">
                    <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">{{ $summary['label'] }}</p>
                    <p class="mt-2 text-3xl font-semibold text-zinc-900 dark:text-white">{{ $summary['count'] }}</p>
                    <span class="mt-3 inline-block text-sm font-semibold text-teal-700 dark:text-teal-300">Manage {{ strtolower($summary['label']) }} &rarr;</span>
                </a>
            @endforeach
        </div>
    </div>
</x-layouts.app>
