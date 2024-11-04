<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{ $titleInv }}</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 12.5px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }
            th {
                font-weight: bold;
                border: 1px solid #000;
            }
            td {
                padding: 5px;
            }

            .space_content {
                padding-left: 30px;
                font-weight: bold;
            }
            .space_content_main {
                padding-left: 75px;
                font-weight: bold;
            }
            .space_content2 {
                padding-left: 20px;
            }

            /* font */
            .bold {
                font-weight: bold;
            }
            .text_center {
                text-align: center;
            }
            .text_uppercase {
                text-transform: uppercase;
            }

            /* border */
            .border_left_right {
                border-left: 1px solid #000;
                border-right: 1px solid #000;
            }
            .no_top_border {
                border-left: 1px solid #000;
                border-right: 1px solid #000;
                border-bottom: 1px solid #000;
            }
        </style>
    </head>
    <body>
        @php
            function spelledout($number) {
                $unit = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
                $dozen = ['sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];
                $tens = ['', 'sepuluh', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'];
                $thousands = ['', 'ribu', 'juta', 'miliar', 'triliun'];
            
                if ($number == 0) {
                    return 'nol';
                }
            
                $result = '';
                $i = 0;
                while ($number > 0) {
                    $hundreds = $number % 1000;
                    $number = floor($number / 1000);
            
                    if ($hundreds != 0) {
                        $hundreds_str = '';
                        if ($hundreds >= 100) {
                            if (floor($hundreds / 100) == 1) {
                                $hundreds_str .= 'seratus ';

                            } else {
                                $hundreds_str .= $unit[floor($hundreds / 100)] . ' ratus ';
                            }

                            $hundreds %= 100;
                        }
            
                        if ($hundreds >= 20) {
                            $hundreds_str .= $tens[floor($hundreds / 10)] . ' ';
                            $hundreds %= 10;

                        } elseif ($hundreds >= 10) {
                            $hundreds_str .= $dozen[$hundreds - 10] . ' ';
                            $hundreds = 0;
                        }
            
                        if ($hundreds > 0) {
                            $hundreds_str .= $unit[$hundreds] . ' ';
                        }
            
                        $result = $hundreds_str . $thousands[$i] . ' ' . $result;
                    }
            
                    $i++;
                }
            
                return trim($result);
            }

            function splitTextIntoLines($text, $maxWidth) {
                $words = explode(" ", $text);
                $lines = [];
                $currentLine = "";

                foreach ($words as $word) {
                    $currentWidth = estimateTextWidth($currentLine . $word . " ");
                    if ($currentWidth <= $maxWidth) {
                        $currentLine .= $word . " ";
                    } else {
                        $lines[] = trim($currentLine);
                        $currentLine = $word . " ";
                    }
                }

                if (!empty($currentLine)) {
                    $lines[] = trim($currentLine);
                }

                return $lines;
            }

            function estimateTextWidth($text) {
                // Anggap setiap karakter memiliki lebar yang sama
                $charWidth = 8; // Ukuran karakter dalam piksel (disesuaikan sesuai kebutuhan)
                return strlen($text) * $charWidth;
            }
        @endphp
        @for ($a = 0; $a < 2; $a++)
            <!-- Check second invoice -->
            @if ($a == 1 && (is_null($customer->discount) || $customer->discount == 0))
                @continue
            @endif
            <div style="margin-top:-40px;">
                <img src="data:image/jpeg;base64,{{ base64_encode($imageContent) }}" style="width: 650px; margin-left:40px;">
            </div>

            <table style="border: 1px solid #000;">
                <tr style="border: 1px solid #000;">
                    <td colspan="6" style="text-align: center; padding-top: 0; padding-bottom: 0; font-weight:bold; font-size:22.5px;">INVOICE</td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <td class="space_content" colspan="2">To :</td>
                    <td style="padding-left: 70px;" class="bold" colspan="2">Inv. No.</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ $invNameGenerate }}</span></td>
                </tr>
                <tr>
                    <td class="space_content" colspan="2"></td>
                    <td style="padding-left: 70px;" class="bold" colspan="2">Date</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $seaShipment->etd)->format('d-M-y') }}</span></td>
                </tr>
                <tr>
                    <td class="space_content_main" colspan="2">{{ $customer->name }}</td>
                    <td style="padding-left: 70px;" class="bold" colspan="2">Term</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ $term }} Days</span></td>
                </tr>
                @if (trim($customer->name) !== trim($shipper->name))
                <tr>
                    <td class="space_content_main" colspan="2">{{ $shipper->name }}</td>
                    <td style="padding-left: 70px;" class="bold" colspan="2">Payment Due</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $paymentDue)->format('d-M-y') }}</span></td>
                </tr>
                @else
                <tr>
                    <td class="space_content_main" colspan="2"></td>
                    <td style="padding-left: 70px;" class="bold" colspan="2">Payment Due</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $paymentDue)->format('d-M-y') }}</span></td>
                </tr>
                @endif
                <tr>
                    <td class="space_content" colspan="2"></td>
                    <td style="padding-left: 70px;" class="bold" colspan="2">Freight Type</td>
                    <td class="bold" colspan="2">: <span class="space_content2">SEA FREIGHT</span></td>
                </tr>
                <tr>
                    <td class="space_content" colspan="2"></td>
                    <td style="padding-left: 70px;" class="bold" colspan="2">Banker</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ $banker->name ?? null }}</span></td>
                </tr>
                <tr>
                    <td class="space_content" colspan="2"></td>
                    <td style="padding-left: 70px;" class="bold" colspan="2">Account No.</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ $account_no->account_no ?? null }}</span></td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th colspan="2">Quantity</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td class="border_left_right"></td>
                    <td class="border_left_right text_center">Biaya Pengiriman {{ $origin->name ?? null }}</td>
                    <td class="border_left_right"></td>
                    <td class="border_left_right"></td>
                    <td class="border_left_right"></td>
                    <td class="border_left_right"></td>
                </tr>

                @php
                    $amount = 0;
                    $totalQty = 0;
                    $totalAmount = 0;
                    $totalCbm = 0;
                    $totalWeight = 0;
                    $checkLoopDate = null;
                    $entryRow = 0;

                    // Bill
                    if ($dataBill) {
                        $resultBill = [];
                        foreach ($dataBill["dateBL"] as $index => $date) {
                            $resultBill[] = [
                                "dateBL" => $dataBill["dateBL"][$index] ?? null,
                                "codeShipment" => $dataBill["codeShipment"][$index] ?? null,
                                "transport" => isset($dataBill["transport"][$index]) ? preg_replace("/[^0-9]/", "", explode(",", $dataBill["transport"][$index])[0]) : null,
                                "bl" => isset($dataBill["bl"][$index]) ? preg_replace("/[^0-9]/", "", explode(",", $dataBill["bl"][$index])[0]) : null,
                                "permit" => isset($dataBill["permit"][$index]) ? preg_replace("/[^0-9]/", "", explode(",", $dataBill["permit"][$index])[0]) : null,
                                "insurance" => isset($dataBill["insurance"][$index]) ? preg_replace("/[^0-9]/", "", explode(",", $dataBill["insurance"][$index])[0]) : null
                            ];
                        }
                    }
                    
                    // Another Bill
                    $totalanotherBillOverall = 0;
                    if ($dataAnotherBill) {
                        $resultAnotherBill = [];
                        $dates = is_array($dataAnotherBill["date"]) ? $dataAnotherBill["date"] : [$dataAnotherBill["date"]];
                        $descs = is_array($dataAnotherBill["desc"]) ? $dataAnotherBill["desc"] : [$dataAnotherBill["desc"]];
                        $charges = is_array($dataAnotherBill["charge"]) ? $dataAnotherBill["charge"] : [$dataAnotherBill["charge"]];
                        $notes = is_array($dataAnotherBill["note"]) ? $dataAnotherBill["note"] : [$dataAnotherBill["note"]];

                        $maxCount = max(count($descs), count($charges));

                        for ($index = 0; $index < $maxCount; $index++) {
                            $date = isset($dates[$index]) ? $dates[$index] : $dates[0];
                            $desc = isset($descs[$index]) ? $descs[$index] : null;
                            $charge = isset($charges[$index]) ? $charges[$index] : null;
                            $note = isset($notes[$index]) ? $notes[$index] : null;
                            $anotherBillValue = $charge ? preg_replace("/[^0-9]/", "", $charge) : null;

                            if (is_null($desc) && ($anotherBillValue == 0 || is_null($anotherBillValue))) {
                                continue;
                            }

                            $resultAnotherBill[] = [
                                "date" => $date,
                                "desc" => $desc,
                                "charge" => $anotherBillValue,
                                "note" => $note
                            ];

                            $totalanotherBillOverall += $anotherBillValue;
                        }
                    }

                    // Set index bill
                    $billIndex = 0;

                    // Update row
                    $entryRow += count($resultAnotherBill);

                    // Show total weight if unit == T (Tonase)
                    $is_tonase = false;

                @endphp

                @if (in_array($origin->name, ['SIN-BTH', 'SIN-JKT']))
                    @php
                        // Set total amount not include another bill
                        $totalAmount = $allTotalAmount;

                        if ($a == 1 && ($customer->discount && $customer->discount > 0)) {
                            $totalAmount = $allTotalAmountDisc;
                        }
                    @endphp

                    @foreach($groupSeaShipmentLines as $groupDate => $totals)
                        @php
                            // Memisahkan bagian-bagian dari key
                            $parts = explode('-', $groupDate);

                            // Mengambil unit
                            $unitType = $parts[3] ?? '';

                            $date = substr($groupDate, 0, 10);
                            $lts = substr($groupDate, strrpos($groupDate, '-') + 1);

                            // Mengambil hanya nilai dari markings
                            $markingsValues = array_values($totals['markings']);

                            $customerPrice = $pricelist;
                            $qty = $totals['total_qty_loose'];
                            $cbm = round($totals['total_cbm2'], 3);
                            $weight = $totals['total_weight'];
                            $cas = $totals['cas'];

                            // Jika invoice kedua (tidak ada cas)
                            if ($a == 1) {
                                if ($customerPrice > 0 && $customerPrice > intval($customer->discount)) {
                                    $customerPrice -= intval($customer->discount);
                                }
                            }

                            $unit_price = $customerPrice;
                            $unitPriceCbmDiff = 0;
                            $entryRow++;
                            
                            // Jika ada cas
                            if ($cas) {
                                $unit_price = $customerPrice + intval($cas);

                                // Jika LTS = LP, LPI, LPM, LPM/LPI, LPI/LPM
                                if (in_array($lts, ['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM'])) {
                                    $unit_price = $totals['total_qty_unit'] * intval($cas);
                                }
                            }

                            // Data tagihan lainnya
                            $bl = null;
                            $permit = null;
                            $transport = null;
                            $insurance = null;
                            $anotherBillData = null;

                            if ($checkLoopDate != $date) {
                                if (isset($resultBill[$billIndex])) {
                                    $code = $resultBill[$billIndex]['codeShipment'];
                                    $bl = $resultBill[$billIndex]['bl'];
                                    $permit = $resultBill[$billIndex]['permit'];
                                    $transport = $resultBill[$billIndex]['transport'];
                                    $insurance = $resultBill[$billIndex]['insurance'];
                                }

                                $billIndex++;
                            
                            }
                            
                            $entryRow += ($bl ? 1 : 0) + ($permit ? 1 : 0) + ($transport ? 1 : 0) + ($insurance ? 1 : 0);
                            // $checkLoopDate = $date;
                            
                            if (in_array($lts, ['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM'])) {
                                $amount = $unit_price;

                            } else {
                                $amount = $cbm * $unit_price;
        
                                // Jika beralih penagihan dengan berat
                                if ($is_weight || $unitType == 'T') {
                                    $amount = $weight * $unit_price;
                                    $is_tonase = true;
                                }
                            }

                            $totalQty += $qty;
                            $totalWeight += $weight;
                            $totalAmount += intval($bl) + intval($permit) + intval($transport) + intval($insurance);
                            $totalCbm += $totals['total_cbm2'];

                            $groupedMarkings = collect(array_keys($totals['markings']))->groupBy(function ($marking) {
                                // Menentukan pola regex untuk ekstraksi prefix dan nomor
                                preg_match('/^(.*?)([-#\s\.\/]?)\s*(\d*)$/', $marking, $matches);
                                $prefix = $matches[1] ?? '';
                                $separator = $matches[2] ?? '';
                                $number = $matches[3] ?? '';
                                return $prefix . $separator;
                            });

                            $mergedMarkings = $groupedMarkings->map(function ($group) {
                                $prefix = '';
                                $separator = '';
                                $suffixes = $group->map(function ($marking) use (&$prefix, &$separator) {
                                    // Ekstraksi prefix dan separator dari marking pertama
                                    preg_match('/^(.*?)([-#\s\.\/]?)\s*(\d*)$/', $marking, $matches);
                                    if (empty($prefix)) {
                                        $prefix = $matches[1] ?? '';
                                        $separator = $matches[2] ?? '';
                                    }
                                    return $matches[3] !== '' ? intval($matches[3]) : null; // Mengambil angka dari grup ketiga hasil regex, atau null jika tidak ada
                                })->filter()->sort()->unique()->values()->toArray();

                                if (empty($suffixes)) {
                                    return $prefix;
                                }

                                $merged = [];
                                $lastSuffix = null; // Initialize with null
                                foreach ($suffixes as $suffix) {
                                    if ($lastSuffix !== null && $suffix - $lastSuffix !== 1) {
                                        $merged[] = count($currentRange) > 1 ? $prefix . $separator . $currentRange[0] . '-' . $lastSuffix : $prefix . $separator . $lastSuffix;
                                        $currentRange = [$suffix];
                                    } else {
                                        $currentRange[] = $suffix;
                                    }
                                    $lastSuffix = $suffix;
                                }
                                $merged[] = count($currentRange) > 1 ? $prefix . $separator . $currentRange[0] . '-' . $lastSuffix : $prefix . $separator . $lastSuffix;

                                // Menyusun hasil akhir dengan format yang diminta
                                $mergedString = implode(', ', $merged);
                                $uniqueSuffixes = implode(', ', $suffixes);

                                return $prefix . $separator . $uniqueSuffixes;
                            })->values()->toArray();

                        @endphp
                        
                        @if ($lts) 
                        <tr>
                            <td width="5%" class="border_left_right"></td>
                            <td width="30%" class="border_left_right text_center">
                                @if ($checkLoopDate != $date)
                                    @if ($is_weight || $unitType == 'T')
                                        @if (!$cas)
                                            @if ($lts == 'SP')
                                                {{ $code ? $code : '' }} : {{ $cbm }} M3 
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                            @else
                                                {{ $code ? $code : '' }} {{ implode(', ', $mergedMarkings) }} : {{ $cbm }} M3 
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                            @endif
                                        @else
                                            @if (in_array($lts, ['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM']))
                                                {{ $code ? $code : '' }} {{ implode(', ', $mergedMarkings) }} = {{ $lts }} : {{ $cbm }} M3 ( {{ $totals['total_qty_unit'] }} 
                                                {{ $unitType }} x {{ 'Rp ' . number_format($cas ?? 0, 0, ',', '.') }} ) {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                            @else
                                                {{ $code ? $code : '' }} {{ implode(', ', $mergedMarkings) }} = {{ $lts }} : {{ $cbm }} M3 
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                            @endif
                                        @endif
                                    @else
                                        @if (!$cas)
                                            @if ($lts == 'SP')
                                                {{ $code ? $code : '' }} {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                            @else
                                                {{ $code ? $code : '' }} {{ implode(', ', $mergedMarkings) }} {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                            @endif
                                        @else
                                            @if (in_array($lts, ['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM']))
                                                {{ $code ? $code : '' }} {{ implode(', ', $mergedMarkings) }} = {{ $lts }} ( {{ $totals['total_qty_unit'] }} 
                                                {{ $unitType }} x {{ 'Rp ' . number_format($cas ?? 0, 0, ',', '.') }} ) {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                            @else
                                                {{ $code ? $code : '' }} {{ implode(', ', $mergedMarkings) }} = {{ $lts }} {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    @if ($is_weight || $unitType == 'T')
                                        @if (!$cas)
                                            @if ($lts == 'SP')
                                                {{ $code ? $code : '' }} : {{ $cbm }} M3 
                                            @else
                                                {{ $code ? $code : '' }} {{ implode(', ', $mergedMarkings) }} : {{ $cbm }} M3 
                                            @endif
                                        @else
                                            @if (in_array($lts, ['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM']))
                                                {{ $code ? $code : '' }} {{ implode(', ', $mergedMarkings) }} = {{ $lts }} : {{ $cbm }} M3 ( {{ $totals['total_qty_unit'] }} 
                                                {{ $unitType }} x {{ 'Rp ' . number_format($cas ?? 0, 0, ',', '.') }} )
                                            @else
                                                {{ $code ? $code : '' }} {{ implode(', ', $mergedMarkings) }} = {{ $lts }} : {{ $cbm }} M3 
                                            @endif
                                        @endif
                                    @else
                                        @if (!$cas)
                                            @if ($lts == 'SP')
                                                {{ $code ? $code : '' }}
                                            @else
                                                {{ $code ? $code : '' }} {{ implode(', ', $mergedMarkings) }}
                                            @endif
                                        @else
                                            @if (in_array($lts, ['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM']))
                                                {{ $code ? $code : '' }} {{ implode(', ', $mergedMarkings) }} = {{ $lts }} ( {{ $totals['total_qty_unit'] }} 
                                                {{ $unitType }} x {{ 'Rp ' . number_format($cas ?? 0, 0, ',', '.') }} )
                                            @else
                                                {{ $code ? $code : '' }} {{ implode(', ', $mergedMarkings) }} = {{ $lts }}
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            </td>

                            <!-- Check Date -->
                            @php
                                $checkLoopDate = $date;
                            @endphp

                            <td width="12.5%" class="border_left_right text_center text_uppercase">{{ $qty }} PKG</td>

                            @if ($is_weight || $unitType == 'T')
                                @if ( ($weight / 1000) > $cbm) 
                                    <td width="10%" class="border_left_right text_center text_uppercase">{{ $weight / 1000 }} T</td>
                                @else
                                    <td width="10%" class="border_left_right text_center text_uppercase">{{ $weight }} KG</td>
                                @endif
                            @else
                                <td width="10%" class="border_left_right text_center text_uppercase">{{ $cbm }} M3</td>
                            @endif

                            @if (in_array($lts, ['LP', 'LPI', 'LPM']))
                                <td width="15%" class="border_left_right text_center"></td>
                            @else
                                <td width="15%" class="border_left_right text_center">
                                    {{ 'Rp ' . number_format($unit_price ?? 0, 0, ',', '.') }}
                                </td>
                            @endif

                            <td width="20%" class="border_left_right text_center">{{ 'Rp ' . number_format($amount ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @endif

                        <!-- bl -->
                        @if ($bl)
                            <tr>
                                <td width="5%" class="border_left_right"></td>
                                <td width="30%" class="border_left_right text_center">BL</td>
                                <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                                <td width="10%" class="border_left_right text_center text_uppercase"></td>
                                <td width="15%" class="border_left_right text_center"></td>
                                <td width="20%" class="border_left_right text_center">{{ 'Rp ' . number_format($bl ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                        
                        <!-- permit -->
                        @if ($permit)
                            <tr>
                                <td width="5%" class="border_left_right"></td>
                                <td width="30%" class="border_left_right text_center">PERMIT</td>
                                <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                                <td width="10%" class="border_left_right text_center text_uppercase"></td>
                                <td width="15%" class="border_left_right text_center"></td>
                                <td width="20%" class="border_left_right text_center">{{ 'Rp ' . number_format($permit ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @endif

                        <!-- transport -->
                        @if ($transport)
                            <tr>
                                <td width="5%" class="border_left_right"></td>
                                <td width="30%" class="border_left_right text_center">TRANSPORT</td>
                                <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                                <td width="10%" class="border_left_right text_center text_uppercase"></td>
                                <td width="15%" class="border_left_right text_center"></td>
                                <td width="20%" class="border_left_right text_center">{{ 'Rp ' . number_format($transport ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @endif

                        <!-- insurance -->
                        @if ($insurance)
                            <tr>
                                <td width="5%" class="border_left_right"></td>
                                <td width="30%" class="border_left_right text_center">INSURANCE</td>
                                <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                                <td width="10%" class="border_left_right text_center text_uppercase"></td>
                                <td width="15%" class="border_left_right text_center"></td>
                                <td width="20%" class="border_left_right text_center">{{ 'Rp ' . number_format($insurance ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                        
                        @php
                            if ($entryRow > 15) {
                                $entryRow = 0;
                                echo '</table>';
                                echo '<div style="page-break-after: always;"></div>';
                                echo '<table style="border: 1px solid #000;">';
                                echo '<tr>
                                        <th>Item</th>
                                        <th>Description</th>
                                        <th colspan="2">Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Amount</th>
                                    </tr>';
                            }
                        @endphp
                    @endforeach

                    <!-- Jika ada selisih -->
                    @php
                        $cbm1 = 0;
                        $cbm2 = 0;
                        $cbmDiff = 0;
                        $amountCbmDiff = 0;
                        $entryRow++;
                    @endphp
                    @foreach($groupedSeaShipmentLinesDate as $totals)
                        @php
                            $cbm1 += $totals['total_cbm1'];
                            $cbm2 += $totals['total_cbm2'];
                            $cbmDiff += $totals['cbm_difference'];
                        @endphp
                    @endforeach
                    @php
                        if ($cbmDiff > 0) {
                            $amountCbmDiff = $bill_diff * round($cbmDiff, 3);
                            $totalAmount += $amountCbmDiff;
                            $totalCbm += $cbmDiff;
                        }
                    @endphp

                    @if (!$is_weight && $cbmDiff > 0)
                        <tr>
                            <td width="5%" class="border_left_right"></td>
                            <td width="30%" class="border_left_right text_center">Selisih SIN BTH ({{ round($cbm1, 3) }} - {{ round($cbm2, 3) }} M3)</td>
                            <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                            <td width="10%" class="border_left_right text_center text_uppercase">{{ round($cbmDiff, 3) }} M3</td>
                            <td width="15%" class="border_left_right text_center">{{ 'Rp ' . number_format($bill_diff ?? 0, 0, ',', '.') }}</td>
                            <td width="20%" class="border_left_right text_center">{{ 'Rp ' . number_format($amountCbmDiff ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endif

                    <!-- another bill -->
                    @if (count($resultAnotherBill) > 0)
                        @for ($d = 0; $d < count($resultAnotherBill); $d++)
                        @php
                            $checkDesc = $descsData->where('id_desc', $resultAnotherBill[$d]['desc'])->first();
                        @endphp
                        <tr>
                            <td width="5%" class="border_left_right"></td>
                            <td width="30%" class="border_left_right text_center">{{ $checkDesc->name }} {{ $resultAnotherBill[$d]['note'] }}</td>
                            <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                            <td width="10%" class="border_left_right text_center text_uppercase"></td>
                            <td width="15%" class="border_left_right text_center"></td>
                            <td width="20%" class="border_left_right text_center">{{ 'Rp ' . number_format($resultAnotherBill[$d]['charge'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @endfor
                    @endif

                    <!-- empty row -->
                    @for ($i = 1; $i <= (16 - $entryRow); $i++)
                        <tr>
                            <td width="5%" class="border_left_right" style="height: 20px;"></td>
                            <td width="30%" class="border_left_right text_center"></td>
                            <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                            <td width="10%" class="border_left_right text_center text_uppercase"></td>
                            <td width="15%" class="border_left_right text_center"></td>
                            <td width="20%" class="border_left_right text_center"></td>
                        </tr>
                    @endfor

                @else
                    @php
                        // Set total amount not include another bill
                        $totalAmount = $allTotalAmount;

                        if ($a == 1 && ($customer->discount && $customer->discount > 0)) {
                            $totalAmount = $allTotalAmountDisc;
                        }
                    @endphp

                    @foreach($groupSeaShipmentLines as $groupDate => $totals)
                        @php
                            // Memisahkan bagian-bagian dari key
                            $parts = explode('-', $groupDate);

                            // Mengambil unit
                            $unitType = $parts[3] ?? '';
                            
                            $date = substr($groupDate, 0, 10);
                            $lts = substr($groupDate, strrpos($groupDate, '-') + 1);

                            // Mengambil hanya nilai dari markings
                            $markingsValues = array_values($totals['markings']);

                            $customerPrice = $pricelist;
                            $qty = $totals['total_qty_pkgs'];
                            $cbm = round($totals['total_cbm2'], 3);
                            $weight = $totals['total_weight'];
                            $cas = $totals['cas'];

                            // Jika invoice kedua (tidak ada cas)
                            if ($a == 1) {
                                if ($customerPrice > 0 && $customerPrice > intval($customer->discount)) {
                                    $customerPrice -= intval($customer->discount);
                                }
                            }

                            $unit_price = $customerPrice;
                            $entryRow++;

                            // Jika ada cas
                            if ($cas) {
                                $unit_price = $customerPrice + intval($cas);

                                // Jika LTS = LP, LPI, LPM, 'LPM/LPI', 'LPI/LPM'
                                if (in_array($lts, ['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM'])) {
                                    $unit_price = $totals['total_qty_unit'] * intval($cas);
                                }
                            }

                            $totalQty += $qty;
                            
                            $totalCbm += $totals['total_cbm2'];
                            $totalWeight += $weight;

                            if (in_array($lts, ['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM'])) {
                                $amount = $unit_price;

                            } else {
                                $amount = $cbm * $unit_price;
        
                                // Jika beralih penagihan dengan berat
                                if ($is_weight || $unitType == 'T') {
                                    $amount = $weight * $unit_price;
                                    $is_tonase = true;
                                }
                            }

                            $totalAmount += isset($anotherBillData['charge']) ? intval($anotherBillData['charge']) : 0;

                            $groupedMarkings = collect(array_keys($totals['markings']))->groupBy(function ($marking) {
                                // Menentukan pola regex untuk ekstraksi prefix dan nomor
                                preg_match('/^(.*?)([-#\s\.\/]?)\s*(\d*)$/', $marking, $matches);
                                $prefix = $matches[1] ?? '';
                                $separator = $matches[2] ?? '';
                                $number = $matches[3] ?? '';
                                return $prefix . $separator;
                            });

                            $mergedMarkings = $groupedMarkings->map(function ($group) {
                                $prefix = '';
                                $separator = '';
                                $suffixes = $group->map(function ($marking) use (&$prefix, &$separator) {
                                    // Ekstraksi prefix dan separator dari marking pertama
                                    preg_match('/^(.*?)([-#\s\.\/]?)\s*(\d*)$/', $marking, $matches);
                                    if (empty($prefix)) {
                                        $prefix = $matches[1] ?? '';
                                        $separator = $matches[2] ?? '';
                                    }
                                    return $matches[3] !== '' ? intval($matches[3]) : null; // Mengambil angka dari grup ketiga hasil regex, atau null jika tidak ada
                                })->filter()->sort()->unique()->values()->toArray();

                                if (empty($suffixes)) {
                                    return $prefix;
                                }

                                $merged = [];
                                $currentRange = [];
                                $lastSuffix = null; // Initialize with null
                                foreach ($suffixes as $suffix) {
                                    if ($lastSuffix !== null && $suffix - $lastSuffix !== 1) {
                                        $merged[] = count($currentRange) > 1 ? $prefix . $separator . $currentRange[0] . '-' . $lastSuffix : $prefix . $separator . $lastSuffix;
                                        $currentRange = [$suffix];
                                    } else {
                                        $currentRange[] = $suffix;
                                    }
                                    $lastSuffix = $suffix;
                                }
                                $merged[] = count($currentRange) > 1 ? $prefix . $separator . $currentRange[0] . '-' . $lastSuffix : $prefix . $separator . $lastSuffix;
                                return implode(', ', $merged);
                            })->values()->toArray();
                        @endphp

                        <tr>
                            <td width="5%" class="border_left_right"></td>
                            <td width="30%" class="border_left_right text_center">
                                @if ($is_weight || $unitType == 'T')
                                    @if (!$cas)
                                        BATAM {{ implode(', ', $mergedMarkings) }} : {{ $cbm }} M3 {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                    @else
                                        @if (in_array($lts, ['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM']))
                                            BATAM {{ implode(', ', $mergedMarkings) }} = {{ $lts }} : {{ $cbm }} M3 ( {{ $totals['total_qty_unit'] }} 
                                            {{ $unitType }} x {{ 'Rp ' . number_format($cas ?? 0, 0, ',', '.') }} ) {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                        @else
                                            BATAM {{ implode(', ', $mergedMarkings) }} = {{ $lts }} : {{ $cbm }} M3 {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                        @endif
                                    @endif
                                @else
                                    @if (!$cas)
                                        BATAM {{ implode(', ', $mergedMarkings) }} {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                    @else
                                        @if (in_array($lts, ['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM']))
                                            BATAM {{ implode(', ', $mergedMarkings) }} = {{ $lts }} ( {{ $totals['total_qty_unit'] }} 
                                            {{ $unitType }} x {{ 'Rp ' . number_format($cas ?? 0, 0, ',', '.') }} ) {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                        @else
                                            BATAM {{ implode(', ', $mergedMarkings) }} = {{ $lts }} {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M') }}
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td width="12.5%" class="border_left_right text_center text_uppercase">{{ $qty }} PKG</td>
                            @if ($is_weight || $unitType == 'T')
                                @if (($weight / 1000) > $cbm)
                                    <td width="10%" class="border_left_right text_center text_uppercase">{{ $weight / 1000 }} T</td>
                                @else
                                    <td width="10%" class="border_left_right text_center text_uppercase">{{ $weight }} KG</td>
                                @endif
                            @else
                                <td width="10%" class="border_left_right text_center text_uppercase">{{ $cbm }} M3</td>
                            @endif
                            @if (in_array($lts, ['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM']))
                                <td width="15%" class="border_left_right text_center"></td>
                            @else
                                <td width="15%" class="border_left_right text_center">
                                    {{ 'Rp ' . number_format($unit_price ?? 0, 0, ',', '.') }}
                                </td>
                            @endif
                            <td width="20%" class="border_left_right text_center">{{ 'Rp ' . number_format($amount ?? 0, 0, ',', '.') }}</td>
                        </tr>

                        @php
                            if ($entryRow > 15) {
                                $entryRow = 0;
                                echo '</table>';
                                echo '<div style="page-break-after: always;"></div>';
                                echo '<table style="border: 1px solid #000;">';
                                echo '<tr>
                                        <th>Item</th>
                                        <th>Description</th>
                                        <th colspan="2">Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Amount</th>
                                    </tr>';
                            }
                        @endphp

                    @endforeach

                    <!-- another bill -->
                    @if (count($resultAnotherBill) > 0)
                        @for ($d = 0; $d < count($resultAnotherBill); $d++)
                        @php
                            $checkDesc = $descsData->where('id_desc', $resultAnotherBill[$d]['desc'])->first();
                        @endphp
                        <tr>
                            <td width="5%" class="border_left_right"></td>
                            <td width="30%" class="border_left_right text_center">{{ $checkDesc->name }} {{ $resultAnotherBill[$d]['note'] }}</td>
                            <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                            <td width="10%" class="border_left_right text_center text_uppercase"></td>
                            <td width="15%" class="border_left_right text_center"></td>
                            <td width="20%" class="border_left_right text_center">{{ 'Rp ' . number_format($resultAnotherBill[$d]['charge'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @endfor
                    @endif

                    <!-- empty row -->
                    @for ($i = 1; $i <= (16 - $entryRow); $i++)
                        <tr>
                            <td width="5%" class="border_left_right" style="height: 20px;"></td>
                            <td width="30%" class="border_left_right text_center"></td>
                            <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                            <td width="10%" class="border_left_right text_center text_uppercase"></td>
                            <td width="15%" class="border_left_right text_center"></td>
                            <td width="20%" class="border_left_right text_center"></td>
                        </tr>
                    @endfor
                @endif

                <tr>
                    <td width="5%" class="border_left_right"></td>
                    @if ($is_weight)
                        <td width="30%" class="border_left_right text_center">Total {{ round($totalCbm, 3) }} M3</td>
                    @else
                        <td width="30%" class="border_left_right text_center">Total</td>
                    @endif
                    <td width="12.5%" class="border_left_right text_center text_uppercase">{{ $totalQty }}</td>
                    @if ($is_weight)
                        @if (($totalWeight / 1000) > round($totalCbm, 3))
                            <td width="10%" class="border_left_right text_center text_uppercase">{{ $totalWeight / 1000 }} T</td>
                        @else
                            <td width="10%" class="border_left_right text_center text_uppercase">{{ $totalWeight }} KG</td>
                        @endif
                    @else
                        @if ($is_tonase)
                            @if (($totalWeight / 1000) > round($totalCbm, 3))
                                <td width="10%" class="border_left_right text_center text_uppercase">{{ round($totalCbm, 3) }} M3 <br> {{ $totalWeight / 1000 }} T</td>
                            @else
                                <td width="10%" class="border_left_right text_center text_uppercase">{{ round($totalCbm, 3) }} M3 <br> {{ $totalWeight }} KG</td>
                            @endif
                        @else
                            <td width="10%" class="border_left_right text_center text_uppercase">{{ round($totalCbm, 3) }} M3</td>
                        @endif
                    @endif
                    <td width="15%" class="border_left_right text_center"></td>
                    <td width="20%" class="border_left_right text_center"></td>
                </tr>

            </table>

            @php
                $totalAmount += intval($totalanotherBillOverall);
            @endphp

            <table style="margin-top: -1px;">
                <tr>
                    <td colspan="4"></td>
                    <td width="20%" style="font-size: 14px;" class="text_center">Total Rp. / S$.</td>
                    <td width="21.6%" class="text_center no_top_border bold" id="total">{{ 'Rp ' . number_format($totalAmount ?? 0, 0, ',', '.') }}</td>
                </tr>
            </table>

            <div style="margin-top: 10px; margin-bottom:5px;"><span>Say of, </span></div>

            @php
            $text = spelledout($totalAmount);
            $maxWidth = 550;
            $lines = splitTextIntoLines($text, $maxWidth);

            foreach ($lines as $index => $line) {
                if ($index === count($lines) - 1) {
                    echo "<div style='text-align:left; border-bottom: 1px solid #000; width:425px; margin-top:2px; font-weight: bold; display: inline-block;'>$line rupiah</div>
                    <div style='text-align:center; width:200px; display: inline-block; margin-left:75px;'>
                        <span><b>$companyName</b></span><br>
                        <span style='margin-top: 5px;'>Prepared by,</span>
                    </div>";

                } else {
                    echo "<div style='border-bottom: 1px solid #000; width:425px; margin-top:2px; font-weight: bold;'>$line</div>";
                }
            }
            @endphp

            <div style="text-align:left; margin-top: 20px; border-bottom: 1px solid #000; width:425px;"><span>Received by, </span></div>
            <div style="text-align:center; width:200px; border-bottom: 1px solid #000; margin-left:505px; margin-top:20px;"></div>

            @if($a == 0 && ($customer->discount || $customer->discount > 0))
                <div style="page-break-after: always;"></div>
            @endif
        @endfor
        <!-- Shipment Status -->
        <style>
            .header-table {
                font-weight: bold;
                text-align: center;
                text-decoration: underline;
            }
        </style>
        <div style="page-break-before: always;">
            <table style="border: 1px solid #000; width: 100%; border-collapse: collapse;">
                <tr>
                    <td colspan="6" class="header-table">SHIPMENT STATUS SEA FREIGHT</td>
                </tr>
                <tr><td colspan="6" style="height: 35px;"></td></tr>
                <tr style="border-top: 1px solid #000;">
                    <td>Shipper</td>
                    <td>: {{ $shipper->name }}</td>
                    <td style="border-left: 1px solid #000;">No.</td>
                    <td></td>
                    <td width=10% colspan="2" style="text-align: end;">
                        Tgl {{ \Carbon\Carbon::createFromFormat('Y-m-d', $seaShipment->date)->format('d M Y') }}
                    </td>
                </tr>
                <tr style="border-top: 1px solid #000;">
                    <td>Consigne</td>
                    <td>: {{ $customer->name }}</td>
                    <td style="border-left: 1px solid #000;">Nama Kapal</td>
                    <td colspan="3">: {{ $ship->name ?? null }}</td>
                </tr>
                <tr style="border-top: 1px solid #000;">
                    <td>Total Jml Ship / BL</td>
                    <td>: {{ $groupSeaShipmentLinesCal->count() }}</td>
                    <td style="border-left: 1px solid #000;">Total Weight</td>
                    <td>: {{ $groupSeaShipmentLinesCal->pluck('total_weight')->sum() }} Kgs</td>
                    <td width=10% colspan="2" style="text-align: end;">
                        Etd: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $seaShipment->etd)->format('d M Y') }}
                    </td>
                </tr>
                <tr style="border-top: 1px solid #000;">
                    <td>Total Jml Pkgs</td>
                    <td>: {{ $totalQty }} Pkgs</td>
                    <td style="border-left: 1px solid #000;">Total Volume</td>
                    <td>: {{ round($groupSeaShipmentLinesCal->pluck('total_cbm2')->sum(), 3) }} Cbm</td>
                    <td width=10% colspan="2" style="text-align: end;">
                        Eta: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $seaShipment->eta)->format('d M Y') }}
                    </td>
                </tr>
            </table>
            <table style="border: 1px solid #000;">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Tgl. BL</th>
                        <th rowspan="2">Jml <br> Pkgs</th>
                        <th rowspan="2">Weight <br> Kgs</th>
                        <th colspan="3">Total Cbm</th>
                        <th colspan="3">Charges Details</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; text-align: center;">I</td>
                        <td style="border: 1px solid #000; text-align: center;">II</td>
                        <td style="border: 1px solid #000; text-align: center;">SF</td>
                        <td style="border: 1px solid #000; text-align: center;">SF Exp</td>
                        <td style="border: 1px solid #000; text-align: center;">SIN-BTM</td>
                        <td style="border: 1px solid #000; text-align: center;">Add C/</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupSeaShipmentLinesCal as $date => $gsl)
                    <tr>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $loop->iteration }}.
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d M Y') }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none; ">
                            {{ $gsl['total_qty_pkgs'] }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            @php
                                $totalWeight = $gsl['total_weight'] / 1000;
                            @endphp
                            {{ $totalWeight != 0 ? $totalWeight . ' T' : '-' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $gsl['total_cbm1'] > 0 ? round($gsl['total_cbm1'], 3) . ' M3' : '-' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $gsl['total_cbm2'] > 0 ? round($gsl['total_cbm2'], 3) . ' M3' : '-' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $gsl['cbm_difference'] > 0 ? round($gsl['cbm_difference'], 3) . ' M3' : '-' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">-</td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">-</td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">-</td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">-</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @php
                $previousDate = null;
                $rowCount = 0;
                $currentPage = 1;
            @endphp
            <table style="border: 1px solid #000;">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Code</th>
                        <th rowspan="2">Marking</th>
                        <th colspan="4">Quantity</th>
                        <th rowspan="2">Weight <br> Kg</th>
                        <th colspan="3">Dimensi</th>
                        <th colspan="2">Total Cbm</th>
                        <th rowspan="2">Desc</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: 1px solid #000; text-align: center;">Pkgs</td>
                        <td colspan="2" style="border: 1px solid #000; text-align: center;">Loose</td>
                        <td style="border: 1px solid #000; text-align: center;">P</td>
                        <td style="border: 1px solid #000; text-align: center;">L</td>
                        <td style="border: 1px solid #000; text-align: center;">T</td>
                        <td style="border: 1px solid #000; text-align: center;">I</td>
                        <td style="border: 1px solid #000; text-align: center;">II</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seaShipmentLinesAll as $ssl)
                    @php
                        $currentDate = $ssl->date;
                        $checkUomPkgs = $uomsData->where('id_uom', $ssl->id_uom_pkgs)->first();
                        $checkUomLoose = $uomsData->where('id_uom', $ssl->id_uom_loose)->first();
                        if ($currentPage == 1 && $rowCount >= 23) {
                            echo '</tbody></table>'; // Menutup tabel saat ini
                            echo '<div style="page-break-after: always;"></div>'; // Menambahkan pemisah halaman
                            echo '<table style="border: 1px solid #000;"><thead>'; // Membuka tabel baru
                            // Menyalin header tabel
                            echo '<tr>
                                    <th rowspan="2">No.</th>
                                    <th rowspan="2">Code</th>
                                    <th rowspan="2">Marking</th>
                                    <th colspan="4">Quantity</th>
                                    <th rowspan="2">Weight <br> Kg</th>
                                    <th colspan="3">Dimensi</th>
                                    <th colspan="2">Total Cbm</th>
                                    <th rowspan="2">Desc</th>
                                    <th rowspan="2">Keterangan</th>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border: 1px solid #000; text-align: center;">Pkgs</td>
                                    <td colspan="2" style="border: 1px solid #000; text-align: center;">Loose</td>
                                    <td style="border: 1px solid #000; text-align: center;">P</td>
                                    <td style="border: 1px solid #000; text-align: center;">L</td>
                                    <td style="border: 1px solid #000; text-align: center;">T</td>
                                    <td style="border: 1px solid #000; text-align: center;">I</td>
                                    <td style="border: 1px solid #000; text-align: center;">II</td>
                                </tr>';
                            echo '</thead><tbody>'; // Menutup header dan membuka body baru
                            $rowCount = 0; // Reset rowCount untuk halaman baru
                            $currentPage++; // Increment halaman saat ini
                        } elseif ($currentPage > 1 && $rowCount >= 40) {
                            echo '</tbody></table>'; // Menutup tabel saat ini
                            echo '<div style="page-break-after: always;"></div>'; // Menambahkan pemisah halaman
                            echo '<table style="border: 1px solid #000;"><thead>'; // Membuka tabel baru
                            // Menyalin header tabel
                            echo '<tr>
                                    <th rowspan="2">No.</th>
                                    <th rowspan="2">Code</th>
                                    <th rowspan="2">Marking</th>
                                    <th colspan="4">Quantity</th>
                                    <th rowspan="2">Weight <br> Kg</th>
                                    <th colspan="3">Dimensi</th>
                                    <th colspan="2">Total Cbm</th>
                                    <th rowspan="2">Desc</th>
                                    <th rowspan="2">Keterangan</th>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border: 1px solid #000; text-align: center;">Pkgs</td>
                                    <td colspan="2" style="border: 1px solid #000; text-align: center;">Loose</td>
                                    <td style="border: 1px solid #000; text-align: center;">P</td>
                                    <td style="border: 1px solid #000; text-align: center;">L</td>
                                    <td style="border: 1px solid #000; text-align: center;">T</td>
                                    <td style="border: 1px solid #000; text-align: center;">I</td>
                                    <td style="border: 1px solid #000; text-align: center;">II</td>
                                </tr>';
                            echo '</thead><tbody>'; // Menutup header dan membuka body baru
                            $rowCount = 0; // Reset rowCount untuk halaman baru
                            $currentPage++; // Increment halaman saat ini
                        }
                    @endphp
                    @if($previousDate !== $currentDate)
                        @php
                            $specificDateData = $groupSeaShipmentLinesCal->filter(function ($value, $date) use ($currentDate) {
                                return $date === $currentDate;
                            });
                        @endphp
                        <tr style="border: 1px solid #000; background-color: #f0f0f0; font-weight: bold; text-align: center;">
                            <td colspan="3">
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $currentDate)->format('d M Y') }}
                            </td>
                            <td colspan="2">{{ $specificDateData->first()['total_qty_pkgs'] }} {{ $checkUomPkgs->name ?? '' }}</td>
                            <td colspan="2">{{ $specificDateData->first()['total_qty_loose'] }} {{ $checkUomLoose->name ?? '' }}</td>
                            <td colspan="4"></td>
                            <td>{{ round($specificDateData->first()['total_cbm1'], 3) }}</td>
                            <td>{{ round($specificDateData->first()['total_cbm2'], 3) }}</td>
                            <td colspan="2"></td>
                        </tr>
                        @php
                            $previousDate = $currentDate;
                        @endphp
                    @endif
                    
                    <tr style="font-size: 11px;">
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $loop->iteration }}.
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $ssl->code ?? '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $ssl->marking ?? '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $ssl->qty_pkgs ?? '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $checkUomPkgs->name ?? '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $ssl->qty_loose ?? '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $checkUomLoose->name ?? '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $ssl->weight ?? '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $ssl->dimension_p ?? '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $ssl->dimension_l ?? '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $ssl->dimension_t ?? '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ isset($ssl->tot_cbm_1) && $ssl->tot_cbm_1 !== null ? round($ssl->tot_cbm_1, 3) : '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ isset($ssl->tot_cbm_2) && $ssl->tot_cbm_2 !== null ? round($ssl->tot_cbm_2, 3) : '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            {{ $ssl->lts ?? '' }}
                        </td>
                        <td style="text-align: center; border: 1px solid #000; border-top: none; border-bottom: none;">
                            @php
                                $description = $ssl->desc ?? '';
                                $stateName = $statesData->where('id_state', $ssl->id_state)->first();
                                if ($stateName) {
                                    $description .= ' ' . $stateName->name;
                                }
                            @endphp
                            {{ $description }}
                        </td>
                    </tr>
                    @php
                        $rowCount++;
                    @endphp
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
