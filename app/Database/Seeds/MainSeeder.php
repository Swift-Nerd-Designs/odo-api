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
            'address'    => '35 Tsitsikame Street, Secunda, MP 2302',
            'facebook'   => '#',
            'twitter'    => '#',
            'instagram'  => '#',
            'linkedin'   => '#',
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
