<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPaiementNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $paiement;
    public function __construct($paiement){ $this->paiement = $paiement; }
    public function build()
    {
        return $this->subject('Nouveau paiement en attente')
                    ->markdown('emails.paiement.new')
                    ->with(['paiement'=>$this->paiement]);
    }
}
