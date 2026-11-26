<x-layouts.app>
    <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 p-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Administration</p>
            <h1 class="mt-1 text-3xl font-semibold text-zinc-900 dark:text-white">Manage staff</h1>
        </div>

        @if (session('status'))
            <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800" role="status">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data" class="grid gap-4 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm sm:grid-cols-2 dark:border-zinc-700 dark:bg-zinc-900">
            @csrf
            <h2 class="text-xl font-semibold text-zinc-900 sm:col-span-2 dark:text-white">Add a staff member</h2>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="name">Name</label>
                <input class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" id="name" name="name" type="text" value="{{ old('name') }}" maxlength="100" required>
                @error('name')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="position">Position</label>
                <input class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" id="position" name="position" type="text" value="{{ old('position') }}" maxlength="100" required>
                @error('position')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="phone">Telephone</label>
                <input class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" id="phone" name="phone" type="tel" value="{{ old('phone') }}" maxlength="30" required>
                @error('phone')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold" for="email">Email</label>
                <input class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" id="email" name="email" type="email" value="{{ old('email') }}" maxlength="120" required>
                @error('email')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-semibold" for="photo">Photo <span class="font-normal text-zinc-500">(JPG or PNG, up to 2 MB)</span></label>
                <input class="block w-full text-sm text-zinc-700 file:mr-3 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-2 dark:text-zinc-200 dark:file:bg-zinc-700" id="photo" name="photo" type="file" accept=".jpg,.jpeg,.png,image/jpeg,image/png" required>
                @error('photo')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <button class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800" type="submit">Add staff member</button>
            </div>
        </form>

        <div class="overflow-x-auto rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <table class="w-full min-w-[760px] divide-y divide-zinc-200 text-left text-sm dark:divide-zinc-700">
                <thead class="bg-zinc-50 text-xs uppercase tracking-wide text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                    <tr><th class="px-4 py-3">Photo</th><th class="px-4 py-3">Name</th><th class="px-4 py-3">Position</th><th class="px-4 py-3">Telephone</th><th class="px-4 py-3">Email</th><th class="px-4 py-3 text-right">Action</th></tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse ($staffMembers as $person)
                        <tr>
                            <td class="px-4 py-3"><img class="h-12 w-12 rounded-full object-cover" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($person->photo) }}" alt="" width="48" height="48"></td>
                            <td class="px-4 py-3 font-semibold text-zinc-900 dark:text-white">{{ $person->name }}</td>
                            <td class="px-4 py-3">{{ $person->position }}</td>
                            <td class="px-4 py-3">{{ $person->phone }}</td>
                            <td class="px-4 py-3">{{ $person->email }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('admin.staff.destroy', $person) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="font-semibold text-red-700 hover:underline dark:text-red-300" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="px-4 py-8 text-center text-zinc-500" colspan="6">No staff members have been added.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
