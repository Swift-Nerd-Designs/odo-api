<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * MainSeeder
 *
 * Seeds all required data for the Odo Group website.
 *
 * Run:  php spark db:seed MainSeeder
 */
class MainSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        $this->seedPages();

        echo "Database seeded successfully.\n";
        echo "  Default password: changeme — change it immediately via /admin/settings\n";
    }

    // ----------------------------------------------------------------
    // Settings
    // ----------------------------------------------------------------

    private function seedSettings(): void
    {
        $settings = [
            // Default password is "changeme" — MUST be changed after first deploy
            'admin_password_hash' => password_hash('changeme', PASSWORD_BCRYPT),

            'site_name'  => 'Odo Group',
            'email'      => 'consultation@odocorp.co.za',
            'phone'      => '+27 82 870 7275',
            'whatsapp'   => '+27828707275',
            'address'    => '35 Tsitsikame Street, Secunda, MP 2302',
            'facebook'   => 'https://www.facebook.com/odogroupsa',
            'twitter'    => '',
            'instagram'  => '',
            'linkedin'   => 'https://www.linkedin.com/company/odo-group',
        ];

        foreach ($settings as $key => $value) {
            $this->db->table('settings')->upsert([
                'key'   => $key,
                'value' => $value,
            ]);
        }

        echo "  Settings seeded.\n";
    }

    // ----------------------------------------------------------------
    // Pages
    // ----------------------------------------------------------------

    private function seedPages(): void
    {
        foreach ($this->builtinPages() as $slug => $data) {
            $this->db->table('pages')->upsert([
                'slug'       => $slug,
                'data'       => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            echo "  Page '{$slug}' upserted.\n";
        }
    }

    private function builtinPages(): array
    {
        return [

            // ── Home ──────────────────────────────────────────────────────
            'home' => [
                'seoTitle'       => 'Odo Group | IT Support & Managed Services Provider',
                'seoDescription' => 'Empowering businesses with reliable IT solutions. Managed services, cybersecurity, network design and more across South Africa.',
                'content' => [
                    'blocks' => [

                        // Full-screen hero
                        [
                            'id'   => 'home-hero',
                            'type' => 'hero',
                            'data' => [
                                'eyebrow'  => 'Managed Services Provider',
                                'heading'  => 'Empowering Businesses with Reliable IT Solutions.',
                                'body'     => 'Your expert tech team — proactive, secure, and always ready.',
                                'bgImage'  => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1920&q=80',
                                'ctaLabel' => 'Explore Our Solutions',
                                'ctaHref'  => '/services',
                            ],
                        ],

                        // About strip: text + icon feature cards
                        [
                            'id'   => 'home-about',
                            'type' => 'features',
                            'data' => [
                                'eyebrow'  => 'About Us',
                                'heading'  => 'Growing your business through a value-driven strategy.',
                                'body'     => "At Odo Group, we truly care about our clients and are dedicated to understanding their unique needs. We're always exploring new ideas and finding better ways to serve them, while ensuring our solutions are dependable and built to last.",
                                'ctaLabel' => 'More About Us',
                                'ctaHref'  => '/about',
                                'items'    => [
                                    ['icon' => 'lightbulb', 'title' => 'What we do',   'body' => 'We specialise in building rock-solid IT systems that are secure, reliable, and always ready to support your growth. Think of us as your expert tech team.'],
                                    ['icon' => 'users',     'title' => 'Our Team',     'body' => 'Highly motivated experts with extensive experience. We deeply value our clients and partners, recognising their crucial role in co-creating solutions.'],
                                    ['icon' => 'globe',     'title' => 'Our Resolve',  'body' => 'Leverage technology responsibly to contribute to a sustainable future for our communities and the planet.'],
                                ],
                            ],
                        ],

                        // Our Solutions: icon card grid
                        [
                            'id'   => 'home-services',
                            'type' => 'icon_cards',
                            'data' => [
                                'eyebrow'   => 'What We Offer',
                                'heading'   => 'Our Solutions',
                                'body'      => 'We provide a comprehensive suite of managed IT services designed to empower businesses with seamless technology solutions.',
                                'cols'      => '3',
                                'iconStyle' => 'light',
                                'background'=> 'gray',
                                'ctaLabel'  => 'Explore All Services',
                                'ctaHref'   => '/services',
                                'items'     => [
                                    ['icon' => 'support',  'title' => '24/7 IT Support',                      'body' => 'Reliable helpdesk and technical support to minimise downtime.'],
                                    ['icon' => 'shield',   'title' => 'Cybersecurity',                        'body' => 'Advanced security solutions to protect your data and infrastructure.'],
                                    ['icon' => 'code',     'title' => 'Web Design & Development',             'body' => 'Crafting stunning, responsive, and user-friendly websites that elevate your brand.'],
                                    ['icon' => 'wifi',     'title' => 'Network Design & Management',          'body' => 'Proactive monitoring and optimisation for seamless connectivity.'],
                                    ['icon' => 'database', 'title' => 'IT Systems Development & Integration', 'body' => 'Custom development projects and IT consulting & strategic planning.'],
                                    ['icon' => 'upload',   'title' => 'Backup & Disaster Recovery',           'body' => 'Robust data backup and recovery plans to safeguard your business continuity.'],
                                ],
                            ],
                        ],

                        // Why Choose Us
                        [
                            'id'   => 'home-why',
                            'type' => 'icon_cards',
                            'data' => [
                                'eyebrow'   => 'Why Us',
                                'heading'   => 'Why Choose Odo Group?',
                                'cols'      => '2',
                                'iconStyle' => 'solid',
                                'background'=> 'white',
                                'items'     => [
                                    ['icon' => 'heart',  'title' => 'Client-Centric Approach', 'body' => 'We put your business needs first, tailoring our services to achieve your specific goals.'],
                                    ['icon' => 'eye',    'title' => 'Proactive Monitoring',    'body' => 'We identify and resolve issues before they impact your operations, keeping you running smoothly.'],
                                    ['icon' => 'badge',  'title' => 'Expertise',               'body' => 'Our certified team brings deep technical knowledge across all areas of IT management.'],
                                    ['icon' => 'bolt',   'title' => 'Future-Ready IT',         'body' => 'We help you adopt emerging technologies that scale with your business as it grows.'],
                                ],
                            ],
                        ],

                        // Stats bar
                        [
                            'id'   => 'home-stats',
                            'type' => 'stats',
                            'data' => [
                                'eyebrow' => 'Our Impact',
                                'items'   => [
                                    ['value' => '25+',     'label' => 'Clients'],
                                    ['value' => '20+',     'label' => 'Positive Reviews'],
                                    ['value' => '30 min',  'label' => 'Avg Response Time'],
                                    ['value' => '6,100 GB','label' => 'Data Recovered'],
                                ],
                            ],
                        ],

                        // Notable clients
                        [
                            'id'   => 'home-clients',
                            'type' => 'clients',
                            'data' => [
                                'eyebrow' => 'Our Clients',
                                'heading' => 'Notable Clients',
                                'body'    => 'Over the last 5 years, we have helped organisations achieve outstanding results',
                                'items'   => [
                                    ['name' => 'FDT',    'logo' => 'https://res.cloudinary.com/drupxc9i4/image/upload/odo/images/clients/fdt.png'],
                                    ['name' => 'Kayise', 'logo' => 'https://res.cloudinary.com/drupxc9i4/image/upload/odo/images/clients/kayise.png'],
                                    ['name' => 'NGA',    'logo' => 'https://res.cloudinary.com/drupxc9i4/image/upload/odo/images/clients/nga.png'],
                                    ['name' => 'SSS',    'logo' => 'https://res.cloudinary.com/drupxc9i4/image/upload/odo/images/clients/sss.png'],
                                ],
                            ],
                        ],

                        // Contact form
                        [
                            'id'   => 'home-contact',
                            'type' => 'contact',
                            'data' => [
                                'eyebrow' => 'Contact',
                                'heading' => 'Get In Touch',
                                'intro'   => "We're a friendly bunch..",
                                'blurb'   => 'We create solutions for companies and startups with a passion for quality',
                                'address' => '35 Tsitsikame Street, Secunda, MP 2302',
                                'email'   => 'consultation@odocorp.co.za',
                                'phone'   => '+27 82 870 7275',
                                'hours'   => "Monday – Friday: 08:00 – 17:00\nAfter Hours: Emergency support available",
                            ],
                        ],
                    ],
                ],
            ],

            // ── About ──────────────────────────────────────────────────────
            'about' => [
                'seoTitle'       => 'About Us — Odo Group',
                'seoDescription' => 'Learn about Odo Group — your trusted IT partner. Our vision, mission, core values, and why businesses trust us.',
                'eyebrow'        => 'Your Trusted IT Partner',
                'title'          => 'Who We Are & Our Values',
                'body'           => '',
                'image'          => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&w=1200&q=80',
                'content' => [
                    'blocks' => [

                        // Main about section
                        [
                            'id'   => 'about-story',
                            'type' => 'media',
                            'data' => [
                                'eyebrow'   => 'Our Story',
                                'heading'   => 'Founded on proactive IT support.',
                                'body'      => "At Odo Group, we believe in proactive IT support. Founded in 2021, we've built our company on the principle of understanding your business inside and out. We don't just fix problems when they arise; we work to anticipate your needs and prevent them in the first place.",
                                'imageUrl'  => 'https://images.unsplash.com/photo-1551434678-e076c223a692?auto=format&fit=crop&w=900&q=80',
                                'imagePosition' => 'right',
                                'checklist' => [
                                    'Proactive monitoring and prevention',
                                    'Personalised, tailored IT solutions',
                                    'Certified and experienced team',
                                    'Long-term technology partnerships',
                                ],
                                'ctaLabel'  => 'Explore Our Services',
                                'ctaHref'   => '/services',
                            ],
                        ],

                        // Vision & Mission
                        [
                            'id'   => 'about-vision',
                            'type' => 'icon_cards',
                            'data' => [
                                'eyebrow'   => 'Our Purpose',
                                'heading'   => 'Vision & Mission',
                                'cols'      => '2',
                                'iconStyle' => 'light',
                                'background'=> 'gray',
                                'items'     => [
                                    ['icon' => 'lightbulb', 'title' => 'Our Vision',  'body' => 'To be the trusted partner businesses rely on for advanced IT solutions, ensuring operational excellence and technological innovation.'],
                                    ['icon' => 'bolt',      'title' => 'Our Mission', 'body' => 'To simplify technology management and deliver customised solutions that enhance productivity, secure data, and enable sustainable growth.'],
                                ],
                            ],
                        ],

                        // Core Values
                        [
                            'id'   => 'about-values',
                            'type' => 'icon_cards',
                            'data' => [
                                'eyebrow'   => 'What Drives Us',
                                'heading'   => 'Our Core Values',
                                'cols'      => '4',
                                'iconStyle' => 'solid',
                                'background'=> 'white',
                                'items'     => [
                                    ['icon' => 'heart',  'title' => 'Client-Centric', 'body' => 'Everything we do is guided by our clients\' goals and success.'],
                                    ['icon' => 'lightbulb', 'title' => 'Innovation', 'body' => 'We continuously explore new technologies to deliver cutting-edge solutions.'],
                                    ['icon' => 'badge',  'title' => 'Integrity',     'body' => 'We are transparent, honest, and accountable in every relationship.'],
                                    ['icon' => 'star',   'title' => 'Excellence',    'body' => 'We hold ourselves to the highest standards and never settle for good enough.'],
                                ],
                            ],
                        ],

                        // Why Choose Us
                        [
                            'id'   => 'about-why',
                            'type' => 'icon_cards',
                            'data' => [
                                'eyebrow'   => 'Why Us',
                                'heading'   => 'Why Choose Odo Group?',
                                'cols'      => '2',
                                'iconStyle' => 'light',
                                'background'=> 'gray',
                                'items'     => [
                                    ['icon' => 'heart', 'title' => 'Client-Centric Approach', 'body' => 'We put your business needs first, tailoring our services to achieve your specific goals.'],
                                    ['icon' => 'eye',   'title' => 'Proactive Monitoring',    'body' => 'We identify and resolve issues before they impact your operations.'],
                                    ['icon' => 'badge', 'title' => 'Expertise',               'body' => 'Our certified team brings deep technical knowledge across all areas of IT management.'],
                                    ['icon' => 'bolt',  'title' => 'Future-Ready IT',         'body' => 'We help you adopt emerging technologies that scale with your business.'],
                                ],
                            ],
                        ],

                        // Stats
                        [
                            'id'   => 'about-stats',
                            'type' => 'stats',
                            'data' => [
                                'eyebrow' => 'By The Numbers',
                                'items'   => [
                                    ['value' => '2021',  'label' => 'Founded'],
                                    ['value' => '25+',   'label' => 'Clients Served'],
                                    ['value' => '30 min','label' => 'Avg Response Time'],
                                    ['value' => '99.9%', 'label' => 'Uptime Target'],
                                ],
                            ],
                        ],

                        // CTA
                        [
                            'id'   => 'about-cta',
                            'type' => 'cta',
                            'data' => [
                                'eyebrow'  => 'Work with us',
                                'heading'  => 'Ready to simplify your IT?',
                                'body'     => "Let's talk about how Odo Group can become your trusted technology partner.",
                                'ctaLabel' => 'Get in Touch',
                                'ctaHref'  => '/contact',
                                'image'    => 'https://images.unsplash.com/photo-1531297484001-80022131f5a1?auto=format&fit=crop&w=1920&q=80',
                            ],
                        ],
                    ],
                ],
            ],

            // ── Services ──────────────────────────────────────────────────
            'services' => [
                'seoTitle'       => 'Our Services — Odo Group',
                'seoDescription' => 'Comprehensive managed IT services: 24/7 support, cybersecurity, network management, web development, and more.',
                'eyebrow'        => 'What We Offer',
                'title'          => 'Comprehensive IT Solutions',
                'body'           => 'A full suite of managed services tailored to your business.',
                'image'          => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=1200&q=80',
                'content' => [
                    'blocks' => [

                        // Core Managed Services
                        [
                            'id'   => 'svc-core',
                            'type' => 'icon_cards',
                            'data' => [
                                'eyebrow'   => 'Core Offering',
                                'heading'   => 'Core Managed Services',
                                'body'      => 'Our foundation services ensure your IT environment is always monitored, maintained, and supported.',
                                'cols'      => '2',
                                'iconStyle' => 'solid',
                                'background'=> 'white',
                                'items'     => [
                                    ['icon' => 'wifi',    'title' => '24/7 Network Monitoring', 'body' => 'Around-the-clock monitoring of your entire network infrastructure. We detect anomalies, performance degradation, and security threats in real-time.'],
                                    ['icon' => 'support', 'title' => 'Help Desk Support',       'body' => 'Fast, friendly technical support for your team. Our certified support specialists resolve hardware, software, and connectivity issues with minimal disruption.'],
                                ],
                            ],
                        ],

                        // Infrastructure Management
                        [
                            'id'   => 'svc-infra',
                            'type' => 'icon_cards',
                            'data' => [
                                'eyebrow'   => 'IT Infrastructure',
                                'heading'   => 'Infrastructure Management',
                                'body'      => 'End-to-end management of your physical and virtual IT infrastructure to ensure peak performance and reliability.',
                                'cols'      => '3',
                                'iconStyle' => 'light',
                                'background'=> 'gray',
                                'items'     => [
                                    ['icon' => 'server',   'title' => 'Server Management',              'body' => 'Comprehensive server administration, patching, performance optimisation, and capacity planning.'],
                                    ['icon' => 'wifi',     'title' => 'Network Management',             'body' => 'Design, deployment, and ongoing management of your network infrastructure.'],
                                    ['icon' => 'endpoint', 'title' => 'Endpoint Management',            'body' => 'Centralised management of all devices including desktops, laptops, and mobile devices.'],
                                    ['icon' => 'badge',    'title' => 'Hardware & Software Procurement','body' => 'Vendor-neutral procurement advice and sourcing at competitive prices, with full lifecycle management.'],
                                    ['icon' => 'users',    'title' => 'Vendor Management',              'body' => 'We act as your single point of contact for all technology vendors, managing relationships and SLAs.'],
                                    ['icon' => 'chart',    'title' => 'IT Consulting',                  'body' => 'Strategic IT advice and guidance aligned with your business goals.'],
                                ],
                            ],
                        ],

                        // Web Development
                        [
                            'id'   => 'svc-web',
                            'type' => 'media',
                            'data' => [
                                'eyebrow'   => 'Digital Presence',
                                'heading'   => 'Website Development & Maintenance',
                                'body'      => 'From concept to launch, we build professional websites that represent your brand, convert visitors, and perform flawlessly on all devices.',
                                'imageUrl'  => 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?auto=format&fit=crop&w=900&q=80',
                                'imagePosition' => 'right',
                                'checklist' => [
                                    'Responsive website design & development',
                                    'Content Management System (CMS) integration',
                                    'E-commerce solutions',
                                    'Website performance optimisation',
                                    'Ongoing maintenance & security updates',
                                    'SEO-ready architecture',
                                ],
                                'ctaLabel'  => 'Get a Quote',
                                'ctaHref'   => '/contact',
                            ],
                        ],

                        // Specialised Services
                        [
                            'id'   => 'svc-specialised',
                            'type' => 'icon_cards',
                            'data' => [
                                'eyebrow'   => 'Additional Services',
                                'heading'   => 'Specialised Solutions',
                                'body'      => 'Beyond the basics — advanced and specialised IT services to address complex business needs.',
                                'cols'      => '3',
                                'iconStyle' => 'light',
                                'background'=> 'white',
                                'items'     => [
                                    ['icon' => 'shield',   'title' => 'Cybersecurity',                       'body' => 'Advanced threat protection, vulnerability assessments, security audits, and staff awareness training.'],
                                    ['icon' => 'upload',   'title' => 'Backup & Disaster Recovery',          'body' => 'Robust data backup solutions and comprehensive disaster recovery plans for business continuity.'],
                                    ['icon' => 'database', 'title' => 'IT Systems Development & Integration','body' => 'Custom software development, API integrations, and strategic IT consulting.'],
                                    ['icon' => 'cloud',    'title' => 'Cloud Services',                      'body' => 'Migration to cloud platforms, hybrid cloud management, and optimisation of cloud costs and performance.'],
                                    ['icon' => 'chart',    'title' => 'IT Consulting & Strategy',            'body' => 'Strategic technology advisory to align IT investments with business goals and digital transformation.'],
                                    ['icon' => 'phone',    'title' => 'VoIP & Communications',               'body' => 'Modern business phone systems and unified communications solutions to improve collaboration.'],
                                ],
                            ],
                        ],

                        // CTA
                        [
                            'id'   => 'svc-cta',
                            'type' => 'cta',
                            'data' => [
                                'eyebrow'  => 'Get started',
                                'heading'  => 'Not sure which service fits your needs?',
                                'body'     => "Contact us for a free consultation — we'll assess your infrastructure and recommend the right solution.",
                                'ctaLabel' => 'Book a Consultation',
                                'ctaHref'  => '/contact',
                                'image'    => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1920&q=80',
                            ],
                        ],
                    ],
                ],
            ],

            // ── Pricing ──────────────────────────────────────────────────
            'pricing' => [
                'seoTitle'       => 'IT Support & Web Design Pricing | Odo Group',
                'seoDescription' => 'Transparent managed IT support from R1,500/month and fixed-price web design from R7,500. Flat rates, no hidden fees, and no lock-in surprises. South Africa-based.',
                'image'          => '',
                'content' => [
                    'blocks' => [

                        // ── Hero ──────────────────────────────────────────
                        [
                            'id'   => 'pricing-hero',
                            'type' => 'hero',
                            'data' => [
                                'eyebrow'   => 'Managed IT Support & Web Development',
                                'heading'   => 'Technology investment, clearly defined.',
                                'body'      => 'Structured IT support programmes and fixed-scope web development engagements — each transparently priced, professionally delivered, and aligned to where your business is going.',
                                'bgImage'   => '',
                                'ctaLabel'  => '',
                                'ctaHref'   => '',
                                'statValue' => 'R1,500',
                                'statLabel' => 'Managed IT support from / month',
                            ],
                        ],

                        // ── IT Support Plans ──────────────────────────────
                        [
                            'id'   => 'pricing-it-plans',
                            'type' => 'pricing_plans',
                            'data' => [
                                'eyebrow'   => 'Managed IT Support',
                                'heading'   => 'Support Programmes',
                                'priceUnit' => 'month',

                                'p1Tier'     => 'Tier 1',
                                'p1Name'     => 'Essential Care',
                                'p1Target'   => 'Designed for businesses of up to 5 users requiring dependable, managed IT coverage',
                                'p1PriceNum' => '1,500',
                                'p1PriceVat' => 'R1,725',
                                'p1CtaLabel' => 'Enquire Now',
                                'p1CtaHref'  => '/contact',
                                'p1Featured' => false,
                                'p1Features' => "Remote IT support — Monday to Friday, 08:00 to 17:00\nDedicated helpdesk via email and WhatsApp\nAll requests logged, tracked, and referenced\nManaged antivirus and endpoint protection\nMonthly system health check with written summary\nPatch management for Windows and core business applications\nMicrosoft 365 email configuration and support",
                                'p1Limits'   => 'Up to 5 devices · Next business day response · Remote only',
                                'p1Tagline'  => '"A measured IT foundation for businesses that value operational consistency."',

                                'p2Tier'     => 'Tier 2',
                                'p2Name'     => 'Business Protect',
                                'p2Target'   => 'Suited to growing businesses of up to 10 users requiring structured support and proactive oversight',
                                'p2PriceNum' => '3,500',
                                'p2PriceVat' => 'R4,025',
                                'p2CtaLabel' => 'Enquire Now',
                                'p2CtaHref'  => '/contact',
                                'p2Featured' => false,
                                'p2Features' => "All Essential Care inclusions, plus:\nPriority remote support — 4 to 8-hour response target\nScheduled onsite support — one visit per month (up to 4 hours)\nNetwork monitoring — router, Wi-Fi, firewall, and switching infrastructure\nBackup monitoring and management across cloud and local repositories\nMicrosoft 365 full administration and licence management\nUser provisioning and deprovisioning (up to 2 events per month)\nActive threat monitoring with monthly security summary",
                                'p2Limits'   => 'Up to 10 devices · 4–8h response · 1 onsite visit / month',
                                'p2Tagline'  => '"Proactive IT governance — structured to address issues before they become incidents."',

                                'p3Tier'     => 'Tier 3',
                                'p3Name'     => 'Premium IT Partner',
                                'p3Target'   => 'Reserved for IT-reliant organisations of up to 20 users requiring a comprehensive managed IT partnership',
                                'p3PriceNum' => '7,500',
                                'p3PriceVat' => 'R8,625',
                                'p3CtaLabel' => 'Enquire Now',
                                'p3CtaHref'  => '/contact',
                                'p3Featured' => true,
                                'p3Features' => "All Business Protect inclusions, plus:\nUnlimited remote support tickets (subject to fair-use policy)\nPriority onsite support — up to 2 visits per month (up to 4 hours each)\n24/7 automated infrastructure monitoring with P1 on-call escalation\nAdvanced endpoint security — EDR with active threat response\nUser provisioning and deprovisioning (up to 5 events per month)\nAnnual disaster recovery planning and recovery testing\nServer and cloud infrastructure management (up to 3 servers)\nQuarterly IT strategy review and forward planning session\nSLA service credits applicable to P1 and P2 incidents",
                                'p3Limits'   => 'Up to 20 devices · 1–2h P1 response · 2 onsite visits / month',
                                'p3Tagline'  => '"A complete outsourced IT function — enterprise discipline, without the enterprise overhead."',
                            ],
                        ],

                        // ── Trust Bar ─────────────────────────────────────
                        [
                            'id'   => 'pricing-trust',
                            'type' => 'trust_bar',
                            'data' => [
                                'items' => [
                                    ['icon' => '🔒', 'label' => 'POPIA Compliant',      'sub' => 'Data handled with legal and ethical rigour'   ],
                                    ['icon' => '⚡', 'label' => '1-Hour P1 Response',   'sub' => 'SLA-backed on our Premium programme'          ],
                                    ['icon' => '🏆', 'label' => '24/7 Monitoring',      'sub' => 'Continuous infrastructure alerting'           ],
                                    ['icon' => '🇿🇦', 'label' => 'South Africa–Based',  'sub' => 'Local expertise, no offshoring'               ],
                                    ['icon' => '📋', 'label' => 'Written SLA',          'sub' => 'Documented commitments on every engagement'   ],
                                ],
                            ],
                        ],

                        // ── IT Plan Comparison ────────────────────────────
                        [
                            'id'   => 'pricing-it-compare',
                            'type' => 'comparison_table',
                            'data' => [
                                'heading' => 'IT Programme Comparison',
                                'col1'    => 'Essential Care',
                                'col2'    => 'Business Protect',
                                'col3'    => 'Premium Partner',
                                'rows'    => [
                                    ['feature' => 'Monthly fee (excl. VAT)',       'c1' => 'R1,500',           'c2' => 'R3,500',           'c3' => 'R7,500'],
                                    ['feature' => 'Device coverage',               'c1' => 'Up to 5',          'c2' => 'Up to 10',         'c3' => 'Up to 20'],
                                    ['feature' => 'Support hours',                 'c1' => 'Mon–Fri 8am–5pm',  'c2' => 'Mon–Fri 8am–5pm',  'c3' => 'Business hrs + 24/7 P1'],
                                    ['feature' => 'P1 response target',            'c1' => 'Within 4 hours',   'c2' => 'Within 2 hours',   'c3' => 'Within 1 hour'],
                                    ['feature' => 'Onsite support',                'c1' => '—',                'c2' => '1 visit / month',  'c3' => 'Up to 2 / month'],
                                    ['feature' => 'Network monitoring',            'c1' => '—',                'c2' => '✔',                'c3' => '24/7'],
                                    ['feature' => 'Backup management',             'c1' => '—',                'c2' => '✔',                'c3' => '✔'],
                                    ['feature' => 'Microsoft 365 admin',           'c1' => 'Email only',       'c2' => 'Full admin',        'c3' => 'Full admin'],
                                    ['feature' => 'User onboarding / offboarding', 'c1' => '—',                'c2' => '2 events / month', 'c3' => '5 events / month'],
                                    ['feature' => 'Advanced cybersecurity (EDR)',  'c1' => '—',                'c2' => 'Basic monitoring', 'c3' => 'Full EDR + response'],
                                    ['feature' => 'Server & cloud support',        'c1' => '—',                'c2' => '—',                'c3' => '✔'],
                                    ['feature' => 'Disaster recovery plan',        'c1' => '—',                'c2' => '—',                'c3' => '✔'],
                                    ['feature' => 'IT strategy consulting',        'c1' => '—',                'c2' => '—',                'c3' => 'Quarterly'],
                                    ['feature' => 'SLA service credits',           'c1' => '—',                'c2' => '—',                'c3' => 'P1 & P2 incidents'],
                                ],
                            ],
                        ],

                        // ── IT Add-Ons ────────────────────────────────────
                        [
                            'id'   => 'pricing-it-addons',
                            'type' => 'addons',
                            'data' => [
                                'eyebrow' => 'Supplementary Services',
                                'heading' => 'IT Supplementary Services',
                                'items'   => [
                                    ['icon' => '🖥️', 'name' => 'Additional Device Coverage',  'desc' => 'Extend managed coverage beyond your programme allocation — applicable to desktops, laptops, and network appliances.',             'price' => 'POA / device'],
                                    ['icon' => '📱', 'name' => 'Mobile Device Management',     'desc' => 'MDM enrolment, policy enforcement, and remote wipe capability for iOS and Android business devices.',                          'price' => 'POA / month'],
                                    ['icon' => '🔐', 'name' => 'Penetration Testing',          'desc' => 'Scheduled or on-demand vulnerability assessment with a formal report covering your network perimeter and endpoints.',           'price' => 'Quoted per scope'],
                                    ['icon' => '🌐', 'name' => 'After-Hours Support Cover',    'desc' => 'Extended helpdesk availability beyond standard business hours, covering P1 and P2 incidents.',                                 'price' => 'POA / month'],
                                    ['icon' => '☁️', 'name' => 'Cloud Migration',              'desc' => 'Formally scoped migration of on-premises infrastructure or data to Microsoft Azure, Microsoft 365, or AWS.',                   'price' => 'Quoted per project'],
                                    ['icon' => '🖨️', 'name' => 'Hardware Procurement',         'desc' => 'Specification, sourcing, and deployment of laptops, desktops, networking equipment, and peripherals — at supplier pricing.',   'price' => 'At cost + setup fee'],
                                    ['icon' => '🎓', 'name' => 'Cybersecurity Awareness',      'desc' => 'Staff training workshops addressing phishing, password discipline, and secure remote working — tailored to your environment.',  'price' => 'POA / session'],
                                    ['icon' => '📞', 'name' => 'VoIP & Telephony',             'desc' => 'Deployment, administration, and ongoing support of cloud-based telephony systems integrated with your Microsoft 365 tenant.',   'price' => 'POA / month'],
                                ],
                            ],
                        ],

                        // ── Web Design Plans ──────────────────────────────
                        [
                            'id'   => 'pricing-web-plans',
                            'type' => 'pricing_plans',
                            'data' => [
                                'eyebrow'     => 'Web Design & Development',
                                'heading'     => 'Digital Development Packages',
                                'priceUnit'   => 'once-off',
                                'pricePrefix' => 'Starting from',

                                'p1Tier'     => 'Starter',
                                'p1Name'     => 'Starter Site',
                                'p1Target'   => 'For businesses establishing a professional online presence',
                                'p1PriceNum' => '7,500',
                                'p1PriceVat' => 'R8,625',
                                'p1CtaLabel' => 'Request a Quote',
                                'p1CtaHref'  => '/contact',
                                'p1Featured' => false,
                                'p1Features' => "Up to 5 pages\nMobile-responsive design\nEnquiry and contact form\nFoundational on-page SEO configuration\nGoogle Maps integration\n30-day post-launch support",
                                'p1Limits'   => 'Up to 5 pages · ~2 week delivery',
                                'p1Tagline'  => '"A professional digital foundation, delivered on a defined timeline."',

                                'p2Tier'     => 'Business',
                                'p2Name'     => 'Business Site',
                                'p2Target'   => 'For established businesses requiring a complete, branded digital presence',
                                'p2PriceNum' => '16,500',
                                'p2PriceVat' => 'R18,975',
                                'p2CtaLabel' => 'Request a Quote',
                                'p2CtaHref'  => '/contact',
                                'p2Featured' => true,
                                'p2Features' => "Up to 12 pages\nBespoke design aligned to your brand identity\nBlog and news module\nAdvanced on-page SEO configuration\nGoogle Analytics and Search Console integration\nSocial media profile integration\n60-day post-launch support",
                                'p2Limits'   => 'Up to 12 pages · ~3–4 week delivery',
                                'p2Tagline'  => '"A comprehensive web presence — built to your brief, structured for growth."',

                                'p3Tier'     => 'E-Commerce',
                                'p3Name'     => 'Online Store',
                                'p3Target'   => 'For businesses with a defined e-commerce requirement',
                                'p3PriceNum' => '32,500',
                                'p3PriceVat' => 'R37,375',
                                'p3CtaLabel' => 'Request a Quote',
                                'p3CtaHref'  => '/contact',
                                'p3Featured' => false,
                                'p3Features' => "Unlimited product listings\nBespoke storefront design\nPayFast or Peach Payments integration\nOrder and inventory management\nCustomer accounts and wish lists\nAbandoned cart recovery\n90-day post-launch support",
                                'p3Limits'   => 'Unlimited products · ~5–6 week delivery',
                                'p3Tagline'  => '"A complete transactional platform, configured to sell from launch."',
                            ],
                        ],

                        // ── Web Plan Comparison ───────────────────────────
                        [
                            'id'   => 'pricing-web-compare',
                            'type' => 'comparison_table',
                            'data' => [
                                'heading' => 'Web Package Comparison',
                                'col1'    => 'Starter Site',
                                'col2'    => 'Business Site',
                                'col3'    => 'Online Store',
                                'rows'    => [
                                    ['feature' => 'Starting from (excl. VAT)',  'c1' => 'R7,500',       'c2' => 'R16,500',       'c3' => 'R32,500'],
                                    ['feature' => 'Number of pages',            'c1' => 'Up to 5',      'c2' => 'Up to 12',      'c3' => 'Unlimited'],
                                    ['feature' => 'Mobile-responsive design',   'c1' => '✔',            'c2' => '✔',             'c3' => '✔'],
                                    ['feature' => 'Custom brand design',        'c1' => '—',            'c2' => '✔',             'c3' => '✔'],
                                    ['feature' => 'Blog / news module',         'c1' => '—',            'c2' => '✔',             'c3' => '✔'],
                                    ['feature' => 'On-page SEO',                'c1' => 'Basic',        'c2' => 'Advanced',      'c3' => 'Advanced'],
                                    ['feature' => 'Google Analytics',           'c1' => '—',            'c2' => '✔',             'c3' => '✔'],
                                    ['feature' => 'Online store',               'c1' => '—',            'c2' => '—',             'c3' => '✔'],
                                    ['feature' => 'Payment gateway',            'c1' => '—',            'c2' => '—',             'c3' => 'PayFast / Peach'],
                                    ['feature' => 'Customer accounts',          'c1' => '—',            'c2' => '—',             'c3' => '✔'],
                                    ['feature' => 'Post-launch support',        'c1' => '30 days',      'c2' => '60 days',       'c3' => '90 days'],
                                    ['feature' => 'Estimated delivery',         'c1' => '~2 weeks',     'c2' => '~3–4 weeks',    'c3' => '~5–6 weeks'],
                                ],
                            ],
                        ],

                        // ── Web Add-Ons ───────────────────────────────────
                        [
                            'id'   => 'pricing-web-addons',
                            'type' => 'addons',
                            'data' => [
                                'eyebrow' => 'Supplementary Web Services',
                                'heading' => 'Web Enhancements & Retainers',
                                'items'   => [
                                    ['icon' => '🛡️', 'name' => 'Monthly Care Plan',        'desc' => 'Managed hosting, security patching, daily backups, and uptime monitoring — continuous protection for your digital asset.',          'price' => 'R450 / month'],
                                    ['icon' => '✏️', 'name' => 'Content Retainer',          'desc' => 'Up to 2 hours of managed content updates per month — copy changes, imagery, blog entries, and structured edits.',                  'price' => 'R950 / month'],
                                    ['icon' => '📈', 'name' => 'SEO Retainer',              'desc' => 'Keyword performance tracking, on-page optimisation, and a monthly summary report — a measured approach to organic visibility.',     'price' => 'R1,800 / month'],
                                    ['icon' => '🎨', 'name' => 'Brand Identity',            'desc' => 'Professional logo design accompanied by a colour system, typography selection, and a foundational brand guide for consistent use.', 'price' => 'R3,500 once-off'],
                                    ['icon' => '✍️', 'name' => 'Professional Copywriting',  'desc' => 'Web copy crafted for your intended audience — clear, brand-aligned, and structured for both readability and search performance.',   'price' => 'R600 / page'],
                                    ['icon' => '📣', 'name' => 'Social Media Setup',        'desc' => 'Profile creation and visual alignment across up to 3 platforms, with a structured content calendar and branded templates.',         'price' => 'R1,800 once-off'],
                                    ['icon' => '🌐', 'name' => 'Domain & Hosting',          'desc' => 'Domain registration and managed hosting configuration. First-year hosting included with Business and Online Store packages.',        'price' => 'R750 once-off'],
                                    ['icon' => '🔗', 'name' => 'Third-Party Integrations',  'desc' => 'Structured integration of your site with CRMs, booking systems, live chat platforms, or any API-based tool your business requires.', 'price' => 'Quoted per scope'],
                                ],
                            ],
                        ],

                        // ── Why Partner With Us ───────────────────────────
                        [
                            'id'   => 'pricing-why',
                            'type' => 'icon_cards',
                            'data' => [
                                'heading'    => 'The Case for Partnership',
                                'cols'       => '4',
                                'background' => 'dark',
                                'items'      => [
                                    ['title' => 'Defined Investment',           'body' => 'IT support programmes are flat-rate monthly. Web engagements are fixed-price. Every proposal is fully itemised — with no room for ambiguity.'],
                                    ['title' => 'Structured Governance',        'body' => 'Infrastructure is monitored, patched, and reviewed on a consistent schedule. Issues are identified and addressed before they affect your operations.'],
                                    ['title' => 'Unified Accountability',       'body' => 'Managed IT support and web development delivered by one team, under one agreement. A single point of accountability for your entire technology environment.'],
                                    ['title' => 'Local Expertise',              'body' => 'A team that understands the South African business environment — load shedding contingencies, local ISPs, and POPIA obligations — with enterprise-grade discipline applied throughout.'],
                                ],
                            ],
                        ],

                        // ── How We Get Started ────────────────────────────
                        [
                            'id'   => 'pricing-process',
                            'type' => 'timeline',
                            'data' => [
                                'eyebrow' => 'Engagement Process',
                                'heading' => 'How an Engagement Begins',
                                'layout'  => 'steps',
                                'items'   => [
                                    ['title' => 'Initial Consultation',   'desc' => 'A focused conversation to understand your business requirements — whether that is IT support, a web development engagement, or a combination of both.'],
                                    ['title' => 'Proposal & Scoping',     'desc' => 'We document the full scope of work and present a clear, itemised proposal. Every line is accounted for before a commitment is made.'],
                                    ['title' => 'Engagement Agreement',   'desc' => 'Your IT Service Level Agreement or web project brief is signed and filed. Scope, timeline, deliverables, and investment are formally confirmed.'],
                                    ['title' => 'Delivery Commences',     'desc' => 'IT environments are brought under managed monitoring from day one. Web development engagements begin immediately following agreement sign-off.'],
                                ],
                            ],
                        ],

                        // ── CTA ───────────────────────────────────────────
                        [
                            'id'   => 'pricing-cta',
                            'type' => 'cta',
                            'data' => [
                                'eyebrow'  => 'Begin the Conversation',
                                'heading'  => 'The right technology partnership starts here.',
                                'body'     => 'All pricing excludes VAT (currently 15%). IT support programmes are governed by a signed Service Level Agreement. Web development engagements are subject to a formal scoping document. Standard terms apply.',
                                'ctaLabel' => 'Enquire Now',
                                'ctaHref'  => '/contact',
                            ],
                        ],
                    ],
                ],
            ],

            // ── Contact ──────────────────────────────────────────────────
            'contact' => [
                'seoTitle'       => 'Contact Us — Odo Group',
                'seoDescription' => "Get in touch with Odo Group. We're based in Secunda, Mpumalanga. Reach out for IT support, consultations, and managed services.",
                'eyebrow'        => 'Reach Out',
                'title'          => 'Get In Touch',
                'body'           => "We're here to help. Send us a message and we'll get back to you as soon as possible.",
                'image'          => '',
                'content' => [
                    'blocks' => [
                        [
                            'id'   => 'contact-form',
                            'type' => 'contact',
                            'data' => [
                                'eyebrow' => '',
                                'heading' => '',
                                'intro'   => "We're a friendly bunch..",
                                'blurb'   => 'We create solutions for companies and startups with a passion for quality',
                                'address' => '35 Tsitsikame Street, Secunda, MP 2302',
                                'email'   => 'consultation@odocorp.co.za',
                                'phone'   => '+27 82 870 7275',
                                'hours'   => "Monday – Friday: 08:00 – 17:00\nAfter Hours: Emergency support available",
                            ],
                        ],
                    ],
                ],
            ],

        ];
    }
}
