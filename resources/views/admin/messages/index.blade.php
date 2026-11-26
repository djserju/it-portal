<x-layouts.app>
    <div class="mx-auto flex w-full max-w-5xl flex-col gap-6 p-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Administration</p>
            <h1 class="mt-1 text-3xl font-semibold text-zinc-900 dark:text-white">Contact messages</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Messages are listed newest first.</p>
        </div>

        <div class="grid gap-4">
            @forelse ($messages as $message)
                <article class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $message->subject }}</h2>
                        <time class="text-sm text-zinc-500" datetime="{{ $message->created_at->toIso8601String() }}">{{ $message->created_at->format('M j, Y g:i A') }}</time>
                    </div>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">From {{ $message->name }} · <a class="text-teal-700 hover:underline dark:text-teal-300" href="mailto:{{ $message->email }}">{{ $message->email }}</a></p>
                    <p class="mt-4 whitespace-pre-wrap text-zinc-800 dark:text-zinc-100">{{ $message->message }}</p>
                </article>
            @empty
                <div class="rounded-xl border border-zinc-200 bg-white p-8 text-center text-zinc-600 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300">No contact messages yet.</div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
