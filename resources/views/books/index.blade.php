@extends('layouts.app')
@section('content')
    <h1 class="mb-10 text-2xl">Books</h1>
    <form action="{{ route('books.index') }}" method="get" class="mb-4 flex item-center gap-2">
        <input type="text" name="title" placeholder="search by titile" value="{{ request('title') }}" class="input" />
        <input type="hidden" name="filter" value="{{ request('filter') }}">
        <button type="submit" class="btn">Search</button>
        <a href="{{ route('books.index') }}" class="btn">Clear</a>

    </form>
    <div class="filter-conatiner mb-4 flex">
        @php
            $filters = [
                '' => 'Latest',
                'polular_last_month' => 'Popular Last Month',
                'polular_last_6month' => 'Popular Last 6 Months',
                'highest_rated_last_month' => 'highest rated Last Month',
                'highest_rated_last_6month' => 'Height Rated Last 6 Months',
            ];
        @endphp

        @foreach ($filters as $key => $label)
            <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}"
                class="{{ request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item' }}">{{ $label }}</a>
        @endforeach

    </div>
    <ul class="">
        @forelse ($books as $book)
            <li class="mb-4">
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="w-full flex-grow sm:w-auto">
                            <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
                            <span class="book-author">by {{ $book->author }}</span>
                        </div>
                        <div>
                            <div class="book-rating">
                                {{ number_format($book->reviews_avg_rating, 1) }}
                            </div>
                            <div class="book-review-count">
                                out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse

    </ul>
@endsection
