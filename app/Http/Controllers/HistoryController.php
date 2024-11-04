<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\User;
use App\Models\SeaShipment;

class HistoryController extends Controller
{
    public function index() {
        $histories = History::orderBy('updated_at', 'desc')->get();
        $user = User::pluck('name', 'id');
        $historyData = [];

        foreach ($histories as $hist) {
            $olderDataJson = $hist->older_data;
            $changedDataJson = $hist->changed_data;
        
            $ObjOlderData = json_decode($olderDataJson, true);
            $ObjChangedData = json_decode($changedDataJson, true);
            $updated_time = isset($ObjChangedData['updated_at']) ? date('d-M-y H:i:s', strtotime($ObjChangedData['updated_at'] . '+7 hours')) : null;
        
            unset($ObjOlderData['updated_at']);
            unset($ObjChangedData['updated_at']);
            $resultFilterOlderData = array_intersect_key($ObjOlderData, $ObjChangedData);
        
            $idChangedData = null;
            $validScopes = ['seashipment', 'seashipmentline', 'seashipmentbill', 'seashipmentanotherbill'];
            
            if (in_array(strtolower($hist->scope), $validScopes)) {
                $checkSeaShipment = SeaShipment::where('id_sea_shipment', $hist->id_changed_data)->first();
                if ($checkSeaShipment) {
                    $idChangedData = $checkSeaShipment->id_sea_shipment;
                }

                $existingHistoryIndex = null;
                foreach ($historyData as $index => $data) {
                    if ($data['id_changed_data'] == $idChangedData) {
                        $existingHistoryIndex = $index;
                        break;
                    }
                }
            
                if ($existingHistoryIndex !== null) {
                    $historyData[$existingHistoryIndex]['older_data'] .= ', ' . json_encode($resultFilterOlderData);
                    $historyData[$existingHistoryIndex]['changed_data'] .= ', ' . json_encode($ObjChangedData);
                    $historyData[$existingHistoryIndex]['scope'] = 'seashipment';
                    $historyData[$existingHistoryIndex]['revcount'] += $hist->revcount;

                } else {
                    $historyData[] = [
                        'user_id' => $hist->user_id,
                        'id_changed_data' => $idChangedData,
                        'scope' => $hist->scope,
                        'older_data' => json_encode($resultFilterOlderData),
                        'changed_data' => json_encode($ObjChangedData),
                        'revcount' => $hist->revcount,
                        'updated_time' => $updated_time
                    ];
                }

            } else {
                $historyData[] = [
                    'user_id' => $hist->user_id,
                    'id_changed_data' => $idChangedData,
                    'scope' => $hist->scope,
                    'older_data' => json_encode($resultFilterOlderData),
                    'changed_data' => json_encode($ObjChangedData),
                    'revcount' => $hist->revcount,
                    'updated_time' => $updated_time
                ];
            }
        
        }

        return view('main.history', compact('user', 'historyData'));
    }
}
