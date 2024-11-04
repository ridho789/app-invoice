<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $titleInv }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12.5px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .content {
            flex-grow: 1;
        }

        .footer {
            margin-top: auto;
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

        .bold {
            font-weight: bold;
        }

        .text_center {
            text-align: center;
        }

        .text_uppercase {
            text-transform: uppercase;
        }

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


        @if ($a == 0)
            <div style="margin-top:-40px;">
                <img src="data:image/jpeg;base64,{{ base64_encode($imageContent) }}" style="width: 600px; margin-left:40px;">
            </div>
            <table style="border: 1px solid #000; width: 100%; border-collapse: collapse;">
                <!-- Header -->
                <tr style="border: 1px solid #000;">
                    <td colspan="6" style="text-align: center; padding-top: 0; padding-bottom: 0; font-weight: bold; font-size: 22.5px;">INVOICE</td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                </tr>
            
                <!-- Informasi Invoice -->
                <tr>
                    <td class="space_content" colspan="2">To :</td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Inv. No.</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ $invNameGenerate }}</span></td>
                </tr>
                <tr>
                    <td class="space_content_main" colspan="2"></td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Date</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $airShipment->date)->format('d-M-y') }}</span></td>
                </tr>
                <tr>
                    <td class="space_content_main" colspan="2" style="white-space: nowrap;">{{ $customer->name }}</td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Term</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ $term }} Days</span></td>
                </tr>
                <tr>
                    <td class="space_content_main" colspan="2">{{ $shipper->name }}</td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Payment Due</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $paymentDue)->format('d-M-y') }}</span></td>
                </tr>
                <tr>
                    <td class="space_content" colspan="2"></td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Freight Type</td>
                    <td class="bold" colspan="2">: <span class="space_content2">AIR FREIGHT</span></td>
                </tr>
                <tr>
                    <td class="space_content" colspan="2"></td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Banker</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ $banker }}</span></td>
                </tr>
                <tr>
                    <td class="space_content" colspan="2"></td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Account No.</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ $account_no }}</span></td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                </tr>
            
                <!-- Header Table Detail -->
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th colspan="2">Quantity</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td class="border_left_right text_center"></td>
                    <td class="border_left_right text_center">Biaya Pengiriman {{ $airShipment->origin }}</td>
                    <td class="border_left_right text_center"></td>
                    <td class="border_left_right text_center"></td>
                    <td class="border_left_right text_center"></td>
                    <td class="border_left_right text_center"></td>
                </tr>
                @php
                    $amount = 0;
                    $totalQty = 0;
                    $checkLoopDate = null;
                    $entryRow = 0;
                    
                    // Another Bill
                    $totalanotherBillOverall = 0;

                     
                    if ($dataAnotherBill) {
                        $resultAnotherBill = [];
                        $dates = is_array($dataAnotherBill["date"]) ? $dataAnotherBill["date"] : [$dataAnotherBill["date"]];
                        $descs = is_array($dataAnotherBill["desc"]) ? $dataAnotherBill["desc"] : [$dataAnotherBill["desc"]];
                        $charges = is_array($dataAnotherBill["charge"]) ? $dataAnotherBill["charge"] : [$dataAnotherBill["charge"]];

                        $maxCount = max(count($descs), count($charges));

                        for ($index = 0; $index < $maxCount; $index++) {
                            $date = isset($dates[$index]) ? $dates[$index] : $dates[0];
                            $desc = isset($descs[$index]) ? $descs[$index] : null;
                            $charge = isset($charges[$index]) ? $charges[$index] : null;
                            $anotherBillValue = $charge ? preg_replace("/[^0-9]/", "", $charge) : null;

                            if (is_null($desc) && ($anotherBillValue == 0 || is_null($anotherBillValue))) {
                                continue;
                            }

                            $resultAnotherBill[] = [
                                "date" => $date,
                                "desc" => $desc,
                                "charge" => $anotherBillValue
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

                @php
                    $totalAllAmount = 0;
                    $totalCasAllAmount = 0; 
                    $totalEqual100 = 0;
                    
                    $bl = 0;
                    $permit = 0;
                    $transport = 0;
                    $insurance = 0; 
                            
                    // Data tagihan lainnya
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
                    $checkLoopDate = $date;

                    $totalAllAmount += $totalloose * $pricelist;
                    
                    foreach ($airShipmentLines as $line) {
                        if ($line->qty_loose >= 100) {
                            $totalEqual100 += $line->qty_loose * $cas;
                        }
                    }
                
                    $totalCasAllAmount = $totalAllAmount + $totalEqual100 ;  

                @endphp
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
 
                <tr>
                    <td class="border_left_right text_center"></td>
                    <td class="border_left_right">BATAM {{ substr($airShipmentLines[0]->marking, 0, 3) }} {{ $airShipmentLines[0]->date }}</td>
                    <td class="border_left_right text_center">{{ $totalpkgs }} CTN</td>
                    <td class="border_left_right text_center">{{ number_format($totalloose, 0, ',', '.') }} KG</td>
                    <td class="border_left_right text_center">{{ number_format($pricelist, 0, ',', '.') }}</td>
                    <td class="border_left_right text_center">{{ number_format($totalAllAmount, 0, ',', '.') }}</td>
                </tr>

                @foreach($airShipmentLines as $line)
                    @if($line->qty_loose >= 100)
                        <tr>
                            <td class="border_left_right text_center"></td>
                            <td class="border_left_right text_center">
                                HEAVY CARGO {{ substr($line->marking, 0, 3) }} : 
                                {{ $line->qty_pkgs }} Ctn {{ $line->qty_loose }} Kg x Rp. 
                                {{ number_format((float)$cas, 0, ',', '.') }}
                            </td>                            
                            <td class="border_left_right text_center"> </td>
                            <td class="border_left_right text_center"></td>
                            <td class="border_left_right text_center"></td>
                            <td class="border_left_right text_center">{{ number_format($line->qty_loose * $cas , 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @endforeach

                {{--  <!-- another bill -->  --}}
                @if (count($resultAnotherBill) > 0)
                    @for ($d = 0; $d < count($resultAnotherBill); $d++)
                    @php
                        $checkDesc = $descsData->where('id_desc', $resultAnotherBill[$d]['desc'])->first();
                    @endphp
                    <tr>
                        <td width="5%" class="border_left_right"></td>
                        <td width="30%" class="border_left_right text_center">{{ $checkDesc->name }}</td>
                        <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                        <td width="10%" class="border_left_right text_center text_uppercase"></td>
                        <td width="15%" class="border_left_right text_center"></td>
                        <td width="20%" class="border_left_right text_center">{{  number_format($resultAnotherBill[$d]['charge'] ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @endfor
                @endif
                
                {{--  <!-- Total Row -->  --}}
                @for ($i = 1; $i <= (9 - $entryRow); $i++)
                    <tr>
                        <td width="10%" class="border_left_right" style="height: 20px;"></td>
                        <td width="30%" class="border_left_right text_center"></td>
                        <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                        <td width="10%" class="border_left_right text_center text_uppercase"></td>
                        <td width="15%" class="border_left_right text_center"></td>
                        <td width="20%" class="border_left_right text_center"></td>
                    </tr>
                @endfor
                <tr>
                    <td class="border_left_right text_center"></td>
                    <td class="border_left_right text_center"> Total </td>
                    <td class="border_left_right text_center">{{ $totalpkgs }} Ctn</td>
                    <td class="border_left_right text_center">{{ number_format($totalloose, 0, ',', '.') }} Kg</td>
                    <td class="border_left_right text_center"></td>
                    <td class="border_left_right text_center"></td>
                </tr>


            </table>

            @php
                $totalCasAllAmount += intval($totalanotherBillOverall);

            @endphp

            <table style="margin-top: -1px;">
                <tr>
                    <td colspan="4"></td>
                    <td width="20%" style="font-size: 14px;" class="text_center">Total Rp. / S$.</td>
                    <td width="20.5%" class="text_center no_top_border bold" id="total">{{ 'Rp ' . number_format($totalCasAllAmount ?? 0, 0, ',', '.') }}</td>
                </tr>
            </table>

            <div style="margin-top: 10px; margin-bottom:5px;"><span>Say of, </span></div>

            @php
                $text = spelledout($totalCasAllAmount);
                $maxWidth = 550;
                $lines = splitTextIntoLines($text, $maxWidth);

                foreach ($lines as $index => $line) {
                    if ($index === count($lines) - 1) {
                        echo "<div style='text-align:left; border-bottom: 1px solid #000; width:425px; margin-top:2px; font-weight: bold; display: inline-block;'>$line rupiah</div>
                        <div style='text-align:center; width:200px; display: inline-block; margin-left:13cm;'>
                            <span><b>$companyName</b></span><br>
                            <span style='margin-top: 5px;'>Prepared by,</span>
                        </div>";

                    } else {
                        echo "<div style='border-bottom: 1px solid #000; width:425px; margin-top:2px; font-weight: bold;'>$line</div>";
                    }
                }
            @endphp


        @else
            <div style="margin-top:-40px;">
                <img src="data:image/jpeg;base64,{{ base64_encode($imageContent) }}" style="width: 600px; margin-left:40px;">
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
                    <td style="padding-left: 50px;" class="bold" colspan="2">Inv. No.</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ $invNameGenerate }}</span></td>
                </tr>
                <tr>
                    <td class="space_content_main" colspan="2"></td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Date</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $airShipment->date)->format('d-M-y') }}</span></td>
                </tr>
                <tr>
                    <td class="space_content_main" colspan="2" style="white-space: nowrap;">{{ $customer->name }}</td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Term</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ $term }} Days</span></td>
                </tr>
                <tr>
                    <td class="space_content_main" colspan="2">{{ $shipper->name }}</td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Payment Due</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $paymentDue)->format('d-M-y') }}</span></td>
                </tr>
                <tr>
                    <td class="space_content" colspan="2"></td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Freight Type</td>
                    <td class="bold" colspan="2">: <span class="space_content2">AIR FREIGHT</span></td>
                </tr>
                <tr>
                    <td class="space_content" colspan="2"></td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Banker</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ $banker }}</span></td>
                </tr>
                <tr>
                    <td class="space_content" colspan="2"></td>
                    <td style="padding-left: 50px;" class="bold" colspan="2">Account No.</td>
                    <td class="bold" colspan="2">: <span class="space_content2">{{ $account_no }}</span></td>
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
                    <td class="border_left_right text_center">Biaya Pengiriman {{ $airShipment->origin }}</td>
                    <td class="border_left_right"></td>
                    <td class="border_left_right"></td>
                    <td class="border_left_right"></td>
                    <td class="border_left_right"></td>
                </tr>
                @php
                    $amount = 0;
                    $totalQty = 0;
                    $checkLoopDate = null;
                    $entryRow = 0;
                    
                    // Another Bill
                    $totalanotherBillOverall = 0;

                     
                    if ($dataAnotherBill) {
                        $resultAnotherBill = [];
                        $dates = is_array($dataAnotherBill["date"]) ? $dataAnotherBill["date"] : [$dataAnotherBill["date"]];
                        $descs = is_array($dataAnotherBill["desc"]) ? $dataAnotherBill["desc"] : [$dataAnotherBill["desc"]];
                        $charges = is_array($dataAnotherBill["charge"]) ? $dataAnotherBill["charge"] : [$dataAnotherBill["charge"]];

                        $maxCount = max(count($descs), count($charges));

                        for ($index = 0; $index < $maxCount; $index++) {
                            $date = isset($dates[$index]) ? $dates[$index] : $dates[0];
                            $desc = isset($descs[$index]) ? $descs[$index] : null;
                            $charge = isset($charges[$index]) ? $charges[$index] : null;
                            $anotherBillValue = $charge ? preg_replace("/[^0-9]/", "", $charge) : null;

                            if (is_null($desc) && ($anotherBillValue == 0 || is_null($anotherBillValue))) {
                                continue;
                            }

                            $resultAnotherBill[] = [
                                "date" => $date,
                                "desc" => $desc,
                                "charge" => $anotherBillValue
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
                @php
                    $totalAllAmount = 0;
                    $totalCasAllAmountDisc = 0; 
                    $totalEqual100 = 0;
                    $totaldiscount = 0;
                     
                    $bl = 0;
                    $permit = 0;
                    $transport = 0;
                    $insurance = 0;
                            
                    // Data tagihan lainnya
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
                    $checkLoopDate = $date;

                    $totaldiscount += $totalloose * ($pricelist - $discount); 

                    foreach ($airShipmentLines as $line) {
                        if ($line->qty_loose >= 100) {
                            $totalEqual100 += $line->qty_loose * $cas;
                        }
                    }
                
                    $totalCasAllAmountDisc = $totaldiscount + $totalEqual100 + (intval($bl) + intval($permit) + intval($transport) + intval($insurance));  
                @endphp
            
                <tr>
                    <td class="border_left_right text_center"></td>
                    <td class="border_left_right">BATAM {{ substr($airShipmentLines[0]->marking, 0, 3) }} {{ $airShipmentLines[0]->date }}</td>
                    <td class="border_left_right text_center">{{ $totalpkgs }} CTN</td>
                    <td class="border_left_right text_center">{{ number_format($totalloose, 0, ',', '.') }} KG</td>
                    <td class="border_left_right text_center">{{ number_format($pricelist, 0, ',', '.') }}</td>
                    <td class="border_left_right text_center">{{ number_format($totaldiscount, 0, ',', '.') }}</td>
                </tr>
                @foreach($airShipmentLines as $line)
                    @if($line->qty_loose >= 100)
                    <tr>
                        <td class="border_left_right text_center"></td>
                        <td class="border_left_right text_center">
                            HEAVY CARGO {{ substr($line->marking, 0, 3) }} : 
                            {{ $line->qty_pkgs }} Ctn {{ $line->qty_loose }} Kg x Rp. 
                            {{ number_format((float)$cas, 0, ',', '.') }}
                        </td>
                        <td class="border_left_right text_center"></td>
                        <td class="border_left_right text_center"></td>
                        <td class="border_left_right text_center"></td>
                        <td class="border_left_right text_center">{{ number_format($line->qty_loose * $cas , 0, ',', '.') }}</td>
                    </tr>
                    @endif
                @endforeach

                <!-- another bill -->
                @if (count($resultAnotherBill) > 0)
                    @for ($d = 0; $d < count($resultAnotherBill); $d++)
                    @php
                        $checkDesc = $descsData->where('id_desc', $resultAnotherBill[$d]['desc'])->first();
                    @endphp
                    <tr>
                        <td width="5%" class="border_left_right"></td>
                        <td width="30%" class="border_left_right text_center">{{ $checkDesc->name }}</td>
                        <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                        <td width="10%" class="border_left_right text_center text_uppercase"></td>
                        <td width="15%" class="border_left_right text_center"></td>
                        <td width="20%" class="border_left_right text_center">{{  number_format($resultAnotherBill[$d]['charge'] ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @endfor
                @endif

                
                <!-- Total Row -->
                @for ($i = 1; $i <= (9 - $entryRow); $i++)
                    <tr>
                        <td width="10%" class="border_left_right" style="height: 20px;"></td>
                        <td width="30%" class="border_left_right text_center"></td>
                        <td width="12.5%" class="border_left_right text_center text_uppercase"></td>
                        <td width="10%" class="border_left_right text_center text_uppercase"></td>
                        <td width="15%" class="border_left_right text_center"></td>
                        <td width="20%" class="border_left_right text_center"></td>
                    </tr>
                @endfor
                <tr>
                    <td class="border_left_right text_center"></td>
                    <td class="border_left_right text_center"> Total </td>
                    <td class="border_left_right text_center">{{ $totalpkgs }} Ctn</td>
                    <td class="border_left_right text_center">{{ number_format($totalloose, 0, ',', '.') }} Kg</td>
                    <td class="border_left_right text_center"></td>
                    <td class="border_left_right text_center"></td>
                </tr>

                @php
                    $totalCasAllAmountDisc += intval($totalanotherBillOverall);
                @endphp
            </table>


            <table style="margin-top: -1px;">
                <tr>
                    <td colspan="4"></td>
                    <td width="20%" style="font-size: 14px;" class="text_center">Total Rp. / S$.</td>
                    <td width="20.5%" class="text_center no_top_border bold" id="total">{{ 'Rp ' . number_format($totalCasAllAmountDisc ?? 0, 0, ',', '.') }}</td>
                </tr>
            </table>

            <div style="margin-top: 10px; margin-bottom:5px;"><span>Say of, </span></div>

            @php
                $text = spelledout($totalCasAllAmountDisc);
                $maxWidth = 550;
                $lines = splitTextIntoLines($text, $maxWidth);

                foreach ($lines as $index => $line) {
                    if ($index === count($lines) - 1) {
                        echo "<div style='text-align:left; border-bottom: 1px solid #000; width:425px; margin-top:2px; font-weight: bold; display: inline-block;'>$line rupiah</div>
                        <div style='text-align:center; width:200px; display: inline-block; margin-left:13cm;'>
                            <span><b>$companyName</b></span><br>
                            <span style='margin-top: 5px;'>Prepared by,</span>
                        </div>";

                    } else {
                        echo "<div style='border-bottom: 1px solid #000; width:425px; margin-top:2px; font-weight: bold;'>$line</div>";
                    }
                }
            @endphp
        @endif




        <div style="text-align:left; margin-top: 20px; border-bottom: 1px solid #000; width:425px;"><span>Received by, </span></div>
        <div style="text-align:center; width:200px; border-bottom: 1px solid #000; margin-left:505px; margin-top:20px;"></div>

        @if($a == 0 && ($customer->discount || $customer->discount > 0))
            <div style="page-break-after: always;"></div>
        @endif
    @endfor
</body>
</html>
