<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notificacion extends Mailable
{
    use Queueable, SerializesModels;
    protected $datos;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($arraydatos)
    {

        $this->datos=$arraydatos;

    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.notificatarea') ->subject("Asignación de Tarea")
        ->with([
            "titulo" => $this->datos['titulo'],
            "proynombre" => $this->datos['proynombre']
        ]);
    }
}
