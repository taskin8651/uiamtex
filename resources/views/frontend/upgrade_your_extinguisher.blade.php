@extends('web_master')
@section('main')

<main id="upg-main">

  <!-- =================== HERO =================== -->
  <section id="upg-hero" class="upg-section-pad">
    <div class="container">
      <div class="row g-4 align-items-center">

        <!-- Left content -->
        <div class="col-lg-7">
          <div class="upg-hero-top d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="upg-pill">
              <i class="bi bi-arrow-repeat me-1"></i>
              Extinguisher Upgrade Program
            </span>
            <span class="upg-pill upg-pill-dark">
              <i class="bi bi-shield-check me-1"></i>
              Cleaner • Safer • Audit-Ready
            </span>
          </div>

          <h1 class="upg-hero-title">
            Upgrade outdated fire extinguishers to
            <span>Mist Retardant Technology</span>
          </h1>

          <p class="upg-hero-subtitle">
            Dry powder extinguishers can cause secondary damage to equipment, interiors and workspaces.
            Amtex enables eligible customers to replace or upgrade existing units with modern
            Mist Retardant Fire Extinguishers designed for cleaner discharge, better control and
            compliance alignment.
          </p>

          <div class="upg-hero-points">
            <div class="upg-point">
              <i class="bi bi-tv"></i>
              <div>
                <div class="upg-point-title">Low residue discharge</div>
                <div class="upg-point-text">
                  Minimises post-fire cleanup and protects electronics, panels and interiors.
                </div>
              </div>
            </div>

            <div class="upg-point">
              <i class="bi bi-activity"></i>
              <div>
                <div class="upg-point-title">Application-specific protection</div>
                <div class="upg-point-text">
                  Recommended based on occupancy type, hazard class and usage environment.
                </div>
              </div>
            </div>

            <div class="upg-point">
              <i class="bi bi-clipboard-check"></i>
              <div>
                <div class="upg-point-title">Compliance & documentation support</div>
                <div class="upg-point-text">
                  Guidance for audits, inspections and record maintenance.
                </div>
              </div>
            </div>
          </div>

          <div class="upg-hero-cta d-flex flex-wrap gap-2 mt-3">
            <a href="#upg-form" class="btn btn-amtex upg-hero-btn">
              Check upgrade eligibility
            </a>
            <a href="#upg-how" class="btn btn-outline-dark upg-hero-btn-outline">
              Understand the process
            </a>
          </div>

          <div class="upg-hero-trust mt-3">
            <span><i class="bi bi-geo-alt me-1"></i> Service coverage across India</span>
            <span><i class="bi bi-truck me-1"></i> Model-dependent delivery timelines</span>
            <span><i class="bi bi-shield-lock me-1"></i> Genuine Amtex products & warranty</span>
          </div>
        </div>

        <!-- Right card -->
        <div class="col-lg-5">
          <div class="upg-hero-card">

            <div class="upg-hero-card-head d-flex align-items-start justify-content-between gap-2">
              <div>
                <div class="upg-card-eyebrow">Upgrade assessment</div>
                <div class="upg-card-title">Request an eligibility check</div>
              </div>
              <span class="upg-mini-chip">
                <i class="bi bi-lightning-charge-fill me-1"></i> Takes ~1 minute
              </span>
            </div>

            <form class="row g-2 mt-2">
              <div class="col-12">
                <input class="form-control upg-input" type="text" placeholder="Full name" />
              </div>
              <div class="col-12">
                <input class="form-control upg-input" type="tel" placeholder="Mobile number" />
              </div>
              <div class="col-12">
                <select class="form-select upg-input">
                  <option selected>Current extinguisher type</option>
                  <option>ABC Dry Powder</option>
                  <option>CO₂</option>
                  <option>Water / Foam based</option>
                  <option>Unsure</option>
                </select>
              </div>
              <div class="col-6">
                <select class="form-select upg-input">
                  <option selected>Capacity</option>
                  <option>2 kg / 2 L</option>
                  <option>4 kg / 4 L</option>
                  <option>6 kg / 6 L</option>
                  <option>9 kg / 9 L</option>
                </select>
              </div>
              <div class="col-6">
                <select class="form-select upg-input">
                  <option selected>Premises type</option>
                  <option>Residential</option>
                  <option>Office / Commercial</option>
                  <option>Retail / Kitchen</option>
                  <option>Industrial / Warehouse</option>
                </select>
              </div>

              <div class="col-12">
                <button type="button" class="upg-card-btn w-100">
                  Submit for evaluation
                </button>
                <p class="upg-card-note mb-0">
                  <i class="bi bi-lock-fill me-1"></i>
                  Your details are used only for upgrade evaluation.
                </p>
              </div>
            </form>

            <div class="upg-card-strip">
              <div class="upg-strip-item">
                <i class="bi bi-arrow-repeat"></i>
                Upgrade paths
              </div>
              <div class="upg-strip-item">
                <i class="bi bi-receipt"></i>
                Compliance records
              </div>
              <div class="upg-strip-item">
                <i class="bi bi-tools"></i>
                Ongoing service
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== HOW IT WORKS =================== -->
  <section id="upg-how" class="upg-section-pad">
    <div class="container">

      <div class="text-center mb-4 mb-md-5">
        <span class="upg-section-eyebrow">How the upgrade works</span>
        <h2 class="upg-section-title mb-2">
          A structured upgrade process, built for safety and compliance.
        </h2>
        <p class="upg-section-subtitle">
          Each upgrade is evaluated carefully to ensure technical feasibility, safety fit and audit readiness.
        </p>
      </div>

      <div class="row g-3 g-md-4">
        <div class="col-md-3 col-6">
          <div class="upg-step">
            <div class="upg-step-no">01</div>
            <h3 class="upg-step-title">Submit basic details</h3>
            <p class="upg-step-text">
              Share extinguisher type, capacity, location and usage environment.
            </p>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="upg-step">
            <div class="upg-step-no">02</div>
            <h3 class="upg-step-title">Technical evaluation</h3>
            <p class="upg-step-text">
              Our team checks condition, certification status and upgrade feasibility.
            </p>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="upg-step">
            <div class="upg-step-no">03</div>
            <h3 class="upg-step-title">Upgrade recommendation</h3>
            <p class="upg-step-text">
              Receive suitable mist model options, exchange value and final quotation.
            </p>
          </div>
        </div>

        <div class="col-md-3 col-6">
          <div class="upg-step">
            <div class="upg-step-no">04</div>
            <h3 class="upg-step-title">Supply & support</h3>
            <p class="upg-step-text">
              Dispatch, installation guidance and documentation support as required.
            </p>
          </div>
        </div>
      </div>

      <div class="upg-how-note mt-4">
        <i class="bi bi-info-circle me-1"></i>
        Upgrade approval depends on extinguisher condition, applicable standards and site-specific risk profile.
      </div>
    </div>
  </section>

  <!-- =================== BEFORE / AFTER =================== -->
  <section id="upg-compare" class="upg-section-pad">
    <div class="container">
      <div class="row g-4 align-items-center">

        <div class="col-lg-5">
          <span class="upg-section-eyebrow">Why upgrade</span>
          <h2 class="upg-section-title mb-2">
            Powder vs Mist: the difference that matters on site.
          </h2>
          <p class="upg-section-subtitle upg-left-sub">
            While powder extinguishers are widely used, mist-based protection offers cleaner discharge
            and better suitability for modern, equipment-heavy environments.
          </p>

          <div class="upg-compare-list">
            <div class="upg-compare-item">
              <div class="upg-compare-head">
                <span class="upg-compare-tag upg-tag-bad">Powder</span>
                <span class="upg-compare-title">Post-discharge impact</span>
              </div>
              <p class="upg-compare-text">
                Dry powder spreads easily, settles into equipment and often requires extensive cleanup
                after deployment.
              </p>
            </div>

            <div class="upg-compare-item">
              <div class="upg-compare-head">
                <span class="upg-compare-tag upg-tag-good">Mist</span>
                <span class="upg-compare-title">Cleaner fire control</span>
              </div>
              <p class="upg-compare-text">
                Fine water mist reduces residue, limiting secondary damage to interiors and sensitive assets.
              </p>
            </div>
          </div>
        </div>

        <div class="col-lg-7">
          <div class="upg-compare-card">
            <div class="row g-3">
              <div class="col-md-6">
                <div class="upg-shot upg-shot-powder">
                  <div class="upg-shot-label">
                    <i class="bi bi-exclamation-triangle me-1"></i> Conventional Powder
                  </div>
                  <div class="upg-shot-body">
                    <ul class="upg-shot-bullets">
                      <li><i class="bi bi-x-circle"></i> Residue inside panels & devices</li>
                      <li><i class="bi bi-x-circle"></i> Higher post-fire cleanup effort</li>
                      <li><i class="bi bi-x-circle"></i> Risk to electronics & interiors</li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="upg-shot upg-shot-mist">
                  <div class="upg-shot-label">
                    <i class="bi bi-stars me-1"></i> Amtex Mist Retardant
                  </div>
                  <div class="upg-shot-body">
                    <ul class="upg-shot-bullets">
                      <li><i class="bi bi-check2-circle"></i> Low-residue discharge</li>
                      <li><i class="bi bi-check2-circle"></i> Safer around electronics</li>
                      <li><i class="bi bi-check2-circle"></i> Better suited for premium sites</li>
                    </ul>
                  </div>
                </div>
              </div>

            </div>

            <div class="upg-compare-bottom">
              <div class="upg-mini-trust">
                <i class="bi bi-shield-check me-1"></i>
                Standards-aligned recommendations
              </div>
              <div class="upg-mini-trust">
                <i class="bi bi-tools me-1"></i>
                Installation, AMC & refilling support
              </div>
              <div class="upg-mini-trust">
                <i class="bi bi-geo-alt me-1"></i>
                Pan-India service coverage
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== ELIGIBILITY + FORM =================== -->
  <section id="upg-form" class="upg-section-pad">
    <div class="container">

      <div class="upg-form-wrap row g-4 align-items-stretch">
        <div class="col-lg-5">
          <div class="upg-form-left">
            <span class="upg-section-eyebrow">Eligibility check</span>
            <h2 class="upg-section-title mb-2">
              See if your existing extinguisher qualifies for an upgrade.
            </h2>
            <p class="upg-section-subtitle">
              Share basic details of your current extinguisher. Our technical team will review its
              condition, application and compliance suitability before recommending upgrade options.
            </p>

            <div class="upg-elig-grid">
              <div class="upg-elig">
                <i class="bi bi-check2-circle"></i>
                <div>
                  <div class="upg-elig-title">Serviceable condition</div>
                  <div class="upg-elig-text">
                    Cylinder body intact, no major corrosion, leakage or structural damage.
                  </div>
                </div>
              </div>
              <div class="upg-elig">
                <i class="bi bi-check2-circle"></i>
                <div>
                  <div class="upg-elig-title">Application suitability</div>
                  <div class="upg-elig-text">
                    Upgrade recommendation based on fire risk, occupancy and site usage.
                  </div>
                </div>
              </div>
              <div class="upg-elig">
                <i class="bi bi-check2-circle"></i>
                <div>
                  <div class="upg-elig-title">Compliance alignment</div>
                  <div class="upg-elig-text">
                    Quantity, placement and model guidance as per applicable standards.
                  </div>
                </div>
              </div>
            </div>

            <div class="upg-left-cta">
              <div class="upg-left-cta-title">
                <i class="bi bi-telephone me-1"></i> Want to speak to an expert directly?
              </div>
              <a class="upg-left-cta-link" href="tel:+919973113905">+91 80478 22682</a>
              <div class="upg-left-cta-sub">
                Technical support available during business hours.
              </div>
            </div>

          </div>
        </div>

        <div class="col-lg-7">
          <div class="upg-form-card">
            <div class="upg-form-head d-flex flex-wrap align-items-center justify-content-between gap-2">
              <div>
                <div class="upg-card-eyebrow">Upgrade request</div>
                <div class="upg-card-title">
                  Share details of your current fire extinguisher
                </div>
              </div>
              <span class="upg-pill upg-pill-soft">
                <i class="bi bi-lock-fill me-1"></i> Information stays confidential
              </span>
            </div>

            <form class="row g-2 g-md-3 mt-1">
              <div class="col-md-6">
                <label class="upg-label">Full name</label>
                <input class="form-control upg-input" type="text" placeholder="Your full name" />
              </div>
              <div class="col-md-6">
                <label class="upg-label">Contact number</label>
                <input class="form-control upg-input" type="tel" placeholder="Mobile number" />
              </div>
              <div class="col-md-6">
                <label class="upg-label">City</label>
                <input class="form-control upg-input" type="text" placeholder="City / location" />
              </div>
              <div class="col-md-6">
                <label class="upg-label">Type of premises</label>
                <select class="form-select upg-input">
                  <option selected>Select premises type</option>
                  <option>Home / Apartment</option>
                  <option>Office / IT Space</option>
                  <option>Retail / Showroom</option>
                  <option>Kitchen / Restaurant</option>
                  <option>Factory / Warehouse</option>
                  <option>Hospital / Institution</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="upg-label">Existing extinguisher type</label>
                <select class="form-select upg-input">
                  <option selected>ABC Dry Powder</option>
                  <option>CO₂ Extinguisher</option>
                  <option>Foam / Water based</option>
                  <option>Not sure</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="upg-label">Capacity</label>
                <select class="form-select upg-input">
                  <option selected>4 KG / 4 L</option>
                  <option>2 KG / 2 L</option>
                  <option>6 KG / 6 L</option>
                  <option>9 KG / 9 L</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="upg-label">Quantity</label>
                <input class="form-control upg-input" type="number" min="1" value="1" />
              </div>

              <div class="col-12">
                <label class="upg-label">Additional notes (optional)</label>
                <textarea
                  class="form-control upg-input upg-textarea"
                  rows="3"
                  placeholder="Installation location, age of extinguisher, any observed issues, expected timeline..."
                ></textarea>
              </div>

              <div class="col-12">
                <div class="upg-form-actions row g-2">
                  <div class="col-md-7">
                    <button type="button" class="upg-form-btn w-100">
                      Submit eligibility request
                    </button>
                  </div>
                  <div class="col-md-5">
                    <a href="products.html" class="btn btn-outline-dark w-100 upg-form-btn-outline">
                      View mist extinguisher range
                    </a>
                  </div>
                </div>

                <div class="upg-form-foot">
                  <div class="upg-form-foot-item">
                    <i class="bi bi-receipt"></i> Exchange value & quotation
                  </div>
                  <div class="upg-form-foot-item">
                    <i class="bi bi-clipboard-check"></i> Compliance documentation
                  </div>
                  <div class="upg-form-foot-item">
                    <i class="bi bi-truck"></i> Pan-India supply & service
                  </div>
                </div>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =================== CTA =================== -->
  <section id="upg-cta" class="upg-section-pad">
    <div class="container">
      <div class="upg-cta-card row g-3 align-items-center">

        <div class="col-lg-8">
          <span class="upg-cta-eyebrow">
            <i class="bi bi-stars me-1"></i>
            Move to cleaner, modern fire protection
          </span>

          <h2 class="upg-cta-title mb-1">
            Planning to replace outdated powder extinguishers?
          </h2>

          <p class="upg-cta-text mb-0">
            Let our experts evaluate your existing setup and recommend the most suitable
            <strong>Mist Retardant Fire Extinguishers</strong> — with clear pricing, exchange value
            and compliance-ready guidance.
          </p>
        </div>

        <div class="col-lg-4 text-lg-end">
          <a href="#upg-form" class="btn btn-amtex upg-cta-btn">
            Check upgrade eligibility
          </a>
        </div>

      </div>
    </div>
  </section>

</main>

@endsection