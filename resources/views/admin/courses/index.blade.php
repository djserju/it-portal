<x-layouts.app>
    <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 p-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Administration</p>
                <h1 class="mt-1 text-3xl font-semibold text-zinc-900 dark:text-white">Manage courses</h1>
            </div>
            <a href="{{ route('admin.courses.create') }}" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">Add course</a>
        </div>

        @if (session('status'))
            <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800" role="status">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                <p class="font-semibold">The course could not be saved.</p>
                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-x-auto rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <table class="w-full min-w-[720px] divide-y divide-zinc-200 text-left text-sm dark:divide-zinc-700">
                <thead class="bg-zinc-50 text-xs uppercase tracking-wide text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                    <tr>
                        <th class="px-4 py-3">Code</th>
                        <th class="px-4 py-3">Course name</th>
                        <th class="px-4 py-3">Credits</th>
                        <th class="px-4 py-3">Prerequisites</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($courses as $course)
                        <tr>
                            <td class="whitespace-nowrap px-4 py-3 font-semibold text-zinc-900 dark:text-white">{{ $course->code }}</td>
                            <td class="px-4 py-3 text-zinc-700 dark:text-zinc-200">{{ $course->name }}</td>
                            <td class="px-4 py-3 text-zinc-700 dark:text-zinc-200">{{ $course->credits }}</td>
                            <td class="px-4 py-3 text-zinc-700 dark:text-zinc-200">{{ $course->prerequisites ?: 'None' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-3">
                                    <a class="font-semibold text-teal-700 hover:underline dark:text-teal-300" href="{{ route('admin.courses.edit', $course) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="font-semibold text-red-700 hover:underline dark:text-red-300" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="px-4 py-8 text-center text-zinc-500" colspan="5">No courses have been added.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
