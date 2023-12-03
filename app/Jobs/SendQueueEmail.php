<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $news;
    protected $emails;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($news, $emails)
    {
        $this->news = $news;
        $this->emails = $emails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->emails as $value) {
            $data['subject'] = "Newsletter from ". (config('app.name') ?? "Alumni");
            $data['email'] = $value['email'];
            $data['news'] = $this->news;
            $data['name'] = $value['name'];
            sendMailWithTemplate($data, 'admin.template.mail.newsletter', $value['email']);
        }
    }
}
