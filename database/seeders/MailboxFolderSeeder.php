<?php

namespace Database\Seeders;

use App\Models\Core\MailboxFolder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MailboxFolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailboxFolder::create([
            'title' => 'Inbox',
            'icon' => 'inbox'
        ])->create([
            'title' => "Sent",
            'icon' => 'envelope-o'
        ])->create([
            'title' => "Drafts",
            'icon' => 'file-text-o'
        ])->create([
            'title' => "Trash",
            'icon' => 'trash-o'
        ]);
    }
}
