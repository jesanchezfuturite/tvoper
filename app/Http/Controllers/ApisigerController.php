<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use Illuminate\Routing\UrlGenerator;

use SimpleXMLElement;

class ApisigerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $url = "http://10.153.144.39:8080/WSSoapIRC/NewWebService";

    protected $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );

    public function __construct(	
    )
    {

      
    }

    /**
     * datefix 
     *
     * @param fecha en formato YYYY-MM-DD
     *
     * @return  fecha en formato 08-JUN-21
     */

    public function datefix(Request $req)
    {
    	try
		  {

			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
					<soapenv:Header/>
						<soapenv:Body>
							<wser:dateFix>
							<!--Optional:-->
							<date>'.$req->date.'</date>
							</wser:dateFix>
						</soapenv:Body>
					</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
	
			$array = json_decode(json_encode((array)$body), TRUE);

			return response()->json($array["ns2dateFixResponse"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }

    /**
     * FinalizarTicket 
     *
     * @param numero de la boleta para finalizar ticket
     *
     * @return  mensaje del api
     */

    public function FinalizarTicket(Request $req)
    {
    	try
		  {
			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
				<soapenv:Header/>
					<soapenv:Body>
						<wser:FinalizarTicket>
							<boleta>'.$req->boleta.'</boleta>
						</wser:FinalizarTicket>
					</soapenv:Body>
				</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
	
			$array = json_decode(json_encode((array)$body), TRUE);
			
			return response()->json($array["ns2FinalizarTicketResponse"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }

    /**
     * GetAllMunicipios 
     *
     * @param ninguno
     *
     * @return  mensaje del api
     */

    public function GetAllMunicipios()
    {
    	try
		  {
			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
					<soapenv:Header/>
					<soapenv:Body>
						<wser:GetAllMunicipios/>
					</soapenv:Body>
				</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
			
			$array = json_decode(json_encode((array)$body), TRUE);
			
			return response()->json($array["ns2GetAllMunicipiosResponse"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }

    /**
     * GetEstados 
     *
     * @param ninguno
     *
     * @return  mensaje del api
     */

    public function GetEstados()
    {
    	try
		  {
			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
				<soapenv:Header/>
				<soapenv:Body>
					<wser:GetEstados/>
				</soapenv:Body>
				</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
			
			$array = json_decode(json_encode((array)$body), TRUE);
			dd($array);
			return response()->json($array["ns2GetEstadosResponse"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }

    /**
     * GetEstado
     *
     * @param id del estado
     *
     * @return  mensaje del api
     */

    public function GetEstado(Request $req)
    {
    	//$estado = 19;
    	try
		  {
			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
					<soapenv:Header/>
					<soapenv:Body>
						<wser:GetEstado>
							<nuEstado>'.$req->estado.'</nuEstado>
						</wser:GetEstado>
					</soapenv:Body>
				</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
			
			$array = json_decode(json_encode((array)$body), TRUE);
			
			return response()->json($array["ns2GetEstadoResponse"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }

    /**
     * GetFedatarios1
     *
     * @param ninguno
     *
     * @return  mensaje del api
     */

    public function GetFedatarios1()
    {
    	
    	try
		  {
			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
				<soapenv:Header/>
				<soapenv:Body>
					<wser:GetFedatarios1/>
				</soapenv:Body>
				</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
			
			$array = json_decode(json_encode((array)$body), TRUE);
			
			return response()->json($array["ns2GetFedatarios1Response"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }

    /**
     * GetMunicipios
     *
     * @param id_estado
     *
     * @return  mensaje del api
     */

    public function GetMunicipios(Request $req)
    {
    	try
		  {
			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
					<soapenv:Header/>
					<soapenv:Body>
						<wser:GetMunicipios>
							<nuEstado>'.$req->estado.'</nuEstado>
						</wser:GetMunicipios>
					</soapenv:Body>
				</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
			
			$array = json_decode(json_encode((array)$body), TRUE);
			
			return response()->json($array["ns2GetMunicipiosResponse"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }
    /**
     * GetFedatario
     *
     * @param numero fedatario,id_municipio,id_estado
     *
     * @return  mensaje del api
     */

    public function GetFedatario(Request $req)
    {
    	/*
		"NOMFED":"LIC. GUILLERMO OSCAR RODRIGUEZ HIBLER",
		"CONSED":"NOTARIA PUBLICA NO. 107",
		"NU_FEDATA":119040107,
		"NU_MUNICI":40,
		"NU_ESTADO":19			
    	*/
    	try
		  {
			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
					<soapenv:Header/>
					<soapenv:Body>
						<wser:GetFedatario>
							<!--Optional:-->
							<nuFed>'.$req->fedatario.'</nuFed>
							<estado>'.$req->estado.'</estado>
							<municipio>'.$req->municipio.'</municipio>
						</wser:GetFedatario>
					</soapenv:Body>
				</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
			
			$array = json_decode(json_encode((array)$body), TRUE);
			
			return response()->json($array["ns2GetFedatarioResponse"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }
    /**
     * GetServicios
     *
     * @param ninguno
     *
     * @return  mensaje del api
     */

    public function GetServicios()
    {
    	try
		  {
			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
					<soapenv:Header/>
					<soapenv:Body>
						<wser:GetServicios/>
					</soapenv:Body>
				</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
			
			$array = json_decode(json_encode((array)$body), TRUE);
			
			return response()->json($array["ns2GetServiciosResponse"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }

    /**
     * GetTicketStatus
     *
     * @param ticket id
     *
     * @return  mensaje del api
     */

    public function GetTicketStatus(Request $req)
    {
    	try
		  {
			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
				<soapenv:Header/>
				<soapenv:Body>
					<wser:GetTicketStatus>
						<ticketNumber>'.$req->boleta.'</ticketNumber>
					</wser:GetTicketStatus>
				</soapenv:Body>
				</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
			
			$array = json_decode(json_encode((array)$body), TRUE);
			
			return response()->json($array["ns2GetTicketStatusResponse"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }

    /**
     * InsertaConceptos
     *
     * @param ticket id
     *
     * @return  mensaje del api
     */

    public function InsertaConceptos(Request $req)
    {	
    	/* PARAMETROS DE PRUEBA QUE FUNCIONAN
		$arefol = "I";
		$RFCExp = "SAVE821214BW5";
		$nuNotari = "119040107";
		$solici =	"JOSE ENRIQUE SANCHEZ VILLANUEVA";
		$otorga = "RAZON SOCIAL";
		$nuMonder = "100000";
		$nuEmplea = "100";
		$modtra = "RE";
		$estpag = "1";
		$nuMonOpe = "100000";
		$nuFolIng = "98030967";
		$fePago = "05-JUN-21";
		$nuRegion = "1";
		$nuMonSub = "0";
		$nuFolSub = "0";
		$nuEstRep = "0";
		$inMulFol = "0";
		$isai = "0";
		$numBoleta = "98989";
		$nuIsai = "0";
		$nuMunici = "0";
		$tipoMov = "0";
		$nomFed = "CHESPIRITO";
		$tipoIngreso = "0";
		$nuEscritura = "0";
		$estEsc = "0";
		$trans = "[{\"acto\":\"M99\", \"vBase\": \"9000\", \"ingresos\":\"000\"}]";

		regresa esta respuesta "return" => "{"NUCONPRE":"4102"}"
		*/

		$arefol = $req->arefol;
		$RFCExp = $req->RFCExp;
		$nuNotari= $req->nuNotari;
		$solici = $req->solici;
		$otorga = $req->otorga;
		$nuMonder = $req->nuMonder;
		$nuEmplea = $req->nuEmplea;
		$modtra = $req->modtra;
		$estpag = $req->estpag;
		$nuMonOpe = $req->nuMonOpe;
		$nuFolIng = $req->nuFolIng;
		$fePago = $req->fePago;
		$nuRegion = $req->nuRegion;
		$nuMonSub = $req->nuMonSub;
		$nuFolSub = $req->nuFolSub;
		$nuEstRep = $req->nuEstRep;
		$inMulFol = $req->inMulFol;
		$isai = $req->isai;
		$numBoleta = $req->numBoleta;
		$nuIsai = $req->nuIsai;
		$nuMunici = $req->nuMunici;
		$tipoMov = $req->tipoMov;
		$nomFed = $req->nomFed;
		$tipoIngreso = $req->tipoIngreso;
		$nuEscritura = $req->nuEscritura;
		$estEsc = $req->estEsc;
		$trans = $req->trans;
    	try
		  {
			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
					<soapenv:Header/>
					<soapenv:Body>
						<wser:InsertaConceptos>
						<!--Optional:-->
						<arefol>'.$arefol.'</arefol>
						<!--Optional:-->
						<RFCExp>'.$RFCExp.'</RFCExp>
						<!--Optional:-->
						<nuNotari>'.$nuNotari.'</nuNotari>
						<!--Optional:-->
						<solici>'.$solici.'</solici>
						<!--Optional:-->
						<otorga>'.$otorga.'</otorga>
						<!--Optional:-->
						<nuMonder>'.$nuMonder.'</nuMonder>
						<!--Optional:-->
						<nuEmplea>'.$nuEmplea.'</nuEmplea>
						<!--Optional:-->
						<modtra>'.$modtra.'</modtra>
						<!--Optional:-->
						<estpag>'.$estpag.'</estpag>
						<!--Optional:-->
						<nuMonOpe>'.$nuMonOpe.'</nuMonOpe>
						<!--Optional:-->
						<nuFolIng>'.$nuFolIng.'</nuFolIng>
						<!--Optional:-->
						<fePago>'.$fePago.'</fePago>
						<!--Optional:-->
						<nuRegion>'.$nuRegion.'</nuRegion>
						<!--Optional:-->
						<nuMonSub>'.$nuMonSub.'</nuMonSub>
						<!--Optional:-->
						<nuFolSub>'.$nuFolSub.'</nuFolSub>
						<!--Optional:-->
						<nuEstRep>'.$nuEstRep.'</nuEstRep>
						<!--Optional:-->
						<inMulFol>'.$inMulFol.'</inMulFol>
						<!--Optional:-->
						<isai>'.$isai.'</isai>
						<!--Optional:-->
						<numBoleta>'.$numBoleta.'</numBoleta>
						<!--Optional:-->
						<nuIsai>'.$nuIsai.'</nuIsai>
						<!--Optional:-->
						<nuMunici>'.$nuMunici.'</nuMunici>
						<!--Optional:-->
						<tipoMov>'.$tipoMov.'</tipoMov>
						<!--Optional:-->
						<nomFed>'.$nomFed.'</nomFed>
						<!--Optional:-->
						<tipoIngreso>'.$tipoIngreso.'</tipoIngreso>
						<!--Optional:-->
						<nuEscritura>'.$nuEscritura.'</nuEscritura>
						<!--Optional:-->
						<estEsc>'.$estEsc.'</estEsc>
						<!--Optional:-->
						<trans>'.$trans.'</trans>
						</wser:InsertaConceptos>
					</soapenv:Body>
				</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
			
			$array = json_decode(json_encode((array)$body), TRUE);
			
			return response()->json($array["ns2InsertaConceptosResponse"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }

    /**
     * RejectTicket
     *
     * @param boleta, comment, rejectType
     *
     * @return  mensaje del api
     */

    public function RejectTicket(Request $req)
    {

    	try
		  {
			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
				<soapenv:Header/>
				<soapenv:Body>
					<wser:RejectTicket>
						<boleta>'.$req->boleta.'</boleta>
						<!--Optional:-->
						<comment>'.$req->comment.'</comment>
						<rejectType>'.$req->type.'</rejectType>
					</wser:RejectTicket>
				</soapenv:Body>
				</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
			
			$array = json_decode(json_encode((array)$body), TRUE);
			
			return response()->json($array["ns2RejectTicketResponse"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }

    /**
     * updateMunicipio
     *
     * @param boleta, municipio, region
     *
     * @return  mensaje del api
     */

    public function updateMunicipio(Request $req)
    {
    	try
		  {
			$request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wser="http://wservices/">
				<soapenv:Header/>
				<soapenv:Body>
					<wser:updateMunicipio>
					<boleta>'.$req->boleta.'</boleta>
					<!--Optional:-->
					<nu_munici>'.$req->municipio.'</nu_munici>
					<!--Optional:-->
					<nu_region>'.$req->region.'</nu_region>
					</wser:updateMunicipio>
				</soapenv:Body>
				</soapenv:Envelope>';

			$header = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache"
			);

			$soap_do = curl_init();

			curl_setopt($soap_do, CURLOPT_URL, $this->url);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($soap_do, CURLOPT_POST,           true );
			curl_setopt($soap_do, CURLOPT_POSTFIELDS,     $request);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER,     $header);

			$result = curl_exec($soap_do);
			curl_close($soap_do);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $result);
	
			$xml = new SimpleXMLElement($response);
			
			$body = $xml->xpath('//SBody')[0];
			
			$array = json_decode(json_encode((array)$body), TRUE);
			
			return response()->json($array["ns2updateMunicipioResponse"],200,$this->header,JSON_UNESCAPED_UNICODE);

       }catch (\Exception $e){
                dd($e->getMessage());

       }
    }
}
