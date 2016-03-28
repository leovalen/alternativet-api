<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PostalArea extends Model {

    protected $primaryKey = 'postal_code';
    protected $guarded = ['*'];
    protected $appends = ['county'];

    private static $countyMunicipalities = [
        '01' => 'Østfold',
        '02' => 'Akershus',
        '03' => 'Oslo',
        '04' => 'Hedmark',
        '05' => 'Oppland',
        '06' => 'Buskerud',
        '07' => 'Vestfold',
        '08' => 'Telemark',
        '09' => 'Aust-Agder',
        '10' => 'Vest-Agder',
        '11' => 'Rogaland',
        '12' => 'Hordaland',
        '14' => 'Sogn og Fjordane',
        '15' => 'Møre og Romsdal',
        '16' => 'Sør-Trøndelag',
        '17' => 'Nord-Trøndelag',
        '18' => 'Nordland',
        '19' => 'Troms',
        '20' => 'Finnmark',
        '21' => 'Svalbard',
        '22' => 'Jan Mayen',
        '23' => 'Kontinentalsokkelen',
    ];

    public function getCountyAttribute()
    {
        $countyCode = substr($this->municipality_code, 0, 2);
        return self::$countyMunicipalities[$countyCode];
    }

}
