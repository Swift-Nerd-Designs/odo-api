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

            // Replace these with client-specific values
            'site_name'  => 'Client Site',
            'email'      => 'hello@clientdomain.com',
            'phone'      => '',
            'address'    => '',
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
                'seoTitle'       => 'Home — Client Site',
                'seoDescription' => 'Welcome to our website.',
                'content'        => (object) [],
            ],

            // ── About ─────────────────────────────────────────────────────
            'about' => [
                'seoTitle'       => 'About — Client Site',
                'seoDescription' => 'Learn more about us.',
                'content'        => (object) [],
            ],

            // ── Contact ───────────────────────────────────────────────────
            'contact' => [
                'seoTitle'       => 'Contact — Client Site',
                'seoDescription' => 'Get in touch with us.',
                'content'        => (object) [],
            ],

        ];
    }
}
