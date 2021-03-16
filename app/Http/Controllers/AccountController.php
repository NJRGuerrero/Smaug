<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Custom\Reply;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Currency;

use DB;

class AccountController extends Controller
{
    /**
     * Array to store validation errors
     * If array contains one or more items the requested operation is not executed
     */
    private $validationErrors = array();
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $reply = new Reply();
        
        $accounts = Account::withTrashed()->orderBy('deleted_at')->orderBy('name')->get();
        $accountsTable = view('tables.accounts')
            ->with('accounts', $accounts)
            ->render();
        $reply->accountsTable = $accountsTable;
        
        return response()->json($reply, 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        $reply = new Reply();
        
        $accountTypes = AccountType::all();
        $accountTypesSlt = view('elements.singleSelect')
            ->with('results', $accountTypes)
            ->with('text', 'name')
            ->render();
        $reply->accountTypesSlt = $accountTypesSlt;
        
        $currencies = Currency::all();
        $currenciesSlt = view('elements.singleSelect')
            ->with('results', $currencies)
            ->with('text', ['code' , 'name'])
            ->render();
        $reply->currenciesSlt = $currenciesSlt;
        
        return response()->json($reply);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $reply = new Reply();
        
        $account = new Account;
        $account->name = $request->name;
        $account->accountType()->associate(AccountType::find($request->accountTypeId));
        $account->currency()->associate(Currency::find($request->currencyId));
        $account->balance = $request->balance;
        $account->notes = $request->notes;

        if ($account->isValid()){

            DB::beginTransaction();
            try {
                 
                $account->save();
                
                DB::commit();
                
                $reply->result = true;
                
            } catch (\Exception $e) {
                
                $reply->error = $e;
                $reply->message = 'No se pudo guardar la Cuenta';
                
                DB::rollback();
                
            }
        } else {

            $reply->message = 'Se encontraron errores en los datos ingresados';
            $reply->validations = $account->validationErrors();

        }
        
        return response()->json($reply);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meter  $meter
     * @return \Illuminate\Http\Response
     */
    public function show($meterId)
    {
        $reply = new Reply();
        
        $meter = Meter::with('card')->withTrashed()->findOrFail($meterId);
        $reply->meter = $meter;
        
        return response()->json($reply);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meter  $meter
     * @return \Illuminate\Http\Response
     */
    public function edit($meterId)
    {
        $reply = new Reply();
        
        $meter = Meter::with(['card', 'division', 'technology'])->withTrashed()->findOrFail($meterId);
        $reply->meter = $meter;
        
        if(is_null($meter->card)){
            $cards = Card::has('meter', '<', 1)->get();
        } else {
            $cards = Card::where('id', $meter->card->id)->orHas('meter', '<', 1)->get();
        }
        
        $optionsCard = view('elements.singleSelect')
            ->with('results', $cards)
            ->with('text', 'serial')
            ->with('first', 'Selecciona una Tarjeta')
            ->with('new', 'Agregar nueva tarjeta')
            ->render();
        $reply->optionsCard = $optionsCard;
        
        return response()->json($reply);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meter  $meter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $reply = new Reply();
        
        /* Meter serial validation */
        $serial = $request->serial;
        $meterId = $request->meterId;
        $meter = $this->fetchMeter($serial, $meterId);
        
        /* Card fetch */
        $card = $this->fetchCard($request->cardSerial, $request->cardId, $meterId);
                
        /* Division  */
        $division = $this->fetchDivision($request->divisionId);

        /* Technology */
        $technology = $this->fetchTechnology($request->technologyId);
        
        if (count($this->validationErrors) == 0 && !is_null($meter)){
            DB::beginTransaction();
            try {
                $card->save();
                
                $meter->card()->associate($card);
                $meter->division()->associate($division);
                $meter->technology()->associate($technology);
                $meter->save();
                
                DB::commit();
                
                $reply->result = true;
                
            } catch (\Exception $e) {
                
                $reply->error = $e;
                $reply->message = 'No se pudo actualizar el Medidor';
                
                DB::rollback();
                
            }
        } else if(is_null($meter)) {
            
            $reply->message = 'El Medidor no existe o se desactivó';

        } else {

            $reply->message = 'Ocurrió un error con la validación de los datos';
            $reply->validations = $this->validationErrors;

        }
        
        return response()->json($reply);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meter  $meter
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $reply = new Reply();
        
        $meterId = $request->meterId;
        DB::beginTransaction();
        try {
            $meter = Meter::findOrFail($meterId);
            $meter->card()->dissociate();
            $meter->save();
            $meter->delete();
            
            $tasks = Task::where('meter_id', $meterId)->where('status', 'Programada')->get();
            foreach($tasks as $task){
                $task->status = 'Cancelada';
                $task->save();
            }
            
            DB::commit();
            
            $reply->result = true;
        } catch (\Exception $e) {
            
            $reply->error = $e;
            $reply->message = 'No se pudo desactivar el Medidor';
            
            DB::rollback();
            
        }
        
        return response()->json($reply);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Meter  $meter
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        $reply = new Reply();
        
        $meterId = $request->meterId;
        DB::beginTransaction();
        try {
        
            $cardId = $request->cardId;
            
            if(is_null($cardId)){
                
                $cardSerial = $request->cardSerial;
                $cards = Card::where('serial', $cardSerial)->get();
                if(count($cards) == 0){
                    
                    $card = new Card;
                    $card->serial = $cardSerial;
                    $card->save();
                    
                } else {
                    
                    $reply->error = true;
                    $reply->message = 'El serial de Tarjeta ingresado ya existe';
                    
                }
            } else {
                
                $card = Card::find($cardId);
                
            }
                
            if(!$reply->error){
                
                $meter = Meter::withTrashed()->findOrFail($meterId);
                $meter->restore();
                $meter->card()->associate($card);
                $meter->save();
                
                DB::commit();
                
                $reply->card = $card;
                $reply->result = true;
                
            }
        } catch (\Exception $e) {
            
            $reply->error = $e;
            $reply->message = 'No se pudo activar el Medidor';
            
            DB::rollback();
            
        }
        
        return response()->json($reply);
    }
    

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Meter  $meter
     * @return \Illuminate\Http\Response
     */
    public function userValidate(Request $request)
    {
        $reply = new Reply();
        
        $meterId = $request->meterId;
        DB::beginTransaction();
        try {
                
            $meter = Meter::withTrashed()->findOrFail($meterId);
            $meter->restore();
            $meter->user_validated = true;
            $meter->save();
            
            DB::commit();
            
            $reply->result = true;
        } catch (\Exception $e) {
            
            $reply->error = $e;
            $reply->message = 'No se pudo validar el Medidor';
            
            DB::rollback();
            
        }
        
        return response()->json($reply);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meter  $meter
     * @return \Illuminate\Http\Response
     */
    public function receivedMessages($meterId)
    {
        $reply = new Reply();
        
        $meter = Meter::with(['messages.task.instruction', 'messages.card'])->withTrashed()->findOrFail($meterId);
        $reply->meter = $meter;
        
        $tableMessages = view('tables.message')
            ->with('messages', $meter->messages)
            ->render();
        $reply->tableMessages = $tableMessages;
        
        return response()->json($reply, 201);
    }

    /**
     * Validate Meter serial
     */
    private function fetchMeter($serial, $meterId = null)
    {
        $meter = null;
        
        if(is_null($meterId)){
            if(strlen($serial) != 6){
                
                $this->validationErrors['serial'] = 'Ingresar 6 caracteres';
                
            }  else if(!preg_match('/^[A-Z0-9]+$/', $serial)){
                
                $this->validationErrors['serial'] = 'Únicamente mayusculas y números';
                
            } else if(count(Meter::where('serial', $serial)->get()) > 0) {

                $this->validationErrors['serial'] = 'Serial ya existente';
                
            } else {

                $meter = new Meter;
                $meter->serial = $serial;

            }
        } else {
                    
            $meter = Meter::find($meterId);

            if(is_null($meter)) {
                
                $this->validationErrors['serial'] = 'Medidor no existente';

            } else if($meter->serial != $serial){

                if(strlen($serial) != 6){
                    
                    $this->validationErrors['serial'] = 'Ingresar 6 caracteres';
                    
                }  else if(!preg_match('/^[A-Z0-9]+$/', $serial)){
                    
                    $this->validationErrors['serial'] = 'Únicamente mayusculas y números';
                    
                } else if(count(Meter::where('serial', $serial)->get()) > 0) {
                    
                    $this->validationErrors['serial'] = 'Serial ya existente';
                    
                } else {

                    $meter->serial = $serial;

                }
            }
        }

        return $meter;
    }

    /**
     * Validate Card and fetch or create object
     */
    private function fetchCard($cardSerial, $cardId = null, $meterId = null)
    {
        
        $card = null;
        
        if(is_null($cardId)){
            if(strlen($cardSerial) != 8){
                
                $this->validationErrors['cardSerial'] = 'Ingresar 8 caracteres';
                
            }  else if(!preg_match('/^[A-Z0-9]+$/', $cardSerial)){
                
                $this->validationErrors['cardSerial'] = 'Únicamente mayusculas y números';
                
            } else if(count(Card::where('serial', $cardSerial)->get()) > 0) {
                
                $this->validationErrors['cardSerial'] = 'Serial ya existente';
                
            } else {

                $card = new Card;
                $card->serial = $cardSerial;

            }
            
        } else {
                    
            $card = Card::find($cardId);
            if(is_null($card)) {
                
                $this->validationErrors['cardId'] = 'Tarjeta no existente';

            } else if(!is_null($card->meter) && $card->meter->id != $meterId){
                
                $this->validationErrors['cardId'] = 'Tarjeta asignada a un Medidor';

            }
        }

        return $card;
    }

    /**
     * Validate Division and fetch object
     */
    private function fetchDivision($divisionId, $byByte = false)
    {
        if($byByte){
            $division = Division::where('digit', $divisionId)->first();
        } else {
            $division = Division::find($divisionId);
        }
        
        if(is_null($division)) {
            
            $this->validationErrors['divisionId'] = 'División no existente';

        } else if(!$division->isActive){
            
            $this->validationErrors['divisionId'] = 'División no activa';
            $division = null;

        }

        return $division;
    }

    /**
     * Validate Technology and fetch object
     */
    private function fetchTechnology($technologyId, $byByte = false)
    {
        if($byByte){
            $technology = Technology::where('digit', $technologyId)->first();
        } else {
            $technology = Technology::find($technologyId);
        }
        
        if(is_null($technology)) {
            
            $this->validationErrors['technologyId'] = 'Tecnología no existente';

        } else if(!$technology->isActive){
            
            $this->validationErrors['technologyId'] = 'Tecnología no activa';
            $technology = null;

        }

        return $technology;
    }

    public function batchUpload(Request $request)
    {
        $reply = new Reply();

        if(is_null($request->document)){
            $reply->message = 'Favor de elegir un archivo';
            $reply->validations = ['document' => 'Favor de subir un archivo'];
        } else if(is_array($request->document) && count($request->document) != 1){
            $reply->message = 'Solo puede subir un archivo';
            $reply->validations = ['document' => 'Solo puede subir un archivo'];
        } else {
            $document = (is_array($request->document) ? $request->document[0] : $request->document);
            
            $name = explode('.', $document->getClientOriginalName());
            $ext = end($name);
            if($ext != 'csv'){
                $reply->message = 'Formato de archivo incorrecto';
                $reply->validations = ['document' => 'Favor de elegir un archivo .csv'];
            } else {
                $onError = $request->meterBatchOnError;
                $newName = 'BatchFile_'.date('Ymdhis').'.'.$ext;
                
                $path = Storage::putFileAs(
                    'Batchs', $document, $newName
                );

                $batchFile = new BatchFile;
                $batchFile->path = $path;

                $data = $this->processCSV($path , ',');
                $reply = $this->processData($data, $onError, $batchFile);
            }
        }
        
        return response()->json($reply);
    }

    private function processCSV($csvPath, $delimeter)
    {
        $csvFile = fopen(storage_path('app\\'.$csvPath), 'r');
        
        while (!feof($csvFile)) {
            $data[] = fgetcsv($csvFile, 0, $delimeter);
        }
        fclose($csvFile);

        return $data;
    }

    private function processData($data, $onError, $batchFile)
    {
        $reply = new Reply();

        $log = false;
        $savedMeters = array();

        if(count($data) == 0 || count($data[0]) != 4) {
            
            $reply->message = 'Estructura incorrecta';
            $reply->validations = ['document' => 'Descarga la plantilla y llenala acordemente'];

        } else if($data[0][0] != 'Meter Serial' || $data[0][1] != 'Card Serial' 
        || $data[0][2] != 'Division Byte' || $data[0][3] != 'Technology Byte') {
            
            $reply->message = 'Encabezados incorrectos';
            $reply->validations = ['document' => 'Descarga la plantilla y llenala acordemente'];
            $reply->data = $data[0][3];

        } else {
            $log = true;

            $batchFile->total = (count($data) - 2);
            $batchFile->success = 0;
            $batchFile->errors = 0;
            $batchFile->errors = 0;
            $batchFile->processed = false;
            $batchFile->summary = '[]';
            $batchFile->save();
            
            $meters = array();
            $cards = array();
            $dataErrors = array();
            
            for($i = 1; $i < count($data); $i++){
                if(!is_array($data[$i])){
                    continue;
                }
                $info = $data[$i];

                if(count($info) != 4){
                    $dataErrors[strval($i)] = ['Información incompleta, no se puede procesar la linea'];
                    if($onError == 'abort'){
                        break;
                    } else {
                        continue;
                    }
                }

                $lineErrors = array();
                
                $meterSerial = $info[0];
                $meter = $this->fetchMeter($meterSerial);
                if(is_null($meter)){
                    array_push($lineErrors, 'Medidor: '.$this->validationErrors['serial'].' <span class="text-danger">['.$meterSerial.']</span>');
                }


                $cardSerial = $info[1];
                $card = $this->fetchCard($cardSerial);
                if(is_null($card)){
                    array_push($lineErrors, 'Tarjeta: '.$this->validationErrors['cardSerial'].' <span class="text-danger">['.$cardSerial.']</span>');
                }


                $divisionDigit = $info[2];
                $division = $this->fetchDivision($divisionDigit, true);
                if(is_null($division)){
                    array_push($lineErrors, $this->validationErrors['divisionId'].' <span class="text-danger">['.$divisionDigit.']</span>');
                }


                $technologyDigit = $info[3];
                $technology = $this->fetchTechnology($technologyDigit, true);
                if(is_null($technology)){
                    array_push($lineErrors, $this->validationErrors['technologyId'].' <span class="text-danger">['.$technologyDigit.']</span>');
                }

                if(count($lineErrors) > 0){
                    $dataErrors[strval($i)] = $lineErrors;
                } else {
                    $cards[$i] = $card;
                
                    $meter->division()->associate($division);
                    $meter->technology()->associate($technology);
                    $meters[$i] = $meter;
                }

                $this->validationErrors = array();
            }

            $warnings = array();
            if(count($dataErrors) != 0 && $onError == 'abort'){
                
                $reply->message = 'Se encontraron errores en el archivo. No se realizó ningún movimiento.';
                $reply->error = $dataErrors;

                $batchFile->errors = count($dataErrors);

            } else if(count($meters) == 0) {
                $reply->message = 'No hay información valida para procesar. No se realizó ningún movimiento.';
                $reply->error = $dataErrors;

                $batchFile->errors = count($dataErrors);
                
            } else {
            
                $dbErrors = array();

                DB::beginTransaction();

                foreach($meters as $index => $meter){

                    try {

                        $card = $cards[$index];
                        $card->save();

                        $meter->card()->associate($card);
                        $meter->batchFile()->associate($batchFile);
                        $meter->save();

                        array_push($savedMeters, $meter);
                        
                    } catch (\Exception $e) {
                        
                        $dbErrors[strval($index)] = $e;

                    }
                }
                
                if(count($dbErrors) > 0 && $onError == 'abort'){

                    DB::rollback();

                    $reply->message = 'Se presentaron errores al guardar la informción. No se realizó ningún movimiento.';
                    $reply->error = array_merge($dataErrors, $dbErrors);
                    
                    $batchFile->errors = count($reply->error);
                    
                } else {

                    $reply->error = array_merge($dataErrors, $dbErrors);

                    try {
                        DB::commit();
                    
                    
                        $reply->result = true;
    
                        $success = (count($meters) - count($dbErrors));
                        $reply->message = 'Se agregaron exitosamente '.$success.' Medidores con sus Tarjetas.';
                        if(count($dbErrors) +  count($dataErrors) > 0){
                            $reply->warning = 'Se presentaron '.(count($dbErrors) +  count($dataErrors)).' errores.';
                        }

                        $batchFile->success = $success;
                        $batchFile->errors = count($reply->warning);
                        $batchFile->processed = true;
                        
                    } catch (\Exception $e) {
                        
                        $reply->warning[0] = $e;
                        
                        $batchFile->errors = count($reply->error);
                        
                    }
                }
            }
        }

        $reply->data = $data;

        if($log){
            DB::beginTransaction();
            try {
                $batchFile->summary = json_encode($reply);
                $batchFile->save();
                
                DB::commit();
                
                $reply->logError = false;

            } catch (\Exception $e) {
                
                $reply->logError = $e;

                DB::rollback();
    
            }
        }

        return $reply;
    }
}
