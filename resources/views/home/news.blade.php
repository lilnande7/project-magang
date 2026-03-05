{{-- ===== NEWS SECTION ===== --}}
<section class="news-section" id="news">
    <div class="section-header" data-animate="fadeInUp">
        <span class="section-label">Informasi</span>
        <h2>Berita terbaru & agenda perpustakaan</h2>
        <p>Ikuti program literasi, workshop, dan rilis koleksi terbaru</p>
    </div>

    @if($headlineNews)
    <div class="news-spotlight" data-animate="fadeInUp">
        <div class="spotlight-content">
            <span class="spotlight-label">Sorotan Hari Ini</span>
            <h3>{{ $headlineNews->title }}</h3>
            <p>{{ \Illuminate\Support\Str::limit(strip_tags($headlineNews->excerpt ?? $headlineNews->content ?? ''), 200, '...') }}</p>
            <div class="spotlight-meta">
                <span><i class="far fa-calendar-alt"></i> {{ $headlineNews->created_at->format('d M Y') }}</span>
                <span><i class="fas fa-tag"></i> {{ optional($headlineNews->category)->name ?? 'Berita' }}</span>
            </div>
            <a href="{{ route('news.show', $headlineNews->id) }}" class="btn-outline">Baca Berita</a>
        </div>
        <div class="spotlight-image">
            @if($headlineNews->featured_image)
                <img src="{{ asset('storage/' . $headlineNews->featured_image) }}" alt="{{ $headlineNews->title }}">
            @else
                <div class="spotlight-placeholder"><i class="fas fa-newspaper"></i></div>
            @endif
        </div>
    </div>
    @endif

    @php
        $newsFeed = $featuredNews->concat($latestNews);
    @endphp

    @if($newsFeed->count() > 0)
    <div class="news-grid">
        @foreach($newsFeed as $index => $news)
            @continue($spotlightId && $news->id === $spotlightId)
            <article class="news-card" data-animate="fadeInUp" data-delay="{{ $index * 90 }}">
                <div class="news-thumb">
                    @if($news->featured_image)
                        <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}">
                    @else
                        <div class="news-thumb-placeholder"><i class="fas fa-image"></i></div>
                    @endif
                </div>
                <div class="news-body">
                    <span class="news-date">{{ $news->created_at->format('d M Y') }}</span>
                    <h4><a href="{{ route('news.show', $news->id) }}">{{ $news->title }}</a></h4>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($news->excerpt ?? $news->content ?? ''), 120, '...') }}</p>
                    <a href="{{ route('news.show', $news->id) }}" class="news-link">Baca selengkapnya</a>
                </div>
            </article>
        @endforeach
    </div>
    <div class="news-more" data-animate="fadeInUp">
        <a href="{{ route('news.index') }}" class="btn-outline">Lihat semua berita</a>
    </div>
    @else
    <div class="no-news" data-animate="fadeIn">
        <i class="fas fa-newspaper"></i>
        <p>Belum ada berita terbaru untuk ditampilkan.</p>
    </div>
    @endif
</section>
