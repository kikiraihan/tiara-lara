<?php

namespace App\Livewire\Dashboard;

use App\Models\Dataset;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

trait DashFilterTrait
{
    public function filterForm(){
        return [
            Select::make('dataset')
                ->label('Pilih dataset')
                // ->hint('(kosongkan untuk semua kabupaten)')
                ->options(
                // Dataset::all()->pluck('title', 'id')
            Dataset::all()->mapWithKeys(function ($dataset) {
                        return [
                            $dataset->id => $dataset->title . ' (' . $dataset->model->name . ')',
                        ];
                    })
                )
                ->searchable(),
        ];
    }

    public function updateDsDashData($r, $data){
        try{
            $r->file_path_agg_year = $data['dash_fname'];
            $r->save();
    
            return $r;
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
        return null;
    }

    public function runDash($data){
        /*
        // wip
        Log::info( json_encode($filter));
        // $this->boxplot_nra_get_data();
        // $data = $this->getDataFromServer('http://0.0.0.0:8009/read_csv');
        $burl = env('APP_MS3_ML_SVC_URL');

        // $file_path = $dataset->file_path;
        
        $ds = Dataset::find();
        $file_path = $ds->file_path;
        // wip sent filename
        $url = "{$burl}api/infer/dash/$file_path";
        $data = $this->getDataFromServer($url);

        // Log::info(json_encode($data));
        $data = $data['data'];
        */
        $filter = $this->getFilter($data);
        $dataset_id = $filter['dataset'];
        $dataset_name = $this->idToNameFilterMapping($filter);
        $this->on_search = $dataset_name;
        
        $dataset = Dataset::find($dataset_id);
        $file_path = $dataset->file_path;
        // $file_path = $dataset->file_path_agg_year; // yg diproses adalah di dashboard adalah file agg year langsung.
        
        $pjp_or_kupva = $this->modelNameToKupvaOrPJP($dataset->model->name);
        $this->pjpOrKupva = $pjp_or_kupva;
        
        $burl = env('APP_MS3_ML_SVC_URL');
        if($pjp_or_kupva=="kupva"){
            if(env('IN_LOCAL')){
                $data = $this->getDataFromServer('http://0.0.0.0:8009/read_csv');
            }
            else{
                // wip sent filename
                // $file_path = urlencode($file_path);
                $url = "{$burl}api/infer/dash/$pjp_or_kupva/$file_path";
                Log::info($url);
                $data = $this->getDataFromServer($url);
                // wip handle data null
                $data = $data['data'];
            }
            $this->triggerDashboardKupva($data);

            // wip update
        } elseif($pjp_or_kupva=="pjp"){
            if(env('IN_LOCAL')){
                $data = $this->getDataFromServer('http://0.0.0.0:8009/read_csv');
            }
            else{
                // $file_path = urlencode($file_path);
                // wip sent filename
                $url = "{$burl}api/infer/dash/$pjp_or_kupva/$file_path";
                Log::info($url);
                $data = $this->getDataFromServer($url);
                // wip handle data null
                $data = $data['data'];
            }
            $this->triggerDashboardPjp($data);
        } else{
            return Notification::make()
            ->title("Tipe dashboard tidak ditemukan")
            ->danger()
            ->send();
        }
        $this->updateDsDashData($dataset, $data);
    }

    public function modelNameToKupvaOrPJP($name){
        $map = [
            "1-zul-pjp-m"=>"pjp",
            "2-zul-pjp-y"=>"pjp",
            "3-dib-pjp"=>"pjp",
            "4-zul-kupva-m"=>"kupva",
            "5-zul-kupva-y"=>"kupva",
            "6-dib-kupva"=>"kupva",
        ];
        return $map[$name];
    }

    public function triggerDashboardKupva($data){
        $total_row = count($data['data']['sandi']);
        $total_column = count($data['data']);

        $this->dispatch('reloadCards', [
            ['title' => 'Nama Dataset', 'value' => $this->on_search['dataset']],
            ['title' => 'Tipe Dataset', 'value' => 'KUPVA'],
            ['title' => 'Total Baris', 'value' => $total_row],
            // $this->pjpOrKupva
        ]);

        $this->dispatch('reloadHistoNRA', $data['data']['NRA_PRED'],
            $data['data']['NRA_APU']);
            
        $this->dispatch('loadDataPulauNra', $data['pulau_vs_nra']);
        $this->dispatch('reloadScatterKursTengah', [
            'data'=>$data['data'],
            'data_regression'=>$data['data_regression']['kurs_tengah_regression'],
        ]);
        $this->dispatch('reloadScatterVolumePenjualan', [
            'data'=>$data['data'],
            'data_regression'=>$data['data_regression']['volume_penjualan_regression'],
        ]);
        $this->dispatch('reloadScatterVolumePembelian', [
            'data'=>$data['data'],
            'data_regression'=>$data['data_regression']['volume_pembelian_regression'],
        ]);
        $this->dispatch('reloadScatterSaldoAwal', [
            'data'=>$data['data'],
            'data_regression'=>$data['data_regression']['saldo_awal_regression'],
        ]);
        $this->dispatch('reloadScatterSaldoAkhir', [
            'data' => $data['data'],
            'data_regression' => $data['data_regression']['saldo_akhir_regression'],
        ]);        
        $this->dispatch('reloadScatterSpreadKeuntungan', [
            'data' => $data['data'],
            'data_regression' => $data['data_regression']['_spread_keuntungan_regression'],
        ]);

        $this->dispatch('reloadBarChartPemegangSaham', $data['pemegang_saham_vs_NRA']);

        $this->dispatch('reloadBarChartPengurus', $data['pengurus_vs_NRA']);

        $this->dispatch('reloadTableChartSandiNRA', $data['data']);
        $this->dispatch('reloadBarChartKpwdn', $data['kpwdn_vs_NRA']);
        $this->dispatch('reloadBarChartTopKpwdn', $data['top_sandi']);

        $this->dispatch('reloadScatterSelisihNRA', $data['data']);
    }

    public function triggerDashboardPjp($data){
        $total_row = count($data['data']['sandi']);
        $total_column = count($data['data']);

        $this->dispatch('reloadCards', [
            ['title' => 'Nama Dataset', 'value' => $this->on_search['dataset']],
            ['title' => 'Tipe Dataset', 'value' => 'PJP'],
            ['title' => 'Total Baris', 'value' => $total_row],
            // $this->pjpOrKupva
        ]);
        
        $this->dispatch('pjpReloadHistoNRA', $data['data']['NRA_PRED'], $data['data']['NRA_APU']);
        $this->dispatch('pjpLoadDataPulauNra', $data['pulau_vs_nra']);
        // $this->dispatch('pjpReloadBarChartPemegangSaham', $data['pemegang_saham_vs_NRA']);
        // $this->dispatch('pjpReloadBarChartPengurus', $data['pengurus_vs_NRA']);
        $this->dispatch('pjpReloadTableChartSandiNRA', $data['data']);
        $this->dispatch('pjpReloadBarChartKpwdn', $data['kpwdn_vs_NRA']);
        $this->dispatch('pjpReloadBarChartTopKpwdn', $data['top_sandi']);
        $this->dispatch('pjpReloadScatterSelisihNRA', $data['data']);
    }


    public function getDataFromServer($url)
    {
        // Fetch data from the server
        $tout = config("app.ml.server-timeout");
        Log::info("srv timeout $tout");
        // exit;
        $response = Http::timeout($tout)->get($url);

        // Parse the response and extract `NRA_PRED`
        if ($response->successful()) {
            // $this->nra_PRED_data = $response->json()['data']['NRA_PRED'] ?? [];
            return $response->json() ?? [];
        }
    }


    public function getFilter($data) {
        // Konversi JSON untuk field tertentu
        $fieldsInList = [
            // 'dataset', 
        ];
    
        foreach ($fieldsInList as $field) {
            $data[$field] = !empty($data[$field]) ? json_encode($data[$field]) : null;
        }
    
        // Return hasil filter
        return [
            'dataset' => $data['dataset'],
        ];
    }

    public function idToNameFilterMapping($filter) {
        // Ambil semua mapping dari database
        $mappings = [
            'dataset' => Dataset::pluck('title', 'id')->toArray(),
        ];

        // Iterasi melalui setiap filter dan mapping
        foreach ($filter as $column => $value) {
            // Cek apakah kolom ada dalam mapping
            if (isset($mappings[$column]) && isset($mappings[$column][$value])) {
                // Ganti nilai ID dengan title
                $filter[$column] = $mappings[$column][$value];
            }
        }

        return $filter;
    }
}