@props([
    'categories' => collect(),
    'featuredPosts' => collect()
])

<div class="overflow-hidden bg-white text-slate-900">

    {{-- HERO SECTION --}}
    <section class="relative overflow-hidden bg-slate-50">

        {{-- Decorative background --}}
        <div class="pointer-events-none absolute -top-24 -right-32
                    size-96 rounded-full bg-indigo-100/70 blur-3xl"></div>

        <div class="relative mx-auto grid max-w-7xl items-center
                    gap-12 px-4 py-20 sm:px-6 lg:grid-cols-2
                    lg:gap-16 lg:px-8 lg:py-28">

            {{-- Hero content --}}
            <div>
                <h1 class="max-w-2xl text-4xl font-extrabold
                           leading-tight tracking-tight
                           sm:text-5xl lg:text-6xl">
                    Learn to Code.
                    <span class="text-teal-600">
                        Build Something Amazing.
                    </span>
                </h1>

                <p class="mt-6 max-w-xl text-base leading-8
                          text-slate-600 sm:text-lg">
                    Explore programming tutorials, practical lessons,
                    and structured learning paths. From your first
                    line of code to building real-world projects.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="#courses"
                       class="inline-flex items-center justify-center
                              gap-2 rounded-xl bg-teal-600
                              px-6 py-3 font-semibold text-white
                              transition-colors hover:bg-teal-700">
                        Explore Courses
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>

                    <a href="#learning-paths"
                       class="inline-flex items-center justify-center
                              gap-2 rounded-xl border border-slate-300
                              bg-white px-6 py-3 font-semibold
                              text-slate-700 transition-colors
                              hover:bg-slate-100">
                        Learning Paths
                    </a>
                </div>

                <div class="mt-10 flex flex-wrap gap-x-6 gap-y-3
                            text-sm text-slate-500">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-check text-emerald-500"></i>
                        Beginner Friendly
                    </span>

                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-check text-emerald-500"></i>
                        Practical Examples
                    </span>

                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-check text-emerald-500"></i>
                        Self-Paced Learning
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- LEARNING PATHS --}}
    <section id="learning-paths" class="scroll-mt-24 py-20 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-12">
                <span class="text-sm font-bold uppercase
                             tracking-widest text-teal-600">
                    Explore Topics
                </span>

                <h2 class="mt-3 text-3xl font-bold tracking-tight
                           sm:text-4xl">
                    Choose Your Learning Path
                </h2>

                <p class="mt-4 max-w-2xl leading-7 text-slate-600">
                    Discover different areas of programming and find
                    the right path for your learning journey.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                @forelse($categories as $category)
                    <x-card
                        :tag="'a'"
                        :href="'#courses'"
                        :style="'hover:border-indigo-200'"
                        :padding="'p-7'"
                        class="'block'"
                    >
                        <h3 class="text-xl font-bold text-slate-900 transition-colors group-hover:text-teal-600">
                            {{ $category->name }}
                        </h3>

                        <p class="mt-3 min-h-14 text-sm leading-7 text-slate-600">
                            {{ $category->posts_count }} Materials
                        </p>

                        <div class="mt-6 flex items-center gap-2 text-sm font-semibold text-teal-600">
                            Explore Path
                            <i class="fa-solid fa-arrow-right ml-2"></i>
                        </div>
                    </x-card>
                @empty
                    <p class="text-slate-500">
                        No learning paths available yet
                    </p>
                @endforelse

            </div>
        </div>
    </section>

    {{-- FEATURED COURSES --}}
    <section id="courses" class="scroll-mt-24 bg-slate-50 py-20 lg:py-24">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-12 flex flex-col gap-5
                        sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <span class="text-sm font-bold uppercase
                                 tracking-widest text-teal-600">
                        Start Learning
                    </span>

                    <h2 class="mt-3 text-3xl font-bold tracking-tight
                               sm:text-4xl">
                        Featured Courses
                    </h2>

                    <p class="mt-4 max-w-xl leading-7 text-slate-600">
                        Explore programming courses and develop
                        your skills one lesson at a time.
                    </p>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @forelse($featuredPosts as $post)
                    <x-card
                        :tag="'article'"
                        :padding="'p-0'"
                        :style="'h-full'"
                    >
                        <div class="flex h-44 items-center justify-center overflow-hidden bg-teal-50">
{{--                            <i class="fa-solid fa-code text-6xl text-teal-600 transition-transform duration-300 group-hover:scale-110"></i>--}}
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Post Image">
                            @endif
                        </div>

                        <div class="flex h-full flex-col p-6">
                            <div class="mb-4 flex items-center justify-between gap-2">
                                <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-700">
                                    {{ $post->category->name ?? 'Uncategorized' }}
                                </span>

                                <span class="text-xs text-slate-500">
                                    {{ $post->created_at->format('d M Y') }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-900">
                                {{ $post->title }}
                            </h3>

                            <p class="mt-3 flex-1 text-sm leading-6 text-slate-600">
                                {{ \Illuminate\Support\Str::limit($post->excerpt ?? '', 110) }}
                            </p>

                            <div class="mt-6 flex items-center justify-between border-t border-slate-600">
                                <span class="text-xs text-slate-500">
                                    <i class="fa-regular fa-user mr-1"></i>
                                    {{ $post->user->name ?? 'Unknown' }}
                                </span>

                                <span class="text-sm font-semibold text-teal-600">
                                    Read More
                                    <i class="fa-solid fa-arrow-right ml-1"></i>
                                </span>
                            </div>
                        </div>

                    </x-card>
                @empty
                    <p class="col-span-full py-12 text-center text-slate-500">
                        No published materials available yet
                    </p>
                @endforelse

            </div>
        </div>
    </section>
</div>
