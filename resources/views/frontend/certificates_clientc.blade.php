@extends('web_master')
@section('main')

<!-- =================== MAIN =================== -->
<main id="cc-main">

  <!-- =================== HERO =================== -->
  <section id="cc-hero" class="cc-pad">
    <div class="container">
      <div class="row g-4 align-items-center">

        <div class="col-lg-7">
          <div class="cc-hero-top d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="cc-pill">
              <i class="bi bi-award me-1"></i>
              Certifications &amp; Compliance
            </span>
            <span class="cc-pill cc-pill-dark">
              <i class="bi bi-shield-check me-1"></i>
              ISO 9001:2015 • BIS/ISI • CE/EN
            </span>
          </div>

          <h1 class="cc-hero-title">
            Certified manufacturing. Trusted by
            <span>Government &amp; Industry.</span>
          </h1>

          <p class="cc-hero-subtitle">
            Explore our certifications and see why safety teams across sectors choose Amtex for
            dependable products, documentation, and support.
          </p>

          <div class="cc-hero-trust">
            <span><i class="bi bi-patch-check me-1"></i> ISO 9001:2015 certified processes</span>
            <span><i class="bi bi-award me-1"></i> BIS/ISI aligned product range</span>
            <span><i class="bi bi-journal-check me-1"></i> Documentation for audits &amp; tenders</span>
          </div>

          <div class="d-flex flex-wrap gap-2 mt-3">
            <a href="#cc-certs" class="btn btn-amtex cc-btn">View certificates</a>
            <a href="#cc-clients" class="btn btn-outline-dark cc-btn-outline">View clients</a>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="cc-hero-card">
            <div class="cc-hero-card-head d-flex align-items-start justify-content-between gap-2">
              <div>
                <div class="cc-card-eyebrow">Quick help</div>
                <div class="cc-card-title">Need compliance guidance?</div>
              </div>
              <span class="cc-mini-chip">
                <i class="bi bi-lightning-charge-fill me-1"></i> 1–2 min
              </span>
            </div>

            <div class="cc-hero-mini-grid">
              <div class="cc-mini">
                <i class="bi bi-building-check"></i>
                <div>
                  <div class="cc-mini-title">Project &amp; audit support</div>
                  <div class="cc-mini-text">Site-fit recommendations + checklist-ready docs.</div>
                </div>
              </div>

              <div class="cc-mini">
                <i class="bi bi-award-fill"></i>
                <div>
                  <div class="cc-mini-title">Certificates mapped to models</div>
                  <div class="cc-mini-text">BIS/ISI, test reports, and product documentation.</div>
                </div>
              </div>

              <div class="cc-mini">
                <i class="bi bi-tools"></i>
                <div>
                  <div class="cc-mini-title">Service &amp; AMC available</div>
                  <div class="cc-mini-text">Installation, refilling, and maintenance support.</div>
                </div>
              </div>
            </div>

            <a href="#cc-downloads" class="cc-hero-card-btn">
              Get brochure + company profile
              <i class="bi bi-arrow-right-short"></i>
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== CERTIFICATES (DISPLAY ONLY — NO OPEN ON CLICK) =================== -->
  <section id="cc-certs" class="cc-pad">
    <div class="container">
      <div class="cc-head text-center mb-4 mb-md-5">
        <span class="cc-section-eyebrow">Certifications</span>
        <h2 class="cc-section-title mb-2">Verified documents &amp; compliance</h2>
        <p class="cc-section-subtitle">
          Certificates are displayed as a visual grid (non-clickable).
        </p>
      </div>

      <div class="row g-3 g-md-4 justify-content-center">

        @forelse(($certifications ?? collect()) as $cert)
          <div class="col-6 col-md-4 col-lg-3">
            <div class="cc-cert-tile" aria-hidden="true">

              @php
                // In your model, image attribute returns a Media object or null
                $img = $cert->image;
              @endphp

              @if($img)
                <img
                  src="{{ $img->getUrl() }}"
                  alt="{{ $cert->title ?? 'Certificate' }}"
                  loading="lazy"
                  style="width:100%; height:auto;"
                />
              @else
                <div class="cc-cert-placeholder d-flex align-items-center justify-content-center text-center"
                     style="width:100%; min-height:180px; border:1px dashed rgba(0,0,0,.2); border-radius:14px; padding:14px;">
                  <div>
                    <i class="bi bi-file-earmark-text" style="font-size:24px;"></i>
                    <div class="mt-2 small">No image uploaded</div>
                  </div>
                </div>
              @endif

              <span class="cc-cert-zoom"><i class="bi bi-image"></i></span>
            </div>

            @if(!empty($cert->title))
              <div class="text-center small mt-2" style="opacity:.8;">
                {{ $cert->title }}
              </div>
            @endif
          </div>

        @empty
          <div class="col-12">
            <div class="text-center py-4">
              <div class="mb-2"><i class="bi bi-info-circle"></i></div>
              <h5 class="mb-1">No certificates available</h5>
              <p class="mb-0" style="opacity:.8;">Please add certifications from the admin panel.</p>
            </div>
          </div>
        @endforelse

      </div>
    </div>
  </section>

  <!-- =================== DOWNLOADS (UNLOCK → POPUP FORM → DOWNLOAD) =================== -->
  <section id="cc-downloads" class="cc-pad">
    <div class="container">
      <div class="cc-head text-center mb-4 mb-md-5">
        <span class="cc-section-eyebrow">Downloads</span>
        <h2 class="cc-section-title mb-2">Brochure &amp; Company Profile</h2>
        <p class="cc-section-subtitle">
          To download, click Unlock and submit your details.
        </p>
      </div>

      <div class="row g-3 g-md-4 justify-content-center">

        @if(isset($downloads) && $downloads->count() > 0)

          @foreach($downloads as $dl)
            <div class="col-md-6 col-lg-5">
              <div class="cc-dl-card">
                <div class="cc-dl-top">
                  <div class="cc-dl-ico"><i class="bi bi-file-earmark-pdf"></i></div>
                  <div>
                    <div class="cc-dl-title">{{ $dl->title }}</div>
                    @if(!empty($dl->description))
                      <div class="cc-dl-sub">{!! \Illuminate\Support\Str::limit(strip_tags($dl->description), 90) !!}</div>
                    @endif
                  </div>
                </div>

                <div class="cc-dl-actions">
                  <button
                    type="button"
                    class="cc-unlock-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#ccUnlockModal"
                    data-download-id="{{ $dl->id }}"
                    data-download-title="{{ e($dl->title) }}"
                  >
                    <i class="bi bi-lock-fill me-1"></i> Unlock
                  </button>

                  <a
                    class="cc-download-btn d-none"
                    id="ccDownloadBtn-{{ $dl->id }}"
                    href="#"
                    download
                  >
                    <i class="bi bi-download me-1"></i> Download
                  </a>
                </div>

                <div class="cc-dl-foot">
                  <i class="bi bi-shield-lock me-1"></i> Your details are used only for this request.
                </div>
              </div>
            </div>
          @endforeach

        @else
          <div class="col-12">
            <div class="text-center py-4">
              <div class="mb-2"><i class="bi bi-info-circle"></i></div>
              <h5 class="mb-1">No downloads available</h5>
              <p class="mb-0" style="opacity:.8;">Please add downloads from the admin panel.</p>
            </div>
          </div>
        @endif

      </div>
    </div>
  </section>

  <!-- =================== CLIENTS (LOGO GRID) =================== -->
  <section id="cc-clients" class="cc-pad">
    <div class="container">
      <div class="cc-head text-center mb-4 mb-md-5">
        <span class="cc-section-eyebrow">Our Clients</span>
        <h2 class="cc-section-title mb-2">Trusted across sectors</h2>
      </div>

      @if(isset($clients) && $clients->count() > 0)
        <div class="cc-logo-grid">
          @foreach($clients as $client)
            <div class="cc-logo-tile">
              @if($client->logo)
                <img
                  src="{{ $client->logo->url }}"
                  alt="{{ $client->name ?? 'Client' }}"
                  loading="lazy"
                >
              @else
                <div class="d-flex align-items-center justify-content-center text-center"
                     style="min-height:80px; opacity:.65;">
                  <div>
                    <i class="bi bi-image"></i>
                    <div class="small mt-1">Logo not available</div>
                  </div>
                </div>
              @endif
            </div>
          @endforeach
        </div>
      @else
        <div class="text-center py-4">
          <div class="mb-2"><i class="bi bi-info-circle"></i></div>
          <h5 class="mb-1">No clients available</h5>
        </div>
      @endif

    </div>
  </section>

  <!-- =================== TESTIMONIALS =================== -->
  <section id="cc-testimonials" class="cc-pad">
    <div class="container">
      <div class="cc-head text-center mb-4 mb-md-5">
        <span class="cc-section-eyebrow">Testimonials</span>
        <h2 class="cc-section-title mb-2">Why our clients trust Amtex</h2>
        <p class="cc-section-subtitle">
          Real feedback from customers and safety teams.
        </p>
      </div>

      <div class="row g-3 g-md-4">

        @if(isset($testimonials) && $testimonials->count() > 0)

          @foreach($testimonials as $t)
            <div class="col-md-6 col-lg-3">
              <article class="cc-t-card h-100">

                <p class="cc-t-text">
                  {{ $t->review ?? '' }}
                </p>

                <div class="cc-t-user">
                  {{-- Photo (Optional) --}}
                  @if(!empty($t->photo) && method_exists($t->photo, 'getUrl'))
                    <div class="cc-t-avatar" style="overflow:hidden;">
                      <img
                        src="{{ $t->photo->getUrl() }}"
                        alt="{{ $t->name ?? 'Client' }}"
                        style="width:100%; height:100%; object-fit:cover;"
                        loading="lazy"
                      />
                    </div>
                  @else
                    <div class="cc-t-avatar"><i class="bi bi-person"></i></div>
                  @endif

                  <div>
                    <div class="cc-t-name">{{ $t->name ?? 'Anonymous' }}</div>

                    @if(!empty($t->company_designation))
                      <div class="cc-t-meta">{{ $t->company_designation }}</div>
                    @endif
                  </div>
                </div>

              </article>
            </div>
          @endforeach

        @else

          <div class="col-12">
            <div class="text-center py-4">
              <div class="mb-2"><i class="bi bi-info-circle"></i></div>
              <h5 class="mb-1">No testimonials available</h5>
              <p class="mb-0" style="opacity:.8;">Please add testimonials from the admin panel.</p>
            </div>
          </div>

        @endif

      </div>
    </div>
  </section>

  <!-- =================== CTA =================== -->
  <section id="cc-cta" class="cc-pad cc-pad-cta">
    <div class="container">
      <div class="cc-cta-card row g-3 align-items-center">

        <div class="col-lg-8">
          <span class="cc-cta-eyebrow">
            <i class="bi bi-life-preserver me-1"></i> Need expert guidance?
          </span>

          <h2 class="cc-cta-title mb-1">
            Need certificates mapped to your site &amp; application?
          </h2>

          <p class="cc-cta-text mb-0">
            Tell us about your premises and risk category. Our team will help you select the right models,
            share matching certificates, and support compliance.
          </p>
        </div>

        <div class="col-lg-4 text-lg-end">
          @if(!empty($siteSetting?->phone))
            <a
              href="tel:{{ preg_replace('/\s+/', '', $siteSetting->phone) }}"
              class="btn btn-amtex cc-cta-btn"
            >
              <i class="bi bi-telephone me-1"></i>
              Speak with a safety expert
            </a>
          @elseif(!empty($siteSetting?->whatsapp))
            <a
              href="https://wa.me/{{ preg_replace('/\D/', '', $siteSetting->whatsapp) }}"
              target="_blank"
              class="btn btn-amtex cc-cta-btn"
            >
              <i class="bi bi-whatsapp me-1"></i>
              Chat on WhatsApp
            </a>
          @else
            <a href="#" class="btn btn-secondary cc-cta-btn disabled">
              Contact unavailable
            </a>
          @endif
        </div>

      </div>
    </div>
  </section>

</main>

<!-- =================== UNLOCK MODAL =================== -->
<div class="modal fade" id="ccUnlockModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content cc-modal">

      <div class="modal-header cc-modal-head">
        <div>
          <div class="cc-modal-eyebrow">Unlock download</div>
          <div class="cc-modal-title" id="ccModalTitle">Fill details to continue</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="ccUnlockForm" class="row g-2 g-md-3">
          @csrf
          <input type="hidden" name="download_id" id="ccDownloadId" value="">

          <div class="col-md-6">
            <label class="cc-label">Full name</label>
            <input name="name" type="text" class="form-control cc-input" placeholder="Enter your name" required />
          </div>

          <div class="col-md-6">
            <label class="cc-label">Phone</label>
            <input name="phone" type="tel" class="form-control cc-input" placeholder="Enter phone number" required />
          </div>

          <div class="col-md-6">
            <label class="cc-label">Email (optional)</label>
            <input name="email" type="email" class="form-control cc-input" placeholder="Enter email" />
          </div>

          <div class="col-md-6">
            <label class="cc-label">Company (optional)</label>
            <input name="company" type="text" class="form-control cc-input" placeholder="Company name" />
          </div>

          <div class="col-md-6">
            <label class="cc-label">City</label>
            <input name="city" type="text" class="form-control cc-input" placeholder="City / location" />
          </div>

          <div class="col-md-6">
            <label class="cc-label">Purpose</label>
            <select name="purpose" class="form-select cc-input">
              <option value="" selected>Select purpose</option>
              <option value="Brochure download">Brochure download</option>
              <option value="Company profile download">Company profile download</option>
              <option value="Quotation request">Quotation request</option>
              <option value="Audit / compliance support">Audit / compliance support</option>
              <option value="AMC / refilling">AMC / refilling</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div class="col-12">
            <label class="cc-label">Message (optional)</label>
            <textarea
              name="message"
              class="form-control cc-input cc-textarea"
              rows="3"
              placeholder="Tell us your requirement (site type, quantity, timeline, etc.)"
            ></textarea>
          </div>

          <div class="col-12 mt-1">
            <button type="submit" class="cc-form-btn w-100" id="ccUnlockSubmitBtn">
              Submit &amp; unlock download
            </button>

            <div class="cc-unlock-note" id="ccUnlockNote">
              <i class="bi bi-info-circle me-1"></i>
              Submit details to unlock the file download.
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
  const unlockModal = document.getElementById('ccUnlockModal');
  const ccModalTitle = document.getElementById('ccModalTitle');
  const ccDownloadId = document.getElementById('ccDownloadId');
  const ccUnlockForm = document.getElementById('ccUnlockForm');
  const ccUnlockBtn = document.getElementById('ccUnlockSubmitBtn');
  const ccUnlockNote = document.getElementById('ccUnlockNote');

  unlockModal.addEventListener('show.bs.modal', (event) => {
    const btn = event.relatedTarget;
    const downloadId = btn?.getAttribute('data-download-id');
    const title = btn?.getAttribute('data-download-title') || 'Download file';

    ccDownloadId.value = downloadId || '';
    ccModalTitle.textContent = title;
    ccUnlockNote.innerHTML = `<i class="bi bi-info-circle me-1"></i> Submit details to unlock <b>${title}</b>.`;

    ccUnlockForm.reset();
    ccDownloadId.value = downloadId || '';
  });

  ccUnlockForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    ccUnlockBtn.disabled = true;
    ccUnlockBtn.innerHTML = 'Please wait...';

    try {
      const formData = new FormData(ccUnlockForm);

      const res = await fetch("{{ route('frontend.downloads.unlock') }}", {
        method: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": "{{ csrf_token() }}",
          "Accept": "application/json"
        },
        body: formData
      });

      const data = await res.json();

      if (!res.ok || !data.ok) {
        throw new Error(data.message || 'Unable to unlock download.');
      }

      // Show download button for that item
      const btnId = `ccDownloadBtn-${data.download_id}`;
      const downloadBtn = document.getElementById(btnId);

      if (downloadBtn) {
        downloadBtn.href = data.file_url;
        downloadBtn.classList.remove('d-none');
      }

      // Optional: auto-download
      // window.open(data.file_url, '_blank');

      bootstrap.Modal.getInstance(unlockModal).hide();

    } catch (err) {
      alert(err.message || 'Something went wrong. Please try again.');
    } finally {
      ccUnlockBtn.disabled = false;
      ccUnlockBtn.innerHTML = 'Submit &amp; unlock download';
    }
  });
</script>


@endsection