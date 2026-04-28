<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * MainSeeder
 *
 * Seeds minimal required data for the application to function.
 * Replace the placeholder settings and pages with client-specific content.
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
        echo "  Next step: update admin_password_hash via the admin panel\n";
        echo "  or run: php spark db:seed AdminPasswordSeeder\n";
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
                'seoDescription' => 'Empowering businesses with reliable IT solutions. Managed services, cybersecurity, network design and more.',
                'content'        => (object) [],
            ],

            'about' => [
                'seoTitle'       => 'About — Odo Group',
                'seoDescription' => 'Learn about Odo Group — our vision, mission and core values as a trusted IT partner.',
                'content'        => (object) [],
            ],

            'services' => [
                'seoTitle'       => 'Services — Odo Group',
                'seoDescription' => 'Comprehensive managed IT services including 24/7 support, cybersecurity, network management and more.',
                'content'        => (object) [],
            ],

            'contact' => [
                'seoTitle'       => 'Contact — Odo Group',
                'seoDescription' => 'Get in touch with Odo Group. We\'re based in Secunda, MP.',
                'content'        => (object) [],
            ],

        ];
    }
}
