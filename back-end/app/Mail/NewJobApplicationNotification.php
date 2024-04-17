<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewJobApplicationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $jobOffer;
    public $profile;

    public function __construct($user, $jobOffer, $profile)
    {
        $this->user = $user;
        $this->jobOffer = $jobOffer;
        $this->profile = $profile;
    }

    public function build()
    {
        $cvPdfPath = storage_path('app/' . $this->profile->cvPdf);
        
        return $this->view('emails.new_job_application')
                    ->subject('Nouvelle candidature')
                    ->attach($cvPdfPath, [
                        'as' => 'cv.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
