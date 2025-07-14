@extends('layouts.backend.app') {{-- أو اسم الـ layout اللي بتستخدمه --}}

@section('admin_title', 'نتائج البحث')

@section('body')
    <div class="container mt-4">
        <h2>نتائج البحث عن: <span class="text-primary">"{{ $query }}"</span></h2>
        <h4 class="mb-4">في جدول: <span class="text-info">{{ $table }}</span></h4>

        @if(count($results) > 0)
            @foreach($results as $type => $items)
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>{{ ucfirst($type) }}</strong>
                    </div>
                    <div class="card-body">
                        @if($items->count())
                            <ul class="list-group">
                                @foreach($items as $item)
                                    <li class="list-group-item">
                                        ID: {{ $item->id }} |
                                        {{ $item->name ?? $item->title ?? '---' }}
                                        {{-- عدل حسب الحقول اللي عندك --}}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">لا توجد نتائج.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-warning">
                لا توجد نتائج مطابقة.
            </div>
        @endif

        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">رجوع</a>
    </div>
@endsection
