<?php

namespace App\Livewire\DatasetResource\CsvValidator;

// use App\Models\Dataset;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Nette\Utils\Validators;

class backupYangDuluWaktuPakeRuleDariLuar implements ToCollection, WithHeadingRow, WithValidation
{
    private $rules;
    
    public function __construct($rules){
        $this->rules = $rules;
    }
    /**
     * Process the imported rows
     */
    public function collection(Collection $rows)
    {
        // Di sini Anda bisa memproses data lebih lanjut jika diperlukan.
        // Misalnya, Anda bisa menyimpan dataset ke file lain atau melakukan tindakan tertentu.
    }

    /**
     * Define the validation rules dynamically
     */
    public function rules(): array
    {
        dd($this->rules);
        return $this->rules;
        $rules = [];
        foreach ($this->rules as $colom=>$dbRule) {
            $rules[$colom] = $dbRule;
        }
        return $rules;    
    }

    /**
     * Define custom messages for validation errors
     */
    public function customValidationMessages()
    {
        return [
            'required' => ':attribute harus diisi.',
            'integer' => ':attribute harus berupa angka.',
            'date' => ':attribute harus berupa tanggal yang valid.',
        ];
    }
}
