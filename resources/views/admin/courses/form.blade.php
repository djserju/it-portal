<x-layouts.app>
    @php($editing = isset($course))
    <div class="mx-auto flex w-full max-w-3xl flex-col gap-6 p-6">
        <div>
            <a class="text-sm font-semibold text-teal-700 hover:underline dark:text-teal-300" href="{{ route('admin.courses.index') }}">&larr; All courses</a>
            <p class="mt-5 text-sm font-semibold uppercase tracking-wide text-teal-700">Administration</p>
            <h1 class="mt-1 text-3xl font-semibold text-zinc-900 dark:text-white">{{ $editing ? 'Edit course' : 'Add course' }}</h1>
        </div>

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $editing ? route('admin.courses.update', $course) : route('admin.courses.store') }}" class="grid gap-5 rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            @csrf
            @if ($editing)
                @method('PUT')
            @endif

            <div>
                <label class="mb-1 block text-sm font-semibold text-zinc-800 dark:text-zinc-100" for="code">Course code</label>
                <input class="w-full rounded-lg border border-zinc-300 px-3 py-2 uppercase dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" id="code" name="code" type="text" value="{{ old('code', $course->code ?? '') }}" maxlength="6" pattern="[A-Z]{3}[0-9]{3}" autocomplete="off" required>
                <p class="mt-1 text-xs text-zinc-500">Three uppercase letters followed by three digits, e.g. ITT101.</p>
                @error('code')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-zinc-800 dark:text-zinc-100" for="name">Name</label>
                <input class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" id="name" name="name" type="text" value="{{ old('name', $course->name ?? '') }}" maxlength="150" required>
                @error('name')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-zinc-800 dark:text-zinc-100" for="credits">Credits</label>
                <input class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" id="credits" name="credits" type="number" value="{{ old('credits', $course->credits ?? 3) }}" min="1" max="4" step="1" required>
                @error('credits')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-zinc-800 dark:text-zinc-100" for="prerequisites">Prerequisites <span class="font-normal text-zinc-500">(optional)</span></label>
                <input class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" id="prerequisites" name="prerequisites" type="text" value="{{ old('prerequisites', $course->prerequisites ?? '') }}" maxlength="255">
                @error('prerequisites')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-zinc-800 dark:text-zinc-100" for="description">Description</label>
                <textarea class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" id="description" name="description" rows="5" required>{{ old('description', $course->description ?? '') }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-wrap gap-3">
                <button class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800" type="submit">{{ $editing ? 'Save changes' : 'Add course' }}</button>
                <a class="rounded-lg border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 hover:bg-zinc-50 dark:border-zinc-600 dark:text-zinc-200 dark:hover:bg-zinc-800" href="{{ route('admin.courses.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
