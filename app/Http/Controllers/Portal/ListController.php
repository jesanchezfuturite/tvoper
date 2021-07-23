<?php
namespace App\Http\Controllers\Portal;
use App\Http\Controllers\Controller;
use App\Models\Transaccion;
use App\Models\Tickets;
use App\Models\User;
use App\Models\UsersNotaryOffices;
use DB;
use Illuminate\Http\Request;

class ListController extends Controller {
	public function getTramites (Request $request) {
		$maxLimit = 500;
		$status = $request->status ?? null;
		$searchBy = $request->search_by ?? 'servicio.Tipo_Descripcion';
		switch($searchBy){
			case 'enajenante':
				$searchBy = DB::raw('JSON_EXTRACT(ticket.info, "$.enajenante")');
			break;
			case 'escritura':
				$searchBy = DB::raw('JSON_EXTRACT(ticket.info, "$.campos.'.getenv('CAMPO_ESCRITURA').'")');
			break;
			case 'expediente':
				$searchBy = DB::raw('JSON_EXTRACT(ticket.info, "$.campos.'.getenv('CAMPO_EXPEDIENTE').'")');
			break;
			case 'folio_pago':
				$searchBy = DB::raw('tramite.id_transaccion_motor');
			break;
			case 'fse':
				$searchBy = DB::raw('ticket.id_transaccion');
			break;
			default:
				$searchBy = DB::raw('servicio.Tipo_Descripcion');
			break;
		}
		$search = $request->search ?? null;
		if(gettype($status) != 'array') $status = [(int)$status];
		if(array_search(3, $status) !== false) array_push($status, 7, 8);
		if(array_search(98, $status) !== false) array_push($status, 2);

		$groupBy = $request->group_by ?? 'clave';
		if($groupBy && strpos($groupBy, '.') === false) $groupBy = 'ticket.'.$groupBy;
		$limit = $request->limit ? (int)$request->limit : 30;
		if($limit >= $maxLimit) $limit = $maxLimit;
		$currentPage = $request->page ? (int)$request->page : 1;
		$skip = $currentPage == 1 ? 0 : $limit*($currentPage-1);

		$currentDate = date('Y-m-d');
		$startDate = $request->start_date ? date('Y-m-d H:i:s', strtotime($request->start_date.' 00:00:00')) : date('Y-m-d H:i:s', strtotime('-30 days '.$currentDate." 00:00:00"));
		$endDate = $request->end_date ? date('Y-m-d H:i:s', strtotime($request->end_date.' 23:59:59')) : date('Y-m-d H:i:s', strtotime($currentDate." 23:59:59"));
		if($startDate > $endDate) return response()->json(["code" => 409, "message" => "conflict", "description" => "La fecha de inicio (start_date) no debe ser mayor a la fecha final (end_date)"], 404);;

		$user = User::with('notary')->orWhere('users.id', (int)$request->user)->first();
		$user->notary->users = UsersNotaryOffices::with('users')->where('notary_office_id', $user->notary->id)->get();
		$tickets = Tickets::whereIn('user_id', $this->array_value_recursive('id', $user->notary->users->toArray()))
			->with('files')
			->select(
				DB::raw('if(count(*) != 1, 1, 0) as is_group'),
				'ticket.id as tramite_id',
				'ticket.clave',
				'ticket.grupo_clave',
				'ticket.created_at',
				'ticket.status',
				'ticket.id_transaccion as fse',
				'tramite.id_transaccion_motor as folio_pago',
				'ticket.user_id',
				'ticket.required_docs',
				'status.descripcion as status_descripcion',
				'ticket.recibo_referencia',
				'tramite.url_recibo',
				DB::raw('
					IF(
						JSON_EXTRACT(ticket.info,"$.tipoTramite") IS NOT NULL && catalogo.tramite_id = "'.getenv('TRAMITE_5_ISR').'",
						REPLACE(JSON_EXTRACT(ticket.info,"$.tipoTramite"), "\"", ""),
						null
					) AS tipo_tramite
				'),
				DB::raw('IF(ticket.en_carrito = 1, 1, 0) as en_carrito'),
				DB::raw('IF(ticket.por_firmar = 1, 1, 0) as por_firmar'),
				DB::raw('IF(ticket.firmado = 1, 1, 0) as firmado'),
				'servicio.Tipo_Descripcion as servicio',
				'servicio.Tipo_Code as servicio_id',
				'catalogo.titulo as catalogo_titulo',
				DB::raw('
					CONCAT(
						"[",
						GROUP_CONCAT(
							CONCAT(
								"{",
								"\"ticket_id\":",
								ticket.id,
								",",
								"\"status\":",
								ticket.status,
								",",
								"\"status_descripcion\":",
								"\"",
								(
									IF(
										status.descripcion IS NOT NULL,
										status.descripcion,
										"Pendiente de Pago"
									)
								),
								"\"",
								(
									IF(
										JSON_EXTRACT(ticket.info,"$.enajenante") IS NOT NULL,
										CONCAT(
											",",
											"\"enajenante\":",
											JSON_EXTRACT(ticket.info,"$.enajenante")
										),
										""
									)
								),
								(
									IF(
										JSON_EXTRACT(ticket.info,"$.solicitantes") IS NOT NULL,
										CONCAT(
											",",
											"\"solicitantes\":",
											JSON_EXTRACT(ticket.info,"$.solicitantes")
										),
										""
									)
								),
								(
									IF(
										JSON_EXTRACT(ticket.info,"$.campos.'.getenv('CAMPO_ESCRITURA').'") IS NOT NULL,
										CONCAT(
											",",
											"\"escritura\":",
											JSON_EXTRACT(ticket.info,"$.campos.'.getenv('CAMPO_ESCRITURA').'")
										),
										""
									)
								),
								(
									IF(
										JSON_EXTRACT(ticket.info,"$.campos.'.getenv('CAMPO_EXPEDIENTE').'.expedientes") IS NOT NULL,
										CONCAT(
											",",
											"\"expediente\":",
											JSON_EXTRACT(ticket.info,"$.campos.'.getenv('CAMPO_EXPEDIENTE').'.expedientes")
										),
										""
									)
								),
								(
									IF(
										JSON_EXTRACT(ticket.info,"$.detalle") IS NOT NULL,
										CONCAT(
											",",
											"\"detalle\":",
											JSON_EXTRACT(ticket.info,"$.detalle")
										),
										""
									)
								),
								(
									IF(
										JSON_EXTRACT(ticket.info,"$.detalleAnterior") IS NOT NULL,
										CONCAT(
											",",
											"\"detalleAnterior\":",
											JSON_EXTRACT(ticket.info,"$.detalleAnterior")
										),
										""
									)
								),
								",\"doc_firmado\":",
								(
									IF(
										doc_firmado IS NOT NULL,
										CONCAT(
											"[\"",
											REPLACE(
												ticket.doc_firmado,
												",",
												"\",\""
											),
											"\"]"
										),
										"null"
									)
								),
								"}"
							) 
							SEPARATOR ","
						),
						"]"
					) AS tickets
				')
			)
			->whereBetween('ticket.created_at', [$startDate, $endDate])
			->orderByDesc('ticket.id')
			->leftjoin('solicitudes_catalogo as catalogo', 'ticket.catalogo_id', 'catalogo.id')
			->leftjoin('egobierno.tipo_servicios as servicio', 'catalogo.tramite_id', 'servicio.Tipo_Code')
			->leftjoin('solicitudes_status as status', 'status.id', 'ticket.status')
			->leftjoin('solicitudes_tramite as tramite', 'tramite.id', 'ticket.id_transaccion');
		if($search) $tickets = $tickets->where($searchBy, "like", "%{$search}%");
		if($status) $tickets = $tickets->whereIn('ticket.status', $status);
		if(array_search(98, $status) !== false) $tickets = $tickets->whereRaw('(catalogo.firma = 1 AND ticket.firmado IS NULL)');
		if(array_search(98, $status) === false && array_search(2, $status) !== false) $tickets->whereRaw('((catalogo.firma = 1 AND ticket.firmado IS NOT NULL) OR catalogo.firma = 0)');
		if($groupBy) $tickets = $tickets->groupBy($groupBy);
		$tickets = $tickets->skip($skip)->take($limit);
		$tickets = $tickets->get();
		
		$ticketsTotal = Tickets::whereIn('user_id', $this->array_value_recursive('id', $user->notary->users->toArray()))
			->whereIn('ticket.status', $status)
			->leftjoin('solicitudes_catalogo as catalogo', 'ticket.catalogo_id', 'catalogo.id');
		if(array_search(98, $status) !== false) $ticketsTotal = $ticketsTotal->whereRaw('(catalogo.firma = 1 AND ticket.firmado IS NULL)');
		if(array_search(98, $status) === false && array_search(2, $status) !== false) $ticketsTotal->whereRaw('((catalogo.firma = 1 AND ticket.firmado IS NOT NULL) OR catalogo.firma = 0)');
		$ticketsTotal = $ticketsTotal->count();

		$ticketsFiltered = Tickets::whereIn('user_id', $this->array_value_recursive('id', $user->notary->users->toArray()))
			->whereBetween('ticket.created_at', [$startDate, $endDate])
			->whereIn('ticket.status', $status)
			->leftjoin('solicitudes_catalogo as catalogo', 'ticket.catalogo_id', 'catalogo.id');
		if(array_search(98, $status) !== false) $ticketsFiltered = $ticketsFiltered->whereRaw('(catalogo.firma = 1 AND ticket.firmado IS NULL)');
		if(array_search(98, $status) === false && array_search(2, $status) !== false) $ticketsFiltered->whereRaw('((catalogo.firma = 1 AND ticket.firmado IS NOT NULL) OR catalogo.firma = 0)');
		$ticketsFiltered = $ticketsFiltered->count();

		$ticketsTotalGroupBy = Tickets::whereIn('user_id', $this->array_value_recursive('id', $user->notary->users->toArray()))
			->whereBetween('ticket.created_at', [$startDate, $endDate])
			->whereIn('ticket.status', $status)
			->leftjoin('solicitudes_catalogo as catalogo', 'ticket.catalogo_id', 'catalogo.id')
			->select(DB::raw('COUNT(DISTINCT '.$groupBy.') AS count'));
		if(array_search(98, $status) !== false) $ticketsTotalGroupBy = $ticketsTotalGroupBy->whereRaw('(catalogo.firma = 1 AND ticket.firmado IS NULL)');
		if(array_search(98, $status) === false && array_search(2, $status) !== false) $ticketsTotalGroupBy->whereRaw('((catalogo.firma = 1 AND ticket.firmado IS NOT NULL) OR catalogo.firma = 0)');
		$ticketsTotalGroupBy = $ticketsTotalGroupBy->first()->count;


		$pages = $ticketsTotalGroupBy / $limit;

		// if(ceil($pages) < $currentPage) return response()->json(["code" => 404, "message" => "error", "description" => "No tenemos resultados para esta página"], 404);

		return [
			"totals" => [
				"global" => $ticketsTotal,
				"filtered" => $ticketsFiltered
			],
			"pages" =>  [
				"current" => $currentPage,
				"total" => ceil($pages)
			],
			"tickets" => $tickets
		];
	}

	protected function array_value_recursive($key, array $arr){
	    $val = array();
	    array_walk_recursive($arr, function($v, $k) use($key, &$val){
	        if($k == $key) array_push($val, $v);
	    });
	    return count($val) > 1 ? $val : array_pop($val);
	}
}