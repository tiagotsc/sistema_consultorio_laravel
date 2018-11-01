<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Agenda;
use Carbon\Carbon;

class AgendaStatusEvento implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $agenda;
    public $medicoId;
    public $tipoUsuario;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Agenda $agenda, $tipoUsuario)
    {
        $this->agenda = [
            'id' => $agenda->id,
            'status_id' => $agenda->agenda_status_id,
            'status_nome' => $agenda->status->nome,
            'data' => Carbon::parse($agenda->data)->format('d/m/Y'),
            'horario' => $agenda->horario,
            'medico_id' => $agenda->medico_id,
            'medico_nome' => $agenda->medico->name
        ];
        $this->medicoId = $agenda->medico_id;
        $this->tipoUsuario = $tipoUsuario;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if($this->tipoUsuario == 'medico'){
            $canal = 'agendaStatus';
        }else{
            $canal = 'agendaStatusMedico.'.$this->medicoId;
        }
        return new Channel($canal);
    }
}
