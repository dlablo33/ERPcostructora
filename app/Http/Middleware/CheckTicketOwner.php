<?php

namespace App\Http\Middleware;

use App\Models\ClientTicket;
use Closure;
use Illuminate\Http\Request;

class CheckTicketOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $ticketId = $request->route('id');
        $devId = session('dev_user_id');

        if (!$ticketId || !$devId) {
            abort(404);
        }

        $ticket = ClientTicket::where('id', $ticketId)
            ->where('desarrollador_id', $devId)
            ->first();

        if (!$ticket) {
            abort(403, 'No tienes permiso para ver este ticket');
        }

        return $next($request);
    }
}