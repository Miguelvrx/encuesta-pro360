<?php

namespace App\Mail;

use App\Models\Evaluacion;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EvaluacionAsignada extends Mailable
{
    use Queueable, SerializesModels;

    public $evaluacion;
    public $evaluador;
    public $evaluado;
    public $tipoRol;

    /**
     * Create a new message instance.
     */
    public function __construct(Evaluacion $evaluacion, User $evaluador, User $evaluado, $tipoRol)
    {
        $this->evaluacion = $evaluacion;
        $this->evaluador = $evaluador;
        $this->evaluado = $evaluado;
        $this->tipoRol = $tipoRol;
    }

     public function build()
    {
        return $this->subject('Invitación - Evaluación 360° ' . $this->evaluacion->tipo_evaluacion)
                    ->markdown('emails.evaluacion-asignada')
                    ->with([
                        'evaluacion' => $this->evaluacion,
                        'evaluador' => $this->evaluador,
                        'evaluado' => $this->evaluado,
                        'tipoRol' => $this->tipoRol,
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Evaluacion Asignada',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
