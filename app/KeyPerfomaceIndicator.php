<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeyPerfomaceIndicator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'strategicObjective_id', 'perspective_id', 'arithmeticStructure','target'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * Get the scoresRecordeds for the KeyPerfomaceIndicator.
     */
    public function scoresRecordeds()
    {
        return $this->hasMany(\App\scoresRecorded::class);
    }


    /**
     * Get the KeyPerfomanceIndicatorScores for the KeyPerfomaceIndicator.
     */
    public function keyPerfomanceIndicatorScores()
    {
        return $this->hasMany(\App\KeyPerfomanceIndicatorScore::class);
    }


    /**
     * Get the NonConformities for the KeyPerfomaceIndicator.
     */
    public function nonConformities()
    {
        return $this->hasMany(\App\NonConformities::class);
    }


    /**
     * Get the Perspective for the KeyPerfomaceIndicator.
     */
    public function perspective()
    {
        return $this->belongsTo(\App\Perspective::class);
    }


    /**
     * Get the StrategicObjective for the KeyPerfomaceIndicator.
     */
    public function strategicObjective()
    {
        return $this->belongsTo(\App\StrategicObjective::class);
    }

}
