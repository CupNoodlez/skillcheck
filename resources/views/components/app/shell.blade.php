@php
    $user = auth()->user();
    $role = $user?->role;

    $links = [];
    $home = url('/');
    if ($role === 'admin') {
        $home = route('admin.dashboard');
        $links = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'dashboard'],
            ['label' => 'Users', 'route' => 'admin.users.index', 'active' => 'admin.users.*', 'icon' => 'users'],
            ['label' => 'Exams', 'route' => 'admin.exams.index', 'active' => 'admin.exams.*', 'icon' => 'clipboard-check'],
        ];
    } elseif ($role === 'instructor') {
        $home = route('instructor.exams.index');
        $links = [
            ['label' => 'My Exams', 'route' => 'instructor.exams.index', 'active' => 'instructor.*', 'icon' => 'file-text'],
        ];
    } elseif ($role === 'student') {
        $home = route('student.exams.index');
        $links = [
            ['label' => 'My Exams', 'route' => 'student.exams.index', 'active' => 'student.*', 'icon' => 'book-open'],
        ];
    }

    $roleLabels = ['admin' => 'Admin', 'instructor' => 'Instructor', 'student' => 'Student'];
    $roleLabel = $roleLabels[$role] ?? 'Member';

    // Current section label for the topbar
    $current = collect($links)->first(fn ($l) => request()->routeIs($l['active']));
    $section = $current['label'] ?? ($title ?? 'SkillCheck');
@endphp

<div x-data="{ sidebar: false }" class="min-h-screen">
    {{-- Mobile backdrop --}}
    <div x-show="sidebar" x-cloak x-transition.opacity @click="sidebar = false"
         class="fixed inset-0 z-30 bg-gray-900/40 lg:hidden"></div>

    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col border-r border-white/20 bg-white/80 backdrop-blur-xl transition-transform duration-200 lg:translate-x-0 shadow-lg"
           :class="sidebar ? 'translate-x-0' : '-translate-x-full'">
        <div class="flex h-16 items-center gap-2 px-4 border-b border-white/20">
            <a href="{{ $home }}" class="flex items-center">
                <x-brand-logo variant="wide" :height="26" />
            </a>
            <button @click="sidebar = false" class="ml-auto text-faint hover:text-ink lg:hidden">
                <x-icon name="x" class="w-5 h-5" />
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto sc-scroll px-3 py-4">
            <p class="px-3 pb-2 text-[0.7rem] font-semibold uppercase tracking-wider text-faint">{{ $roleLabel }}</p>
            <div class="space-y-1">
                @foreach($links as $link)
                    <a href="{{ route($link['route']) }}"
                       class="sc-nav-link {{ request()->routeIs($link['active']) ? 'is-active' : '' }}">
                        <x-icon :name="$link['icon']" class="w-[18px] h-[18px]" />
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </nav>

        <div class="border-t border-white/20 p-3">
            <div class="flex items-center gap-2">
                <a href="{{ route('profile.edit') }}" class="flex min-w-0 flex-1 items-center gap-3 rounded-lg p-2 hover:bg-white/60 transition-colors">
                    <x-ui.avatar :user="$user" size="sm" />
                    <span class="min-w-0">
                        <span class="block truncate text-sm font-medium text-ink">{{ $user->username }}</span>
                        <span class="block text-xs text-muted">{{ $roleLabel }}</span>
                    </span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Log out"
                            class="rounded-lg p-2 text-muted hover:bg-red-50 hover:text-red-600 transition-colors">
                        <x-icon name="log-out" class="w-[18px] h-[18px]" />
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main column --}}
    <div class="lg:pl-64">
        <header class="sticky top-0 z-20 flex h-16 items-center gap-3 border-b border-white/20 bg-canvas/60 px-4 backdrop-blur-xl sm:px-6 shadow-sm">
            <button @click="sidebar = true" class="text-muted hover:text-ink lg:hidden">
                <x-icon name="menu" class="w-6 h-6" />
            </button>
            <div class="flex items-center gap-2 text-sm">
                @if($current)
                    <x-icon :name="$current['icon']" class="w-4 h-4 text-faint" />
                @endif
                <span class="font-medium text-ink">{{ $section }}</span>
            </div>
            <div class="ml-auto flex items-center gap-1">
                <a href="{{ route('profile.edit') }}" class="rounded-lg p-1.5 text-muted hover:bg-subtle hover:text-ink lg:hidden">
                    <x-ui.avatar :user="$user" size="xs" />
                </a>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
            <x-ui.flash />
            {{ $slot }}
        </main>
    </div>
</div>
