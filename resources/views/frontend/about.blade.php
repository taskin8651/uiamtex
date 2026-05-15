@extends('web_master')
@section('main')

<main>
    <!-- =================== ABOUT HERO =================== -->
    <section id="about-hero" class="section-padding">
    <div class="container">
        <div class="row align-items-center gy-4">

        <!-- Left: Text -->
        <div class="col-lg-7">
            <span class="about-eyebrow">
            <i class="bi bi-fire me-1"></i>
            About Amtex Safety Systems
            </span>

            <h1 class="about-title mb-2">
            Engineering <span>Dependable Fire Safety</span><br />
            for Real-World Applications
            </h1>

            <p class="about-lead mb-3">
            Amtex Safety Systems is engaged in the design, manufacture and supply of
            fire extinguishers and fire protection solutions that meet applicable
            safety standards and perform reliably in critical fire situations.
            </p>

            <p class="about-lead mb-3">
            Our product range is developed with a focus on safety, compliance and
            practical usability across residential, commercial and industrial
            environments.
            </p>

            <div class="about-hero-meta row g-3">
            <div class="col-sm-4">
                <div class="about-hero-stat">
                <div class="stat-number">ISO</div>
                <div class="stat-label">9001:2015 Certified</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="about-hero-stat">
                <div class="stat-number">BIS</div>
                <div class="stat-label">ISI Marked Products</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="about-hero-stat">
                <div class="stat-number">NABL</div>
                <div class="stat-label">Lab Tested Performance</div>
                </div>
            </div>
            </div>

            <div class="about-breadcrumb mt-3">
            <a href="index.html">
                <i class="bi bi-house-door me-1"></i>Home
            </a>
            <span class="mx-1">/</span>
            <span>About Us</span>
            </div>
        </div>

        <!-- Right: Visual -->
        <div class="col-lg-5">
            <div class="about-hero-visual">
            <div class="about-hero-glow"></div>
            <img
                src="{{asset('frontend/assets/img/about.png')}}"
                alt="Amtex Safety Systems manufacturing and quality processes"
                class="about-hero-image"
            />
            <div class="about-hero-badge">
                <i class="bi bi-shield-check"></i>
                Safety with Quality
            </div>
            </div>
        </div>

        </div>
    </div>
    </section>

    <!-- =================== OUR STORY =================== -->
    <section id="about-story" class="section-padding">
    <div class="container">
        <div class="row g-4 align-items-start">

        <!-- LEFT: Story copy -->
        <div class="col-lg-7">
            <div class="about-story-content">
            <span class="section-eyebrow">Our journey</span>

            <h2 class="section-title mb-2">
                Built on practical fire safety and long-term reliability.
            </h2>

            <p class="section-text">
                Amtex Safety Systems was established with a clear focus on manufacturing
                fire extinguishers that are dependable, compliant and suitable for real
                operating conditions. From the beginning, our emphasis has been on product
                integrity, safety standards and consistent performance.
            </p>

            <p class="section-text mb-3">
                Over time, our portfolio has expanded to include a wide range of portable
                fire extinguishers, water mist systems and automatic fire suppression
                solutions. We work closely with consultants, contractors, facility teams
                and end users to ensure that fire protection solutions are correctly
                selected, installed and maintained.
            </p>

            <!-- Capability highlights -->
            <div class="about-timeline row g-2">
                <div class="col-sm-4">
                <div class="timeline-chip">
                    <span class="timeline-year">Manufacturing</span>
                    <span class="timeline-text">Certified fire extinguisher production</span>
                </div>
                </div>
                <div class="col-sm-4">
                <div class="timeline-chip">
                    <span class="timeline-year">Technology</span>
                    <span class="timeline-text">Water Mist &amp; clean agent solutions</span>
                </div>
                </div>
                <div class="col-sm-4">
                <div class="timeline-chip">
                    <span class="timeline-year">Support</span>
                    <span class="timeline-text">Inspection, refilling &amp; maintenance</span>
                </div>
                </div>
            </div>

            <!-- key strengths -->
            <div class="about-pill-row">
                <span><i class="bi bi-check2-circle me-1"></i>ISO 9001:2015 certified processes</span>
                <span><i class="bi bi-check2-circle me-1"></i>BIS / ISI compliant products</span>
                <span><i class="bi bi-check2-circle me-1"></i>NABL lab tested performance</span>
            </div>
            </div>
        </div>

        <!-- RIGHT: Mission / Vision / Promise card -->
        <div class="col-lg-5">
            <div class="about-story-card">
            <div class="about-story-label">
                Mission • Vision • Commitment
            </div>

            <h3 class="about-story-heading">What guides our work</h3>

            <div class="about-story-item">
                <div class="story-icon-wrap">
                <i class="bi bi-bullseye"></i>
                </div>
                <div>
                <h4>Our Mission</h4>
                <p>
                    To design and supply fire safety solutions that meet applicable
                    standards and remain dependable throughout their service life.
                </p>
                </div>
            </div>

            <div class="about-story-item">
                <div class="story-icon-wrap">
                <i class="bi bi-eye"></i>
                </div>
                <div>
                <h4>Our Vision</h4>
                <p>
                    To contribute to safer residential, commercial and industrial
                    environments through correctly applied fire protection systems.
                </p>
                </div>
            </div>

            <div class="about-story-item mb-0">
                <div class="story-icon-wrap">
                <i class="bi bi-shield-check"></i>
                </div>
                <div>
                <h4>Our Commitment</h4>
                <p>
                    Transparent recommendations, quality-controlled manufacturing and
                    responsible service support before and after supply.
                </p>
                </div>
            </div>
            </div>
        </div>

        </div>
    </div>
    </section>

    <!-- =================== CORE VALUES =================== -->
    <section id="about-values" class="section-padding">
    <div class="container">

        <div class="text-center mb-4 mb-md-5">
        <span class="section-eyebrow">What we stand for</span>
        <h2 class="section-title mb-2">Principles that guide every Amtex solution.</h2>
        <p class="section-subtitle">
            Our approach to fire safety is shaped by these core principles, applied consistently
            across products, services and long-term support.
        </p>
        </div>

        <div class="row g-3 g-md-4">

        <!-- Reliability -->
        <div class="col-md-4">
            <div class="value-card">
            <div class="value-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h3>Reliability</h3>
            <p>
                Fire extinguishers and suppression systems that are manufactured,
                tested and certified in accordance with applicable standards to
                ensure dependable performance during fire incidents.
            </p>
            </div>
        </div>

        <!-- Innovation -->
        <div class="col-md-4">
            <div class="value-card">
            <div class="value-icon">
                <i class="bi bi-cpu-fill"></i>
            </div>
            <h3>Technology</h3>
            <p>
                Adoption of modern fire suppression technologies such as Water Mist
                and Clean Agent systems, designed to suit contemporary buildings,
                equipment and sensitive environments.
            </p>
            </div>
        </div>

        <!-- Partnership -->
        <div class="col-md-4">
            <div class="value-card">
            <div class="value-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <h3>Responsibility</h3>
            <p>
                A long-term commitment to responsible fire safety through correct
                product selection, compliance guidance, refilling and maintenance
                support over the system lifecycle.
            </p>
            </div>
        </div>

        </div>

    </div>
    </section>

    <!-- =================== MIST TECHNOLOGY FOCUS =================== -->
    <section id="about-mist" class="section-padding">
    <div class="container">
        <div class="row g-4 align-items-center">

        <!-- LEFT CONTENT -->
        <div class="col-lg-6">
            <span class="section-eyebrow">Water Mist Technology</span>
            <h2 class="section-title mb-2">
            Why water mist plays a key role in modern fire protection.
            </h2>

            <p class="section-text">
            In many modern environments, conventional fire extinguishing agents may
            result in secondary damage to equipment, interiors or sensitive systems.
            Water Mist Fire Extinguishers are designed to address these challenges
            while maintaining effective fire suppression.
            </p>

            <p class="section-text">
            Amtex Safety Systems incorporates water mist technology in applications
            where controlled discharge, reduced residue and suitability for occupied
            spaces are important considerations.
            </p>

            <ul class="about-mist-list">
            <li>
                <i class="bi bi-droplet-half"></i>
                Fine water droplets that absorb heat efficiently and help cool the fire zone.
            </li>
            <li>
                <i class="bi bi-tv"></i>
                Reduced water usage and minimal residue, suitable for electronics and interiors.
            </li>
            <li>
                <i class="bi bi-activity"></i>
                Effective on multiple classes of fire, subject to correct application.
            </li>
            <li>
                <i class="bi bi-shield-check"></i>
                Designed and tested in accordance with applicable fire safety standards.
            </li>
            </ul>
        </div>

        <!-- RIGHT VISUAL -->
        <div class="col-lg-6">
            <div class="about-mist-panel">
            <div class="about-mist-badge">
                <i class="bi bi-stars"></i>
                Water Mist Fire Extinguishers
            </div>
            <img
                src="{{asset('frontend/assets/img/hero_one.png')}}"
                alt="Amtex Water Mist Fire Extinguisher"
                class="about-mist-image"
            />
            </div>
        </div>

        </div>
    </div>
    </section>

    <!-- =================== HOW WE WORK =================== -->
    <section id="about-process" class="section-padding">
    <div class="container">
        <div class="text-center mb-4 mb-md-5">
        <span class="section-eyebrow">How we work</span>
        <h2 class="section-title mb-2">A structured approach to fire safety implementation.</h2>
        <p class="section-subtitle">
            From initial assessment to ongoing support, our process is designed to ensure
            correct selection, installation and long-term reliability of fire safety systems.
        </p>
        </div>

        <div class="row g-3 g-md-4 justify-content-center">

        <!-- Step 1 -->
        <div class="col-md-3">
            <div class="process-step">
            <div class="process-step-number">01</div>
            <h3>Assess requirements</h3>
            <p>
                Understanding site conditions, occupancy type, fire risk and
                existing safety infrastructure as a basis for recommendations.
            </p>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="col-md-3">
            <div class="process-step">
            <div class="process-step-number">02</div>
            <h3>Define solutions</h3>
            <p>
                Selection of suitable fire extinguishers or suppression systems
                in line with applicable standards and site-specific needs.
            </p>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="col-md-3">
            <div class="process-step">
            <div class="process-step-number">03</div>
            <h3>Supply &amp; commissioning</h3>
            <p>
                Supply and commissioning of equipment with required documentation
                and conformity to installation guidelines.
            </p>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="col-md-3">
            <div class="process-step">
            <div class="process-step-number">04</div>
            <h3>Service &amp; support</h3>
            <p>
                Refilling, inspection and maintenance services to help ensure
                continued compliance and operational readiness.
            </p>
            </div>
        </div>

        </div>

    </div>
    </section>

    <!-- =================== LEADERSHIP / TEAM =================== -->
    <section id="about-team" class="section-padding">
    <div class="container">

        <div class="text-center mb-4 mb-md-5">
        <span class="section-eyebrow">Leadership &amp; Team</span>
        <h2 class="section-title mb-2">People behind Amtex Safety Systems.</h2>
        <p class="section-subtitle">
            A multidisciplinary team responsible for product integrity, compliance,
            operations and long-term customer support.
        </p>
        </div>

        <div class="row g-3 g-md-4 justify-content-center">

        <!-- Team Area 1 -->
        <div class="col-md-4">
            <div class="team-card">
            <div class="team-avatar">
                <span>LD</span>
            </div>
            <h3 class="team-name">Leadership &amp; Management</h3>
            <p class="team-role">Strategy &amp; Governance</p>
            <p class="team-bio">
                Responsible for overall direction, regulatory alignment and ensuring
                that Amtex Safety Systems operates in line with applicable fire safety
                standards and long-term objectives.
            </p>
            </div>
        </div>

        <!-- Team Area 2 -->
        <div class="col-md-4">
            <div class="team-card">
            <div class="team-avatar">
                <span>OP</span>
            </div>
            <h3 class="team-name">Operations &amp; Quality</h3>
            <p class="team-role">Manufacturing &amp; Execution</p>
            <p class="team-bio">
                Oversees production processes, quality checks, documentation and
                coordination for supply, installation and commissioning activities.
            </p>
            </div>
        </div>

        <!-- Team Area 3 -->
        <div class="col-md-4">
            <div class="team-card">
            <div class="team-avatar">
                <span>SV</span>
            </div>
            <h3 class="team-name">Service &amp; Support</h3>
            <p class="team-role">Maintenance &amp; Compliance</p>
            <p class="team-bio">
                Manages inspection, refilling, AMC coordination and technical assistance
                to support customers during audits and periodic safety reviews.
            </p>
            </div>
        </div>

        </div>

        <p class="team-note small text-center mt-3 mb-0">
        Leadership profiles and individual details may be updated as required.
        </p>

    </div>
    </section>

    <!-- =================== PAN-INDIA PRESENCE CTA =================== -->
    <section id="about-cta" class="section-padding">
    <div class="container">
        <div class="about-cta-card row align-items-center g-3">

        <div class="col-lg-8">
            <h2 class="about-cta-title">
            Looking to review or strengthen your fire safety arrangements?
            </h2>
            <p class="about-cta-text mb-0">
            Share your site or project requirements and our team will assist with
            suitable fire extinguishers, systems and service options based on
            applicable standards and site conditions.
            </p>
        </div>

        <div class="col-lg-4 text-lg-end">
            <a href="#quick-enquiry" class="btn btn-amtex about-cta-btn">
            Contact our team
            </a>
        </div>

        </div>
    </div>
    </section>
</main>

@endsection