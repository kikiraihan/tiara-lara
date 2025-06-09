<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithLimit;

// generic maat import
class CImports implements ToCollection, WithLimit
{
	// ToArray
	public function collection(Collection $rows) {
		return $rows;
	}

	/* function array(array $array){
		return $array;
	} */
	
	public function limit(): int{
		return 10;
	}
}
