@extends('web_master')
@section('main')

@php
  use Illuminate\Support\Str;
  use Carbon\Carbon;

  $formatDate = function($date){
      if(!$date) return '';
      try { return Carbon::parse($date)->format('d M Y'); } catch(\Exception $e){ return (string)$date; }
  };

  $imgOrFallback = function($post){
      if($post && $post->featured_image && !empty($post->featured_image->url)) return $post->featured_image->url;
      return asset('assets/img/blog/blog-featured.jpg');
  };

  $catName = function($post){
      return $post && $post->select_category ? $post->select_category->name : 'General';
  };

  // Build absolute URL for sharing
  $pageUrl = url()->current();

  // Build TOC from H2 tags inside content (optional enhancement)
  $toc = [];
  $contentHtml = $post->content ?? '';
  if(!empty($contentHtml)){
      try{
          $dom = new \DOMDocument();
          libxml_use_internal_errors(true);
          $dom->loadHTML('<?xml encoding="utf-8" ?>'.$contentHtml);
          libxml_clear_errors();

          $h2s = $dom->getElementsByTagName('h2');
          foreach($h2s as $i => $h2){
              $text = trim($h2->textContent);
              if($text === '') continue;

              $id = $h2->getAttribute('id');
              if(!$id){
                  $id = 'bd-sec-'.($i+1);
                  $h2->setAttribute('id', $id);
              }

              $toc[] = ['id' => $id, 'title' => $text];
          }

          // Save modified HTML (with injected IDs)
          $body = $dom->getElementsByTagName('body')->item(0);
          $newHtml = '';
          foreach ($body->childNodes as $child) {
              $newHtml .= $dom->saveHTML($child);
          }
          $contentHtml = $newHtml;
      }catch(\Exception $e){
          // fallback to original html
          $contentHtml = $post->content ?? '';
      }
  }

@endphp

<!-- =================== MAIN =================== -->
<main id="bd-main">

  <!-- =================== ARTICLE HERO =================== -->
  <section id="bd-hero">
    <div class="container">
      <nav class="bd-breadcrumb" aria-label="breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span class="bd-crumb-dot">•</span>
        <a href="{{ route('frontend.blog') }}">Blog</a>
        <span class="bd-crumb-dot">•</span>
        <span class="bd-crumb-active">{{ Str::limit($post->title ?? '', 50) }}</span>
      </nav>

      <div class="row g-4 align-items-end">
        <div class="col-lg-8">
          <div class="bd-hero-meta">
            <span class="bd-chip"><i class="bi bi-journal-text me-1"></i> {{ $catName($post) }}</span>
            <span class="bd-chip bd-chip-dark"><i class="bi bi-shield-check me-1"></i> Compliance-ready</span>
          </div>

          <h1 class="bd-title">
            {{ $post->title }}
          </h1>

          <p class="bd-subtitle">
            {{ $post->excerpt ?? '' }}
          </p>

          <div class="bd-author-row d-flex flex-wrap align-items-center gap-2 gap-md-3">
            <div class="bd-author">
              <div class="bd-avatar">AS</div>
              <div>
                <div class="bd-author-name">Amtex Safety Team</div>
                <div class="bd-author-role">Fire safety & product guidance</div>
              </div>
            </div>

            <div class="bd-author-meta">
              <span><i class="bi bi-calendar3 me-1"></i> {{ $formatDate($post->published_at) }}</span>
              <span class="bd-meta-dot">•</span>
              <span><i class="bi bi-clock me-1"></i> {{ $post->read_time ?? '—' }}</span>
              {{-- Views can be added later --}}
              <span class="bd-meta-dot">•</span>
              <span><i class="bi bi-eye me-1"></i> — views</span>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="bd-hero-card">
            <div class="bd-hero-card-top d-flex align-items-start justify-content-between gap-2">
              <div>
                <div class="bd-hero-card-eyebrow">Quick takeaway</div>
                <div class="bd-hero-card-title">At a glance</div>
              </div>
              <span class="bd-mini-chip"><i class="bi bi-lightning-charge-fill me-1"></i> Quick</span>
            </div>

            <ul class="bd-takeaways">
              <li><i class="bi bi-check2-circle"></i> Category: {{ $catName($post) }}</li>
              <li><i class="bi bi-check2-circle"></i> Read time: {{ $post->read_time ?? '—' }}</li>
              <li><i class="bi bi-check2-circle"></i> Published: {{ $formatDate($post->published_at) }}</li>
            </ul>

            <a href="{{ url('/products') }}" class="btn btn-amtex w-100 bd-hero-btn">
              Explore Amtex products <i class="bi bi-arrow-right-short"></i>
            </a>

            <div class="bd-hero-note">
              <i class="bi bi-lock-fill me-1"></i> No spam — expert guidance only.
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== CONTENT =================== -->
  <section id="bd-content" class="bd-pad">
    <div class="container">
      <div class="row g-4">

        <!-- MAIN ARTICLE -->
        <div class="col-lg-8">

          <!-- cover image -->
          <div class="bd-cover">
            <img src="{{ $imgOrFallback($post) }}" alt="{{ $post->title }}" class="bd-cover-img" />
            <div class="bd-cover-badge">
              <i class="bi bi-stars me-1"></i> Featured
            </div>
          </div>

          <!-- article -->
          <article class="bd-article">
            {!! $contentHtml !!}

            <div class="bd-divider"></div>

            <div class="bd-tags-row">
              <span class="bd-tag"><i class="bi bi-tag me-1"></i> {{ $catName($post) }}</span>
              @if(!empty($post->slug))
                <span class="bd-tag"><i class="bi bi-tag me-1"></i> {{ $post->slug }}</span>
              @endif
              @if(!empty($post->read_time))
                <span class="bd-tag"><i class="bi bi-tag me-1"></i> {{ $post->read_time }}</span>
              @endif
            </div>

            <div class="bd-share-row">
              <div class="bd-share-title"><i class="bi bi-share me-1"></i> Share</div>
              <div class="bd-share-btns">
                <a class="bd-share-btn" target="_blank"
                   href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($pageUrl) }}"
                   aria-label="Share on Facebook"><i class="bi bi-facebook"></i></a>

                <a class="bd-share-btn" target="_blank"
                   href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($pageUrl) }}"
                   aria-label="Share on LinkedIn"><i class="bi bi-linkedin"></i></a>

                <a class="bd-share-btn" target="_blank"
                   href="https://api.whatsapp.com/send?text={{ urlencode($post->title.' - '.$pageUrl) }}"
                   aria-label="Share on WhatsApp"><i class="bi bi-whatsapp"></i></a>

                <a class="bd-share-btn" href="javascript:void(0)" id="bdCopyLinkBtn" aria-label="Copy link">
                  <i class="bi bi-link-45deg"></i>
                </a>
              </div>
            </div>

          </article>

          <!-- RELATED POSTS -->
          @if(isset($relatedPosts) && $relatedPosts->count())
          <div class="bd-related">
            <div class="bd-related-head d-flex align-items-center justify-content-between gap-2">
              <h3 class="bd-related-title mb-0">Related articles</h3>
              <a href="{{ route('frontend.blog', ['category' => $post->select_category->slug ?? null]) }}" class="bd-related-link">
                View all <i class="bi bi-arrow-right-short"></i>
              </a>
            </div>

            <div class="row g-3 g-md-4 mt-1">
              @foreach($relatedPosts->take(2) as $rel)
              <div class="col-md-6">
                <article class="bd-rel-card">
                  <a href="{{ route('frontend.blog.show', $rel->slug) }}" class="bd-rel-media">
                    <img src="{{ $imgOrFallback($rel) }}" alt="{{ $rel->title }}" class="bd-rel-img" />
                    <span class="bd-rel-badge">{{ $catName($rel) }}</span>
                  </a>
                  <div class="bd-rel-body">
                    <div class="bd-rel-meta">
                      <span><i class="bi bi-clock me-1"></i> {{ $rel->read_time ?? '—' }}</span>
                      <span class="bd-meta-dot">•</span>
                      <span>{{ $formatDate($rel->published_at) }}</span>
                    </div>
                    <h4 class="bd-rel-title">
                      <a href="{{ route('frontend.blog.show', $rel->slug) }}">{{ $rel->title }}</a>
                    </h4>
                  </div>
                </article>
              </div>
              @endforeach
            </div>
          </div>
          @endif

        </div>

        <!-- SIDEBAR -->
        <div class="col-lg-4">

          <aside class="bd-sidebar">

            <!-- TOC -->
            <div class="bd-side-card">
              <div class="bd-side-title"><i class="bi bi-list-task me-1"></i> On this page</div>
              <div class="bd-toc">
                @if(!empty($toc))
                  @foreach($toc as $item)
                    <a href="#{{ $item['id'] }}" class="bd-toc-link">{{ $item['title'] }}</a>
                  @endforeach
                @else
                  <a href="#bd-content" class="bd-toc-link">Article</a>
                @endif
              </div>
            </div>

            <!-- PRODUCT HELP -->
            <div class="bd-side-card bd-side-dark">
              <div class="bd-side-title text-white">Need a recommendation?</div>
              <p class="bd-side-text">
                Tell us your site type and risk zone — we’ll guide you with the right extinguisher model.
              </p>
              <a href="{{ url('/products') }}" class="btn btn-amtex w-100 bd-side-btn">Browse products</a>
              <a href="#quick-enquiry" class="btn btn-light w-100 fw-semibold mt-2 bd-side-btn2">Talk to our team</a>
            </div>

            <!-- NEWSLETTER -->
            <div class="bd-side-card">
              <div class="bd-side-title"><i class="bi bi-envelope me-1"></i> Newsletter</div>
              <p class="bd-side-text2">Monthly safety updates (no spam).</p>
              <div class="bd-input-wrap mb-2">
                <i class="bi bi-at"></i>
                <input type="email" class="form-control bd-input" placeholder="Email address" />
              </div>
              <button class="bd-btn w-100" type="button">Subscribe</button>
              <div class="bd-small-note mt-2"><i class="bi bi-lock-fill me-1"></i> We never share your email.</div>
            </div>

          </aside>

        </div>

      </div>
    </div>
  </section>

  <!-- =================== PAGE CTA =================== -->
  <section id="bd-bottom-cta" class="bd-pad bd-pad-tight">
    <div class="container">
      <div class="bd-bottom-card row g-3 align-items-center">
        <div class="col-lg-8">
          <span class="bd-bottom-eyebrow">
            <i class="bi bi-life-preserver me-1"></i> Need help choosing?
          </span>
          <h2 class="bd-bottom-title mb-1">Get the right product mix for your premises.</h2>
          <p class="bd-bottom-text mb-0">
            Share your site details — our team will suggest a compliant, effective solution.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="#quick-enquiry" class="btn btn-amtex bd-bottom-btn">Talk to our team</a>
        </div>
      </div>
    </div>
  </section>

</main>

{{-- Copy link --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('bdCopyLinkBtn');
    if(!btn) return;

    btn.addEventListener('click', async function () {
        const url = window.location.href;
        try {
            await navigator.clipboard.writeText(url);
            btn.classList.add('bd-copied');
            setTimeout(()=> btn.classList.remove('bd-copied'), 1200);
        } catch (e) {
            // fallback
            const tmp = document.createElement('input');
            tmp.value = url;
            document.body.appendChild(tmp);
            tmp.select();
            document.execCommand('copy');
            document.body.removeChild(tmp);
        }
    });
});
</script>

@endsection
