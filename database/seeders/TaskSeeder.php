<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'user@example.com')->first();

        if (!$user) {
            return;
        }

        $sampleTasks = [
            [
                'title' => 'Configure Nginx reverse proxy with SSL',
                'description' => 'Install certbot and configure Nginx virtual host for native Ubuntu deployment.',
                'priority' => 'high',
                'status' => 'pending',
                'due_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
            ],
            [
                'title' => 'Complete quarterly application security review',
                'description' => 'Verify CSRF tokens, SQL injection prevention, and authorization checks on all routes.',
                'priority' => 'high',
                'status' => 'in_progress',
                'due_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
            ],
            [
                'title' => 'Fix overdue database backup verification',
                'description' => 'Ensure automated cron job creates daily mysqldump backups and tests restoration.',
                'priority' => 'high',
                'status' => 'pending',
                'due_date' => Carbon::now()->subDays(3)->format('Y-m-d'), // Overdue!
            ],
            [
                'title' => 'Implement dark mode theme toggle',
                'description' => 'Use Bootstrap 5.3 data-bs-theme and localStorage to preserve user preference across sessions.',
                'priority' => 'medium',
                'status' => 'completed',
                'due_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
            ],
            [
                'title' => 'Design responsive sidebar navigation',
                'description' => 'Build a collapsible mobile-friendly sidebar with active route highlights and icons.',
                'priority' => 'medium',
                'status' => 'completed',
                'due_date' => Carbon::now()->subDays(4)->format('Y-m-d'),
            ],
            [
                'title' => 'Write Ubuntu native deployment instructions',
                'description' => 'Document PHP 8.3 installation, MySQL setup, and Apache/Nginx configuration steps.',
                'priority' => 'medium',
                'status' => 'in_progress',
                'due_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
            ],
            [
                'title' => 'Audit overdue software license renewals',
                'description' => 'Review all third-party subscription statuses and submit procurement tickets.',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => Carbon::now()->subDays(7)->format('Y-m-d'), // Overdue!
            ],
            [
                'title' => 'Clean up storage logs and cache files',
                'description' => 'Execute php artisan view:clear, cache:clear, and rotate large log files in storage/logs.',
                'priority' => 'low',
                'status' => 'pending',
                'due_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
            ],
            [
                'title' => 'Refactor CSS helper styles',
                'description' => 'Remove redundant styling and optimize flat UI color variables.',
                'priority' => 'low',
                'status' => 'in_progress',
                'due_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
            ],
            [
                'title' => 'Initial project kickoff and setup',
                'description' => 'Setup git repository, environment configurations, and initial migrations.',
                'priority' => 'low',
                'status' => 'completed',
                'due_date' => Carbon::now()->subDays(10)->format('Y-m-d'),
            ],
        ];

        foreach ($sampleTasks as $taskData) {
            Task::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $taskData['title'],
                ],
                $taskData
            );
        }

        // Add a task for admin user as well to verify tenant/user isolation
        $admin = User::where('email', 'admin@example.com')->first();
        if ($admin) {
            Task::firstOrCreate(
                [
                    'user_id' => $admin->id,
                    'title' => 'Admin system maintenance and audit',
                ],
                [
                    'description' => 'Check server uptime, database query performance, and disk usage.',
                    'priority' => 'high',
                    'status' => 'in_progress',
                    'due_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                ]
            );
        }
    }
}

